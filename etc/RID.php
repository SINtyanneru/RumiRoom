<?php
function RID_GEN($A, $B, $C){
	$MICROTUME = str_replace(".", "", microtime(true));
	$RAND1 = rand(1, $A);
	$RAND2 = rand(1, $B);
	$RAND3 = substr(md5($RAND2), 0, $C);
	$RAND4 = "";
	
	for ($I = 0; $I < strlen($RAND3); $I++){
		$RAND4 .= ord($RAND3[$I]);
	}
	
	return $RAND1.$MICROTUME.$RAND4;
}

echo RID_GEN(512, 512, 5);
?>