<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-contentheader">Company Details Form</h1>

<?php
	$DBMaster = new DatabaseMaster();

	$username = $DBMaster->escapeString($_SESSION['username']);
	$pageMaster = new PageMaster();

	$query = "SELECT businessname, supervisor FROM project_submission WHERE submitter='$username'";

	$queryResult = $DBMaster->querySelect($query);

	if(is_array($queryResult) && count($queryResult)){
		$companyName = $queryResult[0]['businessname'];
		$supervisor = $queryResult[0]['supervisor'];
	}

	$query = "SELECT emailsupervisor, companycity, companypn, status, DATE_FORMAT(datesubmitted, '%b %e, %Y @ %l:%i %p') AS datepassed FROM company_submission WHERE submitter='$username'";

	$companyRow = $DBMaster->querySelect($query);

	if(is_array($companyRow) && count($companyRow)){
		$companyInfo['companyNum'] = $companyRow[0]['companypn'];
		$companyInfo['companyCity'] = $companyRow[0]['companycity'];
		$companyInfo['supervisorEmail'] = $companyRow[0]['emailsupervisor'];
		$companyInfo['datepassed'] = $companyRow[0]['datepassed'];
		$companyInfo['status'] = $companyRow[0]['status'];
	}

	$previousRequirement = $DBMaster->checkProjectSubmissionStatus($username);

	if(is_bool($previousRequirement) || $previousRequirement == 'pending' || $previousRequirement == 'rejected'){
		$pageMaster->displayNeedPreviousRequirement();
	}
	else if(is_null($previousRequirement)){
		$pageMaster->displayErrorMessage();
	}
	else {
		
?>
<div id="pt-requirementform-holder">
<form action="check_companysubmission.php" method="POST">
<?php
	if(isset($_GET['error']) && $_GET['error'] == 'error'){
		echo '<div class="pt-errornotice rounded-small"><b>Sorry for the inconvenience.</b><br/>A system error has occurred. Please try again later.</div>';
	}
	if(isset($_GET['type']) && $_GET['type'] == 'update'){
		echo '<div class="pt-notice rounded-small"><b>Update successful!</b><br/>';
		echo 'Please wait for this new submission to be confirmed.</div>';
	}

	if(isset($_GET['type']) && $_GET['type'] == 'submit'){
		echo '<div class="pt-notice rounded-small"><b>Submission successful!</b><br/>';
		echo 'Please wait for this new submission to be confirmed.</div>';
	}

	if(isset($companyInfo)){
		echo '<input type="hidden" value="update" name="updatesubmission"/>'; 
		echo '<div id="pt-projectlastupdate" class="rounded-small">';
		echo '<b>Last successful submission</b>: '.$companyInfo['datepassed'].'<br/>';
		echo '<b>Submission status</b>: '.ucwords($companyInfo['status']);
		echo '</div>';
	}
	?>
	<div class="pt-form-section">
	Company Name <input class="pt-textfield rounded-small" type="text" disabled="disabled" value="<?php if(isset($companyName)) echo $companyName; ?>"/>
	</div>
	<div class="pt-form-section">
	Supervisor <input class="pt-textfield rounded-small" type="text" disabled="disabled" value="<?php if(isset($supervisor)) echo $supervisor; ?>" />
	</div>
	<div class="pt-form-section">
	Email of Supervisor <input class="pt-textfield rounded-small" type="text" placeholder="Email of Supervisor" name="emailsupervisor" value="<?php if(isset($companyInfo)) echo $companyInfo['supervisorEmail']; ?>"/>
	</div>
	<div class="pt-form-section">
	Company City <input class="pt-textfield rounded-small" type="text" placeholder="Company City" name="companycity" value="<?php if(isset($companyInfo)) echo $companyInfo['companyCity']; ?>"/>
	</div>
	<div class="pt-form-section">
	Company Phone Number <input type="text" class="pt-textfield rounded-small" placeholder="Company Phone Number" name="companypn" value="<?php if(isset($companyInfo)) echo $companyInfo['companyNum']; ?>"/>
	</div>
	<div class="clearfix"></div>
	
	<div class="clearfix"></div>
	<input id="submitForm" type="submit" class="rounded-small" value="<?php echo (isset($companyInfo) ? "Update" : "Submit"); ?>"/>
</form>
</div>
<?php
	}
?>
</div>