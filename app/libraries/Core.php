<?php

/*
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */

class Core {
  protected $currentController = 'Pages';
  protected $currentMethod = 'index';
  protected $params = [];

  public function __construct(){
    //print_r($this->getUrl());
    $url = $this->getUrl();

    //Look in controllers for first value
    if(file_exists('../app/controllers/'.$url[0].'.php')){
      //If exists set as controller
      $this->currentController = ucwords($url[0]);
      //Unset 0 Index;
      unset($url[0]);
    }
    //Require the controllers
    require_once '../app/controllers/'.$this->currentController.'.php';
    //Intantiate controller
    $this->currentController = new $this->currentController;

    // CHeck for second part of controller
    if(isset($url[1])){
      //Check to see if methode exists in controllers
      if(method_exists($this->currentController,$url[1])){
        $this->currentMethod = $url[1];
        //Unset 1 index
        unset($url[1]);
      }

      //Get params
      $this->params = $url ? array_values($url) : [];

      //Call a calback with array of params
    }
    call_user_func_array([$this->currentController,$this->currentMethod],$this->params);
  }

  public function getUrl(){
    if(isset($_GET['url'])){   //$_GET['url'] give the url
      $url = rtrim($_GET['url'],'/');  //Removes the ending '/' if there is anyone
      $url = filter_var($url,FILTER_SANITIZE_URL); //Removes Illegal character from url
      $url = explode('/',$url);
      return $url;
    }
  }
}

?>
