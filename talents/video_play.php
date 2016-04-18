<?php
include('../_includes/application-top.php');


include('../_includes/meta.php');

if (isset($_GET['filename'])) {
    ?>
    <div id="videoplayer" style="text-align:center;"></div>
    <?php
    // echo $_GET['id'];
    $org_song = $_GET['filename'];
    ?>
    <script type="text/javascript">
        jwplayer("videoplayer").setup({
            flashplayer: "<?php echo SITE_URL; ?>talents/player.swf",
            file: "<?php echo $org_song; ?>",
            'controlbar': 'bottom',
            'width': '500',
            'height': '400',
            'videostart': 'true'
        });
    </script>
    <?php
} elseif (isset($_GET['id'])) {
    $result = mysql_query("SELECT * FROM  tbl_profile_videos WHERE id='" . $_GET['id'] . "' ");
    $data = mysql_fetch_assoc($result);
    //print_r($data);
    echo $data['video_code'];
}
?>