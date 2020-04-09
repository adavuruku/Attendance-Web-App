
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
<title>Sherif Online Supermarket System</title>
<link rel="shortcut icon" href="Server_Pictures_Print/images/image_demo.jpg">
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="settings/css/bootstrap-theme.css" >
<script type="text/javascript" src="settings/js/bootstrap.js"></script>
<script type="text/javascript" src="settings/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="settings/js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="settings/js/bootstrap.min.js"></script>
<script type="text/javascript" src="settings/js/bootstrap.min.js"></script>
<style type="text/css">
body {
 /*   background-image: url(Server_Pictures_Print/images/Programa_Sherif.jpg);
    background-position: top right;
    background-repeat: no-repeat;*/
}
</style>
<style>
            
            #elem{
                position: absolute;
                background-color: transparent;
                -webkit-user-select: none;
                -moz-user-select: none;
                -o-user-select: none;
                -ms-user-select: none;
                -khtml-user-select: none;     
                user-select: none;
				z-index:1;
            }
        </style>
        <script>
            var mydragg = function(){
                return {
                    move : function(divid,xpos,ypos){
                        divid.style.left = xpos + 'px';
                        divid.style.top = ypos + 'px';
                    },
                    startMoving : function(divid,container,evt){
                        evt = evt || window.event;
                        var posX = evt.clientX,
                            posY = evt.clientY,
                        divTop = divid.style.top,
                        divLeft = divid.style.left,
                        eWi = parseInt(divid.style.width),
                        eHe = parseInt(divid.style.height),
                        cWi = parseInt(document.getElementById(container).style.width),
                        cHe = parseInt(document.getElementById(container).style.height);
                        document.getElementById(container).style.cursor='move';
                        divTop = divTop.replace('px','');
                        divLeft = divLeft.replace('px','');
                        var diffX = posX - divLeft,
                            diffY = posY - divTop;
                        document.onmousemove = function(evt){
                            evt = evt || window.event;
                            var posX = evt.clientX,
                                posY = evt.clientY,
                                aX = posX - diffX,
                                aY = posY - diffY;
                                if (aX < 0) aX = 0;
                                if (aY < 0) aY = 0;
                                if (aX + eWi > cWi) aX = cWi - eWi;
                                if (aY + eHe > cHe) aY = cHe -eHe;
                            mydragg.move(divid,aX,aY);
                        }
                    },
                    stopMoving : function(container){
                        var a = document.createElement('script');
                        document.getElementById(container).style.cursor='default';
                        document.onmousemove = function(){}
                    },
                }
            }();

        </script>
</head>
<body id="container" style="padding-top:5%;font-family:Tahoma, Times, serif;font-weight:bold;">

<div id="elem" onmousedown='mydragg.startMoving(this,"container",event);' onmouseup='mydragg.stopMoving("container");'>
                <div style='width:100%;height:100%;padding:10px'>
                <p>Program Design By: <a href="#" style="color:black;">Programmer Abdulraheem Sherif A.</a><p>
                </div>
  </div>

