<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!--Media items content are here-->
<div style="display:none">
    <div id="media">
        <style>
            #add_media_button {margin: 0 0 20px 140px;display: inline-block;}
            #media{margin: 10px 0;}
            #media li{display: inline-block;}
            #media > ul{padding: 0;margin: 0;}
            #media li{display: inline-block; margin: 10px 3px;}
            #media table { padding: 5px;}
            #media li:hover,#media li.selected{background-color:#F1F1F1;}
            #selected_media_preview {margin: 0 0 20px 137px;}
        </style>
        <ul>
            <?php
            $media = new media();
            $media_rows = $media->get_all_media_as_array('pic_music_vedio');
            foreach ($media_rows as $key => $media_row) {
                ?>
                <li class="media_item" data-media-id="<?php echo $media_row['id'] ?>">
                    <div class="media_preview">
                        <?php
                        if ($media_row['type_of_file'] == 'Music') {
                            ?>

                            <audio  width="100%" src="<?php echo BASE_URL . $media_row['file_attached']; ?>" type="audio/mp3" controls="controls"></audio>
                            <?php
                        } else if ($media_row['type_of_file'] == 'Photo') {
                            ?>

                            <img  width="300" height="200" src="<?php echo BASE_URL . $media_row['file_attached']; ?>" />
                            <?php
                        } else if ($media_row['type_of_file'] == 'Video') {
                            ?> 
                            <video width="300" height="200" controls="">
                                <source src="<?php echo BASE_URL . $media_row['file_attached']; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video> 
                            <?php
                        }
                        ?>
                    </div>>
                    <table>
                        <tr>
                            <td>Title Of Work</td>
                            <td>:</td>
                            <td><?php echo $media_row['title_of_work'] ?></td>
                        </tr>
                        <tr>
                            <td>Artist</td>
                            <td>:</td>
                            <td><?php echo $media_row['artistbandname'] ?></td>
                        </tr>
                        <tr>
                            <td>Genre</td>
                            <td>:</td>
                            <td><?php echo $media_row['genre'] ?></td>
                        </tr>
                        <tr>
                            <td>Posted by</td>
                            <td>:</td>
                            <td><?php echo $media_row['name'] ?></td>
                        </tr>
                        <tr>
                            <td>Company</td>
                            <td>:</td>
                            <td><?php echo $media_row['company'] ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td><?php echo $media_row['email'] ?></td>
                        </tr>
                        <tr>
                            <td>Created On</td>
                            <td>:</td>
                            <td><?php echo "{$media_row['join_date']} {$media_row['join_time']}" ?></td>
                        </tr>
                        <tr>
                            <td>Media id</td>
                            <td>:</td>
                            <td><?php echo $media_row['id'] ?></td>
                        </tr>
                    </table>

                </li>

            <?php } ?>
        </ul>

    </div>
</div>

<script type="text/javascript">
    // for media section in the form
    $("a#add_media_button").fancybox();

    //For selecting a media
    $('.media_item').click(function () {
        $('.media_item').removeClass('selected');
        var selected_media_id = $(this).attr('data-media-id');
        $('[name="media_id"]').val(selected_media_id);
        $(this).addClass('selected');

        var media_preview = $('[data-media-id="' + selected_media_id + '"] .media_preview').html();
        $('#selected_media_preview').html(media_preview);
        $('#selected_media_preview > img,#selected_media_preview > video').attr('height', 300);
        $('#selected_media_preview > audio,#selected_media_preview > video').attr('width', 500);
        $('#selected_media_preview > img').removeAttr('width');
    });

</script>
