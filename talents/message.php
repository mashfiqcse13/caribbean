<?php
include('../_includes/application-top.php');
ChecktalentLogin();
if (isset($_POST['delete']) and $_POST['delete'] != "") {
    if (isset($_POST["check"])) {
        foreach ($_POST["check"] as $row) {
            $str = "DELETE FROM tbl_msg WHERE id='" . $row . "'";
            mysql_query($str);
            $MSG = "Record Deleted Successfully.";
        }
    }
}
?>
<?php include('../_includes/header.php'); ?>

<script type="text/javascript">
    /*	$(document).ready(function(){
     $('tr').click(function() {
     
     $(this).closest('tr').toggleClass("highlight", this.checked);
     $(this).css('backgroundColor', '#FFCC00');
     });
     
     });*/
    $(document).ready(function () {
        $("#delete").validate({
        });
    });
</script>



<div class="content"><!--DIV START content-->

    <h1>Messages</h1>

    <a href="member.php" class="button" style="float:left; margin:-5px 0px 5px 0px;">Back</a> <br />

    <!--<div class="form_class">DIV START form_class-->

    <?php
    if ((isset($_SESSION["talent_id"])) && ($_SESSION["talent_id"] != 0)) {
        $uid = $_SESSION["talent_id"];
    }

    $query = "SELECT tbl_msg.id AS m_id, tbl_msg.*,tbl_users.id AS tbl_user_id, tbl_users.first_name, tbl_users.last_name, tbl_users.type

								FROM tbl_msg LEFT OUTER JOIN tbl_users
							
								ON tbl_msg.from_id = tbl_users.id  WHERE tbl_msg.to_id ='" . $uid . "'  ORDER BY tbl_msg.id DESC ";

    $query_msg = mysql_query($query);

    $number = mysql_num_rows($query_msg);

    if ($number <= 0) {
        echo "<p class='err' style='margin-top:10px;'>NO Record Found</p>";
    } else {
        //$number = mysql_num_rows
        ?>
        <table cellpadding="0" cellspacing="0" class="TabUIRecords" style="margin-top:10px;">
            <thead>
                <tr style="">
                    <th align="center" style="width:5%;">Action</th>

                    <th  style="text-align:left;">Name</th>
                    <th style="text-align:left;">Subject</th>
                    <th style="text-align:left;">Time</th>
                    <th style="text-align:left;">View Message</th>

        <!--<th align="center">Action</th>-->						
                </tr>
            </thead>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="delete">
                <tbody>
                    <?php
                    while ($row = mysql_fetch_array($query_msg)) {
                        ?>

                        <tr <?php
                        if ($row["view_status"] == 1) {
                            echo "style='background-color:#FFFFFF;border:1px solid #999999; '";
                        } else {
                            echo "style='border:1px solid #CCCCCC; font-weight:bold; font-size:13px; font-family:Verdana, Arial, Helvetica, sans-serif; '";
                        }
                        ?>>

                            <td><input type="checkbox" name="check[]" value="<?php echo $row['m_id'] ?>" class="required" /></td>

        <?php /* ?><td style="" onclick="$(this).onmousedown('background-color','black')"><input type="checkbox" name="check" class="chk" value="<?php echo $row['m_id'] ?>" /></td><?php */ ?>

                            <td ><a href="view_message.php?id=<?php echo $row['m_id']; ?>" style="color:#000000;"><?php echo $row['first_name'] . " " . $row['last_name']; ?></a></td>

                            <td ><a href="view_message.php?id=<?php echo $row['m_id']; ?>" style="color:#000000;"><?php echo $row['sub']; ?></a></td>

                            <td ><a href="view_message.php?id=<?php echo $row['m_id']; ?>" style="color:#000000;"><?php echo $row['send_date']; ?></a></td>

                            <td ><a href="view_message.php?id=<?php echo $row['m_id']; ?>" >View details</a></td>
                        </tr>
                        <?php
                    }
                    ?>			


                <input type="submit" name="delete" value="delete" class="button1" />

            </form>	
            </tbody>
            <?php
            if (isset($MSG) && ($MSG <> "")) {
                echo "<p class=err style='margin-top:10px;'>" . $MSG . "</p>";
            }
            ?>
        </table>
        <?php
    }
    ?>
    <!--</div>DIV END from_class-->
</div><!--DIV END content-->

<?php include('../_includes/footer.php'); ?>


