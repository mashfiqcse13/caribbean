<?php

include('_includes/application-top.php');


$data = getAnyTableWhereData('tbl_users', 'AND username="' . $_GET['username'] . '" ');

/* echo $_SESSION['user_id'];
  echo $_SESSION["talent_id"];
  exit ();
 */
if ((isset($_SESSION["talent_id"])) && ($_SESSION["talent_id"] != 0)) {
    $uid = $_SESSION["talent_id"];
} elseif ((isset($_SESSION["user_id"])) && ($_SESSION["user_id"] != 0)) {
    $uid = $_SESSION["user_id"];
} else {
    //
}
if (((isset($_SESSION['user_id'])) && ($_SESSION['user_id'] != '') || (isset($_SESSION['talent_id'])) && ($_SESSION['talent_id'] != '')) && $_SESSION["is_admin"] != "yes") {
    if (($_SESSION['user_id'] == $data['id']) || ($_SESSION['talent_id'] == $data['id'])) {
        header('location: profile-details.php?username=' . $_GET['username'] . '&op=self');
    } else {
        $sql = "SELECT id " .
                "FROM tbl_fans ";

        if (isset($_SESSION['user_id'])) {
            $sql.="WHERE profile_id=" . $uid . " AND fan_id=" . $data['id'] . " ";
        } else {
            $sql.="WHERE profile_id=" . $uid . " AND fan_id=" . $data['id'] . " ";
        }


        $result = mysql_query($sql) or die(mysql_error());

        if (mysql_num_rows($result) > 0) {
            header('location: profile-details.php?username=' . $_GET['username'] . '&op=ex');
        } else {

            if (isset($_SESSION['user_id'])) {
                $data1 = array(
                    "profile_id" => $uid,
                    "fan_id" => $data['id']
                );
            } else {
                $data1 = array(
                    "profile_id" => $uid,
                    "fan_id" => $data['id']
                );
            }
            $table = "tbl_fans";
            insertData($data1, $table);

            if (isset($_SESSION['talent_id'])) {
                $data2 = array(
                    "profile_id" => $data['id'],
                    "fan_id" => $uid
                );
            } else {
                $data2 = array(
                    "profile_id" => $data['id'],
                    "fan_id" => $uid
                );
            }
            $table1 = "tbl_fans";
            insertData($data2, $table1);

            /* Added Activity Blow */

            /* if((isset($_SESSION["talent_id"])) && ($_SESSION["talent_id"]!=0)){
              $uid=$_SESSION["talent_id"];
              }elseif((isset($_SESSION["user_id"])) && ($_SESSION["user_id"]!=0)){
              $uid=$_SESSION["user_id"];
              }else{
              //
              } */


            $uname = (GetChatUserName($data['id']));
            $fanename = (GetChatUserName($uid));

            SaveActivity(7, $uname, $fanename, $data['id']);

            SaveActivity(8, $fanename, $uname, $uid);

            //////////////////////////////////////////////////

            header('location: profile-details.php?username=' . $_GET['username'] . '&op=suc');
        }
    }
} else {
    header('location: member/login.php');
}
?>