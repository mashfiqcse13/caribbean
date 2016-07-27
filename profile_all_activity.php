<?php
include('_includes/application-top.php');

if ((isset($_GET['id'])) && ($_GET['id'] != '')) {
    $query = mysqli_query($link,"SELECT * FROM tbl_users WHERE id='" . $_GET['id'] . "'");
    $whereclause = "u.id='" . $_GET['id'] . "' ORDER BY ac.id DESC";
    $_SESSION['ACT_UID'] = $_GET['id'];
} else {
    $query = mysqli_query($link,"SELECT * FROM tbl_users WHERE id='" . $_SESSION['ACT_UID'] . "'");
    $whereclause = "u.id='" . $_SESSION['ACT_UID'] . "' ORDER BY ac.id DESC";
    $_SESSION['ACT_UID'] = $_SESSION['ACT_UID'];
}

$rowss = mysqli_fetch_assoc($query);

$activity_query = "SELECT ac.id AS ACID,ac.user_id,ac.activity,ac.activity_time, u.id AS UID,u.first_name,u.last_name FROM  tbl_user_activity AS ac LEFT OUTER JOIN tbl_users AS u ON                 u.id=ac.user_id WHERE " . $whereclause;

include('_includes/header.php');
?>
<div class="content"><!--START DIV CALSS content-->
    <h2>ALL Activity</h2>
    <p style="text-align:right">
        <a href="<?php echo SITE_URL; ?>profile-details.php?username=<?php echo $rowss['username']; ?>" class="button" style="float:left; margin:-5px 0px 0px 0px;" onclick="return      back();">Back</a>
    </p><br />
    <div class="profile_page_wraper"><!--START DIV CLASS profile_page_wraper-->			
        <div class="activity_div_profile"><!--START DIV comment_div_profile-->
            <?php
            $page_row_no = 50;
            $page_link_no = 50;
            $page = new PS_Pagination($connt, $activity_query, $page_row_no, $page_link_no, $append = "");
            $rs = $page->paginate();
            ?>
            <ul>
                <?php
                while ($row_activity = mysqli_fetch_assoc($rs)) {
                    ?>
                    <li>
                        <h3><?php echo $row_activity['activity']; ?></h3>
                        <p><?php echo $row_activity['activity_time']; ?></p>	
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div><!--END DIV comment_div_profile-->
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
    </div><!--END DIV CLASS profile_page_wraper-->
</div><!--END DIV CALSS content-->
<?php
include('_includes/footer.php');
?>

