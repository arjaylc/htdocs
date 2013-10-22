<?php
	session_start();
	include('includes/classes_DatabaseMaster.inc.php');
	include('includes/classes_PageMaster.inc.php');

	$DBMaster = new DatabaseMaster();
	$pageMaster = new PageMaster();

	$groupName = $_GET['searchString'];
	$groupName = $DBMaster->escapeString($groupName);

	$username = $DBMaster->escapeString($_SESSION['username']);

	$query = "SELECT group_name, COUNT(grpMember.username) AS members, group_id, CONCAT(firstname, ' ', lastname) AS admin_name, (SELECT CASE WHEN '$username' IN (SELECT username FROM group_member AS grpMember2 WHERE grpMember2.group_id = practicumGroup.group_id) THEN 'yes' ELSE 'no' END) AS member FROM practicum_group AS practicumGroup LEFT JOIN user AS userTable ON group_admin = userTable.username LEFT JOIN group_member AS grpMember USING(group_id) WHERE group_name LIKE '%$groupName%' GROUP BY group_id";
	$queryResult = $DBMaster->querySelect($query);

	$userHasGroup = $DBMaster->checkUserHasGroup($username, $_SESSION['type']);

	$formattedData = array();

	if(is_array($queryResult) && count($queryResult) && is_bool($userHasGroup)){
		foreach($queryResult AS $row){
			$html = '<div class="pt-searchresult" data-groupid="'.$row['group_id'].'">';
			$html.='<div class="pt-result-groupname">'.$row['group_name'].'</div>';
			$html.='<div class="pt-result-groupadmin">Coordinator: '.$row['admin_name'].'</div>'
			;
			$html.='<div class="pt-result-groupmembers">Members: '.$row['members'].'</div>';
			
			if($userHasGroup){
				if($row['member'] == 'no' )
					$html.='<a href="switchgroup.php?group_id='.$row['group_id'].'">Switch to Group</a>';
			}
			else{
				$html.='<a href="joingroup.php?group_id='.$row['group_id'].'">Join Group</a>';
			}
			
			$html.='</div>';
			$formattedData[] = $html;
		}
		
	}
	else if(is_array($queryResult) && count($queryResult) == 0 && is_bool($userHasGroup))
		$formattedData[]='none';
	else $formattedData[]='error';

	$JSONData = json_encode($formattedData, JSON_FORCE_OBJECT);
		echo $JSONData;

?>