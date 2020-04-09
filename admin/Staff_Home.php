
<?php
session_start(); 
require_once '../settings/connection.php';
require_once '../settings/filter.php';

if(!isset($_SESSION['full_name']) AND !isset($_SESSION['staff_registration']))
{
	header("location: ../pull_out.php");
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>A T B U Staff | Home </title>
<link rel="shortcut icon" href="../store_files/images/image_demo.jpg">
<link rel="stylesheet" type="text/css" href="../settings/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../settings/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="../settings/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../settings/css/bootstrap-theme.css" >
<script type="text/javascript" src="../settings/js/bootstrap.js"></script>
<script type="text/javascript" src="../settings/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="../settings/js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="../settings/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../settings/js/bootstrap.min.js"></script>

</head>
<body style="padding-top:2%;font-family:Tahoma, Times, serif;font-weight:bold;">


<div class="container" style="padding-top:5px;">
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
		
			
				<div  class="col-sm-12 col-md-12 col-lg-12">
					<div  class="col-lg-12" style="width:100%; padding-top:5px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:white">A T B U System</h3>
						<h5 style="text-align:center;color:yellow">Welcome	- <?php echo $_SESSION['full_name'];?> - <a style="color:white" href="../pull_out.php">Log Out</a></h5>
					</div>
					<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:0px; padding-bottom:5px; background-color:CadetBlue;margin-bottom:1%">
						<div  class="col-sm-6 col-md-6 col-lg-6">
						<div class="nav-head" style="color:yellow"><h4>Manage Courses / Staff / Students</h4></div>
							<div class="list-group show" style="margin-bottom:80px">
								<?php 
									
									if($_SESSION['admin'] =="1"){
										echo'<a href="#" class="list-group-item"> </a>
										<a href="Register_New_Staff.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Upload Staff Details </a>
										<a href="#" class="list-group-item"> </a>
										<a href="Upload_New_Courses.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Upload Courses </a>
										<a href="#" class="list-group-item"> </a>
										<a href="Edit_Uploaded_Courses.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Edit / View / Delete Uploaded Courses </a>';
									}
								?>
								<a href="#" class="list-group-item"> </a>
								<a href="Upload_New_Students.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Upload Student Details </a>
								<a href="#" class="list-group-item"> </a>
							</div>
						</div>
						<div  class="col-sm-6 col-md-6 col-lg-6">
							<div class="nav-head" style="color:yellow"><h4>Download / Print Reports</h4></div>
							<div class="list-group show" style="margin-bottom:80px">
								<?php 
									
									if($_SESSION['admin'] =="1"){
										echo '<a href="#" class="list-group-item"> </a>
										<a href="../store_files/Download_List_Of_Staff.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Download Staff Details </a>
										<a href="#" class="list-group-item"> </a>
										<a href="../store_files/Print_Uploaded_Courses.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Download Courses List </a>
										<a href="#" class="list-group-item"> </a>
										<a href="attendanceReport.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Download Attendance Report </a>
										<a href="#" class="list-group-item"> </a>
										<a href="attendanceSingleReport.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Download Single Day Attendance Report </a>
										<a href="#" class="list-group-item"> </a>';
									}else{
										if($_SESSION['staff_registration'] =="1"){
										echo '<a href="attendanceReport.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Download Attendance Report </a>
										<a href="#" class="list-group-item"> </a>
										<a href="attendanceSingleReport.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Download Single Day Attendance Report </a>
										<a href="#" class="list-group-item"> </a>';
										}
									}
								?>
							</div>
						</div>
						
					</div>
					
					<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						
					</div>
				</div>
				
				<div class="clearfix visible-sm-block"></div>
				<div class="clearfix visible-md-block"></div>
				<div class="clearfix visible-lg-block"></div>
		</div>
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
	
		<?php require_once '../settings/footer_file.php';?>
</div>	
</body>
</html>  
