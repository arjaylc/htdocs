<?php
	session_start();
	include('includes/classes_PageMaster.inc.php');
	include('includes/classes_DatabaseMaster.inc.php');
	include('includes/classes_SessionMaster.inc.php');
	
	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();

	$groupName = $_POST['groupname'];
	$origGroupName = $groupName;
	$groupName = $DBMaster->escapeString($groupName);

	$password = $_POST['password'];
	$password = $DBMaster->escapeString($password);

	$username = $DBMaster->escapeString($_SESSION['username']);

	$query = "SELECT username FROM user WHERE username = '$username' AND password=SHA('$password')";

	$queryResult = $DBMaster->querySelect($query);

	if(count($queryResult) && is_array($queryResult)){
		$DBMaster->autoCommit(false);

		$query = "INSERT INTO practicum_group(group_name, group_admin, datecreated, status) VALUES ('$groupName', '$username', CURDATE(), 'open')";

		$insertResult = $DBMaster->queryUpdate($query);
		if(!$insertResult) {
			$DBMaster->autoCommit(false);
			$pageMaster->redirectUser('creategroup.php?grpname='.$origGroupName.'&error=error');
		}
		
		
		$query = "INSERT INTO group_member VALUES( (SELECT group_id FROM practicum_group WHERE group_name = '$groupName'), '$username')";

		$insertResult = $DBMaster->queryUpdate($query);
		if(!$insertResult) {
			$DBMaster->autoCommit(false);
			$pageMaster->redirectUser('creategroup.php?grpname='.$origGroupName.'&error=error');
		}

		$query = "SELECT group_id FROM practicum_group WHERE group_name = '$groupName'";

		$queryResult = $DBMaster->querySelect($query);
		if(count($queryResult) && is_array($queryResult)){
			$sessionMaster = new SessionMaster();
			$sessionMaster->logUser($_SESSION['username'], $_SESSION['type'], $queryResult[0]['group_id']);
			$DBMaster->autoCommit(true);
			$pageMaster->redirectUser();
		}
		else echo $query;
		
	}
	else if(!count($queryResult) && is_array($queryResult))
		$pageMaster->redirectUser('creategroup.php?grpname='.$origGroupName.'&error=password');
	else
		$pageMaster->redirectUser('creategroup.php?grpname='.$origGroupName.'&error=error');
		
	
?>