<?php

class Parkings extends Controller {


  
  public function __construct(){
    // If not logged id
    if(!isLoggedIn()){
      redirect('users/login');
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

    // die(print_r($data));
    $this->view('parkings/index', $data);
  }


  // Add Parking Function
  public function add(){

    // TODOOOO
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

  // public function show($parking_id){
  //   // $parkings = $this->parkingModel->getParkings($_SESSION['user_id']);

  //   $share = $this->parkingModel->getShareByParkingId($parking_id);

  //   if ($share->user_id != $_SESSION['user_id']) {
  //     redirect('parkings');
  //   }


  //   $shares = $this->parkingModel->getShares($parking_id);
    
  //   // create todays date, to compare existing shares and display correctly
  //   $timestamp = strtotime('+2 Days');
  //   $todayCompare = date('Y-m-d',$timestamp);
   
  //   $data = [
  //     // 'parkings' => $parkings,
  //     'shares' => $shares,
  //     'today' => $todayCompare
  //   ];

  //   $this->view('parkings/show', $data);

  // }

  // public function remove($share_id) {

  //   // NOTE: GET METHOD IS INSECURE! anker element is not the way to go, better a form - but for prototype purpose its ok!
  //   if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //     $share = $this->parkingModel->getShareByShareId($share_id);
      
  //     // die($share->user_id);

  //     if ($share->user_id != $_SESSION['user_id']) {
  //       // die('redirected!');
  //       redirect('parkings');
  //     } else 
  //     {

  //       if ($this->parkingModel->removeShare($share_id)) {

  //         flash('parking_message', 'Share removed');
  //         // $this->view('parkings/show');
  //         // die($share_id);
  //         // die(var_dump());
  //         redirect('parkings/show/' . $share->parking_id);
  //         // die('lol');
  
  //       } else {
  //         die('Something went wrong');
  //       }
  //     }
     
  //   } else {

  //     redirect('parkings/show/' . $share_id);
  //   }
  // }





  // // TODO
  // public function share($parking_id){


  //   // die($parking_id);

  //   // TODOOOO
  //   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //     // Sanitize POST array
  //     $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  
  //     $data=[
  //       'parking_id' => $parking_id,
  //       'share_start' => trim($_POST['share_start']),
  //       'share_end' => trim($_POST['share_end']),
  //       'user_id' => $_SESSION['user_id'],
  //     // parking / contract_id needed to store in share table?
  //       'share_start_err' => '',
  //       'share_end_err' => ''
  //     ];

  //     // die(print_r($data));

  //     // Validate Input
  //     if (empty($data['share_start'])) {
  //       $data['share_start_err'] = 'Please select share_start';
  //     } 

  //     if (empty($data['share_end'])) {
  //       $data['share_end_err'] = 'Please select share_end';
  //     } 

     
  //     // Make sure no errors
  //     if (empty($data['share_start_err']) && empty($data['share_end_err'])) {
        
  //       // If Array is false means its empty continue and Add share input Data to database
  //       if (!$this->parkingModel->shareExists($parking_id, $data)) {

  //         // VIEW MODAL 
  //         // die('LOL');

  //         if ($this->parkingModel->addShare($data)) {
  //           flash('parking_message','Share Added');
  //           redirect('parkings');
  //         } else {
  //           die('something went wrong');
  //         }
        
  //       } else {

  //         $sharesToUpdate = $this->parkingModel->shareExists($parking_id,$data);

  //         if ($this->parkingModel->updateShare($sharesToUpdate)) {
  //           // Call Modal to let User confirm that he wants
  //           $this->parkingModel->addShare($data);
  //           flash('parking_message','Share Updated');
  //           redirect('parkings');
  //         } else {
  //           die('something went wrong');
  //         }
        
  //       }
  //       // Validated
  //       // Call model method


  //     } else {
  //       // Load view with errors

  //       $this->view('parkings/share', $data);
  //     }


  //     // die(print_r($data));
     
  //   } else {

  //   // Put db data from model into array, to make it accessable in index view
  //   // Get exisitng parking from Model

  //   // $parking = $this->parkingModel->getParkings()

  //   $parking = $this->parkingModel->getParkingById($parking_id);

  //   if ($parking->user_id != $_SESSION['user_id']) {
  //     redirect('parkings');
  //   }

  //   $data = [
  //     'parking_id' => $parking_id,
  //     'share_start' => '',
  //     'share_end' => ''
  //   ];

  //   }

  //   $this->view('parkings/share', $data);
  // }

   // Wie kann ich dieser funktion die parkingid zukommen lassen?
  //  public function loadAjaxData($parking_id) {

  //   echo $this->parkingModel->getSharesJSONString($parking_id);
  // }


  //  public function loadAjaxDataObject($parking_id) {

  //   echo $this->parkingModel->getSharesByParkingIdJSON($parking_id);

  // }


  

}