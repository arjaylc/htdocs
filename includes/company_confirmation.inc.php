<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-contentheader">Company Details Submissions</h1>

<?php
	$DBMaster = new DatabaseMaster();
	$username = $DBMaster->escapeString($_SESSION['username']);

	$query = "SELECT COALESCE(companySub.status, 'absent') AS subStatus, CONCAT(lastname, ', ', firstname) AS fullName, company_id, emailsupervisor, companypn, companycity,DATE_FORMAT(companySub.datesubmitted, '%b %e, %Y @ %l:%i %p') AS datepassed, 
	(
		SELECT businessname
		FROM project_submission 
		WHERE submitter = companySub.submitter
	) AS businessname,
	( 
		SELECT supervisor
		FROM project_submission
		WHERE submitter = companySub.submitter
	) AS supervisor
	FROM company_submission AS companySub
	RIGHT JOIN group_member ON submitter=username
	LEFT JOIN user USING(username)
	WHERE group_member.group_id=(
		SELECT group_id
		FROM practicum_group
		WHERE group_admin='$username'
	) 
	ORDER BY datesubmitted DESC, lastname";

	$queryResult = $DBMaster->querySelect($query);

	if(is_array($queryResult) && count($queryResult)){
		$pendingSubmissions = array();
		$confirmedSubmissions = array();
		$rejectedSubmissions = array();
		$noSubmissions = array();


		foreach($queryResult as $row){
			switch($row['subStatus']){
				case 'pending': $pendingSubmissions[] = $row; break;
				case 'confirmed': $confirmedSubmissions[$row['fullName']] = $row; break;
				case 'denied': $rejectedSubmissions[ucwords($row['fullName'])] = $row; break;
				case 'absent': $noSubmissions[ucwords($row['fullName'])] = $row; break;
			}
		}


		/*THIS PART IS FOR THE PENDING SUBMISSION LIST*/
		echo '<div class="pt-searchresults-holder">';
		echo '<div class="pt-searchresult pt-pending pt-margined-bottom">';
		echo '<h1 class="pt-mini-header">Pending Submissions ('.count($pendingSubmissions).')</h1>';
		echo '<div class="pt-toggle-notice">Click to show/hide</div>';
		echo '</div>';
		echo '<div class="pendingsubmissions">';
		if(empty($pendingSubmissions)){
			echo '<div class="pt-searchresult">';
			echo 'No pending submissions at this moment.';
			echo '</div>';
		}
		else{

			foreach($pendingSubmissions AS $submission){
				echo '<div class="pt-searchresult">';


				echo '<div class=""><b>Student</b>: '.$submission['fullName'].'</div>';
				echo '<div class=""><b>Date Submitted</b>: '.$submission['datepassed'].'</div>';
				echo '<b>Submission Details</b>';
				echo '<div class="pt-projectdetails">';
				echo '<div class="">Company: '.$submission['businessname'].'</div>';
				echo '<div class="">Company City: '.$submission['companycity'].'</div>';
				echo '<div class="">Company Phone Number: '.$submission['companypn'].'</div>';
				echo '<div class="">Supervisor: '.$submission['supervisor'].'</div>';
				echo '<div class="">Supervisor\'s Email: '.$submission['emailsupervisor'].'</div>';
				echo '</div>';
				echo '<br/><a href="confirmcompany.php?company_id='.$submission['company_id'].'&status=confirmed">Confirm Details</a>';
				echo '<br/><a href="confirmcompany.php?company_id='.$submission['company_id'].'&status=denied">Reject Details</a>';

				echo '</div>';
			}

		}
		echo '</div>';
		echo '</div>';

		/*THIS PART IS FOR THE CONFIRMED SUBMISSION LIST*/

		echo '<div class="pt-searchresults-holder">';
		echo '<div class="pt-searchresult pt-confirmed pt-margined-bottom">';
		echo '<h1 class="pt-mini-header">Confirmed Submissions ('.count($confirmedSubmissions).')</h1>';
		echo '<div class="pt-toggle-notice">Click to show/hide</div>';
		echo '</div>';
		echo '<div class="confirmedsubmissions">';
		if(empty($confirmedSubmissions)){
			echo '<div class="pt-searchresult">';
			echo 'No confirmed submissions.';
			echo '</div>';
		}
		else{
			ksort($confirmedSubmissions);
			
			foreach($confirmedSubmissions AS $submission){
				echo '<div class="pt-searchresult">';
				echo '<div class=""><b>Student</b>: '.$submission['fullName'].'</div>';
				echo '<div class=""><b>Date Submitted</b>: '.$submission['datepassed'].'</div>';
				echo '</div>';
			}
			
		}
		echo '</div>';
		echo '</div>';


		/*THIS PART IS FOR THE REJECTED SUBMISSION LIST*/

		echo '<div class="pt-searchresults-holder">';
		echo '<div class="pt-searchresult pt-rejected pt-margined-bottom">';
		echo '<h1 class="pt-mini-header">Rejected Submissions ('.count($rejectedSubmissions).')</h1>';
		echo '<div class="pt-toggle-notice">Click to show/hide</div>';
		echo '</div>';
		echo '<div class="rejectedsubmissions">';
		if(empty($rejectedSubmissions)){
			echo '<div class="pt-searchresult">';
			echo 'No rejected submissions.';
			echo '</div>';
		}
		else{
			ksort($rejectedSubmissions);
			
			foreach($rejectedSubmissions AS $submission){
				echo '<div class="pt-searchresult">';
				echo '<div class=""><b>Student</b>: '.$submission['fullName'].'</div>';
				echo '<div class=""><b>Date Submitted</b>: '.$submission['datepassed'].'</div>';
				echo '</div>';
			}
			
		}
		echo '</div>';
		echo '</div>';


		/*THIS PART IS FOR THE NO SUBMISSION LIST*/

		echo '<div class="pt-searchresults-holder">';
		echo '<div class="pt-searchresult pt-none pt-margined-bottom">';
		echo '<h1 class="pt-mini-header">No Submissions ('.count($noSubmissions).')</h1>';
		echo '<div class="pt-toggle-notice">Click to show/hide</div>';
		echo '</div>';
		echo '<div class="nosubmissions">';
		if(empty($noSubmissions)){
			echo '<div class="pt-searchresult">';
			echo 'All your students have submitted.';
			echo '</div>';
		}
		else{
			ksort($noSubmissions);
			
			foreach($noSubmissions AS $submission){
				echo '<div class="pt-searchresult">';
				echo $submission['fullName'];
				echo '</div>';
			}
			
		}
		echo '</div>';
		echo '</div>';

	}
	else if(is_array($queryResult) && !count($queryResult)){
		echo '<h2 class="pt-oops">Oops! Looks like there are no pending submissions.</h2>';
		echo 'Try checking back later.';
	}
?>
<script>
$(document).ready(initializeToggling);

function initializeToggling(){
	$(".pt-pending").click(function(){
		$(this).toggleClass('pt-margined-bottom');
		$(".pendingsubmissions").toggle();
	});

	$(".pt-confirmed").click(function(){
		$(this).toggleClass('pt-margined-bottom');
		$(".confirmedsubmissions").toggle();
	});

	$(".pt-rejected").click(function(){
		$(this).toggleClass('pt-margined-bottom');
		$(".rejectedsubmissions").toggle();
	});

	$(".pt-none").click(function(){
		$(this).toggleClass('pt-margined-bottom');
		$(".nosubmissions").toggle();
	});
}
</script>
</div>