
<?php
session_start(); 
require_once '../settings/connection.php';
require_once '../settings/filter.php';

if(!isset($_SESSION['course_upload']) && !isset($_SESSION['admin']))
{
	header("location: ../pull_out.php");
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
		

				<div  class="col-sm-12 col-md-12 col-lg-12">
					<div  class="col-lg-12" style="width:100%; padding-top:5px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:white">A T B U System</h3>
						<h5 style="text-align:center;color:yellow">Welcome	- <?php echo $_SESSION['full_name'];?> - <a style="color:white" href="Staff_Home.php">My Home </a> || <a style="color:white" href="../pull_out.php">Log Out</a> </h5>
						<h4 style="text-align:left;color:yellow"> List Of All Courses Uploaded On ATBU Server</h4>
					</div>
					<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:15px;padding-right:15px; padding-bottom:5px; margin-bottom:1%">
						
							<table class="table table-condensed">
						<thead style="color:blue;text-weight:bold">
							<tr>
								<th>SN<u>o</u></th>
								<th>Course Code</th>
								<th>Course Title</th>
								<th>Level</th>
								<th>Semester</th>
								<th>Unit</th>
								<th>Lecturer</th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</thead>

						<tbody>
							<?php
							$sql = "SELECT count(*) As totCount FROM atbu_course";
							$stmt2 = $conn->prepare($sql);
							$stmt2->execute();
							if ($stmt2->rowCount () >= 1)
							{
								$rowsy = $stmt2->fetch(PDO::FETCH_ASSOC);
									
								$current_page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
								
									//record per Page($per_page)	
									$per_page = 4;
									$total_count = $rowsy['totCount'];
									$total_pages = $total_count/$per_page;
									$offset = ($current_page - 1) * $per_page;
									$previous_page = $current_page - 1;
									$next_page = $current_page + 1;
									$has_previous_page =  $previous_page >= 1 ? true : false;
									$has_next_page = $next_page <= $total_pages ? true : false;
															
									$sql = "SELECT * FROM atbu_course LIMIT ? OFFSET ?";
									$stmt2 = $conn->prepare($sql);
									$stmt2->execute(array($per_page, $offset));
									if ($stmt2->rowCount () >= 1)
									{
										$j = $current_page;
										if($j !=1)
										{
											$j = $offset + 1;
										}
										while ($row =$stmt2->fetch(PDO::FETCH_ASSOC)) 
										{
												if($row['Semester']=="1"){
													$GRADESE = "First";
												}else{
													$GRADESE = "Second";
												}
												$staff_name ="";
												$Add_Id=$row['staff_id'];
												$stmt = $conn->prepare("SELECT  staff_name, staff_id FROM atbu_staff where staff_id=?");
												$stmt->execute(array($Add_Id));
												if ($stmt->rowCount () >= 1)
												{
													$rows = $stmt->fetch(PDO::FETCH_ASSOC);
													$staff_name = $rows['staff_name'];
												}
												
											echo '<tr>';
											echo '<td>' . $j. '</td>';
											echo '<td>' . $row['Course_Code']. '</td>';
											echo '<td>' . $row['Course_Title']. '</td>';
											echo '<td>' . $row['Level']. '</td>';
											echo '<td>' . $GRADESE. '</td>';
											echo '<td>' . $row['course_unit']. '</td>';
											echo '<td>' . $staff_name. '</td>';
											
											echo '<td><a style="color:blue" data-toggle="tooltip" data-placement="bottom"    href="Edit_Uploaded_Courses_Details.php?SctYj='.$row['Course_Code'].'"  title="Click To Edit Records" >-Edit-</a></td>';
											echo '<td><a href="#" title="Delete_Course" style="color:yellow" onclick="delete_Course(\''.$row['Course_Code'].'\',\''.$row['Course_Title'].'\')"><img src="../store_files/images/delete-icon.jpg" style="height:20px" ></img></a></td>';
											echo '<td id='.$row['Course_Code'].'></td>';
											$j = $j + 1;
										}

										echo '</tr>';
										echo '</tbody>';
										echo '</table>';
										
										echo '<ul class="pagination" align="center">';
														
										if ($total_pages > 1)
										{
											//this is for previous record
											if ($has_previous_page)
											{
											echo ' <li><a href=Edit_Uploaded_Courses.php?page='.$previous_page.'>&laquo; </a> </li>';
											}
											 //it loops to all pages
											 for($i = 1; $i <= $total_pages; $i++)
											 {
												//check if the value of i is set to current page	
												if ($i == $current_page)
												{
												//then it sset the i to be active or focused
													echo '<li class="active"><span>'. $i.' <span class="sr-only">(current)</span></span></li>';
												 }
												 else
												 {
												 //display the page number
													echo ' <li><a href=Edit_Uploaded_Courses.php?page='.$i.'> '. $i .' </a></li>';
												 }
											 }
											//this is for next record		
											if ($has_next_page)
											{
												echo ' <li><a href=Edit_Uploaded_Courses.php?page='.$next_page.'>&raquo;</a></li> ';
											}
											
										}
										
										echo '</ul>';
									}//ooo
									
							}//here last
							
							
							?>
				</tbody>
			</table>
						
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
