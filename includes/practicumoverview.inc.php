<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-contentheader">Practicum Overview</h1>
	<?php
	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();
	$userType = $_SESSION['type'];
	$username = $DBMaster->escapeString($_SESSION['username']);
	$userHasGroup = $DBMaster->checkUserHasGroup($username, $userType);

	/*$query = "SELECT 
	CONCAT('Practicum ', YEAR(datecreated)) AS practicum_name, 
	AVG(relevance) AS relevance,
	AVG(importance) AS importance,
	AVG(informed_guidelines) AS guidelines,
	AVG(duration) AS duration, 
	AVG(requirement_definition) AS requirement_definition,
	AVG(requirement_appropriation) AS requirement_appropriation, 
	AVG(deliverable_relevance) AS deliverable_relevance,
	AVG(requirement_heaviness) AS heaviness
	FROM eval_course_content 
	INNER JOIN group_member ON submitter = username 
	INNER JOIN practicum_group USING(group_id)
	GROUP BY YEAR(datecreated)";*/

	$yearArray = array();

	$currentYear = date('Y');

	$earliestYear = 2000;

	$yearsWithPracticum = 0;

	for($ctr = $currentYear; $ctr >= $earliestYear; $ctr--){
		$query = "SELECT YEAR(datecreated) FROM practicum_group WHERE  YEAR(datecreated) = $ctr";
		
		$queryResult = $DBMaster->querySelect($query);

		if(is_array($queryResult) && count($queryResult)){

			$yearsWithPracticum++;

			echo '<div class="pt-searchresults-holder">';

			echo '<div class="pt-searchresult pt-confirmed pt-margined-bottom" style="border:1px solid #aaa;">';
			echo '<h1 class="pt-mini-header">Practicum '.$ctr.'</h1>';
			echo '</div>';

			$query ="SELECT
			CONCAT('Practicum Program ', YEAR(datecreated)) AS practicum_name, 
			CONCAT(YEAR(datecreated), ' ') AS year, 
			(AVG(EC.relevance) +
			AVG(EC.importance) +
			AVG(EC.informed_guidelines) +
			AVG(EC.duration) +
			AVG(EC.requirement_definition) +
			AVG(EC.requirement_appropriation) +
			AVG(EC.deliverable_relevance) +
			AVG(EC.requirement_heaviness))/8 AS 'Course Content',
			(AVG(EI.objectives_clarity) +
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
			)/15 AS 'Impact on Students',
			(AVG(ESA.ALGOCOM) + 
			AVG(ESA.COMPILE) +
			AVG(ESA.WEBDEVE) + 
			AVG(ESA.INTROAI) +
			AVG(ESA.INTRODB) + 
			AVG(ESA.INTROOS) +
			AVG(ESA.INTROSE) +
			AVG(ESA.STELEC1) +
			AVG(ESA.STRESME) +
			AVG(ESA.THEOPRO))/10 AS 'Academic Relevance',
			(AVG(ES.punctuality) + 
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
			AVG(ES.cooperation))/12 AS 'Skill and Trait Enhancement'
			FROM eval_course_content AS EC
			INNER JOIN group_member ON EC.submitter = username 
			INNER JOIN practicum_group USING(group_id)
			INNER JOIN eval_impact AS EI ON EI.submitter = username
			INNER JOIN eval_subject_application AS ESA ON ESA.submitter = username
			INNER JOIN eval_skill AS ES ON ES.submitter = username
			WHERE YEAR(datecreated) = $ctr
			GROUP BY YEAR(datecreated)";

                        $queryStudents =
                        "SELECT COUNT(*) AS submitters
                        FROM eval_course_content EC
                        INNER JOIN group_member on EC.submitter = username
                        INNER JOIN practicum_group USING(group_id)
                        WHERE YEAR(datecreated) = $ctr
                        GROUP BY YEAR(datecreated)";
                        
                        $queryTotal =
                        "SELECT COUNT(*) AS students
                        FROM group_member g
                        INNER JOIN practicum_group USING(group_id)
                        INNER JOIN user u on u.username = g.username
                        WHERE YEAR(datecreated) = $ctr
                        AND u.type='student'
                        GROUP BY YEAR(datecreated)"  ;
                        
                        $resultStudents = $DBMaster->querySelect($queryStudents);
                        $resultTotal = $DBMaster->querySelect($queryTotal);
                        
                        $students = $resultStudents[0]['submitters'];
                        $total = $resultTotal[0]['students'];

			echo '<div class="ratingbox">';
			echo '<div class="pt-searchresult"><b style="font-size:16px;">Student Experience Ratings ('.$students.'/'.$total.' students) </b><br/>';

			$queryResult = $DBMaster->querySelect($query);
			if(is_array($queryResult) && count($queryResult)){
				foreach($queryResult AS $practicum){
					
					echo '<ul class="pt-ratings">';
					foreach($practicum AS $label => $rating){
						if(is_numeric($rating)){
							$averageRating = number_format($rating, 2);
							$percentage = $averageRating / 5;
							$barWidth = 519 * $percentage;
							$category = strtolower($label);
							echo '<li data-year="'.trim($practicum['year']).'" data-category="'.$category.'">';
							echo $label;
							#echo '<div class="pt-toggle-notice">Click for breakdown</div>';
							echo '<div class="pt-rating-bar" style="width:'.$barWidth.'px;">';
							echo '<div class="pt-rating-avg"><b>'.$averageRating.' </b>/ 5</div>';
							echo '</div>';
							echo '</li>';
							
						}
					}
					echo '</ul>';
					
				}
			}
			else if(is_array($queryResult)){
				echo 'It seems no one has answered the Practicum Evaluation Form yet. Try again later.';
			}
			else if(is_bool($queryResult)){
				echo 'It seems like something went wrong. Please try again.';
			}

			echo '</div>';	

			$query ="SELECT
			CONCAT('Performance Appraisal ', YEAR(datecreated)) AS practicum_name, 
			CONCAT(YEAR(datecreated), ' ') AS year, 
			(AVG(ARS.general_professional_skills) +
			AVG(ARS.technical_skills) +
			AVG(ARS.systems_analysis_skills) +
			AVG(ARS.overall_performance))/4 AS 'General Professional Skills',
			(
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
			AVG(APS.attendance))/17 AS 'Professional Skills',
			(AVG(AGS.knowledge_of_language) + 
			AVG(AGS.knowledge_of_operating) +
			AVG(AGS.program_design) + 
			AVG(AGS.testing_debugging) +
			AVG(AGS.awareness))/5 AS 'Programming Skills',
			(AVG(ASA.business_requirements) + 
			AVG(ASA.technical_requirements) + 
			AVG(ASA.estimating) + 
			AVG(ASA.systems_design) +
			AVG(ASA.quality_usability_of_docu) +
			AVG(ASA.project_planning) +
			AVG(ASA.user_satisfaction))/7 AS 'Systems Analysis Skills'
			FROM appraisal_rating_summary AS ARS
			INNER JOIN group_member ON ARS.student = username 
			INNER JOIN practicum_group USING(group_id)
			INNER JOIN appraisal_professional_skills AS APS ON APS.student = username
			INNER JOIN appraisal_programming_skills AS AGS ON AGS.student = username
			INNER JOIN appraisal_systems_analysis_skills AS ASA ON ASA.student = username
			WHERE YEAR(datecreated)  = $ctr
			GROUP BY YEAR(datecreated)";

			echo '<div class="pt-searchresult"><b style="font-size:16px;">Student Performance Ratings</b><br/>';

			$queryResult = $DBMaster->querySelect($query);
			if(is_array($queryResult) && count($queryResult)){
				foreach($queryResult AS $practicum){
					
					echo '<ul class="pt-ratings">';
					foreach($practicum AS $label => $rating){
						if(is_numeric($rating)){
							$averageRating = number_format($rating, 2);
							$percentage = $averageRating / 5;
							$barWidth = 519 * $percentage;
							echo '<li data-year="'.trim($practicum['year']).'" data-category="'.strtolower($label).'">';
							echo $label;
							#echo '<div class="pt-toggle-notice">Click for breakdown</div>';
							echo '<div class="pt-rating-bar" style="width:'.$barWidth.'px;">';
							echo '<div class="pt-rating-avg"><b>'.$averageRating.' </b>/ 5</div>';
							echo '</div>';
							echo '</li>';
							
						}
					}
					echo '</ul>';
					
				}
			}
			else if(is_array($queryResult)){
				echo 'It seems no one has answered the Performance Appraisal Form yet. Try again later.';
			}
			else if(is_bool($queryResult)){
				echo 'It seems like something went wrong. Please try again.';
			}

			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
		else if(is_bool($queryResult)){
			echo '<h2 class="pt-oops">A system error has occured. Please try again.</h2>';
			echo 'It seems like something went wrong.';
		}
		
		

	}
	?>



</div>
<script>

var serverRequest = null;
var popBox = $(".pt-pop-graphbox");



$(document).ready(initGraphLoader);

function initGraphLoader(){
	$(".pt-ratings li").click(loadGraphs);
	$(".pt-background").click(closePopBoxes);
	$(".pt-confirmed").click(closeYearBoxes);
}

function closeYearBoxes(){
	$(this).toggleClass('pt-margined-bottom');
	var parent = $(this).parent();
	$(parent).find('.ratingbox').toggle();
}

function closePopBoxes(){
	$(this).fadeOut();
	$(popBox).fadeOut(function(){
		$(popBox).css('overflow-y', 'hidden');
	});

}

function loadGraphs(){
	$(".pt-background").fadeIn();
	$(popBox).html('<b>Loading . . .</b>');

	var innerHeight = window.innerHeight/2;
	var innerWidth = window.innerWidth/2;

	var popBoxWidth = $(popBox).width()/2;
	var popBoxHeight = $(popBox).height()/2;

	var newTop = innerHeight - (popBoxHeight+20);
	var newLeft = innerWidth - (popBoxWidth+20);



	$(popBox).css({'top':newTop+'px', 'left':newLeft+'px'});

	var category = $(this).attr('data-category');
	var year = $(this).attr('data-year');

	$(popBox).fadeIn(function(){
		
		if(serverRequest != null){
			serverRequest.abort();
			serverRequest = null;
			$(popBox).hide();
		}

		serverRequest = $.getJSON("ajax/loadgraphs.php", {'category':category, 'year':year}, displayResults);
	});

	
}

function displayResults(data, textStatus){
	if(textStatus == 'success'){
		if(data['error'] == false){
			$(popBox).fadeOut(function(){
				$(popBox).html(data['output']);
				var innerHeight = window.innerHeight/2;
				var innerWidth = window.innerWidth/2;
				var popBoxWidth = $(popBox).width()/2;
				var popBoxHeight = $(popBox).height()/2;

				var newTop = innerHeight - (popBoxHeight+20);
				var newLeft = innerWidth - (popBoxWidth+20);

				$(popBox).css('overflow-y', 'scroll');
				$(popBox).css({'top':newTop+'px', 'left':newLeft+'px'});
				$(popBox).fadeIn();
			});
			
		}
		serverRequest = null;
	}	
}

</script>