<?php
require_once 'includes/config.php';

$username = $password = $userid = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (empty(trim($_POST["username"]))) {
		$username_err = 'Please enter username.';
	}
	else {
		$username = trim($_POST["username"]);
	}

	if (empty(trim($_POST['password']))) {
		$password_err = 'Please enter your password.';
	}
	else {
		$password = trim($_POST['password']);
	}
	if (empty($username_err) && empty($password_err)) {
		$sql = "SELECT Username, Password, Id FROM Users WHERE Username = ?";

		if ($stmt = mysqli_prepare($link, $sql)) {
			mysqli_stmt_bind_param($stmt, "s", $param_username);
			$param_username = $username;
			if (mysqli_stmt_execute($stmt)) {
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) == 1) {
					mysqli_stmt_bind_result($stmt, $username, $hashed_password, $userid);
					if (mysqli_stmt_fetch($stmt)) {
						if (password_verify($password, $hashed_password)) {
							session_start();
							$_SESSION['username'] = $username;
							$_SESSION['userid'] = $userid;
							header("location: index.php");
						}
						else {
							$password_err = 'The password you entered was not valid.';
						}
					}
				}
				else {
					$username_err = 'No account found with that username.';
				}
			}
			else {
				echo "Oops! Something went wrong. Please try again later.";
			}
		}
		mysqli_stmt_close($stmt);
	}
	mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="css/styles.css">

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

	<div class="page-header">
		<h1><span> Welcome </span> to the University of Akron Course Catalog!</h1>
	</div>
	<div class="nav-bar">
		<a href="index.php" class="btn btn-info">Home</a>
		<a href="view_evaluation_history.php" class="btn btn-info">View Evaluation History</a>
		<a href="help.php" class="btn btn-info">Help</a>
		<a href="logout.php" class="btn btn-danger">Sign Out</a>
	</div>
</head>
<body>
	<div class="wrapper">
		<h2>Login</h2>
		<p>Please fill in your credentials to login.</p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
				<label>Username:<sup>*</sup></label>
				<input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
				<span class="help-block"><?php echo $username_err; ?></span>
			</div>
			<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
				<label>Password:<sup>*</sup></label>
				<input type="password" name="password" class="form-control">
				<span class="help-block"><?php echo $password_err; ?></span>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-info" value="Submit">
			</div>
			<p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
		</form>
		<br />
		<a href="report.docx">Click here to download report.</a><br /><br />
		<a href="presentation.pptx">Click here to download presentation.</a>
	</div>
</body>
</html>
