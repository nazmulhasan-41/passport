<?php define('BASEPATH','jbvoucher');
session_start();
include '../jr_settings/domainsettings.php';
include '../jr_dbconn/dbmycon.php';
include '../jr_classes/clsbasics.php';
$basicClass= new Basics;
include '../jr_classes/clsdatasecurity.php';
$DataSecurity = new DataEncSecurity;
require('../fpdf/fpdf.php');
include '../loginfail.php';
$resbrcode = $_SESSION['userjblocat'];
//$advicekey=$commandArray[1];

$advicearray = '';
if (empty($commandArray[1])) {

	if(!empty($_POST['chkconfirm'])){
	foreach($_POST['chkconfirm'] as $selected){
	$advicearray.= $selected . ',';
	}
	}
	$voucherdate = $_POST['txtdate'];
	if (date('Y-m-d',strtotime($voucherdate)) < date('Y-m-d',strtotime($currsoftdate)))  {
	$tbluse = 'B';
	} else {
	$tbluse = 'A';
	}

} else {
$advicearray=$commandArray[1];
$tbluse=$commandArray[2];
}

$advicetype='';
$src_sequence_id='';
class PDF extends FPDF
{
//Page header
function Header()
{
// report header from database
//$sqlExchange="select * from tblbasics";
//$resultExchange=sqlsrv_query($conn,$sqlExchange);
//$rowExchange=sqlsrv_fetch_array($resultExchange);

	//Logo Image(file,left,top,width,height)
//	$this->Image('../jbremitthome/images/logo.jpg',15,11,10,8);
/*     $this->Image('../jbremitthome/images/logo.jpg',50,11,12,8);
    $this->SetFont('Arial','B',16);
    $this->Cell(180,10,$rowExchange['firmName'],0,0,'C');
	$this->Ln(5);
    $this->SetFont('Arial','B',11);
    $this->Cell(180,10,$rowHeader['LocationName'],0,0,'C');
	$this->SetX(140);
    $this->SetFont('Arial','B',8);
	$this->Cell(50,10,'Print Date : '.date("d-m-Y g:i a",time()),0,0,'R');    
	$this->Ln(7);
    $this->SetFont('Arial','B',8);
	$this->Cell(65);
    $this->Cell(50,4,$rowHeader['Address'],0,0,'C');
    //Line break
    $this->Ln(4);
 */}

//Page footer
function Footer()
{
    //Position at 1.5 cm from bottom
/*     $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
 */
 }

}



$leftmrg_initial=14;
$leftmrg=$leftmrg_initial;
$pdf=new PDF();
$pdf->AliasNbPages();



$pdf->AddPage();
$pdf->SetY(20);
$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
$r=1;
$n=0;
$sql_advice ='';

