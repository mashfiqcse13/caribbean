<?php

/*
 * Database configuration
 */

if ($_SERVER['HTTP_HOST'] == 'gill.mashfiqnahid.com') {
    define('db_username', 'thejamun_gill');
    define('db_passward', 'I5Qsid,b&2Sr');
    define('db_name', 'thejamun_mashfiq_gill');
    define('db_host', 'localhost');
} else if ($_SERVER['HTTP_HOST'] == 'mashfiq.caribbeancirclestars.com') {
    define('db_username', 'caribbea_new');
    define('db_passward', 'c@r!663@9');
    define('db_name', 'caribbea_new');
    define('db_host', 'localhost');
} else if ($_SERVER['HTTP_HOST'] == 'caribbeancirclestars.com' || $_SERVER['HTTP_HOST'] == 'www.caribbeancirclestars.com') {
    define('db_username', 'caribbea_new');
    define('db_passward', 'c@r!663@9');
    define('db_name', 'caribbea_new');
    define('db_host', 'localhost');
} else {
    define('db_username', 'root');
    define('db_passward', '');
    define('db_name', 'caribbea_carabiancirclestar');
    define('db_host', 'localhost');
}

// site configuration

if ($_SERVER['HTTP_HOST'] == 'gill.mashfiqnahid.com') {
    $BASE_URL = 'http://gill.mashfiqnahid.com/';
} else if ($_SERVER['HTTP_HOST'] == 'mashfiq.caribbeancirclestars.com') {
    $BASE_URL = 'http://mashfiq.caribbeancirclestars.com/';
} else if ($_SERVER['HTTP_HOST'] == 'caribbeancirclestars.com' || $_SERVER['HTTP_HOST'] == 'www.caribbeancirclestars.com') {
    $BASE_URL = 'http://caribbeancirclestars.com/';
} else {
    $BASE_URL = 'http://localhost/caribiean/';
}

define('BASE_URL', $BASE_URL);
