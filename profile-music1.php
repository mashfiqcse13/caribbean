<?php
include('_includes/application-top.php');

$query = mysql_query("SELECT * FROM tbl_profile_music WHERE user_id='" . $_GET['id'] . "' AND tbl_profile_music.status='1' ORDER BY tbl_profile_music.id DESC");
//$treu=mysql_fetch_assoc($query);
//print_r($treu);


if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Add To Cart')) {
    $sql = mysql_query("SELECT * FROM  tbl_products WHERE id='" . $_POST['p_id'] . "'");
    $producrt = mysql_fetch_assoc($sql);
    //print_r($producrt);

    if (isset($_SESSION["talent_id"])) {
        $uid = $_SESSION["talent_id"];
    } else if (isset($_SESSION["user_id"])) {
        $uid = $_SESSION["user_id"];
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
        header("Location:shopping_cart.php?op=a");
    }
}
include('_includes/header.php');
?>

<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });

    $(document).ready(function () {

        $('a#audio').fancybox();

    });

    function back()
    {
        window.history.back();
    }
</script>
<script type="text/javascript">
    function popitup(url) {
        //var Url="music.php?id="+Mid+"&pid="+Pid;
        newwindow = window.open(url, 'name', 'height=50,width=245');
        if (window.focus) {
            newwindow.focus()
        }
        return false;
    }
</script>
<div class="content">
    <h2>All Musics</h2>
    <p style="text-align:right"><a href="javascript:void(0)" class="button" style="float:left; margin:-5px 0px 0px 0px;" onclick="return back();">Back</a></p>
    <ul class="a_music">
        <?php
        while ($row = mysql_fetch_array($query)) {
            $sql13 = mysql_query("SELECT * FROM  tbl_products WHERE ref_id='" . $row['id'] . "' ");
            $res13 = mysql_fetch_assoc($sql13);
            $row13 = mysql_num_rows($sql13);

            if ($res13['id'] != '') {
                $pid13 = $res13['id'];
            } else {
                $pid13 = 0;
            }
            ?>
            <li class="a_music_li">
                <a onclick="return popitup('music.php?Mid=<?php echo $row['id']; ?>&Pid=<?php echo $pid13; ?>')">
                    <?php /* ?><a id="audio" href="talents/music_play.php?filename=_uploads/profile_music/<?php echo $row["id"];?>.mp3"><?php */ ?>
                    <div style="margin-top:20px; display:inline-block;">
                        <div class="ply_btn" ></div>
                        <span class="music_title"><?php echo $row["music_title"]; ?></span></div>
                </a>

                <?php $data = getAnyTableWhereData("tbl_products", "AND ref_id='" . $row["id"] . "' "); ?>
                <form action="" method="post">

                    <input type="hidden" name="p_id" value="<?php echo $data['id']; ?>" />

                    <?php
                    if ($data['status'] == 1) {
                        ?>


                        <input type="submit" class="m_Add_Cart" value="Add To Cart" name="submit" />



                        <?php
                    }
                    ?>

                </form>				

                <div class="music_details">
                    <?php echo $row["music_details"]; ?>


                </div>
                <div class="clear"></div>   			
            </li>

            <?php
        }
        ?>
    </ul>
</div>



<?php
include('_includes/footer.php');
?>
