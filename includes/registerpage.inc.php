<div id="pt-formholder" class="rounded-small">
<h1 id="pt-contentheader">Register</h1>
<form id="registerform" action="session_register.php" method="POST">
	Username <input class="pt-textfield rounded-small" type="text" placeholder="Username" name="username"/>
	Password <input class="pt-textfield rounded-small" type="password" placeholder="Password" name="password"/><span id="passerror"></span>
	Re-type Password <input class="pt-textfield rounded-small" type="password" placeholder="Re-type Password" name="repassword"/>
	First Name <input class="pt-textfield rounded-small" type="text" placeholder="First Name" name="firstname"/>
	Last Name <input class="pt-textfield rounded-small" type="text" placeholder="Last Name" name="lastname"/>
	Contact Number <input class="pt-textfield rounded-small" type="text" placeholder="Contact Number" name="contactnum"/>
	E-Mail <input class="pt-textfield rounded-small" type="text" placeholder="E-Mail" name="email"/>
	User Type
	<fieldset id="checkBoxes" class="rounded-small">
		<input type="radio" value="student" name="type"/> Student<br/>
		<input type="radio" value="practicum coordinator" name="type"/> Practicum Coordinator<br/>
		<input type="radio" value="linkage officer" name="type"/> Linkage Officer<br/>
	</fieldset>
	City <input class="pt-textfield rounded-small" type="text" placeholder="City" name="address"/>
	<input class="rounded-small" id="submitForm" type="submit" value="Register"/>
</form>
</div>
<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-welcomeheader">Welcome to Practicum Tracker</h1>
<?php
	if(isset($_GET['username']) || isset($_GET['email']) || isset($_GET['contact'])){
		echo '<h2 class="pt-oops">Uh-oh. Duplicate entries were found.</h2>';
		if(isset($_GET['username']))
			echo 'The username you entered is already taken.<br/>';
		if(isset($_GET['email']))
			echo 'Someone is already using the email address you entered.<br/>';
		if(isset($_GET['contact']))
			echo 'There is already someone out there using your phone number.';
	}
	else{
		echo '<h2 class="pt-oops">Hello there, guest!</h2>';
		echo '<a href="/">Login now</a> or register to begin.';
	}
?>
</div>