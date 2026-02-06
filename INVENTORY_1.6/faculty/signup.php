<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('../admin/inc/header.php') ?>
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
  <h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo $_settings->info('name') ?> - Faculty Signup</b></h1>
<div class="login-box">
  <div class="card card-navy my-2">
    <div class="card-body">
      <p class="login-box-msg">Enter your details to sign up</p>
      <form id="signup-frm" action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <select class="form-control" name="teacher_level" required>
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
              <span class="fas fa-chalkboard-teacher"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <select class="form-control" name="department" required>
            <option value="">Select Department</option>
            <option value="Junior High School">Junior High School</option>
            <option value="Senior High School">Senior High School</option>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-building"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
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
            <a href="../admin/login.php">Already have an account? Login</a>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
    $('#signup-frm').submit(function(e){
      e.preventDefault();
      var data = $(this).serialize();
      $.ajax({
        url: '<?= base_url ?>classes/Login.php?f=signup_faculty',
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function(resp){
          if(resp.status == 'success'){
            alert('Signup successful! Please login.');
            location.href = '../admin/login.php';
          }else{
            alert('Signup failed: ' + resp.error);
          }
        }
      });
    });
  })
</script>
</body>
</html>
