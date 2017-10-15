<?php
	require_once("timeClass.php");
	require_once("queries.php");

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
	$userId = getId($student, $host, $user, $pass);

	switch ($action) {
		case "set":
			if(!$student){
				echo json_encode(array("error" => "Request missing student paramter to set time for."));
				break;
			}

			if($userId > 0){
				resetTime($userId, $host, $user, $pass);
				setActive($userId, true, $host, $user, $pass);
			}else{
				addUser($student, $host, $user, $pass);
				$newUserId = getId($student, $host, $user, $pass);
				setTime($newUserId, $host, $user, $pass);
			}

			break;
		case "reset":
			if(!$student){
				echo json_encode(array("error" => "Request missing student paramter to reset time for."));
				break;
			}

			if($userId < 0){
				echo json_encode(array("error" => "Could not find student to reset."));
				break;
			}

			resetTime($userId, $host, $user, $pass);
			setActive($userId, true, $host, $user, $pass);

			break;
		case "fetch":
			echo json_encode(getAllStudentTimes($host, $user, $pass));

			break;
		case "verify":
			if(!$student){
				echo json_encode(array("error" => "Request missing student paramter to verify time for."));
			    break;
			}

			setActive($userId, true, $host, $user, $pass);

			break;
		default:
			echo json_encode(array("error" => "Action not recognised"));
			break;
	}


?>
