<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title><?php echo $this->title; ?></title>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery.color-2.1.1.js"></script>
<script type="text/javascript" src="js/formchecker.js"></script>
<?php
	if($this->title == 'Project Details Form' || $this->title == 'Performance Appraisal Form' || $this->title == 'Practicum Overview'){
		echo '<link rel="stylesheet" type="text/css" href="customscrollbar.css"/>';
		echo '<script type="text/javascript" src="jquery-customscrollbar-min.js"></script>';
	
	}
?>
<link rel="stylesheet" type="text/css" href="css/styles.css"/>
</head>
<body>

<?php
	if($this->title == 'Practicum Overview'){
		echo '<div class="pt-background"></div>';
		echo '<div class="pt-pop-graphbox rounded-small shadowed-medium"> </div>';
	}
?>