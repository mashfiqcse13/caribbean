<?php
include('include/application_top.php');
cmslogin();
?>

<?php include('include/header.php'); ?>



<?php
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    
    $target_file = "../_uploads/admin_avatar/admin_avatar.jpg";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    
}

?>

<?php  $image = "../_uploads/admin_avatar/admin_avatar.jpg";?>

<?php 
    if (file_exists($image)){
        ?>
     
        <img src="<?php echo $image . "?" . time(); ?>" height="100" width="100" />
    <?php
    }
    else{
    ?>
        <img src="images/dummy.png?<?php echo time();?>"  height="100" width="100" />
    
    <?php    
    }

?>



<form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>




<?php include('include/footer.php'); ?>