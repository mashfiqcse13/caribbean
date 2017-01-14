<?php
session_start();

$img = imagecreatetruecolor(90,30);

$white = imagecolorallocate($img, 255, 255, 255);
$black = imagecolorallocate($img, 0, 0, 0);
$grey = imagecolorallocate($img,150,150,150);
$red = imagecolorallocate($img, 255, 0, 0);
$pink = imagecolorallocate($img, 200, 0, 150);

function randomString($length){
    $chars = "abcdefghijkmnopqrstuvwxyz0123456789";
    srand((double)microtime()*1000000);
    $str = "";
    $i = 0;
    
        while($i <= $length){
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $str = $str . $tmp;
            $i++;
        }
    return $str;
}

for($i=1;$i<=rand(2,7);$i++){
    $color = (rand(1,2) == 1) ? $pink : $red;
    imageline($img,rand(5,50),rand(5,20), rand(5,50)+5,rand(5,20)+5, $color);
}

imagefill($img, 0, 0, $grey);

$string = randomString(rand(4,6));
$_SESSION['captcha_string'] = $string;

imagettftext($img, 11, 0, 5, 20, $black, "../fonts/Calibri.ttf", $string);

header("Content-type: image/png");
imagepng($img);
imagedestroy($img);
?>