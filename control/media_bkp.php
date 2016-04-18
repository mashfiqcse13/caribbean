<!-- <script src="http://kolber.github.io/audiojs/audiojs/audio.js"></script> -->
<?php
include('include/application_top.php');
cmslogin();

include('include/header.php');

if (!empty($_REQUEST['id']) && $_REQUEST['action'] == "delete") {
    mysql_query("DELETE FROM `tbl_contact` WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "';");
    echo "<div id='afterpostingajax'>Record Successfully Deleted</div>";
}

$result = mysql_query("SELECT * FROM tbl_contact");

if (!$result) {
    die("Retrieving records from contact table's query faild:" . mysql_query());
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(function () {
            $("#afterpostingajax").fadeOut("slow", function () {
                $("#afterpostingajax").remove();
            });

        }, 3000);
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".xxx").click(function () {
            //alert($(this).attr('id'));	
            var u_id = $(this).attr('id');
            var pp = '#page' + u_id;
            var cc = '#contactid' + u_id;
            page = $(pp + " option:selected").text();
            contactid = $(cc).val();
            $.ajax({
                type: "POST",
                url: "http://caribbeancirclestars.com/control/ajaxcontact.php",
                data: "pg=" + page + "&cnt=" + contactid,
                success: function (html) {
                    if (html == 'true')
                    {
                        $("#afterpostingajax").html("This Media has been shared to " + page + " Page successfully");
                        setTimeout(function () {
                            $("#afterpostingajax").fadeOut("slow", function () {
                                $("#afterpostingajax").remove();
                            });

                        }, 2000);
                        Popup.hide("modal_" + contactid);
                        //$("#profile").html("<a href='logout.php' id='logout'>Logout</a>");
                    } else
                    {
                        //$("#add_err").html("Wrong username or password");
                    }
                },
                beforeSend: function ()
                {
                    ll = '#load' + u_id;
                    $(ll).html("Loading...")
                }
            });
            return false;
        });
    });
</script>
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
        display: inline-block; position: relative; color: #000; cursor: pointer; text-shadow: 1px 1px rgba(0,0,0,0.3); margin-bottom: 3%; }
    .prodlist li a { color: #FB9337; }
    .prodlist li .thumb { padding: 5px; border: 3px solid #ddd; }
    .prodlist li .thumb img { width: 402px; }
    .prodlist li .select { padding: 5px; border: 3px solid #C6FAB2; }
    .prodlist li .select img { width: 402px; }
    .prodlist li .content { position: absolute; top: 5px; left: 5px; width: 225px; height: 163px; overflow: hidden; }
    .prodlist li .contentinner { background: url(bg.png); padding: 5px 7px;float:left;}
    .prodlist li .title { color: #fff; font-family:Arial,Helvetica,sans-serif; font-size: 13px; }
    .prodlist li .title:hover { color: #FB9337; }
    .prodlist li .price { color: #fff; font-weight: bold; float: right; }
    .prodlist li .by { font-size: 12px; font-style: italic; margin-top:8px; }
    .prodlist li .desc { font-size: 12px; margin: 5px 0; line-height: 16px; }
    #afterpostingajax {margin: 2px;position: relative;top: 15px;color: #fff;background-color: #3a87ad;display: inline-block;font-size: 11.844px;font-weight: bold;line-height: 14px;text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);vertical-align: baseline;white-space: nowrap;left:262px;}
    /*body { font-size: 62.5%; }
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }*/

</style>
<div style="margin:50px auto; width:97%; padding:1px; background:#fff;">
    <div id="afterpostingajax"></div>
    <ul class="prodlist">
        <?php
        while ($row = mysql_fetch_array($result)) {

            if ($row['id'] == $_GET['id']) {
                $classcss = "select";
            } else {
                $classcss = "thumb";
            }
            ?>
            <li class="one_third">
                <div class="<?php echo $classcss; ?>">
                    <?php
                    if (!empty($row['file_attached'])) {
                        $stripslash = explode('/', $row['file_attached']);
                        $file = explode('.', $stripslash['1']);

                        if ($file['1'] == 'mp3' || $file['1'] == 'wav') {
                            ?>

                            <audio id="player" src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/" . $row['file_attached']; ?>" type="audio/mp3" controls="controls"></audio>
                            <a href="add_site_music.php?id=<?php echo $row["id"]; ?>&action=add" style="top:12px;position: relative;top: 3px;color: #000;background-color: #C5F9AE;">ADD TO MUSIC</a>
                            <?php
                        }

                        if ($file['1'] == 'jpg') {
                            ?>

                            <img id="player" width="120px" height="120px" src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/" . $row['file_attached']; ?>" />
                            <?php
                        }

                        if ($file['1'] == 'jpeg') {
                            ?>
                            <img id="player" width="120px" height="120px" src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/" . $row['file_attached']; ?>" />
                            <?php
                        }
                        ?>

                    </div>
                    <a href="#" onclick="Popup.showModal('modal_<?php echo $row['id']; ?>');return false;" class="contentinner">Share</a>
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST']; ?>/uploadcontact/filedownload.php?file=<?php echo $stripslash['1']; ?>" title="Download this !" style="float: left; margin: 5px 13px 7px 15px;">Download</a>
                    <a href="#" style="float: right; margin: 5px 244px 3px 5px;" onclick="Popup.showModal('modal_<?php echo $row['id']; ?>');return false;">Repost</a>
                    <a style="margin:-18px;position: relative;top: 5px;color: #fff;background-color: #FB0707;display: inline-block;font-size: 11.844px;font-weight: bold;line-height: 14px;text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);vertical-align: baseline;white-space: nowrap;left:255px;" href="media.php?id=<?php echo $row["id"]; ?>&action=delete">Delete</a>
                </li>
            <?php }
            ?>

            <div id="modal_<?php echo $row['id']; ?>" style="border:3px solid black; background-color:#9999ff; padding:25px; font-size:150%; text-align:center; display:none;">
                <p class="validateTips">Select Page you want Share/Repost it:</p>
                <div id="load<?php echo $row['id']; ?>" class="xxx"></div>
                <form action="ajaxcontact.php">
                    <label for="name">Select Page:</label>
                    <select id="page<?php echo $row['id']; ?>">
                        <option value="home">Home</option>
                        <option value="spotlight">Spotlight</option>
                        <option value="forum">Forum</option>
                    </select>
                    <br>
                    <br>
                    <input type="hidden" id="contactid<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>">
                    <input type="submit" id="<?php echo $row['id']; ?>" class="xxx" value="Submit"/>
                    <input type="button" value="Cancel" onClick="Popup.hide('modal_<?php echo $row['id']; ?>')"/>
                </form>
            </div>
        <?php }
        ?>
    </ul>
</div>
<script>
    $('audio,video').mediaelementplayer();
</script>