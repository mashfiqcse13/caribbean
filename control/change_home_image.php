<?php
include('include/application_top.php');
cmslogin();
?>

<?php
//    function resize_image($file, $w, $h, $crop=FALSE) {
//    list($width, $height) = getimagesize($file);
//    $r = $width / $height;
//    if ($crop) {
//        if ($width > $height) {
//            $width = ceil($width-($width*abs($r-$w/$h)));
//        } else {
//            $height = ceil($height-($height*abs($r-$w/$h)));
//        }
//        $newwidth = $w;
//        $newheight = $h;
//    } else {
//        if ($w/$h > $r) {
//            $newwidth = $h*$r;
//            $newheight = $h;
//        } else {
//            $newheight = $w/$r;
//            $newwidth = $w;
//        }
//    }
//    
//     $newwidth = 154;
//            $newheight = 358;
//    
//    $src = imagecreatefromjpeg($file);
////    echo $src;
////    die();
//    $dst = imagecreatetruecolor($newwidth, $newheight);
//    
////    echo $dst . '</br>';
////    echo $src. '</br>';
////    echo $newwidth. '</br>';
////    echo $newheight. '</br>';
////    echo $width. '</br>';
////    echo $height. '</br>';
////    die();
//    
//    
//    
//    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
//
// 
//    return $dst;
//}


?>



<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['h1']) && $_POST['h1'] == 'h1') {
        $target_dir = "../_images/";
        $target_file = $target_dir . "header_img_1.jpg";
//        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
//        resize_image("../_images/header_img_1.jpg" , 154, 358);
    }
    else if (isset($_POST['h2']) && $_POST['h2'] == 'h2') {
        $target_dir = "../_images/";
        $target_file = $target_dir . "header_img_2.jpg";
//        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
//        resize_image("../_images/header_img_1.jpg" , 154, 358);
    }
    else if (isset($_POST['h3']) && $_POST['h3'] == 'h3') {
        $target_dir = "../_images/";
        $target_file = $target_dir . "header_img_3.jpg";
//        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
//        resize_image("../_images/header_img_1.jpg" , 154, 358);
    }
    else if (isset($_POST['h4']) && $_POST['h4'] == 'h4') {
        $target_dir = "../_images/";
        $target_file = $target_dir . "header_img_4.jpg";
//        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
//        resize_image("../_images/header_img_1.jpg" , 154, 358);
    }

}
?>




<?php include('include/header.php'); ?>

<style>
    .home_left_side{
        width:639px;
        /*min-height:100px;*/
        background:#FFFFFF;
        float:left;
        padding:13px;
        -webkit-border-radius: 5px 5px 5px 5px;
        -moz-border-radius: 5px 5px 5px 5px;
        border-radius:5px 5px 5px 5px;
        -moz-box-shadow:1px 1px 8px 1px #ccc;
        -webkit-box-shadow:1px 1px 8px 1px #ccc;
        box-shadow:1px 1px 8px 1px #ccc;
    }
    /*clear:both;*/


    .home_left_side_first{
        width:100%;
        clear:both;
        /*border:thin solid #006600;*/
    }

    .home_img{
        width:154px;
        /*border:thin solid #CC0000;*/
        float:left;
        /*clear:both;*/
        margin:0px 7px 0px 0px;
        overflow: hidden;
    }
    .home_img a{
        padding:0px;
        margin:0px;
    }
    .home_img_4{
        width:154px;
        /*border:thin solid #CC0000;*/
        float:right;
        /*clear:both;*/
        margin:0px 0px 0px 0px;
        overflow: hidden;
    }

    .home_left_side_second{
        width:100%;
        /*min-height:100px;*/
        /*border:thin solid #663399;*/
        clear:both;
        overflow:hidden;
    }

    .home_text{
        width:154px;
        /*min-height:46px;*/
        /*background:url(../_images/slice_header_text.jpg) repeat-x;*/
        background: lightgrey;
        text-align:center;
        line-height:40px;
        margin:0px 7px 0px 0px;
        float:left;
    }
    .home_text a{
        font-family:Arial, Helvetica, sans-serif;
        font-size:16px;
        color:#292929;
        font-weight:bold;
    }
    .home_text a:hover{
        text-decoration:none;
    }

    .home_text_4{
        width:154px;
        /*min-height:46px;*/
        /*background:url(../_images/slice_header_text.jpg) repeat-x;*/
        background: lightgrey;
        text-align:center;
        line-height:40px;
        margin:0px 0px 0px 0px;
        float:right;
    }
    .home_text_4 a{
        font-family:Arial, Helvetica, sans-serif;
        font-size:16px;
        color:#292929;
        font-weight:bold;
    }
    .home_text_4 a:hover{
        text-decoration:none;
    }

</style>




<div class="home_left_side">
    <h4>Please Upload a photo with 154*358 size</h4>

    <div class="home_left_side_first">

        <div class="home_img">
            <!--<a href="artist-directory.php?id=<?php echo "1"; ?>" >-->
                  <!--<img src="_images/header_img_1.jpg" border="0" />--><img src="../_images/header_img_1.jpg" height="359" />
            <!--</a>-->
        </div>
        <div class="home_img">
            <!--<a href="artist-directory.php?id=<?php echo "5"; ?>">-->
            <img src="../_images/header_img_2.jpg"  border="0" height="359"/>
            <!--</a>-->
        </div>
        <div class="home_img">
            <!--<a href="artist-directory.php?id=<?php echo "7"; ?>">-->
            <img src="../_images/header_img_3.jpg" border="0" height="359" />
            <!--</a>-->
        </div>
        <div class="home_img_4">
            <!--<a href="artist-directory.php?id=<?php echo "2"; ?>">-->
            <img src="../_images/header_img_4.jpg" border="0" height="359" />
            <!--</a>-->
        </div>          
        <div class="clear"></div>
    </div>

    <!--
            <div class="home_left_side_second">
    
                <div class="home_text">
                    <a href="artist-directory.php?id=<?php echo "1"; ?>">MUSICIAN</a>
                </div>
                <div class="home_text">
                    <a href="artist-directory.php?id=<?php echo "5"; ?>">MODELS</a>
                </div>
                <div class="home_text">
                    <a href="artist-directory.php?id=<?php echo "7"; ?>">ACTORS</a>
                </div>
                <div class="home_text_4">
                    <a href="artist-directory.php?id=<?php echo "2"; ?>">ARTS</a>
                </div>
    
            </div>-->
    <div class="home_left_side_second">

        <div class="home_text">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload">
                <input type="hidden" name="h1" value="h1" >

                <input type="submit" value="Upload Image" name="submit">   
            </form>

           
        </div>
        <div class="home_text">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload">
                <input type="hidden" name="h2" value="h2" >

                <input type="submit" value="Upload Image" name="submit">   
            </form>
        </div>
        <div class="home_text">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload">
                <input type="hidden" name="h3" value="h3" >

                <input type="submit" value="Upload Image" name="submit">   
            </form>
        </div>
        <div class="home_text_4">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload">
                <input type="hidden" name="h4" value="h4" >

                <input type="submit" value="Upload Image" name="submit">   
            </form>
        </div>





    </div>



</div>



<?php include('include/footer.php'); ?>


<?php
//include('../_includes/footer.php');
?> 