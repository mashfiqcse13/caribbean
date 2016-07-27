<?php
include('_includes/application-top.php');
//CheckLoginForum();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Chat</title>
        <script type="text/javascript" src="<?php echo SITE_URL; ?>_script/jquery.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                setInterval(function () {
                    //call $.ajax here
                    GetChatUpdates();
                }, 5000); //5 seconds
            });
            function GetChatUpdates() {

                var to_id = $("#from_id").val();
                $.ajax({
                    type: "POST",
                    url: "ajax_chat_update.php",
                    data: {
                        to_id: to_id,
                    },
                    success: function (result) {

                        $("#msg_box").append(result);
                        var messagebox = document.getElementById('msg_box');
                        messagebox.scrollTop = messagebox.scrollHeight;
                    }
                });
            }
        </script>

        <script type="text/javascript">

            function save_chat() {
                var msg = $("#msg").val();
                var from_id = $("#from_id").val();
                var to_id = $("#to_id").val();

                $.ajax({
                    type: "POST",
                    url: "ajax_chat.php",
                    data: {
                        msg: msg,
                        from_id: from_id,
                        to_id: to_id,
                    },
                    success: function (result) {

                        $("#msg_box").append(result);
                        $("#msg").val("");
                        var messagebox = document.getElementById('msg_box');
                        messagebox.scrollTop = messagebox.scrollHeight;
                    }
                });
                return false;
            }
        </script>

        <style type="text/css">

            body {background-color:#CCCCCC;  }

            .button{
                background:#807f7f;
                border:none;
                padding:5px 7px 5px 7px;
                font-family:Arial, Helvetica, sans-serif;
                font-size:14px;
                color:#FFFFFF;
                margin:0px 0px 0px 0px;

                /*margin-left:140px;*/
            }
            input[type=text]{
                padding:5px;
                border:thin solid #999999;
                background:#FFFFFF;
                width:250px;
            }
            label{ display:inline-block; margin-right:5px; }

            span{font-size:16px;
                 font-family:Verdana, Arial, Helvetica, sans-serif;
            }
            span img{
                width:30px; 
                height:30px;
            }
            .chat_content{
                width:360px; 
                min-height:300px; 
                /*border:2px solid #FF6600;*/
            }

            h2{
                font-family:Arial, Helvetica, sans-serif;
                color:#666666;
                border-bottom:4px solid #999999;
            }
            #msg_box{
                width:360px;
                border:3px solid #999999; 
                height:300px; 
                overflow-y: scroll;
                background-color:#FFFFFF;
            }

            .chat_content_container{float:left;padding:0px; margin:0px;margin-top:-10px;clear:both;}

            #Layer1 {
                position:absolute;
                width:200px;
                height:115px;
                z-index:1;
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
    </head>
    <body >
        <?php
        if (((!isset($_SESSION["talent_id"]) || ($_SESSION["talent_id"] == 0)) && (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == 0)) || ($_SESSION["is_admin"] == "yes")) {
//if((!isset($_SESSION["talent_id"]) || ($_SESSION["talent_id"]==0)) && (!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==0)){
            ?>
            <p class="err">Please Login First</p>
            <?php
        } else {
            ?>


            <div class="chat_content"><!--DIV CLASS chat_content-->

                <h2>Chat With
                    <span>
                        <?php
                        $query = mysqli_query($link," SELECT * FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                        $data = mysqli_fetch_assoc($query);
                        ?>
                        <?php $image = "_uploads/user_photo/" . $data['id'] . ".jpg"; ?> 
                        <img src="<?php echo $image; ?> " width="40" height="40" style="vertical-align:top;"/> <?php echo $data['first_name']; ?> <?php echo $data['last_name']; ?>
                    </span>

                </h2>

                <div id="msg_box">


                    <?php
                    if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
                        $identity = $_SESSION['talent_id'];
                    } elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
                        $identity = $_SESSION['user_id'];
                    }



                    $query = mysqli_query($link," SELECT * FROM tbl_users WHERE username='" . $_GET['username'] . "'");

                    $record = mysqli_fetch_assoc($query);

                    $query1 = mysqli_query($link,"SELECT tbl_users.id AS t_u_id,tbl_users.username,tbl_chat.* FROM tbl_users LEFT JOIN tbl_chat ON

															from_id='" . $identity . "' OR to_id='" . $record["id"] . "' AND to_id='" . $identity . "' OR 

															from_id='" . $record["id"] . "' WHERE tbl_users.id='" . $identity . "' AND tbl_chat.view_status='0'");

                    mysqli_query($link,"UPDATE tbl_chat SET view_status = 1  WHERE to_id=" . $identity . " AND from_id=" . $record["id"]);
                    ?>

                    <?php
                    while ($row1 = mysqli_fetch_assoc($query1)) {
                        ?>

                        <?php
                        $str = "SELECT username FROM tbl_users WHERE id='" . $row1['from_id'] . "'";
                        //echo "SELECT username FROM tbl_users WHERE id='".$row1['from_id']."'" ;

                        $friend_query = mysqli_query($link,$str);
                        $friend_data = mysqli_fetch_assoc($friend_query);

                        $user = $friend_data['username'];
                        ?>

                        <?php /* ?> <?php $image ="_uploads/user_photo/".$row1['from_id'].".jpg";?>

                          <img src="<?php echo $image; ?> " width="25" height="25"/><?php */ ?>



                        <label style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:14px; color:#FF9900; font-weight:bold;"><?php echo $user; ?></label>:&nbsp;&nbsp;<label style="color:#999999;font-family:Verdana, Arial, Helvetica, sans-serif;font-weight:bold; font-size:14px; text-align:justify;"><?php echo $row1['msg']; ?></label><br />

                        <?php
                    }
                    ?>

                </div>

                <div class="chat_content_container"><!--DIV CLASS chat_content_container-->

                    <input type="hidden" id="from_id"  name="from_id"  value="<?php echo $identity; ?>"  />

                    <?php
                    $query = mysqli_query($link," SELECT * FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                    ?>
                    <?php
                    while ($row = mysqli_fetch_assoc($query)) {
                        ?>



                        <input type="hidden" name="to_id" id="to_id" value="<?php echo $row['id']; ?>" /><br />

                        <?php
                    }
                    ?>

                    <label><input type="text" name="msg" id="msg" onchange="save_chat();" /></label><label><input type="button" name="submit" value="Send" class="button" onchange="save_chat();"/></label>




                </div> <!--END CLASS chat_content_container-->

            </div><!--END DIV CLASS chat_content-->
            <?php
        }
        ?>					
    </body>
</html>

