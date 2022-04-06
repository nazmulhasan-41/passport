<?php
define('BASEPATH','jbremittancehome');
session_start();
require_once('../../jbneps_settings/domainsettings.php');
require_once('../../jbneps_dbconn/dbmycon.php');
//$conn = sqlsrv_connect($database_hostname,$connectioninfo);

require_once('../../jbneps_classes/class_call.php');

require_once('../../loginfail.php');
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
<link href="<?PHP echo $baseroot;?>/jbneps_lib/jrstl.css" rel="stylesheet" type="text/css"></link>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbneps_lib/menu.js"></script>
<script type="text/javascript" src="<?PHP echo $baseroot;?>/jbneps_lib/globaljava.js"></script>
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
	  	if (validate_required(txt_custFirstName,"Enter Customer's First Name!")==false)
	  	{txt_custFirstName.focus();return false;}
		
		else if (validate_required(txt_custLastName,"Enter Customer's Last Name!")==false)
	  	{txt_custLastName.focus();return false;}

		else if (validate_required(txt_dOB,"Enter Customer's Birth Date!")==false)
	  	{txt_dOB.focus();return false;}
	
		else if (validate_required(txt_nIDNo,"Enter Customer's NID NUMBER !")==false)
	  	{txt_nIDNo.focus();return false;}
	
		else if (validate_required(txt_custFatherName,"Enter Customer's Father's Name!")==false)
	  	{txt_custFatherName.focus();return false;}
	
		else if (validate_required(txt_custMotherName,"Enter Customer's Mother's Name!")==false)
	  	{txt_custMotherName.focus();return false;}

		else if (validate_required(txt_accNo,"Enter Customer's Account Number!")==false)
	  	{txt_accNo.focus();return false;}
	
		else if (validate_required(txt_accName,"Enter Customer's Account Name!")==false)
	  	{txt_accName.focus();return false;}
	
		else if (validate_required(txt_mobNo,"Enter Customer's Mobile Number!")==false)
	  	{txt_mobNo.focus();return false;}

		else if (validate_required(txt_prodTypeKey,"Please Select Bhata Type!")==false)
	  	{txt_prodTypeKey.focus();return false;}
  }	
}

</script>
</head>
<body class="bodybox" onLoad="Timestart();//month_load();;"> 
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
                  <td width="100%" colspan="2" class="tbg"><strong>Enroll Customer </strong>
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
			$createdBy = (string)$_SESSION['loginID'];
			$logedinUserName = (string)$_SESSION['userID'];
			$branchCode = (string)$_SESSION['userjblocat']; 
			$accRoutingCode = (string)$_SESSION['BrRouting'];
            //$bankOrgTxnCode = '';
			$custFirstName=$custLastName=$dOB=$nIDNo=$custFatherName=$custMotherName=$accNo=$accName=$mobNo=$prodTypeKey ='';
		
			
	//------------------------------------------BLOCK----------------------------------------

