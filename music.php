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
        $sql = mysql_query("SELECT * FROM  tbl_products WHERE id='" . $_POST['p_id'] . "' AND content_type='1'");
        $producrt = mysql_fetch_assoc($sql);
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

        $sql = mysql_query("SELECT * FROM  tbl_shopping_cart WHERE 	p_id='" . $_POST['p_id'] . "' and uid='" . $uid . "'");
        $num_row = mysql_num_rows($sql);

        if ($num_row == 0) {
            insertData($data, $table);
            header("Location:music.php?op=a&Mid=" . $_GET['Mid'] . "");
        }
    } else {
        header("Location:music.php?op=cr&Mid=" . $_GET['Mid'] . "");
    }
}

include('_includes/meta.php');
?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Music Play</title>
<script type="text/javascript" src="<?php echo SITE_URL; ?>_script/jquery.min.js"></script>-->
<?php /* ?><script type="text/javascript" src="<?php echo SITE_URL; ?>_script/jquery.fancybox-1.3.4.pack.js"></script>
  <link type="text/css" rel="stylesheet" href="<?php echo SITE_URL; ?>_css/jquery.fancybox-1.3.4.css" />
  <link type="text/css" rel="stylesheet" href="<?php echo SITE_URL; ?>_css/new_theme/jquery-ui.css" />
  <script type="text/javascript" src="<?php echo SITE_URL; ?>_script/jquery.validate.min.js"></script>
  <script type="text/javascript" src="<?php echo SITE_URL; ?>_script/jwplayer.js"></script>
  <script type="text/javascript" src="<?php echo SITE_URL; ?>_script/jquery-ui.js"></script><?php */ ?>


<!--
        <style type="text/css">
        
        body {background-color:#CCCCCC;  }
        

        h2{
        font-family:Arial, Helvetica, sans-serif;
        color:#666666;
        border-bottom:4px solid #999999;
        }

    </style>
</head>
<body >-->
<h2>Music Play</h2>
<?php
if (isset($_GET['op'])) {
    ?>		
    <p class="msg">
        <?php
        if (isset($_GET['op']) AND ( $_GET['op'] == "a")) {
            echo "Music Added To Cart Sucessfully.";
        }
        ?>
    </p>
    <p class="err">
        <?php
        if (isset($_GET['op']) AND ( $_GET['op'] == "cr")) {
            echo "Please Login First To Add In Your Cart .";
        }
        ?>
    </p>
    <?php
}
if (isset($_GET['Mid'])) {
    ?>
    <div id="audioplayer"></div>
    <?php
    // echo $_GET['id'];
    $org_song = "_uploads/profile_music/" . $_GET['Mid'] . ".mp3";
    ?>
    <script type="text/javascript">
        jwplayer("audioplayer").setup({
            flashplayer: "<?php echo SITE_URL; ?>talents/player.swf",
            file: "<?php echo $org_song; ?>",
            'controlbar': 'bottom',
            'width': '245',
            'height': '24',
            'autostart': 'true'
        });
    </script>
<?php } ?>

<?php $data = getAnyTableWhereData("tbl_products", "AND ref_id='" . $_GET['Mid'] . "' "); ?>
<form action="" method="post">

    <input type="hidden" name="p_id" value="<?php echo $data['id']; ?>" />

    <?php
    if ($data['status'] == 1) {
        ?>
        <span class="price_product">Price : $<?php echo $data['product_price']; ?></span>	
        <input type="submit" class="music_pop_Add_Cart" value="Add To Cart" name="submit" />
        <?php
    }
    ?>

</form>				
<!--      
</body>
</html>

-->