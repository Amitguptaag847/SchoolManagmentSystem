<?php
  session_start();

  function flash($name = '', $message = '', $class = 'alert alert-success'){
    if(!empty($name)){
      if(!empty($message) && empty($_SESSION[$name])){
        if(!empty($_SESSION[$name])){
          unset($_SESSION[$name]);
        }

        if(!empty($_SESSION[$name. '_class'])){
          unset($_SESSION[$name. '_class']);
        }

        $_SESSION[$name] = $message;
        $_SESSION[$name. '_class'] = $class;
      } elseif(empty($message) && !empty($_SESSION[$name])){
        $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
        echo '<div class="'.$class.' rounded-0" id="msg-flash">'.$_SESSION[$name].'</div>';
        unset($_SESSION[$name]);
        unset($_SESSION[$name. '_class']);
      }
    }
  }

  function setSession($name='',$value=''){
    if(!empty($name) && !empty($value)){
      if(isset($_SESSION[$name])){
        unset($_SESSION[$name]);
        $_SESSION[$name] = $value;
      } else {
        $_SESSION[$name] = $value;
      }
    }
  }

  function destroySession(){
    session_destroy();
    redirect('users/login');
  }

  function isLoggedIn(){
    if(isset($_SESSION['user_id'])){
      return true;
    } else {
      return false;
    }
  }

  function isSessionAdmin(){
    if(isset($_SESSION['sessionAdmin'])){
      return $_SESSION['sessionAdmin'];
    } else {
      return false;
    }
  }

?>