if (isset($_POST["Submit"])) 
       {	
// Form validation check--start      		
			if (isset($_POST["txt_custFirstName"])) $custFirstName=(string)$_POST["txt_custFirstName"];
				$custFirstName = $CISecurity->xss_clean($custFirstName);
				$InsertClass->isEmpty($custFirstName,"Customer's First Name is Blank !!!");
				$custFirstName = $CISecurity->xss_clean($custFirstName);
			
			if (isset($_POST["txt_custLastName"])) $custLastName=(string)$_POST["txt_custLastName"];
				$custLastName = $CISecurity->xss_clean($custLastName);
				$InsertClass->isEmpty($custLastName,"Customer's Last Name is Blank !!!");
				$custLastName = $CISecurity->xss_clean($custLastName);
				
			if (isset($_POST["txt_dOB"])) 
				$dOB=$_POST["txt_dOB"];
				$dOB = $CISecurity->xss_clean($dOB);
				$InsertClass->isEmpty($dOB, "Please Select Birth Date!");
				$dOB = date('Y-m-d',strtotime($dOB));	

			if (isset($_POST["txt_nIDNo"])) 
				$nIDNo= $_POST["txt_nIDNo"];
				$nIDNo = $CISecurity->xss_clean($nIDNo);
				$InsertClass->isEmpty($nIDNo, "Please Enter NID Number!");
				

			if (isset($_POST["txt_custFatherName"])) $custFatherName=(string)$_POST["txt_custFatherName"];
				$custFatherName = $CISecurity->xss_clean($custFatherName);
				$InsertClass->isEmpty($custFatherName,"Customer's Father's Name is Blank !!!");
				$custFatherName = $CISecurity->xss_clean($custFatherName);
			
			if (isset($_POST["txt_custMotherName"])) $custMotherName=(string)$_POST["txt_custMotherName"];
				$custMotherName = $CISecurity->xss_clean($custMotherName);
				$InsertClass->isEmpty($custMotherName,"Customer's Mother's Name is Blank !!!");
				$custMotherName = $CISecurity->xss_clean($custMotherName);
			
			if (isset($_POST["txt_accNo"])) $accNo=(string)$_POST["txt_accNo"];
				$accNo = $CISecurity->xss_clean($accNo);
				$InsertClass->isEmpty($accNo,'Account Number is Blank !!!');
				$accNo = $CISecurity->xss_clean($accNo);
			
			if (isset($_POST["txt_accName"])) $accName=(string)$_POST["txt_accName"];
				$accName = $CISecurity->xss_clean($accName);
				$InsertClass->isEmpty($accName,'Customers First Name is Blank !!!');
				$accName = $CISecurity->xss_clean($accName);

			if (isset($_POST["txt_mobNo"])) $mobNo=(string)$_POST["txt_mobNo"];
				$mobNo = $CISecurity->xss_clean($mobNo);
				$InsertClass->isEmpty($mobNo,"Customer's Mobile Number is Blank !!!");
				$mobNo = $CISecurity->xss_clean($mobNo);
				
			if (isset($_POST["txt_prodTypeKey"])) $prodTypeKey=(int)$_POST["txt_prodTypeKey"];
				$prodTypeKey = $CISecurity->xss_clean($prodTypeKey);
				$InsertClass->isEmpty($prodTypeKey,'Please Select Bhata Type !!!');
				$prodTypeKey = $CISecurity->xss_clean($prodTypeKey);

// Form Validation Ends
// Form data insert step start
			
        $funcname="spEnroll_Update_Customer";
                    //$values="?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?";
		$values="@tranType=?,@custFirstName=?,@custLastName=?,@dOB=?,@nIDNo=?,@custFatherName=?,
				@custMotherName=?,@accNo=?,@accName=?,@accRoutingCode=?,@prodTypeKey=?,@mobNo=?,
				@branchCode=?,@logedinUserName=?,@createdBy=?,@bankOrgTxnCode=?";//,@submissionStatus,@txnCode";
							 
		if (empty($commandArray[0])){
		//$arrays_data=array($ctrl_no,$subject,$party_name,$act_no,$sqlcourtsub_date,$branchcode,$areacode,$loginuserid,$sqlbranchrequ_date,'I',$tndr_notice_amount,$sqltndr_notice_as_on_date);
			$arrays = array('I',$custFirstName,$custLastName,$dOB,$nIDNo,$custFatherName,
							 $custMotherName,$accNo,$accName,$accRoutingCode,$prodTypeKey,$mobNo,
							 $branchCode,$logedinUserName,$createdBy,NULL);//,$submissionStatus,$txnCode);
									} 
		else if (isset($commandArray[0])) {
			$bankOrgTxnCode = $CISecurity->xss_clean($commandArray[0]);
					//$arrays_data=array($ctrl_no,$subject,$party_name,$act_no,$sqlcourtsub_date,$branchcode,$areacode,$loginuserid,$sqlbranchrequ_date,'U',$tndr_notice_amount,$sqltndr_notice_as_on_date);
			$arrays = array('U',$custFirstName,$custLastName,$dOB,$nIDNo,$custFatherName,
							 $custMotherName,$accNo,$accName,$accRoutingCode,$prodTypeKey,$mobNo,
							 $branchCode,$logedinUserName,$createdBy,$bankOrgTxnCode);//,$submissionStatus,$txnCode);
										}

        $InsertClass->proc_param_data($funcname,$values,$arrays,$conn);
        //echo $InsertClass->datasave;
		//echo $InsertClass->querylog;

// Data insert step end	
// Form field clear
		$msgToClearVariable ='Successfully Saved...';
		$msgToClearVariableUpdate ='Successfully Updated ...';
		if (strcmp($msgToClearVariable,$InsertClass->querylog)==0){
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

				echo "<script>if ( window.history.replaceState ) {
				window.history.replaceState( null, null, window.location.href );}
			</script>";
	
		}
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
			}
		}
