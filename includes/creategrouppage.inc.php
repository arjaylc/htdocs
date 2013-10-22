<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-contentheader">Create Practicum Group</h1>
<?php
	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();

	$username = $DBMaster->escapeString($_SESSION['username']);

	$userHasGroup = $DBMaster->checkUserHasGroup($username, $_SESSION['type']);
	 
	if(!$userHasGroup && is_bool($userHasGroup)){
?>
<div id="pt-requirementform-holder">
<form action="check_creategroup.php" method="post">
	Group name<br/> <input class="pt-textfield rounded-small" type="text" placeholder="Group name" name="groupname" value="<?php if(isset($_GET['grpname'])) echo $_GET['grpname']; ?>"/>
	Confirm password <span class="pt-formnote">*user authentication</span><br/><input type="password" class="pt-textfield rounded-small" placeholder="Enter your password" name="password"/>

	<input id="submitForm" class="rounded-small" type="submit" value="Create Group"/>
</form>
</div>
<?php
	}
	else if($userHasGroup && is_bool($userHasGroup))
		$pageMaster->displayHasGroupMessages($userType);
	else $pageMaster->displayErrorMessage();
?>
</div>