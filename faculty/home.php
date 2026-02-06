<?php require_once('../config.php'); ?>
<?php require_once('inc/sess_auth.php'); ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('../inc/header.php') ?>
<body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed sidebar-mini-md sidebar-mini-xs" data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
  <div class="wrapper">
 

    <div class="content-wrapper pt-3" style="min-height: 567px;">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Welcome, <?php echo $_settings->userdata('full_name'); ?>!</h3>
                <div class="card-tools">
                  <a href="../classes/Login.php?f=logout_faculty" class="btn btn-danger btn-sm">Logout</a>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="card card-outline card-info">
                      <div class="card-header">
                        <h5 class="card-title">Make a Reservation</h5>
                      </div>
                      <div class="card-body">
                        <form id="reservation-form" method="post">
                          <div class="form-group">
                            <label for="items">Select Categories:</label>
                            <select class="form-control select2" name="items[]" multiple required>
                              <?php
                              $items = $conn->query("SELECT i.*, c.name as category_name FROM item_list i INNER JOIN category_list c ON i.category_id = c.id WHERE i.status = 1 AND i.delete_flag = 0 AND i.available > 0");
                              while($row = $items->fetch_assoc()){
                                echo "<option value='{$row['id']}'>{$row['category_name']}/{$row['LabID']}</option>";
                              }
                              ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="date_time">Date and Time:</label>
                            <input type="datetime-local" class="form-control" name="date_time" required>
                          </div>
                          <button type="submit" class="btn btn-primary">Reserve</button>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card card-outline card-success">
                      <div class="card-header">
                        <h5 class="card-title">Your Reservations</h5>
                      </div>
                      <div class="card-body">
                        <table class="table table-bordered table-striped" id="reservation-table">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Items</th>
                              <th>Date Time</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $user_id = $_settings->userdata('id');
                            $user_type = 2; // faculty
                            $reservations = $conn->query("SELECT * FROM reservations WHERE user_type = $user_type AND user_id = $user_id ORDER BY created_at DESC");
                            while($row = $reservations->fetch_assoc()){
                              $status = ['Pending','Approved','Borrowed','Returned'][$row['status']];
                              $items = $conn->query("SELECT LabID FROM item_list WHERE id IN (SELECT item_id FROM reservation_items WHERE reservation_id = {$row['id']})");
                              $item_list = [];
                              while($i = $items->fetch_assoc()) $item_list[] = $i['LabID'];
                              echo "<tr><td>{$row['id']}</td><td>".implode(', ', $item_list)."</td><td>{$row['date_time']}</td><td>$status</td></tr>";
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once('../inc/footer.php') ?>
  </div>
  <script>
    $(document).ready(function(){
      $('.select2').select2({
        placeholder: 'Select items',
        allowClear: true
      });
      $('#reservation-table').DataTable();
      $('#reservation-form').submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
          url: '../classes/Master.php?f=save_reservation',
          method: 'POST',
          data: data,
          dataType: 'json',
          success: function(resp){
            if(resp.status == 'success'){
              alert_toast(resp.msg, 'success');
              setTimeout(function(){
                location.reload();
              }, 2000);
            } else {
              alert_toast(resp.msg, 'error');
            }
          }
        });
      });
      $(document).on('click', '.return-btn', function(){
        var id = $(this).data('id');
        if(confirm('Are you sure you want to return this reservation?')){
          $.ajax({
            url: '../classes/Master.php?f=return_reservation',
            method: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(resp){
              if(resp.status == 'success'){
                alert_toast('Reservation returned successfully.', 'success');
                setTimeout(function(){
                  location.reload();
                }, 2000);
              } else {
                alert_toast('Failed to return reservation.', 'error');
              }
            }
          });
        }
      });
      $(document).on('click', '.receipt-btn', function(){
        var id = $(this).data('id');
        window.open('../receipt.php?id=' + id, 'receipt', 'width=600,height=400,scrollbars=yes,resizable=yes');
      });
    });
  </script>
</body>
</html>
