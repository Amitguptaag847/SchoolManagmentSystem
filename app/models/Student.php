<?php

  class Student {
    private $db;

    function __construct(){
      $this->db = new Database;
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
