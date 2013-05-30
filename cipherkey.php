<?
function EncodeCPT($pinCode, $offerCode, $shortKey, $longKey){
	$decodeX = " abcdefghijklmnopqrstuvwxyz0123456789!$%()*+,-.@;<=>?[]^_{|}~";
	
	if(strlen($offerCode) > 4) {
		$ocode = $offerCode % 10000;
	} else {
		$ocode = $offerCode;
	}
	
	$vob = array();
	$vob[0] = $ocode % 100;
	$vob[1] = ($ocode - $vob[0]) / 100;
	
	$encodeModulo = array();
	for($i = 0; $i < 61; $i++) {
		$encodeModulo[ord(substr($decodeX, $i, 1))] = $i;
	}
	
	$pinCode = strtolower($pinCode) . $offerCode;
	
	if(strlen($pinCode) < 20) {
		$pinCode .= " couponsincproduction";
		$pinCode = substr($pinCode, 0, 20);
	}

	$q = 0;	
	$j = strlen($pinCode);
	$k = strlen($shortKey);
	$cpt = "";

	for($i = 0; $i < $j; $i++) {
		$s1 = $encodeModulo[ord(substr($pinCode, $i, 1))];
		$s2 = 2 * $encodeModulo[ord(substr($shortKey, $i % $k, 1))];
		$s3 = $vob[$i % 2];
		$q = ($q + $s1 + $s2 + $s3) % 61;
		$cpt .= substr($longKey, $q, 1);
	}
	
	return $cpt;
}
?>
