<?php
include('../_includes/application-top.php');
ChecktalentLogin();

/* chacking for payment delails */
$sql12 = mysqli_query($link,"SELECT * FROM  tbl_seller_bank WHERE uid='" . $_SESSION['talent_id'] . "' ");
$payment_details = mysqli_num_rows($sql12);

if ($payment_details > 0) {
    $pdetails = "1";
} else {
    $pdetails = "0";
}

if (isset($_GET['id'])) {
    $sql = mysqli_query($link,"SELECT tp.id as tbl_products_id, tp.ref_id, tp.product_price, tp.shipping, tp.p_shipping, ve.id AS VID, ve.video_name,ve.video_code, ve.video_type, ve.status, ve.user_id FROM  tbl_products As tp LEFT OUTER JOIN tbl_profile_videos AS ve ON tp.ref_id=ve.id WHERE ve.id=" . $_GET['id'] . " AND ve.user_id=" . $_SESSION['talent_id'] . "  AND tp.content_type='2'");

    if (mysqli_num_rows($sql) > 0) {
        $result = mysqli_fetch_assoc($sql);
        $prd_id = $result['VID'];
        $product_price = $result['product_price'];
    } else {
        $sql1 = mysqli_query($link,"SELECT ve.id AS VID, ve.video_name, ve.video_type, ve.video_code, ve.status, ve.user_id FROM  tbl_profile_videos AS ve WHERE id=" . $_GET['id'] . " AND user_id=" . $_SESSION['talent_id'] . " order by id ");
        $result = mysqli_fetch_assoc($sql1);
        $prd_id = 0;
        $product_price = "0.00";
    }
}

