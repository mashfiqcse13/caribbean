<?php include('_includes/application-top.php'); ?>


<?php include('_includes/header.php'); ?>
<div class="content"><!--START CLASS content-->
    <div class="home_left_side">

        <div class="home_left_side_first">

            <div class="home_img">
                <a href="artist-directory.php?id=<?php echo "1"; ?>" >
                      <!--<img src="_images/header_img_1.jpg" border="0" />--><img src="_images/header_img_1.jpg" height="359" />
                </a>
            </div>
            <div class="home_img">
                <a href="artist-directory.php?id=<?php echo "5"; ?>">
                    <img src="_images/header_img_2.jpg"  border="0" height="359"/>
                </a>
            </div>
            <div class="home_img">
                <a href="artist-directory.php?id=<?php echo "7"; ?>">
                    <img src="_images/header_img_3.jpg" border="0" height="359" />
                </a>
            </div>
            <div class="home_img_4">
                <a href="artist-directory.php?id=<?php echo "2"; ?>">
                    <img src="_images/header_img_4.jpg" border="0" height="359" />
                </a>
            </div>          
            <div class="clear"></div>
        </div>


        <div class="home_left_side_second">

            <div class="home_text">
                <a href="artist-directory.php?id=<?php echo "1"; ?>">MUSICIAN</a>
            </div>
            <div class="home_text">
                <a href="artist-directory.php?id=<?php echo "5"; ?>">MODELS</a>
            </div>
            <div class="home_text">
                <a href="artist-directory.php?id=<?php echo "7"; ?>">ACTORS</a>
            </div>
            <div class="home_text_4">
                <a href="artist-directory.php?id=<?php echo "2"; ?>">ARTS</a>
            </div>

        </div>

        <div class="home_left_side_third">
            <h1 class="heding_txt"><?php echo GetPageHeading('Home'); ?></h1>         
            <p class="home_para"><?php echo GetPageText('Home'); ?></p>    
        </div>
        <?php
        $sql1 = "SELECT * FROM  tbl_users  WHERE  type=1 order by RAND() LIMIT 0, 4 ";
        $result1 = mysqli_query($link,$sql1);
        //$row1=mysqli_fetch_assoc($result1);
        //print_r($row1);
        ?>
        <div class="home_left_side_third">
            <br /><span class="sub">Featured Artists</span><br /><hr class="nbv"/>
            <ul class="list_class">
                <?php
                while ($row1 = mysqli_fetch_assoc($result1)) {
                    ?>
                    <li>
                        <a href="profile-details.php?username=<?php echo $row1['username']; ?>">
                            <?php
                            $file_name = "_uploads/user_photo/" . $row1["id"] . ".jpg";
                            if (file_exists($file_name)) {
                                echo "<img  src='" . $file_name . "' height='200' width='149' />";
                            } else {
                                echo "<img src='_images/dummy.png' height='200' width='149'/>";
                            }
                            ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>          
        </div>        

    </div>


    <div class="home_right_side">

        <div class="home_right_side_first">Music
            <?php
            $tmusic = "SELECT * FROM tbl_site_music WHERE status='1' ORDER BY tbl_site_music.id DESC ";
            $sqlmu = mysqli_query($link,$tmusic);
            $sqlmu1 = mysqli_query($link,$tmusic);
            $row = mysqli_fetch_assoc($sqlmu);

            //print_r($music);
            ?> 
            <div id='mediaspace'>This div will be replaced</div>
            <script type="text/javascript">
                $(window).load(function () {

                    music_play_eq('<?php echo $row['id']; ?>');

                });
                function music_play_eq(id) //confarming property delete
                {
                    // alert(id);
                    var play_file = id + '.mp3';
                    // alert (play_file);
                    var file = 'file=_uploads/site_music/' + play_file + '&plugins=ifequalizer-1&ifequalizer.soundonly=false&autostart=true';
                    //alert(file);
                    var so = new SWFObject('player.swf',
                            'mpl', '300', '125', '9');
                    so.addParam('allowscriptaccess', 'always');
                    so.addParam('allowfullscreen', 'true');
                    so.addParam('flashvars', file);
                    so.write('mediaspace');
                }


            </script>
            <form id="form2" name="form2" method="post" action="">
                <label>
                    <select name="select" size="6"  multiple="multiple" id="select">
                        <?php
                        while ($music = mysqli_fetch_assoc($sqlmu1)) {
                            ?>
                            <option ondblclick="<?php echo "javascript:music_play_eq('" . $music['id'] . "')"; ?>">
                                <?php echo $music['name']; ?> - <?php echo $music['artist']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </label>
            </form>
        </div>
        <?php
        $sql = "SELECT * FROM  tbl_forum_topics order by tbl_forum_topics.id desc LIMIT 0, 4 ";
        $result = mysqli_query($link,$sql);
//$row=mysqli_fetch_assoc($result);
//print_r($row);
        ?>
        <div class="home_right_side_second">&nbsp;&nbsp;&nbsp;Latest Forum Topics
            <ul>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <li>
                        <a href="view_forum_topic.php?id=<?php echo $row["id"]; ?>">
                            <img src="_uploads/user_photo/<?php echo $row["uid"]; ?>.jpg" height="35" width="35" /><?php echo $row['forum_topic']; ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="home_right_side_third">
            <a href="forum.php">Join the  Forum</a>
        </div>

        <div class="home_right_side_fourth">
            <a href="talents/registration.php">
                <img src="_images/showcase_img.jpg" />
            </a>
        </div>

    </div>

    <!--<h1>WELCOME TO CARIBBEAN CIRCLE STARS</h1>-->
                    <!--<h2><?php // echo GetPageHeading('Home');   ?></h2>-->
  <!--<p><?php // echo GetPageText('Home');   ?></p>-->





</div><!--END CLASS content-->

<?php
include('_includes/footer.php');
?>

