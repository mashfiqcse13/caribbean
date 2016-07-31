<?php
include('../_includes/application-top.php');
$_SESSION['user_login'] = 0;
/* function yearsDifference($endDate, $beginDate)
  {
  $date_parts1=explode("/", $beginDate);
  $date_parts2=explode("/", $endDate);
  return $date_parts2[2] - $date_parts1[2];
  }
 */
//echo yearsDifference('2011-03-12','2008-03-09');


/* require_once dirname(__FILE__) . '/securimage/securimage.php';
  $securimage = new Securimage();
  $captcha = $_POST['ct_captcha'];
  $errors  =   "";
  if(isset($captcha) && !empty($captcha))
  {
  if ($securimage->check($captcha) == false) {
  $errors = 'Incorrect security code entered';
  }
  //END
  } */
$captcha = $_POST['ct_captcha'];
$errors = "";
if (isset($captcha) && !empty($captcha)) {
    /* if ($securimage->check($captcha) == false) {
      $errors = 'Incorrect security code entered';
      } */
    if (empty($_SESSION['security_code1']) || strcasecmp($_SESSION['security_code1'], $captcha) != 0) {
        $errors = 'Incorrect security code entered';
    }
    //END
}


if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Register') AND $errors == "") {

    $query = "SELECT * FROM tbl_users WHERE email='" . trim($_POST['email']) . "' AND status=1 ";
    $user_exit = mysqli_query($link,$query);
    $count = mysqli_num_rows($user_exit);


    //$start_date=date('Y-m-d', strtotime($_POST['age']));
    /* $start_date1=explode("-", $_POST['age']);
      $start_date=$start_date1[0] . "-" . $start_date1[1] . "-" . $start_date1[2];

      $d1 = new DateTime(date('Y-m-d'));
      $d2 = new DateTime($start_date);
      $diff = $d2->diff($d1);
      $y=$diff->y;

      if($y>="13"){ */
    if ($count > 0) {
        $MSG = "Email Already Exists";
        extract($_POST);
    } else {
        $age = explode('-', $_POST['age']);
        $age = $age['0'] . '-' . $age['1'] . '-' . $age['2'];


        $mac = $_REQUEST['hid_mac'];



        $chkqry = mysqli_query($link,"SELECT * FROM tbl_users WHERE mac_address='$mac'");

        if (mysqli_num_rows($chkqry) > 0) {
            $totl_rec = mysqli_num_rows($chkqry);
            while ($row = mysqli_fetch_assoc($chkqry)) {
                $mac_count = $row['allowed_mac'];
            }

            if ($totl_rec < $mac_count) {
                $newmac = 1;
            } else {
                $newmac = 0;
            }
        } else {
            $newmac = 1;
        }



        if ($newmac == 1) {
            $mymac5 = substr(md5(rand(0, 5000) . 'mac_adr' . rand(6000, 15000)), 0, 25);



            $data = array(
                "username" => mysqli_real_escape_string( $link ,trim($_POST['username'])),
                "password" => mysqli_real_escape_string( $link ,trim($_POST['conframpassword'])),
                "first_name" => mysqli_real_escape_string( $link ,trim($_POST['first_name'])),
                "last_name" => mysqli_real_escape_string( $link ,trim($_POST['last_name'])),
                "phone_no" => mysqli_real_escape_string( $link ,trim($_POST['phone_no'])),
                "email" => mysqli_real_escape_string( $link ,trim($_POST['email'])),
                "city" => $_POST['city'],
                "country" => mysqli_real_escape_string( $link ,trim($_POST['country'])),
                "sex" => $_POST['sex'],
                "age" => $age,
                "type" => '0',
                "status" => '1',
                "joining_time" => date("h:i:s A"),
                "join_date" => date("Y-m-d"),
                "mac_address" => $mymac5
            );

            $table = "tbl_users";
            insertData($data, $table);
            $l_id = mysqli_insert_id($link);
            //////////////////////////SEND_EMAIL_TO_MEMBER_REGISTER_EMAIL_ADDRESS////////////////////////

            $to = mysqli_real_escape_string( $link ,trim($_POST['email']));

            $subject = "CCS: Registration email";

            /* $msg="Welcome"."<br><br>"."Dear ".mysqli_real_escape_string( $link ,trim($_POST['first_name']))." ".mysqli_real_escape_string( $link ,trim($_POST['last_name']))."<br>"."

              Thank you for registring at ccs. At CCS you can highlight your profile as talent, sale music, videos, photos, books etc or as a member you

              can simply browse through artist profile, listen to their music, watch video, view photos, become fans/friends with others, chat, send

              messages, buy product and many more exciting things to do ...

              Get Started Now, <a href=http://test.solutiononline.org/caribbeancirclestars/> [Click Here]</a>

              Kind Redards -
              Team CCS
              "; */

            $msg = "Welcome To CCS" . "<br><br>" . "Dear Member,<br><br>" . "

                 Thank you for registering at CCS.  At CCS you can highlight your profile as Talent Member, sell music, videos, photos, books etc, or as a Patron Member you can simply browse throug h any artist profile.
                 Listen to their music, watch video, view photos, use the forum, become fans/friends with others, chat, send messages, buy products and many more exciting things to do.
                 <br/><br/>
                 Your User Name:- " . (trim($_POST['username'])) . "<br/>
                 Your Password:- " . (trim($_POST['conframpassword'])) . "<br/>
                 <br/>
                 So let us get Started. <a href='http://www.caribbeancirclestars.com/member/login.php?op=a&lid=$l_id'>[Click Here To Confirm Your Membership]</a>
                 <br/>
                 <br/>
                 <br/>
                Thank you,
                <br/>
                <br/>
                 CCS Management and Staff.";

            $from = 'admin@caribbeancirclestars.com';


            SendEMail($to, $subject, $msg, $from);

            //header("Location:member.php?op=a");
            //header("Location:membersuccess.php?op=register");
            ?>
            <script type="text/javascript">
                localStorage.setItem('my_mac_addr', '<?php echo $mymac5; ?>');
                window.location.href = 'membersuccess.php?op=register';

                function new_captcha()
                {
                    var c_currentTime = new Date();
                    var c_miliseconds = c_currentTime.getTime();
                    document.getElementById('captcha').src = '_includes/image.php?x=' + c_miliseconds;
                }
            </script>

            <?php
        } else {

            $data = array(
                "username" => mysqli_real_escape_string( $link ,trim($_POST['username'])),
                "password" => mysqli_real_escape_string( $link ,trim($_POST['conframpassword'])),
                "first_name" => mysqli_real_escape_string( $link ,trim($_POST['first_name'])),
                "last_name" => mysqli_real_escape_string( $link ,trim($_POST['last_name'])),
                "phone_no" => mysqli_real_escape_string( $link ,trim($_POST['phone_no'])),
                "email" => mysqli_real_escape_string( $link ,trim($_POST['email'])),
                "city" => $_POST['city'],
                "country" => mysqli_real_escape_string( $link ,trim($_POST['country'])),
                "sex" => $_POST['sex'],
                "age" => $age,
                "type" => '0',
                "status" => '0',
                "joining_time" => date("h:i:s A"),
                "join_date" => date("Y-m-d"),
                "mac_address" => $mac,
                "new_mac_req" => 1
            );
            $table = "tbl_users";
            //echo '<pre>';print_r($data);
            insertData($data, $table);
            ?>
            <script type="text/javascript">
                alert('Please contact admin to complete sign up!');
            </script>
            <?php
        }
    }
}/* else{
  $error="you must be 13 yrs to join CCS.";
  extract($_POST);
  }


  } */

