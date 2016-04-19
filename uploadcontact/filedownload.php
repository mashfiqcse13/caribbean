<?php


$file = $_GET["file"];
$fp = fopen($file, "r") or die('<script>
    alert("These file is missing");
    history.go(-1);
</script>');

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . urlencode($file));
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Description: File Transfer");
header("Content-Length: " . filesize($file));
flush(); // this doesn't really matter.
while (!feof($fp)) {
    echo fread($fp, 65536);
    flush(); // this is essential for large downloads
}
fclose($fp);
