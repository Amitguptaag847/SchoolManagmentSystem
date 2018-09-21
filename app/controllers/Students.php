<?php

  class Students extends Controller{
    public function __construct(){
      //$this->studentsModal = $this->model('Student');
    }

    public function index(){ //Dashboard
      $this->view('student/dashboard');
    }

    public function viewprofile(){
      $this->view('student/viewprofile');
    }

    public function feedetails(){
      $this->view('student/feedetails');
    }

    public function attendance(){
      $this->view('student/attendance');
    }
  }

?>
