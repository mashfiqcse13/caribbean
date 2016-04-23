<?php include('_includes/application-top.php'); ?>


<?php include('_includes/header.php'); ?>

<style>
    aside.items {
        border: 3px solid #DDDDDD;
        padding: 5px;
        margin: 0 0 10px;
    }
    .item_info{
        color: #009900;
        text-align: right;
    }
    .item_info tr td:first-child {
        font-weight: bold;
        text-align: left;
    }
</style>

<div class="content">
    <!--<h1>SPOTLIGHT</h1>-->
    <h1><?php echo GetPageHeading('SPOTLIGHT'); ?></h1>

    <table cellpadding="10" cellspacing="0" class="Tabforumtopic" width="100%">
        <tr>
            <td width="70%"><p><?php echo GetPageText('SPOTLIGHT'); ?></p></td>
            <td  style="vertical-align: top">
                <?php
                $sql = 'SELECT tbl_contact.*,tbl_contactrecords.`page_name` 
                    FROM tbl_contact 
                        JOIN tbl_contactrecords on tbl_contact.id = tbl_contactrecords.`contactid` 
                    where page_name = \'Spotlight\'';

                $result = mysql_query($sql);

                if ($result) {
                    while ($row = mysql_fetch_array($result)) {
                        if (!empty($row['file_attached'])) {
                            ?>
                            <aside class="items">
                                <?php
                                $stripslash = explode('/', $row['file_attached']);
                                $file = explode('.', $stripslash['1']);

                                if ($file['1'] == 'mp3' || $file['1'] == 'wav') {
                                    ?>

                                    <audio width="100%" id="player" src="<?php echo SITE_URL . $row['file_attached']; ?>" type="audio/mp3" controls="controls"></audio>
                                    <?php
                                }

                                if ($file['1'] == 'jpg' || $file['1'] == 'jpeg' || $file['1'] == 'png') {
                                    ?>

                                    <img id="player" src="<?php echo SITE_URL . $row['file_attached']; ?>" />
                                    <?php
                                }

                                if ($file['1'] == 'mp4') {
                                    ?> 
                                    <video width="100%" controls="">
                                        <source src="<?php echo SITE_URL . $row['file_attached']; ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video> 
                                    <?php
                                }
                                ?>
                                <table class="item_info">
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

                            </aside>
                        <?php }
                        ?>

                        <?php
                    }
                }
                ?>
            </td>
        </tr>
    </table>
</div>

<?php
include('_includes/footer.php');
?>

