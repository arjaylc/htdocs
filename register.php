<?php
	session_start();
	include('includes/classes_SessionMaster.inc.php');
	include('includes/classes_GUI.inc.php');
	include('includes/classes_PageMaster.inc.php');
	include('includes/classes_Pages.inc.php');
	include('includes/classes_DatabaseMaster.inc.php');
	$sessionMaster = new SessionMaster();
	
	if(!$sessionMaster->isLoggedIn()){
		$objGUI = new GUI("Register");

		$objGUI->openHTMLPage();
		$objGUI->displayNavigationBar();
		$objGUI->openMainContainer();

		/*$objCurrentPage = new RegisterPage();
		$objCurrentPage->displayContent();*/

		include('includes/registerpage.inc.php');

		$objGUI->closeMainContainer();
		$objGUI->displayFooter();
		$objGUI->closeHTMLPage();
	}
	else {
		$pageMaster = new PageMaster();
		$pageMaster = $pageMaster->redirectUser();
	}
?>