<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Basics {
public $FirmName,$SoftName,$ImageLoc,$HeaderPage,$systemstatus,$currsoftdate,$duelcheck,$duellimit,$comsaltkey,$brseckey,$topmenu,$bottommenu,$deptname;
	function pageHeader($branch_code,$userbranchname,$deptcode,$logout,$Loaduserlevel,$baseroot) {
	    $deptname='';
		$this->currentdate='';
		//$query = "select * from tblbasics";
        //$result = sqlsrv_query($conn,$query);
		//if(!$result) die("Query didn't work. ");
		//$row = sqlsrv_fetch_array($result);
		if (isset($_SESSION['firmName'])) $this->FirmName=$_SESSION['firmName'];

		//$this->FirmName=$_SESSION['firmName'];
		$this->systemstatus='Y';
		//$this->SoftName=$row['softName'];
		if (isset($_SESSION['session_currdate'])) $this->currentdate=$_SESSION['session_currdate'];

		//$this->comsaltkey=trim($row['com_salt']);
		
		//=========================
	//if ($branch_code=='9999') {
	//$sql_deptname="select deptcode,deptname from tbldepartment where brcode='$branch_code' and deptcode='$deptcode'";
	//$result_deptname=sqlsrv_query($conn,$sql_deptname);
	//$row_deptname=sqlsrv_fetch_array($result_deptname);
	//$deptname = " [".$row_deptname['deptname']."]";
	//}
		//$deptname = $_SESSION['deptname']; 
		if (isset($_SESSION['deptname'])) $deptname=$_SESSION['deptname'];

		//=========================
		//$sql_respond="select count(org_brcode) as pending from tbladvice where res_brcode='$branch_code' and org_status='A' and (res_status='P' or res_status='W')";
	//$result_respond=sqlsrv_query($conn,$sql_respond);
	//$row_respond = sqlsrv_fetch_array($result_respond);
	$pending = '';
	$respending = '';
		if (isset($_SESSION['respond_pending'])) $respending=$_SESSION['respond_pending'];

					if ($respending>0) {
					$pending = "<br><div align='center'><BLINK><span class='error'>Advice Respond Pending/Waiting</span></BLINK></div>";
					}
					
$brseckey='';
//$userip = $_SERVER['REMOTE_ADDR'];
if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
$userip = $_SERVER["HTTP_X_FORWARDED_FOR"];
} else {
$userip = $_SERVER["REMOTE_ADDR"];
}

//$userip = getHostByName(getHostName());

//$sql_ip_verify = "exec proc_ip_verified 'L','$branch_code','$userip'";
//$result_ip_verify=sqlsrv_query($conn,$sql_ip_verify);
//$row_ip_verify=sqlsrv_fetch_array($result_ip_verify);
//$verified = $row_ip_verify[0];
//$verified = $_SESSION['jrbrpsipverified'];
$verified='';
		if (isset($_SESSION['jrbrpsipverified'])) $verified=$_SESSION['jrbrpsipverified'];

if ($verified=='Verified') {
$verified = "IP : $userip <a href='$baseroot/jr_common_forms/frmreqipverify.php'><SPAN class='RM_head'>[ Verified ]</SPAN></a>";
} else {
$verified = "IP : $userip <a href='$baseroot/jr_common_forms/frmreqipverify.php'><SPAN class='error'>[ Un Verified ]</SPAN></a>";
}
//Top Menu
  $this->topmenu = '<table width="100%"  border="0" class="indexbox">
     <tr>
       <td width="150"><table id="tbltoday" width="150"  border="0" cellpadding="0" cellspacing="0" class="msgbox">
         <tr>
           <td><div align="center" class="tbg"><strong>Today</strong></div></td>
         </tr>
         <tr>
           <td><div align="center">'. date("l")."<br>". date("d-M-Y",time()).'</div></td>
         </tr>
         <tr>
           <td align="center"><DIV id="display" align="center"></DIV></td>
         </tr>
       </table></td>
       <td width="703">
         <div align="center"><table width="700"  border=0 align=center>
         <tr>
           <td rowspan="4" valign="middle"><div align="center"><img src="'.$baseroot.'/images/logo.jpg" width=49 height=36 /><br>'.$this->FirmName.'</div></td>
           <td width="501" class="H1"><div align="center">PASSPORT ENDORSEMENT SYSTEM</div></td>
		 </tr>
         <tr>
           <td><span class="H2"><div align="center">Date : '.date("d-m-Y",strtotime($this->currentdate)).'</div></span></td>
          </tr>
         <tr>
           <td><span class="H2"><div class="ver11" align="center">'.$userbranchname.$deptname.' ('.$branch_code.')</div></span></td>
          </tr>
         <tr>
           <td><span class="H2"><div class="bb" align="center">'.$verified.'</div></span></td>
          </tr>
       </table>
		 </div></td>
       <td width="153"><table id="tbltoday" width="150"  border="0" cellpadding="0" cellspacing="0" class="msgbox">
           <tr>
             <td><div align="center" class="tbg"><strong>Current User</strong></div></td>
           </tr>
           <tr>
             <td><div align="center">'.$logout.'</div></td>
           </tr>
           <tr>
             <td align="center"><div id="div" align="center">'.$brseckey.'</div></td>
           </tr>
         </table></td>
     </tr>
  </table>';

//Top Menu
//Bottom Menu
//$this->bottommenu='<div id="helpopenModal" class="modalDialog">
//	<div>
//		<a href="#close" title="Close" class="close">X</a>
//                <span id="ctlbottom"></span>
//        </div>
//</div><table width="100%"  border="0" class="tbg">
//     <tr>
//       <td class="tbg"><div align="center"> <a href=\''.$baseroot.'\jr_common_forms/rpt_branch_list.php/A\' target=\'_blank\'><strong><font color="#FFFFFF">Active Branch List</font></strong></a> | <a href=\''.$baseroot.'\jr_common_forms/rpt_branch_list.php/I\' target=\'_blank\'><strong><font color="#FFFFFF">Inactive Branch List</font></strong></a> | <a href=\'#helpopenModal\' onclick=usermanual(\''.$baseroot.'\')><strong><font color="#FFFFFF">User\'s Manual</font></strong></a> | <a href=\''.$baseroot.'/jr_help/videotutorial.php\' target=\'_blank\'><strong><font color="#FFFFFF">Video Tutorials</font></strong></a> | <a href=\'#helpopenModal\' onclick=jbrpssupport(\''.$baseroot.'\')><strong><font color="#FFFFFF">Support</font></strong></a> | <a href=\'#helpopenModal\' onclick=downloadsoftware(\''.$baseroot.'\')><strong><font color="#FFFFFF">Download</font></strong></a> | <a href=\'#helpopenModal\' onclick=showdeveloper(\''.$baseroot.'\')><strong><font color="#FFFFFF">Developed By</font></strong></a> </div></td>
//     </tr>
//  </table>';

$this->bottommenu='<table width="100%"  border="0" class="tbg">
     <tr>
       <td class="tbg"><div align="center"> <a href=\''.$baseroot.'\jr_common_forms/rpt_branch_list.php/A\' target=\'_blank\'><strong><font color="#FFFFFF">Active Branch List</font></strong></a> | <a href=\''.$baseroot.'\jr_common_forms/rpt_branch_list.php/I\' target=\'_blank\'><strong><font color="#FFFFFF">Inactive Branch List</font></strong></a> | <a href=\''.$baseroot.'/jr_help/usermanual.php\' target=\'_blank\'><strong><font color="#FFFFFF">User\'s Manual</font></strong></a> | <a href=\''.$baseroot.'/jr_help/videotutorial.php\' target=\'_blank\'><strong><font color="#FFFFFF">Video Tutorials</font></strong></a> | <a href=\''.$baseroot.'/jr_help/support.php\' target=\'_blank\'><strong><font color="#FFFFFF">Support</font></strong></a>  | <a href=\''.$baseroot.'/downloads/downloads.php\' target=\'_blank\'><strong><font color="#FFFFFF">Download</font></strong></a>  | <a href=\''.$baseroot.'/jr_help/frmdevelopers.php\' target=\'_blank\'><strong><font color="#FFFFFF">Developed By</font></strong></a>  </div></td>
     </tr>
     </table>
     <br>
     <table width="100%"  border="0" class="tbg">
     <tr>
	   </tr>
	   	<td>
	   	</td>
	 	 <tr>
       <td background="'.$baseroot.'/images/jbl_brand.jpg" height="44"></td>
	   </tr>
  </table>';

//Bottom Menu
	}

	function Indexpage($firmName,$currdate) {
	    //$query = "select * from tblbasics";
        //$result = sqlsrv_query($conn,$query);
		//if(!$result) die("Query didn't work. ");
		//$row = sqlsrv_fetch_array($result);
		//$this->FirmName=$row['firmName'];		
		//$this->SoftName=$row['softName'];
		$this->currentdate=$currdate;
		//$this->comsaltkey=trim($row['com_salt']);
		$this->HeaderPage="<table width=341  border=0 align=center>
         <tr>
           <td rowspan=3 width=49><img src='jbremitthome/images/logo.jpg' width=49 height=36 /></td>
           <td width=282 class=\"H1\"><div align='center'>".$firmName ."</div></td>
         </tr>
         <tr>
           <td><span class=\"H2\"><div align='center'>JB Remittance Payment System</div></span></td>
          </tr>
         <tr>
           <td><span class=\"H2\"><div class='ver11' align='center'>Date : ".date('d-m-Y',strtotime($currdate))."</div></span></td>
          </tr>
       </table>";
	}

