<?php
	
	if(session_status() == PHP_SESSION_NONE) 
	{
		session_start();
	}
	
	$dbhost = "localhost";
	$dbname = "evoting_system";
	$dbuser = "root";
	$dbpass = "";
	
	try
	{
		$db = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $error)
	{
		die($error);
	}
	
?>