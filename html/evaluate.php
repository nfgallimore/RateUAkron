<?php 
session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
    exit;
}

require_once '../includes/config.php';

$recommended = $timespent = $reason = $grade = $gpa = "";
$recommended_err = $timespent_err = $reason_err = $grade_err = $gpa_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (empty(trim($_POST["recommendation"]))) {
		$recommended_err = "Please enter a recommendation.";
	}
	if (empty(trim($_POST["timespent"]))) {
		$timespent_err = "Please enter the time spent.";
	}
	if (empty(trim($_POST["reason"]))) {
		$reason_err = "Please enter a reason for taking the course.";
	}
	if (empty(trim($_POST["grade"]))) {
		$grade_err = "Please enter a grade.";
	}
	if (empty(trim($_POST["gpa"]))) {
		$gpa_err = "Please enter your GPA.";
	}
}
if (empty($recommended_err) && empty($timespent_err) && empty($reason_err) && empty($grade_err) && empty($gpa_err)) {
	$cid = $_GET['id'];
	$sql = 'INSERT INTO Evaluations (CourseID, UserID, Recommended, TimeSpent, Reason, Grade, GPA) VALUES (' . $cid . ', ' . $_SESSION['userid'] . ', ?, ?, ?, ?, ?)';
	if ($stmt = mysqli_prepare($link, $sql)) {
		mysqli_stmt_bind_param($stmt, "sssss", $param_recommended, $param_timespent, $param_reason, $param_grade, $param_gpa);

		$recommended = trim($_POST['recommended'])
		$timespent = trim($_POST['timespent']);
		$reason = trim($_POST['reason']);
		$grade = trim($_POST['grade']);
		$gpa = trim($_POST['gpa']);

		$param_recommended = $recommended;
		$param_timespent = $timespent;
		$param_reason = $reason;
		$param_grade = $grade;
		$param_gpa = $gpa;

		if !(mysqli_stmt_execute($stmt)) {
			echo "Something went wrong. Please try again later.";
		}
		mysqli_stmt_close($stmt);
	}
}
mysqli_close($link);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<title>Evaluate <?php echo $title ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>
</head>
<body>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<div class="form-group <?php echo (!empty($recommended_err)) ? 'has-error' : ''; ?>">
		<label>Recommended:<sup>*</sup></label>
		<input type="text" class="form-control bfh-number" data-min="1" data-max="10">
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" value="Submit">
		<input type="reset" class="btn btn-default" value="Reset">
	</div>
</body>