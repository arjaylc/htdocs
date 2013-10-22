<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-contentheader">Assigned Students </h1>
	<?php
	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();
	$userType = $_SESSION['type'];
	$username = $DBMaster->escapeString($_SESSION['username']);
	

	if($_SESSION['group_id'] != 0){
		$query = "SELECT CONCAT(lastname, ', ', firstname) AS fullName, companyname, email 
		FROM practicum_application AS PA
		INNER JOIN user AS U ON U.username = PA.student
		INNER JOIN company AS C ON PA.company_id = C.company_id
		INNER JOIN linkageofficer_company AS LC ON LC.company_id = PA.company_id
		WHERE LC.username = '$username' AND type = 'student' ORDER BY companyname, lastname";

		$queryResult = $DBMaster->querySelect($query);

		if(is_array($queryResult) && count($queryResult)){
			echo '<div id="pt-searchresults-holder">';
			foreach($queryResult AS $key=>$row){
				echo '<div class="pt-searchresult">'; 
				echo '<div class="">'.($key+1).'.) '.$row['fullName'].'</div>';
				echo '<div class=""><b>Company</b>: '.$row['companyname'].'</div>';
				echo '<div class=""><b>Email</b>: '.$row['email'].'</div>';
				
				echo '</div>';
			}
			echo '</div>';
		}
		else if(is_array($queryResult) && !count($queryResult)){
			echo '<h2 class="pt-oops">Oops! You are not assigned to any companies yet.</h2>';
			echo "It seems like your practicum coordinator hasn't assigned you to any companies yet.";
		}
		else $pageMaster->displayErrorMessage();
	}
	else $pageMaster->displayNoGroupMessages($userType);
	?>

</div>