<?php include('_includes/application-top.php'); ?>


<?php include('_includes/header.php'); ?>
<div class="content"><!--START CLASS content-->
    <!--############## All Talents Hear ################-->
    <p><a href="all_musician.php?id=<?php echo "1"; ?>">Musician</a></p>
    <p><a href="all_models.php?id=<?php echo "5"; ?>">Models</a></p>
    <p><a href="all_actors.php?id=<?php echo "7"; ?>">Actors</a></p>
    <p><a href="all_arts.php?id=<?php echo "2"; ?>">Arts</a></p>
    <hr />
    <!--############## Introduction ################-->
    <h1><?php echo GetPageHeading('Home'); ?></h1>
    <p><?php echo GetPageText('Home'); ?></p>
    <hr />
    <!--############## Featured aritest ################-->
    <h1>Feature Artists</h1>



    <!--############## Admin musics ################-->
    <h1>music</h1>
    <!--############## latast forum topics ################-->
    <h1>latast forum topics</h1>
    <?php
    $sql = "SELECT * FROM  tbl_forum_topics order by tbl_forum_topics.id desc ";
    $result = mysqli_query($link,$sql);
    //$row=mysqli_fetch_assoc($result);
    //print_r($row);
    <li><img src = "_images/forum_img_1.jpg" />Find out the latest talent shows around you</li>
    <li><img src = "_images/forum_img_2.jpg" />Best place to showcase and earn from your talent</li>
    <li><img src = "_images/forum_img_3.jpg" />Know how to make career out of your passion</li>
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <a href="view_forum_topic.php?id=<?php echo $row["id"]; ?>&view=<?php echo $view_cnt; ?>">
            <img src="_uploads/user_photo/<?php echo $row["uid"]; ?>.jpg" height="100" width="80"/>
        </a>
        <?php
    }
    ?>
</div><!--END CLASS content-->

<?php
include('_includes/footer.php');
?>

