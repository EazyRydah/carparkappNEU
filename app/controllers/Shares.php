<?php

class Shares extends Controller {

  public function __construct(){
    // If not logged id
    if(!isLoggedIn()){
      redirect('users/login');
    }

  // Check models folder for file called Share.php
  $this->shareModel = $this->model('Share');

  }

  public function index(){
    
    // Get data from model
    $parkings = $this->shareModel->getParkings($_SESSION['user_id']);
    
    // Put db data from model into array, to make it accessable in index view
    $data = [
      'parkings' => $parkings
    ];

    // die(print_r($data));
    $this->view('parkings/index', $data);
  }

  public function add($parking_id){
    // TODOOOO

    // die($parking_id);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST array
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  
      $data=[
        'parking_id' => $parking_id,
        'share_start' => trim($_POST['share_start']),
        'share_end' => trim($_POST['share_end']),
        'user_id' => $_SESSION['user_id'],
      // parking / contract_id needed to store in share table?
        'share_start_err' => '',
        'share_end_err' => ''
      ];

      // die(var_dump($data));

      // Validate Input
      if (empty($data['share_start'])) {
        $data['share_start_err'] = 'Please select share_start';
      } 

      if (empty($data['share_end'])) {
        $data['share_end_err'] = 'Please select share_end';
      } 

     
      // Make sure no errors
      if (empty($data['share_start_err']) && empty($data['share_end_err'])) {

        // If Array is false means its empty continue and Add share input Data to database
        if (!$this->shareModel->shareExists($parking_id, $data)) {

          // VIEW MODAL 
          // die('LOL');

          

            if($this->shareModel->addShare($data)) {
              // die(var_dump($data));
              // $this->shareModel->CSVDump();
              $this->shareModel->sendUserMail($data, "add");
              flash('parking_message','Share Added');
              redirect('parkings');
              // Set function to end, to enhance UX
             
            }else {
              die('something went wrong');
            }
        
          
        
        } else {

          $sharesToUpdate = $this->shareModel->shareExists($parking_id,$data);

          if ($this->shareModel->updateShare($sharesToUpdate)) {
            // Call Modal to let User confirm that he wants
            $this->shareModel->addShare($data);
            $this->shareModel->sendUserMail($data, "add");
            flash('parking_message','Share Updated');
            redirect('parkings');
            // Set function to end, to enhance UX
           
          } else {
            die('something went wrong');
          }
        
        }
        // Validated
        // Call model method

      } else {
        // Load view with errors

        $this->view('shares/add', $data);
      }

      // die(print_r($data));
     
    } else {
      // die('lol');

    // Put db data from model into array, to make it accessable in index view
    // Get exisitng parking from Model

    // $parking = $this->parkingModel->getParkings()

    $parking = $this->shareModel->getParkingById($parking_id);

    if ($parking->user_id != $_SESSION['user_id']) {
      redirect('parkings');
    }

    $data = [
      'parking_id' => $parking_id,
      'share_start' => '',
      'share_end' => ''
    ];

    }

    $this->view('shares/add', $data);
  }
  
  public function show($parking_id){
    // $parkings = $this->parkingModel->getParkings($_SESSION['user_id']);

    $share = $this->shareModel->getShareByParkingId($parking_id);

    if ($share->user_id != $_SESSION['user_id']) {
      redirect('parkings');
    }

    $shares = $this->shareModel->getShares($parking_id);
    
    // create todays date, to compare existing shares and display correctly
    $timestamp = strtotime('+2 Days');
    $todayCompare = date('Y-m-d',$timestamp);
   
    $data = [
      // 'parkings' => $parkings,
      'shares' => $shares,
      'today' => $todayCompare
    ];

    $this->view('shares/show', $data);

  }

  public function remove($share_id) {

    // NOTE: GET METHOD IS INSECURE! anker element is not the way to go, better a form - but for prototype purpose its ok!
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $share = $this->shareModel->getShareByShareId($share_id);
      
      // die(var_dump($share->share_start));
      // die($share->user_id);

      if ($share->user_id != $_SESSION['user_id']) {
        // die('redirected!');
        redirect('parkings');
      } else 
      {

        if ($this->shareModel->removeShare($share_id)) {
  
          // die(var_dump($share)); 
          // $share = $this->shareModel->getShareByShareId($share_id);
          
          // TOODOOO - Maybe convert $shareobject into array first - but makes not really sense...hmmm - why the heck is email function not working with share
          $this->shareModel->sendUserMail($share, "remove");

          flash('parking_message', 'Share removed');
          // $this->view('parkings/show');
          // die($share_id);
          // die(var_dump());
          redirect('shares/show/' . $share->parking_id);
          // die(var_dump($share));
        

          // die('lol');
  
        } else {
          die('Something went wrong');
        }
      }
     
    } else {

      redirect('shares/show/' . $share_id);
    }
  }

   // Wie kann ich dieser funktion die parkingid zukommen lassen?
   public function loadAjaxData($parking_id) {

    echo $this->shareModel->getSharesJSONString($parking_id);
  }

   public function loadAjaxDataObject($parking_id) {

    echo $this->shareModel->getSharesByParkingIdJSON($parking_id);

  }

}