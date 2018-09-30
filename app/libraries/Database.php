<?php

/*
 * PDO database class
 * Connect to database
 * Create prepared statements
 * Bind Values
 * Return the row and result
 */

class Database {
  private $host = DB_HOST;
  private $user = DB_USER;
  private $pass = DB_PASS;
  private $dbname = DB_NAME;

  private $dbh;
  private $stmt;
  private $error;

  public function __construct(){
    //SET SDN
    $dsn =  'mysql:host='.$this->host.';dbname='.$this->dbname;
    $options = array(
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    //create PDO instance
    try {
      $this->dbh = new PDO($dsn,$this->user,$this->pass,$options);
    } catch (PDOException $e){
      $this->error = $e->getMessage();
      echo $this->error;
    }
  }

    //Prepared Statement with query
    public function query($sql){
      $this->stmt = $this->dbh->prepare($sql);
    }

    //Bind value
    public function bind($param,$value,$type = null){
      if(is_null($type)){
        switch (true) {
          case is_int($value):
            $type = PDO::PARAM_INT;
            break;
          case is_bool($value):
            $type = PDO::PARAM_BOOL;
            break;
          case is_null($value):
            $type = PDO::PARAM_NULL;
            break;
          default:
            $type = PDO::PARAM_STR;
        }
      }

      $this->stmt->bindValue($param,$value,$type);
    }

    //Execute the prepared statement
    public function execute(){
      return $this->stmt->execute();
    }

    //Get result set as array of objects
    public function resultSet(){
      $this->execute();
      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //Get single record as object
    public function single(){
      $this->execute();
      return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    //Get the row count
    public function rowCount(){
      return $this->stmt->rowCount();
    }

    //Begin Transaction
    public function beginTransaction(){
      return $this->dbh->beginTransaction();
    }

    //rollBack
    public function rollBack(){
      return $this->dbh->rollBack();
    }

    //commit
    public function commit(){
      return $this->dbh->commit();
    }
}

?>
