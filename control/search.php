<?php
include('include/application_top.php');
cmslogin();
//session_start();
?>


<?php include('include/header.php'); ?>




<div id="textbox">

    <form action="" method="post" >
        <div style="clear:both; float:left; margin:0px; padding:0px; width:225px; ">	
            <div style="clear:both; float:left; margin:0px; padding:0px; width:200px;">
                <label>
                    <input type="text" name="search" id="search" placeholder="Search user..." class="searchbox" />
                </label>
            </div> 
            <div style="float:right; margin:0px; padding:0px; width:25px; text-align:left">
                <input type="button" name="submit" value="" class="btnsearch" />
            </div>     
        </div> 
    </form>
</div>

<div class="load"></div>









<script>
    $(document).ready(function () {
        $('.btnsearch').click(function () {
            var txt = $('#search').val();
            $('.load').load('getdata.php?search=' + txt);
            $('#search').val("");
        });
    });
</script>

<div id="show_search_user"><!--END THE show_search_user-->
    <?php include('include/footer.php'); ?>
