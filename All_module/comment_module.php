<?php
$query_comment = mysqli_query($link, "SELECT c.id AS CID,c.profile_id,c.comment_text,c.commenter_id, u.id AS UID,u.first_name,u.last_name FROM  tbl_profile_comments AS c 
															LEFT OUTER JOIN
															tbl_users AS u ON u.id=c.profile_id WHERE u.username='" . $_GET['username'] . "' ORDER BY c.id DESC LIMIT 2");
?>

<div class="comment_div"><!--START DIV comment_div-->
    <h2>Comments</h2>	
    <?php
    if (mysqli_num_rows($query_comment) > 0) {
        ?>

        <?php
        while ($row_comment = mysqli_fetch_assoc($query_comment)) {
            $query_username = mysqli_query($link, "SELECT username FROM tbl_users WHERE id='" . $row_comment['commenter_id'] . "' ");
            $rows_username = mysqli_fetch_assoc($query_username);
            ?>

            <ul>
                <li>
                    <div class="post_imge">
                        <a href="profile-details.php?username=<?php echo $rows_username['username'] ?>">
                            <?php
                            $filename = "_uploads/user_photo/{$row_comment['commenter_id'] }.jpg";
                            if (file_exists($filename)) {
                                ?>
                                <img src="_uploads/user_photo/<?php echo $row_comment['commenter_id']; ?>.jpg?<?php echo time() ?>" width="70px" height="60px" />
                            <?php } else { ?>
                                <img src="_images/dummy.png" width="70px" height="60px" />
                            <?php } ?>
                        </a>
                    </div>
                    <div class="post_txt">
                        <h3>
                            <a href="profile-details.php?username=<?php echo $rows_username['username'] ?>"><?php echo $rows_username['username'] ?></a>
                        </h3>

                        <p><?php echo substr($row_comment['comment_text'], 0, 25); ?> </p>
                    </div>
                    <div class="clear"></div>
                </li>

            </ul>
            <?php
        }
    }
    ?>
    <?php
    if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
        $uid = $_SESSION['talent_id'];
    } elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
        $uid = $_SESSION['user_id'];
    } else {
        $uid = "";
    }
    ?>
    <div class="comntbtn_top_spece">
        <a class="profile_btn" href="profile-comment.php?id=<?php echo $data['id']; ?>">All Comments</a> 
        <a  class="profile_btn" href="" onclick="return popitup1('add_comments.php?id=<?php echo $data['id']; ?>')">Add Comments</a>


    </div>
</div><!--END DIV comment_div-->