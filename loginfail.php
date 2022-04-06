<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
define('SALT_LENGTH', 7);

		$org_lastday_pending = '';
		$res_lastday_pending = '';
		$comsaltkey = '';
		$brch_code = '';
		$usr_id = '';
		$esessionkey = '';
		$userdeptcode = '';
		$userID = '';
		$currentusername = '';
		$Loaduserlevel = '';
		$userexpiarydate='';
		$userbranchname = '';
		$session_currdate = '';
		$session_expire_seconds = $_SESSION['session_expire_seconds'];
		if (isset($_SESSION['comsaltkey'])) $comsaltkey = $_SESSION['comsaltkey'];
		if (isset($_SESSION['session_currdate'])) $session_currdate=$_SESSION['session_currdate'];

		if (isset($_SESSION['userjblocat'])) $brch_code=$_SESSION['userjblocat'];
		if (isset($_SESSION['userjbremtt'])) $usr_id=$_SESSION['userjbremtt'];
		if (isset($_SESSION['esessionkey'])) $esessionkey=$_SESSION['esessionkey'];
		if (isset($_SESSION['userjblocat_dept'])) $userdeptcode=$_SESSION['userjblocat_dept'];
		if (isset($_SESSION['userID'])) $userID=$_SESSION['userID'];
		if (isset($_SESSION['currentusername'])) $currentusername=$_SESSION['currentusername'];
		if (isset($_SESSION['userLevel'])) $Loaduserlevel=$_SESSION['userLevel'];
		if (isset($_SESSION['userexpiarydate'])) $userexpiarydate=$_SESSION['userexpiarydate'];
		if (isset($_SESSION['userbranchname'])) $userbranchname=$_SESSION['userbranchname'];
		if (isset($_SESSION['org_lastday_pending'])) $org_lastday_pending=$_SESSION['org_lastday_pending'];
		if (isset($_SESSION['res_lastday_pending'])) $res_lastday_pending=$_SESSION['res_lastday_pending'];
		if (isset($_SESSION['res_month_pending'])) $res_month_pending=$_SESSION['res_month_pending'];
		if (isset($_SESSION['BrRouting'])) $brRouting=$_SESSION['BrRouting'];
	
  //$query = "select u.*,B.BranchName,B.Address,B.mang_mobile_no,B.br_open_close_status from tblusers u inner join Branch B on u.BranchCode=B.BranchCode where u.BranchCode='".$brch_code."' and u.loginID ='". $usr_id ."' and u.userStatus='A'";
 
        //$result = sqlsrv_query($conn,$query);
        //if(!$result) die("Query didn't work. ");
		//$row = sqlsrv_fetch_array($result);
		
//if ($row) {
		//$branch_code=$row['BranchCode'];
		//$logout=$userID."<br>[".$usr_id."]<br><a href='".$baseroot."/index.php'>Logout</a>";
		$logout=$userID."<br>[".$usr_id."]<br><a href='".$_SESSION['jb_solution_root']."/jbsolhome.php'>JB Solutions</a>";

//$Loaduserlevel = $row['userLevel'];

		$basicClass->pageHeader($brch_code,$userbranchname,$userdeptcode,$logout,$Loaduserlevel,$baseroot);
		//$userdeptcode = $row['deptcode'];
		//$comsaltkey=$basicClass->comsaltkey;
		//echo $_SESSION['comsaltkey'];
		$systemstatus=$basicClass->systemstatus;
		

		$DataSecurity->MyHashGenerate($usr_id,$comsaltkey);		
		
		$verifyesessionkey = $DataSecurity->mykeyhash;
		
		//echo $_SESSION['comsaltkey'];
		//exit;
  $query_session = "select u.sessk_ey from tblusers u where u.BranchCode='".$brch_code."' and u.loginID ='". $usr_id ."' and u.userStatus='A'";
  //echo $conn_jbrps.'fg'.$query_session; exit;
  $result_session = sqlsrv_query($conn_jbrps,$query_session);
  if(!$result_session) die("Query didn't work. ");
  $row_session = sqlsrv_fetch_array($result_session);
  if ($row_session) {
		$saved_sesskey=$row_session['sessk_ey'];
	}
		//$saved_sesskey=$esessionkey;
		
		$branch_code=$brch_code;
		$currentuser=$usr_id;
		//$currentusername=$row['userName'];
		
		$loginuserid=$usr_id;
		//$userbranchname=$row['BranchName'];
		//$secretkeymobile=$row['mang_mobile_no'];
		//$br_open_close_status=$row['br_open_close_status'];

		//$branchaddress=$row['Address'];
		//$userexpiarydate=$row['passexpiary'];
		
		$currsoftdate=date("d-m-Y",strtotime($session_currdate));
		
		$currdate_sql_format=date("Y-m-d",strtotime($session_currdate));
		
		$curr_rpt_date = date("d M Y",strtotime($currsoftdate));

$dateexp = new DateTime($session_currdate);

$interval = new DateInterval('P1M');
$dateexp->add($interval);
$passexpiary = $dateexp->format('Y-m-d');

		//echo $branch_code;



//} else {
	//header("location:index.php"); // Re-direct to main.php
	//exit;
//} 
//echo 'F';
//exit;
$session_remain_time = time() - $_SESSION['session_last_time'];

if (($session_remain_time > $session_expire_seconds) || empty($brch_code) || empty($usr_id) || empty($esessionkey) || ($esessionkey!=$saved_sesskey) || (strlen($esessionkey)==0) || (strlen($verifyesessionkey)==0) || (strlen($saved_sesskey)==0)) { 
	header("location:".$jbsolutionroot."/index.php"); // Re-direct to main.php
	exit;
} else {
		$_SESSION['session_last_time'] = time();
}

//echo $session_remain_time;

//if (empty($brch_code) || empty($usr_id) || empty($esessionkey) || ($esessionkey!=$verifyesessionkey) || ($saved_sesskey!=$verifyesessionkey)){ 
//if (empty($brch_code) || empty($usr_id) || empty($esessionkey) || ($esessionkey!=$saved_sesskey)){ 
//	header("location:index.php"); // Re-direct to main.php
//	exit;
//}
?>
