<div id="pt-formholder" class="rounded-small">
<h1 id="pt-contentheader">Log In</h1>
<form action="session_login.php" method="POST">
	Username <input class="rounded-small pt-textfield" type="text" placeholder="Username" name="username" value="<?php if(isset($_GET['username'])) echo $_GET['username']; ?>" autofocus="autofocus"/>
	Password <input class="rounded-small pt-textfield" type="password" placeholder="Password" name="password"/>
	<input id="submitForm" class="rounded-small" type="submit" value="Log In"/>
</form>
</div>
<div id="pt-contentbox" class="rounded-small">
<h1 id="pt-welcomeheader">Welcome to Practicum Tracker</h1>
<?php
	if(isset($_GET['success']) && isset($_GET['username'])){
		echo '<h2 class="pt-oops">Uh-oh. Username or password is incorrect.</h2>';
		echo 'Make sure you entered the correct username-password combination.';
	}
	else{
		echo '<h2 class="pt-oops">Hello there, guest!</h2>';
		echo 'Login now or <a href="register.php">register</a> to begin.';
	}
?>

</div>