<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-contentheader">Practicum Overview</h1>
	<?php
	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();
	$userType = $_SESSION['type'];
	$username = $DBMaster->escapeString($_SESSION['username']);
	$userHasGroup = $DBMaster->checkUserHasGroup($username, $userType);

	$query ="SELECT
	CONCAT('Practicum Students Overview ', YEAR(datecreated)) AS practicum_name,
	CONCAT(YEAR(datecreated), ' ') AS year,
	(AVG(AR.general_professional_skills) +
        AVG(AR.technical_skills) +
        AVG(AR.system_analysis_skills) +
        AVG(AR.overall_skills))/4 AS 'Rating Summary',
        (AVG(AP.productivity) +
        AVG(AP.quality) +
        AVG(AP.planning) +
        AVG(AP.timeliness) +
        AVG(AP.knowledge) +
        AVG(AP.adaptability) +
        AVG(AP.creativity) +
        AVG(AP.initiative) +
        AVG(AP.adherence) +
        AVG(AP.communication_skills) +
        AVG(AP.cooperation) +
        AVG(AP.interpersonal_skills) +
        AVG(AP.decision_making) +
        AVG(AP.problem_solving) +
        AVG(AP.personal_development) +
        AVG(AP.interaction) +
        AVG(AP.attendance))/17 AS 'General Professional Skills',
        (AVG(AG.knowledge_of_language) +
        AVG(AG.knowledge_of_operating) +
        AVG(AG.program_design) +
        AVG(AG.testing_debugging) +
        AVG(AG.awareness))/5 AS 'Programming Skills',
        (AVG(AA.business_requirements) +
        AVG(AA.technical_requirements) +
        AVG(AA.estimating) +
        AVG(AA.systems_design) +
        AVG(AA.quality_usability_of_docu) +
        AVG(AA.project_planning) +
        AVG(AA.user_satisfaction))/7 AS 'Systems Analysis Skills'
	FROM evaluator_information AS EI
	INNER JOIN group_member ON EI.student = username
	INNER JOIN practicum_group USING(group_id)
	INNER JOIN appraisal_rating_summary AS AR ON AR.student = username
	INNER JOIN appraisal_professional_skills AS AP ON AP.student = username
	INNER JOIN appraisal_programming_skills AS AG ON AG.student = username
        INNER JOIN appraisal_systems_analysis_skills AS AA ON AA.student = username
	GROUP BY YEAR(datecreated) DESC";

	$queryResult = $DBMaster->querySelect($query);
	if(is_array($queryResult) && count($queryResult) && !empty($queryResult[0]['practicum_name'])){
		foreach($queryResult AS $practicum){
			echo '<div id="pt-searchresults-holder">';
			echo '<div class="pt-searchresult pt-confirmed pt-margined-bottom" style="border:1px solid #aaa;">';
			echo '<h1 class="pt-mini-header">'.$practicum['practicum_name'].'</h1>';
			echo '</div>';
			echo '<div class="pt-searchresult"><b style="font-size:15px;">Student Ratings</b><br/>';
			echo '<ul class="pt-ratings">';
			foreach($practicum AS $label => $rating){
				if(is_numeric($rating)){
					$averageRating = number_format($rating, 2);
					echo '<li data-year="'.trim($practicum['year']).'" data-category="'.strtolower(str_replace(' ', '', $label)).'">';
					echo $label;
					echo ': <b style="font-size:16px;">'.$averageRating.' </b>/ 5';
					echo '<div class="pt-toggle-notice">Click for breakdown</div>';
					echo '</li>';

				}
			}
			echo '</ul>';
			echo '</div>';
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
