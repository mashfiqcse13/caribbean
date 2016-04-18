<?php
include('../_includes/application-top.php');
ChecktalentLogin();
/* chacking for payment delails */
$sql = mysql_query("SELECT * FROM  tbl_seller_bank WHERE uid='" . $_SESSION['talent_id'] . "' ");
//$result=mysql_fetch_assoc($sql);
$payment_details = mysql_num_rows($sql);
//echo $payment_details;
if ($payment_details == 1) {
    $url = "add_product.php";
} else {
    $url = "update_payment_details.php";
}
//$num=mysql_num_rows($sql);
//echo $num;
//print_r($result);

if (isset($_GET['id'])) {
    $sql = "delete from tbl_products where id='" . $_GET['id'] . "'";
    mysql_query($sql);
    unlink("../_uploads/profile_product/" . $_GET['id'] . ".jpg");
    unlink("../_uploads/profile_product/thumb/" . $_GET['id'] . ".jpg");
    header("Location:manage_product.php?op=del");
}
include('../_includes/header.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>
<!--/////MUSIC DELETE CONFIRM MESSAGE///////-->
<script type="text/javascript">
    function ConfrimMessage_Delete(Url) //confarming property delete
    {
        if (confirm("Are you sure you want to delete this Record?"))
        {
            /*self.navigate(Url);*/ //redirecting to the desired page
            window.location = "" + Url;
        }
    }

    function check_ok() {
        var t = confirm("Currently you do not have any bank details added, you need to add your bank details before adding any products for sellig.");

        if (t == true)
        {
            /*self.navigate(Url);*/ //redirecting to the desired page
            return true;
        } else
        {
            return false;
        }

    }

    $(document).ready(function () {
        $("a.fancybox").fancybox();
    });
</script>
<div class="content">
    <h1>Profile Product</h1>
    <?php
    if (isset($_GET['op'])) {
        ?>
        <p class="err">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "del")) {
                echo "Product Record Deleted Sucessfully.";
            }
            ?>
        </p>
        <p class="msg">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "u")) {
                echo "Product Record Edit sucessfully.";
            }
            ?>
        </p>
    <?php } ?>
    <p style="text-align:right">
        <a href="profile_setup.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a>

        <a href="<?php echo $url; ?>" class="button"<?php if ($payment_details == '') { ?> onclick="javascript:return check_ok()"<?php } ?>>Add Product</a>
    </p>
    <!--/////USER MUSIC UPLOAD HEAR/////-->
    <?php
    //DATABASE QUERY
    $result = mysql_query("SELECT * FROM  tbl_products WHERE 	uid='" . $_SESSION['talent_id'] . "' AND content_type=0 ORDER BY tbl_products.id DESC ");
    $number = mysql_num_rows($result);
    //$data=mysql_fetch_assoc($result);
    //print_r($data);
    ?>
    <table cellpadding="0" cellspacing="0" class="TabUIRecords" width="100%">
        <?php
        if ($number <= 0) {
            ?>
            <p class="err"><?php echo "No Record Found!"; ?></p>
            <?php
        } else {
            ?>
            <thead>
                <tr>
                    <th>Product Photo</th>
                    <th style="text-align:left;">Name</th>
                    <th style="text-align:left;">Product Details</th>
                    <th align="center">Product Price</th>
                    <th align="center">Shipping</th>
                    <th align="center">Status</th>
                    <th align="center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
            }
            while ($row = mysql_fetch_assoc($result)) {
                ?>
                <tr>
                    <td width="8%">
                        <?php
                        $image = "../_uploads/profile_product/" . $row["id"] . ".jpg";
                        if (file_exists($image)) {
                            ?>
                            <a href="../_uploads/profile_product/<?php echo $row["id"]; ?>.jpg" class="fancybox">
                                <img class="cart_img" src="../_uploads/profile_product/<?php echo $row["id"] ?>.jpg" /></a>
                        <?php } else { ?>
                            <img class="cart_img" src="../_images/mp3-play.png" />	
    <?php } ?>
                    </td>
                    <td><?php echo $row["product_name"]; ?></td>
                    <td><?php echo substr($row["product_details"], 0, 30); ?></td>
                    <td align="center"><?php echo $row["product_price"]; ?></td>
                    <td align="center"><?php echo $row['p_shipping']; ?></td>
                    <td align="center"><?php if ($row['status'] == 1) { ?><p class="active"><?php echo 'Active'; ?></p><?php } else { ?><p class="inactive"><?php echo 'Inactive'; ?></p><?php } ?></td>
                    <td align="center">
                        <a href="update_product.php?id=<?php echo $row["id"]; ?>"><img src="../_images/Edit.png" title="Update Product"></a>
                        <a href="<?php echo "javascript:ConfrimMessage_Delete('manage_product.php?id=" . $row["id"] . "')"; ?>"><img src="../_images/del.png" title="Delete Product"></a>
                    </td>
                </tr>				
                <?php
            }
            ?>
        </tbody>				
    </table> 
</div>
<?php
include('../_includes/footer.php');
?>
