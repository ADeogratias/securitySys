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

                        <li>
                            <a class="active-menu" href="generateQR.php"><i class="fa fa-print"></i> Generate Report</a>
                        </li>

                    <?php } ?>


                    <?php if(isset($_SESSION['TellerT'])) { ?>

                        <li>
                            <a href="tellerIndex.php"><i class="fa fa-edit"></i> Dashboard</a>
                        </li>

                        <li>
                            <a href="generateQR.php"><i class="fa fa-edit"></i> Record A Transaction</a>
                        </li>

                        <li>
                            <a class="active-menu" href="generateQR.php"><i class="fa fa-print"></i> Generate Report</a>
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
                            Generate Report 
                        </h1>
                    </div>
                </div> 
                
                 <!-- /. ROW  -->
              <div class="row">
                <div class="col-lg-12">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">

                        <!-- logo goes here -->
                            
                            <h1 class="page-header">
                               <small>Transaction Report </small> 
                            </h1>
                            
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="centerme">
                                <div class="col-lg-8">
                                    <form role="form" method="post" action="report.php">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input type="date" name="startdate" class="form-control" placeholder="Enter phone number">
                                        </div>
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input type="date" name="enddate" class="form-control" placeholder="Enter phone number">
                                        </div>
                                        <button name="searchreport" type="submit" class="btn btn-primary">Search</button> 
                                    </form>
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
            <?php 

// search for transactions  in the System
    if (isset($_POST['searchreport'])) {
        $startdate = mysqli_real_escape_string($db, $_POST['startdate']);
        $enddate = mysqli_real_escape_string($db, $_POST['enddate']);

        $sql="SELECT * FROM smart_security.transaction WHERE transaction_date>='$startdate' and transaction_date<='$enddate'";
        $query = $dbh -> prepare($sql);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() > 0){
        ?>
        

        <div id="printableArea">
        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="panel panel-default">

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Transaction Date</th>
                                    <th>Amount</th>
                                    <th>Account No.</th>
                                    <th>Description</th>
                                    <th>Officer Id</th>
                                    <!-- <th>CSS grade</th> -->
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($results as $result)
                                { ?>
                            <tr class="odd gradeX">
                                <td><?php echo htmlentities($result->transaction_date);?></td>
                                <td><?php echo htmlentities($result->amount);?></td>
                                <td><?php echo htmlentities($result->depositor_id);?></td>
                                <td><?php echo htmlentities($result->descript);?></td>
                                <td><?php echo htmlentities($result->teller_id);?></td> 
                            </tr> 
                                
                                <?php }
                            
                            }  else{?>   
                                
                            <tr class="odd gradeX">                                            
                                <td>No Transaction</td>
                                <td>No Transaction</td>
                                <td>No Transaction</td>
                                <td class="center">No Transaction</td>
                                <td class="center">No Transaction</td>
                            </tr> 
                                
                            <?php }  ?>
                                
                        </tbody>
                    </table>
                </div>
                    
            </div>
        <!--End Advanced Tables -->
    </div>
    <input id="print" type="button" onclick="printDiv('printableArea')" value="Print" />
    </div>

    <script>
        function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
        }
    </script>
<?php } ?>
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
