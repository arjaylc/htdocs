<?php
	session_start();
	include('/includes/classes_DatabaseMaster.inc.php');
	include('/includes/classes_PageMaster.inc.php');

	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();

	$username = $DBMaster->escapeString($_SESSION['username']);

	$emailsupervisor = $_POST['emailsupervisor'];
	$emailsupervisor = $DBMaster->escapeString($emailsupervisor);

	$companycity = $_POST['companycity'];
	$companycity = $DBMaster->escapeString($companycity);

	$companypn = $_POST['companypn'];
	$companypn = $DBMaster->escapeString($companypn);

	$updateSubmission = false;

	if(isset($_POST['updatesubmission']))
		$updateSubmission = true;

	$status = "pending";

	

	if(!$updateSubmission)
		$query2 = "INSERT into company_submission VALUES (NULL, (SELECT group_id FROM group_member WHERE username='$username'), '$emailsupervisor', '$companycity', '$companypn', '$username', NOW(), '$status')";
	else $query2 = "UPDATE company_submission SET companypn = '$companypn', companycity = '$companycity', emailsupervisor = '$emailsupervisor', status='$status', datesubmitted = NOW() WHERE submitter = '$username' ";

	if($DBMaster->queryUpdate($query2)){
		if($updateSubmission)
			$pageMaster->redirectUser('company_submission.php?type=update');
		else $pageMaster->redirectUser('company_submission.php?type=submit');
	}
		
	else $pageMaster->redirectUser('company_submission.php?error=error');


?>