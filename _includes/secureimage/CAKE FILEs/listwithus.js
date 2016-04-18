function listwithusvalidation() {
    var propertytype = document.getElementById("property-type");
    var community = document.getElementById("community");
    var buildingname = document.getElementById("building-name");
    var floorno = document.getElementById("floor-no");
    var unitno = document.getElementById("unit-no");
// var streetno = document.getElementById("street-no");
    var askingprice = document.getElementById("asking-price");
    var view = document.getElementById("view");
    var bedrooms = document.getElementById("bedrooms");
    var unitarea = document.getElementById("unit-area");
    var description = document.getElementById("description");
    var title = document.getElementById("title");
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
//var country = document.getElementById("country");
    var mobphone = document.getElementById("mob-phone");
    var mobphone1 = document.getElementById("mob-phone-1");
    var mobphone2 = document.getElementById("mob-phone-2");
    var mobphone3 = document.getElementById("mob-phone-3");
    var emailadd = document.getElementById("emailaddlist");
    var mustcheck = document.getElementById("mustcheck");
    var captcha = document.getElementById("captcha_code");
    var regEmail = /^([-a-zA-Z0-9._]+@[-a-zA-Z0-9.]+(\.[-a-zA-Z0-9]+)+)$/;


    var flag = true;

    if (propertytype.options[propertytype.selectedIndex].value == 0)
    {
        document.getElementById("property-type-error").style.display = "block";
        propertytype.focus();
        flag = false;
    } else
    {
        document.getElementById("property-type-error").style.display = "none";
    }
    if (community.options[community.selectedIndex].value == 0)
    {
        document.getElementById("community-error").style.display = "block";
        community.focus();
        flag = false;
    } else
    {
        document.getElementById("community-error").style.display = "none";
    }

    if (buildingname.value == "")
    {
        document.getElementById("building-name-error").style.display = "block";
        buildingname.focus();
        flag = false;
    } else
    {
        document.getElementById("building-name-error").style.display = "none";
    }

    if (floorno.value == "")
    {
        document.getElementById("floor-no-error").style.display = "block";
        floorno.focus();
        flag = false;
    } else
    {
        document.getElementById("floor-no-error").style.display = "none";
    }

    if (unitno.value == "")
    {
        document.getElementById("unit-no-error").style.display = "block";
        unitno.focus();
        flag = false;
    } else
    {
        document.getElementById("unit-no-error").style.display = "none";
    }
    /*
     if(streetno.value == "")
     {
     document.getElementById("street-no-error").style.display = "block";
     streetno.focus();
     flag = false;
     }
     else
     {
     document.getElementById("street-no-error").style.display = "none";
     }
     */
    if (askingprice.value == "")
    {
        document.getElementById("asking-price-error").style.display = "block";
        askingprice.focus();
        flag = false;
    } else
    {
        document.getElementById("asking-price-error").style.display = "none";
    }

    if (view.value == "")
    {
        document.getElementById("view-error").style.display = "block";
        view.focus();
        flag = false;
    } else
    {
        document.getElementById("view-error").style.display = "none";
    }

    if (bedrooms.options[bedrooms.selectedIndex].value == 0)
    {
        document.getElementById("bedrooms-error").style.display = "block";
        bedrooms.focus();
        flag = false;
    } else
    {
        document.getElementById("bedrooms-error").style.display = "none";
    }

    if (unitarea.value == "")
    {
        document.getElementById("unit-area-error").style.display = "block";
        unitarea.focus();
        flag = false;
    } else
    {
        document.getElementById("unit-area-error").style.display = "none";
    }

    if (description.value == "")
    {
        document.getElementById("description-error").style.display = "block";
        description.focus();
        flag = false;
    } else
    {
        document.getElementById("description-error").style.display = "none";
    }

    if (title.options[title.selectedIndex].value == "0")
    {
        document.getElementById("title-error").style.display = "block";
        title.focus();
        flag = false;
    } else
    {
        document.getElementById("title-error").style.display = "none";
    }

    if (fname.value == "")
    {
        document.getElementById("fname-error").style.display = "block";
        fname.focus();
        flag = false;
    } else
    {
        document.getElementById("fname-error").style.display = "none";
    }

    if (lname.value == "")
    {
        document.getElementById("lname-error").style.display = "block";
        lname.focus();
        flag = false;
    } else
    {
        document.getElementById("lname-error").style.display = "none";
    }
    /*
     if(country.options[country.selectedIndex].value == "0")
     {
     document.getElementById("country-error").style.display = "block";
     country.focus();
     flag = false;
     }
     else
     {
     document.getElementById("country-error").style.display = "none";
     }	
     */

    if (mobphone.options[mobphone.selectedIndex].value == "0")
    {
        document.getElementById("mob-phone-error").style.display = "block";
        document.getElementById("mob-phone-error").innerHTML = "Select Contact Type";
        mobphone.focus();
        flag = false;
    } else if (mobphone1.value == "")
    {
        document.getElementById("mob-phone-error").style.display = "block";
        document.getElementById("mob-phone-error").innerHTML = "Insert Contact Number";
        mobphone1.focus();
        flag = false;
    } else if (mobphone2.value == "")
    {
        document.getElementById("mob-phone-error").style.display = "block";
        document.getElementById("mob-phone-error").innerHTML = "Insert Contact Number";
        mobphone2.focus();
        flag = false;
    } else if (mobphone3.value == "")
    {
        document.getElementById("mob-phone-error").style.display = "block";
        document.getElementById("mob-phone-error").innerHTML = "Insert Contact Number";
        mobphone3.focus();
        flag = false;
    } else
    {
        document.getElementById("mob-phone-error").style.display = "none";
    }

    if (emailadd.value == "")
    {
        document.getElementById("emailadd-error").style.display = "block";
        emailadd.focus();
        flag = false;
    } else if (!regEmail.test(emailadd.value))
    {
        document.getElementById("emailadd-error").innerHTML = "Provide proper email address";
        document.getElementById("emailadd-error").style.display = "block";
        emailadd.focus();
        flag = false;
    } else
    {
        document.getElementById("emailadd-error").style.display = "none";
    }

    if (!mustcheck.checked)
    {
        document.getElementById("mustcheck-error").style.display = "block";
        mustcheck.focus();
        flag = false;
    } else
    {
        document.getElementById("mustcheck-error").style.display = "none";
    }

    if (captcha.value == "")
    {
        document.getElementById("captcha-error").style.display = "block";
        captcha.focus();
        flag = false;
    } else if (flag != false && captcha.value != "") // Only check if we have all validations clear
    {
        var dataString = 'captcha_code=' + captcha.value;
        document.getElementById("captcha-error").innerHTML = "Checking Captcha....";
        document.getElementById("captcha-error").style.display = "block";

        $.ajax({
            type: "POST",
            url: "/secureimage/checkcap.php",
            data: dataString,
            timeout: 3000,
            async: false,
            cache: false,
            success: function (data)
            {
                if (data == 'true')
                {
                    document.getElementById("captcha-error").style.display = "none";
                    flag = true;
                } else
                {
                    flag = false;
                    document.getElementById("captcha-error").innerHTML = "Enter Valid Captcha";
                    document.getElementById("captcha-error").style.display = "block";
                    $('#captcha').click();
                    captcha.focus();
                }
            },
            error: function (errordata)
            {
                flag = false;
                document.getElementById("captcha-error").innerHTML = "Error Checking Captcha. Try again";
                document.getElementById("captcha-error").style.display = "block";
                captcha.focus();
            }
        });
    }

    return flag;
}