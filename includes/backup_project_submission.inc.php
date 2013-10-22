<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-contentheader">Project Details Form</h1>
<?php
	
	$DBMaster = new DatabaseMaster();

	$username = $DBMaster->escapeString($_SESSION['username']);
	$query = "SELECT businessname, status, projdesc, projtitle, output, projtype, numstudents, supervisor, DATE_FORMAT(datesubmitted, '%b %e, %Y @ %l:%i %p') AS datepassed FROM project_submission WHERE submitter = '$username'";

	$queryResult = $DBMaster->querySelect($query);
	if(count($queryResult) && is_array($queryResult))
		$projectDetails = $queryResult[0];
?>
<div id="pt-requirementform-holder">
<form action="check_projsubmission.php" method="POST">
<?php
	if(isset($_GET['error']) && $_GET['error'] == 'duplicate'){
		echo '<div class="pt-errornotice rounded-small"><b>Wait a second!</b><br/>Either your <u>project title or description</u> is identical to another submission.</div>';
	}
	else if(isset($_GET['error']) && $_GET['error'] == 'error'){
		echo '<div class="pt-errornotice rounded-small"><b>Sorry for the inconvenience.</b><br/>A system error has occurred. Please try again later.</div>';
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
		echo '<input type="hidden" value="update" name="updatesubmission"/>'; 
		echo '<div id="pt-projectlastupdate" class="rounded-small">';
		echo '<b>Last successful submission</b>: '.$projectDetails['datepassed'].'<br/>';
		echo '<b>Submission status</b>: '.ucwords($projectDetails['status']);
		echo '</div>';
	}
