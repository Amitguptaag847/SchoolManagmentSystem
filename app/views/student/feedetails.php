<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
  if(!isLoggedIn()){
    redirect('users/login');
  }
  if(isSessionAdmin() != "no"){
    redirect('users/login');
  }
?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/studentFeeDetails.css">

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
          <a class="nav-link" href="<?php echo URLROOT; ?>/students/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/students/attendance"><i class="far fa-calendar-alt"></i> Attendance</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo URLROOT; ?>/students/feedetails"><i class="fas fa-dollar-sign"></i> Fee Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/students/viewprofile"><i class="fas fa-user"></i></i> View Profile</a>
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
          <li class="active" aria-current="page"><i class="fas fa-dollar-sign"></i> Fee Details</li>
          <li class="breadcrumb-item ml-auto"><a href="<?php echo URLROOT; ?>/students/dashboard"><i class="fas fa-home"></i> Home</a></li>
          <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-dollar-sign"></i> Fee Details</li>
        </ol>
      </nav>

      <div class="row m-0">
        <div class="col">
          <table class="table table-striped table-secondary table-hover">
            <thead class="bg-info text-white">
              <tr class="text-center">
                <th scope="col">Fee Month</th>
                <th scope="col">Payment Date</th>
                <th scope="col">Fee</th>
                <th scope="col">Payment Method</th>
                <th scope="col">Payment Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data as $key => $value): ?>
              <tr class="text-center">
                <td><?= $value->fee_month; ?></td>
                <td><?php if(isset($value->payment_date)){echo $value->payment_date;} else {echo "-";}; ?></td>
                <td><?= $value->fee_amount; ?></td>
                <td><?php if($value->payment_method != ""){echo $value->payment_method;} else {echo "-";}; ?></td>
                <td <?php if($value->status == 1){echo 'class="text-success">Paid';} else {echo 'class="text-danger">Due';}; ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/main.js"></script>
</body>
</html>
