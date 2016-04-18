</div>

<div class="footer_outer">

    <div class="footer">


        <div class="left_part">
            <ul>
                <li><a href="<?php echo SITE_URL ?>">Home</a></li>
                <li><a href="<?php echo SITE_URL ?>about.php">About</a></li>
                <li><a href="<?php echo SITE_URL ?>donate.php">Donate</a></li>
                <li><a href="<?php echo SITE_URL ?>contact.php">Contact</a></li>
                <li><a href="<?php echo SITE_URL ?>faq.php">Faq</a></li>
               <!-- <li><a href="<?php echo SITE_URL ?>privacy-policy.php">Privacy policy</a></li>-->
                <li><a href="<?php echo SITE_URL ?>terms-of-use.php">Terms of use</a></li>          
            </ul><br /><br /><br /><br />
            &copy; Copyright Caribbean Circle Stars 2013, all right reserved.  
        </div>

        <div class="right_part">

            <a href="#"><img src="<?php echo SITE_URL ?>_images/twitter.jpg" class="img_4" /></a><a href="https://twitter.com/CaribbeanCirSta">Twitter</a><br />
            <a href="#"><img src="<?php echo SITE_URL ?>_images/blog.jpg" class="img_5" /></a><br class="bn" /><a href="http://caribbeancirclestars.blogspot.in/">Blogspot</a><br />
            <a href="#"><img src="<?php echo SITE_URL ?>_images/google.jpg" class="img_6" /></a><br class="tn" /><a href="https://plus.google.com/communities/113858775104158096504">Google plus</a>				
        </div>

    </div>

</div>
<?php
if ((isset($_SESSION['cms_login'])) && ($_SESSION['cms_login'] != 0)) {
    
} else {
    ?>	
    <script type="text/javascript">

        function OpenChatWindow(username) {

            //alert(username);
            window.open("<?php echo SITE_URL; ?>chat.php?username=" + username, "ChatBox" + username, "width=380,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=20,top=20");
        }
    </script>
    <?php
}
?>

<?php
if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
    $identity = $_SESSION['talent_id'];
} elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
    $identity = $_SESSION['user_id'];
} else {
    $identity = "";
}
?>

<?php /* ?><?php if(isset($_SESSION['talent_id'])) { $identity = $_SESSION['talent_id']; } elseif(isset($_SESSION['user_id'])) { $identity = $_SESSION['user_id']; } ?><?php */ ?>

<?php
if ($identity != '') :
    $sql = "SELECT * FROM tbl_chat WHERE to_id='" . $identity . "' AND view_status=0 GROUP BY from_id";
    $rs = mysql_query($sql);


    while ($data = mysql_fetch_array($rs)) {

        //open popup for each chat session
        ?>
        <script language="javascript" type="text/javascript">
            OpenChatWindow('<?php echo GetChatUserName($data['from_id']); ?>');

        </script>
        <?php
    }
endif;
?>
</body> 
</html>