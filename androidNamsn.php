<?php
require_once 'settings/connection.php';
	$opr = urldecode($_POST['opr']);
	$err=null;
	$two = $one = array();
	$searchQuery ="";
//$opr="uploaddata";
//$opr="retrievecourse";
	//login
	if($opr=="login"){
	$username = urldecode($_POST['userID']);$password = urldecode($_POST['userPassword']);
	$stmt = $conn->prepare("SELECT * FROM atbu_staff where  staff_id=? and staff_password=?  Limit 1");		
	$stmt->execute(array($username,$password));
	$affected_rows = $stmt->rowCount();
	if($affected_rows >= 1){
		$row2 = $stmt->fetch(PDO::FETCH_ASSOC);  
		$one = array(
			"Error" => "None",
			"MyName" => $row2['staff_name'],
			"MyDept" => $row2['staff_dept'],
			"MyId" => $row2['staff_id'],
			"MyFac" => $row2['staff_faculty'],
			"MyPassword"=>$row2['staff_password']
		  );
	}else{
		$one = array("Error" => "Error: Wrong Username Or Password !!!");
	}
	print(json_encode($one));
}

//load courses	
function set_course_values($title,$unit,$code){
		global $two;
		$one = array(
			"Error" => "None",
			"title" => $title,
			"unit" => $unit,
			"code" => $code
		  );
		array_push($two,$one);
}
$title=$unit=$code="";
if($opr=="retrievecourse"){
	$two= array();
	$username = urldecode($_POST['userID']);
	$stmt = $conn->prepare("SELECT * FROM atbu_course where staff_id =?");		
	$stmt->execute(array($username));
	$affected_rows = $stmt->rowCount();
	if($affected_rows >= 1){
		While($row2 = $stmt->fetch(PDO::FETCH_ASSOC)){
			$title=$row2['Course_Title'];
			$unit=$row2['course_unit'];
			$code=$row2['Course_Code'];
			set_course_values($title,$unit,$code);
		}
	}else{
		$two = array("Error" => "Error: No Record Of Course !!!");
	}
	print(json_encode($two));
}
//load student list
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
$dept=$fac=$code=$stname=$level=$regno="";
if($opr=="retrievestudent"){ 
	$two== array();
	$username = urldecode($_POST['coursecode']);
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
}

if($opr=="uploaddata"){
	$username = urldecode($_POST['record']);
	$two = array();
	$someArray = json_decode($username, true);
	$f = count($someArray['allrecord']);
	for($i=0; $i<$f; $i++){
		$stName = $someArray['allrecord'][$i]["stName"];
		$stCode = $someArray['allrecord'][$i]["stCode"];
		$stLevel = $someArray['allrecord'][$i]["stLevel"];
		$stReg = $someArray['allrecord'][$i]["stReg"];
		$stDept = $someArray['allrecord'][$i]["stDept"];
		$stFac = $someArray['allrecord'][$i]["stFac"];
		$stID = $someArray['allrecord'][$i]["stID"];
		$stDate = $someArray['allrecord'][$i]["stDate"];
		
		$sth = $conn->prepare ("INSERT INTO atbu_attendance (code,regno,stlevel,cid,recDate,stName,dept,facult) VALUES (?,?,?,?,?,?,?,?)");							
		$sth->bindValue (1, $stCode);
		$sth->bindValue (2, $stReg);
		$sth->bindValue (3, $stLevel);
		$sth->bindValue (4, $stID);
		$sth->bindValue (5, $stDate);
		$sth->bindValue (6, $stName);
		$sth->bindValue (7, $stDept);
		$sth->bindValue (8, $stFac);
		$sth->execute();
	}
	if($f>=1){
		$two = array("Error" => "Error");
	}else{
		$two = array("Error" => "Error: No Record Of Course !!!");
	}
	print(json_encode($two));
}
 ?>