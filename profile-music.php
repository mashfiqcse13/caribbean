<?php
include('_includes/application-top.php');

function show_music($music_id) {
    $src = "_uploads/profile_music/" . $music_id . ".mp3";
    $output = '<audio controls>
        <source src="' . $src . '" type="audio/ogg">
      Your browser does not support the audio element.
      </audio>';
    return $output;
}

$query = mysqli_query($link, "SELECT * FROM tbl_profile_music WHERE user_id='" . $_GET['id'] . "' AND tbl_profile_music.status='1' ORDER BY tbl_profile_music.id DESC");
//$treu=mysqli_fetch_assoc($query);
//print_r($treu);


if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Add To Cart')) {

    if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
        $uid = $_SESSION['talent_id'];
    } elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
        $uid = $_SESSION['user_id'];
    } else {
        $uid = "";
    }

    if ($uid != "") {
        $sql = mysqli_query($link, "SELECT * FROM  tbl_products WHERE id='" . $_POST['p_id'] . "' AND content_type='1'");
        $producrt = mysqli_fetch_assoc($sql);
        //print_r($producrt);

        $data = array(
            "uid" => $uid,
            "p_id" => $producrt['id'],
            "p_name" => $producrt['product_name'],
            "p_price" => $producrt['product_price'],
            "p_shipping" => $producrt['p_shipping'],
            "add_date" => date('y-m-d h:i:s')
        );
        $table = "tbl_shopping_cart";

        $sql = mysqli_query($link, "SELECT * FROM  tbl_shopping_cart WHERE 	p_id='" . $_POST['p_id'] . "' and uid='" . $uid . "'");
        $num_row = mysqli_num_rows($sql);

        if ($num_row == 0) {
            insertData($data, $table);
            header("Location:shopping_cart.php?op=a");
        }
    } else {
        header("Location:profile-music.php?id=" . $_GET['id'] . "&op=cr ");
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
    <?php if (isset($_GET['op'])) {
        ?>
        <p class="err">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "cr")) {
                echo "Please Login First To Add This Music In Your Cart .";
            }
            ?>
        </p>
    <?php } ?>
    <p style="text-align:right">
        <a href="javascript:back(0)" class="button" style="float:left; margin:-5px 0px 0px 0px;" onclick="return back();">Back</a>
    </p>
    <table width="100%">
        <tr style="background-color: rgb(202, 201, 201);">
            <th style="padding: 15px 10px;">Name of the track</th>
            <th>Track</th>
            <th>Price</th>
            <th>Action</th>
            <th>Share</th>
            <th style="width: 28%;">Description</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_array($query)) {
            $sql13 = mysqli_query($link, "SELECT * FROM  tbl_products WHERE ref_id='" . $row['id'] . "' AND content_type='1' ");
            $res13 = mysqli_fetch_assoc($sql13);
            $row13 = mysqli_num_rows($sql13);

            if ($res13['id'] != '') {
                $pid13 = $res13['id'];
            } else {
                $pid13 = 0;
            }
            ?><?php $data = getAnyTableWhereData("tbl_products", "AND ref_id='" . $row["id"] . "' AND content_type='1' "); ?>
            <tr>
                <td><?php echo $row["music_title"]; ?></td>
                <td><?php echo show_music($row['id']) ?></td>
                <td><?php
                    if ($data['status'] == 1) {
                        ?>			
                        <span class="price_product">$<?php echo $data['product_price']; ?></span>
                        <?php
                    }
                    ?>	</td>
                <td>	

                    <?php if ($data['status'] == 1) { ?>		
                        <form action="" method="post">
                            <input type="hidden" name="p_id" value="<?php echo $data['id']; ?>" />	
                            <input type="submit" class="m_Add_Cart" value="Add To Cart" name="submit" />			
                        </form>
                    <?php } else { ?>	
                        <a class="music_download" href="<?php echo SITE_URL . "_uploads/profile_music/" . $row['id'] . ".mp3"; ?>" >
                            Download 
                        </a>
                    <?php } ?>		
                    <?php if (is_favorite($row["id"], 'music') == false) { ?>
                        <form action="<?php echo BASE_URL ?>member/add_product_to_favorite.php" method="get">
                            <input type="hidden" name="item_id" value="<?php echo $row["id"]; ?>" />
                            <input type="hidden" name="item_type" value="music" />	
                            <input type="submit" value="Add To Favorite" />
                        </form>	
                        <br>
                    <?php } ?>
                </td>
                <td><div id="share">
                        <!-- AddToAny BEGIN -->
                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                            <a class="a2a_dd" href="http://www.addtoany.com/share_save"></a>
                            <a class="a2a_button_facebook"></a>
                            <a class="a2a_button_twitter"></a>
                            <a class="a2a_button_google_plus"></a>
                        </div>
                        <script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
                        <!-- AddToAny END -->
                    </div>
                </td>
                <td><?php echo nl2br(substr($row["music_details"], 0, 230)); ?></td>
            </tr>>
                    <!--<a onclick="return popitup('music.php?Mid=<?php echo $row['id']; ?>&Pid=<?php echo $pid13; ?>')" style="cursor:pointer">-->

            <?php
        }
        ?></table>
    <!--</ul>-->
</div>



<?php
include('_includes/footer.php');
?>
