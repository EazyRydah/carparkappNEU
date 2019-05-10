<?php

  class Parking{
    
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Modelmethods are accessable in Controller!
    public function getParkings($user_id){
      $this->db->query('SELECT * FROM parkings WHERE user_id = :user_id');
      $this->db->bind(':user_id',$user_id);
      
      // Return more than one row of db object array
      $results = $this->db->resultSet();

      return $results;
    }

    public function getParkingById($parking_id) {
      $this->db->query('SELECT * FROM parkings WHERE id = :id');
      $this->db->bind(':id', $parking_id);

      $row = $this->db->single();

      return $row;
    }

    // Find parking by contract id
    public function findParkingByContractId($contract_id) {
        
      $this->db->query('SELECT * FROM parkings WHERE contract_id = :contract_id');
      // Bind methodinput from controller, to named parameter from SQL query
      $this->db->bind(':contract_id', $contract_id);

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

    // Find parking by key id
    public function findParkingByKeyId($key_id) {
    
      $this->db->query('SELECT * FROM parkings WHERE key_id = :key_id');
      // Bind methodinput from controller, to named parameter from SQL query
      $this->db->bind(':key_id', $key_id);

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

     // Find parking by key id
     public function checkContractKeyPair($contract_id, $key_id) {
    
      $this->db->query('SELECT * FROM parkings WHERE contract_id = :contract_id AND key_id = :key_id');
      // Bind methodinput from controller, to named parameter from SQL query
      $this->db->bind(':contract_id', $contract_id);
      $this->db->bind(':key_id', $key_id);

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

  public function addParking($data){

    // Create db query to push data to db, using named params
    $this->db->query('UPDATE parkings SET user_id = :user_id WHERE contract_id = :contract_id AND key_id = :key_id');

    // Bind values 
    $this->db->bind(':user_id', $data['user_id']);
    $this->db->bind(':contract_id', $data['contract_id']);
    $this->db->bind(':key_id', $data['key_id']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  }


    
   

    
  