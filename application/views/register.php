<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>CRM </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?= base_url('assets/');?>vendors/feather/feather.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>vendors/typicons/typicons.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?= base_url('assets/');?>css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?= base_url('assets/');?>images/favicon.png" />
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900"  type="text/css" media="all">
</head>
<style type="text/css">
  .success{
    color: green;
  }
  .error{
    color: red;
  }
</style>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <h2>C R M</h2>
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="fw-light">Sign up to continue.</h6>
              <!-- Status message -->
              <?php  
                  if(!empty($success_msg)){ 
                      echo '<p class="status-msg success">'.$success_msg.'</p>'; 
                  }elseif(!empty($error_msg)){ 
                      echo '<p class="status-msg error">'.$error_msg.'</p>'; 
                  } 
              ?>
              <form class="pt-3" action="<?= base_url('register');?><?php if(isset($_GET['refcode'])){ echo '?refcode='.$_GET['refcode'];} ?>" method="post">
                <input type="hidden" name="refcode" value="<?php if(isset($_GET['refcode'])){ echo $_GET['refcode'];} ?>">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="user_name" placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="conf_password" placeholder="Confirm Password">
                </div>
                <div class="mt-3">
                <input type="submit" name="signupSubmit" value="SIGN UP" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" >
                </div> 
                <div class="text-center mt-4 fw-light">
                  Back To <a href="<?=base_url('login');?>" class="text-primary">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?= base_url('assets/');?>vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="<?= base_url('assets/');?>vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="<?= base_url('assets/');?>js/off-canvas.js"></script>
  <script src="<?= base_url('assets/');?>js/hoverable-collapse.js"></script>
  <script src="<?= base_url('assets/');?>js/template.js"></script>
  <script src="<?= base_url('assets/');?>js/settings.js"></script>
  <script src="<?= base_url('assets/');?>js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
