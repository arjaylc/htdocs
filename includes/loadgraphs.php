<?php
	include('../includes/classes_DatabaseMaster.inc.php');
	$DBMaster = new DatabaseMaster();

	$category = $_GET['category'];
	$category = $DBMaster->escapeString();

	switch($category){
		case 'course content': $query = "SELECT (AVG(EC.relevance) +
			AVG(EC.importance) +
			AVG(EC.informed_guidelines) +
			AVG(EC.duration) +
			AVG(EC.requirement_definition) +
			AVG(EC.requirement_appropriation) +
			AVG(EC.deliverable_relevance) +
			AVG(EC.requirement_heaviness))/8 AS 'result',
			YEAR(datecreated) AS yeardate,
			CONCAT('Practicum ', YEAR(datecreated)) AS practicum
			FROM eval_course_content AS EC
			INNER JOIN group_member ON EC.submitter = username 
			INNER JOIN practicum_group USING(group_id)
			GROUP BY YEAR(datecreated)ORDER BY yeardate DESC "; 
			break;
	}

	$queryResult = $DBMaster->querySelect($query);

	$returnData = array();
	$returnData['error'] = false;

	$html = '<div class="pt-search-result">';
	if(is_array($queryResult)){
		if(count($queryResult)){
			$html '<b style="font-size:16px;">'.ucwords($category).'</b>';
			$html '<ul class="pt-ratings">';
			foreach($queryResult AS $yearlyGraph){
				$html '<li>';
				$html $yearlyGraph['practicum'];

				$averageRating = number_format($yearlyGraph['result'], 2);
				$percentage = $averageRating / 5;
				$barWidth = 519 * $percentage;

				$html = '<div class="pt-rating-bar" style="width:'.$barWidth.'px;">';
				$html = '<div class="pt-rating-avg"><b>'.$averageRating.' </b>/ 5</div>';
				$html = '</div>';
				$html = '</li>';
			}
			$html = '</ul>';
		}
		else{
			$returnData['error'] = true;
		}
	}

	$html = '</div>';

	$returnData['output'] = $html;

	$JSON = json_encode($returnData, JSON_FORCE_OBJECT);

	echo $JSON;

?>