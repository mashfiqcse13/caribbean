<?php
include('_includes/application-top.php');

$result = CheckProfileView($_GET['username']);

$data = getAnyTableWhereData("tbl_users", "AND username='" . $_GET['username'] . "' ");
/* USER COMMENT SUBMIT CHECK */
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'submit')) {
    $data = array(
        "profile_id" => $_POST['profile_id'],
        "commenter_id" => $_POST['talent_id'],
        "comment_text" => mysql_real_escape_string(trim($_POST['comment_text'])),
        "comment_time" => date('Y-m-d H:i:s')
    );

    insertData($data, "tbl_profile_comments");
}

include('_includes/header.php');
?>
<script type="text/javascript">

    /*$(document).ready(function() {
     
     $('a#audio').fancybox();
     
     });*/

    $(document).ready(function () {
        $("a#video").fancybox({
            'width': 400,
            'height': 580,
            'scrolling': 'no',
            'autoScale': true,
            'titlePosition': 'over',
            'transitionIn': 'none',
            'transitionOut': 'none'
        });
    });
</script>



<script type="text/javascript">
    //initialize the 3 popup css class names - create more if needed
    var matchClass = ['popup1'];
    //Set your 3 basic sizes and other options for the class names above - create more if needed
    var popup1 = 'width=380,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=20,top=20';
    //The pop-up function
    function tfpop() {
        var x = 0;
        var popClass;
        //Cycle through the class names
        while (x < matchClass.length) {
            popClass = "'." + matchClass[x] + "'";
            //Attach the clicks to the popup classes
            $(eval(popClass)).click(function () {
                //Get the destination URL and the class popup specs
                var popurl = $(this).attr('href');
                var popupSpecs = $(this).attr('class');
                //Create a "unique" name for the window using a random number
                var popupName = Math.floor(Math.random() * 10000001);
                //Opens the pop-up window according to the specified specs
                newwindow = window.open(popurl, popupName, eval(popupSpecs));
                return false;
            });
            x++;
        }
    }

    //Wait until the page loads to call the function
    $(function () {
        tfpop();
    });
</script>

<!--MUSIC POPUP WINDOW OPEN--->


<script type="text/javascript">
    function popitup(url) {
        newwindow = window.open(url, 'name', 'height=50,width=245');
        if (window.focus) {
            newwindow.focus()
        }
        return false;
    }
</script>




<!--********************************************************
                                        CHECK GET USER ALREADY EXIST OR NOT
*********************************************************-->

