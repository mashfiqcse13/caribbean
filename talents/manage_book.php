<?php
include('../_includes/application-top.php');
ChecktalentLogin();
include('../_includes/header.php');
?> 
<script type="text/javascript">
    function ConfrimMessage_Delete(Mid, Pid) //confarming property delete
    {

        if (confirm("Are you sure you want to delete this Record?"))
        {

            var Url = "delete_book.php?id=" + Mid + "&pid=" + Pid;
            window.location = "" + Url;
        }
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>

<div class="content"><!--START DIV CLASS content-->

    <h1>Profile Books</h1>
    <p style="text-align:right"><a href="profile_setup.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a><a href="add_book.php" class="button">Add Book</a></p>
    <?php
    if (isset($_GET['op']) AND ( $_GET['op'] == "a")) {
        echo "<p class='msg'>Your Book Uploaded  Successfully</p>";
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

    <?php
    $query = mysql_query("SELECT * FROM tbl_profile_books WHERE uid='" . $_SESSION['talent_id'] . "' order by tbl_profile_books.id desc");
    $number = mysql_num_rows($query);
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
                    <th style="text-align:left;">Name</th>
                    <th style="text-align:left;">Author</th>
                    <th style="text-align:left;">Book Details </th>
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
            while ($row = mysql_fetch_assoc($query)) {
                $sql = mysql_query("SELECT * FROM  tbl_products WHERE ref_id='" . $row['id'] . "' AND content_type=4 ");
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
                    <td width="8%"><a href="../_uploads/profile_book_photo/<?php echo $row["id"]; ?>.jpg" class="fancybox"><img src="../_uploads/profile_book_photo/thumb/<?php echo $row["id"]; ?>.jpg" style="margin:10px 10px 10px 10px;" alt="my_img"/></a></td>
                    <td align="left"><?php echo $row["name"]; ?></td>
                    <td align="left"><?php echo $row["author"]; ?></td>
                    <td align="left"><?php echo substr($row["book_details"], 0, 40); ?></td>
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
                        <a href="update_book.php?id=<?php echo $row["id"]; ?>">
                            <img src="../_images/Edit.png" title="Update Book">
                        </a>&nbsp;&nbsp;
                        <a href="javascript:" onclick="ConfrimMessage_Delete(<?php echo $row['id']; ?>, <?php echo $pid; ?>)">
                            <img src="../_images/del.png" title="Delete Book">
                        </a>
                    </td>
                </tr>	
    <?php
}
?>
        </tbody>
    </table>
</div><!--END DIV CLASS content-->

<?php
include('../_includes/footer.php');
?>
