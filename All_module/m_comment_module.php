<?php
$query_comment = mysql_query("SELECT c.id AS CID,c.profile_id,c.comment_text,c.commenter_id, u.id AS UID,u.first_name,u.last_name FROM  tbl_profile_comments AS c 
															LEFT OUTER JOIN
															tbl_users AS u ON u.id=c.profile_id WHERE u.username='" . $_GET['username'] . "' ORDER BY c.id DESC LIMIT 2");
?>

<div class="comment_div"><!--START DIV comment_div-->
    <h2>Comments</h2>	
    <?php
    if (mysql_num_rows($query_comment) > 0) {
        ?>

        <?php
        while ($row_comment = mysql_fetch_assoc($query_comment)) {
            $query_username = mysql_query("SELECT username FROM tbl_users WHERE id='" . $row_comment['commenter_id'] . "' ");
            $rows_username = mysql_fetch_assoc($query_username);
            ?>

            <ul>
                <li>
                    <div class="post_imge"> <a href="profile-details.php?username=<?php echo $rows_username['username'] ?>"><img src="_uploads/user_photo/<?php echo $row_comment['commenter_id']; ?>.jpg" width="70px" height="60px" /></a></div>
                    <div class="post_txt">
                        <h3><a href="profile-details.php?username=<?php echo $rows_username['username'] ?>"> <?php echo $rows_username['username'] ?></a></h3>

                        <p><?php echo substr($row_comment['comment_text'], 0, 25); ?> </p>
                    </div>
                    <div class="clear"></div>
                </li>

            </ul>
            <?php
        }
    }
    ?>
    <div class="comntbtn_top_spece">
        <a class="profile_btn" href="profile-comment.php?id=<?php echo $data['id']; ?>">All Comments</a>
        <a  class="profile_btn" href="" onclick="return popitup1('add_comments.php?id=<?php echo $data['id']; ?>')">Add Comments</a>

    </div>
</div><!--END DIV comment_div-->