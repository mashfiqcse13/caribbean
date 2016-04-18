<?php
include('../_includes/application-top.php');
ChecktalentLogin();
if ((isset($_POST['submit']))AND ( $_POST['submit'] == 'Add Product')) {

    /* move upload photo in temp folder */
    //get the file ext:
    $filename = $_FILES['product_photo']['name'];
    $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

    // $file_ext = strrchr($filename, '.'); 
    $whitelist = array(".jpg", ".jpeg", ".gif", ".png");

    if (!in_array($file_ext, $whitelist)) {
        $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
    } else {

        if ($_POST['shipping'] == 1) {
            $pshipping = mysql_real_escape_string(trim($_POST['p_shipping']));
        } else {
            $pshipping = "0.00";
        }

        $data = array(
            "uid" => $_SESSION['talent_id'],
            "product_name" => mysql_real_escape_string(trim($_POST['product_name'])),
            "product_details" => mysql_real_escape_string(trim($_POST['product_details'])),
            "product_price" => mysql_real_escape_string(trim($_POST['product_price'])),
            "shipping" => mysql_real_escape_string(trim($_POST['shipping'])),
            "p_shipping" => $pshipping,
            "video_code" => mysql_real_escape_string(trim($_POST['video_code'])),
            "content_type" => '0',
            "status" => '1'
        );
        $table = "tbl_products";
        insertData($data, $table);
        $lid = mysql_insert_id();

        $upload_file = $_FILES['product_photo']['tmp_name'];
        $destination = "../_temp/" . $lid . ".jpg";
        upload_my_file($upload_file, $destination);

        $source = "../_temp/" . $lid . '.jpg';

        $dest = "../_uploads/profile_product/thumb/" . $lid . ".jpg";
        CreateFixedSizedImage($source, $dest, $width = 150, $height = 150);

        $destination = "../_uploads/profile_product/" . $lid . ".jpg";
        $size = PROFILE_PHOTO_BIG;
        create_thumb($source, $size, $destination);

        unlink("../_temp/" . $lid . '.jpg');

        /* Added Activity Below */

        $uname = (GetChatUserName($_SESSION["talent_id"]));
        SaveActivity(13, $uname, mysql_real_escape_string(trim($_POST['product_name'])), $_SESSION["talent_id"]);

        //////////////////////////////////////////////////	

        $MSG1 = "Your Product upload sucessfully.";
    }
}


include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#add_product').validate({
            rules: {
                product_photo: {
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
</script>

<div class="content"><!--START CLASS contant PART -->
    <h1>Add Product</h1>
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
    <p style="text-align:right"><a href="manage_product.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->
            <div id="m_profile_left"><!--START CLASS m_profile_left PART -->

            </div><!--END CLASS m_profile_left PART -->

            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="add_product" >
                    <p>
                        <label>Product Name:</label>
                        <input type="text" name="product_name" value="" class="required">
                    </p>
                    <p>
                        <label style="vertical-align:top;">Product Details:</label>

                        <TEXTAREA NAME="product_details" COLS=40 ROWS=6 class="required" ></TEXTAREA></p>
                            <p>
                            <p>
                              <label>Product Price:</label>
                              <input id="price" type="text" name="product_price" value="" class="required">
                            </p>
                            <p>
                            <label>
                               Shipping Charge: 
                            </label>
                           <select name="shipping"  onchange="return clickme(this.value);">
                              <option value="1">YES</option>
                              <option value="0">NO</option>
                           </select>
                           </p>
                            <div id="file_type">
                              <p>
                                <label>Shipping Amount:</label>
                                <input id="Shipping" type="text" name="p_shipping" value="" class="required">
                              </p>
                            </div>
                            <div id="you_tube"> 
                            </div>
                            <p>
                              <label style="vertical-align:top;">Video Code:</label>
                            
                            <TEXTAREA NAME="video_code" COLS=40 ROWS=6 ></TEXTAREA></p>
                            <p>
                              <label>
                                 Select Photo:
                              </label>
                              <input type="file" name="product_photo" class="required">
                            </p>
                            <p>
                              <input type="submit" name="submit" value="Add Product" class="button">
                            </p>
                      </form>    
                  </div><!--END CLASS m_profile_right PART -->
            </div><!--END CLASS m_profile PART -->
			</div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->

<?php
include('../_includes/footer.php');
?>
