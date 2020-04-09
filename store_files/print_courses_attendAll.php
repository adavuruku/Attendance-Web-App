<?php
require_once('tcpdf_include.php');
session_start();
require_once '../settings/connection.php';
require_once '../settings/filter.php';


if(!isset($_SESSION['user_identity']) || !isset($_SESSION['faculty']))
{
	header("location: ../pull_out.php");
}

if(!isset($_GET['level']) || !isset($_GET['page']))
{
	header("location: ../pull_out.php");
}	
$courseCode = $_GET['level'];
$date500 = new DateTime("Now");
$J = date_format($date500,"D");
$Q = date_format($date500,"d-F-Y, h:i:s A");
$dateprint = "Printed On: ".$J.", ".$Q;
	
//retrieve staff incharge
$lecture = $title=$code="";
$stmt2 = $conn->prepare("SELECT * FROM atbu_course inner join atbu_staff on atbu_course.staff_id =  atbu_staff.staff_id where atbu_course.Course_Code = ?");
$stmt2->execute(array($courseCode));
if ($stmt2->rowCount() >= 1)
{
	$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
	$lecture = $row2['staff_name'];
	$code = $row2['Course_Code'];
	$title = $row2['Course_Title'];
}	
	


class MYPDF extends TCPDF 
{
	// Page footer
		public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('dejavusans', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'A T B U System - 2018 - - Page '.$this->getAliasNumPage().' Of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
	}
}



$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Abdulraheem Sherif A');
$pdf->SetTitle('A T B U System');
$pdf->SetSubject('Courses');

$pdf->SetKeywords('Pesoka, Computers, Nigeia, Limited, Ajaokuta');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// to remove default header use this
$pdf->setPrintHeader(false);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

$pdf->AddPage("l");



//total number of time attendance is taken
$totNo = 0;
$stmtv = $conn->prepare("SELECT distinct cid FROM atbu_attendance where code=?");		
$stmtv->execute(array($courseCode));
$affected_rowsv = $stmtv->rowCount();

$html = '<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr >
        <td rowspan="4" width="90"><img src="images/image_demo.jpg" width="200" height="200"/></td>
        <td width="760"></td>
        <td rowspan="4" width="90"><img src="images/image_demo.jpg" width="200" height="200"/></td>
    </tr>
    <tr >
        <td  align="center" style="font-size:15;font-weight:bold;color:blue" >Abubakar Tafawa Balewa University, Bauchi</td>
    </tr>
    <tr >
    	 <td align="center" style="font-size:11;font-weight:bold">P.M.B	1037 Bauchi State, Nigeria.</td>
    </tr>
    <tr>
       <td align="center"  style="font-size:10;font-weight:bold;color:black">ATTENDACE SUMMARY REPORT</td>
    </tr>
	
</table>';
$pdf->writeHTML($html, true, false, true, false, '');

$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
		<td align="Left" style="font-size:8;font-weight:bold;color:brown">.:: COURSE INFORMATION </td> 
		<td  align="Right" style="font-size:8;">'.$dateprint.'</td> 
    </tr>
</table><hr>';

$pdf->writeHTML($html, true, false, false, false, '');

$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
		<td align="Left" width="150" style="font-size:8;font-weight:bold;color:brown">Lecturer: </td> 
		<td  align="Left" width="800" style="font-size:8;">'.$lecture.'</td> 
    </tr>
	<tr style="bottom-border:1 solid;">
		<td align="Left" width="150" style="font-size:8;font-weight:bold;color:brown">Course Code: </td> 
		<td  align="Left" width="800"  style="font-size:8;">'.$code.'</td> 
    </tr>
	<tr style="bottom-border:1 solid;">
		<td align="Left" width="150" style="font-size:8;font-weight:bold;color:brown">Course Title: </td> 
		<td  align="Left" width="800"  style="font-size:8;">'.$title.'</td> 
    </tr>
	<tr style="bottom-border:1 solid;">
		<td align="Left" width="150" style="font-size:8;font-weight:bold;color:brown">Total N<u>o</u> Of Lecture: </td> 
		<td  align="Left" width="800"  style="font-size:8;">'.$affected_rowsv.'</td> 
    </tr>
</table>';

$pdf->writeHTML($html, true, false, false, false, '');


// -----------PERSONALINFORMATION GOODS DETAIL TABLE----------------------------------------------
$pdf->SetAlpha(0.3);
$img_file = K_PATH_IMAGES.'image_demo.jpg';
$pdf->Image($img_file, 85, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAlpha(1);
$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
		<td colspan="2" align="Left" style="font-size:8;font-weight:bold;color:brown">.:: ATTENDANCE SUMARRY REPORT</td> 
    </tr>
</table><hr>';

$pdf->writeHTML($html, true, false, false, false, '');
$html1 ="";
$html1 .= '<tr style="background-color:grey;color:yellow;">
				<td width="40">S/N<u>o</u></td>
				<td width="210">Student Name </td>
				<td width="100">Reg. N<u>o</u></td>
				<td width="150">Faculty</td>
				<td width="150">Department </td>
				<td width="100">Level </td>
				<td width="100">Tot. Attendance</td>
				<td width="100">Percentage</td>
			</tr>';

if($affected_rowsv >=1){
	$totNo = $affected_rowsv;
	//number of student that register the course
	$stmt = $conn->prepare("SELECT reg_no,subject_code FROM coursereg where subject_code=? ");		
	$stmt->execute(array($courseCode));
	$affected_rows = $stmt->rowCount();
	if($affected_rows >= 1){
		$id= 1;
		While($row2 = $stmt->fetch(PDO::FETCH_ASSOC)){
			$studAtt =0;
			//total number of times student was present for the register in the course
			$stmt2 = $conn->prepare("SELECT * FROM atbu_attendance where code=? and regno=?");		
			$stmt2->execute(array($row2['subject_code'],$row2['reg_no']));
			$affected_rows2 = $stmt2->rowCount();
			if($affected_rows2 >= 1){
				//calculate percentage attendance
				$studAtt = ($affected_rows2 * 100)/$totNo;
				$row3 = $stmt2->fetch(PDO::FETCH_ASSOC);
			//display the details
			$html1 .= '<tr  >
						<td width="40">'.$id.'</td>
						<td width="210">'.$row3['stName'].'</td>
						<td width="100">'.$row3['regno'].'</td>
						<td width="150">'.$row3['facult'].'</td>
						<td width="150">'.$row3['dept'].'</td>
						<td width="100">'.$row3['stlevel'].'</td>
						<td width="100">'.$affected_rows2.'</td>
						<td width="100">'.$studAtt.'%</td>
					</tr>
					<tr width="400">
						<td align="Center" colspan ="8" style="font-size:8;"></td>
					</tr>';
			}
			$id = $id + 1;
		}
		
		$id = $id -1;
			$html  = '<table border="1" cellpadding="4" width="800">'.$html1.'
			<tr>
				<td colspan="3" style="text-align:right;color:blue" >N<u>o</u> of Student :</td>
				<td colspan="5" style="text-align:left;">'.$id.'</td>
			</tr></table>';
			// output the HTML content
			$pdf->writeHTML($html, true, false, false, false, '');
	}
}

$file_name = strtoupper($courseCode);
$pdf->Output($file_name.'.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+

?>