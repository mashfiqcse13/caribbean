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



if ((isset($_POST['submit']))AND ( $_POST['submit'] == 'Add Music')) {


    if ((isset($_POST['product_price'])) && ($_POST['product_price'] != '')) {


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

            $data = array(
                "user_id" => $_SESSION['talent_id'],
                "music_title" => mysqli_real_escape_string( $link ,trim($_POST['music_titl'])),
                "music_details" => mysqli_real_escape_string( $link ,trim($_POST['music_details'])),
                "status" => '1'
            );
            $table = "tbl_profile_music";
            insertData($data, $table);
            $lid = mysqli_insert_id($link);
            /*  Aa fore Sold */
            $data1 = array(
                "uid" => $_SESSION['talent_id'],
                "ref_id" => $lid,
                "product_name" => mysqli_real_escape_string( $link ,trim($_POST['music_titl'])),
                "product_details" => mysqli_real_escape_string( $link ,trim($_POST['music_details'])),
                "product_price" => mysqli_real_escape_string( $link ,trim($_POST['product_price'])),
                "content_type" => '1',
                "status" => '1'
            );
            $table1 = "tbl_products";
            insertData($data1, $table1);

            $source_path = $_FILES['mp3_file']['tmp_name'];
            $destination = "../_temp/" . $lid . ".mp3";
            upload_my_file($source_path, $destination);

            /* copy upload file in profile_music folder copy in to temp folder */
            $file = "../_temp/" . $lid . ".mp3";
            $newfile = "../_uploads/profile_music/" . $lid . ".mp3";
            copy($file, $newfile);

            /* delete temp folder file */
            unlink("../_temp/" . $lid . ".mp3");

            /* Added Activity Below */

            $uname = (GetChatUserName($_SESSION["talent_id"]));
            SaveActivity(3, $uname, mysqli_real_escape_string( $link ,trim($_POST['music_titl'])), $_SESSION["talent_id"]);

            //////////////////////////////////////////////////

            $MSG1 = "Your Music File upload sucessfully.";
        }
    } else {
        /* move upload photo in temp folder */
        //get the file ext:
        $filename = $_FILES['mp3_file']['name'];
        
        $file_ext = ".".pathinfo($filename,PATHINFO_EXTENSION);
//        echo $file_ext;
//        die();
        //$file_ext = strrchr($filename, '.');
        //check if its allowed or not:
        // $whitelist = array(".mp3"); 
        if ($file_ext <> ".mp3") {
            $MSG = 'Not allowed extension,please upload mp3 only!';
        } else {

            $data = array(
                "user_id" => $_SESSION['talent_id'],
                "music_title" => mysqli_real_escape_string( $link ,trim($_POST['music_titl'])),
                "music_details" => mysqli_real_escape_string( $link ,trim($_POST['music_details'])),
                "status" => '1'
            );
            $table = "tbl_profile_music";
            insertData($data, $table);
            $lid = mysqli_insert_id($link);


            $source_path = $_FILES['mp3_file']['tmp_name'];
            
            $destination = "../_temp/" . $lid . ".mp3";
       
            upload_my_file($source_path, $destination);



            /* copy upload file in profile_music folder copy in to temp folder */
            $file = "../_temp/" . $lid . ".mp3";
            $newfile = "../_uploads/profile_music/" . $lid . ".mp3";

            copy($file, $newfile);

            /* delete temp folder file */
            unlink("../_temp/" . $lid . ".mp3");

            /* Added Activity Below */

            $uname = (GetChatUserName($_SESSION["talent_id"]));
            SaveActivity(3, $uname, mysqli_real_escape_string( $link ,trim($_POST['music_titl'])), $_SESSION["talent_id"]);

            //////////////////////////////////////////////////

            $MSG1 = "Your Music File upload sucessfully.";
        }
    }
}


include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#add_mp3_songs').validate({
            rules: {
                mp3_file: {
                    required: true,
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
    <h1>Add Music</h1>
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
    <p style="text-align:right"><a href="manage_music.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->
            <div id="m_profile_left"><!--START CLASS m_profile_left PART -->

            </div><!--END CLASS m_profile_left PART -->

            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <form name="add_mp3_songs" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="add_mp3_songs" onsubmit="return Validate_info()">
                    <p>
                        <label>Music Title:</label><input type="hidden" name="pdetails" value="<?php echo $pdetails; ?>" />
                        <input type="text" name="music_titl" value="" class="required">
                    </p>
                    <p>
                        <label style="vertical-align:top;">Additional Notes:</label>

                        <TEXTAREA NAME="music_details" COLS=40 ROWS=6 ></TEXTAREA></p>
                            <p>
                              <label>
                                 Select a mp3 File:
                              </label>
                              <input type="file" name="mp3_file" class="required">
                            </p>
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
                              <input id="price" type="text" name="product_price" value="" class="required">
                            </p>
                          </div>
                            <p>
                              <input type="submit" name="submit" value="Add Music" class="button">
                            </p>
                      </form>    
                  </div><!--END CLASS m_profile_right PART -->
            </div><!--END CLASS m_profile PART -->
			</div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->

<?php
include('../_includes/footer.php');
?>
