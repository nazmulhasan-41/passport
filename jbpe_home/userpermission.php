<?php
define('BASEPATH','jbremittancehome');
session_start();
include '../jbpe_settings/domainsettings.php';
include '../jbpe_dbconn/dbmycon.php';
include '../jbpe_classes/class_call.php';
include '../loginfail.php';
$usermenu->user_menu($Loaduserlevel,$loginuserid,$conn,$baseroot);
//$restrictlink="userpermission.php";
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

  var answer = confirm ("Are You Sure To Update User Permission?")
		if (answer) {
		return true;
		} else {
		return false;
		}
}
</script>
<link href="<?PHP echo $baseroot;?>/jbpe_lib/jrstl.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?PHP echo $baseroot;?>/jbpe_lib/modalcss.css" media="screen, print" />
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/menu.js"></script>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/globaljava.js"></script>

</head>
<body class="bodybox" onLoad="Timestart();"> 
<center>
<form method="post" action="<?php echo $actionlink; ?>" onSubmit="return validate_form(this)">
  <table width="100%"  border="0" class="indexbox">
     <tr>
       <td><?PHP echo $basicClass->topmenu;?></td>
     </tr>
     <tr>
       <td><div class="tbg" style="height:22px"><div class="tbg" align="center"><?php  echo $usermenu->menu; ?></div></div></td>
     </tr>
     <tr>
       <td><div align="center"><?php //$usermenu->restricpage($loginuserid,$Loaduserlevel,$restrictlink,$systemstatus,$connectioninfo_jbrps);?></div>       </td>
     </tr>
     <tr>
       <td>
           <?php
 if (!isset($commandArray[0])) {
echo "<span class='error'>Sorry, Select User Permission From User List.</span>&nbsp;&nbsp;&nbsp; <a href=\"$baseroot/jbpe_home/frmuserlist.php\">Click Here</a>";
return false;
exit;
}
?>
           <table width="100%"  cellspacing="0" cellpadding="0" class="msgbox">
         <tr>
           <td colspan="3" class="tbg"><strong>User Permission </strong></td>
         </tr>
         <tr>
           <td width="7%">&nbsp;</td>
           <td width="58%"><?php 
