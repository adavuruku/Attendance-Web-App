
<?php
session_start(); 
require_once '../settings/connection.php';
require_once '../settings/filter.php';

if(!isset($_SESSION['admin']))
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
		
			<div  class="col-sm-1 col-md-1 col-lg-1"></div>
				<div  class="col-sm-10 col-md-10 col-lg-10">
					<div  class="col-lg-12" style="width:100%; padding-top:5px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:white">A T B U System</h3>
						<h5 style="text-align:center;color:yellow">Welcome	- <?php echo $_SESSION['full_name'];?> - <a style="color:white" href="../pull_out.php">Log Out</a> || <a style="color:white" href="Staff_Home.php">My Home </a> </h5>
						<h5 style="text-align:center;color:yellow"> 1 - Allow || 0 - Disallow </h5>
					</div>
					<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:15px;padding-right:15px; padding-bottom:5px; background-color:#D8D8D8 ;margin-bottom:1%">
			
							<table class="table table-condensed">
						<thead>
							<tr>
								<th>Id</th>
								<th>Staff Name</th>
								<th>Admin</th>
								<th>Register Couses</th>
								<th>Register Staffs</th>
								<th></th>
								<th>Status</th>
							</tr>
						</thead>

						<tbody>
							<?php
							//create a mySQL connection
							$dbhost    = 'localhost';
							$dbuser    = 'root';
							$dbpass    = '';
							$conn = mysql_connect($dbhost, $dbuser, $dbpass);
							if (!$conn) {
								die('Could not connect: ' . mysql_error());
							}
							mysql_select_db('atbu_server');
							/* Get total number of records */
							$sql    = "SELECT count(*) FROM atbu_staff where staff_dept='".$_SESSION['department']."'";
							$retval = mysql_query($sql, $conn);
							
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
							$per_page = 2;
							
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
							$sql = "SELECT Id,staff_id,staff_name, staff_dept,admin, course_upload,staff_registration FROM atbu_staff LIMIT {$per_page} OFFSET {$offset}"; 
						
							$retval = mysql_query($sql, $conn);
							if (!$retval) {
								die('Could not get data: ' . mysql_error());
							}
							$j = $current_page;
							if($j !=1)
							{
								$j = $offset + 1;
							}
							while ($row = mysql_fetch_array($retval, MYSQL_ASSOC)) 
							{
									//$idM ="<input type='text' value=".$row['Reg_No']."M";
									$idS =" id=".$row['staff_id']."S";
									$idA =" id=".$row['staff_id']."A";
									$idC =" id=".$row['staff_id']."C";
									
									$idstatus =" id=".$row['staff_id']."status";
									
									$staff_id = $row['staff_id'];
									$GRADES = "Value=".$row['staff_registration']." ";
									$GRADEA = "Value=".$row['admin']." ";
									$GRADEC = "Value=".$row['course_upload']." ";
								echo '<tr>';
								echo '<td>' . $j . '</td>';
								echo '<td>' . $row['staff_name'] . '</td>';
								
								echo '<td><input style="width:80px;" onkeydown="return noNumbers(event,this)" type="text"'.$GRADEA.$idA.'></td>';
								echo '<td><input style="width:120px;" onkeydown="return noNumbers(event,this)" type="text"'.$GRADEC.$idC.'></td>';
								echo '<td><input style="width:120px;" onkeydown="return noNumbers(event,this)" type="text"'.$GRADES.$idS.'></td>';
								
								echo '<td><input type="button" value="Save Changes" onclick="submit_changes(\''.$staff_id.'\')" ></td>';
								echo '<td '.$idstatus.'><td>';
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
								echo ' <li><a href=Admin_Permission.php?page='.$previous_page.'>&laquo; </a> </li>';
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
										echo ' <li><a href=Admin_Permission.php?page='.$i.'> '. $i .' </a></li>';
									 }
								 }
								//this is for next record		
								if ($has_next_page)
								{
									echo ' <li><a href=Admin_Permission.php?page='.$next_page.'>&raquo;</a></li> ';
								}
								
							}
							
							echo '</ul>';
							mysql_close($conn);
							?>
				</tbody>
			</table>
						
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
