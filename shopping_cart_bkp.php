<?php
include('_includes/application-top.php');
CheckLoginForum();
if (isset($_GET['p_id'])) {
    $sql = "delete from tbl_shopping_cart where id='" . $_GET['p_id'] . "'";
    mysqli_query($link,$sql);
    header("Location:shopping_cart.php?op=d");
}
include('_includes/header.php');
?>

<script type="text/javascript">
    function ConfrimMessage_Delete(Url) //confarming property delete
    {
        if (confirm("Are you sure you want to Remove this Record?"))
        {
            /*self.navigate(Url);*/ //redirecting to the desired page
            window.location = "" + Url;
        }
    }

    function back()
    {
        window.history.back();
    }
</script>

<div class="content">
    <h2>Products</h2>
    <?php
    if (isset($_GET['op'])) {
        ?>
        <p class="err">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "d")) {
                echo "Product Removed From cart Sucessfully.";
            }
            ?>
        </p>
        <p class="msg">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "a")) {
                echo "Product Added To Cart Sucessfully.";
            }
            ?>
        </p>
    <?php } ?>

    <?php
    if (isset($_SESSION["talent_id"])) {
        $uid = $_SESSION["talent_id"];
    } else if (isset($_SESSION["user_id"])) {
        $uid = $_SESSION["user_id"];
    }
    $result = mysqli_query($link,"SELECT * FROM tbl_shopping_cart WHERE uid=" . $uid . "");
    $number = mysqli_num_rows($result);
    //$data=mysqli_fetch_assoc($result);
    // print_r($data);
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
                    <th style="border:none; text-align:right;">Product</th>
                    <th></th>
                    <th align="center">Product Price</th>
                    <th align="center">Shipping</th>
                    <th align="center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
            }
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td width="20%" style="border:none;">
                        <?php
                        $image = "_uploads/profile_product/thumb/" . $row["p_id"] . ".jpg";
                        if (file_exists($image)) {
                            ?>
                            <img class="cart_img" src="_uploads/profile_product/thumb/<?php echo $row["p_id"] ?>.jpg" />
                        <?php } else { ?>
                            <img class="cart_img" src="_images/mp3-play.png" />	
    <?php } ?>
                    </td>
                    <td><a href="products_details.php?id=<?php echo $row["p_id"]; ?>"><?php echo $row["p_name"]; ?></a></td>
                    <td align="center">$<?php echo $row["p_price"]; ?></td>
                    <td align="center">$<?php echo $row["p_shipping"]; ?></td>
                    <td align="center" width="22%">
                        <p class="remove">
                            <a href="<?php echo "javascript:ConfrimMessage_Delete('shopping_cart.php?p_id=" . $row["id"] . "')"; ?>">Remove</a></p>
                        <p class="buy_now_5"><a href="order_confirmation.php?id=<?php echo $row['p_id']; ?>">Buy Now</a></p>
                    </td>
                </tr>				
                <?php
            }
            ?>
        </tbody>				
    </table> 
    <p style="text-align:right;"><a href="view_products.php?id=<?php echo $uid; ?>" class="button" style="float:left; margin:-5px 0px 5px 0px;" ">continue</a></p>
</div>
<?php
include('_includes/footer.php');
?>
