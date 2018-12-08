<div class="nav-bar">
	<a href="index.php" class="btn btn-info">Home</a>
	<?php if($logged_in): ?>
		<a href="view_evaluation_history.php" class="btn btn-info">View Your Evaluation History</a>
	<?php endif; ?>
	<a href="help.php" class="btn btn-info">Help</a>
	<?php if($logged_in): ?>
		<a href="logout.php" class="btn btn-danger">Sign Out</a>
	<?php else: ?>
		<a href="logout.php" class="btn btn-danger">Log In</a>
	<?php endif; ?>
</div>