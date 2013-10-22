<?php
	class PageMaster{
		public function redirectUser($page = 'index.php'){
			$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
			$url = rtrim($url, '/\\');
			$url.= '/'.$page;
			header('Location: '.$url);
			exit();
		}

		public function displayNoGroupMessages($userType){
			echo '<h2 class="pt-oops">Oops! Looks like you don\'t have a group yet.</h2>';
			switch($userType){
				case 'student': echo 'You should try <a href="searchgroup.php">searching for and joining a practicum group</a> created by your coordinator.'; break;

				case 'practicum coordinator': echo 'You should try <a href="creategroup.php">creating a practicum group</a> for your students and linkage officers.'; break;

				case 'linkage officer': echo 'You should try <a href="searchgroup.php">searching for and joining a practicum group</a> created by your coordinator or wait for a coordinator to add you to a group.'; break;
			}
		}


		public function displayErrorMessage(){
			echo '<h2 class="pt-oops">A system error has occurred.</h2>';
			echo 'Please try again later. We apologize for the inconvenience.';
		}


		public function displayHasGroupMessages($userType){
			echo '<h2 class="pt-oops">Oops! It seems like you still have an active group.</h2>';
			switch($userType){
				case 'student': echo 'Students can only be a member of one group at a time. You should leave your current group, then join a new one.'; break;
				case 'practicum coordinator': echo 'Coordinators can only handle one group at a time.<br/>You should close your current group, then create a new one.'; break;

			}
		}

		public function displayNeedPreviousRequirement(){
			echo '<h2 class="pt-oops">You shall not pass!</h2>';
			echo 'Your previous requirement is either not yet submitted or is still awaiting confirmation.';
		}
	}
?>