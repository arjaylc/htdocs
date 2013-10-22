<?php
	abstract class Page{
		public $DBMaster;
		public $pageMaster;
		public $sessionMaster;

		function __construct(){
			$this->DBMaster = new DatabaseMaster();
			$this->pageMaster = new PageMaster();
			$this->sessionMaster = new SessionMaster();
		}

		abstract public function displayContent();
	}

	class HomePage extends Page{
		//prints out the necessary content of this page
		public function displayContent(){
			include('/includes/homepage.inc.php');	
		}
	}

	class LoginPage extends Page{
		public function displayContent(){
			include('/includes/loginpage.inc.php');
		}
	}

	class RegisterPage extends Page{
		public function displayContent(){
			include('/includes/registerpage.inc.php');
		}
	}

	class ProjectSubmissionPage extends Page{
		public function displayContent(){
			include('/includes/project_submission.inc.php');
		}
	}

	class RequirementsPage extends Page{
		private $userType;

		function __construct(){
			$this->userType = $_SESSION['type'];
		}

		public function displayContent(){
			if($this->userType == 'student')
				include('/includes/requirementspage_student.inc.php');	
			else include('/includes/requirementspage_faculty.inc.php');		
		}	
	}

	class CreateGroupPage extends Page{
		public function displayContent(){
			include('/includes/creategrouppage.inc.php');
		}
	}

	class SearchGroupPage extends Page{
		public function displayContent(){
			include('/includes/searchgroup.inc.php');
		}
	}

	class ProjectConfirmationPage extends Page{
		public function displayContent(){
			include('/includes/project_confirmation.inc.php');
		}
	}

	class GroupMembersPage extends Page{
		public function displayContent(){
			include('/includes/groupmember.inc.php');
		}
	}

	class CompanyDetailsPage extends Page{
		public function displayContent(){
			include('/includes/company_submission.inc.php');
		}
	}

	class CompanyConfirmationPage extends Page{
		public function displayContent(){
			include('/includes/company_confirmation.inc.php');
		}
	}

	class LinkageOfficersPage extends Page{
		public function displayContent(){
			include('/includes/linkageofficers.inc.php');
		}
	}

	class PracticumOverviewPage extends Page{
		public function displayContent(){
			include('/includes/practicumoverview.inc.php');
		}
	}

	class StudentEvaluationConfirmationPage extends Page{
		public function displayContent(){
			include('/includes/studentevaluationconfirmation.inc.php');
		}
	}

	class AppraisalFormConfirmationPage extends Page{
		public function displayContent(){
			include('/includes/appraisalformconfirmation.inc.php');
		}
	}

	class LinkageAssignmentPage extends Page{
		public function displayContent(){
			include('/includes/linkageassignment.inc.php');
		}
	}

	class HelpPage extends Page{
		public function displayContent(){
			if(empty($_GET))
				include('/includes/help.inc.php');
			else{
				if(isset($_GET['topic'])){
					switch($_GET['topic']){
						case 'groups': include('/includes/help_groups.inc.php'); break;
						case 'relatedsearch': include('/includes/help_relatedsearch.inc.php'); break;
						case 'requirements': include('/includes/help_requirements.inc.php'); break;
						case 'joingroup': include('/includes/help_joingroup.inc.php'); break;
						case 'reqconfirmation': include('/includes/help_reqconfirmation.inc.php'); break;
						case 'assignedstudents': include('/includes/help_assignedstudents.inc.php'); break;
						case 'groupcontrols': include('/includes/help_groupcontrols.inc.php'); break;
						case 'groupmembers': include('/includes/help_groupmembers.inc.php'); break;
						case 'linkageofficers': include('/includes/help_linkageofficers.inc.php'); break;
						case 'overview': include('/includes/help_overview.inc.php'); break;
					}
				}
			}
		}
	}

	class AssignedStudentsPage extends Page{
		public function displayContent(){
			include('/includes/assignedstudents.inc.php');
		}
	}
?>