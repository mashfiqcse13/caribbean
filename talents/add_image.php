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



if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Add Image')) {
    if ((isset($_POST['product_price'])) && ($_POST['product_price'] != '')) {

        /* USER IMAGE UPLOAD */
        $filename = $_FILES['img_path']['name'];
        $file_ext = ".".pathinfo($filename,PATHINFO_EXTENSION);

        //$file_ext = strrchr($filename, '.');
        //preg_replace('/\.\w+$/e', 'strtolower("$0")', $string);
        $whitelist = array(".jpg", ".jpeg", ".gif", ".png");

        if (!in_array($file_ext, $whitelist)) {
            $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
        } else {
            $data = array(
                "user_id" => $_SESSION["talent_id"],
                "photo_title" => mysqli_real_escape_string( $link ,trim($_POST['photo_title'])),
                "photo_details" => mysqli_real_escape_string( $link ,trim($_POST['photo_details'])),
                "status" => '1'
            );
            insertData($data, "tbl_profile_photos");


            $img_id = mysqli_insert_id($link);

            /*  Aa fore Sold */
            $data1 = array(
                "uid" => $_SESSION['talent_id'],
                "ref_id" => $img_id,
                "product_name" => mysqli_real_escape_string( $link ,trim($_POST['photo_title'])),
                "product_details" => mysqli_real_escape_string( $link ,trim($_POST['photo_details'])),
                "product_price" => mysqli_real_escape_string( $link ,trim($_POST['product_price'])),
                "shipping" => mysqli_real_escape_string( $link ,trim($_POST['shipping'])),
                "p_shipping" => mysqli_real_escape_string( $link ,trim($_POST['p_shipping'])),
                "content_type" => '3',
                "status" => '1'
            );
            $table1 = "tbl_products";
            insertData($data1, $table1);

            $prod_id = mysqli_insert_id($link);

            $upload_file = $_FILES['img_path']['tmp_name'];
            $destination = "../_temp/" . $img_id . ".jpg";
            upload_my_file($upload_file, $destination);

            /* $source="../_temp/".$img_id.'.jpg';
              $destination="../_uploads/profile_photo/thumb/".$img_id.".jpg";
              $size=PROFILE_PHOTO_THUMB;
              create_thumb($source,$destination,$size); */

            $source1 = "../_temp/" . $img_id . '.jpg';

            $dest1 = "../_uploads/profile_product/thumb/" . $prod_id . ".jpg";
            CreateFixedSizedImage($source1, $dest1, $width = 150, $height = 150);

            $destination1 = "../_uploads/profile_product/" . $prod_id . ".jpg";
            $size = PROFILE_PHOTO_BIG;
            create_thumb($source1, $size, $destination1);


            /*             * ***********product photo************* */
            $source = "../_temp/" . $img_id . '.jpg';


            $dest = "../_uploads/profile_photo/thumb/" . $img_id . ".jpg";
            CreateFixedSizedImage($source, $dest, $width = 150, $height = 150);

            $destination = "../_uploads/profile_photo/" . $img_id . ".jpg";
            $size = PROFILE_PHOTO_BIG;
            create_thumb($source, $size, $destination);
            /* $source="../_temp/".$img_id.'.jpg';
              $dest="../_uploads/profile_photo/".$img_id.".jpg";
              CreateFixedSizedImage($source,$dest,$width=600,$height=600); */

            unlink("../_temp/" . $img_id . '.jpg');

            /* Added Activity Below */

            $uname = (GetChatUserName($_SESSION["talent_id"]));
            SaveActivity(2, $uname, mysqli_real_escape_string( $link ,trim($_POST['photo_title'])), $_SESSION["talent_id"]);

            //////////////////////////////////////////////////	


            header("Location:manage_photo.php?id=$user_idd&op=a");
        }
    } else {

        /* USER IMAGE UPLOAD */
        $filename = $_FILES['img_path']['name'];

        $file_ext = ".".pathinfo($filename,PATHINFO_EXTENSION);
        //echo $file_ext = strrchr($filename, '.');

        $whitelist = array(".jpg", ".jpeg", ".gif", ".png");

        if (!in_array($file_ext, $whitelist)) {
            $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
        } else {
            $data = array(
                "user_id" => $_SESSION["talent_id"],
                "photo_title" => mysqli_real_escape_string( $link ,trim($_POST['photo_title'])),
                "photo_details" => mysqli_real_escape_string( $link ,trim($_POST['photo_details'])),
                "status" => '1'
            );
            insertData($data, "tbl_profile_photos");


            $img_id = mysqli_insert_id($link);

            $upload_file = $_FILES['img_path']['tmp_name'];
            $destination = "../_temp/" . $img_id . ".jpg";
            upload_my_file($upload_file, $destination);

            $source = "../_temp/" . $img_id . '.jpg';


            $dest = "../_uploads/profile_photo/thumb/" . $img_id . ".jpg";
            CreateFixedSizedImage($source, $dest, $width = 150, $height = 150);

            $destination = "../_uploads/profile_photo/" . $img_id . ".jpg";
            $size = PROFILE_PHOTO_BIG;
            create_thumb($source, $size, $destination);
            /* $source="../_temp/".$img_id.'.jpg';
              $dest="../_uploads/profile_photo/".$img_id.".jpg";
              CreateFixedSizedImage($source,$dest,$width=600,$height=600); */

            unlink("../_temp/" . $img_id . '.jpg');

            /* Added Activity Below */

            $uname = (GetChatUserName($_SESSION["talent_id"]));
            SaveActivity(2, $uname, mysqli_real_escape_string( $link ,trim($_POST['photo_title'])), $_SESSION["talent_id"]);

            //////////////////////////////////////////////////

            header("Location:manage_photo.php?id=$user_idd&op=a");
        }
    }
}

