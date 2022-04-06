<?php
define('BASEPATH','jbremittancegetaccount');
session_start();
require_once('../jbpe_settings/domainsettings.php');
require_once('../jbpe_dbconn/dbmycon.php');
require_once('../jbpe_classes/class_call.php');
require_once('../loginfail.php');

if (isset($commandArray[0])) $cond_type=$commandArray[0];
if (isset($commandArray[1])) $accountvalue1=$commandArray[1];
if (isset($commandArray[2])) $accountvalue2=$commandArray[2];
if (isset($commandArray[3])) $accountvalue3=$commandArray[3];
if (isset($commandArray[4])) $accountvalue4=$commandArray[4];
if (isset($commandArray[5])) $accountvalue5=$commandArray[5];
if (isset($commandArray[6])) $accountvalue6=$commandArray[6];
if (isset($commandArray[7])) $accountvalue7=$commandArray[7];
//echo $cond_type;
//exit;RPTACC

if ($cond_type=='userlist') {
	if (isset($_SESSION['userjbremtt'])) $usr_id=$_SESSION['userjbremtt'];
	$tblname="tblusers";
	$tblcaption="User List";
	$colHeader="Login ID,User Name,Mobile,Branch,File No,User Level,Status,Permission";
	$sql="select u.loginID,u.userName,u.mobileNo,b.BranchName,u.pfileno,u.userLevel,u.userStatus,'Permission',u.BranchCode,u.deptcode from tblusers u inner join Branch b on u.BranchCode=b.BranchCode where (u.BranchCode='$accountvalue2' or u.mobileNo='$accountvalue2' or u.pfileno='$accountvalue2') and u.loginID<>'$usr_id' order by u.userStatus,u.loginID";
	//echo $sql;	   
	//$actionlink=$baseroot ."/jr_user_forms/index.php/";
	$actionlink=$baseroot ."/jbpe_home/userpermission.php/";
	$permissionlink=$baseroot ."/jbpe_home/userpermission.php/";
	
	$dataviewclass->data_user_list($tblname,$tblcaption,$colHeader,$sql,$accountvalue1,$actionlink,$permissionlink,$conn_jbrps);
	echo $dataviewclass->DataList;
} else if ($cond_type=='Branchstatus') { //Branch Status
$dataviewclass->BranchSettings($accountvalue1,'',$currsoftdate,$baseroot,$conn);
echo $dataviewclass->BranchSettings;
} else if ($cond_type=='Servicestatus') { //Branch Status
$dataviewclass->service_provider_details($accountvalue1,$baseroot,$conn);
echo $dataviewclass->service_provider_details;
}
////////////////////////////////////////////////////////////////////
//////////       Passport  Endorsement Starts Here ////////////////
//////////////////////////////////////////////////////////////////
else if ($cond_type=='SHOWPASSPORTINFO') {

//IF ($nIDNo == NULL)
	IF (empty($commandArray[1]))
		{	ECHO '<span style="color:red;font-size: 20px">*Please Enter Passport Number...</span>';}
	ELSE
		{
			$passportNo=$CISecurity->xss_clean($commandArray[1]);
			$passportNo= trim($passportNo);
			//echo $passportNo."<br>".$tblcaption."<br>".$colHeader."<br>".$passportNo."<br>".$baseroot."<br>".$conn;
			
			$tblcaption="Passport Information";
			$colHeader="Passport Number,Applicant Name,Address,Passport Date,Passport Issue Place,Passport Renewal Date,
						Passport Create Date,Created By,Approved By";

			//$routing_no=$accountvalue2;
			//$br_code=$accountvalue3;
			$dataviewclass->PassportInfo($tblcaption,$colHeader,$passportNo,$baseroot,$conn);
			echo $dataviewclass->DataList;
		}
}

/* else if ($cond_type=='SHOWPASSPORTINFO') {

//IF ($nIDNo == NULL)
	IF (empty($commandArray[1]))
		{	ECHO '<span style="color:red;font-size: 20px">*Please Enter Passport Number...</span>';}
	ELSE
		{
			$passportNo=$CISecurity->xss_clean($commandArray[1]);
			
			//echo $passportNo."<br>".$tblcaption."<br>".$colHeader."<br>".$passportNo."<br>".$baseroot."<br>".$conn;
			
			$tblcaption="Passport Information";
			$colHeader="Passport Number,Applicant Name,Address,Passport Date,Passport Issue Place,Passport Renewal Date,
						Passport Create Date,Created By,Approved By";

			//$routing_no=$accountvalue2;
			//$br_code=$accountvalue3;
			$dataviewclass->PassportInfo($tblcaption,$colHeader,$passportNo,$baseroot,$conn);
			echo $dataviewclass->DataList;
		}
}
 */