else {
// Get Customer Information  		
		if(isset($commandArray[0]))  
			{ 			
				$bankOrgTxnCode = $CISecurity->xss_clean($commandArray[0]);	
				$sql="SELECT [custFirstName]
						,[custLasttName]
						,convert(varchar, [dOB], 110) dOB
						,[nIDNo]
						,[custFatherName]
						,[custMotherName]
						,[accNo]
						,[accName]
						,[prodTypeKey]
						,[mobNo]
					 FROM	[dbjbneps].[dbo].[nepsCustEnroll] 
					 WHERE [bankOrgTxnCode]='".$bankOrgTxnCode."'";
				$result_list = sqlsrv_query($conn,$sql);
				
				while($row_list = sqlsrv_fetch_array($result_list))
						{
							
							 $custFirstName=$row_list['custFirstName'];
							 $custLastName=$row_list['custLasttName']; 
							 $dOB=$row_list['dOB'];
							 $nIDNo=$row_list['nIDNo']; 
							 $custFatherName=$row_list['custFatherName'];
							 $custMotherName=$row_list['custMotherName'];
							 $accNo=$row_list['accNo'];
							 $accName=$row_list['accName']; 
							 $prodTypeKey=$row_list['prodTypeKey']; 
							 $mobNo=$row_list['mobNo'];
							 
						
						}						
						//$isReadonly='readonly';		
						sqlsrv_free_stmt($result_list);
            }
} 	

