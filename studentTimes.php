<?php
	require_once("timeClass.php");
	require_once("../db.conf");

	/* +--------------+------------+------+-----+-------------------+-----------------------------+
	 * | Field        | Type       | Null | Key | Default           | Extra                       |
	 * +--------------+------------+------+-----+-------------------+-----------------------------+
	 * | id           | int(11)    | NO   | PRI | NULL              | auto_increment              |
	 * | studentId    | int(11)    | YES  | UNI | NULL              |                             |
	 * | sessionStart | timestamp  | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |
	 * | isActive     | tinyint(1) | YES  |     | NULL              |                             |
	 * +--------------+------------+------+-----+-------------------+-----------------------------+
	 */

	/* +----------+-------------+------+-----+---------+----------------+
	 * | Field    | Type        | Null | Key | Default | Extra          |
	 * +----------+-------------+------+-----+---------+----------------+
	 * | id       | int(11)     | NO   | PRI | NULL    | auto_increment |
	 * | name     | varchar(64) | NO   | UNI | NULL    |                |
	 * | password | varchar(64) | YES  |     | NULL    |                |
	 * +----------+-------------+------+-----+---------+----------------+
	 */

	$link = mysqli_connect($host, $user, $pass) or die("Connect Error " . mysql_error());
	mysqli_select_db($link, "studentInfo") or die ("Database Error " . mysqli_error($link));

	ini_set('session.gc_maxlifetime', 86400);

	$action = (empty($_POST["action"])) ? "" : mysqli_real_escape_string($link, htmlspecialchars($_POST["action"]));
	$student = (empty($_POST["student"])) ? "" : mysqli_real_escape_string($link, htmlspecialchars($_POST["student"]));

	switch ($action) {
		case "set":
			if(!$student){
				echo json_encode(array("error" => "Request missing student paramter to set time for."));
				break;
			}



			mysqli_stmt_close($stmt);

			break;
		case "reset":
			if(!$student){
				echo json_encode(array("error" => "Request missing student paramter to reset time for."));
				break;
			}

			break;
		case "fetch":
			if(!$student){
				break;
			}

			break;
		case "verify":
			if(!$student){
				echo json_encode(array("error" => "Request missing student paramter to verify time for."));
			    break;
			}

			break;
		default:
			echo json_encode(array("error" => "Action not recognised"));
			break;
	}


?>
