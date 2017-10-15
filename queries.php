<?php 
    require_once("../db.conf");

    function startdb(){
        $link = mysqli_connect($host, $user, $pass) or die("Connect Error " . mysql_error());
        mysqli_select_db($link, "studentInfo") or die ("Database Error " . mysqli_error($link));
    
        ini_set('session.gc_maxlifetime', 86400);
    }
    function getId($studentName){
        

    }

    function addUser($name){


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