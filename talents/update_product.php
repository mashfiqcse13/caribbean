<?php
include('../_includes/application-top.php');
ChecktalentLogin();
if (isset($_GET['id'])) {
    $sql = mysql_query("SELECT * FROM  tbl_products WHERE id='" . $_GET['id'] . "' order by id ");
    $result = mysql_fetch_assoc($sql);
    //print_r($result);
}

if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Update Product')) {

    //extract($_POST);
    if ((isset($_FILES['product_photo']['name'])) && ($_FILES['product_photo']['name'] != '')) {
        $filename = $_FILES['product_photo']['name'];
        $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

        //$file_ext = strrchr($filename, '.'); 
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
                "status" => $_POST['status'],
            );
            $table = "tbl_products";
            $parameters = "id='" . $_POST["pid"] . "'";
            updateData($data, $table, $parameters);

            $upload_file = $_FILES['product_photo']['tmp_name'];
            $destination = "../_temp/" . $_POST['pid'] . ".jpg";
            upload_my_file($upload_file, $destination);

            $source = "../_temp/" . $_POST['pid'] . '.jpg';

            $dest = "../_uploads/profile_product/thumb/" . $_POST['pid'] . ".jpg";
            CreateFixedSizedImage($source, $dest, $width = 150, $height = 150);

            $destination = "../_uploads/profile_product/" . $_POST['pid'] . ".jpg";
            $size = PROFILE_PHOTO_BIG;
            create_thumb($source, $size, $destination);

            unlink("../_temp/" . $_POST['pid'] . '.jpg');
            header("Location:manage_product.php?op=u");
        }
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
            "status" => $_POST['status'],
        );
        $table = "tbl_products";
        $parameters = "id='" . $_POST["pid"] . "'";
        updateData($data, $table, $parameters);
        header("Location:manage_product.php?op=u");
    }
}


include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#product_update').validate({
            rules: {
                product_photo: {
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
    <h1>Update Product</h1>
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
    <?php }
    ?>
    <p style="text-align:right"><a href="manage_product.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->

            <div id="m_profile_left"><!--START CLASS m_profile_left PART -->

            </div><!--END CLASS m_profile_left PART -->

            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" id="product_update" >
                    <input type="hidden" name="pid" value="<?php echo $result['id']; ?>" />
                    <p>
                        <label>Product Name:</label>
                        <input type="text" name="product_name" value="<?php echo $result['product_name']; ?>" class="required">
                    </p>
                    <p>
                        <label style="vertical-align:top;">Product Details:</label>

                        <TEXTAREA NAME="product_details" COLS=40 ROWS=6 class="required" ><?php echo $result['product_details']; ?></TEXTAREA></p>
                            <p>
                            <p>
                              <label>Product Price:</label>
                              <input id="price" type="text" name="product_price" value="<?php echo $result['product_price']; ?>" class="required">
                            </p>
                            <p>
                            <label>
                               Shipping Charge: 
                            </label>
                        <?php if ($result['shipping'] == 1) { ?>
                                   <select name="shipping" onchange="return clickme(this.value);">
                                      <option value="1" selected="selected">YES</option>
                                      <option value="0">NO</option>
                                   </select>
                        <?php } else { ?>
                                   <select name="shipping" onchange="return clickme(this.value);">
                                      <option value="1">YES</option>
                                      <option value="0" selected="selected">NO</option>
                                   </select>
                        <?php } ?> 
                           
                           </p>
                    <?php
                    if ($result['shipping'] == 1) {
                        ?>
                                    <div id="file_type" style="display:block;">
                                      <p>
                                        <label>Shipping Amount:</label>
                                        <input id="Shipping" type="text" name="p_shipping" value="<?php echo $result['p_shipping']; ?>" class="required">
                                      </p>
                                    </div>
                        <?php
                    } else {
                        ?>
                                    <div id="file_type" style="display:none;">
                                      <p>
                                        <label>Shipping Amount:</label>
                                        <input id="Shipping" type="text" name="p_shipping" value="<?php echo $result['p_shipping']; ?>" class="required">
                                      </p>
                                    </div>
                        <?php
                    }
                    ?>
                            <div id="you_tube"> 
                            </div>
                            <p>
                              <label style="vertical-align:top;">Video Code:</label>
                            
                            <TEXTAREA NAME="video_code" COLS=40 ROWS=6 ><?php echo $result['video_code']; ?></TEXTAREA></p>
                            <p>
                              <label>
                                 Select Photo:
                              </label>
                              <input type="file" name="product_photo" >
                            </p>
                            <p>
                                <label>
                                    Status:
                                </label>
                                <select name="status">
                                  <option <?php
                            if ($result["status"] == "1") {
                                echo "selected='selected'";
                            }
                            ?> value="1">Active</option>
                                  <option  <?php
                        if ($result["status"] == "0") {
                            echo "selected='selected'";
                        }
                        ?> value="0">Inactive</option>
                                </select>
                            </p>
                            <p> 
                            <input type="submit" name="submit" value="Update Product"  class="button">
                          </p>
                      </form>    
                </div><!--END CLASS m_profile_right PART -->
            </div><!--END CLASS m_profile PART -->
			</div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->

<?php
include('../_includes/footer.php');
?>
