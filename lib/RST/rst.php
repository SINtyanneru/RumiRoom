<?php
class RST {
	private string $rst2html4_path = "/usr/bin/rst2html4";

	public function to_html($rst_text) {
		$cmd = [
			$this->rst2html4_path,
			"--no-doc-title",
			"--initial-header-level=2",
			"--report=2",
			"--halt=5",
			"--no-file-insertion",
			"--no-raw"
		];

		$descriptor = [
			0 => ['pipe', 'r'],
			1 => ['pipe', 'w'],
			2 => ['pipe', 'w'],
		];

		$proc = proc_open($cmd, $descriptor, $pipes);
		if (is_resource($proc) == false) throw new RuntimeException("rst2html4 を起動できません");

		fwrite($pipes[0], $rst_text);
		fclose($pipes[0]);

		$out = stream_get_contents($pipes[1]);
		$err = stream_get_contents($pipes[2]);
		fclose($pipes[1]);
		fclose($pipes[2]);

		$code = proc_close($proc);
		if ($code != 0) throw new RuntimeException("rst2html4 失敗: ".$err);

		if (preg_match('/<body>(.*)<\/body>/s', $out, $m)) {
			return trim($m[1]);
		} else {
			return $out;
		}
	}
}