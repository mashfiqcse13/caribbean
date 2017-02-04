<?php
include('../_includes/application-top.php');
include_once '../_includes/class.database.php';
$db = new DBClass(db_host, db_username, db_passward, db_name);

$_SESSION['talent_login'] = 0;


// Only try to validate the captcha if the form has no errors
// This is especially important for ajax calls

require_once dirname(__FILE__) . '/securimage/securimage.php';
$securimage = new Securimage();
if(isset($_POST['ct_captcha'])){
    $captcha = $_POST['ct_captcha'];
}
$errors = "";
if (isset($captcha) && !empty($captcha)) {
    if ($securimage->check($captcha) == false) {
        $errors = 'Incorrect security code entered';
    }
    //END
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Sign up') AND $errors == "") {



    $query1 = "SELECT * FROM tbl_users WHERE username='" . $_POST["username"] . "' AND  status=1";
    $row = mysqli_query($link, $query1);
    $row = mysqli_num_rows($row);


    /* $start_date1=explode("-", $_POST['age']);
      $start_date=$start_date1[0] . "-" . $start_date1[1] . "-" . $start_date1[2];
      $d1 = new DateTime(date('Y-m-d'));

      $d2 = new DateTime($start_date);
      $diff = $d2->diff($d1);
      $y=$diff->y;
      //echo $y;
      //exit();
      if($y>="13"){ */


    if ($row > 0) {
        $MSG = "Username Already Exists";
        extract($_POST);
    } else {
        $check = $_POST["check"];
        //print_r($check);
        $check_tot = implode(',', $check);
        $age = explode('-', $_POST['age']);
        $age = $age['0'] . '-' . $age['1'] . '-' . $age['2'];
        $username = $_POST['username'];
        $country = explode("-", $_REQUEST['country']);
        $country_with_code = $_REQUEST['country'];


        if (empty($_POST['first_name'])) {
            $nameErr = "Name is required";
        } else {
            $name = test_input($_POST['first_name']);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                $nameErr = "Only letters and white space allowed";
            }
        }

        if (empty($_POST['email'])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST['email']);
            // check if e-mail address syntax is valid
            //if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

        if (empty($_POST['phone_no'])) {
            $phoneErr = "Phone Number is required";
        } else {
            $phone = $_POST['phone_no'];
            $phone_match_country = explode("-", $phone);
            // check if name only contains letters and whitespace
            $expr = '/^\+?(\(?[0-9]{3}\)?|[0-9]{3})[-\.\s]?[0-9]{3}[-\.\s]?[0-9]{4}$/';
            if (!preg_match($expr, $phone)) {
                $phoneErr = "Invalid Phone Number";
            } else if ($country[1] != $phone_match_country[0]) {
                $phoneErr = "Invalid Phone Number for selected Country";
            }
        }
        if (empty($username)) {
            $usernameeErr = "Username is required";
        } else {
            // check if name only contains letters and whitespace
            if (!preg_match('/^\w{5,}$/', $username)) {
                $usernameeErr = "Invalid Username";
            }
        }
        if (empty($_REQUEST['check'])) {
            $checkErr = "Please Select atleast one";
        }

//                             die('Call');

        if (empty($usernameeErr) && empty($nameErr) && empty($phoneErr)) { // \w equals "[0-9A-Za-z_]"
            // valid username, alphanumeric & longer than or equals 5 chars
            //Getting IP address for storeing
            $mac_address = $_SERVER['REMOTE_ADDR'];
            $chkqry = mysqli_query($link, "SELECT * FROM tbl_users WHERE mac_address='$mac_address'");
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
                $data = array(
                    "username" => mysqli_real_escape_string($link, trim($username)),
                    "password" => mysqli_real_escape_string($link, trim($_POST['conframpassword'])),
                    "first_name" => mysqli_real_escape_string($link, trim($_POST['first_name'])),
                    "last_name" => mysqli_real_escape_string($link, trim($_POST['last_name'])),
                    "phone_no" => mysqli_real_escape_string($link, trim($_POST['phone_no'])),
                    "email" => mysqli_real_escape_string($link, trim($_POST['email'])),
                    "city" => mysqli_real_escape_string($link, trim($_POST['city'])),
                    "country" => $country_with_code,
                    "sex" => $_POST['sex'],
                    "age" => $age,
                    "type" => '1',
                    "talent" => $check_tot,
                    "status" => '1',
                    "joining_time" => date("h:i:s A"),
                    "join_date" => date("Y-m-d"),
                    "mac_address" => $mac_address
                );
                $table = "tbl_users";
                //echo '<pre>';print_r($data);
                insertData($data, $table);





                //////////////////////////SEND_EMAIL_TO_TALENT_REGISTER_EMAIL_ADDRESS////////////////////////

                $to = mysqli_real_escape_string($link, trim($_POST['email']));

                $subject = "CCS: Registration email";

                /* $msg="Welcome"."<br><br>"."Dear ".mysqli_real_escape_string( $link ,trim($_POST['first_name']))." ".mysqli_real_escape_string( $link ,trim($_POST['last_name']))."<br>"."
                  Thank you for registring at ccs. At CCS you can highlight your profile as talent, sale music, videos, photos, books etc or as a member you

                  can simply browse through artist profile, listen to their music, watch video, view photos, become fans/friends with others, chat, send

                  messages, buy product and many more exciting things to do ...

                  Get Started Now, <a href=http://test.solutiononline.org/caribbeancirclestars/> [Click Here]</a>

                  Kind Redards -
                  Team CCS
                  "; */
                $lid = mysqli_insert_id($link);
                $msg = "Welcome To CCS" . "<br><br>" . "Dear Member,<br><br>" . "

     Thank you for registering at CCS.  At CCS you can highlight your profile as Talent Member, sell music, videos, photos, books etc, or as a Patron Member you can simply browse throug h any artist profile.
     Listen to their music, watch video, view photos, use the forum, become fans/friends with others, chat, send messages, buy products and many more exciting things to do.
     <br/><br/>
     Your User Name:- " . (trim($username)) . "<br/>
     Your Password:- " . (trim($_POST['conframpassword'])) . "<br/>
     <br/>
     So let us get Started. <a href='http://www.caribbeancirclestars.com/talents/member.php?op=register&lid=$lid'>[Click Here To Confirm Your Membership]</a>
     <br/>
     <br/>
     <br/>
    Thank you,
    <br/>
    <br/>
     CCS Management and Staff.";

                $from = TO_ADMIN;


                SendEMail($to, $subject, $msg, $from);




                /*                 * **********************profile settings**************************** */
                $data = array(
                    "uid" => $lid,
                    "profile_display_status" => $_POST['profile_display_status'],
                    "p_photo" => '1',
                    "p_bio" => '1',
                    "p_music" => '2',
                    "p_social" => '2',
                    "p_fans" => '2',
                    "p_video" => '3',
                    "p_comments" => '3',
                    "p_event" => '2',
                    "p_book" => '1',
                    "p_product" => '2'
                );
                $table = "tbl_user_profile_settings";
                //echo '<pre>';print_r($data);
                insertData($data, $table);



                /* $_SESSION['talent_login']=1;
                  $_SESSION['talent_id']=$lid;
                  ////////tbl_user_details INSERTED/////////

                  $data=array(
                  "user_id"=>$_SESSION['talent_id'],
                  "biography"=>" ",
                  "profile_display_status"=>"1"
                  );
                  $table="tbl_user_details";
                  insertData($data,$table);

                  /* Added Activity Below */
                /* SaveActivity(14,mysqli_real_escape_string( $link ,trim($_POST['username'])),'',$lid); */

                //////////////////////////////////////////////////

                header("Location:membersuccess.php?op=register");
            } else {

                $data = array(
                    "username" => mysqli_real_escape_string($link, trim($username)),
                    "password" => mysqli_real_escape_string($link, trim($_POST['conframpassword'])),
                    "first_name" => mysqli_real_escape_string($link, trim($_POST['first_name'])),
                    "last_name" => mysqli_real_escape_string($link, trim($_POST['last_name'])),
                    "phone_no" => mysqli_real_escape_string($link, trim($_POST['phone_no'])),
                    "email" => mysqli_real_escape_string($link, trim($_POST['email'])),
                    "city" => mysqli_real_escape_string($link, trim($_POST['city'])),
                    "country" => $country_with_code,
                    "sex" => $_POST['sex'],
                    "age" => $age,
                    "type" => '1',
                    "talent" => $check_tot,
                    "status" => '1',
                    "joining_time" => date("h:i:s A"),
                    "join_date" => date("Y-m-d"),
                    "mac_address" => $mac_address,
                    "new_mac_req" => 1
                );
                $table = "tbl_users";
                //echo '<pre>';print_r($data);
                insertData($data, $table);

                /*                 * **********************profile settings**************************** */
                $data = array(
                    "uid" => $lid,
                    "profile_display_status" => $_POST['profile_display_status'],
                    "p_photo" => '1',
                    "p_bio" => '1',
                    "p_music" => '2',
                    "p_social" => '2',
                    "p_fans" => '2',
                    "p_video" => '3',
                    "p_comments" => '3',
                    "p_event" => '2',
                    "p_book" => '1',
                    "p_product" => '2'
                );
                $table = "tbl_user_profile_settings";
                //echo '<pre>';print_r($data);
                insertData($data, $table);
                $last_inserted_user_id = $db->auto_increment_id('tbl_users')-1;
                header("Location: " . SITE_URL . "new_mac_varification.php?banned_user_id=$last_inserted_user_id");
                die();
            }
        } else {
            $erro_form = "Please Try again";
        }
    }
}
/* else{
  $error="you must be 13 yrs to join CCS.";
  extract($_POST);
  }

  } */

