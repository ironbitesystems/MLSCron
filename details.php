<?php
require_once('includes/config.php');

$photos = $rets->GetObject('Property', 'Photo', $_REQUEST['id'], '*');

foreach ($photos as $key => $void)
{
	
	$id = trim($photos[$key]['Content-ID']);
	$number = trim($photos[$key]['Object-ID']);
	
	if ($photos[$key]['Success'] == true)
		echo '<img src="/get-image.php?id='.$id.'&num='.$number.'" height="120" border="0" />'."<br>\n";
	else
		echo '<img src="http://url.com/images/noListingImageSmall.gif" height="120" />'."<br>\n";# get blank standard image

}

$rets->Disconnect();

?>

