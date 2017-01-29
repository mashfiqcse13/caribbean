<?php
include('_includes/application-top.php');

include('_includes/class.Profile_pic.php');

/* USER COMMENT SUBMIT CHECK */
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'submit')) {
    $data = array(
        "profile_id" => $_POST['profile_id'],
        "commenter_id" => $_POST['talent_id'],
        "comment_text" => mysqli_real_escape_string($link, trim($_POST['comment_text'])),
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

    function get_videopath(id)
    {
        var url_video = $("#video_content_" + id).val();
        //alert(url_video);
        $("#video_div").load(url_video);
        $("#video_container").show();
        window.location.href = "#video_container";
    }

    function get_musicpath(id)
    {
        var url_video = $("#music_content_" + id).val();
        alert(url_video);
        $("#video_div").load(url_video);
        $("#video_container").show();
        window.location.href = "#video_container";
    }

    function close_videoplayer()
    {
        $("#video_container").hide();
        $("#video_div").html('');

    }


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
        //var Url="music.php?id="+Mid+"&pid="+Pid;
        newwindow = window.open(url, 'name', 'height=50,width=245');
        if (window.focus) {
            newwindow.focus()
        }
        return false;
    }
</script>

<script type="text/javascript">
    function popitup1(url) {
        //var Url="music.php?id="+Mid+"&pid="+Pid;
        newwindow = window.open(url, 'name', 'height=250,width=570');
        if (window.focus) {
            newwindow.focus()
        }
        return false;
    }
</script>
<style>
    .profile_details_top > img {
        max-width: 150px;
    }
</style>

<?php
$result = CheckProfileView($_GET['username']);

$data = getAnyTableWhereData("tbl_users", "AND username='" . $_GET['username'] . "' ");



if ($data['id'] != '') {
    if ((isset($_SESSION["talent_id"])) && ($_SESSION["talent_id"] != 0)) {
        $uid = $_SESSION["talent_id"];
    } elseif ((isset($_SESSION["user_id"])) && ($_SESSION["user_id"] != 0)) {
        $uid = $_SESSION["user_id"];
    } else {
        $_SESSION["talent_id"] = 0;
        $_SESSION["user_id"] = 0;
        $uid = "";
    }
    $query211 = mysqli_query($link, "SELECT profile_display_status FROM  tbl_user_profile_settings WHERE uid='" . $data['id'] . "'");
    $ror211 = mysqli_fetch_assoc($query211);



    $query111 = mysqli_query($link, "SELECT * FROM tbl_users WHERE username='" . $_GET['username'] . "'");
    $RESULT = mysqli_fetch_assoc($query111);
    $ror111 = mysqli_num_rows($query111);

    $member_profile_disply = getAnyTableWhereData("tbl_user_details", "AND user_id='" . $data['id'] . "' ");
    //echo $uid;
    //if(($RESULT['id']!=$uid)||(($ror211['profile_display_status']==1)&&($uid=="")) || ($RESULT['id']==$uid)){
    if ((($ror211['profile_display_status'] == 1) && (($uid == ""))) || ($RESULT['id'] == $uid) || ($uid != "") || (($RESULT['type'] == 0) && ($member_profile_disply['profile_display_status'] == 1))) {
        ?>
        <div class="profile_page_wraper"><!--START DIV CLASS profile_page_wraper	-->
            <div class="profile_page_contnt_heading">
                <span class="name_profile">
                    <?php
                    //$name = GetFullName($_GET['username']); echo $name . " "."is".' '."currently"." ";
                    $name = ($_GET['username']);
                    echo $name . " " . "is" . ' ' . "currently" . " ";
                    /* ###################GET VALUE FROM tbl_user_online############### */
                    $SQL_ONLI = mysqli_query($link, "SELECT id FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                    $SQL_RESULT = mysqli_fetch_array($SQL_ONLI);
                    //print_r($SQL_RESULT);
                    $SQL_QUERY = "SELECT * FROM tbl_user_online WHERE uid='" . $SQL_RESULT['id'] . "'";
                    $SQL_RESULT1 = mysqli_query($link, $SQL_QUERY);
                    $SQL_fetch = mysqli_fetch_array($SQL_RESULT1);
                    //print_r($SQL_fetch);
                    $SQL_ROWS = mysqli_num_rows($SQL_RESULT1);

                    if ($SQL_ROWS == '') {
                        ?>
                        <span style="color:#CCCCCC; font-size:18px; font-weight:bold;"><?php echo "OFFLINE"; ?></span>


                        <a href="send_msg.php?id=<?php echo $SQL_RESULT['id']; ?>" style="float:right; "> 
                            <img src="_images/send_msg.png" title="send message" />
                        </a>

                        <a href="chat.php?username=<?php echo $_GET['username']; ?>" style="float:right; " class="popup1"> 
                            <img src="_images/chat.png" title="Chat Now" style="margin-top:-2px;"  />
                        </a>

                        <?php /* ?><?php if((isset($_SESSION["talent_id"])) && ($_SESSION["talent_id"]!=0)){
                          $uid=$_SESSION["talent_id"];?>

                          <a href="send_msg.php?id=<?php echo $SQL_RESULT['id'];  ?>" style="float:right; "> <img src="_images/send_msg.png" title="send message" /></a>

                          <?php }elseif((isset($_SESSION["user_id"])) && ($_SESSION["user_id"]!=0)){
                          $uid=$_SESSION["user_id"];?>
                          <a href="send_msg.php?id=<?php echo $SQL_RESULT['id'];  ?>" style="float:right; "> <img src="_images/send_msg.png" title="send message" /></a>
                          <?php }?><?php */ ?>

                        <?php
                    } else {
                        ?>
                        <span style="color:#009900; font-size:18px; font-weight:bold;"><?php echo "ONLINE"; ?></span>

                        <?php
                        if ((isset($_SESSION["talent_id"])) && ($_SESSION["talent_id"] != 0)) {
                            $uid = $_SESSION["talent_id"];
                        } elseif ((isset($_SESSION["user_id"])) && ($_SESSION["user_id"] != 0)) {
                            $uid = $_SESSION["user_id"];
                        } else {
                            $_SESSION["talent_id"] = 0;
                            $_SESSION["user_id"] = 0;
                            $uid = "";
                        }

                        //if($SQL_RESULT['id']!=$uid){
                        //if((!isset($_SESSION["talent_id"]) || ($_SESSION["talent_id"]==0)) && (!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==0)){
                        ?>



                        <?php //}else{
                        ?>              				
                        <a href="send_msg.php?id=<?php echo $SQL_RESULT['id']; ?>" style="float:right;  "> 
                            <img src="_images/send_msg.png" title="Send Message" width="46"  />
                        </a>
                        <a href="chat.php?username=<?php echo $_GET['username']; ?>" style="float:right; width:70px; " class="popup1"> 
                            <img src="_images/chat.png" title="Chat Now" style="margin-top:-2px;"  />
                        </a>

                        <?php
                        //echo "here";
                        //}
                        //}
                    }
                    ?>
                    <!-----------------------------------------------
                    START MESSAGE
        ----------------------------------------------->
                    <?php /* ?><?php 
                      $name_user = GetFullName($_GET['username']);

                      $user_online=mysqli_query($link,"SELECT id FROM tbl_users WHERE username='".$_GET['username']."'");
                      $user_online_row=mysqli_fetch_array($user_online);

                      $user_query="SELECT * FROM tbl_user_online WHERE uid='" . $user_online_row['id'] . "'";
                      $user_query_online=mysqli_query($link,$user_query);
                      $user_query_online_row=mysqli_fetch_array($user_query_online);

                      $rows=mysqli_num_rows($SQL_RESULT1);

                      if($rows=='')


                      if((isset($_SESSION["talent_id"])) && ($_SESSION["talent_id"]!=0)){
                      $uid=$_SESSION["talent_id"];

                      echo "HERE";

                      }elseif((isset($_SESSION["user_id"])) && ($_SESSION["user_id"]!=0)){
                      $uid=$_SESSION["user_id"];
                      echo "HERE";
                      }
                      else{
                      $_SESSION["talent_id"]=0;
                      $_SESSION["user_id"]=0;
                      $uid="";
                      }


                      ?><?php */ ?>
                </span>
            </div>

            <div class="profile_page_contnt"><!--START DIV CLASS profile_page_contnt-->
                <div style="width:62%; float:right; display:none;"; id="video_container"> 
                    <div style="width:100%; position:relative; float:right; text-align:center; padding-bottom:10px;" id="video_div" >Please wait video loading...

                    </div>
                    <span id="close" style="float:right; text-align:right;">
                        <a href="javascript:void(0);" onclick="javascript:close_videoplayer();">Close</a>
                    </span>
                </div>
                <?php
                if (isset($_GET['op'])) {
                    ?>
                    <p class="msg">
                        <?php
                        if (isset($_GET['op']) AND ( $_GET['op'] == "suc")) {
                            $query27 = mysqli_query($link, "SELECT * FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                            $row27 = mysqli_fetch_assoc($query27);

                            echo "Congratulations,Now you are connected to " . $row27['first_name'] . " " . $row27['last_name'] . "";
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
                            $query26 = mysqli_query($link, "SELECT * FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                            $row26 = mysqli_fetch_assoc($query26);
                            echo "You are already connected to " . $row26['first_name'] . " " . $row26['last_name'] . "";
                        }
                        ?>
                    </p>
                <?php } ?>

                <!-----FRIST-------------------------------------------------------------SATRT-CONTENT-LEFT-DIV-------------------------------------------------------------------------------------->
                <?php
                $p_query = mysqli_query($link, "SELECT type,id FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                $p_result = mysqli_fetch_assoc($p_query);
//echo $p_result['id']; 
                if ($p_result['type'] == 1) {
                    $p_query1 = mysqli_query($link, "SELECT * FROM tbl_user_profile_settings WHERE uid='" . $p_result['id'] . "'");
                    $p_result1 = mysqli_fetch_assoc($p_query1);
//print_r($p_result1); 
                    ?>
                    <div class="profile_page_contnt_left"><!--START DIV CLASS profile_page_contnt_left-->

                        <div class="profile_details"><!--START DIV CLASS profile_details-->

                            <!---------------------------------------START-PROFILE PHOTOS-DIV--1------------------------------------------->

                            <div class="profile_details_top"><!--START DIV CLASS profile_photo-->
                                <?php
                                $query1 = mysqli_query($link, "SELECT id,type FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                                $row = mysqli_fetch_assoc($query1);
                                //echo $row['type'];
                                $profile_id = $row['id'];
                                //echo $row['id'];

                                $image = "_uploads/user_photo/" . $row['id'] . ".jpg";
                                //echo $image;
                                
//                                
                                $profile_pic = new Profile_pic($_SESSION["talent_id"], "talent");
                                $images_details = $profile_pic->get_gallery();
//                    echo '<pre>';
//                    print_r($images_details);
//                    die();
                                
                                if (file_exists($image)) {
                                    ?>
                                
                                   
                                    <a href="<?php echo "$image?" . time(); ?>" data-lightbox="01" ><img class="slide" src="<?php echo "$image?" . time(); ?>"></a>


                                             
                                             <?php
                                                $size = count($images_details);
                                                for($i=1;$i<$size;$i++){?>
                                                    
                                                    
                                    <a href="<?php echo $images_details[$i]['file_url'] . "?" . time(); ?>" data-lightbox="01" ><img style="display: none" class="slide" src="<?php echo $images_details[$i]['file_url'] . "?" . time(); ?>"></a>
                                                
                                                        <?php
                                                    }
                                             ?>
                                    
                                    
                                    
                                    
                                    <?php
                                } else {
                                    ?>
                                    <img src="_images/dummy.png" />	
                                    <?php
                                }
                                ?>

                            </div><!--END DIV CLASS profile_photo-->
                            <!---------------------------------------END-PROFILE PHOTOS-DIV------------------------------------------>

                            <?php
                            if ($p_result1['p_photo'] == 1) {
                                ?>

                                <!---------------------------------------START-PHOTOS-DIV----2-------------------------------------------->

                                <?php include('All_module/photo_module.php'); ?>
                                <!---------------------------------------END-PHOTOS-DIV------------------------------------------------>

                                <?php
                            }
                            if ($p_result1['p_bio'] == 1) {
                                ?>

                                <!---------------------------------------START-BIO-DIV---------3----------------------------------------->
                                <?php include('All_module/bio_module.php'); ?>
                                <!---------------------------------------END-BIO-DIV--------------------------------------------------->	

                                <?php
                            }
                            if ($p_result1['p_book'] == 1) {
                                ?>

                                <!---------------------------------------MY-Book-DIV-----------4----------------------------------------->
                                <?php include('All_module/book_module.php'); ?>
                                <!---------------------------------------END-MYSTORE-DIV------------------------------------------------>	<!--COPY 2-------------->

                                <?php
                            }
                            if ($p_result1['p_music'] == 1) {
                                ?>

                                <!---------------------------------------START-MUSIC-DIV--------5---------------------------------------->	
                                <?php include('All_module/music_module.php'); ?>    
                                <!---------------------------------------END-MUSIC-DIV------------------------------------------------>

                                <?php
                            }
                            if ($p_result1['p_social'] == 1) {
                                ?>

                                <!---------------------------------------START-SOCIAL-LINKS-DIV--------6------------------------------->
                                <?php include('All_module/social_module.php'); ?>  
                                <!---------------------------------------END-SOCIAL-LINKS-DIV--------------------------------------->

                                <?php
                            }
                            if ($p_result1['p_fans'] == 1) {
                                ?>

                                <!---------------------------------------FANS-DIV-----------------7---------------------------------->
                                <?php include('All_module/fans_module.php'); ?>     
                                <!-------------------------------------END FANS-DIV------------------------------------------------>

                                <?php
                            }
                            if ($p_result1['p_product'] == 1) {
                                ?>

                                <!-------------------------------------START PRODUCT-DIV----------8-------------------------------------->
                                <?php include('All_module/product_module.php'); ?>
                                <!-------------------------------------END PRODUCT-DIV------------------------------------------------>

                                <?php
                            }
                            if ($p_result1['p_event'] == 1) {
                                ?>

                                <!--------------------------------------START-EVENT-AND-SHOWS-DIV----------9--------------------------->
                                <?php include('All_module/events_module.php'); ?>
                                <!--------------------------------------END-EVENT-AND-SHOWS-DIV-------------------------------------> 

                                <?php
                            }
                            if ($p_result1['p_video'] == 1) {
                                ?>

                                <!--------------------------------------START-VIDEO-DIV---------10------------------------------------>    
                                <?php include('All_module/video_module.php'); ?>
                                <!--------------------------------------END-VIDEO-DIV--------------------------------------------->

                                <?php
                            }
                            if ($p_result1['p_comments'] == 1) {
                                ?>

                                <!--------------------------------------START-COMMENTS-DIV--------11--------------------------------->
                                <?php include('All_module/comment_module.php'); ?>
                                <!--------------------------------------END-COMMENTS-DIV----------------------------------------->	
                            <?php } ?>

                        </div><!--END DIV CLASS profile_details-->
                    </div><!--END DIV CLASS profile_page_contnt_left-->
                    <?php
                }
                if ($p_result['type'] == 0) {
                    ?>

                    <div class="profile_page_contnt_left"><!--START DIV CLASS profile_page_contnt_left-->



                        <div class="profile_details"><!--START DIV CLASS profile_details-->
                            <div class="profile_details_top"><!--START DIV CLASS profile_photo-->
                                <?php
                                $query1 = mysqli_query($link, "SELECT id,type FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                                $row = mysqli_fetch_assoc($query1);
                                //echo $row['type'];
                                $profile_id = $row['id'];
                                //echo $row['id'];

                                $image = "_uploads/user_photo/" . $row['id'] . ".jpg";
                                //echo $image;
                                
                                
                                 $profile_pic = new Profile_pic($_SESSION["user_id"], "talent");
                                $images_details = $profile_pic->get_gallery();
                                
                                if (file_exists($image)) {
                                    ?>
                                 <a href="<?php echo "$image?" . time(); ?>" data-lightbox="01"><img class="slide" src="<?php echo "$image?" . time(); ?>"></a>


                                             
                                             <?php
                                                $size = count($images_details);
                                                for($i=1;$i<$size;$i++){?>
                                                    
                                                    
                                    <a href="<?php echo $images_details[$i]['file_url'] . "?" . time(); ?>" data-lightbox="01" ><img style="display: none" class="slide" src="<?php echo $images_details[$i]['file_url'] . "?" . time(); ?>"></a>
                                                
                                                        <?php
                                                    }
                                             ?>
                                    
                                    
                                    
                                    
                                    <?php
                                } else {
                                    ?>
                                    <img src="_images/dummy.png" />	
                                    <?php
                                }
                                ?>

                            </div><!--END DIV CLASS profile_photo-->	

                            <!---------------------------------------START-BIO-DIV---------3----------------------------------------->
                            <?php include('All_module/m_bio_module.php'); ?>
                            <!---------------------------------------END-BIO-DIV--------------------------------------------------->	
                        </div><!--END DIV CLASS profile_details-->  
                    </div><!--END DIV CLASS profile_page_contnt_left-->
                <?php } ?>


                <!----------------------------------------------------------------------------------------END-CONTENT-LEFT-DIV------------------------------------------------------------------------------------------>

                <!----SECOND-------------------------------------------------------------------------------------START-CONTENT-MIDDLE-DIV------------------------------------------------------------------------------------>					
                <div class="profile_page_contnt_middle"><!--START DIV CLASS profile_page_contnt_middle-->



                    <?php
                    $p_query = mysqli_query($link, "SELECT type,id FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                    $p_result = mysqli_fetch_assoc($p_query);
//echo $p_result['id']; 
                    if ($p_result['type'] == 1) {
                        $p_query1 = mysqli_query($link, "SELECT * FROM tbl_user_profile_settings WHERE uid='" . $p_result['id'] . "'");
                        $p_result1 = mysqli_fetch_assoc($p_query1);
//print_r($p_result1); 
                        ?>
                        <div class="profile_page_contnt_left"><!--START DIV CLASS profile_page_contnt_middle-->

                            <div class="profile_details"><!--START DIV CLASS profile_details-->
                                <?php
                                if ($p_result1['p_music'] == 2) {
                                    ?>

                                    <!---------------------------------------START-PHOTOS-DIV----2-------------------------------------------->
                                    <?php include('All_module/music_module.php'); ?>
                                    <!---------------------------------------END-PHOTOS-DIV------------------------------------------------>

                                    <?php
                                }
                                if ($p_result1['p_video'] == 2) {
                                    ?>

                                    <!---------------------------------------START-BIO-DIV---------3----------------------------------------->
                                    <?php include('All_module/video_module.php'); ?>
                                    <!---------------------------------------END-BIO-DIV--------------------------------------------------->	

                                    <?php
                                }
                                if ($p_result1['p_book'] == 2) {
                                    ?>

                                    <!---------------------------------------MY-Book-DIV-----------4----------------------------------------->

                                    <?php include('All_module/book_module.php'); ?>
                                    <!---------------------------------------END-MYSTORE-DIV------------------------------------------------>	<!--COPY 2-------------->

                                    <?php
                                }
                                if ($p_result1['p_product'] == 2) {
                                    ?>

                                    <!---------------------------------------START-MUSIC-DIV--------5---------------------------------------->	
                                    <?php include('All_module/product_module.php'); ?>         
                                    <!---------------------------------------END-MUSIC-DIV------------------------------------------------>

                                    <?php
                                }
                                if ($p_result1['p_photo'] == 2) {
                                    ?>

                                    <!---------------------------------------START-SOCIAL-LINKS-DIV--------6------------------------------->
                                    <?php include('All_module/photo_module.php'); ?>  

                                    <!---------------------------------------END-SOCIAL-LINKS-DIV--------------------------------------->

                                    <?php
                                }
                                if ($p_result1['p_event'] == 2) {
                                    ?>

                                    <!---------------------------------------FANS-DIV-----------------7---------------------------------->
                                    <?php include('All_module/events_module.php'); ?> 
                                    <!-------------------------------------END FANS-DIV------------------------------------------------>

                                    <?php
                                }
                                if ($p_result1['p_bio'] == 2) {
                                    ?>

                                    <!-------------------------------------START PRODUCT-DIV----------8-------------------------------------->
                                    <?php include('All_module/bio_module.php'); ?>
                                    <!-------------------------------------END PRODUCT-DIV------------------------------------------------>

                                    <?php
                                }
                                if ($p_result1['p_fans'] == 2) {
                                    ?>

                                    <!--------------------------------------START-EVENT-AND-SHOWS-DIV----------9--------------------------->
                                    <?php include('All_module/fans_module.php'); ?>
                                    <!--------------------------------------END-EVENT-AND-SHOWS-DIV-------------------------------------> <!----------COPY 3-------> 

                                    <?php
                                }
                                if ($p_result1['p_social'] == 2) {
                                    ?>

                                    <!--------------------------------------START-VIDEO-DIV---------10------------------------------------>    
                                    <?php include('All_module/social_module.php'); ?>
                                    <!--------------------------------------END-VIDEO-DIV--------------------------------------------->

                                    <?php
                                }
                                if ($p_result1['p_comments'] == 2) {
                                    ?>

                                    <!--------------------------------------START-COMMENTS-DIV--------11--------------------------------->
                                    <?php include('All_module/comment_module.php'); ?>
                                    <!--------------------------------------END-COMMENTS-DIV----------------------------------------->	
                                <?php } ?>

                            </div><!--END DIV CLASS profile_details-->
                        </div><!--END DIV CLASS profile_page_contnt_left-->
                        <?php
                    }
                    if ($p_result['type'] == 0) {
                        ?>

                        <div class="profile_page_contnt_left"><!--START DIV CLASS profile_page_contnt_left-->

                            <div class="profile_details"><!--START DIV CLASS profile_details-->
                                <!---------------------------------------START-PHOTOS-DIV----2-------------------------------------------->
                                <?php include('All_module/m_photo_module.php'); ?>
                                <!---------------------------------------END-PHOTOS-DIV------------------------------------------------>

                                <!---------------------------------------FANS-DIV-----------------7---------------------------------->

                                <?php include('All_module/m_fans_module.php'); ?>
                                <!-------------------------------------END FANS-DIV------------------------------------------------>

                            </div><!--END DIV CLASS profile_details-->  
                        </div><!--END DIV CLASS profile_page_contnt_left-->
                    <?php } ?>




                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                    }
                    ?>


                    <?php include 'All_module/user-fav/images-modul.php'; ?>
                    <?php include 'All_module/user-fav/music-modul.php'; ?>
                    <?php include 'All_module/user-fav/video-modul.php'; ?>



                </div><!--END DIV CLASS profile_page_contnt_middle-->
                <!---------------------------------------------------------------------------------------END-CONTENT-MIDDLE-DIV------------------------------------------------------------------------------------------------------>

                <!--------THIRD---------------------------------------------------------------------------------START-CONTENT-RIGHT-DIV----------------------------------------------------------------------------------------->
                <div class="profile_page_contnt_right"><!--END DIV CLASS profile_page_contnt_RIGHT-->
                    <?php
                    $p_query = mysqli_query($link, "SELECT type,id FROM tbl_users WHERE username='" . $_GET['username'] . "'");
                    $p_result = mysqli_fetch_assoc($p_query);
//echo $p_result['id']; 
                    if ($p_result['type'] == 1) {
                        $p_query1 = mysqli_query($link, "SELECT * FROM tbl_user_profile_settings WHERE uid='" . $p_result['id'] . "'");
                        $p_result1 = mysqli_fetch_assoc($p_query1);
//print_r($p_result1); 
                        ?>
                        <div class="profile_page_contnt_left"><!--START DIV CLASS profile_page_contnt_middle-->

                            <div class="profile_details"><!--START DIV CLASS profile_details-->

                                <?php
                                if ($p_result1['p_music'] == 3) {
                                    ?>

                                    <!---------------------------------------START-PHOTOS-DIV----2-------------------------------------------->
                                    <?php include('All_module/music_module.php'); ?>
                                    <!---------------------------------------END-PHOTOS-DIV------------------------------------------------>

                                    <?php
                                }
                                if ($p_result1['p_video'] == 3) {
                                    ?>

                                    <!---------------------------------------START-BIO-DIV---------3----------------------------------------->
                                    <?php include('All_module/video_module.php'); ?>
                                    <!---------------------------------------END-BIO-DIV--------------------------------------------------->	

                                    <?php
                                }
                                if ($p_result1['p_book'] == 3) {
                                    ?>

                                    <!---------------------------------------MY-Book-DIV-----------4----------------------------------------->

                                    <?php include('All_module/book_module.php'); ?>
                                    <!---------------------------------------END-MYSTORE-DIV------------------------------------------------>	<!--COPY 2-------------->

                                    <?php
                                }
                                if ($p_result1['p_product'] == 3) {
                                    ?>

                                    <!---------------------------------------START-MUSIC-DIV--------5---------------------------------------->	
                                    <?php include('All_module/product_module.php'); ?>         
                                    <!---------------------------------------END-MUSIC-DIV------------------------------------------------>

                                    <?php
                                }
                                if ($p_result1['p_photo'] == 3) {
                                    ?>

                                    <!---------------------------------------START-SOCIAL-LINKS-DIV--------6------------------------------->
                                    <?php include('All_module/photo_module.php'); ?>  

                                    <!---------------------------------------END-SOCIAL-LINKS-DIV--------------------------------------->

                                    <?php
                                }
                                if ($p_result1['p_event'] == 3) {
                                    ?>

                                    <!---------------------------------------FANS-DIV-----------------7---------------------------------->
                                    <?php include('All_module/events_module.php'); ?> 
                                    <!-------------------------------------END FANS-DIV------------------------------------------------>

                                    <?php
                                }
                                if ($p_result1['p_bio'] == 3) {
                                    ?>

                                    <!-------------------------------------START PRODUCT-DIV----------8-------------------------------------->
                                    <?php include('All_module/bio_module.php'); ?>
                                    <!-------------------------------------END PRODUCT-DIV------------------------------------------------>

                                    <?php
                                }
                                if ($p_result1['p_fans'] == 3) {
                                    ?>

                                    <!--------------------------------------START-EVENT-AND-SHOWS-DIV----------9--------------------------->
                                    <?php include('All_module/fans_module.php'); ?>
                                    <!--------------------------------------END-EVENT-AND-SHOWS-DIV-------------------------------------> <!----------COPY 3-------> 

                                    <?php
                                }
                                if ($p_result1['p_social'] == 3) {
                                    ?>

                                    <!--------------------------------------START-VIDEO-DIV---------10------------------------------------>    
                                    <?php include('All_module/social_module.php'); ?>
                                    <!--------------------------------------END-VIDEO-DIV--------------------------------------------->

                                    <?php
                                }
                                if ($p_result1['p_comments'] == 3) {
                                    ?>

                                    <!--------------------------------------START-COMMENTS-DIV--------11--------------------------------->
                                    <?php include('All_module/comment_module.php'); ?>
                                    <!--------------------------------------END-COMMENTS-DIV----------------------------------------->	
                                <?php } ?>
                                <!--------------------------------------START-ACTIVITY-DIV--------12--------------------------------->
                                <?php include('All_module/activity_module.php'); ?>


                            </div><!--END DIV CLASS profile_details-->
                        </div><!--END DIV CLASS profile_page_contnt_left-->
                        <?php
                    }
                    if ($p_result['type'] == 0) {
                        ?>

                        <div class="profile_page_contnt_left"><!--START DIV CLASS profile_page_contnt_left-->

                            <div class="profile_details"><!--START DIV CLASS profile_details-->
                                <!--------------------------------------START-COMMENTS-DIV--------11--------------------------------->
                                <?php include('All_module/m_comment_module.php'); ?>
                                <!--------------------------------------END-COMMENTS-DIV----------------------------------------->


                                <!--------------------------------------START-ACTIVITY-DIV--------12--------------------------------->
                                <?php include('All_module/activity_module.php'); ?>		
                            </div><!--END DIV CLASS profile_details-->  
                        </div><!--END DIV CLASS profile_page_contnt_left-->
                    <?php } ?>

                </div><!--END DIV CLASS profile_page_contnt_RIGHT-->
                <!---------------------------------------------------------------------------------------------END-CONTENT-RIGHT-DIV-------------------------------------------------------------------------------->
                <div style="clear:both"></div> 





            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="content"><!--START CLASS contant PART -->
            <h2><p class='err_yellowdark'>WANT TO VIEW THIS PROFILE ? THEN LOGIN FIRST .</p></h2>


        </div>
        <?php
        //echo "<p class='err'>WANT TO VIEW THIS PROFILE ? THEN LOGIN FIRST .</p>";
    }
} else {
    echo "<p class='err' align='center'><strong>User Not Found</strong></p>";
}
include('_includes/footer.php');
?>
