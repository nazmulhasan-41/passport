<?php
define('BASEPATH','jbremittancehome');
session_start();
include '../jbpe_settings/domainsettings.php';
include '../jbpe_dbconn/dbmycon.php';
include '../jbpe_classes/class_call.php';
include '../loginfail.php';
$usermenu->user_menu($Loaduserlevel,$loginuserid,$conn,$baseroot);
//$restrictlink="index.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $basicClass->SoftName; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="<?PHP echo $baseroot;?>/jbpe_lib/jrstl.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?PHP echo $baseroot;?>/jbpe_lib/modalcss.css" media="screen, print" />
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/menu.js"></script>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/globaljava.js"></script>
</head>
<body class="bodybox" onLoad="Timestart();"> 
<center>
<form method="post" action="<?php echo $actionlink; ?>">
  <table width="100%"  border="0" class="indexbox">
     <tr>
       <td><?PHP echo $basicClass->topmenu;?></td>
     </tr>
     <tr>
       <td><div class="tbg" style="height:22px"><div class="tbg" align="center"><?php  echo $usermenu->menu; ?></div></div></td>
     </tr>
     <tr>
       <td><div align="center"><?php //$usermenu->restricpage($loginuserid,$Loaduserlevel,$restrictlink,$systemstatus,$conn);?></div>       </td>
     </tr>
     <tr>
       <td><?php
Global $userlist;
if ($Loaduserlevel!='SA') {
	$tblname="tblusers";
	$tblcaption="User List";
	$colHeader="Login ID,User Name,Mobile,Branch,File No,User Level,Status,Expiary,Permission";
	$sql="select u.loginID,u.userName,u.mobileNo,b.BranchName,u.pfileno,u.userLevel,u.userStatus,convert(varchar,cast(u.passexpiary as datetime),106) as expdate,'Permission',u.BranchCode,u.deptcode from tblusers u inner join Branch b on u.BranchCode=b.BranchCode where u.BranchCode='$branch_code' and u.loginID<>'$loginuserid'";	
	
	//............USER PERMISION.....................//
	
	//$actionlink=$baseroot ."/jr_user_forms/index.php/";
	$actionlink=$baseroot ."/jbpe_home/userpermission.php/";
	$permissionlink=$baseroot ."/jbpe_home/userpermission.php/";
	
	
	
	$dataviewclass->data_user_list($tblname,$tblcaption,$colHeader,$sql,$branch_code,$actionlink,$permissionlink,$conn_jbrps);
	$userlist = $dataviewclass->DataList;
}
?>
<form method="post" action="<?php echo $actionlink; ?>">
  <table width="100%"  cellspacing="0" cellpadding="0" class="msgbox">
 <?php
  if (($Loaduserlevel=='SA') || ($Loaduserlevel=='SU')) {
      echo "<tr>
      <td width=\"15%\"><strong>Branch Code/Mobile/File </strong></td>
      <td width=\"85%\"><input name=\"txtbranchcode\" type=\"text\" id=\"txtbranchcode\" 
	  onChange=\"userlist('userlist','".$Loaduserlevel."','".$baseroot."');\" maxlength=\"20\">
      <input name=\"Showlist\" type=\"button\" id=\"Showlist\" onClick=\"userlist('userlist','".$Loaduserlevel."','".$baseroot."');\" value=\"Show User List\"><span id='ctlbrname'></span></td>
    </tr>"; 
}  
?>
    <tr>
      <td colspan="2"><span id="userlist"><?php echo $userlist; ?></span></td>
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
</form>			 
</center>
</body>
</html>
<?PHP
sqlsrv_close($conn);
?>