<?php
$query_product = "SELECT tbl_users.*, tbl_products.*,tbl_products.id AS p_id FROM tbl_users LEFT OUTER JOIN 
														tbl_products ON tbl_users.id=tbl_products.uid WHERE username ='" . $_GET['username'] . "' AND tbl_products.status='1'  
														AND content_type=0 ORDER BY tbl_products.id DESC LIMIT 0, 2 ";
$query_product_ro = mysqli_query($link,$query_product);
$query_product_ro_2 = mysqli_query($link,$query_product);
$row_product1 = mysqli_fetch_assoc($query_product_ro_2);
//print_r($row_product);

if ((mysqli_num_rows($query_product_ro) > 0)) {
    ?>			
    <div class="mystore">
        <h2>Products</h2>
        <?php
        while ($row_product = mysqli_fetch_assoc($query_product_ro)) {
            ?>
            <div class="store_detail">
                <div class="store_detail_left"> 
                    <a href="products_details.php?id=<?php echo $row_product['p_id']; ?>" title="View Product Details">
                        <img src="_uploads/profile_product/thumb/<?php echo $row_product['p_id']; ?>.jpg" width="100" />
                    </a>
                </div>
                <div class="store_detail_right">
                    <a href="products_details.php?id=<?php echo $row_product['p_id']; ?>" title="View Product Details">
                        <h4><?php echo $row_product['product_name']; ?></h4>
                    </a>
                    <span class="pspan">$<?php echo $row_product['product_price']; ?></span> 
                    <p class="product_details">
                        <a href="products_details.php?id=<?php echo $row_product['p_id']; ?>" title="View Product Details">Product Details</a>
                    </p>

                </div><div class="clear"></div>
            </div>
            <?php
        }
        ?>
        <div class="storebtn_top_spece">
            <a class="profile_btn" href="view_products.php?id=<?php echo $row_product1['uid']; ?>">View All products</a> 
        </div>
    </div>
<?php } ?>