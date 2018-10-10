<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
  if(!isLoggedIn()){
    redirect('users/login');
  }
  if(isSessionAdmin() != "no"){
    redirect('users/login');
  }
?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/studentDashboard.css">

</head>
<body>
  <nav class="navbar navbar-expand-sm navbar-dark sticky-top">
    <a class="navbar-brand py-0" href="#">My School</a>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle py-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo getUsername(); ?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?php echo URLROOT; ?>/students/editprofile">Edit Profile</a>
          <a class="dropdown-item" href="<?php echo URLROOT; ?>/students/changepassword">Change Password</a>
          <a class="dropdown-item" href="<?php echo URLROOT; ?>/users/logout">Log out</a>
        </div>
      </li>
    </ul>
  </nav>

  <div class="row m-0">
    <div class="col-2"></div>
    <!--Left Section-->
    <div class="col-2 h-100 px-0 bg-dark left_section">

      <!--User info-->
      <div class="row align-items-center profile_details text-white mt-2">
        <div class="col-3">
          <img src="<?php echo URLROOT; ?>/img/student.png" class="profile_image rounded-circle pl-1" alt="">
        </div>
        <div class="col-9">
          <p class="m-0"><i>Student</i></p>
        </div>
      </div>

      <ul class="nav mt-2 sidebar flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo URLROOT; ?>/students/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/students/attendance"><i class="far fa-calendar-alt"></i> Attendance</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/students/feedetails"><i class="fas fa-dollar-sign"></i> Fee Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/students/viewprofile"><i class="fas fa-user"></i> View Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/students/editprofile"><i class="fas fa-user-edit"></i> Edit Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/students/changepassword"><i class="fas fa-key"></i> Change Password</a>
        </li>
      </ul>

    </div>


    <!--Right section-->
    <div class="col px-0">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2 mx-3 mt-2 bg-light">
          <li class="active" aria-current="page"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
          <li class="breadcrumb-item ml-auto"><a href="<?php echo URLROOT; ?>/students/dashboard"><i class="fas fa-home"></i> Home</a></li>
          <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
        </ol>
      </nav>

      <div class="row m-0">

        <div class="col-3">
          <div class="card text-white bg-warning">
            <div class="card-body rounded-top pt-3 pb-2">
              <div class="row">
                <div class="col-7">
                  <h2 class="card-title my-0">Paid</h2>
                  <p class="card-text">Fee Status</p>
                </div>
                <div class="col-4 rounded-bottom">
                  <div class="display-4 py-0 my-0"><i class="fas fa-dollar-sign"></i></div>
                </div>
              </div>
            </div>
            <div class="card-footer py-1 text-center">
              <small class="text-muted"><a href="<?= URLROOT; ?>/students/feedetails" class="text-white">More info <i class="fas fa-arrow-circle-up"></i></a></small>
            </div>
          </div>
        </div>

        <div class="col-3">
          <div class="card text-white bg-success">
            <div class="card-body rounded-top pt-3 pb-2">
              <div class="row">
                <div class="col-7">
                  <h2 class="card-title my-0">85%</h2>
                  <p class="card-text">Attendance</p>
                </div>
                <div class="col-4 rounded-bottom">
                  <div class="display-4 py-0 my-0"><i class="far fa-calendar-alt"></i></div>
                </div>
              </div>
            </div>
            <div class="card-footer py-1 text-center">
              <small class="text-muted"><a href="<?= URLROOT; ?>/students/attendance" class="text-white">More info <i class="fas fa-arrow-circle-up"></i></a></small>
            </div>
          </div>
        </div>

      </div>

      <!-- <div class="row m-0 mt-3">
        <div class="col-6 mx-0">
          <div class="mb-3 bg-light border-0 rounded">

          </div>
        </div>
      </div> -->

    </div>
  </div>

  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/studentDashboard.js"></script>
</body>
</html>
