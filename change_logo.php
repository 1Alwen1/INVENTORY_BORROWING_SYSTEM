<?php
$img = imagecreatefrompng('uploads/logo.png');
$color = imagecolorallocate($img, 136,136,136); // grey
$fontfile = 'C:/Windows/Fonts/arial.ttf';
$size = 18;
$text = "Alwen Casagan";

// compute box to center
$bbox = imagettfbbox($size, 0, $fontfile, $text);
$text_w = $bbox[2] - $bbox[0];
$text_h = $bbox[1] - $bbox[7];

$img_w = imagesx($img);
$img_h = imagesy($img);

// adjust these if the pill is off-center; this centers in whole image
$x = ($img_w - $text_w) / 2;
$y = ($img_h + $text_h) / 2;

imagettftext($img, $size, 0, (int)$x, (int)$y, $color, $fontfile, $text);
imagesavealpha($img, true);
imagepng($img, 'uploads/logo.png');
imagedestroy($img);
?>
