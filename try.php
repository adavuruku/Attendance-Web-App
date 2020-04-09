<?php
require_once 'settings/connection.php';
//if($opr=="retrievestudent"){ 
	$two= array();
	//$username = urldecode($_POST['coursecode']);
	$username = urldecode("MTH221");
	$stmt = $conn->prepare("SELECT * FROM coursereg LEFT JOIN atbu_student ON coursereg.reg_no = atbu_student.student_regno where subject_code =?");		
	$stmt->execute(array($username));
	$affected_rows = $stmt->rowCount();
	if($affected_rows >= 1){
		While($row2 = $stmt->fetch(PDO::FETCH_ASSOC)){
			$dept=$row2['student_dept'];
			$fac=$row2['student_facult'];
			$code=$row2['subject_code'];
			$stname=$row2['student_name'];
			$level=$row2['student_level'];
			$regno=$row2['student_regno'];
			set_stud_values($dept,$fac,$code,$stname,$level,$regno);
		}
	}else{
		$two = array("Error" => "Error: No Record Of Course !!!");
	}
	print(json_encode($two));
	
	 print_r (json_decode(json_encode($two)));
	
//}

function set_stud_values($dept,$fac,$code,$stname,$level,$regno){
		global $two;
		$one = array(
			"Error" => "None",
			"dept" => $dept,
			"fac" => $fac,
			"code" => $code,
			"stname" => $stname,
			"level" => $level,
			"regno" => $regno
		  );
		array_push($two,$one);
}
?>