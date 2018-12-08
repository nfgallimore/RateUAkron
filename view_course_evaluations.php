<?php
require_once 'includes/config.php';

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

$sum = 0;
$count = 0;
$avg = 0;

foreach ($evals as $eval) {
    $sum += $eval["Recommended"];
    $count++;
}
if ($count > 0) {
	$avg = $sum / $count;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title><?php echo $courseTitle ?></title>
	<?php include("includes/header_includes.php"); ?>

</head>
<body>

	<div class="page-header">
		<h2>
			<?php if(!empty($evals[0]['Instructor'])): ?>
				<?php echo $evals[0]['Instructor'] . "'s <i>" . $courseTitle . "</i><br /><span>" . $avg . "</span> average rating.<br />" ?>
			<?php else: ?>
				<?php echo "<i>" . $courseTitle . "</i><br /><span>" . $avg . "</span> average rating.<br />" ?>
			<?php endif; ?>
		</h2>
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
	
	<?php include("includes/footer.php"); ?>

</body>
</html>
