<?php
session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
    exit;
}

require_once 'includes/config.php';

$sql = 'SELECT CourseID, Title FROM Evaluations INNER JOIN Courses ON Evaluations.CourseID = Courses.Cid WHERE Evaluations.UserID = ' . $_SESSION["userid"] . ';';

$evals = [];

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_array($result)){
		    $evals[] = [
		        'CourseID' => $row['CourseID'],
		        'Title' => $row['Title']
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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<title>Evaluations for <?php echo $title ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

</head>
<body>
	<div class="page-header">
		<h1>Hi, <b><?php echo $_SESSION['username']; ?></b>.<br>Welcome to your recommended courses.</h1>
		<p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
	</div>
	<div class="nav-bar">
		<a href="welcome.php" class="btn btn-info">Home</a>
	</div><br><br>
	<div class="container">
		<table class="course-table" data-toggle="table" data-sort-name="stargazers_count" data-sort-order="desc" class="table text-align:left table-hover table-bordered results">
			<thead>
				<tr>
					<th data-field="cid" data-sortable="true" class="col-md-2 col-xs-2">Course ID</th>
					<th data-field="title" data-sortable="true" class="col-md-2 col-xs-2">Course Name</th>
				</tr>
				<tr class="warning no-result">
					<td colspan="4"><i class="fa fa-warning"></i>No result</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($evals as $eval): ?>
					<tr>
						<td><a href="geteval.php/q?id=<?= $eval["CourseID"]?>"><?= $eval["CourseID"]?></a></td>
						<td><a href="geteval.php/q?id= <?= $eval["CourseID"]?>"><?= $eval["Title"]?></a></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</body>
