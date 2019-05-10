<?php

  class Share{
    
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

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


     // Modelmethods are accessable in Controller!
     public function getShares($parking_id){
      $this->db->query('SELECT * FROM shares WHERE parking_id = :parking_id ORDER BY share_start DESC');
      $this->db->bind(':parking_id',$parking_id);
      // Return more than one row of db object array
      $results = $this->db->resultSet();

      return $results;
    }


    public function getShareByParkingId($parking_id) {

      $this->db->query('SELECT * FROM shares WHERE parking_id = :parking_id');
      $this->db->bind(':parking_id', $parking_id);

      $row = $this->db->single();

      return $row;
    }

    public function getSharesByParkingIdJSON($parking_id) {
      // 2. Getting all upcoming shares, related to this parking
      $shares = $this->getShares($parking_id);
  
      $sharePeriodDatesJSON = json_encode($shares);

      return $sharePeriodDatesJSON;
 }

    public function getShareByShareId($share_id) {

      $this->db->query('SELECT * FROM shares WHERE id = :id');
      $this->db->bind(':id', $share_id);

      $row = $this->db->single();

      return $row;
    }

    public function getShareByDate($date) {

        $this->db->query('SELECT * FROM shares WHERE share_start = :date');
        $this->db->bind(':date', $date);

        $row = $this->db->single();
        return $row;
    
    }

    public function addShare($data){
      // Create db query to push data to db, using named params
      $this->db->query('INSERT INTO shares (share_start, share_end, amount_days, credit_item, parking_id, user_id) VALUES (:share_start, :share_end, :amount_days, :credit_item , :parking_id, :user_id)');
      
      $shareStart = new DateTime($data['share_start']);
      // $modifiedShareStart = $shareStart->modify('')
      $shareEnd = new DateTime($data['share_end']);

      $diff = ($shareStart->diff($shareEnd));
      
      // Correction because start and end date is uncluded
      $amountDays = floatval($diff->format('%a') + 1);
      
      $creditItem = floatval(($amountDays * 0.75));
    

      // Bind values 
      $this->db->bind(':parking_id', $data['parking_id']);
      $this->db->bind(':share_start', $shareStart->format('Y-m-d'));
      $this->db->bind(':share_end', $shareEnd->format('Y-m-d'));
      $this->db->bind(':amount_days', $amountDays);
      $this->db->bind(':credit_item', $creditItem);
      $this->db->bind(':user_id', $data['user_id']);

      // Execute
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    public function updateShare($sharesToUpdate) {
      
      $shares = array();
      foreach ($sharesToUpdate as $shareDate) {
        if($this->getShareByDate($shareDate)) {
          array_push($shares,$this->getShareByDate($shareDate));
        }
      }

      $shareIds = array();

      $sharesSize = sizeof($shares);

      for ($i=0; $i < $sharesSize ; $i++) { 
      
        $this->removeShare($shares[$i]->id);
     
      }

    //  $this->addShare($data);

     if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }


    }

    public function removeShare($share_id) {

      // Create db query to push data to db, using named params
      $this->db->query('DELETE FROM shares WHERE id = :id');

      // Bind values 
      $this->db->bind(':id', $share_id);
    
      // Execute
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    public function shareExists($parking_id, $data) {

      $dateInterval = new DateInterval('P1D'); 
      
      $inputStart = new DateTime($data['share_start']);
      $inputEnd = new DateTime($data['share_end']);

      // Add One Day for correct DatePeriod Conversion
      $inputEnd = $inputEnd->modify('+1 day');

      $inputPeriod = new DatePeriod($inputStart, $dateInterval, $inputEnd);

      // Array for InputPeriodDates
      $inputPeriodDates = [];

      foreach ($inputPeriod as $inputPeriodDate) {
        array_push($inputPeriodDates, $inputPeriodDate->format('Ymd'));
      }

      // Getting all upcoming shares, related to this parking
      $shares = $this->getShares($parking_id);
      
      // Create empty Array to store DatePeriodObjects
      $sharePeriods = [];

      // Create DatePeriod for each parking related share and store it in array
      foreach ($shares as $share) {

        // Formatting string into datetime
        // $dateInterval = new DateInterval('P1D'); 
        $shareStart = new DateTime($share->share_start);
        $shareEnd = new DateTime($share->share_end);
        // Get Enddate
        $shareEnd = $shareEnd->modify('+1 day');
        
        $sharePeriod = new DatePeriod($shareStart, $dateInterval, $shareEnd);

        array_push($sharePeriods, $sharePeriod);
      }

      $sharePeriodDates = [];

      // Loop through each sharePeriod in shareperiods
      foreach ($sharePeriods as $sharePeriod) {
        // For each date in shareperiod and look for match with input date
        foreach ($sharePeriod as $date) {
          // array_push($sharePeriodDates, $date->format('Ymd'));  
          // die($date->format('Ymd'));
  
          array_push($sharePeriodDates,$date->format('Ymd')) ;

          } 

        }

        // Compare Both Arrays
        $result = array_intersect($inputPeriodDates, $sharePeriodDates);

        return $result;
    }

    public function getSharesJSONString($parking_id) {
         // Getting all upcoming shares, related to this parking
         $shares = $this->getShares($parking_id);
      
         $dateInterval = new DateInterval('P1D'); 

         // Create empty Array to store DatePeriodObjects
         $sharePeriods = [];
   
         // Create DatePeriod for each parking related share and store it in array
         foreach ($shares as $share) {
   
           // Formatting string into datetime
           // $dateInterval = new DateInterval('P1D'); 
           $shareStart = new DateTime($share->share_start);
           $shareEnd = new DateTime($share->share_end);
           // Get Enddate
           $shareEnd = $shareEnd->modify('+1 day');
           
           $sharePeriod = new DatePeriod($shareStart, $dateInterval, $shareEnd);
   
           array_push($sharePeriods, $sharePeriod);
         }

         $sharePeriodDates = [];
   
         // Loop through each sharePeriod in shareperiods
         foreach ($sharePeriods as $sharePeriod) {
           // For each date in shareperiod and clook for match with input date
           foreach ($sharePeriod as $date) {
             // array_push($sharePeriodDates, $date->format('Ymd'));  
             // die($date->format('Ymd'));
            
             // Formatting in ISO FORMAT for JSON export and JS import
             array_push($sharePeriodDates,$date->format('Y-m-d')) ;
   
             } 
   
           }

          $sharePeriodDatesJSON = json_encode($sharePeriodDates);

          // die(var_dump($sharePeriodDatesJSON));

          return $sharePeriodDatesJSON;
    }

   

    public function sendUserMail($data, $action) {
    
      $mail = new PHPMailer();

      // SMTP Settings
      $mail->isSMTP();
      $mail->Host = "smtp.gmail.com";
      $mail->SMTPAuth = true;
      $mail->Username = "zenzor6@gmail.com";
      $mail->Password = "sierra123";
      $mail->Port = 465; // 587
      $mail->SMTPSecure = "ssl"; // tls

      // Email Settings
      $mail->isHTML(true);
      $mail->setFrom("fabian.rhoda@gmx.net", "CarParkInfo");
      $mail->addAddress("fabian.rhoda@gmx.net");
      $mail->Subject = ("SWG - CarparkApp-Info");

      if ($action == "add") {
       
        $shareStart = new DateTime($data['share_start']);
        // $modifiedShareStart = $shareStart->modify('')
        $shareEnd = new DateTime($data['share_end']);
  
        $diff = ($shareStart->diff($shareEnd));
        
        // Correction because start and end date is uncluded
        $amountDays = floatval($diff->format('%a') + 1);
        
        $creditItem = floatval(($amountDays * 0.75));

        $mail->Body = "Lieber Kunde, <br><br>". 
                        "Ihr Parkplatz: " . $this->getParkingById($data['parking_id'])->name . " wurde vom " . $data['share_start'] . " bis zum  " .  $data['share_end'] . ", fuer insgesamt " . $amountDays . " Tage, freigegeben.<br><br>".
                       " Dafuer erhalten Sie eine Gutschrift von: " . $creditItem . " Euro und ihr Einfahrtsticket wird fuer den genannten Zeitraum deaktiviert. <br><br>Vielen Dank fuer die Nutzung unseres neues Services,<br><br> Ihr Stadtwerke Goettingen Mobility-Team" ;    
      } else {

        // Get share 
        // die($data->share_start);
        $mail->Body = "Lieber Kunde, <br><br>". 
                        "Die Freigabe ihres Parkplatzes " . $this->getParkingById($data->parking_id)->name .", vom " . $data->share_start . " bis zum  " .  $data->share_end . ", wurde storniert."
                       ."<br><br>Vielen Dank fuer die Nutzung unseres neues Services,<br><br> Ihr Stadtwerke Goettingen Mobility-Team" ;  
      }

      if ($mail->send()) {
        return true;
      } else {
        return $mail->ErrorInfo;
      }
    }

      // public function CSVDump(){
      
    //   $this->db->query('SELECT * FROM shares');
    //   $results = $this->db->resultSet();

    //   $allData = "";
    //   foreach ($results as $shareObject) {
    //     $allData .= $shareObject->id . ',' . $shareObject->share_start . ',' . $shareObject->share_end . "\n";
    //   }

    //   $response = "data:text/csv;charset=utf-8,id,share_start,share_end\n";
    //   $response .= $allData;

    //   // $echo = '<a href="'.$response.'" download="testTable.csv">Download</a>';

    //   $handle = fopen('internData.csv', 'w');
    //   fwrite($handle, $response);
    //   fclose($handle);
       
    // }
  }


    
   

    
  