//================
	list($advicearray) = array(split('[,]', $advicearray)); 
	for($x = 0; $x < count($advicearray); $x++) {	
	$sql_advice="exec proc_local_res_voucher '$resbrcode','$advicearray[$x]','$tbluse'";
	$advicekey=trim($advicearray[$x]);
//================
//$sql_advice="exec proc_local_res_voucher '$resbrcode','$advicekey','$tbluse'";
//echo $sql_advice;

$result_advice=sqlsrv_query($conn,$sql_advice);
while ($row_advice=sqlsrv_fetch_array($result_advice)) {

		$deposite_cheque = $row_advice['deposite_cheque'];

	if ($n==2) {
	$pdf->AddPage();
	$pdf->SetY(20);
	$n=0;
	}
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
    $ypos= $pdf->GetY();
	//Logo Image(file,left,top,width,height)
	//$pdf->Image('../images/logo.jpg',14,$ypos + 4,12,8);
	$pdf->Image('../jbremitthome/images/logo.jpg',15,$ypos,10,8);
	$pdf->SetFont('Arial','B',10);
	$leftmrg=$leftmrg + 12;
	$pdf->SetX($leftmrg);
	$pdf->Cell(40,5,'JANATA BANK LTD',0,0,'L');
	$leftmrg=$leftmrg + 90;
	$pdf->SetX($leftmrg);	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(88,5,'Print Time : ' . date("d M Y g:i:s a",time()),0,0,'R');
 	$pdf->Ln(5);	
	$leftmrg=$leftmrg_initial;
	$leftmrg=$leftmrg + 12;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(140,5,$userbranchname,0,0,'L');
	$leftmrg=$leftmrg + 145;
	$pdf->SetX($leftmrg);	
	$pdf->Cell(30,5,'RESPONDING',1,0,'C');

	if ($row_advice['res_dwn_status']=='D') {
	$pdf->SetFont('Arial','B',30);
    $pdf->SetTextColor(255,192,203);
	$pdf->RotatedText(35,120,'DUPLICATE VOUCHER',45);
 	} 
	$pdf->Ln(5);	
	$leftmrg=$leftmrg_initial;
	$leftmrg=$leftmrg + 12;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
    $pdf->SetTextColor(0,0,0);
	$pdf->Cell(140,5,'',0,0,'L');
 	$pdf->Ln(5);	
    $ypos= $pdf->GetY() ;
	$pdf->Line(204,$ypos,13,$ypos);
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
   	$pdf->SetFont('Arial','B',9);
	if ($row_advice['cibta']=='C') {
	$pdf->Cell(30,5,'Debit: CIBTA '.$row_advice['BranchName'].'('.$row_advice['org_brcode'].') Zone: '.$row_advice['ZoneName'].'('.$row_advice['ZoneCode'].')',0,0,'L');
	} else if ($row_advice['cibta']=='D') {
	$pdf->Cell(30,5,'Credit: CIBTA '.$row_advice['BranchName'].'('.$row_advice['org_brcode'].') Zone: '.$row_advice['ZoneName'].'('.$row_advice['ZoneCode'].')',0,0,'L');
	} 	
	$leftmrg=$leftmrg + 140;
	$pdf->SetX($leftmrg);
	$pdf->Cell(50,5,'Advice No: '.$row_advice['adviceno'],0,0,'R');
	$advice_no=$row_advice['adviceno'];
 	$pdf->Ln();	
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	$pdf->Cell(60,5,'Originating Date: '.date_format($row_advice['org_date'],"d/m/Y"),0,0,'L');
	$leftmrg=$leftmrg + 60;
	$pdf->SetX($leftmrg);
	$pdf->Cell(60,5,'Tr. Code: '.$row_advice['advice_type'],0,0,'C');
	$leftmrg=$leftmrg + 80;
	$pdf->SetX($leftmrg);
	$pdf->Cell(50,5,'Voucher Date: '.date_format($row_advice['res_date'],"d/m/Y"),0,0,'R');
	$respond_date=date_format($row_advice['res_date'],"d/m/Y");
 	$pdf->Ln(7);		
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
   	$pdf->SetFont('Arial','',10);
	$pdf->Cell(140,5,'Description',1,0,'L');
	$leftmrg=$leftmrg + 140;
	$pdf->SetX($leftmrg);
	$pdf->Cell(50,5,'Amount',1,0,'R');
 	$pdf->Ln();	
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	$pdf->Cell(140,40,'',1,0,'R');
	$leftmrg=$leftmrg + 140;
	$pdf->SetX($leftmrg);
	$pdf->Cell(50,40,'',1,0,'R');
 	$pdf->Ln();	
	$ypos=$pdf->GetY()+5;
	$leftmrg=$leftmrg_initial;
	$pdf->SetXY($leftmrg,$ypos-40);
	$pdf->SetFont('Arial','',12);
	if ($row_advice['advice_type']=='01') {
	$pdf->MultiCell(140,5,'Being the Amount received from above branch in favour of '.$row_advice['beneficiaryname'].' and Instrument No : '.$row_advice['instrumentno'].' TEST No '.$row_advice['org_test_key'].' '.$row_advice['particulars'].'',0,'L');
	} else if ($row_advice['advice_type']=='02') {
	$pdf->MultiCell(140,5,'Being the Amount received from above branch in favour of '.$row_advice['beneficiaryname'].' A/C No '.$row_advice['beneficiaryaccount'].' and Instrument No : '.$row_advice['instrumentno'].' TEST No '.$row_advice['org_test_key'].' '.$row_advice['particulars'].'',0,'L');
	} else if ($row_advice['advice_type']=='03') {
	$pdf->MultiCell(140,5,'Being the Amount received from above branch in favour of '.$row_advice['beneficiaryname'].' A/C No '.$row_advice['beneficiaryaccount'].' and Instrument No : '.$row_advice['instrumentno'].' TEST No '.$row_advice['org_test_key'].' '.$row_advice['particulars'].'',0,'L');
	} else if ($row_advice['advice_type']=='05') {
	$pdf->MultiCell(140,5,'Being the Amount received from above branch in favour of '.$row_advice['beneficiaryname'].' '.$row_advice['particulars'].'',0,'L');
	} else if ($row_advice['advice_type']=='08')  {
	$pdf->MultiCell(140,5,'Being the Amount received from above branch in favour of '.$row_advice['beneficiaryname'].' by our OBC No: '.$row_advice['instrumentno'].' TEST No '.$row_advice['org_test_key'].' for '.$row_advice['particulars'].'',0,'L');
	} else if ($row_advice['advice_type']=='14')  {
	$pdf->MultiCell(140,5,'Being the Amount received from above branch in favour of '.$row_advice['beneficiaryname'].' TEST No '.$row_advice['org_test_key'].' for '.$row_advice['particulars'].'',0,'L');
	} else if (($row_advice['advice_type']=='09') || ($row_advice['advice_type']=='12')) {
	$pdf->MultiCell(140,5,'Being the Amount received from above branch in favour of '.$row_advice['beneficiaryname'].' '.$row_advice['particulars'].'',0,'L');
	} else if ($row_advice['advice_type']=='15') {
	$pdf->MultiCell(140,5,'Being the Amount Debited by above branch against '.$row_advice['beneficiaryname'].' '.$row_advice['particulars'].'',0,'L');
	} else if (($row_advice['advice_type']=='18') && ($row_advice['deposite_cheque']=='D')) {
	$pdf->MultiCell(140,5,'Being the Amount received from above branch in favour of '.$row_advice['beneficiaryname'].' A/C No '.$row_advice['beneficiaryaccount'].' against Cash Deposit Slip No '.$row_advice['instrumentno'].' and deposited by '.$row_advice['particulars'],0,'L');
	} else if (($row_advice['advice_type']=='18') && ($row_advice['deposite_cheque']=='C')) { //Sundry Deposit A/C JB Cheque Payment
	$pdf->MultiCell(140,5,'Being the Amount received from above branch for JB Cheque Payment by debiting their Account Holder\'s A/C No '.$row_advice['beneficiaryaccount'].' Cheque No '.$row_advice['instrumentno'].' '.$row_advice['particulars'],0,'L');
	} else if (($row_advice['advice_type']=='19') && ($row_advice['deposite_cheque']=='D')) {
	$pdf->MultiCell(140,5,'Being the Amount received from above branch in favour of '.$row_advice['beneficiaryname'].' A/C No '.$row_advice['beneficiaryaccount'].' against Cash Deposit Slip No '.$row_advice['instrumentno'].' and deposited by '.$row_advice['particulars'],0,'L');
	} else if (($row_advice['advice_type']=='19') && ($row_advice['deposite_cheque']=='C')) {
	$pdf->MultiCell(140,5,'Being the Amount received from above branch for JB Cheque Payment for Crediting Our Account Holder\'s A/C No '.$row_advice['beneficiaryaccount'].' against their Cheque No '.$row_advice['instrumentno'].' '.$row_advice['particulars'],0,'L');
	} else if (($row_advice['advice_type']=='20') && ($row_advice['beneficiaryname']=='Sundry Deposit A/C JB PIN Cash Payment')) {
	$pdf->MultiCell(140,5,'Being the Amount received from above branch for JB PIN Cash Payment by debiting their Sundry Deposit A/C JB PIN Cash Payment '.$row_advice['particulars'],0,'L');
	} else if (($row_advice['advice_type']=='21') && ($row_advice['beneficiaryname']=='Sundry Deposit A/C Instant Cash Payment')) {
	$pdf->MultiCell(140,5,'Being the Amount received from above branch for Instant Cash Payment by debiting their Sundry Deposit A/C Instant Cash Payment '.$row_advice['particulars'],0,'L');
	} 
 if (!empty($row_advice['error_note'])) {
	$pdf->SetXY($leftmrg,$ypos-15);
	$pdf->SetFont('Arial','BI',10);
	$pdf->MultiCell(140,5,'Correction Note : '.$row_advice['error_note'],0,'L');
}

	$pdf->SetXY($leftmrg+140,$ypos-63);
	$pdf->Cell(50,50,$basicClass->moneyformat($row_advice['org_amount']),0,0,'R');
 	$pdf->Ln(63);	
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(190,5,'In Word : Taka ' .$basicClass->convert_number($row_advice['org_amount']).' Only.',0,'L');
 	$pdf->Ln(15);	
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(130,5,'Officer',0,0,'L');
	$leftmrg=$leftmrg + 130;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,5,'Manager',0,0,'L');
    $pdf->Ln(15);	
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(180,5,'Accepted By : '.$row_advice['firstuser'] . ' & Authorized By : '.$row_advice['seconduser'] ,0,0,'L');
	$pdf->Ln(7);	
$n++;
		
$r++;
//}
    $ypos= $pdf->GetY() + 15 ;
	//$pdf->Line(220,$ypos,2,$ypos);
	$pdf->Line(220,150,2,150);
	
 $pdf->Ln(20);	
// TT Information
	if ($n==2) {
	$pdf->AddPage();
	$n=0;
	}
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
    $ypos= $pdf->GetY();
	//Logo Image(file,left,top,width,height)
	//$pdf->Image('../images/logo.jpg',14,$ypos + 4,12,8);
	$pdf->Image('../jbremitthome/images/logo.jpg',15,$ypos,10,8);
	$pdf->SetFont('Arial','B',10);
	$leftmrg=$leftmrg + 12;
	$pdf->SetX($leftmrg);
	$pdf->Cell(40,5,'JANATA BANK LTD',0,0,'L');
	$leftmrg=$leftmrg + 40;
	$pdf->SetX($leftmrg);	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(138,5,'Print Time : ' . date("d M Y g:i:s a",time()),0,0,'R');
 	$pdf->Ln(5);	
	$leftmrg=$leftmrg_initial;
	$leftmrg=$leftmrg + 12;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(140,5,$userbranchname,0,0,'L');
	if ($row_advice['res_dwn_status']=='D') {
	$pdf->SetFont('Arial','B',30);
    $pdf->SetTextColor(255,192,203);
	$pdf->RotatedText(35,260,'DUPLICATE VOUCHER',45);
 	}
	$pdf->Ln(5);	
	$leftmrg=$leftmrg_initial;
	$leftmrg=$leftmrg + 12;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
    $pdf->SetTextColor(0,0,0);
	$pdf->Cell(140,5,'',0,0,'L');
 	$pdf->Ln(5);	
    $ypos= $pdf->GetY() ;
	$pdf->Line(204,$ypos,13,$ypos);
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
   	$pdf->SetFont('Arial','B',9);
	if ($row_advice['advice_type']=='01') {
	$pdf->Cell(30,5,'Credit: Bills Payable A/C DD Payable',0,0,'L');
	} else if (($row_advice['advice_type']=='02') || ($row_advice['advice_type']=='03') || ($row_advice['advice_type']=='19')) {
	$pdf->Cell(30,5,'Beneficiary: '.$row_advice['beneficiaryname'],0,0,'L');
	} else {
		if ($row_advice['cibta']=='C') {
		$pdf->Cell(30,5,'Credit: '.$row_advice['beneficiaryname'],0,0,'L');	
		} else if ($row_advice['cibta']=='D') {
		$pdf->Cell(30,5,'Debit: '.$row_advice['beneficiaryname'],0,0,'L');			
		}
	}
	$leftmrg=$leftmrg + 140;
	$pdf->SetX($leftmrg);
	if ($row_advice['cibta']=='C') {
	$pdf->Cell(50,5,'CREDIT VOUCHER',0,0,'R');
	} else if ($row_advice['cibta']=='D') {
	$pdf->Cell(50,5,'DEBIT VOUCHER',0,0,'R');
	}
 	$pdf->Ln();	
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	if (($row_advice['advice_type']=='02') || ($row_advice['advice_type']=='03') || ($row_advice['advice_type']=='19') || (($row_advice['advice_type']=='18') && ($row_advice['deposite_cheque']=='D'))) {
	$pdf->Cell(140,5,'A/C No: '.$row_advice['beneficiaryaccount'],0,0,'L');
	} else {
	$pdf->Cell(140,5,'',0,0,'L');	
	}
	$leftmrg=$leftmrg + 140;
	$pdf->SetX($leftmrg);
	$pdf->Cell(50,5,'Voucher Date: '.$respond_date,0,0,'R');
 	$pdf->Ln(7);	
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
   	$pdf->SetFont('Arial','',10);
	$pdf->Cell(140,5,'Description',1,0,'L');
	$leftmrg=$leftmrg + 140;
	$pdf->SetX($leftmrg);
	$pdf->Cell(50,5,'Amount',1,0,'R');
 	$pdf->Ln();	
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	$pdf->Cell(140,40,'',1,0,'R');
	$leftmrg=$leftmrg + 140;
	$pdf->SetX($leftmrg);
	$pdf->Cell(50,40,'',1,0,'R');
 	$pdf->Ln();	
	$ypos=$pdf->GetY()+5;
	$leftmrg=$leftmrg_initial;
	$pdf->SetXY($leftmrg,$ypos-40);
	$pdf->SetFont('Arial','',12);
	$advicetype = $row_advice['advice_type'];
	$src_sequence_id = $row_advice['src_sequence_id'];
	if ($row_advice['advice_type']=='01') {
	$pdf->MultiCell(140,5,'Being the amount responded by Advice No : '.$row_advice['adviceno'].' dated '.date_format($row_advice['org_date'],"d/m/Y").' from '.$row_advice['BranchName'].' against '.$row_advice['adv_code'].' No : '.$row_advice['instrumentno'].' and TEST No :'.$row_advice['org_test_key'] .' against Beneficiary '.$row_advice['beneficiaryname'],0,'L');
	} else if ($row_advice['advice_type']=='02') {
	$pdf->MultiCell(140,5,'Being the amount responded by Advice No : '.$row_advice['adviceno'].' dated '.date_format($row_advice['org_date'],"d/m/Y").' from '.$row_advice['BranchName'].' against '.$row_advice['adv_code'].' No : '.$row_advice['instrumentno'].' and TEST No :'.$row_advice['org_test_key'] .'',0,'L');
	} else if ($row_advice['advice_type']=='03') {
	$pdf->MultiCell(140,5,'Being the amount responded by Advice No : '.$row_advice['adviceno'].' dated '.date_format($row_advice['org_date'],"d/m/Y").' from '.$row_advice['BranchName'].' against '.$row_advice['adv_code'].' No : '.$row_advice['instrumentno'].' and TEST No :'.$row_advice['org_test_key'] .'',0,'L');
	} else if ($row_advice['advice_type']=='05') {
	$pdf->MultiCell(140,5,'Being the amount responded by Advice No : '.$row_advice['adviceno'].' dated '.date_format($row_advice['org_date'],"d/m/Y").' from '.$row_advice['BranchName'].'',0,'L');
	} else if ($row_advice['advice_type']=='08') {
	$pdf->MultiCell(140,5,'Being the amount responded by Advice No : '.$row_advice['adviceno'].' dated '.date_format($row_advice['org_date'],"d/m/Y").' from '.$row_advice['BranchName'].' for '.$row_advice['particulars'].' by our OBC No: '.$row_advice['instrumentno'].' TEST No :'.$row_advice['org_test_key'],0,'L');
	} else if ($row_advice['advice_type']=='14') {
	$pdf->MultiCell(140,5,'Being the amount responded by Advice No : '.$row_advice['adviceno'].' dated '.date_format($row_advice['org_date'],"d/m/Y").' from '.$row_advice['BranchName'].' for '.$row_advice['particulars'].' TEST No :'.$row_advice['org_test_key'],0,'L');
	} else if (($row_advice['advice_type']=='09') || ($row_advice['advice_type']=='12')) {
	$pdf->MultiCell(140,5,'Being the amount responded by Advice No : '.$row_advice['adviceno'].' dated '.date_format($row_advice['org_date'],"d/m/Y").' from '.$row_advice['BranchName'].' for '.$row_advice['particulars'],0,'L');
	} else if ($row_advice['advice_type']=='15') {
	$pdf->MultiCell(140,5,'Being the amount responded against above head by Advice No : '.$row_advice['adviceno'].' dated '.date_format($row_advice['org_date'],"d/m/Y").' from '.$row_advice['BranchName'].'',0,'L');
	} else if (($row_advice['advice_type']=='18')  && ($row_advice['deposite_cheque']=='D')) {
		$beneficiaryname = $row_advice['beneficiaryname'];
	$pdf->MultiCell(140,5,'Being the amount responded by Advice No : '.$row_advice['adviceno'].' dated '.date_format($row_advice['org_date'],"d/m/Y").' from '.$row_advice['BranchName'].' against Cash Deposit Slip No '.$row_advice['instrumentno'].' '.$row_advice['particulars'],0,'L');
	} else if (($row_advice['advice_type']=='19') && ($row_advice['deposite_cheque']=='D')) {
		$beneficiaryname = $row_advice['beneficiaryname'];
	$pdf->MultiCell(140,5,'Being the amount responded by Advice No : '.$row_advice['adviceno'].' dated '.date_format($row_advice['org_date'],"d/m/Y").' from '.$row_advice['BranchName'].' against Cash Deposit Slip No '.$row_advice['instrumentno'].' '.$row_advice['particulars'],0,'L');
	} else if (($row_advice['advice_type']=='18') && ($row_advice['deposite_cheque']=='C')) {
		$beneficiaryname = $row_advice['beneficiaryname'];
	$pdf->MultiCell(140,5,'Being the amount responded against above head by Advice No : '.$row_advice['adviceno'].' dated '.date_format($row_advice['org_date'],"d/m/Y").' from '.$row_advice['BranchName'].' for JB Cheque Payment of A/C No: '.$row_advice['beneficiaryaccount'].' Cheque No '.$row_advice['instrumentno'],0,'L');
	} else if (($row_advice['advice_type']=='19') && ($row_advice['deposite_cheque']=='C')) {
		$beneficiaryname = $row_advice['beneficiaryname'];
	$pdf->MultiCell(140,5,'Being the amount responded against above head by Advice No : '.$row_advice['adviceno'].' dated '.date_format($row_advice['org_date'],"d/m/Y").' from '.$row_advice['BranchName'].' for JB Cheque Payment Cheque No '.$row_advice['instrumentno'].' '. $row_advice['particulars'],0,'L');
	} else if (($row_advice['advice_type']=='20') && ($row_advice['beneficiaryname']=='Sundry Deposit A/C JB PIN Cash Payment')) {
	$pdf->MultiCell(140,5,'Being the Amount received from above branch for JB PIN Cash Payment by debiting their Sundry Deposit A/C JB PIN Cash Payment through Advice No '.$advice_no . ' Dated '.$respond_date.' '.$row_advice['particulars'],0,'L');
	} else if (($row_advice['advice_type']=='21') && ($row_advice['beneficiaryname']=='Sundry Deposit A/C Instant Cash Payment')) {
	$pdf->MultiCell(140,5,'Being the Amount received from above branch for Instant Cash Payment by debiting their Sundry Deposit A/C Instant Cash Payment through Advice No '.$advice_no . ' Dated '.$respond_date.' '.$row_advice['particulars'],0,'L');
	} 
 if (!empty($row_advice['error_note'])) {
	$pdf->SetXY($leftmrg,$ypos-15);
	$pdf->SetFont('Arial','BI',10);
	$pdf->MultiCell(140,5,'Correction Note : '.$row_advice['error_note'],0,'L');
}

	$pdf->SetXY($leftmrg+140,$ypos-63);
	$pdf->Cell(50,50,$basicClass->moneyformat($row_advice['org_amount']),0,0,'R');
 	$pdf->Ln(63);	
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','',10);
	$pdf->MultiCell(190,5,'In Word : Taka ' .$basicClass->convert_number($row_advice['org_amount']).' Only.',0,'L');
 	$pdf->Ln(15);	
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(130,5,'Officer',0,0,'L');
	$leftmrg=$leftmrg + 130;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,5,'Manager',0,0,'L');
    $pdf->Ln(5);	
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(180,5,'Accepted By : '.$row_advice['firstuser'] . ' & Authorized By : '.$row_advice['seconduser'] ,0,0,'L');
	 $pdf->Ln(11);	
	 
	 $image_file_dir = $row_advice["image_file_dir"];
	 $image_file_name = $row_advice["image_file_name"];
	 
