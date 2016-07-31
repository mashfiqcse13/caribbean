<?php
include('_includes/application-top.php');
CheckLoginForum();

if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
    $uid = $_SESSION['talent_id'];
} elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
    $uid = $_SESSION['user_id'];
} else {
    $uid = "";
}

/* * ************************************************************************
  INSERT DATA tbl_orders
 * ************************************************************************* */

$query4 = mysqli_query($link,"SELECT p.id as prid,p.uid,p.product_price,p.shipping, p.p_shipping, u.id 
								
		                     FROM tbl_products as p LEFT OUTER JOIN tbl_users AS u ON u.id=p.uid WHERE p.id='" . $_GET['id'] . "'");

$data = mysqli_fetch_array($query4);

$total = ($data['product_price'] + $data['p_shipping']);

$product_id = $data['prid'];

if ((isset($_POST['submit'])) && ($_POST['submit'] == "Make Payment")) {
    $data = array(
        "order_date" => date('Y-m-d H:i:s'),
        "uid" => $uid,
        "seller_id" => $data['uid'],
        "p_id" => $data['prid'],
        "p_amt" => $data['product_price'],
        "shipping_amt" => $data['p_shipping'],
        "total_amt" => $total,
        "order_status" => '0',
        "payment_status" => '0'
    );
    //echo '<pre>';print_r($data);die;
    $table = "tbl_orders";
    insertData($data, $table);

    $oid = mysqli_insert_id($link);
    $_SESSION['OID'] = $oid;

    if ($_POST['ordershipping'] != 0) {
        $data = array(
            "order_id" => $oid,
            "name" => mysqli_real_escape_string( $link ,trim($_POST['name'])),
            "address" => mysqli_real_escape_string( $link ,trim($_POST['address'])),
            "zip" => mysqli_real_escape_string( $link ,trim($_POST['zip'])),
            "city" => mysqli_real_escape_string( $link ,trim($_POST['city'])),
            "state" => mysqli_real_escape_string( $link ,trim($_POST['state'])),
            "country" => mysqli_real_escape_string( $link ,trim($_POST['country']))
        );
        //echo '<pre>';print_r($data);die;

        $table = "tbl_order_shipping";

        insertData($data, $table);
    }
    $sql = "DELETE " .
            "FROM tbl_shopping_cart " .
            "WHERE 1=1 AND uid=" . $uid . " AND p_id=" . $_GET['id'] . " ";
    $result = mysqli_query($link,$sql) or die(mysqli_error($link,));
    header("Location:paypal.php?p=" . $product_id . "&o=" . $oid);
}



include('_includes/header.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#s_details').validate()
    });
</script>

