<?php
define('BASEPATH','jbremittancehome');
session_start();
require_once('../jbpe_settings/domainsettings.php');
require_once('../jbpe_dbconn/dbmycon.php');
//$conn = sqlsrv_connect($database_hostname,$connectioninfo);

require_once('../jbpe_classes/class_call.php');

require_once('../loginfail.php');
$usermenu->user_menu($Loaduserlevel,$loginuserid,$conn,$baseroot);
//$restrictlink="/jbnepsforms/neps_form/enroll.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title><?php echo $basicClass->SoftName; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
 <meta http-equiv="Pragma" content="no-cache">
 <meta http-equiv="Cache-Control"  content="no-cache">
<link href="<?PHP echo $baseroot;?>/jbpe_lib/jrstl.css" rel="stylesheet" type="text/css"></link>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/menu.js"></script>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbpe_lib/globaljava.js"></script>
<script type="text/javascript" src="<?php echo $baseroot?>/datetimepicker/datetimepicker_css.js"></script>

<script type="text/javascript">
/*function validate_required(field,alerttxt)
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
*/

function validate_form(thisform)
{
with (thisform)
  {
  //alert(testtype);
	  	if (validate_required(txt_dollar,"Plz Enter US Dollar Rate!")==false)
	  	{txt_dollar.focus();return false;}
		
		else if (validate_required(txt_euro,"Plz Enter Enter EURO Rate!")==false)
	  	{txt_euro.focus();return false;}

		else if (validate_required(txt_gbp,"Plz Enter Grate Britain Pound Rate!")==false)
	  	{txt_gbp.focus();return false;}
	
		else if (validate_required(txt_aud,"Plz Enter AUSTRALIAN Dollar Rate !")==false)
	  	{txt_aud.focus();return false;}
	
		else if (validate_required(txt_cad,"Plz Enter Canadian Dollar Rate!")==false)
	  	{txt_cad.focus();return false;}
	
		else if (validate_required(txt_singd,"Plz Enter Singapure Dollar Rate!")==false)
	  	{txt_singd.focus();return false;}
	
	    else if (validate_required(txt_myr,"Plz Enter MALAYSIAN RINGGIT Rate!")==false)
	  	{txt_myr.focus();return false;}

		else if (validate_required(txt_sar,"Plz Enter Saudi Riyal Rate!")==false)
	  	{txt_sar.focus();return false;}
	
		else if (validate_required(txt_jpy,"Plz Enter Jpanese YEN Rate!")==false)
	  	{txt_jpy.focus();return false;}
	
		else if (validate_required(txt_kwd,"Plz Enter Kwet DINNER Rate!")==false)
	  	{txt_kwd.focus();return false;}

		else if (validate_required(txt_aed,"Plz Enter U.A.E DIRHAM Rate!")==false)
	  	{txt_aed.focus();return false;}
  }	
}

</script>
</head>
<body class="bodybox" onLoad="Timestart(); month_load();;"> 
<center>
  <table width="100%"  border="0" class="indexbox">
     <tr>
       <td><?PHP echo $basicClass->topmenu;?></td>
     </tr>
     <tr>
       <td>	<div class="tbg" style="height:22px">
				<div class="tbg" align="center"><?php  echo $usermenu->menu; ?>
				</div>
			</div>
	   </td>
     </tr>
     <tr>
       <td>	<div align="center"><?php  //$usermenu->restricpage($loginuserid,$Loaduserlevel,$restrictlink,$systemstatus,$conn);?>
			</div>       
       </td>
     </tr>
     <tr>
       <td>
         <form action="" method="post" enctype="multipart/form-data" name="frmupload"  >  
            <table width="100%"  cellspacing="0" cellpadding="0" class="msgbox">
                <tr>
                  <td width="100%" colspan="2" class="tbg"><strong>Enter Daily FC Rates</strong>
				  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <table width="100%" border="1" align="center" cellpadding="10"  cellspacing="2" bordercolor="#CCCCCC">
                      <tr>
                        <td width="100%">
                         <table width="100%" border="1" align="center" cellpadding="10"  cellspacing="2" bordercolor="#CCCCCC">
							<tr>
								<td colspan="5" style= "color:red;font-size: 20px">
