<?php 
    require_once("../db.conf");

    function startdb(){
        $link = mysqli_connect($host, $user, $pass) or die("Connect Error " . mysql_error());
        mysqli_select_db($link, "studentInfo") or die ("Database Error " . mysqli_error($link));
    
        ini_set('session.gc_maxlifetime', 86400);
    }
    function getId($studentName){
        if($stmt = mysqli_prepare($link, "SELECT id FROM Users WHERE name = ?") or die ("prepare error" . mysqli_error($link))){
            mysqli_stmt_bind_param($stmt, "s", $student) or die ("bind param" . mysqli_stmt_error($stmt));

            if(mysqli_stmt_execute($stmt) or die ("not executed")){
                mysqli_stmt_store_result($stmt) or die (mysqli_stmt_error($stmt));

                if(!mysqli_stmt_num_rows($stmt) == 0){
                    return -1;
                }else{

                return mysqli_stmt_bind_result($stmt, $studentId);


                }		
            }
        }

    }

    function addUser($name){
        if($stmtCreateStudent = mysqli_prepare($link, "INSERT INTO Users (name) VALUES (?)") or die ("prepare error" . mysqli_error($link))){
            mysqli_stmt_bind_param($stmtCreateStudent, "s", $student) or die ("bind param" . mysqli_stmt_error($stmtCreateStudent));
            mysqli_stmt_execute($stmtCreateStudent) or die(mysqli_stmt_error($stmtCreateStudent));

            if(!mysqli_affected_rows($link)){								
                echo json_encode(array("error" => "Could not create resources for " . $student));	
            }
        }

        mysqli_stmt_close($stmtCreateStudent);

    }

    function getName($id){

    }

    function getTime($id){

    }

    function getActive($id){


    }

    function getAllStudentTimes(){
        
    }

    function resetTime($id){

    }
   
    function setActive($id, $active){


    }

?>