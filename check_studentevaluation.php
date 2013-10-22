<?php
	session_start();
	include('includes/classes_DatabaseMaster.inc.php');
	include('includes/classes_PageMaster.inc.php');

	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();

	$username = $DBMaster->escapeString($_SESSION['username']);

	$a1 = $_POST['groupa1'];
	$a2 = $_POST['groupa2'];
	$a3 = $_POST['groupa3'];
	$a4 = $_POST['groupa4'];
	$a5 = $_POST['groupa5'];
	$a6 = $_POST['groupa6'];
	$a7 = $_POST['groupa7'];
	$a8 = $_POST['groupa8'];

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
	
	$c1 = $_POST['groupc1'];
	$c2 = $_POST['groupc2'];
	$c3 = $_POST['groupc3'];
	$c4 = $_POST['groupc4'];
	$c5 = $_POST['groupc5'];
	$c6 = $_POST['groupc6'];
	$c7 = $_POST['groupc7'];
	$c8 = $_POST['groupc8'];
	$c9 = $_POST['groupc9'];
	$c10 = $_POST['groupc10'];
	
	$d1 = $_POST['groupd1'];
	$d2 = $_POST['groupd2'];
	$d3 = $_POST['groupd3'];
	$d4 = $_POST['groupd4'];
	$d5 = $_POST['groupd5'];
	$d6 = $_POST['groupd6'];
	$d7 = $_POST['groupd7'];
	$d8 = $_POST['groupd8'];
	$d9 = $_POST['groupd9'];
	$d10 = $_POST['groupd10'];
	$d11 = $_POST['groupd11'];
	$d12 = $_POST['groupd12'];
	
	$question1 = $_POST['question1'];
	$question2 = $_POST['question2'];
	$question3 = $_POST['question3'];
	$question4 = $_POST['question4'];
	$question5 = $_POST['question5'];
	$question1 = $DBMaster->escapeString($question1);
	$question2 = $DBMaster->escapeString($question2);
	$question3 = $DBMaster->escapeString($question3);
	$question4 = $DBMaster->escapeString($question4);
	$question5 = $DBMaster->escapeString($question5);

	$queryA =  "INSERT INTO eval_course_content VALUES ('$username', '$a1', '$a2', '$a3', '$a4', '$a5', '$a6', '$a7', '$a8')";
        $queryB =  "INSERT INTO eval_impact VALUES ('$username', '$b1', '$b2', '$b3', '$b4', '$b5', '$b6', '$b7', '$b8', '$b9', '$b10', '$b11', '$b12', '$b13', '$b14', '$b15')";
        $queryC =  "INSERT INTO eval_subject_application VALUES ('$username', '$c1', '$c2', '$c3', '$c4', '$c5', '$c6', '$c7', '$c8', '$c9', '$c10')";
        $queryD =  "INSERT INTO eval_skill VALUES ('$username', '$d1', '$d2', '$d3', '$d4', '$d5', '$d6', '$d7', '$d8', '$d9', '$d10', '$d11', '$d12')";
        $queryE =  "INSERT INTO eval_essay VALUES ('$username', '$question1', '$question2', '$question3', '$question4', '$question5')";
        if($DBMaster->queryUpdate($queryA)&&$DBMaster->queryUpdate($queryB)&&$DBMaster->queryUpdate($queryC)&&$DBMaster->queryUpdate($queryD)&&$DBMaster->queryUpdate($queryE)){
            $pageMaster->redirectUser('studentevaluation.php?type=submit');
	}
	else{
	     $pageMaster->redirectUser('studentevaluation.php?error=error');
	}
?>