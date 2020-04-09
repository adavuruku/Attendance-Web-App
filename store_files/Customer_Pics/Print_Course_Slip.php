
<?php
session_start(); 
require_once '../settings/connection.php';
require_once '../settings/filter.php';

if(!isset($_SESSION['user_identity']) || !isset($_SESSION['faculty']))
{
	header("location: ../pull_out.php");
}



	$year =$semester=$search_dept=$dept=$course_title=$err="";
	$sql = "SELECT * FROM course_data where edit_status=? ORDER BY Id DESC Limit 1";
	$stmt = $conn->prepare($sql);
	$stmt->execute(array("False"));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if (!$stmt->rowCount () >= 1)
	{
		header("location: Staff_Home.php");
	}else{
		$year =$row['year'];$semester=$row['semester'];
		$_SESSION['all_table']=$row['year']."_".$row['semester'];
	}
	
	//proceeed
	if(($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['submit']))
	{
		$link_1= "?couCode=".$_POST['course_title'];
		$link_2= "&couTitle=".$_SESSION['course_title'];
		$link_3= "&coudept=".$_POST['dept'];
		$link_4 = "&unit=".$_SESSION['course_unit'];
		header('location: ../store_files/Print_All_Course_Result.php'.$link_1.$link_2.$link_3.$link_4);
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
		
		<title>A T B U Staff | Home </title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" href="Server_Pictures_Print/images/image_demo.jpg">
		<link rel="stylesheet" type="text/css" href="../settings/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../settings/css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="../settings/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../settings/css/bootstrap-theme.css" >
		<script type="text/javascript" src="../settings/js/bootstrap.js"></script>
		<script type="text/javascript" src="../settings/js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../settings/js/jquery-2.1.1.js"></script>
		<script type="text/javascript" src="../settings/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../settings/js/bootstrap.min.js"></script>
		<script type="text/javascript"  src="my_result_submit.js"></script>
</head>
<body style="padding-top:2%;font-family:Tahoma, Times, serif;font-weight:bold;">


<div class="container" style="padding-top:5px;">
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
		
			<div  class="col-sm-2 col-md-2 col-lg-1"  >
				<!-- display user details like passport ..name.. ID ..Class type -->
			</div>
				<div  class="col-sm-8 col-md-8 col-lg-10">
					<div  class="col-lg-12" style="width:100%; padding-top:5px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:white">A T B U System</h3>
						<h5 style="text-align:center;color:yellow">Welcome	- <?php echo $_SESSION['full_name'];?> - <a style="color:white" href="../pull_out.php">Log Out</a> || <a style="color:white" href="Staff_Home.php">My Home </a> </h5>
						
					</div>
					<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:15px;padding-right:15px; padding-bottom:5px; background-color:#D8D8D8 ;margin-bottom:1%">
						<h4 style="text-align:center;color:black"> Select the Title Of Course And The Department To Print  </h4>
						<hr>
						<form role="form"  name="reg_form"  id="form" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
								<div class="form-group">
									<label for="course" class="control-label col-xs-3">Courses :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
										
											<select class="form-control"  id="course_title" onchange="load_department()" value="<?php echo $course_title; ?>" name="course_title">
													<?php
														$first=1;
														$sql = "SELECT staff_id,Course_Code,Semester,Course_Title,course_unit FROM atbu_course where staff_id=? AND Semester=?";
														$stmt = $conn->prepare($sql);
														$stmt->execute(array($_SESSION['user_identity'],$semester));
														if ($stmt->rowCount () >= 1)
														{
															while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
															{
																if ($first=="1")
																{
																	$search_dept = $row['Course_Code'];
																	$_SESSION['course_title']=$row['Course_Title'];
																	$_SESSION['course_unit']  =$row['course_unit'];
																}
																echo '<option value='.$row['Course_Code'].'>'.$row['Course_Title'].'</option>';
																$first=$first+1;
															}
														}
													?>
											</select>
									
									</div>
								</div>
								<div class="form-group">
									<label for="status" class="control-label col-xs-3"></label>
									<div class="col-xs-5" id="status">
									<!-- loading image display -->
									</div>
								</div>
								
								<div class="form-group">
									<label for="dept" class="control-label col-xs-3">Departments :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
										
											<select class="form-control"  id="dept" value="<?php echo $dept; ?>" name="dept">
													<?php
														$sql = "SELECT DISTINCT(Department),subject_code FROM ".$_SESSION['all_table']." where subject_code=?";
														$stmt2 = $conn->prepare($sql);
														$stmt2->execute(array($search_dept));
														if ($stmt2->rowCount () >= 1)
														{
															
															while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) 
															{
																echo '<option value='.$row2['Department'].'>'.$row2['Department'].'</option>';
															}
														}
													?>
											</select>
									
									</div>
								</div>
								<div class="form-group">
									<label for="" class="control-label col-xs-3"></label>
									<label for="" class="control-label col-xs-3"><?php echo $err;?></label>
									<div class="col-xs-2">
										<div class="input-group">
												<input  type="Submit"  class="submit_btn btn btn-success"  style="width:100%;" value=" Proceed >>" name="submit"  ></input>
										</div>
									</div>									
								</div>
						
						</form>
						
					</div>
					
					<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						
					</div>
				</div>		
				
				<div  class="col-sm-1 col-md-1 col-lg-1"></div>
				
				<div class="clearfix visible-sm-block"></div>
				<div class="clearfix visible-md-block"></div>
				<div class="clearfix visible-lg-block"></div>
		</div>
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
	
		<div class="row">
			<div class="col-xs-2 col-sm-2"></div>	
				<div class="col-xs-8 col-sm-8" >
					<footer>
						<p style="text-align:center">Copyright &copy; 2015 - All Rights Reserved - Software Development Unit, P C N L.</p>
					</footer>
				</div>
			<div class="col-xs-2 col-sm-2"></div>	
		</div>	
</div>	
</body>
</html>  
