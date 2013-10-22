<?php
	class GUI{
		private $title;

		function __construct($newTitle){
			$this->title = $newTitle;
		}

		//prints out the necessary opening tags of the HTML page
		public function openHTMLPage(){
			include('/includes/header.inc.php');
		}

		//prints out the navigation bar on top of the page
		public function displayNavigationBar(){

			include('/includes/navigationbar.inc.php');
		}

		//prints out the opening tags the main container which holds all dynamic data
		public function openMainContainer(){
			echo '<div id="pt-maincontainer" class="rounded-small">';
		}

		//prints out the closing tags of the main container and the clearfix div
		public function closeMainContainer(){
			echo '<div class="clearfix"></div></div>';
		}

		//prints out the menu located on the left side of the main container
		public function displayMenu(){
			include('/includes/menu.inc.php');
		}

		//prints out the closing tags and footer of the HTML page
		public function displayFooter(){
			include('/includes/footer.inc.php');
		}

		public function closeHTMLPage(){
			echo '</body></html>';
		}
	}
?>