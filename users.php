﻿<?php
include('../config.php');
include('../server.php');

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
     <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
   
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
                <a class="navbar-brand" href="index.php"><i class="fa fa-lock"></i> <strong>SMART SECURITY</strong></a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Update Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="users.php?logout='1'"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                        <a href="index.html"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="tellers.php"><i class="fa fa-desktop"></i> Tellers</a>
                    </li>
                    <li>
                        <a class="active-menu" href="users.php"><i class="fa fa-users"></i> Customers</a>
                    </li>
                    <li>
                        <a href="form.php"><i class="fa fa-edit"></i> Form</a>
                    </li>
                </ul>

            </div>

        </nav>

        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">


                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Sytem <small>Users</small> <a href="form.php?register=add-client"> <button type="submit" class="btn btn-primary">Add a Client </button> </a>
                        </h1>
                            
                    </div>
                </div>
                
                 <!-- /. ROW  -->
                
               
                <div class="row">
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Advanced Tables
                            </div>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Account No</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>DOB</th>
                                            <th></th>
                                            <th></th>
                                            <!-- <th>CSS grade</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                            $sql="SELECT * from smart_security.client";
                                            $query = $dbh -> prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            if($query->rowCount() > 0){
                                                foreach($results as $result)
                                                    { ?>
                                                        <tr class="odd gradeX">
                                                            <td><?php echo htmlentities($result->name);?></td>
                                                            <td><?php echo htmlentities($result->acc_no);?></td>
                                                            <td><?php echo htmlentities($result->email);?></td>
                                                            <td><?php echo htmlentities($result->phone);?></td>
                                                            <td><?php echo htmlentities($result->dob);?></td> 
                                                            <td ><a href="server.php?deluser=<?php echo htmlentities($result->id);?>" onclick="return confirm('Sure you want to delete?');">Remove</a></td>
															<td ><a href="updateuser.php?updatecustomer=<?php echo htmlentities($result->id);?>">Update</a></td>                         
                                                        </tr> 
                                                <?php } } else{?>   
                                        <tr class="odd gradeX">                                            
                                            <td>Trident</td>
                                            <td>Internet Explorer 4.0</td>
                                            <td>Win 95+</td>
                                            <td class="center">4</td>
                                            <td class="center">X</td>
                                            <td class="center">4</td>
                                            <td class="center">X</td>
                                        </tr> 
                                        
                                        <?php }  ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
        </div>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
	 
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
	
	
	<script src="assets/js/easypiechart.js"></script>
	<script src="assets/js/easypiechart-data.js"></script>
	
	 <script src="assets/js/Lightweight-Chart/jquery.chart.js"></script>

     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
         <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    
   
</body>
</html>
