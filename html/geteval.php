<?php session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
    exit;
}

require_once '../includes/config.php';
$cid = $_GET['id'];

$sql = 'SELECT Title, Instructor, Description, Courses.Id, CourseId, UserId, Recommended, TimeSpent, Reason, Grade, GPA, Created_At FROM Evaluations INNER JOIN Courses ON Evaluations.CourseID = Courses.Id WHERE CourseId =' . $cid;
$evals = [];

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_array($result)){
		    $evals[] = [
		        'Id' => $row['Id'],
		        'CourseId' => $row['CourseId'],
		        'Recommended' => $row['Recommended'],
		        'TimeSpent' => $row['TimeSpent'],
		        'Reason' => $row['Reason'],
		        'Grade' => $row['Grade'],
		        'GPA' => $row['GPA'],
		        'Created_At' => $row['CreatedAt'],
		        'Title' => $row['Title'],
		        'Instructor' => $row['Instructor'],
		        'Description' => $row['Description']
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<title>Evaluations for <?= $evals['Title']
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

</head>
<body>
<
<?= $array_sum($eval["Recommended"]) / count($eval["Recommended"]) ?>
</body>