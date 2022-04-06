<?php
header('Content-Type: image/png');
 //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Set the content-type

// Create the image
$im = imagecreatetruecolor(150, 20);

// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, 399, 29, $white);

global $code;
$x=180;								//Width of the grid
$y=30;								//Height of the grid
$step=20;							//Fit grid step
//unset($code);
$pass_lentgh=6;
$pattern="abcdefghijklmnpqrstuvwxyz123456789";
for($p=0; $p<$pass_lentgh; $p++) {
 $code.=substr($pattern,rand(1,strlen($pattern)),1);
}
$code=strtoupper($code);
session_start();
		$_SESSION['captchacode'] = $code;

$font = 'arial.ttf';

// Add some shadow to the text
imagettftext($im, 15, 0, 11, 21, $grey, $font, $code);

// Add the text
imagettftext($im, 15, 0, 10, 20, $black, $font, $code);

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);
?> 