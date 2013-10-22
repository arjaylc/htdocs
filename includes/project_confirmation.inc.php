<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-contentheader">Company Details Submissions</h1>

<?php
	$DBMaster = new DatabaseMaster();
	$username = $DBMaster->escapeString($_SESSION['username']);

	$query = "SELECT CONCAT(firstname, ' ', lastname) AS submittedBy, username, pa.application_id, company_id, DATE_FORMAT(application_date, '%M %e, %Y') AS datepassed, companyname, COALESCE(status, 'cancelled') AS status, businessline, 
	floor_unit, street, building, city,
	project_title, project_description, project_output, project_num_students, project_duration,
	contacts.hr_name,
	(
		SELECT department FROM contactpersons WHERE name = contacts.hr_name
	) AS hr_department,
	(
		SELECT position FROM contactpersons WHERE name = contacts.hr_name
	) AS hr_position,
	(
		SELECT email FROM contactpersons WHERE name = contacts.hr_name
	) AS hr_email,
	(
		SELECT telnum FROM contactpersons WHERE name = contacts.hr_name
	) AS hr_telnum,
	(
		SELECT COALESCE(faxnum, 'N/A') FROM contactpersons WHERE name = contacts.hr_name
	) AS hr_faxnum,
	contacts.ts_name,
	(
		SELECT department FROM contactpersons WHERE name = contacts.ts_name
	) AS ts_department,
	(
		SELECT position FROM contactpersons WHERE name = contacts.ts_name
	) AS ts_position,
	(
		SELECT email FROM contactpersons WHERE name = contacts.ts_name
	) AS ts_email,
	(
		SELECT telnum FROM contactpersons WHERE name = contacts.ts_name
	) AS ts_telnum,
	(
		SELECT COALESCE(faxnum, 'N/A') FROM contactpersons WHERE name = contacts.ts_name
	) AS ts_faxnum
	FROM practicum_application AS pa
	LEFT JOIN company USING(company_id)
	LEFT JOIN practicum_application_project USING(application_id)
	LEFT JOIN practicum_application_contacts AS contacts USING(application_id)
	RIGHT JOIN group_member ON student = username 
	LEFT JOIN user USING(username)
	WHERE group_id = {$_SESSION['group_id']}
	AND type = 'student'
	ORDER BY application_date DESC";

	$queryResult = $DBMaster->querySelect($query);

	if(is_array($queryResult) && count($queryResult)){
		$pendingSubmissions = array();
		$confirmedSubmissions = array();
		$rejectedSubmissions = array();
		$noSubmissions = array();

		
		foreach($queryResult as $row){
			switch($row['status']){
				case 'pending': $pendingSubmissions[] = $row; break;
				case 'confirmed': $confirmedSubmissions[$row['submittedBy']] = $row; break;
				case 'denied': 
				case 'cancelled': $noSubmissions[ucwords($row['submittedBy'])] = $row; break;
			}
		}

		if(isset($_GET['success']) && $_GET['success'] == 'false'){
			echo '<div class="pt-errornotice rounded-small"><span class="pt-error-title">Sorry for the inconvenience.</span><br/>A system error has occurred. Please try again later.</div>';
		}
		if(isset($_GET['success']) && $_GET['success'] == 'true'){
			echo '<div id="pt-projectlastupdate"  class="rounded-small"><b>Project confirmation successful!</b><br/>';
			echo 'The project you chose was successfully confirmed or rejected.</div>';
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

				echo '<div class=""><b>Student</b>: '.$submission['submittedBy'].'</div>';
				echo '<div class=""><b>Date Submitted</b>: '.$submission['datepassed'].'</div>';
				echo '<b>Submission Details</b>';
				echo '<div class="pt-projectdetails">';
				echo '<div>Company: '.$submission['companyname'].'</div>';
				echo '<div>Supervisor: '.$submission['ts_name'].'</div>';
				echo '<div>Project Name: '.$submission['project_title'].'</div>';
				echo '<div>Description: '.$submission['project_description'].'</div>';
				echo '<div>Output: '.$submission['project_output'].'</div>';
				echo '<div>No. of Students: '.$submission['project_num_students'].'</div>';



                                echo '<form action="confirmproject.php" method="get">';
                                echo '<input type="hidden" value="'.$submission['application_id'].'" name="project_id">';
                                echo '</div>';
  	                        echo '<div>Comments: <textarea class="pt-eval rounded-small" name="comment"></textarea>';
                                echo '</div>';
                                echo '<input type="submit" name="flag" value="Confirm Project"/>';
                                echo '<input type="submit" name="flag" value="Reject Project"/>';
                                echo '</form>';
				#echo '<br/><a href="confirmproject.php?project_id='.$submission['application_id'].'&status=confirmed&comment = '.$_GET['comment'].'>Confirm Project</a>';
				#echo '<br/><a href="confirmproject.php?project_id='.$submission['application_id'].'&status=denied&comment = '.$_GET['comment'].'>Reject Project</a>';
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
				echo '<div data-expanded="false" data-username="'.$submission['username'].'" class="pt-confirmed-applications pt-searchresult">';
				echo '<div>'.$submission['submittedBy'].'</div>';
				//echo '<div class=""><b>Date Submitted</b>: '.$submission['datepassed'].'</div>';
				echo '<div class="sub-details"></div>';
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
				echo $submission['submittedBy'];
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
$(document).ready(initializeHandling);

function initializeHandling(){
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

	$(".pt-confirmed-applications").click(retrieveDetails);
}

function retrieveDetails(){
	var flag = $(this).attr('data-expanded');

	if(flag == 'false'){
		var username = $(this).attr('data-username');
		var clickedObject = $(this);

		$.getJSON("ajax/getprojectdetails.php", {'username':username}, function (data, textStatus){
			if(textStatus == 'success'){
				if(data['error'] == false){
					$(clickedObject).attr('data-expanded', 'true');
					$(clickedObject).find('.sub-details').html(data['output']);
				}
			}
		});	
	}
	else{
		$(this).find('.sub-details').html('');
		$(this).attr('data-expanded', 'false');
	}
}


</script>
</div>