<?php
	session_start();
	include('includes/classes_GUI.inc.php');
	include('includes/classes_DatabaseMaster.inc.php');
	include('includes/classes_SessionMaster.inc.php');
	include('includes/classes_PageMaster.inc.php');
	include('includes/classes_Pages.inc.php');

	$sessionMaster = new SessionMaster();
	$objGUI = new GUI("Welcome To Practicum");

	$objGUI->openHTMLPage();
	$objGUI->displayNavigationBar();
	$objGUI->openMainContainer();

	if($sessionMaster->isLoggedIn()){
		$objGUI->displayMenu();
		
		$objCurrentPage = new RequirementsPage();
	}
	else {
		$objCurrentPage = new LoginPage();
	}
	
	$objGUI->setPage($objCurrentPage);
	$objGUI->displayPage();
	$objGUI->closeMainContainer();
	$objGUI->displayFooter();
	$objGUI->closeHTMLPage();
?>


