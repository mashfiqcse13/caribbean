<?php
include('../_includes/application-top.php');


include('../_includes/meta.php');

if (isset($_GET['filename'])) {
    ?>
    <video controls="">
        <source src="<?php echo $_GET['filename'] ?>"/>
    </video>
    <?php
} elseif (isset($_GET['id'])) {
    $result = mysqli_query($link,"SELECT * FROM  tbl_profile_videos WHERE id='" . $_GET['id'] . "' ");
    $data = mysqli_fetch_assoc($result);
    //print_r($data);
    echo $data['video_code'];
}
?>