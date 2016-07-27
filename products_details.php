<?php
include('_includes/application-top.php');
//CheckLoginForum();
$query = mysqli_query($link,"SELECT * FROM  tbl_products WHERE id='" . $_GET['id'] . "'   ORDER BY tbl_products.id DESC");
$row = mysqli_fetch_assoc($query);

if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Add To Cart')) {

    if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
        $uid = $_SESSION['talent_id'];
    } elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
        $uid = $_SESSION['user_id'];
    } else {
        $uid = "";
    }

    if ($uid != "") {

        $sql = mysqli_query($link,"SELECT * FROM  tbl_products WHERE id='" . $_POST['p_id'] . "' AND content_type='0' ");
        $producrt = mysqli_fetch_assoc($sql);
        //print_r($producrt);

        if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
            $uid = $_SESSION['talent_id'];
        } elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
            $uid = $_SESSION['user_id'];
        } else {
            $uid = "";
        }
        $data = array(
            "uid" => $uid,
            "p_id" => $producrt['id'],
            "p_name" => $producrt['product_name'],
            "p_price" => $producrt['product_price'],
            "p_shipping" => $producrt['p_shipping'],
            "add_date" => date('y-m-d h:i:s')
        );
        $table = "tbl_shopping_cart";

        $sql = mysqli_query($link,"SELECT * FROM  tbl_shopping_cart WHERE 	p_id='" . $_POST['p_id'] . "' and uid='" . $uid . "'");
        $num_row = mysqli_num_rows($sql);

        if ($num_row == 0) {
            insertData($data, $table);
            header("Location:shopping_cart.php?op=a");
        }
    } else {

        header("Location:products_details.php?id=" . $_GET['id'] . "&op=cr ");
    }
}
include('_includes/header.php');
?>

<script type="text/javascript">
    function back()
    {
        window.history.back();
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>

<div class="content">
    <h2><?php echo $row['product_name']; ?></h2>
    <?php if (isset($_GET['op'])) {
        ?>
        <p class="err">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "cr")) {
                echo "Please Login First To Add This Product In Your Cart .";
            }
            ?>
        </p>
    <?php } ?>
    <p style="text-align:right"><a href="javascript:back(0)" class="button" style="float:left; margin:-5px 0px 0px 0px;" onclick="return back();">Back</a></p><br />
    <div class="profile_page_wraper"><!--START DIV CLASS profile_page_wraper-->	

        <div class="mystore">

            <div class="store_detail_products">

        <!--	<div class="store_detail_left_book"> <img src="_uploads/profile_book_photo/thumb/<?php echo $row['id']; ?>.jpg" alt=" "/></div>-->
                <div class="store_detail_left_book"> 
<!--<a href="_uploads/profile_book_photo/<?php echo $row["id"]; ?>.jpg" class="fancybox"><img src="_uploads/profile_book_photo/thumb/<?php echo $row["id"]; ?>.jpg" alt="my_img"/></a>-->
                    <?php
                    $image = "_uploads/profile_product/thumb/" . $row["id"] . ".jpg";
                    if (file_exists($image)) {
                        ?>
                        <img src="_uploads/profile_product/thumb/<?php echo $row["id"] ?>.jpg" />
                    <?php } else { ?>
                        <img src="_images/mp3-play.png" />	
<?php } ?>
                </div>
                <div class="store_detail_right_product_as">
                    <br /><h4><?php echo $row['product_name']; ?></h4><br />		

<?php echo nl2br($row['product_details']); ?>

                    <h4 class="pspan">Price: $<?php echo $row['product_price']; ?></h4>

<?php /* ?><p class="buy_now"><a href="order_confirmation.php?id=<?php echo $row['id']; ?>">Buy now</a></p><?php */ ?>



                    <div class="buy_now_4"> <form action="" method="post">

                            <input type="hidden" name="p_id" value="<?php echo $row['id']; ?>" />

                            <?php
                            if ($row['status'] == 1) {
                                ?>

                                <input type="submit" class="Add_Cart" value="Add To Cart" name="submit" />
                                <?php
                            }
                            ?>

                        </form>

                    </div>
                </div>
                <div class="clear"></div> 
                <div>
<?php echo $row['video_code']; ?>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
include('_includes/footer.php');
?>
