<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-contentheader">Performance Appraisal Form</h1>
<?php
	

	if(isset($_GET['error']) && $_GET['error'] == 'error'){
         echo '<div class="pt-errornotice rounded-small"><b>Sorry for the inconvenience.</b><br/>A system error has occurred. Please try again later.</div>';
         }
        if(isset($_GET['type']) && $_GET['type']=='submit'){
            echo '<div class="pt-notice rounded-small"><b>Thank you for your submission!</b><br/></div>';
        }
        else {
?>

		<div class="pt-evalform">
		<form action="check_performanceappraisal.php" method="POST">
			<i>The purpose of the performance appraisal is threefold, namely:</i>
				<ol>
					<li>to evaluate the student-trainee’s performance in the practicum job site;</li>
					<li>to help the student-trainee improve and be better prepared as future IT professional; </li>
					<li>to help DLSU-CCS-ST in training the future IT professionals.</li>
				</ol>

	</div>	

		<i>The evaluator’s honest and fair rating and comments on the student-trainee’s performance are therefore very essential and much appreciated.</i>
		<form action="index.php" method="POST">
<div id="pt-requirementform-holder">

	<fieldset class="pt-fieldset-default rounded-small">
	<legend class="pt-fieldset-legend rounded-small">Evaluator Information</legend>
		<div class="pt-form-section-left">
			Evaluator <span class="pt-formnote">*firstname lastname</span>
			<input class="pt-textfield rounded-small" autocomplete="off" type="text" placeholder="Supervisor" id="decoy-tsname" name="supervisor"/>
			<div id="tsname-related" class="pt-related-search rounded-small">
				<h1 class="pt-related-header">Related Contacts</h1>
				<div id="ts-search-results"></div>
			</div>
		</div>

        <div class="pt-form-section-right">
			Student <span class="pt-formnote">*firstname lastname</span>
			<input class="pt-textfield rounded-small" autocomplete="off" type="text" placeholder="Student" id="decoy-student" name="student"/>
			<input id="student_username" type="hidden" value="" name="student_username"/>
			<div id="sname-related" class="pt-related-search rounded-small">
				<h1 class="pt-related-header">Related Students</h1>
				<div id="s-search-results"></div>
			</div>
		</div>
	</fieldset>
	
	
	
	
	
		<div class="clearfix">
</div>

</div>
<div id="pt-legend"></div>
<div id="pt-legend"></div>
<div id="pt-legend"><hr><center>
	<b>5</b> - Outstanding,
	<b>4</b> - Above Expectation, 
	<b>3</b> - Meets Expectation, 
	<b>2</b> - Unsatisfactory, 
	<b>1</b> - Poor
	<b>N/A</b> - Not Applicable</center>
</div>
<hr>
<?php
	$questionset = [["Rating Summary",
						["General Professional Skills",
		 				"Programming / Technical Skills",
		 				"Systems Analysis Skills",
		 				"Overall Performance Evaluation"]]
	 				];
	 $groupletter = 'a';
	 $groupletter = makeTable($questionset, $groupletter);
?><br>
<?php
	$questionset = [["Section 1: 	Evaluation - General Professional Skills",
						["<u>Productivity</u> - has high personal drive and capacity for work.",
		 				"<u>Quality of work</u> - ability to produce accurate, thorough and neat work.",
		 				"<u>Planning and Organizing</u> - effective at setting priorities, developing a course of action, securing resources and meeting the objectives of a plan.",
		 				"<u>Timeliness of Results</u> - ability to produce results according to schedules and within budget.",
		 				"<u>Knowledge of Technical/Professional Requirements</u> - understands all aspects of his work",
		 				"<u>Adaptability to Assigned Environment</u> - able to adapt to circumstances, open-minded to suggestions.",
		 				"<u>Resourcefulness/Creativity</u> - able to develop different ideas, methods, and alternative solutions to problems.",
		 				"<u>Initiative</u> - able to perform assignments and contribute more than expected with minimal counseling from the supervisor.",
		 				"<u>Adherence to Standards</u> - follows the standards prescribed by the project.",
		 				"<u>Communication Skills</u> - effectively expresses verbal/written thoughts and ideas.",
		 				"<u>Cooperation and Team Work</u> - constructive, cooperative, keen and dedicated; willingness to work as a team member.",
		 				"<u>Interpersonal Skills</u> - effectively interacting with others on all levels.",
		 				"<u>Decision Making</u> - quickly and objectively selecting a solution from two	or more alternatives; exhibits sound judgment",
		 				"<u>Problem solving</u> - able to determine cause of problems and develop effective solutions",
		 				"<u>Personal Development</u> - able to measure own strengths and weaknesses in order to enhance performance and development in meeting organizational goals.",
		 				"<u>Interaction with Senior and User Management</u> - effectively interacting with senior and user management related to the work at hand.",
		 				"<u>Attendance</u> - is regular and punctual in work attendance."]],
		 			["Section 2: 	Evaluation - Programming Skills",
		 				["Knowledge of Programming Language",
		 				"Knowledge of Operating (HW and SW) Environment",
		 				"<u>Program Design</u> - ability to design modules, meet programming standards, observe program maintainability/flexibility and performance, consider ease of debugging.",
		 				"<u>Testing and Debugging</u> - ability to prepare test plane, produce test data, and complete the task within timeframe and budget.",
		 				"Awareness of the relationship between the business problem and the program - understands all aspects of his/her work on business and technical requirements."]],
	 				["Section 3:	Evaluation - Systems Analysis Skills",
	 					["<u>Business Requirements Analysis</u> - ability to understand and analyze the business requirements, perform cost/benefit analysis; able to produce the deliverables as defined in the requirements phase.",
	 					"<u>Technical Requirements Analysis and Skills</u> - has effective fact finding techniques, systems analysis skills, ability to produce deliverables as required.",
	 					"<u>Estimating</u> - ability to produce realistic, accurate project estimates.",
	 					"<u>Systems Design</u> - ability to design, develop systems to meet	requirements effectively.",
	 					"<u>Quality and Usability of Documentation</u> - the deliverables are well structured according to standards.",
	 					"<u>Project Planning and Control</u> - effective at setting priorities, developing a course of action, meeting the objectives of a plan in an efficient, cost-effective fashion; establishing meaningful performance standards, appraise results achieved by others and ensuring productive output; able to complete task/project within timeframe and budget.",
	 					"<u>User Satisfaction</u> - ability to meet user requirements and specifications within timeframe and budget."]]
	 				];
	 $groupletter = makeTable($questionset, $groupletter);
?>	
<br>

<div align="right"><input id="submitForm" class="rounded-small" type="submit" value="Submit"/></div>

<script>

$(document).ready(initializeChecker);
function initializeChecker(){
	$("#submitForm").click(function(event){
		var tableRows = $("tr");
		var errors = 0;

		for(var ctr = 0; ctr < tableRows.length; ctr++){
			var radioButtons = $(tableRows[ctr]).find("input:radio");
			if(radioButtons.length == 6){	
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
 }
?>
<script type="text/javascript">

//these variables handle the search variables
var currentSearch = null; //the current HTML element that needs AJAX searching
var currentRelated = null; //the current pop-up result box
var currentSearchResults = null; //the current container of the results (found inside the result box)
var serverRequest = null; //the current request to the server
var searchFlag = ""; //handles what type of search to be conducted

//ensures that the page loads before any script is run
$(document).ready(initRelatedSearching);

//initializes the eventhandlers and variables necessary for the AJAX search
function initRelatedSearching(){

	//creates the custom scroll bar in the pop-up search result box
	$(".pt-related-search").mCustomScrollbar({
		advanced:{
       		updateOnContentResize: true
  		},
  		scrollInertia: 300
	});

	//assigns an "on click" listener to HTML elements that have the 'pt-related-result' class
	//for short, any search result that is clicked will trigger the manipulateData function
	$(document).delegate(".pt-related-result", "click", manipulateData);

	//assigns an "on click" listener to the whole page
	//so that everytime a search box closes when a user clicks anywhere but the searchbox
	/*$(window).on("click", function(event){
		//checks whether a search has/is being conducted and the clicked element is not the pop-up result box
		if(currentSearch!=null && event.target != currentSearch && event.target != currentRelated){
			resetSearch();

		}
	});*/

	$(window).keydown(function(event){
		if(event.keyCode == 27){
			if(currentSearch!=null){
				$(currentSearch).blur();
				resetSearch();
			}
		}
	});

	//assigns listeners to HTML elements that need AJAX searching
	/*$("#decoy-companyname").keyup(searchRelated);	
	$("#decoy-companyname").focus(searchRelated);
	$("#decoy-hrname").keyup(searchRelated);	
	$("#decoy-hrname").focus(searchRelated);*/
	$("#decoy-tsname").keyup(searchRelated);
	$("#decoy-tsname").focus(searchRelated);
	$("#decoy-student").keyup(searchRelated);
	$("#decoy-student").focus(searchRelated);
}

//deals with the actual search request
function searchRelated(event){
	var proceedSearch = true;
	if(event.keyCode){
		if(event.keyCode == 27)
			proceedSearch = false;
	} 

	if(proceedSearch){
		//called to cancel or abort any AJAX request currently being conducted before a new search is conductued
		nullifyAJAX();

		//gets the ID of the HTML element that triggered the event
		var searchBoxID = $(this).attr('id');

		//this part deals with the initialization of the search variables
		if(searchBoxID == "decoy-companyname"){
			searchFlag = 'companyname';
			currentSearch = document.getElementById("decoy-companyname");
			currentRelated = document.getElementById("companyname-related");
			currentSearchResults = document.getElementById("company-search-results");
		}
		else if(searchBoxID == "decoy-student"){
			searchFlag = 'student';
			currentSearch = document.getElementById("decoy-student");
			currentRelated = document.getElementById("sname-related");
			currentSearchResults = document.getElementById("s-search-results");
		}
		else{
			searchFlag = 'contactname_noadd';
			if(searchBoxID == "decoy-hrname"){
				currentSearch = document.getElementById("decoy-hrname");
				currentRelated = document.getElementById("hrname-related");
				currentSearchResults = document.getElementById("hr-search-results");
			}
			if(searchBoxID == "decoy-tsname"){
				currentSearch = document.getElementById("decoy-tsname");
				currentRelated = document.getElementById("tsname-related");
				currentSearchResults = document.getElementById("ts-search-results");
			}
		}

		//closes the other search result boxes other than the active search result box
		closeSearchBoxes();

		//display a 'Searching' text to let the user know that a search is being conducted
		$(currentRelated).show();
		$(currentSearchResults).html('Searching...');

		var searchValue = $(currentSearch).val();
		//shows the result box and starts the search when the user input isn't blank or made up of whitespaces
		if(searchValue.length > 0 && searchValue.match(/^\s+$/) == null){
			//gets the user input
			var searchString = currentSearch.value;
			var searchString = searchValue.replace(/\s+/g, ' ');
			//starts the connection to the server
			serverRequest = $.getJSON("ajax/relatedsearch.php",{'searchflag':searchFlag, 'searchstring':searchString}, showResults);
		}
		else {
			//just hide the result box and clear the search results
			$(currentRelated).hide();
			$(currentSearchResults).html('');
		}
	}
}

//the callback function of the AJAX request (when the request's status changes, this function is called)
function showResults(data, textStatus){
	//clears the search results
	$(currentSearchResults).html(''); 

	//if no error during the request occurred
	if(textStatus == "success"){
		//if an error in the server occurred or no data was retrieved from the database
		if(data[0] == 'error' || data[0] == 'none'){
			$(currentSearchResults).html(data[1]);
		}
		else{
			//if there are search results, display them
			for(var related in data)
				$(currentSearchResults).append(data[related]);
		}
		
		//remove the reference to the current AJAX request so you can start a new one
		serverRequest = null;
	}
}

//called when a user clicks a search result
function manipulateData(event){

	//indicates whether to create a new record in the database or just use existing records
	var manipulationFlag = $(this).attr('data-type');

	if(searchFlag == 'companyname'){
		//if the user chooses an existing company record in the database
		if(manipulationFlag == 'old'){
			//these variables handle company-related data (tel. no., fax no., line of business, etc.)
			//the values here are retrieved from an individual search result (the one that was clicked)
			var companyID = $(this).attr('data-company-id');
			var companyLine = $(this).attr('data-businessline');
			var companyName = $(this).find(".companyname").text();
			var companyCity = $(this).find(".city").text();
			var companyStreet = $(this).attr('data-street');
			var companyBuilding = $(this).attr('data-building');
			var companyFloorUnit = $(this).attr('data-floorunit');
			
			$("#companyid").val(companyID);

			//these arrays are declared and initialized for easier access to the company-related textfields
			//the values must be on the same index as their textfield counterparts
			var companyValuesArray = new Array(companyFloorUnit, companyBuilding, companyStreet, companyCity, companyLine);
			var companyFieldsArray = new Array($("#floorunit"), $("#building"), $("#street"), $("#city"), $("#businessline"));

			//fills up the company-related text fields with the retrieved records from the database
			$(currentSearch).val(companyName);
			for(var ctr = 0; ctr < companyFieldsArray.length; ctr++){
				$(companyFieldsArray[ctr]).val(companyValuesArray[ctr]);
				disableObject(companyFieldsArray[ctr]);
			}

		}
		//if the user chooses to create a new company record
		else{
			var companyID = $(this).attr('data-new-company-id');
			var companyName = $(this).attr('data-companyname');

			$(currentSearch).val(companyName);
			$("#companyid").val(companyID);

			//this array is declared and initialized for easier access to the company-related textfields
			var companyFieldsArray = new Array($("#floorunit"), $("#building"), $("#street"), $("#city"), $("#businessline"));

			//enable and clear for user input (if disabled or has text) the company-related textfields
			for(var ctr = 0; ctr < companyFieldsArray.length; ctr++){
				if($(companyFieldsArray[ctr]).val().length > 0){
					$(companyFieldsArray[ctr]).val('');
					enableObject($(companyFieldsArray[ctr]));
				}
			}
		}
	}
	//if the user is searching for a contact person
	else if(searchFlag == "contactname" || searchFlag == "contactname_noadd"){
		//these variables are references to the necessary textfields of a contact person
		var positionField, departmentField, emailField, telNumField, faxNumField;

		//used to check for what type of contact person the use is searching for (human resource / supervisor)
		var searchBoxID = $(currentSearch).attr('id');

		//initializes the variables
		if(searchBoxID == "decoy-hrname"){
			positionField = $("#hrposition");
			departmentField = $("#hrdepartment");
			emailField = $("#hremail");
			telNumField = $("#hrtelnum");
			faxNumField = $("#hrfaxnum");
		}
		else{
			positionField = $("#tsposition");
			departmentField = $("#tsdepartment");
			emailField = $("#tsemail");
			telNumField = $("#tstelnum");
			faxNumField = $("#tsfaxnum");
		}

		//if the user chooses an existing contact record in the database
		if(manipulationFlag == 'old'){
			//these variables handle contact-related data (name, position, department, email, etc)
			//the values here are retrieved from an individual search result (the one that was clicked)
			var contactName = $(this).find('.contactname').text();
			var contactPosition = $(this).attr('data-position');
			var contactDepartment = $(this).attr('data-department');
			var contactEmail = $(this).find('.email').text();
			var contactTelNum = $(this).attr('data-telnum');
			var contactFaxNum = $(this).attr('data-faxnum');

			//these arrays are declared and initialized for easier access to the contact-related textfields
			//the values must be on the same index as their textfield counterparts
			var contactFieldsArray = new Array(positionField, departmentField, emailField, telNumField, faxNumField);
			var contactValuesArray = new Array(contactPosition, contactDepartment, contactEmail, contactTelNum, contactFaxNum);

			//fills up the contact-related text fields with the retrieved records from the database
			$(currentSearch).val(contactName);
			for(var ctr = 0; ctr < contactFieldsArray.length; ctr++){
				$(contactFieldsArray[ctr]).val(contactValuesArray[ctr]);
				alertObject(contactFieldsArray[ctr], true);
				alertObject(currentSearch, true);
			}
		}
		//if the user chooses to add a new contact
		else{
			var contactName = $(this).attr('data-contactname');
			var contactPosition = $(positionField).val();
			var contactDepartment = $(departmentField).val();
			var contactEmail = $(emailField).val();
			var contactTelNum = $(telNumField).val();
			var contactFaxNum = $(faxNumField).val();

			//this array is declared and initialized for easier access to the contact-related textfields
			var contactFieldsArray = new Array(positionField, departmentField, emailField, telNumField, faxNumField);

			//place the new name in the textfield of the contact person's name
			$(currentSearch).val(contactName);

			//clear out the other contact-related textfields that are not empty
			for(var ctr = 0; ctr < contactFieldsArray.length; ctr++){
				if($(contactFieldsArray[ctr]).val().length > 0){
					$(contactFieldsArray[ctr]).val('');
					alertObject(contactFieldsArray[ctr], true);
				}
			}
		}
	}
	else if(searchFlag == "student"){
		var studentName = $(this).find('.studentname').text();
		var studentUsername = $(this).attr('data-username');

		$("#student_username").val(studentUsername);
		$(currentSearch).val(studentName);
		alertObject(currentSearch, true);
	}

	//prepare the variables for another search
	resetSearch();
}

function resetSearch(){
	$(currentRelated).hide();
	$(currentSearchResults).html('');
	currentRelated = null;
	currentSearch = null;
	currentSearchResults = null;
	nullifyAJAX();
}

//used for cancelling and removing the reference to the current AJAX request
function nullifyAJAX(){
	//checks whether a request is being made
	if(serverRequest != null){
		serverRequest.abort();
		serverRequest = null;
		window.console.log("NULLIFIED");
	}
}

//creates a glowing effect on the specified object for user notification
//the alertFlag determines which color the object will fade into
function alertObject(object, alertFlag){
	$(object).stop();

	if($(object).hasClass('error') == true)
		$(object).removeClass('error');

	if(alertFlag == true)
		$(object).css('background-color', '#FFF173 !important').animate({backgroundColor:'#fff'}, 2500);
	else $(object).css('background-color', '#FFF173 !important').animate({backgroundColor:'#ddd'}, 2500);
}

//disables the specified object and notifies the user
function disableObject(object){
	$(object).attr('readonly', 'readonly');
	alertObject(object, false);
}

//enables the specified object and notifies the user
function enableObject(object){
	$(object).removeAttr('readonly');
	alertObject(object, true);
}


function closeSearchBoxes(){
	var activeSearchBoxID = $(currentRelated).attr('id');
	window.console.log(activeSearchBoxID);
	$("#pt-requirementform-holder").find(".pt-related-search").each(function(){
		var tempSearchBoxID = $(this).attr('id');
		if(tempSearchBoxID != activeSearchBoxID){
			window.console.log(tempSearchBoxID);
			$(this).hide();
		}
			
	});
}

</script>
</form>
</div>
<?php
function makeTable($questionset, $groupletter)
{
	foreach ($questionset as $title) {
		?>
		<table class="pt-evalform" cellspacing="0">
				<tr class="pt-reqheader"><td></td><td><center><?= $title[0] ?></center></td>
					<td>5<br><td>4<br><td>3<br><td>2<br><td>1<br><td>N/A<br>
				</tr>
				<?php
					$index = 1;
					foreach($title[1] as $question){
						?> 
						<tr>
							<td><?= ($index).'.' ?></td>
							<td><?= $question ?></td>
							<?php
								for($i = 5; $i >= 0; $i--){
									?> <td><input type="radio" name="<?php echo 'group'.$groupletter.$index; ?>" value="<?php echo $i; ?>"></td><?php
								}
							?>
						</tr>
						<?php
						$index++;
					}
				?>
		</table> 
		<br>
		<div class="pt-remarks">
			<?php if($groupletter=='a') echo 'Summary Assessment'; else echo 'Remarks'; ?>
			<textarea class="rounded-small" name="<?php if($groupletter=='a') echo 'summaryassessment'; else echo 'Remarks'.$groupletter; ?>"></textarea>
		</div>
		<?php
		$groupletter++;
	}
	return $groupletter;
}
?>