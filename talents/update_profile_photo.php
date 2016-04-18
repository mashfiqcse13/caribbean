
<?php
include('../_includes/application-top.php');
ChecktalentLogin();

include('../_includes/header.php');
?>

<link type="text/css" rel="stylesheet" href="<?php echo SITE_URL; ?>_css/component.css" />
<script type="text/javascript" src="<?php echo SITE_URL; ?>_script/modernizr.custom.js">
</script>
<script type="text/javascript" src="<?php echo SITE_URL; ?>_script/toucheffects.js">
</script>
<?php
if ((isset($_POST['submit']))AND ( $_POST['submit'] == 'Update')) {
    /* move upload photo in temp folder */
    //get the file ext:
    $filename = $_FILES['img_path']['name'];
    $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

    //$file_ext = strrchr($filename, '.');
    //check if its allowed or not:
    $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
    if (!in_array($file_ext, $whitelist)) {
        $MSG = 'Not allowed extension,please upload images only!';
    } else {
        /* $linkcat="../_temp/".$_SESSION["talent_id"].'.jpg';
          @copy($_FILES["img_path"]["tmp_name"],$linkcat); */

        $source_path = $_FILES['img_path']['tmp_name'];
        $destination = "../_temp/" . $_SESSION["talent_id"] . ".jpg";
        upload_my_file($source_path, $destination);

        /* create thumb upload photo in user_photo folder copy in to temp folder */
        $source = "../_temp/" . $_SESSION["talent_id"] . '.jpg';
        $destination = "../_uploads/user_photo/" . $_SESSION["talent_id"] . ".jpg";
        $size = MEMBER_IMAGE_SIZE;
        create_thumb($source, $size, $destination);

        /* delete temp folder photo */
        unlink("../_temp/" . $_SESSION["talent_id"] . '.jpg');

        /* Added Activity Blow */
        $uname = (GetChatUserName($_SESSION["talent_id"]));
        SaveActivity(1, $uname, '', $_SESSION["talent_id"]);

        $statusquery = "SHOW TABLE STATUS WHERE name = 'tbl_profile_images'";
        $result = mysql_query($statusquery);
        $row = mysql_fetch_assoc($result);
        $next_id = $row['Auto_increment'];
        $imagename = $next_id . '.jpg';
        $successflag = 0;
        $src = "../_uploads/user_photo/" . $_SESSION["talent_id"] . ".jpg";
        $des = "../_uploads/profile_images/" . $_SESSION["talent_id"] . ".jpg";
        $newdes = "../_uploads/profile_images/" . $next_id . ".jpg";
        copy($src, $des);
        rename($des, $newdes);

        $sqlQry = "INSERT INTO tbl_profile_images (userid,imagename,status,createddate) VALUES ('" . $_SESSION["talent_id"] . "', '" . $imagename . "', '1', now())";

        $execQry = mysql_query($sqlQry);

        if ($execQry) {
            $successflag = 1;
        } else {
            $successflag = 0;
        }

        if ($successflag == 0) {
            echo "something happened seriously";
            die;
        }


        $MSG = 'Your Profile Photo has been updated Successfully!';

        header("Location:update_profile_photo.php");
    }
}

if (!empty($_REQUEST['photoid']) && $_REQUEST['action'] == "makeprofile") {
    //../_uploads/profile_images/1.jpg
    $file = "../_uploads/profile_images/" . $_REQUEST['photoid'] . ".jpg";
    $newfile = "../_uploads/user_photo/" . $_REQUEST['photoid'] . ".jpg";
    $newfile1 = "../_uploads/user_photo/" . $_SESSION["talent_id"] . ".jpg";
    copy($file, $newfile);
    unlink("../_uploads/user_photo/" . $_SESSION["talent_id"] . ".jpg");
    rename($newfile, $newfile1);
    $MSG = 'Your Profile Photo has been updated Successfully!';
    header("Location:update_profile_photo.php");
}

if ((isset($_REQUEST['action'])) AND ( $_REQUEST['action'] == 'delete')) {
    unlink("../_uploads/user_photo/" . $_SESSION["talent_id"] . ".jpg");
    $MSG = 'Your Profile Photo has been deleted Successfully!';
    header("Location:update_profile_photo.php");
}


