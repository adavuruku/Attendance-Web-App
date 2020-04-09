
<?php
session_start(); 
//require_once 'settings/connection.php';
//require_once 'settings/filter.php';

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Home | Abubakar Tafawa University Bauchi </title>
<link rel="shortcut icon" href="../store_files/images/image_demo.jpg">
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap-theme.css" >
<script type="text/javascript" src="settings/js/bootstrap.js"></script>
<script type="text/javascript" src="settings/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="settings/js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="settings/js/bootstrap.min.js"></script>
<script type="text/javascript" src="settings/js/bootstrap.min.js"></script>
</head>
<body id="container" style="padding-top:2%;font-family:Tahoma, Times, serif;font-weight:bold;">


<div class="container" style="padding-top:10px;">
	<div class="row">
		<div  class="col-sm-1 col-md-1 col-lg-1" style="padding-left:20px;" ></div>
		
			<div  class="col-lg-10" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
				<h3 style="text-align:center;color:yellow">ATBU System Home Platform</h3>
			</div>
		<div  class="col-sm-1 col-md-1 col-lg-1" style="padding-left:20px;" ></div>
		<div  class="col-sm-12 col-md-12 col-lg-12" style="background-color:#CCFFFF;">
			<div id="myModal" >
				<div class="modal-dialog modal-lg modal-sm modal-md">
					<div class="modal-content">
						<div class="modal-header label-primary" >
							<button type="button" style="color:RED;font-family:comic sans ms;font-size:20px;font-weight:bold" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" style="color:WHITE;font-family:comic sans ms;font-size:25px;font-weight:bold">ABOUT THE PROJECT - STUDENT ATTENDANCE MANAGEMENT SYSTEM - (SAMS)</h4>
						</div>
						<div class="modal-body" style="font-family:comic sans ms;font-size:15px;font-weight:bold">
							<p>Abubakar Tafawa Balewa University, Bauchi - Bauchi State Nigeria.</p>
							<p>The Project Student Attendance Management System - (SAMS). is Design By :</p>
							<p> Habila Mercy Tamidah - Registration N<u>o</u> : 13/36759U/1 .</p>
							<br>
							<p >For the Partial Fulfillment of the requirement for the Award of Bachelor Of Technology (BTech) in Computer Science - Abubakar Tafawa Balewa University, Bauchi - 2018</p><br>
							<p  style="color:red">Supervised By : Mal. S. K. Alarama.</p>
							<p  class="text-warning"><small >Copyright © 2018</small></p>
						</div>
						<div class="modal-footer label-primary">
							<span class="btn btn-success"><a href="admin/index.php"><span class="btn btn-primary">Staff Login</span></a></span>
							<span class="btn btn-success pull-left"><a href="Customer_Login.php"><span class="btn btn-primary">Student Login</span></a></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div  class="col-lg-12" style="padding-top:10px; padding-left:5px; 1510px; background-color:grey;margin-bottom:1%">
		</div>
	</div>
	
	<?php require_once 'settings/footer_file.php';?>
</div>	
</body>
</html>  
