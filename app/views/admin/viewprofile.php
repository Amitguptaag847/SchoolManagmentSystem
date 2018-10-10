<?php require APPROOT . '/views/inc/header.php' ?>
<?php
  if(!isLoggedIn()){
    redirect('users/login');
  }
  if(isSessionAdmin() != "yes"){
    redirect('users/login');
  }
?>
<link rel="stylesheet" href="<?php echo URLROOT ?>/css/viewprofile.css">

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
          <a class="dropdown-item" href="<?php echo URLROOT; ?>/admins/editprofile">Edit Profile</a>
          <a class="dropdown-item" href="<?php echo URLROOT; ?>/admins/changepassword">Change Password</a>
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
          <img src="<?php echo URLROOT; ?>/img/admin.png" class="profile_image rounded-circle pl-1" alt="">
        </div>
        <div class="col-9">
          <p class="m-0"><i>Admin</i></p>
        </div>
      </div>

      <ul class="nav mt-2 sidebar flex-column">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/admins/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/admins/addstudent"><i class="fas fa-user-plus"></i> Add Student</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/admins/viewstudentprofile"><i class="fas fa-user-graduate"></i> View Student Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/admins/editstudentprofile"><i class="fas fa-user-edit"></i> Edit Student Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo URLROOT; ?>/admins/viewprofile"><i class="fas fa-user-tie"></i> View your Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/admins/editprofile"><i class="fas fa-user-edit"></i> Edit your Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/admins/changepassword"><i class="fas fa-key"></i> Change Password</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/admins/maintainattendance"><i class="far fa-calendar-alt"></i> Maintain Attendance</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/admins/maintainfee"> <i class="fas fa-dollar-sign"></i> &nbsp;Maintain Fee</a>
        </li>
      </ul>

    </div>


    <!--Right section-->
    <div class="col px-0">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2 mx-3 mt-2 bg-light">
          <li class="active" aria-current="page"><i class="fas fa-user-tie"></i> View your Profile</li>
          <li class="breadcrumb-item ml-auto"><a href="<?php echo URLROOT; ?>/admins/dashboard"><i class="fas fa-home"></i> Home</a></li>
          <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-user-tie"></i> View your Profile</li>
        </ol>
      </nav>

      <div class="row m-3">
        <div class="col py-2 bg-light border border-info rounded">
          <form class="" action="<?php echo URLROOT; ?>/admins/viewprofile" method="post">
            <div class="row">
              <div class="col">

                <!-- Admin detail -->
                <div class="card mb-3 border border-info rounded">
                  <div class="card-head bg-info">
                    <p class="m-2 ml-3 text-white"><i class="fa fa-info-circle"></i> Your Details</p>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col form-group">
                        <input type="text" name="first_name" class="form-control" value="<?= $data['first_name']; ?>" placeholder="First Name" disabled required>
                      </div>
                      <div class="col form-group">
                        <input type="text" name="last_name" class="form-control" value="<?= $data['last_name']; ?>" placeholder="Last Name" disabled required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col form-group">
                        <input type="date" name="date_of_birth" class="form-control" value="<?= $data['date_of_birth']; ?>" disabled required>
                      </div>
                      <div class="col form-group">
                        <select class="form-control" name="gender" disabled required>
                          <option value="" disabled <?php if($data['gender'] == ""){ echo 'selected'; } ?>>Gender</option>
                          <option value="male" <?php if($data['gender'] == "male"){ echo 'selected'; } ?>>Male</option>
                          <option value="female" <?php if($data['gender'] == "female"){ echo 'selected'; } ?>>Female</option>
                          <option value="others" <?php if($data['gender'] == "others"){ echo 'selected'; } ?>>Others</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col form-group input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-secondary text-white" id="email_addon">Email</span>
                        </div>
                        <input type="email" name="email" class="form-control" value="<?= $data['email']; ?>" placeholder="Email" disabled required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col form-group mb-0 input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-secondary text-white" id="phonenumber_addon">Phone Number</span>
                        </div>
                        <input type="text" name="mobile_number" class="form-control" value="<?= $data['mobile_number']; ?>" placeholder="Mobile Number" disabled required>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Current Address -->
                <div class="card mb-3 border border-info rounded">
                  <div class="card-head bg-info">
                    <p class="m-2 ml-3 text-white"><i class="fa fa-info-circle"></i> Current Address</p>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col form-group">
                        <input type="text" name="current_address" class="form-control" value="<?= $data['current_address']; ?>" placeholder="Address" disabled required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col form-group mb-0">
                        <input type="text" name="current_city" class="form-control" value="<?= $data['current_city']; ?>" placeholder="City" disabled required>
                      </div>
                      <div class="col form-group mb-0">
                        <select class="form-control" name="current_country" disabled>
                          <option value="india">India</option>
                        </select>
                      </div>
                      <div class="col form-group mb-0">
                        <input type="text" name="current_pincode" class="form-control" value="<?= $data['current_pincode']; ?>" placeholder="Pincode" disabled required>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="col">
                <div class="row mb-3">
                  <div class="col">

                    <!-- Permanent Address -->
                    <div class="card border border-info rounded">
                      <div class="card-head bg-info">
                        <p class="m-2 ml-3 text-white"><i class="fa fa-info-circle"></i> Permanent Address</p>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col form-group">
                            <input type="text" name="permanent_address" class="form-control" value="<?= $data['permanent_address']; ?>" placeholder="Address" disabled required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col form-group mb-0">
                            <input type="text" name="permanent_city" class="form-control" value="<?= $data['permanent_city']; ?>" placeholder="City" disabled required>
                          </div>
                          <div class="col form-group mb-0">
                            <select class="form-control" name="permanent_country" disabled>
                              <option value="india">India</option>
                            </select>
                          </div>
                          <div class="col form-group mb-0">
                            <input type="text" name="permanent_pincode" class="form-control" value="<?= $data['permanent_pincode']; ?>" placeholder="Pincode" disabled required>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col">
                    <div class="card border border-info rounded">
                      <div class="card-head bg-info">
                        <p class="m-2 ml-3 text-white">Parent Details </p>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-secondary text-white" id="fathers_name_addon">Father's Name</span>
                            </div>
                            <input type="text" name="fathers_name" class="form-control" value="<?= $data['fathers_name']; ?>" placeholder="Father's name" disabled required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-secondary text-white" id="mothers_name_addon">Mother's Name</span>
                            </div>
                            <input type="text" name="mothers_name" class="form-control" value="<?= $data['mothers_name']; ?>" placeholder="Mother's name" disabled required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col form-group input-group mb-0">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-secondary text-white" id="fathers_number_addon">Father's Mobile Number</span>
                            </div>
                            <input type="text" name="fathers_mobile_number" class="form-control" value="<?= $data['fathers_mobile_number']; ?>" placeholder="Fathers Contact Number" disabled required>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-6 form-group">
                    <a href="<?= URLROOT; ?>/admins/editprofile" class="btn btn-primary btn-block">Edit</a>
                  </div>
                </div>

              </div>
            </div>
          </form>

        </div>
      </div>

    </div>
  </div>
  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/main.js"></script>
</body>
</html>
