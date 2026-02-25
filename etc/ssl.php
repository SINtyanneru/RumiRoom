<?php
function getSSLCertificateExpiry($Domain) {
	$Context = stream_context_create(["ssl" => ["capture_peer_cert" => true]]);
	$Client = stream_socket_client("ssl://{$Domain}:443", $ErrNo, $ErrStr, 10, STREAM_CLIENT_CONNECT, $Context);
	if (!$Client) {
		return "接続失敗: {$ErrStr} ({$ErrNo})";
	}

	$Cert = stream_context_get_params($Client)["options"]["ssl"]["peer_certificate"];
	$CertInfo = openssl_x509_parse($Cert);
	$JuukouKigen = $CertInfo["validTo_time_t"];

	return date("Y-m-d H:i:s", $JuukouKigen);
}

if (isset($_GET["Domain"])) {
	echo $_GET["Domain"]."の証明書の有効期限は".getSSLCertificateExpiry($_GET["Domain"])."です";
} else {
	?>
	<FORM ACTION="" METHOD="GET">
		<INPUT TYPE="TEXT" NAME="Domain">
		<BUTTON>取得</BUTTON>
	</FORM>
	<?php
}
?>
