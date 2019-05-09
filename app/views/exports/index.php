<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('parking_message'); ?>
  <div class="row mb-3">
    <div class="col-md-6">
      <h1>Export-View</h1>
      
    </div>
  </div>
    
  <div class="card card-body mb-3 ">

      <!-- HIER GEHTS MORGEN WEITER! FORM CONTROL MIT GET REQUEST UND AJAX AUSHORCHEN UND DANN ENTSPRECHEND DEN PHP FUNKTIONEN ZUR VERFÜNGEN STELLEN!  -->

      <div class="bg-light p-2 mb-3">

      <form action="#" method="post" class="form-inline d-flex justify-content-between">

      <div class="input-group">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <span class="ml-2">Choose Export Profile: </span>
            </div>
          </div>
          <select class="form-control" id="select-export-profile">
            <option value="">-</option>
            <option value="Parking Service">Parking Service</option>
            <option value="Customer Service">Customer Service</option>
          </select>
      </div>

        <div class="input-group">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <span class="ml-2">E-Mail: </span>
            </div>
          </div>
          <input type="email" class="form-control" id="email-input" placeholder="<? echo $_SESSION['user_email'] ;?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <a id="link-exports-sendMail" href="#"> Send Now</a>
            </div>
          </div>
        </div>

        <div class="input-group">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <span class="ml-2">Direct Download: </span>
            </div>
          </div>
          <div class="input-group-append">
            <div class="input-group-text">
              <a href="<?php echo URLROOT; ?>/exports/downloadCSV/" > .CSV</a>
            </div>
          </div>
        </div>

      </form>

      

      </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>