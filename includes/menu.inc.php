<div id="pt-navigationmenu" class="rounded-small">

<div class="greetings">
	
	<?php 
		if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
			//echo '<img src="images/thumb_pc.png" alt="Practicum Coordinator"/>';
			$DBMaster = new DatabaseMaster();
			$username = $DBMaster->escapeString($_SESSION['username']);
			$query="SELECT CONCAT(a.firstname, ' ', a.lastname) AS fullname,
			COALESCE(CONCAT(d.firstname, ' ', d.lastname), 'N/A') as LO,
			a.type AS type FROM user as a
			LEFT JOIN practicum_application as b ON b.student = a.username
			LEFT JOIN linkageofficer_company as c ON c.company_id = b.company_id
			LEFT JOIN user as d ON c.username = d.username
			WHERE a.username='$username'";

			$queryResult = $DBMaster->querySelect($query);
			echo '<b>'.$queryResult[0]['fullname'].'</b>';
			echo '<br/>';
			echo '<span class="usertype"><b>Type</b>: '.ucwords($queryResult[0]['type']).'</span>';


			if($_SESSION['type'] == 'student'){
				echo '<br/>';
				echo '<span class="usertype" title="Linkage Officer"><b>LO</b>: '.ucwords($queryResult[0]['LO']).'</span>';
			}
		}
		else{
			echo '<b><i>Hello there, guest!</i></b>';
		}
	?>
</div>
<ul>
<?php
	if(!isset($_SESSION['logged']) || $_SESSION['logged'] == false){
		echo '<li><a href="/">Log In</a></li>';
		echo '<li><a href="/register.php">Register</a></li>';
	}
	else if($_SESSION['type']=='practicum coordinator'){
		$newRequirements = 0;

		$query = "SELECT COUNT(application_id) AS newForms FROM practicum_application AS PA INNER JOIN group_member ON student=username WHERE group_id = {$_SESSION['group_id']} AND PA.status = 'pending'";

		$queryResult = $DBMaster->querySelect($query);

		if(is_array($queryResult) && count($queryResult))
			$newRequirements = $queryResult[0]['newForms'];

		echo '<li><a href="requirements.php">Submissions';
		if($newRequirements != 0)
			echo '<span class="pt-newrequirementscount">'.$newRequirements.'</span>';
		echo '</a></li>';
		echo '<li><a href="groupmember.php">Group Members</a></li>';
		echo '<li><a href="linkageofficers.php">Linkage Officers</a></li>';
		//echo '<li><a href="groupmember.php">Practicum Directory</a></li>';
		echo '<li><a href="practicumoverview.php">Practicum Overview</a></li>';
	}
	else if($_SESSION['type']=='student'){
		/*echo '<li><a href="/">Student Profile</a></li>'; */
		echo '<li><a href="requirements.php">Requirements</a></li>';
		echo '<li><a href="searchgroup.php">Find Group</a></li>';

	}
	else if($_SESSION['type']=='linkage officer'){
		$newRequirements = 0;

		$query = "SELECT COUNT(application_id) AS newForms FROM practicum_application AS PA INNER JOIN group_member ON student=username WHERE group_id = {$_SESSION['group_id']} AND PA.status = 'pending'";

		$queryResult = $DBMaster->querySelect($query);

		if(is_array($queryResult) && count($queryResult))
			$newRequirements = $queryResult[0]['newForms'];

		echo '<li><a href="requirements.php">Submissions';
		if($newRequirements != 0)
			echo '<span class="pt-newrequirementscount">'.$newRequirements.'</span>';
		echo '</a></li>';
		echo '<li><a href="assignedstudents.php">Assigned Students</a></li>'; 
		echo '<li><a href="searchgroup.php">Find Group</a></li>';
	}
	
?>
<li><a href="/help.php">Help</a>
</ul>

<?php	
	/*if($_SESSION['type']=='practicum coordinator'){
		echo '<ul>';
		echo '<li class="menutitle">Other Features</li>';
		echo '<li><a href="/">Practicum Directory</a></li>';
		echo '<li><a href="/">Overall Summary</a></li>';
	    echo '</ul>';
	}*/
?>
</div>