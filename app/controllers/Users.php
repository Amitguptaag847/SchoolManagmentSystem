<?php

  class Users extends Controller{
    public function __construct(){
      $this->userModel = $this->model('User');
    }

    public function index(){ //login
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $data =[
          'username' => trim($_POST['username']),
          'password' => trim($_POST['password']),
          'error' => '',
        ];

        if(empty($data['username'])){
          $data['error'] = 'Pleae enter username';
        }

        if(empty($data['password'])){
          $data['error'] = 'Pleae enter password';
        }

        if($this->userModel->findUserByUsername($data['username'])){
          //User found
        } else {
          $data['error'] = 'Unknown User';
        }

        if(empty($data['error'])){
          $loggedInUser = $this->userModel->login($data['username'],$data['password']);
          if($loggedInUser){
            $isAdmin = $loggedInUser->admin;
            if($isAdmin){
              setSession('user_id',$loggedInUser->user_id);
              setSession('sessionAdmin',"yes");
              redirect('admin/dashboard');
            } else {
              setSession('user_id',$loggedInUser->user_id);
              setSession('sessionAdmin',"no");
              redirect('students/dashboard');
            }
          } else {
            $data['error'] = 'Password is wrong';
            $this->view('user/login',$data);
          }
        } else {
          $this->view('user/login',$data);
        }
      } else {
        $data =[
          'username' => '',
          'password' => '',
          'error' => '',
        ];

        $this->view('user/login',$data);
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

        if(empty($data['username'])){
          $data['error'] = 'Pleae enter username';
        }

        if(empty($data['password'])){
          $data['error'] = 'Pleae enter password';
        }

        if(empty($data['confirmpassword'])){
          $data['error'] = 'Pleae reenter password';
        }

        if($_POST['password'] != $_POST['confirmpassword']){
          $data['error'] = "Password do not match";
        }

        if($_POST['code'] != '1234'){
          $data['error'] = "Code is wrong";
        }

        if($this->userModel->findUserByUsername($data['username'])){
          //User found
        } else {
         $data['error'] = 'Unknown User';
        }

        if(empty($data['error'])){
          $changedPassword = $this->userModel->changePassword($data['username'],$data['password']);
          if($changedPassword){
            flash('forgotPassword','Password Changed Successfully!!!');
            redirect('users');
          } else {
            $data['error'] = 'Cannot Change Password';
            $this->view('user/forgot',$data);
          }
        } else {
          $this->view('user/forgot',$data);
        }
      } else {
        $data =[
          'username' => '',
          'password' => '',
          'confirmpassword' => '',
          'code' => '',
          'error' => '',
        ];

        $this->view('user/forgot',$data);
      }
    }

    public function logout(){
      destroySession();
    }
  }

?>
