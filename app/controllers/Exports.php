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

  public function downloadCSV($exportProfile) {
    // echo $exportProfile;
  }

  public function sendMail($exportProfile, $email) {


    // create timestamp from todays date, as refrence to fetch only active shares 
    // That cant be touched by user, and pass them to view
    $timestamp = strtotime('+2 Days');
    $todayCompare = date('Y-m-d', $timestamp);

    $relevantData = $this->exportModel->getRelevantData($todayCompare, $exportProfile);

    echo $this->exportModel->createCSV($relevantData, $exportProfile);
    
    // die($CSV);
    // echo $this->exportModel->createExportData($todayCompare, $exportProfile);

    
    }

    



  }

