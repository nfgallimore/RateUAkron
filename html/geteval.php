<?php session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
    exit;
}

require_once '../includes/config.php';
$cid = $_GET['id'];

$sql = 'SELECT Id, CourseId, UserId, Recommended, TimeSpent, Reason, Grade, GPA, Created_At FROM Evaluations WHERE CourseId =' . $cid;
$evals = [];

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_array($result)){
		    $evals[] = [
		        'Id' => $row['Id'],
		        'CourseId' => $row['CourseId'],
		        'Recommended' => $row['Recommended']
		    ];
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

$RecommendedSum = 0;
foreach ($evals as $eval) {
	$RecomendedSum += $eval["Recommended"];
}
$RecommendedAvg = $RecomendedSum / count($evals["Recommended"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?= $RecommendedAvg ?>
</body>