<?php
include('_includes/application-top.php');
$query = mysqli_query($link,"SELECT * FROM  tbl_products WHERE id='" . $_GET['id'] . "' ORDER BY tbl_products.id DESC");
$row = mysqli_fetch_assoc($query);
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
    <p style="text-align:right"><a href="javascript:back(0)" class="button" style="float:left; margin:-5px 0px 0px 0px;" onclick="return back();">Back</a></p><br />
    <div class="profile_page_wraper"><!--START DIV CLASS profile_page_wraper-->	

        <div class="mystore">

            <div class="store_detail_products">

        <!--	<div class="store_detail_left_book"> <img src="_uploads/profile_book_photo/thumb/<?php echo $row['id']; ?>.jpg" alt=" "/></div>-->
                <div class="store_detail_left_book"> 
<!--<a href="_uploads/profile_book_photo/<?php echo $row["id"]; ?>.jpg" class="fancybox"><img src="_uploads/profile_book_photo/thumb/<?php echo $row["id"]; ?>.jpg" alt="my_img"/></a>-->
                    <img src="_uploads/profile_product/<?php echo $row["id"]; ?>.jpg" width="500px" alt="my_img"/>
                </div>
                <div class="store_detail_right_product_as">
                    <br /><h4><?php echo $row['product_name']; ?></h4><br />				
                    <?php echo nl2br($row['product_details']); ?>
                    <h4 class="pspan">Price: $<?php echo $row['product_price']; ?></h4>
                    <p class="by_now"><a href="#">By now</a></p>

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
