<?php

/*
 * Database configuration
 */

if ($_SERVER['HTTP_HOST'] == 'gill.mashfiqnahid.com') {
    $db_username = 'thejamun_gill';
    $db_passward = 'I5Qsid,b&2Sr';
    $db_name = 'thejamun_mashfiq_gill';
    $db_host = 'localhost';
} else if ($_SERVER['HTTP_HOST'] == 'mashfiq.caribbeancirclestars.com') {
    $db_username = 'caribbea_new';
    $db_passward = 'c@r!663@9';
    $db_name = 'caribbea_new';
    $db_host = 'localhost';
} else {
    $db_username = 'root';
    $db_passward = '';
    $db_name = 'caribbea_carabiancirclestar';
    $db_host = 'localhost';
}

// site configuration

if ($_SERVER['HTTP_HOST'] == 'gill.mashfiqnahid.com') {
    $BASE_URL = 'http://gill.mashfiqnahid.com/';
} else if ($_SERVER['HTTP_HOST'] == 'mashfiq.caribbeancirclestars.com') {
    $BASE_URL = 'http://mashfiq.caribbeancirclestars.com/';
} else {
    $BASE_URL = 'http://localhost/caribiean/';
}