<?php
			//$tranType = 'I';
			//$createdBy = $_SESSION['loginID'];
			$createdBy = $_SESSION['userjbremtt'];
			$logedinUserName = (string)$_SESSION['userID'];
			$branchCode = (string)$_SESSION['userjblocat']; 
			$accRoutingCode = (string)$_SESSION['BrRouting'];
            //$bankOrgTxnCode = '';
			//$custFirstName=$custLastName=$dOB=$nIDNo=$custFatherName=$custMotherName=$accNo=$accName=$mobNo=$prodTypeKey ='';
			$usDollar=$euro=$gbPound=$ausDollar=$canDollar=$singDollar=$malayDollar=$saudiRiyal=$jpnYen=$kwtDinner=$uaeDirham='';
		
			//print_r ($commandArray[0]);
	//------------------------------------------BLOCK----------------------------------------

if (isset($_POST["Submit"])) 
       {	
// Form validation check--start      		
			if (isset($_POST["txt_dollar"])) $usDollar=$_POST["txt_dollar"];
				$usDollar = $CISecurity->xss_clean($usDollar);
				$InsertClass->isEmpty($usDollar,"US DOLLAR Rate is Blank !!!");
				//$usDollar = floatval($usDollar);
			    
			if (isset($_POST["txt_euro"])) $euro=$_POST["txt_euro"];
				$euro = $CISecurity->xss_clean($euro);
				$InsertClass->isEmpty($euro,"EURO Rate is Blank !!!");
				//$euro = floatval($euro);

			if (isset($_POST["txt_gbp"])) $gbPound=$_POST["txt_gbp"];
				$gbPound = $CISecurity->xss_clean($gbPound);
				$InsertClass->isEmpty($gbPound, "Grate Britain Pound Rate is Blank!");
				//$gbPound = floatval($gbPound);
				
			if (isset($_POST["txt_aud"])) $ausDollar=$_POST["txt_aud"];
				$ausDollar = $CISecurity->xss_clean($ausDollar);
				$InsertClass->isEmpty($ausDollar, "AUSTRALIAN DOLLAR Rate is Blank!");
				//$ausDollar = floatval($ausDollar);

			if (isset($_POST["txt_cad"])) $canDollar=$_POST["txt_cad"];
				$canDollar = $CISecurity->xss_clean($canDollar);
				$InsertClass->isEmpty($canDollar,"Canadian DOLLAR RATE is Blank !!!");
				//$canDollar =floatval($canDollar);
			
			if (isset($_POST["txt_singd"])) $singDollar=$_POST["txt_singd"];
				$singDollar = $CISecurity->xss_clean($singDollar);
				$InsertClass->isEmpty($singDollar,"SINGAPORE Dollar Rate is Blank !!!");
				//$singDollar = floatval($singDollar);
			
			if (isset($_POST["txt_myr"])) $malayDollar=$_POST["txt_myr"];
				$malayDollar = $CISecurity->xss_clean($malayDollar);
				$InsertClass->isEmpty($malayDollar," Dollar Rate is Blank !!!");
				//$malayDollar = floatval($malayDollar);
	
			if (isset($_POST["txt_sar"])) $saudiRiyal=$_POST["txt_sar"];
				$saudiRiyal = $CISecurity->xss_clean($saudiRiyal);
				$InsertClass->isEmpty($saudiRiyal,'SAUDI Riyal Rate is Blank !!!');
				//$saudiRiyal = floatval($saudiRiyal);
			
			if (isset($_POST["txt_jpy"])) $jpnYen=$_POST["txt_jpy"];
				$jpnYen = $CISecurity->xss_clean($jpnYen);
				$InsertClass->isEmpty($jpnYen,'JAPANESE YEN Rate is Blank !!!');
				//$jpnYen = floatval($jpnYen);

			if (isset($_POST["txt_kwd"])) $kwtDinner=$_POST["txt_kwd"];
				$kwtDinner = $CISecurity->xss_clean($kwtDinner);
				$InsertClass->isEmpty($kwtDinner,"Kwit DINNER Rate is Blank !!!");
				//$kwtDinner = floatval($kwtDinner);
				
			if (isset($_POST["txt_aed"])) $uaeDirham=$_POST["txt_aed"];
				$uaeDirham = $CISecurity->xss_clean($uaeDirham);
				$InsertClass->isEmpty($uaeDirham,'U.A.E DIRHAM Rate is Blank !!!');
				//$uaeDirham = floatval($uaeDirham);
				
			
						$createdBy = $CISecurity->xss_clean($createdBy);
						$InsertClass->isEmpty($createdBy,"Logged In User Id Error");
						$createdBy = $CISecurity->xss_clean($createdBy);
						
						$branchCode = $CISecurity->xss_clean($branchCode);
						$InsertClass->isEmpty($branchCode,"Branch Code Error");
						$branchCode = $CISecurity->xss_clean($branchCode);
						

// Form Validation Ends
// Form data insert step start
		
 //----------------------------------FOR ISSUE----------------------------------------------------------------                   
		$funcname="spISSUE_UPDATE_FC_RATE";
		$values="?,?,?,?,?,?,?,?,?,?,?,?,?,?";
							 
		if (empty($commandArray[0]))
		{
		
			/* $arrays = array('I',$usDollar,$euro,$gbPound,$ausDollar,$canDollar,
							 $singDollar,$malayDollar,$saudiRiyal,$jpnYen,$kwtDinner,
							 $uaeDirham,$createdBy,'');//,$submissionStatus,$txnCode); */
			
			$arrays = array('I',$usDollar,$canDollar,$gbPound,$ausDollar,
							 $malayDollar,$singDollar,$saudiRiyal,$jpnYen,$euro,$kwtDinner,
							 $uaeDirham,$createdBy,'');//,$submissionStatus,$txnCode);
							 
						
			//print_r($arrays);	
		}
//--------------------------------------FOR UPDATE-------------------------------------------------------									} 
								
		else if (isset($commandArray[0])) 
		{   
	        
			//$bankOrgTxnCode = $CISecurity->xss_clean($commandArray[0]);
					
			$arrays = array('U',$usDollar,$canDollar,$gbPound,$ausDollar,
							 $malayDollar,$singDollar,$saudiRiyal,$jpnYen,$euro,$kwtDinner,
							 $uaeDirham,$createdBy,$commandArray[0]);//,$submissionStatus,$txnCode);
										
		//$arrays_data=array($ctrl_no,$subject,$party_name,$act_no,$sqlcourtsub_date,$branchcode,$areacode,$loginuserid,$sqlbranchrequ_date,'U',$tndr_notice_amount,$sqltndr_notice_as_on_date);
		}
        $InsertClass->proc_param_data($funcname,$values,$arrays,$conn);
		
        //echo $InsertClass->datasave;
		echo $InsertClass->querylog;
		$usDollar=$euro=$gbPound=$ausDollar=$canDollar=$singDollar=$malayDollar=$saudiRiyal=$jpnYen=$kwtDinner=$uaeDirham='';
		

// Data insert step end	
// Form field clear
    
		//$msgToClearVariable ='Successfully Saved...';
		//$usDollar=$euro=$gbPound=$ausDollar=$canDollar=$singDollar=$malayDollar=$saudiRiyal=$jpnYen=$kwtDinner=$uaeDirham='';
		//$msgToClearVariableUpdate ='Successfully Updated ...';
	
//---------------------------CLEAR FORM AFTER INSERSION-----------------------------------------------------------------------		
		//if (strcmp($msgToClearVariable,$InsertClass->querylog)==0){
			      // $usDollar=$euro=$gbPound=$ausDollar=$canDollar=$singDollar=$malayDollar=$saudiRiyal=$jpnYen=$kwtDinner=$uaeDirham='';
					/*$tranType=$custFirstName=$custLastName=$dOB=$nIDNo=$custFatherName='';
					$custMotherName=$accNo=$accName=$accRoutingCode=$prodTypeKey=$mobNo='';
					$branchCode=$logedinUserName=$createdBy='';

			if (isset($_POST["txt_dollar"],$_POST["txt_euro"],$_POST["txt_gbp"],$_POST["txt_aud"],
						$_POST["txt_cad"],$_POST["txt_singd"],$_POST["txt_myr"],$_POST["txt_sar"],
						$_POST["txt_jpy"],$_POST["txt_kwd"],$_POST["txt_aed"]))
						{
						unset($_POST["txt_dollar"],$_POST["txt_euro"],$_POST["txt_gbp"],$_POST["txt_aud"],
						$_POST["txt_cad"],$_POST["txt_singd"],$_POST["txt_myr"],$_POST["txt_sar"],
						$_POST["txt_jpy"],$_POST["txt_kwd"],$_POST["txt_aed"]);
					    } 

				echo "<script>if ( window.history.replaceState ) {
				window.history.replaceState( null, null, window.location.href );}
			</script>";
	
		}
//--------------------------CLEAR FORM AFTER UPDATE--------------------------------------------------------------------------	
	/*
		else If ( strcmp($msgToClearVariableUpdate,$InsertClass->querylog)==0){
			$tranType=$custFirstName=$custLastName=$dOB=$nIDNo=$custFatherName='';
					$custMotherName=$accNo=$accName=$accRoutingCode=$prodTypeKey=$mobNo='';
					$branchCode=$logedinUserName=$createdBy='';

					if (isset($_POST["txt_custFirstName"],$_POST["txt_custLastName"],$_POST["txt_dOB"],$_POST["txt_nIDNo"],
						$_POST["txt_custFatherName"],$_POST["txt_custMotherName"],$_POST["txt_accNo"],$_POST["txt_accName"],
						$_POST["txt_mobNo"],$_POST["txt_prodTypeKey"])){
						unset($_POST["txt_custFirstName"],$_POST["txt_custLastName"],$_POST["txt_dOB"],$_POST["txt_nIDNo"],
						$_POST["txt_custFatherName"],$_POST["txt_custMotherName"],$_POST["txt_accNo"],$_POST["txt_accName"],
						$_POST["txt_mobNo"],$_POST["txt_prodTypeKey"]);
					}

		echo '<script>if ( window.history.replaceState ) {
				window.history.replaceState( null, null,"'.$baseroot.'/jbnepsforms/neps_form/enroll.php");}
			</script>';
		
		} 
		else{
			$dOB = date('d-m-Y',strtotime($dOB));
			}*/
		}
