<?php
include('../_includes/application-top.php');
if (!empty($_REQUEST['lid'])) {
    $lid = $_REQUEST['lid'];
    $_SESSION['user_login'] = 1;
    $_SESSION['user_id'] = $lid;

    $data = array(
        "user_id" => $_SESSION['user_id'],
        "biography" => " ",
        "profile_display_status" => "1"
    );
    $table = "tbl_user_details";
    insertData($data, $table);

    /* Added Activity Below */
    SaveActivity(14, mysqli_real_escape_string($link, trim($_POST['username'])), '', $l_id);
    //////////////////////////////////////////////////
}
ChecknontalentLogin();
include('../_includes/header.php');
?>
<div class="content"><!--START CLASS contant PART -->
    <h1>Member Area</h1>		
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START ID m_profile PART -->
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "up")) {
                echo "<p class='msg'>Image Uploaded Successfuly.</p>";
            }
            if (isset($_GET['op']) AND ( $_GET['op'] == "u")) {
                echo "<p class='msg'>Record Updated Sucessfully.</p>";
            }


            include('./profile_template/sidebar_right.php');
            ?>

            <!--END CLASS m_profile_left PART -->

            <div id="m_profile_right_1"><!--START ID m_profile_right PART -->

                <!--NONTALENTS USER PROFILE UPDATE START HEAR-->
                <?php
                $result = mysqli_query($link, "SELECT * FROM tbl_users WHERE id='" . $_SESSION['user_id'] . "'");
                if (!$result) {
                    die("database query faild:" . mysqli_error($link));
                }
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <p>
                        <label>Name:</label>
                        <?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?>
                    </p>
                    <p>
                        <label>Phone No:</label>
                        <?php echo $row['phone_no']; ?>
                    </p>
                    <p>
                        <label>Email:</label>				
                        <?php echo $row['email']; ?>
                    </p>
                    <p>
                        <label>City:</label>
                        <?php echo $row['city']; ?>
                    </p>
                    <p>
                        <label>Country:</label>
                        <?php echo $countries_array[$row['country']]; ?>               
                    </p>
                    <p>
                        <label>Sex:</label>
                        <?php
                        if ($row['sex'] == 1) {
                            echo "Male";
                        } else {
                            echo "Female";
                        }
                        ?>
                    </p>									
                    <?php
                }
                ?>
                <!--NONTALENTS USER PROFILE UPDATE END HEAR-->
                <div>
                    <iframe width="420" height="315" src="//www.youtube.com/embed/n5AFIangQ0w" frameborder="0" allowfullscreen></iframe>
                </div>

            </div><!--END ID m_profile_right PART -->

        </div><!--END ID m_profile PART -->
    </div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->

<?php
include('../_includes/footer.php');
?>