include('../_includes/header.php');
?>
<!--<div style="margin: 0 auto;width: 300px"><h1>UNDER CONSTRUCTION</h1></div>-->
<script type="text/javascript">
    $(document).ready(function () {
        $("#nontalents_reg").validate({
            rules: {
                username: {
                    required: true, minlength: 2, maxlength: 30
                },
                phone_no: {
                    required: true, minlength: 7, maxlength: 10
                },
                password: {
                    required: true, minlength: 7, maxlength: 15
                },
                conframpassword: {
                    required: true, equalTo: "#password", minlength: 2, maxlength: 30
                },
                ct_captcha: {
                    required: true, equalTo: "#ct_captcha"
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("type") == "checkbox") {
                    error.insertAfter(element.parent().last());
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });

    $(document).ready(function () {
        $("#age").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 46 || e.which > 57))
            {
                return false;
            }
        });
        //$("#phone").keypress(function (e){
//
//        var phone_length = $("#phone").val().length;
//         if((phone_length == 3 || phone_length == 7) && e.which != 8)
//         {
//             $("#phone").val($("#phone").val()+"-");
//         }
//         else if(phone_length > 11 && e.which != 8)
//         {
//             return false;
//         }
//
//
//			if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57) && e.which!=45)
//			  {
//				return false;
//			   }
//	});



        jQuery.fn.forceNumeric = function () {

            return this.each(function () {
                $(this).keydown(function (e) {
                    var key = e.which || e.keyCode;

                    if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
                            // numbers   
                            key >= 48 && key <= 57 ||
                            // Numeric keypad
                            key >= 96 && key <= 105 ||
                            // Backspace and Tab and Enter
                            key == 8 || key == 9 || key == 13 ||
                            // left and right arrows
                            key == 37 || key == 39)
                        return true;

                    return false;
                });
            });
        }

        $("#phone").forceNumeric();

        $("#username").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))
            {
                return false;
            }
        });
        $("#age").datepicker({
            changeMonth: true,
            changeYear: true,
            //dateFormat: 'dd/mm/yy'
            dateFormat: 'yy-mm-dd',
            maxDate: new Date(2002, 01, 01)
        });
    });
    function correct_number()
    {
        var loc_val = $("#location").val();

        var new_loc = loc_val.split("-");
        var phone = $("#phone").val();

        if (phone.length > 3)
        {
            var new_ph = new Array();
            new_ph[0] = phone.substr(0, 3);

            if (phone.substr(0, 2) == '53')
            {
                new_ph[0] = '0' + phone.substr(0, 2);
            }
            new_ph[1] = phone.substr(3, 3);
            new_ph[2] = phone.substr(6, 4);
            if (new_ph[2] == undefined)
            {
                new_ph[2] = "000";
            }
            if (new_ph[1] == undefined)
            {
                new_ph[1] = "0000";
            }



            if (new_loc[2])
            {
                if ((new_loc[1]) != new_ph[0] && (new_loc[2]) != new_ph[0])
                {
                    alert("You have entered Wrong Number");
                    $("#phone").css("border", "3px solid green");
                    $("#phone").focus();
                }
                //var new_val = (new_loc[1])+"-"+new_ph[1]+"-"+new_ph[2];
            } else
            {
                if ((new_loc[1]) != new_ph[0])
                {
                    alert("You have entered Wrong Number");
                    $("#phone").css("border", "3px solid green");
                    $("#phone").focus();
                }
                var new_val = (new_loc[1]) + "-" + new_ph[1] + "-" + new_ph[2];
            }

            //$("#phone").val(new_val);

        } else
        {
            //$("#phone").val(new_loc[1]);
        }

    }

    function getAge(dateString) {
        var today = new Date();
        var birthDate = new Date(dateString);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }

    function checkBirthDate(bdate)
    {

        var Years = getAge(bdate);
        if (Years < 13) {
            document.getElementById("showmsg").innerHTML = "you must be 13 yrs to join CCS.";
            document.getElementById("showbutton").style.display = "none";
        } else {
            document.getElementById("showmsg").innerHTML = "";
            document.getElementById("showbutton").style.display = "block";
        }
    }
