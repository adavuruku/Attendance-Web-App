
<?php
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';

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
<body id="container" style="padding-top:2%;font-family:Tahoma, Times, serif;font-weight:bold;">

<div class="container" style="padding-top:20px;">
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
		
			
				<div  class="col-sm-12 col-md-12 col-lg-12">
					<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:yellow">ATBU System Home Platform</h3>
					</div>
					<div  id="Question_Container" class="table-responsive" class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:#CCFFFF;margin-bottom:1%">
						
						<div  class="col-sm-4 col-md-4 col-lg-4">
							<?php require_once 'settings/menu.php';?>
						</div>
						<div  class="col-sm-6 col-md-6 col-lg-6" style="margin-top:37px;background-color:white;padding:3px;">
							 <table class="table table-condensed" border="0%" style="padding:15%;">
								<?php
							$stud_info="";
							$stmt = $conn->prepare("SELECT * FROM atbu_student where  student_dept=? AND student_regno=?  Limit 1");
							$stmt->execute(array($_SESSION['department'],$_SESSION['user_identity']));
							$affected_rows = $stmt->rowCount();
							if($affected_rows == 1) 
							{
								$row = $stmt->fetch(PDO::FETCH_ASSOC);
								echo '<tr>
												<td colspan="3" align="center">STUDENT INFORMATION</td>
											</tr>
											<tr>
												<td>Name :</td>
												<td width="15px"></td>
												<td>'.$row['student_name'].'</td>
											</tr>
											<tr>
												<td colspan="3"></td>
											</tr>
											<tr>
												<td>Registration No :</td>
												<td width="15px"></td>
												<td>'.$row['student_regno'].'</td>
											</tr>
											<tr>
												<td colspan="3"></td>
											</tr>
											<tr>
												<td>Faculty :</td>
												<td width="15px"></td>
												<td>'.$row['student_facult'].'</td>
											</tr>
											<tr>
												<td colspan="3"></td>
											</tr>
											<tr>
												<td>Department :</td>
												<td width="15px"></td>
												<td>'.$row['student_dept'].'</td>
											</tr>
											<tr>
												<td colspan="3"></td>
											</tr>
											<tr>
												<td>Level :</td>
												<td width="15px"></td>
												<td>'.$row['student_level'].'</td>
											</tr>
											<tr>
												<td colspan="3"></td>
											</tr>';	
							}
							
							?>
							</table>
						</div>
					</div>
					
					<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						
					</div>
				</div>
		</div>
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
	
		<?php require_once 'settings/footer_file.php';?>
</div>	
</body>
</html>  
