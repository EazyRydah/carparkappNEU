<?php
  // needed to be initialized on every page, where sessions are used
  session_start();

  // Flash message helper
  // EXAMPLE - flash('register_success', 'You are now registered', 'alert alert-danger');
  // DISPLAY IN VIEW - <?php echo flash('register_success'); 
  function flash($name= '', $message='', $class='alert alert-success'){
    if (!empty($name)) {
      if (!empty($message) && empty($_SESSION[$name])) {
        
        // IF session isset, unset before rename
        if (!empty($_SESSION[$name])) {
          unset($_SESSION[$name]);
        }
        if (!empty($_SESSION[$name. '_class'])) {
          unset($_SESSION[$name. '_class']);
        }
        $_SESSION[$name] = $name;
        $_SESSION[$name. '_class'] = $class;
      } elseif(empty($message) && !empty($_SESSION[$name])){
        $class = !empty($_SESSION[$name. '_class']) ?  $_SESSION[$name. '_class'] : '';
        echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
        unset($_SESSION[$name]);
        unset($_SESSION[$name. '_class']);
      }
    }
  }

  // Simple function to check if user islogged in
  function isLoggedIn(){
    if (isset($_SESSION['user_id'])) {
      return true;
    } else {
      return false;
    }
  }

  function isAdmin(){ 
  if ($_SESSION['user_role'] == 'admin') {
      return true;
    } else {
      return false;
    }
}

  function calculateTimestampDifference($timestamp2, $timestamp1){
    // return date('d', strtotime($timestamp2) - strtotime($timestamp1));
    return abs (strtotime($timestamp2) - strtotime($timestamp1)) / 86400;
  }

  // function calculateCreditItem($amountDays, $creditItemPerDay) {
    
  //   $result = floatval($amountDays) * $creditItemPerDay;
    
  //   return $result;
  // }
