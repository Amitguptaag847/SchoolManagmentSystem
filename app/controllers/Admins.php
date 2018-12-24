<?php
  class Admins extends Controller{
    function __construct(){
      $this->adminModel = $this->model('Admin');
    }

    public function index(){ //Dashboard
      $this->view('admin/dashboard');
    }

    public function addstudent(){
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
          if($this->adminModel->findUserByUsername($data['username'])){
            $data['error'] = 'Username is already taken';
            $this->view('admin/addstudent',$data);
          } else {
            $response = $this->adminModel->addStudent($data);
            if($response === true){
              flash('addstudent','Student Added Successfully!!!','alert alert-success rounded');
              redirect('admins/addstudent');
            } else {
              $data['error'] = $response.' Internal Error try after sometime';

              $this->view('admin/addstudent',$data);
            }
          }
        } else {
          $this->view('admin/addstudent',$data);
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

        $this->view('admin/addstudent',$data);
      }
    }

    public function viewprofile(){
      $data = $this->adminModel->getAdminProfileData(getUserId());
      $this->view('admin/viewprofile',$data);
    }

    public function editprofile(){
      if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $data = [
          'admin_id' => getUserId(),
          'first_name' => trim($_POST['first_name']),
          'last_name' => trim($_POST['last_name']),
          'date_of_birth' => trim($_POST['date_of_birth']),
          'gender' => trim($_POST['gender']),
          'email' => trim($_POST['email']),
          'mobile_number' => trim($_POST['mobile_number']),
          'current_address' => trim($_POST['current_address']),
          'current_city' => trim($_POST['current_city']),
          'current_country' => trim($_POST['current_country']),
          'current_pincode' => trim($_POST['current_pincode']),
          'permanent_address' => trim($_POST['permanent_address']),
          'permanent_city' => trim($_POST['permanent_city']),
          'permanent_country' => trim($_POST['permanent_country']),
          'permanent_pincode' => trim($_POST['permanent_pincode']),
          'fathers_name' => trim($_POST['fathers_name']),
          'mothers_name' => trim($_POST['mothers_name']),
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

        //Admin Contact number validation
        if(strlen($data['mobile_number'])!=10){
          $data['error'] = ' Your Mobile number must be 10 digit';
        }

        if(!is_Numeric($data['mobile_number'])){
          $data['error'] = 'Your mobile number should be number';
        }

        //Fathers Contact number validation
        if(strlen($data['fathers_mobile_number'])!=10){
          $data['error'] = 'Fathers Contact number must be 10 digit';
        }

        if(!is_Numeric($data['fathers_mobile_number'])){
          $data['error'] = 'Fathers Contact number should be number';
        }

        if(empty($data['error'])){
          $response = $this->adminModel->updateAdmin($data);
          if($response === true){
            flash('changeAdminData','Details changed Successfully!!!','alert alert-success rounded');
            redirect('admins/editprofile/'.$data['student_id'],$data);
          } else {
            $data['error'] = 'Internal Error try after sometime';
            $this->view('admin/editprofile',$data);
          }
        } else {
          $this->view('admin/editprofile',$data);
        }
      } else {
        $data = $this->adminModel->getAdminProfileData(getUserId());
        $this->view('admin/editprofile',$data);
      }
    }

    public function viewstudentprofile($student_id = ""){
      if($student_id != ""){
        $data = array();
        $data = $this->adminModel->getStudentProfileData($student_id);

        //Checking Student found or not
        if(count($data)==0){
          $data['student_not_found'] = true;
        }
        $this->view('admin/viewstudentprofile',$data);

      } else if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $data = array();
        if(isset($_POST['search'])){
          if($_POST['search_type'] == 'username'){
            $data = $this->adminModel->getStudentDetailsByUsername($_POST['search_keyword']);
          } else if ($_POST['search_type'] == 'rollnumber') {
            $data = $this->adminModel->getStudentDetailsByRollnumber($_POST['search_keyword']);
          } else if ($_POST['search_type'] == 'fullname') {
            $data = $this->adminModel->getStudentDetailsByFullname($_POST['search_keyword']);
          }
        } else if (isset($_POST['go'])) {
          if($_POST['class']=='allclass' && $_POST['section']=='allsection'){
            $data = $this->adminModel->getAllStudentDetails();
          } else if($_POST['class']=='allclass'){
            $data = $this->adminModel->getStudentDetailsBySection($_POST['section']);
          } else if($_POST['section']=='allsection'){
            $data = $this->adminModel->getStudentDetailsByClass($_POST['class']);
          } else {
            $data = $this->adminModel->getStudentDetailsByClassSection($_POST['class'],$_POST['section']);
          }
        }
        //Checking Student found or not
        if(count($data)==0){
          $data['student_not_found'] = true;
        }
        $this->view('admin/viewstudentprofile',$data);
      } else {
        $this->view('admin/viewstudentprofile');
      }
    }

    public function editstudentprofile($student_id = ""){
      if($student_id != ""){

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
          $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
          $data = [
            'student_id' => $student_id,
            'first_name' => trim($_POST['first_name']),
            'last_name' => trim($_POST['last_name']),
            'date_of_birth' => trim($_POST['date_of_birth']),
            'gender' => trim($_POST['gender']),
            'username' => trim($_POST['username']),
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
            //Checking username
            if($this->adminModel->findDifferentUserByUsername($data['username'],$data['student_id'])){
              $data['error'] = 'Username is already taken';
              $this->view('admin/editstudentprofile',$data);
            } else {
              $response = $this->adminModel->updateStudent($data);
              if($response === true){
                flash('changeStudentData','Student data changed Successfully!!!','alert alert-success rounded');
                redirect('admins/editstudentprofile/'.$data['student_id']);
              } else {
                $data['error'] = 'Internal Error try after sometime';

                $this->view('admin/editstudentprofile',$data);
              }
            }
          } else {
            $this->view('admin/editstudentprofile',$data);
          }
        } else {
          $data = array();
          $data = $this->adminModel->getStudentProfileData($student_id);

          //Checking Student found or not
          if(count($data)==0){
            $data['student_not_found'] = true;
          }
          $this->view('admin/editstudentprofile',$data);
        }
      } else if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $data = array();
        if(isset($_POST['search'])){
          if($_POST['search_type'] == 'username'){
            $data = $this->adminModel->getStudentDetailsByUsername($_POST['search_keyword']);
          } else if ($_POST['search_type'] == 'rollnumber') {
            $data = $this->adminModel->getStudentDetailsByRollnumber($_POST['search_keyword']);
          } else if ($_POST['search_type'] == 'fullname') {
            $data = $this->adminModel->getStudentDetailsByFullname($_POST['search_keyword']);
          }
        } else if (isset($_POST['go'])) {
          if($_POST['class']=='allclass' && $_POST['section']=='allsection'){
            $data = $this->adminModel->getAllStudentDetails();
          } else if($_POST['class']=='allclass'){
            $data = $this->adminModel->getStudentDetailsBySection($_POST['section']);
          } else if($_POST['section']=='allsection'){
            $data = $this->adminModel->getStudentDetailsByClass($_POST['class']);
          } else {
            $data = $this->adminModel->getStudentDetailsByClassSection($_POST['class'],$_POST['section']);
          }
        }

        //Checking Student found or not
        if(count($data)==0){
          $data['student_not_found'] = true;
        }
        $this->view('admin/editstudentprofile',$data);
      } else {
        $this->view('admin/editstudentprofile');
      }
    }

    public function maintainfee($student_id = ""){
      if($student_id != ""){

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
          $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
          $data = [
            "student_id"=>$student_id,
            "fee_month"=>$_POST['fee_month'],
            "payment_date"=>$_POST['payment_date'],
            "fee_amount"=>$_POST['fee_amount'],
            "payment_method"=>$_POST['payment_method'],
            "status"=>0,
            "error"=>""
          ];
          if(!empty($data['fee_month']) && !empty($data['payment_date']) && !empty($data['fee_amount']) && !empty($data['payment_method'])){
            $data['status']=1;
          }
          if($this->adminModel->validateFeeMonth($data)){
            $response = $this->adminModel->addFee($data);
            if($response === true){
              flash('addFee','Fee Details Added!!','alert alert-success rounded');
              $data = $this->adminModel->getFeeDetails($student_id);
            } else {
              flash('addFee','Select Payment Method!!','alert alert-danger rounded');
              $data = $this->adminModel->getFeeDetails($student_id);
            }
          } else {
            flash('addFee','Fee of month '.ucfirst($data['fee_month']).' is already paid!!','alert alert-danger rounded');
            $data=$this->adminModel->getFeeDetails($student_id);
          }
        } else {
          $data = array();
          $data = $this->adminModel->getFeeDetails($student_id);
        }
        $this->view('admin/maintainfee',$data);
      } else if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $data = array();
        if(isset($_POST['search'])){
          if($_POST['search_type'] == 'username'){
            $data = $this->adminModel->getStudentDetailsByUsername($_POST['search_keyword']);
          } else if ($_POST['search_type'] == 'rollnumber') {
            $data = $this->adminModel->getStudentDetailsByRollnumber($_POST['search_keyword']);
          } else if ($_POST['search_type'] == 'fullname') {
            $data = $this->adminModel->getStudentDetailsByFullname($_POST['search_keyword']);
          }
        } else if (isset($_POST['go'])) {
          if($_POST['class']=='allclass' && $_POST['section']=='allsection'){
            $data = $this->adminModel->getAllStudentDetails();
          } else if($_POST['class']=='allclass'){
            $data = $this->adminModel->getStudentDetailsBySection($_POST['section']);
          } else if($_POST['section']=='allsection'){
            $data = $this->adminModel->getStudentDetailsByClass($_POST['class']);
          } else {
            $data = $this->adminModel->getStudentDetailsByClassSection($_POST['class'],$_POST['section']);
          }
        }

        //Checking Student found or not
        if(count($data)==0){
          $data['student_not_found'] = true;
        }
        $this->view('admin/maintainfee',$data);
      } else {
        $this->view('admin/maintainfee');
      }
    }

    public function maintainattendance($student_id = "",$subject_id="",$details=""){
      if(is_Numeric($student_id) && $student_id != ""){
        if($subject_id != "") {
          if($details != ""){
            $data = $this->adminModel->getAttendanceOfASubjectDetails($student_id,$subject_id);
          } else if(is_Numeric($subject_id) && $subject_id>0 && $subject_id<8){
            if($_SERVER['REQUEST_METHOD']=="POST"){
              $attendance = strtolower($_POST['attendance']);
              $attendance_increment_by = 0;
              $cancel_increment_by = 0;
              $response = false;
              if($attendance=="present"){
                $attendance_increment_by = 1;
                $response = $this->adminModel->updateAttendance($student_id,$subject_id,$attendance_increment_by,$cancel_increment_by);
              } else if($attendance=="absent"){
                $response = $this->adminModel->updateAttendance($student_id,$subject_id,$attendance_increment_by,$cancel_increment_by);
              } else if($attendance=="cancel"){
                $cancel_increment_by = 1;
                $response = $this->adminModel->updateAttendance($student_id,$subject_id,$attendance_increment_by,$cancel_increment_by);
              }
              if($response===true){
                flash("attendanceUpdateResult","Attendance Updated!!!!","alert alert-success rounded");
              } else if($response===false){
                flash("attendanceUpdateResult","Wrong value given!!!!","alert alert-danger rounded");
              } else {
                flash("attendanceUpdateResult","Internal error try after sometime!!","alert alert-danger rounded");
              }
            }
            $data = $this->adminModel->getAttendanceDetails($student_id);
          } else {
            flash("attendanceUpdateResult","Unknown Subject!!","alert alert-danger rounded");
            $data = $this->adminModel->getAttendanceDetails($student_id);
          }
          $this->view('admin/maintainattendance',$data);
        } else {
          $data = array();
          $data = $this->adminModel->getAttendanceDetails($student_id);
        }
        $this->view('admin/maintainattendance',$data);
      } else if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $data = array();
        if(isset($_POST['search'])){
          if($_POST['search_type'] == 'username'){
            $data = $this->adminModel->getStudentDetailsByUsername($_POST['search_keyword']);
          } else if ($_POST['search_type'] == 'rollnumber') {
            $data = $this->adminModel->getStudentDetailsByRollnumber($_POST['search_keyword']);
          } else if ($_POST['search_type'] == 'fullname') {
            $data = $this->adminModel->getStudentDetailsByFullname($_POST['search_keyword']);
          }
        } else if (isset($_POST['go'])) {
          if($_POST['class']=='allclass' && $_POST['section']=='allsection'){
            $data = $this->adminModel->getAllStudentDetails();
          } else if($_POST['class']=='allclass'){
            $data = $this->adminModel->getStudentDetailsBySection($_POST['section']);
          } else if($_POST['section']=='allsection'){
            $data = $this->adminModel->getStudentDetailsByClass($_POST['class']);
          } else {
            $data = $this->adminModel->getStudentDetailsByClassSection($_POST['class'],$_POST['section']);
          }
        }

        //Checking Student found or not
        if(count($data)==0){
          $data['student_not_found'] = true;
        }
        $this->view('admin/maintainattendance',$data);
      } else {
        $this->view('admin/maintainattendance');
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

        $verifyStudent = $this->adminModel->verifyAdmin(getUserId(),$_POST['oldpassword']);
        if($verifyStudent === false){
          $data['error'] = "Wrong Password";
        }

        if(empty($data['error'])){
          $changedPassword = $this->adminModel->changePassword(getUserId(),$_POST['newpassword']);
          if($changedPassword === true){
            flash('changePassword','Password Changed Successfully!!!');
            redirect('admins/changepassword');
          } else {
            flash('changePassword','Error in changing password','alert alert-danger rounded');
            redirect('admins/changepassword');
          }
        } else {
          flash('changePassword',$data['error'],'alert alert-danger rounded');
          redirect('admins/changepassword');
        }
      } else {
        $this->view('admin/changepassword');
      }
    }
  }
?>
