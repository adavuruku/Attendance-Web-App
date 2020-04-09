<?php
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';

if(!isset($_SESSION['user_full_name']) || !isset($_SESSION['user_email']) || !isset($_SESSION['user_identity'])){
	header("location: exam_logout.php");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta content="noindex, nofollow" name="robots">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Sherif Online Supermarket System Home Platform</title>
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap-theme.css" >
<script type="text/javascript" src="settings/js/bootstrap.js"></script>
<script type="text/javascript" src="settings/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="settings/js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="settings/js/bootstrap.min.js"></script>
<script type="text/javascript" src="settings/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="settings/test.css" >
<script type="text/javascript" src="settings/Add_and_Remove_from_Cart.js"></script>

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
<body style="font-family:Tahoma, Times, serif;font-weight:bold;" >


<div class="container" style="margin:auto;width:90%">
		<div class="row" style="padding-bottom:1%;">
				<div class="col-xs-12 col-sm-12" style="background-color:Cadetblue;" >
					<?php require_once 'settings/header_file.php';?>
				</div>
		</div>
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row" style="background-color:;margin-top:1%;padding-top:1%;">
			<?php require_once 'settings/menu.php';?>
						<!-- middle content ends here where vertical nav slides and news ticker ends -->
						<div  class="col-sm-12 col-md-12 col-lg-12 ">
						<!-- d php -->
						<?php
											//create a mySQL conn_twoection
											$dbhost    = 'localhost';
											$dbuser    = 'root';
											$dbpass    = '';
											$conn_two = mysql_connect($dbhost, $dbuser, $dbpass);
											if (!$conn_two) {
												die('Could not conn_twoect: ' . mysql_error());
											}
											mysql_select_db('sherif_store');
											/* Get total number of records */
											$sql    = "SELECT count(user_id), trans_code FROM cart_stock where user_id='".$_SESSION['user_identity']."' GROUP BY trans_code";
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
											$sql = "(SELECT trans_code,user_id, date, amount, COUNT(trans_code) As Items, SUM(amount) As total_amount FROM cart_stock where user_id='".$_SESSION['user_identity']."' GROUP BY trans_code ORDER BY id DESC LIMIT {$per_page} OFFSET {$offset})"; 
											$retval = mysql_query($sql, $conn_two);
											if (!$retval) {
												die('Could not get data: ' . mysql_error());
											}else{
											echo '<h4>'.$_SESSION['user_full_name'].' -  List Of All Your Transaction Order</h4>';
											echo '<table class="table table-condensed">
																		<thead>
																			<tr>
																				<th>S/N<u>o</u>.</th>
																				<th>Date Of Transaction</th>
																				<th>Purchase Order Code</th>
																				<th>N<u>o</u>. Of Items</th>
																				<th>Total Amount</th>
																				<th></th>
																			</tr>
																		</thead>
																		<tbody>';
											}
											$j = 1;
											$data="";
											$data_list="";
											while ($row_retrieve = mysql_fetch_array($retval, MYSQL_ASSOC)) 
											{
												
												$formattedNum_one =  number_format($row_retrieve['total_amount'], 2);
												$Amount_Naira =" &#8358; ".$formattedNum_one;
												$date500 = new DateTime($row_retrieve['date']);
												$J = date_format($date500,"D");
												$Q = date_format($date500,"d-F-Y");
												$date2 = $J.", ".$Q;
												
												
												//FOR THE TOOL TIP THAT SHOWS THE ITEMS
												$cart_all_result= '<div class="well">
												 <p style="color:Cadetblue"> Transaction - Order : <a  style="color:red" data-toggle="tooltip" data-placement="bottom"    href="store_files/Purchase_Order_Slip_Print.php?former_trans_code='.$row_retrieve['trans_code'].'" target="_blank" title="Click To Print Purchase Order Slip" >'.$row_retrieve['trans_code'].' </a></p>
																	<table class="table table-condensed">
																		<thead>
																			<tr>
																				<th>S/No.</th>
																				<th>Product Name</th>
																				<th>Price </th>
																				<th>Quantity</th>
																				<th>Amount </th>
																				
																			</tr>
																		</thead>
																		<tbody>';
																		
															//select query
															$formattedNum_two ="";
															$stmt = $conn->prepare("SELECT user_id, goods_code,status,quantity,amount,product_name FROM cart_stock where user_id=? AND trans_code=?");
															$stmt->execute(array($_SESSION['user_identity'],$row_retrieve['trans_code']));
															$affected_rows = $stmt->rowCount();
															if($affected_rows >= 1) 
															{
																$numbering_two =1;
																$Amount_total_two =0;
																while($row_ret_two = $stmt->fetch(PDO::FETCH_ASSOC)) 
																{
																	$formattedNum_one_two =  number_format($row_ret_two['amount'], 2);
																	$Amount_two =  $row_ret_two['amount'] * $row_ret_two['quantity'];
																	$formattedNum_two = number_format($Amount_two, 2);
																	$Amount_Naira_two =" &#8358; ".$formattedNum_two;
																	$Amount_total_two = $Amount_total_two + $Amount_two;
																	$cart_all_result=$cart_all_result."<tr>
																				<td>".$numbering_two."</td>
																				<td>".$row_ret_two['product_name']."</td>
																				<td>"." &#8358; ".$formattedNum_one_two."</td>
																				<td>".$row_ret_two['quantity']."</td>
																				<td>".$Amount_Naira_two."</td>											
																		</tr>";
																		$numbering_two =$numbering_two +1;
																}
																$formattedNum_two = number_format($Amount_total_two, 2);
																$cart_all_result= $cart_all_result."
																<tr>
																	<td colspan='2'></td>
																	<td colspan='2' style='text-align:right;color:blue'>Total Amount :</td>
																	<td >"." &#8358; ".$formattedNum_two."</td>
																</tr>
																</tbody>
																</table></div>";
															}

												//ends here
												//$cart_all_result ="<p>sdsdsd</p>";
												$cart_all_result = htmlspecialchars_decode($cart_all_result);
												$Amount_Naira=$formattedNum_two;
												$link =" href=".'"#collapseThree'.$j.'"';
												$id_link =" id=".'"collapseThree'.$j.'"';
												//$id_link ="id="."#collapseThree".$j.'"';
												$data=$data.'<tr class="listed">
																	<td>'.$j.'</td>
																	<td>'.$date2.'</td>
																	<td><a  data-toggle="tooltip" data-placement="bottom"    href="store_files/Purchase_Order_Slip_Print.php?former_trans_code='.$row_retrieve['trans_code'].'" target="_blank" title="Click To Print Purchase Order Slip" >'.$row_retrieve['trans_code'].' </a></td>
																	<td>'.$row_retrieve['Items'].'</td>
																	<td>'." &#8358; ".$Amount_Naira.'</td>
																	<td><a data-toggle="collapse" data-parent="#accordion" 
              '.$link.' title="Click To View Full Goods Details">View Details</a></td>
															</tr>
															<tr class="list" '.$id_link.' >
																	<td colspan="2"></td>
																	<td colspan="4" >'.$cart_all_result.'</td>
																	
															</tr>';
													$j =$j +1;
											}
											echo $data.'</able></table>';
											//echo $cart_all_result;
											echo '<ul class="pagination" align="center">';
														
											if ($total_pages > 1)
											{
												//this is for previous record
												if ($has_previous_page)
												{
												echo ' <li><a href=All_My_Cart_List.php?page='.$previous_page.'>&laquo; </a> </li>';
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
														echo ' <li><a href=All_My_Cart_List.php?page='.$i.'> '. $i .' </a></li>';
													 }
												 }
												//this is for next record		
												if ($has_next_page)
												{
												echo ' <li><a href=All_My_Cart_List.php?page='.$next_page.'>&raquo;</a></li> ';
												}
												
											}
											
											echo '</ul>';
											mysql_close($conn_two);
					?>
			
						
						<!-- d end php -->
						</div>
		</div>
<script>
   $(function () { $("[data-toggle='tooltip']").tooltip(); });
</script>
<script type="text/javascript">
   $(function () { $('#collapseThree1').collapse('toggle')});
</script>
		<div class="row" style="padding-top:1%;">
				<div class="col-xs-12 col-sm-12" style="background-color:Cadetblue;" >
					<footer>
						<p style="text-align:center"><?php //echo $cart_all_result;?>Copyright &copy; 2015 - All Rights Reserved - Software Development Unit, P C N L.</p>
					</footer>
				</div>
		</div>	
</div>	
</body>
</html>  