</script>
<div class="content">
    <h1>Members Registration</h1>
    <?php
    if ((isset($MSG1)) || (isset($MSG)) || (isset($errors))) {
        ?>
        <p class="err">
            <?php
            if (isset($errors) && ($errors <> "")) {
                echo $errors;
            }
            if (isset($MSG) AND ( $MSG <> "")) {
                echo $MSG;
            }
            ?>
            <?php
            if (isset($MSG1) AND ( $MSG1 <> "")) {
                echo $MSG1;
            }
            if (isset($erro_form) AND ( $erro_form <> "")) {
                echo $erro_form;
            }
            ?>
        </p>
    <?php } ?>
    <div class="form_class">
        <form name="nontalents_reg" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="nontalents_reg">
            <?php
            if ((isset($error)) && ($error != '')) {
                echo "<p class=err>" . $error . "</font></p>";
            }
            ?>
            <p>
                <label for="username">Username:</label>
                <input  type="text" name="username" id="username"  value="" maxlength="30" class="required"  />
                <?php if (!empty($usernameeErr)) { ?>
                    <label for="username" generated="true" class="error"><?php echo $usernameeErr; ?>.</label>
                <?php } ?>
            </p>
            <p>
                <label for="password">Password:</label>
                <input  type="password" name="password" value="" id="password" maxlength="16" size="30" class="required"  />
            </p>
            <p>
                <label>Confirm Password:</label>
                <input type="password" name="conframpassword" maxlength="16" value="" id="conframpassword" class="required" size="30"/>
            </p>
            <hr/>
            <p>
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" value="<?php
                if (isset($first_name) AND ( $first_name <> "")) {
                    echo $first_name;
                }
                ?>" maxlength="100" class="required" />

                <?php if (!empty($nameErr)) { ?>
                    <label for="first_name" generated="true" class="error"><?php echo $nameErr; ?>.</label>
<?php } ?>
            </p>
            <p>
                <label for="last_name">Last Name:</label>
                <input  type="text" name="last_name" value="<?php
