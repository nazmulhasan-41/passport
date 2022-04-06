<?php
define('BASEPATH','jbremittancehome');
//define('BASEPATH','js_settings');

session_start();
require_once('jbpe_settings/domainsettings.php');

require_once('jbpe_dbconn/dbmycon.php');
$conn = sqlsrv_connect($database_hostname,$connectioninfo);
require_once('jbpe_classes/class_call.php');


require_once('loginfail.php');


$usermenu->user_menu($Loaduserlevel,$loginuserid,$conn,$baseroot);
//echo $conn;
$restrictlink="jbpehome.php";

		$userexpiarydate =  date_format($userexpiarydate,"d-m-Y");

//echo $userexpiarydate;
$noticeexpiary =  date('Y-m-d', strtotime('-5 day', strtotime($userexpiarydate)));

//echo $noticeexpiary;
//echo $basicClass->currentdate;
//exit;

	if ($noticeexpiary<$basicClass->currentdate) {
	echo "<meta HTTP-EQUIV='REFRESH' CONTENT='0; URL=".$jbrpsroot."/jr_user_forms/frmprocesspassword.php'>";
	echo "Your Password Expired. Redirecting .............";
	exit;	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $basicClass->SoftName; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="<?PHP echo $baseroot;?>/jbpe_lib/jrstl.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/menu.js"></script>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/globaljava.js"></script>
</head>
<body class="bodybox" onLoad="Timestart();"> 


<center>
  <table width="100%"  border="0" class="indexbox">
     <tr>
       <td><?PHP echo $basicClass->topmenu;?></td>
     </tr>
     <tr>
       <td><div class="tbg" style="height:25px"><div class="tbg" align="center"><?php  echo $usermenu->menu; ?></div></div></td>
     </tr>
     <tr>
       <td><table width="100%"  cellspacing="0" cellpadding="0" class="msgbox">
         <tr>
           <td class="tbg"><strong>Passport Endorsement</strong></td>
         </tr>
         <tr>
           <td width="58%">&nbsp;</td>
         </tr>
         <tr>
           <td><table width="90%" border="0" align="center" cellpadding="25"  cellspacing="2"  bordercolor="#CCCCCC">
               
               <tr>
                 <td class="H1"><a href="javascript:void(0)" onclick="get_module('JBRPS','<?PHP echo $baseroot;?>')"></a> </td>
                </tr>
               <tr>
                 <td class="H1"><a href="javascript:void(0)" onclick="get_module('JBSSCR','<?PHP echo $baseroot;?>')"></a></td>
               </tr>
               
           </table></td>
         </tr>
         <tr>
           <td>&nbsp;</td>
         </tr>
       </table></td>
     </tr>
     <tr>
       <td><div align="center">
	   
		 &nbsp;</div>       </td>
     </tr>
     
     <tr>
       <td class="error"><div align="center"></div></td>
     </tr>
     
     <tr>
       <td class="TTNo"><marquee direction="left" scrollamount="2">
       </marquee></td>
     </tr>
     <tr>
       <td><div align="center"><?PHP //echo $basicClass->bottommenu;
									echo '<table width="100%"  border="0" class="tbg">
											<tr>
											<td class="tbg"><div align="center"><a href=\''.$baseroot.'/jbpe_help/usermanual.php\' target=\'_blank\'><strong><font color="#FFFFFF">User\'s Manual</font></strong></a>  </div></td>
											</tr>
										</table>';
								?>
	</div>
	 </td>
     </tr>
  </table>
			 
   
   <p>&nbsp;</p>
</center>
</body>
</html>
