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

    <script src="../lib/qr-scanner.min.js"></script>
    <script src="../lib/qr-scanner-worker.min.js"></script>

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
                            <a class="active-menu" href="scanQR.php"><i class="fa fa-qrcode"></i> Scan QR-Code</a>
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
                                QR Code <small> Transaction Details </small> 
                            </h1>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="centerme">
                                <div class="col-lg-8">
                                <div id="printableArea">

                                    <?php 

                                        
                                        if (isset($_GET['qrid'])){
                                            $num = $_GET['qrid'];
                                            $sql = "SELECT * from smart_security.transaction where id='$num'";
                                            $query = mysqli_query($db, $sql); 

                                                if (mysqli_num_rows($query) > 0) {
                                                    $result=mysqli_fetch_assoc($query);
                                                
                                           ?>

                                           <h3 class="page-header"> Transaction date: <small> <?php echo $result['transaction_date']; ?> </small> </h3>
                                               
                                           <h3 class="page-header"> Transaction total amount: <small> <?php echo $result['amount']; ?> Rwandan Francs</small> </h3>
                                           
                                           <h3 class="page-header"> Depositor id: <small> <?php echo $result['depositor_id']; ?> </small> </h3>
                                           
                                           <h3 class="page-header"> Description: <small> <?php echo $result['descript']; ?> </small> </h3>
                                            
                                        <?php 
                                         $sql = "SELECT * from smart_security.qrcodes where qrContent='$num'";
                                            $query = mysqli_query($db, $sql);
                                            if (mysqli_num_rows($query) > 0) {
                                            $result=mysqli_fetch_assoc($query);
                                            $imag = ($result['qrImg']); }?>

                                                <img src="userQr/<?php echo $imag; ?>" alt="">
                                                <?php 
                                                $workDir = $_SERVER['HTTP_HOST'];
                                                $qrlink = $workDir."/qrcode/userQr/".$imag;
                                                ?>
                                                
                                                <input type="text" value="<?php echo $qrlink; ?>" readonly>
                                                <br><br>
                                            <a href="download.php?download=<?php echo $imag; ?>">Download Now</a>
                                            <br>
                                            <br><br>
                                                <a href="scanQR.php">Go Back To Scan a QR Code</a>

                                                
                                                </div>
                                                <input id="print" type="button" onclick="printDiv('printableArea')" value="Print" />
                                                </div></div>
                                                <script>
                                                    function printDiv(divName) {
                                                        var printContents = document.getElementById(divName).innerHTML;
                                                        var originalContents = document.body.innerHTML;

                                                        document.body.innerHTML = printContents;

                                                        window.print();

                                                        document.body.innerHTML = originalContents;
                                                    }
                                                </script>
                                                
                                        <?php } else{ ?>
                                            
                                            <b>Detected QR code is not part of the system: </b> 
                                            <?php echo $num; ?> <br><br>
                                            <a href="scanQR.php">Go Back To Scan a QR Code</a>

                                            <?php } } else{ ?>

                                        <b>Detected QR code: </b>
                                        <span id="cam-qr-result"></span>
                                        <br>

                                        <b>Last detected at: </b>
                                        <span id="cam-qr-result-timestamp"></span>
                                        <br>
                                        
                                        <b>Device has camera: </b>
                                        <span id="cam-has-camera"></span>
                                        <br>

                                        <br>
                                        <video style="width:75rem" id="qr-video"></video>
                                        </br>

                                        <button id="start-button">Start</button>
                                        <button id="stop-button">Stop</button>
                                        <?php


                                        } ?>

                                    <script type="module">
                                        import QrScanner from "../lib/qr-scanner.min.js";
                                        QrScanner.WORKER_PATH = '../lib/qr-scanner-worker.min.js';
                                    
                                        const video = document.getElementById('qr-video');
                                        const camHasCamera = document.getElementById('cam-has-camera');
                                        const camHasFlash = document.getElementById('cam-has-flash');
                                        const flashToggle = document.getElementById('flash-toggle');
                                        const flashState = document.getElementById('flash-state');
                                        const camQrResult = document.getElementById('cam-qr-result');
                                        const camQrResultTimestamp = document.getElementById('cam-qr-result-timestamp');
                                        const fileSelector = document.getElementById('file-selector');
                                        const fileQrResult = document.getElementById('file-qr-result');
                                        var resulttouse;
                                    
                                        function setResult(label, result) {
                                            label.textContent = result;
                                            resulttouse = result;
                                            camQrResultTimestamp.textContent = new Date().toString();
                                            clearTimeout(label.highlightTimeout);
                                            label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
                                            window.location.href = "scanQR.php?qrid=" + result;

                                        }
                                    
                                        // ####### Web Cam Scanning #######
                                    
                                        QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = hasCamera);
                                    
                                        const scanner = new QrScanner(video, result => setResult(camQrResult, result));
                                        scanner.start().then(() => {
                                            scanner.hasFlash().then(hasFlash => {
                                                camHasFlash.textContent = hasFlash;
                                                if (hasFlash) {
                                                    flashToggle.style.display = 'inline-block';
                                                    flashToggle.addEventListener('click', () => {
                                                        scanner.toggleFlash().then(() => flashState.textContent = scanner.isFlashOn() ? 'on' : 'off');
                                                    });
                                                }
                                            });
                                        });
                                    
                                        // for debugging
                                        window.scanner = scanner;
                                    
                                        document.getElementById('start-button').addEventListener('click', () => {
                                            scanner.start();
                                        });
                                    
                                        document.getElementById('stop-button').addEventListener('click', () => {
                                            scanner.stop();
                                        });
                                    
                                    </script>


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