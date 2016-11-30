<?php
/*
 * important variables
 *          $user_id
 *          
 */
$db = new DBClass(db_host, db_username, db_passward, db_name);
$sql = "SELECT * FROM `tbl_profile_photos` WHERE `id` in (
                select tbl_user_fav_photo.id_photo as id from tbl_user_fav_photo 
                where tbl_user_fav_photo.id_user = $user_id
            )";
$my_fav_photos = $db->db_query($sql);
if (sizeof($my_fav_photos) > 0) {
    return FALSE;
}
?>
<h2>My Favorite Video</h2>

<!--div.flexbox>(div.flex-itme*7)-->

<div class="flexbox my-fav-image">
    <?php
    foreach ($my_fav_photos as $my_fav_photo) {
        ?>

        <div class="flex-item image-item single-item">
            <?php
            $img_name = "{$my_fav_photo->id}.jpg?" . time();

            //Writting image item
            if ($my_fav_photo->croped == 1) {
                ?>
                <a href="../_uploads/profile_photo/croped/<?php echo $img_name; ?>" class="fancybox">
                    <img src="../_uploads/profile_photo/croped/<?php echo $img_name; ?>" 
                         width="100" alt="my_img"/>
                </a>
            <?php } else { ?>
                <a href="../_uploads/profile_photo/<?php echo $img_name; ?>" class="fancybox">
                    <img src="../_uploads/profile_photo/thumb/<?php echo $img_name; ?>" 
                         width="100" alt="my_img"/>
                </a>
            <?php }
            ?><br><br>
            <strong><?php echo $my_fav_photo->photo_title; ?></strong>
            <br><br>
            <?php if (is_favorite($my_fav_photo->id, 'photo')) { ?>
                <div>
                    <form action="<?php echo BASE_URL ?>member/remove_product_from_favorite.php" method="get">
                        <input type="hidden" name="item_id" value="<?php echo $my_fav_photo->id; ?>" />
                        <input type="hidden" name="item_type" value="photo" />	
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