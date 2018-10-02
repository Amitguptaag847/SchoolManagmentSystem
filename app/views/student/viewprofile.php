<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
  if(!isLoggedIn()){
    redirect('users/login');
  }
  if(isSessionAdmin() != "no"){
    redirect('users/login');
  }
?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/studentViewProfile.css">

</head>
<body>
  <nav class="navbar navbar-expand-sm navbar-dark sticky-top">
    <a class="navbar-brand py-0" href="#">My School</a>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle py-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          sysdmin
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
          <a class="nav-link" href="<?php echo URLROOT; ?>/students/feedetails"><i class="fas fa-dollar-sign"></i> Fee Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo URLROOT; ?>/students/viewprofile"><i class="fas fa-user"></i> View Profile</a>
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
          <li class="active" aria-current="page"><i class="fas fa-user"></i> Profile</li>
          <li class="breadcrumb-item ml-auto"><a href="<?php echo URLROOT; ?>/students/dashboard"><i class="fas fa-home"></i> Home</a></li>
          <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-user"></i> Profile</li>
        </ol>
      </nav>

      <div class="row m-3">
        <div class="col py-2 bg-light border border-info rounded">
          <form class="" action="index.html" method="post">
            <div class="row">
              <div class="col">

                <!-- Student detail -->
                <div class="card mb-3 border border-info rounded">
                  <div class="card-head bg-info">
                    <p class="m-2 ml-3 text-white"><i class="fa fa-info-circle"></i> Your Details</p>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col form-group">
                        <input type="text" name="student_first_name" class="form-control" value="" placeholder="First Name" disabled required>
                      </div>
                      <div class="col form-group">
                        <input type="text" name="student_last_name" class="form-control" value="" placeholder="Last Name" disabled required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col form-group">
                        <input type="date" name="date_of_birth" class="form-control" value="" disabled required>
                      </div>
                      <div class="col form-group">
                        <select class="form-control" disabled name="">
                          <option value="" disabled selected>Gender</option>
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                          <option value="others">Others</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col form-group  mb-0">
                        <input type="email" name="student_email" class="form-control" value="" placeholder="Email" disabled required>
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
                        <input type="text" name="student_current_address" class="form-control" value="" placeholder="Address" disabled required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col form-group mb-0">
                        <input type="date" name="student_current_city" class="form-control" value="" placeholder="City" disabled required>
                      </div>
                      <div class="col form-group mb-0">
                        <select class="form-control" name="student_current_country" disabled>
                          <option value="india">India</option>
                        </select>
                      </div>
                      <div class="col form-group mb-0">
                        <input type="text" name="student_current_pincode" class="form-control" value="" placeholder="Pincode" disabled required>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Permanent Address -->
                <div class="card mb-3 border border-info rounded">
                  <div class="card-head bg-info">
                    <p class="m-2 ml-3 text-white"><i class="fa fa-info-circle"></i> Permanent Address</p>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col form-group">
                        <input type="text" name="student_permanent_address" class="form-control" value="" placeholder="Address" disabled required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col form-group mb-0">
                        <input type="date" name="student_permanent_city" class="form-control" value="" placeholder="City" disabled required>
                      </div>
                      <div class="col form-group mb-0">
                        <select class="form-control" name="student_permanent_country" disabled>
                          <option value="india">India</option>
                        </select>
                      </div>
                      <div class="col form-group mb-0">
                        <input type="text" name="student_permanent_pincode" class="form-control" value="" placeholder="Pincode" disabled required>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="row mb-3">
                  <div class="col">

                    <!-- Class Details -->
                    <div class="card border border-info rounded">
                      <div class="card-head bg-info">
                        <p class="m-2 ml-3 text-white">Class Details </p>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col form-group">
                            <select class="form-control" name="student_class" disabled>
                              <option value="" disabled selected>Class</option>
                              <option value="5">5th</option>
                              <option value="6">6th</option>
                              <option value="7">7th</option>
                              <option value="8">8th</option>
                              <option value="9">9th</option>
                              <option value="10">10th</option>
                              <option value="11">11th</option>
                              <option value="12">12th</option>
                            </select>
                          </div>
                          <div class="col form-group">
                            <select class="form-control" name="student_section" disabled>
                              <option value="" disabled selected>Section</option>
                              <option value="a">Section A</option>
                              <option value="b">Section B</option>
                              <option value="c">Section C</option>
                            </select>
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
                          <div class="col form-group">
                            <input type="text" name="fathers_name" class="form-control" value="" placeholder="Father's name" disabled required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col form-group">
                            <input type="text" name="mothers_name" class="form-control" value="" placeholder="Mother's name" disabled required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col form-group">
                            <input type="text" name="fathers_occupation" class="form-control" value="" placeholder="Father's occupation" disabled required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col form-group">
                            <input type="text" name="mothers_occupation" class="form-control" value="" placeholder="Mothers's occupation" disabled required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col form-group">
                            <input type="text" name="family_annual_income" class="form-control" value="" placeholder="Annual income of family" disabled required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col form-group">
                            <input type="text" name="fathers_mobile_number" class="form-control" value="" placeholder="Fathers Contact Number" disabled required>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-6 form-group">
                    <a href="<?php echo URLROOT; ?>/students/editprofile" class="btn btn-primary btn-block">Edit</a>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/main.js"></script>
</body>
</html>
