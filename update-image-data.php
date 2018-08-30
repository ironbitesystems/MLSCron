<?php
include('includes/config.php');

echo "+ Connecting to ".DB_SERVER." as ".DB_USER.".<br>\n";
$db->connect(); # connect to the database

$rets->updatePropertiesPhoto(); # check folders for rogue images

echo "+ Closing database connection.<br>\n";
$db->close(); # close database connection
?>