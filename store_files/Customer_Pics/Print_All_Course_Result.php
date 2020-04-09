<?php
require_once('tcpdf_include.php');
session_start();
require_once '../settings/connection.php';
require_once '../settings/filter.php';

if(!isset($_SESSION['user_identity']) || !isset($_SESSION['faculty']))
{
	header("location: ../pull_out.php");
}

$year =$semester=$search_dept=$dept=$course_title=$err="";
	$sql = "SELECT * FROM course_data where edit_status=? ORDER BY Id DESC Limit 1";
	$stmt = $conn->prepare($sql);
	$stmt->execute(array("False"));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($stmt->rowCount () >= 1)
	{
		$year =$row['year'];
		$semester=$row['semester'];
		if($semester=="1"){
			$semester ="First";
		}
		if($semester=="2"){
			$semester ="Second";
		}
		$_SESSION['all_table']=$row['year']."_".$row['semester'];
	}



//make sure the lecturer trying to edit the result is the actual person editing it
if(!isset($_GET['couCode']) || !isset($_GET['couTitle'])|| !isset($_GET['coudept']) || !isset($_GET['unit']))
{
	header("location: ../pull_out.php");
}
if(($_GET['couCode']=="") || ($_GET['couTitle']=="")|| ($_GET['coudept']=="") || ($_GET['unit']==""))
{
	header("location: ../pull_out.php");
}
$link_1= "&couCode=".$_GET['couCode'];
$link_2= "&couTitle=".$_GET['couTitle'];
$link_3= "&coudept=".$_GET['coudept'];
$link = $link_1.$link_2.$link_3;
$course_code = strip_tags($_GET['couCode']);
$course_Title = strip_tags($_GET['couTitle']);
$course_dept = strip_tags($_GET['coudept']);
$course_gp =strip_tags($_GET['unit']);

$sql = "SELECT * FROM ".$_SESSION['all_table']." INNER JOIN atbu_course ON ".$_SESSION['all_table'].".subject_code = atbu_course.Course_Code  where ".$_SESSION['all_table'].".subject_code=? AND 
atbu_course.staff_id=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute(array($course_code,$_SESSION['user_identity']));
	if ($stmt->rowCount () >= 1)
	{
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$course_gp = $row['course_gp'];
		
	}else{
		header("location: ../pull_out.php");	
	}
	
/////////////////////666777
		
		$date500 = new DateTime("Now");
		$J = date_format($date500,"D");
		$Q = date_format($date500,"d-F-Y, h:i:s A");
		$dateprint = "Printed On: ".$J.", ".$Q;	

		
