<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
define('BASEPATH','index.php');

include '../js_settings/domainsettings.php';

if (isset($commandArray[0])) $moduletype=$commandArray[0];


//define('SALT_LENGTH', 7);

include '../js_dbconn/dbmycon.php';
include '../js_classes/class_call.php';
include '../loginfail.php';

if ($moduletype=='JBRPS') {
$mnu_conn = $conn;
$header_location = $jbrpsroot;
//echo 'sdf';
} else if ($moduletype=='JBSSCR') {
$mnu_conn = $conn_sanction;
$header_location = $jbsscroot;
}
//echo $moduletype;
//exit;
	
	
//User Menu Session Start
$session_menu_file='';
$session_sub_menu_file='';
	//if ($row['userLevel']=='SA') {
    $query_menu = "select * from tblmenu where display='Y' and pkey='' order by slno";
    $result_menu = sqlsrv_query($mnu_conn,$query_menu);
	while($row_menu = sqlsrv_fetch_array($result_menu)){
		$session_menu_file .= $row_menu['fileKey'] . '#'.$row_menu['caption']. '!'; 
		//Sub Menu Start
		$session_sub_sub_menu_file='';
		if ($Loaduserlevel=='SA') {
		$query_sub_menu="select * from tblmenu where display='Y' and pkey='".$row_menu['ckey']."' order by slno";
		} else {
		$query_sub_menu="select m.* from tblmenu m left join tblpermission p on m.ckey=p.ckey where m.display='Y' and m.pkey='".$row_menu['ckey']."' and p.loginID='$usr_id'
		union
		select m.* from tblmenu m where m.display='Y' and m.pkey='".$row_menu['ckey']."' and (m.userAccess='RU' or m.userAccess='HU' or m.userAccess='AL') order by m.slno";
		}
		$result_sub_menu = sqlsrv_query($mnu_conn,$query_sub_menu);
		while($row_sub_menu = sqlsrv_fetch_array($result_sub_menu)){			
		$session_sub_sub_menu_file .= $row_sub_menu['fileName'] . '#'.$row_sub_menu['caption']. '!';
		}
		$session_sub_menu_file .=substr($session_sub_sub_menu_file,0,-1).'@';
		//Sub Menu End
	sqlsrv_free_stmt( $result_sub_menu);
	}
sqlsrv_free_stmt( $result_menu);
//echo $session_sub_menu_file;
		$_SESSION['session_menu_file'] = substr($session_menu_file,0,-1);
		$_SESSION['session_sub_menu_file'] = substr($session_sub_menu_file,0,-1);
		
//echo $_SESSION['session_sub_menu_file'];
//exit;
//User Menu Sessin End
//Pending
if ($moduletype=='JBRPS') {
		$sql_respond="select count(org_brcode) as pending from tbladvice where res_brcode='$branch_code' and org_status='A' and (res_status='P' or res_status='W')";
	$result_respond=sqlsrv_query($conn,$sql_respond);
	$row_respond = sqlsrv_fetch_array($result_respond);
	$respond_pending = $row_respond["pending"];
	$_SESSION['respond_pending'] = $respond_pending;
	sqlsrv_free_stmt( $result_respond);

$sql_org_lastday_pending = "exec proc_orgapprove_orgreject '$branch_code','$userdeptcode','O'";
$result_org_lastday_pending=sqlsrv_query($conn,$sql_org_lastday_pending);
$row_org_lastday_pending=sqlsrv_fetch_array($result_org_lastday_pending);
$org_lastday_pending = $row_org_lastday_pending[0];
$_SESSION['org_lastday_pending'] = $row_org_lastday_pending[0];
sqlsrv_free_stmt( $result_org_lastday_pending);

//Before One Month Pending
if (($org_lastday_pending=='') || (is_null($org_lastday_pending))) {
$sql_org_lastday_pending = "exec proc_orgapprove_orgreject '$branch_code','$userdeptcode','M'";
$result_org_lastday_pending=sqlsrv_query($conn,$sql_org_lastday_pending);
$row_org_lastday_pending=sqlsrv_fetch_array($result_org_lastday_pending);
//$org_lastday_pending = $row_org_lastday_pending[0];
$_SESSION['org_lastday_pending'] = $row_org_lastday_pending[0];
sqlsrv_free_stmt( $result_org_lastday_pending);
}

$sql_res_lastday_pending = "exec proc_orgapprove_orgreject '$branch_code','$userdeptcode','R'";
$result_res_lastday_pending=sqlsrv_query($conn,$sql_res_lastday_pending);
$row_res_lastday_pending=sqlsrv_fetch_array($result_res_lastday_pending);
//$org_lastday_pending = $row_org_lastday_pending[0];
$_SESSION['res_lastday_pending'] = $row_res_lastday_pending[0];
sqlsrv_free_stmt( $result_res_lastday_pending);
}


//IP Verified
//$userip = $_SERVER['REMOTE_ADDR'];

$sql_ip_verify = "exec proc_ip_verified 'L','$branch_code','$userip','$usr_id'";
$result_ip_verify=sqlsrv_query($conn,$sql_ip_verify);
$row_ip_verify=sqlsrv_fetch_array($result_ip_verify);
$_SESSION['jrbrpsipverified'] = $row_ip_verify[0];
sqlsrv_free_stmt( $result_ip_verify);
//==========================
/* $login_history_sql="select * from tblloginhistory where  loginuser='$userID' and logstatus='T'";
$login_history_result=sqlsrv_query($conn,$login_history_sql);
$login_history_row=sqlsrv_fetch_array($login_history_result);
if (!$login_history_row) {
$login_history_insert="insert into tblloginhistory (loginuser,logindate,logintime,logstatus,userip) values ('$usr_id','".date("Y-m-d g:i a",time())."','".date("Y-m-d g:i a",time())."','T','".$userip."')";
$result_login_history = sqlsrv_query($conn,$login_history_insert);
sqlsrv_free_stmt( $result_login_history);
}
 *///==========================


		//$result_loggied = sqlsrv_query($conn,"update tblusers set usertry=0,sessk_ey='".$esessionkey."',logged='T',loginTime='".date("Y-m-d g:i a",time())."', loggedip='$userip' where loginID=".$usr_id."");

//sqlsrv_free_stmt( $result_loggied);
	//echo "<meta HTTP-EQUIV='REFRESH' CONTENT='0; URL=http://localhost/jbremittance/jbrpshome.php' target='_self'>";

		header("location:".$header_location.""); // Re-direct to main.php
		exit;
		


sqlsrv_free_stmt( $result);
sqlsrv_close($conn);
?>