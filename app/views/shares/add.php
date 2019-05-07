<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-6 mx-auto">

     
      <div class="card card-body bg-light mt-5">
        <h2>Share Parking</h2>
        <p>Select lapse of time where parkings should get shared</p>
        <!-- Direct input to specific file with post-method -->
        <form action="<?php echo URLROOT; ?>/shares/add/<?php echo $data['parking_id']; ?>" method="post">
        <!-- TODOOOO: HOW TO GET THE LINK STUFF RIGHT? -->
        <input type="hidden" value="<?php echo $data['parking_id']; ?>" id="datepicker_parking_id">
        <div class="row mt-3">
            <div class="col-md-6 mx-auto">    

            <div class="form-group">
              <label for="name">share_start: <sup>*</sup></label>
              <!-- Check if there is error and add is_invalid / load data to not get blank, when error occurs -->
              <input type="text" id="datepicker_share_start" name="share_start" class="form-control form-control-lg  <?php echo (!empty($data['share_start_err'])) ? 'is-invalid' : '' ?>" value="<?php echo ($data['share_start']); ?>">
              <span class="invalid-feedback"><?php echo $data['share_start_err']; ?></span>
            </div>

            </div>
            <div class="col-md-6 mx-auto">    
            
            <div class="form-group">
              <label for="name">share_end: <sup>*</sup></label>
              <!-- Check if there is error and add is_invalid / load data to not get blank, when error occurs -->
              <input type="text" id="datepicker_share_end" name="share_end" class="form-control form-control-lg  <?php echo (!empty($data['share_end_err'])) ? 'is-invalid' : '' ?>" value="">
              <span class="invalid-feedback"><?php echo $data['share_end_err']; ?></span>
            </div>

            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-6 mx-auto">    

                <h5 id="share-heading-amount-days">Amount Days: </h5>

            </div>
            <div class="col-md-6 mx-auto">    

                <h5 id="share-heading-credit-item">Credit Item: </h5>

            </div>
          </div>

     
          <div class="row mt-4">
            <div class="col-md-6">
              <input type="submit" id="share-submit-btn" class="btn btn-success col-12" value="Submit">
              <!-- <button type="button" class="btn btn-success col-12" data-toggle="modal" data-target="#SubmitModal">Submit</button> -->


            </div>
            <div class="col-md-6">
              <a href="<?php echo URLROOT; ?>/parkings" class="btn btn-lght col-12"><i class="fa fa-backward"></i> Back</a>
            </div>
          </div>  


        </form>
      
        </div>
      </div>

    </div>
  </div>


<?php require APPROOT . '/views/inc/footer.php'; ?>