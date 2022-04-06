<?php //define('BASEPATH','jbvoucher');
define('BASEPATH','jbremittancehome');
session_start();
include '../../jbneps_settings/domainsettings.php';
include '../../jbneps_classes/class_call.php';

$DataSecurity = new DataEncSecurity;
require('../../fpdf/fpdf.php');
include '../../jbneps_dbconn/dbmycon.php';
include '../../loginfail.php';

if (isset($commandArray[0])) {$br_code=$commandArray[0];
								if(empty($br_code)){
									echo 'Branch Code Empty'; EXIT;
									}
								$chkBranchArr=array("9999","5044");	
								$chkBranch=	(string)$_SESSION['userjblocat'];
							 	if (!(in_array($chkBranch, $chkBranchArr))){
									if($br_code !== $chkBranch){Echo "Other Branch Report Not Available"; EXIT;}
								}
							
								
								$br_code = $CISecurity->xss_clean($br_code);
								
								}
if (isset($commandArray[1])) {$f_date=$commandArray[1];
								if(empty($f_date)){
									echo 'From Date Empty'; EXIT;
									}
								$f_date = $CISecurity->xss_clean($f_date);
								if (!preg_match("/^(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}$/",$f_date)) {
										echo "FORMAT DD-MM-YY DOES NOT MATCH";
										EXIT;
									}
								}
if (isset($commandArray[2])) {$to_date=$commandArray[2];
								if(empty($to_date)){
									echo 'To Date Empty'; EXIT;
									}
								$to_date = $CISecurity->xss_clean($to_date);
								if (!preg_match("/^(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}$/",$to_date)) {
										echo "FORMAT DD-MM-YY DOES NOT MATCH";
										EXIT;
									}
								}

//if (isset($commandArray[3])) $br_code=$commandArray[3];
//if (isset($commandArray[3])) $req_date=$commandArray[3];
//if (isset($commandArray[4])) $Process_date=$commandArray[4];

$where='';
$sql_f_date=date("Y-m-d",strtotime($f_date));
$sql_to_date=date("Y-m-d",strtotime($to_date));

$br_code = strtoupper($br_code);
$GLOBALS['titleMessageForTable']='Successfully Enrolled Customer List For DSS Bhata System ('.$f_date.' To '.$to_date.')';
  
$tsql="exec spNepsEnrolledCustomerReport '$br_code','$sql_f_date','$sql_to_date'";

 
  /*******************Branch Name And Zone Name**********************//////////////////
 
 IF ($br_code == "ALL")
 {
		$GLOBALS['branchName']="ALL";
		//$GLOBALS['zoneName']=$row_branch_name['ZoneName'];
		$GLOBALS['districtName']="ALL";
 }
 ELSE
 {
 
	 $sql_branch="SELECT  dbjbwebremitt.dbo.Branch.BranchName, dbjbwebremitt.dbo.Zone.ZoneName, dbjbwebremitt.dbo.Branch.Address, dbjbwebremitt.dbo.Branch.DistCode
				 FROM    dbjbwebremitt.dbo.Zone INNER JOIN
                         dbjbwebremitt.dbo.Branch ON dbjbwebremitt.dbo.Zone.ZoneID = dbjbwebremitt.dbo.Branch.ZoneID
				 WHERE   (dbjbwebremitt.dbo.Branch.BranchCode = $br_code)";
			  
	  
  $result_branch_Name=sqlsrv_query($conn,$sql_branch);
  $row_branch_name=sqlsrv_fetch_array($result_branch_Name);
  $GLOBALS['branchName']=$row_branch_name['BranchName'];
  $GLOBALS['zoneName']=$row_branch_name['ZoneName'];
  $GLOBALS['districtName']=$row_branch_name['DistCode'];
 }
  