?>
			</td>
  </tr>
						  <tr>
							<td width="10%"><strong>Customer First Name:</strong>
							</td>
							<td width="90%" colspan="4"><input name="txt_custFirstName" type="text" id="txt_custFirstName"  value="<?PHP echo $custFirstName;?>" size="50" autocomplete="off"  placeholder="Customer First Name?"/>
							  <span class="error">*</span>
							</td>
						  </tr>
                          <tr>
							<td width="10%"><strong>Customer Last Name:</strong></td>
							<td width="10%" colspan="4"><input name="txt_custLastName" type="text" id="txt_custLastName"  value="<?PHP echo $custLastName;?>" size="50" autocomplete="off"  placeholder="Customer Last Name?"/>
							  <span class="error">*</span></td>
						  </tr>
						  <tr>
							<td width="10%"><strong>Date of Birth: </strong></td>
							<td width="10%" colspan="4"><span class="inputcaption">
								<input  type="text" id="txt_dOB" required pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}" title="format DD-MM-YYYY" value="<?php  echo $dOB; ?>" maxlength="10" size="50" name="txt_dOB"  placeholder="DD-MM-YYYY?"/>
									<a href="javascript: NewCssCal('txt_dOB','ddmmyyyy','arrow','<?PHP echo $baseroot;?>')"><img src="<?PHP echo $baseroot;?>/images/cal.gif" width="16" height="16" alt="Pick a date" />
									</a></span><span class="error">*  **DD-MM-YYYY**</span>
									<!-- 
									<input  type="text" id="txt_dOB" required pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}" title="format DD-MM-YYYY" value="<?php  echo $dOB; ?>" maxlength="10" size="50" name="txt_dOB"  placeholder="DD-MM-YYYY?"/>
									<a href="javascript: NewCssCal('txt_dOB','ddmmyyyy','arrow','<?PHP echo $baseroot;?>')"><img src="<?PHP echo $baseroot;?>/images/cal.gif" width="16" height="16" alt="Pick a date" />
									</a></span><span class="error">*  **DD-MM-YYYY**</span>
									-->
							</td>
						  
						  </tr>
						  <tr>
						     <td width="10%"><strong>NID Number: </strong></td>
						     <td width="10%" colspan="4"><input name="txt_nIDNo" type="text" id="txt_nIDNo" onkeyup="IsNumericInt(this);" value="<?PHP echo $nIDNo;?>"  size="50" autocomplete="off"  placeholder="NID Number?" min="10" maxlength="17"/>
							 <span class="error">* 10-17 Digit</span>
							 </td>
							 
                          </tr>
						  <tr>
							<td width="10%"><strong>Cust. Father's Name:</strong></td>
							<td width="10%" colspan="4"><input name="txt_custFatherName" type="text" id="txt_custFatherName"  value="<?PHP echo $custFatherName;?>" size="50" autocomplete="off"  placeholder="Customer Father's Name?"/>
							  <span class="error">*</span></td>
						  </tr>
                          <tr>
							<td width="10%"><strong>Cust. Mother's Name:</strong></td>
							<td width="10%" colspan="4"><input name="txt_custMotherName" type="text" id="txt_custMotherName"  value="<?PHP echo $custMotherName;?>" size="50" autocomplete="off"  placeholder="Customer Mother's Name?"/>
							  <span class="error">*</span></td>
						  </tr>
						  <tr>
						     <td width="10%"><strong>Account Number: </strong></td>
						     <td width="10%" colspan="4"><input name="txt_accNo" type="text" id="txt_accNo" onkeyup="IsNumericInt(this);" value="<?PHP echo $accNo;?>"  size="50" autocomplete="off"  placeholder="Account Number?" maxlength="13"/>
							<span class="error">* T24 Account Number Only</span></td>
						  </tr>
						  <tr>
							<td width="10%"><strong>Account Title:</strong></td>
							<td width="90%" colspan="4"><input name="txt_accName" type="text" id="txt_accName"  value="<?PHP echo $accName;?>" size="50" autocomplete="off"  placeholder="Account Name?"/>
							  <span class="error">*</span></td>
						  </tr>
						  <tr>
						     <td width="10%"><strong>Bhata Type: </strong></td>
						     <td width="10%" colspan="4">
							   <label>
							   <input type="radio" name="txt_prodTypeKey" id="txt_prodTypeKey" value="1" <?PHP if ($prodTypeKey==1) {echo 'checked="checked"';}?> />
							   Boyosko Bhata
							   </label>
							   
							   <label>
							   <input type="radio" name="txt_prodTypeKey" id="txt_prodTypeKey" value="2" <?PHP if ($prodTypeKey==2) {echo 'checked="checked"';}?> />
							   Bidhoba Bhata
							   </label>
							   
							   <label>
							   <input type="radio" name="txt_prodTypeKey" id="txt_prodTypeKey" value="3" <?PHP if ($prodTypeKey==3) {echo 'checked="checked"';}?> />
							   Protibondhi Bhata
							   </label>
								<span class="error">*</span>
							</td>
                          </tr>
						  <tr>
						     <td width="10%"><strong>Mobile Number: </strong></td>
						     <td width="10%" colspan="4"><input name="txt_mobNo" type="text" id="txt_mobNo" onkeyup="IsNumericInt(this);" value="<?PHP echo $mobNo;?>"  size="50" autocomplete="off"  placeholder="Mobile Number?" min="11" maxlength="11"/>
							 <span class="error">*</span>
							 </td>
                            
						  </tr>
						  
                            <tr>
                                <td colspan="5"><input name="Submit" type="submit" id="Submit" value="Enroll Customer" onclick="return validate_form(frmupload);" />
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