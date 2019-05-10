<?php

class Parkings extends Controller {

  public function __construct(){

    // If not logged id
    if(!isLoggedIn()){
      redirect('users/login');
    }

    if(isAdmin()){
      // die(isAdmin());
      redirect('exports');
    }

    // Load parking model
    $this->parkingModel = $this->model('Parking');

  }

  public function index(){
    
    // Get data from model
    $parkings = $this->parkingModel->getParkings($_SESSION['user_id']);
    
    // Put db data from model into array, to make it accessable in index view
    $data = [
      'parkings' => $parkings
    ];

    $this->view('parkings/index', $data);
  }


  // Add Parking Function
  public function add(){

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST array
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $data = [
        'contract_id' => trim($_POST['contract_id']),
        'key_id' => trim($_POST['key_id']),
        'user_id' => $_SESSION['user_id'],

        'contract_id_err' => '',
        'key_id_err' => ''
      ];

      // Validate Data
      if (empty($data['contract_id'])) {
        $data['contract_id_err'] = 'Please enter contract_id';
      } else {
         // Check for contract_id
         if ($this->parkingModel->findParkingByContractid($data['contract_id'])) {
          // Contract_id found
          } else {
          // Parking not found
          $data['contract_id_err'] = 'Parking not found';
          }
      }

      if (empty($data['key_id'])) {
        $data['key_id_err'] = 'Please enter key_id';
      }

        // Validate Data
        if (empty($data['key_id'])) {
        $data['key_id_err'] = 'Please enter key_id';
      } else {
          // Check for key_id
          if ($this->parkingModel->findParkingByKeyId($data['key_id'])) {
          // key_id found
          } else {
          // Key not found
          $data['key_id_err'] = 'Key not found';
          }
      }

      // Check for Contract/Key Pair
      if ($this->parkingModel->checkContractKeyPair($data['contract_id'],$data['key_id'])) { 

      } else {
        $data['key_id_err'] = 'key_id doenst match contract_id';
      }

      // Make sure no errors
      if (empty($data['contract_id_err']) && empty($data['key_id_err'])) {
        
        // Validated
        // Call model method
        if ($this->parkingModel->addParking($data)) {
          flash('parking_message','Parking Added');
          redirect('parkings');
        } else {
          die('something went wrong');
        }

      } else {
        // Load view with errors
        $this->view('parkings/add', $data);
      }

    } else {

      // Put db data from model into array, to make it accessable in index view
    $data = [
      'contract_id' => '',
      'key_id' => ''
    ];
    }

    $this->view('parkings/add', $data);
  } 

}