<?php 
define('BASEPATH','jbremittancehome');
session_start();
include '../jbpe_settings/domainsettings.php';
include '../jbpe_classes/class_call.php';

$DataSecurity = new DataEncSecurity;
require('../fpdf/fpdf.php');
include '../jbpe_dbconn/dbmycon.php';
include '../loginfail.php';


						
$br_code = $_SESSION['userjblocat'];
$loginuserid = $_SESSION['userjbremtt'];
$branchName = $_SESSION['userbranchname'];

if (isset($commandArray[0])) $petxn_id=$commandArray[0];
//if (isset($commandArray[3])) $req_date=$commandArray[3];
//if (isset($commandArray[4])) $Process_date=$commandArray[4];

$where='';
//$sql_f_date=date("Y-m-d",strtotime($f_date));
//$sql_to_date=date("Y-m-d",strtotime($to_date));


 
 
 /*******************Branch Name And Zone Name**********************//////////////////
 		  
	$sql_branch="SELECT  dbjbwebremitt.dbo.Branch.BranchName, dbjbwebremitt.dbo.Zone.ZoneName, dbjbwebremitt.dbo.Branch.Address, dbjbwebremitt.dbo.Branch.DistCode
				 FROM    dbjbwebremitt.dbo.Zone INNER JOIN
                         dbjbwebremitt.dbo.Branch ON dbjbwebremitt.dbo.Zone.ZoneID = dbjbwebremitt.dbo.Branch.ZoneID
				 WHERE   (dbjbwebremitt.dbo.Branch.BranchCode = $br_code)";
			  
	  
  $result_branch_Name=sqlsrv_query($conn,$sql_branch);
  $row_branch_name=sqlsrv_fetch_array($result_branch_Name);
  $GLOBALS['branchName']=$row_branch_name['BranchName'];
  $GLOBALS['zoneName']=$row_branch_name['ZoneName'];
  $GLOBALS['districtName']=$row_branch_name['DistCode'];
  $GLOBALS['address']=$row_branch_name['Address'];
 
  $sql_passport="SELECT dbo.tblTMData.PASSPORT_NO, dbo.tblTMData.APPLICANT_NAME, dbo.tblCurrencyList.CURRENCY_ABBR, dbo.tblTMData.SFC_BANK,
						dbo.tblTMData.AMOUNT_IN_BDT,dbo.tblTMData.CONTACT_NO, dbo.tblTMData.BANK_REFERENCE, dbo.tblCountryList.COUNTRY_NAME,
						dbo.tblTMData.CURRENCY_CODE,
						dbo.tblTMData.CERTIFICATE_DOWLOAD_STATUS
				FROM    dbo.tblTMData INNER JOIN
                        dbo.tblCurrencyList ON dbo.tblTMData.CURRENCY_CODE = dbo.tblCurrencyList.CURRENCY_CODE INNER JOIN
                        dbo.tblCountryList ON dbo.tblTMData.COUNTRY_CODE = dbo.tblCountryList.COUNTRY_CODE
			  WHERE   (dbo.tblTMData.PE_TXN_ID ='".$petxn_id."'and dbo.tblTMData.TM_DATE=CONVERT(date,GETDATE()))";
	  
  $result_passport=sqlsrv_query($conn,$sql_passport);
  $row_passport=sqlsrv_fetch_array($result_passport);
  $passport_no=$row_passport['PASSPORT_NO'];
  $name=$row_passport['APPLICANT_NAME'];
  $remittance=$row_passport['SFC_BANK'];
  $amount_BDT=$row_passport['AMOUNT_IN_BDT'];
  $reference=$row_passport['BANK_REFERENCE'];
  $currency_name=$row_passport['CURRENCY_ABBR'];
  $country_name=$row_passport['COUNTRY_NAME'];
  $currency_code=$row_passport['CURRENCY_CODE'];
  $certificate_download_status=$row_passport['CERTIFICATE_DOWLOAD_STATUS'];
  //echo $passport_no;
  
  $sql_fc_rate="SELECT [Rate] FROM [dbjbPassportEndorse].[dbo].[ExchangeRate]
					UNPIVOT
					([Rate]
					FOR [ISO] IN (USD, CAD ,GBP,AUD,MYR,SGD,SAR,JPY,EUR,KWD,AED))AS UPE
					WHERE [ISO]=(SELECT [ISO]
				    FROM [dbjbPassportEndorse].[dbo].[tblCurrencyList]
				    Where [CURRENCY_CODE]='".$currency_code."')and [DATE]=CONVERT(date,GETDATE())";
  
  $result_fc_rate=sqlsrv_query($conn,$sql_fc_rate);
  $row_fc_rate=sqlsrv_fetch_array($result_fc_rate);
  $fc_rate=$row_fc_rate['Rate'];
  
  
class PDF extends FPDF
{
//Page header
function Header()
{ 
	
}

//Page footer
function Footer()
{
	$this->SetY(-14);
    // Select Arial italic 8
    $this->SetFont('Arial','I',8);
	$this->Cell(120,5,'Print Time : ' . date("d M Y g:i:s a",time()),0,0,'R');
 }
}

