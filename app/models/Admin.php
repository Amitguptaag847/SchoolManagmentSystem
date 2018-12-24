<?php

  class Admin {
    private $db;

    function __construct(){
      $this->db = new Database;
    }

    //Find user
    public function findUserByUsername($username){
      $this->db->query('SELECT * FROM `sms`.`users` WHERE username = :username');
      $this->db->bind(':username',$username);
      $this->db->execute();
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }

    //Find user using username other than this user id
    public function findDifferentUserByUsername($username,$user_id) {
      $this->db->query('SELECT * FROM `sms`.`users` WHERE username = :username AND NOT (user_id = :user_id)');
      $this->db->bind(':username',$username);
      $this->db->bind(':user_id',$user_id);
      $this->db->execute();
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }

    //Add student
    public function addStudent($data){
      $this->db->beginTransaction();
      try {

        //Insert into users(Username,password) table
        $hashed_password = password_hash($data['password'],PASSWORD_DEFAULT);
        $this->db->query('INSERT INTO `sms`.`users` (username,password) values (:username,:password)');
        $this->db->bind(':username',$data['username']);
        $this->db->bind(':password',$hashed_password);
        $this->db->execute();

        //Geting userid from users table
        $this->db->query('SELECT * FROM `sms`.`users` WHERE username = :username');
        $this->db->bind(':username',$data['username']);
        $users_row = $this->db->single();
        $user_id = $users_row->user_id;

        //Insert into student(user_id,first_name, last_name, fullname,gender,date of birth) table
        $fullname = $data['first_name'].' '.$data['last_name'];
        $this->db->query('INSERT INTO `sms`.`student` (user_id,first_name,last_name,fullname,dob,gender,rollnumber,class,section) values (:user_id,:first_name,:last_name,:fullname,:dob,:gender,:rollnumber,:class,:section)');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':first_name',$data['first_name']);
        $this->db->bind(':last_name',$data['last_name']);
        $this->db->bind(':fullname',$fullname);
        $this->db->bind(':dob',$data['date_of_birth']);
        $this->db->bind(':gender',$data['gender']);
        $this->db->bind(':rollnumber',$data['rollnumber']);
        $this->db->bind(':class',$data['class']);
        $this->db->bind(':section',$data['section']);
        $this->db->execute();

        //Insert current address (user_id,address,country,city,pincode)
        $this->db->query('INSERT INTO `sms`.`current_address` (user_id,address,country,city,pincode) values (:user_id,:address,:country,:city,:pincode)');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':address',$data['current_address']);
        $this->db->bind(':country',$data['current_country']);
        $this->db->bind(':city',$data['current_city']);
        $this->db->bind(':pincode',$data['current_pincode']);
        $this->db->execute();

        //Insert permanent address (user_id,address,country,city,pincode)
        $this->db->query('INSERT INTO `sms`.`permanent_address` (user_id,address,country,city,pincode) values (:user_id,:address,:country,:city,:pincode)');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':address',$data['permanent_address']);
        $this->db->bind(':country',$data['permanent_country']);
        $this->db->bind(':city',$data['permanent_city']);
        $this->db->bind(':pincode',$data['permanent_pincode']);
        $this->db->execute();

        //Insert parent (user_id,fathers_name,mothers_name,fathers_occupation,mothers_occupation,annual_income,contact number)
        $this->db->query('INSERT INTO `sms`.`parents` (user_id,fathers_name,mothers_name,fathers_occupation,mothers_occupation,annual_income,fathers_mobile_number) values (:user_id,:fathers_name,:mothers_name,:fathers_occupation,:mothers_occupation,:annual_income,:fathers_mobile_number)');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':fathers_name',$data['fathers_name']);
        $this->db->bind(':mothers_name',$data['mothers_name']);
        $this->db->bind(':fathers_occupation',$data['fathers_occupation']);
        $this->db->bind(':mothers_occupation',$data['mothers_occupation']);
        $this->db->bind(':annual_income',$data['annual_income']);
        $this->db->bind(':fathers_mobile_number',$data['fathers_mobile_number']);
        $this->db->execute();

        //Initializing the attendance data
        // for($i=1;$i<=7;$i++){
        //   $this->db->query('INSERT INTO `sms`.`attendance` (user_id,subject_id) values (:user_id,:subject_id)');
        //   $this->db->bind(':user_id',$user_id);
        //   $this->db->bind(':subject_id',$i);
        //   $this->db->execute();
        // }

        $this->db->commit();
        return true;
      } catch (PDOException $e) {
        $this->db->rollBack();
        return $e->getMessage();
      }
    }

    //Update student
    public function updateStudent($data) {
      $this->db->beginTransaction();
      try {
        $user_id = $data['student_id'];

        //Upadate into users(Username) table
        $this->db->query('UPDATE `sms`.`users` SET username = :username WHERE user_id = :user_id');
        $this->db->bind(':username',$data['username']);
        $this->db->bind(':user_id',$user_id);
        $this->db->execute();

        //Update student(user_id,first_name, last_name, fullname,gender,date of birth) table
        $fullname = $data['first_name'].' '.$data['last_name'];
        $this->db->query('UPDATE `sms`.`student` SET first_name = :first_name ,last_name = :last_name,fullname = :fullname,dob = :dob,gender = :gender,rollnumber = :rollnumber,class = :class,section = :section WHERE user_id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':first_name',$data['first_name']);
        $this->db->bind(':last_name',$data['last_name']);
        $this->db->bind(':fullname',$fullname);
        $this->db->bind(':dob',$data['date_of_birth']);
        $this->db->bind(':gender',$data['gender']);
        $this->db->bind(':rollnumber',$data['rollnumber']);
        $this->db->bind(':class',$data['class']);
        $this->db->bind(':section',$data['section']);
        $this->db->execute();

        //Update current address (user_id,address,country,city,pincode)
        $this->db->query('UPDATE `sms`.`current_address` SET address = :address,country = :address,city = :city,pincode = :pincode WHERE user_id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':address',$data['current_address']);
        $this->db->bind(':country',$data['current_country']);
        $this->db->bind(':city',$data['current_city']);
        $this->db->bind(':pincode',$data['current_pincode']);
        $this->db->execute();

        //Update permanent address (user_id,address,country,city,pincode)
        $this->db->query('UPDATE `sms`.`permanent_address` SET address = :address,country = :address,city = :city,pincode = :pincode WHERE user_id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':address',$data['permanent_address']);
        $this->db->bind(':country',$data['permanent_country']);
        $this->db->bind(':city',$data['permanent_city']);
        $this->db->bind(':pincode',$data['permanent_pincode']);
        $this->db->execute();

        //Update parent (user_id,fathers_name,mothers_name,fathers_occupation,mothers_occupation,annual_income,contact number)
        $this->db->query('UPDATE `sms`.`parents` SET fathers_name = :fathers_name,mothers_name = :mothers_name,fathers_occupation = :fathers_occupation,mothers_occupation = :mothers_occupation,annual_income = :annual_income,fathers_mobile_number = :fathers_mobile_number WHERE user_id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':fathers_name',$data['fathers_name']);
        $this->db->bind(':mothers_name',$data['mothers_name']);
        $this->db->bind(':fathers_occupation',$data['fathers_occupation']);
        $this->db->bind(':mothers_occupation',$data['mothers_occupation']);
        $this->db->bind(':annual_income',$data['annual_income']);
        $this->db->bind(':fathers_mobile_number',$data['fathers_mobile_number']);
        $this->db->execute();

        $this->db->commit();

        return true;
      } catch (PDOException $e) {
        $this->db->rollBack();
        return $e->getMessage();
      }
    }

    //Students list with few info by username
    public function getStudentDetailsByUsername($username){
      $data = array();
      $this->db->query('SELECT * FROM `sms`.`users` WHERE username LIKE :username AND admin = 0');
      $this->db->bind(':username',$username."%");
      $users = $this->db->resultSet();
      foreach ($users as $key => $value) {
        $this->db->query('SELECT * FROM `sms`.`student` WHERE user_id = :user_id');
        $this->db->bind(':user_id',$value->user_id);
        $details = $this->db->single();
        $details->username = $value->username;
        $data[] = $details;
      }
      return $data;
    }

    //Students list with few info by Fullname
    public function getStudentDetailsByFullname($fullname){
      $data = array();
      $this->db->query('SELECT * FROM `sms`.`student` WHERE fullname LIKE :fullname');
      $this->db->bind(':fullname',$fullname."%");
      $students = $this->db->resultSet();
      foreach ($students as $key => $value) {
        $this->db->query('SELECT * FROM `sms`.`users` WHERE user_id = :user_id');
        $this->db->bind(':user_id',$value->user_id);
        $users = $this->db->single();
        $details = $value;
        $details->username = $users->username;
        $data[] = $details;
      }
      return $data;
    }

    //Students list with few info by roll number
    public function getStudentDetailsByRollnumber($rollnumber){
      $data = array();
      $this->db->query('SELECT * FROM `sms`.`student` WHERE rollnumber = :rollnumber');
      $this->db->bind(':rollnumber',$rollnumber);
      $students = $this->db->resultSet();
      foreach ($students as $key => $value) {
        $this->db->query('SELECT * FROM `sms`.`users` WHERE user_id = :user_id');
        $this->db->bind(':user_id',$value->user_id);
        $users = $this->db->single();
        $details = $value;
        $details->username = $users->username;
        $data[] = $details;
      }
      return $data;
    }

    //All Students
    public function getAllStudentDetails(){
      $data = array();
      $this->db->query('SELECT * FROM `sms`.`student`');
      $students = $this->db->resultSet();
      foreach ($students as $key => $value) {
        $this->db->query('SELECT * FROM `sms`.`users` WHERE user_id = :user_id');
        $this->db->bind(':user_id',$value->user_id);
        $users = $this->db->single();
        $details = $value;
        $details->username = $users->username;
        $data[] = $details;
      }
      return $data;
    }

    //Students list by Section
    public function getStudentDetailsBySection($section){
      $data = array();
      $this->db->query('SELECT * FROM `sms`.`student` WHERE section = :section');
      $this->db->bind(':section',$section);
      $students = $this->db->resultSet();
      foreach ($students as $key => $value) {
        $this->db->query('SELECT * FROM `sms`.`users` WHERE user_id = :user_id');
        $this->db->bind(':user_id',$value->user_id);
        $users = $this->db->single();
        $details = $value;
        $details->username = $users->username;
        $data[] = $details;
      }
      return $data;
    }

    //All Students by class
    public function getStudentDetailsByClass($class){
      $data = array();
      $this->db->query('SELECT * FROM `sms`.`student` WHERE class = :class');
      $this->db->bind(':class',$class);
      $students = $this->db->resultSet();
      foreach ($students as $key => $value) {
        $this->db->query('SELECT * FROM `sms`.`users` WHERE user_id = :user_id');
        $this->db->bind(':user_id',$value->user_id);
        $users = $this->db->single();
        $details = $value;
        $details->username = $users->username;
        $data[] = $details;
      }
      return $data;
    }

    //All Students by class and section
    public function getStudentDetailsByClassSection($class,$section){
      $data = array();
      $this->db->query('SELECT * FROM `sms`.`student` WHERE class = :class AND section = :section');
      $this->db->bind(':class',$class);
      $this->db->bind(':section',$section);
      $students = $this->db->resultSet();
      foreach ($students as $key => $value) {
        $this->db->query('SELECT * FROM `sms`.`users` WHERE user_id = :user_id');
        $this->db->bind(':user_id',$value->user_id);
        $users = $this->db->single();
        $details = $value;
        $details->username = $users->username;
        $data[] = $details;
      }
      return $data;
    }

    //Get Student Data
    public function getStudentProfileData($student_id) {
      $data = array();
      $this->db->query('SELECT * FROM `sms`.`users` WHERE user_id = :student_id AND admin = 0');
      $this->db->bind(':student_id',$student_id);
      $users = $this->db->single();

      //Checking Student Exists
      if($this->db->rowCount() > 0){
        //Get data from users table
        $data['student_id'] = $users->user_id;
        $data['username'] = $users->username;

        //Get data from Student Table
        $this->db->query('SELECT * FROM `sms`.`student` WHERE user_id = :student_id');
        $this->db->bind(':student_id',$data['student_id']);
        $student = $this->db->single();
        $data['first_name'] = $student->first_name;
        $data['last_name'] = $student->last_name;
        $data['date_of_birth'] = $student->dob;
        $data['gender'] = $student->gender;
        $data['rollnumber'] = $student->rollnumber;
        $data['class'] = $student->class;
        $data['section'] = $student->section;

        //Get data from Current Address Table
        $this->db->query('SELECT * FROM `sms`.`current_address` WHERE user_id = :student_id');
        $this->db->bind(':student_id',$data['student_id']);
        $address = $this->db->single();
        $data['current_address'] = $address->address;
        $data['current_country'] = $address->country;
        $data['current_city'] = $address->city;
        $data['current_pincode'] = $address->pincode;

        //Get data from Current Address Table
        $this->db->query('SELECT * FROM `sms`.`permanent_address` WHERE user_id = :student_id');
        $this->db->bind(':student_id',$data['student_id']);
        $address = $this->db->single();
        $data['permanent_address'] = $address->address;
        $data['permanent_country'] = $address->country;
        $data['permanent_city'] = $address->city;
        $data['permanent_pincode'] = $address->pincode;

        //Get data from Parent Table
        $this->db->query('SELECT * FROM `sms`.`parents` WHERE user_id = :student_id');
        $this->db->bind(':student_id',$data['student_id']);
        $parent = $this->db->single();
        $data['fathers_name'] = $parent->fathers_name;
        $data['mothers_name'] = $parent->mothers_name;
        $data['fathers_occupation'] = $parent->fathers_occupation;
        $data['mothers_occupation'] = $parent->mothers_occupation;
        $data['annual_income'] = $parent->annual_income;
        $data['fathers_mobile_number'] = $parent->fathers_mobile_number;
      }
      return $data;
    }

    public function getAdminProfileData($user_id) {
      $data = array();
      $this->db->query('SELECT * FROM `sms`.`users` WHERE user_id = :user_id AND admin = 1');
      $this->db->bind(':user_id',$user_id);
      $users = $this->db->single();

      //Checking Admin Exists
      if($this->db->rowCount() > 0){

        //Get data from Student Table
        $this->db->query('SELECT * FROM `sms`.`admin` WHERE user_id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $student = $this->db->single();
        $data['first_name'] = $student->first_name;
        $data['last_name'] = $student->last_name;
        $data['date_of_birth'] = $student->dob;
        $data['gender'] = $student->gender;
        $data['mobile_number'] = $student->mobile_number;
        $data['email'] = $student->email;

        //Get data from Current Address Table
        $this->db->query('SELECT * FROM `sms`.`current_address` WHERE user_id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $address = $this->db->single();
        $data['current_address'] = $address->address;
        $data['current_country'] = $address->country;
        $data['current_city'] = $address->city;
        $data['current_pincode'] = $address->pincode;

        //Get data from Current Address Table
        $this->db->query('SELECT * FROM `sms`.`permanent_address` WHERE user_id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $address = $this->db->single();
        $data['permanent_address'] = $address->address;
        $data['permanent_country'] = $address->country;
        $data['permanent_city'] = $address->city;
        $data['permanent_pincode'] = $address->pincode;

        //Get data from Parent Table
        $this->db->query('SELECT * FROM `sms`.`parents` WHERE user_id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $parent = $this->db->single();
        $data['fathers_name'] = $parent->fathers_name;
        $data['mothers_name'] = $parent->mothers_name;
        $data['fathers_occupation'] = $parent->fathers_occupation;
        $data['mothers_occupation'] = $parent->mothers_occupation;
        $data['annual_income'] = $parent->annual_income;
        $data['fathers_mobile_number'] = $parent->fathers_mobile_number;
      }
      return $data;
    }

    //Update admin
    public function updateAdmin($data) {
      $this->db->beginTransaction();
      try {
        $user_id = $data['admin_id'];

        //Update student(user_id,first_name, last_name, fullname,gender,date of birth) table
        $fullname = $data['first_name'].' '.$data['last_name'];
        $this->db->query('UPDATE `sms`.`admin` SET first_name = :first_name ,last_name = :last_name,fullname = :fullname,dob = :dob,gender = :gender WHERE user_id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':first_name',$data['first_name']);
        $this->db->bind(':last_name',$data['last_name']);
        $this->db->bind(':fullname',$fullname);
        $this->db->bind(':dob',$data['date_of_birth']);
        $this->db->bind(':gender',$data['gender']);
        $this->db->execute();

        //Update current address (user_id,address,country,city,pincode)
        $this->db->query('UPDATE `sms`.`current_address` SET address = :address,country = :address,city = :city,pincode = :pincode WHERE user_id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':address',$data['current_address']);
        $this->db->bind(':country',$data['current_country']);
        $this->db->bind(':city',$data['current_city']);
        $this->db->bind(':pincode',$data['current_pincode']);
        $this->db->execute();

        //Update permanent address (user_id,address,country,city,pincode)
        $this->db->query('UPDATE `sms`.`permanent_address` SET address = :address,country = :address,city = :city,pincode = :pincode WHERE user_id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':address',$data['permanent_address']);
        $this->db->bind(':country',$data['permanent_country']);
        $this->db->bind(':city',$data['permanent_city']);
        $this->db->bind(':pincode',$data['permanent_pincode']);
        $this->db->execute();

        //Update parent (user_id,fathers_name,mothers_name,fathers_occupation,mothers_occupation,annual_income,contact number)
        $this->db->query('UPDATE `sms`.`parents` SET fathers_name = :fathers_name,mothers_name = :mothers_name,fathers_mobile_number = :fathers_mobile_number WHERE user_id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':fathers_name',$data['fathers_name']);
        $this->db->bind(':mothers_name',$data['mothers_name']);
        $this->db->bind(':fathers_mobile_number',$data['fathers_mobile_number']);
        $this->db->execute();

        $this->db->commit();

        return true;
      } catch (PDOException $e) {
        $this->db->rollBack();
        return $e->getMessage();
      }
    }

    //Checking admin for changing password
    public function verifyAdmin($user_id,$password){
      $this->db->query('SELECT * FROM `sms`.`users` WHERE user_id = :user_id');
      $this->db->bind(':user_id',$user_id);

      $row = $this->db->single();

      $hashed_password = $row->password;

      if(password_verify($password,$hashed_password)){
        return true;
      } else {
        return false;
      }
    }

    //Changing password of admin
    public function changePassword($user_id,$password){

      $hashed_password = password_hash($password,PASSWORD_DEFAULT);

      $this->db->beginTransaction();
      try {
        $this->db->query('UPDATE `sms`.`users` SET password = :password WHERE user_id = :user_id');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':password',$hashed_password);
        $this->db->execute();

        $this->db->commit();
        return true;
      } catch (PDOException $e) {
        $this->db->rollBack();
        return $e->getMessage();
      }
    }

    public function getAttendanceDetails($student_id){
      $this->db->query('SELECT * FROM `sms`.`subjects`');

      $subjectData = $this->db->resultSet();

      $dataArray = array();

      foreach ($subjectData as $key => $value) {
        $this->db->query('SELECT * FROM `sms`.`attendance` WHERE subject_id = :subject_id AND user_id = :user_id');
        $this->db->bind(':subject_id',$value->subject_id);
        $this->db->bind(':user_id',$student_id);

        $attendanceData = $this->db->resultSet();

        $data = array();
        $data['subject'] = $value->subject_name;
        $data['subject_id'] = $value->subject_id;
        $data['total'] = $this->db->rowCount();
        if($data['total']==0){
          $data['attended'] = 0;
          $data['cancel'] = 0;
        } else {
          $count1 = 0;
          $count2 = 0;
          foreach ($attendanceData as $key1 => $value1) {
            if($value1->attended==1){
              $count1++;
            } else if($value1->cancel==1) {
              $count2++;
            }
          }
          $data['attended']=$count1;
          $data['cancel']=$count2;
        }

        $dataArray[$key] = $data;
      }
      $dataArray['student_id']=$student_id;

      return $dataArray;
    }

    public function getAttendanceOfASubjectDetails($student_id,$subject_id){
      $this->db->query('SELECT * FROM `sms`.`attendance` WHERE subject_id = :subject_id AND user_id = :user_id');
      $this->db->bind(':subject_id',$subject_id);
      $this->db->bind(':user_id',$student_id);
      $dataArray = $this->db->resultSet();

      $dataArray['student_id']=$student_id;

      $dataArray['details']=true;

      return $dataArray;
    }

    public function updateAttendance($student_id,$subject_id,$attended,$cancel){
      $this->db->beginTransaction();
      try {
        $this->db->query('INSERT INTO `sms`.`attendance` (date ,attended, cancel, user_id, subject_id) VALUES (:date,:attended,:cancel,:user_id,:subject_id)');
        $this->db->bind(':attended',$attended);
        $this->db->bind(':date',date('Y:m:d', time()));
        $this->db->bind(':cancel',$cancel);
        $this->db->bind(':user_id',$student_id);
        $this->db->bind(':subject_id',$subject_id);
        $this->db->execute();

        $this->db->commit();
        return true;
      } catch(PDOException $e){
        $this->db->rollBack();
        return $e->getMessage();
      }
    }

    public function getFeeDetails($student_id){
      $this->db->query("SELECT *FROM `sms`.`fee` WHERE user_id = :user_id ORDER BY fee_id DESC");
      $this->db->bind(':user_id',$student_id);

      $data = array();

      $result = $this->db->resultSet();
      foreach ($result as $value) {
        $data[] = $value;
      }
      $data["student_id"]=$student_id;
      return $data;
    }

    public function addFee($data){
      $this->db->beginTransaction();
      try{
        $this->db->query("INSERT INTO `sms`.`fee` (user_id,fee_month,payment_date,fee_amount,payment_method,status) VALUES (:user_id,:fee_month,:payment_date,:fee_amount,:payment_method,:status)");
        $this->db->bind(":user_id",$data['student_id']);
        $this->db->bind(":fee_month",$data['fee_month']);
        $this->db->bind(":payment_date",$data['payment_date']);
        $this->db->bind(":fee_amount",$data['fee_amount']);
        $this->db->bind(":payment_method",$data['payment_method']);
        $this->db->bind(":status",$data['status']);
        $this->db->execute();

        $this->db->commit();
        return true;
      } catch (PDOException $e) {
        $this->db->rollBack();
        return false;
      }
    }

    public function validateFeeMonth($data){
      $this->db->query("SELECT * FROM `sms`.`fee` WHERE fee_month = :fee_month AND user_id = :user_id");
      $this->db->bind(":user_id",$data['student_id']);
      $this->db->bind(":fee_month",$data['fee_month']);
      $this->db->execute();

      if($this->db->rowCount() > 0){
        return false;
      } else {
        return true;
      }
    }
  }
?>
