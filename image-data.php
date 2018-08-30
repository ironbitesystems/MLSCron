<?php
include('includes/config.php');

echo "+ Connecting to ".RETS_LOGIN_URL." as ".RETS_USER."<br>\n";

# Check connection
if ($connect)
	echo "+ Connected<br>\n";
else
{
	echo "+ Not connected:<br>\n";
	$rets->Error(); # Show error array
	exit;
}

echo "+ Connecting to ".DB_SERVER." as ".DB_USER.".<br>\n";
$db->connect(); # connect to the database

$rets->getPropertiesPhoto(); # get images for properties and save in database

echo "+ Closing database connection.<br>\n";
$db->close(); # close database connection


?>