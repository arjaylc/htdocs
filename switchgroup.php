<?php
	session_start();
	include('includes/classes_SessionMaster.inc.php');
	include('includes/classes_PageMaster.inc.php');
	include('includes/classes_DatabaseMaster.inc.php');

	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();

	$group_id = $_GET['group_id'];
	$username = $DBMaster->escapeString($_SESSION['username']);

	$query = "DELETE FROM group_member WHERE username = '$username'";
	$deleteResult = $DBMaster->queryUpdate($query);
	if($deleteResult){
		$query2 = "INSERT into group_member VALUES('$group_id','$username')";
		$insertResult = $DBMaster->queryUpdate($query2);
		
		if($insertResult){
			$pageMaster->redirectUser('index.php?success=true');
			$sessionMaster = new SessionMaster();
			$sessionMaster->logUser($_SESSION['username'], $_SESSION['type'], $group_id);
		}
		else $pageMaster->redirectUser('index.php?success=false');
	}
	else $pageMaster->redirectUser('index.php?success=false');
?>