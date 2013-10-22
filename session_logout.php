<?php
	session_start();
	include('includes/classes_SessionMaster.inc.php');
	include('includes/classes_PageMaster.inc.php');
	$sessionMaster = new SessionMaster();
	$pageMaster = new PageMaster();
	
	$sessionMaster->logUserOut();
	$pageMaster->redirectUser();

?>