if (!empty($_REQUEST['photoid']) && ($_REQUEST['action'] == 'delimage')) {

    $sqlQry = "DELETE FROM tbl_profile_images where id =" . $_REQUEST['photoid'];

    $execQry = mysql_query($sqlQry);

    if ($execQry) {
        $successflag = 1;
    } else {
        $successflag = 0;
    }

    if ($successflag == 0) {
        echo "something happened seriously with deletion";
        die;
    }

    unlink("../_uploads/profile_images/" . $_REQUEST['photoid'] . ".jpg");
    $MSG = 'Photo has been deleted Successfully!';
    header("Location:update_profile_photo.php");
}

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<script type="text/javascript">
    function back()
    {
        window.history.back();
    }

    function showonlyone(thechosenone) {
        $('.newboxes').each(function (index) {
            if ($(this).attr("id") == thechosenone) {
                $(this).show(200);
            } else {
                $(this).hide(600);
            }
        });
    }

    function Confrim_Delete(Url) //confarming property delete
    {
        if (confirm("Are you sure you want to delete this Photo ?"))
        {
            window.location = "" + Url;
            return false;
        }
    }

    function Confrim_Photo_Delete(Url) //confarming property delete
    {
        if (confirm("Are you sure you want to delete this Photo ?"))
        {
            window.location = "" + Url;
            return false;
        }
    }

    function Confrim_Profile_Photo(url) //confarming property delete
    {
        if (confirm("Are you sure you want to make this Profile Photo ?"))
        {
            window.location = "" + url;
        }
    }

