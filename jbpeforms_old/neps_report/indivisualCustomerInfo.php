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
						
							$nIDNo = null;
						?>
            <table width="100%"  cellspacing="0" cellpadding="5" class="msgbox">
				<tr>
					<td width="100%" height = "30px" colspan="2" class="tbg"><strong>Indivisual Bnificiary Information</strong></td>
                </tr>
				<tr>
					<td width="100%" height = "30px" colspan="2" class="error"> 
						<strong> **সুবিধাভোগী ইতোপূর্বে নিবন্ধিত হয়েছে কি না  NID দিয়ে যাচাই করুন </strong>
					</td>
                </tr>
				
				<tr>
                 
					<td width="100%" colspan="2" >
			<!--  EDIT HERE -->
							<strong>ENTER BENIFICIARY NID NUMBER:</strong>
							<input name="txt_nidnumber" type="text" id="txt_nidnumber" onkeyup="IsNumericInt(this);"  value="<?PHP echo $nIDNo;?>" size="20" autocomplete="off"  placeholder="NID NUMBER ?" min="10" maxlength="17" required />
                            <input type="button" name="btn_showIndivisualCustomer" id="btn_showIndivisualCustomer" value="Show" onclick="showIndivisualCustomer('showCustomer',txt_nidnumber.value,'<?php echo $baseroot;?>');return false;" />
                            <span class="error" >*</span>
					</td>
				
                </tr>
				
				<tr>
					<td width="100%" height = "20px" colspan="2" ></td>
                </tr>
				  <tr>
					<td width="100%" colspan="2" >
                          <SPAN id="showCustomer"><?php //echo $zone;?> </SPAN> 
					</td>
						 
                 </tr>	  
                <tr>
					<td width="100%" height = "20px" colspan="2" ></td>
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