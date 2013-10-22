<?php
	session_start();
	include('includes/classes_SessionMaster.inc.php');
	include('includes/classes_GUI.inc.php');
	include('includes/classes_PageMaster.inc.php');
	include('includes/classes_Pages.inc.php');
	include('includes/classes_DatabaseMaster.inc.php');

	$pageMaster = new PageMaster();

	if(isset($_SESSION['logged']) && $_SESSION['logged'] == true)
		$pageMaster->redirectUser();

	$pageTitle = "Performance Appraisal Form";

	$objGUI = new GUI($pageTitle);

	$objGUI->openHTMLPage();
	$objGUI->displayNavigationBar();
	$objGUI->openMainContainer();
	$objGUI->displayMenu();

	/*$objCurrentPage = new RequirementsPage();
	$objCurrentPage->displayContent();*/

	//if($userType == 'student')
	include('includes/performance_appraisal.inc.php');	
	//else include('includes/requirementspage_faculty.inc.php');
	$objGUI->closeMainContainer();
	$objGUI->displayFooter();
	$objGUI->closeHTMLPage();
?>