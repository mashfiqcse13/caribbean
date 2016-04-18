<?php
include('../_includes/application-top.php');
//ChecktalentLogin();

include('../_includes/meta.php');


if (isset($_GET['filename'])) {
    ?>
    <div id="audioplayer"></div>
    <?php
    // echo $_GET['id'];
    $org_song = $_GET['filename'];
    ?>
    <script type="text/javascript">
        jwplayer("audioplayer").setup({
            flashplayer: "<?php echo SITE_URL; ?>talents/player.swf",
            file: "<?php echo $org_song; ?>",
            'controlbar': 'bottom',
            'width': '245',
            'height': '24',
            'autostart': 'true'
        });
    </script>
<?php } ?>