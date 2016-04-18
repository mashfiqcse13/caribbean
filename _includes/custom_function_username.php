<?php

function GetUserName($username) {
    $sql = "SELECT   tbl_users.first_name,tbl_users.last_name FROM   tbl_users WHERE username='" . $username . "'";
    $query = mysql_query($sql);
    $row = mysql_fetch_assoc($query);
    $name = $row["first_name"] . " " . $row["last_name"];
    return $name;
}

?>