// create new PDF document

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF 
{
	// Page footer
		public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('dejavusans', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'A T B U System - 2015 - - Page '.$this->getAliasNumPage().' Of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
		//getAliasNumPage() from the immediate line mean the current page
		//getAliasNbPages() from the immediate line mean the total number of pages
		//remember you can remove them and put a common string there
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

// add a page - 100 level
$pdf->AddPage();
// set alpha to semi-transparency


$html = '<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr >
        <td rowspan="4" width="90"><img src="images/image_demo.jpg" width="200" height="200"/></td>
        <td width="460"></td>
        <td rowspan="4" width="90"></td>
    </tr>
    <tr >
        <td  align="center" style="font-size:15;font-weight:bold;color:blue" >Abubakar Tafawa Balewa University, Bauchi</td>
    </tr>
    <tr >
    	 <td align="center" style="font-size:11;font-weight:bold">P.M.B	1037 Bauchi State, Nigeria.</td>
    </tr>
    <tr>
       <td align="center"  style="font-size:10;font-weight:bold;color:black"> RESULT FOR '.strtoupper($_SESSION['department']).' DEPARTMENT - FACULTY OF '.strtoupper($_SESSION['faculty']).'</td>
    </tr>

</table>';
$pdf->writeHTML($html, true, false, true, false, '');

$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
	<tr style="bottom-border:1 solid;">
		<td align="Left" style="font-size:8;font-weight:bold;color:brown;" colspan="2"> Course : '.strtoupper($course_code).' - '.strtoupper($course_Title).' - '.$course_gp.' Unit </td> 
    </tr>
	<tr style="bottom-border:1 solid;">
		<td align="Left" style="font-size:8;font-weight:bold;color:brown;" colspan="2"> Department : '.strtoupper($course_dept).' - '.strtoupper($_SESSION['faculty']).'</td> 
    </tr>
	<tr style="bottom-border:1 solid;">
		<td align="Left" style="font-size:8;font-weight:bold;color:brown;" colspan="2"> Session - Semester : '.strtoupper($year).' - '.strtoupper($semester).' Semester </td>  
    </tr>
    <tr style="bottom-border:1 solid;">
		<td align="Left" style="font-size:8;font-weight:bold;color:brown"> Prepared By : '.strtoupper($_SESSION['full_name']).' </td> 
		<td  align="Right" style="font-size:8;">'.$dateprint.'</td> 
    </tr>
</table><hr>';

$pdf->writeHTML($html, true, false, false, false, '');


// -----------PERSONALINFORMATION GOODS DETAIL TABLE----------------------------------------------
$pdf->SetAlpha(0.3);
$img_file = K_PATH_IMAGES.'image_demo.jpg';
$pdf->Image($img_file, 55, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAlpha(1);

$html1 ="";
$stmt = $conn->prepare("SELECT * FROM ".$_SESSION['all_table']." INNER JOIN atbu_student ON ".$_SESSION['all_table'].".reg_no=atbu_student.student_regno 
where ".$_SESSION['all_table'].".subject_code=? AND ".$_SESSION['all_table'].".department =? ORDER BY atbu_student.student_name ASC");
$stmt->execute(array($course_code,$course_dept));
if ($stmt->rowCount () >= 1)
{
	 $html1 .= '<tr style="background-color:grey;color:yellow;">
			<td width="40">S/N<u>o</u></td>
			<td width="130">Student Name </td>
			<td width="100">Reg_No</td>
			<td width="60">1st Test</td>
			<td width="60">2nd Test</td>
			<td width="60">3rd Test</td>
			<td width="60">Exam</td>
			<td width="60">Total Score</td>
			<td width="60">Grade</td>
		</tr>';
		$id=1;$NO_A =0;$NO_B =0;$NO_C =0;$NO_D =0;$NO_CO =0;
		$staff_name ="";$tot_unit=0;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
		{	
			
			//$staff_name = $row['staff_name'];
			if($row['student_gpa']=="A"){
				$NO_A = $NO_A +1;
			}
			if($row['student_gpa']=="B"){
				$NO_B = $NO_B +1;
			}
			if($row['student_gpa']=="C"){
				$NO_C = $NO_C +1;
			}
			if($row['student_gpa']=="D"){
				$NO_D = $NO_D +1;
			}
			if($row['student_gpa']=="C/O"){
				$NO_CO = $NO_CO +1;
			}
			
			$html1 .= '<tr  >
							<td >'.$id.'</td>
							<td>'.$row['student_name'].'</td>
							<td>'.$row['reg_no'].'</td>
							<td>'.$row['test1'].'</td>
							<td>'.$row['test2'].'</td>
							<td>'.$row['test3'].'</td>
							<td>'.$row['exam'].'</td>
							<td>'.$row['total'].'</td>
							<td>'.$row['student_gpa'].'</td>
						</tr>
						<tr width="400">
							<td align="Center" colspan ="2" style="font-size:8;"></td>
						</tr>';
						$id = $id + 1;
		}
		$id = $id -1;
		$SUMAARY = " A - ".$NO_A." , B - ".$NO_B." , C - ".$NO_C." , D - ".$NO_D." , C/O - ".$NO_CO;
		$html  = '<table border="1" cellpadding="4" width="800">'.$html1.'
		<tr>
			<td style="text-align:right;color:blue" colspan="2" >N<u>o</u> of Students :</td>
			<td style="text-align:left;">'.$id.'</td>
			<td style="text-align:right;color:blue" colspan="2" >Result Summary :</td>
			<td style="text-align:left;" colspan="4">'.$SUMAARY.'</td>
		</tr></table>';
		// output the HTML content
		$pdf->writeHTML($html, true, false, false, false, '');
}
$file_name = strtoupper($course_code." ".$course_Title." ".$_SESSION['department']);
$pdf->Output($file_name.'.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+


	
?>