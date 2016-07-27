<?php
include('_includes/application-top.php');
include('_includes/header.php');
?>
<div class="content"><!--START CLASS contant PART -->
    <h1>Search Result</h1>	
    <div class="form_class"><!--START CLASS form_class PART -->
        <?php
        if ((isset($_POST['search'])) AND ( $_POST['search']) != '') {

            $string = explode(" ", mysqli_real_escape_string( $link ,trim($_POST['search'])));

            $strcount = count($string);

            $count = 1;
            $stringar = "";

            foreach ($string as $row) {
                if ($count < $strcount) {
                    $stringar.="(username REGEXP '[[:<:]]" . strtolower($row) . "[[:>:]]' OR first_name REGEXP '[[:<:]]" . strtolower($row) . "[[:>:]]' OR last_name REGEXP '[[:<:]]" . strtolower($row) . "[[:>:]]') || ";
                } else {
                    $stringar.="(username REGEXP '[[:<:]]" . strtolower($row) . "[[:>:]]' OR first_name REGEXP '[[:<:]]" . strtolower($row) . "[[:>:]]' OR last_name REGEXP '[[:<:]]" . strtolower($row) . "[[:>:]]') ";
                }

                $count = $count + 1;
            }

            $qry = "SELECT * " .
                    "FROM tbl_users " .
                    "WHERE " . $stringar . " " .
                    "ORDER BY username ";

            $result = mysqli_query($link,$qry) or die(mysql_error());

            //$query=mysqli_query($link,"SELECT * FROM  tbl_users WHERE username like '".$_POST['search']."%' OR first_name like '".$_POST['search']."%' OR last_name like '".$_POST['search']."%'");
            $number = mysqli_num_rows($result);
            if ($number <= 0) {
                echo "<p class='err'>No Record Found!</p>";
            }
            ?>

            <ul>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>

                    <li class="b_image">

                        <a href="<?php echo SITE_URL; ?>profile-details.php?username=<?php echo $row['username']; ?>">

                            <?php /* ?><img src="_uploads/user_photo/<?php echo $row["id"]; ?>.jpg" height='150' width='120'/><?php */ ?>

                            <?php
                            $image = "_uploads/user_photo/" . $row["id"] . ".jpg";

                            if (file_exists($image)) {
                                ?>
                                <img src="<?php echo $image; ?>" height='150' width='120'/>
        <?php } else { ?>

                                <img src="_images/dummy.png" height='150' width='120'/>
                            <?php }
                            ?>
                        </a>


                        <p style="text-align:center; margin-top:-2px;">	<a href="<?php echo SITE_URL; ?>profile-details.php?username=<?php echo $row['username']; ?>"><?php echo $row["username"]; ?></p>

                        </a><br />

                    </li>
                    <?php
                }
            } else {
                echo "<p class='err'>No Record Found!</p>";
            }
            ?>
        </ul>

    </div><!--END CLASS form_class PART -->	
</div><!--END CLASS contant PART -->
<?php
include('_includes/footer.php');
?>