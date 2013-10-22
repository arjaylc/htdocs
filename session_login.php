<?php
	session_start();
	include('includes/classes_DatabaseMaster.inc.php');
	include('includes/classes_PageMaster.inc.php');
	include('includes/classes_SessionMaster.inc.php');

	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();
	
	$username = $_POST['username'];
	$origUsername = $username;
	$username = $DBMaster->escapeString($username);

	$password = $_POST['password'];
	$password = $DBMaster->escapeString($password);

	$query = "SELECT a.username, COALESCE(group_id, 0) AS group_id, type FROM user AS a LEFT JOIN group_member USING(username) WHERE a.username='$username' AND password=SHA('$password')";

	$queryResult = $DBMaster->querySelect($query);
	
	if(is_array($queryResult) && count($queryResult)){
		$sessionMaster = new SessionMaster();
		$sessionMaster->logUser($queryResult[0]['username'], $queryResult[0]['type'], $queryResult[0]['group_id']);
		$pageMaster->redirectUser();
	}
	else $pageMaster->redirectUser('index.php?success=false&username='.$username);
	

?>