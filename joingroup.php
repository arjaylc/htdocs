<?php
	session_start();
	include('includes/classes_SessionMaster.inc.php');
	include('includes/classes_PageMaster.inc.php');
	include('includes/classes_DatabaseMaster.inc.php');

	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();

	$group_id = $_GET['group_id'];
	$username = $DBMaster->escapeString($_SESSION['username']);

	$query = "INSERT into group_member VALUES('$group_id','$username')";

	if($DBMaster->queryUpdate($query))
		$pageMaster->redirectUser('index.php?success=true');
	else $pageMaster->redirectUser('index.php?success=false');
?>