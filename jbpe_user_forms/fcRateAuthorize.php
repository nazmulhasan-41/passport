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
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/menu.js"></script>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/globaljava.js"></script>
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
						//$createdBy = (string)$_SESSION['loginID'];
						$createdBy = $_SESSION['userjbremtt'];
						$logedinUserName = (string)$_SESSION['userID'];
						$branchCode = (string)$_SESSION['userjblocat'];
						$Date = date("Y-m-d");					
						?>		 
            <table width="100%"  cellspacing="0" cellpadding="0" class="msgbox">
                <tr>
                  <td >
							<?PHP
							  //$examid='';
							  /*
							  // FOR ALL FC RATE APPROVE
							  
							  $editlink="jbpe/jbpe_user_forms/";
							  $tblcaption="Unauthorize FC Rate List";
							 
							  $colHeader=" Date, US DOLLAR,CANADIAN DOLLAR,POUND STARLING,AUSTRALLIAN DOLLAR,MALAYSIAN RINGGIT,SINGAPORE DOLLAR,SAUDI ARABIAN RIYAL,JAPANESE YEN,EURO,KUWAITI DINNER,U.A.E DERHAM,Reject,Authorize";
							  //,Edit,Authorize
							 $sql="SELECT convert(varchar, [Date], 23)
										  ,[USD]
										  ,[CAD]
										  ,[GBP]
										  ,[AUD]
										  ,[MYR]
										  ,[SGD]
										  ,[SAR]
										  ,[JPY]
										  ,[EUR]
										  ,[KWD]
										  ,[AED] 
										  ,[FC_RATE_ID]
										  FROM [dbjbPassportEndorse].[dbo].[ExchangeRate]
										  WHERE [Date]='".$Date."' AND [SUBMISSION_STATUS] = 'P'";
								
							    $dataviewclass->form_fc_rate_auth($tblcaption,$colHeader,$sql,$editlink,$baseroot,$conn);
								
								*/
								
								//ONLY DOALLAR RATE APPROVE
								
								$editlink="jbpe/jbpe_user_forms/";
								$tblcaption="Unauthorize FC Rate List";
							 
								$colHeader=" Date, US DOLLAR RATE, Reject,Authorize";
								//,Edit,Authorize
										$sql="SELECT convert(varchar, [Date], 23),[USD],[FC_RATE_ID]FROM [dbjbPassportEndorse].[dbo].[ExchangeRate] WHERE [Date]='".$Date."' AND [SUBMISSION_STATUS] = 'P'";
										  
							    $dataviewclass->form_fc_rate_auth_dollar($tblcaption,$colHeader,$sql,$editlink,$baseroot,$conn);
							   
							   echo $dataviewclass->DataList;
							
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