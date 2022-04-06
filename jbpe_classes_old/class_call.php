<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//include 'clsbasics.php';
require_once('clsbasics.php');

$basicClass= new Basics;

$ua=$basicClass->getBrowser();

require_once('clsdatasecurity.php');
$DataSecurity = new DataEncSecurity;
require_once('clssecurity.php');
$CISecurity = new CI_Security;
require_once('clsmenu.php');
$usermenu = new UserAccess;
require_once('clsdataview.php');
$dataviewclass = new DataView;
require_once('clscodeview.php');
$codeviewclass = new DataCodeView;
require_once('clsdatainsert.php');
$InsertClass = new DataInsert;



$runningfile="http://".$_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
//$currsoftdate=date("d-m-Y",strtotime($basicClass->currentdate));

//$currsoftdate=date("d-m-Y",strtotime($_SESSION['session_currdate']));

$actionlink='';
$currdatetime = date("Y-m-d g:i:s a",time());
//$userip = $_SERVER['REMOTE_ADDR'];
if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
$userip = htmlentities($_SERVER["HTTP_X_FORWARDED_FOR"],  ENT_QUOTES,  "utf-8");
} else {
$userip = htmlentities($_SERVER["REMOTE_ADDR"],  ENT_QUOTES,  "utf-8");
}


//$userip = getHostByName(getHostName());

//$dateexp = new DateTime($basicClass->currentdate);
//$interval = new DateInterval('P1M');
//$dateexp->add($interval);
//$passexpiary = $dateexp->format('Y-m-d');
//$dateexpnotice = new DateTime($basicClass->currentdate);
//$intervalnotice = new DateInterval('P5D');
//$dateexpnotice->sub($intervalnotice);
//$noticeexpiary = $dateexpnotice->format('Y-m-d');
?>