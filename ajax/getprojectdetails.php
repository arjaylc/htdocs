<?php
	include('../includes/classes_DatabaseMaster.inc.php');

	$DBMaster = new DatabaseMaster();

	$username = $_GET['username'];
	$username = $DBMaster->escapeString($username);

	$query = "SELECT companyname, city,
	project_title, project_description, project_output, project_num_students,
	contacts.hr_name AS hrname, contacts.ts_name AS tsname, project_type
	FROM practicum_application AS pa
	INNER JOIN company USING(company_id)
	INNER JOIN practicum_application_contacts AS contacts USING(application_id)
	INNER JOIN practicum_application_project USING(application_id)
	INNER JOIN practicum_application_project_types USING(application_id)
	WHERE student = '$username'";

	$returnData = array();
	$returnData['error'] = false;
	$html = "";

	$queryResult = $DBMaster->querySelect($query);

	if(is_array($queryResult)){
		$details = $queryResult[0];
		$html .= '<b>Submission Details</b><div class="pt-projectdetails">';
		$html .= '<div>Company: '.$details['companyname'].' <i>'.$details['city'].'</i></div>';
		$html .= '<div>Supervisor: '.$details['tsname'].'</div>';
		$html .= '<div class="">Project Name: '.$details['project_title'].'</div>';
		$html .= '<div class="">Description: '.$details['project_description'].'</div>';
		$html .= '<div class="">Output: '.$details['project_output'].'</div>';
		$html .= '<div class="">No. of Students: '.$details['project_num_students'].'</div>';
		$html .= '</div>';
	}
	else{
		$returnData['error'] = true;
		$html .= 'It seems like somethign went wrong. Please try again.';
	}

	$returnData['output'] = $html;

	$JSON = json_encode($returnData, JSON_FORCE_OBJECT);

	echo $JSON;
?>