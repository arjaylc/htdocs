<?php
	session_start();
	include('includes/classes_DatabaseMaster.inc.php');
	include('includes/classes_PageMaster.inc.php');

	$pageMaster = new PageMaster();
	$errors = 0;
	$inputCount = count($_POST);

	//check if all inputs were passed to the server
	//or a user deleted an element intentionally
	if($inputCount != 25)
		$errors++;

	//check whether all inputs are empty or not
	foreach($_POST AS $input){
		if(empty($input))
			$errors++;
	}

	//if no errors were found, proceed with the checking
	if($errors == 0){
		$DBMaster = new DatabaseMaster();

		//initialize the company data
		$companyID = $_POST['companyid'];
		$companyName = $DBMaster->escapeString($_POST['companyname']);
		$companyLine = $DBMaster->escapeString($_POST['businessline']);
		$companyFloorUnit = $DBMaster->escapeString($_POST['floorunit']);
		$companyBuilding = $DBMaster->escapeString($_POST['building']);
		$companyStreet = $DBMaster->escapeString($_POST['street']);
		$companyCity = $DBMaster->escapeString($_POST['city']);

		//disable the autocommit feature to prevent unwanted data when an error occurs
		$DBMaster->autoCommit(false);

                $username = $DBMaster->escapeString($_SESSION['username']);

		//label previous requirements as pending
		$query = "DELETE FROM practicum_application WHERE student='$username'";
		$queryResult = $DBMaster->queryUpdate($query);
		if(!$queryResult){
			$pageMaster->redirectUser('project_submission.php?error=error&out=1');
		}

		//deals with the insertion of the new company record to the company table
		$query = "SELECT company_id FROM company WHERE company_id = '$companyID'";
		$queryResult = $DBMaster->querySelect($query);

		//if the query was successful and there was no duplicate, create a new company record
		if(is_array($queryResult) && !count($queryResult)){
			$query = "INSERT INTO company VALUES('$companyID', '$companyName', '$companyLine', '$companyFloorUnit', '$companyStreet', '$companyBuilding', '$companyCity')";

			# CHECKPOINT!
			# if an error occurs here, the script will redirect the user and stop running!
			$queryResult = $DBMaster->queryUpdate($query);
			if(!$queryResult){
				$DBMaster->commitChanges(false);
				$pageMaster->redirectUser('project_submission.php?error=error&out=1');
			}
		}

		//if the checking / insertion of the company was successful, create a new record in the practicum_application table
		//create a extra-random 40-character string for the new application ID
		$randomNum = time().mt_rand();
		$newApplicationID = sha1($randomNum);

		$query = "INSERT INTO practicum_application VALUES ('$newApplicationID', '{$_SESSION['username']}', NOW(), 'pending', '$companyID')";	

		# CHECKPOINT!
		# if an error occurs here, the script will redirect the user and stop running!
		# and to be safe, discard all changes (INSERTs, UPDATEs) made to the database
		$queryResult = $DBMaster->queryUpdate($query);
		if(!$queryResult){
			$DBMaster->commitChanges(false);
			$pageMaster->redirectUser('project_submission.php?error=error&out=2');
		}

		//initialize contact person details for the human resource contact person
		$hrName = $DBMaster->escapeString($_POST['hrname']);
		$hrPosition = $DBMaster->escapeString($_POST['hrposition']);
		$hrEmail = $DBMaster->escapeString($_POST['hremail']);
		$hrDepartment = $DBMaster->escapeString($_POST['hrdepartment']);
		$hrTelNum = $DBMaster->escapeString($_POST['hrtelnum']);
		$hrFaxNum = $DBMaster->escapeString($_POST['hrfaxnum']);

		$hrUpdate = $DBMaster->updateContactPerson($pageMaster, $hrName, $hrPosition, $hrDepartment, $hrEmail, $hrTelNum, $hrFaxNum);
		
		if(!$hrUpdate){
			$DBMaster->commitChanges(false);
			$pageMaster->redirectUser('project_submission.php?error=error&out=2');
		}

		$tsName = $DBMaster->escapeString($_POST['tsname']);
		$tsPosition = $DBMaster->escapeString($_POST['tsposition']);
		$tsEmail = $DBMaster->escapeString($_POST['tsemail']);
		$tsDepartment = $DBMaster->escapeString($_POST['tsdepartment']);
		$tsTelNum = $DBMaster->escapeString($_POST['tstelnum']);
		$tsFaxNum = $DBMaster->escapeString($_POST['tsfaxnum']);

		$tsUpdate = $DBMaster->updateContactPerson($pageMaster, $tsName, $tsPosition, $tsDepartment, $tsEmail, $tsTelNum, $tsFaxNum);

		if(!$tsUpdate){
			$DBMaster->commitChanges(false);
			$pageMaster->redirectUser('project_submission.php?error=error&out=2');
		}

		//if the checking / updating / inserting of contact persons were successful, place them in the practicum_application_contacts table
		$query = "INSERT INTO practicum_application_contacts VALUES('$newApplicationID', '$hrName', '$tsName')";

		# CHECKPOINT!
		# if an error occurs here, the script will redirect the user and stop running!
		# and to be safe, discard all changes (INSERTs, UPDATEs) made to the database
		$queryResult = $DBMaster->queryUpdate($query);
		if(!$queryResult){
			$DBMaster->commitChanges(false);
			$pageMaster->redirectUser('project_submission.php?error=error&out=2');
		}


		//if the insertion of contact persons into the practicum_application_contacts table was successful, insert the user's project data to the practicum_application_project table
		$projectTitle = $DBMaster->escapeString($_POST['projtitle']);
		$projectStudents = $_POST['numstudents'];
		$projectDuration = $DBMaster->escapeString($_POST['projduration']);
		$projectDescription = $DBMaster->escapeString($_POST['projdesc']);
		$projectOutput = $DBMaster->escapeString($_POST['projoutput']);
		$projectTypes = $_POST['projtype'];
		$escapedProjectTypes = array();

		if(is_array($projectTypes) && count($projectTypes)){
			foreach($projectTypes AS $type)
				$escapedProjectTypes[] = $DBMaster->escapeString($type);
		}

		$query = "INSERT INTO practicum_application_project VALUES('$newApplicationID', '$projectTitle', '$projectDescription', '$projectOutput', $projectStudents, '$projectDuration')";

		# CHECKPOINT!
		# if an error occurs here, the script will redirect the user and stop running!
		# and to be safe, discard all changes (INSERTs, UPDATEs) made to the database
		$queryResult = $DBMaster->queryUpdate($query);
		if(!$queryResult){
			$DBMaster->commitChanges(false);
			$pageMaster->redirectUser('project_submission.php?error=error&out=2');
		}

		//if the project details were recorded in the database successfully, insert the project type(s) into the project_application_project_types table

		$query = "INSERT INTO practicum_application_project_types VALUES ";

		$valuesArray = array();
		
		foreach($escapedProjectTypes AS $type){
			$valuesArray[] = "('$newApplicationID', '$type')";
		}

		$query .= implode(', ', $valuesArray);

		# CHECKPOINT!
		# if an error occurs here, the script will redirect the user and stop running!
		# and to be safe, discard all changes (INSERTs, UPDATEs) made to the database
		$queryResult = $DBMaster->queryUpdate($query);
		if(!$queryResult){
			$DBMaster->commitChanges(false);
			$pageMaster->redirectUser('project_submission.php?error=error&out=2');
		}

		$DBMaster->commitChanges(true);
		$pageMaster->redirectUser('project_submission.php?type=submit');
		
		
	}
	else $pageMaster->redirectUser('project_submission.php?error=error&out='.$inputCount);

?>