<?php require APPROOT . '/views/inc/header.php' ?>
<?php
  if(!isLoggedIn()){
    redirect('users/login');
  }
  if(isSessionAdmin() != "yes"){
    redirect('users/login');
  }
?>
<link rel="stylesheet" href="<?php echo URLROOT ?>/css/adminDashboard.css">

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
          <a class="nav-link active" href="<?php echo URLROOT; ?>/admins/maintainfee"><i class="fas fa-dollar-sign"></i> &nbsp;Maintain Fee</a>
        </li>
      </ul>

    </div>


    <!--Right section-->
    <div class="col px-0">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2 mx-3 mt-2 bg-light">
          <li class="active" aria-current="page"><i class="fas fa-dollar-sign"></i> &nbsp;Maintain Fee</li>
          <li class="breadcrumb-item ml-auto"><a href="<?php echo URLROOT; ?>/admins/dashboard"><i class="fas fa-home"></i> Home</a></li>
          <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-dollar-sign"></i> &nbsp;Maintain Fee</li>
        </ol>
      </nav>

      <!-- Searching Methods -->
      <?php //Checking is admin viewing any profile ?>
      <?php if(!isset($data['student_id'])): ?>
      <div class="row m-3">
        <div class="col py-2 bg-light border border-info rounded">
          <div class="row">
            <div class="col-5">
              <form class="" action="<?php echo URLROOT; ?>/admins/maintainfee" method="post">
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
              <form class="" action="<?php echo URLROOT; ?>/admins/maintainfee" method="post">
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
                <th scope="col">Details</th>
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
                <td><a href="<?= URLROOT; ?>/admins/maintainfee/<?= $value->user_id; ?>" class="text-success"><i class="fas fa-file-alt"></i> Details</a></td>
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
        <div class="col py-2 bg-secondary border border-info rounded">
          <div class="row">
            <div class="col">
              <?php flash('addFee'); ?>
              <form class="" action="<?php echo URLROOT; ?>/admins/maintainfee/<?= $data['student_id']; ?>" method="post">
                <div class="row">
                  <div class="col-2 form-group my-0">
                    <select class="form-control" name="fee_month" required>
                      <option value="" disabled selected>Fee Month</option>
                      <option value="january">January</option>
                      <option value="february">February</option>
                      <option value="march">March</option>
                      <option value="april">April</option>
                      <option value="may">May</option>
                      <option value="june">June</option>
                      <option value="july">July</option>
                      <option value="august">August</option>
                      <option value="september">September</option>
                      <option value="october">October</option>
                      <option value="november">November</option>
                      <option value="december">December</option>
                    </select>
                  </div>
                  <div class="col-4 form-group input-group my-0">
                    <div class="input-group-prepend">
                      <span class="input-group-text bg-info text-white" id="payment_date_addon">Payment Date</span>
                    </div>
                    <input type="date" name="payment_date" value="" class="form-control">
                  </div>
                  <div class="col-2 form-group my-0">
                    <input type="number" name="fee_amount" value="" class="form-control" placeholder="Fee Amount" required>
                  </div>
                  <div class="col-3 form-group my-0">
                    <select class="form-control" name="payment_method" required>
                      <option value="" disabled selected>Payment Method</option>
                      <option value="-">NA</option>
                      <option value="cash">Cash</option>
                      <option value="cheque">Cheque</option>
                    </select>
                  </div>
                  <div class="col-1 form-group my-0">
                    <input type="submit" name="addfee" value="Add" class="btn btn-block btn-success">
                  </div>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>

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
              <?php if($key!=="student_id"): ?>
              <tr class="text-center">
                <td><?= $value->fee_month; ?></td>
                <td><?php if(isset($value->payment_date)){echo $value->payment_date;} else {echo "-";}; ?></td>
                <td><?= $value->fee_amount; ?></td>
                <td><?php if($value->payment_method != ""){echo $value->payment_method;} else {echo "-";}; ?></td>
                <td <?php if($value->status == 1){echo 'class="text-success">Paid';} else {echo 'class="text-danger">Due';}; ?></td>
              </tr>
            <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
          </table>
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