//PE Authorization

else if ($cond_type=='PEAUTHORIZATION') {
	 //echo "command1:".$commandArray[1]."<br>command 2:".$commandArray[2]; exit;
	IF (empty($commandArray[1]))
		{	ECHO '<span style="color:red;font-size: 20px">*Bank Txn Empty...</span>';}
	Else IF (empty($commandArray[2]))
		{	ECHO "Login Id Not Found";}
	ELSE
		{
			 $peTxnId =$CISecurity->xss_clean($commandArray[1]);
			 $authorizedBy =$CISecurity->xss_clean($commandArray[2]);
			 $sql="SELECT [CREATED_BY]  
					FROM [dbjbPassportEndorse].[dbo].[tblTMData]
					WHERE [PE_TXN_ID]='".$peTxnId."'";
			
			 $result_list = sqlsrv_query($conn,$sql);
			 $data=sqlsrv_fetch_array($result_list);
			 sqlsrv_free_stmt($result_list); 
	 
 	 
	 if ($data['CREATED_BY']==$authorizedBy)
		{	//echo '<span style="color:green;font-size: 12px">Same User Can Not Authorize</span>';
			echo "Same User Can Not Authorize";
		}
	 
	 else{ 
			//echo "CreatedBY:".$data['CREATED_BY']."AuthorizeBY:".$authorizedBy;
			$funcname="spAuthorizeTmnPP";
			$values="@peTxnId=?,@approvedBy=?";
			$arrays=array($peTxnId,$authorizedBy);
			
			$InsertClass->proc_param_data($funcname,$values,$arrays,$conn);
			//echo '<span style="color:green;font-size: 20px">'.$InsertClass->datasave.'</span>';$InsertClass->querylog
			echo '<span style="color:green;font-size: 14px">'.$InsertClass->querylog.'</span>';
	 }
		}
 }

//PE Reject

else if ($cond_type=='PEREJECT') {
	 
	IF (empty($commandArray[1]))
		{	ECHO '<span style="color:red;font-size: 20px">*Bank Txn Empty...</span>';}
	Else IF (empty($commandArray[2]))
		{	ECHO "Login Id Not Found";}
	ELSE
		{
			 $peTxnId =$CISecurity->xss_clean($commandArray[1]);
			 $rejecteddBy =$CISecurity->xss_clean($commandArray[2]);
			 $sql="SELECT [CREATED_BY]  
					FROM [dbjbPassportEndorse].[dbo].[tblTMData]
					WHERE [PE_TXN_ID]='".$peTxnId."'";
			
			 $result_list = sqlsrv_query($conn,$sql);
			 $data=sqlsrv_fetch_array($result_list);
			 sqlsrv_free_stmt($result_list); 
	 
 	 
	 if ($data['CREATED_BY']==$rejecteddBy)
		{	echo "Same User Can Not Reject";
		}
	 
	 else{ 
		 
			$funcname="spRejectTmnPP";
			$values="@peTxnId=?,@approvedBy=?";
			$arrays=array($peTxnId,$rejecteddBy);
			
			$InsertClass->proc_param_data($funcname,$values,$arrays,$conn);
			echo '<span style="color:green;font-size: 14px">'.$InsertClass->querylog.'</span>';
			//echo $InsertClass->datasave;
	 
	 }
		}
 }








////////////////////////////////////////////////////////////////////
//////////       Passport  Endorsement ENDS Here ////////////////
//////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////
//////////       NEPS STARTS HERE   ////////////////
///////////////////////////////////////////////////

