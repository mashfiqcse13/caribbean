<?php
include('../_includes/application-top.php');
ChecknontalentLogin();
include('../_includes/header.php');
?> 
<div class="content"><!--START CLASS contant PART -->

    <h2>Order History</h2>
    <p style="text-align:right"><a href="member.php" class="button" style="float:left; margin:-5px 0px 5px 0px;" >Back</a></p>
    <div class="form_class"><!--START CLASS form_class PART -->
        <?php
        //echo $sql_query="SELECT * FROM tbl_orders WHERE uid='".$_SESSION['user_id']."'";
        //$query=mysql_query("SELECT * FROM tbl_orders WHERE uid='".$_SESSION['user_id']."'");
        //$query=mysql_query("SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id as prid,p.product_name FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON
        //p.id=tbl_orders.p_id WHERE tbl_orders.uid='".$_SESSION['user_id']."' AND (tbl_orders.order_status='1' OR tbl_orders.order_status='2')  ORDER BY tbl_orders.id DESC");
        $query = mysql_query("SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id as prid,p.product_name FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON
			p.id=tbl_orders.p_id WHERE tbl_orders.uid='" . $_SESSION['user_id'] . "' AND  tbl_orders.order_status='1'  ORDER BY tbl_orders.id DESC");

        //echo "SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id as prid,p.product_name FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON
			//p.id=tbl_orders.p_id WHERE tbl_orders.uid='".$_SESSION['user_id']."' AND  tbl_orders.order_status='1'  ORDER BY tbl_or