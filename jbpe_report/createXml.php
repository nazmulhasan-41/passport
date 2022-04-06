<?php
define('BASEPATH','jbremittancehome');
session_start();
require_once('../jbpe_settings/domainsettings.php');
require_once('../jbpe_dbconn/dbmycon.php');
require_once('../jbpe_classes/clsdatainsert.php');
$InsertClass = new DataInsert;

//require_once('../jbuniv_classes/class_call.php');
//require_once('../loginfail.php');

//if (isset($commandArray[0])) $branch_code=$commandArray[0];
//if (isset($commandArray[1])) $f_date=$commandArray[1];

$br_code = $_SESSION['userjblocat'];
//$loginuserid = $_SESSION['userID'];
$loginuserid = $_SESSION['userjbremtt'];
//echo($br_code);
//$where='';
//$f_date=date("Y-m-d",strtotime($f_date));
//$s_date=date("Y-m-d",strtotime($s_date));
	
	$sql_branch="SELECT  dbo.tblTMData.SL_NO, dbo.tblTMData.TM_FOR, dbo.tblTMData.CURRENCY_CODE, dbo.tblTMData.COUNTRY_CODE, dbo.tblTMData.PURPOSE_CODE, dbo.tblTMData.BENEFICIARY_DETAILS, 
                     dbo.tblTMData.APPLICANT_NAME, dbo.tblTMData.APPLICANT_ADDRESS, dbo.tblTMData.EFFECTED_REMITTANCE, dbo.tblTMData.FX_MANUAL_PARA, dbo.tblTMData.BB_APPROVAL_NO, 
                     dbo.tblTMData.APPROVAL_DATE, dbo.tblTMData.CATEGORY_CODE, dbo.tblTMData.TM_DATE, dbo.tblTMData.COMPANY_TYPE_ID, dbo.tblTMData.MOP_CASH, dbo.tblTMData.MOP_CARD, 
                     dbo.tblTMData.MOP_FDD, dbo.tblTMData.MOP_MT, dbo.tblTMData.MOP_OTHER, dbo.tblTMData.SFC_BANK, dbo.tblTMData.SFC_FC_AC, dbo.tblTMData.SFC_ERQ, dbo.tblTMData.SFC_OTHER, 
                     dbo.tblTMData.AMOUNT_IN_BDT, dbo.tblTMData.CONTACT_NO, dbo.tblTMData.BANK_REFERENCE, dbo.tblpassport.SL_NO AS SLNO, dbo.tblpassport.PASSPORT_NO, 
                     dbo.tblpassport.CITIZEN_NAME, dbo.tblpassport.ADDRESS, dbo.tblpassport.PASSPORT_DATE, dbo.tblpassport.PASSPORT_ISSUE_PLACE, dbo.tblpassport.PASSPORT_RENEWAL_DATE, 
                     dbo.tblTMData.MOP_TC
					FROM dbo.tblTMData INNER JOIN
                    dbo.tblpassport ON dbo.tblTMData.PASSPORT_NO = dbo.tblpassport.PASSPORT_NO					
					WHERE (dbo.tblTMData.TM_DATE = CONVERT(date, GETDATE()))and dbo.tblTMData.BRANCH_CODE='$br_code'"; 
	
	$dom = new DOMDocument();
	//$dom->encoding = 'utf-8';
	$dom->xmlVersion = '1.0';
	//$dom->actualEncoding = true;
	$dom->formatOutput = true;
	
	$root = $dom->createElement('TM');
	$dom->appendChild($root);
	
	$i=0;
	$exportData = sqlsrv_query($conn,$sql_branch);
	while( $row = sqlsrv_fetch_array( $exportData) ) {
		
		$result = $dom->createElement('TM_MAIN');
		$root->appendChild($result);
		
		$result->appendChild( $dom->createElement('SL_NO', $i+1) );
		$result->appendChild( $dom->createElement('TM_FOR', $row["TM_FOR"]) );
		$result->appendChild( $dom->createElement('CURRENCY_CODE', $row["CURRENCY_CODE"]) );
		$result->appendChild( $dom->createElement('COUNTRY_CODE', $row["COUNTRY_CODE"]) );
		$result->appendChild( $dom->createElement('PURPOSE_CODE', $row["PURPOSE_CODE"]) );
		$result->appendChild( $dom->createElement('BENEFICIARY_DETAILS', $row["BENEFICIARY_DETAILS"]) );
		$result->appendChild( $dom->createElement('APPLICANT_NAME', $row["APPLICANT_NAME"]) );
		$result->appendChild( $dom->createElement('APPLICANT_ADDRESS', $row["APPLICANT_ADDRESS"]) );
		$result->appendChild( $dom->createElement('EFFECTED_REMITTANCE', $row["EFFECTED_REMITTANCE"]) );		
		$result->appendChild( $dom->createElement('FX_MANUAL_PARA', $row["FX_MANUAL_PARA"]) );
		$result->appendChild( $dom->createElement('BB_APPROVAL_NO', $row["BB_APPROVAL_NO"]) );
		$result->appendChild( $dom->createElement('APPROVAL_DATE', $row["APPROVAL_DATE"]) );
		$result->appendChild( $dom->createElement('CATEGORY_CODE', $row["CATEGORY_CODE"]) );
		$result->appendChild( $dom->createElement('TM_DATE', $row["TM_DATE"]->format('Y-m-d')));		
		$result->appendChild( $dom->createElement('COMPANY_TYPE_ID', $row["COMPANY_TYPE_ID"]) );
		$result->appendChild( $dom->createElement('MOP_CASH', $row["MOP_CASH"]) );
		$result->appendChild( $dom->createElement('MOP_TC', $row["MOP_TC"]) );
		$result->appendChild( $dom->createElement('MOP_CARD', $row["MOP_CARD"]) );
		$result->appendChild( $dom->createElement('MOP_FDD', $row["MOP_FDD"]) );		
		$result->appendChild( $dom->createElement('MOP_MT', $row["MOP_MT"]) );
		$result->appendChild( $dom->createElement('MOP_OTHER', $row["MOP_OTHER"]) );
		$result->appendChild( $dom->createElement('SFC_BANK', $row["SFC_BANK"]) );
		$result->appendChild( $dom->createElement('SFC_FC_AC', $row["SFC_FC_AC"]) );
		$result->appendChild( $dom->createElement('SFC_ERQ', $row["SFC_ERQ"]) );
		$result->appendChild( $dom->createElement('SFC_OTHER', $row["SFC_OTHER"]) );
		$result->appendChild( $dom->createElement('AMOUNT_IN_BDT', $row["AMOUNT_IN_BDT"]) );
		$result->appendChild( $dom->createElement('CONTACT_NO', $row["CONTACT_NO"]) );
		$result->appendChild( $dom->createElement('BANK_REFERENCE', $row["BANK_REFERENCE"]) );	

		$result_new = $dom->createElement('PASSPORT');
		$result->appendChild($result_new);
		//$result_new->appendChild( $dom->createElement('SL_NO', $row["SLNO"]) );
		$result_new->appendChild( $dom->createElement('SL_NO', '1' ));
		$result_new->appendChild( $dom->createElement('PASSPORT_NO', $row["PASSPORT_NO"]) );
		$result_new->appendChild( $dom->createElement('CITIZEN_NAME', $row["CITIZEN_NAME"]) );
		$result_new->appendChild( $dom->createElement('ADDRESS', $row["ADDRESS"]) );
		$result_new->appendChild( $dom->createElement('PASSPORT_DATE', $row["PASSPORT_DATE"]->format('Y-m-d')) );
		$result_new->appendChild( $dom->createElement('PASSPORT_ISSUE_PLACE', $row["PASSPORT_ISSUE_PLACE"]) );
		$result_new->appendChild( $dom->createElement('PASSPORT_RENEWAL_DATE', 'NA') );		
		
		$i++;
	}
	if($i>0){	
		$directory = 'output/';
		$output_file_name = $directory.date("Ymd").'_'.$br_code.'_TM_DATA.xml';	
		 	
		 $dom->save($output_file_name) or die('XML Create Error');
		 
		//echo (basename($output_file_name));		
		
		
		/* header('Content-Description: File Transfer');
		header("Content-type: text/xml");
		header('Content-Disposition: attachment; filename="'.basename($output_file_name).'"');
		header("Expires: 0");		
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");		
		header("Pragma: public");		
		header('Content-Length: ' . filesize($output_file_name));
		readfile($output_file_name);
		exit; */
		
			if (file_exists($output_file_name)) {
				header('Content-Description: File Transfer');
				header("Content-type: text/xml");
				header('Content-Disposition: attachment; filename="'.basename($output_file_name).'"');
				header("Expires: 0");		
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");		
				header("Pragma: public");		
				header('Content-Length: ' . filesize($output_file_name));
				readfile($output_file_name);
				//ob_clean(); 
				//flush(); 
				//exit;
			} else {
				exit('Sorry, Failed to open XML file. Please try again later.');
			}
		
		} 
		else{
		//echo "<script>alert('No data found related to report date !!!');history.go(-1);</script>";
		echo "No data found related to report date !!!";
		}
	
			
//////////////////////////////////////

/* $header = '';
$result ='';
$exportData = sqlsrv_query($conn,$sql_branch);

 
$export_data='';

$i=0;$j=0;


$export_data.='BrCode,BrName,EXAM FEE,no of Form,Date'."\r\n";
while( $row = sqlsrv_fetch_array( $exportData) ) {
      
$export_data.=$row["branch_code"].','.$row["BranchName"].','.$row["Exam_fee"].','.$row["Form_no"].','.$row["Date"]."\r\n";
	  
	  $i++;
}

 if($i>0){
			$fileName = date("YmdHis").'_DU_GEN_NEW.csv'; 
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header('Content-Description: File Transfer');
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename={$fileName}");

			header("Expires: 0");
			header("Pragma: public");

			$fh = @fopen( 'php://output', 'w' );

			print $export_data;	
				
			// Close the file
			fclose($fh);
			// Make sure nothing else is sent, our file is done
			exit;
		}
		else
			{
				echo "No data to Export";
			} */
?>