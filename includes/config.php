<?php

session_start();

define('DB_SERVER', '52.91.5.119');
define('DB_USERNAME', 'db_user');
define('DB_PASSWORD', 'universityofakron2019');
define('DB_NAME', 'rateuakron');
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

include 'ChromePhp.php';
// ChromePhp::log('This is just a log message');
// ChromePhp::warn("This is a warning message " ) ;
// ChromePhp::error("This is an error message" ) ;
ChromePhp::log($_SERVER);
 
foreach ($_SERVER as $key => $value) {
    ChromePhp::log($key, $value);
}

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
	$logged_in = false;
}
else {
	$logged_in = true;
	$username = $_SESSION['username'];
	$user_id = $_SESSION['userid'];
}


require_once 'Mobile_Detect.php'


// For using Mobile_Detect:

// $detect = new Mobile_Detect();
// $mobile = false;
// if ($detect->isMobile()) {
// 	$mobile = true;
// }


?>
