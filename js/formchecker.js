$(document).ready(initFormChecker);

function initFormChecker(){
	$("#submitForm").on("click", checkForm);
}

function checkForm(event){
	var errors = 0;

	var formInputElements = document.getElementsByTagName("input");
	var formTextAreas = document.getElementsByTagName("textarea");
	var formFieldSets = document.getElementsByTagName("fieldset");
	var formTextFields = new Array();
	var formPasswordFields = new Array();
	var ctr;


	for(ctr = 0; ctr < formInputElements.length; ctr++){
		if(formInputElements[ctr].type != "password" && formInputElements[ctr].type != "radio" && formInputElements[ctr].type != "submit" && formInputElements[ctr].type != "hidden" && !formInputElements[ctr].getAttribute('data-nullable'))
			formTextFields[formTextFields.length] = formInputElements[ctr];
		else if(formInputElements[ctr].type == "password")
			formPasswordFields[formPasswordFields.length] = formInputElements[ctr];
	}

	for(ctr = 0; ctr < formTextAreas.length; ctr++){
		var textAreaValue = formTextAreas[ctr].value;
		if(textAreaValue.length == 0 || textAreaValue.match(/^\s+$/)){
			$(formTextAreas[ctr]).addClass('error');
			$(formTextAreas[ctr]).one("focus", function(){$(this).removeClass('error');});
			errors++;
		}
	}

	for(ctr = 0; ctr < formFieldSets.length; ctr++){
		var checkBoxes = $(formFieldSets[ctr]).children("input:radio, input:checkbox");
		window.console.log(checkBoxes.length);
		if(checkBoxes.length > 0){
			var unchecked = 0;
			for(var ctr2 = 0; ctr2 < checkBoxes.length; ctr2++){
				if(!checkBoxes[ctr2].checked)
					unchecked++;
			}
			if(unchecked == checkBoxes.length){
				$(formFieldSets[ctr]).addClass('error');
				for(var ctr2 = 0; ctr2 < checkBoxes.length; ctr2++)
					$(checkBoxes[ctr2]).one("focus", function(){$(this).parent().removeClass('error');});
				$(formFieldSets[ctr]).one("click", function(){$(this).removeClass('error');});
				errors++;
			}
		}
	}

	for(ctr = 0; ctr < formTextFields.length; ctr++){
		var textFieldValue = formTextFields[ctr].value;
		if(textFieldValue.length == 0 || textFieldValue.match(/^\s+$/)){
			$(formTextFields[ctr]).addClass('error');
			$(formTextFields[ctr]).one("focus", function(){$(this).removeClass('error');});
			errors++;
		}
	}

	if(formPasswordFields.length == 2){
		if(formPasswordFields[0].value != formPasswordFields[1].value){
			$(formPasswordFields[0]).addClass('error');
			$(formPasswordFields[0]).one("focus", function(){$(this).removeClass('error');});
			$(formPasswordFields[1]).addClass('error');
			$(formPasswordFields[1]).one("focus", function(){$(this).removeClass('error');});
			errors++;
		}
		else{
			if((formPasswordFields[0].value.match(/^\s+$/) && formPasswordFields[1].value.match(/^\s+$/)) || (formPasswordFields[0].value.length == 0) || formPasswordFields[1].value.length == 0){
				$(formPasswordFields[0]).addClass('error');
				$(formPasswordFields[0]).one("focus", function(){$(this).removeClass('error');});
				$(formPasswordFields[1]).addClass('error');
				$(formPasswordFields[1]).one("focus", function(){$(this).removeClass('error');});
				errors++;
			}
		}
	}
	else if(formPasswordFields.length == 1){
		if(formPasswordFields[0].value.match(/^\s+$/) || formPasswordFields[0].value.length == 0 ){
			$(formPasswordFields[0]).addClass('error');
			$(formPasswordFields[0]).one("focus", function(){$(this).removeClass('error');});
			errors++;
		}
	}
	
	if(errors != 0) {
		if($("#empty-input-error").length > 0){
			$("#empty-input-error").html('<span class="pt-error-title">You left some empty fields.</span><br/>Please fill up the red fields.');
			$("#empty-input-error").show();
			window.scrollTo(0,0);
			
			
		}
		event.preventDefault();
		return false;
	}
	else return true;
}