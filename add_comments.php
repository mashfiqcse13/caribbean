<?php
include('_includes/application-top.php');
if ($_POST['ajax'] == 1) {
    if (((!isset($_SESSION["talent_id"]) || ($_SESSION["talent_id"] == 0)) && (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == 0)) || ($_SESSION["is_admin"] == "yes"))
        die('{"Error":1, "Message":"Please login first"}');

    if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
        $uid = $_SESSION['talent_id'];
    } elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
        $uid = $_SESSION['user_id'];
    } else {
        $uid = "";
    }

    $data = array(
        "profile_id" => $_POST['profile_id'],
        "commenter_id" => $uid,
        "comment_text" => mysqli_real_escape_string( $link ,trim($_POST['comment_text'])),
    );
    $table = "tbl_profile_comments";
    insertData($data, $table);
    $uname = (GetChatUserName($_POST['profile_id']));
    $fanename = (GetChatUserName($uid));
    SaveActivity(10, $uname, $fanename, $_POST['profile_id']);
    SaveActivity(9, $fanename, $uname, $uid);
    //////////////////////////////////////////////////
    die('{"Error":0}');
} else {


    if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Submit')) {
        $data = array(
            "profile_id" => $_POST['profile_id'],
            "commenter_id" => $_POST['commenter_id'],
            "comment_text" => mysqli_real_escape_string( $link ,trim($_POST['comment_text'])),
        );
        $table = "tbl_profile_comments";
        insertData($data, $table);

        /* Added Activity Blow */


        if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
            $uid = $_SESSION['talent_id'];
        } elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
            $uid = $_SESSION['user_id'];
        } else {
            $uid = "";
        }


        $uname = (GetChatUserName($_GET['id']));
        $fanename = (GetChatUserName($uid));

        SaveActivity(10, $uname, $fanename, $_GET['id']);

        SaveActivity(9, $fanename, $uname, $uid);

        //////////////////////////////////////////////////

        $MSG = "Record Added Sucessfully";
    }
    ?>
    <style type="text/css">

        .comment_input p label{vertical-align:top;}

        .comment_input textarea{width:400px; height:100px;margin-left:40px;}

        .button{
            background:#807f7f;
            border:none;
            padding:5px 7px 5px 7px;
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
            color:#FFFFFF;
            margin:0px 0px 0px 140px;
        }
        .msg{
            font-size:12px;
            color:#FFF;
            text-align:center;
            background:#339933;
            border:1px solid #FFF;
            padding:0px;
            margin:0px;
            line-height:25px;
        }
        .err{
            font-size:12px;
            color:#FFF;
            text-align:center;
            background:#990000;
            border:1px solid #FFF;
            padding:0px;
            margin:0px;
            line-height:25px;
        }	

    </style>

    <?php
    if (((!isset($_SESSION["talent_id"]) || ($_SESSION["talent_id"] == 0)) && (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == 0)) || ($_SESSION["is_admin"] == "yes")) {
        ?>
        <p class="err">Please Login First</p>
        <?php
    } else {
        ?>  
        <div class="comment_input">
            <?php
            if (isset($MSG) AND ( $MSG != "")) {
                echo "<p class='msg'>" . $MSG . "</p>";
            }
            /* if(isset($MSG) AND ($MSG != ""))
              {
              echo  $MSG;
              } */
            ?>
            <?php
            $query = mysqli_query($link,"SELECT * FROM tbl_users WHERE id='" . $_GET['id'] . "'");
            $data = mysqli_fetch_array($query);
            ?>
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="comment">											
                <p><label for="comment_text">Add Comments:</label>
                    <textarea name="comment_text" id="comment_text" class="required"></textarea>					
                </p>																							
                <input type="hidden" id="profile_id" name="profile_id" value="<?php echo $data['id']; ?>"/>


                <?php
                if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
                    $uid = $_SESSION['talent_id'];
                } elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
                    $uid = $_SESSION['user_id'];
                } else {
                    $uid = "";
                }
                ?>


                <input type="hidden" id="commenter_id"  name="commenter_id"  value="<?php echo $uid; ?>"  />
                <input type="submit" name="submit" value="Submit" class="button" />
            </form>	

        </div>

        <?php
    }
}
//include('_includes/footer.php');
?>
