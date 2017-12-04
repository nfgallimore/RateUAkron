<?php
define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'wecandowhatever');
define('DB_NAME', 'myproject');
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

include 'ChromePhp.php';
ChromePhp::log('This is just a log message');
ChromePhp::warn("This is a warning message " ) ;
ChromePhp::error("This is an error message" ) ;
ChromePhp::log($_SERVER);
 
foreach ($_SERVER as $key => $value) {
    ChromePhp::log($key, $value);
}

?>

