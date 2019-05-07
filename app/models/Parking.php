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

    // INSERT, UPDATE, DELETE - operations needs to call execute method from db library
    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

    //  // Modelmethods are accessable in Controller!
    //  public function getShares($parking_id){
    //   $this->db->query('SELECT * FROM shares WHERE parking_id = :parking_id ORDER BY share_start DESC');
    //   $this->db->bind(':parking_id',$parking_id);
    //   // Return more than one row of db object array
    //   $results = $this->db->resultSet();

    //   return $results;
    // }


    // public function getShareByParkingId($parking_id) {

    //   $this->db->query('SELECT * FROM shares WHERE parking_id = :parking_id');
    //   $this->db->bind(':parking_id', $parking_id);

    //   $row = $this->db->single();

    //   return $row;
    // }

//     public function getSharesByParkingIdJSON($parking_id) {
//       // 2. Getting all upcoming shares, related to this parking
//       $shares = $this->getShares($parking_id);
  
//        $sharePeriodDatesJSON = json_encode($shares);

//        // die(var_dump($sharePeriodDatesJSON));

//        return $sharePeriodDatesJSON;
//  }

//     public function getShareByShareId($share_id) {

//       $this->db->query('SELECT * FROM shares WHERE id = :id');
//       $this->db->bind(':id', $share_id);

//       $row = $this->db->single();

//       return $row;
//     }

//     public function getShareByDate($date) {

//         $this->db->query('SELECT * FROM shares WHERE share_start = :date');
//         $this->db->bind(':date', $date);

//         $row = $this->db->single();
//         return $row;
    
