<?php session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
    exit;
}

require_once '../includes/config.php';
$id = $_GET['id'];

$sql = 'SELECT * FROM Courses WHERE Cid = \' . $id . \'';
$evals = [];
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_array($result)){
		    $evals[] = [
		        'Id' => $row['Id']
		    ];
			echo $row['Id'];
			echo $row['CourseID'];
		}
		mysqli_free_result($result);
	}
	else {
		echo "No records matching your query were found.";
	}
} 
else {
	echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
mysqli_close($link);
echo $evals['Id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>