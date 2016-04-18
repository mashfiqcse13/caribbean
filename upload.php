<?php

session_start();
//If directory doesnot exists create it.
$output_dir = "uploadcontact/";

if (isset($_FILES["myfile"])) {
    $ret = array();

    $error = $_FILES["myfile"]["error"];
    {

        if (!is_array($_FILES["myfile"]['name'])) { //single file
            $fileName = $_FILES["myfile"]["name"];
            $_SESSION['file1'] = $fileName;
            move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $_FILES["myfile"]["name"]);
            //echo "<br> Error: ".$_FILES["myfile"]["error"];

            $ret[$fileName] = $output_dir . $fileName;
        } else {
            $fileCount = count($_FILES["myfile"]['name']);
            for ($i = 0; $i < $fileCount; $i++) {
                $fileName = $_FILES["myfile"]["name"][$i];
                $ret[$fileName] = $output_dir . $fileName;
                move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . $fileName);
            }
        }
    }
    //echo json_encode("Done");
}
if (isset($_FILES["myfile1"])) {
    $ret = array();

    $error = $_FILES["myfile1"]["error"];
    {

        if (!is_array($_FILES["myfile1"]['name'])) { //single file
            $fileName = $_FILES["myfile1"]["name"];
            $_SESSION['file2'] = $fileName;
            move_uploaded_file($_FILES["myfile1"]["tmp_name"], $output_dir . $_FILES["myfile1"]["name"]);
            //echo "<br> Error: ".$_FILES["myfile"]["error"];

            $ret[$fileName] = $output_dir . $fileName;
        } else {
            $fileCount = count($_FILES["myfile1"]['name']);
            for ($i = 0; $i < $fileCount; $i++) {
                $fileName = $_FILES["myfile1"]["name"][$i];
                $ret[$fileName] = $output_dir . $fileName;
                move_uploaded_file($_FILES["myfile1"]["tmp_name"][$i], $output_dir . $fileName);
            }
        }
    }
    echo json_encode($ret);
}
?>