if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Update Video')) {
    extract($_POST);

    $data = array(
        "video_name" => mysqli_real_escape_string( $link ,trim($video_name)),
        "video_type" => $vtype,
        "video_code" => mysqli_real_escape_string( $link ,trim($video_code)),
        "status" => $status
    );
    $table = "tbl_profile_videos";
    $parameters = "id='" . $vid . "'";
    updateData($data, $table, $parameters);

    if ($video_sale == '1') {
        if ($vtype == '1') {
            $sql = "SELECT * " . "FROM tbl_products " . "WHERE id=" . $vpid . " AND uid=" . $_SESSION['talent_id'] . " AND ref_id=" . $vid . " ";
            $result = mysqli_query($link,$sql) or die(mysqli_error($link,));
            if (mysqli_num_rows($result) > 0) {
                $data = array(
                    'product_name' => mysqli_real_escape_string( $link ,$video_name),
                    "status" => $status,
                    'product_price' => $product_price,
                    "status" => $status
                );
                updateData($data, "tbl_products", "id=" . $vpid . " AND ref_id=" . $vid . " ");

                if ($shipping1 == 1) {
                    $data1 = array('shipping' => $shipping1,
                        'p_shipping' => $p_shipping);

                    updateData($data1, "tbl_products", "id=" . $vpid . " AND ref_id=" . $vid . " ");
                } else {
                    $data1 = array('shipping' => '0',
                        'p_shipping' => '0.00');

                    updateData($data1, "tbl_products", "id=" . $vpid . " AND ref_id=" . $vid . " ");
                }
            } else {
                $data = array(
                    'uid' => $_SESSION['talent_id'],
                    'ref_id' => $vid, "status" => $status,
                    'content_type' => '2',
                    'product_name' => mysqli_real_escape_string( $link ,$video_name),
                    'product_price' => $product_price,
                    "status" => $status
                );
                insertData($data, "tbl_products");
                $vpid = mysql_insert_id();

                if ($shipping1 == 1) {
                    $data1 = array('shipping' => $shipping1,
                        'p_shipping' => $p_shipping);

                    updateData($data1, "tbl_products", "id=" . $vpid . " AND ref_id=" . $vid . " ");
                } else {
                    $data1 = array('shipping' => '0',
                        'p_shipping' => '0.00');

                    updateData($data1, "tbl_products", "id=" . $vpid . " AND ref_id=" . $vid . " ");
                }

                $source = "../_uploads/video_photo/" . $vid . ".jpg";

                if (file_exists($source)) {

                    /* copy upload file in profile_music folder copy in to temp folder */
                    $videoimgpath = "../_uploads/video_photo/" . $vid . ".jpg";
                    $productimgpath = "../_uploads/profile_product/" . $vpid . ".jpg";

                    $size1 = PROFILE_PHOTO_THUMB1;

                    copy($videoimgpath, $productimgpath);

                    $productimgpaththumb = "../_uploads/profile_product/thumb/" . $vpid . ".jpg";

                    create_thumb($productimgpath, $size1, $productimgpaththumb);
                }
            }

            if ((isset($_FILES['file_photo']['name'])) && ($_FILES['file_photo']['name'] != '')) {
                $filename = $_FILES['file_photo']['name'];
                $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

                //$file_ext = strrchr($filename, '.');

                $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
                if (!in_array($file_ext, $whitelist)) {
                    $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
                } else {
                    $source_path1 = $_FILES['file_photo']['tmp_name'];
                    $destination1 = "../_temp/" . $vid . ".jpg";
                    upload_my_file($source_path1, $destination1);

                    /* copy upload file in profile_music folder copy in to temp folder */
                    $source = "../_temp/" . $vid . '.jpg';
                    $destination = "../_uploads/video_photo/" . $vid . ".jpg";
                    $size = PROFILE_PHOTO_BIG;
                    create_thumb($source, $size, $destination);

                    $size1 = PROFILE_PHOTO_THUMB1;
                    $productimgpaththumb = "../_uploads/profile_product/thumb/" . $vpid . ".jpg";
                    create_thumb($source, $size1, $productimgpaththumb);

                    /* copy upload file in profile_music folder copy in to temp folder */
                    $videoimgpath = "../_uploads/video_photo/" . $vid . ".jpg";
                    $productimgpath = "../_uploads/profile_product/" . $vpid . ".jpg";

                    copy($videoimgpath, $productimgpath);


                    /* delete temp folder file */
                    unlink("../_temp/" . $vid . ".jpg");
                }
            }

            if ((isset($_FILES['mp4_file']['name'])) && ($_FILES['mp4_file']['name'] != '')) {
                $filename1 = $_FILES['mp4_file']['name'];
                $file_ext1 = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename1), '.');

                //$file_ext1 = strrchr($filename1, '.');

                $whitelist1 = array(".mp4");

                if (!in_array($file_ext1, $whitelist1)) {
                    $MSG = 'Not allowed extension,please upload mp4 file only!';
                } else {
                    $source_path2 = $_FILES['mp4_file']['tmp_name'];
                    $destination2 = "../_temp/" . $vid . ".mp4";
                    upload_my_file($source_path2, $destination2);

                    $vfile = "../_uploads/profile_video/" . $vid . ".mp4";

                    copy($destination2, $vfile);
                    unlink($destination2);
                }
            }
        } else {


            $sql = "SELECT * " . "FROM tbl_products " . "WHERE id=" . $vpid . " AND uid=" . $_SESSION['talent_id'] . " AND ref_id=" . $vid . " ";
            $result = mysqli_query($link,$sql) or die(mysqli_error($link,));
            if (mysqli_num_rows($result) > 0) {
                $data = array(
                    'product_name' => mysqli_real_escape_string( $link ,$video_name),
                    "status" => $status,
                    'product_price' => $product_price,
                    "status" => $status
                );
                updateData($data, "tbl_products", "id=" . $vpid . " AND ref_id=" . $vid . " ");

                if ($shipping1 == 1) {
                    $data1 = array('shipping' => $shipping1,
                        'p_shipping' => $p_shipping);

                    updateData($data1, "tbl_products", "id=" . $vpid . " AND ref_id=" . $vid . " ");
                } else {
                    $data1 = array('shipping' => '0',
                        'p_shipping' => '0.00');

                    updateData($data1, "tbl_products", "id=" . $vpid . " AND ref_id=" . $vid . " ");
                }
            } else {
                $data = array(
                    'uid' => $_SESSION['talent_id'],
                    'ref_id' => $vid, "status" => $status,
                    'content_type' => '2',
                    'product_name' => mysqli_real_escape_string( $link ,$video_name),
                    'product_price' => $product_price,
                    "status" => $status
                );
                insertData($data, "tbl_products");
                $vpid = mysql_insert_id();

                if ($shipping1 == 1) {
                    $data1 = array('shipping' => $shipping1,
                        'p_shipping' => $p_shipping);

                    updateData($data1, "tbl_products", "id=" . $vpid . " AND ref_id=" . $vid . " ");
                } else {
                    $data1 = array('shipping' => '0',
                        'p_shipping' => '0.00');

                    updateData($data1, "tbl_products", "id=" . $vpid . " AND ref_id=" . $vid . " ");
                }
            }

            if ((isset($_FILES['file_photo']['name'])) && ($_FILES['file_photo']['name'] != '')) {
                $filename = $_FILES['file_photo']['name'];
                $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

                //$file_ext = strrchr($filename, '.');

                $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
                if (!in_array($file_ext, $whitelist)) {
                    $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
                } else {
                    $source_path1 = $_FILES['file_photo']['tmp_name'];
                    $destination1 = "../_temp/" . $vid . ".jpg";
                    upload_my_file($source_path1, $destination1);

                    /* copy upload file in profile_music folder copy in to temp folder */
                    $source = "../_temp/" . $vid . '.jpg';
                    $destination = "../_uploads/video_photo/" . $vid . ".jpg";
                    $size = PROFILE_PHOTO_BIG;
                    create_thumb($source, $size, $destination);

                    $size1 = PROFILE_PHOTO_THUMB1;
                    $productimgpaththumb = "../_uploads/profile_product/thumb/" . $vpid . ".jpg";
                    create_thumb($source, $size1, $productimgpaththumb);

                    /* copy upload file in profile_music folder copy in to temp folder */
                    $videoimgpath = "../_uploads/video_photo/" . $vid . ".jpg";
                    $productimgpath = "../_uploads/profile_product/" . $vpid . ".jpg";

                    copy($videoimgpath, $productimgpath);


                    /* delete temp folder file */
                    unlink("../_temp/" . $vid . ".jpg");
                }
            }

            $vfile = "../_uploads/profile_video/" . $vid . ".mp4";

            if (file_exists($vfile)) {
                unlink($vfile);
            }
        }
        header("location:manage_video.php?op=u");
    } else {
        if ($vtype == '1') {
            $sql = "SELECT * " . "FROM tbl_products " . "WHERE id=" . $vpid . " AND uid=" . $_SESSION['talent_id'] . " AND ref_id=" . $vid . " ";
            $result = mysqli_query($link,$sql) or die(mysqli_error($link,));
            if (mysqli_num_rows($result) > 0) {
                $sql = "DELETE " .
                        "FROM tbl_products " .
                        "WHERE id=" . $vpid . " AND ref_id=" . $vid . " ";
                $result = mysqli_query($link,$sql) or die(mysqli_error($link,));
            }


            $product_img_thumb = "../_uploads/profile_product/thumb/" . $vpid . ".jpg";
            $product_img_org = "../_uploads/profile_product/" . $vpid . ".jpg";

            if (file_exists($product_img_org)) {
                unlink($product_img_thumb);
                unlink($product_img_org);
            }

            if ((isset($_FILES['file_photo']['name'])) && ($_FILES['file_photo']['name'] != '')) {
                $filename = $_FILES['file_photo']['name'];
                $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

                //$file_ext = strrchr($filename, '.');

                $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
                if (!in_array($file_ext, $whitelist)) {
                    $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
                } else {
                    $source_path1 = $_FILES['file_photo']['tmp_name'];
                    $destination1 = "../_temp/" . $vid . ".jpg";
                    upload_my_file($source_path1, $destination1);

                    /* copy upload file in profile_music folder copy in to temp folder */
                    $source = "../_temp/" . $vid . '.jpg';
                    $destination = "../_uploads/video_photo/" . $vid . ".jpg";
                    $size = PROFILE_PHOTO_BIG;
                    create_thumb($source, $size, $destination);

                    /* delete temp folder file */
                    unlink("../_temp/" . $vid . ".jpg");
                }
            }

            if ((isset($_FILES['mp4_file']['name'])) && ($_FILES['mp4_file']['name'] != '')) {
                $filename1 = $_FILES['mp4_file']['name'];
                $file_ext1 = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename1), '.');

                //$file_ext1 = strrchr($filename1, '.');

                $whitelist1 = array(".mp4");

                if (!in_array($file_ext1, $whitelist1)) {
                    $MSG = 'Not allowed extension,please upload mp4 file only!';
                } else {
                    $source_path2 = $_FILES['mp4_file']['tmp_name'];
                    $destination2 = "../_temp/" . $vid . ".mp4";
                    upload_my_file($source_path2, $destination2);

                    $vfile = "../_uploads/profile_video/" . $vid . ".mp4";

                    copy($destination2, $vfile);
                    unlink($destination2);
                }
            }
        } else {

            $sql = "SELECT * " . "FROM tbl_products " . "WHERE id=" . $vpid . " AND uid=" . $_SESSION['talent_id'] . " AND ref_id=" . $vid . " ";
            $result = mysqli_query($link,$sql) or die(mysqli_error($link,));
            if (mysqli_num_rows($result) > 0) {

                $sql = "DELETE " .
                        "FROM tbl_products " .
                        "WHERE id=" . $vpid . " AND ref_id=" . $vid . " ";
                $result = mysqli_query($link,$sql) or die(mysqli_error($link,));
            }

            $product_img_thumb = "../_uploads/profile_product/thumb/" . $vpid . ".jpg";
            $product_img_org = "../_uploads/profile_product/" . $vpid . ".jpg";

            if (file_exists($product_img_org)) {
                unlink($product_img_thumb);
                unlink($product_img_org);
            }

            if ((isset($_FILES['file_photo']['name'])) && ($_FILES['file_photo']['name'] != '')) {
                $filename = $_FILES['file_photo']['name'];
                $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

                //$file_ext = strrchr($filename, '.');

                $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
                if (!in_array($file_ext, $whitelist)) {
                    $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
                } else {
                    $source_path1 = $_FILES['file_photo']['tmp_name'];
                    $destination1 = "../_temp/" . $vid . ".jpg";
                    upload_my_file($source_path1, $destination1);

                    /* copy upload file in profile_music folder copy in to temp folder */
                    $source = "../_temp/" . $vid . '.jpg';
                    $destination = "../_uploads/video_photo/" . $vid . ".jpg";
                    $size = PROFILE_PHOTO_BIG;
                    create_thumb($source, $size, $destination);


                    /* delete temp folder file */
                    unlink("../_temp/" . $vid . ".jpg");
                }
            }

            $vfile = "../_uploads/profile_video/" . $vid . ".mp4";

            if (file_exists($vfile)) {
                unlink($vfile);
            }
        }
        header("location:manage_video.php?op=u");
    }
}