<div class="content"><!--START CLASS contant PART -->

    <h2>Order details</h2>		

    <div class="form_class"><!--START CLASS form_class PART -->

        <div class="profile_page_wraper"><!--START DIV CLASS profile_page_wraper-->	
            <form  action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $_GET['id']; ?>" method="post" name="s_details" id="s_details">
                <?php
                $query = mysqli_query($link,"SELECT * FROM tbl_products WHERE id='" . $_GET['id'] . "'");
                $row = mysqli_fetch_array($query);
                ?>


                <h1><?php echo $row['product_name']; ?></h1> 
                <div class="product_name">

                    <?php
                    $image = "_uploads/profile_product/thumb/" . $row["id"] . ".jpg";
                    if (file_exists($image)) {
                        ?>
                        <img src="_uploads/profile_product/thumb/<?php echo $row["id"] ?>.jpg" />
                    <?php } else { ?>
                        <img src="_images/mp3-play.png" />	
<?php } ?>

                    <div class="product_detailss"><?php echo substr($row['product_details'], 0, 200); ?></div>
                </div>


                <input type="hidden" name="orderpay" value="1" />
                <?php
                if (($row['shipping'] == 0) || (($row['content_type'] == 0) && (($row['shipping'] == 0) || ($row['shipping'] == 1)))) {

                    if (($row['content_type'] == 2 && $row['shipping'] == 0) || ($row['content_type'] == 1)) {
                        
                    } else {
                        ?>

                        <br /><br /><hr style="border:2px solid #FF9900;"/><br />


                        <h1>Shipping Details</h1>


                        <p><label for="name">Name</label>
                            <input type="text" name="name" value="" class="required"/>
                        </p>

                        <p><label for="address">Address</label>
                            <input type="text" name="address" value="" class="required"/>
                        </p>

                        <p><label for="zip">Zip</label>
                            <input type="text" name="zip" value="" />
                            <span class="form_nots1">This field is optional.</span>
                        </p>

                        <p><label for="city">City</label>
                            <input type="text" name="city" value="" class="required"/>
                        </p>

                        <p><label for="state">State</label>
                            <input type="text" name="state" value="" class="required"/>
                        </p>

                        <p><label for="country">Country</label>
                            <select name="country" id="country" class="required">
                                <?php
                                //for ($i=0;$i<=239;$i++) {
                                foreach ($countries_array as $key => $value) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php if (isset($country)) {
                                    if ($key == $country) {
                                            ?>selected<?php }
                        }
                                    ?>><?php echo $value; ?></option>

            <?php
        }
        ?>
                            </select>
                        </p>
                        <input type="hidden" name="ordershipping" value="1" />
                        <?php
                    }
                } elseif (($row['content_type'] == 2 && $row['shipping'] == 1) || ($row['content_type'] == 4 && $row['shipping'] == 1) || ($row['content_type'] == 3 && $row['shipping'] == 1)) {
                    ?>
                    <br /><br /><hr style="border:2px solid #FF9900;"/><br />


                    <h1>Shipping Details</h1>


                    <p><label for="name">Name</label>
                        <input type="text" name="name" value="" class="required"/>
                    </p>

                    <p><label for="address">Address</label>
                        <input type="text" name="address" value="" class="required"/>
                    </p>

                    <p><label for="zip">Zip</label>
                        <input type="text" name="zip" value="" />
                        <span class="form_nots1">This field is optional.</span>
                    </p>

                    <p><label for="city">City</label>
                        <input type="text" name="city" value="" class="required"/>
                    </p>

                    <p><label for="state">State</label>
                        <input type="text" name="state" value="" class="required"/>
                    </p>

                    <p><label for="country">Country</label>
                        <select name="country" id="country" class="required">
                            <?php
                            //for ($i=0;$i<=239;$i++) {
                            foreach ($countries_array as $key => $value) {
                                ?>
                                <option value="<?php echo $key; ?>" <?php if (isset($country)) {
                                    if ($key == $country) {
                                        ?>selected<?php }
                }
                                ?>><?php echo $value; ?></option>

                        <?php
                    }
                    ?>
                        </select>
                    </p>
                    <input type="hidden" name="ordershipping" value="1" />
                    <?php
                } else {
                    ?>
                    <input type="hidden" name="ordershipping" value="0" />
    <?php
}
?>
                <br /><br /><hr style="border:2px solid #FF9900;"/><br />



                <h1>Payment Details</h1>

                <p>Product Price:&nbsp;$<?php echo number_format($row['product_price'], 2); ?></p><br />
                <p>Product Shipping:&nbsp;$<?php echo $row['p_shipping']; ?></p><br />

                <p>Total = &nbsp;$<?php echo $total = number_format($row['product_price'] + $row['p_shipping'], 2); ?></p>

                <input type="submit" name="submit" value="Make Payment" class="button"/>
            </form>	
            <br /><br /><hr style="border:2px solid #FF9900;"/><br /> 
            &nbsp;&nbsp;&nbsp;<!--<input type="submit" name="submit" value="Make Payment" class="button" />-->

        </div><!--END DIV CLASS profile_page_wraper-->	

    </div><!--END CLASS form_class PART -->


</div><!--END CLASS contant PART -->

<?php include('_includes/footer.php'); ?>