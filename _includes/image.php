<?php

include_once 'image_common.php';
include_once 'image_class.captcha.php';

$captcha = new Captcha();

$captcha->chars_number = 6;
$captcha->font_size = 14;
$captcha->tt_font = 'verdana.ttf';

$captcha->show_image(100, 30);
?>