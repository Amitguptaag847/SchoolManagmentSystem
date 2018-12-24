<?php

  class User {
    private $db;

    public function __construct(){
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

    //Login
    public function login($username,$password){
      $this->db->query('SELECT * FROM `sms`.`users` WHERE username = :username');
      $this->db->bind(':username',$username);

      $row = $this->db->single();

      $hashed_password = $row->password;

      if(password_verify($password,$hashed_password)){
        return $row;
      } else {
        return false;
      }
    }

    public function register($data){
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

    //Change Password
    public function changePassword($username,$password){
      $hashed_password = password_hash($password,PASSWORD_DEFAULT);

      $this->db->beginTransaction();
      try {
        $this->db->query('UPDATE `sms`.`users` SET password = :password WHERE username = :username');
        $this->db->bind(':username',$username);
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
