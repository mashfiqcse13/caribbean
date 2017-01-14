
<?php

//date_default_timezone_set('Asia/Kolkata');
date_default_timezone_set('America/New_York');
//date_default_timezone_set('America/Los_Angeles');
//date_default_timezone_set("America/Nassau");
//date_default_timezone_set("America/Anchorage");


session_start();
//require('contact.php'); 
require_once 'common_config.php';
require("db.inc.php");
require_once('class.database.php');
require_once('classes/User.php');
require("ps_pagination.php");
require("sol_functions.php");
require("custom_functions.php");
require_once('common_functions.php');
//require("custom_function_username.php");
if ((isset($_SESSION['cms_login'])) && ($_SESSION['cms_login'] != 0)) {
    
} else {
    Onlineactivity();
}

define('SITE_NAME', 'CCS');

define('SITE_URL', $BASE_URL);

define('FROM_EMAIL', 'donotreply@caribbeancirclestars.com');
define('TO_ADMIN', 'mashfiqnahid@gmail.com');
//define('TO_ADMIN', 'caribbea@caribbeancirclestars.com');


define('MEMBER_IMAGE_SIZE', 150);
define('PROFILE_PHOTO_BIG', 600);
define('PROFILE_PHOTO_MEDIUM', 300);
define('PROFILE_PHOTO_THUMB', 150, 150);
define('PROFILE_PHOTO_THUMB1', 150);
define('THUMB_SIZE', 166);



/* define('PAYPAL_ID','surajit@solutiononline.co.in');
  define('PAYPAL_REDIRECT_URL','https://www.sandbox.paypal.com/webscr&cmd=');
  define('DEVELOPER_PORTAL','https://developer.paypal.com'); */
define('ADMIN_PAYPAL_ID', 'webmas_1343822910_biz@solutiononline.co.in');
define('CURRENCY_CODE', 'USD');
define('DEVICE_ID', 'CCS');
define('APPLICATION_ID', 'APP-80W284485P519543T');

//define('PROFILE_PHOTO_THUMB_WIDTH', 150);
//define('PROFILE_PHOTO_THUMB_HEIGHT', 150);

