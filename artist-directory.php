<?php
include('_includes/application-top.php');
$sql = "SELECT talent FROM tbl_talents WHERE ID='" . $_GET['id'] . "' ";
$result = mysql_query($sql);
$rows = mysql_fetch_assoc($result);
//print_r($rows);


include('_includes/header.php');
?>
<script type="text/javascript">
    function back()
    {
        window.history.back();
    }
</script>
<div class="content"><!--START CLASS contant PART -->
    <?php
    if ($_GET['id'] == 1) {
        $str = "SELECT * FROM tbl_users WHERE FIND_IN_SET( " . $_GET['id'] . " , talent ) or FIND_IN_SET( 4 , talent ) or FIND_IN_SET( 8 , talent ) or FIND_IN_SET( 9 , talent )";
        ?>
        <h2>All Musicans, Literatures, Singers, Poets</h2>
        <?php
    }
    if ($_GET['id'] == 5) {
        $str = "SELECT * FROM tbl_users WHERE FIND_IN_SET( " . $_GET['id'] . " , talent ) or FIND_IN_SET( 10 , talent )";
        ?>
        <h2>All Models, Sports</h2>
        <?php
    }
    if ($_GET['id'] == 7) {
        $str = "SELECT * FROM tbl_users WHERE FIND_IN_SET( " . $_GET['id'] . " , talent ) or FIND_IN_SET( 6 , talent )";
        ?>
        <h2>All Actors, Comedians</h2>
        <?php
    }
    if ($_GET['id'] == 2) {
        $str = "SELECT * FROM tbl_users WHERE FIND_IN_SET( " . $_GET['id'] . " , talent ) or FIND_IN_SET( 3 , talent )";
        ?>
        <h2>All Arts, Crafts</h2>
        <?php
    }
    $query = mysql_query($str);
    ?>

    <p style="text-align:right"><a href="javascript:fans(0)" class="button" style="float:left; margin:-5px 0px 0px 0px;" onclick="return back();">Back</a><br />

    <ul>
        <?php
        while ($rows = mysql_fetch_assoc($query)) {
            ?>
            <li class="b_image">

                <a href="profile-details.php?username=<?php echo $rows['username']; ?>">
                    <?php
                    $file_name = "_uploads/user_photo/" . $rows["id"] . ".jpg";
                    if (file_exists($file_name)) {
                        echo "<img  src='" . $file_name . "' height='150' width='120' />";
                    } else {
                        echo "<img src='_images/dummy.png' height='150' width='120'/>";
                    }
                    ?>

                </a>
                <p style="text-align:center; margin-top:-2px;"><a href="profile-details.php?username=<?php echo $rows['username']; ?>"><?php echo $rows['username']; ?></a></p>
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
