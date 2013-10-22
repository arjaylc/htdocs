<?php
	session_start();
	include('includes/classes_DatabaseMaster.inc.php');
	include('includes/classes_PageMaster.inc.php');

	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();

    $supervisor = $_POST['supervisor'];
    $supervisor = $DBMaster->escapeString($supervisor);
    
    $student = $_POST['student_username'];
    $student = $DBMaster->escapeString($student);
    
	$a1 = $_POST['groupa1'];
	$a2 = $_POST['groupa2'];
	$a3 = $_POST['groupa3'];
	$a4 = $_POST['groupa4'];
	$summary = $_POST['summaryassessment'];
	$summary = $DBMaster->escapeString($summary);

    $b1 = $_POST['groupb1'];
	$b2 = $_POST['groupb2'];
	$b3 = $_POST['groupb3'];
	$b4 = $_POST['groupb4'];
	$b5 = $_POST['groupb5'];
	$b6 = $_POST['groupb6'];
	$b7 = $_POST['groupb7'];
	$b8 = $_POST['groupb8'];
	$b9 = $_POST['groupb9'];
	$b10 = $_POST['groupb10'];
	$b11 = $_POST['groupb11'];
	$b12 = $_POST['groupb12'];
	$b13 = $_POST['groupb13'];
	$b14 = $_POST['groupb14'];
	$b15 = $_POST['groupb15'];
	$b16 = $_POST['groupb16'];
	$b17 = $_POST['groupb17'];
	$remarksB = $_POST['remarksb'];
    $remarksB = $DBMaster->escapeString($remarksB);

	$c1 = $_POST['groupc1'];
	$c2 = $_POST['groupc2'];
	$c3 = $_POST['groupc3'];
	$c4 = $_POST['groupc4'];
	$c5 = $_POST['groupc5'];
	$remarksC = $_POST['remarksc'];
    $remarksC = $DBMaster->escapeString($remarksC);

	$d1 = $_POST['groupd1'];
	$d2 = $_POST['groupd2'];
	$d3 = $_POST['groupd3'];
	$d4 = $_POST['groupd4'];
	$d5 = $_POST['groupd5'];
	$d6 = $_POST['groupd6'];
	$d7 = $_POST['groupd7'];
	$remarksD = $_POST['remarksd'];
    $remarksD = $DBMaster->escapeString($remarksD);

	$queryA =  "INSERT INTO evaluator_information VALUES ('$supervisor', '$position', '$student', '$dateStart', '$dateEnd', '$jobDesc')";
    $queryB =  "INSERT INTO appraisal_rating_summary VALUES ('$supervisor', '$student', '$a1', '$a2', '$a3', '$a4', '$summary')";
    $queryC =  "INSERT INTO appraisal_professional_skills VALUES ('$supervisor', '$student', '$b1', '$b2', '$b3', '$b4', '$b5', '$b6', '$b7', '$b8', '$b9', '$b10', '$b11', '$b12', '$b13', '$b14', '$b15', '$b16', '$b17', '$remarksB')";
    $queryD =  "INSERT INTO appraisal_programming_skills VALUES ('$supervisor', '$student', '$c1', '$c2', '$c3', '$c4', '$c5', '$remarksC')";
    $queryE =  "INSERT INTO appraisal_systems_analysis_skills VALUES ('$supervisor', '$student', '$d1', '$d2', '$d3', '$d4', '$d5', '$d6', '$d7', '$remarksD')";

    if($DBMaster->queryUpdate($queryA)&&$DBMaster->queryUpdate($queryB)&&$DBMaster->queryUpdate($queryC)&&$DBMaster->queryUpdate($queryD)&&$DBMaster->queryUpdate($queryE)){
        $pageMaster->redirectUser('performanceappraisal.php?type=submit');
	}
	else{
	     $pageMaster->redirectUser('performanceappraisal.php?error=error');
	}
?>