$countries_array = array();
$countries_array[''] = "-- Select Country--";
$countries_array[1] = "Afghanistan";
$countries_array[2] = "Albania";
$countries_array[3] = "Algeria";
$countries_array[4] = "American Samoa";
$countries_array[5] = "Andorra";
$countries_array[6] = "Angola";
$countries_array[7] = "Anguilla";
$countries_array[8] = "Antarctica";
$countries_array[9] = "Antigua and Barbuda";
$countries_array[10] = "Argentina";
$countries_array[11] = "Armenia";
$countries_array[12] = "Aruba";
$countries_array[13] = "Australia";
$countries_array[14] = "Austria";
$countries_array[15] = "Azerbaidjan";
$countries_array[16] = "Bahamas";
$countries_array[17] = "Bahrain";
$countries_array[18] = "Bangladesh";
$countries_array[19] = "Barbados";
$countries_array[20] = "Belarus";
$countries_array[21] = "Belgium";
$countries_array[22] = "Belize";
$countries_array[23] = "Benin";
$countries_array[24] = "Bermuda";
$countries_array[25] = "Bhutan";
$countries_array[26] = "Bolivia";
$countries_array[27] = "Bosnia-Herzegovina";
$countries_array[28] = "Botswana";
$countries_array[29] = "Bouvet Island";
$countries_array[30] = "Brazil";
$countries_array[31] = "British Indian Ocean Territory";
$countries_array[32] = "Brunei Darussalam";
$countries_array[33] = "Bulgaria";
$countries_array[34] = "Burkina Faso";
$countries_array[35] = "Burundi";
$countries_array[36] = "Cambodia";
$countries_array[37] = "Cameroon";
$countries_array[38] = "Canada";
$countries_array[39] = "Cape Verde";
$countries_array[40] = "Cayman Islands";
$countries_array[41] = "Central African Republic";
$countries_array[42] = "Chad";
$countries_array[43] = "Chile";
$countries_array[44] = "China";
$countries_array[45] = "Christmas Island";
$countries_array[46] = "Cocos (Keeling) Islands";
$countries_array[47] = "Colombia";
$countries_array[48] = "Comoros";
$countries_array[49] = "Congo";
$countries_array[50] = "Cook Islands";
$countries_array[51] = "Costa Rica";
$countries_array[52] = "Croatia";
$countries_array[53] = "Cuba";
$countries_array[54] = "Cyprus";
$countries_array[55] = "Czech Republic";
$countries_array[56] = "Denmark";
$countries_array[57] = "Djibouti";
$countries_array[58] = "Dominica";
$countries_array[59] = "Dominican Republic";
$countries_array[60] = "East Timor";
$countries_array[61] = "Ecuador";
$countries_array[62] = "Egypt";
$countries_array[63] = "El Salvador";
$countries_array[64] = "Equatorial Guinea";
$countries_array[65] = "Eritrea";
$countries_array[66] = "Estonia";
$countries_array[67] = "Ethiopia";
$countries_array[68] = "Falkland Islands";
$countries_array[69] = "Faroe Islands";
$countries_array[70] = "Fiji";
$countries_array[71] = "Finland";
$countries_array[72] = "Former USSR";
$countries_array[73] = "France";
$countries_array[74] = "France (European Territory)";
$countries_array[75] = "French Guyana";
$countries_array[76] = "French Southern Territories";
$countries_array[77] = "Gabon";
$countries_array[78] = "Gambia";
$countries_array[79] = "Georgia";
$countries_array[80] = "Germany";
$countries_array[81] = "Ghana";
$countries_array[82] = "Gibraltar";
$countries_array[83] = "Greece";
$countries_array[84] = "Greenland";
$countries_array[85] = "Grenada";
$countries_array[86] = "Guadeloupe (French)";
$countries_array[87] = "Guam";
$countries_array[88] = "Guatemala";
$countries_array[89] = "Guinea";
$countries_array[90] = "Guinea Bissau";
$countries_array[91] = "Guyana";
$countries_array[92] = "Haiti";
$countries_array[93] = "Heard and McDonald Islands";
$countries_array[94] = "Honduras";
$countries_array[95] = "Hong Kong";
$countries_array[96] = "Hungary";
$countries_array[97] = "Iceland";
$countries_array[98] = "India";
$countries_array[99] = "Indonesia";
$countries_array[100] = "Iran";
$countries_array[101] = "Iraq";
$countries_array[102] = "Ireland";
$countries_array[103] = "Israel";
$countries_array[104] = "Italy";
$countries_array[105] = "Ivory Coast";
$countries_array[106] = "Jamaica";
$countries_array[107] = "Japan";
$countries_array[108] = "Jordan";
$countries_array[109] = "Kazakhstan";
$countries_array[110] = "Kenya";
$countries_array[111] = "Kiribati";
$countries_array[112] = "Kuwait";
$countries_array[113] = "Kyrgyzstan";
$countries_array[114] = "Laos";
$countries_array[115] = "Latvia";
$countries_array[116] = "Lebanon";
$countries_array[117] = "Lesotho";
$countries_array[118] = "Liberia";
$countries_array[119] = "Libya";
$countries_array[120] = "Liechtenstein";
$countries_array[121] = "Lithuania";
$countries_array[122] = "Luxembourg";
$countries_array[123] = "Macau";
$countries_array[124] = "Macedonia";
$countries_array[125] = "Madagascar";
$countries_array[126] = "Malawi";
$countries_array[127] = "Malaysia";
$countries_array[128] = "Maldives";
$countries_array[129] = "Mali";
$countries_array[130] = "Malta";
$countries_array[131] = "Marshall Islands";
$countries_array[132] = "Martinique (French)";
$countries_array[133] = "Mauritania";
$countries_array[134] = "Mauritius";
$countries_array[135] = "Mayotte";
$countries_array[136] = "Mexico";
$countries_array[137] = "Micronesia";
$countries_array[138] = "Moldavia";
$countries_array[139] = "Monaco";
$countries_array[140] = "Mongolia";
$countries_array[141] = "Montserrat";
$countries_array[142] = "Morocco";
$countries_array[143] = "Mozambique";
$countries_array[144] = "Myanmar, Union of (Burma)";
$countries_array[145] = "Namibia";
$countries_array[146] = "Nauru";
$countries_array[147] = "Nepal";
$countries_array[148] = "Netherlands";
$countries_array[149] = "Netherlands Antilles";
$countries_array[150] = "Neutral Zone";
$countries_array[151] = "New Caledonia (French)";
$countries_array[152] = "New Zealand";
$countries_array[153] = "Nicaragua";
$countries_array[154] = "Niger";
$countries_array[155] = "Nigeria";
$countries_array[156] = "Niue";
$countries_array[157] = "Norfolk Island";
$countries_array[158] = "North Korea";
$countries_array[159] = "Northern Mariana Islands";
$countries_array[160] = "Norway";
$countries_array[161] = "Oman";
$countries_array[162] = "Pakistan";
$countries_array[163] = "Palau";
$countries_array[164] = "Panama";
$countries_array[165] = "Papua New Guinea";
$countries_array[166] = "Paraguay";
$countries_array[167] = "Peru";
$countries_array[168] = "Philippines";
$countries_array[169] = "Pitcairn Island";
$countries_array[170] = "Poland";
$countries_array[171] = "Polynesia (French)";
$countries_array[172] = "Portugal";
$countries_array[173] = "Qatar";
$countries_array[174] = "Reunion (French)";
$countries_array[175] = "Romania";
$countries_array[176] = "Russian Federation";
$countries_array[177] = "Rwanda";
$countries_array[178] = "S. Georgia & S. Sandwich Islands";
$countries_array[179] = "Saint Helena";
$countries_array[180] = "Saint Kitts & Nevis Anguilla";
$countries_array[181] = "Saint Lucia";
$countries_array[182] = "Saint Pierre and Miquelon";
$countries_array[183] = "Saint Tome and Principe";
$countries_array[184] = "Saint Vincent & Grenadines";
$countries_array[185] = "Samoa";
$countries_array[186] = "San Marino";
$countries_array[187] = "Saudi Arabia";
$countries_array[188] = "Senegal";
$countries_array[189] = "Seychelles";
$countries_array[190] = "Sierra Leone";
$countries_array[191] = "Singapore";
$countries_array[192] = "Slovakia";
$countries_array[193] = "Slovenia";
$countries_array[194] = "Solomon Islands";
$countries_array[195] = "Somalia";
$countries_array[196] = "South Africa";
$countries_array[197] = "South Korea";
$countries_array[198] = "Spain";
$countries_array[199] = "Sri Lanka";
$countries_array[200] = "Sudan";
$countries_array[201] = "Suriname";
$countries_array[202] = "Svalbard and Jan Mayen Islands";
$countries_array[203] = "Swaziland";
$countries_array[204] = "Sweden";
$countries_array[205] = "Switzerland";
$countries_array[206] = "Syria";
$countries_array[207] = "Tadjikistan";
$countries_array[208] = "Taiwan";
$countries_array[209] = "Tanzania";
$countries_array[210] = "Thailand";
$countries_array[211] = "Togo";
$countries_array[212] = "Tokelau";
$countries_array[213] = "Tonga";
$countries_array[214] = "Trinidad and Tobago";
$countries_array[215] = "Tunisia";
$countries_array[216] = "Turkey";
$countries_array[217] = "Turkmenistan";
$countries_array[218] = "Turks and Caicos Islands";
$countries_array[219] = "Tuvalu";
$countries_array[220] = "Uganda";
$countries_array[221] = "UK";
$countries_array[222] = "Ukraine";
$countries_array[223] = "United Arab Emirates";
$countries_array[224] = "Uruguay";
$countries_array[225] = "USA";
$countries_array[226] = "USA Minor Outlying Islands";
$countries_array[227] = "Uzbekistan";
$countries_array[228] = "Vanuatu";
$countries_array[229] = "Vatican City";
$countries_array[230] = "Venezuela";
$countries_array[231] = "Vietnam";
$countries_array[232] = "Virgin Islands (British)";
$countries_array[233] = "Virgin Islands (USA)";
$countries_array[234] = "Wallis and Futuna Islands";
$countries_array[235] = "Western Sahara";
$countries_array[236] = "Yemen";
$countries_array[237] = "Yugoslavia";
$countries_array[238] = "Zambia";
$countries_array[239] = "Zimbabwe";







