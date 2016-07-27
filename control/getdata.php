<?php
include('include/application_top.php');
cmslogin();
session_start();

$string = explode(" ", mysqli_real_escape_string( $link ,trim($_REQUEST['search'])));

$strcount = count($string);

$count = 1;
$stringar = "";

foreach ($string as $row) {
    if ($count < $strcount) {
        $stringar.="(username REGEXP '[[:<:]]" . strtolower($row) . "[[:>:]]' OR first_name REGEXP '[[:<:]]" . strtolower($row) . "[[:>:]]' OR last_name REGEXP '[[:<:]]" . strtolower($row) . "[[:>:]]') || ";
        $_SESSION['search'] = $stringar;
    } else {
        $stringar.="(username REGEXP '[[:<:]]" . strtolower($row) . "[[:>:]]' OR first_name REGEXP '[[:<:]]" . strtolower($row) . "[[:>:]]' OR last_name REGEXP '[[:<:]]" . strtolower($row) . "[[:>:]]') ";
        $_SESSION['search'] = $stringar;
    }

    $count = $count + 1;
}

$qry = "SELECT * " .
        "FROM tbl_users " .
        "WHERE " . $_SESSION['search'] . " " .
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

            <a href="details.php?id=<?php echo $row['id']; ?>">

                <?php /* ?><img src="_uploads/user_photo/<?php echo $row["id"]; ?>.jpg" height='150' width='120'/><?php */ ?>

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


            <p style="text-align:center; margin-top:-2px;">	<a href="details.php?id=<?php echo $row['id']; ?>"> <?php echo $row["username"]; ?></a></p>

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
    /* else{
      echo "<p class='err'>No Record Found!</p>";
      } */
    ?>
