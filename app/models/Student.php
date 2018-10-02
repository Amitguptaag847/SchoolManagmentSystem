<?php

  class Student {
    private $db;

    function __construct(){
      $this->db = new Database;
    }

    public function getFeeDetails($user_id){
      $this->db->query("SELECT *FROM `sms`.`fee` WHERE user_id = :user_id");
      $this->db->bind(':user_id',$user_id);

      $data = array();

      $result = $this->db->resultSet();
      foreach ($result as $value) {
        $data[] = $value;
      }
      return $data;
    }

    public function getAttendance($user_id){
      $this->db->query('SELECT * FROM `sms`.`attendance` WHERE user_id = :user_id');
      $this->db->bind(':user_id',$user_id);

      $attendance = $this->db->resultSet();

      $dataArray = array();

      foreach ($attendance as $key => $value) {
        $this->db->query('SELECT * FROM `sms`.`subjects` WHERE subject_id = :subject_id');
        $this->db->bind(':subject_id',$value->subject_id);

        $subjectData = $this->db->single();

        $data = array();
        $data['subject'] = $subjectData->subject_name;
        $data['attended'] = $value->attended;
        $data['cancel'] = $value->cancel;
        $data['total'] = $value->total;

        $dataArray[$key] = $data;
      }

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
