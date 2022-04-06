<?php
define('BASEPATH','jbremittancehome');
session_start();
include '../jbpe_settings/domainsettings.php';
include '../jbpe_dbconn/dbmycon.php';
include '../jbpe_classes/class_call.php';
include '../loginfail.php';

$usermenu->user_menu($Loaduserlevel,$loginuserid,$conn,$baseroot);
// $restrictlink="jbbill_prd/prd_report/frm_prd_ledger_report.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $basicClass->SoftName; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript">
//function form_fc_rate_print(brcode,frm_date,to_date){
function form_fc_rate_print(brcode,frm_date,to_date){
	//alert(brcode);
	if(brcode=='selected'){
		alert('Please Select A Branch!');
		return false;		
	}
		
	var rurl='fc_rate_report_fpdf.php/'+brcode+ '/' +frm_date+ '/' +to_date;
	//alert(rurl);
	window.open(rurl);		
}


</script>

<link href="<?PHP echo $baseroot;?>/jbpe_lib/jrstl.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/menu.js"></script>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/globaljava.js"></script>
<script type="text/javascript" src="<?php echo $baseroot?>/datetimepicker/datetimepicker_css.js"></script>  

</head>
<body class="bodybox" onLoad="Timestart();"> 
<center>
  <table width="100%"  border="0" class="indexbox">
     <tr>
       <td><?PHP echo $basicClass->topmenu;?></td>
     </tr>
     <tr>
       <td><div class="tbg" style="height:22px"><div class="tbg" align="center"><?php  echo $usermenu->menu; ?></div></div></td>
     </tr>
     <tr>
       <td><div align="center"><?php //$usermenu->restricpage($loginuserid,$Loaduserlevel,$restrictlink,$systemstatus,$conn);?></div>    
	   </td>
     </tr>
     <tr>
       <td><table width="100%"  cellspacing="0" cellpadding="0" class="msgbox">
    <tr>
      <td width="100%" colspan="2" class="tbg" ><strong>FOREIGN CURRENY RATE REPORT</strong>
	  </td>
    </tr>
    <tr>
      <td colspan="2">
<?PHP
						//$tranType = 'I';
						$createdBy = (string)$_SESSION['loginID'];
						$logedinUserName = (string)$_SESSION['userID'];
						$branchCode = (string)$_SESSION['userjblocat']; 
						$accRoutingCode = (string)$_SESSION['BrRouting'];
						
 if (isset($_POST["Submit"])) 
	{	

	if (isset($_POST["cmbthisbranchlist"])) 
	$branchcode=$_POST["cmbthisbranchlist"];
//echo $branchcode;
	$branchcode = $CISecurity->xss_clean($branchcode);
	$InsertClass->isEmpty($branchcode, "Branch Name Required");
	
	if (isset($_POST["txtfrm_date"])) $frm_date=$_POST["txtfrm_date"];
	$frm_date = $CISecurity->xss_clean($frm_date);
	$sqlfrm_date = date('Y-m-d',strtotime($frm_date));

	if (isset($_POST["txtto_date"])) $to_date=$_POST["txtto_date"];
	$to_date = $CISecurity->xss_clean($to_date);
	$sqlto_date = date('Y-m-d',strtotime($to_date));
	} 
else {
	$codeviewclass->thisbranchlist($branchCode,$branchCode,$baseroot,$conn_jbrps);
	$branch_list=$codeviewclass->thisbranchlist;
	$frm_date = $currsoftdate;
	$to_date = $currsoftdate;
	
}

	
 ?></td>
    </tr>
    <tr>
      <td colspan="2"><form action="" method="post" enctype="multipart/form-data" name="frmupload">
        <table width="100%" border="1" align="center" cellpadding="10"  cellspacing="2" bordercolor="#CCCCCC">
          <tr>
            <td colspan="5"><div align="center"><strong>DAILY FC RATE REPORT</strong></div>
			</td>
		</tr>
		<tr>
			<!-- <td width="100%" colspan="5" class="error" ><strong>**সঠিকভাবে নিবন্ধিত সুবিধাভোগীদের তথ্য পেতে  Verify Enrollment সম্পন্ন করে আসুন </strong> -->
			</td>
		</tr>
			<tr>
            <td width="6%">Branch</td>
            <td colspan="5"><?PHP echo $branch_list;?></td>
            
            </tr>
			<tr>
            <td width="10%">Date From:</td>
            <td width="18%"><input name="txtfrm_date" type="text" id="txtfrm_date" value="<?PHP echo $frm_date;?>" size="15"  maxlength="12" readonly="readonly" />
              <a href="javascript: NewCssCal('txtfrm_date','ddmmyyyy','arrow','<?PHP echo $baseroot;?>')"><img
			   src="<?PHP echo $baseroot;?>/images/cal.gif" width="16" height="16" alt="Pick a date" /></a></td>
            
			<td width="10%">Date To:</td>
            <td width="18%"><input readonly="readonly" type="text" id="txtto_date"  value="<?PHP echo $to_date;?>" maxlength="12" size="15" name="txtto_date" />
              <a href="javascript: NewCssCal('txtto_date','ddmmyyyy','arrow','<?PHP echo $baseroot;?>')"><img
				src="<?PHP echo $baseroot;?>/images/cal.gif" width="16" height="16" alt="Pick a date" /></a></td>
            <td><!--input type="Submit" name="Submit" value="Show"/-->
              <input type="button" name="Submit2" value="Print" onclick="form_fc_rate_print(cmbthisbranchlist.value,txtfrm_date.value,txtto_date.value);" />
			 
            </td>
          </tr>
 
			
 
          <tr>
            <td colspan="7"><?PHP echo $dataviewclass->DataList; ?></td>
          </tr>
        </table>
        </form>      </td>
    </tr>
    
  </table></td>
     </tr>
     <tr>
       <td><div align="center"><?PHP //echo $basicClass->bottommenu;
									echo '<table width="100%"  border="0" class="tbg">
											<tr>
											<td class="tbg"><div align="center"><a href=\''.$baseroot.'/jbneps_help/usermanual.php\' target=\'_blank\'><strong><font color="#FFFFFF">User\'s Manual</font></strong></a>  </div></td>
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
sqlsrv_close($conn_jbrps);
?>