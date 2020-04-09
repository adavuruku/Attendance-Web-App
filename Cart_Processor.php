<?php 
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';

////retrieve from cart table
function Display_Cart_Goods()
{
	global $conn;
	$table_course=$sem=$head_ti="";
		
		$cart_all_result='	<div class="well">
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
}


if(isset($_POST['auto_fill']))
{
	$stmt = $conn->prepare("SELECT * FROM atbu_course where Department=? AND Level=? AND Semester=?");
	$stmt->execute(array($_SESSION['department'],$_SESSION['level'],"2"));
	$affected_rows = $stmt->rowCount();
	if($affected_rows >= 1) 
	{
		//$row_retrieve = $stmt->fetch(PDO::FETCH_ASSOC);
		while($row_retrieve = $stmt->fetch(PDO::FETCH_ASSOC)) 
		{
			//check if student already register the course
			$stmt4 = $conn->prepare("SELECT * FROM coursereg where reg_no=? AND department=? AND subject_code =? Limit 1");
			$stmt4->execute(array($_SESSION['user_identity'],$_SESSION['department'],$row_retrieve['Course_Code']));
			$affected_rows4 = $stmt4->rowCount();
			if($affected_rows4 != 1) 
			{
				//it means course is not there then insert the course
				$sth = $conn->prepare ("INSERT INTO coursereg (course_gp,reg_no,department,subject_code,course_title)
														VALUES (?,?,?,?,?)");															
					$sth->bindValue (1, $row_retrieve['course_unit']);
					$sth->bindValue (2, $_SESSION['user_identity']);
					$sth->bindValue (3, $_SESSION['department']);
					$sth->bindValue (4, $row_retrieve['Course_Code']);
					$sth->bindValue (5, $row_retrieve['Course_Title']);			
					$sth->execute();			
			}	
		}
		Display_Cart_Goods();
	}else{
		Display_Cart_Goods();
	}
}
//delete courses you have register
if(isset($_POST['delete_item']))
{
	$Add_Id = $_POST['course'];
	//delete the items
	$stmt = $conn->prepare("Delete from coursereg where reg_no=? AND department=? AND subject_code=? Limit 1");
	$stmt->execute(array($_SESSION['user_identity'],$_SESSION['department'],$Add_Id));
	$affected_rows = $stmt->rowCount();
	Display_Cart_Goods();
}

//add courses to register
if(isset($_POST['add_item']))
{
	//retrieve the goods details
	$Add_Id = $_POST['course'];
	
	
	//check if course exist
	//add courses
	//reload the div $_SESSION['table_course']
	
	//check if student has reg course before
	$stmt4 = $conn->prepare("SELECT * FROM coursereg where reg_no=? AND department=? AND subject_code=? Limit 1");
	$stmt4->execute(array($_SESSION['user_identity'],$_SESSION['department'],$Add_Id));
	$affected_rows4 = $stmt4->rowCount();
	if($affected_rows4 != 1) 
	{
		//retrieve course from course well
		$stmt = $conn->prepare("SELECT * FROM atbu_course where Course_Code=? Limit 1");
		$stmt->execute(array($Add_Id));
		$affected_rows = $stmt->rowCount();
		if($affected_rows == 1) 
		{
			$row_retrieve = $stmt->fetch(PDO::FETCH_ASSOC);
			
			
			//add courses
			$sth = $conn->prepare ("INSERT INTO coursereg (course_gp,reg_no,department,subject_code,course_title)
														VALUES (?,?,?,?,?)");															
					$sth->bindValue (1, $row_retrieve['course_unit']);
					$sth->bindValue (2, $_SESSION['user_identity']);
					$sth->bindValue (3, $_SESSION['department']);
					$sth->bindValue (4, $row_retrieve['Course_Code']);
					$sth->bindValue (5, $row_retrieve['Course_Title']);			
					if($sth->execute())
					{
						Display_Cart_Goods();
						//echo "sherif";
					}			
		}else{
			echo "Wrong Code";
		}
	}else{
	
		Display_Cart_Goods();
	}
}
?>