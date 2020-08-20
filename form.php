<?php
include('../config.php');
include('../server.php');
include('errors.php');

if (isset($_GET['logout'])) {
	session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['userid']);
	header("location: ../admin_login.php");
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smart Security Admin</title>
	<!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- Morris Chart Styles-->
   
        <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"> <i class="fa fa-lock"></i> <strong>SMART SECURITY</strong></a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="updateuser.php?update=<?php echo $_SESSION['userid'];?>"><i class="fa fa-user fa-fw"></i> Update Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="form.php?logout='1'"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>

                    <li>
                        <a href="tellers.php"><i class="fa fa-desktop"></i> Tellers</a>
                    </li>

                    <li>
                        <a href="users.php"><i class="fa fa-users"></i> Customers</a>
                    </li>

                    <li>
                        <a class="active-menu" href="form.php"><i class="fa fa-edit"></i> Form</a>
                    </li>
					<!-- <li>
                        <a href="chart.html"><i class="fa fa-bar-chart-o"></i> Charts</a>
                    </li>
                    <li>
                        <a href="tab-panel.html"><i class="fa fa-qrcode"></i> Tabs & Panels</a>
                    </li>
                    
                    <li>
                        <a href="table.html"><i class="fa fa-table"></i> Responsive Tables</a>
                    </li>
                    <li>
                        <a class="active-menu"  href="form.html"><i class="fa fa-edit"></i> Forms </a>
                    </li>


                    <li>
                        <a href="#"><i class="fa fa-sitemap"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Second Level Link</a>
                            </li>
                            <li>
                                <a href="#">Second Level Link</a>
                            </li>
                            <li>
                                <a href="#">Second Level Link<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#">Third Level Link</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Link</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Link</a>
                                    </li>

                                </ul>

                            </li>
                        </ul>
                    </li> -->
                    <!-- <li>
                        <a href="empty.html"><i class="fa fa-fw fa-file"></i> Empty Page</a>
                    </li> -->
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->

        <!-- form for customer registration -->
        <div id="page-wrapper" >
            <div id="page-inner">

			    <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            <?php if (!isset($_GET['register']) && (!isset($_POST['teller'])) && (!isset($_POST['customer'])) ){ ?> User Registration <?php } else{?> 
                                <?php if (isset($_GET['register']) && ($_GET['register'] == "add-teller") ){ ?> Teller 
                                <?php } else{ ?> Customer <?php } ?>
                                <small>Form Page .</small> <?php } ?> 
                        </h1>
                    </div>
                </div> 
                
                 <!-- /. ROW  -->
              <div class="row">
                <div class="col-lg-12">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <?php if (!isset($_GET['register']) && (!isset($_POST['teller'])) && (!isset($_POST['customer'])) ){ ?> <h1 class="page-header">
                                <small>Register a new system user, either </small> 
                                <a href="form.php?register=add-teller"> <button type="submit" class="btn btn-primary">Add a Teller</button> </a>
                                <small>or</small> 
                                <a href="form.php?register=add-client"> <button type="submit" class="btn btn-primary">Add a Customer </button> </a>
                            </h1> <?php } else{?> 
                            
                                        
                        <?php if (isset($_GET['register']) && ($_GET['register'] == "add-teller")){ ?>
                            <!--    teller -->
                            Teller Information Form

                        <?php } else{ ?>
                            <!-- customer -->
                            Customer Information Form
                        <?php } ?>
                            
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="centerme">
                                <div class="col-lg-8">
                                    <?php if (isset($_GET['register']) && ($_GET['register'] == "add-teller") ){ ?>
                                        <!--    teller -->
                                        <form role="form" method="post" action="form.php">
                                            <div class="form-group">
                                                <label>Full Names</label>
                                                <input name="name" class="form-control" placeholder="Enter Your Full Names">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input name="email" class="form-control" placeholder="email@secsystem.com">
                                            </div>
                                            <div class="form-group">
                                                <label>Department Name</label>
                                                <select name="department" class="form-control">
                                                    <option>Finance</option>
                                                    <option>Information Technology</option>
                                                    <option>More...</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input name="phone" class="form-control" placeholder="email@secsystem.com">
                                            </div>
                                            <div class="form-group">
                                                <label>Date Of Birth</label>
                                                <input type="date" name="dob" class="form-control" placeholder="Enter phone number">
                                            </div>
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select name="gender" class="form-control">
                                                    <option>Female</option>
                                                    <option>Male</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input name="password" type="password" class="form-control" placeholder="Enter Password">
                                            </div>
                                            <button type="submit" name="teller" class="btn btn-default">Submit Form</button>
                                            <button type="reset" class="btn btn-default">Reset Form</button>
                                        </form>

                                    <?php } else{ ?>
                                        <!-- customer -->
                                        <form role="form" method="post" action="form.php">
                                            <div class="form-group">
                                                <label>Full Names</label>
                                                <input name="name" class="form-control" placeholder="Enter Your Full Names">
                                            </div>
                                            <div class="form-group">
                                                <label>Account Number</label>
                                                <input name="acc" class="form-control" placeholder="i.e.: 10000230663450745">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input name="email" class="form-control" placeholder="email@secsystem.com">
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input name="phone" class="form-control" placeholder="Enter phone number">
                                            </div>
                                            <div class="form-group">
                                                <label>Data Of Birth</label>
                                                <input name="dob" type="date" class="form-control" placeholder="Enter text">
                                            </div>
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select name="gender" class="form-control">
                                                    <option>Female</option>
                                                    <option>Male</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input name="password" type="password" class="form-control" placeholder="Enter Password">
                                            </div>
                                            <button type="submit" name="customer" class="btn btn-default">Submit Form</button>
                                            <button type="reset" class="btn btn-default">Reset Form</button>
                                        </form>

                                    <!-- end of client form -->

                                    <?php }

                                    // admin adds a customer to the Security System
                                        if (isset($_POST['customer'])) {
                                            // receive all input values from client form
                                            $name = mysqli_real_escape_string($db, $_POST['name']);
                                            $acc = mysqli_real_escape_string($db, $_POST['acc']);
                                            $email = mysqli_real_escape_string($db, $_POST['email']);
                                            $phone = mysqli_real_escape_string($db, $_POST['phone']);
                                            $dob = mysqli_real_escape_string($db, $_POST['dob']);
                                            $gender = mysqli_real_escape_string($db, $_POST['gender']);
                                            $password = mysqli_real_escape_string($db, $_POST['password']);
                                        
                                            // form validation: ensure that the form is correctly filled ...
                                            // by adding (array_push()) corresponding error unto $errors array
                                            if (empty($name)) { array_push($errors, "name is required"); }
                                            if (empty($password)) { array_push($errors, "Password is required"); }
                                            if (empty($acc)) { array_push($errors, "your account number is required"); }
                                        
                                            else{  // first check the database to make sure 
                                            // a user does not already exist with the same username and/or email
                                            $user_check_query = "SELECT * FROM smart_security.client WHERE client.name='$name' OR email='$email' LIMIT 1";
                                            $result = mysqli_query($db, $user_check_query);
                                            $user = mysqli_fetch_assoc($result);
                                            
                                            if ($user) { 
                                                if ($user['email'] === $email) {
                                                array_push($errors, "User already exists");
                                                }
                                        
                                                if ($user['acc_no'] === $acc) {
                                                array_push($errors, "User already exists");
                                                }
                                            }
                                        
                                            // Finally, register user if there are no errors in the form
                                            if (count($errors) == 0) {
                                                $password = md5($password);//password before saving in the database
                                                
                                                $isdeleted = "no";
                                        
                                                // filling the user table
                                                $query = "INSERT INTO smart_security.client (client.name,acc_no, email, phone, dob, gender, client.password, isdeleted) 
                                                    VALUES('$name','$acc','$email','$phone', '$dob', '$gender', '$password', '$isdeleted')";
                                        
                                                mysqli_query($db, $query);

                                                echo "<script>
                                                    alert('Client successfully registered.');
                                                    window.location.href='form.php';
                                                    </script>";
                                            }
                                         }
                                        }

                                    // admin adds a customer to the Security System
                                        if (isset($_POST['teller'])) {
                                            $name = mysqli_real_escape_string($db, $_POST['name']);
                                            $department = mysqli_real_escape_string($db, $_POST['department']);
                                            $email = mysqli_real_escape_string($db, $_POST['email']);
                                            $phone = mysqli_real_escape_string($db, $_POST['phone']);
                                            $dob = mysqli_real_escape_string($db, $_POST['dob']);
                                            $gender = mysqli_real_escape_string($db, $_POST['gender']);
                                            $password = mysqli_real_escape_string($db, $_POST['password']);
                                        
                                            // form validation: ensure that the form is correctly filled ...
                                            // by adding (array_push()) corresponding error unto $errors array
                                            if (empty($name)) { array_push($errors, "Set User Name"); }
                                            if (empty($password)) { array_push($errors, "Set Password"); }
                                        
                                            else{  // first check the database to make sure 
                                            // a user does not already exist with the same username and/or email
                                            $user_check_query = "SELECT * FROM smart_security.teller WHERE user.name='$name' OR email='$email' LIMIT 1";
                                            $result = mysqli_query($db, $user_check_query);
                                            $user = mysqli_fetch_assoc($result);
                                            
                                            if ($user) { 
                                                if ($user['email'] === $name) {
                                                array_push($errors, "User already exists");
                                                }
                                            }
                                        
                                            // Finally, register user if there are no errors in the form
                                            if (count($errors) == 0) {
                                                $password = md5($password);//password before saving in the database
                                        
                                                // adding photo and database state
                                                // $userPhoto = "profileIcon.jpg";
                                                $isdeleted = "no";
                                        
                                                // filling the user table
                                                $query = "INSERT INTO smart_security.teller (teller.name, email, department, phone, dob, gender, teller.password, isdeleted) 
                                                    VALUES('$name','$email','$department','$phone', '$dob', '$gender', '$password', '$isdeleted')";
                                        
                                                mysqli_query($db, $query);

                                                echo "<script>
                                                    alert('Teller successfully registered.');
                                                    window.location.href='form.php';
                                                    </script>";
                                            }
                                         }
                                        }
                                    ?>

                                </div>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                                    <?php } ?>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
			</div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    
   
</body>
</html>