//NEPS EDIT USER VALIDATION
/*
else if ($cond_type=='NEPSEDIT') {
	 
	IF (empty($commandArray[1]))
		{	ECHO '<span style="color:red;font-size: 20px">*Please Enter NID Number...</span>';}
	Else IF (empty($commandArray[2]))
		{	ECHO "Login Id Not Found";}
	ELSE
		{
			 $bankOrgTxnCode =$CISecurity->xss_clean($commandArray[1]);
			 $rejecteddBy =$CISecurity->xss_clean($commandArray[2]);
			 $sql="SELECT [createdBy]  
					FROM [dbjbneps].[dbo].[nepsCustEnroll]
					WHERE [bankOrgTxnCode]='".$bankOrgTxnCode."'";
			
			 $result_list = sqlsrv_query($conn,$sql);
			 $data=sqlsrv_fetch_array($result_list);
			 sqlsrv_free_stmt($result_list); 
	 
 	 
	 if ($data['createdBy']==$rejecteddBy)
		{	echo "Same User Can Not Reject";
		}
	 
	 else{ 
		 
			$funcname="spRejectEnroll";
			$values="@bankOrgTxnCode=?,@rejectedBy=?";
			$arrays=array($bankOrgTxnCode,$rejecteddBy);
			
			$InsertClass->proc_param_data($funcname,$values,$arrays,$conn);
			echo $InsertClass->datasave;
	 
	 }
		}
 }

*/

//NEPS Rejection Local DB

else if ($cond_type=='FCRATEREJECT') {
	 
	IF (empty($commandArray[1]))
		{	ECHO '<span style="color:red;font-size: 20px">*Please Enter NID Number...</span>';}
	Else IF (empty($commandArray[2]))
		{	ECHO "Login Id Not Found";}
	ELSE
		{
			 $fcrateid =$CISecurity->xss_clean($commandArray[1]);
			 $rejecteddBy =$CISecurity->xss_clean($commandArray[2]);
			 $sql="SELECT [CREATED_BY]  
					FROM [dbjbPassportEndorse].[dbo].[ExchangeRate]
					WHERE [FC_RATE_ID]='".$fcrateid."'";
			
			 $result_list = sqlsrv_query($conn,$sql);
			 $data=sqlsrv_fetch_array($result_list);
			 sqlsrv_free_stmt($result_list); 
	 
 	 
	 if ($data['CREATED_BY']==$rejecteddBy)
		{	echo "Same User Can Not Reject";
		}
	 
	 else{ 
		 
			$funcname="spRejectFCrates";
			$values="?,?";
			$arrays=array($fcrateid,$rejecteddBy);
			
			$InsertClass->proc_param_data($funcname,$values,$arrays,$conn);
			//echo $InsertClass->datasave;
			echo '<span style="color:green;font-size: 14px">'.$InsertClass->querylog.'</span>';
	 
	 }
		}
 }



//FC RATES AUTHORIZATION

 else if ($cond_type=='FCRATEAUTHORIZATION') {
	 
	IF (empty($commandArray[1]))
		{	ECHO '<span style="color:red;font-size: 20px">*Bank Txn Empty...</span>';}
	Else IF (empty($commandArray[2]))
		{	ECHO "Login Id Not Found";}
	ELSE
		{
			 $fcrateid =$CISecurity->xss_clean($commandArray[1]);
			 $authorizedBy =$CISecurity->xss_clean($commandArray[2]);
			 $sql="SELECT [CREATED_BY]  
					FROM [dbjbPassportEndorse].[dbo].[ExchangeRate]
					WHERE [FC_RATE_ID]='".$fcrateid."'";
			
			 $result_list = sqlsrv_query($conn,$sql);
			 $data=sqlsrv_fetch_array($result_list);
			 sqlsrv_free_stmt($result_list); 
	 
 	 
	 if ($data['CREATED_BY']==$authorizedBy)
		{	//echo '<span style="color:green;font-size: 12px">Same User Can Not Authorize</span>';
			echo "Same User Can Not Authorize";
		}
	 
	 else{ 
		 
			$funcname="spFCratesAuthorize";
			$values="?,?"; //parameters=fcrate id and anuthorized by
			$arrays=array($fcrateid,$authorizedBy);
			
			$InsertClass->proc_param_data($funcname,$values,$arrays,$conn);
			//echo '<span style="color:green;font-size: 20px">'.$InsertClass->datasave.'</span>';
			echo '<span style="color:green;font-size: 14px">'.$InsertClass->querylog.'</span>';
	 
	 }
		}
 }
 //NEPS VERIFY

