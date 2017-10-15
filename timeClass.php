<?php
	class Time{
          public $time;
          public $isActive;
 
          public function __construct(){
 
	            $this->time = date("h:i:sa");
	            $this->isActive = true;
	        }
 
          public function reset(){
              $this->time = date("h:i:sa");
              $this->isActive = true;
          }
      }
?>
