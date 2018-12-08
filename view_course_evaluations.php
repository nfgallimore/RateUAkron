<?php
require_once 'includes/config.php';

$logged_in = true;

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
	$logged_in = false;
}

$cid = htmlspecialchars($_GET['id']);
$courseTitle = htmlspecialchars($_GET['title']);

$sql = 'SELECT Title, Instructor, Description, CourseID, UserId, Comment, Recommended, TimeSpent, Reason, Grade, GPA, Created_At, Evaluations.Id as Eid FROM Evaluations INNER JOIN Courses ON Evaluations.CourseID = Courses.Cid WHERE CourseID = ' . $cid;
$evals = [];

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_array($result)){
		    $evals[] = [
		        'Eid' => $row['Eid'],
		        'CourseId' => $row['CourseID'],
		        'Recommended' => $row['Recommended'],
		        'TimeSpent' => $row['TimeSpent'],
		        'Reason' => $row['Reason'],
		        'Grade' => $row['Grade'],
		        'GPA' => $row['GPA'],
		        'Created_At' => $row['Created_At'],
		        'Title' => $row['Title'],
		        'Instructor' => $row['Instructor'],
		        'Description' => $row['Description'],
				'UserId' => $row['UserId'],
				'Eds' => $row['Eid'],
				'Comment' => $row['Comment']
		    ];
		}
		mysqli_free_result($result);
	}
}

if ($logged_in) {
	$user_id = $_SESSION['userid'];
}

// $RecommendedSum = 0;
// $RecommendedCount = 0;
// $RecommendedAvg = 0;
// $title = "";

// foreach ($evals as $eval) {
//     $RecommendedSum += $eval["Recommended"];
//     $RecommendedCount++;
//     $title = $eval["Title"];
// }
// if ($RecommendedCount > 0) {
// 	$RecommendedAvg = $RecommendedSum / $RecommendedCount;
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<title><?php echo $courseTitle ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

	<!-- Favicons -->
	<link rel="icon"  type="image/png"  href="favicons/favicon.png" />
	<link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
	<link rel="icon" type="image/png" sizes="192x192" href="favicons/android-chrome-192x192.png">
	<link rel="manifest" href="favicons/site.webmanifest">
	<link rel="mask-icon" href="favicons/safari-pinned-tab.svg" color="#0a1f41">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">
	<!-- Favicons -->

</head>
<body>
<body>
	<div class="page-header">
		<h1>
			<?php echo $courseTitle?>
		</h1>
	</div>

	<?php include("includes/nav_bar.php"); ?>
	
	<?php foreach ($evals as $eval): ?>
		<table class="table text-align:left table-hover table-bordered results">
			<thead>
				<tr><th>Rating: <?= intval($eval["Recommended"])?> / 5</th></tr>
			</thead>
			<tbody>
				<tr><td>Time spent per week: <?= $eval["TimeSpent"]?></td></tr>
				<tr><td>Grade Recieved: <?= $eval["Grade"]?></td></tr>
				<tr><td>GPA: <?= $eval["GPA"]?></td></tr>
				<tr><td><span><?= $eval["Comment"]?></span></td></tr>
					<?php if($eval["UserId"] == $user_id) : ?>
						<tr><td><a href="delete_evaluation.php?id=<?php echo $eval['Eds']?>" class="btn btn-danger">Delete</a></td></tr>
					<?php endif; ?>
				</tr>
			</tbody>
		</table>
	<?php endforeach ?>

</body>
</html>
