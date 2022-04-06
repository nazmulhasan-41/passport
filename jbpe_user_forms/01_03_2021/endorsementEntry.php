<?php
define('BASEPATH','jbremittancehome');
session_start();
require_once('../jbpe_settings/domainsettings.php');
require_once('../jbpe_dbconn/dbmycon.php');
//$conn = sqlsrv_connect($database_hostname,$connectioninfo);

require_once('../jbpe_classes/class_call.php');

require_once('../loginfail.php');
$usermenu->user_menu($Loaduserlevel,$loginuserid,$conn,$baseroot);
//$restrictlink="jbnepsforms/neps_form/enroll.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $basicClass->SoftName; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="<?PHP echo $baseroot;?>/jbpe_lib/jrstl.css" rel="stylesheet" type="text/css"></link>
<link href="<?PHP echo $baseroot;?>/jbpe_lib/w3.css" rel="stylesheet" type="text/css"></link>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/menu.js"></script>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/globaljava.js"></script>
<script type="text/javascript" src="<?php echo $baseroot?>/datetimepicker/datetimepicker_css.js"></script>

<script type="text/javascript">
/* window.onload=function(){
  document.getElementById("txt_amnt").click();
} */
function myFunction(buttonId) {
	//alert ('onclick');
  //document.getElementById("frmIndia").submit();
	if (buttonId=='btn_submitIndia'){
	  alert ('submitting form india');
	
	form = document.getElementById("frmIndia");
	
	with (form)
	  {
	  //alert(testtype);
			if (validate_required(txt_passportnumber,"Enter Passport Number!")==false)
			{txt_passportnumber.focus();return false;}
			
			else if (validate_required(passportNo,"Enter Passport Number!")==false)
			{passportNo.focus();return false;}
			
			else if (validate_required(applicantName,"Enter Applicant's Name!")==false)
			{applicantName.focus();return false;}
			
			else if (validate_required(address,"Enter Address!")==false)
			{address.focus();return false;}
			
			else if (validate_required(passportDate,"Enter Passport Date!")==false)
			{passportDate.focus();return false;}
			
			else if (validate_required(passportIssuePlace,"Enter Passport Issue Place!")==false)
			{passportIssuePlace.focus();return false;}
			
			else if (validate_required(contactNo,"Enter Contact Number!")==false)
			{contactNo.focus();return false;}
			
			else if (validate_required(tmfor,"Select TM For!")==false)
			{tmfor.focus();return false;}
			
			else if (validate_required(txt_amnt,"Please Select Amount!")==false)
			{txt_amnt.focus();return false;}
			
			else if (validate_required(txt_total_bdt_amount,"BDT AMOUNT Blank!")==false)
			{txt_total_bdt_amount.focus();return false;}
			
			else if (validate_required(txt_total_fc_amount,"Total FC Amount!")==false)
			{txt_total_fc_amount.focus();return false;}
			
			else if (validate_required(txt_sfc_total,"Total SFC Amount!")==false)
			{txt_sfc_total.focus();return false;}
			
			else if (validate_required(cmbCompanyTypeList,"Enter Company Type!")==false)
			{cmbCompanyTypeList.focus();return false;}
			
		
	  }	
	document.getElementById("frmIndia").submit();
	//alert ('frmIndia submitted');
	  }
	  
	else {
		  alert ('submitting form frmOther'); 
		  exit;
	document.getElementById("frmOthers").submit();
	  }
  
}



function handleClick(value)
{
    //alert(document.getElementById(txtcheque).value);
	  
	if(value=='ck')
	{
		document.getElementById('txt_amnt_input').style.display = 'block';
		document.getElementById('txt_sfc_bank').value="0";
		document.getElementById('txt_total_bdt_amount').value="0";
		document.getElementById('txt_total_fc_amount').value="0";
		document.getElementById('txt_sfc_total').value="0";
		
              //  document.getElementById(txtcheque).value=chequeno;
		
	}
	else
	{
		document.getElementById('txt_amnt_input').value='0';
		document.getElementById('txt_amnt_input').style.display = 'none';
		
		exchangeRateIndia=document.getElementById('txt_exchangeRateIndia').innerText;
		//alert(exchangeRateIndia);
		
		document.getElementById('txt_sfc_bank').value=value;
		document.getElementById('txt_total_bdt_amount').value=(value*exchangeRateIndia);
		document.getElementById('txt_total_fc_amount').value=value;
		document.getElementById('txt_sfc_total').value=value;
		
		
	}
}

function sfcAmount(value)
{
  document.getElementById('txt_sfc_bank').value=value;
  
  exchangeRateIndia=document.getElementById('txt_exchangeRateIndia').innerText;
  //alert(exchangeRateIndia);
  
  document.getElementById('txt_total_bdt_amount').value=(value*exchangeRateIndia);
  document.getElementById('txt_total_fc_amount').value=value;
  document.getElementById('txt_sfc_total').value=value;
}

