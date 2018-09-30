<?php

  class Students extends Controller{
    public function __construct(){
      $this->studentModal = $this->model('Student');
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

    public function editprofile(){
      $this->view('student/editprofile');
    }

    public function changepassword(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        $data =[
          'error' => '',
        ];

        if(empty($_POST['oldpassword'])){
          $data['error'] = 'Pleae enter old password';
        }

        if(empty($_POST['newpassword'])){
          $data['error'] = 'Pleae enter new password';
        }

        if(empty($_POST['confirmpassword'])){
          $data['error'] = 'Pleae reenter password';
        }

        if($_POST['newpassword'] != $_POST['confirmpassword']){
          $data['error'] = "Password do not match";
        }

        $verifyStudent = $this->studentModal->verifyStudent(getUserId(),$_POST['oldpassword']);
        if($verifyStudent === false){
          $data['error'] = "Wrong Password";
        }

        //$data['error'] = '';

        if(empty($data['error'])){
          $changedPassword = $this->studentModal->changePassword(getUserId(),$_POST['newpassword']);
          if($changedPassword === true){
            flash('changePassword','Password Changed Successfully!!!');
            redirect('students/changepassword');
          } else {
            flash('changePassword','Error in changing password','alert alert-danger rounded');
            redirect('students/changepassword');
          }
        } else {
          flash('changePassword',$data['error'],'alert alert-danger rounded');
          redirect('students/changepassword');
        }
      } else {
        $this->view('student/changepassword');
      }
    }
  }

?>
