<?php
session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
    exit;
}

require_once 'includes/config.php';
$cid = $_GET['id'];

$sql = 'SELECT Title, Instructor, Description, Courses.Id, CourseId, UserId, Recommended, TimeSpent, Reason, Grade, GPA, Created_At, Evaluations.Id as Eid FROM Evaluations INNER JOIN Courses ON Evaluations.CourseID = Courses.Cid WHERE CourseId = ' . $cid;
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
		        'Created_At' => $row['Created_At'],
		        'Title' => $row['Title'],
		        'Instructor' => $row['Instructor'],
		        'Description' => $row['Description'],
				'Userid' => $row['UserId'],
				'Eds' => $row['Eid']
		    ];
		}
		mysqli_free_result($result);
	}
}

//-------------------------------------------------------------------
$usrn = $_SESSION['username'];
$sqe = "SELECT id from Users WHERE username like '$usrn'";
$evee = [];

if($result = mysqli_query($link, $sqe)) {
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            $evee[] = [
				'ids' => $row['id']
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
foreach ($evee as $eve) {
	$check = $eve['ids'];
}
//-------------------------------------------------------------------
$RecommendedSum = 0;
$RecommendedCount = 0;
$RecommendedAvg = 0;
$title = "";

foreach ($evals as $eval) {
    $RecommendedSum += $eval["Recommended"];
    $RecommendedCount++;
    $title = $eval["Title"];
}
if ($RecommendedCount > 0) {
	$RecommendedAvg = $RecommendedSum / $RecommendedCount;
}
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
		<h1>Hi, <b><?php echo $_SESSION['username']; ?></b>.<br><?php echo $title ?> See courses evaluations here.</h1>
		<p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
	</div>
	<div class="nav-bar">
		<a href="../welcome.php" class="btn btn-info">Home</a>
		<a href="../recommended.php" class="btn btn-info">Your Evaluation</a>
	</div><br>
	<table data-toggle="table" data-sort-name="stargazers_count" data-sort-order="desc" class="table text-align:left table-hover table-bordered results">
		<thead>
			<tr>
				<th data-field="EID" data-sortable="true" class="col-md-2 col-xs-2"> EID </th>
				<th data-field="id" data-sortable="true" class="col-md-2 col-xs-2"> Reviewer </th>
				<th data-field="name" data-sortable="true" class="col-md-2 col-xs-2"> Course ID </th>
				<th data-field="instructor" data-sortable="true" class="col-md-2 col-xs-2"> Recommend </th>
				<th data-field="description" data-sortable="true" class="col-md-2 col-xs-2"> Time Spent </th>
				<th data-field="evaluations" data-sortable="true" class="col-md-2 col-xs-2"> Grade </th>
				<th data-field="viewevals" data-sortable="true" class ="col-md-2 col-xs-2"> GPA </th>
				<th data-field="DEL" data-sortable="true" class ="col-md-2 col-xs-2"> DELETE </th>


			</tr>
			<tr class="warning no-result">
				<td colspan="4"><i class="fa fa-warning"></i> No result</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($evals as $eval): ?>
			<tr>
				<td><?= $eval["Eds"]?></td>
				<td><?= $eval["Userid"]?></td>
				<td><?= $eval["CourseId"]?></td>
				<td><?= $eval["Recommended"]?></td>
				<td><?= $eval["TimeSpent"]?></td>
				<td><?= $eval["Grade"]?></td>
				<td><?= $eval["GPA"]?></td>
				<?php if($eval["Userid"] == $check) : ?>
					<td>
						<a href="../deleval.php/q?id=<?php echo $eval['Eds']?>" class="btn btn-danger">X</a>
					</td>
				<?php endif; ?>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</body>
</html>
