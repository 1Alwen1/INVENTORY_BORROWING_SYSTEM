<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
  <script>
    start_loader()
  </script>
  <style>
    body{
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size:cover;
      background-repeat:no-repeat;
      backdrop-filter: contrast(1);
    }
    #page-title{
      text-shadow: 6px 4px 7px black;
      font-size: 3.5em;
      color: #fff4f4 !important;
      background: #8080801c;
    }
  </style>
  <h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo $_settings->info('name') ?></b></h1>
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-navy my-2">
    <div class="card-body">
      <p class="login-box-msg" id="login-msg">Please enter your credentials</p>
      <form id="login-frm" action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" id="username" autofocus placeholder="Username">
          <select class="form-control" name="teacher_level" id="teacher_level_select" style="display:none;">
            <option value="">Select Teacher Level</option>
            <option value="Teacher I">Teacher I</option>
            <option value="Teacher II">Teacher II</option>
            <option value="Teacher III">Teacher III</option>
            <option value="Master Teacher I">Master Teacher I</option>
            <option value="Master Teacher II">Master Teacher II</option>
            <option value="Master Teacher III">Master Teacher III</option>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control"  name="password" id="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-eye" id="toggle-password" style="cursor: pointer;"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <p id="signup-link"><a href="#" id="signup-url">Don't have an account? Sign Up</a></p>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  <div class="text-center mt-3">
    <button class="btn btn-primary mr-3" id="admin-btn" style="margin-right: 5%; margin-bottom: 5%;">Login as Admin</button>
    <button class="btn btn-success mr-3" id="student-btn" style="margin-right: 5%; margin-bottom: 5%;">Login as Student</button>
    <button class="btn btn-warning" id="faculty-btn">Login as Faculty</button>
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url ?>dist/js/adminlte.min.js"></script>

<script>
  $(document).ready(function(){
    end_loader();
    $('#toggle-password').click(function(){
      var passwordField = $('#password');
      var icon = $(this);
      if(passwordField.attr('type') === 'password'){
        passwordField.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
      } else {
        passwordField.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
      }
    });
    var login_type = 'admin';
    $('#signup-link').hide();

    $('#admin-btn').click(function(){
      login_type = 'admin';
      $('#username').show();
      $('#teacher_level_select').hide();
      $('#username').attr('placeholder', 'Username');
      $('#username').attr('name', 'username');
      $('#teacher_level_select').removeAttr('name');
      $('#login-msg').text('Please enter your credentials');
      $('#signup-link').hide();
    });

    $('#student-btn').click(function(){
      login_type = 'student';
      $('#username').show();
      $('#teacher_level_select').hide();
      $('#username').attr('placeholder', 'LRN');
      $('#username').attr('name', 'lrn');
      $('#teacher_level_select').removeAttr('name');
      $('#login-msg').text('Please enter your Student credentials');
      $('#signup-link').show();
      $('#signup-url').attr('href', '<?= base_url ?>student/signup.php');
      $('#signup-url').text('Don\'t have an account? Sign Up');
    });

    $('#faculty-btn').click(function(){
      login_type = 'faculty';
      $('#username').hide();
      $('#teacher_level_select').show();
      $('#teacher_level_select').attr('name', 'teacher_level');
      $('#username').removeAttr('name');
      $('#login-msg').text('Please enter your Faculty credentials');
      $('#signup-link').show();
      $('#signup-url').attr('href', '<?= base_url ?>faculty/signup.php');
      $('#signup-url').text('Don\'t have an account? Sign Up');
    });

    $('#login-frm').submit(function(e){
      e.preventDefault();
      var data = $(this).serialize();
      var url = '<?= base_url ?>classes/Login.php?f=login';
      if(login_type == 'student') url = '<?= base_url ?>classes/Login.php?f=login_student';
      if(login_type == 'faculty') url = '<?= base_url ?>classes/Login.php?f=login_faculty';
      $.ajax({
        url: url,
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function(resp){
          if(resp.status == 'success'){
            if(login_type == 'admin') location.href = '<?= base_url ?>admin/home.php';
            else if(login_type == 'student') location.href = '<?= base_url ?>student/home.php';
            else if(login_type == 'faculty') location.href = '<?= base_url ?>faculty/home.php';
          }else{
            alert('Incorrect credentials');
          }
        }
      });
    });
  })
</script>
</body>
</html>