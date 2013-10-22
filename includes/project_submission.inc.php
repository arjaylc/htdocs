<div id="pt-contentbox" class="rounded-small pt-formloaded-page">
<h1 id="pt-contentheader">Project Details Form</h1>
<?php
	
	$DBMaster = new DatabaseMaster();
	$applicationDetails = array();


	$username = $DBMaster->escapeString($_SESSION['username']);
	$query = "SELECT pa.application_id, company_id, DATE_FORMAT(application_date, '%M %e, %Y') AS datepassed, companyname, status, businessline, 
	floor_unit, street, building, city,
	project_title, project_description, project_output, project_num_students, project_duration,
	contacts.hr_name,
	(
		SELECT department FROM contactpersons WHERE name = contacts.hr_name
	) AS hr_department,
	(
		SELECT position FROM contactpersons WHERE name = contacts.hr_name
	) AS hr_position,
	(
		SELECT email FROM contactpersons WHERE name = contacts.hr_name
	) AS hr_email,
	(
		SELECT telnum FROM contactpersons WHERE name = contacts.hr_name
	) AS hr_telnum,
	(
		SELECT COALESCE(faxnum, 'N/A') FROM contactpersons WHERE name = contacts.hr_name
	) AS hr_faxnum,
	contacts.ts_name,
	(
		SELECT department FROM contactpersons WHERE name = contacts.ts_name
	) AS ts_department,
	(
		SELECT position FROM contactpersons WHERE name = contacts.ts_name
	) AS ts_position,
	(
		SELECT email FROM contactpersons WHERE name = contacts.ts_name
	) AS ts_email,
	(
		SELECT telnum FROM contactpersons WHERE name = contacts.ts_name
	) AS ts_telnum,
	(
		SELECT COALESCE(faxnum, 'N/A') FROM contactpersons WHERE name = contacts.ts_name
	) AS ts_faxnum
	FROM practicum_application AS pa
	INNER JOIN company USING(company_id)
	INNER JOIN practicum_application_project USING(application_id)
	INNER JOIN practicum_application_contacts AS contacts USING(application_id)
	WHERE student = '$username'
	ORDER BY application_date DESC LIMIT 1";

	$queryResult = $DBMaster->querySelect($query);
	
	if(count($queryResult) && is_array($queryResult))
		$projectDetails = $queryResult[0];


	if(isset($projectDetails)){
		$projectTypeArray = array();
		$query = "SELECT project_type FROM practicum_application_project_types WHERE application_id='{$projectDetails['application_id']}'";
		$queryResult = $DBMaster->querySelect($query);
		if(count($queryResult) && is_array($queryResult)){
			foreach($queryResult AS $projectType){
				$projectTypeArray[] = $projectType['project_type'];
			}
			$projectDetails[] = $projectTypeArray;
		}
	}
		
?>
<div id="pt-requirementform-holder">
<div id="empty-input-error" style="display:none;" class="pt-errornotice rounded-small">

</div>
<form action="check_projsubmission.php" method="POST">
<?php
	if(isset($_GET['error']) && $_GET['error'] == 'duplicate'){
		echo '<div class="pt-errornotice rounded-small"><span class="pt-error-title">Wait a second!</span><br/>Either your <u>project title or description</u> is identical to another submission.</div>';
	}
	else if(isset($_GET['error']) && $_GET['error'] == 'error'){
		echo '<div class="pt-errornotice rounded-small"><span class="pt-error-title">Sorry for the inconvenience.</span><br/>A system error has occurred. Please try again later.</div>';
	}
	if(isset($_GET['type']) && $_GET['type'] == 'update'){
		echo '<div class="pt-notice rounded-small"><b>Update successful!</b><br/>';
		echo 'Don\'t forget to also update your Company Details Form (if necessary) after this new submission is confirmed.</div>';
	}

	if(isset($_GET['type']) && $_GET['type'] == 'submit'){
		echo '<div class="pt-notice rounded-small"><b>Submission successful!</b><br/>';
		echo 'Please wait for this new submission to be confirmed.</div>';
	}

	if(isset($projectDetails)){
		//echo '<input type="hidden" value="update" name="updatesubmission"/>'; 
		echo '<div id="pt-projectlastupdate" class="rounded-small">';
		echo '<b>Last successful submission</b>: '.$projectDetails['datepassed'].'<br/>';
		echo '<b>Submission status</b>: '.ucwords($projectDetails['status']);
		echo '</div>';
	}

      $commentQuery = "SELECT comment FROM comments WHERE application_id ='{$projectDetails['application_id']}'";
      $commentResult = $DBMaster->querySelect($commentQuery);
      if(is_array($commentResult) && count($commentResult) && $projectDetails['status'] != 'confirmed'){
           $comment = $commentResult[0]['comment'];
           echo '<div class="pt-notice rounded-small"><b>Comments:</b><br/>';
           if(empty($comment))
             echo 'No comments.';
           else  echo $comment;
           echo '</div>';
      }
