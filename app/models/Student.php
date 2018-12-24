<?php

  class Student {
    private $db;

    function __construct(){
      $this->db = new Database;
    }

    public function getStudentProfileData($student_id) {
      $data = array();
      $this->db->query('SELECT * FROM `sms`.`users` WHERE user_id = :student_id AND admin = 0');
      $this->db->bind(':student_id',$student_id);
      $users = $this->db->single();

      //Checking Student Exists
      if($this->db->rowCount() > 0){
        //Get data from users table
        $data['student_id'] = $users->user_id;

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

    //Update student
    public function updateStudent($data) {
      $this->db->beginTransaction();
      try {
        $user_id = $data['student_id'];

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

    public function getFeeDetails($user_id){
      $this->db->query("SELECT *FROM `sms`.`fee` WHERE user_id = :user_id ORDER BY fee_id DESC");
      $this->db->bind(':user_id',$user_id);

      $data = array();

      $result = $this->db->resultSet();
      foreach ($result as $value) {
        $data[] = $value;
      }
      return $data;
    }

    public function getAttendance($user_id){
      $this->db->query('SELECT * FROM `sms`.`subjects`');

      $subjectData = $this->db->resultSet();

      $dataArray = array();

      foreach ($subjectData as $key => $value) {
        $this->db->query('SELECT * FROM `sms`.`attendance` WHERE subject_id = :subject_id AND user_id = :user_id');
        $this->db->bind(':subject_id',$value->subject_id);
        $this->db->bind(':user_id',$user_id);

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

      return $dataArray;
    }

    public function getAttendanceOfASubjectDetails($student_id,$subject_id){
      $this->db->query('SELECT * FROM `sms`.`attendance` WHERE subject_id = :subject_id AND user_id = :user_id');
      $this->db->bind(':subject_id',$subject_id);
      $this->db->bind(':user_id',$student_id);
      $dataArray = $this->db->resultSet();

      $dataArray['details']=true;

      return $dataArray;
    }

    public function verifyStudent($user_id,$password){
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
  }


?>
