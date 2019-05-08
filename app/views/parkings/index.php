<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('parking_message'); ?>
  <div class="row mb-3">
    <div class="col-md-6">
      <h1>Parkings</h1>
    </div>
    <div class="col-md-6">
      <a href="<?php echo URLROOT; ?>/parkings/add" class="btn btn-dark pull-right">
        <i class="fa fa-pencil"></i> Add Parking
      </a>
    </div>
  </div>
  <!-- LOOP THROUGH DATA ARRAY -->
  <?php foreach($data['parkings'] as $parking) : ?>
    <div class="card card-body mb-3">
      <h4 class="card-title"><?php echo $parking->name; ?></h4>
     
      <div class="bg-light p-2 mb-3">
      Address: <?php echo $parking->address; ?> - Status: <?php echo $parking->status; ?>
      <a href="<?php echo URLROOT; ?>/shares/show/<?php echo $parking->id; ?>" class="btn btn-light pull-right ml-3">
        <i class="fa fa-plus-square"></i> More 
      </a>
      <a href="<?php echo URLROOT; ?>/shares/add/<?php echo $parking->id; ?>" class="btn btn-success pull-right">
        <i class="fa fa-pencil"></i> Share 
      </a>
      </div>
    </div>
  <?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>