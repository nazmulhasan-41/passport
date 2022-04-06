<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class DataCodeView {
	var $Listlocation,$BankList,$BranchList,$YesNo; 

	function branchstatus($ctlname,$sbranch,$branch_code,$baseroot,$conn) {
            $this->branchstatus='';
	$sql="select BranchCode,BranchName,DistCode from Branch where BranchCode<>'5044' order by BranchName";
	$result=sqlsrv_query($conn,$sql);
		$this->branchstatus.="<select name=\"cmbbranch\" id=\"cmbbranch\" onChange=\"branchdetails('$ctlname','Branchstatus',this.value,'$branch_code','$baseroot')\">";
	while($row = sqlsrv_fetch_array($result)){
	if ($sbranch==$row['BranchCode']) {
	$this->branchstatus.=" <option value=\"".$row['BranchCode']."\" selected>".$row['BranchName'].' ['.$row['BranchCode']."]</option>";
	} else {
	$this->branchstatus.=" <option value=\"".$row['BranchCode']."\">".$row['BranchName'].' ['.$row['BranchCode']."]</option>";	
	}
	}
    $this->branchstatus.="</select>";
	sqlsrv_free_stmt( $result);
}

function service_provider($type,$sprovider,$baseroot,$conn) {
            $this->service_provider='';
	$sql="select * from tbl_service_provider where head_leaf='L' order by sp_code";
	$result=sqlsrv_query($conn,$sql);
                if($type=="Z")
                {
		$this->service_provider.="<select name=\"cmbservice\" id=\"cmbservice\" onChange=\"show_spzone('ctlzone','N','SPZONE',cmbservice.value,'$baseroot') \">";
                }
                else if($type=="P")
                {
                $this->service_provider.="<select name=\"cmbservice\" id=\"cmbservice\" onChange=\"show_spzone('ctlzone','ctlcmbzone','SPZONENAME',cmbservice.value,'$baseroot') \">";    
                }
	while($row = sqlsrv_fetch_array($result)){
	if ($sprovider==$row['sp_code']) {
	$this->service_provider.=" <option value=\"".$row['sp_code']."\" selected>".$row['sp_name']."</option>";
	} else {
	$this->service_provider.=" <option value=\"".$row['sp_code']."\">".$row['sp_name']."</option>";	
	}
	}
    $this->service_provider.="</select>";
	sqlsrv_free_stmt( $result);
}

function service_provider_prefix($spzonecode,$baseroot,$conn) {
            $this->service_provider='';
	$sql="select  [spzoneln],a.[sp_code],[sp_zonecode],[sp_zoneName],[sp_zonecontact],[sp_zoneaddress],b.sp_name
            from tbl_sp_zone_map a
            inner join tbl_service_provider b on a.sp_code=b.sp_code 
            order by b.sp_name,a.sp_zoneName";
	$result=sqlsrv_query($conn,$sql);
                /*if($type=="Z")
                {
		$this->service_provider.="<select name=\"cmbservice\" id=\"cmbservice\" onChange=\"show_spzone('ctlzone','N','SPZONE',cmbservice.value,'$baseroot') \">";
                }
                else if($type=="P")
                {*/
                $this->service_provider.="<select name=\"cmbservice\" id=\"cmbservice\" \">";    
                //}
	while($row = sqlsrv_fetch_array($result)){
	if ($spzonecode==$row['spzoneln']) {
	$this->service_provider.=" <option value=\"".$row['spzoneln']."\" selected>".$row['sp_name']."--> ".$row['sp_zoneName']."</option>";
	} else {
	$this->service_provider.="  <option value=\"".$row['spzoneln']."\" >".$row['sp_name']."--> ".$row['sp_zoneName']."</option>";	
	}
	}
    $this->service_provider.="</select>";
	sqlsrv_free_stmt( $result);
}



function load_payment_type($paytype,$chequeno,$conn) {
    $this->payment_type='';
	$sql="exec SP_transaction_mode_load";
	//echo $sql;
 	$result=sqlsrv_query($conn,$sql);
	$this->payment_type.="<select name=\"cmb_payment_type\" id=\"cmb_payment_type\" onchange=\"fn_enable_cheque('txt_chequeno',cmb_payment_type.value,'$chequeno')\">";
	$this->payment_type.="<option value=\"\">Select Payment Type</option>";
	while($row = sqlsrv_fetch_array($result)){
		if($paytype==$row['tr_mode'])
		{
	$this->payment_type.=" <option value=\"".$row['tr_mode']."\" selected>".$row['tr_name']."</option>";	
		}
		else
		{
	$this->payment_type.=" <option value=\"".$row['tr_mode']."\">".$row['tr_name']."</option>";
		}
	}
    $this->payment_type.="</select>";
	sqlsrv_free_stmt( $result);
}


/////////////// PASSPORT ENDORSE STARTS HERE /////////////////////

function thisbranchlist($sbranch,$br_code,$suserlevel,$conn) {
    $this->thisbranchlist='';
	if (($br_code=='5044') or ($br_code=='9999')) {
	$sql_branch = "select BranchCode,BranchName,DistCode from Branch order by BranchName";
    } else {
	$sql_branch = "select BranchCode,BranchName,DistCode from Branch where BranchCode=$sbranch order by BranchName";
    }
	$result_branch=sqlsrv_query($conn,$sql_branch);	
	$this->thisbranchlist.="<select name=\"cmbthisbranchlist\" id=\"cmbthisbranchlist\">";
	if (($br_code=='5044') or ($br_code=='9999')) {
	$this->thisbranchlist.=" <option value=\"All\">All</option>";	
	}
	while($row = sqlsrv_fetch_array($result_branch,SQLSRV_FETCH_BOTH)){
	if ($sbranch==$row['BranchCode']) {
	$this->thisbranchlist.=" <option value=\"".$row['BranchCode']."\" selected>".$row['BranchName']." [".$row['BranchCode']."]</option>";
	} else {
	$this->thisbranchlist.=" <option value=\"".$row['BranchCode']."\">".$row['BranchName']." [".$row['BranchCode']."]</option>";	
	}
	}
    $this->thisbranchlist.="</select>";
sqlsrv_free_stmt($result_branch);	
}

////List Of Company Type

function cmbCompanyTypeList($conn) {
    $this->cmbCompanyTypeList='';
	
	$sql_companyType = "SELECT [COMPANY_TYPE_ID],[COMPANY_TYPE_NAME] FROM [dbjbPassportEndorse].[dbo].[tblCompanyTypeList]";
	$result_companyType=sqlsrv_query($conn,$sql_companyType);
	
	$this->cmbCompanyTypeList.="<select name=\"cmbCompanyTypeList\" id=\"cmbCompanyTypeList\">";
	
	
	while($row = sqlsrv_fetch_array($result_companyType,SQLSRV_FETCH_BOTH)){
	
	if ($row['COMPANY_TYPE_ID']=='3'){
		$this->cmbCompanyTypeList.="<option selected value=\"".$row['COMPANY_TYPE_ID']."\">".$row['COMPANY_TYPE_NAME']."</option>";	
	}
	else
	{
		$this->cmbCompanyTypeList.="<option value=\"".$row['COMPANY_TYPE_ID']."\">".$row['COMPANY_TYPE_NAME']."</option>";
	}
	}
    $this->cmbCompanyTypeList.="</select>";
sqlsrv_free_stmt($result_companyType);	
}

////List Of Category

function cmbCategoryList($conn) {
    $this->cmbCategoryList='';
	
	$sql_categoryList = "SELECT [CATEGORY_CODE],[CATEGORY_NAME] FROM [dbjbPassportEndorse].[dbo].[tblCategoryList]";
	$result_categoryList=sqlsrv_query($conn,$sql_categoryList);
	
	$this->cmbCategoryList.="<select name=\"cmbCategoryList\" id=\"cmbCategoryList\">";
	
	
	while($row = sqlsrv_fetch_array($result_categoryList,SQLSRV_FETCH_BOTH)){
	
	if ($row['CATEGORY_CODE']=='42'){
		$this->cmbCategoryList.="<option selected value=\"".$row['CATEGORY_CODE']."\">".$row['CATEGORY_NAME']."</option>";	
	}
	else
	{
		$this->cmbCategoryList.="<option value=\"".$row['CATEGORY_CODE']."\">".$row['CATEGORY_NAME']."</option>";
	}
	
	
		
	
	}
    $this->cmbCategoryList.="</select>";
sqlsrv_free_stmt($result_categoryList);	
}
////List Of Currency

function cmbCurrencyList($conn) {
    $this->cmbCurrencyList='';
	
	$sql_currency = "SELECT CURRENCY_CODE,CURRENCY_NAME FROM [dbjbPassportEndorse].[dbo].[tblCurrencyList]";
	$result_currency=sqlsrv_query($conn,$sql_currency);
	
	$this->cmbCurrencyList.="<select name=\"cmbCurrencyList\" id=\"cmbCurrencyList\">";
	
	
	while($row = sqlsrv_fetch_array($result_currency,SQLSRV_FETCH_BOTH)){
	
	$this->cmbCurrencyList.="<option value=\"".$row['CURRENCY_CODE']."\">".$row['CURRENCY_NAME']."</option>";	
	
	}
    $this->cmbCurrencyList.="</select>";
sqlsrv_free_stmt($result_currency);	
}

////List Of Purpose

function cmbPurposeList($conn) {
    $this->cmbPurposeList='';
	
	$sql_purpose = "SELECT [PURPOSE_CODE],[DESCRIPTION] FROM [dbjbPassportEndorse].[dbo].[tblPurposeList]";
	$result_purpose=sqlsrv_query($conn,$sql_purpose);
	
	$this->cmbPurposeList.="<select name=\"cmbPurposeList\" id=\"cmbPurposeList\">";
	
	
	while($row = sqlsrv_fetch_array($result_purpose,SQLSRV_FETCH_BOTH)){
	
	if ($row['PURPOSE_CODE']=='1130'){
		$this->cmbPurposeList.="<option selected value=\"".$row['PURPOSE_CODE']."\">".$row['DESCRIPTION']."</option>";	
	}
	else
	{
		$this->cmbPurposeList.="<option value=\"".$row['PURPOSE_CODE']."\">".$row['DESCRIPTION']."</option>";
	}
	
	}
    $this->cmbPurposeList.="</select>";
sqlsrv_free_stmt($result_purpose);	
}

////List Of Country

function cmbCountryList($conn) {
    $this->cmbCountryList='';
	
	$sql_country = "SELECT[COUNTRY_CODE],[COUNTRY_NAME] FROM [dbjbPassportEndorse].[dbo].[tblCountryList]";
	$result_country=sqlsrv_query($conn,$sql_country);
	
	$this->cmbCountryList.="<select name=\"cmbCountryList\" id=\"cmbCountryList\">";
	
	
	while($row = sqlsrv_fetch_array($result_country,SQLSRV_FETCH_BOTH)){
	
	$this->cmbCountryList.="<option value=\"".$row['COUNTRY_CODE']."\">".$row['COUNTRY_NAME']."</option>";	
	
	}
    $this->cmbCountryList.="</select>";
sqlsrv_free_stmt($result_country);	
}
//Currency Rate
function usdExchangeRate($conn) {
    $this->usdExchangeRate='';
	
	$sql_country = "SELECT [Rate] FROM [dbjbPassportEndorse].[dbo].[ExchangeRate]
					UNPIVOT
				(	[Rate]
					FOR [ISO] IN (USD, CAD ,GBP,AUD,MYR,SGD,SAR,JPY,EUR,KWD,AED)
				) 	AS UPE
					WHERE [ISO]='USD' AND [SUBMISSION_STATUS]='A' AND [DATE]=CONVERT(date,GETDATE());";
	
	$result_usdExchangeRate=sqlsrv_query($conn,$sql_country);
	
	while($row = sqlsrv_fetch_array($result_usdExchangeRate,SQLSRV_FETCH_ASSOC)){
	
		$this->usdExchangeRate=$row['Rate'];	
	
	}

	sqlsrv_free_stmt($result_usdExchangeRate);	
}



//sqlsrv_close($conn);
////////////// PASSPORT ENDORSE//////////////////////

	//end class
} 
?>