<?php
include('_includes/application-top.php');

/* USER COMMENT SUBMIT CHECK */
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'submit')) {
    $data = array(
        "profile_id" => $_POST['profile_id'],
        "commenter_id" => $_POST['talent_id'],
        "comment_text" => mysql_real_escape_string(trim($_POST['comment_text'])),
        "comment_time" => date('Y-m-d H:i:s')
    );

    insertData($data, "tbl_profile_comments");
}

include('_includes/header.php');
?>
<script type="text/javascript">

    /*$(document).ready(function() {
     
     $('a#audio').fancybox();
     
     });*/

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
</script>
<script type="text/javascript">
    //initialize the 3 popup css class names - create more if needed
    var matchClass = ['popup1'];
    //Set your 3 basic sizes and other options for the class names above - create more if needed
    var popup1 = 'width=380,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=20,top=20';
    //The pop-up function
    function tfpop() {
        var x = 0;
        var popClass;
        //Cycle through the class names
        while (x < matchClass.length) {
            popClass = "'." + matchClass[x] + "'";
            //Attach the clicks to the popup classes
            $(eval(popClass)).click(function () {
                //Get the destination URL and the class popup specs
                var popurl = $(this).attr('href');
                var popupSpecs = $(this).attr('class');
                //Create a "unique" name for the window using a random number
                var popupName = Math.floor(Math.random() * 10000001);
                //Opens the pop-up window according to the specified specs
                newwindow = window.open(popurl, popupName, eval(popupSpecs));
                return false;
            });
            x++;
        }
    }

    //Wait until the page loads to call the function
    $(function () {
        tfpop();
    });
</script>

<!--MUSIC POPUP WINDOW OPEN--->


<script type="text/javascript">
    function popitup(url) {
        newwindow = window.open(url, 'name', 'height=50,width=245');
        if (window.focus) {
            newwindow.focus()
        }
        return false;
    }
</script>
<?php
$result = CheckProfileView($_GET['username']);

$data = getAnyTableWhereData("tbl_users", "AND username='" . $_GET['username'] . "' ");



if ($data['id'] != '') {
    if ((isset($_SESSION["talent_id"])) && ($_SESSION["talent_id"] != 0)) {
        $uid = $_SESSION["talent_id"];
    } elseif ((isset($_SESSION["user_id"])) && ($_SESSION["user_id"] != 0)) {
        $uid = $_SESSION["user_id"];
    } else {
        $_SESSION["talent_id"] = 0;
        $_SESSION["user_id"] = 0;
        $uid = "";
    }
    $query211 = mysql_query("SELECT profile_display_status FROM  tbl_user_profile_settings WHERE uid='" . $data['id'] . "'");
    $ror211 = mysql_fetch_assoc($query211);



    $query111 = mysql_query("SELECT * FROM tbl_users WHERE username='" . $_GET['username'] . "'");
    $RESULT = mysql_fetch_assoc($query111);
    $ror111 = mysql_num_rows($query111);
    //echo $uid;
    //if(($RESULT['id']!=$uid)||(($ror211['profile_display_status']==1)&&($uid=="")) || ($RESULT['id']==$uid)){
    if ((($ror211['profile_display_status'] == 1) && (($uid == ""))) || ($RESULT['id'] == $uid) || ($uid != "")) {
        ?>
        <div class="profile_page_wraper"><!--START DIV CLASS profile_page_wraper	-->
            <div class="profile_page_contnt_heading">
                <span class="name_profile">
                    <?php
                    $name = GetFullName($_GET['username']);
                    echo $name . " " . "is" . ' ' . "currently" . " ";
                    /* ###################GET VALUE FROM tbl_user_online############### */
                    $SQL_ONLI = mysql_query("SELECT id FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                    $SQL_RESULT = mysql_fetch_array($SQL_ONLI);
                    //print_r($SQL_RESULT);
                    $SQL_QUERY = "SELECT * FROM tbl_user_online WHERE uid='" . $SQL_RESULT['id'] . "'";
                    $SQL_RESULT1 = mysql_query($SQL_QUERY);
                    $SQL_fetch = mysql_fetch_array($SQL_RESULT1);
                    //print_r($SQL_fetch);
                    $SQL_ROWS = mysql_num_rows($SQL_RESULT1);

                    if ($SQL_ROWS == '') {
                        ?>
                        <span style="color:#CCCCCC; font-size:18px; font-weight:bold;"><?php echo "OFFLINE"; ?></span>
                        <?php
                    } else {
                        ?>
                        <span style="color:#009900; font-size:18px; font-weight:bold;"><?php echo "ONLINE"; ?></span>
                        <?php
                        if ((isset($_SESSION["talent_id"])) && ($_SESSION["talent_id"] != 0)) {
                            $uid = $_SESSION["talent_id"];
                        } elseif ((isset($_SESSION["user_id"])) && ($_SESSION["user_id"] != 0)) {
                            $uid = $_SESSION["user_id"];
                        } else {
                            $_SESSION["talent_id"] = 0;
                            $_SESSION["user_id"] = 0;
                            $uid = "";
                        }

                        if ($SQL_RESULT['id'] != $uid) {
                            if ((!isset($_SESSION["talent_id"]) || ($_SESSION["talent_id"] == 0)) && (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == 0)) {
                                
                            } else {
                                ?>
                                <a href="chat.php?username=<?php echo $_GET['username']; ?>" style="float:right;color:#FFFFFF;" class="popup1">Chat now</a>
                                <?php
                            }
                        }
                    }
                    ?>
                </span>
            </div>
            <div class="profile_page_contnt"><!--START DIV CLASS profile_page_contnt-->
                <?php
                if (isset($_GET['op'])) {
                    ?>
                    <p class="msg">
                        <?php
                        if (isset($_GET['op']) AND ( $_GET['op'] == "suc")) {
                            $query27 = mysql_query("SELECT * FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                            $row27 = mysql_fetch_assoc($query27);

                            echo "Congratulations,Now you are connected to " . $row27['first_name'] . " " . $row27['last_name'] . "";
                        }
                        ?>
                    </p>
                    <?php
                }
                if (isset($_GET['op'])) {
                    ?>
                    <p class="err">
                        <?php
                        if (isset($_GET['op']) AND ( $_GET['op'] == "self")) {
                            echo "You Can Not send Request Yourself.";
                        }
                        if (isset($_GET['op']) AND ( $_GET['op'] == "ex")) {
                            $query26 = mysql_query("SELECT * FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                            $row26 = mysql_fetch_assoc($query26);
                            echo "You are already connected to " . $row26['first_name'] . " " . $row26['last_name'] . "";
                        }
                        ?>
                    </p>
                    <?php
                }
                //include('all_module.php');
                ?>









                <div style="clear:both"></div> 
            </div>
        </div>
        <?php
    } else {
        echo "<p class='err'>WANT TO VIEW THIS PROFILE ? THEN LOGIN FIRST .</p>";
    }
} else {
    echo "<p class='err' align='center'><strong>User Not Found</strong></p>";
}
include('_includes/footer.php');
?>
