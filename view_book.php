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

        $sql = mysql_query("SELECT * FROM  tbl_products WHERE id='" . $_POST['p_id'] . "' AND content_type='4'");
        $producrt = mysql_fetch_assoc($sql);
        //print_r($producrt);

        $data = array(
            "uid" => $uid,
            "p_id" => $producrt['id'],
            "p_name" => $producrt['product_name'],
            "p_price" => $producrt['product_price'],
            "p_shipping" => $producrt['p_shipping'],
            "add_date" => date('y-m-d h:i:s')
        );
        $table = "tbl_shopping_cart";

        $sql = mysql_query("SELECT * FROM  tbl_shopping_cart WHERE 	p_id='" . $_POST['p_id'] . "' and uid='" . $uid . "'");
        $num_row = mysql_num_rows($sql);

        if ($num_row == 0) {
            insertData($data, $table);
            header("Location:shopping_cart.php?op=a");
        }
    } else {
        header("Location:view_book.php?id=" . $_GET['id'] . "&op=cr ");
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
    <h2>Books</h2>
    <?php if (isset($_GET['op'])) {
        ?>
        <p class="err">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "cr")) {
                echo "Please Login First To Add This Book In Your Cart .";
            }
            ?>
        </p>
    <?php } ?>
    <p style="text-align:right"><a href="javascript:back(0)" class="button" style="float:left; margin:-5px 0px 0px 0px;" onclick="return back();">Back</a></p><br />
    <?php
    $query = mysql_query("SELECT * FROM  tbl_profile_books WHERE uid='" . $_GET['id'] . "' ORDER BY tbl_profile_books.id DESC");
    ?>
    <div class="profile_page_wraper"><!--START DIV CLASS profile_page_wraper-->	
        <?php
        while ($row = mysql_fetch_assoc($query)) {
            $data = getAnyTableWhereData("tbl_products", "AND ref_id='" . $row["id"] . "' AND content_type='4' ");
            ?>
            <div class="mystore">

                <div class="store_detail_book">


                    <div class="store_detail_left_book"> 
                        <a href="_uploads/profile_book_photo/<?php echo $row["id"]; ?>.jpg" class="fancybox">
                            <img src="_uploads/profile_book_photo/thumb/<?php echo $row["id"]; ?>.jpg" alt="my_img"/>
                        </a>		    
                        <form action="" method="post">
                            <input type="hidden" name="p_id" value="<?php echo $data['id']; ?>" />
                            <?php
                            if ($data['status'] == 1) {
                                ?>
                                <input type="submit" class="Book_Add_Cart" value="Add To Cart" name="submit" />
                                <?php
                            }
                            ?>
                        </form>
                    </div>			
                    <div class="store_detail_right_book">
                        <h4><?php echo $row['name']; ?></h4>
                        <span><?php echo $row['author']; ?></span>
                        <?php
                        if ($data['status'] == 1) {
                            ?> 
                            <span class="price_product">Price : $<?php echo $data['product_price']; ?></span>	
                            <?php
                        }
                        echo substr($row['book_details'], 0, 25);
                        ?><a href="view_book_details.php?id=<?php echo $row['id']; ?>" class="book_details">&nbsp;[ View Details ]</a>
                    </div><div class="clear"></div>
                </div>

            </div>
            <?php
        }
        ?>

    </div>
</div>
<?php
include('_includes/footer.php');
?>
