<?php
include('_includes/application-top.php');

/* USER FORUM HEAR DATABASE QUERY FOR TOPIC */
$str = "SELECT * FROM  tbl_forum_topics order by tbl_forum_topics.id desc";
$str2 = mysql_query($str);
$number = mysql_num_rows($str2);
//$query=mysql_query($str);
$page_row_no = PAGE_ROW_NO;
$page_link_no = PAGE_LINK_NO;
$page = new PS_Pagination($connt, $str, $page_row_no, $page_link_no, $append = "");
$rs = $page->paginate();
echo mysql_error();

include('_includes/header.php');
?>
<script type="text/javascript">
    function back()
    {
        window.history.back();
    }
</script>
<div class="content">
    <!--<h1>Forum</h1>-->
    <h1><?php //echo GetPageHeading('FORUM');   ?>Forum<h1>
            <p style="text-align:right"><a href="javascript:back(0)" class="button" style="float:left; margin:-5px 0px 5px 0px;" onclick="return back();">Back</a></p>
            <?php
            if (isset($_GET['op'])) {
                ?>
                <br /><p class="err">
                    <?php
                    if (isset($_GET['op']) AND ( $_GET['op'] == "d")) {
                        echo "Your Topic Deleted Sucessfully.";
                    }
                    ?>
                </p>
                <?php
            }
            //echo '<pre>';print_r($_SESSION);
            if ((isset($_SESSION['user_login']) AND ( $_SESSION['user_login'] == 1)) || (isset($_SESSION['talent_login']) AND ( $_SESSION['talent_login'] == 1))) {
                ?>
                <p style="text-align:right"><a href="add-forum-topic.php" class="button">Add Topic</a></p>
                <?php
            }
            ?>

            <table cellpadding="8" cellspacing="0" class="Tabforumtopic" width="100%">
                <?php
                if ($number <= 0) {
                    ?>
                    <p class="err"><?php echo "No Record Found!"; ?></p>
                    <?php
                } else {
                    ?>
                    <thead>
                        <tr>
                            <th style="text-align:left;">Topic</th>
                            <th align="center">Replies</th>
                            <th align="center">Views</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    }
                    while ($row = mysql_fetch_assoc($rs)) {
                        $SQL = mysql_query("SELECT * FROM  tbl_forum_reply WHERE forum_id=" . $row["id"] . " ");
                        $number = mysql_num_rows($SQL);
                        ?>
                        <tr>
                            <td align="left">
                                <?php
                                $sql_view_cnt = "select view_count from  tbl_forum_topics where id='" . $row["id"] . "'";
                                $sql_query_view = mysql_query($sql_view_cnt);
                                $der = mysql_fetch_assoc($sql_query_view);
                                $view_cnt_pre = $der['view_count'];
                                $view_cnt = $view_cnt_pre + 1;
                                ?>
                                <a href="view_forum_topic.php?id=<?php echo $row["id"]; ?>&view=<?php echo $view_cnt; ?>">
                                    <img src="_images/FORUME.png" height="50" width="50" title="View Topic" /></a>
                                <p class="forum_head">
                                    <a href="view_forum_topic.php?id=<?php echo $row["id"]; ?>&view=<?php echo $view_cnt; ?>"><?php echo $row["forum_topic"]; ?></a>
                                    <br/>Started by lovinglinux,  <?php echo date('F jS, Y h:i:s', strtotime($row["post_date"])); ?></p>
                            </td>
                            <td align="center">
                                <p style="text-align:center;"><?php echo $number; ?></p>
                            </td>
                            <td align="center">
                                <p style="text-align:center;"><?php echo $row["view_count"]; ?></p>
                            </td>
                        </tr>	
                        <?php
                    }
                    ?>			
                </tbody>  	
            </table>
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

            <?php
            include('_includes/footer.php');
            ?>

