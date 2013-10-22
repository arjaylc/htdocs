
<div id="pt-contentbox" class="rounded-small">
	<h1 id="pt-contentheader">Online Student Requirements</h1>
<?php
	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();
	$userType = $_SESSION['type'];
	$username = $DBMaster->escapeString($_SESSION['username']);

	$userHasGroup = $DBMaster->checkUserHasGroup($username, $userType);

	if($userHasGroup && is_bool($userHasGroup)){
?>
	<table id="pt-requirements" cellspacing="0">
		<tr class="pt-reqheader"><td>Requirement</td><td>Status</td></tr>
		<tr>
			<td>
			<a href="project_submission.php">Company Application Form</a>
			</td>
			<td>
			<?php
				$query = "SELECT application_id, status FROM practicum_application WHERE student = '$username'";

				$queryResult = $DBMaster->querySelect($query);

				if(is_array($queryResult) && !count($queryResult))
					echo 'No Submission';
				else if(is_array($queryResult) && count($queryResult)){
					echo ucwords($queryResult[0]['status']);
				}
				else echo 'Error occurred';
			?>
			</td>
		</tr>
		<tr>
			<td>
				<?php
				     $query1 = "select status from group_member g inner join practicum_application p on g.username = p.student where g.username = '$username';";
				     $result =  $DBMaster->querySelect($query1);
				     if((is_array($result) && !count($result))||$result[0]['status']=='pending'||$result[0]['status']=='denied'){
                                        echo "Practicum Evaluation Form";
                                     }
                                     else{
                                       echo"<a href='studentevaluation.php'>Practicum Evaluation Form</a>";
                                     }
				?>

			</td>
			<td>
				<?php
					$query = "SELECT COALESCE(submitter, 'none') AS status FROM group_member INNER JOIN user USING(username) LEFT JOIN eval_essay ON submitter = username WHERE username = '{$_SESSION['username']}'";

					$queryResult = $DBMaster->querySelect($query);

					if(is_array($queryResult) && !count($queryResult))
						echo 'No Submission';
					else if(is_array($queryResult) && count($queryResult)){
						$status = $queryResult[0]['status'];
						if($status == 'none')
							echo 'No Submission';
						else echo 'Confirmed';
					}
					else echo 'Error occurred';
				?>
			</td>
		</tr>
		<tr>
			<td>
				<a href="javascript:void(0);">Electronic Appraisal Form <br/><i>(Will be sent to your technical supervisor)</i></a>
				<!--<a href="performanceappraisal.php">Electronic Appraisal Form</a>-->
			</td>
			<td>
				<?php
					$query = "SELECT COALESCE(student, 'none') AS status FROM group_member INNER JOIN user USING(username) LEFT JOIN appraisal_rating_summary ON student = username WHERE username = '{$_SESSION['username']}'";
					$queryResult = $DBMaster->querySelect($query);

					if(is_array($queryResult) && !count($queryResult))
						echo 'No Submission';
					else if(is_array($queryResult) && count($queryResult)){
						$status = $queryResult[0]['status'];
						if($status == 'none')
							echo 'No Submission';
						else echo 'Confirmed';
					}
					else echo 'Error occurred';
				?>
			</td>
		</tr>
	</table>
<?php
	}
	else if(!$userHasGroup && is_bool($userHasGroup))
		$pageMaster->displayNoGroupMessages($userType);
	else $pageMaster->displayErrorMessage();
?>
</div>