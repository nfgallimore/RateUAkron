<?php 
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
	header("location: login.php");
	exit;
}

require_once 'includes/config.php';

$sql = "DELETE FROM Courses";

mysqli_query($link, $sql);
mysqli_close($link);

?>
<!DOCTYPE html>
<head>
</head>
<body>
	<h1>That was a bad idea.</h1>
	<img src="https://www.askideas.com/media/37/Funny-Laughing-Gif-Dr.-Evil-Image.gif">
</body>
</html>