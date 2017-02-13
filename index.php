<?php
//die('Under maintinance');
include('_includes/application-top.php');
include('_includes/header.php');


$string = "";
$string = '<?xml version="1.0" encoding="UTF-8"?><rss xmlns:media="http://search.yahoo.com/mrss/" VERSION="2.0"><channel> <title>EnergyIQ media RSS playlist</title>';
$string3 = '<item><title>Title : ';
$string4 = '</title><media:content url="_uploads/site_music/';
$string5 = '.mp3"/><description>Artist Name : ';
$string6 = '</description></item>';

$tmusic = "SELECT * FROM tbl_site_music WHERE status='1' ORDER BY tbl_site_music.id DESC ";
$sqlmu = mysqli_query($link, $tmusic);
$sqlmu1 = mysqli_query($link, $tmusic);

while ($row = mysqli_fetch_assoc($sqlmu)) {
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
                      <!--<img src="_images/header_img_1.jpg" border="0" />--><img src="_images/header_img_1.jpg?<?php echo time() ?>" height="359" />
                </a>
            </div>
            <div class="home_img">
                <a href="artist-directory.php?id=<?php echo "5"; ?>">
                    <img src="_images/header_img_2.jpg?<?php echo time() ?>"  border="0" height="359"/>
                </a>
            </div>
            <div class="home_img">
                <a href="artist-directory.php?id=<?php echo "7"; ?>">
                    <img src="_images/header_img_3.jpg?<?php echo time() ?>" border="0" height="359"/>
                </a>
            </div>
            <div class="home_img_4">
                <a href="artist-directory.php?id=<?php echo "2"; ?>">
                    <img src="_images/header_img_4.jpg?<?php echo time() ?>" border="0" height="359"/>
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
        $result1 = mysqli_query($link, $sql1);
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
              while($music=mysqli_fetch_assoc($sqlmu1))
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
        $result = mysqli_query($link, $sql);
        //$row=mysqli_fetch_assoc($result);
        //print_r($row);
        ?>
        <div class="home_right_side_second">&nbsp;&nbsp;&nbsp;Latest Forum Topics
            <ul>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <li>
                        <?php
                        

                        if ($row['is_admin'] == 'No') {
                            $image = "_uploads/user_photo/" . $row["uid"] . ".jpg";
                            
                            if (file_exists($image)) {
                                ?>
                                <a href="view_forum_topic.php?id=<?php echo $row["id"]; ?>">

                                    <img src="<?php echo $image . "?" . time(); ?>" height="35" width="35" /><?php echo $row['forum_topic']; ?>

                                </a>
                            <?php } else { ?>

                                <a href="view_forum_topic.php?id=<?php echo $row["id"]; ?>">
                                    <img src="control/images/dummy.png?<?php echo time();?>" height="35" width="35" /><?php echo $row['forum_topic']; ?>


                                    <?php
                                }
                               

                        }else{
                           $image = "_uploads/admin_avatar/admin_avatar.jpg";
                            
                            if (file_exists($image)) {
                                ?>
                                <a href="view_forum_topic.php?id=<?php echo $row["id"]; ?>">

                                    <img src="<?php echo $image . "?" . time(); ?>" height="35" width="35" /><?php echo $row['forum_topic']; ?>

                                </a>
                            <?php } else { ?>

                                <a href="view_forum_topic.php?id=<?php echo $row["id"]; ?>">
                                    <img src="control/images/dummy.png?<?php echo time();?>" height="35" width="35" /><?php echo $row['forum_topic']; ?>


                                    <?php
                                }                     
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
                <iframe width="322" height="242" src="//www.youtube.com/embed/Ng_xLu7DylE" frameborder="0" allowfullscreen></iframe>
            </div>
            <style>
                aside.items {
                    border: 3px solid #DDDDDD;
                    padding: 5px;
                    margin: 0 0 10px;
                }
                .items > img {
                    width: 100%;
                }
                .item_info{
                    color: #009900;
                    text-align: right;
                }
                .item_info tr td:first-child {
                    font-weight: bold;
                    text-align: left;
                }
                .home_bottom {
                    clear: both;
                    padding: 5px 0 0;
                }
                .home_bottom > ul {
                    padding: 0;
                    text-align: center;
                }
                .home_bottom li {
                    display: inline-block;
                    width: 32%;
                }
            </style>

        </div>
        <div class="home_bottom">
            <?php
            $sql = 'SELECT tbl_contact.*,tbl_contactrecords.`page_name` 
                    FROM tbl_contact 
                        JOIN tbl_contactrecords on tbl_contact.id = tbl_contactrecords.`contactid` 
                    where page_name = \'Home\'';

            $result = mysqli_query($link, $sql);

            if ($result) {
                ?>
                <ul>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        if (!empty($row['file_attached'])) {
                            ?>
                            <li>
                                <aside class="items">
                                    <?php
                                    $stripslash = explode('/', $row['file_attached']);
                                    $file = explode('.', $stripslash['1']);

                                    if ($file['1'] == 'mp3' || $file['1'] == 'wav') {
                                        ?>

                                        <audio width="100%" id="player" src="<?php echo SITE_URL . $row['file_attached']; ?>" type="audio/mp3" controls="controls"></audio>
                                        <?php
                                    }

                                    if ($file['1'] == 'jpg' || $file['1'] == 'jpeg' || $file['1'] == 'png') {
                                        ?>
                                        <a href="<?php echo SITE_URL . $row['file_attached']; ?>" class="img_preview">
                                            <img height="150" src="<?php echo SITE_URL . $row['file_attached']; ?>" />
                                        </a>
                                        <?php
                                    }

                                    if ($file['1'] == 'mp4') {
                                        ?> 
                                        <video width="100%" height="150" controls="">
                                            <source src="<?php echo SITE_URL . $row['file_attached']; ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video> 
                                        <?php
                                    }
                                    ?>
                                    <table class="item_info">
                                        <tr>
                                            <td>Title</td>
                                            <td>:</td>
                                            <td><?php echo $row['title_of_work'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Artist</td>
                                            <td>:</td>
                                            <td><?php echo $row['artistbandname'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Genre</td>
                                            <td>:</td>
                                            <td><?php echo $row['genre'] ?></td>
                                        </tr>
                                    </table>

                                </aside>

                            </li><?php }
                                ?>

                        <?php
                    }
                    ?>
                </ul>
            <?php } ?>
        </div>

        <!--<h1>WELCOME TO CARIBBEAN CIRCLE STARS</h1>-->
                        <!--<h2><?php // echo GetPageHeading('Home');                          ?></h2>-->
      <!--<p><?php // echo GetPageText('Home');                          ?></p>-->





    </div><!--END CLASS content-->
    <script language="javascript" type="text/javascript">
        $(document).ready(function () {
            $('.img_preview').fancybox();
        });
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