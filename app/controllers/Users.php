<?php

class Users extends Controller {

  // Constructor needed to load model
  public function __construct(){

    // Check models folder for file called User.php
    $this->userModel = $this->model('User');

  }

  // Register function - loading register form and handle post-requests
  public function register(){
    
    // Check if form is loaded or POST request is send
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      // Process form
      // Sanitize POST data array - clean all invalid characters
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      // Init data
      $data = [
        // Fill with form inputdata from register-view and HTML input name-attribute
        // Trim-Method to prevent white-space
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),

        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => '',
      ];

      // VALIDATION

      // if submitted but email is empty, ouput error
      if (empty($data['name'])) {
        $data['name_err'] = 'Please enter your full name';
      }  

      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter email';
      } else {
        // Check if email already used
        if ($this->userModel->findUserByEmail($data['email'])) {
          $data['email_err'] = 'Email is already taken';
        } 
      }

      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter password';
      } elseif(strlen($data['password']) < 6) {
        $data['password_err'] = 'Password must be at least 6 characters';
      }

      if (empty($data['confirm_password'])) {
        $data['confirm_password_err'] = 'Please confirm password';
      } else {
        if ($data['password'] != $data['confirm_password']) {
          $data['confirm_password_err'] = 'Passwords do not match';
        }

      }

      // Make sure errors are emtpy
      if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
        // die('SUCCESS');

        // Hash password, before storing in db
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Call model function - register user
        if ($this->userModel->register($data)) {
          // if registering user went okay, redirect to login page
          flash('register_success', 'You are registered and can log in');
          redirect('users/login');
        } else {
          die('Something went wrong');
        }
        
      } else {
        // Load view with errors
        $this->view('users/register', $data);
      }

    

    } else {

      // Init Data before loading view
      // So If there is input error, data could remain in form
      // No total retyping/refilling nessessary
      $data = [
        'name' => '',
        'email' => '',
        'password' => '',
        'confirm_password' => '',

        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => '',
      ];

      // Load view and pass data
      $this->view('users/register', $data);
    }
  }

  // Loading login form and handle post-requests
  public function login(){
    
    // Check if form is loaded or POST request is send
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Process form

      // Sanitize POST data array - clean all invalid characters
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      // Init data
      $data = [
        // Fill with form inputdata from register-view and HTML input name-attribute
        // Trim-Method to prevent white-space
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),

        'email_err' => '',
        'password_err' => '',
      ];

      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter email';
      }  else {
        // Check for user/email
        if ($this->userModel->findUserByEmail($data['email'])) {
        // User found
        } else {
        // User not found
        $data['email_err'] = 'No user found';
        }

      }

      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter password';
      } 

      

      // Make sure errors are emtpy
      if (empty($data['email_err']) && empty($data['password_err'])) {

        // Validated
        // Check and set logged in user
        $loggedInUser = $this->userModel->login($data['email'], $data['password']);

        if ($loggedInUser) {

        // Create Session 
        $this->createUserSession($loggedInUser);

        
        } else {
        
          // Rerender View with error
          $data['password_err'] = 'Password incorrect';
          $this->view('users/login', $data);

        }
      } else {

        // Load view with errors
        $this->view('users/login', $data);
      }


    } else {

      // Init Data before loading view
      // So If there is input error, data could remain in form
      // No total retyping/refilling nessessary
      $data = [
       
        'email' => '',
        'password' => '',
       
        'email_err' => '',
        'password_err' => ''

      ];

      // Load view and pass data
      $this->view('users/login', $data);
    }
  }

  public function createUserSession($user) {
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_role'] = $user->role;
    $_SESSION['user_name'] = $user->name;
    $_SESSION['user_email'] = $user->email;
    redirect('parkings');
  }

  public function logout(){
    unset($_SESSION['user_id']);
    unset($_SESSION['user_role']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_email']);
    session_destroy();
    redirect('users/login');
  }

}