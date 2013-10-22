<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-contentheader">Appraisal Form Submissions</h1>

<?php
	$DBMaster = new DatabaseMaster();
	$username = $DBMaster->escapeString($_SESSION['username']);

	$query = "SELECT CONCAT(firstname, ' ', lastname) AS submittedBy, username, COALESCE(student, 'none') AS status FROM group_member INNER JOIN user USING(username) LEFT JOIN appraisal_rating_summary ON student = username WHERE group_id={$_SESSION['group_id']} AND type='student'";

	$queryResult = $DBMaster->querySelect($query);

	if(is_array($queryResult) && count($queryResult)){
		$submitted = array();
		$noSubmissions = array();

		foreach($queryResult as $row){
			switch($row['status']){
				case 'none': $noSubmissions[ucwords($row['submittedBy'])] = $row; break;
				default: $submitted[ucwords($row['submittedBy'])] = $row; break;
			}
		}

		/*THIS PART IS FOR THE CONFIRMED SUBMISSION LIST*/

		echo '<div class="pt-searchresults-holder">';
		echo '<div class="pt-searchresult pt-confirmed pt-margined-bottom">';
		echo '<h1 class="pt-mini-header">Submitted Forms ('.count($submitted).')</h1>';
		echo '<div class="pt-toggle-notice">Click to show/hide</div>';
		echo '</div>';
		echo '<div class="confirmedsubmissions">';
		if(empty($submitted)){
			echo '<div class="pt-searchresult">';
			echo 'No one has submitted yet.';
			echo '</div>';
		}
		else{
			ksort($submitted);
			
			foreach($submitted AS $submission){
				echo '<div class="pt-searchresult">';
				echo '<div class="">'.$submission['submittedBy'].'</div>';
				//echo '<div class=""><b>Date Submitted</b>: '.$submission['datepassed'].'</div>';
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