/* var currentValue = 0;
function handleClick(myRadio) {
	document.getElementById('txt_amnt_input').style.display = "block";
     alert('Old value: ' + currentValue);
    alert('New value: ' + myRadio.value);
    currentValue = myRadio.value; 
} */

/* $('input[type="radio"]').click(function(){
        if($(this).attr("value")=="150"){
            $(".txt_amnt_input").hide('slow');
        }
        if($(this).attr("value")=="200"){
            $(".txt_amnt_input").show('slow');

        }        
    });
$('input[type="radio"]').trigger('click');

 */
/* var currentValue = 0;
function handleClick(myRadio) {
	
	document.getElementById('txt_amnt_input').style.display = "block";
    alert('Old value: ' + currentValue);
    //alert('New value: ' + myRadio.value);
    //currentValue = myRadio.value;
//} */


function openCity(evt, cityName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " w3-red";
}
		
</script>
<style> 
select {
  width: 190px;
  padding: 3px 3px;
  border: solid 1px;
  border-radius: 2px;

}
#tmForm {
  border: 1px solid black;
  border-spacing: 5px;
  padding: 2px;
  width: 570px;
  background-color: #f1f1c1;
}
#passportForm {
  border: 1px solid black;
  border-spacing: 5px;
  padding: 2px;
  width: 570px;
  /* background-color: #f1f1c1; */
}

#passportForm th{
 text-align: center;
 color: black;
}

#passportEntryForm th{
 text-align: center;
 color: black;
}

#passportEntryForm {
  border: 1px solid black;
  border-spacing: 5px;
  padding: 2px;
  width: 570px;
  /* background-color: #f1f1c1; */
}
#button {
	margin-left: auto;
	margin-right: 60%;
/*	margin-right: auto;*/
	text-align: center;
	background-color: #f1f1c1;
}