else if ($cond_type=='NEPSVERIFY') {
	IF (empty($commandArray[1]))
		{	ECHO '<span style="color:red;font-size: 20px">*Please Enter NID Number...</span>';}
	ELSE
		{
			$txnCode =$CISecurity->xss_clean($commandArray[1]);
			$funcname="spCheckSubmissionStatus";
			$values="@txnCode=?";
			$arrays=array($txnCode);
			
			$InsertClass->proc_param_data($funcname,$values,$arrays,$conn);
			echo $InsertClass->datasave;
	
		}
 }

 // NEPS INDIVISUAL CUSTOMER DATA
/*  else if ($cond_type=='SHOWINDIVISUALCUSTOMER') {
	 
	$funcname="spIndivisualCustomerDataFetch";
	$values="@nIDNo=?";
	$arrays=array($commandArray[1]);
	
	$InsertClass->proc_param_data($funcname,$values,$arrays,$conn);
	echo $InsertClass->datasave;

 } */
 
else if ($cond_type=='SHOWINDIVISUALCUSTOMER') {

//IF ($nIDNo == NULL)
	IF (empty($commandArray[1]))
		{	ECHO '<span style="color:red;font-size: 20px">*Please Enter NID Number...</span>';}
	ELSE
		{
			$nIDNo=$CISecurity->xss_clean($commandArray[1]);
			$tblcaption="Customer Details";
			$colHeader="Transaction No, Birth Date, NID Number, Account Enroll Date, Customer Status,
						Account Number, Account Name, Bhata Type, Account Routing Code, Is Active, Mobile No";

			//$routing_no=$accountvalue2;
			//$br_code=$accountvalue3;
			$dataviewclass->NepsIndivisualCustomerData($tblcaption,$colHeader,$nIDNo,$baseroot,$conn);
			echo $dataviewclass->DataList;
		}
}

else if ($cond_type=='SHOWCUSTBULKDATA') {
	IF (empty($commandArray[1]))
	{	ECHO "Please Enter Date From";}
	Else IF (empty($commandArray[2]))
	{	ECHO "Please Enter Date TO";}
	Else
	{
		$dateFrom =$CISecurity->xss_clean($commandArray[1]);
		$dateTo =$CISecurity->xss_clean($commandArray[2]);
		//$dOB = date('Y-m-d',strtotime($dOB));
		//$fromDate=$commandArray[1];
		//$toDate=$commandArray[2];
		//$editlink="jbneps/jbnepsforms/neps_form/";
		$tblcaption="Customer Bulk Data";
		$colHeader="Sl#,Txn No,Birth Date,NID No,Enroll Date,Status,Acc No ,Acc Name,Bhata,Routing,isActive,Mobile No";
		//,Edit,Authorize
		$dataviewclass->form_data_list_bulk($tblcaption,$colHeader,$dateFrom,$dateTo);
		echo $dataviewclass->DataList;
	}
}

/////////////NEPS Reconcile/////////////////////////////


else if ($cond_type=='RECONCILE') {
	IF (empty($commandArray[1]))
	{ECHO "Please Enter Date From";}
	Else IF (empty($commandArray[2]))
	{ECHO "Please Enter Date TO";}
	Else IF (empty($commandArray[3]))
	{ECHO "Branch Code Not Found";}
	Else
	{	$dateFrom =$CISecurity->xss_clean($commandArray[1]);
		$dateTo =$CISecurity->xss_clean($commandArray[2]);
		$branchCode = $CISecurity->xss_clean($commandArray[3]);
		//$dOB = date('Y-m-d',strtotime($dOB));
		//$fromDate=$commandArray[1];
		//$toDate=$commandArray[2];
		//$editlink="jbneps/jbnepsforms/neps_form/";
	$tblcaption="Customer Bulk Data";
	$colHeader="Sl#,Branch Code, Branch Name, Total JBL Data, Total NEPS Data";
	//,Edit,Authorize
	$dataviewclass->form_reconcile($tblcaption,$colHeader,$dateFrom,$dateTo,$branchCode,$conn);
	echo $dataviewclass->DataList;
	}
}
//////////////////////////////////////////////////
//////////       NEPS END HERE   ////////////////
////////////////////////////////////////////////
	sqlsrv_close($conn);
?>