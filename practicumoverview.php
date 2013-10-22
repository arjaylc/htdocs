<?php
	session_start();
	include('includes/classes_SessionMaster.inc.php');
	include('includes/classes_GUI.inc.php');
	include('includes/classes_PageMaster.inc.php');
	include('includes/classes_Pages.inc.php');
	include('includes/classes_DatabaseMaster.inc.php');
	$sessionMaster = new SessionMaster();

	if($sessionMaster->isLoggedIn() && $_SESSION['type'] == 'practicum coordinator'){
		$objGUI = new GUI("Practicum Overview");
		$objGUI->openHTMLPage();
		$objGUI->displayNavigationBar();
		$objGUI->openMainContainer();
		$objGUI->displayMenu();

		$objCurrentPage = new PracticumOverviewPage();
		$objGUI->setPage($objCurrentPage);
		$objGUI->displayPage();

		#include('includes/groupmember.inc.php');

		$objGUI->closeMainContainer();
		$objGUI->displayFooter();
		$objGUI->closeHTMLPage();
	}
	else{
		$pageMaster = new PageMaster();
		$pageMaster->redirectUser();
	}



?>