global $deptdata,$halevel;
if (isset($_POST["Submit"])) 
{
$uloginid=$commandArray[0];
$uloginid = $CISecurity->xss_clean($uloginid);
$ulevel=$_POST["huserlevel"];

//$Uusername=$_POST["txtusername"];
//$InsertClass->isEmpty($Uusername, "User Full Name Required");
//$shortname=$_POST["txtshortname"];
//$InsertClass->isEmpty($shortname, "User Short Name Required");
//if (str_word_count($shortname)>1) {
//$shortcount='';
//$InsertClass->isEmpty($shortcount, "Short Name Must be Single word!");
//}
//$designation=$_POST["txtdesignation"];
//$InsertClass->isEmpty($designation, "User Designation Required");

//$Uconfirm = $codeviewclass->password_reset();
//$seccode = $codeviewclass->password_salt();

//		$DataSecurity->MyHashGenerate($Uconfirm,$seccode);
//		$user_pass_key = $DataSecurity->mykeyhash;

//$Umobileno=$_POST["txtmobileno"];
//$Umobileno = $CISecurity->xss_clean($Umobileno);
//$InsertClass->isEmpty($Umobileno, "User Mobile Number Required");
//$sms_mobile =  substr($Umobileno,-10);

$branchcode=$_POST["cmbbranch"];
$dataviewclass->branchselect('',$branchcode,$Loaduserlevel,$baseroot,$conn_jbrps); //Department deffination
//if ($branchcode=='9999') {
//$deptcode=$_POST["cmbdepartment"];
//$InsertClass->isEmpty($deptcode, "Select Central Office Department");
//$dataviewclass->deptselect($branch_code,$deptcode,$Loaduserlevel,$conn); //Department deffination
//$dataviewclass->deptselect_all($branch_code,$deptcode,$Loaduserlevel,$conn); //Department deffination
//	$deptdata = $dataviewclass->deptselect;
//}


//$ulevel=$_POST["cmbuserlevel"];
//$dataviewclass->Ulevel($ulevel,$Loaduserlevel,$loginuserid,$baseroot); // Administrator or User deffination with selection
	//user check list
	$chkmenu='';
	if (isset($_POST["chkuserpermission"])) {
	  for($i=0; $i < count($_POST["chkuserpermission"]); $i++) { 
          $chkmenu .="" . $_POST["chkuserpermission"][$i] . ",";
       }
	  }
	   $chkmenu=substr($chkmenu,0,-1);
	   $InsertClass->isEmpty($chkmenu, "User Permission Required");

	   //echo $chkmenu;
$usermenu->user_permission_menu($ulevel,'',$chkmenu,$loginuserid,$Loaduserlevel,$conn); //User Menu permission deffination with selection
// $alevel=$_POST["cmbactivelevel"];
//$dataviewclass->UActive($alevel); //User activity deffination with selection
//$userip=$_POST["txtuserip"];
//echo $halevel;
if (isset($commandArray[0])) {

	//echo $commandArray[0];		   
/* if (($alevel=='A') && ($halevel==$alevel)) {
$where=" loginID<>'".$uloginid."' and userStatus='A' and RIGHT(mobileNo,10)='".$sms_mobile."'";
$InsertClass->isExistsKeyWhere('tblusers',$where,'This User Already Active In Another Branch',$conn);

$values = array(
               'userID' => $shortname,
               'userName' => $Uusername,
               'desig' => $designation,
               'mobileNo' => $Umobileno,
			   'userStatus' => $alevel,
			   'modifyBy' => $currentuser,
			   'modifyDate' => $currdatetime,
			   'usertry' => '0'
               );
} else if (($alevel=='A') && ($halevel!=$alevel)) {
$where=" loginID<>'".$uloginid."' and userStatus='A' and RIGHT(mobileNo,10)='".$sms_mobile."'";
$InsertClass->isExistsKeyWhere('tblusers',$where,'This User Already Active In Another Branch',$conn);

$values = array(
               'userID' => $shortname,
               'userName' => $Uusername,
			   'upass_key' =>$user_pass_key,
			   'passexpiary' =>$passexpiary,
			   'upass_salt' =>$seccode,
               'desig' => $designation,
               'mobileNo' => $Umobileno,
			   'userStatus' => $alevel,
			   'modifyBy' => $currentuser,
			   'modifyDate' => $currdatetime,
			   'usertry' => '0'
               );
} 	else if (($alevel=='C') || ($alevel=='I')) {
$values = array(
               'userID' => $shortname,
               'userName' => $Uusername,
			   'upass_key' =>$user_pass_key,
			   'passexpiary' =>$passexpiary,
			   'upass_salt' =>$seccode,
               'desig' => $designation,
               'mobileNo' => $Umobileno,
			   'userStatus' => $alevel,
			   'modifyBy' => $currentuser,
			   'modifyDate' => $currdatetime,
			   'usertry' => '0'
               );
} 	 		   
 			   
			   
$tablename ="tblusers" ;
$where = "loginID='".$uloginid."'";
 */
$InsertClass->update_user_data($currentuser,$currdatetime,$uloginid,$chkmenu,$conn);
}  
if ($InsertClass->datasave=='T') {
/*  	 if (($alevel=='A') && ($halevel!=$alevel)) {
$smscontent = 'Your JBRPS new password ' . $Uconfirm . ' for Login ID '. $uloginid .', Don\'t share your password with others. Thank you, ICTD(System), Janata Bank Limited';
$sms_description = 'JBRPS password changed of ' . $branchcode . ' and Login ID '. $uloginid;
$funcname="dbo.proc_sms_gateway_encrypt";
$values="?,?,?,?,?";
$arrays=array($branchcode,$sms_mobile,$smscontent,'Password',$sms_description);
$InsertClass->proc_param_data($funcname,$values,$arrays,$conn);
	}  
 */	
$shortname='';
$Uloginid='';
$Upassword='';
$Uconfirm='';
$Uusername='';
$Uempno='';
$Umobileno='';
$Uemailid='';
$designation='';
$userip='';
$halevel='';
$alevel='';
}
} else {
	if (isset($commandArray[0])) {
	$uloginid = $commandArray[0];
	$result=sqlsrv_query($conn_jbrps,"select * from tblusers where loginID='$uloginid'");
	while($row = sqlsrv_fetch_array($result)){	
	$Uusername=$row["userName"];
	$shortname=$row["userID"];
	$userfileno=$row["pfileno"];
	$designation=$row["desig"];
	$Umobileno=$row["mobileNo"];
	$Uemailid=$row["emailID"];
$branchcode=$row["BranchCode"];
$dataviewclass->branchselect('ctldepartment',$branchcode,$Loaduserlevel,$baseroot,$conn_jbrps); //Department deffination

//$branchcode=$row["BranchCode"];
//$dataviewclass->branchselect('',$branchcode,$Loaduserlevel,$baseroot,$conn); //Department deffination
if ($branchcode=='9999') {
$deptcode=$row["deptcode"];
$dataviewclass->deptselect($branch_code,$deptcode,$Loaduserlevel,$conn_jbrps); //Department deffination
	$deptdata = $dataviewclass->deptselect;
}
	$ulevel=$row["userLevel"];
	//$dataviewclass->Ulevel($ulevel,$Loaduserlevel,$loginuserid,$baseroot); // Administrator or User deffination with selection
	$userip=$row["restrictip"];
	//$alevel=$row["userStatus"];
	//$halevel=$row["userStatus"];
	
	//$dataviewclass->UActive($alevel); //User activity deffination with selection
	$Upassword='';
	$Uconfirm='';
	$chkmenu='';
	  $result_menu=sqlsrv_query($conn,"select ckey from tblpermission where loginID='$uloginid'");
	  while($row_menu=sqlsrv_fetch_array($result_menu)){
	  $chkmenu .=  "". $row_menu["ckey"] . ",";
	  }
	  //echo "select ckey from tblpermission where loginID='$uloginid'";
	   $chkmenu=substr($chkmenu,0,-1);
	  $usermenu->user_permission_menu($ulevel,'',$chkmenu,$loginuserid,$Loaduserlevel,$conn); //User Menu permission deffination with selection
	}
sqlsrv_free_stmt( $result_menu);
sqlsrv_free_stmt( $result);
	} 
	else {
	$codeviewclass->uloginid();
	$uloginid=$codeviewclass->uloginid;
	$dataviewclass->branchselect('',$branch_code,$Loaduserlevel,$baseroot,$conn_jbrps); //Department deffination
	
	//$dataviewclass->Ulevel('',$Loaduserlevel,$loginuserid,$baseroot); // Administrator or User deffination
	//$dataviewclass->UActive(''); // User activity deffination 
	$dataviewclass->ULogged('F'); // User Logged deffination 
		if ($Loaduserlevel!='SA') {
		$usermenu->user_permission_menu($dataviewclass->Firstuserlevel,'','',$loginuserid,$Loaduserlevel,$conn); //User Menu permission deffination with selection
		} 
	$Uusername='';
	$shortname='';
	$Upassword='';
	$Uconfirm='';
	$userfileno='';
	$designation='';
	$Umobileno='';
	$Uemailid='';
	$userip='';
	$halevel='';
	}
}
?>           </td>
           <td width="35%">&nbsp;</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
           <td><table width="100%" border="1" cellpadding="3"  cellspacing="2" bordercolor="#CCCCCC">
               <tr>
                 <td class="input_level">&nbsp;</td>
                 <td><div align="center"><span class="error">*</span> <span class="bb">Indicating Required Fields</span></div></td>
               </tr>
               <tr>
                 <td class="input_level">Login ID </td>
                 <td><span id="loginid" class="TTNo"><?php echo $uloginid; ?>
                   <input name="huserlevel" id="huserlevel" type="hidden" value="<?php echo $halevel; ?>" />
                 </span></td>
               </tr>
               <tr>
                 <td class="input_level">User Name </td>
                 <td class="input_level"><?php echo $Uusername;  ?></td>
               </tr>
               <tr>
                 <td width="37%" class="input_level">Short Name </td>
                 <td width="63%" class="input_level"><?php echo $shortname;  ?></td>
               </tr>
               
               <tr>
                 <td class="input_level">Designation</td>
                 <td class="input_level"><?php echo $designation;  ?></td>
               </tr>
               <tr>
                 <td class="input_level">Mobile Number</td>
                 <td class="input_level"><?php echo $Umobileno;  ?></td>
               </tr>
               
               <tr>
                 <td class="input_level">User Branch</td>
                 <td><?php echo $dataviewclass->branchselect; ?></td>
               </tr>
			   
               <tr>
                 <td class="input_level">User Level </td>
                 <td><?php echo $ulevel; ?> <span class="TTNo">
                   <input name="huserlevel" id="huserlevel" type="hidden" value="<?php echo $ulevel; ?>" />
                 </span></td>
               </tr>
               <tr>
                 <td class="input_level"><?php if (!isset($commandArray[0])) {
		  $btn="Save";
		  } else if (isset($commandArray[0])) {
		  $btn="Update";
		  } else if ($_GET["module"]=='deleteuser') {
		  $btn="Delete";
		  } ?></td>
                 <td><input type="submit" name="Submit" value="<?php echo $btn; ?>" /></td>
               </tr>
           </table></td>
           <td><span id="userpermission"><?php echo $usermenu->permission_menu; ?></span><br />
             <p>&nbsp;</p>
             </td>
         </tr>
         <tr>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
       </table></td>
     </tr>
     <tr>
       <td><div align="center"><?PHP //echo $basicClass->bottommenu;
									echo '<table width="100%"  border="0" class="tbg">
											<tr>
											<td class="tbg"><div align="center"><a href=\''.$baseroot.'/jbnpe_help/usermanual.php\' target=\'_blank\'><strong><font color="#FFFFFF">User\'s Manual</font></strong></a>  </div></td>
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