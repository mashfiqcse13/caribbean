<?php
include('_includes/application-top.php');
include('_includes/header.php');


$string = "";
$string = '<?xml version="1.0" encoding="UTF-8"?><rss xmlns:media="http://search.yahoo.com/mrss/" VERSION="2.0"><channel> <title>EnergyIQ media RSS playlist</title>';
$string3 = '<item><title>Title : ';
$string4 = '</title><media:content url="_uploads/site_music/';
$string5 = '.mp3"/><description>Artist Name : ';
$string6 = '</description></item>';

$tmusic = "SELECT * FROM tbl_site_music WHERE status='1' ORDER BY tbl_site_music.id DESC ";
$sqlmu = mysql_query($tmusic);
$sqlmu1 = mysql_query($tmusic);

while ($row = mysql_fetch_assoc($sqlmu)) {
    $string.=$string3 . ucfirst($row["name"]);
    $string.=$string4 . $row["id"];
    $string.=$string5 . ucfirst($row["artist"]);
    $string.=$string6;
}
$string.="</channel></rss>";
$my_file = 'songs_new.xml';
file_put_contents($my_file, "");
$handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
$data = $string;
fwrite($handle, $data);
?>		

<script type="text/javascript">
    (function ($) {
        $(function () {
            $(".home_left_side_third > ul:first").simplyScroll({
                autoMode: 'loop',
                pauseOnHover: true,
                frameRate: 30,
                speed: 2
            });
        });
    })(jQuery);
</script>
<script type="text/javascript" src="<?php echo SITE_URL; ?>_script/longtail.js"></script>
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
// $sql1="SELECT * FROM  tbl_users  WHERE  type=1 order by RAND() LIMIT 0, 20 ";
        $sql1 = "SELECT * FROM tbl_featured_artists WHERE  status=1";
        $result1 = mysql_query($sql1);
//$row1=mysql_fetch_assoc($result1);
//print_r($row1);
        ?>
        <div class="home_left_side_third">
            <br /><span class="sub">Featured Artists</span><br /><hr class="nbv"/>
            <ul class="list_class">
                <?php
                while ($row1 = mysql_fetch_assoc($result1)) {
                    ?>
                    <li>
                        <div style="padding:0px; margin:0px; width:100px; height:230px;">
                            <div style="clear:both; float:left; text-align:center;; height:200px;">
                                <?php
                                $file_name = "_uploads/featured_artists/" . $row1["id"] . ".jpg";
                                if (file_exists($file_name)) {
                                    echo "<img  src='" . $file_name . "' height='200' width='149' />";
                                } else {
                                    echo "<img src='_images/dummy.png' height='200' width='149' />";
                                }
                                ?>
                            </div>
                            <div style="clear:both; float:left; text-align:center; width:150px; height:30px; color:#000000; margin:5px 0px 0px 0px; font-weight:bold;">
                                <?php echo $row1['f_artists_name']; ?>
                            </div>
                        </div>
                    </li>

                <?php } ?>
            </ul>         
        </div>        

    </div>


    <div class="home_right_side">

        <div class="home_right_side_first" id="music_content">
            Music

            <div id='mediaspace' style="color:#999; font-size:11px;">Please wait...</div>

            <?php /* ?>  
              <form id="form2" name="form2" method="post" action="">
              <label>
              <select name="select" size="6"  multiple="multiple" id="select">
              <?php
              while($music=mysql_fetch_assoc($sqlmu1))
              {
              ?>
              <option ondblclick="<?php echo "javascript:music_play_eq('".$music['id']."')";?>">
              <?php echo $music['name'];?> - <?php echo $music['artist'];?>
              </option>
              <?php } ?>
              </select>
              </label>
              </form>
              <?php */ ?>

        </div>
        <?php
        $sql = "SELECT * FROM  tbl_forum_topics order by tbl_forum_topics.id desc LIMIT 0, 4 ";
        $result = mysql_query($sql);
        //$row=mysql_fetch_assoc($result);
        //print_r($row);
        ?>
        <div class="home_right_side_second">&nbsp;&nbsp;&nbsp;Latest Forum Topics
            <ul>
                <?php
                while ($row = mysql_fetch_assoc($result)) {
                    ?>
                    <li>
                        <?php
                        $image = "_uploads/user_photo/" . $row["uid"] . ".jpg";
                        if (file_exists($image)) {
                            ?>
                            <a href="view_forum_topic.php?id=<?php echo $row["id"]; ?>">
                                <?php /* ?><img src="_uploads/user_photo/<?php echo $row["uid"]; ?>.jpg" height="35" width="35" /><?php echo $row['forum_topic']; ?><?php */ ?>
                                <img src="<?php echo $image; ?>" height="35" width="35" /><?php echo $row['forum_topic']; ?>

                            </a>
                        <?php } else { ?>

                            <a href="view_forum_topic.php?id=<?php echo $row["id"]; ?>">
                                <img src="_images/user_icon_demo.png" height="35" width="35" /><?php echo $row['forum_topic']; ?>


                                <?php
                            }
                            ?>

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
        <div style="margin:10px 0px 0px 5px;">
            <iframe width="322" height="242" src="//www.youtube.com/embed/GYs9j3taIJQ" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>

    <!--<h1>WELCOME TO CARIBBEAN CIRCLE STARS</h1>-->
                    <!--<h2><?php // echo GetPageHeading('Home');        ?></h2>-->
  <!--<p><?php // echo GetPageText('Home');        ?></p>-->





</div><!--END CLASS content-->
<script language="javascript" type="text/javascript">
    $(window).bind('load', function () {

        // $("#music_content").load('music_player.php');
        $.ajax({
            type: "POST",
            url: "music_player.php",
            async: false,
            success: function (result) {
                $("#music_content").html(result);
            }
        });

    });

    /*window.onunload=function(){
     alert("tesj");
     //your code here
     }
     */

    window.onpagehide = function () {
        // some code here.
        //alert("tes");
        $("#music_content").html('Music');
    };
    window.onbeforeunload = function () {
        // alert("tes");
        $("#music_content").html('Music');
    };

    window.onbeforeunload = Call;
    function Call() {
        //alert("Unload Callled");
        //  return "You are going to close this window?";
        $("#music_content").html('Music');
    }
    setInterval(function () {
        if ($("#music_content").html() == "Music")
        {
            $.ajax({
                type: "POST",
                url: "music_player.php",
                async: false,
                success: function (result) {
                    $("#music_content").html(result);
                }
            });
        }
        //code goes here that will be run every 5 seconds.    
    }, 5000);
</script>
<?php
include('_includes/footer.php');
?> 