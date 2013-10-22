<?php
	include('../includes/classes_DatabaseMaster.inc.php');
	$DBMaster = new DatabaseMaster();

	$category = $_GET['category'];
	$category = $DBMaster->escapeString($category);

	$year = $_GET['year'];

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
			GROUP BY YEAR(datecreated) ORDER BY yeardate DESC"; 
			break;
		case 'impact on students': $query = "SELECT (AVG(EI.objectives_clarity) +
			AVG(EI.objectives_met) +
			AVG(EI.organized) +
			AVG(EI.seminars_sufficient) +
			AVG(EI.stcurriculum_preparatory) +
			AVG(EI.adjustability) + 
			AVG(EI.motivation) +
			AVG(EI.challenging) + 
			AVG(EI.work_satisfaction) +
			AVG(EI.company_likeness) + 
			AVG(EI.companyenvironment_exp) +
			AVG(EI.importance) + 
			AVG(EI.career_clarification) + 
			AVG(EI.work_preparedness) + 
			AVG(EI.bestcouse)
			)/15 AS 'result', YEAR(datecreated) AS yeardate,
			CONCAT('Practicum ', YEAR(datecreated)) AS practicum
			FROM eval_impact AS EI
			INNER JOIN group_member ON EI.submitter = username 
			INNER JOIN practicum_group USING(group_id)
			GROUP BY YEAR(datecreated) ORDER BY yeardate DESC"; 
			break;
		case 'academic relevance': $query = "SELECT (AVG(ESA.ALGOCOM) + 
			AVG(ESA.COMPILE) +
			AVG(ESA.WEBDEVE) + 
			AVG(ESA.INTROAI) +
			AVG(ESA.INTRODB) + 
			AVG(ESA.INTROOS) +
			AVG(ESA.INTROSE) +
			AVG(ESA.STELEC1) +
			AVG(ESA.STRESME) +
			AVG(ESA.THEOPRO))/10 AS 'result', YEAR(datecreated) AS yeardate,
			CONCAT('Practicum ', YEAR(datecreated)) AS practicum
			FROM eval_subject_application AS ESA
			INNER JOIN group_member ON ESA.submitter = username 
			INNER JOIN practicum_group USING(group_id)
			GROUP BY YEAR(datecreated) ORDER BY yeardate DESC"; 
			break;
		case 'skill and trait enhancement': $query = "SELECT (AVG(ES.punctuality) + 
			AVG(ES.adaptability) + 
			AVG(ES.creativity) + 
			AVG(ES.initiative) +
			AVG(ES.decision_making) +
			AVG(ES.planning) +
			AVG(ES.time_management) +
			AVG(ES.verbal_communication) + 
			AVG(ES.written_communication) +
			AVG(ES.courteousness) +
			AVG(ES.interpersonal) +
			AVG(ES.cooperation))/12 AS 'result', YEAR(datecreated) AS yeardate,
			CONCAT('Practicum ', YEAR(datecreated)) AS practicum
			FROM eval_skill AS ES
			INNER JOIN group_member ON ES.submitter = username 
			INNER JOIN practicum_group USING(group_id)
			GROUP BY YEAR(datecreated) ORDER BY yeardate DESC"; 
			break;
		case 'general professional skills': $query = "SELECT 
			(AVG(ARS.general_professional_skills) +
			AVG(ARS.technical_skills) +
			AVG(ARS.systems_analysis_skills) +
			AVG(ARS.overall_performance))/4 AS 'result', YEAR(datecreated) AS yeardate,
			CONCAT('Practicum ', YEAR(datecreated)) AS practicum
			FROM appraisal_rating_summary AS ARS
			INNER JOIN group_member ON ARS.student = username 
			INNER JOIN practicum_group USING(group_id)
			GROUP BY YEAR(datecreated)
			ORDER BY yeardate DESC;
			"; break;
		case 'professional skills': $query = "SELECT (
			AVG(APS.productivity) + 
			AVG(APS.quality) +
			AVG(APS.planning) + 
			AVG(APS.timeliness) +
			AVG(APS.knowledge) + 
			AVG(APS.adaptability) +
			AVG(APS.creativity) +
			AVG(APS.initiative) +
			AVG(APS.adherence) +
			AVG(APS.communication_skills) +
			AVG(APS.cooperation) +
			AVG(APS.interpersonal_skills) +
			AVG(APS.decision_making) +
			AVG(APS.problem_solving) +
			AVG(APS.personal_development) +
			AVG(APS.interaction) +
			AVG(APS.attendance))/17 AS 'result', YEAR(datecreated) AS yeardate,
			CONCAT('Practicum ', YEAR(datecreated)) AS practicum
			FROM appraisal_professional_skills AS APS
			INNER JOIN group_member ON APS.student = username 
			INNER JOIN practicum_group USING(group_id)
			GROUP BY YEAR(datecreated) ORDER BY yeardate DESC"; 
			break;
		case 'programming skills': $query = "SELECT (AVG(AGS.knowledge_of_language) + 
			AVG(AGS.knowledge_of_operating) +
			AVG(AGS.program_design) + 
			AVG(AGS.testing_debugging) +
			AVG(AGS.awareness))/5 AS 'result', YEAR(datecreated) AS yeardate,
			CONCAT('Practicum ', YEAR(datecreated)) AS practicum
			FROM appraisal_programming_skills AS AGS
			INNER JOIN group_member ON AGS.student = username 
			INNER JOIN practicum_group USING(group_id)
			GROUP BY YEAR(datecreated) ORDER BY yeardate DESC"; 
			break;
		case 'systems analysis skills': $query = "SELECT (AVG(ASA.business_requirements) +
			AVG(ASA.technical_requirements) + 
			AVG(ASA.estimating) + 
			AVG(ASA.systems_design) +
			AVG(ASA.quality_usability_of_docu) +
			AVG(ASA.project_planning) +
			AVG(ASA.user_satisfaction))/7 AS 'result', YEAR(datecreated) AS yeardate,
			CONCAT('Practicum ', YEAR(datecreated)) AS practicum
			FROM appraisal_systems_analysis_skills AS ASA
			INNER JOIN group_member ON ASA.student = username 
			INNER JOIN practicum_group USING(group_id)
			GROUP BY YEAR(datecreated) ORDER BY yeardate DESC";
			break;
	}

	$queryResult = $DBMaster->querySelect($query);

	$returnData = array();
	$returnData['error'] = false;

	$html = '<div class="pt-search-result">';
	if(is_array($queryResult)){
		if(count($queryResult)){
			$html .= '<b style="font-size:16px;">'.ucwords($category).'</b>';
			$html .= '<ul class="pt-ratings">';
			foreach($queryResult AS $yearlyGraph){
				if($yearlyGraph['yeardate'] == $year)
					$html .= '<li class="pt-selected">';
				else  $html .= '<li>';
				$html .= $yearlyGraph['practicum'];

				$averageRating = number_format($yearlyGraph['result'], 2);
				$percentage = $averageRating / 5;
				$barWidth = 519 * $percentage;

				$html .= '<div class="pt-rating-bar" style="width:'.$barWidth.'px;">';
				$html .= '<div class="pt-rating-avg"><b>'.$averageRating.' </b>/ 5</div>';
				$html .= '</div>';
				$html .= '</li>';
			}
			$html .= '</ul>';
		}
	}
	else{
		$html .= 'An error occurred. Please try again.';
	}

	$html .= '</div>';

	$returnData['output'] = $html;

	$JSON = json_encode($returnData, JSON_FORCE_OBJECT);

	echo $JSON;

?>