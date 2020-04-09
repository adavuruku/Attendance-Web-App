
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
<script type="text/javascript" src="settings/Add_and_Remove_from_Cart.js"></script>
</head>
<body id="container" style="padding-top:2%;font-family:Tahoma, Times, serif;font-weight:bold;">

<div class="container" style="padding-top:20px;">
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
		
			
				<div  class="col-sm-12 col-md-12 col-lg-12">
					<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:yellow">ATBU System Student Home Platform</h3>
					</div>
					<div  id="Question_Container"  class="col-sm-12 col-md-12 col-lg-12"  style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:#CCFFFF;margin-bottom:1%">
						
						<div  class="col-sm-3 col-md-3 col-lg-3">
							<?php require_once 'settings/menu.php';?>
						</div>
						<div  class="col-sm-9 col-md-9 col-lg-9">
							 <hr/>
							 <div  class="col-sm-12 col-md-12 col-lg-12" id="course_reg_div" style="margin-top:10px;background-color:white;padding:3px;" >
								<!-- Add Courses -->
								<?php
									
									$cart_all_result= '	<div class="well">
									<table class="table table-condensed">
													<thead style="color:blue;">
														<tr>
															<th>S/No.</th>
															<th>Course Code</th>
															<th>Course Title </th>
															<th>Course Unit</th>
															<th></th>
														</tr>
													</thead>
													<tbody>';
													
										//select query
										//$formattedNum_two ="";
										$stmt4 = $conn->prepare("SELECT * FROM coursereg where reg_no=? AND department=? order by subject_code ASC");
										$stmt4->execute(array($_SESSION['user_identity'],$_SESSION['department']));
										$affected_rows4 = $stmt4->rowCount();
										if($affected_rows4 >= 1) 
										{
											$numbering_two =1;
											//$Amount_total_two =0;
											$c_unit =0;
											while($row_ret_two = $stmt4->fetch(PDO::FETCH_ASSOC)) 
											{
												$c_unit = $c_unit + $row_ret_two['course_gp'];
												$cart_all_result=$cart_all_result.'<tr>
															<td>'.$numbering_two.'</td>
															<td>'.$row_ret_two['subject_code'].'</td>
															<td>'.$row_ret_two['course_title'].'</td>
															<td>'.$row_ret_two['course_gp'].'</td>					
															<td><a href="#" title="Remove_Course" style="color:red" onclick="delete_Cart(\''.$row_ret_two['subject_code'].'\')"><img src="store_files/images/delete-icon.jpg" style="height:20px" ></img></a></td>
													</tr>';
													$numbering_two =$numbering_two + 1;
											}
											$numbering_two =$numbering_two - 1;
											$cart_all_result= $cart_all_result."
											<tr>
												
												<td  style='text-align:right;color:blue'>N<u>o</u> Of Courses :</td>
												<td >".round($numbering_two,2)."</td>
												<td  style='text-align:right;color:blue'>Total Unit :</td>
												<td >".round($c_unit,2)."</td>
												
											</tr>
											</tbody>
											</table></div>";
											$cart_all_result = htmlspecialchars_decode($cart_all_result);
											echo $cart_all_result;
										}
									//
								?>
								 </div>
								<hr/>
								<div  class="col-sm-12 col-md-12 col-lg-12" style="margin-top:0px;background-color:white;padding:3px;" >
										<div class="form-group">
															<label for="txtPassword" class="control-label col-xs-2">Course Code :</label>
															<div class="col-xs-4">
																<div class="input-group">
																	<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
																	<input type="text" class="form-control" id="txtcourse" name="txtcourse" value="" placeholder="Enter The Course Code">
																</div>
															</div>
															<div class="col-xs-2">
																<button  type="button"  name="submit" onclick="Add_to_Cart()" class="btn btn-success">ADD COURSE</button>
															</div>
															<div class="col-xs-4">
																<button  type="button"  title="Automatically fill your Core Courses for The Semester" name="submit" onclick="fill_all_my_course()" class="btn btn-success">AUTO FILL MY COURSE</button>
															</div>
									</div>
									<br />
								<hr/>
							 </div>
						</div>
						
					</div>
					
					<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						
					</div>
				</div>
		</div>
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
	<script>
   $(function () { $("[data-toggle='tooltip']").tooltip(); });
</script>
<script type="text/javascript">
   $(function () { $('#collapseThree1').collapse('toggle')});
</script>
		<?php require_once 'settings/footer_file.php';?>
</div>	
</body>
</html>  
