<?php
	session_start();
	include('includes/classes_SessionMaster.inc.php');
	include('includes/classes_PageMaster.inc.php');
	include('includes/classes_DatabaseMaster.inc.php');

	$DBMaster = new DatabaseMaster();
	$sessionMaster = new SessionMaster();
	$pageMaster = new PageMaster();

	$errors = array();

	$username = $_POST['username'];
	$origUsername = $username;
	$username = $DBMaster->escapeString($username);

	$password = $_POST['password'];
	$password = $DBMaster->escapeString($password);

	$firstname = $_POST['firstname'];
	$firstname = $DBMaster->escapeString($firstname);

	$lastname = $_POST['firstname'];
	$lastname = $DBMaster->escapeString($lastname);

	$email = $_POST['email'];
	$email = $DBMaster->escapeString($email);

	$address = $_POST['address'];
	$address = $DBMaster->escapeString($address);

	$contactNum = $_POST['contactnum'];
	$contactNum = $DBMaster->escapeString($contactNum);

	$type = $_POST['type'];

	if(!$DBMaster->checkUsername($username))
		$errors['username'] = "username";
	if(!$DBMaster->checkEmail($email))
		$errors['email'] = "email";
	if(!$DBMaster->checkContactNum($contactNum))
		$errors['contact'] = "email";

	if(empty($errors)){
		$query = "INSERT INTO user VALUES ('$username', SHA('$password'), '$firstname', '$lastname', '$email', '$contactNum', '$address', '$type')";
		
		if($DBMaster->queryInsert($query)){
			$sessionMaster->logUser($origUsername, $type);
			$pageMaster->redirectUser();
		}
		else $pageMaster->redirectUser('register.php?error=error');
	}
?>