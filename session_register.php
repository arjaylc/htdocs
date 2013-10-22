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

	$lastname = $_POST['lastname'];
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
		$errors['contact'] = "contact";

	if(empty($errors)){
		$query = "INSERT INTO user VALUES ('$username', SHA('$password'), '$firstname', '$lastname', '$email', '$contactNum', '$address', '$type')";
		
		if($DBMaster->queryUpdate($query)){
			$sessionMaster->logUser($origUsername, $type, 0);
			$pageMaster->redirectUser();
		}
		else $pageMaster->redirectUser('register.php?error=error');
	}
	else{
		$URL = 'register.php?';
		$errorCount = 0;
		foreach($errors AS $queryString){
			$errorCount++;
			$URL.=$queryString.'=false';
			if($errorCount != count($errors))
				$URL.='&';
		}
		$pageMaster->redirectUser($URL);
	}
?>