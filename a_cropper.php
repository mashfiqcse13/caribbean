<?php
die("Becareful ! I can see you !");
// basic of corping using cropper.js

$target_image_url = "http://mashfiq.caribbeancirclestars.com/uploadcontact/newname2015-04-27-23-53-22.jpg";

$target_image_url = "http://localhost/caribiean/uploadcontact/newname2016-04-25-20-02-19.jpg";

if(isset($_GET['submit'])){
    require_once './_includes/Croper.php';
    $form_data = $_GET ;
    unset($form_data['submit']);
    $resizing_data = json_encode($form_data);
    $croper = new Croper();
    $croper->resize_existing($target_image_url, $resizing_data, 'uploadcontact/croped.jpg');
}
?>

<script src="_script/cropper/jquery.min.js" type="text/javascript"></script>
<link href="_css/cropper/cropper.css" rel="stylesheet" type="text/css"/>
<script src="_script/cropper/cropper.js" type="text/javascript"></script>

<!-- Wrap the image or canvas element with a block element -->
<div style="display: block; width: 500px; height: 500px; margin: 0 auto;">
    <img id="image" src="<?php echo $target_image_url; ?>">
</div>

<form action="" method="get">
    <input id="X" type="hidden" name='x'/>
    <input id="Y" type="hidden" name='y'/>
    <input id="width" type="hidden" name='width'/>
    <input id="height" type="hidden" name='height'/>
    <input id="rotate" type="hidden" name='rotate'/>
    <input id="scaleX" type="hidden" name='scaleX'/>
    <input id="scaleY" type="hidden" name='scaleY'/>
    <input type="submit" name="submit" value="Save"/>
</form>

<script>
    $('#image').cropper({
        dragMode: 'move',
        restore: false,
        guides: false,
        highlight: false,
//        aspectRatio: 16 / 9,
        crop: function (e) {
            // Output the result data for cropping image.
            console.log("X :" + e.x);
            console.log("Y :" + e.y);
            console.log("width :" + e.width);
            console.log("height :" + e.height);
            console.log("rotate :" + e.rotate);
            console.log("scaleX :" + e.scaleX);
            console.log("scaleY :" + e.scaleY);
            
            $('form #X').val(e.x);
            $('form #Y').val(e.y);
            $('form #width').val(e.width);
            $('form #height').val(e.height);
            $('form #rotate').val(e.rotate);
            $('form #scaleX').val(e.scaleX);
            $('form #scaleY').val(e.scaleY);
        }
    });
</script>