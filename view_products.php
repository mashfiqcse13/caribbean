<?php
include('_includes/application-top.php');

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
    <h2>ALL PRODUCTS</h2>
    <p style="text-align:right"><a href="javascript:back(0)" class="button" style="float:left; margin:-5px 0px 0px 0px;" onclick="return back();">Back</a></p><br />
    <?php
    $query = mysql_query("SELECT * FROM  tbl_products WHERE uid='" . $_GET['id'] . "' AND status=1 AND content_type=0 ORDER BY tbl_products.id DESC");
    ?>
    <div class="profile_page_wraper"><!--START DIV CLASS profile_page_wraper-->	
        <?php
        while ($row = mysql_fetch_assoc($query)) {
            ?>
            <div class="mystore">

                <div class="store_detail_book">

                <!--	<div class="store_detail_left_book"> <img src="_uploads/profile_book_photo/thumb/<?php echo $row['id']; ?>.jpg" alt=" "/></div>-->
                    <div class="store_detail_left_book"> <a href="_uploads/profile_product/<?php echo $row["id"]; ?>.jpg" class="fancybox"><img src="_uploads/profile_product/thumb/<?php echo $row["id"]; ?>.jpg" alt="my_img"/></a></div>
                    <div class="store_detail_right_product">
                        <h4>
                            <a href="products_details.php?id=<?php echo $row['id']; ?>" class="book_details">
                                <?php echo $row['product_name']; ?>
                            </a>
                        </h4><br />						
                        <?php echo substr($row['product_details'], 0, 125); ?>
                        <p class="pspan">$<?php echo $row['product_price']; ?></p>
                        <p class="product_details"><a href="products_details.php?id=<?php echo $row['id']; ?>">Product Details</a></p>


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
