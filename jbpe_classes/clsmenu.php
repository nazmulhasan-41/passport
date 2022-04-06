<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class UserAccess {
public $UserID,$UserName,$SuccessUser,$passWord,$scode,$hscode,$userLevel,$filename,$userLevelName,$companyID,$companyName,$companyDate,$companytype,$currdeptdate,$menu,$CurrentUser,$permission_menu;

function user_menu($Loaduserlevel,$currentuser,$conn,$baseroot){
	
	$this->menu.="<div align='left' style=\" border:0px solid #FFFFFF;height: 10px;  width: 1200px;\">
                    <ul class=\"dropdown\">";
			
			$session_menu_file = $_SESSION['session_menu_file'];
			$session_sub_menu_file = $_SESSION['session_sub_menu_file'];

			$submenuarray=explode("@",$session_sub_menu_file);
			$menuarray=explode("!",$session_menu_file);
			for ($m=0;$m < count($menuarray); $m++) {				
				$mainmenu = $menuarray[$m];				
				$mainmenuarray=explode("#",$mainmenu);
				
	$this->menu.="<li><a href=".$baseroot.'/'.$mainmenuarray[0].">".$mainmenuarray[1]."</a>
					<ul class=\"dropdown\">";
					$sub_menuarray=explode("!",$submenuarray[$m]);
			for ($m2=0;$m2 < count($sub_menuarray); $m2++) {
					$sub_menuarray_details=explode("#",$sub_menuarray[$m2]);
				if ($sub_menuarray_details[0]) {
					if(($sub_menuarray_details[1]=="Account Type Settings") || ($sub_menuarray_details[1]=="Requisition Pending") || ($sub_menuarray_details[1]=="MICR Process") || ($sub_menuarray_details[1]=="MICR Data Export"))
					{
						if(($_SESSION['userjblocat']=="5044") || (($_SESSION['userjblocat_dept']=="5005")))
						{
					   $this->menu.="<li><a href=".$baseroot.'/'.$sub_menuarray_details[0].">".$sub_menuarray_details[1]."</a></li>";
						}
						else
						{
							
						}
					 }
					else
					{
				$this->menu.="<li><a href=".$baseroot.'/'.$sub_menuarray_details[0].">".$sub_menuarray_details[1]."</a></li>";
					}
				}
				}
 $this->menu.="</ul>
					</li>";
	}
	$this->menu.="</ul>                
					</div>";
}


function user_menu_old($Loaduserlevel,$currentuser,$conn,$baseroot){
	if ($Loaduserlevel=='SA') {
    $query_menu = "select * from tblmenu where display='Y' and pkey='' order by slno";
	} else  {  //($Loaduserlevel=='SU')
		$query_menu = "select distinct m2.* from tblmenu m left join tblpermission p on m.ckey=p.ckey
inner join tblmenu m2 on m2.ckey=m.pkey where (m2.display='Y' and p.loginID='$currentuser') or (m2.userAccess='RU' or m2.userAccess='HU') order by slno";
	} 
    $result_menu = sqlsrv_query($conn,$query_menu);
	$this->menu.="<div align='left' style=\" border:0px solid #FFFFFF;height: 10px;  width: 1200px;\">
                    <ul class=\"dropdown\">";
	 while($row_menu = sqlsrv_fetch_array($result_menu)){			
	$this->menu.="<li><a href=".$baseroot.'/'.$row_menu['fileKey'].">".$row_menu['caption']."</a>
					<ul class=\"dropdown\">";
if ($Loaduserlevel=='SA') {
		$query_sub_menu="select * from tblmenu where display='Y' and pkey='".$row_menu['ckey']."' order by slno";
} else {
$query_sub_menu="select distinct m.* from tblmenu m left join tblpermission p on m.ckey=p.ckey left join tblmenu m2 on m2.ckey=m.pkey where m.display='Y' and m.pkey='".$row_menu['ckey']."' and (p.loginID='$currentuser' or (m.userAccess='RU' or m.userAccess='HU' or m.userAccess='AL')) order by m.slno";
}
		$result_sub_menu = sqlsrv_query($conn,$query_sub_menu);
				 while($row_sub_menu = sqlsrv_fetch_array($result_sub_menu)){			
		$this->menu.="<li><a href=".$baseroot.'/'.$row_sub_menu['fileName'].">".$row_sub_menu['caption']."</a></li>";
			}					
 $this->menu.="</ul>
					</li>";
sqlsrv_free_stmt( $result_sub_menu);			
	}
	$this->menu.="</ul>                
					</div>";
sqlsrv_free_stmt( $result_menu);			
}



//User Permission Menu Start
function user_permission_menu($Suserlevel,$Gmenudisplay,$Gchkmenu,$currentuser,$usertype,$conn){
//echo $Suserlevel;
	$this->permission_menu.="<table width=200 id='tbluserpermission'>";
	if ($usertype=='SA') {
	
		if ($Suserlevel=='SU') {
		$query_menu = "select * from tblmenu where display='Y' and userAccess<>'SA' and pkey='' order by slno";
		} elseif ($Suserlevel=='BM') {
		$query_menu = "select * from tblmenu where display='Y' and (userAccess='OM' or userAccess='OU' or userAccess='BM' or userAccess='RU' or userAccess='BU' or userAccess='CM' or userAccess='UR' or userAccess='CM' or userAccess='CU' or userAccess='TM' or userAccess='TU' or userAccess='HU') and pkey='' order by slno";
		} elseif ($Suserlevel=='RU') {
		$query_menu = "select * from tblmenu where display='Y' and (userAccess='OU' or userAccess='RU' or userAccess='UR' or userAccess='TU' or userAccess='HU') and pkey='' order by slno";
		}  elseif ($Suserlevel=='BU') {
		$query_menu = "select * from tblmenu where display='Y' and (userAccess='OU' or userAccess='RU' or userAccess='BU' or userAccess='UR' or userAccess='TU' or userAccess='HU') and pkey='' order by slno";
		} elseif ($Suserlevel=='CM') {
		$query_menu = "select * from tblmenu where display='Y' and (userAccess='OM' or userAccess='OU' or userAccess='BM' or userAccess='RU' or userAccess='BU' or userAccess='UR' or userAccess='CM' or userAccess='CU' or userAccess='TM' or userAccess='TU' or userAccess='HU') and pkey='' order by slno";
		} elseif ($Suserlevel=='CU') {
		$query_menu = "select * from tblmenu where display='Y' and (userAccess='OU' or userAccess='CU' or userAccess='RU' or userAccess='BU' or userAccess='HU') and pkey='' order by slno";
		} elseif ($Suserlevel=='MR') {
		$query_menu = "select * from tblmenu where display='Y' and (userAccess='OM' or userAccess='OU' or userAccess='BM' or userAccess='RU' or userAccess='BU' or userAccess='CM' or userAccess='UR' or userAccess='CM' or userAccess='CU' or userAccess='TM' or userAccess='TU' or userAccess='HU') and pkey='' order by slno";
		} elseif ($Suserlevel=='UR') {
		$query_menu = "select * from tblmenu where display='Y' and (userAccess='OM' or userAccess='OU' or userAccess='BM' or userAccess='RU' or userAccess='BU' or userAccess='CM' or userAccess='UR' or userAccess='CM' or userAccess='CU' or userAccess='TM' or userAccess='TU' or userAccess='HU') and pkey='' order by slno";
		} elseif ($Suserlevel=='SM') {
		$query_menu = "select * from tblmenu where display='Y' and slno='100' order by slno";
		} else {
		$query_menu = "select distinct m2.* from tblmenu m inner join tblmenu m2 on m2.ckey=m.pkey where m2.display='Y' and m2.userAccess is NULL";
	
		}

	} else 	{
		$query_menu = "select distinct m2.* from tblmenu m inner join tblpermission p on m.ckey=p.ckey
inner join tblmenu m2 on m2.ckey=m.pkey where m2.display='Y' and p.loginID='$currentuser'";
	}
	
	$result_menu = sqlsrv_query($conn,$query_menu);
	//echo $Gchkmenu;
	$chkarray= explode(',',$Gchkmenu);
	$i=1;
	if ($result_menu) {
	 while($row_menu = sqlsrv_fetch_array($result_menu)){			
	$this->permission_menu.="<tr><td class='mnucolor' bgcolor='#23559c'><a href='javascript:void(0)' onclick=\"submenudisplay('tbluserpermission','tblu$i')\"><font color='#FFFFFF'>".$row_menu['caption'] . "</font></a></td></tr>";
 		if ($usertype=='SA') {		
		if ($Suserlevel=='SU') {
		$query_sub_menu="select * from tblmenu where display='Y' and (userAccess='SU' or userAccess='OM' or userAccess='OU' or userAccess='BM' or userAccess='RU' or userAccess='BU' or userAccess='CM' or userAccess='CU' or userAccess='RL' or userAccess='TM' or userAccess='TU' or userAccess='HU') and pkey='".$row_menu['ckey']."' order by slno";
		} elseif ($Suserlevel=='BM') {
		$query_sub_menu="select * from tblmenu where display='Y' and (userAccess='OM' or userAccess='OU' or userAccess='BM' or userAccess='RU' or userAccess='BU' or userAccess='CM' or userAccess='CU' or userAccess='RL' or userAccess='TM' or userAccess='TU' or userAccess='HU') and pkey='".$row_menu['ckey']."' order by slno";
		} elseif ($Suserlevel=='RU') {
		$query_sub_menu="select * from tblmenu where display='Y' and (userAccess='CU' or userAccess='OU' or userAccess='RU' or userAccess='BU' or userAccess='RL' or userAccess='TU' or userAccess='HU') and pkey='".$row_menu['ckey']."' order by slno";
		} elseif ($Suserlevel=='BU') {
		$query_sub_menu="select * from tblmenu where display='Y' and (userAccess='OU' or userAccess='BU' or userAccess='RL' or userAccess='RF' or userAccess='UR' or userAccess='TU' or userAccess='HU') and pkey='".$row_menu['ckey']."' order by slno";
		} elseif ($Suserlevel=='CM') {
		$query_sub_menu="select * from tblmenu where display='Y' and (userAccess='OM' or userAccess='OU' or userAccess='BM' or userAccess='RU' or userAccess='BU' or userAccess='CM' or userAccess='CU' or userAccess='RL' or userAccess='TM' or userAccess='TU' or userAccess='HU') and pkey='".$row_menu['ckey']."' order by slno";
		} elseif ($Suserlevel=='CU') {
		$query_sub_menu="select * from tblmenu where display='Y' and (userAccess='OU' or userAccess='CU' or userAccess='RU' or userAccess='BU' or userAccess='HU') and pkey='".$row_menu['ckey']."' order by slno";
		} elseif ($Suserlevel=='MR') {
		$query_sub_menu="select * from tblmenu where display='Y' and (userAccess='AL' or userAccess='HU') and pkey='".$row_menu['ckey']."' order by slno";
		} elseif ($Suserlevel=='UR') {
		$query_sub_menu="select * from tblmenu where display='Y' and (userAccess='AL' or userAccess='HU') and pkey='".$row_menu['ckey']."' order by slno";
		} elseif ($Suserlevel=='SM') {
		$query_sub_menu="select * from tblmenu where display='Y' and (slno='101' or slno='102' or slno='103' or slno='106' or slno='107' or slno='109') and pkey='".$row_menu['ckey']."' order by slno";
		} elseif ($Suserlevel=='SC') {
		$query_sub_menu="select * from tblmenu where display='Y' and (slno='102' or slno='103') and pkey='".$row_menu['ckey']."' order by slno";
		} else {
		$query_sub_menu="select distinct m.* from tblmenu m inner join tblmenu m2 on m2.ckey=m.pkey where m.userAccess<>'OM' and m.display='Y' and m.pkey='".$row_menu['ckey']."' order by m.slno";
		}
		
		} else {
		//Manager Permission
		
				if ($Suserlevel=='SU') {
		$query_sub_menu="select distinct m.* from tblmenu m inner join tblpermission p on m.ckey=p.ckey where m.display='Y' and m.userAccess<>'SU' and m.pkey='".$row_menu['ckey']."' and p.loginID='$currentuser' order by slno";
		} elseif ($Suserlevel=='BM') {
		$query_sub_menu="select distinct m.* from tblmenu m inner join tblpermission p on m.ckey=p.ckey where m.display='Y' and (m.userAccess='HU' or m.userAccess='OM' or m.userAccess='OU' or m.userAccess='BM' or m.userAccess='BU' or m.userAccess='CU' or m.userAccess='RL' or m.userAccess='TM' or m.userAccess='TU') and m.pkey='".$row_menu['ckey']."' and p.loginID='$currentuser' order by slno";
		} elseif ($Suserlevel=='RU') {
		$query_sub_menu="select distinct m.* from tblmenu m inner join tblpermission p on m.ckey=p.ckey where m.display='Y' and (m.userAccess='HU' or m.userAccess='OU' or m.userAccess='BU' or m.userAccess='RL' or m.userAccess='TU') and m.pkey='".$row_menu['ckey']."' and p.loginID='$currentuser' order by slno";
		} elseif ($Suserlevel=='BU') {
		$query_sub_menu="select distinct m.* from tblmenu m inner join tblpermission p on m.ckey=p.ckey where m.display='Y' and (m.userAccess='HU' or m.userAccess='OU' or m.userAccess='BU' or m.userAccess='RL' or m.userAccess='RF' or m.userAccess='UR' or m.userAccess='TU') and m.pkey='".$row_menu['ckey']."' and p.loginID='$currentuser' order by slno";

		} elseif ($Suserlevel=='CM') {
		$query_sub_menu="select distinct m.* from tblmenu m inner join tblpermission p on m.ckey=p.ckey where m.display='Y' and (m.userAccess='OM' or m.userAccess='OU' or m.userAccess='BM' or m.userAccess='RU' or m.userAccess='BU' or m.userAccess='CM' or m.userAccess='CU' or m.userAccess='RL' or m.userAccess='TM' or m.userAccess='TU' or m.userAccess='HU') and m.pkey='".$row_menu['ckey']."' and p.loginID='$currentuser' order by slno";
		} elseif ($Suserlevel=='CU') {
		$query_sub_menu="select distinct m.* from tblmenu m inner join tblpermission p on m.ckey=p.ckey where m.display='Y' and (m.userAccess='HU' or m.userAccess='OU' or m.userAccess='BU' or m.userAccess='CU' or m.userAccess='RL' or m.userAccess='TM' or m.userAccess='TU') and m.pkey='".$row_menu['ckey']."' and p.loginID='$currentuser' order by slno";

		} elseif ($Suserlevel=='MR') {
		$query_sub_menu="select distinct m.* from tblmenu m inner join tblpermission p on m.ckey=p.ckey where m.display='Y' and (m.userAccess='HU' or m.userAccess='OM' or m.userAccess='OU' or m.userAccess='BM' or m.userAccess='RL' or m.userAccess='RF') and m.pkey='".$row_menu['ckey']."' and p.loginID='$currentuser' order by slno";

		} elseif ($Suserlevel=='UR') {
		$query_sub_menu="select distinct m.* from tblmenu m inner join tblpermission p on m.ckey=p.ckey where m.display='Y' and (m.userAccess='HU' or m.userAccess='OU' or m.userAccess='RL' or m.userAccess='RF') and m.pkey='".$row_menu['ckey']."' and p.loginID='$currentuser' order by slno";

		} elseif ($Suserlevel=='SM') {
		$query_sub_menu="select * from tblmenu where display='Y' and (slno='101' or slno='102' or slno='103' or slno='106' or slno='107' or slno='109') and pkey='".$row_menu['ckey']."' order by slno";
		} elseif ($Suserlevel=='SC') {
		$query_sub_menu="select * from tblmenu where display='Y' and (slno='102' or slno='103') and pkey='".$row_menu['ckey']."' order by slno";
		} else {
		$query_sub_menu="select distinct m.* from tblmenu m inner join tblpermission p on m.ckey=p.ckey where m.display='Y' and m.userAccess<>'OM' and m.pkey='".$row_menu['ckey']."' and p.loginID='$currentuser' order by slno";
		}
		//Manager Permission
		}

		$result_sub_menu = sqlsrv_query($conn,$query_sub_menu);
			$this->permission_menu.="<tr class='tblu$i' style=\"display: none;\"><td width=100%><table width=100% border=0>";

			 while($row_sub_menu = sqlsrv_fetch_array($result_sub_menu)){			
			$checkedmenu='';
			//echo $row_sub_menu['ckey'], $chkarray[0].';';
			if (in_array($row_sub_menu['ckey'], $chkarray,true)) {
				$checkedmenu="checked";
			}

			$this->permission_menu.="<tr><td class='submnucolor'><input type=\"checkbox\" name=\"chkuserpermission[]\" value=".$row_sub_menu['ckey']." $checkedmenu>".$row_sub_menu['caption'] . "</td></tr>";

			}
			$this->permission_menu.="</table></td></tr>";
	$i++;
sqlsrv_free_stmt( $result_sub_menu);			
	}
	}
	$this->permission_menu.="</table>";

sqlsrv_free_stmt( $result_menu);			

}



//User Permission Menu End
function current_company($gcompanyid,$conn){
		$query = "select * from tblcompany where companyid ='". $gcompanyid ."'";
        $result = mysql_query($query);
		$row = mysql_fetch_array($result);
		$this->companyName=$row['companyname'];
		$this->companyDate=date("d-m-Y",strtotime($row['currDate']));
		$this->currdeptdate=date("Y-m-d 00:00:00",strtotime($row['currDate']));
		$this->companytype=$row['companytype'];
		return $this->companyName;
sqlsrv_free_stmt( $result);					
}
function current_user(){
$this->current_company($this->companyID);
$this->CurrentUser="<table width=100% class=msgbox  border=0 cellpadding=0 cellspacing=0>
         <tr>
           <td colspan=2 class=tbg><strong>Current User and Company Information </strong></td>
         </tr>
         <tr>
           <td>".$this->companyName. " => " . $this->UserName . $this->userLevelName ."</td>
		   
		   <td class=H2></td>
         </tr>
         <tr>
           <td>&nbsp;</td>
		   <td>&nbsp;</td>
         </tr>
       </table>";
}
function login_success(){
	if (!($this->SuccessUser)){
	header("location:../index.php"); // Re-direct to main.php
	exit; 
	} 
}


//Page Restriction Start
function restricpage($userid,$Loaduserlevel,$filename,$systemstatus,$connectioninfo_jbrps) {
	$userip = $_SERVER['REMOTE_ADDR'];
	$branch_code = 	$_SESSION['userjblocat'] ;
	$session_currdate = $_SESSION['session_currdate'];
	
	if (($systemstatus=='Y') && (($Loaduserlevel!='SA') && ($Loaduserlevel!='SU'))) { //Diffrent System Date
	//$sql_date="select * from tblbasics where convert(date,currDate)=convert(date,GETDATE())";
	//$result_date=sqlsrv_query($conn,$sql_date,array(),array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
	//$row_date=sqlsrv_num_rows($result_date);
		//if ($row_date==0) {
		if ($session_currdate <> date("Y-m-d",time())) {
		echo "<br><br><br><span class='error'>Sorry, Transaction Closed. Wait. . . . . </span><br><br></br> <a href=\"javascript: history.go(-1)\">Go Back</a>";
		exit;	
		}
	//Check IP Verify
	$sql_ip_verify = "exec proc_ip_verified 'L','$branch_code','$userip', '$userid'";
	//echo 'HI'.$sql_ip_verify."<br>".$connectioninfo_jbrps;
        $result_ip_verify=sqlsrv_query($connectioninfo_jbrps,$sql_ip_verify);
	$row_ip_verify=sqlsrv_fetch_array($result_ip_verify);
	$verified = $row_ip_verify[0];
	$verified = $_SESSION['jrbrpsipverified'];
		if ($verified!='Verified') {
		echo "<br><br><br><span class='error'>Sorry, Your IP Not Verified. Please Verify Your Machine IP With Manager ID</span><br><br></br> <a href=\"../jr_common_forms/frmreqipverify.php\">Click Here</a>";
		exit;	
		}

	} 

	if ((($Loaduserlevel!='SA') && ($Loaduserlevel!='SU'))) { //Diffrent System Date

			if ($branch_code!='7777') {
				if ($systemstatus=='W') {
				echo "<br><br><br><span class='error'>Wait Please, Data Uploading . . . . . . . </span><br><br><a href=\"javascript: history.go(-1)\">< Back</a>";
			exit;
				}
			}
$mnu_running =   explode("/jbutility/",$_SERVER['SCRIPT_NAME']);
$running_file =  $mnu_running[1];
//echo $running_file;
 				$session_menu_file = $_SESSION['session_menu_file'];
				$session_sub_menu_file ="search/". $_SESSION['session_sub_menu_file'];
				//echo $session_sub_menu_file;
$mnurestrict = strpos($session_sub_menu_file, $running_file);
//echo $mnurestrict;
			if ($mnurestrict==false) {
			echo "<br><br><br><span class='error'>Sorry, You Are Not Allowd For This Module</span><br><br><a href=\"javascript: history.go(-1)\">< Back</a>";
			exit;	
			} 
}

}
//Page Restriction End

//End Class
}
?>