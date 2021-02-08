<?php
include('../config.php');
include('../server.php');
include('errors.php');
include ('meRaviQr/qrlib.php');
include ('config.php');

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
                            <a class="active-menu" href="generateQR.php"><i class="fa fa-edit"></i> Record A Transaction</a>
                        </li>

                    <?php } ?>


                    <?php if(isset($_SESSION['TellerT'])) { ?>

                        <li>
                            <a href="tellerIndex.php"><i class="fa fa-edit"></i> Dashboard</a>
                        </li>

                        <li>
                            <a class="active-menu" href="generateQR.php"><i class="fa fa-edit"></i> Record A Transaction</a>
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
                        <h1 class="page-header"> Generate QR Code <small> Form Page .</small>
                        </h1>
                    </div>
                </div> 
                
                 <!-- /. ROW  -->
              <div class="row">
                <div class="col-lg-12">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 class="page-header">
                                Transaction <small> Details </small> 
                            </h1>
                            
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="centerme">
                                    <div class="col-lg-8">
                                        <?php
                                        if(isset($_POST['transaction']))
                                            {
                                                $date = mysqli_real_escape_string($db, $_POST['date']);
                                                $amount = mysqli_real_escape_string($db, $_POST['amount']);
                                                $depositor_id = mysqli_real_escape_string($db, $_POST['depositor_id']);
                                                $description = mysqli_real_escape_string($db, $_POST['description']);
                                                $tid = $_SESSION['userid'];
                                                $qrImgName = "mrDe".rand();

                                                if (empty($date)) { array_push($errors, "Provide Transaction Date"); 
                                                    echo "<script>alert('Please enter transaction date');</script>";
                                                }
                                                $date_now = date("Y-m-d"); // this format is string comparable
                                                $date = date('Y-m-d', strtotime(str_replace('-', '/', $date)));
                                                
                                                if ($date_now != $date) { array_push($errors, "Provide a valid transaction date");
                                                    echo "<script>alert('Please enter a valid transaction date');</script>";
                                                }
                                                if (empty($amount)) { array_push($errors, "Provide Transaction amount");
                                                    echo "<script>alert('Please enter transaction amount');</script>";
                                                }
                                                if ((intval($amount) != $amount)) { array_push($errors, "Provide Transaction amount");
                                                    echo "<script>alert('Please enter amount to transact');</script>";
                                                }

                                                if (intval($amount) < 1) { array_push($errors, "Provide Transaction amount");
                                                    echo "<script>alert('Please enter valid transaction amount');</script>";
                                                }

                                                if (empty($depositor_id)) { array_push($errors, "Provide Depositors Id"); 
                                                    echo "<script>alert('Please enter transaction depositer id number');</script>";
                                                }
                                                if (empty($description)) { array_push($errors, "Provide Descrption"); 
                                                    echo "<script>alert('Please enter transaction description');</script>";
                                                }
                                                
                                                if (count($errors) == 0) {
                                                    $sql ="SELECT * FROM client where acc_no = '$depositor_id'";

                                                    $query = mysqli_query($db, $sql);

                                                    if (mysqli_num_rows($query) > 0) {

                                                    // create qr code

                                                    
                                                    $query ="INSERT INTO smart_security.transaction (transaction_date, teller_id, amount, depositor_id, descript) VALUES('$date','$tid','$amount','$depositor_id', '$description')";
                                                
                                                    // mysqli_query($db, $query);
                                                    
                                                    if(mysqli_query($db, $query)){
                                                        // echo "Records added successfully.";
                                                                                                            // check and get the last id 
                                                    $sql = "SELECT * from smart_security.transaction order by id desc limit 1";
                            
                                                    $query = mysqli_query($db, $sql);
                                                    if (mysqli_num_rows($query) > 0) {
                                                        $result=mysqli_fetch_assoc($query);
                                                        $qc = ($result['id']);
                                                        //   echo "<script>alert('transaction id $qc ');
                                                        //   </script>";
                                                    }
        
                                                    echo "<script>
                                                    alert('Transaction successfully registered.');
                                                    </script>";
                                                    $final = $qc;
                                                    $qrs = QRcode::png($final,"userQr/$qrImgName.png","H","3","3");
                                                    $qrimage = $qrImgName.".png";
                                                    $workDir = $_SERVER['HTTP_HOST'];
                                                    $qrlink = $workDir."/qrcode".$qrImgName.".png";
                                                    $insQr = $mrDe->insertQr($depositor_id,$final,$qrimage,$qrlink);
                                                    if($insQr==true)
                                                    {
                                                        $sql = "SELECT * from smart_security.qrcodes order by id desc limit 1";
                            
                                                        $query = mysqli_query($db, $sql);
                                                        if (mysqli_num_rows($query) > 0) {
                                                              echo "<script>window.location='generateQR.php?success=$qrimage';</script>";
                                                        }

    
                                                    }
                                                        else{
                                                        echo "<script>alert('QR Code cant create');</script>";}
                                                    }
                                                    else{
                                                        echo "ERROR: Could not able to execute $query. " . mysqli_error($db);
                                                    }

                                                    }
                                                    else{
                                                        echo "<script>alert('Account Number does not exist, Please verify Account Number and try again');</script>";
                                                    }
                                                }
                                            }
                                            ?>
                                        <?php 
                                            if(isset($_GET['success']))
                                            {
                                                $imgGetId = $_GET['success'];
                                                $sql = "SELECT qrContent from qrcodes where qrImg = '$imgGetId'";
                                                $query = mysqli_query($db, $sql);

                                                if(mysqli_num_rows($query) > 0){
                                                    $result=mysqli_fetch_assoc($query);
                                                    $id = ($result['qrContent']);


                                                    $sql = "SELECT * from smart_security.transaction where id = '$id'";

                                                    $query = mysqli_query($db, $sql);
                                                        if (mysqli_num_rows($query) > 0) {
                                                            $result=mysqli_fetch_assoc($query);
                                                            // $amount = ($result['amount']);
                                                            //   echo "<script>alert('Amount $amount');
                                                            //   </script>";
                                                            }
                                                }
                                           ?>

                                           <h3 class="page-header"> Transaction date: <small> <?php echo $result['transaction_date']; ?> </small> </h3>
                                               
                                           <h3 class="page-header"> Transaction total amount: <small> <?php echo $result['amount']; ?> Rwandan Francs</small> </h3>
                                           
                                           <h3 class="page-header"> Depositor id: <small> <?php echo $result['depositor_id']; ?> </small> </h3>
                                           
                                           <h3 class="page-header"> Description: <small> <?php echo $result['descript']; ?> </small> </h3>
                                            
                                                <img src="userQr/<?php echo $_GET['success']; ?>" alt="">
                                                <?php 
                                                $workDir = $_SERVER['HTTP_HOST'];
                                                $qrlink = $workDir."/qrcode/userQr/".$_GET['success'];
                                                ?>
                                                
                                                <input type="text" value="<?php echo $qrlink; ?>" readonly>
                                                <br><br>
                                            <a href="download.php?download=<?php echo $_GET['success']; ?>">Download Now</a>
                                            <br>
                                            <br><br>
                                                <a href="index.php">Go Back To Generate Again</a>
                                                
                                                </div></div>
                                                
                                        <?php
                                            }
                                            else
                                            {
                                            ?>
                                            


                                            <!--   *********************** teller and admin create qr code ***************************-->
                                        <form role="form" method="post" action="generateQR.php">

                                            <div class="form-group">
                                                <label>Transaction Date</label>
                                                <input type="date" name="date" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Amount (in Rwf)</label>
                                                <input name="amount" class="form-control" placeholder="E.g.: 1000">
                                            </div>
                                            <div class="form-group">
                                                <label>Client Account Number</label>
                                                <input name="depositor_id" class="form-control" placeholder="123165498846545">
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <input name="description" class="form-control" placeholder="Materials purchase">
                                            </div>
                                            <button type="submit" name="transaction" class="btn btn-default">Submit Form</button>
                                            <button type="reset" class="btn btn-default">Reset Form</button>

                                        </form>
                                                <?php 
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
