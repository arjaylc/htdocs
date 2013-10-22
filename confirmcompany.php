<?php
	session_start();
	include('includes/classes_DatabaseMaster.inc.php');
	include('includes/classes_PageMaster.inc.php');

	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();

	$company_id = $_GET['company_id'];
	$newstatus = $_GET['status']; //// NEW STATUS

	$query = "UPDATE company_submission SET status = '$newstatus' WHERE company_id = $company_id";

	$updateResult = $DBMaster->queryUpdate($query);

	if($updateResult)
		$pageMaster->redirectUser('company_confirmation.php?success=true');
	else $pageMaster->redirectUser('company_confirmation.php?success=false');
?>