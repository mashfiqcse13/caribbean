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

$sql = mysqli_query($link,"SELECT pr.id AS pr_id, pr.ref_id, pr.product_name, pr.product_details, pr.product_price, pr.shipping, pr.p_shipping, pb.id AS pb_book_id, pb.uid, pb.name, pb.author, pb.book_details FROM tbl_products AS pr LEFT OUTER JOIN tbl_profile_books AS pb ON pb.id=pr.ref_id WHERE pb.id=" . $_GET['id'] . " AND pb.uid=" . $_SESSION['talent_id'] . " AND pr.content_type='4' ");

if (mysqli_num_rows($sql) > 0) {
    $result = mysqli_fetch_assoc($sql);
    $prd_id = $result['pr_id'];
    $product_price = $result['product_price'];
} else {
    $sql1 = mysqli_query($link,"SELECT pb.id AS pb_book_id, pb.uid, pb.name, pb.author, pb.book_details, pb.status FROM  tbl_profile_books AS pb WHERE id=" . $_GET['id'] . " AND uid=" . $_SESSION['talent_id'] . " order by id ");
    $result = mysqli_fetch_assoc($sql1);
    $prd_id = 0;
    $product_price = "0.00";
}
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'update')) {


    extract($_POST);


    if ($video_type == 1) {

        if ($prd_id != 0) {

            $prod_photo = "../_uploads/profile_product/" . $prd_id . ".jpg";
            $prod_photo_thumb = "../_uploads/profile_product/thumb/" . $prd_id . ".jpg";

            if (file_exists($prod_photo)) {
                unlink($prod_photo_thumb);
                unlink($prod_photo);
            }
            $sql = "DELETE " .
                    "FROM tbl_products " .
                    "WHERE 1=1 AND id=" . $prd_id . " ";
            $result = mysqli_query($link,$sql) or die(mysqli_error($link));
        }

        $data = array(
            "uid" => $_SESSION["talent_id"],
            "name" => mysqli_real_escape_string( $link ,trim($name)),
            "author" => mysqli_real_escape_string( $link ,trim($author)),
            "book_details" => mysqli_real_escape_string( $link ,trim($book_details)),
            "status" => '1'
        );
        $table = "tbl_profile_books";
        $parameters = "id=" . $mid . " ";
        updateData($data, $table, $parameters);
    } else {


        $data = array(
            "uid" => $_SESSION["talent_id"],
            "name" => mysqli_real_escape_string( $link ,trim($name)),
            "author" => mysqli_real_escape_string( $link ,trim($author)),
            "book_details" => mysqli_real_escape_string( $link ,trim($book_details)),
            "status" => '1'
        );
        $table = "tbl_profile_books";
        $parameters = "id=" . $mid . " ";
        updateData($data, $table, $parameters);


        $sql = "SELECT * " .
                "FROM tbl_products " .
                "WHERE 1=1 AND id=" . $prd_id . " AND ref_id=" . $mid . " ";
        $result = mysqli_query($link,$sql) or die(mysqli_error($link));

        if (mysqli_num_rows($result) > 0) {

            if ($shipping == 1) {
                $data1 = array(
                    "uid" => $_SESSION['talent_id'],
                    "ref_id" => $mid,
                    "product_name" => mysqli_real_escape_string( $link ,trim($name)),
                    "product_details" => mysqli_real_escape_string( $link ,trim($book_details)),
                    "product_price" => mysqli_real_escape_string( $link ,trim($product_price)),
                    "shipping" => mysqli_real_escape_string( $link ,trim($shipping)),
                    "p_shipping" => mysqli_real_escape_string( $link ,trim($p_shipping)),
                    "content_type" => '4',
                    "status" => '1'
                );
            } else {
                $data1 = array(
                    "uid" => $_SESSION['talent_id'],
                    "ref_id" => $mid,
                    "product_name" => mysqli_real_escape_string( $link ,trim($name)),
                    "product_details" => mysqli_real_escape_string( $link ,trim($book_details)),
                    "product_price" => mysqli_real_escape_string( $link ,trim($product_price)),
                    "shipping" => 0,
                    "p_shipping" => "0.00",
                    "content_type" => '4',
                    "status" => '1'
                );
            }
            $table = "tbl_products";

            $parameters = "id=" . $prd_id . " AND ref_id=" . $mid . " ";

            $prof_photo = "../_uploads/profile_book_photo/" . $mid . ".jpg";
            $prof_photo_thumb = "../_uploads/profile_book_photo/thumb/" . $mid . ".jpg";

            $prod_photo = "../_uploads/profile_product/" . $prd_id . ".jpg";
            $prod_photo_thumb = "../_uploads/profile_product/thumb/" . $prd_id . ".jpg";

            if (file_exists($prof_photo)) {
                copy($prof_photo, $prod_photo);
                copy($prof_photo_thumb, $prod_photo_thumb);
            }

            updateData($data1, $table, $parameters);
        } else {
            $data1 = array(
                "uid" => $_SESSION['talent_id'],
                "ref_id" => $mid,
                "product_name" => mysqli_real_escape_string( $link ,trim($name)),
                "product_details" => mysqli_real_escape_string( $link ,trim($book_details)),
                "product_price" => mysqli_real_escape_string( $link ,trim($product_price)),
                "shipping" => mysqli_real_escape_string( $link ,trim($shipping)),
                "p_shipping" => mysqli_real_escape_string( $link ,trim($p_shipping)),
                "content_type" => '4',
                "status" => '1'
            );

            $table1 = "tbl_products";
            insertData($data1, $table1);
            $prod_id = mysqli_insert_id($link);

            $prof_photo = "../_uploads/profile_book_photo/" . $mid . ".jpg";
            $prof_photo_thumb = "../_uploads/profile_book_photo/thumb/" . $mid . ".jpg";

            $prod_photo = "../_uploads/profile_product/" . $prod_id . ".jpg";
            $prod_photo_thumb = "../_uploads/profile_product/thumb/" . $prod_id . ".jpg";

            if (file_exists($prof_photo)) {
                copy($prof_photo, $prod_photo);
                copy($prof_photo_thumb, $prod_photo_thumb);
            }
        }
    }

    if ((isset($_FILES['img_path']['name'])) && ($_FILES['img_path']['name'] != '')) {

        $filename = $_FILES['img_path']['name'];
        $file_ext = ".".pathinfo($filename,PATHINFO_EXTENSION);

        //$file_ext = strrchr($filename, '.');
        $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
        if (!in_array($file_ext, $whitelist)) {
            $MSG = 'Not allowed extension,please upload ".jpg",".jpeg",".gif",".png" only!';
        } else {
            $upload_file = $_FILES['img_path']['tmp_name'];
            $destination = "../_temp/" . $mid . ".jpg";
            upload_my_file($upload_file, $destination);


            $source = "../_temp/" . $mid . '.jpg';
            $dest = "../_uploads/profile_book_photo/thumb/" . $mid . ".jpg";
            CreateFixedSizedImage($source, $dest, $width = 150, $height = 150);

            $source = "../_temp/" . $mid . '.jpg';
            $destination = "../_uploads/profile_book_photo/" . $mid . ".jpg";
            $size = PROFILE_PHOTO_BIG;
            create_thumb($source, $size, $destination);

            if (isset($prod_id)) {
                $prof_photo = "../_uploads/profile_book_photo/" . $mid . ".jpg";
                $prof_photo_thumb = "../_uploads/profile_book_photo/thumb/" . $mid . ".jpg";

                $prod_photo = "../_uploads/profile_product/" . $prod_id . ".jpg";
                $prod_photo_thumb = "../_uploads/profile_product/thumb/" . $prod_id . ".jpg";

                if (file_exists($prof_photo)) {
                    copy($prof_photo, $prod_photo);
                    copy($prof_photo_thumb, $prod_photo_thumb);
                }
            } else {
                $prof_photo = "../_uploads/profile_book_photo/" . $mid . ".jpg";
                $prof_photo_thumb = "../_uploads/profile_book_photo/thumb/" . $mid . ".jpg";

                $prod_photo = "../_uploads/profile_product/" . $prd_id . ".jpg";
                $prod_photo_thumb = "../_uploads/profile_product/thumb/" . $prd_id . ".jpg";

                if (file_exists($prof_photo)) {
                    copy($prof_photo, $prod_photo);
                    copy($prof_photo_thumb, $prod_photo_thumb);
                }
            }

            unlink("../_temp/" . $mid . '.jpg');
        }
    }


    header("Location:manage_book.php?op=u");
}
?>
<?php include('../_includes/header.php'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#img_update').validate({
            rules: {
                img_path: {
                    /*required: true,*/
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
        if (document.img_update.video_type.value == 0) {

            if (document.img_update.pdetails.value == 0) {

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
        <?php
        if (isset($MSG) AND ( $MSG <> "")) {
            echo "<p class='err'>" . $MSG . "</p>";
        }
        ?>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART --><?php //print_r($result); ?>
            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->

                <form  name="img_update" action="update_book.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" id="img_update" onsubmit="return Validate_info()">
                    <input type="hidden" name="mid" value="<?php echo $result['pb_book_id']; ?>" />
                    <input type="hidden" name="pdetails" value="<?php echo $pdetails; ?>" />
                    <p><label for="photo_title">Nam:</label>
                        <input type="text" name="name" value="<?php echo $result['name'] ?>" class="required" maxlength="100"/> 
                    </p>
                    <p><label for="author">Author:</label>
                        <input type="text" name="author" value="<?php echo $result['author'] ?>" class="required" /> 
                    </p>
                    <p><label style="vertical-align:top;" for="photo_details">Book Details:</label>
                        <textarea name="book_details" id="details" class="required" style="height:100px; width:300px;" maxlength="255"><?php echo $result['book_details']; ?></textarea>
                    </p>
                    <!--///////CHECK THE IMAGE IS ALREADY EXITS OR NOT////////-->	
                    <?php
                    $img_path = "../_uploads/profile_book_photo/thumb/" . $result['pb_book_id'] . ".jpg";
                    if (file_exists($img_path)) {
                        ?>

                        <p style="margin-left:140px;"><a href="../_uploads/profile_book_photo/<?php echo $result["pb_book_id"]; ?>.jpg" class="fancybox"><img src="<?php echo $img_path; ?>" alt="Image"/></a></p>
                        <?php
                    }
                    ?>

                    <p>
                        <label>Select Photo:</label>
                        <input type="file" name="img_path" />
                    </p>
                    <?php
                    if (((isset($result['product_price'])) && ($result['product_price'] != "0.00")) && ((isset($result['p_shipping'])) && ($result['p_shipping'] != "0.00"))) {
                        ?>
                        <p>
                            <label style="width:170px;">
                                Is This Photo Saleable : 
                            </label>
                            <?php if ((isset($result['product_price'])) && ($result['product_price'] != '')) { ?>
                                <select name="video_type" onchange="clickme(this.value);">
                                    <option value="1">No</option>
                                    <option value="0" selected="selected">Yes</option>
                                </select>
                            <?php } else { ?>
                                <select name="video_type" onchange="clickme(this.value);">
                                    <option value="1" selected="selected">No</option>
                                    <option value="0">Yes</option>
                                </select>
                            <?php } ?>
                        </p>
                        <div id="you_tube" style="display:block;">
                            <p>
                                <label>Price:</label>
                                <input id="price" type="text" name="product_price" value="<?php
                                if ((isset($result['product_price'])) && ($result['product_price'] != '')) {
                                    echo $result['product_price'];
                                }
                                ?>" class="required">
                            </p>


                            <p>
                                <label style="width:170px;">
                                    Shipping Charge: 
                                </label>
    <?php if ((isset($result['p_shipping'])) && ($result['p_shipping'] != '')) { ?>
                                    <select name="shipping" onchange="return clickme_ship(this.value);">
                                        <option value="1" selected="selected">Yes</option>
                                        <option value="0">No</option>
                                    </select>
    <?php } else { ?>
                                    <select name="shipping" onchange="return clickme_ship(this.value);">
                                        <option value="1">Yes</option>
                                        <option value="0" selected="selected">No</option>
                                    </select>
    <?php } ?>
                            </p>
                            <div id="you_tube1" style="display:block;">
                                <p>
                                    <label>Shipping Amount:</label>
                                    <input id="Shipping" type="text" name="p_shipping" value="<?php
    if ((isset($result['p_shipping'])) && ($result['p_shipping'] != '')) {
        echo $result['p_shipping'];
    }
    ?>" class="required">
                                </p>
                            </div>
                        </div>
    <?php
} elseif ((((isset($result['product_price'])) && ($result['product_price'] != "0.00")) && ((isset($result['p_shipping'])) && ($result['p_shipping'] == "0.00")))) {
    ?>
                        <p>
                            <label style="width:170px;">
                                Is This Photo Saleable : 
                            </label>
                            <select name="video_type" onchange="clickme(this.value);">
                                <option value="1">No</option>
                                <option value="0" selected="selected">Yes</option>
                            </select>
                        </p>
                        <div id="you_tube" style="display:block;">
                            <p>
                                <label>Price:</label>
                                <input id="price" type="text" name="product_price" value="<?php
    if ((isset($result['product_price'])) && ($result['product_price'] != '')) {
        echo $result['product_price'];
    }
    ?>" class="required">
                            </p>


                            <p>
                                <label style="width:170px;">
                                    Shipping Charge: 
                                </label>
                                <select name="shipping" onchange="return clickme_ship(this.value);">
                                    <option value="1">Yes</option>
                                    <option value="0" selected="selected">No</option>
                                </select>
                            </p>
                            <div id="you_tube1" style="display:none;">
                                <p>
                                    <label>Shipping Amount:</label>
                                    <input id="Shipping" type="text" name="p_shipping" value="<?php
                        if ((isset($result['p_shipping'])) && ($result['p_shipping'] != '')) {
                            echo $result['p_shipping'];
                        }
                        ?>" class="required">
                                </p>
                            </div>
                        </div>
    <?php
} else {
    ?>
                        <p>
                            <label style="width:170px;">
                                Is This Photo Saleable : 
                            </label>
                            <select name="video_type" onchange="clickme(this.value);">
                                <option value="1" selected="selected">No</option>
                                <option value="0">Yes</option>
                            </select>
                        </p>
                        <div id="you_tube" style="display:none;">
                            <p>
                                <label>Price:</label>
                                <input id="price" type="text" name="product_price" value="<?php
    if ((isset($result['product_price'])) && ($result['product_price'] != '')) {
        echo $result['product_price'];
    }
    ?>" class="required">
                            </p>


                            <p>
                                <label style="width:170px;">
                                    Shipping Charge: 
                                </label>
                                <select name="shipping" onchange="return clickme_ship(this.value);">
                                    <option value="1">Yes</option>
                                    <option value="0" selected="selected">No</option>
                                </select>
                            </p>
                            <div id="you_tube1" style="display:none;">
                                <p>
                                    <label>Shipping Amount:</label>
                                    <input id="Shipping" type="text" name="p_shipping" value="<?php
    if ((isset($result['p_shipping'])) && ($result['p_shipping'] != '')) {
        echo $result['p_shipping'];
    }
    ?>" class="required">
                                </p>
                            </div>
                        </div>
    <?php
}
?>
                    <input type="submit" name="submit" value="update" class="button" />
                </form>

            </div><!--END ID m_profile_right PART -->
        </div><!--END ID m_profile PART -->
    </div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->
<?php include('../_includes/footer.php'); ?>



