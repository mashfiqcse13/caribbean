<!-- <script src="http://kolber.github.io/audiojs/audiojs/audio.js"></script> -->
<?php
include('include/application_top.php');
cmslogin();

include('include/header.php');

$result = mysqli_query($link,"SELECT * FROM tbl_contact");

if (!$result) {
    die("Retrieving records from contact table's query faild:" . mysqli_error($link));
}
?>
<style>
    li,a,img,ul,div,span {
        background: transparent;
        border: 0;
        margin: 0;
        padding: 0;
        vertical-align: baseline;
    }
    .prodlist { list-style: none; margin: 20px; }
    .prodlist li { 
        display: inline-block; position: relative; color: #eee; cursor: pointer; text-shadow: 1px 1px rgba(0,0,0,0.3); margin-bottom: 3%; }
    .prodlist li a { color: #FB9337; }
    .prodlist li .thumb { padding: 5px; border: 3px solid #ddd; }
    .prodlist li .thumb img { width: 225px; }
    .prodlist li .content { position: absolute; top: 5px; left: 5px; width: 225px; height: 163px; overflow: hidden; }
    .prodlist li .contentinner { background: url(bg.png); padding: 5px 7px; margin-top: 132px; height: 163px; }
    .prodlist li .title { color: #fff; font-family:Arial,Helvetica,sans-serif; font-size: 13px; }
    .prodlist li .title:hover { color: #FB9337; }
    .prodlist li .price { color: #fff; font-weight: bold; float: right; }
    .prodlist li .by { font-size: 12px; font-style: italic; margin-top:8px; }
    .prodlist li .desc { font-size: 12px; margin: 5px 0; line-height: 16px; }
</style>

<div style="margin:50px auto; width:97%; padding:1px; background:#fff;">
    <ul class="prodlist">
        <?php
        while ($row = mysqli_fetch_array($result)) {
            ?>
            <li class="one_third">
                <div class="thumb">
                    <?php
                    if (!empty($row['file_attached'])) {
                        $stripslash = explode('/', $row['file_attached']);
                        $file = explode('.', $stripslash['1']);

                        if ($file['1'] == 'mp3' || $file['1'] == 'wav') {
                            ?>

                            <audio id="player" src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/" . $row['file_attached']; ?>" type="audio/mp3" controls="controls"></audio>
                            <?php
                        }

                        if ($file['1'] == 'jpg' || $file['1'] == 'wav') {
                            ?>

                            <img id="player" src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/" . $row['file_attached']; ?>" />
                            <?php
                        }
                    }
                    ?>
                </div>
                <!-- <div class="content">
                <div class="contentinner">
                <div>
                <span class="price"></span>
                <a class="title" href=""></a>
                </div>
                </div><!--contentinner-->
                <!--</div>content-->
            </li>
            <?php
        }
        ?>
    </ul>
</div>

<script>
    $('audio,video').mediaelementplayer();
</script>