<?php
//print_r($_POST);
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

if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Add Video')) {
    extract($_POST);
    if ($video_type == '0') {
        if ($video_sale == '1') {
            if ((isset($_FILES['file_photo']['name'])) && ($_FILES['file_photo']['name'] != '')) {
                /* USER IMAGE UPLOAD */
                $filename = $_FILES['file_photo']['name'];
                $file_ext = ".".pathinfo($filename,PATHINFO_EXTENSION);

                //$file_ext = strrchr($filename, '.');

                $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
                if (!in_array($file_ext, $whitelist)) {
                    $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
                } else {
                    /* echo "You Tube Saleable";
                      exit(); */
                    $data = array(
                        "user_id" => $_SESSION['talent_id'],
                        "video_name" => mysqli_real_escape_string( $link ,trim($_POST['video_name'])),
                        "video_type" => mysqli_real_escape_string( $link ,trim($_POST['video_type'])),
                        "video_code" => mysqli_real_escape_string( $link ,trim($_POST['video_code'])),
                        "status" => '1'
                    );
                    $table = "tbl_profile_videos";
                    insertData($data, $table);
                    $vid = mysqli_insert_id($link);

                    /* INSERT INTO tbl_products */
                    $data1 = array(
                        "uid" => $_SESSION['talent_id'],
                        "ref_id" => $vid,
                        "product_name" => mysqli_real_escape_string( $link ,trim($_POST['video_name'])),
                        "product_price" => mysqli_real_escape_string( $link ,trim($_POST['product_price'])),
                        "shipping" => mysqli_real_escape_string( $link ,trim($_POST['shipping1'])),
                        "p_shipping" => mysqli_real_escape_string( $link ,trim($_POST['p_shipping'])),
                        "content_type" => '2',
                        "status" => '1'
                    );
                    $table1 = "tbl_products";
                    insertData($data1, $table1);
                    $Mid = mysqli_insert_id($link);

                    $source_path = $_FILES['file_photo']['tmp_name'];
                    $destination = "../_temp/" . $vid . ".jpg";
                    upload_my_file($source_path, $destination);

                    /* copy upload file in profile_music folder copy in to temp folder */
                    $source = "../_temp/" . $vid . '.jpg';
                    $destination1 = "../_uploads/video_photo/" . $vid . ".jpg";
                    $size1 = PROFILE_PHOTO_THUMB;
                    create_thumb($source, $size1, $destination1);


                    /* INSERT PHOTO PROFILE PRODUCT FOLDER */
                    $destination2 = "../_uploads/profile_product/" . $Mid . ".jpg";
                    copy($source, $destination2);

                    $destination3 = "../_uploads/profile_product/thumb/" . $Mid . ".jpg";
                    $size3 = PROFILE_PHOTO_THUMB;
                    create_thumb($source, $size3, $destination3);

                    /* delete temp folder file */
                    unlink("../_temp/" . $vid . ".jpg");

                    /* Added Activity Below */

                    $uname = (GetChatUserName($_SESSION["talent_id"]));
                    SaveActivity(4, $uname, mysqli_real_escape_string( $link ,trim($_POST['video_name'])), $_SESSION["talent_id"]);

                    //////////////////////////////////////////////////

                    $MSG1 = "Your Youtube Video File Added sucessfully!";
                }
            }
        } else {
            if ((isset($_FILES['file_photo']['name'])) && ($_FILES['file_photo']['name'] != '')) {
                /* USER IMAGE UPLOAD */
                $filename = $_FILES['file_photo']['name'];
                $file_ext = ".".pathinfo($filename,PATHINFO_EXTENSION);

                //$file_ext = strrchr($filename, '.');

                $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
                if (!in_array($file_ext, $whitelist)) {
                    $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
                } else {
                    /* echo "You Tube Not Saleable";
                      exit(); */

                    $data = array(
                        "user_id" => $_SESSION['talent_id'],
                        "video_name" => mysqli_real_escape_string( $link ,trim($_POST['video_name'])),
                        "video_type" => mysqli_real_escape_string( $link ,trim($_POST['video_type'])),
                        "video_code" => mysqli_real_escape_string( $link ,trim($_POST['video_code'])),
                        "status" => '1'
                    );
                    $table = "tbl_profile_videos";
                    insertData($data, $table);
                    $vid = mysqli_insert_id($link);

                    $source_path1 = $_FILES['file_photo']['tmp_name'];
                    $destination1 = "../_temp/" . $vid . ".jpg";
                    upload_my_file($source_path1, $destination1);

                    /* copy upload file in profile_music folder copy in to temp folder */
                    $source = "../_temp/" . $vid . '.jpg';
                    $destination = "../_uploads/video_photo/" . $vid . ".jpg";
                    $size = PROFILE_PHOTO_THUMB;
                    create_thumb($source, $size, $destination);

                    /* delete temp folder file */
                    unlink("../_temp/" . $vid . ".jpg");

                    /* Added Activity Below */

                    $uname = (GetChatUserName($_SESSION["talent_id"]));
                    SaveActivity(4, $uname, mysqli_real_escape_string( $link ,trim($_POST['video_name'])), $_SESSION["talent_id"]);

                    //////////////////////////////////////////////////

                    $MSG1 = "Your Youtube Video File Added sucessfully!";
                }
            }
        }
    } else {
        if ($video_sale == '1') {

            if (((isset($_FILES['file_photo']['name'])) && ($_FILES['file_photo']['name'] != '')) || (isset($_FILES['mp4_file']['name']) && ($_FILES['mp4_file']['name'] != ''))) {
                /* USER IMAGE UPLOAD */
                $filename = $_FILES['file_photo']['name'];
                $file_ext = ".".pathinfo($filename,PATHINFO_EXTENSION);

                //$file_ext = strrchr($filename, '.');

                $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
                if (!in_array($file_ext, $whitelist)) {
                    $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
                } else {
                    $filename1 = $_FILES['mp4_file']['name'];
                    $file_ext1 = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename1), '.');

                    //$file_ext1 = strrchr($filename1, '.');
                    $whitelist1 = array(".mp4");
                    if (!in_array($file_ext1, $whitelist1)) {
                        $MSG = 'Not allowed extension,please upload mp4 file only!';
                    } else {
                        /* echo "VIDEO Saleable";
                          exit(); */
                        /* INSERT INTO tbl_profile_videos */
                        $data = array(
                            "user_id" => $_SESSION['talent_id'],
                            "video_name" => mysqli_real_escape_string( $link ,trim($_POST['video_name'])),
                            "video_type" => mysqli_real_escape_string( $link ,trim($_POST['video_type'])),
                            "video_code" => mysqli_real_escape_string( $link ,trim($_POST['video_code'])),
                            "status" => '1'
                        );
                        $table = "tbl_profile_videos";
                        insertData($data, $table);
                        $vid = mysqli_insert_id($link);

                        /* INSERT INTO tbl_products */
                        $data1 = array(
                            "uid" => $_SESSION['talent_id'],
                            "ref_id" => $vid,
                            "product_name" => mysqli_real_escape_string( $link ,trim($_POST['video_name'])),
                            "product_price" => mysqli_real_escape_string( $link ,trim($_POST['product_price'])),
                            "shipping" => mysqli_real_escape_string( $link ,trim($_POST['shipping1'])),
                            "p_shipping" => mysqli_real_escape_string( $link ,trim($_POST['p_shipping'])),
                            "content_type" => '2',
                            "status" => '1'
                        );
                        $table1 = "tbl_products";
                        insertData($data1, $table1);
                        $Mid = mysqli_insert_id($link);

                        /* INSERT PHOTO VIDEO PHOTO FOLDER */
                        $source_path = $_FILES['file_photo']['tmp_name'];
                        $destination = "../_temp/" . $vid . ".jpg";
                        upload_my_file($source_path, $destination);

                        /* copy upload file in profile_music folder copy in to temp folder */
                        $source = "../_temp/" . $vid . '.jpg';
                        $destination1 = "../_uploads/video_photo/" . $vid . ".jpg";
                        $size1 = PROFILE_PHOTO_THUMB;
                        create_thumb($source, $size1, $destination1);

                        /* INSERT PHOTO PROFILE PRODUCT FOLDER */
                        $destination2 = "../_uploads/profile_product/" . $Mid . ".jpg";
                        copy($source, $destination2);

                        $destination3 = "../_uploads/profile_product/thumb/" . $Mid . ".jpg";
                        $size3 = PROFILE_PHOTO_THUMB;
                        create_thumb($source, $size3, $destination3);


                        /* delete temp folder file */
                        unlink("../_temp/" . $vid . ".jpg");

                        /* INSERT VIDEO FILE PROFILE VIDEO FOLDER */

                        $source_path2 = $_FILES['mp4_file']['tmp_name'];
                        $destination2 = "../_temp/" . $vid . ".mp4";
                        upload_my_file($source_path2, $destination2);

                        /* copy upload file in profile_music folder copy in to temp folder */
                        $file = "../_temp/" . $vid . ".mp4";
                        $newfile = "../_uploads/profile_video/" . $vid . ".mp4";
                        copy($file, $newfile);

                        /* delete temp folder file */
                        unlink("../_temp/" . $vid . ".mp4");

                        /* Added Activity Below */

                        $uname = (GetChatUserName($_SESSION["talent_id"]));
                        SaveActivity(4, $uname, mysqli_real_escape_string( $link ,trim($_POST['video_name'])), $_SESSION["talent_id"]);

                        //////////////////////////////////////////////////


                        $MSG1 = "Your Video File Added sucessfully!";
                    }
                }
            }
        } else {

            if (((isset($_FILES['file_photo']['name'])) && ($_FILES['file_photo']['name'] != '')) || (isset($_FILES['mp4_file']['name']) && ($_FILES['mp4_file']['name'] != ''))) {
                /* USER IMAGE UPLOAD */
                $filename = $_FILES['file_photo']['name'];
                $file_ext = ".".pathinfo($filename,PATHINFO_EXTENSION);

                //$file_ext = strrchr($filename, '.');

                $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
                if (!in_array($file_ext, $whitelist)) {
                    $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
                } else {
                    $filename1 = $_FILES['mp4_file']['name'];
                    $file_ext1 = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename1), '.');

                    //$file_ext1 = strrchr($filename1, '.');

                    $whitelist1 = array(".mp4");
                    if (!in_array($file_ext1, $whitelist1)) {
                        $MSG = 'Not allowed extension,please upload mp4 file only!';
                    } else {
                        /* echo "VIDEO Not Saleable";
                          exit(); */
                        $data = array(
                            "user_id" => $_SESSION['talent_id'],
                            "video_name" => mysqli_real_escape_string( $link ,trim($_POST['video_name'])),
                            "video_type" => mysqli_real_escape_string( $link ,trim($_POST['video_type'])),
                            "video_code" => mysqli_real_escape_string( $link ,trim($_POST['video_code'])),
                            "status" => '1'
                        );
                        $table = "tbl_profile_videos";
                        insertData($data, $table);
                        $vid = mysqli_insert_id($link);

                        /* INSERT PHOTO VIDEO PHOTO FOLDER */
                        $source_path1 = $_FILES['file_photo']['tmp_name'];
                        $destination1 = "../_temp/" . $vid . ".jpg";
                        upload_my_file($source_path1, $destination1);

                        /* copy upload file in profile_music folder copy in to temp folder */
                        $source = "../_temp/" . $vid . '.jpg';
                        $destination = "../_uploads/video_photo/" . $vid . ".jpg";
                        $size = PROFILE_PHOTO_THUMB;
                        create_thumb($source, $size, $destination);

                        /* delete temp folder file */
                        unlink("../_temp/" . $vid . ".jpg");

                        /* INSERT VIDEO FILE PROFILE VIDEO FOLDER */

                        $source_path2 = $_FILES['mp4_file']['tmp_name'];
                        $destination2 = "../_temp/" . $vid . ".mp4";
                        upload_my_file($source_path2, $destination2);

                        /* copy upload file in profile_music folder copy in to temp folder */
                        $file = "../_temp/" . $vid . ".mp4";
                        $newfile = "../_uploads/profile_video/" . $vid . ".mp4";
                        copy($file, $newfile);

                        /* delete temp folder file */
                        unlink("../_temp/" . $vid . ".mp4");

                        /* Added Activity Below */

                        $uname = (GetChatUserName($_SESSION["talent_id"]));
                        SaveActivity(4, $uname, mysqli_real_escape_string( $link ,trim($_POST['video_name'])), $_SESSION["talent_id"]);

                        //////////////////////////////////////////////////

                        $MSG1 = "Your Video File Added sucessfully!";
                    }
                }
            }
        }
    }
}


