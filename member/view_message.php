<?php
include('../_includes/application-top.php');
ChecknontalentLogin();
if (isset($_GET['id'])) {
    $data = array(
        "view_status" => '1'
    );
    $table = "tbl_msg";
    $parameters = "id='" . $_GET['id'] . "'";
    updateData($data, $table, $parameters);
}
include('../_includes/header.php');
?> 
<script type="text/javascript">
    function ConfrimMessage_Delete(Url) //confarming property delete
    {
        if (confirm("Are you sure you want to delete this Record?"))
        {
            /*self.navigate(Url);*/ //redirecting to the desired page
            window.location = "" + Url;
        }
    }
</script>
<div class="content"><!--START content PART-->

    <h1>View message details</h1>
    <p style="text-align:right"><a href="message.php" class="button" style="float:left; margin:-5px 0px 5px 0px;">Back</a></p>	

    <br />
    <div class="form_class">
        <?php
        if (isset($_GET['op']) AND ( $_GET['op'] == "del")) {
            $MSG = "Message deleted successfully.";
            echo "<p class=err>" . $MSG . "</p>";
        }
        ?>
        <?php
        if (isset($_GET['id']) AND $_GET['id'] != '') {
            $query = "SELECT tbl_msg.id AS m_id, tbl_msg.msg, tbl_msg.send_date, tbl_msg.from_id, tbl_users.id AS tbl_user_id, tbl_users.first_name, tbl_users.last_name

					FROM tbl_msg LEFT OUTER JOIN tbl_users
				
					ON tbl_msg.from_id = tbl_users.id  WHERE tbl_msg.id='" . $_GET['id'] . "'";

            $query_row = mysqli_query($link,$query);

            $number = mysqli_num_rows($query_row);

            if ($number <= 0) {
                echo "<p class='err'>No Record Found.</p>";
            } else {

                $data = mysqli_fetch_assoc($query_row);
                ?>

                <div class="view_msg"><!--START div class  view_msg-->

                    <div class="view_msg_left">

                        <p>Name&nbsp;:-&nbsp;&nbsp;<?php echo $data['first_name']; ?> <?php echo $data['last_name']; ?></p>

                        <p>Message&nbsp;:-&nbsp;&nbsp;<?php echo $data['msg']; ?></p>

                    </div>

                    <div class="view_msg_right">
                        <?php
                        /* $data=getAnyTableWhereData("send_msg", "AND from_id='" .$data['from_id']. "' "); */
                        ?>
                        <p><a href="Replay" id="replay">Reply</a></p>

                        <script type="text/javascript">
                            $(function () {
                                $("#replay").click(function () {
                                    window.location.href = "<?php echo SITE_URL . "send_msg.php?id=" . $data['from_id']; ?>";
                                    return false;
                                })
                            });
                        </script>



                        <span><a href="<?php echo "javascript:ConfrimMessage_Delete('delete_view_message.php?id=$data[m_id]')"; ?>">Delete</a></span>
                    </div>

                </div><!--END div class  view_msg-->
                <?php
            }
        }
        ?>
        <div style="clear:both;"></div>

    </div><!--END div class  form_class-->

</div><!--END content PART-->




<?php
include('../_includes/footer.php');
?>
