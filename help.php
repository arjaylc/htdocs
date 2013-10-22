<?php
	session_start();
	include('includes/classes_GUI.inc.php');
	include('includes/classes_DatabaseMaster.inc.php');
	include('includes/classes_SessionMaster.inc.php');
	include('includes/classes_PageMaster.inc.php');
	include('includes/classes_Pages.inc.php');

	$sessionMaster = new SessionMaster();
	$objGUI = new GUI("Practicum Tracker Help");

	$objGUI->openHTMLPage();
	$objGUI->displayNavigationBar();
	$objGUI->openMainContainer();
	$objCurrentPage = new HelpPage();

	if($sessionMaster->isLoggedIn()){
		$objGUI->displayMenu();
	}
	else {
	?>
		<div id="pt-formholder" class="rounded-small">
		<h1 id="pt-contentheader">Log In</h1>
		<form action="session_login.php" method="POST">
			Username <input class="rounded-small pt-textfield" type="text" placeholder="Username" name="username" value="<?php if(isset($_GET['username'])) echo $_GET['username']; ?>" autofocus="autofocus"/>
			Password <input class="rounded-small pt-textfield" type="password" placeholder="Password" name="password"/>
			<input id="submitForm" class="rounded-small" type="submit" value="Log In"/>
		</form>
		</div>
	<?php
	}
	
	$objGUI->setPage($objCurrentPage);
	$objGUI->displayPage();
	$objGUI->closeMainContainer();
	$objGUI->displayFooter();
	$objGUI->closeHTMLPage();
?>


