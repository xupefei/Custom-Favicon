<?php
function hex2rgb($hexColor) {
	$color = str_replace('#', '', $hexColor);
	if (strlen($color) > 3) {
		$rgb = array(
			'r' => hexdec(substr($color, 0, 2)),
			'g' => hexdec(substr($color, 2, 2)),
			'b' => hexdec(substr($color, 4, 2))
		);
	}
	else {
		$color = str_replace('#', '', $hexColor);
		$r = substr($color, 0, 1) . substr($color, 0, 1);
		$g = substr($color, 1, 1) . substr($color, 1, 1);
		$b = substr($color, 2, 1) . substr($color, 2, 1);
		$rgb = array(
			'r' => hexdec($r),
			'g' => hexdec($g),
			'b' => hexdec($b)
		);
}
	return $rgb;
}
function unicode_decode($unistr, $encoding = 'GBK', $prefix = '&#', $postfix = ';') {
	$arruni = explode($prefix, $unistr);
	$unistr = '';
	for($i = 1, $len = count($arruni); $i < $len; $i++) {
		if (strlen($postfix) > 0) {
			$arruni[$i] = substr($arruni[$i], 0, strlen($arruni[$i]) - strlen($postfix));
		}
		$temp = intval($arruni[$i]);
		$unistr .= ($temp < 256) ? chr(0) . chr($temp) : chr($temp / 256) . chr($temp % 256);
	}
	return iconv('UCS-2', $encoding, $unistr);
}
function unicode_encode($str, $encoding = 'GBK', $prefix = '&#', $postfix = ';') {
	$str = iconv($encoding, 'UCS-2', $str);
	$arrstr = str_split($str, 2);
	$unistr = '';
	for($i = 0, $len = count($arrstr); $i < $len; $i++) {
		$dec = hexdec(bin2hex($arrstr[$i]));
		$unistr .= $prefix . $dec . $postfix;
	}
	return $unistr;
} 

header('Content-type: image/png');

$char = '字';
$color = array(
	'r' => 0,
	'g' => 0,
	'b' => 0
);

$url = $_SERVER['HTTP_HOST'];

//$file = fopen("./test.txt","w");
//fwrite($file,$url);
//fclose($file);

//$url = "5b57.af10ea.icon.sukima.me";
if(preg_match("/^[0-9a-fA-F]{4}\.[0-9a-fA-F]{6}\.icon\.sukima\.me$/",$url)) {
	$url = substr($url, 0,11);
	$res = explode(".", $url);
	
	$char = unicode_decode("\\u".hexdec($res[0]), 'UTF-8', "\\u", '');
	$color = hex2rgb($res[1]);
}
else
	$char = '字';

$im = imagecreate(16, 16); 
$white = ImageColorAllocate($im, 255, 255, 255); 
$brush = ImageColorAllocate($im, $color['r'], $color['g'], $color['b']); 

imagecolortransparent($im, $white);

$fnt = "./font.ttf";
imagettftext($im, 12, 0, 0, 14, $brush, $fnt, $char); 
ImagePng($im); 
ImageDestroy($im);
?>
