
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
	$lecture =$level =$semester =$c_unit =$c_title=$c_code=$txtfaculty =$txtdept=$err="";
	
	//retrieve the Course Details
	
	//proceeed
	if(($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['submit']))
	{
		$txtfaculty =$_POST['txtfaculty'];
		$txtdept =$_POST['txtdept'];
		$c_title=$_POST['c_title'];
		$c_code=$_POST['c_code'];
		
		//search if they are empty
		if($txtdept !="" || $txtfaculty !="" || $c_title !="" || $c_code !=""){
			
			$sql = "SELECT staff_id FROM atbu_staff where staff_id=?";
			$stmt2 = $conn->prepare($sql);
			$stmt2->execute(array($c_title));
			if ($stmt2->rowCount () >= 1)
			{
				//update the record
		
				$stmt = $conn->prepare("UPDATE atbu_staff SET staff_id = ?,staff_name = ?,staff_dept = ?,staff_faculty = ?,staff_password = ?,admin = ?,course_upload = ?,staff_registration = ? WHERE staff_id=? Limit 1");
				$stmt->execute(array($c_title,$c_code,$txtdept,$txtfaculty,$c_title,"0","1","1",$c_title));
				$affected_rows = $stmt->rowCount();
				if($affected_rows==1){
					$err =  "<p style='color:blue'>Change Applied</p>";
					$s_name =$s_id="";
				}
				else
				{
					$err =  "<p style='color:red'>Faill to Update</p>";
				}
			}else{
				//insert it as new Records
				$status ="0";
					$type ="Ebook";
					//insert record to Database
					$sth = $conn->prepare ("INSERT INTO atbu_staff (staff_id,staff_name,staff_dept,staff_faculty,staff_password,admin,course_upload,staff_registration)
														VALUES (?,?,?,?,?,?,?,?)");															
					$sth->bindValue (1, $c_title); 
					$sth->bindValue (2, $c_code); 
					
					$sth->bindValue (3, $txtdept);
					$sth->bindValue (4, $txtfaculty);					
					$sth->bindValue (5, $c_title); 
					$sth->bindValue (6, "0");
					$sth->bindValue (7, "1");
					$sth->bindValue (8, "1");
					if($sth->execute()){
						$err = '<p style="color:blue"> Record Saved - Successfully</p>';
						$s_name =$s_id="";
					}
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
		<script type="text/javascript" src="../settings/edit_goods.js"></script>
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
						<h5 style="text-align:center;color:yellow">Welcome	- <?php echo $_SESSION['full_name'];?> - <a style="color:white" href="../pull_out.php">Log Out</a> || <a style="color:white" href="Staff_Home.php">My Home </a> </h5>
						
					</div>
					<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:15px;padding-right:15px; padding-bottom:5px; background-color:#D8D8D8 ;margin-bottom:1%">
						<h4 style="text-align:center;color:black"> Register / Upload New Staff Details </h4>
						<hr>
						<form role="form"  name="reg_form"  id="form" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
								
								<div class="form-group">
									<label for="c_code" class="control-label col-xs-3">Full Name :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-5">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
													<input  type="text"  class="text_field form-control"  id="c_code" name="c_code" value="<?php echo $c_code; ?>" placeholder="First Name Middle Name Last Name"> </input>
											</div>
										</div>
								</div>
								<div class="form-group">
									<label for="c_title" class="control-label col-xs-3">Staff ID N<u>o</u> :<span style="color:red" class"require">*</span></label>
										<div class="col-xs-5">
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
													<input  type="text"  class="text_field form-control"  id="c_title" name="c_title" value="<?php echo $c_title; ?>" placeholder="Enter Registration No."> </input>
											</div>
										</div>
								</div>
								
								
								<div class="form-group">
									<label for="semester" class="control-label col-xs-3">Faculty :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
										
											<select class="form-control" name="txtfaculty" id="faculty" onchange="schoolComboChange();">    
												<option value="<?php echo $txtfaculty; ?>" ><?php echo $txtfaculty; ?></option>
												<option value="Agriculture">Agriculture</option>
												<option value="Bussiness Studies">Bussiness Studies</option>
												<option value="Engineering">Engineering</option>
												<option value="Environmental Studies">Environmental Studies</option>
												<option value="Science">Science</option>
											</select>
									
									</div>
								</div>
								<div class="form-group">
									<label for="semester" class="control-label col-xs-3">Department :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
										<select class="form-control" id="department" name="txtdept">
											<option value="<?php echo $txtdept; ?>" ><?php echo $txtdept; ?></option>
										</select>
									</div>
								</div>
								<div class="form-group">
									
									<label for="" class="control-label col-xs-6"><?php echo $err;?></label>
									<div class="col-xs-4">
										<div class="input-group">
												<input  type="Submit"  class="submit_btn btn btn-success"  style="width:100%;" value="<< Save Records >>" name="submit"  ></input>
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
