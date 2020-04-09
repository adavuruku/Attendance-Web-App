<?php
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$error=$P=$R =$txtPassword=$txtUsername="";
 $_SESSION['user_photo'] ='<img src="store_files/Customer_Pics/defaultpasport.jpg" style="height:150px;width:150px;border:4px solid black;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
	
	$txtPassword =strip_tags($_POST['txtPassword']);
	$txtUsername = strip_tags($_POST['txtUsername']);
	
	$stmt = $conn->prepare("SELECT * FROM atbu_student where  student_password=? AND student_regno=?  Limit 1");
	$stmt->execute(array($txtPassword,$txtUsername));
	$affected_rows = $stmt->rowCount();
	if($affected_rows == 1) 
	{
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		/*if ($row['u_photo']  !=""){
			$_SESSION['user_photo'] ='<img src="store_files/Customer_Pics/'.$row['u_photo'].'" style="height:150px;width:150px;border:4px solid white;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
		}*/
		
		$_SESSION['full_name'] = $row['student_name'];
		$_SESSION['user_identity'] = $row['student_regno'];
		
		$_SESSION['faculty'] = $row['student_facult'];
		$_SESSION['department'] = $row['student_dept'];
		$_SESSION['level'] = $row['student_level'];
		header("location: student_index.php");
	}
	else
	{
		$error = "<p style='color:white'>Unable To Login, Password or User_Name Incorrect</p>";
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Home | Abubakar Tafawa University Bauchi</title>
<link rel="shortcut icon" href="store_files/images/image_demo.jpg">
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
<body style="padding-top:5%;font-family:Tahoma, Times, serif;font-weight:bold;">

<div class="navbar navbar-inverse navbar-fixed-top" style="background-color:green" role="navigation" >
            <div class="navbar-header" style="background-color:grey">
                <div class="container-fluid">
				<a class="navbar-brand" style="font-size:20px;font-weight:bold;color:white" href="#">ATBU Attendance Sysytem </a>
					
                </div>
			</div>
			<ul class="nav navbar-nav navbar-right" style="background-color:green">
					<li><a class="navbar-brand" style="font-size:20px;font-weight:bold;color:white" href="index.php">Go to Home Page</a></li>
			</ul>
    </div>

 <div class="nav-overflow"></div>



<div class="container">
	
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
				<form role="form" name="Login_form"  id="frm0" class="form-horizontal"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
			
			<div  class="col-sm-1 col-md-1 col-lg-1" style="padding-left:20px;" >
			</div>
					
			<div  class="col-sm-10 col-md-10 col-lg-10">
			<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
							<h3 style="text-align:center;padding-top:5px; padding-bottom:25px;color:yellow" >Student Login Platform</h3>	
				</div>
				<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:10px; padding-bottom:10px; background-color:white;margin-bottom:1%">
										
								<div class="form-group">
														<label for="txtUsername" class="control-label col-xs-5">Reg N<u>o</u> :<span style="color:red" class"require">*</span></label>
														<div class="col-xs-7">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
																<input type="text" class="form-control"  id="txtUsername" name="txtUsername" value="<?php echo $txtUsername; ?>" placeholder="Enter Your Registration Number">
															</div>
														</div>
								</div>
				<div class="form-group">
														<label for="txtPassword" class="control-label col-xs-5">Password :<span style="color:red"class"require">*</span></label>
														<div class="col-xs-7">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
																<input type="password" class="form-control" id="txtPassword" name="txtPassword" value="" placeholder="Enter Your Password">
															</div>
														</div>
								</div>
				
				<div class="form-group">
														<label for="txtPassword" class="control-label col-xs-5"></label>
														<div class="col-xs-7">
															<a href="Retrieve_Login_Details.php">Forget Password </a> 
														</div>
								</div>
				
				
				</div>	
							
				<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
								<div  class="col-lg-5" style="align:left;">
									<?php echo $error; ?>
								</div>
								<div  class="col-lg-7" >
											<button  type="submit"  name="submit" class="btn btn-success">Login &gt&gt&gt</button>
											<button  type="reset" name="previous"  class="btn btn-success">Clear / Reset</button>
								</div>
							</form>
				</div>
					
			</div>			
			<div  class="col-sm-1 col-md-1 col-lg-1"></div>
						
						<div class="clearfix visible-sm-block"></div>
						<div class="clearfix visible-md-block"></div>
						<div class="clearfix visible-lg-block"></div>
					
		
		</div>
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
		
		<?php require_once 'settings/footer_file.php';?>
</div>	
</body>
</html>  
