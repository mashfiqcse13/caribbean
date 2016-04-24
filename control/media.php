<!-- <script src="http://kolber.github.io/audiojs/audiojs/audio.js"></script> -->
<?php
include('include/application_top.php');
cmslogin();

include('include/header.php');

if (!empty($_REQUEST['id']) && $_REQUEST['action'] == "delete") {
    $db_rslt_file_name = mysql_query("SELECT * FROM tbl_contact WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'");
    $file_name_4_dlt = mysql_fetch_array($db_rslt_file_name);
    $file_name_4_dlt = '../' . $file_name_4_dlt['file_attached'];
    unlink($file_name_4_dlt);
//    die($file_name_4_dlt);

    mysql_query("UPDATE `tbl_contact` SET `file_attached`='' WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "';");
    echo "<div id='afterpostingajax'>File Successfully Deleted</div>";
}


if (isset($_GET['filetype'])) {
    $supported_file_type = array('Video', 'Photo', 'Music', 'Document', 'Archive');
    $selected_file_type = $supported_file_type[$_GET['filetype']];
    $sql = "SELECT * FROM tbl_contact where `type_of_file` = '$selected_file_type'";
    $result = mysql_query($sql);
} else {
    $sql = "SELECT * FROM tbl_contact";
    $result = mysql_query($sql);
}

if (!$result) {
    die("Retrieving records from contact table's query faild:" . mysql_query());
}
?>
<script type="text/javascript">
    function ConfrimMessage_Delete(Url) //confarming property delete
    {
        if (confirm("Are you sure you want to delete this Song ?"))
        {
            window.location = "" + Url;
        }
    }

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
                url: "<?php echo SITE_URL; ?>ajaxcontact.php",
                data: "pg=" + page + "&cnt=" + contactid,
                success: function (html) {
                    if (html.trim() == 'true')
                    {
                        $("#content_body").prepend("<div id=\"afterpostingajax\">\n\
                                    This Media has been shared to " + page + " Page successfully</div>");
                        setTimeout(function () {
                            $("#afterpostingajax").fadeOut("slow", function () {
                                $("#afterpostingajax").remove();
                            });

                        }, 2000);
                        Popup.hide("modal_" + contactid);
                    } else
                    {
                        ll = '#load' + u_id;
                        $(ll).html("Posting failed");
                    }
                },
                beforeSend: function ()
                {
                    ll = '#load' + u_id;
                    $(ll).html("Loading...");
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
    .prodlist {
        list-style: outside none none;
        margin: 20px;
        min-width: 900px;
    }

    .prodlist li {
        color: #000;
        display: inline-block;
        margin: 0 10px 40px;
        overflow: hidden;
        position: relative;
        text-shadow: 1px 1px rgba(0, 0, 0, 0.3);
        width: 31%;
    }
    .prodlist li a { color: #FB9337; }
    .prodlist li .thumb { padding: 5px; border: 3px solid #ddd; }
    .prodlist li .thumb img { max-width: 100%; max-height: 215px; }
    .prodlist li .select { padding: 5px; border: 3px solid #FF9900; }
    .prodlist li .content { position: absolute; top: 5px; left: 5px; width: 225px; height: 163px; overflow: hidden; }
    .prodlist li .contentinner { background: url(bg.png); padding: 5px 7px;float:left;}
    .prodlist li .title { color: #fff; font-family:Arial,Helvetica,sans-serif; font-size: 13px; }
    .prodlist li .title:hover { color: #FB9337; }
    .prodlist li .price { color: #fff; font-weight: bold; float: right; }
    .prodlist li .by { font-size: 12px; font-style: italic; margin-top:8px; }
    .prodlist li .desc { font-size: 12px; margin: 5px 0; line-height: 16px; }
    #afterpostingajax {margin: 2px;position: relative;top: 15px;color: #fff;background-color: #3a87ad;display: inline-block;font-size: 11.844px;font-weight: bold;line-height: 14px;text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);vertical-align: baseline;white-space: nowrap;left:262px;}
    .thumb > table {
        color: #009900;
        text-align: right;
    }
    .thumb tr td:first-child {
        text-align: left;
        font-weight: bold;
    }
    .file_sorter {
        list-style: outside none none;
    }
    .file_sorter > li {
        border-left: 2px solid #444444;
        color: #FF9900;
        display: inline-block;
        margin: 0 5px;
        padding: 0 20px;
    }
    .file_sorter > li:first-child {
        border-left: none;
    }
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
<div style="margin:50px auto; width:97%; padding:1px; background:#fff;" id="content_body">
    <div id="afterpostingajax"></div>
    <ul class="file_sorter">
        <?php
        // file separation buttons
        $links = array(
            array(
                'url' => 0,
                'text' => 'Video'
            ),
            array(
                'url' => 1,
                'text' => 'Photo'
            ),
            array(
                'url' => 2,
                'text' => 'Music'
            ),
            array(
                'url' => 3,
                'text' => 'Document'
            ),
            array(
                'url' => 4,
                'text' => 'Archive'
            ),
        );
        foreach ($links as $link) {
            if (isset($_GET['filetype']) && $_GET['filetype'] == $link['url']) {
                echo '<li>' . $link['text'] . '</li>';
            } else {
                echo '<li><a href="' . basename(__FILE__) . "?filetype=" . $link['url'] . '">' . $link['text'] . '</a></li>';
            }
        }
        ?>
    </ul>
    <ul class="prodlist">
        <?php
        while ($row = mysql_fetch_array($result)) {

            if ($row['id'] == $_GET['id']) {
                $classcss = "select";
            } else {
                $classcss = "";
            }
            ?>
            <?php
            if (!empty($row['file_attached'])) {
                $stripslash = explode('/', $row['file_attached']);
                $file = explode('.', $stripslash['1']);
                ?>
                <li class="one_third">
                    <div class="thumb <?php echo $classcss; ?>">
                        <?php
                        if ($file['1'] == 'mp3' || $file['1'] == 'wav') {
                            ?>

                            <audio width="100%" id="player" src="<?php echo SITE_URL1 . $row['file_attached']; ?>" type="audio/mp3" controls="controls"></audio>
                            <a href="add_site_music.php?id=<?php echo $row["id"]; ?>&action=add" style="top:12px;position: relative;top: 3px;color: #000;background-color: #C5F9AE;">ADD TO MUSIC</a>
                            <?php
                        } else if ($file['1'] == 'jpg' || $file['1'] == 'jpeg' || $file['1'] == 'png') {
                            ?>

                            <img id="player" src="<?php echo SITE_URL1 . $row['file_attached']; ?>" />
                            <?php
                        } else if ($file['1'] == 'mp4') {
                            ?> 
                            <video width="100%">
                                <source src="<?php echo SITE_URL1 . $row['file_attached']; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video> 
                            <?php
                        } else {
                            ?>

                            <img id="player" style="width: 70px;text-align: center" src="http://downloadicons.net/sites/default/files/folder-files-icon-14281.png" />
                            <?php
                        }
                        ?>
                        <table>
                            <tr>
                                <td>Title Of Work</td>
                                <td>:</td>
                                <td><?php echo $row['title_of_work'] ?></td>
                            </tr>
                            <tr>
                                <td>Artist</td>
                                <td>:</td>
                                <td><?php echo $row['artistbandname'] ?></td>
                            </tr>
                            <tr>
                                <td>Genre</td>
                                <td>:</td>
                                <td><?php echo $row['genre'] ?></td>
                            </tr>
                            <tr>
                                <td>Posted by</td>
                                <td>:</td>
                                <td><?php echo $row['name'] ?></td>
                            </tr>
                            <tr>
                                <td>Company</td>
                                <td>:</td>
                                <td><?php echo $row['company'] ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><?php echo $row['email'] ?></td>
                            </tr>
                            <tr>
                                <td>Created On</td>
                                <td>:</td>
                                <td><?php echo "{$row['join_date']} {$row['join_time']}" ?></td>
                            </tr>
                        </table>

                    </div>
                    <a href="#" onclick="Popup.showModal('modal_<?php echo $row['id']; ?>');
                            return false;" 
                       class="contentinner">Share</a>
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST']; ?>/uploadcontact/filedownload.php?file=<?php echo $stripslash['1']; ?>" 
                       title="Download this !" class="contentinner">Download</a>
                    <a href="#" onclick="Popup.showModal('modal_<?php echo $row['id']; ?>');
                            return false;"
                       class="contentinner">Repost</a>
                    <a  href="<?php echo "javascript:ConfrimMessage_Delete('" . basename(__FILE__) . "?id=" . $row["id"] . "&action=delete')"; ?>"
                        class="contentinner btn_dlt">Delete</a>
                </li>
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
                </li>
            <?php }
            ?>

        <?php }
        ?>
    </ul>
</div>
<script>
    $('audio,video').mediaelementplayer();
</script>