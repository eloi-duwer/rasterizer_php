<?PHP

$img = imagecreatetruecolor(400, 300);
$color = imagecolorallocate($img, 255, 255, 255);
imagesetpixel($img, 100, 200, $color);
imagepng($img, "./img.png");


?>
