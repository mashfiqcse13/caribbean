<?php
include('_includes/application-top.php');
CheckLoginForum();
//ChecktalentLogin();
/* USER COMMENT SUBMIT CHECK */
if (isset($_GET['did'])) {
    $sql = "delete from tbl_profile_comments where id='" . $_GET['did'] . "'";
    mysqli_query($link,$sql);
    header("Location:profile-comment.php?id=" . $_GET['id'] . "&op=del");
}

if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Submit')) {
    if ($_SESSION['dup_comment_body'] == $_POST['comment_text']) {
        echo 'You already entered that.';
    } else {
        $data = array(
            "profile_id" => $_POST['profile_id'],
            "commenter_id" => $_POST['commenter_id'],
            "comment_text" => mysqli_real_escape_string( $link ,trim($_POST['comment_text'])),
        );

        insertData($data, "tbl_profile_comments");

        $_SESSION['dup_comment_body'] = $_POST['comment_text'];

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

        header("Location:profile-comment.php?id=" . $_GET['id'] . "&op=a");
    }
}

include('_includes/header.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#comment').validate()
    });

    function ConfrimMessage_Delete(Url) //confarming property delete
    {
        if (confirm("Are you sure you want to delete this Record?"))
        {
            /*self.navigate(Url);*/ //redirecting to the desired page
            window.location = "" + Url;
        }
    }
    function Update_Comments(cid, uid, url)
    {
        var comm = $("#comment_text_" + cid).val();
        if ($.trim(comm) == "")
        {
            ConfrimMessage_Delete(url);
        } else
        {

            $.ajax({
                type: "POST",
                url: "updatecomments.php",
                data: "cid=" + cid + "&uid=" + uid + "&txt=" + comm,
                success: function (result)
                {
                    //alert(result);
                    $("#pl2_" + cid).hide();
                    $("#pl1_" + cid).html(comm).show();

                }});
        }
    }

    function edit_enable(id)
    {
        $("#pl1_" + id).hide();
        $("#pl2_" + id).show();
    }
</script>

<!--<script type="text/javascript">	
function back()
                        {
                                window.history.back();
                        }			
</script>-->

