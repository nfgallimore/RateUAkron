<?php
require_once 'includes/config.php';

$loggedIn = true;

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
	$loggedIn = false;
}
else {
	$username = $_SESSION['username'];
}

if (!isset($_GET['page']) || empty($_GET['page'])) {
	$page = 1;
}
else {
	$page = htmlspecialchars($_GET['page']);
}

if (!isset($_GET['search']) || empty($_GET['search'])) {
	$search = "";
}
else {
	$search = htmlspecialchars($_GET['search']);
}


if (!isset($_GET['search']) || empty($_GET['search'])) {
	$sql = "SELECT Cid, Id, Title, Description, Instructor, Start_Time, End_Time FROM Courses LIMIT " . ($page - 1) * 25 . "," . (($page - 1) * 25 + 25);
}
else {
	$sql = "SELECT Cid, Id, Title, Description, Instructor, Start_Time, End_Time FROM Courses WHERE Title LIKE '%{$search}%' OR Description LIKE '%{$search}%' OR Course LIKE '%{$search}%' OR Department LIKE '%{$search}%' OR Instructor LIKE '%{$search}%' OR Id LIKE '%{$search}%' LIMIT " . ($page - 1) * 25 . "," . (($page - 1) * 25 + 25);
}

$courses = [];
if($result = mysqli_query($link, $sql)) {
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_array($result)) {
			$courses[] = [
				'Cid' => $row['Cid'],
				'Id' => $row['Id'],
				'Title' => $row['Title'],
				'Description' => $row['Description'],
				'Instructor' => $row['Instructor'],
				'Start_Time' => $row['Start_Time'],
				'End_Time' => $row['End_Time']
			];
		}
		mysqli_free_result($result);
	}
}
else {
	echo "ERROR: Could not execute $sql. ";
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<title>Course Evaluations</title>

	<!-- Favicons -->
	<link rel="icon" type="image/png" href="favicons/favicon.png" />
	<link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
	<link rel="icon" type="image/png" sizes="192x192" href="favicons/android-chrome-192x192.png">
	<link rel="manifest" href="favicons/site.webmanifest">
	<link rel="mask-icon" href="favicons/safari-pinned-tab.svg" color="#0a1f41">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">
	<!-- Favicons -->

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css" />
	<link rel="stylesheet" href="css/styles.css" />

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>
</head>
<body>
	<div class="page-header">
		<h1>
			<?php if($loggedIn) : ?>
				Hi, <b><?php echo $username; ?></b>.<br>
			<?php endif; ?>
			<span> Welcome </span> to the University of Akron Course Catalog
		</h1>
	</div>
	<div class="nav-bar">
		<a href="index.php" class="btn btn-info">Home</a>
		<a href="view_evaluation_history.php" class="btn btn-info">View Your Evaluation History</a>
		<a href="help.php" class="btn btn-info">Help</a>
		<a href="<?php echo ($loggedIn) ? 'logout.php' : 'login.php' ?>" class="btn btn-danger"><?php echo ($loggedIn) ? 'Sign Out' : 'Log in' ?></a>
	</div>
	<form class="search form-group" action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="GET">
		<input type="text" name="search" class="inline-block search-box form-control" placeholder="What you looking for?">
		<input type="submit" class="inline-block btn btn-info" value="Submit">
	</form>
	<span class="counter pull-right"></span>
		<table data-toggle="table" data-sort-name="stargazers_count" data-sort-order="desc" class="table text-align:left table-hover table-bordered results">
			<thead>
				<tr>
					<th data-field="id" data-sortable="true" class="col-md-2 col-xs-2"> Course ID </th>
					<th data-field="name" data-sortable="true" class="col-md-3 col-xs-3"> Name </th>
					<th data-field="instructor" data-sortable="true" class="col-md-2 col-xs-2"> Instructor </th>
					<th data-field="description" data-sortable="true" class="col-md-5 col-xs-5"> Description </th>
					<th data-field="start-time" data-sortable="true" class="col-md-5 col-xs-5"> Start Time </th>
					<th data-field="end-time" data-sortable="true" class="col-md-5 col-xs-5"> End Time </th>
					<th data-field="evaluations" data-sortable="false" class="col-md-2 col-xs-2"> Evaluate Course </th>
					<th data-field="viewevals" data-sortable="false" class ="col-md-2 col-xs-2"> View Evaluations </th>
				</tr>
				<tr class="warning no-result">
					<td colspan="4"><i class="fa fa-warning"></i> No result</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($courses as $course): ?>
				<tr>
					<td><?= $course["Id"]?></td>
					<td><?= $course["Title"]?></td>
					<td><?= $course["Instructor"]?></td>
					<td><?= $course["Description"]?></td>
					<td><?= $course["Start_Time"]?></td>
					<td><?= $course["End_Time"]?></td>
					<td><a href="evaluate_course.php?id=<?php echo $course['Cid'] . "&title=" . $course['Title']?>" class="btn btn-success">Evaluate</a></td>
					<td><a href="view_course_evaluations.php?id=<?php echo $course['Cid'] . "&title=" . $course['Title'] ?>" class="btn btn-success">View Evaluations</a></td>
				</tr>
				<?php endforeach ?>
			</tbody>
			<nav aria-label="Page navigation">
				<ul class="pagination">
					<li class="page-item">
						<a class="page-link" href="?page=<?php echo ($page - 1 == 0) ? $page : $page - 1?>&search=<?php echo $search ?>" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
							<span class="sr-only">Previous</span>
						</a>
					</li>
					<li class="page-item">
						<a class="page-link" href="?page=<?php echo $page?>&search=<?php echo $search ?>"><?php echo $page?></a>
					</li>
					<?php if(count($courses) >= 25) : ?>
						<li class="page-item">
							<a class="page-link" href="?page=<?php echo $page + 1?>&search=<?php echo $search ?>"><?php echo $page + 1?></a>
						</li>
						<li class="page-item">
							<a class="page-link" href="?page=<?php echo $page + 2?>&search=<?php echo $search ?>"><?php echo $page + 2?></a>
						</li>				
						<li class="page-item">
							<a class="page-link" href="?page=<?php echo $page + 1?>&search=<?php echo $search ?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
								<span class="sr-only">Next</span>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</nav>
		</table>
</body>
</html>
