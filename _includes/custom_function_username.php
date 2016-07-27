<?php

function GetUserName($username) {
    $sql = "SELECT   tbl_users.first_name,tbl_users.last_name FROM   tbl_users WHERE username='" . $username . "'";
    $query = mysqli_query($link,$sql);
    $row = mysqli_fetch_assoc($query);
    $name = $row["first_name"] . " " . $row["last_name"];
    return $name;
}

?>