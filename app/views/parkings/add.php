<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-6 mx-auto">

     
      <div class="card card-body bg-light mt-5">
        <h2>Add Parking</h2>
        <p>Add new Parking to your account</p>
        <!-- Direct input to specific file with post-method -->
        <form action="<?php echo URLROOT; ?>/parkings/add" method="post">

          <div class="form-group">
            <label for="name">contract_id: <sup>*</sup></label>
            <!-- Check if there is error and add is_invalid / load data to not get blank, when error occurs -->
            <input type="text" name="contract_id" class="form-control form-control-lg <?php echo (!empty($data['contract_id_err'])) ? 'is-invalid' : '' ?>" value="<?php echo $data['contract_id']; ?>">
            <span class="invalid-feedback"><?php echo $data['contract_id_err']; ?></span>
          </div>

          <div class="form-group">
            <label for="name">key_id: <sup>*</sup></label>
            <!-- Check if there is error and add is_invalid / load data to not get blank, when error occurs -->
            <input type="text" name="key_id" class="form-control form-control-lg <?php echo (!empty($data['key_id_err'])) ? 'is-invalid' : '' ?>" value="<?php echo $data['key_id']; ?>">
            <span class="invalid-feedback"><?php echo $data['key_id_err']; ?></span>
          </div>

          <div class="row mt-4">
          <div class="col-md-6">
              <input type="submit" class="btn btn-success col-12 " value="Submit">
            </div>
            <div class="col-md-6">
              <a href="<?php echo URLROOT; ?>/parkings" class="btn btn-dark col-12"><i class="fa fa-backward"></i> Back</a>
            </div>
          </div>  
          
         

          </form>
          

        </div>
      </div>

    </div>
  </div>

  
<?php require APPROOT . '/views/inc/footer.php'; ?>