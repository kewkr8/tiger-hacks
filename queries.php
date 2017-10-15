<?php 

	require_once("db.conf");

	function getDBLink($host, $user, $pass){
        $link = mysqli_connect($host, $user, $pass) or die("Connect Error " . mysql_error());
		mysqli_select_db($link, "studentInfo") or die ("Database Error " . mysqli_error($link));

		return $link;
	}
	
	function getId($studentName, $host, $user, $pass){
        $link = getDBLink($host, $user, $pass);
        if($stmt = mysqli_prepare($link, "SELECT id FROM Users WHERE name = ?") or die ("prepare error" . mysqli_error($link))){
            mysqli_stmt_bind_param($stmt, "s", $studentName) or die ("bind param" . mysqli_stmt_error($stmt));

            if(mysqli_stmt_execute($stmt) or die ("not executed")){
                mysqli_stmt_store_result($stmt) or die (mysqli_stmt_error($stmt));

				if(mysqli_stmt_num_rows($stmt) == 0){
                    return -1;
				}else{
					mysqli_stmt_bind_result($stmt, $studentId);
					mysqli_stmt_fetch($stmt);
					return $studentId;
                }		
            }
        }
        mysqli_close($link);
    }

    function addUser($name, $host, $user, $pass){
        $link = getDBLink($host, $user, $pass);
        if($stmt = mysqli_prepare($link, "INSERT INTO Users (name) VALUES (?)") or die ("prepare error" . mysqli_error($link))){
            mysqli_stmt_bind_param($stmt, "s", $name) or die ("bind param" . mysqli_stmt_error($stmt));
            mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));

            if(!mysqli_affected_rows($link)){								
                echo json_encode(array("error" => "Could not create resources for " . $name));	
            }
        }

        mysqli_stmt_close($stmt);
    }
    
    function getName($id, $host, $user, $pass){
        $link = getDBLink($host, $user, $pass);
        if($stmt = mysqli_prepare($link, "SELECT name FROM Users WHERE id = ?") or die ("prepare error" . mysqli_error($link))){
            mysqli_stmt_bind_param($stmt, "i", $id) or die ("bind param" . mysqli_stmt_error($stmt));

            if(mysqli_stmt_execute($stmt) or die ("not executed")){
                mysqli_stmt_store_result($stmt) or die (mysqli_stmt_error($stmt));

                if(mysqli_stmt_num_rows($stmt) == 0){
                    return '';
                }else{
                    mysqli_stmt_bind_result($stmt, $name);
                    mysqli_stmt_fetch($stmt);
                    return $name;

                }		
            }
		}

        mysqli_stmt_close($stmt);
    }

    function getTime($id, $host, $user, $pass){
        $link = getDBLink($host, $user, $pass);
        if($stmt = mysqli_prepare($link, "SELECT sessionStart FROM studentTimes WHERE studentId = ?") or die ("prepare error" . mysqli_error($link))){
            mysqli_stmt_bind_param($stmt, "i", $id) or die ("bind param" . mysqli_stmt_error($stmt));

            if(mysqli_stmt_execute($stmt) or die ("not executed")){
                mysqli_stmt_store_result($stmt) or die (mysqli_stmt_error($stmt));

                if(mysqli_stmt_num_rows($stmt) == 0){
                    return '';
                }else{
                    mysqli_stmt_bind_result($stmt, $time);
                    mysqli_stmt_fetch($stmt);
                    return $time;

                }		
            }
        }

        mysqli_stmt_close($stmt);
    }

    function getActive($id, $host, $user, $pass){
        $link = getDBLink($host, $user, $pass);
        if($stmt = mysqli_prepare($link, "SELECT isActive FROM studentTimes WHERE studentId = ?") or die ("prepare error" . mysqli_error($link))){
            mysqli_stmt_bind_param($stmt, "i", $id) or die ("bind param" . mysqli_stmt_error($stmt));

            if(mysqli_stmt_execute($stmt) or die ("not executed")){
                mysqli_stmt_store_result($stmt) or die (mysqli_stmt_error($stmt));

                if(mysqli_stmt_num_rows($stmt) == 0){
                    return 0;
                }else{
                    mysqli_stmt_bind_result($stmt, $isActive);
                    mysqli_stmt_fetch($stmt);
                    return $isActive;

                }		
            }
        }

		mysqli_stmt_close($stmt);
    }

    function getAllStudentTimes($host, $user, $pass){
        $link = getDBLink($host, $user, $pass);
        if($stmt = mysqli_prepare($link, "SELECT sessionStart, studentId FROM studentTimes") or die ("prepare error" . mysqli_error($link))){

            if(mysqli_stmt_execute($stmt) or die ("not executed")){
                mysqli_stmt_store_result($stmt) or die (mysqli_stmt_error($stmt));

                if(mysqli_stmt_num_rows($stmt) == 0){
                    return '';
                }else{
                    mysqli_stmt_bind_result($stmt, $time, $studentId);
                    $times = array();
                    while(mysqli_stmt_fetch($stmt)){
                        $times[getName($studentId, $host, $user, $pass)] = $time; 

                    }
                    
                    return $times;

                }		
            }
        }

        mysqli_stmt_close($stmt);
        
    }

    function resetTime($id, $host, $user, $pass){
        $link = getDBLink($host, $user, $pass);
        if($stmt = mysqli_prepare($link, "UPDATE studentTimes SET sessionStart = now() WHERE studentId = ?") or die ("prepare error" . mysqli_error($link))){
            mysqli_stmt_bind_param($stmt, "i", $id) or die ("bind param" . mysqli_stmt_error($stmt));
            mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));

            if(!mysqli_affected_rows($link)){							
                echo json_encode(array("error" => "Could not reset time"));	
            }
        }

        mysqli_stmt_close($stmt);

    }
   
    function setTime($id, $host, $user, $pass){
        $link = getDBLink($host, $user, $pass);
        if($stmt = mysqli_prepare($link, "INSERT INTO studentTimes (studentId, sessionStart, isActive) VALUES (?, NOW(), true)") or die ("prepare error" . mysqli_error($link))){
            mysqli_stmt_bind_param($stmt, "i", $id) or die ("bind param" . mysqli_stmt_error($stmt));
            mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));

            if(!mysqli_affected_rows($link)){								
                echo json_encode(array("error" => "Could not create resources for " . $name));	
            }
        }


        mysqli_stmt_close($stmt);

    }

    function setActive($id, $active, $host, $user, $pass){
        $link = getDBLink($host, $user, $pass);
        if($stmt = mysqli_prepare($link, "UPDATE studentTimes SET isActive  = ? WHERE studentId = ?") or die ("prepare error" . mysqli_error($link))){
            mysqli_stmt_bind_param($stmt, "ii",$active, $id) or die ("bind param" . mysqli_stmt_error($stmt));
            mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
    }
?>
