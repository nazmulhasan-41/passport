<?php
define('BASEPATH','jbremittancehome');
session_start();
require_once('../jbbill_settings/domainsettings.php');
require_once('../jbbill_dbconn/dbmycon.php');
//$conn = sqlsrv_connect($database_hostname,$connectioninfo);
require_once('../jbbill_classes/class_call.php');
require_once('../loginfail.php');
$usermenu->user_menu($Loaduserlevel,$loginuserid,$conn,$baseroot);
$restrictlink="jbbill_home/Branch_Setting.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $basicClass->SoftName; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript">
function validate_form(thisform)
{
with (thisform)
  {
  //alert(testtype);
	  	if (validate_required(txtexam_name,"Exam Name Required!")==false)
	  	{txtexam_name.focus();return false;}
	  	else if (validate_required(txtexam_fee,"Exam Fee Required!")==false)
  		{txtexam_fee.focus();return false;}  
	  	else if (validate_required(txtbank_charge,"Bank Charge Required!")==false)
  		{txtbank_charge.focus();return false;}  
	  	else if (validate_required(txtvat_charge,"VAT Required!")==false)
  		{txtvat_charge.focus();return false;}  

	}

  var answer = confirm ("Are You Sure To Save This Examination?")
		if (answer) {
		return true;
		} else {
		return false;
		}

}

</script>
<link href="<?PHP echo $baseroot;?>/jbbill_lib/jrstl.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbbill_lib/menu.js"></script>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbbill_lib/globaljava.js"></script>
<script type="text/javascript" src="<?php echo $baseroot?>/datetimepicker/datetimepicker_css.js"></script></head>
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
       <td><div align="center"><?php $usermenu->restricpage($loginuserid,$Loaduserlevel,$restrictlink,$systemstatus,$conn);?></div>       </td>
     </tr>
     <tr>
       <td><table width="100%"  cellspacing="0" cellpadding="0" class="msgbox">
    <tr>
      <td width="100%" colspan="2" class="tbg"><strong>Branch Settings</strong></td>
    </tr>
    <tr>
      <td colspan="2"><form action="" method="post" enctype="multipart/form-data" name="frmupload" onSubmit="return validate_form(this);">
        <table width="100%" border="1" align="center" cellpadding="10"  cellspacing="2" bordercolor="#CCCCCC">
          <tr>
            <td><table width="100%" border="1" align="center" cellpadding="10"  cellspacing="2" bordercolor="#CCCCCC">
              <tr>
                <td colspan="2">
<?php
$branch_code='';
$sp_code='';
$scrl_id='';
//$vat_charge='';
$ac_no='';
$ac_type='';
$vat_ac_no='';
$vat_ac_type='';
if (isset($_POST["Submit"])) 
{	

if (isset($_POST["cmbthisbranchlist"])) $branch_code=$_POST["cmbthisbranchlist"];
$branch_code = $CISecurity->xss_clean($branch_code);
$InsertClass->isEmpty($branch_code, "Branch Code Required");

$codeviewclass->thisbranchlist($branch_code,$userdeptcode,$Loaduserlevel,$conn_jbrps);
$branch_list=$codeviewclass->thisbranchlist;

if (isset($_POST["cmbservice"])) $sp_code=$_POST["cmbservice"];
$sp_code = $CISecurity->xss_clean($sp_code);
$InsertClass->isEmpty($sp_code, "SP Name Required");

$codeviewclass->service_provider_status('ctlservice','',$baseroot,'S',$conn);
$service_provider =$codeviewclass->service_provider_status;//cmbservice

if (isset($_POST["cmb_scroll"])) $scrl_id=$_POST["cmb_scroll"];
$scrl_id = $CISecurity->xss_clean($scrl_id);
$InsertClass->isEmpty($scrl_id, "SCroll ID Required");

$codeviewclass->load_scrolltype_list($conn);
$scrolltype=$codeviewclass->scrolltype_list;//scrolltype_list

if (isset($_POST["txt_ac_no"])) $ac_no=$_POST["txt_ac_no"];
$ac_no = $CISecurity->xss_clean($ac_no);
$InsertClass->isEmpty($ac_no, "A/C No Required");

if (isset($_POST["txt_vat_ac_type"])) $ac_type=$_POST["txt_vat_ac_type"];
$ac_type = $CISecurity->xss_clean($ac_type);
$InsertClass->isEmpty($ac_type, "A/C Type Required");

if (isset($_POST["txt_vat_ac_no"])) $vat_ac_no=$_POST["txt_vat_ac_no"];
$vat_ac_no = $CISecurity->xss_clean($vat_ac_no);
$InsertClass->isEmpty($vat_ac_no, "VAT A/C No Required");

if (isset($_POST["txt_vat_ac_type"])) $vat_ac_type=$_POST["txt_vat_ac_type"];
$vat_ac_type = $CISecurity->xss_clean($vat_ac_type);
$InsertClass->isEmpty($vat_ac_type, "VAT Required");

$table_name ='tbl_sp_branch_map';

	if (empty($commandArray[0])) {

	$field_name = "BankCode,BranchCode,sp_code,ac_no,ac_type,vat_ac_no,vat_ac_type,CreatedBy,CreatedDate,scrl_id";
	$values_data="?,?,?,?,?,?,?,?,?,?";
	$arrays_data=array('1200',$branch_code,$sp_code,$ac_no,$ac_type,$vat_ac_no,$vat_ac_type,$loginuserid,$currdate_sql_format,$scrl_id);
	$InsertClass->insert_data($field_name,$values_data,$arrays_data,$table_name,$conn);
	} else if (isset($commandArray[0])) {
	/*$values = array(
               'exam_name' => $exam_name,
               'exam_fee' => $exam_fee,
			   'bank_charge' => $bank_charge,
			   'vat_charge' => $vat_charge,
               'form_start' => $sqlstartdate,
               'form_end' => $sqlenddate,
               'exam_status' => $exam_status,
               'edit_userid' => $loginuserid,
               'edt_date' => $currdate_sql_format,
			   'edt_ip_address' => $userip
			   
               );*/
	//$where = "exam_id='".$commandArray[0]."'";
	//$InsertClass->update_data($table_name,$values,$where,$conn);
	}
	
	if ($InsertClass->datasave=='T') {
	 
	}
		
}

   else
		 {
		$codeviewclass->thisbranchlist($branch_code,$userdeptcode,$Loaduserlevel,$conn_jbrps);
		$branch_list=$codeviewclass->thisbranchlist;//cmbthisbranchlist
		
		$codeviewclass->service_provider_status('ctlservice','',$baseroot,'S',$conn);
		$service_provider =$codeviewclass->service_provider_status;//cmbservice	
		
		$codeviewclass->load_scrolltype_list($conn);
        $scrolltype=$codeviewclass->scrolltype_list;//scrolltype_list
		
		$tblcaption="SP Branch Mapping";
		$colHeader="BankCode,BranchCode,sp code,sp name,scroll Name,AC No,ac type,vat ac no,vat ac type";
	  //$colHeader="BrCode,Service Name,ConsumerNo,ScrollNo,Total Month,Total Burner,BillAmount,Vat,Surcharge,Total,EntryBy,Edit,Delete";
		$sql="select BankCode,BranchCode,c.sp_code,c.sp_name,d.scroll_Name,ac_no,ac_type,vat_ac_no,vat_ac_type,c.scrl_id from
				(select BankCode,BranchCode,a.sp_code,b.sp_name,scrl_id,ac_no,ac_type,vat_ac_no,vat_ac_type
				 from tbl_sp_branch_map a 
				 inner join tbl_service_provider b
				 on a.sp_code=b.sp_code) c
				 inner join tbl_scroll d
				 on c.scrl_id=d.scrl_id order by BranchCode";

//echo $sql;

		$dataviewclass->gas_bill_list($tblcaption,$colHeader,$sql,$editlink,$brRouting,$baseroot,$conn);
		
		
		} 



