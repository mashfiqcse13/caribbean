<?php
include('../_includes/application-top.php');
//ChecktalentLogin();
/* function talent($id)
  {
  $sql="SELECT * FROM tbl_talents WHERE status=1 AND id='".$id."'";
  $result=mysql_query($sql);
  $data=mysql_fetch_assoc($result);
  return $data['talent'];
  }

  $result="SELECT * FROM tbl_users WHERE id='".$_SESSION['talent_id']."'";
  $sql=mysql_query($result);
  $data=mysql_fetch_assoc($sql); */

include('../_includes/header.php');
?>
<div class="content">
    <h1>Congratulations,</h1>
    <?php
    if (isset($_GET['op'])) {
        ?>
        <p class="msg">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "register")) {
                echo "Please go to your email address to confirm verification, before you proceed with this signup application. ";
            }
            ?>
        </p>
    <?php } ?>

</div>

<?php
include('../_includes/footer.php');
?>
