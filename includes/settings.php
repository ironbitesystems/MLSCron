<?php

# grab database argument to figure out which database to use
$database = (isset($_GET['db'])) ? $_GET['db'] : $_SERVER['argv'][1];

if ($database != '' || $database !== false)
{
	
	define('DB_CONNECT', true);
	
	# select which database to use based on argument passed from above
	switch($database)
	{
			
		case 'database1':
			# Set database connection variables
			define('DB_SERVER', 'localhost');
			define('DB_USER', 'database_user');
			define('DB_PASS', 'password');
			define('DB_DATABASE', 'database_name');
			define('DB_TBLPRE', 'tbl_');
			define('LISTINGS', 'listings_resi');
			define('UPDATE_LISTING', false);
			break;
		
		default:
			# Set database connection variables
			define('DB_SERVER', 'localhost');
			define('DB_USER', 'database_user');
			define('DB_PASS', 'password');
			define('DB_DATABASE', 'database_name');
			define('DB_TBLPRE', 'tbl_');
			define('LISTINGS', 'listings_resi');
			define('UPDATE_LISTING', true);
			break;
	
	}

}
else
	define('DB_CONNECT', false);

# Set RETS connection variables
define('RETS_LOGIN_URL', 'http://mls.loginurl.com/login');
define('RETS_USER', 'username');
define('RETS_PASS', 'password');

# Set data variables
define('RETS_DATA', '/path/to/csv/property_data.csv');
define('RETS_IMG', '/path/to/mls/listing/images/');
define('RETS_YEAR', date('Y',strtotime('-2 years')));

?>