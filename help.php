<?php
require_once 'includes/config.php';

$loggedIn = true;
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    $loggedIn = false;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css" />
	<link rel="stylesheet" href="css/styles.css" />

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

	<title>Online Help</title>
</head>
<body>
	<!-- header start -->
    <div class="page-header">
        <h1>Hi, <b><?php echo $_SESSION['username']; ?></b>.<br> <span> Welcome </span> to the help page!</h1>
    </div>
    </div>
    <div class="nav-bar">
        <a href="index.php" class="btn btn-info">Home</a>
        <a href="view_evaluation_history.php" class="btn btn-info">View Evaluation History</a>
        <a href="help.php" class="btn btn-info">Help</a>
        <a href="logout.php" class="btn btn-danger">Sign Out</a>
    </div>
		<ul>
			<li>If you have not created an account, please create an account before using this webpage.</li>
			<li>You can do so by clicking on Sign up now link which will prompt you to the page to create an account.</li>
			<li>If you have already created an account, enter your username.</li>
			<li>Corresponding password to get to the welcome page.</li>
		</ul>
		<p>Once you are in welcome page, you can use the search box located on upper right-hand corner of the webpage to search information using any of the following titles displayed on the table.<br>
			You can evaluate a course by clicking on the Evaluate button which corresponds to the course you are evaluating. If you wish to view the evaluations, you are free to click on <strong> View Evolutions </strong> to view your evaluations.<br>
			You can delete the evaluations if necessary/wanted by click on red <bold> X </bold>. In order to return back to the welcome page, you would need to click on Home button from your current page.<br>
			When you are done using the webpage, you can click on <em> Sign Out of Your Account </em> to log out. Moreover, it will save all of your information to the database. </p>
	</div>
</body>
</html>
