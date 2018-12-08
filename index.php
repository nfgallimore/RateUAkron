<?php
require_once 'includes/config.php';

$logged_in = true;

if (!isset($_SESSION['username']) || empty($_SESSION['username']))
	$logged_in = false;
else
	$username = $_SESSION['username'];


// Get page number
if (!isset($_GET['page']) || empty($_GET['page']))
	$page = 1;
else
	$page = htmlspecialchars($_GET['page']);

// Get search parameters
if (!isset($_GET['search']) || empty($_GET['search'])) {
	$search = "";
	$sql = "SELECT Cid, Id, Title, Description, Instructor, Start_Time, End_Time, Location, Start_Date, End_Date, Credit, Term, Campus FROM Courses LIMIT " . ($page - 1) * 25 . "," . (($page - 1) * 25 + 25);
}
else {
	$search = htmlspecialchars($_GET['search']);
	$sql = "SELECT Cid, Id, Title, Description, Instructor, Start_Time, End_Time, Location, Start_Date, End_Date, Credit, Term, Campus FROM Courses WHERE Title LIKE '%{$search}%' OR Description LIKE '%{$search}%' OR Course LIKE '%{$search}%' OR Department LIKE '%{$search}%' OR Instructor LIKE '%{$search}%' OR Id LIKE '%{$search}%' LIMIT " . ($page - 1) * 25 . "," . (($page - 1) * 25 + 25);
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
				'End_Time' => $row['End_Time'],
				'Location' => $row['Location'],
				'Start_Date' => $row['Start_Date'],
				'End_Date' => $row['End_Date'],
				'Credit' => $row['Credit'],
				'Term' => $row['Term'],
				'Campus' => $row['Campus']
			];
		}
		mysqli_free_result($result);
	}
}
else

	echo "ERROR: Could not execute $sql. ";


mysqli_close($link);

$detect = new Mobile_Detect();
$mobile = false;
if ($detect->isMobile()) {
	$mobile = true;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>

	<title>Course Evaluations</title>

	<?php include("includes/header_includes.php"); ?>

</head>
<body>
	<div class="page-header">
		<h1>
			<?php if($logged_in) : ?>
				Hi, <b><?php echo $username; ?></b>.<br>
			<?php endif; ?>
			<span> Welcome </span> to Rate UAkron!
		</h1>
	</div>

	<?php include("includes/nav_bar.php"); ?>

	<form class="search form-group" action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="GET">
		<input type="text" name="search" class="inline-block search-box form-control" placeholder="Enter a course to search for">
		<input type="submit" class="inline-block btn btn-info" value="Submit">
	</form>

	<?php foreach ($courses as $course): ?>
		<table class="table text-align:left table-hover table-bordered results">
			<thead>
				<tr>
					<th> <?php echo $course["Title"] ?> </th>
				</tr>
				<tr class="warning no-result">
					<td><i class="fa fa-warning"></i> No result</td>
				</tr>
			</thead>
			<tbody>
				<tr><td><?= $course["Id"]?></td></tr>
				<tr><td><?= $course["Instructor"]?></td></tr>
				<tr><td><?= $course["Description"]?></td></tr>
				<?php if($course["Start_Time"] != "T.B.A."): ?>
					<tr><td><?= $course["Start_Time"] . " - " . $course["End_Time"]?></td></tr>
				<?php endif; ?>
				<tr>
					<td>
						<a href="evaluate_course.php?id=<?php echo $course['Cid'] . "&title=" . $course['Title']?>" class="btn btn-success">Evaluate</a>
						<a href="view_course_evaluations.php?id=<?php echo $course['Cid'] . "&title=" . $course['Title'] ?>" class="btn btn-success">View Evaluations</a>
					</td>
				</tr>
			</tbody>
		</table>
	<?php endforeach ?>


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


	<footer>
	 	The University of Akron trademarks and logos are property of The University of Akron. RateUAkron is not an affiliate of The University of Akron.
	</footer>
</body>
</html>
