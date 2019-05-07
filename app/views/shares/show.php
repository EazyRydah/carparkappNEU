<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="row mb-3">
    <div class="col-md-6">
      <h1>Shares</h1>
    </div>
    <div class="col-md-6">
      <a href="<?php echo URLROOT; ?>/parkings" class="btn btn-dark pull-right">
      <i class="fa fa-backward"></i> Back</a>
      </a>
    </div>
  </div>


  <h4 >Upcoming</h4>  

  <div class="row mb-3">
      <!-- LOOP THROUGH DATA ARRAY -->
      <?php foreach($data['shares'] as $shares) : ?>

        <?if ($shares->share_start > $data['today']) : ?>

              <div class="col-md-12">
                <div class="bg-light p-2 mb-3">
                Timeperiod: <?php echo $shares->amount_days; ?> days - credit_item: <?php echo $shares->credit_item; ?> € - share_start: <?php echo $shares->share_start; ?> - share_end: <?php echo $shares->share_end; ?> - on: <?php echo $shares->created_at; ?>
                  <a href="#" data-toggle="modal" data-target="#mymodal<?php echo $shares->id; ?>" class="btn btn-light btn-sm pull-right p-0 ml-6" ><i class="fa fa-close"></i> Cancel</a>
                </div>
              </div>

          <?php endif; ?> 


      <!-- MODAL -->

      <div class="modal fade" id="mymodal<?php echo $shares->id; ?>">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <h4>Are you sure?</h4>
            </div>

            <div class="modal-body text-center">
              <form action="<?php echo URLROOT; ?>/shares/remove/<?php echo $shares->id; ?>" method="post">
                Are you sure you want to cancel share from:<br> <?php echo $shares->share_start; ?> to <?php echo $shares->share_end; ?> ?<br>
                <input type="submit" class="btn btn-warning col-6 btn-sm mt-3" value="Cancel Share">            
              </form>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal"><i class="fa fa-backward"></i> Back</a></button>
            </div>

          </div>
        </div>
      </div>

      <?php endforeach; ?>



    </div>

      

  <button type="button" class="btn btn-light mb-3" data-toggle="collapse" data-target="#contentPast">View past shares</button>
  <!-- <button class="btn btn-primary" data-toggle="collapse" data-target="#content"></button> -->
  <div class="row mb-3 collapse" id="contentPast">
      <!-- LOOP THROUGH DATA ARRAY -->
      <?php foreach($data['shares'] as $shares) : ?>
      <?if ($shares->share_start <= $data['today']) : ?>
      <div class="col-md-12">
        <div class="bg-light p-2 mb-3">
        Timeperiod: <?php echo $shares->amount_days; ?> days - credit_item: <?php echo $shares->credit_item; ?> € - share_start: <?php echo $shares->share_start; ?> - share_end: <?php echo $shares->share_end; ?> - on: <?php echo $shares->created_at; ?>
        </div>
      </div>

      <?php endif; ?> 
      <?php endforeach; ?>

      </div>
  
 
  
  
<?php require APPROOT . '/views/inc/footer.php'; ?>