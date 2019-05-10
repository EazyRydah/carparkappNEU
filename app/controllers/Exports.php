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
  
   $data = [];

   $this->view('exports/index', $data);
  }

  public function updateView($exportProfile, $email) {

    $timestamp = strtotime('+2 Days');
    $todayCompare = date('Y-m-d', $timestamp);
    $relevantData = $this->exportModel->getRelevantData($todayCompare, $exportProfile);
    $CSVFile =  $this->exportModel->createCSV($relevantData, $exportProfile);

    echo $CSVFile;

  }


  }

