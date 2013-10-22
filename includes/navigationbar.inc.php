<div id="pt-menubar">
	<div class="menu-items">
		<a href="/"><img src="images/dlsu-banner.png" alt="De La Salle University"/></a>
		<div class="nav-menu">
			<?php 
				if(isset($_SESSION['username'])){
					echo '<a href="/">Home</a>';
					echo '<a href="/help.php">Help</a>';
					echo '<a href="/session_logout.php">Log Out</a>';
				}
				else {
					echo '<a href="/">Log in</a>';
					echo '<a href="/register.php">Register</a>';
					echo '<a href="/help.php">Help</a>';
				}
			?>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>