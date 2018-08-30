<?php
include ('settings.php');
require_once('class/phrets.class.php');
require_once('class/database.class.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

# Create new Databause class
if (DB_CONNECT === true)
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE, DB_TBLPRE);
else
	echo "Couldn't establish database connection<br>\n";

# Create new RETS class
$rets = new phRETS;

# Connect to RETS Server
$connect = $rets->Connect(RETS_LOGIN_URL, RETS_USER, RETS_PASS);

# Set data file
$rets->dataFile	= RETS_DATA;
# Set images folder
$rets->photoDir = RETS_IMG;
# Set year to start pull
$rets->startYear = RETS_YEAR;
# Set year to start pull
$rets->property_classes = array("RESI");

?>