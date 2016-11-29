<?php
include('_includes/application-top.php');

function show_video($video_type, $video_id) {

    if ($video_type == 1) {     // means it is a file type
        $src = '_uploads/profile_video/' . $video_id . '.mp4';
        $output = '<video  width="315" height="220" controls>
                    <source src="' . $src . '" type="video/mp4">
                    <source src="movie.ogg" type="video/ogg">
                  Your browser does not support the video tag.
                  </video>';
    } else if (!empty($video_id)) {        // there is a video code
        global $connt, $selt;
        $result = mysqli_query($link, "SELECT * FROM  tbl_profile_videos WHERE id='" . $video_id . "' ");
        $data = mysqli_fetch_assoc($result);
        //print_r($data);
        $output = preg_replace('/width=("|\')(\d+|\d+px|)("|\')/i', 'width="315"', $data['video_code']);
        $output = preg_replace('/height=("|\')(\d+|\d+px|)("|\')/i', 'height="220"', $output);
    }
    return $output;
}

$query = mysqli_query($link, "SELECT * FROM tbl_profile_videos WHERE user_id='" . $_GET['id'] . "' AND tbl_profile_videos.status='1' ORDER BY tbl_profile_videos.id DESC");
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
        $sql = mysqli_query($link, "SELECT * FROM  tbl_products WHERE id='" . $_POST['p_id'] . "' AND content_type='2'");
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
        header("Location:profile-video.php?id=" . $_GET['id'] . "&op=cr ");
    }
}
include('_includes/header.php');
?>

<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });

    $(document).ready(function () {
        $("a#video").fancybox({
            'width': 400,
            'height': 580,
            'scrolling': 'no',
            'autoScale': true,
            'titlePosition': 'over',
            'transitionIn': 'none',
            'transitionOut': 'none'
        });
    });

    function back()
    {
        window.history.back();
    }
</script>
<div class="content">
    <h2>All Videos</h2>
    <?php if (isset($_GET['op'])) {
        ?>
        <p class="err">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "cr")) {
                echo "Please Login First To Add This Video In Your Cart .";
            }
            ?>
        </p>
    <?php } ?>
    <p style="text-align:right"><a href="javascript:back(0)" class="button" style="float:left; margin:-5px 0px 0px 0px;" onclick="return back();">Back</a></p>
    <ul>
        <?php
        while ($row = mysqli_fetch_array($query)) {
            ?>
            <?php $data = getAnyTableWhereData("tbl_products", "AND ref_id='" . $row["id"] . "' AND content_type='2' "); ?>
            <li class="b_image">

                <p class="title"><label><?php echo $row["video_name"]; ?></label></p>		
                <!--              
                <a id="video" <?php if ($row["video_type"] == 1) { ?>href="talents/video_play.php?filename=_uploads/profile_video/<?php echo $row["id"]; ?>.mp4" <?php } else {
                ?> href="talents/video_play.php?id=<?php
                    echo $row["id"];
                }
                ?>">
                -->
                <?php echo show_video($row["video_type"], $row["id"]) ?>				
                <?php
                if ($data['status'] == 1) {
                    ?>			

                    <?php
                }
                ?>	

                <form action="" method="post">

                    <input type="hidden" name="p_id" value="<?php echo $data['id']; ?>" />
                    <?php
                    if ($data['status'] == 1) {
                        ?>
                        <span class="price_product">Price : $<?php echo $data['product_price']; ?></span>			
                        <input type="submit" class="video_Add_Cart" value="Add To Cart" name="submit" />
                        <?php
                    }
                    ?>			
                </form>	
                <?php if (is_favorite($row["id"], 'video') == false) { ?>
                    <form action="<?php echo BASE_URL ?>member/add_product_to_favorite.php" method="get">
                        <input type="hidden" name="item_id" value="<?php echo $row["id"]; ?>" />
                        <input type="hidden" name="item_type" value="video" />	
                        <input type="submit" value="Add To Favorite" />
                    </form>
                    <br>
                <?php } ?>
            </li> 
            <?php
        }
        ?>
    </ul>
    <div style="clear:both;"></div>
</div>

<?php
include('_includes/footer.php');
?>
