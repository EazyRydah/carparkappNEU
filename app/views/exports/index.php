<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('parking_message'); ?>
  <div class="row mb-3">
    <div class="col-md-6">
      <h1>Export-View</h1>
      
    </div>
  </div>
    
  <div class="card card-body mb-3">
      
      <div class="bg-light p-2 mb-3">

          <form class="form-inline d-flex justify-content-between">
      
            <div class="col-md-4">
            <h4>Choose Table</h4>
            </div>

            <div class="input-group">
                <div class="input-group-text">
                  <input type="radio" name="" id="">
                  <span class="ml-2">Parkings </span>
                </div>
            </div>

            <div class="input-group">
                <div class="input-group-text">
                  <input type="radio" name="" id="">
                  <span class="ml-2">Shares </span>
                </div>
            </div>

          </form>

      

      </div>


      <div class="bg-light p-2 mb-3">

      <form class="form-inline d-flex justify-content-between">
     
      <div class="col-md-4">
        <h4>Export Options</h4>
        </div>

        <div class="input-group">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <span class="ml-2">E-Mail: </span>
            </div>
          </div>
          <input type="text" class="form-control" placeholder="account email">
          <div class="input-group-append">
            <div class="input-group-text">
              <a href="<?php echo URLROOT; ?>/shares/add/<?php echo $parking->id; ?>" > Send Now</a>
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
              <a href="<?php echo URLROOT; ?>/shares/add/<?php echo $parking->id; ?>" > .CSV</a>

            </div>
            <div class="input-group-text">
              <a href="<?php echo URLROOT; ?>/shares/add/<?php echo $parking->id; ?>" > .XML</a>
            </div>
          </div>
        </div>

      </form>

      

      </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>