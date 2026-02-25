<?php
$PASS_GEN = hash("sha3-256", $_REQUEST['PASS']);
$SHA_GEN = $PASS_GEN.hash("sha3-256", $_REQUEST['TEXT']).hash("sha3-256", $_REQUEST['Y']).hash("sha3-256", $_REQUEST['M']).hash("sha3-256", $_REQUEST['D']);

echo json_encode(array("GENE" => md5(hash("sha3-256", $SHA_GEN)), "PASS" => md5($PASS_GEN)));
?>