include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#update_video').validate({
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



    $(document).ready(function () {
        $("a#video").fancybox({
            'width': 400,
            'height': 580,
            'scrolling': 'no',
            'autoScale': true,
            'titlePosition': 'over',
            'transitionIn': 'none',
            'transitionOut': 'none'
        });
    });

    function clickme(id) {
        if (id == 1)
        {
            $('#file_type').slideDown('slow');
            $('#you_tube').slideUp('slow');
            $("#video_code").val("");
        }
        if (id == 0)
        {
            $('#you_tube').slideDown('slow');
            $('#file_type').slideUp('slow');

        }



    }

    function clickme1(id)
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
            $("#Shipping").val("");
        }
        if (id == 1)
        {
            $('#you_tube2').slideDown('slow');

        }

    }

    function Validate_info() {
        if (document.update_video.video_sale.value == 1) {

            if (document.update_video.pdetails.value == 0) {

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
    <h1>Video update</h1>
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
    <p style="text-align:right"><a href="manage_video.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->

            <div id="m_profile_left"><!--START CLASS m_profile_left PART -->

            </div><!--END CLASS m_profile_left PART -->

            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <form name="update_video" action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data"
                      id="update_video" onsubmit="return Validate_info()" >
                    <input type="hidden" name="vid" value="<?php echo $result['VID']; ?>" />
                    <input type="hidden" name="pdetails" value="<?php echo $pdetails; ?>" />
                    <input type="hidden" name="vpid" value="<?php
                    if ((isset($result['tbl_products_id'])) && ($result['tbl_products_id'] != '')) {
                        echo $result['tbl_products_id'];
                    } else {
                        echo "0";
                    }
                    ?>" />
                    <p>
                        <label>
                            Video Title:
                        </label>
                        <input type="text" name="video_name" value="<?php echo $result['video_name']; ?>" class="required">
                    </p>
                    <p>
                        <label>
                            Select Photo:
                        </label>
                        <input type="file" name="file_photo">
                    </p>
                    <hr />



                    <?php
                    if ($result['video_type'] == 1) {
                        ?>
                        <p style="margin-left:140px;">
                            <a id="video" href="video_play.php?filename=../_uploads/profile_video/<?php echo $result["VID"]; ?>.mp4">
                                <img src="../_uploads/video_photo/<?php echo $result["VID"]; ?>.jpg" width="150" title="Play Video"/><br/>
                            </a>
                        </p>
                        <p>
                            <label>
                                Video Type : 
                            </label>
                            <select name="vtype" onchange="return clickme(this.value);">
                                <option value="1" selected="selected">File</option>
                                <option value="0">You Tube</option>
                            </select>
                        </p>
                        <div id="you_tube" style="display:none;">
                            <p>
                                <label style="vertical-align:top;">
                                    Embed Code:
                                </label>
                                <TEXTAREA id="video_code" NAME="video_code" COLS="40" ROWS="6" class="required" ></TEXTAREA>
                                   </p>
                                  </div>
                                  <div id="file_type" style="display:block;">
                                   <p>
                                      <label>
                                         Select Video:
                                      </label>
                                      <input type="file" name="mp4_file">
                                    </p>
                                    <p><span class="form_nots">Please upload mp4 file only</span></p>
                                   </div> 
                                   
                    <?php } else { ?>
                                    <p style="margin-left:140px;">
                                        <a id="video" href="video_play.php?filename=../_uploads/profile_video/<?php echo $result["VID"]; ?>.mp4">
                                           <img src="../_uploads/video_photo/<?php echo $result["VID"]; ?>.jpg" width="150" title="Play Video"/><br/>
                                        </a>
                                   </p>
                                    <p>
                                      <label>
                                         Video Type : 
                                      </label>
                                     <select name="vtype" onchange="return clickme(this.value);">
                                        <option value="1">File</option>
                                        <option value="0" selected="selected">You Tube</option>
                                     </select>
                                   </p>
                                   <div id="you_tube" style="display:block;">
                                   <p>
                                    <label style="vertical-align:top;">
                                             Embed Code:
                                    </label>
                                    <TEXTAREA id="video_code" NAME="video_code" COLS="40" ROWS="6" class="required" ><?php echo $result['video_code']; ?></TEXTAREA>
                                   </p>
                                  </div>
                                  <div id="file_type" style="display:none;">
                                   <p>
                                      <label>
                                         Select Video:
                                      </label>
                                      <input type="file" name="mp4_file">
                                    </p>
                                    <p><span class="form_nots">Please upload mp4 file only</span></p>
                                   </div> 
                                   
                    <?php } ?>                        
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
                          
                          
                          
                          
                          
                          <hr />
                            <?php
                        if ($product_price != '0.00') {
                            ?>
                                    <p>
                                      <label style="width:170px;">
                                         Is This Video Saleable : 
                                      </label>
                                     <select name="video_sale" onchange="return clickme1(this.value);">
                                        <option value="1" selected="selected">Yes</option>
                                        <option value="0">No</option>
                                     </select>
                                   </p>
                                   
                                   <div id="you_tube1">
                                   <p>
                                      <label>Price:</label>
                                      <input id="price" type="text" name="product_price" value="<?php
                            if ((isset($result['product_price'])) && ($result['product_price'] != '')) {
                                echo $result['product_price'];
                            }
                            ?>" class="required">
                                    </p>
                                <?php
                                if ($result['shipping'] == '1') {
                                    ?>
                                             <p>
                                              <label style="width:170px;">
                                                 Shipping Charge:  : 
                                              </label>
                                             <select name="shipping1" onchange="return clickme_ship1(this.value);">
                                                <option value="1" selected="selected">Yes</option>
                                                <option value="0" >No</option>
                                             </select>
                                           </p>
                                            <div id="you_tube2" style="display:block;">
                                             <p>
                                                <label>Shipping Amount:</label>
                                                <input id="Shipping" type="text" name="p_shipping" value="<?php
                                if ((isset($result['p_shipping'])) && ($result['p_shipping'] != '')) {
                                    echo $result['p_shipping'];
                                }
                                ?>" class="required">
                                              </p>
                                            </div> 
                                    <?php
                                    } else {
                                        ?>
                                             <p>
                                              <label style="width:170px;">
                                                 Shipping Charge:  : 
                                              </label>
                                             <select name="shipping1" onchange="return clickme_ship1(this.value);">
                                                <option value="1">Yes</option>
                                                <option value="0" selected="selected">No</option>
                                             </select>
                                           </p>
                                            <div id="you_tube2" style="display:none;">
                                             <p>
                                                <label>Shipping Amount:</label>
                                                <input id="Shipping" type="text" name="p_shipping" value="" class="required">
                                              </p>
                                            </div> 
                        <?php } ?>
                                   
                                                             
                                    </div>
                            <?php
                            } else {
                                ?>
                                    <p>
                                      <label style="width:170px;">
                                         Is This Video Saleable : 
                                      </label>
                                     <select name="video_sale" onchange="return clickme1(this.value);">
                                        <option value="1">Yes</option>
                                        <option value="0" selected="selected">No</option>
                                     </select>
                                   </p>
                                   
                                   <div id="you_tube1" style="display:none;">
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
                                        <option value="0" selected="selected" >No</option>
                                     </select>
                                   </p>
                                    <div id="you_tube2" style="display:none;">
                                     <p>
                                        <label>Shipping Amount:</label>
                                        <input id="Shipping" type="text" name="p_shipping" value="" class="required">
                                      </p>
                                    </div>  
                                    </div>
                                    
                                    
                                    
                                    
                <?php
        }
        ?>
                          <p> 
                            <input type="submit" name="submit" value="Update Video"  class="button">
                          </p>
                      </form>    
                </div><!--END CLASS m_profile_right PART -->
            </div><!--END CLASS m_profile PART -->
			</div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->

<?php
include('../_includes/footer.php');
?>
