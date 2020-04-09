
<?php
session_start(); 
require_once '../settings/connection.php';
require_once '../settings/filter.php';

if(!isset($_GET['level'])){
header("location: ../pull_out.php");
}
$_level = strip_tags($_GET['level']);
$link_1= "&level=".$_level;
if(!isset($_SESSION['user_identity']) || !isset($_SESSION['faculty']))
{
	header("location: ../pull_out.php");
}

if($_SESSION['course_upload'] != "1" && $_SESSION['admin']!="1")
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
		<style>
			.list{ /*CSS for enlarged image*/
			visibility:collapse;
			//visibility:visible;
			//display:inline;
			}

			tr.listed:hover table > .list{ /*CSS for enlarged image on hover*/
			visibility: visible;
			}
		</style>
</head>
<body style="padding-top:2%;font-family:Tahoma, Times, serif;font-weight:bold;">


<div class="container" style="padding-top:5px;">
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
		

				<div  class="col-sm-12 col-md-12 col-lg-12">
					<div  class="col-lg-12" style="width:100%; padding-top:5px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:white">A T B U System</h3>
						<h5 style="text-align:center;color:yellow">Welcome	- <?php echo $_SESSION['full_name'];?> - <a style="color:white" href="Staff_Home.php">My Home </a> || <a style="color:white" href="Upload_Course_Result_Step_1.php">Go Step 1</a> || <a style="color:white" href="../pull_out.php">Log Out</a> </h5>
											</div>
					<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:15px;padding-right:15px; padding-bottom:5px; background-color:#D8D8D8 ;margin-bottom:1%">
						
							<?php
											//create a mySQL conn_twoection
											$dbhost    = 'localhost';
											$dbuser    = 'root';
											$dbpass    = '';
											$conn_two = mysql_connect($dbhost, $dbuser, $dbpass);
											if (!$conn_two) {
												die('Could not conn_twoect: ' . mysql_error());
											}
											mysql_select_db('atbu_server');
											/* Get total number of records */
											$sql    = "SELECT count(*) FROM ".$_SESSION['all_table']." where department='".$_SESSION['department']."' AND level ='".$_level."'";
											
											$retval = mysql_query($sql, $conn_two);
											
											if (!$retval)
											{
												die('Could not get data: ' . mysql_error());
											}
											
											//this is the current page per number ($current_page)
											//anytime u click the program always come here to test if what you click
											//if u have click i.e u click 1 it check if u have click if not it select the first one
											//asive u just reload the page if u click $_GET['page'] will be set but once u statr the
											//page for the first $_GET['page'] will not be set
											
											$current_page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
										
											//record per Page($per_page)	
											$per_page = 10;
											
											//total count record ($total_count) execute the sqlquery set using MYSQL_NUM
											//TO get the total number return from executing Sql in line 47
											$row = mysql_fetch_array($retval, MYSQL_NUM);
											//the total number of page is in this variable bellow $total_count
											$total_count = $row[0];
											
											//it gets the result of total_count over per page
											//i.e it devides the total record according to the number of record you want to
											//dispaly at a time i.e 100/10 = 10 pages
											$total_pages = $total_count/$per_page;
											
											//get the offset current page minus 1 multiply by record per page
											//offset is where the record counting should statr and where it should end
											//is always calculate as the number u click on minus one times the number of page that
											//shoul be dispaly in each page i.e (2-1)*10 = 1*10 = 10
											//(3-1)*10 = 20
											//4=30 5=40 e.t.c
											$offset = ($current_page - 1) * $per_page;
											
											//in every click set the previous pages and next page clicking down in case any body click on it
											//move to previous record by subtracting one into the current record
											$previous_page = $current_page - 1;
											//mvove to next record by incrementing the current page by one		
											$next_page = $current_page + 1;
											//check if previous record is still greater than one then it returns to true
											$has_previous_page =  $previous_page >= 1 ? true : false;
											//check if Next record is still lesser than one total pages then it returns to true
											$has_next_page = $next_page <= $total_pages ? true : false;
											
											//find records of employee and we specify the offset and the limit record per page
											//$sql = "(SELECT trans_code,user_id, date, amount, COUNT(trans_code) As Items, SUM(amount) As total_amount FROM cart_stock where user_id='".$_SESSION['user_identity']."' GROUP BY trans_code ORDER BY id DESC LIMIT {$per_page} OFFSET {$offset})"; 
											
											$sql = "SELECT  DISTINCT(reg_no),  student_name FROM ".$_SESSION['all_table']." INNER JOIN atbu_student ON ".$_SESSION['all_table'].".reg_no=atbu_student.student_regno where ".$_SESSION['all_table'].".level='".$_level."' AND ".$_SESSION['all_table'].".department ='".$_SESSION['department']."' LIMIT {$per_page} OFFSET {$offset}";
											
											$retval = mysql_query($sql, $conn_two);
											if (!$retval) {
												die('Could not get data: ' . mysql_error());
											}else{
											echo '<h4> List Of Registered Courses for '.$_level.' Level - '.$_SESSION['department'].' Department</h4>';
											echo '<table class="table table-condensed">
																		<thead>
																			<tr>
																				<th>S/N<u>o</u>.</th>
																				<th>Registration No</th>
																				<th>Name</th>
																				<th>Status</th>
																				<th></th>
																			</tr>
																		</thead>
																		<tbody>';
											}
											$j = 1;
											$data="";
											$data_list="";
											while ($row = mysql_fetch_array($retval, MYSQL_ASSOC)) 
											{
												
												
												
												//FOR THE TOOL TIP THAT SHOWS THE ITEMS
												$cart_all_result= '<div class="well">
												 
																	<table class="table table-condensed">
																		<thead>
																			<tr>
																				<th>S/No.</th>
																				<th>Course Code</th>
																				<th>Course Title </th>
																				<th>Unit</th>
																			</tr>
																		</thead>
																		<tbody>';
																		
															//select query
														
															$stmt = $conn->prepare("SELECT * from ".$_SESSION['all_table']." where reg_no=?");
															$stmt->execute(array($row['reg_no']));
															$affected_rows = $stmt->rowCount();
															if($affected_rows >= 1) 
															{
																$numbering_two =1;
																$unit =0;
																while($row_ret_two = $stmt->fetch(PDO::FETCH_ASSOC)) 
																{
																	
																	$unit =$unit + $row_ret_two['course_gp'];
																	$cart_all_result=$cart_all_result."<tr>
																				<td>".$numbering_two."</td>
																				<td>".$row_ret_two['subject_code']."</td>
																				<td>".$row_ret_two['course_title']."</td>
																				<td>".$row_ret_two['course_gp']."</td>											
																		</tr>";
																		$numbering_two =$numbering_two +1;
																}
																$link_App ="Approve_Courses.php?level=".$_level."&page=".strip_tags($_GET['page'])."&reg_no=".$row['reg_no']."&type=App".$link_1;
																$link_Disapp ="Approve_Courses.php?level=".$_level."&page=".strip_tags($_GET['page'])."&reg_no=".$row['reg_no']."&type=Disapp".$link_1;
																$cart_all_result= $cart_all_result."
																<tr>
																	<td colspan='2'></td>
																	<td  style='text-align:right;color:blue'>Total Unit :</td>
																	<td >".$unit."</td>
																</tr>
																<tr>
																	<td colspan='2' style='text-align:right;color:blue'> <button type='button' class='btn btn-primary'>Click to Approve</button></td>
																	<td colspan='2' style='text-align:left;color:blue'> <button type='button' class='btn btn-warning'>Click to Disapprove</button></td>
																
																	
																</tr>
																</tbody>
																</table></div>";
															}

												//ends here
												//$cart_all_result ="<p>sdsdsd</p>";
												
												$link =" href=".'"#collapseThree'.$j.'"';
												$id_link =" id=".'"collapseThree'.$j.'"';
												$status =" id=".$row['reg_no'].'"';
												
												$data=$data.'<tr class="listed">
																	<td>'.$j.'</td>
																	<td>'.$row['reg_no'].'</td>
																	<td>'.$row['student_name'].'</td>
																	<td '.$status.'></td>
																	<td><a data-toggle="collapse" data-parent="#accordion" 
              '.$link.' title="Click To View Full Goods Details">View Details</a></td>
															</tr>
															<tr class="list" '.$id_link.' >
																	<td colspan="5" >'.$cart_all_result.'</td>
																	
															</tr>';
													$j =$j +1;
											}
											echo $data.'</tbody></table>';
											
											echo '<ul class="pagination" align="center">';
														
											if ($total_pages > 1)
											{
												//this is for previous record
												if ($has_previous_page)
												{
												echo ' <li><a href=Approve_Courses.php?page='.$previous_page.$link_1.'>&laquo; </a> </li>';
												}
												 //it loops to all pages
												 for($i = 1; $i <= $total_pages; $i++)
												 {
													//check if the value of i is set to current page	
													if ($i == $current_page)
													{
													//then it sset the i to be active or focused
														echo '<li class="active"><span>'. $i.$link_1.' <span class="sr-only">(current)</span></span></li>';
													 }
													 else
													 {
													 //display the page number
														echo ' <li><a href=Approve_Courses.php?page='.$i.$link_1.'> '. $i .' </a></li>';
													 }
												 }
												//this is for next record		
												if ($has_next_page)
												{
												echo ' <li><a href=Approve_Courses.php?page='.$next_page.$link_1.'>&raquo;</a></li> ';
												}
												
											}
											
											echo '</ul>';
											mysql_close($conn_two);
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
