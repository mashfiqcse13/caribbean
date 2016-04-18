<?php
include('../_includes/application-top.php');
ChecknontalentLogin();
//if(isset($_POST['submit']))
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'update')) {

    $start_date = date('Y-m-d', strtotime($_POST['age']));

    //echo $agediff=daysDifference(date('Y-m-d'), $start_date);
    //exit();
    /* $d1 = new DateTime(date('Y-m-d'));
      $d2 = new DateTime($start_date);
      $diff = $d2->diff($d1);
      $y=$diff->y;

      //echo $y;
      //exit();
      if($y>="13")
      {
     */
    extract($_POST);
    $age = explode('-', $_POST['age']);
    $age = $age['0'] . '-' . $age['1'] . '-' . $age['2'];
    $data = array(
        "first_name" => $_POST['first_name'],
        "last_name" => $_POST['last_name'],
        "phone_no" => mysql_real_escape_string(trim($_POST['phone_no'])),
        "city" => $_POST['city'],
        "username" => $_POST['username'],
        "email" => $_POST['email'],
        "country" => $_POST['country'],
        "sex" => $_POST['sex'],
        "age" => $age,
        "type" => '0',
        "status" => '1'
    );
    $table = "tbl_users";
    $parameters = "id='" . $_SESSION['user_id'] . "'";
    updateData($data, $table, $parameters);
    header("Location:member.php?op=u");
}/* else{
  $error="You must be above 13 years to be a member of CCS.";
  }

  } */
?>
<?php include('../_includes/header.php'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#update').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
        });
        $("#phone").keypress(function (e) {

            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 45)
            {
                return false;
            }
        });
    });

    /*	$(document).ready(function(){
     
     //called when key is pressed in textbox
     $("#age").keypress(function (e)
     {
     //if the letter is not digit then display error and don't type anything
     if( e.which!=8 && e.which!=0 && (e.which<46 || e.which>57))
     {
     //display error message
     //$("#errmsg1").html("Accept Only Numbers").show();
     return false;
     }
     });
     
     });*/

</script>
<script type="text/javascript">
    $(function () {
        $("#age").datepicker({
            changeMonth: true,
            changeYear: true,
            /*dateFormat: 'dd/mm/yy'*/
            dateFormat: 'yy-mm-dd'
        });
    });

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
        //document.getElementById("demo").innerHTML = Years + "Year(s), " + Months + " Month(s), " + Days + "Day(s)";
        if (Years < 13) {
            document.getElementById("showmsg1").innerHTML = "You must be above 13 years to be a member of CCS.";
            document.getElementById("showbutton").style.display = "none";
        } else {
            document.getElementById("showmsg1").innerHTML = "";
            document.getElementById("showbutton").style.display = "block";
        }
    }

</script>


<div class="content"><!--START CLASS contant PART -->
    <h1>Profile Update:</h1>
    <?php
    if ((isset($error)) && ($error != '')) {
        echo "<p class=err>" . $error . "</font></p>";
    }
    ?>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->

            <div id="m_profile_left"><!--START CLASS m_profile_left PART -->
                <ul>
                    <li><a href="member.php">Member Area</a></li>
                    <li><a href="change-password.php">Change Password</a></li>
                    <li><a href="edit-profile.php">Edit Profile</a></li>
                    <li><a href="log-out.php">LogOut</a></li>
                </ul>
            </div><!--END CLASS m_profile_left PART -->


            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <?php
                $result = mysql_query("SELECT * FROM tbl_users WHERE id='" . $_SESSION['user_id'] . "' ");
                if (!$result) {
                    die("database query faild:" . mysql_query());
                }
                ?>
                <?php
                while ($row = mysql_fetch_assoc($result)) {
                    ?>

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  id="update">

                        <p>
                            <label for="first_name">First Name :</label>
                            <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" maxlength="100" class="required" />
                        </p>
                        <p>
                            <label for="last_name">Last Name :</label>
                            <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" maxlength="100" class="required"/>
                        </p>
                        <p>
                            <label for="phone_no">Phone No:</label>
                            <input  type="text" id="phone" name="phone_no" value="<?php echo $row['phone_no']; ?>" maxlength="30"/>
                        </p> <p>
                            <label for="username">Username:</label>
                            <input type="text" name="username" value="<?php echo $row['username']; ?>" maxlength="100" class="required" />
                        </p>

                        <p>
                            <label for="email">Email :</label>
                            <input type="text" name="email" value="<?php echo $row['email']; ?>" class="required"/>
                        </p>
                        <p>
                            <label for="city">City:</label>
                            <input type="text" name="city" value="<?php echo $row['city']; ?>" class="required"/>
                        </p>
                        <p>
                            <label for="country">Country :</label>
                            <select name="country" id="location" class="required">
                                <?php
                                //for ($i=0;$i<=239;$i++) {
                                foreach ($countries_array as $key => $value) {
                                    if ($row['country'] == $key) {
                                        ?>
                                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </p>
                        <p>
                            <label for="sex">Sex :</label>
                            <input type="radio" name="sex" value="1" class="required" <?php
                            if ($row['sex'] == "1") {
                                echo 'checked="checked"';
                            }
                            ?>>Male
                            <input type="radio" name="sex" value="2" class="required" <?php
                            if ($row['sex'] == "2") {
                                echo 'checked="checked"';
                            }
                            ?>>Female										
                        </p>
                        <p>
                            <label for="age">Date of Birth :</label>
                            <input type="text" name="age"  id="age" onchange="checkBirthDate(this.value)" value="<?php $age = explode('-', $row['age']);
                            echo $age = $age['0'] . '-' . $age['1'] . '-' . $age['2'];
                            ?>" class="required"/>
                        <div id="showmsg1"></div>
                        </p>
                        <div id="showbutton">

                            <input type="submit" name="submit" value="update" class="button" />

                        </div>


                    </form>	



    <?php
}
?>
            </div><!--END CLASS form_class PART -->

        </div><!--END CLASS m_profile_right PART -->

    </div><!--END CLASS m_profile PART -->

</div><!--END CLASS contant PART -->

<?php
include('../_includes/footer.php');
?>

