<?php
class User {
  // Create database var
  private $db;

  // Call an instance of PDO class and store in $db
  public function __construct() {
    $this->db = new Database;
  }

  // Register User - method gets full data array from controller
  public function register($data) {

    // Create db query to push data to db, using named params
    $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');

    // Bind values 
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':password', $data['password']);

    // INSERT, UPDATE, DELETE - operations needs to call execute method from db library
    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }

  }

  // Login User
  public function login($email, $password) {
    // Create query
    $this->db->query('SELECT * FROM users WHERE email = :email');
    $this->db->bind(':email', $email);

    $row = $this->db->single();
    // die(var_dump($row));
    $hashed_password = $row->password;

    if (password_verify($password,$hashed_password)) {
      return $row;
    } else {
      return false;
    }
  }

  // Find user by email
  public function findUserByEmail($email) {
    
    $this->db->query('SELECT * FROM users WHERE email = :email');
    // Bind methodinput from controller, to named parameter from SQL query
    $this->db->bind(':email', $email);

    // Get single data and save in var
    $row = $this->db->single();

    // Check for row with data
    if ($this->db->rowCount() > 0) {
      // data is found 
      return true;
    } else {
      return false;
    }
  }

  
}