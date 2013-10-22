<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-contentheader">Linkage Officers </h1>

	<?php
	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();
	$userType = $_SESSION['type'];
	$username = $DBMaster->escapeString($_SESSION['username']);
	$userHasGroup = $DBMaster->checkUserHasGroup($username, $userType);

	$query = "SELECT CONCAT(lastname, ', ', firstname) AS fullName, email, ";
	if(isset($_GET['sort']) && $_GET['sort'] == 'company')
		$query .= " companyname, COALESCE(city, 'zzzz') as city ";
	else $query .= " GROUP_CONCAT(companyname ORDER BY companyname ASC SEPARATOR '~xXx~') AS companyname "; 
	$query .= "FROM group_member 
	LEFT JOIN user USING(username) 
	LEFT JOIN linkageofficer_company USING(username)
	LEFT JOIN company USING(company_id)
	WHERE group_id = {$_SESSION['group_id']} 
	AND type = 'linkage officer'";

	if(isset($_GET['sort']) && $_GET['sort'] == 'company')
		$query .= " ORDER BY city, companyname, lastname";
	else $query .= " GROUP BY username ORDER BY lastname, companyname";

	$queryResult = $DBMaster->querySelect($query);

	if(is_array($queryResult) && count($queryResult) && $queryResult[0]['fullName']){
		echo '<a href="linkageofficers.php">View by Linkage Officer</a> | 
		<a href="linkageofficers.php?sort=company">View by Company</a> | 
		<a href="linkageassignment.php">Assign Linkage Officers</a>';
		
		if(isset($_GET['sort']) && $_GET['sort'] == 'company'){
			$oldCompanyArray = array();
			$uniqueCompanyArray = array();
			$companyCityArray = array();

			foreach($queryResult AS $row){
				$oldCompanyArray[] = $row['companyname'];
				$companyCityArray[$row['companyname']] = $row['city'];
			}

			$uniqueCompanyArray = array_unique($oldCompanyArray);

			foreach($uniqueCompanyArray AS $company){
				echo '<div id="pt-searchresults-holder">';
			
				if(!empty($company)){
					echo '<div class="pt-searchresult pt-confirmed pt-margined-bottom" style="border:1px solid #aaa;">';
					echo '<h1 class="pt-mini-header">'.$company.'</h1>';
					echo "<i>$companyCityArray[$company]</i>";
					echo '</div>';
				}
				else {
					echo '<div class="pt-searchresult pt-rejected pt-margined-bottom" style="border:1px solid #aaa;">';
					echo '<h1 class="pt-mini-header">No companies</h1>';
					echo '</div>';
				}
				

				foreach($queryResult AS $row){
					
					if($row['companyname'] == $company){
						echo '<div class="pt-searchresult">';
						echo $row['fullName'].'<br/>';
						echo '</div>';
					}
				}
				echo '</div>';
			}
		}
		else{
			echo '<div id="pt-searchresults-holder">';
			foreach($queryResult AS $key=>$row){
				echo '<div class="pt-searchresult">'; 
				echo '<div class="">'.($key+1).'.) '.$row['fullName'].'</div>';
				echo '<div class="">'.$row['email'].'</div>';
				echo '<div class="">Companies Assigned: <br/>';
				$companyArray = explode('~xXx~', $row['companyname']);
				echo '<ul style="list-style-type:square; margin:0; padding: 0 0 0 25px;">';
				if(count($companyArray) && !empty($companyArray[0])){
					
					foreach($companyArray AS $company)
						echo "<li>".$company."</li>";
				}
				else{
					echo '<li>No companies assigned yet.</li>';
				}
				echo '</ul>';
				echo '</div>';
				echo '</div>';
			}
			echo '</div>';
		}
		
		
	}
	else if(is_array($queryResult) && !count($queryResult)){
		echo '<h2 class="pt-oops">Oops! There are still no linkage officers.</h2>';
		echo 'It seems like no linkage officer has joined the group you created yet.';
	}
	else{
		echo '<h2 class="pt-oops">Oops! There are still no linkage officers.</h2>';
		echo 'It seems like no linkage officer has joined the group you created yet.';
	}
	?>

</div>