<div id="pt-contentbox" class="rounded-small">
	<h1 id="pt-contentheader">ST Practicum Evaluation Form</h1>
<?php
	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();
	$userType = $_SESSION['type'];
	$username = $DBMaster->escapeString($_SESSION['username']);

	$userHasGroup = $DBMaster->checkUserHasGroup($username, $userType);
	
	$query = "SELECT e.submitter AS submitter FROM group_member g LEFT JOIN eval_essay e ON g.username = e.submitter WHERE g.username = '$username'";

    $queryResult = $DBMaster->querySelect($query);
    if(is_array($queryResult) && count($queryResult) && !empty($queryResult[0]['submitter']))
        $continue = false;
    else $continue = true;
	if(isset($_GET['error']) && $_GET['error'] == 'error'){
         echo '<div class="pt-errornotice rounded-small"><b>Sorry for the inconvenience.</b><br/>A system error has occurred. Please try again later.</div>';
    }
    if(isset($_GET['type']) && $_GET['type']=='submit'){
   		echo '<h2 class="pt-oops">Thank you for the submission!</h2>';
		echo 'The form you answered is used to help improve the practicum experience of future Software Technology students. We appreciate every bit of help you offer us.';
    }
    else if(!$continue){
    	echo '<h2 class="pt-oops">You already submitted this form.</h2>';
		echo 'It looks like you already submitted this form at an earlier time. You can only submit the ST Practicum Evaluation Form once.';
    }
	else if($userHasGroup && is_bool($userHasGroup)){
?>
<div class="pt-evalform">
<i>The purpose of the evaluation is:</i>
<ol>
	<li>to evaluate the ST Practicum program;</li>
	<li>to help improve the ST Practicum program;</li>
	<li>to help the ST Department and Practicum program in training ST Students<br> as future IT professional.</li>
</ol>
<i>The evaluator’s honest and fair rating and comments on the ST Practicum program is very essential and much appreciated.</i>

</div>
<div class="clearfix"></div>
<br>
<div id="pt-legend"><hr><center>
	<b>5</b> - Strongly Agree, 
	<b>4</b> - Agree,
	<b>3</b> - Neutral, 
	<b>2</b> - Disagree, 
	<b>1</b> - Strongly Disagree</center>
</div>	
<hr>
<form action="check_studentevaluation.php" method="post">
<?php
	$questionset = [["Course Content and Workload",
						["STPRACT is relevant to the needs of the students.",
		 				"STPRACT is an important requirement to the degree of BSCS-ST",
		 				"Students are well informed of the STPRACT guidelines.",
		 				"The duration of the practicum is too short.",
		 				"STPRACT requirements are clearly defined.",
		 				"The scope of the STPRACT work requirements is appropriate.",
		 				"Deliverables are relevant to the objectives of STPRACT.",
		 				"STPRACT work requirements are too heavy."]],
		 			["Impact on Students",
		 				["The objectives of STPRACT are clear.",
		 				"The objectives of STPRACT are met.",
		 				"STPRACT is well organized and well planned.",
		 				"Enough seminars were given to prepare me for the practicum.",
		 				"I am technically prepared for the practicum because of the courses and requirements in the ST curriculum.",
		 				"With my personal skills and traits, I found it easy to adjust or adapt to the work and industry environment.",
		 				"I am motivated to work hard during the practicum.",
		 				"The practicum has aroused my curiosity and challenged me intellectually.",
		 				"I am satisfied with my work.",
		 				"I liked the company assigned to me.",
		 				"I was able to experience an actual company environment.",
		 				"I feel the value or importance of the practicum.",
		 				"The practicum helped me in clarifying possible career paths.",
		 				"After having an idea of how it is to work in the industry, I can say that I am prepared to work immediately after graduation",
		 				"STPRACT is one of the best courses I have had here at DLSU."]]
	 				];
	 $groupletter ='a';
	 $groupletter = makeTable($questionset, $groupletter);
?>
<hr>
	<div id="pt-lowlegend"><center><b>5</b> - Highest &nbsp&nbsp&nbsp <b>1</b> - lowest</center></div>	
<hr>
<?php
	$questionset = [["Rate each of the ff. subjects as to how much you were able to apply them in the practicum.",
						["ALGOCOM",
		 				"COMPILE",
		 				"WEBDEVE",
		 				"INTROAI",
		 				"INTRODB / ADVANDB",
		 				"INTROOS / ADVANOS",
		 				"INTROSE / ADVANSE",
		 				"STELEC1",
		 				"STRESME",
		 				"THEOPRO"]],
		 			["Rate each of the ff. skills and traits as to how well you were able to enhance them through the practicum.",
		 				["Punctuality",
		 				"Adaptability to Assigned Environment",
		 				"Creativity / Resourcefulness",
		 				"Initiative",
		 				"Decision Making Skills",
		 				"Planning and Organization",
		 				"Time Management Skills",
		 				"Verbal Communication Skills",
		 				"Written Communication Skills",
		 				"Courteousness",
		 				"Interpersonal Skills",
		 				"Teamwork and Cooperation"]]
	 				];

	 $groupletter = makeTable($questionset, $groupletter);
?>
<hr>
	1. What new things were you able to learn during the practicum?
	<textarea class="pt-eval rounded-small" name="question1"></textarea>
	2. What topic / courses / requirements / trainings / seminars should be included in the curriculum to prepare the students for practicum?
	<textarea class="pt-eval rounded-small" name="question2"></textarea>
	3. If you are to be given a chance to modify the SITE policies, procedure and guidelines, what particular items do you wish to change and why?
	<textarea class="pt-eval rounded-small" name="question3"></textarea>
	4. How would you evaluate the Practicum Coordinator? (e.g. Availability, Guidance, Communication, etc.)
	<textarea class="pt-eval rounded-small" name="question4"></textarea>
	5. Comment / Suggestions:
	<textarea class="pt-eval rounded-small" name="question5"></textarea>

	<br>
	<div align="right"><input id="submitForm" class="rounded-small" type="submit" value="Submit"/></div>

<?php
	}
	else if(!$userHasGroup && is_bool($userHasGroup))
		$pageMaster->displayNoGroupMessages($userType);
	else $pageMaster->displayErrorMessage();
