<?php
include('../_includes/application-top.php');
ChecknontalentLogin();
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Update')) {
    $user_id = mysqli_real_escape_string( $link ,$_POST['user_id']);
    $data = array(
        "user_id" => $_SESSION['user_id'],
        "biography" => mysqli_real_escape_string( $link ,trim($_POST['biography'])),
        "profile_display_status" => $_POST['profile_display_status'],
        "social_link1" => mysqli_real_escape_string( $link ,trim($_POST['social_link1'])),
        "social_link2" => mysqli_real_escape_string( $link ,trim($_POST['social_link2'])),
        "social_link3" => mysqli_real_escape_string( $link ,trim($_POST['social_link3'])),
        "social_link4" => mysqli_real_escape_string( $link ,trim($_POST['social_link4']))
    );

    $table = "tbl_user_details";

    $parameters = "user_id='" . $_SESSION['user_id'] . "' ";

    if (!empty($user_id) && is_numeric($user_id)) {
        updateData($data, 'tbl_user_details', $parameters);
    } else {
        $data['user_id'] = $_SESSION['user_id'];
        insertData($data, $table);
    }

    $MSG = "Document Updated Successfully";
}
include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#add_details').validate();
    });


</script>
<div class="content">
    <h1>Add Details</h1>
    <?php
    if (isset($MSG) AND ( $MSG <> "")) {
        echo "<p class='msg'>$MSG</p>";
    }
    ?>
    <p><a href="profile_setup.php<?php echo $user_idd; ?>" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p>

    <div class="form_class">
        <?php
        //echo "SELECT * FROM ` tbl_user_details` WHERE user_id='".$_SESSION['talent_id']."' ";
        $query = mysqli_fetch_array(mysqli_query($link,"SELECT * FROM tbl_user_details WHERE user_id='" . $_SESSION['user_id'] . "' "));
        $row = $query;
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="add_details" >
            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
            <p>
                <label style="vertical-align:top;">
                    Biography :
                </label>
                <TEXTAREA NAME="biography"  class="required" id="textarea" cols="45" rows="7"><?php echo $row['biography']; ?></TEXTAREA>
                    </p>
    										<p>
    								<label for="social_link1">Facebook Link :</label>
    								<input type="text" name="social_link1" value="<?php echo $row['social_link1']; ?>" />
    								</p>
    								<p>
    								<label for="social_link2">Twitter Link :</label>
    								<input type="text" name="social_link2" value="<?php echo $row['social_link2']; ?>" />
    								</p>
    								<p>
    								<label for="social_link3">Google Plus Link :</label>
    								<input type="text" name="social_link3" value="<?php echo $row['social_link3']; ?>" />
    								</p>
    								<p>
    								<label for="social_link4">Pinterest Link :</label>
    								<input type="text" name="social_link4" value="<?php echo $row['social_link4']; ?>" />
    								</p>
<!--                    <p>
                        <label style="width:290px;">
                           Profile can be viewed without login:
                        </label>
                        <select name="profile_display_status">
                          <option <?php /* if($row["profile_display_status"]=="1"){ echo "selected='selected'"; } */ ?>  value="1">Yes</option>
                          <option <?php /* if($row["profile_display_status"]=="0"){ echo "selected='selected'"; } */ ?>  value="0">No</option>
                        </select>
                    </p>-->

                     <input type="submit" name="submit" value="Update" class="button"></p>
              </form>
        <?php /*         while($row=mysqli_fetch_assoc($query))
          {
         */ ?><!--
         <form action="<?php /* echo $_SERVER['PHP_SELF']; */ ?>" method="post" id="add_details" >
				
                <p>
                  <label style="vertical-align:top;">
                    Biography :
                  </label>
                  <TEXTAREA NAME="biography"  class="required" id="textarea" cols="45" rows="7"><?php /* echo $row['biography']; */ ?></TEXTAREA>
                </p>
										<p>
								<label for="social_link1">Facebook Link :</label>
								<input type="text" name="social_link1" value="<?php /* echo $row['social_link1']; */ ?>" />
								</p>
								<p>
								<label for="social_link2">Twitter Link :</label>
								<input type="text" name="social_link2" value="<?php /* echo $row['social_link2']; */ ?>" />
								</p>
								<p>
								<label for="social_link3">Google Plus Link :</label>
								<input type="text" name="social_link3" value="<?php /* echo $row['social_link3']; */ ?>" />
								</p>
								<p>
								<label for="social_link4">Pinterest Link :</label>
								<input type="text" name="social_link4" value="<?php /* echo $row['social_link4']; */ ?>" />
								</p>
                <p>
                    <label style="width:290px;">
                       Profile can be viewed without login:
                    </label>
                    <select name="profile_display_status">
                      <option <?php /* if($row["profile_display_status"]=="1"){ echo "selected='selected'"; } */ ?>  value="1">Yes</option>
                      <option <?php /* if($row["profile_display_status"]=="0"){ echo "selected='selected'"; } */ ?>  value="0">No</option>
                    </select>
                </p>
						
                 <input type="submit" name="submit" value="Update" class="button"></p>
          </form> 			
          --><?php
        /* } */
        ?>   
    </div>
</div>
<script type="text/javascript" language="javascript">
    $("#add_details").validate({
        rules: {
            social_link1: {
                url: true
            },
            social_link2: {
                url: true
            },
            social_link3: {
                url: true
            },
            social_link4: {
                url: true
            }
        }
    });
</script>
<?php
include('../_includes/footer.php');
?>
