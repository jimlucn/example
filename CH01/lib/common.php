<?php
define('IS_ENV_PRODUCTION', true);

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', IS_ENV_PRODUCTION);
ini_set('error_log', 'log/phperror.txt');

date_default_timezone_get('Asia/Shanghai');

if (get_magic_quotes_gpc()) {
	function _stripslashes_rcurs($variable, $top=true)
	{
		$clean_data=array();
		foreach ($variable as $key => $value) {
			$key = ($top) ? $key : stripcslashes($key);
			$clean_data[$key] = (is_array($value)) ? _stripslashes_rcurs($value, flase) : stripcslashes($value);
		}
		return $clean_data;
	}
	$_GET = _stripslashes_rcurs($_GET);
	$_POST = _stripslashes_rcurs($_POST);
}