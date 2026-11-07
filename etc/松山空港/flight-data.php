<?php
// 松山空港ライブボード用データ取得
//   flight-data.php?radar=1  … adsb.lol から松山空港周辺の飛行中機体を返す
//   flight-data.php?board=1  … 松山空港公式サイトの本日の発着情報を解析して返す
// データ源への負荷軽減のため、結果は短時間ファイルキャッシュする。

header('Content-Type: application/json; charset=utf-8');

const MYJ_LAT = 33.8272;
const MYJ_LON = 132.6997;
const RADAR_RADIUS_NM = 120;

function fetch_url($url, $timeout = 12) {
	$ctx = stream_context_create([
		'http' => [
			'timeout' => $timeout,
			'header' => "User-Agent: Mozilla/5.0 (compatible; MYJ-live-board)\r\n",
		],
		'ssl' => ['verify_peer' => true],
	]);
	$body = @file_get_contents($url, false, $ctx);
	return $body === false ? null : $body;
}

function cached($key, $ttl, $producer) {
	$file = sys_get_temp_dir() . '/myj_' . $key . '.json';
	if (is_file($file) && (time() - filemtime($file) < $ttl)) {
		$data = @file_get_contents($file);
		if ($data !== false) return $data;
	}
	$data = $producer();
	if ($data !== null) @file_put_contents($file, $data, LOCK_EX);
	return $data;
}

function out($json) {
	if ($json === null) {
		http_response_code(502);
		echo '{"error":"upstream fetch failed"}';
	} else {
		echo $json;
	}
	exit;
}

// ---- レーダー（飛行位置） ----
if (isset($_GET['radar'])) {
	out(cached('radar', 8, function () {
		$raw = fetch_url('https://api.adsb.lol/v2/point/' . MYJ_LAT . '/' . MYJ_LON . '/' . RADAR_RADIUS_NM);
		if ($raw === null) return null;
		$src = json_decode($raw, true);
		if (!isset($src['ac'])) return null;
		$ac = [];
		foreach ($src['ac'] as $a) {
			if (!isset($a['lat'], $a['lon'])) continue;
			if (($a['seen_pos'] ?? 99) > 60) continue;
			$ac[] = [
				'hex'    => $a['hex'] ?? '',
				'flight' => trim($a['flight'] ?? ''),
				'reg'    => $a['r'] ?? '',
				'type'   => $a['t'] ?? '',
				'lat'    => $a['lat'],
				'lon'    => $a['lon'],
				'alt'    => $a['alt_baro'] ?? null,   // ft、地上は "ground"
				'gs'     => $a['gs'] ?? null,        // kt
				'track'  => $a['track'] ?? null,     // 度
				'vrate'  => $a['baro_rate'] ?? null, // ft/min
				'dst'    => $a['dst'] ?? null,       // 松山空港からの距離 NM
			];
		}
		usort($ac, fn($x, $y) => ($x['dst'] ?? 999) <=> ($y['dst'] ?? 999));
		return json_encode(['time' => time(), 'ac' => $ac], JSON_UNESCAPED_UNICODE);
	}));
}

// ---- 発着ボード（公式サイト解析） ----
if (isset($_GET['board'])) {
	out(cached('board', 45, function () {
		// 公式ページは1ページ内に出発・到着の両テーブルを持ち、JSで切り替えている
		$raw = fetch_url('https://www.matsuyama-airport.co.jp/flight/timetable.html');
		if ($raw === null) { http_response_code(502); echo '{"error":"board fetch failed"}'; exit; }
		$parse = function ($tableClass) use ($raw) {
			if (!preg_match('#<table class="' . $tableClass . '">(.*?)</table>#s', $raw, $tb)) return [];
			$table = $tb[1];
			$rows = [];
			if (!preg_match_all('#<tr>(.*?)</tr>#s', $table, $trs)) return $rows;
			foreach ($trs[1] as $tr) {
				if (!preg_match_all('#<td[^>]*>(.*?)</td>#s', $tr, $tds)) continue;
				$cells = $tds[1];
				if (count($cells) < 5) continue;

				// 1列目: 定刻（変更時は <s>元の時刻</s>新しい時刻）
				$timeCell = $cells[0];
				$sched = null; $revised = null;
				if (preg_match('#<s>([0-9:]+)</s>\s*([0-9:]+)#', $timeCell, $m)) {
					$sched = $m[1]; $revised = $m[2];
				} elseif (preg_match('#([0-9]{1,2}:[0-9]{2})#', strip_tags($timeCell), $m)) {
					$sched = $m[1];
				}
				if ($sched === null) continue;

				// 2列目: 行き先 / 出発地（見出しの <span> は除去）
				$place = trim(strip_tags(preg_replace('#<span>.*?</span>#s', '', $cells[1])));
				// 3列目: 航空会社ロゴ /img/logo/ANA.png
				$airline = '';
				if (preg_match('#/img/logo/([A-Za-z0-9]+)\.png#', $cells[2], $m)) $airline = strtoupper($m[1]);
				// 4列目: 便名（コードシェアは 34/3134 の形式、<span> は除去）
				$flightNo = trim(strip_tags(preg_replace('#<span>.*?</span>#s', '', $cells[3])));
				// 5列目: 変更 / 備考
				$note = $cells[4];
				$change = ''; $remark = '';
				if (preg_match('#<span>変更</span>(.*?)<br\s*/?>#s', $note, $m)) $change = trim(strip_tags($m[1]));
				if (preg_match('#<span>備考</span>(.*?)$#s', $note, $m)) $remark = trim(strip_tags($m[1]));
				// 経路検索リンク（tabicube）から空港コードと STD/STA を拾う
				$from = ''; $to = '';
				if (preg_match('#fromAirportCode=([A-Z]{3})#', $tr, $m)) $from = $m[1];
				if (preg_match('#toAirportCode=([A-Z]{3})#', $tr, $m)) $to = $m[1];

				$rows[] = [
					'time'    => $sched,
					'revised' => $revised,
					'place'   => $place,
					'airline' => $airline,
					'flight'  => $flightNo,
					'change'  => $change,
					'remark'  => $remark,
					'from'    => $from,
					'to'      => $to,
				];
			}
			return $rows;
		};
		return json_encode([
			'time' => time(),
			'dep'  => $parse('departure'),
			'arr'  => $parse('arrival'),
		], JSON_UNESCAPED_UNICODE);
	}));
}

http_response_code(400);
echo '{"error":"specify radar=1 or board=1"}';
