<?php
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','');
define('DB_SCHEMA','WROX_DATABASE');
define('DB_TBL_PREFIX','WROX_');

if (!$GLOBALS['DB'] = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)) {
	die('Error: Unable to connect to database server.');
}
if (!mysql_select_db(DB_SCHEMA, $GLOBALS['DB'])) {
	mysql_close($GLOBALS['DB']);
	die('Error: Unable to select database schema.');
}