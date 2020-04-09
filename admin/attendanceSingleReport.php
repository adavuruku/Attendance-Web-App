
<?php
session_start(); 
require_once '../settings/connection.php';
require_once '../settings/filter.php';
$year =$semester=$search_dept=$dept=$course_title=$err="";
if(!isset($_SESSION['user_identity']) || !isset($_SESSION['faculty']))
{
	header("location: ../pull_out.php");
}
$ocd = "Now";
//proceeed
if(($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['submit']))
{
	if ($_POST['level']<> "select Courses" && trim($_POST['ocd']) <> ""){
		
		$link_1= "?level=".$_POST['level']."&sdate=".trim($_POST['ocd'])."&page=1";
		header('location: ../store_files/print_courses_attendSingle.php'.$link_1);
	}else{
		$err="Error: Select Course To Print Report!!";
	}
	
}
$date500 = new DateTime($ocd);
$ocd = date_format($date500,"m/d/Y");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
		
		<title>A T B U Staff | Home </title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
		
		<link rel="stylesheet" type="text/css" href="../settings/css/bootstrap-datepicker.css" />
		<link rel="stylesheet" type="text/css" href="../settings/css/bootstrap-datepicker3.min.css" />
		<script type="text/javascript" src="../settings/js/bootstrap-datepicker.js"></script>
</head>
<body style="padding-top:2%;font-family:Tahoma, Times, serif;font-weight:bold;">


<div class="container" style="padding-top:5px;">
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
		
			
				<div  class="col-sm-12 col-md-12 col-lg-12">
					<div  class="col-lg-12" style="width:100%; padding-top:5px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:white">A T B U System</h3>
						<h5 style="text-align:center;color:yellow">Welcome	- <?php echo $_SESSION['full_name'];?> - <a style="color:white" href="../pull_out.php">Log Out</a> || <a style="color:white" href="Staff_Home.php">My Home </a> </h5>
						
					</div>
					<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:15px;padding-right:15px; padding-bottom:5px; background-color:#D8D8D8 ;margin-bottom:1%">
						<h4 style="text-align:center;color:black">  Select the Title Of Course To Upload And The Department To Upload  </h4>
						<hr>
						<form role="form"  name="reg_form"  id="form" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
						
						
								<div class="form-group">
									<label for="level" class="control-label col-xs-5">Courses :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-4">
										
											<select class="form-control"  id="level"  name="level">
											<option value="select Courses">select Courses</option>
												
												<?php
													if($_SESSION['admin'] == 1){
														$stmt2 = $conn->prepare("SELECT * FROM atbu_course order by Course_Title asc");
														$stmt2->execute();
														if ($stmt2->rowCount() >= 1)
														{
															while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) 
															{
																echo '<option value='.$row2['Course_Code'].'>'.$row2['Course_Title'].'</option>';
															}
														}
													}else{
														$stmt2 = $conn->prepare("SELECT * FROM atbu_course where staff_id =? order by Course_Title asc");
														$stmt2->execute(array($_SESSION['user_identity']));
														if ($stmt2->rowCount() >= 1)
														{
															while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) 
															{
																echo '<option value='.$row2['Course_Code'].'>'.$row2['Course_Title'].'</option>';
															}
														}
													}
													
												?>
											</select>
									
									</div>
								</div>
								<div class="form-group">
									<label for="ocd" class="control-label col-xs-5">Date <span style="color:red">*</span> : </label>
									<div class="col-xs-4">
										<div class="input-group date" data-provide="datepicker">
												
												<input type="text" class="form-control"  id="ocd" name="ocd" value="<?php echo $ocd;?>" required="true" />
												<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="status" class="control-label col-xs-3"></label>
									<div class="col-xs-5" id="status">
									<!-- loading image display -->
									</div>
								</div>
								
								
								<div class="form-group">
									
									<label for="" class="control-label col-xs-7" style="color:red"><?php echo $err;?></label>
									<div class="col-xs-4">
										<div class="input-group">
												<input  type="Submit"  class="submit_btn btn btn-success"  style="width:100%;" value=" Print Report >>" name="submit"  ></input>
										</div>
									</div>									
								</div>
						
						</form>
						
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
  <script type="text/javascript">
	$(document).ready(function() {
		$('.js-example-basic-single').select2();
	});
</script>
</body>
</html>  