?>
</form>
</div>

<script>

$(document).ready(initializeChecker);
function initializeChecker(){
	$("#submitForm").click(function(event){
		var tableRows = $("tr");
		var errors = 0;
		for(var ctr = 0; ctr < tableRows.length; ctr++){

			var radioButtons = $(tableRows[ctr]).find("input:radio");
			if(radioButtons.length == 5){	
				var radioChecked = 0;
				for(var ctr2 = 0; ctr2 < radioButtons.length; ctr2++){
					if(radioButtons[ctr2].checked)
						radioChecked++;
				}

				if(radioChecked == 0){
					$(tableRows[ctr]).off();
					$(tableRows[ctr]).addClass('error');
					$(tableRows[ctr]).on('click', function(event){
						$(this).off();
						$(this).removeClass('error');
					});
					errors++;
				}
			}

		}
		if(errors != 0){
			event.preventDefault();
			return false;
		}

	});
}
</script>

<?php
function makeTable($questionset, $groupletter)
{
	foreach ($questionset as $title) {
	    ?>
	    <table class="pt-evalform" cellspacing="0">
	        <tr class="pt-reqheader"><td></td><td><center><?= $title[0] ?></center></td>
	                <td>5<br><td>4<br><td>3<br><td>2<br><td>1<br>
                    </tr>
                    <?php
	                 $index = 1;
                         foreach($title[1] as $question){
                             ?>
	                     <tr>
	                         <td><?php echo ($index).'.' ?></td>
	                         <td><?php echo $question ?></td>
	                         <?php
	                             for($i = 5; $i >= 1; $i--){
					?>
					<td>
					<input type="radio" name="<?php echo 'group'.$groupletter.$index ?>" value="<?php echo $i; ?>"></td>
					<?php
					     }
					?>
					</tr>
					<?php
					     $index++;
					}
	?>
		</table> 
		<?php
		$groupletter++;
	}
	return $groupletter;
}
?>