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

echo "+ Saving data to csv file<br>\n";
$rets->SaveData(); # Save data to csv file

echo "+ Disconnecting<br>\n";
$rets->Disconnect(); # Disconnect from RETS server

?>



