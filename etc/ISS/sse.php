<?php
// sse.php — ISSテレメトリを Server-Sent Events で配信する
//
// 仕組み:
//   ブラウザが EventSource で接続 → このスクリプトが PDO で telemetry
//   テーブルをポーリングし、前回から変わった行だけを SSE で返す。
//   初回接続時は全行を "init" イベントで送る。
//
// 注意:
//   SSE の接続中は PHP のワーカーを1つ占有し続けます。個人用ページの
//   規模なら問題ありませんが、同時接続数が多い用途には向きません。

declare(strict_types=1);

// 接続済み PDO（$sql）が用意されている env.php を読み込む
require_once(__DIR__ . "/../../env.php");

const POLL_INTERVAL_MS = 1000; // ポーリング間隔（ミリ秒）
const MAX_RUNTIME_SEC  = 300;  // 1接続の最大継続時間。過ぎたら切断し、ブラウザが自動で再接続する
const PING_INTERVAL_SEC = 15;  // キープアライブ（コメント行）の間隔

// ===== SSE 用ヘッダー =====
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('X-Accel-Buffering: no'); // nginx 等のリバースプロキシでバッファさせない

// 出力バッファリングを全部剥がして即時送信にする
while (ob_get_level() > 0) {
	ob_end_clean();
}
ob_implicit_flush(true);

// ブラウザが切断したらループを抜けられるようにする
ignore_user_abort(false);
set_time_limit(0);

/** SSE イベントを1つ送る */
function send_event(string $event, array $data): void
{
	echo "event: {$event}\n";
	echo 'data: ' . json_encode($data, JSON_UNESCAPED_UNICODE) . "\n\n";
	flush();
}

/** telemetry テーブルの全行を取る */
function fetch_all_rows(PDOStatement $stmt): array
{
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ===== 履歴モード（?history=<Label>） =====
// 指定 Label の履歴を telemetry_history から配信する。
// 初回は新しい順に最大100件を "history_init" で送り、以降は新しい行が
// 増えるたびに "history_update" で送る（seq の差分で判定）。
if (isset($_GET['history'])) {
	$label = (string) $_GET['history'];

	$initStmt = $sql->prepare(
		'SELECT seq, Label, `Value`, Timestamp FROM telemetry_history
		 WHERE Label = ? ORDER BY seq DESC LIMIT 100'
	);
	$initStmt->execute([$label]);
	$rows = $initStmt->fetchAll(PDO::FETCH_ASSOC);
	send_event('history_init', $rows);

	$lastSeq = 0;
	foreach ($rows as $row) {
		$lastSeq = max($lastSeq, (int) $row['seq']);
	}

	$pollStmt = $sql->prepare(
		'SELECT seq, Label, `Value`, Timestamp FROM telemetry_history
		 WHERE Label = ? AND seq > ? ORDER BY seq ASC'
	);

	$started  = time();
	$lastPing = time();

	while (!connection_aborted()) {
		if (time() - $started >= MAX_RUNTIME_SEC) {
			break; // EventSource が自動で再接続し、history_init からやり直す
		}

		usleep(POLL_INTERVAL_MS * 1000);

		$pollStmt->execute([$label, $lastSeq]);
		$newRows = $pollStmt->fetchAll(PDO::FETCH_ASSOC);
		if ($newRows !== []) {
			foreach ($newRows as $row) {
				$lastSeq = max($lastSeq, (int) $row['seq']);
			}
			send_event('history_update', $newRows);
		}

		if (time() - $lastPing >= PING_INTERVAL_SEC) {
			echo ": ping\n\n";
			flush();
			$lastPing = time();
		}
	}
	exit;
}

$stmt = $sql->prepare('SELECT Label, `Value`, Timestamp FROM telemetry ORDER BY dbID');

// 初回は全行を送り、スナップショットとして保持する
$snapshot = [];
$rows = fetch_all_rows($stmt);
foreach ($rows as $row) {
	$snapshot[$row['Label']] = $row['Value'] . '|' . $row['Timestamp'];
}
send_event('init', $rows);

$started  = time();
$lastPing = time();

while (!connection_aborted()) {
	if (time() - $started >= MAX_RUNTIME_SEC) {
		break; // EventSource が自動で再接続し、init からやり直す
	}

	usleep(POLL_INTERVAL_MS * 1000);

	$changed = [];
	foreach (fetch_all_rows($stmt) as $row) {
		$key = $row['Value'] . '|' . $row['Timestamp'];
		if (($snapshot[$row['Label']] ?? null) !== $key) {
			$snapshot[$row['Label']] = $key;
			$changed[] = $row;
		}
	}
	if ($changed !== []) {
		send_event('update', $changed);
	}

	// 定期的にコメント行を送って接続維持＆切断検知を早める
	if (time() - $lastPing >= PING_INTERVAL_SEC) {
		echo ": ping\n\n";
		flush();
		$lastPing = time();
	}
}
