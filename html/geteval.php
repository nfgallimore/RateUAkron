<?php 
session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
    exit;
}

require_once '../includes/config.php';
$cid = $_GET['id'];

$sql = 'SELECT Title, Instructor, Description, Courses.Id, CourseId, UserId, Recommended, TimeSpent, Reason, Grade, GPA, Created_At FROM Evaluations INNER JOIN Courses ON Evaluations.CourseID = Courses.Cid WHERE CourseId = ' . $cid;
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
		        'Description' => $row['Description'],
				'Userid' => $row['UserId']
		    ];
		}
		mysqli_free_result($result);
	}
}
mysqli_close($link);

$RecommendedSum = 0;
$RecommendedCount = 0;
$title = "";

foreach ($evals as $eval) {
    $RecommendedSum += $eval["Recommended"];
    $RecommendedCount++;
    $title = $eval["Title"];
}
$RecommendedAvg = $RecommendedSum / $RecommendedCount;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<title>Evaluations for <?php echo $title ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css" />
    <link rel="stylesheet" href="../css/styles.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>
</head>
<body>
	<div class="page-header">
		<h1>Hi, <b><?php echo $_SESSION['username']; ?></b>.<br><?php echo $title ?> Evaluations.</h1>	
		<p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
	</div>
	<div class="nav-bar">
		<a href="../welcome.php" class="btn btn-info">Home</a>
		<a href="../recommended.php" class="btn btn-info">Recommended Courses</a>
		<a href="../recommendedprofs.php" class="btn btn-info">Recommended Professors</a>
	</div>
	<table data-toggle="table" data-sort-name="stargazers_count" data-sort-order="desc" class="table text-align:left table-hover table-bordered results">
		<thead>
			<tr>
				<th data-field="id" data-sortable="true" class="col-md-2 col-xs-2"> Reviewer </th>
				<th data-field="name" data-sortable="true" class="col-md-2 col-xs-2"> Course ID </th>
				<th data-field="instructor" data-sortable="true" class="col-md-2 col-xs-2"> Recommend </th>
				<th data-field="description" data-sortable="true" class="col-md-2 col-xs-2"> Time Spent </th>
				<th data-field="evaluations" data-sortable="true" class="col-md-2 col-xs-2"> Grade </th>
				<th data-field="viewevals" data-sortable="true" class ="col-md-2 col-xs-2"> GPA </th>
			</tr>
			<tr class="warning no-result">
				<td colspan="4"><i class="fa fa-warning"></i> No result</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($evals as $eval): ?>
			<tr>
				<td><?= $eval["Userid"]?></td>
				<td><?= $eval["CourseId"]?></td>
				<td><?= $eval["Recommended"]?></td>
				<td><?= $eval["TimeSpent"]?></td>
				<td><?= $eval["Grade"]?></td>
				<td><?= $eval["GPA"]?></td>	
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</body>
</html>