//     }


    // public function addShare($data){

    //   // Create db query to push data to db, using named params
    //   $this->db->query('INSERT INTO shares (share_start, share_end, amount_days, credit_item, parking_id, user_id) VALUES (:share_start, :share_end, :amount_days, :credit_item , :parking_id, :user_id)');
      
    //   $shareStart = new DateTime($data['share_start']);
    //   // $modifiedShareStart = $shareStart->modify('')
    //   $shareEnd = new DateTime($data['share_end']);

    //   $diff = ($shareStart->diff($shareEnd));
      
    //   // Correction because start and end date is uncluded
    //   $amountDays = floatval($diff->format('%a') + 1);
      
    //   $creditItem = floatval(($amountDays * 0.75));
    

    //   // Bind values 
    //   $this->db->bind(':parking_id', $data['parking_id']);
    //   $this->db->bind(':share_start', $shareStart->format('Y-m-d'));
    //   $this->db->bind(':share_end', $shareEnd->format('Y-m-d'));
    //   $this->db->bind(':amount_days', $amountDays);
    //   $this->db->bind(':credit_item', $creditItem);
    //   $this->db->bind(':user_id', $data['user_id']);

    //   // INSERT, UPDATE, DELETE - operations needs to call execute method from db library
    //   // Execute
    //   if ($this->db->execute()) {
    //     return true;
    //   } else {
    //     return false;
    //   }
    // }

    // public function updateShare($sharesToUpdate) {
      

    // //  die(var_dump($sharesToUpdate));
    //   $shares = array();
    //   foreach ($sharesToUpdate as $shareDate) {
    //     if($this->getShareByDate($shareDate)) {
    //       array_push($shares,$this->getShareByDate($shareDate));
    //     }
    //   }

    //   $shareIds = array();

    //   $sharesSize = sizeof($shares);

    //   for ($i=0; $i < $sharesSize ; $i++) { 
      
    //     $this->removeShare($shares[$i]->id);
     
    //   }

    // //  $this->addShare($data);

    //  if ($this->db->execute()) {
    //   return true;
    // } else {
    //   return false;
    // }


    // }

    // public function removeShare($share_id) {

    //   // Create db query to push data to db, using named params
    //   $this->db->query('DELETE FROM shares WHERE id = :id');

    //   // Bind values 
    //   $this->db->bind(':id', $share_id);
    

    //   // INSERT, UPDATE, DELETE - operations needs to call execute method from db library
    //   // Execute
    //   if ($this->db->execute()) {
    //     return true;
    //   } else {
    //     return false;
    //   }
    // }



    // public function shareStartExists($parking_id, $date) {
    //   // 1. Getting input Data and convert and format to DateTIme
    //   $shareToCompare = new DateTime($date);
    
    //   // 2. Getting all upcoming shares, related to this parking
    //   $shares = $this->getShares($parking_id);
      
    //   // 3. Create empty Array to store DatePeriodObjects
    //   $sharePeriods = [];

    //   // 4. Create DatePeriod for each parking related share and store it in array
    //   foreach ($shares as $share) {

    //     // Formatting string into datetime
    //     $dateInterval = new DateInterval('P1D'); 
    //     $shareStart = new DateTime($share->share_start);
    //     $shareEnd = new DateTime($share->share_end);
    //     // Get Enddate
    //     $shareEnd = $shareEnd->modify('+1 day');
        
    //     $sharePeriod = new DatePeriod($shareStart, $dateInterval, $shareEnd);

    //     array_push($sharePeriods, $sharePeriod);
    //   }

    //   $sharePeriodDates = [];
    //   // die(var_dump($sharePeriods));
    //   // Loop through each sharePeriod in shareperiods

    //   $shareStartExists = false;

    //   foreach ($sharePeriods as $sharePeriod) {
    //     // For each date in shareperiod and clook for match with input date
    //     foreach ($sharePeriod as $date) {
    //       // array_push($sharePeriodDates, $date->format('Ymd'));  
    //       // die($date->format('Ymd'));
  
    //       if ($shareToCompare->format('Ymd') == $date->format('Ymd')) {

    //         die('LOOOOL');

    //         $shareStartExists = true;

    //       } 
        

    //     }

    //   }

    //   return $shareStartExists;

    // }

    // public function shareEndExists($parking_id, $date) {
    //   // 1. Getting input Data and convert and format to DateTIme
    //   $shareToCompare = new DateTime($date);
    
    //   // 2. Getting all upcoming shares, related to this parking
    //   $shares = $this->getShares($parking_id);
      
    //   // 3. Create empty Array to store DatePeriodObjects
    //   $sharePeriods = [];

    //   // 4. Create DatePeriod for each parking related share and store it in array
    //   foreach ($shares as $share) {

    //     // Formatting string into datetime
    //     $dateInterval = new DateInterval('P1D'); 
    //     $shareStart = new DateTime($share->share_start);
    //     $shareEnd = new DateTime($share->share_end);
    //     // Get Enddate
    //     $shareEnd = $shareEnd->modify('+1 day');
        
    //     $sharePeriod = new DatePeriod($shareStart, $dateInterval, $shareEnd);

    //     array_push($sharePeriods, $sharePeriod);
    //   }

    //   $sharePeriodDates = [];

    //   $shareEndExists = false;

    //   // die(var_dump($sharePeriods));
    //   // Loop through each sharePeriod in shareperiods
    //   foreach ($sharePeriods as $sharePeriod) {
    //     // For each date in shareperiod and clook for match with input date
    //     foreach ($sharePeriod as $date) {
    //       // array_push($sharePeriodDates, $date->format('Ymd'));  
    //       // die($date->format('Ymd'));
  
    //       if ($shareToCompare->format('Ymd') == $date->format('Ymd')) {

    //         // die('LOOOOL');

    //         $shareEndExists = true;

    //       } else {
            
    //       }

    //     }

    //   }

    //   return $shareEndExists;

    // }

    // public function shareExists($parking_id, $data) {

    //   $dateInterval = new DateInterval('P1D'); 
      
    //   $inputStart = new DateTime($data['share_start']);
    //   $inputEnd = new DateTime($data['share_end']);
    //   // Add One Day for correct DatePeriod Conversion
    //   $inputEnd = $inputEnd->modify('+1 day');

    //   $inputPeriod = new DatePeriod($inputStart, $dateInterval, $inputEnd);

    //   // Array for InputPeriodDates
    //   $inputPeriodDates = [];

    //   foreach ($inputPeriod as $inputPeriodDate) {
    //     array_push($inputPeriodDates, $inputPeriodDate->format('Ymd'));
    //   }


    //   // 2. Getting all upcoming shares, related to this parking
    //   $shares = $this->getShares($parking_id);
      
    //   // 3. Create empty Array to store DatePeriodObjects
    //   $sharePeriods = [];

    //   // 4. Create DatePeriod for each parking related share and store it in array
    //   foreach ($shares as $share) {

    //     // Formatting string into datetime
    //     // $dateInterval = new DateInterval('P1D'); 
    //     $shareStart = new DateTime($share->share_start);
    //     $shareEnd = new DateTime($share->share_end);
    //     // Get Enddate
    //     $shareEnd = $shareEnd->modify('+1 day');
        
    //     $sharePeriod = new DatePeriod($shareStart, $dateInterval, $shareEnd);

    //     array_push($sharePeriods, $sharePeriod);
    //   }

    //   $sharePeriodDates = [];

    //   // Loop through each sharePeriod in shareperiods
    //   foreach ($sharePeriods as $sharePeriod) {
    //     // For each date in shareperiod and clook for match with input date
    //     foreach ($sharePeriod as $date) {
    //       // array_push($sharePeriodDates, $date->format('Ymd'));  
    //       // die($date->format('Ymd'));
  
    //       array_push($sharePeriodDates,$date->format('Ymd')) ;

    //       } 

    //     }

    //     // $result = $sharePeriodDates;


    //     // Compare Both Arrays

    //     $result = array_intersect($inputPeriodDates, $sharePeriodDates);

    //     // DEBUG
    //     // die(var_dump($result));

    //     return $result;



    // }

    // public function getSharesJSONString($parking_id) {
    //      // 2. Getting all upcoming shares, related to this parking
    //      $shares = $this->getShares($parking_id);
      
    //      $dateInterval = new DateInterval('P1D'); 

    //      // 3. Create empty Array to store DatePeriodObjects
    //      $sharePeriods = [];
   
    //      // 4. Create DatePeriod for each parking related share and store it in array
    //      foreach ($shares as $share) {
   
    //        // Formatting string into datetime
    //        // $dateInterval = new DateInterval('P1D'); 
    //        $shareStart = new DateTime($share->share_start);
    //        $shareEnd = new DateTime($share->share_end);
    //        // Get Enddate
    //        $shareEnd = $shareEnd->modify('+1 day');
           
    //        $sharePeriod = new DatePeriod($shareStart, $dateInterval, $shareEnd);
   
    //        array_push($sharePeriods, $sharePeriod);
    //      }

   
    //      $sharePeriodDates = [];
   
    //      // Loop through each sharePeriod in shareperiods
    //      foreach ($sharePeriods as $sharePeriod) {
    //        // For each date in shareperiod and clook for match with input date
    //        foreach ($sharePeriod as $date) {
    //          // array_push($sharePeriodDates, $date->format('Ymd'));  
    //          // die($date->format('Ymd'));
            
    //          // Formatting in ISO FORMAT for JSON export and JS import
    //          array_push($sharePeriodDates,$date->format('Y-m-d')) ;
   
    //          } 
   
    //        }


          
    //       $sharePeriodDatesJSON = json_encode($sharePeriodDates);

    //       // die(var_dump($sharePeriodDatesJSON));

    //       return $sharePeriodDatesJSON;
    // }




  


  }


    
   

    
  