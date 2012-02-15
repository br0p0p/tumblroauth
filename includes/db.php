<?php
	// define database credentials
	defined('DBHOSTNAME') ? null : define('DBHOSTNAME', 'localhost');
	defined('DBUSERNAME') ? null : define('DBUSERNAME', '');
	defined('DBPASSWORD') ? null : define('DBPASSWORD', '');
	defined('DBDATABASE') ? null : define('DBDATABASE', '');
	
	// Include ezSQL core
	require_once(SITE_ROOT.'/includes/classes/ez_sql/shared/ez_sql_core.php');
	require_once(SITE_ROOT.'/includes/classes/ez_sql/mysql/ez_sql_mysql.php');
	$db = new ezSQL_mysql(DBUSERNAME,DBPASSWORD,DBDATABASE,DBHOSTNAME);
	