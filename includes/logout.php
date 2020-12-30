<?php
	require_once("db.php");
	session_destroy();
	header("Location: /evoting");
?>