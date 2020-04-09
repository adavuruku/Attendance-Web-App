
<?php
session_start(); 
require_once '../settings/connection.php';
require_once '../settings/filter.php';

if(!isset($_SESSION['user_identity']) || !isset($_SESSION['faculty']))
{
	header("location: ../pull_out.php");
}

if($_SESSION['course_upload'] != "1" && $_SESSION['admin']!="1")
{
	header("location: ../pull_out.php");
}
$lecture =$level =$semester =$c_unit =$c_title=$c_code=$err="";
if(!isset($_GET['SctYj'])){

	if(!isset($_POST['submit'])){
		header("location: ../pull_out.php");
	}else{
		$c_code=$_POST['c_code'];
	}
}else{
	$c_code= strip_tags($_GET['SctYj']);
}

	

		///$c_code= strip_tags($_GET['SctYj']);
		$sql = "SELECT * FROM atbu_course where Course_Code=?";
		$stmt2 = $conn->prepare($sql);
		$stmt2->execute(array($c_code));
		if ($stmt2->rowCount () >= 1)
		{
			$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
			$lecture =$row2['staff_id'];
			$level =$row2['Level'];
			$semester =$row2['Semester'];$c_unit =$row2['course_unit'];
			$c_title=$row2['Course_Title'];
		}else{
				//header("location: ../Eit_Uploaded_Courses.php");
		}
	//retrieve the Course Details
	
	//proceeed
	if(($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['submit']))
	{
		$lecture =$_POST['lecture'];
		$level =$_POST['level'];
		$semester =$_POST['semester'];
		$c_unit =$_POST['c_unit'];
		$c_title=$_POST['c_title'];
		$c_code=$_POST['c_code'];
		
		//search if they are empty
		if($lecture !="" || $level !="" || $semester !="" || $c_unit !="" || $c_title !="" || $c_code !=""){
			
			//check if the record exist before
			$sql = "SELECT Course_Code FROM atbu_course where Course_Code=?";
			$stmt2 = $conn->prepare($sql);
			$stmt2->execute(array($c_code));
			if ($stmt2->rowCount () >= 1)
			{
				//update the record
				$stmt = $conn->prepare("UPDATE atbu_course SET Course_Code = ?,Course_Title = ?,School = ?,Department = ?,Level = ?,Semester = ?,course_unit = ?,staff_id = ? WHERE Course_Code=? Limit 1");
				$stmt->execute(array($c_code,$c_title,$_SESSION['faculty'],$_SESSION['department'],$level,$semester,$c_unit,$lecture,$c_code));
				$affected_rows = $stmt->rowCount();
				if($affected_rows==1){
					$err =  "<p style='color:blue'>Change Applied</p>";
					//$lecture =$level =$semester =$c_unit =$c_title=$c_code="";
				}
				else
				{
					$err =  "<p style='color:red'>Faill to Update";
				}
			}else{
				$err =  "<p style='color:blue'>Record Updated";
			}
		}else{
			$err = "<p style='color:red;' > Error: Some fields are Empty ! </p>";
		}
		//header('location: Display_Courses.php'.$link_1.$link_2.$link_3);
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
		<script type="text/javascript">
		
		function noNumbers(e, t) 
		{
			try {

				if (window.event) {
					var charCode = window.event.keyCode;}

				else if (e) {
					var charCode = e.which;
				}
				else { return true; }

				if (charCode > 31 && (charCode < 48 || charCode > 57)) {
					return false;
				}
				return true;
			}
			catch (err) {
				alert(err.Description);
			}   
		} 
		
		
		</script>
</head>
<body style="padding-top:2%;font-family:Tahoma, Times, serif;font-weight:bold;">


<div class="container" style="padding-top:5px;">
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
		
			
				<div  class="col-sm-12 col-md-12 col-lg-12">
					<div  class="col-lg-12" style="width:100%; padding-top:5px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:white">A T B U System</h3>
						<h5 style="text-align:center;color:yellow">Welcome	- <?php echo $_SESSION['full_name'];?> - <a style="color:white" href="../pull_out.php">Log Out</a> || <a style="color:white" href="Edit_Uploaded_Courses.php">Course List </a> || <a style="color:white" href="Staff_Home.php">My Home </a> </h5>
						
					</div>
					<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:15px;padding-right:15px; padding-bottom:5px; background-color:#D8D8D8 ;margin-bottom:1%">
						<h4 style="text-align:center;color:black"> Edit Uploaded Courses For - <?php echo $_SESSION['department'];?> Dapartment In Faculty <?php echo $_SESSION['faculty'];?> </h4>
						<hr>
						<form role="form"  name="reg_form"  id="form" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
								<input type="hidden" name="c_code" value="<?php echo $c_code;?>"></input>
								<div class="form-group">
									<label for="code" class="control-label col-xs-3">Course Code :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-5">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
													<input  type="text"  disabled="disabled" class="text_field form-control"  id="code" name="code" value="<?php echo $c_code; ?>" placeholder="Enter The Course Code"> </input>
											</div>
										</div>
								</div>
								<div class="form-group">
									<label for="c_title" class="control-label col-xs-3">Course Title :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-5">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
													<input  type="text"  class="text_field form-control"  id="c_title" name="c_title" value="<?php echo $c_title; ?>" placeholder="Enter The Course Title"> </input>
											</div>
										</div>
								</div>
								<div class="form-group">
									<label for="c_unit" class="control-label col-xs-3">Course Unit :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-5">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
													<input  type="text"  class="text_field form-control" onkeydown="return noNumbers(event,this)"  id="c_unit" name="c_unit" value="<?php echo $c_unit; ?>" placeholder="Enter The Course Unit"> </input>
											</div>
										</div>
								</div>
								
								<div class="form-group">
									<label for="semester" class="control-label col-xs-3">Semester :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
										
											<select class="form-control"  id="semester" value="<?php 
														if($semester =="1"){
														echo "First";
														}else{echo "Second";}
														?>" name="semester">
														
													<option value="1">First</option>
													<option value="2">Second</option>
													
											</select>
									
									</div>
								</div>
								
								<div class="form-group">
									<label for="level" class="control-label col-xs-3">Level: <span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
										
											<select class="form-control"  id="level" value="<?php echo $level; ?>" name="level">
													<option value="100">100</option>
													<option value="200">200</option>
													<option value="100">300</option>
													<option value="200">400</option>
													<option value="100">500</option>
													
											</select>
									
									</div>
								</div>
								
								<div class="form-group">
									<label for="dept" class="control-label col-xs-3">Lecture :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
										
											<select class="form-control"  id="lecture" value="<?php echo $lecture; ?>" name="lecture">
													<?php
														$sql = "SELECT * FROM atbu_staff where staff_dept=? AND staff_faculty=?";
														$stmt2 = $conn->prepare($sql);
														$stmt2->execute(array($_SESSION['department'],$_SESSION['faculty']));
														if ($stmt2->rowCount () >= 1)
														{
															while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) 
															{
																echo '<option value='.$row2['staff_id'].'>'.$row2['staff_name'].'</option>';
															}
														}
													?>
											</select>
									
									</div>
								</div>
								<div class="form-group">
									
									<label for="" class="control-label col-xs-6"><?php echo $err;?></label>
									<div class="col-xs-4">
										<div class="input-group">
												<input  type="Submit"  class="submit_btn btn btn-success"  style="width:100%;" value="<< Update Records >>" name="submit"  ></input>
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
</body>
</html>  
