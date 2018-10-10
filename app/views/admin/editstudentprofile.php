<?php require APPROOT . '/views/inc/header.php' ?>
<?php
  if(!isLoggedIn()){
    redirect('users/login');
  }
  if(isSessionAdmin() != "yes"){
    redirect('users/login');
  }
?>
<link rel="stylesheet" href="<?php echo URLROOT ?>/css/editstudentprofile.css">

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
          <a class="nav-link active" href="<?php echo URLROOT; ?>/admins/editstudentprofile"><i class="fas fa-user-edit"></i> Edit Student Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/admins/viewprofile"><i class="fas fa-user-tie"></i> View your Profile</a>
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
          <li class="active" aria-current="page"><i class="fas fa-user-edit"></i> Edit Student Profile</li>
          <li class="breadcrumb-item ml-auto"><a href="<?php echo URLROOT; ?>/admins/dashboard"><i class="fas fa-home"></i> Home</a></li>
          <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-user-edit"></i> Edit Student Profile</li>
        </ol>
      </nav>

      <!-- Searching Methods -->
      <?php //Checking is admin viewing any profile ?>
      <?php if(!isset($data['student_id'])): ?>
      <div class="row m-3">
        <div class="col py-2 bg-light border border-info rounded">
          <div class="row">
            <div class="col-5">
              <form class="" action="<?php echo URLROOT; ?>/admins/viewstudentprofile" method="post">
                <div class="row">
                  <div class="col-5 form-group my-0">
                    <input type="text" name="search_keyword" value="" class="form-control" placeholder="Enter Keyword" required>
                  </div>
                  <div class="col-4 form-group my-0">
                    <select class="form-control" name="search_type" required>
                      <option value="" selected disabled>Search By</option>
                      <option value="username">Username</option>
                      <option value="rollnumber">Roll Number</option>
                      <option value="fullname">Full Name</option>
                    </select>
                  </div>
                  <div class="col-3 form-group my-0">
                    <input type="submit" name="search" value="Search" class="btn btn-primary btn-block">
                  </div>
                </div>
              </form>
            </div>

            <div class="col-2 form-group my-0 text-center">
              <p class="m-0 w-100 pt-2">OR</p>
            </div>

            <div class="col-5">
              <form class="" action="<?php echo URLROOT; ?>/admins/viewstudentprofile" method="post">
                <div class="row">
                  <div class="col-5 form-group m-0">
                    <select class="form-control" name="class" required>
                      <option value="" disabled selected>Class</option>
                      <option value="5">5th</option>
                      <option value="6">6th</option>
                      <option value="7">7th</option>
                      <option value="8">8th</option>
                      <option value="9">9th</option>
                      <option value="10">10th</option>
                      <option value="11">11th</option>
                      <option value="12">12th</option>
                      <option value="allclass">All Class</option>
                    </select>
                  </div>
                  <div class="col-5 form-group m-0">
                    <select class="form-control" name="section" required>
                      <option value="" disabled selected>Section</option>
                      <option value="a">Section A</option>
                      <option value="b">Section B</option>
                      <option value="c">Section C</option>
                      <option value="allsection">All section</option>
                    </select>
                  </div>
                  <div class="col-2 form-group m-0">
                    <input type="submit" name="go" class="btn btn-warning btn-block" value="Go!">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <!--Search Result-->
      <?php //If search happened ?>
      <?php if((count($data) != 0) && !isset($data['student_id'])): ?>
      <div class="row m-0">
        <div class="col">
          <?php //Checking Student found or not ?>
          <?php if(!isset($data['student_not_found'])): ?>
          <table class="table table-striped table-secondary table-hover">
            <thead class="bg-info text-white">
              <tr class="text-center">
                <th scope="col">Name</th>
                <th scope="col">Username</th>
                <th scope="col">Class</th>
                <th scope="col">Section </th>
                <th scope="col">Roll Number </th>
                <th scope="col">Edit</th>
                <th scope="col">View</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data as $key => $value): ?>
              <tr class="text-center">
                <td><?= $value->fullname; ?></td>
                <td><?= $value->username; ?></td>
                <td><?= $value->class."th"; ?></td>
                <td><?= "Section-".ucfirst($value->section); ?></td>
                <td><?= $value->rollnumber; ?></td>
                <td><a href="<?= URLROOT; ?>/admins/editstudentprofile/<?= $value->user_id; ?>" class="text-success"><i class="fas fa-pencil-alt"></i> Edit</a></td>
                <td><a href="<?= URLROOT; ?>/admins/viewstudentprofile/<?= $value->user_id; ?>" class="text-primary"><i class="fas fa-eye"></i> View</a></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
            <h3 class="text-center mt-5 d-block w-100">Student Not Found</h3>
        <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>

      <!--Student Details-->
      <?php //if admin is viewing any profile ?>
      <?php if(isset($data['student_id'])): ?>
      <div class="row m-3">
        <div class="col py-2 bg-light border border-info rounded">

          <div class="alert alert-danger rounded <?php echo (!empty($data['error']))? '' : 'd-none'; ?>"><?php echo $data['error']; ?></div>
          <?php flash('changeStudentData'); ?>

          <form class="" action="<?php echo URLROOT; ?>/admins/editstudentprofile/<?php echo $data['student_id']; ?>" method="post">
            <div class="row">
              <div class="col">

                <!-- Student detail -->
                <div class="card mb-3 border border-info rounded">
                  <div class="card-head bg-info">
                    <p class="m-2 ml-3 text-white"><i class="fa fa-info-circle"></i> Student Details</p>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col form-group">
                        <input type="text" name="first_name" class="form-control" value="<?= $data['first_name']; ?>" placeholder="First Name"  required>
                      </div>
                      <div class="col form-group">
                        <input type="text" name="last_name" class="form-control" value="<?= $data['last_name']; ?>" placeholder="Last Name"  required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col form-group">
                        <input type="date" name="date_of_birth" class="form-control" value="<?= $data['date_of_birth']; ?>"  required>
                      </div>
                      <div class="col form-group">
                        <select class="form-control" name="gender"  required>
                          <option value="" disabled <?php if($data['gender'] == ""){ echo 'selected'; } ?>>Gender</option>
                          <option value="male" <?php if($data['gender'] == "male"){ echo 'selected'; } ?>>Male</option>
                          <option value="female" <?php if($data['gender'] == "female"){ echo 'selected'; } ?>>Female</option>
                          <option value="others" <?php if($data['gender'] == "others"){ echo 'selected'; } ?>>Others</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col form-group mb-0 input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-secondary text-white" id="username">Username</span>
                        </div>
                        <input type="text" name="username" class="form-control" value="<?= $data['username']; ?>" placeholder="Username"  required>
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
                        <input type="text" name="current_address" class="form-control" value="<?= $data['current_address']; ?>" placeholder="Address"  required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col form-group mb-0">
                        <input type="text" name="current_city" class="form-control" value="<?= $data['current_city']; ?>" placeholder="City"  required>
                      </div>
                      <div class="col form-group mb-0">
                        <select class="form-control" name="current_country" >
                          <option value="india">India</option>
                        </select>
                      </div>
                      <div class="col form-group mb-0">
                        <input type="text" name="current_pincode" class="form-control" value="<?= $data['current_pincode']; ?>" placeholder="Pincode"  required>
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
                        <input type="text" name="permanent_address" class="form-control" value="<?= $data['permanent_address']; ?>" placeholder="Address"  required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col form-group mb-0">
                        <input type="text" name="permanent_city" class="form-control" value="<?= $data['permanent_city']; ?>" placeholder="City"  required>
                      </div>
                      <div class="col form-group mb-0">
                        <select class="form-control" name="permanent_country" >
                          <option value="india">India</option>
                        </select>
                      </div>
                      <div class="col form-group mb-0">
                        <input type="text" name="permanent_pincode" class="form-control" value="<?= $data['permanent_pincode']; ?>" placeholder="Pincode"  required>
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
                            <select class="form-control" name="class"  required>
                              <option value="" disabled <?php if($data['class'] == ""){ echo 'selected'; } ?>>Class</option>
                              <option value="5" <?php if($data['class'] == "5"){ echo 'selected'; } ?>>5th</option>
                              <option value="6" <?php if($data['class'] == "6"){ echo 'selected'; } ?>>6th</option>
                              <option value="7" <?php if($data['class'] == "7"){ echo 'selected'; } ?>>7th</option>
                              <option value="8" <?php if($data['class'] == "8"){ echo 'selected'; } ?>>8th</option>
                              <option value="9" <?php if($data['class'] == "9"){ echo 'selected'; } ?>>9th</option>
                              <option value="10" <?php if($data['class'] == "10"){ echo 'selected'; } ?>>10th</option>
                              <option value="11" <?php if($data['class'] == "11"){ echo 'selected'; } ?>>11th</option>
                              <option value="12" <?php if($data['class'] == "12"){ echo 'selected'; } ?>>12th</option>
                            </select>
                          </div>
                          <div class="col form-group">
                            <select class="form-control" name="section"  required>
                              <option value="" disabled <?php if($data['section'] == ""){ echo 'selected'; } ?>>Section</option>
                              <option value="a" <?php if($data['section'] == "a"){ echo 'selected'; } ?>>Section A</option>
                              <option value="b" <?php if($data['section'] == "b"){ echo 'selected'; } ?>>Section B</option>
                              <option value="c" <?php if($data['section'] == "c"){ echo 'selected'; } ?>>Section C</option>
                            </select>
                          </div>
                          <div class="col form-group">
                            <input type="number" name="rollnumber" class="form-control" value="<?= $data['rollnumber']; ?>" placeholder="Roll Number"  required>
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
                            <input type="text" name="fathers_name" class="form-control" value="<?= $data['fathers_name']; ?>" placeholder="Father's name"  required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-secondary text-white" id="mothers_name_addon">Mother's Name</span>
                            </div>
                            <input type="text" name="mothers_name" class="form-control" value="<?= $data['mothers_name']; ?>" placeholder="Mother's name"  required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-secondary text-white" id="fathers_occupation_addon">Father's Occupation</span>
                            </div>
                            <input type="text" name="fathers_occupation" class="form-control" value="<?= $data['fathers_occupation']; ?>" placeholder="Father's occupation"  required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-secondary text-white" id="mothers_occupation_addon">Mother's Occupation</span>
                            </div>
                            <input type="text" name="mothers_occupation" class="form-control" value="<?= $data['mothers_occupation']; ?>" placeholder="Mothers's occupation"  required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-secondary text-white" id="annual_income">Annual Family Income</span>
                            </div>
                            <input type="text" name="annual_income" class="form-control" value="<?= $data['annual_income']; ?>" placeholder="Annual income of family"  required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-secondary text-white" id="fathers_number_addon">Father's Mobile Number</span>
                            </div>
                            <input type="text" name="fathers_mobile_number" class="form-control" value="<?= $data['fathers_mobile_number']; ?>" placeholder="Fathers Contact Number"  required>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-4 form-group">
                    <input type="submit" name="save" class="btn btn-primary btn-block" value="Save">
                  </div>
                  <div class="col-4 form-group">
                    <a href="<?= URLROOT; ?>/admins/editstudentprofile" class="btn btn-secondary btn-block">Search Again</a>
                  </div>
                  <div class="col-4 form-group">
                    <a href="<?= URLROOT; ?>/admins/editstudentprofile/<?= $data['student_id']; ?>" class="btn btn-warning btn-block">Reset</a>
                  </div>
                </div>

              </div>
            </div>
          </form>

        </div>
      </div>
      <?php endif; ?>

    </div>
  </div>

  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo URLROOT; ?>/js/main.js"></script>
</body>
</html>
