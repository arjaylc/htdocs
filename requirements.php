<?php
	session_start();
	include('includes/classes_SessionMaster.inc.php');
	include('includes/classes_GUI.inc.php');
	include('includes/classes_PageMaster.inc.php');
	include('includes/classes_Pages.inc.php');
	include('includes/classes_DatabaseMaster.inc.php');

	$sessionMaster = new SessionMaster();

	if($sessionMaster->isLoggedIn()){
		$userType = $_SESSION['type'];
		if($userType == 'student')
			$pageTitle = "Online Student Requirements";
		else $pageTitle = "Online Student Submissions";

		$objGUI = new GUI($pageTitle);

		$objGUI->openHTMLPage();
		$objGUI->displayNavigationBar();
		$objGUI->openMainContainer();
		$objGUI->displayMenu();

		/*$objCurrentPage = new RequirementsPage();
		$objCurrentPage->displayContent();*/

		if($userType == 'student')
			include('includes/requirementspage_student.inc.php');	
		else include('includes/requirementspage_faculty.inc.php');
		$objGUI->closeMainContainer();
		$objGUI->displayFooter();
		$objGUI->closeHTMLPage();
	}
	else {
		$pageMaster = new PageMaster();
		$pageMaster->redirectUser();
	}
?>