else {
// Get Customer Information  		
		if(isset($commandArray[0]))  
			{ 			
		      
				//$bankOrgTxnCode = $CISecurity->xss_clean($commandArray[0]);
				  $fcRateID = $CISecurity->xss_clean($commandArray[0]);
				
				$sql="SELECT [USD]
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
				  FROM [dbjbPassportEndorse].[dbo].[ExchangeRate]
					 WHERE [FC_RATE_ID]='".$fcRateID."'";
					 
				$result_list = sqlsrv_query($conn,$sql);
				
				while($row_list = sqlsrv_fetch_array($result_list))
						{
							
							 $usDollar=$row_list['USD'];
							 $canDollar=$row_list['CAD']; 
							 $gbPound=$row_list['GBP'];
							 $ausDollar=$row_list['AUD']; 
							 $malayDollar=$row_list['MYR'];
							 $singDollar=$row_list['SGD'];
							 $saudiRiyal=$row_list['SAR'];
							 $jpnYen=$row_list['JPY']; 
							 $euro=$row_list['EUR']; 
							 $kwtDinner=$row_list['KWD'];
							 $uaeDirham=$row_list['AED'];
						
						}						
						//$isReadonly='readonly';		
						sqlsrv_free_stmt($result_list);
            }
} 	

?>
			</td>
  </tr>
						  <!-- <tr>
						    <td width="10%">SL.</td>
							<td width="10%" class="error" ><strong>CURRENCY NAME</strong></td>
							<td width="10%" class="error"><strong>CURRENCY RATE</strong></td>
						  </tr> -->
						  <tr>
						    <td width="10%">SL.</td>
							<td width="10%" class="error" ><strong>CURRENCY NAME</strong></td>
							<td width="10%" class="error"><strong>CURRENCY RATE</strong></td>
						  </tr>
						  
						  <tr>
							<td>1.</td>
							<td width="10%"><strong>US DOLLAR</strong></td>
							<td width="10%" colspan="4"><input name="txt_dollar" type="text" required pattern="[0-9]*[.]?[0-9]+"   id="txt_dollar"  value="<?PHP echo $usDollar;?>"  size="30" maxlength="7" autocomplete="off"  placeholder="US $ Rate?" />
						  </tr>

						  

						  <tr>
							<td>2.</td>
							<td width="10%"><strong>CANADIAN DOLLAR</strong></td>
							<td width="10%" colspan="4"><input name="txt_cad" type="text" required pattern="[0-9]*[.]?[0-9]+"  id="txt_cad"  value="<?PHP echo $canDollar;?>"  size="30" maxlength="7" autocomplete="off"  placeholder="CANADIAN $  Rate?" />
						  </tr>
						  <tr>
							<td>3.</td>
							<td width="10%"><strong>GRATE BRITAIN POUND</strong></td>
							<td width="10%" colspan="4"><input name="txt_gbp" type="text" required pattern="[0-9]*[.]?[0-9]+"   id="txt_gbp"  value="<?PHP echo $gbPound;?>"  size="30" maxlength="7" autocomplete="off"  placeholder="POUND £  Rate?" />
						  </tr>
						  <tr>
							<td>4.</td>
							<td width="10%"><strong>AUSTRALLIAN DOLLAR</strong></td>
							<td width="10%" colspan="4"><input name="txt_aud" type="text" required pattern="[0-9]*[.]?[0-9]+"   id="txt_aud"  value="<?PHP echo $ausDollar;?>"  size="30" maxlength="7" autocomplete="off"  placeholder="AUSTRALIAN $  Rate?" />
						  </tr>
						  <tr>
							<td>5.</td>
							<td width="10%"><strong>MALAYSIAN RINGGIT</strong></td>
							<td width="10%" colspan="4"><input name="txt_myr" type="text" required pattern="[0-9]*[.]?[0-9]+"   id="txt_myr"  value="<?PHP echo $malayDollar;?>"  size="30" maxlength="7" autocomplete="off"  placeholder="MALAYSIAN RINGIT Rate?" />
						  </tr>
						  <tr>
							<td>6.</td>
							<td width="10%"><strong>SINGAPORE DOLLAR</strong></td>
							<td width="10%" colspan="4"><input name="txt_singd" type="text" required pattern="[0-9]*[.]?[0-9]+"   id="txt_singd"  value="<?PHP echo $singDollar;?>"  size="30" maxlength="7" autocomplete="off"  placeholder="SINGAPORE $  Rate?" />
						  </tr>
						  <tr>
							<td>7.</td>
							<td width="10%"><strong>SAUDI ARABIAN RIYAL</strong></td>
							<td width="10%" colspan="4"><input name="txt_sar" type="text" required pattern="[0-9]*[.]?[0-9]+"   id="txt_sar"  value="<?PHP echo $saudiRiyal;?>"  size="30" maxlength="7" autocomplete="off"  placeholder="SAUDI RIYAL Rate?" />
						  </tr>
						   <tr>
							<td>8.</td>
							<td width="10%"><strong>JAPANESE YEN</strong></td>
							<td width="10%" colspan="4"><input name="txt_jpy" type="text" required pattern="[0-9]*[.]?[0-9]+"   id="txt_jpy"  value="<?PHP echo $jpnYen;?>"  size="30" maxlength="7" autocomplete="off"  placeholder="JAPANESE YEN Rate?" />
						  </tr>
						  <tr>
							<td>9.</td>
							<td width="10%"><strong>EURO</strong></td>
							<td width="10%" colspan="4"><input name="txt_euro" type="text" required pattern="[0-9]*[.]?[0-9]+"   id="txt_euro"  value="<?PHP echo $euro;?>"  size="30" maxlength="7" autocomplete="off"  placeholder="EURO €  Rate?" />
						  </tr>
						  <tr>
							<td>10.</td>
							<td width="10%"><strong>KUWAITI DINNER</strong></td>
							<td width="10%" colspan="4"><input name="txt_kwd" type="text" required pattern="[0-9]*[.]?[0-9]+"   id="txt_kwd"  value="<?PHP echo $kwtDinner;?>"  size="30" maxlength="7" autocomplete="off"  placeholder="KUWAITI DINNER Rate?" />
						  </tr>

						  <tr>
							<td>11.</td>
							<td width="10%"><strong>U.A.E DERHAM</strong></td>
							<td width="10%" colspan="4"><input name="txt_aed" type="text" required pattern="[0-9]*[.]?[0-9]+"   id="txt_aed"  value="<?PHP echo $uaeDirham;?>"  size="30" maxlength="7" autocomplete="off"  placeholder="U.A.E DERHAM Rate?" />
						  </tr>
								  
						  
                            <tr>
                                <td colspan="5"><input name="Submit" type="submit" id="Submit" value="SAVE FC RATE" onclick="return validate_form(frmupload);" />
								</td>  
                               
                            </tr>    
                               
                        </table> 
                        </td>
                     
                      </tr>				  
                      
                    </table>
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