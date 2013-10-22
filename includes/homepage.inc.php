<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-contentheader">Group Activity</h1>
<?php
	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();
	$userType = $_SESSION['type'];

	$username = $DBMaster->escapeString($_SESSION['username']);
	$userHasGroup = $DBMaster->checkUserHasGroup($username, $userType);

	if($userHasGroup && is_bool($userHasGroup)){
		echo 'Not yet available.';
	}
	else if(!$userHasGroup && is_bool($userHasGroup))
		$pageMaster->displayNoGroupMessages($userType);
	else $pageMaster->displayErrorMessage();
?>
</div>