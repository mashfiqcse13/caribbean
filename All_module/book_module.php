
<?php
$query_bookdetails = mysql_query("SELECT b.id as bookid,b.name,b.author,b.uid,u.id,u.username FROM tbl_profile_books AS b LEFT OUTER JOIN tbl_users AS u ON u.id=b.uid
									WHERE u.username='" . $_GET['username'] . "' ORDER BY b.id DESC LIMIT 0, 2 ");

//$row_bookdetails=mysql_fetch_assoc($query_bookdetails);	
//print_r($row_bookdetails);		
if ((mysql_num_rows($query_bookdetails) > 0)) {
    ?>					
    <div class="mystore">
        <h2> My Book</h2>
        <?php
        while ($row_bookdetailsl = mysql_fetch_assoc($query_bookdetails)) {
            ?>
            <div class="store_detail">
                <div class="store_detail_left"> 
                    <a href="view_book.php?id=<?php echo $profile_id; ?>" title="View All Books">
                        <img src="_uploads/profile_book_photo/thumb/<?php echo $row_bookdetailsl['bookid']; ?>.jpg" width="100" />
                    </a>
                </div>
                <div class="store_detail_right">
                    <a href="view_book.php?id=<?php echo $profile_id; ?>" title="View All Books">
                        <h4><?php echo $row_bookdetailsl['name']; ?></h4>
                    </a>
                    <span><?php echo $row_bookdetailsl['author']; ?></span> 

                </div><div class="clear"></div>
            </div>
            <?php
        }
        ?>
        <div class="storebtn_top_spece">
            <a class="profile_btn" href="view_book.php?id=<?php echo $profile_id; ?>">View All Books</a> 
        </div>
    </div>
    <?php
}
?>	