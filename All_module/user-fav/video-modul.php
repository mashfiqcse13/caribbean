<?php
/*
 * important variables
 *          $user_id
 *          
 */
$db = new DBClass(db_host, db_username, db_passward, db_name);
$sql = "SELECT * FROM `tbl_profile_videos` WHERE `id` in (
                select tbl_user_fav_video.id_video as id from tbl_user_fav_video 
                where tbl_user_fav_video.id_user = $user_id
            )";
//echo$sql;
$my_fav_videos = $db->db_query($sql);
if (empty($my_fav_videos)) {
    return FALSE;
}
?>
<h2>My Favorite Video</h2>

<!--div.flexbox>(div.flex-itme*7)-->

<div class="flexbox my-fav-image">
    <?php
    foreach ($my_fav_videos as $my_fav_video) {
        ?>

        <div class="flex-item video-item single-item">
            <?php
            echo show_video($my_fav_video->video_type, $my_fav_video->id);
            ?><br><br>
            <strong><?php echo $my_fav_video->video_name; ?></strong>
            <br><br>
            <?php if (is_favorite($my_fav_video->id, 'video')) { ?>
                <div>
                    <form action="<?php echo BASE_URL ?>member/remove_product_from_favorite.php" method="get">
                        <input type="hidden" name="item_id" value="<?php echo $my_fav_video->id; ?>" />
                        <input type="hidden" name="item_type" value="video" />	
                        <input type="submit" value="Remove from Favorite" />
                    </form>
                </div>	
                <br>
            <?php } ?>
        </div>
        <?php
    }
    ?>
</div>