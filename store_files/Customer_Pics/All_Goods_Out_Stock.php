<?php
require_once('tcpdf_include.php');
session_start();
require_once '../settings/connection.php';
require_once '../settings/filter.php';
require_once '../settings/site_root_config.php';
$root = my_site_root();
$user_name = $profile_Pics =$email=$state=$local_gov=$phone_no =$phone_no =$dateprint =$perm_address=$contact_address=$id_count=$total_amount_summary="";



if(!isset($_SESSION['Admin_user_name']) AND !isset($_SESSION['Admin_user_full_name']))
{
	header("location: ../exam_logout.php");
}
		
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
		$this->Cell(0, 10, 'Sherif Online Marketing System - 2015 - - Page '.$this->getAliasNumPage().' Of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
		//getAliasNumPage() from the immediate line mean the current page
		//getAliasNbPages() from the immediate line mean the total number of pages
		//remember you can remove them and put a common string there
	}
}



$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Abdulraheem Sherif A');
$pdf->SetTitle('Sherif Online Marketing System');
$pdf->SetSubject('Customer Purchase Order Slip');

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

// add a page
$pdf->AddPage();
// set alpha to semi-transparency


$html = '<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr >
        <td rowspan="4" width="90"><img src="images/image_demo.jpg" width="200" height="200"/></td>
        <td width="460"></td>
        <td rowspan="4" width="90"></td>
    </tr>
    <tr >
        <td  align="center" style="font-size:15;font-weight:bold;color:blue" >SHERIF ONLINE MARKETING SYSTEM</td>
    </tr>
    <tr >
    	 <td align="center" style="font-size:11;font-weight:bold">P.M.B	1037 KADUNA ESTATE AJAOKUTA KOGI STATE NIGERIA</td>
    </tr>
    <tr>
       <td align="center"  style="font-size:10;font-weight:bold;color:black">LIST OF ALL GOODS IN STOCK</td>
    </tr>

</table>';
$pdf->writeHTML($html, true, false, true, false, '');

$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
		<td align="Left" style="font-size:8;font-weight:bold;color:brown">GOODS DETAILS LIST</td> 
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
//fetch the email
$stmt = $conn->prepare("SELECT user_id FROM cart_stock where status=? GROUP BY user_id");
$stmt->execute(array("2"));
if ($stmt->rowCount () >= 1)
{
	$grand_total=0;
	while($row_retrieve = $stmt->fetch(PDO::FETCH_ASSOC)) 
	{
		$user_mail = $row_retrieve['user_id'];
		//retrieve the customer name from customer details table
		$stmt2 = $conn->prepare("SELECT email,full_name FROM customers_details where email=? Limit 1");
		$stmt2->execute(array($user_mail));
		if ($stmt2->rowCount () >= 1)
		{
			$row_retrieve2 = $stmt2->fetch(PDO::FETCH_ASSOC);
			$html1 .= '<tr >
			<td style="background-color:grey;color:yellow;" colspan="5"><i>'.$row_retrieve2['full_name'].' - '.$user_mail.'</i></td>
		</tr>';
		}
		
		//group the transcode
		$stmt21 = $conn->prepare("SELECT trans_code,user_id,date,status FROM cart_stock where user_id=? AND status=? GROUP BY trans_code");
		$stmt21->execute(array($user_mail,"2"));
		$affected_rows21 = $stmt21->rowCount();
		if($affected_rows21 >= 1) 
		{
			
			while($row_retrieve21 = $stmt21->fetch(PDO::FETCH_ASSOC)) 
			{
				//echo  $row_retrieve21['date'].'<br/>';
				$html1 .= '<tr >
							<td></td>
						<td style="color:blue;" colspan="4"><i>'.$row_retrieve21['trans_code'].' - '.$row_retrieve21['date'].'</i></td>
					</tr>
					
					<tr >
						<td ></td>
						<td style="background-color:grey;color:yellow;">S/N<u>o</u></td>
						<td style="background-color:grey;color:yellow;">Item Name </td>
						<td style="background-color:grey;color:yellow;">Quantity</td>
						<td style="background-color:grey;color:yellow;">Price</td></tr>';
				
				$stmt3 = $conn->prepare("SELECT trans_code,product_name,quantity,amount,user_id,date FROM cart_stock where trans_code=?");
				$stmt3->execute(array($row_retrieve21['trans_code']));
				$affected_rows3 = $stmt3->rowCount();
				if($affected_rows3 >= 1) 
				{
					$id=1;$Amount_total=0;
					while($row_retrieve3 = $stmt3->fetch(PDO::FETCH_ASSOC)) 
					{
						//echo  $row_retrieve3['product_name'].'<br/>';
						$Price = number_format($row_retrieve3['amount'], 2);
						$price_sum =$row_retrieve3['amount'];
						$Price_Naira = " &#8358; ".$Price;
						//the total Amount
						$Amount_total = $Amount_total + $price_sum;
						$html1 .= '<tr >
							<td></td>
							<td width="40">'.$id.'</td>
							<td width="215" >'.$row_retrieve3['product_name'].'</td>
							<td>'.$row_retrieve3['quantity'].'</td>
							<td>'.$Price_Naira.'</td>
						</tr>';
						$id=$id+1;
					}
					$grand_total = $grand_total + $Amount_total;
					$Amount_total_display = number_format($Amount_total, 2);
					$Amount_total_Naira =" &#8358; ".$Amount_total_display;
					$html1 .= '<tr >
							<td></td>
							<td style="text-align:right;color:blue;" colspan="3">Total Amount : </td>
							<td style="text-align:left;"><b>'.$Amount_total_Naira.'</b></td>
						</tr>';
				}
				
			}
		}
		$grand_total_display = number_format($grand_total, 2);
		$grand_total_Naira =" &#8358; ".$grand_total_display;
		$grand_total=0;
		$html1 .= '<tr style="color:black;">
		<td></td>
			<td style="background-color:grey;text-align:right;color:yellow;" colspan="3"><i>Grand Total :</i></td>
			<td style="background-color:grey;color:yellow;">'.$grand_total_Naira.'</td>
		</tr>';
		$html1 .= '<tr >
			<td colspan="5"></td>
		</tr>';
	}
	$html  = '<table border="1" cellpadding="1" width="100%">'.$html1.'</table>';
	// output the HTML content
	$pdf->writeHTML($html, true, false, false, false, '');
}


$pdf->Output('All_Goods_Delivered_Slip.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

