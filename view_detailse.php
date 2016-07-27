<?php
include('_includes/application-top.php');

//$query=mysqli_query($link,"SELECT * FROM tbl_user_details WHERE user_id='".$_GET['id']."' AND tbl_user_details.profile_display_status='1' ");
$query = mysqli_query($link,"SELECT * FROM tbl_user_details WHERE user_id='" . $_GET['id'] . "'");
$treu = mysqli_fetch_assoc($query);
//print_r($treu);

include('_includes/header.php');
?>
<script type="text/javascript">
    function back()
    {
        window.history.back();
    }
</script>
<div class="content">
    <h2>Biography</h2>
    <p style="text-align:right"><a href="javascript:music(0)" class="button" style="float:left; margin:-5px 0px 0px 0px;" onclick="return back();">Back</a></p>
    <div id="a_detailse">		
        <?php echo nl2br($treu["biography"]); ?>	   
    </div>
</div>
<?php
include('_includes/footer.php');
?>
