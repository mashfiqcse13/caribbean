<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include('meta.php'); ?>
        <title>Caribbean Circle Stars</title>
        <!--<script>
                window.onbeforeunload = function (e) {
                    var e = e || window.event;
                    var msg = "Do you really want to leave this page?"
        
                    // For IE and Firefox
                    if (e) {
                        e.returnValue = msg;
                    }
        
                    // For Safari / chrome
                    return msg;
                 };
        </script>-->
        <?php
        /* if($_POST['contact_submit']== "1"){ 
          header('Location: contact.php');
          } */
        ?>
        <!--<script>
                };
        </script>-->

    </head>
    <style>
        .main{display:none;}
    </style>
    <body>

        <div class="main" style="overflow:hidden !important">
            <div class="bg" style="background-color:#000; opacity:0.5; z-index:5;  width:100% !important; height:100% !important; position:fixed; overflow:hidden;  ">
            </div>
            <div style="z-index:10; background-color:#f1f1f1; width:300px; height:100px; margin-left:40%; position:fixed; padding:10px; border-radius:10px; padding-top: 18px; ">

                You have entered Wrong Number
                <p style="float:right; margin-right:10px; margin-top:70px;"><input type="button" style="width:70px;" name="btnpop" id="btnpop" value="Ok" /></p>

            </div>

        </div>
        </div>  
        <div class="wrapper">

            <div class="top_content">

                <div class="logo">
                    <a href="<?php echo SITE_URL ?>"><img src="<?php echo SITE_URL ?>_images/logo.png" /></a>       
                </div>

                <div class="head_img">
                    <img src="<?php echo SITE_URL ?>_images/head_img.png" />
                </div>

                <div class="right_head">
                    <?php
                    
                    function view1(){
                    ?>
                        <a style="float:left; margin-bottom:10px;" href="<?php echo SITE_URL ?>talents/member.php"><img src="<?php echo SITE_URL ?>_images/membr_area.png"/></a>
                        <a style="float:right; margin-bottom:10px; margin-right:2px;" href="<?php echo SITE_URL ?>talents/logout.php"><img src="<?php echo SITE_URL ?>_images/btn_logout.png"/></a>
                    <?php
                    }
                    function view2(){
                    ?>
                         <a style="float:left; margin-bottom:10px;" href="<?php echo SITE_URL ?>member/member.php"><img src="<?php echo SITE_URL ?>_images/membr_area.png"/></a>
                        <a style="float:right; margin-bottom:10px; margin-right:2px;" href="<?php echo SITE_URL ?>member/log-out.php"><img src="<?php echo SITE_URL ?>_images/btn_logout.png"/></a>
                      
                    <?php    
                    }
                   function view3(){
                       ?>
                       <a href="<?php echo SITE_URL ?>talents/login.php"><img src="<?php echo SITE_URL ?>_images/button_1.png"/></a>
                       <a href="<?php echo SITE_URL ?>member/login.php"><img src="<?php echo SITE_URL ?>_images/button_2.png" class="img_1" /></a>
                   <?php
                   }
                   
                   $a=(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 'YES');
                   $b=(isset($_SESSION['talent_login']) && $_SESSION['talent_login'] == 1);
                   $c=(isset($_SESSION['user_login']) && $_SESSION['user_login'] == 1);
                   
                   if(($b)){
                       view1();
                   }
                   elseif ($c) {
                       view2();
                   }
                   else if( ($a == false && $b == false  && $c == false )  ){
                       view3();
                   }
                   ?>  
                    <div id="textbox">
                        <form id="form1" name="form1" method="post" action="<?php echo SITE_URL; ?>search.php">

                            <div style="clear:both; float:left; margin:0px; padding:0px; width:225px;">	
                                <div style="clear:both; float:left; margin:0px; padding:0px; width:200px;"><label><input type="text" name="search" id="search" placeholder="Search friend..." class="searchbox" /></label></div> 
                                <div style="float:right; margin:0px; padding:0px; width:25px; text-align:left"><input type="submit" name="submit" value="" class="btnsearch" /></div>     
                            </div>  
                        </form>        	 
                    </div>
                    <div class="cart"> 
                        <a href="<?php echo SITE_URL ?>shopping_cart.php"><img src="<?php echo SITE_URL ?>_images/cart_icon.png" class="img_3" /></a><a href="<?php echo SITE_URL ?>shopping_cart.php">Shopping cart</a>
                        <?php
                        if ($identity != '') {
                            $query55 = mysqli_query($link,"SELECT * FROM tbl_shopping_cart WHERE uid='" . $identity . "'");

                            $rows55 = mysqli_num_rows($query55);
                            echo "(" . $rows55 . ")";
                        }
                        ?>
                    </div>     
                </div>

            </div>


            <div class="menu">
                <ul>
                    <li><a href="<?php echo SITE_URL ?>">Home</a></li>
                    <li><a href="<?php echo SITE_URL ?>about.php">About</a></li>
                    <li><a href="<?php echo SITE_URL ?>spotlight.php">Spotlight</a></li>
                    <li><a href="<?php echo SITE_URL ?>donate.php">Donate</a></li>
                    <li><a href="<?php echo SITE_URL ?>forum.php">Forum</a></li>
                    <li><a href="<?php echo SITE_URL ?>contact.php">Contact</a></li>
                </ul>
            </div>