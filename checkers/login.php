<?php
	session_start();
	include('../includes/classes.inc.php');
	$DBoy = new DatabaseMaster();

	$username = $_POST['username'];
	$username = $DBoy->escapeString($username);

	$password = $_POST['password'];
	$password = $DBoy->escapeString($password);

	$query = "SELECT username, type FROM users WHERE username='$username' AND password=SHA('$password')";

	$queryResult = $DBoy->querySelect($query);
	if($queryResult){
		$sessionBoy = new SessionMaster();
		$sessionBoy->logUser($query['username'], $query['type']);

		

	}
	
	$pageBoy = new PageMaster();
	$pageBoy->redirectUser('index.php');

?>