?>
	<!--<div class="pt-form-header">
	<h1 class="pt-mini-header">Company Details</h1>
	</div>-->
	<fieldset class="pt-fieldset-default rounded-small">
		<legend class="pt-fieldset-legend rounded-small">Company Details</legend>
		<div class="pt-form-section-left">
		Company Name <input style="width:240px;" name="companyname" maxlength="75" autocomplete="off" id="decoy-companyname" class="pt-textfield rounded-small" type="text" placeholder="Company Name" value="<?php if(isset($projectDetails)) echo $projectDetails['businessname']; ?>"/>
		<input type="hidden" id="newcompany" name="newcompany" value="true"/>
		<div id="companyname-related" class="pt-related-search rounded-small">
		<h1 class="pt-related-header">Related Searches</h1>
		<div id="company-search-results"></div>
		</div>
		</div>
		<div class="pt-form-section-right">
		Main Line of Business<input style="width:240px;" id="businessline" class="pt-textfield rounded-small" type="text" placeholder="e.g. Computer Hardware" name="businessline"/>
		</div>
		<div class="pt-form-section-left">
		Telephone Number <span class="pt-formnote">e.g. (053) 323-6689</span><input style="width:240px;" id="companynum" class="pt-textfield rounded-small" type="text" placeholder="e.g. (053) 323-6689" name="companynum"/>
		</div>
		<div class="pt-form-section-right">
		Fax Number <span class="pt-formnote">e.g. (053) 323-6689</span><input style="width:240px;" id="companyfax" class="pt-textfield rounded-small" type="text" placeholder="e.g. (053) 323-6689" name="companyfaxnum"/>
		</div>
		<div class="clearfix"></div>
		<fieldset class="pt-fieldset-inner rounded-small">
			<legend class="pt-fieldset-legend rounded-small">Company Address</legend>
			<div class="pt-form-section-left">
			Floor, Unit No. <input class="pt-textfield rounded-small" type="text" placeholder="e.g. Tower 2 Unit 3111" name="floorunit"/>
			</div>
			<div class="pt-form-section-right">
			Building <input class="pt-textfield rounded-small" type="text" placeholder="e.g. Mezza Residences" name="building"/>
			</div>
			<div class="pt-form-section-left">
			Street <input class="pt-textfield rounded-small" type="text" placeholder="e.g. Aurora Blvd. cor. Araneta Ave." name="street"/>
			</div>
			<div class="pt-form-section-right">
			Area, Subdivision, District <input class="pt-textfield rounded-small" type="text" placeholder="e.g. Brgy. Dona Imelda, Sta. Mesa" name="area"/>
			</div>
			<div class="pt-form-section-left">
			City <input class="pt-textfield rounded-small" type="text" placeholder="e.g. Quezon City" name="city"/>
			</div>
			<div class="clearfix"></div>
		</fieldset>
	</fieldset>
	<br/>
	<fieldset class="pt-fieldset-default rounded-small">
		<legend class="pt-fieldset-legend rounded-small">Contact Persons</legend>

		<fieldset class="pt-fieldset-inner rounded-small">
			<legend class="pt-fieldset-legend-multitab"><a id="hrtab" class="rounded-small activetab" href="javascript:void(0)">Human Resource</a><a id="tstab" class="rounded-small" href="javascript:void(0)">Technical Supervisor</a></legend>
			<div class="pt-form-section-left">
			<input type="hidden" id="newhr" name="newhr" value="true"/>
			Full Name <span class="pt-formnote">*firstname lastname</span><input class="pt-textfield rounded-small" type="text" placeholder="e.g. Julian Asoy" name="hrname"/>
			</div>
			<div class="pt-form-section-right">
			Position <input class="pt-textfield rounded-small" type="text" placeholder="e.g. Manager" name="hrposition"/>
			</div>
			<div class="clearfix"></div>
			<div class="pt-form-section-left">
			Department <input class="pt-textfield rounded-small" type="text" placeholder="e.g. Publicity" name="hrdepartment"/>
			</div>
			<div class="pt-form-section-right">
			Email Address<input class="pt-textfield rounded-small" type="text" placeholder="e.g. jasoy@gmail.com" name="hremail"/>
			</div>
			<div class="pt-form-section-left">
			Telepone Number <span class="pt-formnote">e.g. (053) 323-6689</span><input class="pt-textfield rounded-small" type="text" placeholder="e.g. (053) 323-6689" name="hrphonenum"/>
			</div>
			<div class="pt-form-section-right">
			Fax Number <span class="pt-formnote">e.g. (053) 323-6689</span><input class="pt-textfield rounded-small" type="text" placeholder="e.g. (053) 323-6689" name="hrfaxnumber"/>
			</div>
		</fieldset>
		<fieldset class="pt-fieldset-inner rounded-small">
			<legend class="pt-fieldset-legend rounded-small">Technical Supervisor</legend>
			<div class="pt-form-section-left">
			<input type="hidden" id="newhr" name="newhr" value="true"/>
			Full Name <span class="pt-formnote">*firstname lastname</span><input class="pt-textfield rounded-small" type="text" placeholder="e.g. Julian Asoy" name="tsrname"/>
			</div>
			<div class="pt-form-section-right">
			Position <input class="pt-textfield rounded-small" type="text" placeholder="e.g. Manager" name="tsposition"/>
			</div>
			<div class="clearfix"></div>
			<div class="pt-form-section-left">
			Department <input class="pt-textfield rounded-small" type="text" placeholder="e.g. Publicity" name="tsdepartment"/>
			</div>
			<div class="pt-form-section-right">
			Email Address<input class="pt-textfield rounded-small" type="text" placeholder="e.g. jasoy@gmail.com" name="tsemail"/>
			</div>
			<div class="pt-form-section-left">
			Telepone Number <span class="pt-formnote">e.g. (053) 323-6689</span><input class="pt-textfield rounded-small" type="text" placeholder="e.g. (053) 323-6689" name="tsphonenum"/>
			</div>
			<div class="pt-form-section-right">
			Fax Number <span class="pt-formnote">e.g. (053) 323-6689</span><input class="pt-textfield rounded-small" type="text" placeholder="e.g. (053) 323-6689" name="tsfaxnumber"/>
			</div>
		</fieldset>
	</fieldset>
	
	<!--<div class="pt-form-section">
	Supervisor <input class="pt-textfield rounded-small" type="text" placeholder="Supervisor" name="supervisor" value="<?php if(isset($projectDetails)) echo $projectDetails['supervisor']; ?>"/>
	</div>
	<div class="pt-form-section">
	Project Title <input class="pt-textfield rounded-small" type="text" placeholder="Project Title" name="projtitle" value="<?php if(isset($projectDetails)) echo $projectDetails['projtitle']; ?>"/>
	</div>
	<div class="pt-form-section">
	Number of Students <input class="pt-textfield rounded-small" type="text" placeholder="Number of Students" name="numstudents" value="<?php if(isset($projectDetails)) echo $projectDetails['numstudents']; ?>"/>
	</div>
	<div class="pt-form-section">
	Project Description <textarea placeholder="Project Description"  name="projdesc"><?php if(isset($projectDetails)) echo $projectDetails['projdesc']; ?></textarea></div>
	<div class="pt-form-section">
	Output: <textarea placeholder="Output"  name="output"><?php if(isset($projectDetails)) echo $projectDetails['output']; ?></textarea>
	</div>
	<div class="pt-form-section">
	Project Type <textarea placeholder="Project Type"  name="projtype"><?php if(isset($projectDetails)) echo $projectDetails['projtype']; ?></textarea>
	</div>-->
	<div class="clearfix"></div>
	<input id="submitForm" type="submit" class="rounded-small" value="<?php echo (isset($projectDetails) ? "Update" : "Submit"); ?>"/>
	<div class="clearfix"></div>
