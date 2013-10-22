<div id="pt-navigationmenu" class="rounded-small">

<div class="greetings">
	<img src="images/thumb_pc.png" alt="Practicum Coordinator"/>
	<?php 
		$DBMaster = new DatabaseMaster();
		$username = $DBMaster->escapeString($_SESSION['username']);
		$query="SELECT CONCAT(firstname, ' ', lastname) AS fullname, type FROM user WHERE username='$username'";

		$queryResult = $DBMaster->querySelect($query);
		echo '<b>'.$queryResult[0]['fullname'].'</b>';
		echo '<br/>';
		echo '<span class="usertype">'.ucwords($queryResult[0]['type']).'</span>';
	?>
</div>
<ul>
<li class="menutitle">Group Menu</li>
<li><a href="/">Group Activity</a></li>
<?php
	if($_SESSION['type']=='practicum coordinator'){
		$newRequirements = 0;


		$pendingProjectsCount = $DBMaster->getPendingProjectsCount($username);
		$newRequirements += $pendingProjectsCount;

		

		$pendingCompanySubmission = $DBMaster->getPendingCompanyFormCount($username);
		$newRequirements += $pendingCompanySubmission;

		echo '<li><a href="requirements.php">Submissions';
		if($newRequirements != 0)
			echo '<span class="pt-newrequirementscount">'.$newRequirements.'</span>';
		echo '</a></li>';
		echo '<li><a href="groupmember.php">Group Members</a></li>';
		//echo '<li><a href="/">Linkage Officers</a></li>';
	}
	else if($_SESSION['type']=='student'){
		/*echo '<li><a href="/">Student Profile</a></li>'; */
		echo '<li><a href="requirements.php">Requirements</a></li>';
		echo '<li><a href="searchgroup.php">Find Group</a></li>';
		echo '<li><a href="studentevaluation.php">Evaluation Form</a></li>';
	}
	else if($_SESSION['type']=='linkage officer'){
		echo '<li><a href="/">Assigned Students</a></li>'; 
		echo '<li><a href="requirements.php">Requirements</a></li>';
	}
	
?>
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