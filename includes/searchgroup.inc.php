<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-contentheader">Find Practicum Group</h1>
<div id="pt-requirementform-holder">
Group Name<br/> 
<input style="width:97%;" class="pt-textfield rounded-small" id="searchbox" type="text" placeholder="Keyword, phrase, letter, etc." name="pracgroup"/>

<input id="submitForm" class="rounded-small" type="submit" value="Search"/>
<div class="clearfix"></div>
</div>
<div id="pt-searchresults-holder" style="display:none;">
<h1 id="pt-searchresults-header">Search Results</h1>
<div id="resultslist">
</div>
</div>

<script type="text/javascript">
$("#submitForm").on("click", searchData);

var searchText;
function searchData(event){
	if(checkForm(event)){
		var searchString = document.getElementById("searchbox").value;
		searchText = searchString;
		$.getJSON("check_searchgroup.php", {'searchString':searchString}, outputResults);
		$("#resultslist").html('<div class="pt-searchresult">Searching . . .</div>');
		$("#pt-searchresults-holder").show();

	}
}

function outputResults(data, textStatus){
	var resultsList = $("#resultslist");

	$(resultsList).html('');

	if(data[0] == 'none')
		$(resultsList).html('<div class="pt-searchresult">Sorry. It seems like "'+searchText+'" doesn\'t point to any practicum group.</div>');
	else if(data[0] == 'error')
		$(resultsList).html('<div class="pt-searchresult">An error occurred during the search. Please try again.</div>');
	else {
		for(var result in data)
			$(resultsList).append(data[result]);
	}
}
</script>
</div>