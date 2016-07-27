<?php
include('../_includes/application-top.php');
ChecknontalentLogin();
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Add Book')) {
    /* USER IMAGE UPLOAD CHECK */
    $filename = $_FILES['img_path']['name'];
    $file_ext = strrchr($filename, '.');
    $whitelist = array(".jpg", ".jpeg", ".gif", ".png");

    if (!in_array($file_ext, $whitelist)) {
        $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
    } else {

        $data = array(
            "uid" => $_SESSION["user_id"],
            "name" => mysqli_real_escape_string( $link ,trim($_POST['name'])),
            "author" => mysqli_real_escape_string( $link ,trim($_POST['author'])),
            "book_details" => mysqli_real_escape_string( $link ,trim($_POST['book_details'])),
            "status" => '1'
        );
        $table = "tbl_profile_books";
        insertData($data, $table);

        $img_id = mysql_insert_id();

        $upload_file = $_FILES['img_path']['tmp_name'];
        $destination = "../_temp/" . $img_id . ".jpg";
        upload_my_file($upload_file, $destination);

        $source = "../_temp/" . $img_id . '.jpg';
        $dest = "../_uploads/profile_book_photo/thumb/" . $img_id . ".jpg";
        CreateFixedSizedImage($source, $dest, $width = 100, $height = 100);

        $destination = "../_uploads/profile_book_photo/" . $img_id . ".jpg";
        $size = PROFILE_PHOTO_MEDIUM;
        create_thumb($source, $size, $destination);

        unlink("../_temp/" . $img_id . '.jpg');
        header("Location:manage_book.php?op=a");
    }
}

include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#book_upload').validate({
            rules: {
                img_path: {
                    required: true,
                    accept: "jpg,png,jpeg,gif"
                }
            },
        });
    });
</script>

<div class="content"><!--START DIV CLASS content-->
    <h1>Add Book</h1>
    <p style="text-align:right"><a href="manage_book.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a>

    <div class="form_class"><!--START CLASS form_class PART -->

        <div id="m_profile"><!--START CLASS m_profile PART -->

            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->

                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="book_upload" enctype="multipart/form-data">
                    <p>
                        <label for="name">Name:</label>
                        <input type="text" name="name" value="" class="required" maxlength="150"/> 
                    </p>

                    <p>
                        <label for="author">Author:</label>
                        <input type="text" name="author" value="" class="required" maxlength="150"/> 
                    </p>

<!--<p>
        <label for="book_details">Book Details:</label>
        <input type="text" name="book_details" value="" class="required" maxlength="150"/> 
</p>-->

                    <p><label style="vertical-align:top;" for="book_details">Book Details:</label>
                        <textarea name="book_details" style="height:100px; width:300px;" class="required"></textarea>
                    </p>

                    <p><label>Select Photo:</label><input type="file" name="img_path" value="" class="required"/></p>

                    <input type="submit" name="submit" value="Add Book" class="button"/>
                </form>

            </div><!--END CLASS m_profile_right PART -->

        </div><!--END CLASS m_profile PART -->

    </div><!--END CLASS form_class PART -->

</div><!--END DIV CLASS content-->

<?php
include('../_includes/footer.php');
?>
