<?php
session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
    exit;
}

require_once 'includes/config.php';
$courseId = $_GET['CourseID'];
$sql = "DELETE FROM Evaluations WHERE CourseId = " . $courseId . ";";

mysqli_query($link, $sql);

mysqli_close($link);
header("location: ../welcome.php");
exit;

?>