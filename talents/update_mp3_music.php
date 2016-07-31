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


$sql = mysqli_query($link,"SELECT p.id AS PID, p.ref_id AS REFID, p.product_price,p.id AS produc_id, m.id AS MID, m.music_title, m.music_details, m.status FROM tbl_products AS p LEFT OUTER JOIN tbl_profile_music AS m ON m.id=p.ref_id WHERE m.id=" . $_GET['id'] . " AND user_id=" . $_SESSION['talent_id'] . " AND p.content_type='1' ");

if (mysqli_num_rows($sql) > 0) {
    $result = mysqli_fetch_assoc($sql);
    $prd_id = $result['PID'];
    $product_price = $result['product_price'];
} else {
    $sql1 = mysqli_query($link,"SELECT m.id AS MID, m.music_title, m.music_details, m.status FROM  tbl_profile_music AS m WHERE id=" . $_GET['id'] . " AND user_id=" . $_SESSION['talent_id'] . " order by id ");
    $result = mysqli_fetch_assoc($sql1);
    $prd_id = 0;
    $product_price = "0.00";
}

if ((isset($_POST['submit']))AND ( $_POST['submit'] == 'Update Music')) {
    extract($_POST);
    if ($video_sale == 1) {

        if ($product_price != "") {

            $sql = "DELETE " .
                    "FROM tbl_products " .
                    "WHERE 1=1 AND id=" . $prd_id . " ";
            $result = mysqli_query($link,$sql) or die(mysqli_error($link));

            $data = array(
                "music_title" => mysqli_real_escape_string( $link ,trim($music_titl)),
                "music_details" => mysqli_real_escape_string( $link ,trim($music_details)),
                "status" => $_POST['status'],
            );
            $table = "tbl_profile_music";
            $parameters = "id=" . $mid . " ";
            updateData($data, $table, $parameters);
        }
    } else {

        if ($prd_id != 0) {

            $data = array(
                "music_title" => mysqli_real_escape_string( $link ,trim($music_titl)),
                "music_details" => mysqli_real_escape_string( $link ,trim($music_details)),
                "status" => $_POST['status'],
            );
            $table = "tbl_profile_music";
            $parameters = "id=" . $mid . " ";
            updateData($data, $table, $parameters);

            $data1 = array(
                "uid" => $_SESSION['talent_id'],
                "ref_id" => $mid,
                "product_name" => mysqli_real_escape_string( $link ,trim($music_titl)),
                "product_details" => mysqli_real_escape_string( $link ,trim($music_details)),
                "product_price" => mysqli_real_escape_string( $link ,trim($product_price)),
                "content_type" => '1',
                "status" => '1'
            );
            $table1 = "tbl_products";
            $parameters1 = "id=" . $product_id . " ";
            updateData($data1, $table1, $parameters1);
        } else {

            $data = array(
                "music_title" => mysqli_real_escape_string( $link ,trim($music_titl)),
                "music_details" => mysqli_real_escape_string( $link ,trim($music_details)),
                "status" => $_POST['status'],
            );
            $table = "tbl_profile_music";
            $parameters = "id=" . $mid . " ";
            updateData($data, $table, $parameters);

            $data1 = array(
                "uid" => $_SESSION['talent_id'],
                "ref_id" => $mid,
                "product_name" => mysqli_real_escape_string( $link ,trim($music_titl)),
                "product_details" => mysqli_real_escape_string( $link ,trim($music_details)),
                "product_price" => mysqli_real_escape_string( $link ,trim($product_price)),
                "content_type" => '1',
                "status" => '1'
            );
            $table1 = "tbl_products";

            insertData($data1, $table1);
        }
    }

    if ((isset($_FILES['mp3_file']['name'])) && ($_FILES['mp3_file']['name'] != '')) {



        /* move upload photo in temp folder */
        //get the file ext:
        $filename = $_FILES['mp3_file']['name'];
        $file_ext = ".".pathinfo($filename,PATHINFO_EXTENSION);

        //$file_ext = strrchr($filename, '.');
        //check if its allowed or not:
        // $whitelist = array(".mp3"); 
        if ($file_ext <> ".mp3") {
            $MSG = 'Not allowed extension,please upload mp3 only!';
        } else {
            $source_path = $_FILES['mp3_file']['tmp_name'];
            $destination = "../_temp/" . $mid . ".mp3";
            upload_my_file($source_path, $destination);

            /* copy upload file in profile_music folder copy in to temp folder */
            $file = "../_temp/" . $mid . ".mp3";
            $newfile = "../_uploads/profile_music/" . $mid . ".mp3";
            copy($file, $newfile);

            /* delete temp folder file */
            unlink("../_temp/" . $mid . ".mp3");
        }
    }

    header("Location:manage_music.php?op=u");
}

include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#add_mp3_songs').validate({
            rules: {
                mp3_file: {
                    accept: "mp3"
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

    function Validate_info() {
        if (document.update_mp3_songs.video_sale.value == 0) {

            if (document.update_mp3_songs.pdetails.value == 0) {

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
    <h1>Update Music</h1>
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
    <p style="text-align:right"><a href="manage_music.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->
            <div id="m_profile_left"><!--START CLASS m_profile_left PART -->

            </div><!--END CLASS m_profile_left PART -->

            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <form name="update_mp3_songs" action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" id="add_mp3_songs" onsubmit="return Validate_info()" >
                    <input type="hidden" name="mid" value="<?php echo $result['MID']; ?>" />
                    <input type="hidden" name="product_id" value="<?php echo $prd_id; ?>" />
                    <input type="hidden" name="pdetails" value="<?php echo $pdetails; ?>" />
                    <p>
                        <label>
                            Music Title:
                        </label>
                        <input type="text" name="music_titl" value="<?php echo $result['music_title']; ?>" class="required">
                    </p>
                    <p>
                        <label style="vertical-align:top;">
                            Additional Notes:
                        </label>
                        <TEXTAREA NAME="music_details" COLS=40 ROWS=6><?php echo $result['music_details']; ?></TEXTAREA>
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
                            <label>
                              Select a MP3 File:
                            </label>
                          <input type="file" name="mp3_file"  value="">
                       </p>
                       
                        <?php
                            if ($product_price != '0.00') {
                                ?>
                              <p>
                                  <label style="width:170px;">
                                     Is This Music Saleable : 
                                  </label>
                                 <select name="video_sale" onchange="return clickme(this.value);">
                                    <option value="1">No</option>
                                    <option value="0" selected="selected">Yes</option>
                                 </select>
                                 </p>
                                <div id="you_tube" style="display:block;">
                                 <p>
                                    <label>Price: $ </label>
                                    <input id="price" type="text" name="product_price" value="<?php echo $result['product_price']; ?>" class="required">
                                  </p>
                                </div>
                            <?php
                            } else {
                                ?>
                              <p>
                                  <label style="width:170px;">
                                     Is This Music Saleable : 
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
                                    <label>Price: $ </label>
                                    <input id="price" type="text" name="product_price" value="<?php echo $product_price; ?>" class="required">
                                  </p>
                                </div>
                        <?php
                        }
                        ?>
                       
                       <p>
                        <input type="submit" name="submit" value="Update Music" class="button">
                      </p>
                  </form>    
              </div><!--END CLASS m_profile_right PART -->
          </div><!--END CLASS m_profile PART -->
		</div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->
<?php
include('../_includes/footer.php');
?>
