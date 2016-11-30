<?php
/*
 * important variables
 *          $user_id
 *          
 */
$db = new DBClass(db_host, db_username, db_passward, db_name);
$sql = "SELECT * FROM `tbl_profile_music` WHERE `id` in (
                select tbl_user_fav_music.id_music as id from tbl_user_fav_music 
                where tbl_user_fav_music.id_user = $user_id
            )";
//echo$sql;
$my_fav_musics = $db->db_query($sql);
if (empty($my_fav_musics)) {
    return FALSE;
}
?>
<h2>My Favorite Musics</h2>

<!--div.flexbox>(div.flex-itme*7)-->

<div class="flexbox my-fav-image">
    <?php
    foreach ($my_fav_musics as $my_fav_music) {
        ?>

        <div class="flex-item music-item single-item">
            <?php
            echo show_music($my_fav_music->id);
            ?><br><br>
            <strong><?php echo $my_fav_music->music_title; ?></strong>
            <br><br>
            <?php if (is_favorite($my_fav_music->id, 'music')) { ?>
                <div>
                    <form action="<?php echo BASE_URL ?>member/remove_product_from_favorite.php" method="get">
                        <input type="hidden" name="item_id" value="<?php echo $my_fav_music->id; ?>" />
                        <input type="hidden" name="item_type" value="music" />	
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