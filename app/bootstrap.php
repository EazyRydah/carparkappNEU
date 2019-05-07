<?php

// Load Config
require_once 'config/config.php';

// Load Helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';


// Load PHPMailer Library
// require_once 'helpers/PHPMailer/Exception.php';
// require_once 'helpers/PHPMailer/PHPMailer.php';
// require_once 'helpers/PHPMailer/SMTP.php';

// use PHPMailer\PHPMailer\PHPMailer;





// Load Libraries
// require_once 'libraries/Core.php';
// require_once 'libraries/Controller.php';
// require_once 'libraries/Database.php';



// Load PHPMailer Library
// require_once 'libraries/PHPMailer/Exception.php';
// require_once 'libraries/PHPMailer/PHPMailer.php';
// require_once 'libraries/PHPMailer/SMTP.php';



// Autoload Core Libraries - Cleaner way
spl_autoload_register(function($className){
  require 'libraries/' . $className . '.php';});

