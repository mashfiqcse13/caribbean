<?php
include('../_includes/application-top.php');
ChecktalentLogin();
$table1 = "tbl_users";
$whereClause = "AND id=" . $_SESSION['talent_id'] . "";
$result = getAnyTableWhereData($table1, $whereClause);
extract($result);

if (isset($_POST['submit'])) {


    /* $start_date1=explode("-", $_POST['age']);
      $start_date=$start_date1[0] . "-" . $start_date1[1] . "-" . $start_date1[2];
      $d1 = new DateTime(date('Y-m-d'));
      $d2 = new DateTime($start_date);
      $diff = $d2->diff($d1);
      $y=$diff->y;
      echo $y;
      exit();
      if($y>"13")
      { */
    extract($_POST);
    $check = $_POST["check"];

    $check_tot = implode(',', $check);
    $age = explode('-', $_POST['age']);
    $age = $age['0'] . '-' . $age['1'] . '-' . $age['2'];
    $data = array(
        "first_name" => mysql_real_escape_string(trim($_POST['first_name'])),
        "last_name" => mysql_real_escape_string(trim($_POST['last_name'])),
        "phone_no" => mysql_real_escape_string(trim($_POST['phone_no'])),
        "username" => mysql_real_escape_string(trim($_POST['username'])),
        "email" => mysql_real_escape_string(trim($_POST['email'])),
        "city" => mysql_real_escape_string(trim($_POST['city'])),
        "country" => $_POST['country'],
        "sex" => $_POST['sex'],
        "age" => $age,
        "type" => '1',
        "talent" => $check_tot,
        "status" => '1'
    );
    $table = "tbl_users";
    $parameters = "id='" . $_POST["id"] . "'";
    updateData($data, $table, $parameters);

    header("Location:edit_profile.php?op=u");
}
/* else{
  $error="You must be above 13 years to be a member of CCS.";
  }

  } */
include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $("#talents_edit").validate({
            rules: {
                phone_no: {
                    required: true, minlength: 10, maxlength: 20
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("type") == "checkbox")
                {
                    error.insertAfter(element.parent().last());
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });

    $(document).ready(function () {
        $("#phone").keypress(function (e) {

            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 45)
            {
                return false;
            }
        });
//called when key is pressed in textbox
        $("#age").keypress(function (e)
        {
//if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 46 || e.which > 57))
            {
//display error message
//$("#errmsg1").html("Accept Only Numbers").show();
                return false;
            }
        });
        $("#age").datepicker({
            changeMonth: true,
            changeYear: true,
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

        if (Years < 13) {
            document.getElementById("showmsg1").innerHTML = "You must be above 13 years to be a member of CCS.";
            document.getElementById("showbutton").style.display = "none";
        } else {
            document.getElementById("showmsg1").innerHTML = "";
            document.getElementById("showbutton").style.display = "block";
        }
    }

    function back()
    {
        window.history.back();
    }
</script>

<script type="text/javascript">
    function ConfrimMessage_Delete(Url) //confarming property delete
    {
        if (confirm("Are you sure you want to delete your profile?"))
        {
            /*self.navigate(Url);*/ //redirecting to the desired page
            window.location = "" + Url;
        }
    }
</script>


<div class="content">
    <h1>Edit Your Profile</h1>

    <?php
    if (isset($_GET['op'])) {
        ?>
        <p class="msg">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "u")) {
                echo "Profile Updated Successfully.";
            }
            ?>
        </p>
    <?php } ?>
    <?php
    if ((isset($error)) && ($error != '')) {
        echo "<p class=err>" . $error . "</font></p>";
    }
    ?>
    <p style="text-align:right"><a href="member.php" class="button" style="float:left; margin:-5px 0px 5px 0px;" onclick="return back();">Back</a></p>
    <div class="form_class">
        <div id="m_profile">
            <div id="m_profile_left">
                <ul>
                    <li><a href="change_password.php">Change Password</a></li>
                    <li><a href="edit_profile.php">Edit Profile</a></li>
                    <li><a href="profile_setup.php">Profile Setup</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
            <div id="m_profile_right">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="talents_edit">             
                    <input type="hidden" name="id" value="<?php echo $_SESSION['talent_id']; ?>" />
                    <p>
                        <label for="first_name">First Name:</label>
                        <input type="text" name="first_name" value="<?php echo $first_name; ?>" maxlength="100" class="required" />
                    </p>
                    <p>
                        <label for="last_name">Last Name:</label>
                        <input  type="text" name="last_name" value="<?php echo $last_name; ?>" maxlength="100" class="required" />
                    </p>
                    <p>
                        <label for="phone_no">Phone No:</label>
                        <input  type="text" id="phone" name="phone_no" value="<?php echo $phone_no; ?>" maxlength="30" class="required" />
                    </p>
                    <p>
                        <label for="username">Username:</label>
                        <input type="text" name="username" value="<?php echo $username; ?>" maxlength="100" class="required" />
                    </p>
                    <p>
                        <label for="email">Email:</label>
                        <input  type="text" name="email" value="<?php echo $email; ?>" maxlength="100" class="email required" />
                    </p>
                    <p>
                        <label for="city">City:</label>
                        <input  type="text" name="city" value="<?php echo $city; ?>" maxlength="50" class="required" />
                    </p>
                    <p>
                        <label for="country">Country:</label>
                        <select name="country" id="location" class="required">
                            <?php
                            //for ($i=0;$i<=239;$i++) {
                            foreach ($countries_array1 as $key => $value) {
                                if ($country == $key) {
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
                        <label for="sex">Sex:</label>
                        <label><input type="radio" name="sex" value="1" <?php if ($sex == 1) { ?>checked="checked" <?php } ?> >Male</label>
                        <label><input type="radio" name="sex" value="2" <?php if ($sex == 2) { ?>checked="checked" <?php } ?> >Female</label>
                    </p><br/><br/>
                    <p>
                        <label for="age">Date of Birth:</label>
                        <input  type="text" name="age" id="age" onchange="checkBirthDate(this.value)" value="<?php $age = explode('-', $age);
                            echo $age = $age['0'] . '-' . $age['1'] . '-' . $age['2'];
                            ?>" class="required" />
                    <div id="showmsg1"></div>
                    </p>
                    <hr/>

                    <label for="type">Type:</label><br/>
                    <ul>
                        <?php
                        $talent_list = $talent;
                        $talent_list_tot = explode(',', $talent_list);

                        $sql = "SELECT * FROM tbl_talents WHERE status=1";
                        $result = mysql_query($sql);
                        while ($data = mysql_fetch_assoc($result)) {
                            ?>
                            <li style="width:400px; clear:both;margin-left:98px;">
                                <label>
                                    <input type="checkbox" name="check[]" value="<?php echo $data['id']; ?>"
                                    <?php
                                    if (in_array($data['id'], $talent_list_tot)) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                           ?> 
                                           class="required" /><?php echo $data['talent']; ?>
                                </label>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <div style="clear:both"></div>
                    <hr />
                    <div id="showbutton">		
                        <input type="submit" name="submit" value="submit" class="button" />
                    </div>
                </form> 

            </div>
        </div>
    </div>
</div>

<?php
include('../_includes/footer.php');
?>
