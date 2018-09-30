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
