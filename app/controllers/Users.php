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
              setSession('username',$data['username']);
              redirect('admins/dashboard');
            } else {
              setSession('user_id',$loggedInUser->user_id);
              setSession('sessionAdmin',"no");
              setSession('username',$data['username']);
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
          if($changedPassword === true){
            flash('forgotPassword','Password Changed Successfully!!!','alert alert-success rounded-0');
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

    public function register(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $data = [
          'first_name' => trim($_POST['first_name']),
          'last_name' => trim($_POST['last_name']),
          'date_of_birth' => trim($_POST['date_of_birth']),
          'gender' => trim($_POST['gender']),
          'current_address' => trim($_POST['current_address']),
          'current_city' => trim($_POST['current_city']),
          'current_country' => trim($_POST['current_country']),
          'current_pincode' => trim($_POST['current_pincode']),
          'permanent_address' => trim($_POST['permanent_address']),
          'permanent_city' => trim($_POST['permanent_city']),
          'permanent_country' => trim($_POST['permanent_country']),
          'permanent_pincode' => trim($_POST['permanent_pincode']),
          'username' => trim($_POST['username']),
          'password' => trim($_POST['password']),
          'class' => trim($_POST['class']),
          'section' => trim($_POST['section']),
          'rollnumber' => trim($_POST['rollnumber']),
          'fathers_name' => trim($_POST['fathers_name']),
          'mothers_name' => trim($_POST['mothers_name']),
          'fathers_occupation' => trim($_POST['fathers_occupation']),
          'mothers_occupation' => trim($_POST['mothers_occupation']),
          'annual_income' => trim($_POST['annual_income']),
          'fathers_mobile_number' => trim($_POST['fathers_mobile_number']),
          'error' => ''
        ];

        //Checking empty data
        foreach ($data as $key => $value) {
          if(!isset($value) && $key!='error'){
            $data['error'] = $key.' is not filled';
          }
        }

        //Current Pincode validation
        if(strlen($data['current_pincode'])!=6){
          $data['error'] = 'pincode length must be 6';
        }

        if(!is_Numeric($data['current_pincode'])){
          $data['error'] = 'pincode must in digits';
        }

        //Permanent pincode validation
        if(strlen($data['permanent_pincode'])!=6){
          $data['error'] = 'Pincode length must be 6';
        }

        if(!is_Numeric($data['permanent_pincode'])){
          $data['error'] = 'Pincode must in digits';
        }

        //Annual Income validation
        if(!is_Numeric($data['annual_income'])){
          $data['error'] = 'Annual income must in digits';
        }

        //Fathers Contact number validation
        if(strlen($data['fathers_mobile_number'])!=10){
          $data['error'] = 'Fathers Contact number must be 10 digit';
        }

        if(!is_Numeric($data['fathers_mobile_number'])){
          $data['error'] = 'Fathers Contact number should be number';
        }

        if(empty($data['error'])){
          //Checking username
          if($this->userModel->findUserByUsername($data['username'])){
            $data['error'] = 'Username is already taken';
            $this->view('user/register',$data);
          } else {
            $response = $this->userModel->register($data);
            if($response === true){
              flash('register','Successfully Registered!!!','alert alert-success rounded-0');
              redirect('users/login');
            } else {
              $data['error'] = 'Internal Error try after sometime';

              $this->view('user/register',$data);
            }
          }
        } else {
          $this->view('user/register',$data);
        }
      } else {

        $data = [
          'first_name' => '',
          'last_name' => '',
          'date_of_birth' => '',
          'gender' => '',
          'current_address' => '',
          'current_city' => '',
          'current_country' => '',
          'current_pincode' => '',
          'permanent_address' => '',
          'permanent_city' => '',
          'permanent_country' => '',
          'permanent_pincode' => '',
          'username' => '',
          'password' => '',
          'class' => '',
          'section' => '',
          'rollnumber' => '',
          'fathers_name' => '',
          'mothers_name' => '',
          'fathers_occupation' => '',
          'mothers_occupation' => '',
          'annual_income' => '',
          'fathers_mobile_number' => '',
          'error' => ''
        ];

        $this->view('user/register',$data);
      }
    }

    public function logout(){
      destroySession();
    }
  }

?>