include('../_includes/header.php');
?>





<!--<div style="margin: 0 auto;width: 300px"><h1>UNDER CONSTRUCTION</h1></div>-->

<script type="text/javascript">
    $(document).ready(function () {
        $("#talents_reg").validate({
            rules: {
                username: {
                    required: true, minlength: 2, maxlength: 30
                },
                phone_no: {
                    required: true, minlength: 12, maxlength: 12
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
        $("#phone").keypress(function (e) {

            var phone_length = $("#phone").val().length;
            if ((phone_length == 3 || phone_length == 7) && e.which != 8)
            {
                $("#phone").val($("#phone").val() + "-");
            } else if (phone_length > 11 && e.which != 8)
            {
                return false;
            }


            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 45)
            {
                return false;
            }
        });


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
            dateFormat: 'yy-mm-dd'
        });
    });
    function correct_number()
    {
        var loc_val = $("#location").val();

        var new_loc = loc_val.split("-");
        var phone = $("#phone").val();

        if (phone.length > 3)
        {
            var new_ph = phone.split("-");
            if (new_ph[2] == undefined)
            {
                new_ph[2] = "000";
            }
            if (new_ph[1] == undefined)
            {
                new_ph[1] = "0000";
            }
            if ((new_loc[1]) != new_ph[0])
            {





                $('.main').css('display', 'block');

                $('#err').fadeOut(5000);
                $("#phone").css("border", "3px solid green");
                $("#phone").focus();
                //$("#phone").val(new_loc[1]);
            }
            //var new_val = (new_loc[1])+"-"+new_ph[1]+"-"+new_ph[2];

            //$("#phone").val(new_val);

        } else
        {
            // $("#phone").val(new_loc[1]);
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
<script>
    $('#btnpop').click(function (e) {
        $('.main').css('display', 'none');
    });
</script>


<div class="content">
    <h1>Talents Registration</h1>
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
        <form name="frm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="talents_reg">
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
            <div id="err" style="margin-left:140px;color:#FF0000;"></div>
            <?php if (!empty($phoneErr)) { ?>
                <label for="phone_no" generated="true"  class="error"><?php echo $phoneErr; ?>.</label>
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
                <select name="country" id="location" class="required" onchange="correct_number()" >
                    <?php
                    foreach ($countries_array1 as $key => $value) {
                        // $code = explode("-",$value);
                        ?>
                        <option value="<?php echo $key; ?>" <?php
                        if (isset($country)) {
                            if ($key == $country) {
                                ?>selected<?php
                                    }
                                }
                                ?>><?php echo $value; ?></option>
                                <?php
                            }
                            ?>
                </select>
            </p>
            <p>
                <label for="sex">Sex:</label>
                <label><input type="radio" name="sex" value="1" <?php
                    if (isset($sex)) {
                        if ($sex == 1) {
                            ?>checked="checked"<?php
                                  }
                              } else {
                                  ?> checked="checked"<?php } ?>>Male</label>
                <label><input type="radio" name="sex" value="2" <?php
                    if (isset($sex)) {
                        if ($sex == 2) {
                            ?>checked="checked"<?php
                                  }
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

            <hr/>

            <label for="type">Type:</label>

            <ul>
                <?php if (!empty($checkErr)) { ?>
                    <label for="type" generated="true" class="error"><?php echo $checkErr; ?>.</label>
                <?php } ?>
                <?php
                $sql = "SELECT * FROM tbl_talents WHERE status=1";
                $result = mysqli_query($link, $sql);
                while ($data = mysqli_fetch_assoc($result)) {
                    ?>
                    <li style="width:400px; clear:both;margin-left:98px; ">

                        <label>
                            <input type="checkbox" name="check[]" value="<?php echo $data['id'] ?>"  class="required"
                            <?php
                            if (isset($check)) {
                                if (in_array($data['id'], $check)) {
                                    ?> checked="checked" <?php
                                       }
                                   }
                                   ?>/>
                                   <?php echo $data['talent']; ?>
                        </label>

                    </li>
                    <?php
                }
                ?>

            </ul>
            <br/>

            <p>
                <img id="siimage" style="border: 1px solid #000; margin-right: 15px" src="./securimage/securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left" />
                <object type="application/x-shockwave-flash" data="./securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=./securimage/images/audio_icon.png&amp;audio_file=./securimage/securimage_play.php" height="32" width="32">
                    <param name="movie" value="./securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=./securimage/images/audio_icon.png&amp;audio_file=./securimage/securimage_play.php" />
                </object>
                &nbsp;
                <a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = './securimage/securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="./securimage/images/refresh.png" alt="Reload Image" height="32" width="32" onclick="this.blur()" align="bottom" border="0" /></a><br /><br />
                <br/><br/><br/>
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
            <div id="showbutton">
                <input type="submit" name="submit" value="Sign up" class="button" />
            </div>
        </form>
    </div>
</div>
<?php
include('../_includes/footer.php');
?>
