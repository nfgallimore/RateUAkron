<?php
require_once 'includes/config.php';

$loggedIn = true;

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
	$loggedIn = false;
}
else {
	$username = $_SESSION['username'];
}

$cid = htmlspecialchars($_GET['id']);
$courseTitle = htmlspecialchars($_GET['title']);

$sql = 'SELECT Evaluations.Id as Eid, Title, Instructor, Description, CourseID, UserId, Comment, Recommended, TimeSpent, Reason, Grade, GPA, Created_At, Evaluations.Id as Eid FROM Evaluations INNER JOIN Courses ON Evaluations.CourseID = Courses.Cid WHERE CourseID = ' . $cid;
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

if ($loggedIn) {
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
			<?php if($loggedIn) : ?>
				Hi, <b><?php echo $username; ?></b><br>
			<?php endif; ?>
			<span> <?php echo $courseTitle?> </span> course evaluations		
		</h1>
	</div>
	<div class="nav-bar">
		<a href="index.php" class="btn btn-info">Home</a>
		<a href="view_evaluation_history.php" class="btn btn-info">View Your Evaluation History</a>
		<a href="help.php" class="btn btn-info">Help</a>
		<a href="<?php echo ($loggedIn) ? 'logout.php' : 'login.php' ?>" class="btn btn-danger"><?php echo ($loggedIn) ? 'Sign Out' : 'Log in' ?></a>
	</div>
	<table data-toggle="table" data-sort-name="stargazers_count" data-sort-order="desc" class="table text-align:left table-hover table-bordered results">
		<thead>
			<tr>
				<th data-field="name" data-sortable="true" class="col-md-2 col-xs-2"> Course Name </th>
				<th data-field="instructor" data-sortable="true" class="col-md-2 col-xs-2"> Recommend </th>
				<th data-field="description" data-sortable="true" class="col-md-2 col-xs-2"> Time Spent </th>
				<th data-field="evaluations" data-sortable="true" class="col-md-2 col-xs-2"> Grade </th>
				<th data-field="gpa" data-sortable="true" class ="col-md-2 col-xs-2"> GPA </th>
				<th data-field="comment" data-sortable="true" class ="col-md-2 col-xs-2"> Comment </th>
				<th data-field="del" data-sortable="false" class ="col-md-2 col-xs-2"> Delete </th>
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
				<td><?= $eval["Grade"]?></td>
				<td><?= $eval["GPA"]?></td>
				<td><?= $eval["Comment"]?></td>
				<?php if($eval["Userid"] == $check) : ?>
					<td>
						<a href="delete_evaluation.php?id=<?php echo $eval['Eid']?>" class="btn btn-danger">Delete</a>
					</td>
				<?php endif; ?>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</body>
</html>
