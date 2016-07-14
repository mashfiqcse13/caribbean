<?php
include('../_includes/application-top.php');
ChecktalentLogin();

/* $sql=mysql_query("SELECT payment_details FROM  tbl_users WHERE id='".$_SESSION['talent_id']."' ");
  $result=mysql_fetch_assoc($sql); */
//print_r($result);

if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Save')) {

    $data = array(
        "uid" => $_SESSION['talent_id'],
        "bank_name" => mysql_real_escape_string(trim($_POST['bank_name'])),
        "country" => $_POST['country'],
        "routing_number" => mysql_real_escape_string(trim($_POST['routing_number'])),
        "bank_address" => mysql_real_escape_string(trim($_POST['bank_address'])),
        "bank_address_2" => mysql_real_escape_string(trim($_POST['bank_address_2'])),
        "bank_city" => mysql_real_escape_string(trim($_POST['bank_city'])),
        "bank_state" => mysql_real_escape_string(trim($_POST['bank_state'])),
        "bank_zip_code" => mysql_real_escape_string(trim($_POST['bank_zip_code'])),
        "account_holder_name" => mysql_real_escape_string(trim($_POST['account_holder_name'])),
        "accountnumber_iban" => mysql_real_escape_string(trim($_POST['accountnumber_iban']))
    );
    $table = "tbl_seller_bank";
    insertData($data, $table);

    header("Location:member.php?op=add");
}


if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Update')) {

    $data = array(
        "uid" => $_SESSION['talent_id'],
        "bank_name" => mysql_real_escape_string(trim($_POST['bank_name'])),
        "country" => $_POST['country'],
        "routing_number" => mysql_real_escape_string(trim($_POST['routing_number'])),
        "bank_address" => mysql_real_escape_string(trim($_POST['bank_address'])),
        "bank_address_2" => mysql_real_escape_string(trim($_POST['bank_address_2'])),
        "bank_city" => mysql_real_escape_string(trim($_POST['bank_city'])),
        "bank_state" => mysql_real_escape_string(trim($_POST['bank_state'])),
        "bank_zip_code" => mysql_real_escape_string(trim($_POST['bank_zip_code'])),
        "account_holder_name" => mysql_real_escape_string(trim($_POST['account_holder_name'])),
        "accountnumber_iban" => mysql_real_escape_string(trim($_POST['accountnumber_iban']))
    );
    $table = "tbl_seller_bank";
    $parameters = "uid='" . $_SESSION["talent_id"] . "'";
    updateData($data, $table, $parameters);

    header("Location:member.php?op=up");
}

include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#payment_details').validate()
    });
</script>
<div class="content"><!--START CLASS contant PART -->
    <h1>Add Payment Details</h1>
    <p style="text-align:right">
        <a href="member.php<?php echo $user_idd; ?>" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a>
    </p><br class="spacebr" />
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->

            <div class="m_profile_left"><!--START CLASS m_profile_left PART -->

            </div><!--END CLASS m_profile_left PART -->
            <div class="m_profile_right">
                <p>For selling purpose's please add your Bank account details.</p>


                <?php
                $sql = mysql_query("SELECT * FROM tbl_seller_bank WHERE uid='" . $_SESSION['talent_id'] . "' ");
                $result = mysql_fetch_array($sql);