//inwords
function convert_number($number) 
{ 
if (($number < 0) || ($number > 9999999999999)) 
{ 
return "$number"; 
} 
$decimal='';

//echo $number;
	   //list($int,$decimal)=explode('.', $number);
		/* $intnumber = (int) $number;
		$decnumber = $number - $intnumber;
		if ($decnumber>0) {
	   	//list($int,$decimal)=explode('.', $number);		
		$decimal=substr($decnumber,2,strlen($decnumber));
		} else {
		//$int=$number;
		$decimal='';
		} */			   


$Cr = floor($number / 10000000); /* Crore (giga) */ 
$number -= $Cr * 10000000; 

$Lc = floor($number / 100000); /* Lac (giga) */ 
$number -= $Lc * 100000; 

$kn = floor($number / 1000); /* Thousands (kilo) */ 
$number -= $kn * 1000; 
$Hn = floor($number / 100); /* Hundreds (hecto) */ 
$number -= $Hn * 100; 
$Dn = floor($number / 10); /* Tens (deca) */ 
$number -= $Dn * 10; //== 

$n = $number % 10; /* Ones */ 
$number -= $n % 10; //== 

//$decimal = $number;

$res = ""; 

if ($Cr) 
{ 
$res .= $this->convert_number($Cr) . " Crore "; 
} 

if ($Lc) 
{ 
$res .= $this->convert_number($Lc) . " Lac "; 
} 

if ($kn) 
{ 

$res .= $this->convert_number($kn) . " Thousand"; 

} 

if ($Hn) 
{ 
$res .= (empty($res) ? "" : " ") . 
$this->convert_number($Hn) . " Hundred"; 
} 

$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", 
"Nineteen"); 
$tens = array("", "", "Twenty ", "Thirty ", "Forty ", "Fifty ", "Sixty ", 
"Seventy ", "Eigthy ", "Ninety "); 

