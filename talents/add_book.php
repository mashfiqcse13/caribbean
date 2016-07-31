<?php
include('../_includes/application-top.php');
ChecktalentLogin();
/* chacking for payment delails */
$sql = mysqli_query($link,"SELECT * FROM  tbl_seller_bank WHERE uid='" . $_SESSION['talent_id'] . "' ");
$payment_details = mysqli_num_rows($sql);


if ($payment_details > 0) {
    $pdetails = "1";
} else {
    $pdetails = "0";
}



if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Add Book')) {

    if ((isset($_POST['product_price'])) && ($_POST['product_price'] != '')) {
        /* USER IMAGE UPLOAD CHECK */
        $filename = $_FILES['img_path']['name'];
        $file_ext = ".".pathinfo($filename,PATHINFO_EXTENSION);

        //$file_ext= strrchr($filename, '.');
        $whitelist = array(".jpg", ".jpeg", ".gif", ".png");

        if (!in_array($file_ext, $whitelist)) {
            $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
        } else {

            $data = array(
                "uid" => $_SESSION["talent_id"],
                "name" => mysqli_real_escape_string( $link ,trim($_POST['name'])),
                "author" => mysqli_real_escape_string( $link ,trim($_POST['author'])),
                "book_details" => mysqli_real_escape_string( $link ,trim($_POST['book_details'])),
                "status" => '1'
            );
            $table = "tbl_profile_books";
            insertData($data, $table);

            $img_id = mysqli_insert_id($link);

            /*  Aa fore Sold */
            $data1 = array(
                "uid" => $_SESSION['talent_id'],
                "ref_id" => $img_id,
                "product_name" => mysqli_real_escape_string( $link ,trim($_POST['name'])),
                "product_details" => mysqli_real_escape_string( $link ,trim($_POST['book_details'])),
                "product_price" => mysqli_real_escape_string( $link ,trim($_POST['product_price'])),
                "shipping" => mysqli_real_escape_string( $link ,trim($_POST['shipping'])),
                "p_shipping" => mysqli_real_escape_string( $link ,trim($_POST['p_shipping'])),
                "content_type" => '4',
                "status" => '1'
            );
            $table1 = "tbl_products";
            insertData($data1, $table1);
            $last_img = mysqli_insert_id($link);



            $upload_file = $_FILES['img_path']['tmp_name'];
            $destination = "../_temp/" . $img_id . ".jpg";
            upload_my_file($upload_file, $destination);

            $source = "../_temp/" . $img_id . '.jpg';
            $dest = "../_uploads/profile_book_photo/thumb/" . $img_id . ".jpg";
            CreateFixedSizedImage($source, $dest, $width = 100, $height = 100);

            $destination = "../_uploads/profile_book_photo/" . $img_id . ".jpg";
            $size = PROFILE_PHOTO_MEDIUM;
            create_thumb($source, $size, $destination);



            $destination1 = "../_uploads/profile_product/" . $last_img . ".jpg";
            copy($source, $destination1);

            $destination2 = "../_uploads/profile_product/thumb/" . $last_img . ".jpg";
            $size = PROFILE_PHOTO_THUMB;
            create_thumb($source, $size, $destination2);


            if (file_exists($source)) {
                unlink("../_temp/" . $img_id . '.jpg');
            }

            /* Added Activity Below */

            $uname = (GetChatUserName($_SESSION["talent_id"]));
            SaveActivity(5, $uname, mysqli_real_escape_string( $link ,trim($_POST['name'])), $_SESSION["talent_id"]);

            //////////////////////////////////////////////////

            header("Location:manage_book.php?op=a");
        }
    } else {
        /* USER IMAGE UPLOAD CHECK */
        $filename = $_FILES['img_path']['name'];
        $file_ext = ".".pathinfo($filename,PATHINFO_EXTENSION);

        //$file_ext= strrchr($filename, '.');
        $whitelist = array(".jpg", ".jpeg", ".gif", ".png");

        if (!in_array($file_ext, $whitelist)) {
            $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
        } else {

            $data = array(
                "uid" => $_SESSION["talent_id"],
                "name" => mysqli_real_escape_string( $link ,trim($_POST['name'])),
                "author" => mysqli_real_escape_string( $link ,trim($_POST['author'])),
                "book_details" => mysqli_real_escape_string( $link ,trim($_POST['book_details'])),
                "status" => '1'
            );
            $table = "tbl_profile_books";
            insertData($data, $table);

            $img_id = mysqli_insert_id($link);

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


            /* Added Activity Below */

            $uname = (GetChatUserName($_SESSION["talent_id"]));
            SaveActivity(5, $uname, mysqli_real_escape_string( $link ,trim($_POST['name'])), $_SESSION["talent_id"]);

            //////////////////////////////////////////////////

            header("Location:manage_book.php?op=a");
        }
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

        $("#price").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 46 || e.which > 57))
            {
                return false;
            }
        });

        $("#Shipping").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 46 || e.which > 57))
            {
                return false;
            }
        });
    });

    function clickme(id) {
        if (id == 1)
        {
            $('#file_type').slideDown('slow');
            $('#you_tube').slideUp('slow');
        }
        if (id == 0)
        {
            $('#you_tube').slideDown('slow');
            $('#file_type').slideUp('slow');
        }

    }


    function clickme_to(id) {


        if (id == 0)
        {
            $('#file_type1').slideDown('slow');
            $('#you_tube1').slideUp('slow');
        }
        if (id == 1)
        {
            $('#you_tube1').slideDown('slow');
            $('#file_type1').slideUp('slow');
        }
    }



    function Validate_info() {
        if (document.book_upload.video_type.value == 0) {

            if (document.book_upload.pdetails.value == 0) {

                if (confirm("Currently you do not have any bank details added, you need to add your bank details before adding any products for sellig.")) {
                    var Url = "update_payment_details.php";
                    window.location = "" + Url;
                    return false;
                } else {
                    return false;
                }
            }
        }
    }
