<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-contentheader">Linkage Officer Assignment</h1>
<div class="pt-notice rounded-small" style="display:none;">
</div>
<div class="pt-errornotice" style="display:none;"></div>
<?php
	$DBMaster = new DatabaseMaster();

	$query = "SELECT DISTINCT companyname, CONCAT(building, ', ', city) AS city, city AS boom, a.company_id AS companyID
	FROM practicum_application AS a
	INNER JOIN company USING(company_id) 
	INNER JOIN group_member ON student = username
	WHERE group_id = {$_SESSION['group_id']}
	ORDER BY city, companyname";

	$queryResult = $DBMaster->querySelect($query);

	if(is_array($queryResult) && count($queryResult)){
		$companyArray = array();
		$companyIDs = array();
		$companyCity = array();

		foreach($queryResult AS $company){
			$companyArray[$company['city']] = $company['companyname'];
			$companyCity[$company['city']] = $company['boom'];
			$companyIDs[$company['companyname']] = $company['companyID'];
		}

		$query = "SELECT CONCAT(firstname, ' ', lastname) AS fullname, address, username FROM group_member INNER JOIN user USING(username) WHERE type = 'linkage officer' AND group_id={$_SESSION['group_id']}";

		$queryResult = $DBMaster->querySelect($query);

		if(is_array($queryResult) && count($queryResult)){
			$linkageArray = array();

			foreach($queryResult AS $officer){
				$linkageArray[$officer['username']] = $officer['fullname'];
				$linkageArrayAddress[$officer['username']] = $officer['address'];
			}

			$companyCount = 0;
			foreach($companyArray AS $city => $company){
				echo '<div id="pt-searchresults-holder">';
				echo '<div class="pt-searchresult pt-confirmed pt-margined-bottom" style="border:1px solid #aaa;">';
				if(!empty($company)){
					echo '<h1 class="pt-mini-header">'.$company.'</h1>';
					echo "<i>$city</i>";
				}
				else {
					echo '<h1 class="pt-mini-header">No companies</h1>';
				}
				echo '</div>';

				echo '<div class="pt-searchresult">';
				$companyCount++;
				echo '<table>';
				foreach($linkageArray AS $username => $fullName){
					echo '<tr>';
					$query = "SELECT username FROM linkageofficer_company INNER JOIN company USING(company_id) WHERE username='$username' AND companyname = '$company'";

					$checkLO = $DBMaster->querySelect($query);
					$checked = false;
					if(is_array($checkLO) && count($checkLO))
						$checked = true;
					echo '<td>';
					if($checked == true)
						echo '<input data-assignedto="'.$companyCity[$city].'" data-query="remove" class="pt-lo" data-city="'.$linkageArrayAddress[$username].'" data-company-id="'.$companyIDs[$company].'" type="checkbox" id="'.$username.$companyCount.'" value="'.$username.'" checked="checked">';
					else
						echo '<input data-assignedto="'.$companyCity[$city].'"  data-query="add" class="pt-lo" data-city="'.$linkageArrayAddress[$username].'" data-company-id="'.$companyIDs[$company].'" type="checkbox" id="'.$username.$companyCount.'"  value="'.$username.'">';
					echo '</td>';
					echo '<td>';
					echo '<label style="display:block;" for="'.$username.$companyCount.'"><span class="lo-name">'.$fullName.'</span><br/><span style="font-size:11px;font-style:italic;">'.$linkageArrayAddress[$username].'</span></label>';
					echo '</td>';
					echo '</tr>';
				}
				echo '</table>';
				echo '</div>';
				echo '</div>';
			}

		}
		else{
			echo '<h2 class="pt-oops">Oops! There are still no linkage officers.</h2>';
			echo 'It seems like no linkage officer has joined the group you created yet.';
		}

	}
	else if(is_array($queryResult) && !count($queryResult)){
		echo '<h2 class="pt-oops">There are still no companies available.</h2>';
		echo 'It seems like your students haven\'t applied for a company yet.';
	}
	else{
		$pageMaster = new PageMaster();
		$pageMaster->displayErrorMessage();
	}
?>

<script>
	$(document).ready(initializeAJAX);

	function initializeAJAX(){
		$(".pt-lo").click(startUpdate);
	}

	function startUpdate(){
		var button = $(this);
		var companyID = $(this).attr('data-company-id');
		var username = $(this).val();
		var fullname = $(this).parent().parent().find('.lo-name').text();
		var flag = $(this).attr('data-query');
		var loCity = $(this).attr('data-city');
		var assignedTo = $(this).attr('data-assignedto');

		if(loCity != assignedTo && flag == 'add'){
			var proceed = confirm(fullname + " ("+loCity+") doesn't come from "+assignedTo+".\nDo you want to make this assignment?");
			if(proceed == false){	
				$(this).removeAttr('checked');	
				return 0;
			}

		}

		$(this).attr('disabled', 'disabled');


		

		if(flag == 'add')
			$(this).attr('data-query', 'remove');
		else $(this).attr('data-query', 'add');
		
		$.post("ajax/assignlinkageofficer.php", {'companyID':companyID, 'username':username, 'flag':flag}, function(data, textStatus){
			if(textStatus == 'success'){
				if(data != 'error'){
					$(".pt-notice").hide();
					$(".pt-errornotice").hide();
					if(flag == 'add')
						$(".pt-notice").html('<b>Update successful!</b><br/>Linkage officer was assigned!');
					else $(".pt-notice").html('<b>Update successful!</b><br/>Linkage officer was removed!');
					$(".pt-notice").show();
				}
				else $(".pt-errornotice").html('<b>An error occured!</b><br/>Please try again.');
			}
			else $(".pt-errornotice").html('<b>An error occured!</b><br/>Please try again.');
			$(button).removeAttr('disabled');
		});
	}

	function displayNotice(){
		
	}
</script>
</div>