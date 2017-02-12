<?php
include('include/application_top.php');
cmslogin();
if (isset($_POST["update"])) {

    $data = array(
        "name" => $_POST['name'],
        "heading" => $_POST['heading'],
        "cms_text" => $_POST['cms_text'],
        "meta_keyword" => $_POST['meta_keyword'],
        "meta_description" => $_POST['meta_description'],
        "status" => $_POST['status']
    );
    $table = "tbl_cms";
    $parameters = "id='" . $_GET['id'] . "'";
    updateData($data, $table, $parameters);
    header("Location:cms.php?op=U");
}
?>
<?php include('include/header.php'); ?>


<?php
$result = mysqli_query($link,"SELECT * FROM tbl_cms WHERE id='" . $_GET['id'] . "' ");
if (!$result) {
    die("database query faild:" . mysqli_error($link));
}
?>

<?php
while ($row = mysqli_fetch_array($result)) {
    ?>
    <?php /* ?><div id="cms_heading"></div><?php */ ?>
    <div id="cms">
        <h1><?php echo $row['heading']; ?></h1>
        <form action="" method="post" id="login_check">
            <p><label>Name:</label><label><?php echo $row['name']; ?></label></p>
            <input type="hidden" size="50" name="name" value="<?php echo $row['name']; ?>" />
            <p><label>Heading:</label><input type="text" size="50" name="heading" value="<?php echo $row['heading']; ?>" class="required"/></p>
            <p><label style="vertical-align:top;">CmsText:</label>
                <textarea name="cms_text" id="txtContent" class="required"><?php echo $row['cms_text']; ?></textarea>

                <script language="javascript" type="text/javascript">
                    CKEDITOR.replace('txtContent');
                </script>
            </p>


            <?php /* ?><p><label style="vertical-align:top;">Page Title:</label><input type="text" size="50" name="page_title" value="<?php echo $row['page_title']; ?>" /></p><?php */ ?>
            <p><label style="vertical-align:top;">Meta Keyword:</label><textarea name="meta_keyword"><?php echo $row['meta_keyword']; ?></textarea></p>
            <p><label style="vertical-align:top;">Meta Description:</label><textarea name="meta_description" ><?php echo $row['meta_description']; ?></textarea></p>
            <p><label>Status:</label>
                <select name="status">
                    <option <?php
                    if ($row["status"] == "1") {
                        echo "selected='selected'";
                    }
                    ?> value="1">Active</option>
                    <option <?php
                    if ($row["status"] == "0") {
                        echo "selected='selected'";
                    }
                    ?> value="0">InActive</option>
                </select></p>
                
               <?php
                    if(isset($_GET['id']) && $_GET['id'] == 1){
                ?>
                <p><label style="vertical-align:top;">Change Home Images</label><a href="change_home_image.php">Click Here</a></p>
            
                <?php
                    }
               ?>
                
                
            <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
            <input type="submit" name="update" value="update" />
            <input type="button" value="Cancel" onclick='location.href = "cms.php";'>
        </form>
    </div>
    <?php
}
?>


<?php include('include/footer.php'); ?>