
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



	$year =$semester=$err="";
	
	//retrieve the Course Details
	 
	 if(($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['approved']))
	{
			//check the existence of the selection
			$year =$_POST['year'];
			$semester =$_POST['semester'];
			$status="0";
			$sql = "SELECT *  FROM course_data where year=? AND semester=?";
			$stmt2 = $conn->prepare($sql);
			$stmt2->execute(array($year,$semester));
			if ($stmt2->rowCount () >= 1)
			{
				$row = $stmt2->fetch(PDO::FETCH_ASSOC);
				$my_table = $row['year']."_".$row['semester'];
				//select the students reg no
				$sql3 = "SELECT DISTINCT(reg_no)  FROM ".$my_table;
				$stmt3 = $conn->prepare($sql3);
				$stmt3->execute();
				if ($stmt3->rowCount () >= 1)
				{
					while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) 
					{
						//sum the GP'S
						$sql4 = "SELECT SUM(course_gp) AS course_gpno,SUM(student_gpn) AS student_gpno, reg_no FROM ".$my_table." where reg_no=?";
						$stmt4 = $conn->prepare($sql4);
						$stmt4->execute(array($row3['reg_no']));
						if ($stmt4->rowCount () >= 1)
						{
							while($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) 
							{
								$reg_no = $row4['reg_no'];
								$course_gpno = $row4['course_gpno'];
								$student_gpno =$row4['student_gpno'];
								
								//make sure record is in course_cgp
								$sql5 = "SELECT * FROM course_cgp where (reg_no=? AND year=?) AND semester=?";
								$stmt5 = $conn->prepare($sql5);
								$stmt5->execute(array($reg_no,$year,$semester));
								if ($stmt5->rowCount () >= 1){
									$stmt = $conn->prepare("Update course_cgp set STP =?,CTU =? WHERE (reg_no =? AND year=?) AND semester=? Limit 1");
									$stmt->execute(array($student_gpno,$course_gpno,$reg_no,$year,$semester));
									$affected_rows = $stmt->rowCount();
		
								}else{
									//insert it
									$sth = $conn->prepare ("INSERT INTO course_cgp (STP,CTU,reg_no,year,semester)
															VALUES (?,?,?,?,?)");															
									$sth->bindValue (1, $student_gpno); 
									$sth->bindValue (2, $course_gpno); 
									$sth->bindValue (3, $reg_no);
									$sth->bindValue (4, $year); 
									$sth->bindValue (5, $semester);
									$sth->execute();
								}
							}
							
						}
					}
					$status="1";
					$stmt = $conn->prepare("Update course_data set edit_status =? WHERE (semester =? AND year=?) Limit 1");
					$stmt->execute(array($status,$semester,$year));
					$affected_rows = $stmt->rowCount();
					if($affected_rows==1){
						$err =  "<p style='color:blue'>Change Applied</p>";
					}
					else
					{
						$err =  "<p style='color:red'>Faill to Update</p>";
					}
			
		}else{
			$err =  "<p style='color:red'>Error : No Such Session</p>";
		}
	}
}
	
	
	//proceeed
	if(($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['disapproved']))
	{
		
		$year =$_POST['year'];
		$semester =$_POST['semester'];
		$status="0";
		$stmt = $conn->prepare("Update course_data set edit_status =? WHERE (semester =? AND year=?) Limit 1");
		$stmt->execute(array($status,$semester,$year));
		$affected_rows = $stmt->rowCount();
		if($affected_rows==1){
			$err =  "<p style='color:blue'>Change Applied</p>";
		}
		else
		{
			$err =  "<p style='color:red'>Faill to ff</p>";
		}
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
						<h4 style="text-align:center;color:black"> Approve The SESSION Result </h4>
						<hr>
						<form role="form"  name="reg_form"  id="form" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
							<div class="form-group">
									<label for="dept" class="control-label col-xs-3">Session :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
										
											<select class="form-control"  id="year" value="<?php echo $year; ?>" name="year">
													<?php
														$sql = "SELECT Distinct(year) FROM course_data order by id DESC";
														$stmt2 = $conn->prepare($sql);
														$stmt2->execute();
														if ($stmt2->rowCount () >= 1)
														{
															while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) 
															{
																echo '<option value='.$row2['year'].'>'.$row2['year'].'</option>';
															}
														}
													?>
											</select>
									
									</div>
								</div>
								
								<div class="form-group">
									<label for="semester" class="control-label col-xs-3">Semester :<span style="color:red;padding:0px"class"require">*</span></label>
									<div class="col-xs-5">
										
											<select class="form-control"  id="semester" value="<?php echo $semester; ?>" name="semester">
													<option value="1">First</option>
													<option value="2">Second</option>
													
											</select>
									
									</div>
								</div>
								<div class="form-group">
									
									<label for="" class="control-label col-xs-3"><?php echo $err;?></label>
									<div class="col-xs-3">
										<div class="input-group">
												<input  type="Submit"  class="submit_btn btn btn-success"  style="width:100%;" value="<< Approved >>" name="approved"  ></input>
										</div>
									</div>		
									
									<div class="col-xs-3">
										<div class="input-group">
												<input  type="Submit"  class="submit_btn btn btn-success"  style="width:100%;" value="<< Disapproved >>" name="disapproved"  ></input>
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
