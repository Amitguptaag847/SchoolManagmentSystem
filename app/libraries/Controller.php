<?php

  /*
   * Base Controller
   *  Loads Models and Views
   */
class Controller {
  //Load Model
  public function model($model){
    //require modal file
    require_once '../app/models/'.$model.'.php';

    // Intantiate model
    return new $model();
  }

  //Load Views
  public function view($view, $data = []){
    //Check for view file
    if(file_exists('../app/views/'. $view . '.php')){
      require_once '../app/views/'. $view . '.php';
    } else {
      //View Does not exists
      die('View Does not exist');
    }
  }
}

?>