if (isset($last_name) AND ( $last_name <> "")) {
    echo $last_name;
}
?>" maxlength="100" class="required" />
            </p>
            <p>
                <label for="phone_no">Phone No:</label>
                <input  type="text" id="phone" name="phone_no" value="<?php
                if (isset($phone_no) AND ( $phone_no <> "")) {
                    echo $phone_no;
                }
                ?>" maxlength="30" class="required" />
                <?php if (!empty($phoneErr)) { ?>
                    <label for="phone_no" generated="true" class="error">Please enter valid phone number<?php //echo str_replace($phoneErr,'12','7'); ?>.</label>
                        <?php } ?>
            </p>
            <p>
                <label for="email">Email:</label>
                <input  type="text" name="email" value="<?php
                        if (isset($email) AND ( $email <> "")) {
                            echo $email;
                        }
                        ?>" maxlength="100" class="email required" />
                        <?php if (!empty($emailErr)) { ?>
                    <label for="email" generated="true" class="error"><?php echo $emailErr; ?>.</label>
<?php } ?>
            </p>
            <p>
                <label for="city">City:</label>
                <input  type="text" name="city" value="<?php
                    if (isset($city) AND ( $city <> "")) {
                        echo $city;
                    }
                    ?>" maxlength="50" class="required" />
            </p>
            <p>
                <label for="country">Country:</label>
                <select name="country" id="location" class="required" >
<?php
foreach ($countries_array as $key => $value) {
    // $code = explode("-",$value);
    ?>
                        <option value="<?php echo $key; ?>" <?php if (isset($country)) {
        if ($key == $country) {
            ?>selected<?php }
                      }
                      ?>><?php echo $value; ?></option>
                                  <?php
                              }
                              ?>
                </select>
            </p>
            <p>
                <label for="sex">Sex:</label>
                <label><input type="radio" name="sex" value="1" <?php if (isset($sex)) {
                                  if ($sex == 1) {
                                      ?>checked="checked"<?php }
        } else {
            ?> checked="checked"<?php } ?>>Male</label>
                <label><input type="radio" name="sex" value="2" <?php if (isset($sex)) {
            if ($sex == 2) {
                ?>checked="checked"<?php }
        }
                              ?>>Female</label>
            </p>

            <br/><br/>

            <p>
                <label for="age">Date of Birth:</label>
                <input  type="text" name="age" id="age" onchange="checkBirthDate(this.value)" value="<?php
        if (isset($age) AND ( $age <> "")) {
            echo $age;
        }
                              ?>" class="required" />
            <div id="showmsg"></div>
            </p>


            <br/>

            <p>
              <!--<img id="siimage" style="border: 1px solid #000; margin-right: 15px" src="./securimage/securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left" />-->
                <img border="0" id="captcha" src="../_includes/image.php" alt="" align="bottom">
                <!--  <object type="application/x-shockwave-flash" data="./securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=./securimage/images/audio_icon.png&amp;audio_file=./securimage/securimage_play.php" height="32" width="32">
                  <param name="movie" value="./securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=./securimage/images/audio_icon.png&amp;audio_file=./securimage/securimage_play.php" />
                  </object>-->
                &nbsp;
                <a href="JavaScript: new_captcha();"><img border="0" alt="" src="../_images/refresh.png" style="vertical-align:top; margin-top:8px; " title="Can't read the image? click here to refresh" /></a><br />
                <br/>
                <strong>Enter Code*:</strong><br />
                <input type="text" name="ct_captcha" id="ct_captcha" size="12" maxlength="8" />
<?php
if (isset($errors) && !empty($errors)) {
    echo '<label for="ct_captcha" generated="true" class="error">Invalid Security Code.</label>';
}
?>
            </p>

            <div style="clear:both"></div>
            <hr />
            <input type="hidden" name="hid_mac" id="hid_mac" value="" />
            <div id="showbutton">
                <input type="submit" name="submit" value="Register" class="button" />
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    if (localStorage.getItem('my_mac_addr') != null)
    {
        $('#hid_mac').val(localStorage.getItem('my_mac_addr'));
    } else
    {
        $('#hid_mac').val('0');
    }
</script>
<div style="clear:both;"></div>
<?php
include('../_includes/footer.php');
?>