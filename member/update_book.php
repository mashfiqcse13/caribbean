<?php
include('../_includes/application-top.php');
ChecknontalentLogin();
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Update')) {

    /* USER IMAGE UPLOAD */
    if ((isset($_FILES['img_path']['name'])) && ($_FILES['img_path']['name'] != '')) {
        $filename = $_FILES['img_path']['name'];
        $file_ext = strrchr($filename, '.');
        $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
        if (!in_array($file_ext, $whitelist)) {
            $MSG = 'Not allowed extension,please upload ".jpg",".jpeg",".gif",".png" only!';
        } else {
            $data = array(
                "uid" => $_SESSION["user_id"],
                "name" => mysql_real_escape_string(trim($_POST['name'])),
                "author" => mysql_real_escape_string(trim($_POST['author'])),
                "book_details" => mysql_real_escape_string(trim($_POST['book_details'])),
                "status" => '1'
            );
            $table = "tbl_profile_books";
            $parameters = "id='" . $_GET['id'] . "'";
            updateData($data, $table, $parameters);

            $upload_file = $_FILES['img_path']['tmp_name'];
            $destination = "../_temp/" . $_GET['id'] . ".jpg";
            upload_my_file($upload_file, $destination);

            $source = "../_temp/" . $_GET['id'] . '.jpg';
            $dest = "../_uploads/profile_book_photo/thumb/" . $_GET['id'] . ".jpg";
            CreateFixedSizedImage($source, $dest, $width = 100, $height = 100);

            $source = "../_temp/" . $_GET['id'] . '.jpg';
            $destination = "../_uploads/profile_book_photo/" . $_GET['id'] . ".jpg";
            $size = PROFILE_PHOTO_MEDIUM;
            create_thumb($source, $size, $destination);


            unlink("../_temp/" . $_GET['id'] . '.jpg');

            header("Location:manage_book.php?op=u");
        }
    } else {
        $data = array(
            "uid" => $_SESSION["user_id"],
            "name" => mysql_real_escape_string(trim($_POST['name'])),
            "author" => mysql_real_escape_string(trim($_POST['author'])),
            "book_details" => mysql_real_escape_string(trim($_POST['book_details'])),
            "status" => '1'
        );
        $table = "tbl_profile_books";
        $parameters = "id='" . $_GET['id'] . "'";
        updateData($data, $table, $parameters);
        header("Location:manage_book.php?op=u");
    }
}
?>
<?php include('../_includes/header.php'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#book_update').validate({
            rules: {
                img_path: {
                    accept: "jpg,png,jpeg,gif"
                }
            },
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>

<div class="content"><!--START CLASS contant PART -->
    <h1>Upadte Book</h1>
    <p style="text-align:right"><a href="manage_book.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a>
        <?php
        if (isset($MSG) AND ( $MSG <> "")) {
            echo "<p class='err'>" . $MSG . "</p>";
        }
        ?>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->


            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <?php
                $result = mysql_query("SELECT * FROM  tbl_profile_books WHERE id='" . $_GET['id'] . "' ");
                ?>

                <?php
                while ($row = mysql_fetch_assoc($result)) {
                    ?>
                    <form action="update_book.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" id="book_update">
                        <p><label for="name">Name</label>
                            <input type="text" name="name" value="<?php echo $row['name'] ?>" class="required" /> 
                        </p>

                        <p><label for="author">Author</label>
                            <input type="text" name="author" value="<?php echo $row['author'] ?>" class="required" /> 
                        </p>

                        <?php /* ?><p><label for="book_details">Book Details</label>
                          <input type="text" name="book_details" value="<?php  echo $row['book_details']?>" class="required" />
                          </p><?php */ ?>

                        <p><label style="vertical-align:top;" for="book_details">Book Details:</label>
                            <textarea name="book_details" style="height:100px; width:300px;" class="required"><?php echo $row['book_details'] ?></textarea>
                        </p>

                        <!--///////CHECK THE IMAGE IS ALREADY EXITS OR NOT////////-->	
                        <?php
                        $img_path = "../_uploads/profile_book_photo/thumb/" . $row['id'] . ".jpg";
                        if (file_exists($img_path)) {
                            ?>

                            <p style="margin-left:140px;"><a href="../_uploads/profile_book_photo/<?php echo $row["id"]; ?>.jpg" class="fancybox"><img src="<?php echo $img_path; ?>" alt="Image"/></a></p>
                            <?php
                        }
                        ?>

                        <p><label>Select Photo:</label><input type="file" name="img_path"/></p>

                        <input type="submit" name="submit" value="Update" class="button" />
                    </form>
                    <?php
                }
                ?>
            </div><!--END ID m_profile_right PART -->
        </div><!--END ID m_profile PART -->
    </div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->
<?php include('../_includes/footer.php'); ?>