?>
	<!--<div class="pt-form-header">
	<h1 class="pt-mini-header">Company Details</h1>
	</div>-->
	<input type="hidden" value="<?php
		if(isset($projectDetails))
			echo $projectDetails['company_id'];
		else{
			$randomNum = time().mt_rand();
			$defaultCompanyID = sha1($randomNum);
			echo $defaultCompanyID;
		}
		
	?>" id="companyid" name="companyid"/>
	<fieldset class="pt-fieldset-default rounded-small">
		<legend class="pt-fieldset-legend rounded-small">Company Details</legend>
		<div class="pt-form-section-left">
			Company Name 
			<input name="companyname" maxlength="75" autocomplete="off" id="decoy-companyname" class="pt-textfield rounded-small" type="text" placeholder="Company Name" value="<?php if(isset($projectDetails)) echo $projectDetails['companyname']; ?>" />
			
			<div id="companyname-related" class="pt-related-search rounded-small">
				<h1 class="pt-related-header">Related Companies</h1>
				<div id="company-search-results"></div>
			</div>
		</div>
		<div class="pt-form-section-right">
		Main Line of Business<input  id="businessline" class="pt-textfield rounded-small" type="text" placeholder="e.g. Computer Hardware" value="<?php if(isset($projectDetails)) echo $projectDetails['businessline']; ?>" <?php if(isset($projectDetails)) echo 'readonly="readonly" style="background-color:#ddd;"'; ?> name="businessline"/>
		</div>
		<div class="pt-form-section-left">
		<!--Telephone Number <span class="pt-formnote">e.g. (053) 323-6689</span><input id="companynum" class="pt-textfield rounded-small" type="text" value="" placeholder="e.g. (053) 323-6689" name="companynum"/>
		</div>
		<div class="pt-form-section-right">
		Fax Number <span class="pt-formnote">e.g. (053) 323-6689</span><input id="companyfax" class="pt-textfield rounded-small" type="text" value="" placeholder="e.g. (053) 323-6689" name="companyfaxnum"/>
		</div>
		<div class="clearfix"></div>-->
		<fieldset class="pt-fieldset-inner rounded-small">
			<legend class="pt-fieldset-legend rounded-small">Company Address</legend>
			<div class="pt-form-section-left">
			Floor, Unit No. <input class="pt-textfield rounded-small" type="text" value="<?php if(isset($projectDetails)) echo $projectDetails['floor_unit']; ?>" placeholder="e.g. Tower 2 Unit 3111" name="floorunit" id="floorunit" <?php if(isset($projectDetails)) echo 'readonly="readonly" style="background-color:#ddd;"'; ?>/>
			</div>
			<div class="pt-form-section-right">
			Building <input class="pt-textfield rounded-small" type="text" value="<?php if(isset($projectDetails)) echo $projectDetails['building']; ?>" placeholder="e.g. Mezza Residences" name="building" id="building" <?php if(isset($projectDetails)) echo 'readonly="readonly" style="background-color:#ddd;"'; ?>/>
			</div>
			<div class="pt-form-section-left">
			Street <input class="pt-textfield rounded-small" type="text" value="<?php if(isset($projectDetails)) echo $projectDetails['street']; ?>" placeholder="e.g. Aurora Blvd. cor. Araneta Ave." name="street" id="street" <?php if(isset($projectDetails)) echo 'readonly="readonly" style="background-color:#ddd;"'; ?>/>
			</div>
			<!--<div class="pt-form-section-right">
			Area, Subdivision, District <input class="pt-textfield rounded-small" type="text" placeholder="e.g. Brgy. Dona Imelda, Sta. Mesa" name="area"/>
			</div>-->
			<div class="pt-form-section-right">
			City <input class="pt-textfield rounded-small" type="text" value="<?php if(isset($projectDetails)) echo $projectDetails['city']; ?>" placeholder="e.g. Quezon City" name="city" id="city" <?php if(isset($projectDetails)) echo 'readonly="readonly" style="background-color:#ddd;"'; ?>/>
			</div>
			<div class="clearfix"></div>
		</fieldset>
	</fieldset>
	<br/>
	<fieldset class="pt-fieldset-default rounded-small">
		<legend class="pt-fieldset-legend rounded-small">Contact Persons</legend>
		<fieldset class="pt-fieldset-inner rounded-small">
			<legend class="pt-fieldset-legend rounded-small">Human Resource</legend>
			<div class="pt-form-section-left">
				Full Name <span class="pt-formnote">*firstname lastname</span>
				<input id="decoy-hrname" class="pt-textfield rounded-small" autocomplete="off" type="text" placeholder="e.g. Julian Asoy" name="hrname" value="<?php if(isset($projectDetails)) echo $projectDetails['hr_name']; ?>"/>
				<div id="hrname-related" class="pt-related-search rounded-small">
					<h1 class="pt-related-header">Related Contacts</h1>
					<div id="hr-search-results"></div>
				</div>
			</div>
			<div class="pt-form-section-right">
			Position <input class="pt-textfield rounded-small" id="hrposition" type="text" placeholder="e.g. Manager" name="hrposition" value="<?php if(isset($projectDetails)) echo $projectDetails['hr_position']; ?>"/>
			</div>
			<div class="clearfix"></div>
			<div class="pt-form-section-left">
			Department <input class="pt-textfield rounded-small" id="hrdepartment" type="text" placeholder="e.g. Publicity" name="hrdepartment" value="<?php if(isset($projectDetails)) echo $projectDetails['hr_department']; ?>"/>
			</div>
			<div class="pt-form-section-right">
			Email Address<input class="pt-textfield rounded-small" id="hremail" type="text" placeholder="e.g. jasoy@gmail.com" name="hremail" value="<?php if(isset($projectDetails)) echo $projectDetails['hr_email']; ?>"/>
			</div>
			<div class="pt-form-section-left">
			Telephone Number <span class="pt-formnote">e.g. (053) 323-6689</span>
			<input id="hrtelnum" class="pt-textfield rounded-small" type="text" placeholder="e.g. (053) 323-6689" name="hrtelnum" value="<?php if(isset($projectDetails)) echo $projectDetails['hr_telnum']; ?>"/>
			</div>
			<div class="pt-form-section-right">
			Fax Number
			<span class="pt-formnote">e.g. (053) 323-6689</span><br/>
			<input id="hrfaxnum" data-nullable="true" class="pt-textfield rounded-small" type="text" placeholder="Enter N/A if not applicable" name="hrfaxnum" value="<?php if(isset($projectDetails)) echo $projectDetails['hr_faxnum']; ?>"/>
			</div>
		</fieldset>
		<fieldset class="pt-fieldset-inner rounded-small">
			<legend class="pt-fieldset-legend rounded-small">Technical Supervisor</legend>
			<div class="pt-form-section-left">
				Full Name <span class="pt-formnote">*firstname lastname</span>
				<input id="decoy-tsname" class="pt-textfield rounded-small" autocomplete="off" type="text" placeholder="e.g. Julian Asoy" name="tsname" value="<?php if(isset($projectDetails)) echo $projectDetails['ts_name']; ?>"/>
				<div id="tsname-related" class="pt-related-search rounded-small">
					<h1 class="pt-related-header">Related Contacts</h1>
					<div id="ts-search-results"></div>
				</div>
			</div>
			<div class="pt-form-section-right">
			Position <input id="tsposition" class="pt-textfield rounded-small" type="text" placeholder="e.g. Manager" name="tsposition" value="<?php if(isset($projectDetails)) echo $projectDetails['ts_position']; ?>"/>
			</div>
			<div class="clearfix"></div>
			<div class="pt-form-section-left">
			Department <input id="tsdepartment" class="pt-textfield rounded-small" type="text" placeholder="e.g. Publicity" name="tsdepartment" value="<?php if(isset($projectDetails)) echo $projectDetails['ts_department']; ?>"/>
			</div>
			<div class="pt-form-section-right">
			Email Address<input id="tsemail" class="pt-textfield rounded-small" type="text" placeholder="e.g. jasoy@gmail.com" name="tsemail" value="<?php if(isset($projectDetails)) echo $projectDetails['ts_email']; ?>"/>
			</div>
			<div class="pt-form-section-left">
			Telephone Number <span class="pt-formnote">e.g. (053) 323-6689</span>
			<input id="tstelnum" class="pt-textfield rounded-small" type="text" placeholder="e.g. (053) 323-6689" name="tstelnum" value="<?php if(isset($projectDetails)) echo $projectDetails['ts_telnum']; ?>"/>
			</div>
			<div class="pt-form-section-right">
			Fax Number <span class="pt-formnote">e.g. (053) 323-6689</span>
			<input id="tsfaxnum" data-nullable="true" class="pt-textfield rounded-small" type="text" placeholder="Enter N/A if not applicable" name="tsfaxnum" value="<?php if(isset($projectDetails)) echo $projectDetails['ts_faxnum']; ?>"/>
			</div>
		</fieldset>
	</fieldset>
	<br/>
	<fieldset class="pt-fieldset-default rounded-small">
		<legend class="pt-fieldset-legend rounded-small">Project Details</legend>
		<div class="pt-form-section-left">
		Project Title <input class="pt-textfield rounded-small" type="text" placeholder="Project Title" name="projtitle" value="<?php if(isset($projectDetails)) echo $projectDetails['project_title']; ?>"/>
		</div>
		<div class="clearfix"></div>
		<div class="pt-form-section-left">
		Number of Students Required<input class="pt-textfield rounded-small" type="text" placeholder="Number of Students" name="numstudents" value="<?php if(isset($projectDetails)) echo $projectDetails['project_num_students']; ?>"/>
		</div>
		<div class="pt-form-section-right">
		Project Duration <span class="pt-formnote">*in days</span>
		<input class="pt-textfield rounded-small" type="text" placeholder="e.g. 30" name="projduration" value="<?php if(isset($projectDetails)) echo $projectDetails['project_duration']; ?>"/>
		</div>
		<div class="clearfix"></div>
		<div class="pt-form-section-left">
		Project Description 
		<textarea placeholder="Project Description" class="rounded-small" style="font-size:13px;" name="projdesc"><?php if(isset($projectDetails)) echo $projectDetails['project_description']; ?></textarea>
		</div>
		<div class="pt-form-section-left">
		Project Output
		<textarea placeholder="Project Output" class="rounded-small" style="font-size:13px;" name="projoutput"><?php if(isset($projectDetails)) echo $projectDetails['project_output']; ?></textarea>
		</div>
		<fieldset class="pt-fieldset-inner rounded-small">
		<legend class="pt-fieldset-legend rounded-small">Project Type</legend>

		<?php
			$projectTypes = array();
			$projectTypesValues = array();
			$query = "SELECT * FROM projecttype ORDER BY projecttype_text";
			$queryResult = $DBMaster->querySelect($query);
			foreach($queryResult AS $row){
				$projectTypes[] = $row['projecttype_text'];
				$projectTypesValues[] = $row['projecttype'];
			}
			for($ctr = 0; $ctr < count($projectTypes); $ctr++){
				echo '<input type="checkbox"';
				if(isset($projectTypeArray)){
					if(in_array($projectTypesValues[$ctr], $projectTypeArray))
						echo 'checked="checked"';
				}
				echo 'class="pt-project-type" value="'.$projectTypesValues[$ctr].'" name="projtype[]" id="'.$projectTypesValues[$ctr].'"/> <label for="'.$projectTypesValues[$ctr].'">'.$projectTypes[$ctr].'</label><br/>';
			}
		?>
		</fieldset>
	</fieldset>
	<?php
		if(isset($projectDetails) && ($projectDetails['status'] == 'denied' || $projectDetails['status'] == 'cancelled')){
			echo '<input id="submitForm" type="submit" class="rounded-small" value="Update"/>';
		}
		else if(!isset($projectDetails)){
			echo '<input id="submitForm" type="submit" class="rounded-small" value="Submit"/>';
		}
		else{}
	?>
	<div class="clearfix"></div>
</form>

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
	$("#decoy-companyname").keyup(searchRelated);	
	$("#decoy-companyname").focus(searchRelated);
	$("#decoy-hrname").keyup(searchRelated);	
	$("#decoy-hrname").focus(searchRelated);
	$("#decoy-tsname").keyup(searchRelated);
	$("#decoy-tsname").focus(searchRelated);
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
		else{
			searchFlag = 'contactname';
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
	else if(searchFlag == "contactname"){
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
			window.console.log(tempSearchBoxID+"S");
			$(this).hide();
		}
			
	});
}

</script>
</div>
</div>