<?php
require_once 'settings/connection.php';
	//$opr = urldecode($_POST['opr']);
	$err=null;
	$two = $one = array();
	$searchQuery ="";
//$opr="login";
//$opr="retrievecourse";
$username = "MTH221";//$password = "111222";
	//total no
	$stmtv = $conn->prepare("SELECT cid FROM atbu_attendance where code=? group by cid");		
	$stmtv->execute(array($username));
	$affected_rowsv = $stmtv->rowCount();
	echo $affected_rowsv."<BR/>";

	

	$stmt = $conn->prepare("SELECT reg_no,subject_code FROM coursereg where subject_code=? ");		
	$stmt->execute(array($username));
	$affected_rows = $stmt->rowCount();
	echo $affected_rows."<BR/>"; //number that register it
	if($affected_rows >= 1){
		While($row2 = $stmt->fetch(PDO::FETCH_ASSOC)){
			$stmt2 = $conn->prepare("SELECT regno,code FROM atbu_attendance where code=? and regno=?");		
			$stmt2->execute(array($row2['subject_code'],$row2['reg_no']));
			$affected_rows2 = $stmt2->rowCount();
			if($affected_rows2 >= 1){
				echo $row2['reg_no']." - ".$affected_rows2."<BR/>";
			}else{
				echo $row2['reg_no']." - ".$affected_rows2."<BR/>";
			}	
		}
	}


	/**$someJSON = '{"allrecord":[{"stLevel":"200","stName":"Abdulhaqq y Abdulraheem A.","stCode":"MTH221","stID":"2018-10-07 00:29:18","stDate":"2018-10-07 00:29:18","stReg":"419419"},{"stLevel":"200","stName":"Marry Jude K.","stCode":"MTH221","stID":"2018-10-07 00:29:18","stDate":"2018-10-07 00:29:18","stReg":"14\/37139D\/1"},{"stLevel":"200","stName":"Abdulhaqq Abdulraheem A.","stCode":"CS142","stID":"2018-10-07 00:30:48","stDate":"2018-10-07 00:30:48","stReg":"419419"},{"stLevel":"200","stName":"Marry Jude K.","stCode":"CS142","stID":"2018-10-07 00:30:48","stDate":"2018-10-07 00:30:48","stReg":"14\/37139D\/1"},{"stLevel":"200","stName":"Abdulhaqq Abdulraheem A.","stCode":"MTH221","stID":"2018-10-07 00:31:19","stDate":"2018-10-07 00:31:19","stReg":"419419"},{"stLevel":"200","stName":"Marry Jude K.","stCode":"MTH221","stID":"2018-10-07 00:31:19","stDate":"2018-10-07 00:31:19","stReg":"14\/37139D\/1"},{"stLevel":"100","stName":"Abdullahi Sunday H.","stCode":"MTH221","stID":"2018-10-07 00:31:19","stDate":"2018-10-07 00:31:19","stReg":"12\/23222D\/1"}]}';
	
	//$username = urldecode($_POST['record']);
	$someArray = json_decode($someJSON, true);
	$f = count($someArray['allrecord']);
	for($i=0;$i<$f;$i++){
		$stName = $someArray['allrecord'][$i]["stName"];
		$stCode = $someArray['allrecord'][$i]["stCode"];
		$stLevel = $someArray['allrecord'][$i]["stLevel"];
		$stReg = $someArray['allrecord'][$i]["stReg"];
		$stID = $someArray['allrecord'][$i]["stID"];
		$stDate = $someArray['allrecord'][$i]["stDate"];
		$sth = $conn->prepare ("INSERT INTO test (data,dater) VALUES (?,?)");															
		$sth->bindValue (1, $username);
		$sth->bindValue (2, $stDate);
		$sth->execute();
	}**/
	/**$someArray = json_decode($someJSON, true);
	echo '<br/>';
	echo '<br/>';
	echo '<br/>';
	echo '<br/>';
	echo count($someArray['allrecord']);
	$f = count($someArray['allrecord']);
	for($i=0;$i<$f;$i++){
		echo $i." - ".$someArray['allrecord'][$i]["stName"] ." - ".$someArray['allrecord'][$i]["stCode"] ." - ".$someArray['allrecord'][$i]["stLevel"] ." - ".$someArray['allrecord'][$i]["stReg"] ." - ".$someArray['allrecord'][$i]["stID"]."<br/><br/>";
	}
	//print_r(array_chunk($someArray,6));
	echo '<br/>';echo '<br/>';echo '<br/>';
	echo $someArray['allrecord'][0]["stName"];
	echo '<br/>';echo '<br/>';echo '<br/>';
	print_r($someArray);
	//echo $two.length;**/

 ?>