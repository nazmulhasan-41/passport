<?php //define('BASEPATH','jbvoucher');
define('BASEPATH','jbremittancehome');
session_start();
include '../jbpe_settings/domainsettings.php';
include '../jbpe_classes/class_call.php';

$DataSecurity = new DataEncSecurity;
require('../fpdf/fpdf.php');
include '../jbpe_dbconn/dbmycon.php';
include '../loginfail.php';

if (isset($commandArray[0])) {$br_code=$commandArray[0];
								if(empty($br_code)){
									echo 'Branch Code Empty'; EXIT;
									}
								$chkBranchArr=array("9999","5044","All");	
								$chkBranch=	(string)$_SESSION['userjblocat'];
							 	if (!(in_array($chkBranch, $chkBranchArr))){
									if($br_code !== $chkBranch){echo "Other Branch Report Not Available"; EXIT;}
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
$GLOBALS['titleMessageForTable']='Passport Endorsement List      Date: '.$f_date.' To '.$to_date.'';

  
$tsql="exec spPEdailyReport '$br_code','$sql_f_date','$sql_to_date'";

 
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
	$this->Image('../images/logo.jpg',14,$ypos +4,12,8);
	$this->SetX($leftmrg+12);

	$this->SetFont('Arial','B',8);
	$this->Cell(0,12,'JANATA BANK LTD',0,0,'L');
	
	$this->SetFont('Arial','',8);
	$this->Cell(0,12,'Print Time : ' . date("d M Y g:i:s a",time()),0,0,'R');
    $this->Ln(4);
	$this->SetX($leftmrg+12);
	$this->Cell(0,12,$GLOBALS['branchName'],0,0,'L');
	
	$this->SetFont('Arial','B',8);
	
	//$this->Cell(0,12,'BRANCH: '.$branchName,0,0,'C');
	//$this->Cell(0,12,'BRANCH: '.$GLOBALS['branchName'],0,0,'C');
	//$this->SetX($leftmrg);
	//$this->Cell(0,20,'Area:'.$GLOBALS['zoneName'],0,0,'C');
	$this->SetX($leftmrg);
	//$this->Cell(0,20,'District:'.$GLOBALS['districtName'],0,0,'C');
	//$this->Cell(0,20,'District:'.$districtName,0,0,'C');
	$this->SetFont('Arial','B',8);
	$this->SetX($leftmrg+14);
	
	
	$this->SetFont('Arial','B',8);
	$this->SetX($leftmrg);
	$this->Cell(0,35,$GLOBALS['titleMessageForTable'],0,0,'L');
	
	$this->Ln(21);
	
	$this->SetFont('Arial','B',8);
	$this->SetX($leftmrg_initial);
	 
	$this->Cell(12,5,'Sl#',1,0,'L');
	$this->Cell(23,5,'Passport No',1,0,'L');
	/* IF ($GLOBALS['branchName']=="ALL")
		{
			$this->Cell(9,5,'Br.Co.',1,0,'L');
		} */
	$this->Cell(45,5,'Applicant Name',1,0,'L');
	$this->Cell(20,5,'Contact No',1,0,'L');
	$this->Cell(80,5,'Address',1,0,'L');
	$this->Cell(22,5,'Passport Date',1,0,'L');
	$this->Cell(15,5,'TM For',1,0,'L');
	$this->Cell(20,5,'Endorse Date',1,0,'C');
	$this->Cell(17,5,'FC Amnt',1,0,'L');
	$this->Cell(17,5,'Amnt. BDT',1,0,'L');
	
	
	
	$this->Ln(5);
}

//Page footer
function Footer()
{
	// Go to 1.5 cm from bottom
    $this->SetY(-18);
    // Select Arial italic 8
    $this->SetFont('Arial','I',8);
    // Print centered page number
    
	//$this->Cell(0,20,' This is Computer generated no signature required.',0,0,'C');
	//$this->Ln(10);
	$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
 }
}

//===========================dADA POPULATE FROM HERE========================//

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
$TotalBdt=0;
$TotalFC=0;
//$OutstandinBalance=0;
$result_form2=sqlsrv_query($conn,$tsql);
//$result_form=sqlsrv_query($conn,$sql);

	$pdf->SetFont('Arial','',8);
	$pdf->SetX($leftmrg_initial);	
	$pdf->Ln(5);
	$slNo=1; 
	/////////***************************************///////////////
while ($row_form=sqlsrv_fetch_array($result_form2)) {
							
							$tmFor="";
							switch ($row_form['TM_FOR']) 
							{		case 'T':
										$tmFor='Travel';
										break;
									case 'M':
										$tmFor= 'Miscellenious';
										break;
									default:
										echo 'Not Found';
							} 
							
		if ($pdf->GetY()>=175) {
			$pdf->AddPage();
		}	
		
		$pdf->SetX($leftmrg_initial);
		$pdf->Cell(12,5,$slNo,1,0,'L');
		$pdf->Cell(23,5,$row_form['PASSPORT_NO'],1,0,'L');	
		/* IF ($GLOBALS['branchName']=="ALL")
				{
				  $pdf->Cell(9,5,$row_form['branchCode'],1,0,'L');
				}	 */	
		$pdf->Cell(45,5,$row_form['CITIZEN_NAME'],1,0,'L');
		$pdf->Cell(20,5,$row_form['CONTACT_NO'],1,0,'L');
		$pdf->Cell(80,5,$row_form['ADDRESS'],1,0,'L');
		$pdf->Cell(22,5,$row_form['PASSPORT_DATE'],1,0,'L');
		$pdf->Cell(15,5,$tmFor,1,0,'L');	
		$pdf->Cell(20,5,$row_form['TM_DATE'],1,0,'C');
		$pdf->Cell(17,5,$row_form['SFC_BANK'],1,0,'R');	
		$pdf->Cell(17,5,$row_form['AMOUNT_IN_BDT'],1,0,'R');
	    	$TotalFC=$TotalFC+$row_form['SFC_BANK'];
		$TotalBdt=$TotalBdt+$row_form['AMOUNT_IN_BDT'];
	
		$pdf->Ln(5);
		$slNo=$slNo+1;
}
		$pdf->SetFont('Arial','B',10);
		$pdf->SetX($leftmrg_initial);
		$pdf->Cell(237,5,'Total =',1,0,'R');
		//$pdf->Cell(17,5,''.$TotalFC,1,0,'R');
		//$pdf->Cell(17,5,''.$TotalBdt,1,0,'R');
                //$pdf->Cell(17,5,''.$basicClass->moneyformat($TotalFC),1,0,'R');
		//$pdf->Cell(17,5,''.$basicClass->moneyformat($TotalBdt),1,0,'R');
		$pdf->Cell(17,5,''.number_format($TotalFC,4),1,0,'R');
		$pdf->Cell(17,5,''.number_format($TotalBdt,4),1,0,'R');

//===========================DATA POPULATE END HERE========================//	
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