$countries_array1 = array();
$countries_array1[''] = "-- Select Country--";
$countries_array1["1-268"] = "Antigua and Barbuda";
$countries_array1["2-264"] = "Anguilla";
$countries_array1["3-297"] = "Aruba";
$countries_array1["4-242"] = "Bahamas";
$countries_array1["5-246"] = "Barbados";
$countries_array1["6-501"] = "Belize";
$countries_array1["7-441"] = "Bermuda";
$countries_array1["8-284"] = "British Virgin Islands";
$countries_array1["9-345"] = "Cayman Islands";
$countries_array1["10-053"] = "Cuba";
$countries_array1["11-599"] = "Cura&ccedil;ao";
$countries_array1["12-767"] = "Dominica";
$countries_array1["13-809-829"] = "Dominican Republic";
$countries_array1["34-596"] = "French Antilles";
$countries_array1["14-473"] = "Grenada";
$countries_array1["15-784"] = "Grenadines";
$countries_array1["16-590"] = "Guadeloupe";
$countries_array1["17-592"] = "Guyana";
$countries_array1["18-509"] = "Haiti";
$countries_array1["19-876"] = "Jamaica";
$countries_array1["20-596"] = "Martinique";
$countries_array1["21-664"] = "Montserrat";
$countries_array1["22-599"] = "Netherlands";
$countries_array1["23-787-939"] = "Puerto Rico";
$countries_array1["24-590"] = "Saint Barth&eacute;lemy";
$countries_array1["25-869"] = "St. Kitts and Nevis";
$countries_array1["26-758"] = "Saint Lucia";
$countries_array1["27-599"] = "Saint Martin";
$countries_array1["28-721"] = "Sint Maarten";
$countries_array1["29-784"] = "Saint Vincent";
$countries_array1["30-597"] = "Suriname";
$countries_array1["31-868"] = "Trinidad and Tobago";
$countries_array1["32-649"] = "Turks and Caicos Islands";
$countries_array1["33-340"] = "United States Virgin Islands";


/* ##### ALL ACTIVITY HEAR ##### */

define('AC1', 'Added/Changed Profile Picture');
define('AC2', 'Added a new Photo');
define('AC3', 'Added a new Music');
define('AC4', 'Added a new Video');
define('AC5', 'Added a new Book');
define('AC6', 'Added a new Event');
define('AC7', 'got a new Fan/Friend');
define('AC8', 'Just become fan/friend?s of');
define('AC9', 'Posted Comment on');
define('AC10', 'Received comment from');
define('AC11', 'Posted a Forum Article');
define('AC12', 'Posted comment on');
define('AC13', 'Added a new Product');
define('AC14', 'has Joined CCS');

/* ##### ALL PAGENATION LINK HEAR ##### */
define('PAGE_ROW_NO', 5);
define('PAGE_LINK_NO', 50);

//Check if Admin login then dont use the user session value because values are dynamic.......
$user_id = Let_the_admin_see_the_user_dashboard();
if ($user_id) {
    $user_idd = "?id=" . $user_id;
    $user_idd1 = "&id=" . $user_id;
} else {
    $user_idd = '';
    $user_idd1 = '';
}
define('user_idd', $user_idd);
define('user_idd1', $user_idd1);
?>