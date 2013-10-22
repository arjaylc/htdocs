<?php
	include('../includes/classes_DatabaseMaster.inc.php');

	$DBMaster = new DatabaseMaster();

	$username = $DBMaster->escapeString($_POST['username']);
	$companyID = $_POST['companyID'];
	$flag = $_POST['flag'];

	if($flag == 'add'){
		$query = "INSERT INTO linkageofficer_company VALUES('$username', '$companyID')";
	}
	else $query = "DELETE FROM linkageofficer_company WHERE username = '$username' AND company_id = '$companyID'";

	$queryResult = $DBMaster->queryUpdate($query);

	if($queryResult) 
		echo $flag;
	else echo 'error';

?>