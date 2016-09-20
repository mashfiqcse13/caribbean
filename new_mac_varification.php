<?php
include('_includes/application-top.php');
include_once './_includes/class.database.php';
$db = new DBClass(db_host, db_username, db_passward, db_name);

if (!empty($_POST['banned_user_id']) && !empty($_POST['mac_msg_by_user'])) {
    $banned_user_id = $_POST['banned_user_id'];
    $data_to_insert = array(
        "mac_msg_by_user" => $_POST['mac_msg_by_user']
    );
    $db->db_update('tbl_users', $data_to_insert, "`id` = $banned_user_id");
    header("Location: ".SITE_URL."new_mac_varification.php?banned_user_id=$banned_user_id");
    die();
}


$banned_user_id = $_GET['banned_user_id'];

$related_users = $db->db_select_as_array('tbl_users', "`id` != $banned_user_id and `mac_address` in ( SELECT `mac_address` FROM `tbl_users` WHERE `id` = $banned_user_id )");
if (sizeof($related_users) < 1) {
    die("Go Home");
}
$banned_user_details = $db->db_select_as_array('tbl_users', "`id` = $banned_user_id");
$banned_user_details = $banned_user_details[0];
//                echo "<pre>" . print_r($banned_user_details, TRUE) . "</pre>";

include('_includes/header.php');
?> 
<style>
    .item {
        float: left;
        margin: 5px 5px;
        text-align: center;
        width: 23%;
        min-width: 200px;
    }
    .item img{height: 150px;width: auto;}
</style>
<div class="content">
    <h1 style="text-align: center;">We have found some users related to you</h1>
    <p>Please define your relationship with them . If we are satisfied with your answer, we will let you in . &nbsp;Otherwise ,&nbsp;you will not able to login . Thank you</p>
    <h2>Related Users</h2>
    <div id="member">
        <ul>
            <?php
            foreach ($related_users as $related_user) {
                $related_user_type = $related_user['type'] == 1 ? "Talent" : "General";
                $related_user_full_name = "{$related_user['first_name']} {$related_user['last_name']}";
                $related_user_public_profile_url = "profile-details.php?username={$related_user['username']}";
                $related_user_image_url = "_uploads/user_photo/" . $related_user["id"] . ".jpg";

                if (!file_exists($related_user_image_url)) {
                    $related_user_image_url = "_images/dummy.png";
                }
                ?>
                <li class="item">
                    <a href="<?php echo $related_user_public_profile_url ?>">
                        <img width="120" height="152" src="<?php echo $related_user_image_url . "?" . time(); ?>">
                    </a><br>
                    <a href="<?php echo $related_user_public_profile_url ?>"> <?php echo $related_user_full_name ?></a><br>
                    User name : <?php echo $related_user['username'] ?><br>
                    Type : <?php echo $related_user_type ?>
                </li>
                <?php
            }
            ?>
        </ul>
        <div style="clear:both;"></div>
    </div>
    <p>Please write to admin in the following Text box. To mention a user Please use the "<strong>User name</strong>" . You will be notified by email about the progress .</p>
    <table>
        <tr>
            <th>Admin : </th>
            <td><?php
                if (empty($banned_user_details['mac_msg_by_admin'])) {
                    $banned_user_details['mac_msg_by_admin'] = "Tell me about the relationship among these users and you";
                }
                echo $banned_user_details['mac_msg_by_admin']
                ?>
            </td>
        </tr>
        <tr>
            <th>You : </th>
            <td><br>
                <form method="post" action="new_mac_varification.php">
                    <input type="hidden" name="banned_user_id" value="<?php echo $banned_user_id ?>"/>
                    <textarea name="mac_msg_by_user" placeholder="Say something..." rows="5" cols="100" required=""
                              ><?php echo $banned_user_details['mac_msg_by_user'] ?></textarea><br><br>
                    <input type="submit" value="Send to admin">
                </form>
            </td>
        </tr>
    </table>
</div>
<?php
include('_includes/footer.php');