if ($Dn || $n) 
{ 

	if (!empty($res)) 
	{ 
	$res .= " "; 
	} 

	if ($Dn < 2) 
	{ 
	$res .= $ones[$Dn * 10 + $n]; 
	} 
	else 
	{ 
	$res .= $tens[$Dn]; 
	
		if ($n) 
		{ 
		$res .= $ones[$n] ; 
		} 
	} 
} 


if (empty($res)) 
{ 
$res = "zero"; 
} 


		if ($number>0) {		
		$decimal=substr(round($number,2),2,2);
			if (strlen($decimal)==1) {
			$decimal=$decimal.'0';
			}
		$Dec = floor($decimal / 10); 
		$nc = $decimal % 10; 
		$res .=" and ";

		if ($Dec < 2) 
		{ 
		$res .= $ones[$Dec * 10 + $nc]; 
		} 
		else 
		{ 
		$res .= $tens[$Dec]; 
		
			if ($nc) 
			{ 
			$res .= $ones[$nc] ; 
			} 
		} 
	$res .=" Paisa ";
		} 

return $res ; 
} 
//inwords
//Money Format
function moneyformat($number){ 
$number = number_format($number, 2, '.','');
$explrestunits='';
		$intnumber = (int) $number;
		$decnumber =  $number - $intnumber;
		//echo $decnumber;
		if ($decnumber>0) {
	   	list($num,$decimal)=explode('.', $number);		
		} else if ($decnumber==0) {
		$num=$intnumber;
		$decimal='';			
		}else {
		$num=$number;
		$decimal='';
		}
		
		if (empty($decimal)) {
		$decimal="00";
		} else if (strlen($decimal)==1){
		$decimal =$decimal . "0"; 
		}
    if(strlen($num)>3){ 
            $lastthree = substr($num, strlen($num)-3, strlen($num)); 
            $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits 
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping. 

            $expunit = str_split($restunits, 2); 
            for($i=0; $i<sizeof($expunit); $i++){ 
					if ($i==0) {
                $explrestunits .= (int)$expunit[$i].","; // creates each of the 2's group and adds a comma to the end 
					} else {
                $explrestunits .= $expunit[$i].","; // creates each of the 2's group and adds a comma to the end 					
					}
            }    

            $thecash = $explrestunits.$lastthree; 
    } else { 
           $thecash = $num; 
    } 
    
    return $thecash.".".$decimal; // writes the final format where $currency is the currency symbol. 
}
//Money Format
//Browser Information
function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
    $ub = "";
	$require = 0;
	$required ="";
    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    //echo $u_agent;
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE";
		$require = 8.0; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
		$require = 17.0; 
    }
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
		$require = 24.0; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
		$require = 12.14; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    if (floatval($version)<floatval($require)) {
	$required =  "Your Browser ".$bname." ".$version." Not Supported. Minimum Required Version ".$require . "<br><br><br><strong>Alternate Browsers:</strong><br><a href='downloads/internetexplorer8.exe'>01.Internet Explorer 8.0</a><br><a href='downloads/mozilla17.exe'>02.Mozilla Firefox 17.0</a><br><a href='downloads/chrome24.exe'>03.Google Chrome 24.0</a><br><a href='downloads/AdbeRdr70_enu_full.exe'>04.Acrobat Reader 7.0</a>";		
	}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern,
		'require'   => $require,
		'required'   => $required
    );


} 
//Browser Information
}
?>