include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#add_video').validate({
            rules: {
                mp4_file: {
                    /*required: true,*/
                    accept: "mp4"
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


    function clickme_ship1(id)
    {

        if (id == 0)
        {

            $('#you_tube2').slideUp('slow');
        }
        if (id == 1)
        {
            $('#you_tube2').slideDown('slow');

        }

    }



    function Validate_info() {
        if (document.add_video.video_sale.value == 1) {

            if (document.add_video.pdetails.value == 0) {

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
    <h1>Add Video</h1>
    <?php
    if (isset($MSG)) {
        ?>
        <p class="err">
            <?php
            if (isset($MSG) AND ( $MSG <> "")) {
                echo $MSG;
            }
            ?>
        </p>
        <?php
    }
    if (isset($MSG1)) {
        ?>
        <p class="msg">
            <?php
            if (isset($MSG1) AND ( $MSG1 <> "")) {
                echo $MSG1;
            }
            ?>
        </p>
    <?php } ?>
    <p style="text-align:right"><a href="manage_video.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->

            <div id="m_profile_left"><!--START CLASS m_profile_left PART -->

            </div><!--END CLASS m_profile_left PART -->

            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  enctype="multipart/form-data" id="add_video" name="add_video" onsubmit="return Validate_info()">
                    <input type="hidden" name="pdetails" value="<?php echo $pdetails; ?>" />
                    <p>
                        <label>
                            Video Title:
                        </label>
                        <input type="text" name="video_name" value="" class="required">
                    </p>
                    <p>
                        <label>
                            Select Photo:
                        </label>
                        <input type="file" name="file_photo" class="required">
                    </p>
                    <p>
                        <label>
                            Video Type : 
                        </label>
                        <select name="video_type" onchange="return clickme(this.value);">
                            <option value="1">File</option>
                            <option value="0">You Tube</option>
                        </select>
                    </p>
                    <div id="file_type">
                        <p>
                            <label>
                                Select Video:
                            </label>
                            <input type="file" name="mp4_file" class="required">
                        </p>
                        <p><span class="form_nots">Please upload mp4 file only</span></p>
                    </div>
                    <div id="you_tube">
                        <p>
                            <label style="vertical-align:top;">
                                Embed Code:
                            </label>
                            <TEXTAREA NAME="video_code" COLS="40" ROWS="6" class="required" ></TEXTAREA>
                             </p>
                            </div>
                            <p>
                            <label style="width:170px;">
                               Is This Video Saleable : 
                            </label>
                           <select name="video_sale" onchange="return clickme_ship(this.value);">
                              <option value="1">Yes</option>
                              <option value="0">No</option>
                              
                           </select>
                           </p>
                          <div id="you_tube1">
                           <p>
                              <label>Price:</label>
                              <input id="price" type="text" name="product_price" value="" class="required">
                            </p>
                            <p>
                              <label style="width:170px;">
                                 Shipping Charge:  : 
                              </label>
                             <select name="shipping1" onchange="return clickme_ship1(this.value);">
                                <option value="1">Yes</option>
                                <option value="0" selected="selected">No</option>
                             </select>
                           </p>
                            <div id="you_tube2">
                             <p>
                                <label>Shipping Amount:</label>
                                <input id="Shipping" type="text" name="p_shipping" value="" class="required">
                              </p>
                            </div>
                          </div>
                          <p>
                            <input type="submit" name="submit" value="Add Video" class="button">
                          </p>
                    </form>
                </div><!--END CLASS m_profile_right PART -->
            </div><!--END CLASS m_profile PART -->
			</div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->
<?php
include('../_includes/footer.php');
?>