</script>

<div class="content"><!--START DIV CLASS content-->
    <h1>Add Book</h1>
    <p style="text-align:right"><a href="manage_book.php<?php echo $user_idd; ?>" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a><br />
        <?php
        if (isset($MSG) AND ( $MSG <> "")) {
            echo "<p class='err'>" . $MSG . "</p>";
        }
        ?>
    <div class="form_class"><!--START CLASS form_class PART -->

        <div id="m_profile"><!--START CLASS m_profile PART -->

            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->

                <form name="book_upload" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="book_upload" enctype="multipart/form-data" onsubmit="return Validate_info()">
                    <input type="hidden" name="pdetails" value="<?php echo $pdetails; ?>" />
                    <p>
                        <label for="name">Name:</label>
                        <input type="text" name="name" value="" class="required" maxlength="150"/> 
                    </p>

                    <p>
                        <label for="author">Author:</label>
                        <input type="text" name="author" value="" class="required" maxlength="150"/> 
                    </p>


                    <p><label style="vertical-align:top;" for="book_details">Book Details:</label>
                        <textarea name="book_details" style="height:100px; width:300px;" class="required"></textarea>
                    </p>

                    <p><label>Select Photo:</label><input type="file" name="img_path" value="" class="required"/></p>


                    <p>
                        <label style="width:170px;">
                            Is This Book Saleable :
                        </label>
                        <select name="video_type" onchange="return clickme(this.value);">
                            <option value="1">No</option>
                            <option value="0">Yes</option>
                        </select>
                    </p>
                    <div id="file_type">
                    </div>
                    <div id="you_tube">
                        <p>
                            <label>Price:</label>
                            <input id="price" type="text" name="product_price" value="" class="required">
                        </p>


                        <p>
                            <label style="width:170px;">
                                Shipping Charge:  : 
                            </label>
                            <select name="shipping" onchange="return clickme_to(this.value);">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </p>
                        <div id="file_type1">
                        </div>
                        <div id="you_tube1">
                            <p>
                                <label>Shipping Amount:</label>
                                <input id="Shipping" type="text" name="p_shipping" value="" class="required">
                            </p>
                        </div>
                    </div>
                    <input type="submit" name="submit" value="Add Book" class="button"/>
                </form>

            </div><!--END CLASS m_profile_right PART -->

        </div><!--END CLASS m_profile PART -->

    </div><!--END CLASS form_class PART -->

</div><!--END DIV CLASS content-->

<?php
include('../_includes/footer.php');
?>
