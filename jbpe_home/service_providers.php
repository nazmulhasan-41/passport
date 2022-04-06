<?php
define('BASEPATH','jbremittancehome');
session_start();
include '../jbbill_settings/domainsettings.php';
include '../jbbill_dbconn/dbmycon.php';
$conn = sqlsrv_connect($database_hostname,$connectioninfo);
include '../jbbill_classes/class_call.php';
include '../loginfail.php';
$usermenu->user_menu($Loaduserlevel,$loginuserid,$conn,$baseroot);
$restrictlink="jr_common_forms/index.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $basicClass->SoftName; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript">
function validate_required(field,alerttxt)
{
with (field)
  {
  if (value==null||value=="")
    {
    alert(alerttxt);return false;
    }
  else
    {
    return true;
    }
  }
}
function validate_form(thisform)
{
    
with (thisform)
  { 
      
  if (validate_required(txtsecmobile,"Mobile Number Required!")==false)
  {txtsecmobile.focus();return false;}
 
    

  var answer = confirm ("Are You Sure To Save This Status?")
		if (answer) {
		return true;
		} else {
		return false;
		}

   }
}
function showapi(apivalue)
{
    
    //alert(document.getElementById('txtapilink'));//
    document.getElementById('txtapilink').style.display = 'none';
    if(apivalue=='M')
    {
        document.getElementById('txtapilink').style.display = 'none';
        document.getElementById('txtapilink').value='';
    }
    else
    {
        document.getElementById('txtapilink').style.display = 'block';
    }
}
</script>
<script type="text/javascript" src="<?php echo $baseroot?>/datetimepicker/datetimepicker_css.js"></script>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbbill_lib/menu.js"></script>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbbill_lib/globaljava.js"></script>
<link href="<?PHP echo $baseroot;?>/jbbill_lib/jrstl.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?PHP echo $baseroot;?>/jbbill_lib/modalcss.css" media="screen, print" />
</head>
<body class="bodybox" onLoad="Timestart();"> 
<center>
  <table width="100%"  border="0" class="indexbox">
     <tr>
       <td><?PHP echo $basicClass->topmenu;?></td>
     </tr>
     <tr>
       <td><div class="tbg" style="height:20px"><div class="tbg" align="center"><?php  echo $usermenu->menu; ?></div></div></td>
     </tr>
     <tr>
       <td><div align="center"><?php $usermenu->restricpage($loginuserid,$Loaduserlevel,$restrictlink,$systemstatus,$conn);?></div>       </td>
     </tr>
     <tr>
       <td><form method="post" action="<?php //echo $actionlink; ?>" onSubmit="return validate_form(this);">
  <table width="100%"  cellspacing="0" cellpadding="3" class="msgbox">
    <tr>
      <td class="tbg"><strong>Service Provider Settings </strong></td>
    </tr>
    <tr>
      <td width="58%"><?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
global $connectivity,$brstatus,$secmobile,$adbranchstatus ;
if (isset($_POST["Submit"])) 
{	   
if (isset($_POST["cmbservice"])) $service_provider=$_POST["cmbservice"];
	$codeviewclass->service_provider_status('ctlservice',$service_provider,$baseroot,'S',$conn);
if (isset($_POST["txtrevenuestamp"])) $revenuestamp=$_POST["txtrevenuestamp"];
	
if (isset($_POST["txtstamprate"])) $stamprate=$_POST["txtstamprate"];
	
if (isset($_POST["txtvatrate"])) $vatrate=$_POST["txtvatrate"];

if (isset($_POST["txtbilldesc"])) $billdesc=$_POST["txtbilldesc"];


if (isset($_POST["txtvatdesc"])) $vatdesc=$_POST["txtvatdesc"];

if (isset($_POST["txtapilink"])) $apilink=$_POST["txtapilink"];

if (isset($_POST["optcollectiontype"])) $collectiontype=$_POST["optcollectiontype"];

$values = array(
               'rev_stamp_min' => $revenuestamp,
			   'rev_stamprate' => $stamprate,
			   'vat_rate' => $vatrate,
                           'Collection_type'=>$collectiontype,
                           'API_Procedure'=>$apilink,
                            'bill_desc'=>$billdesc,
                            'vat_desc'=>$vatdesc
               );
$tablename ="tbl_service_provider" ;
$where = " sp_code='".$service_provider."'";
$InsertClass->update_data($tablename,$values,$where,$conn);
if ($InsertClass->datasave=='T') {
$branchdetails='';
}
} else {
	$codeviewclass->service_provider_status('ctlservice','',$baseroot,'S',$conn);
	$service_provider =$codeviewclass->service_provider_status;//cmbservice
	}
?></td>
    </tr>
    <tr>
      <td>
        <table width="90%" border="1" align="center" cellpadding="0"  cellspacing="2" bordercolor="#CCCCCC">
        <tr>
          <td width="22%" class="input_level">&nbsp;</td>
          <td width="78%"><div align="left"><span class="error">*</span> <span class="bb">Indicating Required Fields</span></div></td>
        </tr>
        <tr>
            <td class="input_level">Service Provider Name</td>
          <td><?PHP echo $service_provider;?><input name="branchcode" type="button" id="branchcode" onClick="service_provider_details('ctlservice','Servicestatus',cmbservice.value,'<?PHP echo $baseroot;?>')" value="Show Service"></input></td>
        </tr>
        <tr>
          <td colspan="2" class="input_level"><SPAN id="ctlservice"><?PHP echo $branchdetails;?></SPAN></td>
        </tr>
      </table>      </td>
    </tr>
  </table>
</form>
</td>
     </tr>
     
     <tr>
       <td><div align="center"><?PHP echo $basicClass->bottommenu;?></div></td>
     </tr>
  </table>
   
</center>
</body>
</html>
<?PHP
sqlsrv_close( $conn);
?>