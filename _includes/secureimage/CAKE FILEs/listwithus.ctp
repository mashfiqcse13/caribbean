<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php echo $javascript->link('datetimepicker.js'); ?>
<script type="text/javascript">
    function openup()
    {
        document.getElementById('upload_testi_photo').style.display = 'block';
    }
    function closeup()
    {
        document.getElementById('upload_testi_photo').style.display = 'none';
        document.getElementById('photo_info').value = '';
    }
</script>

<div class="container" style="padding-top:16px;">

    <div class="main-crumbar">
        <?
        echo $crumb->getHtml('List With Us', null, 'List With Us' ) ;
        ?>
    </div>

    <!--<div class="bannerabt" style="background:url(/app/webroot/img/gen_banner2.jpg) no-repeat 0 0;">
				<?php $sel=mysqli_query($link,"SELECT bannerimg FROM contentmanagements WHERE id =82 AND parent_id =0");
				 					 $selimg = mysqli_fetch_array($sel); $selectimg = $selimg['bannerimg'];?>
    <div class="bannerabt" style="background:url(<?php echo $this->webroot.'admin/bannerimg/'.$selectimg;?>) no-repeat 0 0;">-->
    <div class="left_area">			
        <h2>SELLING OR RENTING YOUR PROPERTY</h2>
        <p>
            Please take two minutes of your time to fill in the details below, about your property. One of our expert property consultant will call you within
            24 hours to talk you through the next step and any further marketing advice we may have for you, to ensure maximum results.
        </p>
        <div class="clear"></div>
        <div style="height:15px;"></div>
        <? 
        $composeform = array('type'=>'POST','action'=>'sendamail', 'name' => 'listwithus','onsubmit'=>'javascript:return listwithusvalidation();','enctype' => 'multipart/form-data');
        echo $form->create('Users',$composeform);
        ?>


        <div style="float: left; width: 695px;">
            <div class="form-top" style="width:695px"></div>
            <div class="form-center" style="width:599px">
						<?php echo "<font color='red'>".$message_set."</font>";?>
                <h1 style="padding-bottom:8px;">YOUR PROPERTY DETAILS</h1>
                <div class="clear"></div>
                <div class="form-main" style="width:465px">
                    <div class="clear"></div>
                    <div class="required"><span class="star">*</span>Required fields.</div>
                    <div class="clear"></div>

                    <input name="querystring" type="hidden" class="txtbox" id="querystring" value="<?php echo $_SERVER['REQUEST_URI']?>" />
                    <input name="freemailalert" type="hidden" class="txtbox" value="12" id="freemailalert" />

                    <div class="form-text">I Wish To:</div>
                    <div class="form-input">
                        <select name="selling-type" id="selling-type" style="width:328px">                

                            <option value="Rent My Property">Rent My Property</option>
                            <option value="Sell My Property">Sell My Property</option>

                        </select>
                    </div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>								

                    <div class="formerror" id="property-type-error" style="display:none">Select Property Type</div>
                    <div class="clear"></div>
                    <div class="form-text">Property Type:</div>
                    <div class="form-input">
                        <select name="property-type" id="property-type" style="width:328px">                
                            <option value="0">Select Property Type</option>
                            <option value="Commercial">Commercial</option>
                            <option value="Flat/Apartment">Flat/ Apartment</option>
                            <option value="Villa">Villa</option>
                        </select>
                    </div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                    <div class="formerror" id="community-error" style="display:none">Select Community</div>
                    <div class="clear"></div>
                    <div class="form-text">Community:</div>
                    <div class="form-input">
                        <select name="community" id="community" style="width:328px" >
                            <option value="0" selected>Select Community</option>
										<?php foreach($select_local_area as $local_area_arr) {?>
                            <option value="<?php echo $local_area_arr['propertydetails']['local_area']?>"><?php echo $local_area_arr['propertydetails']['local_area']?></option>
                            <? } ?>
                        </select>
                    </div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                    <div class="formerror" id="building-name-error" style="display:none">Insert Building Name</div>
                    <div class="clear"></div>
                    <div class="form-text">Building Name:</div>
                    <div class="form-input"><input name="building-name" type="text" class="input" id="building-name" /></div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                    <div class="formerror" id="floor-no-error" style="display:none">Insert Floor No</div>
                    <div class="clear"></div>
                    <div class="form-text">Floor No.:</div>
                    <div class="form-input"><input name="floor-no" type="text" class="input" id="floor-no" /></div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                    <div class="formerror" id="unit-no-error" style="display:none">Insert Unit No</div>
                    <div class="clear"></div>
                    <div class="form-text">Unit No.:</div>
                    <div class="form-input"><input name="unit-no" type="text" class="input" id="unit-no" /></div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                    <div class="form-text">Street No.:</div>
                    <div class="form-input"><input name="street-no" type="text" class="input" id="street-no" /></div>
                    <div class="form-clear"></div>

                    <div class="formerror" id="asking-price-error" style="display:none">Insert Asking Price</div>
                    <div class="clear"></div>
                    <div class="form-text">Asking Price:</div>
                    <div class="form-input"><input name="asking-price" type="text" class="input" id="asking-price" /></div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                    <div class="formerror" id="view-error" style="display:none">Insert View</div>
                    <div class="clear"></div>
                    <div class="form-text">View:</div>
                    <div class="form-input"><input name="view" type="text" class="input" id="view" /></div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                    <div class="formerror" id="bedrooms-error" style="display:none">Select Bedrooms</div>
                    <div class="clear"></div>
                    <div class="form-text">Bedrooms:</div>
                    <div class="form-input">
                        <select name="bedrooms" id="bedrooms" style="width:328px" >
                            <option value="0">Select Bedrooms</option>									
                            <option value="Studio">Studio</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                    <div class="formerror" id="unit-area-error" style="display:none">Insert Unit area</div>
                    <div class="clear"></div>
                    <div class="form-text">Unit area (sq.ft): </div>
                    <div class="form-input"><input name="unit-area" type="text" class="input" id="unit-area" /></div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                    <div class="formerror" id="description-error" style="display:none">Insert Description</div>
                    <div class="clear"></div>
                    <div class="form-text">Description: </div>
                    <div class="form-input"><textarea name="description" id="description" style="height: 132px;" class="input"></textarea></div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                </div>

                <div class="clear"></div>
                <h1>UPLOAD PROPERTY DOCUMENTS</h1>
                <div class="clear"></div>
                <div class="form-main">
                    <div class="clear"></div>
                    <div class="clear"></div>

                    <div class="form-text">Proof Of Ownership <br>(Title Deeds):</div>
                    <div class="form-input">
                        <input type="file" size="53" class="input" name="proof-of-ownership" id="proof-of-ownership" />
                    </div>
                    <div style="padding-left: 11px;" class="star"></div>
                    <div class="form-clear"></div> 

                    <div class="form-text">Passport Page Scan:</div>
                    <div class="form-input">
                        <input type="file" size="53" class="input" name="passport-page-scan" id="passport-page-scan" />
                    </div>
                    <div style="padding-left: 11px;" class="star"></div>
                    <div class="form-clear"></div> 

                    <div class="form-text">Floor Plan:</div>
                    <div class="form-input">
                        <input type="file" size="53" class="input" name="floor-plan" id="floor-plan" />
                    </div>
                    <div class="star"></div>
                    <div class="form-clear"></div>

                    <div class="form-text">Photo Of Property 1 :</div>
                    <div class="form-input">
                        <input type="file" size="53" class="input" name="photo-of-property" id="photo-of-property" />
                    </div>
                    <div style="padding-left: 11px;" class="star"></div>
                    <div class="form-clear"></div>

                </div>	
                <div class="clear"></div>
                <h1>YOUR DETAILS</h1> 
                <div class="clear"></div>
                <div class="form-main" style="width:465px;">
                    <div class="clear"></div>

                    <div class="formerror" id="title-error" style="display:none; color:#676767;">Select Title</div>
                    <div class="clear"></div>
                    <div class="form-text">Title:</div>
                    <div class="form-select">
                        <select name="title" id="title" style="width:120px">
                            <option value="0">Select</option>
                            <option value="Mr.">Mr.</option>
                            <option value="Miss">Miss</option>
                            <option value="Mrs.">Mrs.</option>
                            <option value="Ms.">Ms.</option>
                            <option value="Dr.">Dr.</option>
                            <option value="Sheikh">Sheikh</option>
                            <option value="Sheikha">Sheikha</option>
                            <option value="H.H">H.H</option>
                            <option value="H.E">H.E</option>
                            <option value="Ms.">Ms.</option>
                        </select>
                    </div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                    <div class="formerror" id="fname-error" style="display:none">Insert First Name</div>
                    <div class="clear"></div>
                    <div class="form-text">First Name:</div>
                    <div class="form-input"><input class="input" id="fname" name="fname" /></div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                    <div class="formerror" id="lname-error" style="display:none">Insert Last Name</div>
                    <div class="clear"></div>
                    <div class="form-text">Last Name:</div>
                    <div class="form-input"><input class="input" id="lname" name="lname" /></div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                    <div class="formerror" id="mob-phone-error" style="display:none"></div>
                    <div class="clear"></div>
                    <div class="form-text">Contact No.:</div>
                    <div class="form-input">
                        <div style="float: left; width:82px;">
                            <select style="width: 79px; height: 23px;" name="mob-phone" id="mob-phone">
                                <option value="0">Select</option>
                                <option value="Mobile">Mobile</option>
                                <option value="Phone">Phone</option>
                            </select>
                        </div>                                                   
                        <input type="text" id="mob-phone-1" name="mob-phone-1" style="width: 80px; margin-right:4px;" class="input" />
                        <input type="text" id="mob-phone-2" name="mob-phone-2" style="width: 79px; margin-right:4px;" class="input" />
                        <input type="text" id="mob-phone-3" name="mob-phone-3" style="width: 79px; margin-right:4px;" class="input" />
                    </div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                    <div class="formerror" id="emailadd-error" style="display:none">Insert Email Address</div>
                    <div class="clear"></div>
                    <div class="form-text">Email Address:</div>
                    <div class="form-input"><input value="" id="emailaddlist" name="emailadd" class="input" /></div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                    <div class="clear"></div>
                    <div class="form-text">&nbsp;</div>
                    <div class="form-input"><img onclick="document.getElementById('captcha').src = '/secureimage/securimage_show_example2.php?' + Math.random(); return false" id="captcha" src="/secureimage/securimage_show_example2.php" alt="CAPTCHA Image" width="142px" height="50px" /></div>
                    <div class="form-clear"></div>

                    <div class="formerror" id="captcha-error" style="display:none">Enter Captcha</div>
                    <div class="clear"></div>
                    <div class="form-text">Enter Captcha</div>
                    <div class="form-input"><input value="" id="captcha_code" name="captcha_code" class="input" /></div>
                    <div class="star">*</div>
                    <div class="form-clear"></div>

                    <div class="formerror" id="mustcheck-error" style="display:none">Please check</div>
                    <div class="clear"></div>
                    <div class="form-text"></div>
                    <div class="form-input"><input checked="checked" type="checkbox" id="mustcheck" name="mustcheck" class="input" style="padding:0px;width:16px;" />
                        <span style="float:left;width:300px;padding-top:2px;">
                            I have no objection to Allsopp & Allsopp marketing my property through a variety of marketing mediums in order to find a potential client for my property
                        </span>
                    </div>
                    <div class="form-clear"></div>

                    <div class="form-text">&nbsp;</div>
                    <div class="form-input">
                        <div class="box-privacypolicy">Note: We take your privacy seriously. All details and information<br>provided are dealt with in a professional manner according to our<br><a href="http://allsopp.trafficdemos.net/privacy">Privacy Policy</a></div></div>                        
                    <div class="form-clear"></div>   

                    <div class="form-text"></div>
                    <div style="padding-top: 15px; padding-bottom: 15px;" class="form-input">
                        <div style="float: left; width: 128px;"><input name="callbackbutton" type="image" src="<?php echo $this->webroot ;?>images/send-bt.gif"></div>
                    </div>
                    <div class="form-clear"></div> 


                </div>	

            </div>        



            <div class="form-bot" style="width:695px" ></div>

        </div>


				<?php
				
				echo $form->end();
				?>




    </div>
    <!--container content div end here -->

    <!--property search div start here -->

    <!--property search div end here -->

    <!--property search div start here -->
    <div class="right_area">
            <?php echo $this->renderElement("search_right_panel");?>
    </div>
            <?php //echo $this->renderElement("aboutdetail_right_panel");?>

    <div class="clear"></div>

    <!--bottom panel div start here -->
    <?php echo $this->renderElement("bottom_content");?>
    <!--bottom panel div end here -->


    <script type="text/javascript" language="javascript">
        modified_Styler('proof-of-ownership', 'apnaUploadImage');
        modified_Styler('passport-page-scan', 'apnaUploadImage');
        modified_Styler('floor-plan', 'apnaUploadImage');
        modified_Styler('photo-of-property', 'apnaUploadImage');
    </script>

    <!--container div end here -->

