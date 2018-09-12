<?php

  class Login extends Controller{
    public function __construct(){

    }

    public function index(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $data =[
          'username' => trim($_POST['username']),
          'password' => trim($_POST['password']),
          'error' => '',
        ];

        if(empty($data['error'])){

        } else {
          $this->view('login/index',$data);
        }
      } else {
        $data =[
          'username' => '',
          'password' => '',
          'error' => '',
        ];

        $this->view('login/index',$data);
      }
    }

    public function forgot(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $data =[
          'username' => trim($_POST['username']),
          'password' => trim($_POST['password']),
          'confirmpassword' => trim($_POST['confirmpassword']),
          'code' => trim($_POST['code']),
          'error' => '',
        ];

        if($_POST['password'] != $_POST['confirmpassword']){
          $data['error'] = "Password do not match";
        }

        if($_POST['code'] != '1234'){
          $data['error'] = "Code is wrong";
        }

        if(empty($data['error'])){

        } else {
          $this->view('login/forgot',$data);
        }
      } else {
        $data =[
          'username' => '',
          'password' => '',
          'confirmpassword' => '',
          'code' => '',
          'error' => '',
        ];

        $this->view('login/forgot',$data);
      }
    }
  }

?>
