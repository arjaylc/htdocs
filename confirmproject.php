<?php
	session_start();
	include('includes/classes_DatabaseMaster.inc.php');
	include('includes/classes_PageMaster.inc.php');

	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();

	$proj_id = $_GET['project_id'];
	$newstatus = $_GET['flag']; //// NEW STATUS
	$comment = $_GET['comment'];
        $comment = $DBMaster->escapeString($comment);
        


        if($newstatus == 'Confirm Project')
          $status = 'confirmed';
        else $status = 'denied';

	$query = "UPDATE practicum_application SET status = '$status' WHERE application_id = '$proj_id'";

	$querySelect = "SELECT comment
        FROM comments c
        INNER JOIN practicum_application p on c.application_id = p.application_id
        WHERE c.application_id = '$proj_id'";
        
        $selectResult = $DBMaster->querySelect($querySelect);

	$updateResult = $DBMaster->queryUpdate($query);

        if(is_array($selectResult) && !count($selectResult)){
            $updateQuery = "INSERT INTO comments VALUES('$comment', '$proj_id')";
        }
        else if(is_array($selectResult)){
          $updateQuery = "UPDATE comments SET comment = '$comment' WHERE application_id = '$proj_id'";
        }
        $commentQuery = $DBMaster->queryUpdate($updateQuery);
	if($updateResult){
          if(!empty($comment)){
           if($commentQuery)
		$pageMaster->redirectUser('project_confirmation.php?success=true');
		else $pageMaster->redirectUser('project_confirmation.php?error=error');
	 } else
	 $pageMaster->redirectUser('project_confirmation.php?success=true');
	}
	else $pageMaster->redirectUser('project_confirmation.php?error=error');
?>