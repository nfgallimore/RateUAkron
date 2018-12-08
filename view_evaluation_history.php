<?php
require_once 'includes/config.php';

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  	header("location: login.php");
    exit;
}
else
	$logged_in = true;

$sql = 'SELECT Courses.Title as Title, Evaluations.Id as Eid, Recommended, TimeSpent, Reason, Grade, GPA, Comment FROM Evaluations INNER JOIN Courses ON Evaluations.CourseID = Courses.Cid WHERE UserID = ' . $_SESSION["userid"] . ' ORDER BY Created_At DESC;';

$evals = [];

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_array($result)){
		    $evals[] = [
		        'Title' => $row['Title'],
		        'Recommended' => $row['Recommended'],
		        'TimeSpent' => $row['TimeSpent'],
		        'Reason' => $row['Reason'],
		        'Grade' => $row['Grade'],
		        'GPA' => $row['GPA'],
		        'Comment' => $row['Comment'],
		        'Eid' => $row['Eid']
		    ];
		}
		mysqli_free_result($result);
	}
}
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Evaluations for <?php echo $title ?></title>
	<?php include("includes/header_includes.php") ?>

</head>
<body>
	<div class="page-header">
		<h1><span> Welcome </span> to your course evaluation history!</h1>
	</div>

	<?php include("includes/nav_bar.php") ?>

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