class PDF extends FPDF
{
//Page header
function Header()
{ 
	$leftmrg_initial=14;
	$leftmrg=$leftmrg_initial;
	$this->SetX($leftmrg);
	$ypos= $this->GetY();
	$this->Image('../../images/logo.jpg',14,$ypos +4,12,8);
	$this->SetX($leftmrg+12);

	$this->SetFont('Arial','B',8);
	
	$this->Cell(0,12,'JANATA BANK LTD',0,0,'L');
	$this->SetFont('Arial','',8);
	$this->Cell(0,12,'Print Time : ' . date("d M Y g:i:s a",time()),0,0,'R');
    $this->Ln(4);
	
	$this->SetFont('Arial','B',8);
	//$this->Cell(0,12,'BRANCH: '.$branchName,0,0,'C');
	$this->Cell(0,12,'BRANCH: '.$GLOBALS['branchName'],0,0,'C');
	//$this->SetX($leftmrg);
	//$this->Cell(0,20,'Area:'.$GLOBALS['zoneName'],0,0,'C');
	$this->SetX($leftmrg);
	$this->Cell(0,20,'District:'.$GLOBALS['districtName'],0,0,'C');
	//$this->Cell(0,20,'District:'.$districtName,0,0,'C');
	$this->SetFont('Arial','B',8);
	$this->SetX($leftmrg+14);
	
	
	$this->SetFont('Arial','B',8);
	$this->SetX($leftmrg);
	$this->Cell(0,35,$GLOBALS['titleMessageForTable'],0,0,'C');
	
	$this->Ln(21);
	
	$this->SetFont('Arial','B',8);
	$this->SetX($leftmrg_initial);
	
	$this->Cell(12,5,'Sl#',1,0,'L');
	$this->Cell(23,5,'Txn No',1,0,'L');
IF ($GLOBALS['branchName']=="ALL")
{
	$this->Cell(9,5,'Br.Co.',1,0,'L');
}
	$this->Cell(25,5,'Cust F Name',1,0,'L');
	$this->Cell(20,5,'Cust L Name',1,0,'L');
	$this->Cell(16,5,'Birth Date',1,0,'L');
	$this->Cell(28,5,'NID Number',1,0,'L');
	$this->Cell(23,5,'Father Name',1,0,'L');
/* IF ($GLOBALS['branchName']=="ALL")
{
	$this->Cell(23,5,'Br.Code',1,0,'L');
} */
/* IF ($GLOBALS['branchName']!=="ALL")
{
	$this->Cell(23,5,'Mother Name',1,0,'L');
} */
	//$this->Cell(23,5,'Mother Name',1,0,'L');
	//$this->Cell(13,5,'Status',1,0,'L');
	$this->Cell(15,5,'Enroll Date',1,0,'C');
	$this->Cell(22,5,'Acc Number',1,0,'L');
	$this->Cell(40,5,'Acc Name',1,0,'L');
	$this->Cell(13,5,'Bhata',1,0,'C');
	$this->Cell(19,5,'Mobile No',1,0,'L');
	//Left 3 pixel
	
	$this->Ln(5);
}

//Page footer
function Footer()
{
 }
}
$leftmrg_initial=14;
$leftmrg=$leftmrg_initial;
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L');
$pdf->SetY(35);
$pdf->SetX($leftmrg);
$pdf->SetFont('Arial','B',9);
	
$r=1;
$n=0;
$TotalDr=0;
$TotalCr=0;
$OutstandinBalance=0;
$result_form2=sqlsrv_query($conn,$tsql);
//$result_form=sqlsrv_query($conn,$sql);

	$pdf->SetFont('Arial','',8);
	$pdf->SetX($leftmrg_initial);	
	$pdf->Ln(5);
	$slNo=1;
	/////////***************************************///////////////
	while ($row_form=sqlsrv_fetch_array($result_form2)) {
							$bhataType ="";
							switch ($row_form['prodTypeKey']) 
							{		case '1':
										$bhataType='Boyosko';
										break;
									case '2':
										$bhataType= 'Bidhoba';
										break;
									case '3':
										$bhataType= 'Prtibndi';
										break;
									default:
										echo 'Not Found';
							}
							
		$pdf->SetX($leftmrg_initial);
		$pdf->Cell(12,5,$slNo,1,0,'L');
		$pdf->Cell(23,5,$row_form['txnCode'],1,0,'L');	
IF ($GLOBALS['branchName']=="ALL")
{
		$pdf->Cell(9,5,$row_form['branchCode'],1,0,'L');
}		
		$pdf->Cell(25,5,$row_form['custFirstName'],1,0,'L');
		$pdf->Cell(20,5,$row_form['custLasttName'],1,0,'L');
		$pdf->Cell(16,5,$row_form['dOB'],1,0,'L');
		$pdf->Cell(28,5,$row_form['nIDNo'],1,0,'L');		
		$pdf->Cell(23,5,$row_form['custFatherName'],1,0,'L');
/* IF ($GLOBALS['branchName']=="ALL")
{
		$pdf->Cell(23,5,$row_form['branchCode'],1,0,'L');
} */
/* IF ($GLOBALS['branchName']!=="ALL")
{
		$pdf->Cell(23,5,$row_form['custMotherName'],1,0,'L');
} */		
		
		
		//$pdf->Cell(23,5,$row_form['custMotherName'],1,0,'L');		
		//$pdf->Cell(23,5,$row_form['branchCode'],1,0,'L');
		
		//$pdf->Cell(13,5,$row_form['nEPSEnrollStatus'],1,0,'L');		
		$pdf->Cell(15,5,$row_form['enrollDate'],1,0,'C');
		$pdf->Cell(22,5,$row_form['accNo'],1,0,'L');
		$pdf->Cell(40,5,$row_form['accName'],1,0,'L');		
		$pdf->Cell(13,5,$bhataType,1,0,'L');		
		$pdf->Cell(19,5,$row_form['mobNo'],1,0,'L');
		//$TotalDr=$TotalDr+$row_form['DrAmount'];
		//$TotalCr=$TotalCr+$row_form['CrAmount'];
		//Left 3 pixel
		$pdf->Ln(5);
		$slNo=$slNo+1;
}
		
	
	///////*****************************************///////////////
	

$pdf->SetFont('Arial','B',10);

$ypos= $pdf->GetY();
$pdf->SetY($ypos+30);
$pdf->Cell(30,5,'Officer',0,0,'R');
$pdf->Cell(150,5,'Manager',0,0,'R');


$pdf->Output();
sqlsrv_free_stmt($result_form2);
sqlsrv_free_stmt($result_form);
sqlsrv_free_stmt($row_branch_name);
sqlsrv_close($conn);
?>