include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#img_upload').validate({
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

    function clickme(id)
    {
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

    function clickme_ship(id)
    {

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

        if (document.add_mp3_songs.video_sale.value == 0) {

            if (document.add_mp3_songs.pdetails.value == 0) {

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
<div class="content"><!--START CLASS contant PART -->
    <h1>Add Image</h1>
    <p style="text-align:right"><a href="manage_photo.php<?php echo $user_idd; ?>" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a><br />
        <?php
        if (isset($MSG) AND ( $MSG <> "")) {
            echo "<p class='err'>" . $MSG . "</p>";
        }
        ?>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->


            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <!--/////USER IMAGE UPLOAD/////-->
                <form  name="add_mp3_songs" action="add_image.php?id=<?php $user_idd; ?>" method="post" id="add_mp3_songs" enctype="multipart/form-data" onsubmit="return Validate_info()">
                    <input type="hidden" name="pdetails" value="<?php echo $pdetails; ?>" />
                    <p><label for="photo_title">Title:</label>
                        <input type="text" name="photo_title" value="" class="required" maxlength="100"/> 
                    </p>
                    <p><label style="vertical-align:top;" for="photo_details">Details:</label>
                        <textarea name="photo_details" id="details" style="height:100px; width:300px;" maxlength="255"></textarea>
                    </p>				
                    <p><label>Select Photo:</label><input type="file" name="img_path" value="" class="required"/></p>
                    <p>
                        <label style="width:170px;">
                            Is This Photo Saleable : 
                        </label>
                        <select name="video_sale" onchange="return clickme(this.value);">
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
                                Shipping Charge:  
                            </label>
                            <select name="shipping" onchange="return clickme_ship(this.value);">
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
                    <input type="submit" name="submit" value="Add Image" class="button"/>
                </form>
            </div><!--END CLASS m_profile_right PART -->
        </div><!--END CLASS m_profile PART -->
    </div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->
<?php
include('../_includes/footer.php');
?>
