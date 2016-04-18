<?php
include('include/application_top.php');
cmslogin();
?>
<?php include('include/header.php'); ?>

<h1> SHOW ALL Basic MEMBER'S </h1>
<?php
//$query = "SELECT * FROM tbl_users ORDER BY id DESC";
$query = "SELECT * FROM tbl_users WHERE TYPE = '0' ORDER BY id DESC";
//$query_row = mysql_query($query);

$page = new PS_Pagination($connection, $query, $rows_per_page = 32, $link_page = 200, $append = "");
$rs = $page->paginate();
?>
<div id="member">
    <ul>
        <?php
        if (mysql_num_rows($rs) > 0) {
            while ($row = mysql_fetch_array($rs)) {
                ?>
                <li class="b_image">
                    <p style="text-align:center;">
                        <a href="details.php?id=<?php echo $row['id']; ?>">

                            <?php
                            $image = "../_uploads/user_photo/" . $row["id"] . ".jpg";

                            if (file_exists($image)) {
                                ?>
                                <img src="<?php echo $image; ?>" height='152' width='120'/>
        <?php } else { ?>

                                <img src="images/dummy.png" height='152' width='120'/>
                            <?php }
                            ?>
                        </a>
                    </p>


                    <p style="text-align:center; margin-top:-2px;">	<a href="details.php?id=<?php echo $row['id']; ?>" <?php if ($row['new_mac_req'] == 1) { ?> style="color:#FF0000; font-weight:bold;" <?php } ?>> <?php echo $row["username"]; ?></a></p>

                    <p style="text-align:center; margin-top:-2px;"> Joined On : <a href="details.php?id=<?php echo $row['id']; ?>"> <?php echo $row["join_date"]; ?>: Time: <?php echo $row["joining_time"]; ?></a></p>

                    <p style="text-align:center; margin-top:-2px;"> <a href="details.php?id=<?php echo $row['id']; ?>">	<?php
                            if ($row['type'] == 1) {
                                echo "Talent";
                            } else {
                                echo "Member";
                            }
                            ?>
                        </a></p>  <br />

                </li>
                <?php
            }
        } else {
            echo "<br/><br/><br/><h1> No Record Found. </h1>";
        }
        ?>
    </ul>
    <div style="clear:both;"></div>
</div>

<div id="pagination">
    <?php
    echo $page->renderFirst();
//Display the link to previous page: <<
    echo $page->renderPrev();

//Display page links: 1 2 3
    echo $page->renderNav();

//Display the link to next page: >>
    echo $page->renderNext();

//Display the link to last page: Last
    echo $page->renderLast();
    ?>
</div>
<div style="clear:both;"></div>

<?php include('include/footer.php'); ?>
