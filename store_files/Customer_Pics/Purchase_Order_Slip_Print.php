<?php
require_once('tcpdf_include.php');
session_start();
require_once '../settings/connection.php';
require_once '../settings/filter.php';
require_once '../settings/site_root_config.php';
$root = my_site_root();
$user_name = $profile_Pics =$email=$state=$local_gov=$phone_no =$phone_no =$dateprint =$perm_address=$contact_address=$id_count=$total_amount_summary="";


if (!isset($_SESSION['user_full_name']))
{
	header("location: ../exam_logout.php");
}
if (!isset($_GET['former_trans_code']))
{
	header("location: ../exam_logout.php");
}

//MAKE SURE THE USER TRYING TO PRINT THE SLIP IS THE ACTUALL OWNER
//$stmt = $conn->prepare("SELECT product_name,price, product_id FROM store_goods where product_id=? Limit 1");

$stmt = $conn->prepare("SELECT user_id, trans_code FROM cart_stock where trans_code=?  AND user_id=?");
$stmt->execute(array($_GET['former_trans_code'],$_SESSION['user_identity']));
$affected_rows = $stmt->rowCount();
if($affected_rows >= 1) 
{
	
}else{
	header("location: ../exam_logout.php");
}
		//RETRIEVE USER DETAILS
		$stmt = $conn->prepare("SELECT email,full_name,u_photo,state,local_gov,phone_no,perm_address,contact_address FROM customers_details where email=? Limit 1");
		$stmt->execute(array($_SESSION['user_email']));
		$affected_rows = $stmt->rowCount();
		if($affected_rows == 1) 
		{
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($row['u_photo'] !=""){
				$profile_Pics ="Customer_Pics/".$row['u_photo'];
			}
			$user_name =$row['full_name'];$email=$row['email'];$state=$row['state'];$local_gov=$row['local_gov'];$phone_no =$row['phone_no'];
			$perm_address=$row['perm_address'];$contact_address=$row['contact_address'];			
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
       <td align="center"  style="font-size:10;font-weight:bold;color:black">CUSTOMER RECEIVE PURCHASE ORDER SLIP</td>
    </tr>

</table>';
$pdf->writeHTML($html, true, false, true, false, '');

// -----------------------PERSONALINFORMATION HEADER TABLE----------------------------------
$html ='<hr>
	<table cellspacing="0" cellpadding="1" border="0" align="center">
		<tr style="bottom-border:1 solid;">
			<td align="center" style="font-size:10;font-weight:bold;color:brown">PURCHASE ORDER SLIP - ORDER CODE : '.$_GET['former_trans_code'].'</td>
		</tr>
	</table>
<hr>';
$pdf->writeHTML($html, true, false, false, false, '');

$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
        <td align="Left" style="font-size:8;font-weight:bold;color:brown">CUSTOMERS INFORMATION DETAILS</td> 
		<td  align="Right" style="font-size:8;">'.$dateprint.'</td> 
    </tr>
</table><hr>';

$pdf->writeHTML($html, true, false, false, false, '');


//PERSONAL INFO DETAILS
//$user_name = $profile_Pics =$email=$state=$local_gov=$phone_no =$phone_no =$dateprint =$perm_address=$contact_address="";
$html = '<table cellspacing="0" cellpadding="1" border="0" align="center" style="font-size:8;color:black">
	<tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  style="font-size:8;">Customer Name :</td>
		<td align="Left"  style="font-size:8;">'.$user_name.'</td>
		<td align="Center" rowspan="6" style="font-size:8;"><img width="100" height="100" border="0" src="'.$profile_Pics.'"/></td>
    </tr>
	
    <tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  style="font-size:8;">Email_Address :</td>
		<td align="Left" colspan="2" style="font-size:8;">'.$email.'</td>
	</tr>
	
    <tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  style="font-size:8;">Phone N<u>o</u>:</td>
		<td align="Left" colspan="2" style="font-size:8;">'.$phone_no.'</td>
	</tr>
	
    <tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  style="font-size:8;">State / Local Govt :</td>
		<td align="Left" colspan="2" style="font-size:8;">'.$state.' / '.$local_gov.'</td>
	</tr>
	
    <tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
	
	<tr width="400">
		<td align="Right"  style="font-size:8;">Perm. / Cont. Address :</td>
		<td align="Left"  colspan="2" style="font-size:8;">'.$perm_address.' / '.$contact_address.'</td>
	</tr>
	<tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
  </table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
        <td align="Left" style="font-size:8;font-weight:bold;color:brown">GOODS DETAILS LIST</td> 
    </tr>
</table><hr>';

$pdf->writeHTML($html, true, false, false, false, '');

// -----------PERSONALINFORMATION GOODS DETAIL TABLE----------------------------------------------
$pdf->SetAlpha(0.3);
$img_file = K_PATH_IMAGES.'image_demo.jpg';
$pdf->Image($img_file, 55, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAlpha(1);

$html1 ="";
$stmt = $conn->prepare("SELECT user_id, goods_code,status,quantity,amount,product_name FROM cart_stock where user_id=?  AND trans_code=?");
$stmt->execute(array($_SESSION['user_email'],$_GET['former_trans_code']));
if ($stmt->rowCount () >= 1)
{
	 $html1 .= '<tr width="400">
			<td width="60">S/N<u>o</u></td>
			<td width="200">Item_Name </td>
			<td >Price</td>
			<td width="80">Quantity</td>
			<td >Amount</td>
			<td >Remarks(R / N)</td>
		</tr>';
		$id=1;
		$Amount_total=0;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
		{
			
			$Product_Name = $row['product_name'];
			
			$Price = number_format($row['amount'], 2);
			$Price_Naira = " &#8358; ".$Price;
			
			$Quantity = $row['quantity'];
			
			$Amount = $row['amount'] * $Quantity;
			$Amount_display = number_format($Amount, 2);
			$Amount_Naira =" &#8358; ".$Amount_display;
			
			//the total Amount
			$Amount_total = $Amount_total + $Amount;
			
			$html1 .= '<tr width="400" >
							<td>'.$id.'</td>
							<td>'.$Product_Name.'</td>
							<td>'.$Price_Naira.'</td>
							<td>'.$Quantity.'</td>
							<td>'.$Amount_Naira.'</td>
							<td></td>
						</tr>
						<tr width="400">
							<td align="Center" colspan ="6" style="font-size:8;"><hr></td>
						</tr>';
						$id = $id + 1;
		}
		
		$Amount_total_display = number_format($Amount_total, 2);
		$Amount_total_Naira =" &#8358; ".$Amount_total_display;
		$id_count=$id - 1;
		$total_amount_summary=$Amount_total_Naira;
		$html  = '<table border="1" cellpadding="1">'.$html1.'
		<tr>
			<td style="text-align:right;color:blue" colspan="4">Total Amount :</td>
			<td style="text-align:left;" colspan="2">'.$Amount_total_Naira.'</td>
		</tr></table>';
		// output the HTML content
		$pdf->writeHTML($html, true, false, false, false, '');
}

//SUMMARY AND REMARKS BEGINS
$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
        <td align="Left" style="font-size:8;font-weight:bold;color:brown">DEALLER AND CUSTOMER SUMMARY / REMARKS</td> 
    </tr>
</table><hr>';

$pdf->writeHTML($html, true, false, false, false, '');

$html = '<table cellspacing="0" cellpadding="1" border="1" align="center" style="font-size:8;color:black">
	<tr width="400">
        <td align="Center" colspan ="4" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  style="font-size:8;">N<u>o</u> of Item Request :</td>
		<td align="Left"  style="font-size:8;">'.$id_count.'</td>
		<td align="Right"  style="font-size:8;">N<u>o</u> of Item Receive :</td>
		<td align="Left"  style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  style="font-size:8;">Total Amount of Item Request :</td>
		<td align="Left"  style="font-size:8;">'.$total_amount_summary.'</td>
		<td align="Right"  style="font-size:8;">Total Amount of Item Receive :</td>
		<td align="Left"  style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  style="font-size:8;">Balance of Total Amount :</td>
		<td align="Left"  style="font-size:8;"></td>
		<td align="Left"  style="font-size:8;">List S/N<u>o</u> of item Not Received:</td>
		<td align="Left"  style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Left"  style="font-size:8;">Detail Address Of Transaction Venue :</td>
		<td align="Left" colspan ="3" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Center" colspan ="4" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  width="100" style="font-size:8;">Customer Name :</td>
		<td align="Left" width="220"  style="font-size:8;"></td>
		<td align="Right"  width="100" style="font-size:8;">Sign/Date :</td>
		<td align="Left"  width="220" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  width="100" style="font-size:8;">Dealler Name :</td>
		<td align="Left"  width="220" style="font-size:8;"></td>
		<td align="Right" width="100" style="font-size:8;">Sign/Date :</td>
		<td align="Left" width="220" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Center" colspan ="4" style="font-size:8;"></td>
    </tr>
  </table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
	



//#####################################/
//####################################//
//####################################//
/******  SECOND PAGE CONTINUE  ******/
//####################################//
//####################################//
//####################################//




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
       <td align="center"  style="font-size:10;font-weight:bold;color:black">DEALLER DELIVERY ORDER SLIP (COPY)</td>
    </tr>

</table>';
$pdf->writeHTML($html, true, false, true, false, '');

// -----------------------PERSONALINFORMATION HEADER TABLE----------------------------------
$html ='<hr>
	<table cellspacing="0" cellpadding="1" border="0" align="center">
		<tr style="bottom-border:1 solid;">
			<td align="center" style="font-size:10;font-weight:bold;color:brown">PURCHASE ORDER SLIP - ORDER CODE : '.$_GET['former_trans_code'].'</td>
		</tr>
	</table>
<hr>';
$pdf->writeHTML($html, true, false, false, false, '');

$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
        <td align="Left" style="font-size:8;font-weight:bold;color:brown">CUSTOMERS INFORMATION DETAILS</td> 
		<td  align="Right" style="font-size:8;">'.$dateprint.'</td> 
    </tr>
</table><hr>';

$pdf->writeHTML($html, true, false, false, false, '');


//PERSONAL INFO DETAILS
//$user_name = $profile_Pics =$email=$state=$local_gov=$phone_no =$phone_no =$dateprint =$perm_address=$contact_address="";
$html = '<table cellspacing="0" cellpadding="1" border="0" align="center" style="font-size:8;color:black">
	<tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  style="font-size:8;">Customer Name :</td>
		<td align="Left"  style="font-size:8;">'.$user_name.'</td>
		<td align="Center" rowspan="6" style="font-size:8;"><img width="100" height="100" border="0" src="'.$profile_Pics.'"/></td>
    </tr>
	
    <tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  style="font-size:8;">Email_Address :</td>
		<td align="Left" colspan="2" style="font-size:8;">'.$email.'</td>
	</tr>
	
    <tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  style="font-size:8;">Phone N<u>o</u>:</td>
		<td align="Left" colspan="2" style="font-size:8;">'.$phone_no.'</td>
	</tr>
	
    <tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  style="font-size:8;">State / Local Govt :</td>
		<td align="Left" colspan="2" style="font-size:8;">'.$state.' / '.$local_gov.'</td>
	</tr>
	
    <tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
	
	<tr width="400">
		<td align="Right"  style="font-size:8;">Perm. / Cont. Address :</td>
		<td align="Left"  colspan="2" style="font-size:8;">'.$perm_address.' / '.$contact_address.'</td>
	</tr>
	<tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
  </table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
        <td align="Left" style="font-size:8;font-weight:bold;color:brown">GOODS DETAILS LIST</td> 
    </tr>
</table><hr>';

$pdf->writeHTML($html, true, false, false, false, '');

// -----------PERSONALINFORMATION GOODS DETAIL TABLE----------------------------------------------
$pdf->SetAlpha(0.3);
$img_file = K_PATH_IMAGES.'image_demo.jpg';
$pdf->Image($img_file, 55, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAlpha(1);

$html1 ="";
$stmt = $conn->prepare("SELECT user_id, goods_code,status,quantity,amount,product_name FROM cart_stock where user_id=?  AND trans_code=?");
$stmt->execute(array($_SESSION['user_email'],$_GET['former_trans_code']));
if ($stmt->rowCount () >= 1)
{
	 $html1 .= '<tr width="400">
			<td width="60">S/N<u>o</u></td>
			<td width="200">Item_Name </td>
			<td >Price</td>
			<td width="80">Quantity</td>
			<td >Amount</td>
			<td >Remarks(R / N)</td>
		</tr>';
		$id=1;
		$Amount_total=0;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
		{
			
			$Product_Name = $row['product_name'];
			
			$Price = number_format($row['amount'], 2);
			$Price_Naira = " &#8358; ".$Price;
			
			$Quantity = $row['quantity'];
			
			$Amount = $row['amount'] * $Quantity;
			$Amount_display = number_format($Amount, 2);
			$Amount_Naira =" &#8358; ".$Amount_display;
			
			//the total Amount
			$Amount_total = $Amount_total + $Amount;
			
			$html1 .= '<tr width="400" >
							<td>'.$id.'</td>
							<td>'.$Product_Name.'</td>
							<td>'.$Price_Naira.'</td>
							<td>'.$Quantity.'</td>
							<td>'.$Amount_Naira.'</td>
							<td></td>
						</tr>
						<tr width="400">
							<td align="Center" colspan ="6" style="font-size:8;"><hr></td>
						</tr>';
						$id = $id + 1;
		}
		
		$Amount_total_display = number_format($Amount_total, 2);
		$Amount_total_Naira =" &#8358; ".$Amount_total_display;
		$id_count=$id - 1;
		$total_amount_summary=$Amount_total_Naira;
		$html  = '<table border="1" cellpadding="1">'.$html1.'
		<tr>
			<td style="text-align:right;color:blue" colspan="4">Total Amount :</td>
			<td style="text-align:left;" colspan="2">'.$Amount_total_Naira.'</td>
		</tr></table>';
		// output the HTML content
		$pdf->writeHTML($html, true, false, false, false, '');
}

//SUMMARY AND REMARKS BEGINS
$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
        <td align="Left" style="font-size:8;font-weight:bold;color:brown">DEALLER AND CUSTOMER SUMMARY / REMARKS</td> 
    </tr>
</table><hr>';

$pdf->writeHTML($html, true, false, false, false, '');

$html = '<table cellspacing="0" cellpadding="1" border="1" align="center" style="font-size:8;color:black">
	<tr width="400">
        <td align="Center" colspan ="4" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  style="font-size:8;">N<u>o</u> of Item Request :</td>
		<td align="Left"  style="font-size:8;">'.$id_count.'</td>
		<td align="Right"  style="font-size:8;">N<u>o</u> of Item Receive :</td>
		<td align="Left"  style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  style="font-size:8;">Total Amount of Item Request :</td>
		<td align="Left"  style="font-size:8;">'.$total_amount_summary.'</td>
		<td align="Right"  style="font-size:8;">Total Amount of Item Receive :</td>
		<td align="Left"  style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  style="font-size:8;">Balance of Total Amount :</td>
		<td align="Left"  style="font-size:8;"></td>
		<td align="Left"  style="font-size:8;">List S/N<u>o</u> of item Not Received:</td>
		<td align="Left"  style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Left"  style="font-size:8;">Detail Address Of Transaction Venue :</td>
		<td align="Left" colspan ="3" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Center" colspan ="4" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  width="100" style="font-size:8;">Customer Name :</td>
		<td align="Left" width="220"  style="font-size:8;"></td>
		<td align="Right"  width="100" style="font-size:8;">Sign/Date :</td>
		<td align="Left"  width="220" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Right"  width="100" style="font-size:8;">Dealler Name :</td>
		<td align="Left"  width="220" style="font-size:8;"></td>
		<td align="Right" width="100" style="font-size:8;">Sign/Date :</td>
		<td align="Left" width="220" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="Center" colspan ="4" style="font-size:8;"></td>
    </tr>
  </table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


//update the Availlable Goods ..SO It wont reload as items not yet booked for....
$stmt = $conn->prepare("UPDATE cart_stock SET status = ? WHERE user_id=? And trans_code=?");
$stmt->execute(array("1",$_SESSION['user_identity'],$_SESSION['former_trans_code']));
$affected_rows = $stmt->rowCount();





$pdf->Output($user_name.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

