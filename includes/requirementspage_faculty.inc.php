<div id="pt-contentbox" class="rounded-small">
	<h1 id="pt-contentheader">Online Student Submissions</h1>
<?php
	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();
	$userType = $_SESSION['type'];
	$username = $DBMaster->escapeString($_SESSION['username']);
	$userHasGroup = $DBMaster->checkUserHasGroup($username, $userType);

	if($userHasGroup && is_bool($userHasGroup)){
		/*GET LATEST PROJECT SUBMISSION*/

		$query = "SELECT COUNT(application_id) AS pending 
		FROM practicum_application 
		INNER JOIN group_member ON student = username
		WHERE group_id = {$_SESSION['group_id']}
		AND status = 'pending'";

		$queryResult = $DBMaster->querySelect($query);
		if(is_array($queryResult) && count($queryResult))
			$pendingProjectsCount = $queryResult[0]['pending'];

?>
	<table id="pt-requirements" cellspacing="0">
		<tr class="pt-reqheader"><td>Requirement</td><!--<td>Latest Submission</td>--></tr>
		<tr>
			<td>
			<a href="project_confirmation.php">Company Details Form<?php if($pendingProjectsCount > 0) echo '<span class="pt-newprojectscount">'.$pendingProjectsCount.'</span>' ?></a>
			</td>
		</tr>
		<tr>
			<td><a href="studentevaluationconfirmation.php">Practicum Evaluation Form</a></td>
		</tr>
		<tr>
			<td><a href="appraisalformconfirmation.php">Practicum Appraisal Form</a></td>
		</tr>
	</table>

<?php
	}
	else if(!$userHasGroup && is_bool($userHasGroup))
		$pageMaster->displayNoGroupMessages($userType);
	else $pageMaster->displayErrorMessage();
?>
</div>