$leftmrg_initial=20;
$leftmrg=$leftmrg_initial;
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetY(30);
$pdf->SetX($leftmrg);
$pdf->SetFont('Arial','B',9);
$r=1;
$n=0;
$pdf->Ln(10);	
$ypos= $pdf->GetY();
/* $pdf->Image('../images/logo.jpg',15,$ypos,10,8);
	$pdf->SetFont('Arial','B',10);
	$leftmrg=$leftmrg + 12;
	$pdf->SetX($leftmrg);
	$pdf->Cell(40,5,'JANATA BANK LTD',0,0,'L'); */
	/* $leftmrg=$leftmrg + 90;
	$pdf->SetX($leftmrg);	
	$pdf->SetFont('Arial','',8);
	//$pdf->Cell(88,5,'Print Time : ' . date("d M Y g:i:s a",time()),0,0,'R'); */
 	$pdf->Ln(5);	
	$leftmrg=$leftmrg_initial;
	$leftmrg=$leftmrg + 12;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
	//$pdf->Cell(140,5,$userbranchname,0,0,'L');
	
$pdf->Ln(10);	
$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
   	$pdf->SetFont('Times','',12);
	$pdf->Cell(100,5,'REF:'.$reference,0,0,'L');
	$pdf->Cell(75,5,'Date: ' . date("d M Y"),0,0,'R');
$pdf->Ln(35);	
$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
   	$pdf->SetFont('Times','U',15);
	$pdf->Cell(180,5,'TO WHOM IT MAY CONCERN',0,0,'C');


	

	//$pdf->ShadowCell($pdf->GetPageWidth(),50,'Hello World!', 1, 0, 'C', true);

	

	
$pdf->Ln(10);	
$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
   	$pdf->SetFont('Times','',13);
	$pdf->MultiCell(175,5,'This is to certifity that we have sold cash '.$currency_name.' '.$remittance.'('.$basicClass->convert_number($remittance).') in favour of '.$name .' bearing passport no. '  .$passport_no . ' to visit to '  .$country_name . '. We have endorsed the same in the passport.',0,'J');

$pdf->Ln(20);	
$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
   	$pdf->SetFont('Times','U',14);
	$pdf->Cell(180,5,'Currency Information',0,0,'C');	
	
$pdf->Ln(15);	
$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
   	$pdf->SetFont('Times','',13);
	$pdf->Cell(40,5,'Transaction Type',1,0,'C');
	$pdf->Cell(35,5,'Currency',1,0,'C');	
	$pdf->Cell(30,5,'Amount',1,0,'C');	
	$pdf->Cell(30,5,'Rate',1,0,'C');
	$pdf->Cell(40,5,'Amount in BDT',1,0,'C');	
	
$pdf->Ln(5);		
$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
   	$pdf->SetFont('Times','',13);
	$pdf->Cell(40,5,'SALE',1,0,'C');
	$pdf->Cell(35,5,$currency_name,1,0,'C');
	$pdf->Cell(30,5,$remittance,1,0,'C'); 
	$pdf->Cell(30,5,$fc_rate,1,0,'C');
	$pdf->Cell(40,5,$amount_BDT,1,0,'C');
$pdf->Ln(5);		
$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
   	$pdf->SetFont('Times','',13);
	$pdf->Cell(40,5,'--',1,0,'C');
	$pdf->Cell(35,5,'--',1,0,'C'); 
	$pdf->Cell(30,5,'--',1,0,'C'); 
	$pdf->Cell(30,5,'Total',1,0,'C');
	$pdf->Cell(40,5,$amount_BDT,1,0,'C');	
	
$pdf->Ln(5);		
$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
   	$pdf->SetFont('Times','',13);
	$pdf->Cell(175,5,'In Word : Taka ' .$basicClass->convert_number($amount_BDT).' Only.',1,0,'C');
	
	
$pdf->Ln(35);	
$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
   	$pdf->SetFont('Times','',13);
	$pdf->Cell(180,5,'For Janata Bank Limited',0,0,'C');
$pdf->Ln(5);	
$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
   	$pdf->SetFont('Times','',13);
	//$pdf->Cell(180,5,$branchName .' Dhaka',0,0,'C');
	$pdf->Cell(180,5,$branchName.', '.$GLOBALS['districtName'],0,0,'C');
$pdf->Ln(45);	
$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
   	$pdf->SetFont('Times','U',13);
	$pdf->Cell(80,5,'Officer',0,0,'C');
	$pdf->Cell(80,5,'Manager/ In-charge',0,0,'C');
	
	if($certificate_download_status == 'D'){
		$pdf->SetFont('Arial','B',35);
	    //$pdf->SetTextColor(255,192,203);
	    $pdf->SetTextColor(255,200,203);
		$pdf->RotatedText(65,180,'DUPLICATE COPY',35);
	}
	

$pdf->Output();
//sqlsrv_free_stmt($result_form2);
//sqlsrv_free_stmt($result_form);
//sqlsrv_free_stmt($row_branch_name);
sqlsrv_close($conn);
?>