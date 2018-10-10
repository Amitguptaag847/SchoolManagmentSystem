<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
  if(isLoggedIn()){
    if(isSessionAdmin() == "no"){
      redirect('students/dashboard');
    } else if(isSessionAdmin() == "yes"){
      redirect('admins/dashboard');
    }
  }
?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/login.css">
</head>
</body>

  <div class="container pt-5 h-100">
    <div class="row h-100 mt-4 pt-5 justify-content-center">
      <div class="col-4 mt-5 pt-3 pb-3 form_container">
        <form action="<?php echo URLROOT."/users/index"; ?>" method="post" class="mt-2 mb-3 p-3">
          <?php flash('forgotPassword'); ?>
          <?php flash('register'); ?>
          <div class="form-group">
            <input type="text" name="username" class="form-control rounded-0" placeholder="Username" value="<?php echo $data['username']; ?>" required>
          </div>
          <div class="form-group">
            <input type="password" name="password" class="form-control rounded-0" placeholder="Password" value="<?php echo $data['password']; ?>" required>
          </div>
          <div class="form-group">
            <input type="submit" name="" value="Login" class="btn btn-block btn-primary rounded-0">
          </div>
          <div class="alert alert-danger rounded-0 <?php echo (!empty($data['error']))? '' : 'd-none'; ?>"><?php echo $data['error']; ?></div>
          <a href="<?php echo URLROOT."/users/forgot"; ?>" class="mr-5">Forgot password?</a><a href="<?php echo URLROOT."/users/register"; ?>" class="ml-5 pl-4 mr-0">register</a>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/main.js"></script>
</body>
</html>
