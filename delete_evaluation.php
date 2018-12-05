<?php
require_once 'includes/config.php';

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
    exit;
}

$id = $_GET['id'];
$sql = "DELETE FROM Evaluations WHERE Id = " . $id . ";";

mysqli_query($link, $sql);

mysqli_close($link);
header("location: view_evaluation_history.php");
exit;

?>