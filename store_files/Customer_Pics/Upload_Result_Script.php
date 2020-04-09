<?php
session_start(); 
require_once '../settings/connection.php';
require_once '../settings/filter.php';
//ADMIN CHANGE AUTHORITY					
if (isset($_POST['admin']))
{
	//echo "Result was submitted";
	//echo $_POST['maths'];
	
	$school_value = strip_tags($_POST['school_value']);
	$course_value = strip_tags($_POST['course_value']);
	$admin_value = strip_tags($_POST['admin_value']);
	$staff_id = strip_tags($_POST['staff_id']);
	
	$stmt = $conn->prepare("UPDATE atbu_staff SET admin=?,course_upload=?,staff_registration=? where staff_id=? Limit 1");
	$stmt->execute(array($admin_value,$course_value,$school_value,$staff_id));
	$affected_rows = $stmt->rowCount();
	if($affected_rows == 1)
	{
		echo "<p style='color:blue'>Change Applied";
	}
	else
	{
		echo "<p style='color:red'>Faill to Update";
	}
}

///Delete Courses
if(isset($_POST['delete_item']))
{
	$Add_Id = $_POST['course_code'];
	$all_dept= "";
	$sql = "DELETE FROM atbu_course where Course_Code=? Limit 1";
	$stmt = $conn->prepare($sql);
	$stmt->execute(array($Add_Id));
	if ($stmt->rowCount () == 1)
	{
		echo "<p style='color:blue'>Course Removed"; 
	}else{
		echo "<p style='color:red'>Error : Not Deleted"; 
	}
}


///Upload courses step one
if(isset($_POST['result_step_one']))
{
	$Add_Id = $_POST['course_code'];
	$all_dept= "";
	$sql = "SELECT DISTINCT(Department),subject_code,course_title,course_gp FROM ".$_SESSION['all_table']." where subject_code=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute(array($Add_Id));
	if ($stmt->rowCount () >= 1)
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
		{
			if($all_dept==""){
				$all_dept = $all_dept.$row['Department'];
			}else{
				$all_dept = $all_dept.";".$row['Department'];
			}
			$_SESSION['course_title']=$row['course_title'];
			$_SESSION['course_unit']=$row['course_gp'];
		}
		echo $all_dept;
	}
}

//save test scores
if(isset($_POST['result']))
{
	$test1 = $_POST['test1'];$grade = $_POST['grade'];$code = $_POST['code'];
	$test2 = $_POST['test2'];$point = $_POST['point'];
	$test3 = $_POST['test3'];$regno = $_POST['regno'];
	$exam = $_POST['exam_val'];$dept = $_POST['dept'];
	$total = $test1 + $test2 + $test3 + $exam;
	//Update the result
	$stmt = $conn->prepare("UPDATE ".$_SESSION['all_table']." SET test1 = ?,test2 = ?,test3 = ?,exam = ?,total = ?,student_gpa = ?,student_gpn = ? WHERE (reg_no=? And department=?) AND subject_code=? Limit 1");
		$stmt->execute(array($test1,$test2,$test3,$exam,$total,$grade,$point,$regno,$dept,$code));
		$affected_rows = $stmt->rowCount();
		if($affected_rows==1){
			echo "<p style='color:blue'>Change Applied";
		}
		else
		{
			echo "<p style='color:red'>Faill to Update";
		}
}
?>