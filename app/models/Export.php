<?php

  class Export{
    
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getRelevantData($date, $exportProfile) {
      
      if ($exportProfile == 'ParkingService') {
        $this->db->query('SELECT shares.share_start, shares.share_end, parkings.key_id 
                          FROM shares JOIN parkings ON shares.parking_id = parkings.id
                          WHERE share_start <= :date ');

        $this->db->bind(':date', $date);

        $results = $this->db->resultSet();

        return $results;

      } elseif ($exportProfile == 'CustomerService') {

        $this->db->query('SELECT shares.credit_item, shares.amount_days, parkings.contract_id 
        FROM shares JOIN parkings ON shares.parking_id = parkings.id
        WHERE share_start <= :date ');

        $this->db->bind(':date', $date);

        $results = $this->db->resultSet();

        return $results;

      } else {
        return false;
      }
    }

    public function createCSV($data, $exportProfile){

      if ($exportProfile == 'ParkingService') {
        $allItems = "";
  
        foreach ($data as $item) {
          $allItems .= $item->key_id . ',' . $item->share_start . ',' . $item->share_end . "\n";
        }
  
        $response = "data:text/csv;charset=utf-8,contract_id,credit_item,amount_days\n";
        $response .= $allItems;
        
        $echo = '<a href="'.$response.'" download="testTable.csv">Download</a>';


        return $response;

      } elseif ($exportProfile == 'CustomerService') {

        // die($data[0]->credit_item);

        $allItems = "";
  
        foreach ($data as $item) {
          $allItems .= $item->contract_id . ',' . $item->credit_item . ',' . $item->amount_days . "\n";
        }
  

        $response = "data:text/csv;charset=utf-8,contract_id,credit_item,amount_days\n";
        $response .= $allItems;
  
        $echo = '<a href="'.$response.'" download="testTable.csv">Download</a>';

        return $response;
       

      } else {
        return false;
      }
    }
    
  }


    
   

    
  