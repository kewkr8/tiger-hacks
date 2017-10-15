<?php
	ini_set('session.gc_maxlifetime', 86400);
	session_start();

	$action = (empty($_POST["action"])) ? "" : htmlspecialchars($_POST["action"]);
	$student = (empty($_POST["student"])) ? "" : htmlspecialchars($_POST["student"]);
	$_SESSION["studentList"] = (empty($_SESSION["studentList"])) ? array() : $_SESSION["studentList"];

	class Time{
		public $time;
		public $isActive;

		public function __construct(){

			$this->time = date("h:i:sa");
			$this->isActive = true;	
		}

		public function reset(){
			$time = date("h:i:sa");
		}
	}

	switch ($action) {
		case "set":
			if(!$student){
				echo json_encode(array("error" => "Request missing student paramter to set time for."));
				break;
			}

			$_SESSION["studentList"][$student] = new Time();

			break;
		case "reset":
			if(!$student){
				echo json_encode(array("error" => "Request missing student paramter to reset time for."));
				break;
			}

			$_SESSION["studentList"][$student] -> reset();
			
			break;
		case "fetch":
			if(!$student){
				echo json_encode($_SESSION["studentList"]);
				break;
			}

			echo json_encode($_SESSION["studentList"][$student]);

			break;
		case "verify":
			break;
		default:
			echo json_encode(array("error" => "Action not recognised"));
			break;
	}

	$test = new Time();
	if(!$student){
		echo ($test -> time);
	}
?>
