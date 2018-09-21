<?php
  class Admin extends Controller{
    function __construct(){

    }

    public function index(){ //Dashboard
      $this->view('admin/dashboard');
    }
  }
?>
