<?php

echo date('Y-m-d h:i:s');
echo "<br />";
date_default_timezone_set('America/New_York');

$script_tz = date_default_timezone_get();

if (strcmp($script_tz, ini_get('date.timezone'))) {
    echo 'Script timezone differs from ini-set timezone.';
} else {
    echo 'Script timezone and ini-set timezone match.';
    echo "<br />";
}

echo date('Y-m-d h:i:s');
?>