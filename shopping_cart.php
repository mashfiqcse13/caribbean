<?php
include('_includes/application-top.php');
CheckLoginForum();
if (isset($_GET['p_id'])) {
    $sql = "delete from tbl_shopping_cart where id='" . $_GET['p_id'] . "'";
    mysql_query($sql);
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
    if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
        $uid = $_SESSION['talent_id'];
    } elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
        $uid = $_SESSION['user_id'];
    } else {
        $uid = "";
    }
    //echo $uid;
    // $result=mysql_query("SELECT * FROM tbl_shopping_cart WHERE uid=".$uid."");
    $result = mysql_query("SELECT tbl_shopping_cart.*, tbl_users.id AS t_u_id, tbl_users.age FROM tbl_shopping_cart LEFT OUTER JOIN tbl_users ON 

							 						 tbl_shopping_cart.uid=tbl_users.id WHERE tbl_shopping_cart.uid='" . $uid . "'");

    $number = mysql_num_rows($result);
    //$data=mysql_fetch_assoc($result);
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
            while ($row = mysql_fetch_assoc($result)) {
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

                        <?php
                        $age1 = explode('-', $row['age']);

                        $age = $age1[2] . '/' . $age1[1] . '/' . $age1[0];

                        //$d1 = new DateTime(date('Y-m-d'));
                        //$d2 = new DateTime($age); 
                        //$diff = $d2->diff($d1);
                        //$y=$diff->y;
                        //echo $y=age_from_dob($row['age']);
                        //date in mm/dd/yyyy format; or it can be in other formats as well
                        $birthDate = $age;
                        //explode the date to get month, day and year
                        $birthDate = explode("/", $birthDate);
                        //get age from date or birthdate
                        $y = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));


                        if ($y > "18") {
                            ?>
                            <p class="buy_now_5"><a href="order_confirmation.php?id=<?php echo $row['p_id']; ?>">Buy Now</a></p>
                            <?php
                        } else {
                            echo "You must be above 18 years to Buy.";
                        }
                        ?>



                    </td>
                </tr>				
                <?php
            }
            ?>
        </tbody>				
    </table> 
    <p style="text-align:right;"><a href="view_products.php?id=<?php echo $uid; ?>" class="button" style="float:left; margin:-5px 0px 5px 0px;">continue</a></p>
</div>
<?php
include('_includes/footer.php');
?>
