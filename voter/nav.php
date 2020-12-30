<?php
require_once("../includes/init.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'voter') {
	echo "<script>window.location = '/';</script>";
	exit(0);
}
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="/evoting/voter">e-Voting</a>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="change_password.php">Change Password</a></li>
			<li><a href="../includes/logout.php">Logout</a></li>
		</ul>
	</div>
	</div>
</nav>