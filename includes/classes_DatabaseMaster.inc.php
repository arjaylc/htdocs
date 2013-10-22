<?php
	class DatabaseMaster{
		private $databaseConnection;

		function __construct(){
			$this->connectDatabase();
		}


		private function connectDatabase(){
			$this->databaseConnection = mysqli_connect('ap-cdbr-azure-east-b.cloudapp.net', 'b90e7654391dcc', '26759141', 'rj1'); 
			mysqli_set_charset($this->databaseConnection, 'utf8');
		}

		public function autoCommit($switch = true){
			mysqli_autocommit($this->databaseConnection, $switch);
		}

		public function commitChanges($commit = true){
			if($commit)
				mysqli_commit($this->databaseConnection);
			else mysqli_rollback($this->databaseConnection);
		}

		public function escapeString($string){
			$string = mysqli_real_escape_string($this->databaseConnection, trim($string));
			return $string;
		}

		public function querySelect($query){
			$result = mysqli_query($this->databaseConnection, $query);
			if($result){
				$resultData = array();
				$rowCount = mysqli_num_rows($result);
				if($rowCount >= 1){
					if($rowCount == 1)
						$resultData[] = mysqli_fetch_array($result, MYSQLI_ASSOC);
					else{
						while($rowData = mysqli_fetch_array($result, MYSQLI_ASSOC))
							$resultData[] = $rowData;
					}
					return $resultData;
				}
				else return $resultData;
			}
			else return false;
		}

		public function queryUpdate($query){
			$result = mysqli_query($this->databaseConnection, $query);
			if($result)	return true;	
			else return false;
		}

		public function checkUsername($username){
			$query = "SELECT username FROM user WHERE username='$username'";
			$result = mysqli_query($this->databaseConnection, $query);
			if($result){
				if(mysqli_num_rows($result)) return false;
				else return true;
			}
			else return false;
		}

		public function checkEmail($email){
			$query = "SELECT username FROM user WHERE email='$email'";
			$result = mysqli_query($this->databaseConnection, $query);
			if($result){
				if(mysqli_num_rows($result)) return false;
				else return true;
			}
			else return false;
		}

		public function checkContactNum($contactNum){
			$query = "SELECT username FROM user WHERE contactnum='$contactNum'";
			$result = mysqli_query($this->databaseConnection, $query);
			if($result){
				if(mysqli_num_rows($result)) return false;
				else return true;
			}
			else return false;
		}

		public function checkUserHasGroup($username, $userType){
			if($userType == 'student' || $userType == 'linkage officer')
				$query = "SELECT group_id FROM group_member INNER JOIN practicum_group USING(group_id) WHERE username = '$username' AND status = 'open'";
			else if($userType == 'practicum coordinator')
				$query = "SELECT group_id FROM practicum_group WHERE group_admin = '$username' AND status = 'open'";
			
			$resultData = $this->querySelect($query);

			if(count($resultData) && is_array($resultData))
				return true;
			else if(count($resultData) == 0 && is_array($resultData))
				return false;
			else return null;
		}

		public function checkStudentRequirement($username, $requirement){
			$query = "SELECT username ";
			switch($requirement){
				case 'project proposal': $query.=", status, project_submission"; break;
			}

			$query.=" WHERE username = '$username'";

			$queryResult = $this->querySelect($query);

			if(count($queryResult) && is_array($queryResult))
				return true;
			else if(count($queryResult) == 0 && is_array($queryResult))
				return false;
			else return null;

		}

		public function checkProjectSubmissionStatus($username){
			$query = "SELECT status FROM project_submission WHERE submitter = '$username'";
			$queryResult = $this->querySelect($query);

			if(count($queryResult) && is_array($queryResult)){
				return $queryResult[0]['status'];
			}
			else if(count($queryResult) == 0 && is_array($queryResult))
				return false;
			else return null;
		}

		public function checkCompanySubmissionStatus($username){
			$query = "SELECT status FROM company_submission WHERE submitter = '$username'";
			$queryResult = $this->querySelect($query);

			if(count($queryResult) && is_array($queryResult)){
				return $queryResult[0]['status'];
			}
			else if(count($queryResult) == 0 && is_array($queryResult))
				return false;
			else return null;
		}

		public function getPendingProjectsCount($username){
			$query = "SELECT COUNT(project_id) AS pendingItemsCount FROM project_submission WHERE group_id = (SELECT group_id FROM practicum_group WHERE group_admin = '$username' AND status = 'open') AND status = 'pending'";

			$queryResult = $this->queryCount($query);

			return $queryResult;

		}

		public function getPendingCompanyFormCount($username){
			$query = "SELECT COUNT(company_id) AS pendingItemsCount FROM company_submission WHERE group_id = (SELECT group_id FROM practicum_group WHERE group_admin = '$username' AND status = 'open') AND status = 'pending'";

			$queryResult = $this->queryCount($query);

			return $queryResult;
		}

		public function queryCount($query){
			$queryResult = $this->querySelect($query);

			if(is_array($queryResult) && count($queryResult))
				return $queryResult[0]['pendingItemsCount'];
			else if(is_array($queryResult) && !count($queryResult))
				return 0;
			else return -1;
		}

		public function updateContactPerson($pageMaster, $contactName, $contactPosition, $contactDepartment, $contactEmail, $contactTelNum, $contactFaxNum){
			$query = "SELECT name FROM contactpersons WHERE name = '$contactName'";
			$queryResult = $this->querySelect($query);

			//if the user inputs a new human resource contact
			if(is_array($queryResult) && !count($queryResult)){
				$query = "INSERT INTO contactpersons VALUES ('$contactName', '$contactPosition', '$contactDepartment', '$contactEmail', '$contactTelNum', ";
				if(empty($contactFaxNum) || $contactFaxNum == 'N/A')
					$query .= "NULL)";
				else $query .= "'$contactFaxNum')";

				# CHECKPOINT!
				# if an error occurs here, the script will redirect the user and stop running!
				# and to be safe, discard all changes (INSERTs, UPDATEs) made to the database
				$queryResult = $this->queryUpdate($query);
				if(!$queryResult){
					return false;
				}
				else return true;
			}
			//if the user chooses an existing human resource contact
			else if(is_array($queryResult) && count($queryResult)){
				//check whether the user updated any contact info
				//if a user changed a contact info, update the database.

				//place all contact info (except the fax number) in an array with their keys being the column names in the contact persons table
				$contactInfoArray = array('email' => $contactEmail, 'position' => $contactPosition, 'department' => $contactDepartment, 'telnum' => $contactTelNum);

				//check which columns should be updated or not
				$query = "SELECT ";

				foreach($contactInfoArray AS $column => $value){
					$query .= "( SELECT CASE WHEN $column = '$value' THEN 'retain' ELSE '$column' END FROM contactpersons WHERE name = '$contactName') AS '$column', ";
				}

				if(empty($contactFaxNum) || $contactFaxNum == 'N/A'){
					$query .= "(
						SELECT CASE WHEN faxnum IS NULL THEN 'retain' ELSE 'faxnum' END FROM contactpersons WHERE name = '$contactName'
					) AS faxNum";
				}
				else{
					$query .= "(
						SELECT CASE WHEN faxnum = '$contactFaxNum' THEN 'retain' ELSE 'faxnum' END FROM contactpersons WHERE name = '$contactName'
					) AS sameFaxNum";
				}

				$queryResult = $this->querySelect($query);
				if(is_array($queryResult) && count($queryResult)){
					$updateableCol = $queryResult[0];
					$updateContactCount = 0;
					$queryParts = array();

					foreach($updateableCol AS $column){
						if($column != 'retain'){
							$updateContactCount++;
							if($column != 'faxnum')
								$queryParts[] = "$column = '{$contactInfoArray[$column]}'";
							else{
								if(empty($contactFaxNum) || $contactFaxNum == 'N/A')
									$queryParts[] = "faxnum = NULL";
								else $queryParts[] = "faxnum = '$contactFaxNum'";
							}
						}
					}


					if($updateContactCount != 0){
						$query = "UPDATE contactpersons SET ";
						$query .= implode(', ', $queryParts);
						$query .= " WHERE name = '$contactName'";
						
						# CHECKPOINT!
						# if an error occurs here, the script will redirect the user and stop running!
						# and to be safe, discard all changes (INSERTs, UPDATEs) made to the database
						$queryResult = $this->queryUpdate($query);
						if(!$queryResult)
							return false;
						else return true;


					}

					return true;
				}
				else return false;
			}
			else return false;
		}
	}
?>