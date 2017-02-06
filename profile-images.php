<?php
include('_includes/application-top.php');

if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Add To Cart')) {

    if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
        $uid = $_SESSION['talent_id'];
    } elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
        $uid = $_SESSION['user_id'];
    } else {
        $uid = "";
    }

    if ($uid != "") {

        $sql = mysqli_query($link, "SELECT * FROM  tbl_products WHERE id='" . $_POST['p_id'] . "' AND content_type='3'");
        $producrt = mysqli_fetch_assoc($sql);

        $data = array(
            "uid" => $uid,
            "p_id" => $producrt['id'],
            "p_name" => $producrt['product_name'],
            "p_price" => $producrt['product_price'],
            "p_shipping" => $producrt['p_shipping'],
            "add_date" => date('y-m-d h:i:s')
        );
        $table = "tbl_shopping_cart";

        $sql = mysqli_query($link, "SELECT * FROM  tbl_shopping_cart WHERE 	p_id='" . $_POST['p_id'] . "' and uid='" . $uid . "'");
        $num_row = mysqli_num_rows($sql);

        if ($num_row == 0) {
            insertData($data, $table);
            header("Location:shopping_cart.php?op=a");
        }
    } else {
        header("Location:profile-images.php?id=" . $_GET['id'] . "&op=cr ");
    }
}


include('_includes/header.php');
?>

<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>
<script type="text/javascript">
    function back()
    {
        window.history.back();
    }
</script>
<!--/////////////////SESSION USER ALL IMAGE//////////////-->

<div class="content"><!--START CLASS contant PART -->
    <h2>All Images</h2>
    <?php if (isset($_GET['op'])) {
        ?>
        <p class="err">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "cr")) {
                echo "Please Login First To Add This Photo In Your Cart .";
            }
            ?>
        </p>
    <?php } ?>
    <p style="text-align:right"><a href="javascript:back(0)" class="button" style="float:left; margin:-5px 0px 0px 0px;" onclick="return back();">Back</a><br />
        <?php
        $query = mysqli_query($link, "SELECT * FROM tbl_profile_photos WHERE user_id='" . $_GET['id'] . "' ORDER BY tbl_profile_photos.id DESC");
        ?>

        <?php
        while ($row = mysqli_fetch_assoc($query)) {
            ?>
        <div class="profile_details_bottom1">
            <?php
            $img_name = "{$row["id"]}.jpg?" . time();
            if ($row["croped"] == 1) {
                ?>
                <a href="<?php echo BASE_URL ?>_uploads/profile_photo/croped/<?php echo $img_name; ?>" class="fancybox">
                    <img src="<?php echo BASE_URL ?>_uploads/profile_photo/croped/<?php echo $img_name; ?>" 
                         width="100" alt="my_img"/>
                </a>
            <?php } else { ?>
                <a href="<?php echo BASE_URL ?>_uploads/profile_photo/<?php echo $img_name; ?>" class="fancybox">
                    <img src="<?php echo BASE_URL ?>_uploads/profile_photo/thumb/<?php echo $img_name; ?>" 
                         width="100" alt="my_img"/>
                </a>
            <?php } ?>
            <?php $data = getAnyTableWhereData("tbl_products", "AND ref_id='" . $row["id"] . "' AND content_type='3' "); ?>
            <p><label><?php echo $row['photo_title']; ?></label><p>	
                <?php if (is_favorite($row["id"], 'photo') == false) { ?>
                <form action="<?php echo BASE_URL ?>member/add_product_to_favorite.php" method="get">
                    <input type="hidden" name="item_id" value="<?php echo $row["id"]; ?>" />
                    <input type="hidden" name="item_type" value="photo" />	
                    <input type="submit" value="Add To Favorite" />
                </form>	
                <br>
            <?php } ?>

            <form action="" method="post">
                <input type="hidden" name="p_id" value="<?php echo $data['id']; ?>" />
                <?php
                if ($data['status'] == 1) {
                    ?>
                    <p><label>Price : </label><span class="price_product">$<?php echo $data['product_price']; ?></span></p>		
                    <input type="submit" class="p_Add_Cart" value="Add To Cart" name="submit" />
                    <?php
                }
                ?>

            </form>		

        </div>

        <?php
    }
    ?>
    <div style="clear:both"></div>
</div>



<?php
include('_includes/footer.php');
?>
