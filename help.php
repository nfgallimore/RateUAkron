<?php

require_once 'includes/config.php';

?>

<!DOCTYPE html>
<html>
<head>

	<title>Online Help</title>
	<?php include("includes/header_includes.php") ?>

</head>
<body>

    <div class="page-header">
        <h1>
            <span> Welcome </span> to the help page!
        </h1>
    </div>

	<?php include("includes/nav_bar.php") ?>

	<ul>
		<li>If you have not created an account, please create an account before using this webpage.</li>
		<li>You can do so by clicking on Sign up now link which will prompt you to the page to create an account.</li>
		<li>If you have already created an account, enter your username.</li>
		<li>Corresponding password to get to the welcome page.</li>
	</ul>
	<p>
		Once you are in welcome page, you can use the search box located on upper right-hand corner of the webpage to search information using any of the following titles displayed on the table.<br>
		You can evaluate a course by clicking on the Evaluate button which corresponds to the course you are evaluating. If you wish to view the evaluations, you are free to click on <strong> View Evalutions </strong> to view your evaluations.<br>
		You can delete the evaluations if necessary/wanted by click on red <bold> X </bold>. In order to return back to the welcome page, you would need to click on Home button from your current page.<br>
		When you are done using the webpage, you can click on <em> Sign Out of Your Account </em> to log out. Moreover, it will save all of your information to the database.
	</p>
</body>
</html>
