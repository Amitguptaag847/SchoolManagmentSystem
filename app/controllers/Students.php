<?php

  class Students extends Controller{
    public function __construct(){
      $this->studentModel = $this->model('Student');
    }

    public function index(){ //Dashboard
      $this->view('student/dashboard');
    }

    public function viewprofile(){
      $data = $this->studentModel->getStudentProfileData(getUserId());
      $this->view('student/viewprofile',$data);
    }

    public function feedetails(){
      $data = $this->studentModel->getFeeDetails(getUserId());
      $this->view('student/feedetails',$data);
    }

    public function attendance($subject_id=""){
      if($subject_id!=""){
        $data = $this->studentModel->getAttendanceOfASubjectDetails(getUserId(),$subject_id);
        $this->view('student/attendance',$data);
      } else {
        $data = $this->studentModel->getAttendance(getUserId());
        $this->view('student/attendance',$data);
      }
    }

    public function editprofile(){
      if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $data = [
          'student_id' => getUserId(),
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
          $response = $this->studentModel->updateStudent($data);
          if($response === true){
            flash('changeStudentData','Changes Saved Successfully!!!','alert alert-success rounded');
            redirect('students/editprofile');
          } else {
            $data['error'] = 'Internal Error try after sometime';
            $this->view('student/editprofile',$data);
          }
        } else {
          $this->view('student/editprofile',$data);
        }
      } else {
        $data = $this->studentModel->getStudentProfileData(getUserId());
        $this->view('student/editprofile',$data);
      }
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

        $verifyStudent = $this->studentModel->verifyStudent(getUserId(),$_POST['oldpassword']);
        if($verifyStudent === false){
          $data['error'] = "Wrong Password";
        }

        if(empty($data['error'])){
          $changedPassword = $this->studentModel->changePassword(getUserId(),$_POST['newpassword']);
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
