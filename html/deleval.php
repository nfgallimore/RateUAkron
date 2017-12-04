<?php
session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
    exit;
}

require_once '../includes/config.php';
$did = $_GET['id'];

echo $did;

?>