<div class="container" style="padding-top:20px;">
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
		
			
				<div  class="col-sm-12 col-md-12 col-lg-12">
					<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:yellow">ATBU System Home Platform</h3>
					</div>
					<div  id="Question_Container"  class="col-sm-12 col-md-12 col-lg-12"  style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:CadetBlue;margin-bottom:1%">
						
						<div  class="col-sm-3 col-md-3 col-lg-3">
							<?php require_once 'settings/menu.php';?>
						</div>
						<div  class="col-sm-9 col-md-9 col-lg-9" style="margin-top:37px;background-color:white;padding:3px;">
							
							<?php
									echo '<h4>'.$_SESSION['full_name'].' -  All Your Result</h4>';
								
									$stud_stu=0;
									$stud_ctu=0;
									$gp=$cgp=0;
									$cart_all_result=$table_course=$sem="";
									$stmt = $conn->prepare("SELECT * FROM course_data where  edit_status=?");
									$stmt->execute(array("1"));
									$affected_rows = $stmt->rowCount();
									if($affected_rows >= 1) 
									{
										echo '<table class="table table-responsive" border="0%" style="padding:5%;">
													<thead>
														<tr>
															<th colspan="2">Session - Semester</th>
															<th>Semester GP</th>
															<th>Cumulative GP</th>
															<th></th>
														</tr>
													</thead>
													<tbody>';
										$j = 1;
										$data="";
										$data_list="";
										while($row = $stmt->fetch(PDO::FETCH_ASSOC))
										{

														//go to the student course registration page $row['']
														$stmt2 = $conn->prepare("SELECT * FROM course_cgp where  year=? and semester=? and reg_no=?");
														$stmt2->execute(array($row['year'],$row['semester'],$_SESSION['user_identity']));
														$affected_rows2 = $stmt2->rowCount();
														if($affected_rows2 >= 1) 
														{
															$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
															$sem="";
															$stud_stu=$stud_stu + $row2['STP'];
															$stud_ctu=$stud_ctu + $row2['CTU'];
															$cgp = $stud_stu / $stud_ctu;
															$gp = $row2['STP']/$row2['CTU'];
															
															if($row2['semester']=="1"){
																$sem ="First Semester";
															}
															if($row2['semester']=="2"){
																$sem ="Second Semester";
															}
															
															$table_course = $row2['year']."_".$row2['semester'];
																 
															//create another loop to load the courses for each student
															$cart_all_result= '<div class="well">
																	 <p style="color:Cadetblue">Result Slip : <a  style="color:red" data-toggle="tooltip" data-placement="bottom"    href="store_files/Purchase_Order_Slip_Print.php?former_trans_code='.$row2['reg_no'].'&year='.$row2['year'].'&semester='.$row2['semester'].'" target="_blank" 
																	 title="Click To Print Semester Result Slip" >'.$row2['year'].' - '.$sem.' </a></p>
																						<table class="table table-condensed">
																							<thead>
																								<tr>
																									<th>S/No.</th>
																									<th>Course Code</th>
																									<th>Course Title </th>
																									<th>Course Unit</th>
																									<th>Grade </th>
																								</tr>
																							</thead>
																							<tbody>';
																							
																				//select query
																				//$formattedNum_two ="";
																				$stmt4 = $conn->prepare("SELECT * FROM ".$table_course." where reg_no=? AND department=?");
																				$stmt4->execute(array($_SESSION['user_identity'],$_SESSION['department']));
																				$affected_rows4 = $stmt4->rowCount();
																				if($affected_rows4 >= 1) 
																				{
																					$numbering_two =1;
																					//$Amount_total_two =0;
																					while($row_ret_two = $stmt4->fetch(PDO::FETCH_ASSOC)) 
																					{
																						$cart_all_result=$cart_all_result."<tr>
																									<td>".$numbering_two."</td>
																									<td>".$row_ret_two['subject_code']."</td>
																									<td>".$row_ret_two['course_title']."</td>
																									<td>".$row_ret_two['course_gp']."</td>
																									<td>".$row_ret_two['student_gpa']."</td>											
																							</tr>";
																							$numbering_two =$numbering_two + 1;
																					}
																					
																					$cart_all_result= $cart_all_result."
																					<tr>
																					
																						<td colspan='2' style='text-align:right;color:blue'>Semester GP :</td>
																						<td >".round($gp,2)."</td>
																						<td style='text-align:right;color:blue'>Cumulative GP :</td>
																						<td >".round($cgp,2)."</td>
																					</tr>
																					</tbody>
																					</table></div>";
																				}
															//ends bring
														}												
												
												
												$cart_all_result = htmlspecialchars_decode($cart_all_result);
												$link =" href=".'"#collapseThree'.$j.'"';
												$id_link =" id=".'"collapseThree'.$j.'"';
												$data=$data.'<tr class="listed">
											
												<td colspan="2"><a  data-toggle="tooltip" data-placement="bottom"    href="store_files/Purchase_Order_Slip_Print.php?former_trans_code='.$_SESSION['user_identity'].'&year='.$row['year'].'&semester='.$row['semester'].'"
												target="_blank" title="Click To Print Semester Result Slip" >'.$row['year'].' - '.$sem.'</a></td>
													<td>'.round($gp,2).'</td>
													<td>'.round($cgp,2).'</td>
													<td><a data-toggle="collapse" data-parent="#accordion"'.$link.' title="Click To View Result">View Result</a></td>
												</tr>
												<tr class="list" '.$id_link.' >
													<td></td>
													<td colspan="4" >'.$cart_all_result.'</td>
												</tr>';
												$j =$j +1;
															
										}
										echo $data.'</tbody></table>';
									}
									
							?>
							 
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
		<div class="row">
			<div class="col-xs-2 col-sm-2"></div>	
				<div class="col-xs-8 col-sm-8" >
					<footer>
						<p style="text-align:center">Copyright &copy; 2015 - All Rights Reserved - Software Development Unit, S O S M.</p>
					</footer>
				</div>
			<div class="col-xs-2 col-sm-2"></div>	
		</div>	
</div>	
</body>
</html>  
