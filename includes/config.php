<?php
	define("APP_NAME", "Smarturl");
	define("WEBSITE_URL", "smarturl.gq");
	define("DB_SERVER", "localhost");
	define("DB_NAME", "smarturl_db");
	define("DB_USER", "smarturl_db");
	define("DB_PASS", "password");
	
	if(session_id() == '') {
		session_start();
	}

	$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	
	if(mysqli_connect_errno()) {
	die("Database connection failed: " . 
		 mysqli_connect_error() . 
		 " (" . mysqli_connect_errno() . ")"
	);
	}
function execute_query($query){
	global $connection;
	return mysqli_query($connection,$query);
}
function execute_insert_query($query){
	global $connection;
	mysqli_query($connection,$query);
	return mysqli_insert_id($connection);
}

function mysql_prep($string) {
	global $connection;
	$escaped_string = mysqli_real_escape_string($connection, $string);
	return $escaped_string;
}	
function confirm_query($result_set) {
	if (!$result_set) {
		die("Database query failed.");
	}
}
function get_sql_india_time(){
	return " DATE_ADD(UTC_TIMESTAMP(), INTERVAL 330 MINUTE) ";
}
function get_php_india_time(){
	return (strtotime(gmdate("M d Y H:i:s",  time()))+19800);
}
function toChars($number) {
   $res = base_convert($number, 10,36);
   return $res;
}
function toNum($number) {
   $res = base_convert($number, 36,10);
   return $res;
}
function redirect_to($url){
header('Location: '.$url);
}
?>