</form>

<script>
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
  		scrollInertia: 750
	});

	//assigns an "on click" listener to HTML elements that have the 'pt-related-result' class
	//for short, any search result that is clicked will trigger the manipulateData function
	$(".pt-form-section").delegate(".pt-related-result", "click", manipulateData);

	//assigns an "on click" listener to the whole page
	//so that everytime a search box closes when a user clicks anywhere but the searchbox
	$(window).on("click", function(event){
		//checks whether a search has/is being conducted and the clicked element is not the pop-up result box
		if(currentSearch!=null && event.target != currentSearch && event.target != currentRelated){
			$(currentRelated).hide();
			$(currentSearchResults).html('');
			currentRelated = null;
			currentSearch = null;
			currentSearchResults = null;
			nullifyAJAX();
		}
	});

	//assigns listeners to HTML elements that need AJAX searching
	$("#decoy-companyname").keyup(searchRelated);	
	$("#decoy-companyname").click(searchRelated);
}

//deals with the actual search request
function searchRelated(){
	//called to cancel or abort any AJAX request currently being conducted
	nullifyAJAX();

	//display a 'Searching' text to let the user know that a search is being conducted
	$(currentRelated).show();
	$(currentSearchResults).html('Searching...');

	//gets the ID of the HTML element that triggered the event
	var searchBoxID = $(this).attr('id');

	//this part deals with the initialization of the search variables
	if(searchBoxID == "decoy-companyname"){
		searchFlag = 'companyname';
		currentSearch = document.getElementById("decoy-companyname");
		currentRelated = document.getElementById("companyname-related");
		currentSearchResults = document.getElementById("company-search-results");
	}

	//shows the result box and starts the search when the user input isn't blank or made up of whitespaces
	if(currentSearch.value.length!=0){
		//gets the user input
		var searchString = currentSearch.value;

		//starts the connection to the server
		serverRequest = $.getJSON("ajax/relatedsearch.php",{'searchflag':searchFlag, 'searchstring':searchString}, showResults);
	}
	else {
		//just hide the result box and clear the search results
		$(currentRelated).hide();
		$(currentSearchResults).html('');
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
			var companyNum = $(this).attr('data-telnum');
			var companyFax = $(this).attr('data-faxnum');
			var companyLine = $(this).attr('data-businessline');
			var companyName = $(this).find(".companyname").text();
			currentSearch.value = companyName;


			//fills up the company-related text fields with the retrieved records from the database
			$("#companynum").attr('value', companyNum);
			$("#companyfax").attr('value', companyFax);
			$("#businessline").attr('value', companyLine);
			
			window.console.log(companyName);
		}
		//if the user chooses to create a new company record
		else{
			var companyName = $(this).attr('data-companyname');
			currentSearch.value = companyName;

			//indicates that a new company is being made (used for server-side processing)
			$("#newcompany").attr('value', 'true');
		}

		/*$("#companynum").removeAttr('disabled');
		$("#companyfax").removeAttr('disabled');
		$("#businessline").removeAttr('disabled');*/
	}
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



</script>
</div>
</div>