//print_r($result);
                $row = mysql_num_rows($sql);
                if ($row == '0') {
                    ?>


                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="payment_details">

                        <p>Bank Information<hr /></p>

                        <p><label style="width:200px;">*Bank Name:</label>
                            <input type="text" name="bank_name" value="<?php
                            if (isset($bank_name) AND ( $bank_name <> "")) {
                                echo $bank_name;
                            }
                            ?>" class="required"/>
                        </p>

                        <p><label style="width:200px;">*Bank Country:</label>
                            <select name="country" id="location" class="required" />
                            <?php
                            //for ($i=0;$i<=239;$i++) {
                            foreach ($countries_array1 as $key => $value) {
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

                        <p><label style="width:200px;">Routing Number:</label>
                            <input type="text" name="routing_number" value="<?php
                            if (isset($routing_number) AND ( $routing_number <> "")) {
                                echo $routing_number;
                            }
                            ?>" />
                        </p>

                        <p><label style="width:200px;">*Bank  Address:</label>
                            <input type="text" name="bank_address" value="<?php
                            if (isset($bank_address) AND ( $bank_address <> "")) {
                                echo $bank_address;
                            }
                            ?>" class="required" />
                        </p>

                        <p><label style="width:200px;">Bank  Address 2:</label>
                            <input type="text" name="bank_address_2" value="<?php
                            if (isset($bank_address_2) AND ( $bank_address_2 <> "")) {
                                echo $bank_address_2;
                            }
                            ?>" />
                        </p>

                        <p><label style="width:200px;">*Bank  City:</label>
                            <input type="text" name="bank_city" value="<?php
                            if (isset($bank_city) AND ( $bank_city <> "")) {
                                echo $bank_city;
                            }
                            ?>" class="required" />
                        </p>

                        <p><label style="width:200px;">Bank  State:</label>
                            <input type="text" name="bank_state" value="<?php
                            if (isset($bank_state) AND ( $bank_state <> "")) {
                                echo $bank_state;
                            }
                            ?>"  />
                        </p>

                        <p><label style="width:200px;">Bank  Zip Code:</label>
                            <input type="text" name="bank_zip_code" value="<?php
                            if (isset($bank_zip_code) AND ( $bank_zip_code <> "")) {
                                echo $bank_zip_code;
                            }
                            ?>"  />

                        </p><br /><br />

                        <p>Account Holder Information<hr /></p>


                        <p><label style="width:200px;">*Account Holder Name:</label>
                            <input type="text" name="account_holder_name" value="<?php
                            if (isset($account_holder_name) AND ( $account_holder_name <> "")) {
                                echo $account_holder_name;
                            }
                            ?>" class="required" />
                        </p>

                        <p><label style="width:200px;">*Account Number&nbsp;/&nbsp;IBAN:</label>
                            <input type="text" name="accountnumber_iban" value="<?php
                            if (isset($accountnumber_iban) AND ( $accountnumber_iban <> "")) {
                                echo $accountnumber_iban;
                            }
                            ?>" class="required" />
                        </p>
                        <input type="submit" name="submit" value="Save"   class="button"> 
                    </form>
                    <?php
                } else {
                    ?>
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="payment_details">

                        <p>Bank Information<hr /></p>

                        <p><label style="width:200px;">*Bank Name:</label>
                            <input type="text" name="bank_name" value="<?php echo $result['bank_name']; ?>" class="required"/>
                        </p>

                        <p><label style="width:200px;">*Bank Country:</label>
                            <select name="country" id="location" class="required">
                                <?php
                                foreach ($countries_array1 as $key => $value) {

                                    if ($result['country'] == $key) {
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

                        <p><label style="width:200px;">Routing Number:</label>
                            <input type="text" name="routing_number" value="<?php echo $result['routing_number']; ?>"  />
                        </p>

                        <p><label style="width:200px;">*Bank  Address:</label>
                            <input type="text" name="bank_address" value="<?php echo $result['bank_address']; ?>" class="required" />
                        </p>

                        <p><label style="width:200px;">Bank  Address 2:</label>
                            <input type="text" name="bank_address_2" value="<?php echo $result['bank_address_2']; ?>" />
                        </p>

                        <p><label style="width:200px;">*Bank  City:</label>
                            <input type="text" name="bank_city" value="<?php echo $result['bank_city']; ?>" class="required" />
                        </p>

                        <p><label style="width:200px;">Bank  State:</label>
                            <input type="text" name="bank_state" value="<?php echo $result['bank_state']; ?>" />
                        </p>

                        <p><label style="width:200px;">Bank  Zip Code:</label>
                            <input type="text" name="bank_zip_code" value="<?php echo $result['bank_zip_code']; ?>"  />						
                        </p><br /><br />

                        <p>Account Holder Information<hr /></p>


                        <p><label style="width:200px;">*Account Holder Name:</label>
                            <input type="text" name="account_holder_name" value="<?php echo $result['account_holder_name']; ?>" class="required" />
                        </p>

                        <p><label style="width:200px;">*Account Number&nbsp;/&nbsp;IBAN:</label>
                            <input type="text" name="accountnumber_iban" value="<?php echo $result['accountnumber_iban']; ?>" class="required" />
                        </p>
                        <input type="submit" name="submit" value="Update"   class="button"> 
                    </form> 
<?php }
?>

            </div><!--END CLASS m_profile_right PART -->
            <div style="clear:both"></div>
        </div><!--END CLASS m_profile PART -->
    </div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->

<?php
include('../_includes/footer.php');
?>
