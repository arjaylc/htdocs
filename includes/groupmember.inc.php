<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-contentheader"> Group Members </h1>
	<?php
	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();
	$userType = $_SESSION['type'];
	$username = $DBMaster->escapeString($_SESSION['username']);
	$userHasGroup = $DBMaster->checkUserHasGroup($username, $userType);


	$query = "SELECT CONCAT(lastname, ', ', firstname) AS fullName, email FROM group_member INNER JOIN user USING(username) WHERE group_id = {$_SESSION['group_id']} AND type = 'student' ORDER BY lastname";

	$queryResult = $DBMaster->querySelect($query);

        if(is_array($queryResult) && count($queryResult)){
		echo '<div id="pt-searchresults-holder">';
		foreach($queryResult AS $key=>$row){
			echo '<div class="pt-searchresult">'; 
			echo '<div class="">'.($key+1).'.) '.$row['fullName'].'</div>';
			echo '<div class="">'.$row['email'].'</div>';
			echo '</div>';
		}
		echo '</div>';
	}
	else if(is_array($queryResult) && !count($queryResult)){
		echo '<h2 class="pt-oops">Oops! There are still no members.</h2>';
		echo 'It seems like no one has joined the group you created yet.';
	}
	?>

</div>