//echo $branch_code;


?></td>
              </tr>
              
              <tr>
                <td width="23%"><strong>Branch Name</strong> </td>
                <td width="77%"><?PHP echo $branch_list;?>
                <span class="error">*</span></td>
              </tr>
              <tr>
				<td width="23%"><strong>SP Name</strong> </td>
                <td width="77%"><?PHP echo $service_provider;?>
                <span class="error">*</span></td>
                
              </tr>
              
              <tr>
                <td width="23%"><strong>Scroll Type</strong> </td>
                <td width="77%"><?PHP echo $scrolltype;?>
                <span class="error">*</span></td>
              </tr>
              <tr>
                <td><strong>A/C No </strong> </td>
                <td><input name="txt_ac_no" type="text" id="txt_ac_no" onkeyup="IsNumeric(this);" value="<?PHP echo $ac_no;?>" size="40" autocomplete="off" placeholder="A/C No?"/>
                 <span class="error">*</span></td>
              </tr>
              <tr>
                <td><strong>A/C Type </strong> </td>
                <td><input name="txt_ac_type" type="text" id="txt_ac_type"  value="<?PHP echo $ac_type;?>" size="40" autocomplete="off" placeholder="A/C Type?"/>
                 <span class="error">*</span></td>
              </tr>
              <tr>
                <td><strong>Vat A/C No </strong> </td>
                <td><input name="txt_vat_ac_no" type="text" id="txt_vat_ac_no" onkeyup="IsNumeric(this);" value="<?PHP echo $vat_ac_no;?>" size="40" autocomplete="off" placeholder="vat A/C No"/>
                 <span class="error">*</span></td>
              </tr>
              <tr>
                <td><strong> Vat A/C Type </strong> </td>
                <td><input name="txt_vat_ac_type" type="text" id="txt_vat_ac_type" value="<?PHP echo $vat_ac_type;?>" size="40" autocomplete="off" placeholder="Vat A/C Type?"/>
                 <span class="error">*</span></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="Submit" type="submit" id="Submit" value="Save" /></td>
              </tr>
			  <tr>
			  
			  <td colspan="2">
			  <?php
			  echo $dataviewclass->DataList;
			  ?>
			  </td>
			  </tr>
            </table></td>
            </tr>
        </table>
        </form>      </td>
    </tr>
    
  </table></td>
     </tr>
     <tr>
       <td><div align="center"><?PHP echo $basicClass->bottommenu;?></div></td>
     </tr>
  </table>
</center>
</body>
</html>
<?PHP
sqlsrv_close($conn);
?>