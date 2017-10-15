<?php
	require_once("timeClass.php");

	ini_set('session.gc_maxlifetime', 86400);

	$action = (empty($_POST["action"])) ? "" : htmlspecialchars($_POST["action"]);
	$student = (empty($_POST["student"])) ? "" : htmlspecialchars($_POST["student"]);
	$_SESSION["studentList"] = (empty($_SESSION["studentList"])) ? array() : $_SESSION["studentList"];

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
			if(!$student){
				echo json_encode(array("error" => "Request missing student paramter to verify time for."));
			    break;
			}

			$_SESSION["studentList"][$student]->isActive = true;
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
