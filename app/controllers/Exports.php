<?php

class Exports extends Controller {

  public function __construct(){

     // If not logged id
     if(!isAdmin()){
      redirect('parkings');
    }


      // Load parking model
      $this->exportModel = $this->model('Export');

  }

  public function index(){
    
   // Get data from model
  //  $parkings = $this->parkingModel->getParkings($_SESSION['user_id']);
    
   // Put db data from model into array, to make it accessable in index view
   $data = [
     
   ];

   // die(print_r($data));
   $this->view('exports/index', $data);
  }

  public function downloadCSV() {
    die('PETER PAN!');
  }

  public function sendMail($exportProfileText) {
    if (isset($_GET[''])) {
      # code...
    }
  }

}