<?php
$query111 = mysql_query("SELECT * FROM tbl_users WHERE username='" . $_GET['username'] . "'");
$ror111 = mysql_num_rows($query111);
if ($ror111 > 0) {
    ?>

    <div class="profile_page_wraper"><!--START DIV CLASS profile_page_wraper	-->
        <div class="profile_page_contnt_heading">
            <span class="name_profile"><?php
                $name = GetFullName($_GET['username']);
                echo $name . " " . "is" . ' ' . "currently" . " ";



                /* ###################GET VALUE FROM tbl_user_online############### */
                $SQL_ONLI = mysql_query("SELECT id FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                $SQL_RESULT = mysql_fetch_array($SQL_ONLI);
                //print_r($SQL_RESULT);
                $SQL_QUERY = "SELECT * FROM tbl_user_online WHERE uid='" . $SQL_RESULT['id'] . "'";
                $SQL_RESULT1 = mysql_query($SQL_QUERY);
                $SQL_fetch = mysql_fetch_array($SQL_RESULT1);
                //print_r($SQL_fetch);
                $SQL_ROWS = mysql_num_rows($SQL_RESULT1);

                if ($SQL_ROWS == '') {
                    ?>
                    <samp style="color:#FF0000; font-weight:bold;"><?php echo "OFFLINE"; ?></samp>
                    <?php
                } else {
                    ?>
                    <samp style="color:#009900; font-weight:bold;"><?php echo "ONLINE"; ?></samp>
                    <?php
                    /* if(isset($_SESSION["talent_id"])){
                      $uid=$_SESSION["talent_id"];
                      }else if(isset($_SESSION["user_id"])){
                      $uid=$_SESSION["user_id"];
                      } */
                    if ((isset($_SESSION["talent_id"])) && ($_SESSION["talent_id"] != 0)) {
                        $uid = $_SESSION["talent_id"];
                    } elseif ((isset($_SESSION["user_id"])) && ($_SESSION["user_id"] != 0)) {
                        $uid = $_SESSION["user_id"];
                    } else {
                        $_SESSION["talent_id"] = 0;
                        $_SESSION["user_id"] = 0;
                        $uid = "";
                    }

                    //if(($uid=="") || ($uid!=$SQL_fetch['uid']) && ($uid!="") ){	
                    ?>

                    <?php
                    if ($SQL_RESULT['id'] != $uid) {
                        if ((!isset($_SESSION["talent_id"]) || ($_SESSION["talent_id"] == 0)) && (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == 0)) {
                            
                        } else {
                            ?>	
                            <a href="chat.php?username=<?php echo $_GET['username']; ?>" style="float:right;color:#FFFFFF;" class="popup1">Chat now</a>
                            <?php
                        }
                    }
                    ?>

                    <?php
                    //}
                }
                ?> 




                <!--*********************************************************
                                                                                        CHAT NOW PROCESS START NOW
                        ***********************************************************-->








            </span>
        </div>

        <div class="profile_page_contnt"><!--START DIV CLASS profile_page_contnt-->
            <?php
            if (isset($_GET['op'])) {
                ?>
                <p class="msg">
                    <?php
                    if (isset($_GET['op']) AND ( $_GET['op'] == "suc")) {
                        $query27 = mysql_query("SELECT * FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                        $row27 = mysql_fetch_assoc($query27);
                        echo "Congratulations, You are a new fans of " . $row27['first_name'] . " " . $row27['last_name'] . "";
                    }
                    ?>
                </p>
                <?php
            }
            if (isset($_GET['op'])) {
                ?>
                <p class="err">
                    <?php
                    if (isset($_GET['op']) AND ( $_GET['op'] == "self")) {
                        echo "You Can Not send Request Yourself.";
                    }
                    if (isset($_GET['op']) AND ( $_GET['op'] == "ex")) {
                        $query26 = mysql_query("SELECT * FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                        $row26 = mysql_fetch_assoc($query26);
                        echo "You are already fans of " . $row26['first_name'] . " " . $row26['last_name'] . "";
                    }
                    ?>
                </p>
            <?php } ?>

            <!---------------------------------------SATRT-CONTENT-LEFT-DIV------------------------------------------------>


            <div class="profile_page_contnt_left"><!--START DIV CLASS profile_page_contnt_left-->

                <div class="profile_details"><!--START DIV CLASS profile_details-->
                                <div class="profile_details_top"><!--<img src="_images/Profile_big_img.jpg" border="0"/>-->
                        <?php
                        $query1 = mysql_query("SELECT id,type FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                        $row = mysql_fetch_assoc($query1);
                        //echo $row['type'];
                        $profile_id = $row['id'];
                        //echo $row['id'];

                        $image = "_uploads/user_photo/" . $row['id'] . ".jpg";
                        //echo $image;
                        if (file_exists($image)) {
                            ?>
                            <img src="<?php echo $image; ?> " width="308px;"/>
                            <?php
                        } else {
                            ?>
                            <img src="_images/dummy.png" />	
                            <?php
                        }
                        ?>

                    </div>

                    <?php
                    //echo "SELECT p.id AS PID, u.id AS UID,u.type FROM tbl_profile_photos AS p LEFT OUTER JOIN tbl_users AS u ON u.id=p.user_id WHERE u.username='".$_GET['username']."' ORDER BY p.id DESC LIMIT 3";

                    $qry = getAnyTableWhereData("tbl_users", "AND username='" . $_GET['username'] . "' ");

                    $weq = $qry['type'];

                    $query = mysql_query("SELECT p.id AS PID, u.id AS UID,u.type FROM tbl_profile_photos AS p LEFT OUTER JOIN tbl_users AS u ON u.id=p.user_id WHERE u.username='" . $_GET['username'] . "' ORDER BY p.id DESC LIMIT 3");

                    if ((mysql_num_rows($query) > 0) && ($weq == 1)) {
                        ?>
                        <?php
                        while ($row1 = mysql_fetch_assoc($query)) {
                            ?>

                            <div class="profile_details_bottom"><a href="profile-images.php?id=<?php echo $row1['UID']; ?>"><img src="_uploads/profile_photo/thumb/<?php echo $row1['PID']; ?>.jpg" alt=" " width="100"/></a></div>

                            <?php
                        }
                        ?>

                        <a class="profile_btn" href="profile-images.php?id=<?php echo $profile_id; ?>">All photos</a>
                        <?php
                    }
                    ?>




                    <!---------------------------------------START-BIO-DIV------------------------------------------------>
                    <?php
                    $query2 = mysql_query("SELECT b.id AS BID,b.*, u.id AS UID,u.type FROM  tbl_user_details AS b LEFT OUTER JOIN tbl_users AS u ON u.id=b.user_id 
																							WHERE u.username='" . $_GET['username'] . "'");
                    $weq1 = mysql_fetch_assoc($query2);
                    //print_r($weq1);										
                    $row2 = mysql_fetch_assoc($query2);
                    //print_r($row2);
                    if ((mysql_num_rows($query2) > 0) && ($weq1['type'] == 1) && ($weq1['profile_display_status'] == 1)) {
                        ?>
                        <div class="bio_div">

                            <h2>Bio</h2>
                            <p style=""><?php echo nl2br(substr($weq1["biography"], 0, 300)); ?></p>
                            <a class="profile_btn" href="view_detailse.php?id=<?php echo $data['id']; ?>">View Details</a>

                        </div>
                        <?php
                    }
                    ?>

                    <!---------------------------------------END-BIO-DIV------------------------------------------------>	



                    <!---------------------------------------MYSTORE-DIV------------------------------------------------>

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
                                    <div class="store_detail_left"> <a href="view_book.php?id=<?php echo $profile_id; ?>"><img src="_uploads/profile_book_photo/thumb/<?php echo $row_bookdetailsl['bookid']; ?>.jpg" width="100" /></a></div>
                                    <div class="store_detail_right">
                                        <a href="view_book.php?id=<?php echo $profile_id; ?>"><h4><?php echo $row_bookdetailsl['name']; ?></h4></a>
                                        <span><?php echo $row_bookdetailsl['author']; ?></span> 
                                        <!--<a  href="#"><img src="_images/btn_button.png" border="0" alt="buynow"/></a>-->

                                    </div><div class="clear"></div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="storebtn_top_spece"><a class="profile_btn" href="view_book.php?id=<?php echo $profile_id; ?>">View All Books</a> </div>
                        </div>
                        <?php
                    }
                    ?>	
                    <!---------------------------------------END-MYSTORE-DIV------------------------------------------------>		





                </div><!--END DIV CLASS profile_details-->




            </div><!--END DIV CLASS profile_page_contnt_left-->


            <!---------------------------------------END-CONTENT-LEFT-DIV------------------------------------------------>











            <!---------------------------------------START-CONTENT-MIDDLE-DIV------------------------------------------------>

            <div class="profile_page_contnt_middle"><!--START DIV CLASS profile_page_contnt_middle-->
                <?php
                $query3 = mysql_query("SELECT tbl_users.*, tbl_profile_music.*,tbl_profile_music.id AS music_id FROM tbl_users LEFT OUTER JOIN 
																						tbl_profile_music ON tbl_users.id=tbl_profile_music.user_id WHERE username ='" . $_GET['username'] . "' AND tbl_profile_music.status='1'  
																						ORDER BY tbl_profile_music.id DESC LIMIT 0, 4 ");
                //$de=mysql_fetch_assoc($query3);
                // print_r($de);
                $numrows = mysql_num_rows($query3);
                if ($numrows > 0) {
                    ?>

                    <!-----------------START-MUSIC-DIV--------------->
                    <div class="music_div"><!--START DIV CLASS music_div-->

                        <!--	<a href="#">
                                <div class="ply_btn">
                                <span>I Remember Me</span></a></div>-->

                        <h2>Music</h2>
                        <ul>
                            <?php
                            while ($row3 = mysql_fetch_assoc($query3)) {
                                ?>	
                                <li>

                                    <?php /* ?><a id="audio" href="talents/music_play.php?filename=_uploads/profile_music/<?php echo $row3["music_id"];?>.mp3">
                                      <div class="ply_btn"></div>
                                      <span><?php echo $row3["music_title"];?></span>
                                      </a><?php */ ?>
                                    <?php /* ?><a href="music.php?filename=_uploads/profile_music/<?php echo $row3["music_id"]; ?>.mp3" style="float:right;color:#FFFFFF;" class="popup2">
                                      <div class="ply_btn"></div></a>
                                      <span><?php echo $row3["music_title"];?></span>
                                      <?php */ ?>

                                    <a  style="float:right;color:#FFFFFF;" onclick="return popitup('music.php?filename=_uploads/profile_music/<?php echo $row3["music_id"]; ?>.mp3')">
                                        <div style="margin-top:-9px;" class="ply_btn"></div></a>
                                    <span><?php echo $row3["music_title"]; ?></span>



                                </li>
                                <?php
                            }
                            ?>
                            <a class="profile_btn" href="profile-music.php?id=<?php echo $data['id']; ?>">All Songs</a>
                        </ul>

                    </div><!--END DIV CLASS music_div-->
                <?php } ?>	        
                <!-----------------END-MUSIC-DIV--------------->


                <!---------------------------------------START-BIO-DIV------------------------------------------------>
                <?php
                if ((mysql_num_rows($query2) > 0) && ($weq1['type'] == 0) && ($weq1['profile_display_status'] == 1)) {
                    ?>
                    <div style="margin-top:-5px;" class="bio_div">

                        <h2>About Me</h2>
                        <p ><?php echo nl2br(substr($weq1["biography"], 0, 300)); ?></p>
                        <a class="profile_btn" href="view_detailse.php?id=<?php echo $data['id']; ?>">View Details</a>

                    </div>
                    <?php
                }
                ?>

                <!---------------------------------------END-BIO-DIV------------------------------------------------>	





                <!---------------START-SOCIAL-LINKS-DIV--------------->
                <?php
                if (($row2["social_link1"] != '') || ($row2["social_link2"] != '') || ($row2["social_link3"] != '') || ($row2["social_link4"] != '')) {
                    ?>
                    <div class="social_links">
                        <h2>Social Links</h2>
                        <?php
                        if ($row2["social_link1"] != '') {
                            ?>
                            <a href="<?php echo $row2["social_link1"]; ?>"><img src="_images/fcbk_socl_mdia.png" border="0" alt="facebook"/></a>
                            <?php
                        }
                        if ($row2["social_link2"] != '') {
                            ?>
                            <a href="<?php echo $row2["social_link2"]; ?>"><img src="_images/twiter_socl_mdia.png" border="0" alt="twitter"/></a>
                            <?php
                        }
                        if ($row2["social_link3"] != '') {
                            ?>
                            <a href="<?php echo $row2["social_link3"]; ?>"><img src="_images/gplus_socl_mdia.png"border="0" alt="googleplus"/></a>
                            <?php
                        }
                        if ($row2["social_link4"] != '') {
                            ?>
                            <a href="<?php echo $row2["social_link4"]; ?>"><img src="_images/lindn_socl_mdia.png"border="0" alt="linkdin"/></a>
                        <?php } ?>

                    </div>
                <?php }
                ?>

                <!--become fan--> 
                <?php //if(((isset($_SESSION['user_id']))&&($_SESSION['user_id']<>$data['id']))||((isset($_SESSION['talent_id']))&&($_SESSION['talent_id']<>$data['id']))){ ?>
                <?php /* ?><div class="fan_button"><a href="add_fans.php?username=<?php echo $_GET['username']; ?>"><img src="_images/fan_btn.png" border="0"/></a></div><?php */ ?>
                <?php //} ?>

                <?php
                if (isset($_SESSION['talent_id'])) {
                    $mysql = mysql_query("SELECT type FROM tbl_users WHERE id='" . $_SESSION['talent_id'] . "' ");
                    $rest = mysql_fetch_assoc($mysql);
                    $mysql1 = mysql_query("SELECT * FROM tbl_users WHERE username='" . $_GET['username'] . "' ");
                    $rest1 = mysql_fetch_assoc($mysql1);

                    if ($rest['type'] == $rest1['type']) {
                        ?>
                        <div class="fan_button"><a href="add_fans.php?username=<?php echo $_GET['username']; ?>"><img src="_images/fan_btn.png" border="0"/></a></div>
                        <?php
                    }
                }
                ?>

                <?php
                /*                 * All fans Here* */

                $result5 = "SELECT * FROM  tbl_fans WHERE fan_id='" . $data['id'] . "' ORDER BY tbl_fans.id DESC";
                $sql5 = mysql_query($result5);
                $number = mysql_num_rows($sql5);
                //echo $number;
                //$data5=mysql_fetch_assoc($sql5);
                //print_r($data5);

                if ($number <> 0) {
                    ?>     
                    <!---------------END-SOCIAL-LINKS-DIV----------------->

                    <!-----------------------------------member biodata hear---------------------------->



                    <!---------------------------------------FANS-DIV------------------------------------------------>

                    <div class="fans_div">
                        <h2>Fans</h2>
                        <ul>
                            <?php
                            while ($data5 = mysql_fetch_assoc($sql5)) {
                                $result6 = mysql_query("SELECT username FROM  tbl_users WHERE id=" . $data5["profile_id"] . "");
                                $sql6 = mysql_fetch_assoc($result6);
                                //print_r($sql6);
                                ?>
                                <li><a href="profile-details.php?username=<?php echo $sql6['username'] ?>"><img src="_uploads/user_photo/<?php echo $data5["profile_id"] ?>.jpg" style="width:60px; height:45px;"/></a></li>
                                <?php
                            }
                            ?>
                            <div class="fansbtn_top_spece"><a class="profile_btn" href="profile-fans.php?id=<?php echo $data['id']; ?>">All Fans</a></div>
                        </ul>
                    </div>
                <?php } ?>
                <!-------------------------------------END FANS-DIV------------------------------------------------>


                <!-------------------------------------START PRODUCT-DIV------------------------------------------------>
                <?php
                $query_product = "SELECT tbl_users.*, tbl_products.*,tbl_products.id AS p_id FROM tbl_users LEFT OUTER JOIN 
																						tbl_products ON tbl_users.id=tbl_products.uid WHERE username ='" . $_GET['username'] . "' AND tbl_products.status='1'  
																						ORDER BY tbl_products.id DESC LIMIT 0, 2 ";
                $query_product_ro = mysql_query($query_product);
                $query_product_ro_2 = mysql_query($query_product);
                $row_product1 = mysql_fetch_assoc($query_product_ro_2);
                //print_r($row_product);

                if ((mysql_num_rows($query_product_ro) > 0)) {
                    ?>			
                    <div class="mystore">
                        <h2>Products</h2>
                        <?php
                        while ($row_product = mysql_fetch_assoc($query_product_ro)) {
                            ?>
                            <div class="store_detail">
                                <div class="store_detail_left"> 
                                    <a href="products_details.php?id=<?php echo $row_product['p_id']; ?>">
                                        <img src="_uploads/profile_product/thumb/<?php echo $row_product['p_id']; ?>.jpg" width="100" />
                                    </a>
                                </div>
                                <div class="store_detail_right">
                                    <a href="products_details.php?id=<?php echo $row_product['p_id']; ?>"><h4><?php echo $row_product['product_name']; ?></h4></a>
                                    <span class="pspan">$<?php echo $row_product['product_price']; ?></span> 
                                    <p class="product_details"><a href="products_details.php?id=<?php echo $row_product['p_id']; ?>">Product Details</a></p>

                                                                                                                        <!--<a  href="#"><img src="_images/btn_button.png" border="0" alt="buynow"/></a>-->

                                </div><div class="clear"></div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="storebtn_top_spece"><a class="profile_btn" href="view_products.php?id=<?php echo $row_product1['uid']; ?>">View All products</a> </div>
                    </div>
                <?php } ?>
                <!-------------------------------------END PRODUCT-DIV------------------------------------------------>



                <!------------------START-EVENT-AND-SHOWS-DIV---------------------------->


                <?php
                $cur_date = date('Y-m-d');
                $query_event = mysql_query("SELECT p.*, u.id AS UID FROM tbl_profile_events AS p LEFT OUTER JOIN tbl_users AS u ON u.id=p.uid WHERE u.username='" . $_GET['username'] . "' AND p.event_date >= '" . $cur_date . "' ORDER BY p.id DESC LIMIT 3");
                ?>
                <?php
                if (mysql_num_rows($query_event) > 0) {
                    ?>
                    <div class="eventandshows_div"><!--START DIV CLASS eventandshows_div-->
                        <h2 class="txt_1">events and shows</h2>

                        <?php
                        while ($rows_event = mysql_fetch_assoc($query_event)) {
                            ?>

                            <div class="event_detail"><a href="all_events_shows.php?id=<?php echo $rows_event['UID']; ?>"><!--START DIV CLASS event_detail-->
                                    <div class="event_detail_left">
                                        <div class="show_date">																
                                            <p><?php echo date('Y', strtotime($rows_event['event_date'])); ?></p>
                                            <p><?php echo date('F j', strtotime($rows_event['event_date'])); ?></p>																
                                        </div>
                                    </div>
                                    <div class="event_detail_right">
                                        <h3><?php echo $rows_event['name']; ?></h3>
                                        <span><?php echo $rows_event['location']; ?> | <?php echo $rows_event['event_time']; ?></span> 
                                    </div>
                                    <div class="clear"></div>
                                </a> </div><!--END DIV CLASS event_detail-->

                            <?php
                        }
                        ?>
                    </div><!--END DIV CLASS eventandshows_div-->
                    <div class="eventbtn_top_spece"><a class="profile_btn" href="all_events_shows.php?id=<?php echo $profile_id; ?>">All Events & Shows</a> </div>

                    <?php
                }
                ?>




                <!-------------------END-EVENT-AND-SHOWS-DIV--------------------------->


            </div><!--END DIV CLASS profile_details-->

            <!---------------------------------------END-CONTENT-MIDDLE-DIV------------------------------------------------>








            <!---------------------------------------START-CONTENT-RIGHT-DIV------------------------------------------------>
            <div class="profile_page_contnt_right">
                <?php
                $query4 = mysql_query("SELECT tbl_users.*,  tbl_profile_videos.*,tbl_profile_videos.id AS video_id FROM tbl_users LEFT OUTER JOIN 
                                         tbl_profile_videos ON tbl_users.id= tbl_profile_videos.user_id WHERE username ='" . $_GET['username'] . "' AND tbl_profile_videos.status='1'  ORDER BY tbl_profile_videos.id DESC LIMIT 1");
                $number = mysql_num_rows($query4);
                if ($number > 0) {
                    ?>
                    <!--------START-VIDEO-DIV----------->
                    <div class="video_div">
                        <h2>Video</h2>
                        <?php
                        while ($row4 = mysql_fetch_assoc($query4)) {
                            ?>
                            <a id="video" <?php if ($row4["video_type"] == 1) { ?>href="talents/video_play.php?filename=_uploads/profile_video/<?php echo $row4["video_id"]; ?>.mp4" <?php } else {
                                ?> href="talents/video_play.php?id=<?php echo $row4["video_id"];
               }
                            ?>" >

                                <div class="video_ply_btn"><img src="_images/vido_play_btn.png" border="0"/></div>

                            </a>
                            <img src="_uploads/video_photo/<?php echo $row4["video_id"]; ?>.jpg" width="315"/>

                            <?php
                        }
                        ?>

                        <a class="profile_btn" href="profile-video.php?id=<?php echo $data['id']; ?>">All Videos</a>
                    </div>
    <?php } ?>
                <!--------END-VIDEO-DIV----------->
                <!------------------------------member all photo hear--------------------->
                <?php
                //$query=mysql_query("SELECT p.id AS PID, u.id AS UID,u.type FROM tbl_profile_photos AS p LEFT OUTER JOIN tbl_users AS u ON u.id=p.user_id WHERE u.username='".$_GET['username']."' ORDER BY p.id DESC LIMIT 3");
                //$weq=mysql_fetch_assoc($query);
                //print_r($weq);
                ?>
                <?php
                if ((mysql_num_rows($query) > 0) && ($weq['type'] == 0)) {
                    ?>
                    <?php
                    while ($row1 = mysql_fetch_assoc($query)) {
                        ?>

                        <div class="profile_details_bottom"><a href="profile-images.php?id=<?php echo $row1['UID']; ?>"><img src="_uploads/profile_photo/thumb/<?php echo $row1['PID']; ?>.jpg" alt=" " width="100"/></a></div>

                        <?php
                    }
                    ?>

                    <a class="profile_btn" href="profile-images.php?id=<?php echo $profile_id; ?>">All photos</a>
                    <?php
                }
                ?>


                <!-----------------START-COMMENTS-DIV------------------->



                <?php
                $query_comment = mysql_query("SELECT c.id AS CID,c.profile_id,c.comment_text,c.commenter_id, u.id AS UID,u.first_name,u.last_name FROM  tbl_profile_comments AS c 
																									LEFT OUTER JOIN
																									tbl_users AS u ON u.id=c.profile_id WHERE u.username='" . $_GET['username'] . "' ORDER BY c.id DESC LIMIT 2");
                ?>

                <div class="comment_div"><!--START DIV comment_div-->
                    <h2>Comments</h2>	
                    <?php
                    if (mysql_num_rows($query_comment) > 0) {
                        ?>

                        <?php
                        while ($row_comment = mysql_fetch_assoc($query_comment)) {
                            $query_username = mysql_query("SELECT username FROM tbl_users WHERE id='" . $row_comment['commenter_id'] . "' ");
                            $rows_username = mysql_fetch_assoc($query_username);
                            ?>

                            <ul>
                                <li>
                                    <div class="post_imge"> <a href="profile-details.php?username=<?php echo $rows_username['username'] ?>"><img src="_uploads/user_photo/<?php echo $row_comment['commenter_id']; ?>.jpg" width="70px" height="60px" /></a></div>
                                    <div class="post_txt">
                                        <h3><a href="profile-details.php?username=<?php echo $rows_username['username'] ?>"> <?php echo $rows_username['username'] ?></a></h3>

                                        <p><?php echo substr($row_comment['comment_text'], 0, 25); ?> </p>
                                    </div>
                                    <div class="clear"></div>
                                </li>

                            </ul>
                            <?php
                        }
                        ?>

                        <?php
                    }
                    ?>


                    <div class="comntbtn_top_spece"><a class="profile_btn" href="profile-comment.php?id=<?php echo $data['id']; ?>">All Comments</a></div>

                    <!-----------------END-COMMENTS-DIV------------------->

                </div><!--END DIV comment_div-->

            </div><!---------------------------------------END-CONTENT-RIGHT-DIV------------------------------------------------>
            <div style="clear:both"></div> 
        </div><!--END DIV CLASS profile_page_contnt-->

    </div><!--END DIV CLASS profile_page_wraper-->


    <?php
} else {
    echo "<p class='err'>NO USER FOUND</p>";
}
?>


<?php
include('_includes/footer.php');
?>
