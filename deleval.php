<?php
session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
    exit;
}

require_once 'includes/config.php';
$id = $_GET['id'];
$sql = "DELETE FROM Evaluations WHERE Id = " . $id . ";";

mysqli_query($link, $sql);

mysqli_close($link);
header("location: ../welcome.php");
exit;

?>