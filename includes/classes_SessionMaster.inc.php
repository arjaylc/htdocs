<?php
	
	class SessionMaster{
		public function isLoggedIn(){
			if(isset($_SESSION['logged'])){
				if($_SESSION['logged'] == true)
					return true;
				else return false;
			}
			else return false;
		}

		public function logUser($username, $type, $group_id){
			$_SESSION['username'] = $username;
			$_SESSION['type'] = $type;
			$_SESSION['group_id'] = $group_id;
			$_SESSION['logged'] = true;
		}

		public function logUserOut(){
			$_SESSION['username'] = '';
			$_SESSION['type'] = '';
			$_SESSION['logged'] = '';
			$_SESSION = array();
			session_destroy();
		}
	}

?>