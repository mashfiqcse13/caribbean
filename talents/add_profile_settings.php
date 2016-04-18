<?php
include('../_includes/application-top.php');
ChecktalentLogin();
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Update')) {
    $data = array(
        "uid" => $_SESSION['talent_id'],
        "profile_display_status" => $_POST['profile_display_status'],
        "p_photo" => $_POST['p_photo'],
        "p_bio" => $_POST['p_bio'],
        "p_music" => $_POST['p_music'],
        "p_social" => $_POST['p_social'],
        "p_fans" => $_POST['p_fans'],
        "p_video" => $_POST['p_video'],
        "p_comments" => $_POST['p_comments'],
        "p_event" => $_POST['p_event'],
        "p_book" => $_POST['p_book'],
        "p_product" => $_POST['p_product']
    );

    $table = "tbl_user_profile_settings";

    $parameters = "uid='" . $_SESSION['talent_id'] . "' ";
    //print_r($data);
    updateData($data, $table, $parameters);

    $MSG = "Profile Settings Updated Successfully";
}
include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#add_details').validate();
    });


</script>
<div class="content">
    <h1>Profile Settings</h1>
    <?php
    if (isset($MSG) AND ( $MSG <> "")) {
        echo "<p class='msg'>$MSG</p>";
    }
    ?>
    <p><a href="profile_setup.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p>

    <div class="form_class">
        <?php
        //echo "SELECT * FROM ` tbl_user_details` WHERE user_id='".$_SESSION['talent_id']."' ";
        $query = mysql_query("SELECT * FROM tbl_user_profile_settings WHERE uid='" . $_SESSION['talent_id'] . "' ");
        //$row=mysql_fetch_assoc($query);
        //print_r($row);
        ?>

        <?php
        while ($row = mysql_fetch_assoc($query)) {
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="add_details" >
                <p>
                    <label style="width:290px;">
                        Profile can be viewed without login:
                    </label>
                    <select name="profile_display_status">
                        <option <?php
                        if ($row["profile_display_status"] == "1") {
                            echo "selected='selected'";
                        }
                        ?>  value="1">Yes</option>
                        <option <?php
                        if ($row["profile_display_status"] == "0") {
                            echo "selected='selected'";
                        }
                        ?>  value="0">No</option>
                    </select>
                </p>
                <p>
                    <label style="width:290px;">
                        Profile Photos Position:
                    </label>
                    <select name="p_photo">
                        <option <?php
                            if ($row["p_photo"] == "0") {
                                echo "selected='selected'";
                            }
                            ?>  value="0">Hide Module</option>
                        <option <?php
                        if ($row["p_photo"] == "1") {
                            echo "selected='selected'";
                        }
                        ?>  value="1">First Column</option>
                        <option <?php
                        if ($row["p_photo"] == "2") {
                            echo "selected='selected'";
                        }
                        ?>  value="2">Second Column</option>
                        <option <?php
                        if ($row["p_photo"] == "3") {
                            echo "selected='selected'";
                        }
                        ?>  value="3">Third Column</option>
                    </select>
                </p>
                <p>
                    <label style="width:290px;">
                        Profile Bio Position:
                    </label>
                    <select name="p_bio">
                        <option <?php
                        if ($row["p_bio"] == "0") {
                            echo "selected='selected'";
                        }
                        ?>  value="0">Hide Module</option>
                        <option <?php
                        if ($row["p_bio"] == "1") {
                            echo "selected='selected'";
                        }
                        ?>  value="1">First Column</option>
                        <option <?php
                        if ($row["p_bio"] == "2") {
                            echo "selected='selected'";
                        }
                        ?>  value="2">Second Column</option>
                        <option <?php
                        if ($row["p_bio"] == "3") {
                            echo "selected='selected'";
                        }
                        ?>  value="3">Third Column</option>
                    </select>
                </p>
                <p>
                    <label style="width:290px;">
                        Profile Musics Position:
                    </label>
                    <select name="p_music">
                        <option <?php
                            if ($row["p_music"] == "0") {
                                echo "selected='selected'";
                            }
                            ?>  value="0">Hide Module</option>
                        <option <?php
                        if ($row["p_music"] == "1") {
                            echo "selected='selected'";
                        }
                        ?>  value="1">First Column</option>
                        <option <?php
                        if ($row["p_music"] == "2") {
                            echo "selected='selected'";
                        }
                        ?>  value="2">Second Column</option>
                        <option <?php
                        if ($row["p_music"] == "3") {
                            echo "selected='selected'";
                        }
                        ?>  value="3">Third Column</option>
                    </select>
                </p>
                <p>
                    <label style="width:290px;">
                        Profile Social Links Position:
                    </label>
                    <select name="p_social">
                        <option <?php
                        if ($row["p_social"] == "0") {
                            echo "selected='selected'";
                        }
                        ?>  value="0">Hide Module</option>
                        <option <?php
                        if ($row["p_social"] == "1") {
                            echo "selected='selected'";
                        }
                        ?>  value="1">First Column</option>
                        <option <?php
                        if ($row["p_social"] == "2") {
                            echo "selected='selected'";
                        }
                        ?>  value="2">Second Column</option>
                        <option <?php
                        if ($row["p_social"] == "3") {
                            echo "selected='selected'";
                        }
                        ?>  value="3">Third Column</option>
                    </select>
                </p>
                <p>
                    <label style="width:290px;">
                        Profile Fans Position:
                    </label>
                    <select name="p_fans">
                        <option <?php
                        if ($row["p_fans"] == "0") {
                            echo "selected='selected'";
                        }
                        ?>  value="0">Hide Module</option>
                        <option <?php
                        if ($row["p_fans"] == "1") {
                            echo "selected='selected'";
                        }
                        ?>  value="1">First Column</option>
                        <option <?php
                        if ($row["p_fans"] == "2") {
                            echo "selected='selected'";
                        }
                        ?>  value="2">Second Column</option>
                        <option <?php
                        if ($row["p_fans"] == "3") {
                            echo "selected='selected'";
                        }
                        ?>  value="3">Third Column</option>
                    </select>
                </p>
                <p>
                    <label style="width:290px;">
                        Profile Videos Position:
                    </label>
                    <select name="p_video">
                        <option <?php
                        if ($row["p_video"] == "0") {
                            echo "selected='selected'";
                        }
                        ?>  value="0">Hide Module</option>
                        <option <?php
                        if ($row["p_video"] == "1") {
                            echo "selected='selected'";
                        }
                        ?>  value="1">First Column</option>
                        <option <?php
                        if ($row["p_video"] == "2") {
                            echo "selected='selected'";
                        }
                        ?>  value="2">Second Column</option>
                        <option <?php
                        if ($row["p_video"] == "3") {
                            echo "selected='selected'";
                        }
                        ?>  value="3">Third Column</option>
                    </select>
                </p>
                <p>
                    <label style="width:290px;">
                        Profile Comments Position:
                    </label>
                    <select name="p_comments">
                        <option <?php
                        if ($row["p_comments"] == "0") {
                            echo "selected='selected'";
                        }
                        ?>  value="0">Hide Module</option>
                        <option <?php
                        if ($row["p_comments"] == "1") {
                            echo "selected='selected'";
                        }
                        ?>  value="1">First Column</option>
                        <option <?php
                        if ($row["p_comments"] == "2") {
                            echo "selected='selected'";
                        }
                        ?>  value="2">Second Column</option>
                        <option <?php
                            if ($row["p_comments"] == "3") {
                                echo "selected='selected'";
                            }
                            ?>  value="3">Third Column</option>
                    </select>
                </p>
                <p>
                    <label style="width:290px;">
                        Profile Events Position:
                    </label>
                    <select name="p_event">
                        <option <?php
                            if ($row["p_event"] == "0") {
                                echo "selected='selected'";
                            }
                            ?>  value="0">Hide Module</option>
                        <option <?php
                            if ($row["p_event"] == "1") {
                                echo "selected='selected'";
                            }
                            ?>  value="1">First Column</option>
                        <option <?php
                            if ($row["p_event"] == "2") {
                                echo "selected='selected'";
                            }
                            ?>  value="2">Second Column</option>
                        <option <?php
                            if ($row["p_event"] == "3") {
                                echo "selected='selected'";
                            }
                            ?>  value="3">Third Column</option>
                    </select>
                </p>
                <p>
                    <label style="width:290px;">
                        Profile Book Position:
                    </label>
                    <select name="p_book">
                        <option <?php
    if ($row["p_book"] == "0") {
        echo "selected='selected'";
    }
    ?>  value="0">Hide Module</option>
                        <option <?php
    if ($row["p_book"] == "1") {
        echo "selected='selected'";
    }
    ?>  value="1">First Column</option>
                        <option <?php
    if ($row["p_book"] == "2") {
        echo "selected='selected'";
    }
    ?>  value="2">Second Column</option>
                        <option <?php
    if ($row["p_book"] == "3") {
        echo "selected='selected'";
    }
    ?>  value="3">Third Column</option>
                    </select>
                </p>
                <p>
                    <label style="width:290px;">
                        Profile Product Position:
                    </label>
                    <select name="p_product">
                        <option <?php
    if ($row["p_product"] == "0") {
        echo "selected='selected'";
    }
    ?>  value="0">Hide Module</option>
                        <option <?php
    if ($row["p_product"] == "1") {
        echo "selected='selected'";
    }
    ?>  value="1">First Column</option>
                        <option <?php
    if ($row["p_product"] == "2") {
        echo "selected='selected'";
    }
    ?>  value="2">Second Column</option>
                        <option <?php
    if ($row["p_product"] == "3") {
        echo "selected='selected'";
    }
    ?>  value="3">Third Column</option>
                    </select>
                </p>
                <input type="submit" name="submit" value="Update" class="button"></p>
            </form> 			
    <?php
}
?>   
    </div>
</div>
<script type="text/javascript" language="javascript">
    $("#add_details").validate({
        rules: {
            social_link1: {
                url: true
            },
            social_link2: {
                url: true
            },
            social_link3: {
                url: true
            },
            social_link4: {
                url: true
            }
        }
    });
</script>
<?php
include('../_includes/footer.php');
?>
