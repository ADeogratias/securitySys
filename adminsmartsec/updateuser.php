<?php
include('../config.php');
include('../server.php');
include('errors.php');

if (isset($_GET['logout'])) {
	session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['userid']);
	header("location: ../index.php");
}

if (!isset($_SESSION['username'])) {
    header('location: ../index.php');
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
                    <?php if(isset($_SESSION['ClientT'])) { ?> <li><a href="updateuser.php?updatecustomer=<?php echo $_SESSION['userid'];?>"><i class="fa fa-user fa-fw"></i> Update Profile</a> </li> <?php } ?>
                        <?php if(isset($_SESSION['TellerT'])) { ?> <li><a href="updateuser.php?updateteller=<?php echo $_SESSION['userid'];?>"><i class="fa fa-user fa-fw"></i> Update Profile</a></li> <?php } ?>
                        <?php if(isset($_SESSION['adminT']) ) {?> <li><a href="updateuser.php?update=<?php echo $_SESSION['userid'];?>"><i class="fa fa-user fa-fw"></i> Update Profile</a></li> <?php } ?>
                        <li class="divider"></li>
                        <li><a href="updateuser.php?logout='1'"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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

                    <?php if(isset($_SESSION['adminT']) ) {?>

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
                            <a href="form.php"><i class="fa fa-edit"></i> Add New User</a>
                        </li>

                        <li>
                            <a href="generateQR.php"><i class="fa fa-edit"></i> Record A Transaction</a>
                        </li>

                    <?php } ?>


                    <?php if(isset($_SESSION['TellerT'])) { ?>

                        <li>
                            <a href="tellerIndex.php"><i class="fa fa-edit"></i> Dashboard</a>
                        </li>

                        <li>
                            <a href="generateQR.php"><i class="fa fa-edit"></i> Record A Transaction</a>
                        </li>
                    
                    <?php } ?>

                    <?php if(isset($_SESSION['ClientT'])) { ?>
                        <li>
                            <a href="clientIndex.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                        </li>
                    <?php } ?>

                        <li>
                            <a href="scanQR.php"><i class="fa fa-qrcode"></i> Scan QR-Code</a>
                        </li>
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
                            <?php if (isset($_GET['updateteller'])) { ?> Teller Profile Page <?php } else{
                                if (isset($_GET['update']) ){ ?> Admin 
                                <?php } else{ ?> User <?php } ?>
                                <small>Profile Page .</small> <?php } ?> 
                        </h1>
                    </div>
                </div> 
                
                 <!-- /. ROW  -->
              <div class="row">
                <div class="col-lg-12">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <?php if (isset($_GET['updateteller']) ){ ?> <h1 class="page-header">
                                <small>Update Teller Record </small> 
                            </h1> <?php } else{?> 
                                        
                        <?php if (isset($_GET['update'])){ ?>
                            <!--    teller -->
                            Update Admin Record

                        <?php } else{ ?>
                            <!-- customer -->
                            Update User Record
                        <?php }} ?>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="centerme">
                                <div class="col-lg-8">
                                    <?php if (isset($_GET['updateteller'])) {

                                        
                                    //<!--    ********************************** teller ************************* -->
                                        
                                        $id = $_GET['updateteller'];
                                        $sql = "SELECT teller.email,teller.department, teller.phone from smart_security.teller where (teller.id = '$id')";
                            
                                        $query = mysqli_query($db, $sql);
                                        if (mysqli_num_rows($query) > 0) {
                                            $result=mysqli_fetch_assoc($query);
                                            $email = ($result['email']);
                                            $department = ($result['department']);
                                            $phone = ($result['phone']);
                                        }
                                        ?>

                                        <!--    ********************************** teller ************************* -->
                                        <form role="form" method="post" action="updateuser.php?id=<?php echo $_GET['updateteller'];?>">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input name="email" class="form-control" value="<?php echo $email; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Department Name</label>
                                                <select name="department" class="form-control">
                                                <option  value = "<?php echo ("$department") ?>" selected= 'selected'> <?php echo ("$department") ?>  </option>
                                                    <option> Finance </option>
                                                    <option> Information Technology</option>
                                                    <option> More... </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input name="phone" class="form-control" value="<?php echo $phone; ?>">
                                            </div>
                                            <button type="submit" name="updateteller" class="btn btn-default">Update Teller</button>
                                        </form>

                                    <?php } 
                                    
                                    //  *************************** admin ************************************* 
                                    if (isset($_GET['update'])){ 

                                        $id = $_GET['update'];
                                        $sql = "SELECT adminName, adminPassword from smart_security.admin where (id = '$id')";
                            
                                        $query = mysqli_query($db, $sql);
                                        if (mysqli_num_rows($query) > 0) {
                                            $result=mysqli_fetch_assoc($query);
                                            $email = ($result['adminName']);
                                            $password = ($result['adminPassword']);
                                        }
                                        ?>

                                            <!--  ***************************** admin ********************** -->
                                        <form role="form" method="post" action="updateuser.php?id=<?php echo $_GET['update'];?>">
                                            <div class="form-group">
                                                <label>adminName</label>
                                                <input name="email" class="form-control" value="<?php echo $email; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>adminPassword</label>
                                                <input name="password" class="form-control" value="<?php echo $password; ?>">
                                            </div>
                                            <button type="submit" name="update" class="btn btn-default">Update Admin</button>
                                        </form>

                                    <?php } 

                                            //  **********************CUstomer *************************** 
                                    if (isset($_GET['updatecustomer'])){ 

                                        $id = $_GET['updatecustomer'];
                                        $sql = "SELECT acc_no, email, phone from smart_security.client where (id = '$id')";
                            
                                        $query = mysqli_query($db, $sql);
                                        if (mysqli_num_rows($query) > 0) {
                                            $result=mysqli_fetch_assoc($query);
                                            $acc_no = ($result['acc_no']);
                                            $email = ($result['email']);
                                            $phone = ($result['phone']);
                                        }
                                        ?>

                                            <!-- ******************************     CUstomer ********************* -->
                                        <form role="form" method="post" action="updateuser.php?id=<?php echo $_GET['updatecustomer'];?>">
                                            
                                            <div class="form-group">
                                                <label>Account Number</label>
                                                <input name="acc_no" class="form-control" value="<?php echo $acc_no; ?>">
                                            </div>

                                            <div class="form-group">
                                                <label>Email</label>
                                                <input name="email" class="form-control" value="<?php echo $email; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input name="phone" class="form-control" value="<?php echo $phone; ?>">
                                            </div>
                                            <button type="submit" name="updatecustomer" class="btn btn-default">Update Client</button>
                                        </form>

                                    <?php } 

                                    // admin update a customer to the Smart Security 
                                        if (isset($_POST['updateteller'])) {
                                            $id=intval($_GET['id']);
                                            $email = mysqli_real_escape_string($db, $_POST['email']);
                                            $department = mysqli_real_escape_string($db, $_POST['department']);
                                            $phone = mysqli_real_escape_string($db, $_POST['phone']);

                                            if (empty($department)) { array_push($errors, "Department is required"); }
                                            
                                            if (preg_match("/^[a-zA-Z-' ]*$/",$phone)) {
                                                echo "<script>alert('Only Numbers are allowed');</script>";
                                              }
                                            
                                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                                echo "<script>alert('Invalid email format');</script>";
                                            }
                                            if (empty($email)) { array_push($errors, "Email is email"); 
                                                echo "<script>alert('Provide email');</script>";
                                            }

                                            if (empty($phone)) { array_push($errors, "Set Phone Number ");
                                                echo "<script>alert('Provide Phone Number');</script>";
                                            }

                                            if (count($errors) == 0) {

                                                $sql="update  smart_security.teller x set email=:email,department=:department,phone=:phone where x.id=$id";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':email',$email,PDO::PARAM_STR);
                                                $query->bindParam(':department',$department,PDO::PARAM_STR);
                                                $query->bindParam(':phone',$phone,PDO::PARAM_STR);
                                                $query->execute();
                                            
                                                echo "<script>alert('Successfully updated Teller');
                                                window.location.replace('tellers.php') ;
                                                </script>";
                                            }
                                        }

                                    
                                        // admin update a admin to the Smart Security 
                                        if (isset($_POST['update'])) {
                                            $id=intval($_GET['id']);
                                            $email = mysqli_real_escape_string($db, $_POST['email']);
                                            $password = mysqli_real_escape_string($db, $_POST['password']);

                                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                                echo "<script>alert('Invalid email format');</script>";
                                            }
                                            if (empty($email)) { array_push($errors, "eamil is required"); 
                                                echo "<script>alert('Provide email');</script>";
                                            }
                                            if (empty($password)) { array_push($errors, "Password required"); }

                                            if (count($errors) == 0) {

                                                $sql="update  smart_security.admin x set adminName=:email,adminPassword=:password where x.id=$id";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':email',$email,PDO::PARAM_STR);
                                                $query->bindParam(':password',$password,PDO::PARAM_STR);
                                                $query->execute();
                                            
                                                echo "<script>alert('Successfully updated Admin');
                                                window.location.replace('index.php') ;
                                                </script>";
                                            }
                                        }

                                        // admin update a customer to the Smart Security 
                                        if (isset($_POST['updatecustomer'])) {
                                            $id=intval($_GET['id']);
                                            $acc_no = mysqli_real_escape_string($db, $_POST['acc_no']);
                                            $email = mysqli_real_escape_string($db, $_POST['email']);
                                            $phone = mysqli_real_escape_string($db, $_POST['phone']);

                                            if (empty($acc_no)) { array_push($errors, "your account number is required");
                                                echo "<script>alert('Your account number is required');</script>";
                                            }
                                            if (preg_match("/^[a-zA-Z-' ]*$/",$acc_no)) {
                                                echo "<script>alert('Only Numbers are allowed');</script>";
                                              }

                                            if (preg_match("/^[a-zA-Z-' ]*$/",$phone)) {
                                                echo "<script>alert('Only Numbers are allowed');</script>";
                                              }
                                            
                                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                                echo "<script>alert('Invalid email format');</script>";
                                            }
                                            if (empty($email)) { array_push($errors, "Email is required"); 
                                                echo "<script>alert('Provide email');</script>";
                                            }

                                            if (empty($phone)) { array_push($errors, "Set Phone Number ");
                                                echo "<script>alert('Provide Phone Number');</script>";
                                            }
                                        
                                            if (count($errors) == 0) {
                                                $sql="update  smart_security.client x set acc_no=:acc_no,email=:email,phone=:phone where x.id=$id";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':acc_no',$acc_no,PDO::PARAM_STR);
                                                $query->bindParam(':email',$email,PDO::PARAM_STR);
                                                $query->bindParam(':phone',$phone,PDO::PARAM_STR);
                                                $query->execute();
                                            
                                                echo "<script>alert('Successfully updated Client');
                                                window.location.replace('users.php') ;
                                                </script>";
                                            
                                            }
                                        }
                                    ?>

                                </div>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
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
