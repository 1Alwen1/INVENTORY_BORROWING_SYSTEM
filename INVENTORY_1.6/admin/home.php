<?php require_once('../config.php'); ?>
<?php require_once('inc/sess_auth.php'); ?>
 <!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
  <body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed sidebar-mini-md sidebar-mini-xs text-sm" data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
    <div class="wrapper">
     <?php require_once('inc/topBarNav.php') ?>
     <?php require_once('inc/navigation.php') ?>
     <?php if($_settings->chk_flashdata('success')): ?>
    <script>
      alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
    </script>
    <?php endif;?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper  pt-3" style="min-height: 567.854px.">

        <!-- Main content -->
        <section class="content  text-dark">
          <div class="container-fluid">
            <style>
  #system-cover{
    width:100%;
    height:35em;
    object-fit:cover;
    object-position:center center;
  }
</style>
<h1 class="">Welcome, <?php echo $_settings->userdata('firstname')." ".$_settings->userdata('lastname') ?>!</h1>
<hr>
<div class="row">
  <div class="col-12 col-sm-6 col-md-6">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-navy elevation-1"><i class="fas fa-th-list"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Categories</span>
        <span class="info-box-number text-right h5">
          <?php 
            $category = $conn->query("SELECT id FROM category_list where delete_flag = 0 and `status` = 1")->num_rows;
            echo format_num($category);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-6">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-light elevation-1"><i class="fas fa-th-list"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Pending Borrowed</span>
        <span class="info-box-number text-right h5">
          <?php 
            $pending = $conn->query("SELECT * FROM reservation_items where `reservation_id` IN (SELECT `reservations`.`id` FROM `reservations` where `status` = 0) and `item_id` IN (SELECT `item_list`.`id` FROM `item_list` inner join `category_list` on `item_list`.`category_id` = `category_list`. `id` where `item_list`.`delete_flag` = 0 and `category_list`.`delete_flag` = 0 and `category_list`.`status` = 1) ")->num_rows;
            echo format_num($pending);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<div class="container-fluid text-center">
  <img src="<?= validate_image($_settings->info('cover')) ?>" alt="system-cover" id="system-cover" class="img-fluid">
</div>
          </div>
        </section>
        <!-- /.content -->
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered rounded-0" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary rounded-0" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md rounded-0" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered rounded-0" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary rounded-0" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>
      </div>
      <!-- /.content-wrapper -->
      <?php require_once('inc/footer.php') ?>
  </body>
</html>