<div class="content"><!--START DIV CALSS content-->
    <?php
    $query = mysqli_query($link,"SELECT * FROM tbl_users WHERE id='" . $_GET['id'] . "'");
    $rowss = mysqli_fetch_assoc($query)
    ?>
    <h2><?php echo $rowss['first_name'] . " " . $rowss['last_name']; ?> / Comments</h2>
    <?php
    if (isset($_GET['op'])) {
        ?>
        <p class="err">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "del")) {
                echo "Comment Record Deleted Sucessfully.";
            }
            ?>
        </p>
        <p class="msg">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "a")) {
                echo " Your Comment Added sucessfully.";
            }
            ?>
        </p>
    <?php } ?>
    <p style="text-align:right"><a href="<?php echo SITE_URL; ?>profile-details.php?username=<?php echo $rowss['username']; ?>" class="button" style="float:left; margin:-5px 0px 0px 0px;" onclick="return back();">Back</a></p><br />



    <!--//////////FETCH ALL COMMENTS START////////-->	


    <div class="profile_page_wraper"><!--START DIV CLASS profile_page_wraper-->
        <div style="width:70%;"
             <!------/////////USER INPUT COMMEND///////////----------->	  

             <div class="comment_input">
                     <?php
                     if (((isset($_SESSION['user_id'])) || (isset($_SESSION['talent_id']))) && $_SESSION['is_admin'] != "yes") {
                         $query2 = mysqli_query($link,"SELECT * FROM tbl_users WHERE id='" . $_GET['id'] . "'");
                         while ($row2 = mysqli_fetch_assoc($query2)) {
                             ?>
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="comment">											
                            <p><label for="comment_text">Add Comments:</label>
                                <textarea name="comment_text" id="comment_text" class="required"></textarea>					
                            </p>																							
                            <input type="hidden" id="profile_id" name="profile_id" value="<?php echo $row2['id']; ?>"/>


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
                        <?php
                    }
                } else {
                    //echo "User Not Login";
                }
                ?>			
            </div><hr />

            <div class="comment_div_profile"><!--START DIV comment_div_profile-->
                <?php
                $comment_query = mysqli_query($link,"SELECT tbl_profile_comments.*,tbl_users.username,tbl_users.first_name,tbl_users.last_name FROM tbl_profile_comments LEFT JOIN tbl_users ON tbl_profile_comments.commenter_id=tbl_users.id WHERE tbl_profile_comments.profile_id='" . $_GET['id'] . "' ORDER BY tbl_profile_comments.id DESC LIMIT 50");
                //$weq=mysqli_fetch_assoc($comment_query);
                //print_r($weq);
                ?>
                <ul>
                    <?php
                    while ($row3 = mysqli_fetch_assoc($comment_query)) {
                        ?>


                        <li>
                            <div class="post_imge"> 
                                <a href="profile-details.php?username=<?php echo $row3['username'] ?>">


                                    <?php
                                    //$image = "_uploads/user_photo/".$row_comment['commenter_id'].".jpg"; 
                                    $image = "_uploads/user_photo/" . $_SESSION["talent_id"] . ".jpg";
                                    if (file_exists($image)) {
                                        ?>
                                        <img src="_uploads/user_photo/<?php echo $_SESSION["talent_id"]; ?>.jpg" width="70px" height="60px" />
                                        <?php
                                    } else {
                                        ?>
                                        <img src="_images/dummy.png" style="width:70px; height:75px;">
                                        <?php
                                    }
                                    ?>
                                </a>
                            </div>
                            <div class="post_txt1">
                                <h3><a href="profile-details.php?username=<?php echo $row3['username'] ?>"> <?php echo $row3['first_name']; ?> <?php echo $row3['last_name']; ?></a></h3>
                                <p id="pl1_<?php echo $row3['id']; ?>"><?php echo nl2br($row3['comment_text']); ?> </p>

                                <?php
                                if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
                                    $uid = $_SESSION['talent_id'];
                                } elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
                                    $uid = $_SESSION['user_id'];
                                } else {
                                    $uid = "";
                                }
                                if ((($uid == $row3['profile_id']) || ($uid == $row3['commenter_id'])) && $_SESSION['is_admin'] != "yes") {
                                    ?>
                                    <p id="pl2_<?php echo $row3['id']; ?>" style="display:none;"><textarea name="comment_text_<?php echo $row3['id']; ?>" id="comment_text_<?php echo $row3['id']; ?>"><?php echo nl2br($row3['comment_text']); ?></textarea><input type="button" name="update" value="Update" class="button" onclick="<?php echo "javascript:Update_Comments('" . $row3['id'] . "', '" . $uid . "', 'profile-comment.php?id=" . $_GET['id'] . "&did=" . $row3["id"] . "')"; ?>" /> </p>
                                    <?php
                                }
                                ?>
                                <p style="margin-top:-16px;"><?php echo $row3['comment_time']; ?> </p>
                                <?php
                                if ((($uid == $row3['profile_id']) || ($uid == $row3['commenter_id'])) && $_SESSION['is_admin'] != "yes") {
                                    ?>
                                    <a href="<?php echo "javascript:ConfrimMessage_Delete('profile-comment.php?id=" . $_GET['id'] . "&did=" . $row3["id"] . "')"; ?>"><img src="_images/del.png" title="Delete comment"></a>
                                    <a href="javascript:void(0)" onclick="edit_enable('<?php echo $row3['id']; ?>')" ><img src="_images/editpencil.png" title="Edit comment"></a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="clear"></div>
                        </li>


                        <?php
                    }
                    ?>
                </ul>
            </div><!--END DIV comment_div_profile-->		

        </div><!--END DIV CLASS profile_page_wraper-->

        <!--//////////FETCH ALL COMMENTS END////////-->
    </div>	

    <div style="clear:both"></div>
</div><!--END DIV CALSS content-->




<?php
include('_includes/footer.php');
?>

