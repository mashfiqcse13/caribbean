<?php
include('../_includes/application-top.php');
ChecktalentLogin();
include('../_includes/header.php');
?> 
<!--<script type="text/javascript">
                $(document).ready(function(){
                        $('#talents_loin').validate();
                });
                
</script>-->

<!--/////IMAGE DELETE CONFIRM MESSAGE///////-->
<script type="text/javascript">
    function ConfrimMessage_Delete(Mid, Pid) //confarming property delete
    {

        if (confirm("Are you sure you want to delete this Record?"))
        {
            /*self.navigate(Url);*/ //redirecting to the desired page

            var Url = "delete_gallery.php?id=" + Mid + "&pid=" + Pid;
            window.location = "" + Url;
        }
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("a.fancybox").fancybox();
    });
</script>

<div class="content"><!--START CLASS contant PART -->
    <h1>Profile Images</h1>
    <p style="text-align:right"><a href="profile_setup.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a><a href="add_image.php" class="button">Add Image</a></p>
    <?php
    if (isset($_GET['op']) AND ( $_GET['op'] == "a")) {
        echo "<p class='msg'>Your Image Uploaded  Successfully</p>";
    }
    ?>
    <?php
    if (isset($_GET['op']) AND ( $_GET['op'] == "del")) {
        echo "<p class='err'>Record Deleted Sucessfully</p>";
    }
    ?>
    <?php
    if (isset($_GET['op']) AND ( $_GET['op'] == "u")) {
        echo "<p class='msg'>Record Updated Sucessfully</p>";
    }
    ?>

    <!--/////USER IMAGE UPLOAD HEAR/////-->
    <?php
    //DATABASE QUERY
    $result = mysql_query("SELECT * FROM  tbl_profile_photos WHERE user_id='" . $_SESSION['talent_id'] . "' order by tbl_profile_photos.id DESC ");
    $number = mysql_num_rows($result);
    ?>
    <?php
    if ($number <= 0) {
        echo "<p class='err'>No Record Found!</p>";
    } else {
        ?>
        <table cellpadding="0" cellspacing="0" class="TabUIRecords">
            <thead>
                <tr>
                    <th align="center">Photo</th>
                    <th style="text-align:left;">Title</th>
                    <th style="text-align:left;">Details</th>
                    <th>Saleable</th>
                    <th>Price</th>
                    <th>Shipping</th>
                    <th align="center">Action</th>
                    <!--<th align="center">Action</th>-->
                </tr>
            </thead>
            <tbody>
                <?php
            }
            while ($row = mysql_fetch_assoc($result)) {

                $sql = mysql_query("SELECT * FROM  tbl_products WHERE ref_id='" . $row['id'] . "' AND content_type='3' ");
                $res = mysql_fetch_assoc($sql);
                // print_r($res);
                $row1 = mysql_num_rows($sql);

                if ($res['id'] != '') {
                    $pid = $res['id'];
                } else {
                    $pid = 0;
                }
                ?>
                <tr>
                        <td width="8%"><!--<a href="../_uploads/profile_photo/<?php echo $row["id"]; ?>.jpg" class="fancybox">--><img src="../_uploads/profile_photo/thumb/<?php echo $row["id"]; ?>.jpg" style="margin:10px 10px 10px 10px;" alt="my_img"/><!--</a>--></td>
                    <td align="left"><?php echo $row["photo_title"]; ?></td>
                    <td align="left"><?php echo substr($row["photo_details"], 0, 30); ?></td>
                    <td align="center"><?php
                        if ($row1 == 1) {
                            echo "Yes";
                        } else {
                            echo "No";
                        }
                        ?></td>
                    <td align="center"><?php
                        if ($row1 == 0) {
                            echo "_";
                        } else {
                            echo "$ " . $res['product_price'];
                        }
                        ?></td>
                    <td align="center"><?php
                    if ($row1 == 0) {
                        echo "_";
                    } else {
                        echo "$ " . $res['p_shipping'];
                    }
                    ?></td>
                    <td align="center">
                        <a href="update_gallery.php?id=<?php echo $row["id"]; ?>">
                            <img src="../_images/Edit.png" title="Update Photo">
                        </a>&nbsp;&nbsp;
                        <a href="javascript:" onclick="ConfrimMessage_Delete(<?php echo $row['id']; ?>, <?php echo $pid; ?>)">
                <?php /* ?><a href="<?php echo "javascript:ConfrimMessage_Delete('delete_gallery.php?id=$row[id]')";?>"><?php */ ?>
                            <img src="../_images/del.png" title="Delete photo">
                        </a>
                    </td>
                </tr>				
    <?php
}
?>			
        </tbody>
    </table>
</div>
<?php
include('../_includes/footer.php');
?>
