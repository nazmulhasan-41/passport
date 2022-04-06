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


<link href="<?PHP echo $baseroot;?>/jbpe_lib/jrstl.css" rel="stylesheet" type="text/css"></link>
<link href="<?PHP echo $baseroot;?>/jbpe_lib/w3.css" rel="stylesheet" type="text/css"></link>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/menu.js"></script>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/globaljava.js"></script>
<script type="text/javascript" src="<?php echo $baseroot?>/datetimepicker/datetimepicker_css.js"></script>

<script type="text/javascript">

</script>
<style>
#authorizeList td{
  
  border: 1px solid Aqua;
  border-spacing: 1px;
  padding: 2px;
  vertical-align: middle;
 /*background-color: #f1f1c1;
	Width: 100%;
	width: 570px;
 */
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
     </tr>
     <tr>
       <td>
         <form action="" method="post" enctype="multipart/form-data" name="frmupload" >  
						<?php
						//$tranType = 'I';
						//$createdBy = (string)$_SESSION['loginID'];
						$createdBy = $_SESSION['userjbremtt'];
						$logedinUserName = (string)$_SESSION['userID'];
						$branchCode = (string)$_SESSION['userjblocat'];
						?>		 
            <table width="100%"  cellspacing="0" cellpadding="0" class="msgbox">
                <tr>
                 <!-- <td width="100%" colspan="12" class="tbg" style="color:red;"><strong>Unauthorize Customer List</strong>
				  </td>
				  -->
				    <td >
						<?PHP
							  //$examid='';
							$codeviewclass->usdExchangeRate($conn);
							$exchangeRate =$codeviewclass->usdExchangeRate;
							if (empty($exchangeRate)){
								echo "<span style=\"color:red;font-size: 25px\">Notice: Module Not Active: Today's Exchange Rate Hasn't been Set Yet!!!!</span>";  
								$fcRateEntry=$baseroot+"/jbpe_user_forms/fcRateIssue.php";
								//header("location:".$fcRateEntry."");
								exit();
							}
						
							else {
							  $editlink="jbneps/jbnepsforms/neps_form/";
							  $tblcaption="Passport Endorsement Waiting List";
							  //$colHeader="Cust First Name,Cust Last Name,Birth Date,NID Number,Father Name,Mother Name,Acc Number,Acc Name,Routing Number,Mobile No,Bhata Type,EDIT";
							  //,Edit,Authorize
							  $colHeader="Passport No,Applicant Name,Address,PP Issue Date,PP Issue Place,Contact No,TM For,Amount Fr Curr.,Amount BDT.,Purpose,Company,Category,Reject";
						
								$sql="SELECT pp.[PASSPORT_NO]
										,pp.[CITIZEN_NAME]
										,pp.[ADDRESS]
										,convert(varchar, pp.[PASSPORT_DATE], 105) [PASSPORT_DATE]
										,pp.[PASSPORT_ISSUE_PLACE]
										,tm.[CONTACT_NO]
										,tm.[TM_FOR]
										,tm.[MOP_CASH]
										,tm.[AMOUNT_IN_BDT]
										,pr.[DESCRIPTION]+'('+pr.[PURPOSE_CODE]+')' AS [PURPOSE]
										,com.[COMPANY_TYPE_NAME]+'('+com.[COMPANY_TYPE_ID]+')' AS [COMPANY_TYPE]
										,cat.CATEGORY_NAME+'('+cat.CATEGORY_CODE+')' AS [CATEGORY]
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
								where tm.BRANCH_CODE='".$branchCode."' AND tm.TRAN_STATE='R'
								AND tm.[TM_DATE]=convert(date, getdate())" ;
								
							   $dataviewclass->pe_endoesement_edit($tblcaption,$colHeader,$sql,$editlink,$baseroot,$conn);
							   echo $dataviewclass->DataList;
							}
							?>
					</td>
                </tr>
                 
             </table>
         </form>
       </td>
     </tr>
     <tr>
       <td><div align="center"><?PHP //echo $basicClass->bottommenu;
									echo '<table width="100%"  border="0" class="tbg">
											<tr>
											<td class="tbg"><div align="center"><a href=\''.$baseroot.'/jbpe_help/usermanual.php\' target=\'_blank\'><strong><font color="#FFFFFF">User\'s Manual</font></strong></a>  </div></td>
											</tr>
										</table>';
								?>
	</div></td>
     </tr>
  </table>
</center>
</body>
</html>
<?PHP
sqlsrv_close($conn);
?>