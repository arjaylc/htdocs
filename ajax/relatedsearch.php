<?php
	include('../includes/classes_DatabaseMaster.inc.php');
	$DBMaster = new DatabaseMaster();

	$searchString = trim($_GET['searchstring']);
	$escapedString = $DBMaster->escapeString($searchString);

	$searchFlag = $_GET['searchflag'];
	$likeCharArray = array();

	for($ctr = 0; $ctr < strlen($searchString); $ctr++){
		$likeCharArray[]=$searchString[$ctr];
		$likeCharArray[]='%';
		
	}

	$likeString = implode($likeCharArray);

	switch($searchFlag){
		case 'companyname': $query = "SELECT company_id, companyname AS name, city, street, floor_unit, building, businessline FROM company WHERE companyname LIKE '$likeString' ORDER BY name"; break;
		case 'contactname_noadd':
		case 'contactname': $query = "SELECT name, position, department, email, telnum, COALESCE(faxnum, 'N/A') AS fax FROM contactpersons WHERE name LIKE '$likeString' ORDER BY name"; break; 
		case 'student': $query = "SELECT username, CONCAT(firstname, ' ', lastname) AS name, email FROM user WHERE type='student' AND CONCAT(firstname, ' ', lastname) LIKE '$likeString'"; break;;
	}

	$queryResult = $DBMaster->querySelect($query);

	$formattedData = array();

	$randomNum = time().mt_rand();
	$newCompanyID = sha1($randomNum);

	if($searchFlag == "companyname"){
		if(is_array($queryResult)){
			if(count($queryResult)){
				$returnHTML = '<div data-new-company-id="'.$newCompanyID.'" data-type="new" data-companyname="'.$searchString.'" class="pt-related-result">';
				$returnHTML .= "Add '<b>$searchString</b>' as a new company.";
				$returnHTML .= '</div>';
				$formattedData[] = $returnHTML;
				foreach($queryResult AS $result){
					$returnHTML = '<div data-company-id="'.$result['company_id'].'" data-type="old" data-street="'.$result['street'].'" data-floorunit="'.$result['floor_unit'].'" data-building="'.$result['building'].'" data-businessline="'.$result['businessline'].'" class="pt-related-result">';
					$returnHTML .= '<div class="companyname">'.$result['name'].'</div>';
					$returnHTML .= '<div class="city">'.$result['city'].'</div>';
					$returnHTML .= '</div>';
					$formattedData[] = $returnHTML;
				}	

			}
			else {
				$formattedData[] = 'none';
				$returnHTML = '<div data-new-company-id="'.$newCompanyID.'" data-type="new" data-companyname="'.$searchString.'" class="pt-related-result">';
				$returnHTML .= "Add '<b>$searchString</b>' as a new company.";
				$returnHTML .= '</div>';
				$formattedData[] = $returnHTML;
			}
		} 
		else {
			$formattedData[] = 'error';
			$returnHTML = '<div data-type="error" class="pt-related-result" style="text-align:center;">';
			$returnHTML .= 'An error occurred. Please try again.';
			$returnHTML .= '</div>';
			$formattedData[] = $returnHTML;
		}
	}
	else if($searchFlag == "contactname" || $searchFlag == "contactname_noadd"){
		if(is_array($queryResult)){
			if(count($queryResult)){
				foreach($queryResult AS $result){
					$returnHTML = '<div data-type="old" data-telnum="'.$result['telnum'].'" data-faxnum="'.$result['fax'].'" data-position="'.$result['position'].'" data-department="'.$result['department'].'" class="pt-related-result">';
					$returnHTML .= '<div class="contactname">'.$result['name'].'</div>';
					$returnHTML .= '<div class="email">'.$result['email'].'</div>';
					$returnHTML .= '</div>';
				}	
			}
			else{
				if($searchFlag == "contactname"){
					$returnHTML = '<div data-type="new" data-contactname="'.$searchString.'" class="pt-related-result">';
					$returnHTML .= "Add '<b>$searchString</b>' as a new contact person.";
					$returnHTML .= '</div>';
				}
				else{
					$returnHTML = '<div class="pt-related-result">No contact person found.</div>';
				}
			}
		}
		else {
			$formattedData[] = 'error';
			$returnHTML = '<div data-type="error" class="pt-related-result" style="text-align:center;">';
			$returnHTML .= 'An error occurred. Please try again.';
			$returnHTML .= '</div>';
		}
		$formattedData[] = $returnHTML;
	}
	else if($searchFlag == "student"){
		if(is_array($queryResult)){
			if(count($queryResult)){
				foreach($queryResult AS $result){
					$returnHTML = '<div data-username="'.$result['username'].'" class="pt-related-result">';
					$returnHTML .= '<div class="studentname">'.$result['name'].'</div>';
					$returnHTML .= '<div class="email">'.$result['email'].'</div>';
					$returnHTML .= '</div>';
					
				}	
			}
			else{
				$returnHTML = '<div class="pt-related-result">No student found.</div>';
			}
			$formattedData[] = $returnHTML;
		}
		else {
			$formattedData[] = 'error';
			$returnHTML = '<div data-type="error" class="pt-related-result" style="text-align:center;">';
			$returnHTML .= 'An error occurred. Please try again.';
			$returnHTML .= '</div>';
			$formattedData[] = $returnHTML;
		}
	}

	$JSONData = json_encode($formattedData, JSON_FORCE_OBJECT);
	echo $JSONData;


?>