$n++;
$r++;

//if ($image_file_dir<>'') {

//if (($advicetype=='18')  && ($beneficiaryname!='Sundry Deposit A/C JB Cheque Payment')) {

if ((($advicetype=='18') || ($advicetype=='19'))  && ($deposite_cheque=='D')) {



	$pdf->AddPage();
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
    $ypos= $pdf->GetY();
	//Logo Image(file,left,top,width,height)
	//$pdf->Image('../images/logo.jpg',14,$ypos + 4,12,8);
	$pdf->Image('../jbremitthome/images/logo.jpg',15,$ypos,10,8);
	$pdf->SetFont('Arial','B',10);
	$leftmrg=$leftmrg + 12;
	$pdf->SetX($leftmrg);
	$pdf->Cell(40,5,'JANATA BANK LTD',0,0,'L');
	$leftmrg=$leftmrg + 40;
	$pdf->SetX($leftmrg);	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(138,5,'Print Time : ' . date("d M Y g:i:s a",time()),0,0,'R');
 	$pdf->Ln(5);	
	$leftmrg=$leftmrg_initial;
	$leftmrg=$leftmrg + 12;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(140,5,$userbranchname,0,0,'L');
	$pdf->Ln(5);	
	$leftmrg=$leftmrg_initial;
	$leftmrg=$leftmrg + 12;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
    $pdf->SetTextColor(0,0,0);
	$pdf->Cell(140,5,'',0,0,'L');
 	$pdf->Ln(5);	
    $ypos= $pdf->GetY() ;
	$pdf->Line(204,$ypos,13,$ypos);
 	$pdf->Ln(5);	
	$leftmrg=$leftmrg_initial;
	$leftmrg=$leftmrg + 12;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(120,5,'Advice No: ' . $advice_no ,0,0,'L');
	$leftmrg=$leftmrg + 120;
	$pdf->SetX($leftmrg);
	$pdf->Cell(50,5,'Voucher Date: '.$respond_date,0,0,'R');
	$pdf->Ln(5);	
	
	
	if ($image_file_dir !='/jb_cheque_upload/') {
	//$image_file_dir = $image_file_root;
	$pdf->Image($image_file_root.$image_file_dir.$image_file_name,14,40,190,80);
	} else if ($image_file_dir =='/jb_cheque_upload/') {
	$pdf->Image($baseroot.'/jb_cheque_upload/'.$image_file_name,14,40,190,80);	
	}

	$pdf->Ln(100);	

	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(130,5,'Officer',0,0,'L');
	$leftmrg=$leftmrg + 130;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,5,'Manager',0,0,'L');

 	$pdf->Ln(5);	

	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(180,5,'Accepted By : '.$row_advice['firstuser'] . ' & Authorized By : '.$row_advice['seconduser'] ,0,0,'L');
}

