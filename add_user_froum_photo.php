<?php
include('_includes/application-top.php');
CheckLoginForum();


//echo "<pre>";
//
//print_r($_SESSION);
// Check if image file is a actual image or fake image
if (isset($_POST['submit']) && $_POST['submit'] == "Upload Image") {



    if (isset($_SESSION['user_id'])) {
        $target_file = "_uploads/user_avatar/" . $_SESSION['user_id'] . ".jpg";
    }
    if (isset($_SESSION['talent_id'])) {
        $target_file = "_uploads/user_avatar/" . $_SESSION['talent_id'] . ".jpg";
    }

    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    header("Location:" . BASE_URL . "add_user_froum_photo.php");
    die();
}



if (isset($_POST['submit']) && $_POST['submit'] == "Use Image") {
    if (isset($_SESSION['user_id'])) {
        $target_file = "_uploads/user_avatar/" . $_SESSION['user_id'] . ".jpg";

        $sql = "UPDATE tbl_users set forum_avatar_setting = " . $_POST['use'] . " WHERE id =" . $_SESSION['user_id'] . ";";
        mysqli_query($link, $sql);
    }
    if (isset($_SESSION['talent_id'])) {
        $target_file = "_uploads/user_avatar/" . $_SESSION['talent_id'] . ".jpg";

        $sql = "UPDATE tbl_users set forum_avatar_setting = " . $_POST['use'] . " WHERE id =" . $_SESSION['talent_id'] . ";";
        mysqli_query($link, $sql);
    }
    header("Location:" . BASE_URL . "add_user_froum_photo.php");
    die();
}




if (isset($_POST['submit']) && $_POST['submit'] == "Remove Image") {
    $filename = "_uploads/user_avatar/" . $_SESSION['user_id'] . ".jpg";
    if (file_exists($filename)) {
        unlink($filename);
    }
    header("Location:" . BASE_URL . "add_user_froum_photo.php");
    die();
}
?>

<?php include('_includes/header.php'); ?> 


<style>
    table{
        width: 50%;
        margin: 0 auto;
        padding-top:   100px;
    }
</style>


<div class="content">


<h1>Add Fourm Image</h1>

<p style="text-align:right">

    <a href="add-forum-topic.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a>

</p>



<form action="" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td></td>
            <td>
                <?php
                if (isset($_SESSION['user_id'])) {

                    $image = "_uploads/user_avatar/" . $_SESSION['user_id'] . ".jpg";

                    if (file_exists($image)) {
                        ?>


                        <?php ?>
                        <img src="<?php echo $image . "?" . time(); ?>" height="100" width="100" />

                    <?php } else { ?>

                        <img src="control/images/dummy.png?<?php echo time(); ?>"  height="100" width="100" />


                        <?php
                    }
                }
                ?>
                        
                <?php
                if (isset($_SESSION['talent_id'])) {

                    $image = "_uploads/user_avatar/" . $_SESSION['talent_id'] . ".jpg";

                    if (file_exists($image)) {
                        ?>


                        <?php ?>
                        <img src="<?php echo $image . "?" . time(); ?>" height="100" width="100" />

                    <?php } else { ?>

                        <img src="control/images/dummy.png?<?php echo time(); ?>"  height="100" width="100" />


                        <?php
                    }
                }
                ?>        
                



            </td>


        </tr>


        <tr>

            <td><h4>Select image to upload:</h4></td>

            <td><input type="file" name="fileToUpload" id="fileToUpload" required></td>

        </tr>


        <tr>

            <td></td>
            <td>
                <input type="submit" value="Upload Image" name="submit">

            </td>

        </tr>


    </table>
</form>




<form action="" method="post" enctype="multipart/form-data">
    <table>

        <tr>

            <td width="255px"><h4>Chose Photo:</h4></td>

            <td>
                <select name="use">
                    <option value="1">Use Profile Photo</option>
                    <option value="0">Use Selected Photo</option>

                </select>

            </td>

        </tr>


        <tr>

            <td></td>
            <td><input type="submit" value="Use Image" name="submit"></td>

        </tr>


    </table>

</form>




<form action="" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td width="255px"></td>
            <td>

                <input type="submit" value="Remove Image" name="submit">

            </td>
        </tr>
    </table>
</form>


</div>

<?php
include('_includes/footer.php');
?>