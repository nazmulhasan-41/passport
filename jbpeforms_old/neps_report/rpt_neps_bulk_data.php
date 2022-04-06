<?php
define('BASEPATH','jbremittancehome');
session_start();
require_once('../../jbneps_settings/domainsettings.php');
require_once('../../jbneps_dbconn/dbmycon.php');
//$conn = sqlsrv_connect($database_hostname,$connectioninfo);

require_once('../../jbneps_classes/class_call.php');

require_once('../../loginfail.php');
$usermenu->user_menu($Loaduserlevel,$loginuserid,$conn,$baseroot);
//$restrictlink="jbnepsforms/neps_form/enroll.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $basicClass->SoftName; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />


<link href="<?PHP echo $baseroot;?>/jbneps_lib/jrstl.css" rel="stylesheet" type="text/css"></link>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbneps_lib/menu.js"></script>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbneps_lib/globaljava.js"></script>
<script type="text/javascript" src="<?php echo $baseroot?>/datetimepicker/datetimepicker_css.js"></script>
<script type="text/javascript">

</script>

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
						$createdBy = (string)$_SESSION['loginID'];
						$logedinUserName = (string)$_SESSION['userID'];
						$branchCode = (string)$_SESSION['userjblocat']; 
						$accRoutingCode = (string)$_SESSION['BrRouting'];
						$frm_date = $currsoftdate;
						$to_date = $currsoftdate;
						?>		 
            <table width="100%"  align="center" cellpadding="5"  cellspacing="2" >
              <tr>
            <td  width="100%" colspan="5" class="tbg" ><div align="Left"><strong>Customer Bulk Data </strong></div></td>
			</tr>   
			<tr >
                <td width="8%" style="border: 1px solid black;">Date From:</td>
				<td width="30%" style="border: 1px solid black;">
				<input name="txtfrm_date" type="text" id="txtfrm_date" required pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}" title="format DD-MM-YYYY" value="<?PHP echo $frm_date;?>" size="15"  maxlength="10" placeholder="DD-MM-YYYY?" />
				  <a href="javascript: NewCssCal('txtfrm_date','ddmmyyyy','arrow','<?PHP echo $baseroot;?>')"><img
				   src="<?PHP echo $baseroot;?>/images/cal.gif" width="16" height="16" alt="Pick a date" /></a>
				  <span class="error">**DD-MM-YYYY**</span>
			</td>
            
			<td width="8%" style="border: 1px solid black;">Date To:</td>
            <td width="30%" style="border: 1px solid black;">
				<input type="text" id="txtto_date" required pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}" title="format DD-MM-YYYY"  value="<?PHP echo $to_date;?>" maxlength="10" size="15" name="txtto_date" placeholder="DD-MM-YYYY?" />
				  <a href="javascript: NewCssCal('txtto_date','ddmmyyyy','arrow','<?PHP echo $baseroot;?>')"><img
					src="<?PHP echo $baseroot;?>/images/cal.gif" width="16" height="16" alt="Pick a date" /></a>
				<span class="error">**DD-MM-YYYY**</span>
			</td>
				
			<td style="border: 1px solid black;"><!--input type="Submit" name="Submit" value="Show"/-->
              <input type="button" name="btn_CustBulkData" id="btn_CustBulkData" value="Show" onclick="showCustBulkData('showCustomer',txtfrm_date.value,txtto_date.value,'<?php echo $baseroot;?>');return false;" />
            </td>
          </tr>
				<tr>
                 <!-- <td width="100%" colspan="12" class="tbg" style="color:red;"><strong>Unauthorize Customer List</strong>
				  </td>
				  -->
				    <td colspan="5" id="showCustomer">
							<?PHP
							/*   
							  //$editlink="jbneps/jbnepsforms/neps_form/";
							  $tblcaption="Customer Bulk Data";
							  $colHeader="Sl#,Txn No,Birth Date,NID No,Enroll Date,Status,Acc No ,Acc Name,Bhata,Routing,isActive,Mobile No";
							  //,Edit,Authorize
								$dataviewclass->form_data_list_bulk($tblcaption,$colHeader);
							   echo $dataviewclass->DataList; */
							
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
?>