if (($advicetype=='14')  && ($src_sequence_id<>'')) {
	$pdf->AddPage();
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
    $ypos= $pdf->GetY();
	//Logo Image(file,left,top,width,height)
	//$pdf->Image('../images/logo.jpg',14,$ypos + 4,12,8);
	$pdf->Image('../jbremitthome/images/logo.jpg',15,$ypos,10,8);
	$pdf->SetFont('Arial','B',10);
	$leftmrg=$leftmrg + 12;
	$pdf->SetX($leftmrg);
	$pdf->Cell(40,5,'JANATA BANK LTD',0,0,'L');
	$leftmrg=$leftmrg + 40;
	$pdf->SetX($leftmrg);	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(138,5,'Print Time : ' . date("d M Y g:i:s a",time()),0,0,'R');
 	$pdf->Ln(5);	
	$leftmrg=$leftmrg_initial;
	$leftmrg=$leftmrg + 12;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(140,5,$userbranchname,0,0,'L');
	$pdf->Ln(5);	
    $ypos= $pdf->GetY() ;
	$pdf->Line(204,$ypos,13,$ypos);
	$leftmrg=$leftmrg_initial;
	$leftmrg=$leftmrg + 12;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(120,5,'Advice No: ' . $advice_no ,0,0,'L');
	$leftmrg=$leftmrg + 120;
	$pdf->SetX($leftmrg);
	$pdf->Cell(50,5,'Voucher Date: '.$respond_date,0,0,'R');
	$pdf->Ln(5);	

	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	$pdf->Cell(15,6,'SL No',1,0,'L');
	$leftmrg=$leftmrg+15;
	$pdf->SetX($leftmrg);
	$pdf->Cell(10,6,'Code',1,0,'L');
	$leftmrg=$leftmrg+10;
	$pdf->SetX($leftmrg);
	$pdf->Cell(40,6,'Account No',1,0,'L');
	$leftmrg=$leftmrg+40;
	$pdf->SetX($leftmrg);
	$pdf->Cell(90,6,'Beneficiary Name',1,0,'L');
	$leftmrg=$leftmrg+90;
	$pdf->SetX($leftmrg);
	$pdf->Cell(30,6,'Amount',1,0,'R');
	$pdf->Ln(6);

	$pdf->SetFont('Arial','',9);

$r=1;
$n=0;
$totalamt=0;
$sql_data="select d.trdate,d.jbbranch,d.ben_account,d.ben_name,d.tramount from tblbatchdata d where d.jbbranch='".$resbrcode."' and d.fileuploadid=".$src_sequence_id." order by d.ben_name";
$result_data=sqlsrv_query($conn,$sql_data);
while ($row_data=sqlsrv_fetch_array($result_data)) {
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	$pdf->Cell(15,6,$r,1,0,'L');
	$leftmrg=$leftmrg+15;
	$pdf->SetX($leftmrg);
	$pdf->Cell(10,6,$row_data['jbbranch'],1,0,'L');
	$leftmrg=$leftmrg+10;
	$pdf->SetX($leftmrg);
	$pdf->Cell(40,6,$row_data['ben_account'],1,0,'L');
	$leftmrg=$leftmrg+40;
	$pdf->SetX($leftmrg);
	$pdf->Cell(90,6,$row_data['ben_name'],1,0,'L');
	$leftmrg=$leftmrg+90;
	$pdf->SetX($leftmrg);
	$pdf->Cell(30,6,$basicClass->moneyformat($row_data['tramount']),1,0,'R');
	$totalamt = $totalamt + $row_data['tramount'];
	$pdf->Ln();	
$r++;
}
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	$pdf->Cell(155,6,'Total Amount ',1,0,'R');
	$leftmrg=$leftmrg+155;
	$pdf->Cell(30,6,$basicClass->moneyformat($totalamt),1,0,'R');
	$pdf->Ln();	
 	$pdf->Ln(15);	
	$leftmrg=$leftmrg_initial;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(130,5,'Officer',0,0,'L');
	$leftmrg=$leftmrg + 130;
	$pdf->SetX($leftmrg);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,5,'Manager',0,0,'L');
	$pdf->Ln(21);	

}


//}

}
if ($tbluse=='A') {
$sql_update="update tbladvice set res_dwn_status='D' where res_brcode='".$resbrcode."' and res_dwn_status='P' and advicekey='".$advicekey."'";
} else if ($tbluse=='B') {
$sql_update="update tblbackadvice set res_dwn_status='D' where res_brcode='".$resbrcode."' and res_dwn_status='P' and advicekey='".$advicekey."'";
} 
sqlsrv_query($conn,$sql_update);

}

$pdf->Output('voucher.pdf','I');


sqlsrv_free_stmt( $result_advice);
sqlsrv_close($conn);
?>