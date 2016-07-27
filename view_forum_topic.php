<?php
include('_includes/application-top.php');
CheckLoginALL();
//CheckLoginForum();
//print_r($_SESSION);
if (isset($_GET['view'])) {
    $view_cnt = $_GET['view'];
    $sql_view_insert = "Update tbl_forum_topics set view_count ='" . $view_cnt . "' where id='" . $_GET['id'] . "'";
    mysqli_query($link,$sql_view_insert);
}
//DATABASE QUERY
//$query="SELECT tbl_forum_topics.id AS forum_id,tbl_forum_topics.*, tbl_users.* FROM tbl_forum_topics 
//LEFT JOIN  tbl_users ON tbl_forum_topics.uid=tbl_users.id WHERE tbl_forum_topics.id='".$_GET['id']."'";die;
$sql = mysqli_query($link,"SELECT tbl_forum_topics.id AS forum_id,tbl_forum_topics.*, tbl_users.* FROM tbl_forum_topics 
				 LEFT JOIN  tbl_users ON tbl_forum_topics.uid=tbl_users.id WHERE tbl_forum_topics.id='" . $_GET['id'] . "'");
$data = mysqli_fetch_assoc($sql);
// print_r($data);
//for reply query:
$str = "SELECT tbl_forum_reply.*, tbl_forum_reply.uid as reply_uid,tbl_forum_reply.id as reply_id  , tbl_users.* FROM tbl_forum_reply 
				 LEFT JOIN  tbl_users ON tbl_forum_reply.uid=tbl_users.id WHERE tbl_forum_reply.forum_id='" . $_GET['id'] . "' order by tbl_forum_reply.id desc";
// echo $str;
$sql1 = mysqli_query($link,$str);
//$ert=mysqli_fetch_assoc($sql1);
// print_r($ert);
include('_includes/header.php');
?>
<script type="text/javascript">
    function ConfrimMessage_Delete(Url) //confarming property delete
    {
        if (confirm("Are you sure you want to delete this Record?"))
        {
            /*self.navigate(Url);*/ //redirecting to the desired page
            window.location = "" + Url;
        }
    }

    function ConfrimREPLY_Delete(Url) //confarming property delete
    {
        if (confirm("Are you sure you want to delete this Record?"))
        {
            /*self.navigate(Url);*/ //redirecting to the desired page
            window.location = "" + Url;
        }
    }

    function back()
    {
        window.history.back();
    }
</script>
<div class="content">
    <!--<h1>Forum</h1>-->
    <h1><?php echo $data['forum_topic']; ?></h1>
    <?php
    if (isset($_GET['op'])) {
        ?>
        <p class="msg">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "u")) {
                echo "Your Topic Update Sucessfully.";
            }
            ?>
        </p>
        <p class="err">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "del")) {
                echo "Your Reply Deleted Sucessfully.";
            }
            ?>
        </p>
    <?php } ?>
    <?php
    $page_url = $_SERVER['HTTP_REFERER'];

    if (isset($_GET['view'])) {
        $_SESSION['SET_PATH'] = '';
        $_SESSION['SET_PATH_ID'] = 1;
    } elseif ($page_url == SITE_URL) {
        $_SESSION['SET_PATH'] = SITE_URL;
    } else {
        //
    }
    ?>

    <?php
    if ($_SESSION['SET_PATH'] == SITE_URL) {
        ?>
        <p style="text-align:right"><a href="<?php echo SITE_URL; ?>" class="button" style="float:left; margin:-5px 5px 5px 0px;" onclick="return back();">Back</a></p><br /><br />
        <?php
    } elseif ($_SESSION['SET_PATH_ID'] == 1) {
        ?>
        <p style="text-align:right"><a href="<?php echo SITE_URL . "forum.php"; ?>" class="button" style="float:left; margin:-5px 5px 5px 0px;" onclick="return back();">Back</a></p><br /><br />
        <?php
    } else {
        ?>
        <p style="text-align:right"><a href="<?php echo SITE_URL . "forum.php"; ?>" class="button" style="float:left; margin:-5px 5px 5px 0px;" onclick="return back();">Back</a></p><br /><br />
        <?php
    }
    ?>
    <table cellpadding="5" cellspacing="0" class="Tabforumtopic" width="70%" >
        <tbody>
            <tr>
                <td>
                    <div class="photo_name">
                        <p><?php echo date('F jS, Y h:i:s', strtotime($data["post_date"])); ?></p>
                        <?php /* ?> <img src="_uploads/user_photo/<?php echo $data["uid"] ?>.jpg"/><?php */ ?>
                        <img style="margin:10px 0px 0px 15px;" src="_images/star.png"/>
                    </div>
                    <div class="introduse">
                        <p style="margin-top:-10px;">
                            <?php if ($data['uid'] == "0") { ?>
                                <a href="javascript:void(0)"><?php echo "Admin"; ?></a></p>
                            <p><label>Location: </label> United States
                            <?php } else { ?>
                                <a href="profile-details.php?username=<?php echo $data['username']; ?>"><?php echo $data['username']; ?></a></p>
                            <p><label>Location: </label> <?php echo $data['city']; ?>
                            <?php } ?>
                            <!-- <?php /*                if(isset($_SESSION['talent_id'])AND($_SESSION['talent_id']==$data['id'])){
                             */ ?>
                              , <?php /* echo $countries_array1[$data['country']]; */ ?></p>
                              
                            <?php /* 								 }else{
                             */ ?>
                              , <?php /* echo $countries_array[$data['country']]; */ ?></p>
                             
                            --><?php
                            /* 	 } */
                            ?>
                            <?php
                            if ((isset($_SESSION['talent_id'])AND ( $_SESSION['talent_id'] == $data['id'])) || (isset($_SESSION['cms_login']) && ($_SESSION['cms_login'] != 0)) || (isset($_SESSION['user_id'])AND ( $_SESSION['user_id'] == $data['id']))) {
                                ?>
                            <p>
                                <a href="edit-forum-topic.php?t_id=<?php echo $_GET['id']; ?>">
                                    <img src="_images/Edit.png" title="Update Topic">
                                </a>
                                <a href="<?php echo "javascript:ConfrimMessage_Delete('delete-forum-topic.php?id=" . $_GET['id'] . "')"; ?>">
                                    <img src="_images/del.png" title="Delete Topic">
                                </a>
                            </p>
                            <?php
                        }
                        ?>

                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="text-align:right; margin-right:10px;">
                        <a href="add-topic-reply.php?id=<?php echo $data['forum_id']; ?>"class="button">Reply</a>
                    </p>
                    <div style="margin-left:10px;">
                        <?php echo stripcslashes($data['forum_details']); ?>
                    </div>
                </td>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($sql1)) {
                $data121 = getAnyTableWhereData("tbl_forum_topics", "AND id='" . $_GET['id'] . "' ");
                ?>
                <tr>
                    <td>
                        <div class="total_reply">
                            <div class="reply_photo_name" >
                                <p><?php //echo date('F jS, Y h:i a', strtotime($row["post_time"]));  ?></p>
                                <img style="float:left; margin:15px 0px 0px 15px;" src="_images/star.png"/>
                                <p style="margin-left:80px; margin-top:30px;"><label>By: </label>
                                    <?php if ($row['uid'] == "0") { ?>
                                        <a href="javascript:void(0)"><?php echo "Admin"; ?></a>
                                    <?php } else { ?>
                                        <a href="profile-details.php?username=<?php echo $row['username']; ?>"><?php echo $row['username']; ?></a>
                                    <?php } ?>
                                <p>
                                <p style="margin-left:80px;"><label>on:</label><?php echo date('F jS, Y h:i a', strtotime($row["post_time"])); ?></p>
                                <?php
                                if ((isset($_SESSION['talent_id'])AND ( ($_SESSION['talent_id'] == $row['uid']) || ($_SESSION['talent_id'] == $data121['uid']))) || (isset($_SESSION['user_id'])AND ( ($_SESSION['user_id'] == $row['uid']) || ($_SESSION['user_id'] == $data121['uid']))) || (isset($_SESSION['cms_login']) && ($_SESSION['cms_login'] != 0))) {
                                    //if(isset($_SESSION['talent_id'])AND($_SESSION['talent_id']==$row['uid']) || (isset($_SESSION['cms_login']) && ($_SESSION['cms_login']!=0))||(isset($_SESSION['user_id'])AND($_SESSION['user_id']==$row['uid']))){
                                    ?>
                                    <a  style="margin-left:80px;" href="<?php echo "javascript:ConfrimREPLY_Delete('delete-forum-topic_reply.php?id=" . $row['reply_id'] . "&forum_id=" . $_GET['id'] . "')"; ?>">
                                        <img src="_images/del.png" title="Delete Topic">
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="reply">

                                <?php echo stripcslashes($row['reply_text']); ?>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>  	
    </table> 
</div>
<?php
include('_includes/footer.php');
?>

