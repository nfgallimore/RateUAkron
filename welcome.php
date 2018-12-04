<?php
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
	header("location: login.php");
	exit;
}
require_once 'includes/config.php';
$sql = "SELECT Cid, Id, Title, Description, Instructor, Start_Time, End_Time FROM Courses";

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
	echo "ERROR: Could not able to execute $sql. ";
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>
    <script src="js/search.js"></script>
</head>
<body>
	<div class="page-header">
		<h1>Hi, <b><?php echo $_SESSION['username']; ?></b>.<br> <span> Welcome </span> to the University of Akron Course Catalog</h1>
		<p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
	</div>
	<div class="nav-bar">
		<a href="recommended.php" class="btn btn-info">Your Evaluations</a>
		<!--a href="recommendedprofs.php" class="btn btn-info">Recommended Professors</a-->
	</div>
	<div class="form-group pull-right">
		<input type="text" class="search form-control" placeholder="What you looking for?">
	</div>
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
				<th data-field="evaluations" data-sortable="true" class="col-md-2 col-xs-2"> Evaluate Course </th>
				<th data-field="viewevals" data-sortable="true" class ="col-md-2 col-xs-2"> View Evaluations </th>

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
				<td><a href="evaluate.php/q?id=<?php echo $course['Cid']?>" class="btn btn-success">Evaluate</a>
				<td><a href="geteval.php/q?id=<?php echo $course['Cid']?>" class="btn btn-info">View Evaluations</a>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</body>
</html>