</script> 
<div class="content">
    <h1>Update profile photo</h1>
    <!-- <p style="text-align:right"><a href="javascript:void(0)" class="button" style="float:left; margin:-5px 0px 5px 0px;" onclick="return back();">Back</a></p> -->
    <?php
    if (isset($MSG)) {
        ?>
        <p class="msg">
            <?php
            if (isset($MSG) AND ( $MSG <> "")) {
                echo $MSG;
            }
            ?>
        </p>
    <?php } ?>
    <div class="form_class">
        <div id="m_profile">
            <div id="m_profile_left">
                <ul>
                    <li><a href="change_password.php">Change Password</a></li>
                    <li><a href="edit_profile.php">Edit Profile</a></li>
                    <li><a href="profile_setup.php">Profile Setup</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
            <div id="m_profile_right">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <a id="exist_photos" href="javascript:showonlyone('newboxes1');" onclick="choose();" style="background-color: #ccc; padding: 0px 0px 0px 0px;">Choose From Photos...</a>
                    <a id="upload_new" href="javascript:showonlyone('newboxes2');" onclick="upload()" style="background-color: #ccc; padding: 0px 0px 0px 0px;">Upload Photo...</a>
                    <div class="newboxes" id="newboxes1" style="">
                        <p style="margin: 21px 0 -19px 273px;color: #333333;font-size: 14px;font-weight: bold;">Current Profile Photo:</p>
                        <?php $filename = "../_uploads/user_photo/" . $_SESSION["talent_id"] . ".jpg"; ?>

                        <?php if (file_exists($filename)) { ?>
                            <!-- <div style="border: 10px solid #CCFBB7;width: 120px;box-shadow: 5px 5px 5px #111;"> -->
                            <ul class="grid cs-style-3">
                                <li style="border: 10px solid #CCFBB7;box-shadow: 5px 5px 5px #111;left:210px;">
                                    <figure>
                                        <img width="200" height="200" src="../_uploads/user_photo/<?php echo $_SESSION["talent_id"] ?>.jpg"/>
                                        <!-- </div> -->
                                        <figcaption>
                                            <h3></h3>
                                            <span></span>
                                            <a class="button" href="<?php echo "javascript:Confrim_Delete('update_profile_photo.php?action=delete')"; ?>" style="position: absolute;bottom: 14px;right: 162px;" title="Delete This Photo">Delete</a>
                                            <!-- <a href="<?php echo "javascript:Confrim_Delete('update_profile_photo.php?action=delete')"; ?>" style="position: absolute;bottom: 14px;right: 45px;">Delete</a> -->
                                        </figcaption>
                                    </figure>
                                </li>
                            </ul>
    <!-- <a style="float: right;margin: -100px 635px 0 0;" href="<?php echo "javascript:Confrim_Delete('update_profile_photo.php?action=delete')"; ?>"><img src="../_images/del.png" title="Delete This Photo"></a> -->
                        <?php } else { ?>
                            <div style="">
                                <img width="200" height="200" src="../control/images/dummy.png"/>
                            </div>
                        <?php } ?>   
                        <p style="margin:164px -6px -8px 5px;color: #333333;font-size: 14px;font-weight: bold;">Old Profile Photos:</p>
                        <?php
                        $query = mysql_query("SELECT p.id AS PID, p.imagename AS image FROM tbl_profile_images AS p LEFT OUTER JOIN tbl_users AS u ON u.id=p.userid WHERE u.id='" . $_SESSION["talent_id"] . "' AND p.status=1 ORDER BY p.createddate DESC");


                        if (mysql_num_rows($query) > 0) {
                            ?>
                            <ul class="grid cs-style-3">
                                <?php
                                while ($row1 = mysql_fetch_assoc($query)) {
                                    ?>
                                    <li style="border: 10px solid #CCFBB7;box-shadow: 5px 5px 5px #111;">
                                        <figure>
                                            <img src="../_uploads/profile_images/<?php echo $row1['PID']; ?>.jpg" alt=" " width="200" height="200"/>
                                            <figcaption>
                                                <h3></h3>
                                                <span></span>
                                                <a class="button" style="bottom: 14px;left: -96px;position: absolute;right: 114px;" href="<?php echo "javascript:Confrim_Profile_Photo('update_profile_photo.php?photoid=" . $row1['PID'] . "&action=makeprofile')"; ?>">Make Profile Pic</a>
                                                <a class="button" href="<?php echo "javascript:Confrim_Photo_Delete('update_profile_photo.php?photoid=" . $row1['PID'] . "&action=delimage')"; ?>" style="position: absolute;bottom: 14px;right: 43px;">Delete</a>
                                            </figcaption>
                                        </figure>
                                    </li>
                                    <!-- </div> -->
                                <?php }
                                ?>
                            </ul>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="newboxes" id="newboxes2" style="">
                        <p style="margin: 21px 0 -19px 273px;color: #333333;font-size: 14px;font-weight: bold;">Current Profile Photo:</p>
                        <?php if (file_exists($filename)) { ?>
                            <ul class="grid cs-style-3">
                                <li style="border: 10px solid #CCFBB7;box-shadow: 5px 5px 5px #111;left:210px;">
                                    <figure>
                                        <img width="200" height="200" src="../_uploads/user_photo/<?php echo $_SESSION["talent_id"] ?>.jpg"/>
                                        <!-- </div> -->
                                        <figcaption>
                                            <h3></h3>
                                            <span></span>
                                            <a class="button" href="<?php echo "javascript:Confrim_Delete('update_profile_photo.php?action=delete')"; ?>" style="position: absolute;bottom: 14px;right: 162px;" title="Delete This Photo">Delete</a>
                                            <!-- <a href="<?php echo "javascript:Confrim_Delete('update_profile_photo.php?action=delete')"; ?>" style="position: absolute;bottom: 14px;right: 45px;">Delete</a> -->
                                        </figcaption>
                                    </figure>
                                </li>
                            </ul>
                        <?php } else { ?>
                            <div style="">
                                <img width="120" height="150" src="../control/images/dummy.png"/>
                            </div>
                        <?php } ?>
                        <p style="margin:164px -6px -8px 5px;color: #333333;font-size: 14px;font-weight: bold;">Upload New Profile Photo:</p>
                        <p><label style="float: unset;"></label><input type="file" name="img_path" value="" /><p>
                            <input type="submit" name="submit" value="Update" class="button" style="margin: 0 0 0 188px;"/>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include('../_includes/footer.php');
?>
