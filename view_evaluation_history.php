<?php
session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
    exit;
}

require_once 'includes/config.php';

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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<title>Evaluations for <?php echo $title ?></title>
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
	<div class="page-header">
		<h1>Hi, <b><?php echo $_SESSION['username']; ?></b>.<br> <span> Welcome </span> to your course evaluation history!</h1>
	</div>
	<div class="nav-bar">
		<a href="index.php" class="btn btn-info">Home</a>
		<a href="view_evaluation_history.php" class="btn btn-info">View Evaluation History</a>
		<a href="help.php" class="btn btn-info">Help</a>
		<a href="logout.php" class="btn btn-danger">Sign Out</a>
	</div>
	<table data-toggle="table" data-sort-name="stargazers_count" data-sort-order="desc" class="table text-align:left table-hover table-bordered results">
		<thead>
			<tr>
				<th data-field="name" data-sortable="true" class="col-md-2 col-xs-2"> Course Name </th>
				<th data-field="instructor" data-sortable="true" class="col-md-2 col-xs-2"> Recommend </th>
				<th data-field="description" data-sortable="true" class="col-md-2 col-xs-2"> Time Spent </th>
				<th data-field="evaluations" data-sortable="true" class="col-md-2 col-xs-2"> Grade </th>
				<th data-field="reason" data-sortable="true" class ="col-md-2 col-xs-2"> Reason </th>
				<th data-field="gpa" data-sortable="true" class ="col-md-2 col-xs-2"> GPA </th>
				<th data-field="comment" data-sortable="true" class ="col-md-2 col-xs-2"> Comment </th>
				<th data-field="delete" data-sortable="false" class ="col-md-2 col-xs-2"> Delete </th>
			</tr>
			<tr class="warning no-result">
				<td colspan="4"><i class="fa fa-warning"></i> No result</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($evals as $eval): ?>
			<tr>
				<td><?= $eval["Title"]?></td>
				<td><?= $eval["Recommended"]?></td>
				<td><?= $eval["TimeSpent"]?></td>
				<td><?= $eval["Reason"]?></td>
				<td><?= $eval["Grade"]?></td>
				<td><?= $eval["GPA"]?></td>
				<td><?= $eval["Comment"]?></td>
				<td><a href="delete_evaluation.php/q?id=<?php echo $eval['Eid']?>" class="btn btn-danger">Delete</a></td>
			</tr>
			<?php endforeach ?>
		</tbody
</body>