</style>
</head>
<body class="bodybox" onLoad="Timestart();//month_load();"> 
<center>
  <table width="100%"  border="0" class="indexbox">
     <tr>
       <td><?PHP echo $basicClass->topmenu;?>
	   </td>
     </tr>
     <tr>
       <td><div class="tbg" style="height:22px"><div class="tbg" align="center"><?php  echo $usermenu->menu; ?></div></div>
	   </td>
     </tr>
     <tr>
       <td><div align="center"><?php  //$usermenu->restricpage($loginuserid,$Loaduserlevel,$restrictlink,$systemstatus,$connectioninfo_jbrps);?></div>       
       </td>
	   <tr>
	   <td>
				<?php
						
						
						$createdBy = (string)$_SESSION['loginID'];
						$logedinUserName = (string)$_SESSION['userID'];
						$branchCode = (string)$_SESSION['userjblocat'];
						
						$passportNo="";
						$contactNo="";
						$amount="";
						$amountArr=array(150,200);
						/* $OnclickAmount='<script>
							document.getElementById("txt_amnt_200").click();
							</script>'; */
						
						//if (empty($commandArray[0])){
						
						$codeviewclass->cmbCurrencyList($conn);
						$currency_list=$codeviewclass->cmbCurrencyList;
						
						$codeviewclass->cmbPurposeList($conn);
						$purposeList =$codeviewclass->cmbPurposeList;
						
						$codeviewclass->cmbCountryList($conn);
						$countryList =$codeviewclass->cmbCountryList;
						
						$codeviewclass->cmbCompanyTypeList($conn);
						$companyTypeList =$codeviewclass->cmbCompanyTypeList;
						
						$codeviewclass->cmbCategoryList($conn);
						$categoryList =$codeviewclass->cmbCategoryList;
						
						$codeviewclass->usdExchangeRate($conn);
						$exchangeRate =$codeviewclass->usdExchangeRate;
						//}
						
						//else {
							
						//}
						
						//print_r($exchangeRate);
						
						//$exchangeRate="Rate";
						
						/* $currency_list="";
						$purposeList="";
						$countryList="";
						$companyTypeList="";
						$categoryList=""; */
						
				if ($_SERVER["REQUEST_METHOD"] == "POST") {	
		//Passport Info Starts			
				//echo "From Submitted"; exit;
						if (isset($_POST["txt_passportnumber"])) $srcPassportNumber=(string)$_POST["txt_passportnumber"];
						$srcPassportNumber = $CISecurity->xss_clean($srcPassportNumber);
						$InsertClass->isEmpty($srcPassportNumber,"Passport Number is Blank !!!");
						$srcPassportNumber = $CISecurity->xss_clean($srcPassportNumber);
						
						if (isset($_POST["passportNo"])) $passportNumber=(string)$_POST["passportNo"];
						$passportNumber = $CISecurity->xss_clean($passportNumber);
						$InsertClass->isEmpty($passportNumber,"Passport Number is Blank !!!");
						$passportNumber = $CISecurity->xss_clean($passportNumber);
						
						if (isset($_POST["applicantName"])) $applicantName=(string)$_POST["applicantName"];
						$applicantName = $CISecurity->xss_clean($applicantName);
						$InsertClass->isEmpty($applicantName,"Applicant Name is Blank !!!");
						$applicantName = $CISecurity->xss_clean($applicantName);
						
						if (isset($_POST["address"])) $address=(string)$_POST["address"];
						$address = $CISecurity->xss_clean($address);
						$InsertClass->isEmpty($address,"Customer's First Name is Blank !!!");
						$address = $CISecurity->xss_clean($address);
						
						/* if (isset($_POST["passportDate"])) $passportDate=(string)$_POST["passportDate"];
						$passportDate = $CISecurity->xss_clean($passportDate);
						$InsertClass->isEmpty($passportDate,"Passport Date is Blank !!!");
						$passportDate = $CISecurity->xss_clean($passportDate); */
						
						if (isset($_POST["passportDate"])) 
						$passportDate=$_POST["passportDate"];
						$passportDate = $CISecurity->xss_clean($passportDate);
						$InsertClass->isEmpty($passportDate, "Please Passport Date!");
						$passportDate = date('Y-m-d',strtotime($passportDate));
						
						if (isset($_POST["passportIssuePlace"])) $passportIssuePlace=(string)$_POST["passportIssuePlace"];
						$passportIssuePlace = $CISecurity->xss_clean($passportIssuePlace);
						$InsertClass->isEmpty($passportIssuePlace,"Passport Issue Place is Blank !!!");
						$passportIssuePlace = $CISecurity->xss_clean($passportIssuePlace);
		//Passport Info Ends				
						if (isset($_POST["tmfor"])) $tmFor=(string)$_POST["tmfor"];
						$tmFor = $CISecurity->xss_clean($tmFor);
						$InsertClass->isEmpty($tmFor,"TM For is Blank !!!");
						$tmFor = $CISecurity->xss_clean($tmFor);
						
						if (isset($_POST["currency"])) $currencyCode=(string)$_POST["currency"];
						$currencyCode = $CISecurity->xss_clean($currencyCode);
						$InsertClass->isEmpty($currencyCode,"Currency is Blank !!!");
						$currencyCode = $CISecurity->xss_clean($currencyCode);
						
						if (isset($_POST["cmbCountryList"])) $countryCode=(string)$_POST["cmbCountryList"];
						$countryCode = $CISecurity->xss_clean($countryCode);
						$InsertClass->isEmpty($countryCode,"Please Select Country !!!");
						$countryCode = $CISecurity->xss_clean($countryCode);
						
						// txt_amnt  or $amount should be decimal
						if (isset($_POST["txt_amnt"])) $amount=(string)$_POST["txt_amnt"];
						$amount = $CISecurity->xss_clean($amount);
						$InsertClass->isEmpty($amount,"Amount is Blank !!!");
						$amount = $CISecurity->xss_clean($amount);
						
						// txt_total_fc_amount  or $totlaFcAmount should be decimal
						if (isset($_POST["txt_total_fc_amount"])) $totlaFcAmount=(string)$_POST["txt_total_fc_amount"];
						$totlaFcAmount = $CISecurity->xss_clean($totlaFcAmount);
						$InsertClass->isEmpty($totlaFcAmount,"Total FC Amount is Blank !!!");
						$totlaFcAmount = $CISecurity->xss_clean($totlaFcAmount);
						
						// txt_total_bdt_amount  or $totalBdtAmount should be decimal 
						if (isset($_POST["txt_total_bdt_amount"])) $totalBdtAmount=(string)$_POST["txt_total_bdt_amount"];
						$totalBdtAmount = $CISecurity->xss_clean($totalBdtAmount);
						$InsertClass->isEmpty($totalBdtAmount,"Total BDT. Amount is Blank !!!");
						$totalBdtAmount = $CISecurity->xss_clean($totalBdtAmount);
						
						if (isset($_POST["txt_sfc_bank"])) $sfcBank=(string)$_POST["txt_sfc_bank"];
						$sfcBank = $CISecurity->xss_clean($sfcBank);
						$InsertClass->isEmpty($sfcBank,"SFC BANK AMOUNT is Blank !!!");
						$sfcBank = $CISecurity->xss_clean($sfcBank);
						
						//txt_sfc_total or sfcTotal should be in decimal 
						if (isset($_POST["txt_sfc_total"])) $sfcTotal=(string)$_POST["txt_sfc_total"];
						$sfcTotal = $CISecurity->xss_clean($sfcTotal);
						$InsertClass->isEmpty($sfcTotal,"SFC Total is Blank !!!");
						$sfcTotal = $CISecurity->xss_clean($sfcTotal);
						
						if (isset($_POST["cmbPurposeList"])) $purposeCode=(string)$_POST["cmbPurposeList"];
						$purposeCode = $CISecurity->xss_clean($purposeCode);
						$InsertClass->isEmpty($purposeCode,"Purpose is Blank !!!");
						$purposeCode = $CISecurity->xss_clean($purposeCode);
						
						if (isset($_POST["cmbCompanyTypeList"])) $companyTypeCode=(string)$_POST["cmbCompanyTypeList"];
						$companyTypeCode = $CISecurity->xss_clean($companyTypeCode);
						$InsertClass->isEmpty($companyTypeCode,"Company Type Blank !!!");
						$companyTypeCode = $CISecurity->xss_clean($companyTypeCode);
						
						if (isset($_POST["cmbCategoryList"])) $categoryTypeCode=(string)$_POST["cmbCategoryList"];
						$categoryTypeCode = $CISecurity->xss_clean($categoryTypeCode);
						$InsertClass->isEmpty($categoryTypeCode,"Category is Blank !!!");
						$categoryTypeCode = $CISecurity->xss_clean($categoryTypeCode);
						
						if (isset($_POST["contactNo"])) $contactNo=(string)$_POST["contactNo"];
						$contactNo = $CISecurity->xss_clean($contactNo);
						$InsertClass->isEmpty($contactNo,"Customer's Contact Number is Blank !!!");
						$contactNo = $CISecurity->xss_clean($contactNo);
						
						
					IF($countryCode=="1100"){
						//echo $countryCode."India"; exit;
						IF($tmFor == "T"){
							
							$effectedRemittance=$totlaFcAmount;
							
							$beneficiaryDetails="NA";
							$fxManualPara="CHAPTER-10";
							$bbApprovalNo="NA";
							$approvalDate="NA";
							
							$mopCash=$totlaFcAmount;
							$mopTc="NA";
							$mopCard="NA";
							$mopFdd="NA";
							$mopMt="NA";
							$mopOther="NA";
							
							$sfcBank =$sfcTotal;
							$sfcFcAc="NA";
							$sfcErq="NA";
							$sfcOther="NA";
							$passportRenewalDate="NA";

							$funcname="spCrudTM";
                    
							$values =" @tranType=?			,@branchCode=?			,@passportNumber=?		,@tmFor=?
									  ,@currencyCode=?		,@countryCode=?			,@purposeCode=?			,@beneficiaryDetails=?
									  ,@applicantName=?		,@applicantAddress=?	,@effectedRemitance=?	,@fxManualPara=?
									  ,@bbAprovalNo=?		,@approvalDate=?		,@categoryCode=?		,@companyTypeId=?
									  ,@mopCash=?			,@mopTc=?				,@mopCard=?				,@mopFdd=?
									  ,@mopMt=?				,@mopOther=?			,@sfcBank=?				,@sfcFcAc=?	
									  ,@sfcErq=?			,@sfcOther=?			,@amountInBdt=?			,@contactNo=?
									  ,@passportDate=?		,@passportIssuePlace=?	,@createdBy=?			,@passportRenewalDate=? 
									  ,@peTxnId=? ";			
									  
									  
							//,@peTxnId=?
							if (empty($commandArray[0])){
							$arrays = array('I'					,$branchCode		  	,$passportNumber	  ,$tmFor
											,$currencyCode		,$countryCode		  	,$purposeCode		  ,$beneficiaryDetails
											,$applicantName		,$address			    ,$effectedRemittance  ,$fxManualPara
											,$bbApprovalNo		,$approvalDate		    ,$categoryTypeCode	  ,$companyTypeCode
											,$mopCash			,$mopTc					,$mopCard			  ,$mopFdd
											,$mopMt				,$mopOther				,$sfcBank			  ,$sfcFcAc
											,$sfcErq			,$sfcOther				,$totalBdtAmount	  ,$contactNo
											,$passportDate		,$passportIssuePlace	,$createdBy			  ,$passportRenewalDate
											,NULL
										);				
							}
							else if (isset($commandArray[0])) {
							$arrays = array('U'					,$branchCode		  	,$passportNumber	  ,$tmFor
											,$currencyCode		,$countryCode		  	,$purposeCode		  ,$beneficiaryDetails
											,$applicantName		,$address			    ,$effectedRemittance  ,$fxManualPara
											,$bbApprovalNo		,$approvalDate		    ,$categoryTypeCode	  ,$companyTypeCode
											,$mopCash			,$mopTc					,$mopCard			  ,$mopFdd
											,$mopMt				,$mopOther				,$sfcBank			  ,$sfcFcAc
											,$sfcErq			,$sfcOther				,$totalBdtAmount	  ,$contactNo
											,$passportDate		,$passportIssuePlace	,$createdBy			  ,$passportRenewalDate	
											,$commandArray[0]
										);	
										//print_r($arrays);
										//EXIT;
							}
							
							$InsertClass->proc_param_data($funcname,$values,$arrays,$conn);
							
							//echo $InsertClass->querylog;
							echo "<span style=\"color:red;font-size: 20px\">".$InsertClass->querylog."</span>";
				//SET Variable Value Null
							$msgToClearVariableTM ='Data(TM) Saved Successfully';
							$msgToClearVariablePPTM ='*Passport Saved*TM Data Saved Successfully';
							
							$msgToClearVariableUpdatePP ='TM Data Updated Successfully';
							$msgToClearVariableUpdatePPTM ='*Passport Updated*TM Data Updated Successfully';
							
							if ((strcmp($msgToClearVariableTM,$InsertClass->querylog)==0) OR (strcmp($msgToClearVariablePPTM,$InsertClass->querylog)==0)){
										$branchCode=$passportNumber=$tmFor=$currencyCode=$countryCode=$purposeCode=$beneficiaryDetails='';
										$applicantName=$address=$effectedRemittance=$fxManualPara=$bbApprovalNo=$approvalDate='';
										$categoryTypeCode=$companyTypeCode=$mopCash	=$mopTc	=$mopCard=$mopFdd=$mopMt='';
										$mopOther=$sfcBank=$sfcFcAc=$sfcErq	=$sfcOther	=$totalBdtAmount=$contactNo='';
										$passportDate=$passportIssuePlace=$createdBy=$passportRenewalDate='';

								if (isset($_POST["txt_passportnumber"],$_POST["passportNo"],$_POST["applicantName"],$_POST["address"],
											$_POST["passportDate"],$_POST["passportIssuePlace"],$_POST["tmfor"],$_POST["currency"],
											$_POST["cmbCountryList"],$_POST["txt_amnt"],$_POST["txt_total_fc_amount"],$_POST["txt_total_bdt_amount"],
											$_POST["txt_sfc_bank"],$_POST["txt_sfc_total"],$_POST["cmbPurposeList"],$_POST["cmbCompanyTypeList"],
											$_POST["cmbCategoryList"],$_POST["contactNo"])){
									unset($_POST["txt_passportnumber"],$_POST["passportNo"],$_POST["applicantName"],$_POST["address"],
											$_POST["passportDate"],$_POST["passportIssuePlace"],$_POST["tmfor"],$_POST["currency"],
											$_POST["cmbCountryList"],$_POST["txt_amnt"],$_POST["txt_total_fc_amount"],$_POST["txt_total_bdt_amount"],
											$_POST["txt_sfc_bank"],$_POST["txt_sfc_total"],$_POST["cmbPurposeList"],$_POST["cmbCompanyTypeList"],
											$_POST["cmbCategoryList"],$_POST["contactNo"]);
										} 

									echo "<script>if ( window.history.replaceState ) {
									window.history.replaceState( null, null, window.location.href );}
								</script>";
						
							}
							else If ((strcmp($msgToClearVariableUpdatePP,$InsertClass->querylog)==0) OR (strcmp($msgToClearVariableUpdatePPTM,$InsertClass->querylog)==0)){
										$branchCode=$passportNumber=$tmFor=$currencyCode=$countryCode=$purposeCode=$beneficiaryDetails='';
										$applicantName=$address=$effectedRemittance=$fxManualPara=$bbApprovalNo=$approvalDate='';
										$categoryTypeCode=$companyTypeCode=$mopCash	=$mopTc	=$mopCard=$mopFdd=$mopMt='';
										$mopOther=$sfcBank=$sfcFcAc=$sfcErq	=$sfcOther	=$totalBdtAmount=$contactNo='';
										$passportDate=$passportIssuePlace=$createdBy=$passportRenewalDate='';

										if (isset($_POST["txt_passportnumber"],$_POST["passportNo"],$_POST["applicantName"],$_POST["address"],
											$_POST["passportDate"],$_POST["passportIssuePlace"],$_POST["tmfor"],$_POST["currency"],
											$_POST["cmbCountryList"],$_POST["txt_amnt"],$_POST["txt_total_fc_amount"],$_POST["txt_total_bdt_amount"],
											$_POST["txt_sfc_bank"],$_POST["txt_sfc_total"],$_POST["cmbPurposeList"],$_POST["cmbCompanyTypeList"],
											$_POST["cmbCategoryList"],$_POST["contactNo"])){
											unset($_POST["txt_passportnumber"],$_POST["passportNo"],$_POST["applicantName"],$_POST["address"],
											$_POST["passportDate"],$_POST["passportIssuePlace"],$_POST["tmfor"],$_POST["currency"],
											$_POST["cmbCountryList"],$_POST["txt_amnt"],$_POST["txt_total_fc_amount"],$_POST["txt_total_bdt_amount"],
											$_POST["txt_sfc_bank"],$_POST["txt_sfc_total"],$_POST["cmbPurposeList"],$_POST["cmbCompanyTypeList"],
											$_POST["cmbCategoryList"],$_POST["contactNo"]);
										}

							echo '<script>if ( window.history.replaceState ) {
									window.history.replaceState( null, null,"'.$baseroot.'/jbnepsforms/neps_form/enroll.php");}
								</script>';
							
							} 
							else{
								echo "<span style=\"color:red;font-size: 20px\">".$InsertClass->querylog."</span>";
								}
						}
						
						ELSE {
							echo "Not Implemented Yet";
						}
						
						
						
					}
					ELSE {
						
						echo "Implement For Other"; 
						
					}					
						
					
				   }
				   
				ELSE{
						/* $codeviewclass->cmbCurrencyList($conn);
						$currency_list=$codeviewclass->cmbCurrencyList;
						
						$codeviewclass->cmbPurposeList($conn);
						$purposeList =$codeviewclass->cmbPurposeList;
						
						$codeviewclass->cmbCountryList($conn);
						$countryList =$codeviewclass->cmbCountryList;
						
						$codeviewclass->cmbCompanyTypeList($conn);
						$companyTypeList =$codeviewclass->cmbCompanyTypeList;
						
						$codeviewclass->cmbCategoryList($conn);
						$categoryList =$codeviewclass->cmbCategoryList; */
						
						if(isset($commandArray[0])){ 			
							 $peTxnId = $CISecurity->xss_clean($commandArray[0]);	
							 //echo $peTxnId;
							 
						 $sql="SELECT pp.[PASSPORT_NO]
									,pp.[CITIZEN_NAME]
									,pp.[ADDRESS]
									,convert(varchar, pp.[PASSPORT_DATE], 110) [PASSPORT_DATE]
									,pp.[PASSPORT_ISSUE_PLACE]
									,tm.[CONTACT_NO]
									,tm.[TM_FOR]
									,tm.[MOP_CASH]
									,tm.[AMOUNT_IN_BDT]
									,pr.[PURPOSE_CODE]
									,com.[COMPANY_TYPE_ID]
									,cat.[CATEGORY_CODE]
									,tm.PE_TXN_ID
									,tm.CREATED_BY
							FROM
									[dbjbPassportEndorse].[dbo].[tblpassport] pp
								JOIN
									[dbjbPassportEndorse].[dbo].[tblTMData] tm
								ON
									pp.PASSPORT_NO=tm.PASSPORT_NO
								JOIN
									[dbjbPassportEndorse].[dbo].[tblPurposeList] pr
								ON
									tm.[PURPOSE_CODE]=pr.[PURPOSE_CODE]
								JOIN
									[dbjbPassportEndorse].[dbo].[tblCompanyTypeList] com
								ON
									tm.[COMPANY_TYPE_ID]=com.[COMPANY_TYPE_ID]
								JOIN
									[dbjbPassportEndorse].[dbo].[tblCategoryList] cat
								ON
									tm.[CATEGORY_CODE] = cat.[CATEGORY_CODE]
							where tm.PE_TXN_ID=".$peTxnId."AND tm.TRAN_STATE='R'" ;
							
							$result_list = sqlsrv_query($conn,$sql);
								
								while($row_list = sqlsrv_fetch_array($result_list))
										{
											$passportNo=$row_list['PASSPORT_NO'];
											$contactNo=$row_list['CONTACT_NO'];
											$amount=intval($row_list['MOP_CASH']);
											//$amount= 100;
											$purposeCode=$row_list['PURPOSE_CODE'];
											$categoryTypeCode=$row_list['CATEGORY_CODE'];
											$companyTypeCode=$row_list['COMPANY_TYPE_ID'];
											//echo "<br>Amount:".$amount;
											/*  $custFirstName=$row_list['custFirstName'];
											 $custLastName=$row_list['custLasttName']; 
											 $dOB=$row_list['dOB'];
											 $nIDNo=$row_list['nIDNo']; 
											 $custFatherName=$row_list['custFatherName'];
											 $custMotherName=$row_list['custMotherName'];
											 $accNo=$row_list['accNo'];
											 $accName=$row_list['accName']; 
											 $prodTypeKey=$row_list['prodTypeKey']; 
											 $mobNo=$row_list['mobNo']; */
										}						
						//$isReadonly='readonly';	
					
						sqlsrv_free_stmt($result_list);	
				echo "<script>
						window.onload=function(){
							document.getElementById(\"btn_showPassportInfo\").click();
							document.getElementById(\"btn_showPassportInfo\").disabled = true;
							
							amount = {$amount};
							if (amount==150)
							{document.getElementById(\"txt_amnt_150\").click();}
							else if ((amount==200))
							{document.getElementById(\"txt_amnt_200\").click();}
							else{
								document.getElementById(\"txt_amnt_ck\").click();
								document.getElementById(\"txt_amnt_input\").value = amount;
								sfcAmount(amount);
							}
							
							document.getElementById('cmbPurposeList').value= {$purposeCode};
							document.getElementById('cmbCompanyTypeList').value= {$companyTypeCode};
							document.getElementById('cmbCategoryList').value= {$categoryTypeCode};
						}
						</script>";						
							 
							// exit;
								/* $sql="SELECT [custFirstName]
										,[custLasttName]
										,convert(varchar, [dOB], 110) dOB
										,[nIDNo]
										,[custFatherName]
										,[custMotherName]
										,[accNo]
										,[accName]
										,[prodTypeKey]
										,[mobNo]
									 FROM	[dbjbneps].[dbo].[nepsCustEnroll] 
									 WHERE [bankOrgTxnCode]='".$bankOrgTxnCode."'"; 
								$result_list = sqlsrv_query($conn,$sql);
								
								while($row_list = sqlsrv_fetch_array($result_list))
										{
											
											 $custFirstName=$row_list['custFirstName'];
											 $custLastName=$row_list['custLasttName']; 
											 $dOB=$row_list['dOB'];
											 $nIDNo=$row_list['nIDNo']; 
											 $custFatherName=$row_list['custFatherName'];
											 $custMotherName=$row_list['custMotherName'];
											 $accNo=$row_list['accNo'];
											 $accName=$row_list['accName']; 
											 $prodTypeKey=$row_list['prodTypeKey']; 
											 $mobNo=$row_list['mobNo'];
										}						
						//$isReadonly='readonly';		
						sqlsrv_free_stmt($result_list);*/
						}
					}
						
		
				?>
	   
	   </td>
	   </tr>
     </tr>
     <tr>
       <td>
         

 <div class="w3-container">
  <div class="w3-bar w3-blue">
    <button class="w3-bar-item w3-button tablink w3-red" onclick="openCity(event,'India')">India</button>
    <button class="w3-bar-item w3-button tablink" onclick="openCity(event,'Others')">Others</button>
  
  </div>
  <!-- 
  ################# INDIA STARTS #####################
  -->
  <div id="India" class="w3-container w3-border city">
		<form action=" " method="post" enctype="multipart/form-data" id="frmIndia" name="frmIndia">
			
				
		 <!-- <input type="hidden" name="frmIndia" value="frmIndia"/>  -->
		<table width="100%" border="0" class="indexbox">
		<tr>
			<td style="align:left;">
				<table id="tmForm">
					<tr>
						<td> 	<label class="w3-text-teal w3-text-black"><b>Passport Number</b></label>
								
						</td>
						<td>
								<input name="txt_passportnumber" type="text" id="txt_passportnumber"  value="<?PHP echo $passportNo;?>" size="20" autocomplete="off"  placeholder="Passport Number ?"  required />
								<input type="button" name="btn_showPassportInfo" id="btn_showPassportInfo" value="Show" onclick="showPassportInfo('showPassportInfo',txt_passportnumber.value,'<?php echo $baseroot;?>');return false;" />
								<span class="error" >*</span>
						</td>
					</tr>
					
					<tr>
						<td> 	<label class="w3-text-teal w3-text-black"><b>Mobile Number</b></label>
								
						</td>
						<td><input name="contactNo" type="text" id="contactNo" onkeyup="IsNumericInt(this);" value="<?PHP echo $contactNo;?>"  autocomplete="off"  placeholder="Contact/Mobile Number?"  maxlength="11"/><span class="error">**Contact Number**</span></td>	
						</td>
					</tr>
					
					<tr hidden>	
						<td>
								<label class="w3-text-teal w3-text-black"><b>Currency</b></label>
								
						</td>
						<td >
								<!--<input name="txt_currency" type="text" id="txt_currency"  value="1" size="20" autocomplete="off"  placeholder="CURRENCY For?" readonly required /> -->
								 <select id="currency" name="currency">
									  <option value="1" selected>USD</option>
								</select>
								
								<?PHP //echo $currency_list;?>
								
						</td>
					</tr>
					<tr>
						<td>
								<label class="w3-text-teal w3-text-black"><b>Amount($USD)</b></label>
						</td>
						<!-- <td>
								<input name="txt_TM" type="text" id="txt_TM"  value="<?PHP //echo $tm;?>" size="20" autocomplete="off"  placeholder="TM For?"  required />
						</td> -->
						<td >
							   <label>
							   <input type="radio" name="txt_amnt" id="txt_amnt_150" value="150" onclick="handleClick(this.value);"  <?PHP  if ($amount==150) {echo "checked";}?> /><?PHP // if ($amount==150) {echo $OnclickAmount;}?>
							   $150
							   </label>
							   
							   <label>
							   <input type="radio" name="txt_amnt" id="txt_amnt_200" value="200" onclick="handleClick(this.value);" <?PHP if ($amount==200) {echo "checked";}?> /><?PHP // if ($amount==200) {echo $OnclickAmount;}?>
							   $200
							   </label>
							   
							   <label>
							   <input type="radio" name="txt_amnt" id="txt_amnt_ck" value="ck"  onclick="handleClick(this.value);" <?PHP if (!empty($amount) AND !in_array($amount, $amountArr)) {echo "checked";}?> />
							   Other Amount
							   <input name="txt_amnt_input" type="number" id="txt_amnt_input" onkeyup="sfcAmount(this.value)" value="<?PHP //echo $tm;?>" size="20" autocomplete="off"  placeholder="Amount in USD?" hidden required />
							   </label>
								<span class="error" >*1 USD=<span class="error" id="txt_exchangeRateIndia" ><?PHP echo $exchangeRate;?></span> BDT</span>
							</td>
					</tr>
					
					
					<tr>
						<td>
								<label class="w3-text-teal w3-text-black"><b>TM For</b></label>
								
						</td>
						<td>
						<!--	<input name="txt_tm" type="text" id="txt_tm"  value="<?PHP //echo $tm;?>" size="20" autocomplete="off"  placeholder="TM For?"  required /> -->
								 <select id="tmfor" name="tmfor" readonly >
									  <option value="T" selected>Travel</option>
								</select>
						</td>
					</tr>
					
					<tr hidden >
						<td >
								<label class="w3-text-teal w3-text-black"><b>Country</b></label>
						</td>
						<td>
						<!--		<input name="txt_country" type="text" id="txt_country"  value="<?PHP //echo $tm;?>" size="20" autocomplete="off"  placeholder="Country"  required /> -->
								 <select id="cmbCountryList" name="cmbCountryList">
									  <option value="1100" selected>INDIA</option>
								</select>
								<?PHP //echo $countryList;?>
						</td>
					</tr>
					
					<tr hidden>
						<td>
								<label class="w3-text-teal w3-text-black"><b>Total FC Amount</b></label>
						</td>
						<td>
								<input name="txt_total_fc_amount" type="text" id="txt_total_fc_amount"  value="<?PHP //echo $tm;?>" size="20" autocomplete="off"  placeholder="Total FC Amount?"  required />
						</td>
					</tr>
					<tr>
						<td>
								<label class="w3-text-teal w3-text-black"><b>Total Amount In BDT.</b></label>
						</td>
						<td>
								<input name="txt_total_bdt_amount" type="text" id="txt_total_bdt_amount"  value="<?PHP //echo $tm;?>" size="20" autocomplete="off"  placeholder="Total Amount In BDT?" readonly required />
						</td>
					</tr>
					<tr hidden>
						<td colspan='2'>
								<label class="w3-text-teal w3-text-black"><b>Source Of Fund</b></label>
						</td>
					</tr>
					<tr hidden>	
						<td>
								<label class="w3-text-teal w3-text-black"><b>Bank</b></label>
						</td>
						<td>
								<input name="txt_sfc_bank" type="text" id="txt_sfc_bank"  value="150" size="20" autocomplete="off"  placeholder="SFC Bank" readonly required />
						</td>
					</tr>
					<tr hidden>	
						<td>
								<label class="w3-text-teal w3-text-black"><b>SFC Total</b></label>
						</td>
						<td>
								<input name="txt_sfc_total" type="text" id="txt_sfc_total"  value="" size="20" autocomplete="off"  placeholder="SFC Total" readonly required />
						</td>
					</tr>
					<tr >	
						<td>
								<label class="w3-text-teal w3-text-black"><b>Purpose Code</b></label>
						</td>
						<td>
							<!--	<input name="txt_purpose_code" type="text" id="txt_purpose_code"  value="" size="20" autocomplete="off"  placeholder="Purpose Code" readonly required /> -->
						<?PHP echo $purposeList;?>
						</td>
					</tr>
					<tr>	
						<td>
								<label class="w3-text-teal w3-text-black"><b>Company Type</b></label>
						</td>
						<td>
						<!--		<input name="txt_company_type" type="text" id="txt_company_type"  value="" size="20" autocomplete="off"  placeholder="Company Type" readonly required /> -->
						
						<?PHP echo $companyTypeList;?>
						</td>
					</tr>
					<tr>	
						<td>
								<label class="w3-text-teal w3-text-black"><b>Category</b></label>
						</td>
						<td>
						<!--		<input name="txt_company_type" type="text" id="txt_company_type"  value="" size="20" autocomplete="off"  placeholder="Company Type" readonly required /> -->
						
						<?PHP echo $categoryList;?>
						</td>
					</tr>
				</table>
			</td>
			
			<td style="align:right;" width=570px>
			
				<SPAN id="showPassportInfo" ><?php //echo $zone;?> &nbsp</SPAN>
				<br>
				<SPAN id="" >1**Message</SPAN>
				<br>
				<SPAN id="" >2**Message</SPAN>
			</td>
		</tr>
		</table>
		
		<div >
		<input type="button" name="btn_submitIndia" id="btn_submitIndia" value="SAVE" onclick="myFunction(this.id)" class="w3-btn w3-block w3-teal" form="frmIndia" />	
		</div>
		</form>
		
  </div>
  <!-- 
  ################# INDIA ENDS  #####################
  -->
   <div id="Others" class="w3-container w3-border city" style="display:none">
	  <form action="" method="post" enctype="multipart/form-data"  id="frmOthers" name="frmOthers" >
		<h2>Others</h2>
		<p>Form For Others</p> 
		<div >
		<input type="button" name="btn_submitOthers" id="btn_submitOthers" value="SAVE" onclick="myFunction(this.id)" class="w3-btn w3-block w3-teal" form="frmOthers" />	
		</div>
	  </form>
  </div>
  
  
  
  
       </td>
     </tr>

  </table>
  <div align="center"><?PHP //echo $basicClass->bottommenu;
									echo '<table width="100%"  border="0" class="tbg">
											<tr>
											<td class="tbg"><div align="center"><a href=\''.$baseroot.'/jbneps_help/usermanual.php\' target=\'_blank\'><strong><font color="#FFFFFF">User\'s Manual</font></strong></a>  </div></td>
											</tr>
										</table>';
								?>
			</div>
</center>
</body>

</html>


<?PHP
sqlsrv_close($conn);
?>