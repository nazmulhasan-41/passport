<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Dhaka");

class DataView {
	var $Listdesig,$Listlocation,$Listuserlevel,$Firstuserlevel,$DataList,$Listtype,$Listlevel,$Listdepmethod,$Listreceiver; 

	function branchselect($ctlname,$sbranch,$suserlevel,$baseroot,$conn){
            $this->branchselect='';
	if (($suserlevel=='SA') || ($suserlevel=='SU') || ($suserlevel=='MR') || ($suserlevel=='UR')) {
	$query_branch = "select BranchCode,BranchName,DistCode from Branch order by BranchName";
    } else {
	$query_branch = "select BranchCode,BranchName,DistCode from Branch where BranchCode=$sbranch order by BranchName";
    }
	
	$result_branch = sqlsrv_query($conn,$query_branch);
	$this->branchselect.="<select name=\"cmbbranch\" id=\"cmbbranch\" onChange=\"showdept('$ctlname',this.value,'$suserlevel','$baseroot')\">";
    while($row_branch = sqlsrv_fetch_array($result_branch)){
	if ($sbranch==$row_branch['BranchCode']) {
	$this->branchselect.=" <option value=\"".$row_branch['BranchCode']."\" selected>".$row_branch['BranchName'].",".$row_branch['DistCode']."[".$row_branch['BranchCode']."]</option>";
	} else {
	$this->branchselect.=" <option value=\"".$row_branch['BranchCode']."\">".$row_branch['BranchName'].",".$row_branch['DistCode']."[".$row_branch['BranchCode']."]</option>";	
	}
	}
    $this->branchselect.="</select>";
	sqlsrv_free_stmt( $result_branch);			
	}


	function branchselect2($sbranch,$suserlevel,$conn){
    $this->branchselect='';
	if ($suserlevel=='SA') {
	$query_branch = "select BranchCode,BranchName,DistCode from Branch order by BranchName";
    } else {
	$query_branch = "select BranchCode,BranchName,DistCode from Branch where BranchCode=$sbranch order by BranchName";
    }
	
	$result_branch = sqlsrv_query($conn,$query_branch);
	$this->branchselect.="<select name=\"cmbbranch\" id=\"cmbbranch\">";
    while($row_branch = sqlsrv_fetch_array($result_branch)){
	if ($sbranch==$row_branch['BranchCode']) {
	$this->branchselect.=" <option value=\"".$row_branch['BranchCode']."\" selected>".$row_branch['BranchName'].",".$row_branch['DistCode']."[".$row_branch['BranchCode']."]</option>";
	} else {
	$this->branchselect.=" <option value=\"".$row_branch['BranchCode']."\">".$row_branch['BranchName'].",".$row_branch['DistCode']."[".$row_branch['BranchCode']."]</option>";	
	}
	}
    $this->branchselect.="</select>";
	sqlsrv_free_stmt( $result_branch);				
	}

/* function BranchSettings($branchcode,$dist,$currsoftdate,$baseroot,$conn) {
    $this->BranchSettings='';
	$sql_branch = "select gas_bill_type,gas_bill_api,tel_bill_type,tel_bill_api,elect_bill_type,elect_bill_api,scroll_type from tbl_branch_settings where branch_code='$branchcode'";	
	//echo $sql_branch;
	$result_branch = sqlsrv_query($conn,$sql_branch);
	$row_branch = sqlsrv_fetch_array($result_branch);
	
	$this->BranchSettings.='<table width="100%" border="1" align="center" cellpadding="3"  cellspacing="2" bordercolor="#CCCCCC">';

	$gas_manual_checked='';
	$gas_api_checked='';
	if ($row_branch['gas_bill_type']=='M') {
	$gas_manual_checked = 'checked="checked"';
	} else if ($row_branch['gas_bill_type']=='A') {
	$gas_api_checked = 'checked="checked"';
	}
	$gas_manual_checked = 'checked="checked"';
        $this->BranchSettings.='<tr>
          <td width="22%" class="input_level">GAS Bill Type</td>
          <td width="78%"><label>
                     <input type="radio" name="optgasbilltype" id="optgasbilltype" value="M" '.$gas_manual_checked.'/>
                     Manual</label>
                       <label>
                       <input type="radio" name="optgasbilltype" id="optgasbilltype" value="A" '.$gas_api_checked.'/>
                         API Based</label><br>
						 </td>
        </tr>';
		$this->api_select('G','',$conn);
        $this->BranchSettings.='<tr>
          <td width="22%" class="input_level">GAS API</td>
          <td width="78%" class="input_level">'.$this->api_select.'</td>
        </tr>';
//Telephone
	$tel_manual_checked='';
	$tel_api_checked='';
	if ($row_branch['tel_bill_type']=='M') {
	$tel_manual_checked = 'checked="checked"';
	} else if ($row_branch['tel_bill_type']=='A') {
	$tel_api_checked = 'checked="checked"';
	}
	$tel_manual_checked = 'checked="checked"';
        $this->BranchSettings.='<tr>
          <td width="22%" class="input_level">Telephone Bill Type</td>
          <td width="78%"><label>
                     <input type="radio" name="opttelbilltype" id="opttelbilltype" value="M" '.$tel_manual_checked.'/>
                     Manual</label>
                       <label>
                       <input type="radio" name="opttelbilltype" id="opttelbilltype" value="A" '.$tel_api_checked.'/>
                         API Based</label><br>
						 </td>
        </tr>';
		$this->api_select('T','',$conn);
        $this->BranchSettings.='<tr>
          <td width="22%" class="input_level">Telephone API</td>
          <td width="78%" class="input_level">'.$this->api_select.'</td>
        </tr>';

//Electric
	$elect_manual_checked='';
	$elect_api_checked='';
	if ($row_branch['elect_bill_type']=='M') {
	$elect_manual_checked = 'checked="checked"';
	} else if ($row_branch['elect_bill_type']=='A') {
	$elect_api_checked = 'checked="checked"';
	}
	$elect_manual_checked = 'checked="checked"';
        $this->BranchSettings.='<tr>
          <td width="22%" class="input_level">Electric Bill Type</td>
          <td width="78%"><label>
                     <input type="radio" name="optelectbilltype" id="optelectbilltype" value="M" '.$elect_manual_checked.'/>
                     Manual</label>
                       <label>
                       <input type="radio" name="optelectbilltype" id="optelectbilltype" value="A" '.$elect_api_checked.'/>
                         API Based</label><br>
						 </td>
        </tr>';
		$this->api_select('E','',$conn);
        $this->BranchSettings.='<tr>
          <td width="22%" class="input_level">Electric API</td>
          <td width="78%" class="input_level">'.$this->api_select.'</td>
        </tr>';

		$this->scroll_select('',$conn);
        $this->BranchSettings.='<tr>
          <td width="22%" class="input_level">Scroll Type</td>
          <td width="78%" class="input_level">'.$this->scroll_select.'</td>
        </tr>';


//Data Structure
        $this->BranchSettings.='<tr>
          <td width="22%" class="input_level">&nbsp;</td>
          <td width="78%"><input type="submit" name="Submit" value="Submit" /></td>
        </tr>';
    $this->BranchSettings.='</table>'; 
sqlsrv_free_stmt( $result_branch);			
}

//Service Provider Details
function service_provider_details($sprovider,$baseroot,$conn) {
    $this->service_provider_details='';
	$sql_provider = "select * from tbl_service_provider where sp_code='$sprovider'";	
	//echo $sql_branch;
	$result_provider = sqlsrv_query($conn,$sql_provider);
	$row_provider = sqlsrv_fetch_array($result_provider);
	$this->service_provider_details.='<table width="100%" border="1" align="center" cellpadding="3"  cellspacing="2" bordercolor="#CCCCCC">';


        $this->service_provider_details.='<tr>
          <td width="22%" class="input_level">Revenue Stamp (Min)</td>
          <td width="78%">
                     <input type="text" name="txtrevenuestamp" id="txtrevenuestamp" value="'.$row_provider['rev_stamp_min'].'"/>
           </td>
        </tr>';

        $this->service_provider_details.='<tr>
          <td width="22%" class="input_level">Revenue Stamp Charge</td>
          <td width="78%">
                     <input type="text" name="txtstamprate" id="txtstamprate" value="'.$row_provider['rev_stamprate'].'"/>
            </td>
        </tr>';

        $this->service_provider_details.='<tr>
          <td width="22%" class="input_level">VAT Rate</td>
          <td width="78%">
                     <input type="text" name="txtvatrate" id="txtvatrate" value="'.$row_provider['vat_rate'].'"/>
            </td>
        </tr>';
        
        $this->service_provider_details.='<tr>
          <td width="22%" class="input_level">Bill Description</td>
          <td width="78%">
                     <input type="text" name="txtbilldesc" id="txtbilldesc" size="40" value="'.$row_provider['bill_desc'].'"/>
            </td>
        </tr>';
        
        $this->service_provider_details.='<tr>
          <td width="22%" class="input_level">Vat Description</td>
          <td width="78%">
                     <input type="text" name="txtvatdesc" id="txtvatdesc" size="40" value="'.$row_provider['vat_desc'].'"/>
            </td>
        </tr>';
        
        $manual_checked = '';
        $api_checked = '';$both_checked = '';
        $diplay_apilink='';
        if ($row_provider['Collection_type']=='M') {
	$manual_checked = 'checked="checked"';$diplay_apilink='style="display: none"';
	} else if ($row_provider['Collection_type']=='A') {
	$api_checked = 'checked="checked"';
	}
        else if ($row_provider['Collection_type']=='B') {
	$both_checked = 'checked="checked"';
	}
        
        $this->service_provider_details.='<tr>
          <td width="22%" class="input_level">Collection Type</td>
          <td width="78%"><label>
                     <input type="radio" name="optcollectiontype" id="optcollectiontype" value="M" '.$manual_checked.' onchange="showapi(this.value);"/>
                     JB Server Based</label>
                       <label>
                       <input type="radio" name="optcollectiontype" id="optcollectiontype" value="A" '.$api_checked.' onchange="showapi(this.value);"/>
                         API Based</label>
                       <input type="radio" name="optcollectiontype" id="optcollectiontype" value="B" '.$both_checked.' onchange="showapi(this.value);"/>
                         Both</label><br>  
	  </td>
        </tr>';
        
        $this->service_provider_details.='<tr>
          <td width="22%" class="input_level">API Link</td>
          <td width="78%">
                     <input type="text" name="txtapilink" id="txtapilink" value="'.$row_provider['API_Procedure'].'" '.$diplay_apilink.' />
            </td>
        </tr>';



//Data Structure
        $this->service_provider_details.='<tr>
          <td width="22%" class="input_level">&nbsp;</td>
          <td width="78%"><input type="submit" name="Submit" value="Submit" /></td>
        </tr>';
    $this->service_provider_details.='</table>'; 
sqlsrv_free_stmt( $result_provider);			
}



function api_select($api_type,$sapi,$conn){
	$this->api_select='';
	$query_api = "select sl_api,sp_provider_name from tbl_sp_api where sp_type='".$api_type."' order by sp_type";
	//echo $query_api;
	$result_api = sqlsrv_query($conn,$query_api);
	$this->api_select.="<select name=\"cmbapi_".$sapi."\" id=\"cmbapi_".$sapi."\">";
	//$this->api_select.=" <option value=\"\">Select API</option>";	
    while($row_api = sqlsrv_fetch_array($result_api)){
	if ($sapi==$row_api['sl_api']) {
	$this->api_select.=" <option value=\"".$row_api['sl_api']."\" selected>".$row_api['sp_provider_name']."</option>";
	} else {
	$this->api_select.=" <option value=\"".$row_api['sl_api']."\">".$row_api['sp_provider_name']."</option>";	
	}
	}
    $this->api_select.="</select>";
sqlsrv_free_stmt( $result_api);			
	}

function scroll_select($sscroll,$conn){
	$this->scroll_select='';
	$query_scroll = "select scrln,scroll_type from tbl_scroll order by scrln";
	//echo $query_api;
	$result_scroll = sqlsrv_query($conn,$query_scroll);
	$this->scroll_select.="<select name=\"cmbscroll\" id=\"cmbscroll\">";
	//$this->api_select.=" <option value=\"\">Select API</option>";	
    while($row_scroll = sqlsrv_fetch_array($result_scroll)){
	if ($sscroll==$row_scroll['scrln']) {
	$this->scroll_select.=" <option value=\"".$row_scroll['scrln']."\" selected>".$row_scroll['scroll_type']."</option>";
	} else {
	$this->scroll_select.=" <option value=\"".$row_scroll['scrln']."\">".$row_scroll['scroll_type']."</option>";	
	}
	}
    $this->scroll_select.="</select>";
sqlsrv_free_stmt( $result_scroll);			
	} */
////////////////////////////////////////////////////////	
/////////////      JBPE STARTS HERE      //////////////	
//////////////////////////////////////////////////////
	
/////////////////////////////////////////
/*Form Data List For JBPE AUTHORIZE*////
///////////////////////////////////////
function form_fc_rate_auth($tblcaption,$colHeader,$sql,$editlink,$baseroot,$conn){
	//form_data_list_auth
			$deptname='';
			$authorizedBy =(string)$_SESSION['loginID'];
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			while($row_list = sqlsrv_fetch_array($result_list)){
				
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          	//$this->DataList.="<tr $rowbg id='ctl".$row_list[10]."'>";
				
				$this->DataList.="<tr $rowbg>";
				
			for($c=0; $c < $col; $c++) 
               { 

					 if ($c==12) {	
					$this->DataList.="<td ><span id='ctlno$r' class='error'><a href='javascript:void(0)' style=\"color:red;font-size: 12px\" onclick=\"fcRateReject('ctlno$r','".$row_list[12]."','".$authorizedBy."','$baseroot')\">Reject</a></span></td>"; 
					}
					
					else if ($c==13) {
					
					$this->DataList.="<td class=row_data><span id=\"authorize$r\" class='error'><a href='javascript:void(0)' style=\"color:green;font-size: 12px\" onclick=\"fcRateAuthorize('authorize".$r."','".$row_list[12]."','".$authorizedBy."','$baseroot')\">Authorize</a></span></td>"; 
					
					}
					
					else
					{
					$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
					}
               }
		 	$this->DataList.="</tr>";
			$r++;
			}
       $this->DataList.="</table>";
sqlsrv_free_stmt( $result_list);			
	}	

function form_fc_rate_auth_dollar($tblcaption,$colHeader,$sql,$editlink,$baseroot,$conn){
	//form_data_list_auth
			$deptname='';
			$authorizedBy =(string)$_SESSION['loginID'];
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			while($row_list = sqlsrv_fetch_array($result_list)){
				
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          	//$this->DataList.="<tr $rowbg id='ctl".$row_list[10]."'>";
				
				$this->DataList.="<tr $rowbg>";
			
			/*
			for($c=0; $c < $col; $c++) 
               { 

					 if ($c==12) {	
					$this->DataList.="<td ><span id='ctlno$r' class='error'><a href='javascript:void(0)' style=\"color:red;font-size: 12px\" onclick=\"fcRateReject('ctlno$r','".$row_list[12]."','".$authorizedBy."','$baseroot')\">Reject</a></span></td>"; 
					}
					
					else if ($c==13) {
					
					$this->DataList.="<td class=row_data><span id=\"authorize$r\" class='error'><a href='javascript:void(0)' style=\"color:green;font-size: 12px\" onclick=\"fcRateAuthorize('authorize".$r."','".$row_list[12]."','".$authorizedBy."','$baseroot')\">Authorize</a></span></td>"; 
					
					}
					
					else
					{
					$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
					}
               } */
			   
			   
			// FOR DOLLAR ONLY
			for($c=0; $c < $col; $c++) 
               { 

					 if ($c==2) {	
					$this->DataList.="<td ><span id='ctlno$r' class='error'><a href='javascript:void(0)' style=\"color:red;font-size: 12px\" onclick=\"fcRateReject('ctlno$r','".$row_list[2]."','".$authorizedBy."','$baseroot')\">Reject</a></span></td>"; 
					}
					
					else if ($c==3) {
					
					$this->DataList.="<td class=row_data><span id=\"authorize$r\" class='error'><a href='javascript:void(0)' style=\"color:green;font-size: 12px\" onclick=\"fcRateAuthorize('authorize".$r."','".$row_list[2]."','".$authorizedBy."','$baseroot')\">Authorize</a></span></td>"; 
					
					}
					
					else
					{
					$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
					}
               }
			   
		 	$this->DataList.="</tr>";
			$r++;
			}
       $this->DataList.="</table>";
sqlsrv_free_stmt( $result_list);			
	}

//////////////////////////////////////////	
/*Bulk Customer Data Direct API CALL*////
////////////////////////////////////////	
function form_data_list_bulk($tblcaption,$colHeader,$fromDate,$toDate){
			
			$fromDate=$fromDate." "."00:00:00";
			$toDate=$toDate." "."23:59:59";
			
			$fromDateObj = DateTime::createFromFormat('d-m-Y H:i:s', $fromDate);
			$fromDate = $fromDateObj->getTimestamp()*1000;
			
			$toDateObj = DateTime::createFromFormat('d-m-Y H:i:s', $toDate);
			$toDate = $toDateObj->getTimestamp()*1000;
			
			$deptname='';
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray); //10
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
// API CALL STARTS			
			$url = "http://123.49.47.64:8080/neps-api/oauth/token";

				$client_id = "JanataBank";
				$client_secret = "Test123Test";
				$authorization = base64_encode("$client_id:$client_secret");

				$postCredential = array(
										'grant_type'=>'password',
										'username'=>'JanataBank',
										'password'=>'Test123Test'
										);

				$header = "Authorization: Basic {$authorization}\r\n".
						  "Content-type: application/x-www-form-urlencoded\r\n";
				$context_options=array(
								'http'=>array(  'method'=>'POST'
												,'header'=>$header
												,'content'=>http_build_query($postCredential)
											  )
										);

				$context = stream_context_create($context_options);
				$responseAssocArray=json_decode(file_get_contents($url,false,$context),true);


				$url = "http://123.49.47.64:8080/neps-api/secured/fetchDataCustomerData";
				//$postData = '{"bankOrgKey":14}';
				$postData = '{"bankOrgKey":'.'14'.','.'"accEnrollDateTimeFrom":'.$fromDate.','.'"accEnrollDateTimeTo":'.$toDate.'}';

				$authorization = $responseAssocArray["access_token"];

				$header = "Authorization: Bearer {$authorization}\r\n".
						  "Content-type: application/json;charset=UTF-8\r\n";
				$context_options=array(
								'http'=>array(  'method'=>'POST'
												,'header'=>$header
												,'content'=>$postData
											  )
										);

				$context = stream_context_create($context_options);
				$responseAssocArray=json_decode(file_get_contents($url,false,$context),true,512, JSON_BIGINT_AS_STRING);


				$keys = array_keys($responseAssocArray);

				for($i = 0; $i < count($responseAssocArray); $i++) {
					
					//$txnCode= $responseAssocArray[$i]['txnCode'];
					
			
			if ($i%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          	//$this->DataList.="<tr $rowbg id='ctl".$row_list[10]."'>";
				
				$this->DataList.="<tr $rowbg>";
				$slno = $i+1;
			//$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";
					$bhataType ="";
					switch ($responseAssocArray[$i]['prodTypeKey']) 
					{		case '1':
							$bhataType='Boyosko';
							break;
							case '2':
							$bhataType= 'Bidhoba';
							break;
							case '3':
							$bhataType= 'Protibondhi';
							break;
							default:
							echo 'Not Found';
					}
					$dOB= date('d/m/Y', (int)(($responseAssocArray[$i]['dOB'])/1000));
					//$enrollDateTime= date('d/m/Y H:i:s', (int)(($responseAssocArray[$i]['accEnrollDateTime'])/1000));
					$enrollDateTime= date('d/m/Y', (int)(($responseAssocArray[$i]['accEnrollDateTime'])/1000));
					
					$this->DataList.="<td class=row_data>".$slno."</td>";
					$this->DataList.="<td class=row_data>".$responseAssocArray[$i]['txnCode']."</td>";
					$this->DataList.="<td class=row_data>".$dOB."</td>";
					$this->DataList.="<td class=row_data>".$responseAssocArray[$i]['nIDNo']."</td>";
					$this->DataList.="<td class=row_data>".$enrollDateTime."</td>";
					$this->DataList.="<td class=row_data>".$responseAssocArray[$i]['custStatus']."</td>";
					$this->DataList.="<td class=row_data>".$responseAssocArray[$i]['accNo']."</td>";
					$this->DataList.="<td class=row_data>".$responseAssocArray[$i]['accName']."</td>";
					$this->DataList.="<td class=row_data>".$bhataType."</td>";
					$this->DataList.="<td class=row_data>".$responseAssocArray[$i]['accRoutingCode']."</td>";
					$this->DataList.="<td class=row_data>".$responseAssocArray[$i]['isActive']."</td>";
					$this->DataList.="<td class=row_data>".$responseAssocArray[$i]['mobNo']."</td>";
				
            
		 	$this->DataList.="</tr>";
		
			}
			
       $this->DataList.="</table>";
			
	}		
	
//////////////////////////////////////////	
/*NEPS Reconcile*////
////////////////////////////////////////	

function form_reconcile($tblcaption,$colHeader,$fromDate,$toDate,$branchCode,$conn){
			$branchCode=strtoupper("$branchCode");
			//$branchCode=null;
			$sql_from_date = date("Y-m-d",strtotime($fromDate));
			$sql_to_date = date("Y-m-d",strtotime($toDate));
			
			$fromDate=$fromDate." "."00:00:00";
			$toDate=$toDate." "."23:59:59";
			
			$fromDateObj = DateTime::createFromFormat('d-m-Y H:i:s', $fromDate);
			$fromDateTimestamp = $fromDateObj->getTimestamp()*1000;
			
			$toDateObj = DateTime::createFromFormat('d-m-Y H:i:s', $toDate);
			$toDateTimestamp = $toDateObj->getTimestamp()*1000;
			
			$deptname='';
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray); //10
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
// API CALL STARTS			
			$url = "http://123.49.47.64:8080/neps-api/oauth/token";

				$client_id = "JanataBank";
				$client_secret = "Test123Test";
				$authorization = base64_encode("$client_id:$client_secret");

				$postCredential = array(
										'grant_type'=>'password',
										'username'=>'JanataBank',
										'password'=>'Test123Test'
										);

				$header = "Authorization: Basic {$authorization}\r\n".
						  "Content-type: application/x-www-form-urlencoded\r\n";
				$context_options=array(
								'http'=>array(  'method'=>'POST'
												,'header'=>$header
												,'content'=>http_build_query($postCredential)
											  )
										);

				$context = stream_context_create($context_options);
				$responseAssocArray=json_decode(file_get_contents($url,false,$context),true);
				$totalEntry =0;
				

				$url = "http://123.49.47.64:8080/neps-api/secured/fetchDataCustomerData";
				//$postData = '{"bankOrgKey":14}';
				$postData = '{"bankOrgKey":'.'14'.','.'"accEnrollDateTimeFrom":'.$fromDateTimestamp.','.'"accEnrollDateTimeTo":'.$toDateTimestamp.'}';

				$authorization = $responseAssocArray["access_token"];

				$header = "Authorization: Bearer {$authorization}\r\n".
						  "Content-type: application/json;charset=UTF-8\r\n";
				$context_options=array(
								'http'=>array(  'method'=>'POST'
												,'header'=>$header
												,'content'=>$postData
											  )
										);

				$context = stream_context_create($context_options);
				$responseAssocArray=json_decode(file_get_contents($url,false,$context),true,512, JSON_BIGINT_AS_STRING);
//API CALL ENDS AND API RESPONSE//
				$totalEntryNepsBankWise = sizeof($responseAssocArray);
				//$keys = array_keys($responseAssocArray);
//SELECT BRANCH
					IF ($branchCode =='ALL')
					{
					$sql_branch = "SELECT  dbjbwebremitt.dbo.Branch.BranchCode,dbjbwebremitt.dbo.Branch.BranchName, dbjbwebremitt.dbo.Branch.br_routing_number
								 FROM    dbjbwebremitt.dbo.Branch";
					}
					else
					{$sql_branch = "SELECT  dbjbwebremitt.dbo.Branch.BranchCode,dbjbwebremitt.dbo.Branch.BranchName, dbjbwebremitt.dbo.Branch.br_routing_number
								 FROM    dbjbwebremitt.dbo.Branch Where dbjbwebremitt.dbo.Branch.BranchCode='".$branchCode."'";
					}
					
					$result_branch_Name = sqlsrv_query($conn,$sql_branch);
		$i=0;
			/* $row_branch_name_test = sqlsrv_fetch_array($result_branch_Name);
			echo "<pre>";
			print_r($row_branch_name_test); */
		while ($row_branch_name= sqlsrv_fetch_array($result_branch_Name)) {
					  
				//for($i = 0; $i < count($responseAssocArray); $i++) {
					
					//$txnCode= $responseAssocArray[$i]['txnCode'];
					
			IF($row_branch_name['br_routing_number'] ==NULL OR $row_branch_name['br_routing_number']=="")
			{
				$totalEntryNepsBrWise = 0;
				/* $filter = "";


				$responseAssocArrayBrWise = array_filter($responseAssocArray, function($var) use ($filter){
										return ($var['accRoutingCode'] == $filter);
											});	
				$totalEntryNepsBrWise = sizeof($responseAssocArrayBrWise); */
			}
			Else
			{
				$filter = $row_branch_name['br_routing_number'];


				$responseAssocArrayBrWise = array_filter($responseAssocArray, function($var) use ($filter){
										return ($var['accRoutingCode'] == $filter);
											});	
				$totalEntryNepsBrWise = sizeof($responseAssocArrayBrWise);
			}						
				

				
				$tsql = "SELECT	 COUNT ([txnCode]) AS [branchTotal]
						FROM	[dbjbneps].[dbo].[nepsCustEnroll]
						WHERE	[submissionStatus] ='E' AND [branchCode] ='".$row_branch_name['BranchCode'].
						"' AND (CONVERT(DATE,[enrollDate]) BETWEEN '".$sql_from_date."' AND '".$sql_to_date."')";
						
				$result_rs_branch_total = sqlsrv_query($conn,$tsql);
				$result_branch_total = sqlsrv_fetch_array($result_rs_branch_total);
				
				sqlsrv_free_stmt( $result_rs_branch_total);
			
			
			if ($i%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
				$this->DataList.="<tr $rowbg>";
				$slno = $i+1;
				
			$this->DataList.="<td class=row_data>".$slno."</td>";
			$this->DataList.="<td class=row_data>".$row_branch_name['BranchCode']."</td>";
			$this->DataList.="<td class=row_data>".$row_branch_name['BranchName']."</td>";
			$this->DataList.="<td class=row_data>".$result_branch_total['branchTotal']."</td>";
			$this->DataList.="<td class=row_data>".$totalEntryNepsBrWise."</td>";
			
		 	$this->DataList.="</tr>";
			$i++;
		
		}
		
		sqlsrv_free_stmt( $result_branch_Name);
			
			IF ($branchCode =='ALL')
			{
			
				$tbsql = "SELECT	 COUNT ([txnCode]) AS [bankTotal]
						FROM	[dbjbneps].[dbo].[nepsCustEnroll]
						WHERE	[submissionStatus] ='E' AND (CONVERT(DATE,[enrollDate]) BETWEEN '".$sql_from_date."' AND '".$sql_to_date."')";
			}
			else
			{
				$tbsql = "SELECT	 COUNT ([txnCode]) AS [bankTotal]
						FROM	[dbjbneps].[dbo].[nepsCustEnroll]
						WHERE	[submissionStatus] ='E' AND (CONVERT(DATE,[enrollDate]) BETWEEN '".$sql_from_date."' AND '".$sql_to_date."')".
						" AND [branchCode]='".$branchCode."'";
					
			}
			
			
			$result_rs_bank_total = sqlsrv_query($conn,$tbsql);
			$result_bank_total = sqlsrv_fetch_array($result_rs_bank_total);
			sqlsrv_free_stmt( $result_rs_bank_total);

		
				$this->DataList.="<tr style=\"background-color: rgb(31, 103, 219); color:White;font-size: 20px\">";
				$this->DataList.="<td colspan='3' >Total</td>";
				$this->DataList.="<td >".$result_bank_total['bankTotal']."</td>";
			IF ($branchCode =='ALL')
			{	
				$this->DataList.="<td >".$totalEntryNepsBankWise."</td>";
			}
			else
			{
				$this->DataList.="<td >".$totalEntryNepsBrWise."</td>";
			}
			$this->DataList.="</tr>";
       $this->DataList.="</table>";
	   $branchCode = $sql_from_date = $sql_to_date = $fromDate =$toDate = $toDateTimestamp ="";
	   $responseAssocArray=Null;
	//sqlsrv_free_stmt( $result_branch_Name);		
	}	




/*
function form_reconcile($tblcaption,$colHeader,$fromDate,$toDate,$conn){
			
			$sql_from_date = date("Y-m-d",strtotime($fromDate));
			$sql_to_date = date("Y-m-d",strtotime($toDate));
			
			$fromDateObj = DateTime::createFromFormat('d-m-Y', $fromDate);
			$fromDateTimestamp = $fromDateObj->getTimestamp()*1000;
			
			$toDateObj = DateTime::createFromFormat('d-m-Y', $toDate);
			$toDateTimestamp = $toDateObj->getTimestamp()*1000;
			
			$deptname='';
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray); //10
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
// API CALL STARTS			
			$url = "http://123.49.47.64:8080/neps-api/oauth/token";

				$client_id = "JanataBank";
				$client_secret = "Test123Test";
				$authorization = base64_encode("$client_id:$client_secret");

				$postCredential = array(
										'grant_type'=>'password',
										'username'=>'JanataBank',
										'password'=>'Test123Test'
										);

				$header = "Authorization: Basic {$authorization}\r\n".
						  "Content-type: application/x-www-form-urlencoded\r\n";
				$context_options=array(
								'http'=>array(  'method'=>'POST'
												,'header'=>$header
												,'content'=>http_build_query($postCredential)
											  )
										);

				$context = stream_context_create($context_options);
				$responseAssocArray=json_decode(file_get_contents($url,false,$context),true);
				$totalEntry =0;
				

				$url = "http://123.49.47.64:8080/neps-api/secured/fetchDataCustomerData";
				//$postData = '{"bankOrgKey":14}';
				$postData = '{"bankOrgKey":'.'14'.','.'"accEnrollDateTimeFrom":'.$fromDateTimestamp.','.'"accEnrollDateTimeTo":'.$toDateTimestamp.'}';

				$authorization = $responseAssocArray["access_token"];

				$header = "Authorization: Bearer {$authorization}\r\n".
						  "Content-type: application/json;charset=UTF-8\r\n";
				$context_options=array(
								'http'=>array(  'method'=>'POST'
												,'header'=>$header
												,'content'=>$postData
											  )
										);

				$context = stream_context_create($context_options);
				$responseAssocArray=json_decode(file_get_contents($url,false,$context),true,512, JSON_BIGINT_AS_STRING);
//API CALL ENDS//
				$totalEntryNepsBankWise = sizeof($responseAssocArray);
				//$keys = array_keys($responseAssocArray);

					$sql_branch = "SELECT  dbjbwebremitt.dbo.Branch.BranchCode,dbjbwebremitt.dbo.Branch.BranchName, dbjbwebremitt.dbo.Branch.br_routing_number
								 FROM    dbjbwebremitt.dbo.Branch";
					$result_branch_Name = sqlsrv_query($conn,$sql_branch);
		$i=0;
			/* $row_branch_name_test = sqlsrv_fetch_array($result_branch_Name);
			echo "<pre>";
			print_r($row_branch_name_test); */
/*		while ($row_branch_name= sqlsrv_fetch_array($result_branch_Name)) {
					  
				//for($i = 0; $i < count($responseAssocArray); $i++) {
					
					//$txnCode= $responseAssocArray[$i]['txnCode'];
					
			IF($row_branch_name['br_routing_number'] ==NULL OR $row_branch_name['br_routing_number']=="")
			{$totalEntryNepsBrWise = 0;}
			Else
			{$filter = $row_branch_name['br_routing_number'];


			$responseAssocArrayBrWise = array_filter($responseAssocArray, function($var) use ($filter){
									return ($var['accRoutingCode'] == $filter);
										});	
			$totalEntryNepsBrWise = sizeof($responseAssocArrayBrWise);	}						
			

			
			$tsql = "SELECT	 COUNT ([txnCode]) AS [branchTotal]
					FROM	[dbjbneps].[dbo].[nepsCustEnroll]
					WHERE	[submissionStatus] ='E' AND [branchCode] ='".$row_branch_name['BranchCode'].
					"' AND (CONVERT(DATE,[enrollDate]) BETWEEN '".$sql_from_date."' AND '".$sql_to_date."')";
					
			$result_rs_branch_total = sqlsrv_query($conn,$tsql);
			$result_branch_total = sqlsrv_fetch_array($result_rs_branch_total);
			
			sqlsrv_free_stmt( $result_rs_branch_total);
			
			
			if ($i%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
				$this->DataList.="<tr $rowbg>";
				$slno = $i+1;
				
			$this->DataList.="<td class=row_data>".$slno."</td>";
			$this->DataList.="<td class=row_data>".$row_branch_name['BranchCode']."</td>";
			$this->DataList.="<td class=row_data>".$row_branch_name['BranchName']."</td>";
			$this->DataList.="<td class=row_data>".$result_branch_total['branchTotal']."</td>";
			$this->DataList.="<td class=row_data>".$totalEntryNepsBrWise."</td>";
			
		 	$this->DataList.="</tr>";
			$i++;
		
		}
		
			$tbsql = "SELECT	 COUNT ([txnCode]) AS [bankTotal]
					FROM	[dbjbneps].[dbo].[nepsCustEnroll]
					WHERE	[submissionStatus] ='E' AND (CONVERT(DATE,[enrollDate]) BETWEEN '".$sql_from_date."' AND '".$sql_to_date."')";
					
			$result_rs_bank_total = sqlsrv_query($conn,$tbsql);
			$result_bank_total = sqlsrv_fetch_array($result_rs_bank_total);
			sqlsrv_free_stmt( $result_rs_bank_total);

		
				$this->DataList.="<tr>";
				$this->DataList.="<td colspan='3' >Total</td>";
				$this->DataList.="<td >".$result_bank_total['bankTotal']."</td>";
				$this->DataList.="<td >".$totalEntryNepsBankWise."</td>";
			$this->DataList.="</tr>";
       $this->DataList.="</table>";
	sqlsrv_free_stmt( $result_branch_Name);		
	}		
*/

//////////////////////////////////////////
/*   NEPS Form Data List For Verify*/////
/////////////////////////////////////////
function form_data_list($tblcaption,$colHeader,$sql,$editlink,$baseroot,$conn){
			$deptname='';
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			while($row_list = sqlsrv_fetch_array($result_list)){
				
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          		
				$this->DataList.="<tr $rowbg>";
				
			for($c=0; $c < $col; $c++) 
               { 
				    
					if ($c==10){
							$bhataType ="";
							switch ($row_list[10]) 
							{		case '1':
										$bhataType='Boyosko';
										break;
									case '2':
										$bhataType= 'Bidhoba';
										break;
									case '3':
										$bhataType= 'Protibondhi';
										break;
									default:
										echo 'Not Found';
							}
							$this->DataList.="<td class=row_data>".$bhataType."</td>";
						
					}
					
					else if ($c==11) {
					$this->DataList.="<td class=row_data><span id='ctlno$r' class='error'><a href='javascript:void(0)' onclick=\"nepsVerify('ctlno$r','".$row_list[11]."','$baseroot')\">VERIFY</a></span></td>"; 
					}
					
					else
					{
					$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
					}
               }
		 	$this->DataList.="</tr>";
			$r++;
			}
       $this->DataList.="</table>";
sqlsrv_free_stmt( $result_list);			
	}
////////////////////////////////////////
/* FC RATES ERROR List EDIT*/
////////////////////////////////////////
function edit_fc_error_rate($tblcaption,$colHeader,$sql,$editlink,$baseroot,$conn){
			$deptname='';
			//$loginID =(string)$_SESSION['loginID'];
			$loginID =(string)$_SESSION['userjbremtt'];
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
					
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			while($row_list = sqlsrv_fetch_array($result_list)){
				
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          		
				$this->DataList.="<tr $rowbg>";
				
			for($c=0; $c < $col; $c++) 
               { 
				    		
					
					if ($c==12) {
					$this->DataList.="<td class=row_data><span id=\"edit$r\" class='error'><a href='javascript:void(0)' style=\"color:green;font-size: 12px\" onclick=\"fc_rate_edit('edit".$r."','".$row_list[12]."','".$row_list[13]."','".$loginID."','$baseroot')\">Edit</a></span></td>"; 	
					//$this->DataList.="<td class=row_data><a href='enroll.php/".$row_list[12]."';>Edit</a></td>";
					}
					
					else
					{
					$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
					}
               }
		 	$this->DataList.="</tr>";
			$r++;
			}
       $this->DataList.="</table>";
sqlsrv_free_stmt( $result_list);			
	}	


function edit_fc_error_rate_dollar($tblcaption,$colHeader,$sql,$editlink,$baseroot,$conn){
			$deptname='';
			//$loginID =(string)$_SESSION['loginID'];
			$loginID =(string)$_SESSION['userjbremtt'];
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
					
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			while($row_list = sqlsrv_fetch_array($result_list)){
				
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          		
				$this->DataList.="<tr $rowbg>";
			
// All FC Rate Edit		
  /*	
			for($c=0; $c < $col; $c++) 
               { 
				    		
					
					if ($c==12) {
					$this->DataList.="<td class=row_data><span id=\"edit$r\" class='error'><a href='javascript:void(0)' style=\"color:green;font-size: 12px\" onclick=\"fc_rate_edit('edit".$r."','".$row_list[12]."','".$row_list[13]."','".$loginID."','$baseroot')\">Edit</a></span></td>"; 	
					//$this->DataList.="<td class=row_data><a href='enroll.php/".$row_list[12]."';>Edit</a></td>";
					}
					
					else
					{
					$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
					}
               }
	*/
	
			for($c=0; $c < $col; $c++) 
               { 
				    		
					
					if ($c==2) {
					$this->DataList.="<td class=row_data><span id=\"edit$r\" class='error'><a href='javascript:void(0)' style=\"color:green;font-size: 12px\" onclick=\"fc_rate_edit('edit".$r."','".$row_list[2]."','".$row_list[3]."','".$loginID."','$baseroot')\">Edit</a></span></td>"; 	
					//$this->DataList.="<td class=row_data><a href='enroll.php/".$row_list[12]."';>Edit</a></td>";
					}
					
					else
					{
					$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
					}
               }
		 	$this->DataList.="</tr>";
			$r++;
			}
       $this->DataList.="</table>";
sqlsrv_free_stmt( $result_list);			
	}

////////////////////////////////////////
/* Passport: SHOW CUSTOMER LIST FOR CERTIFICATE PRINT*/
////////////////////////////////////////
function show_customer_list_for_certificate_print($tblcaption,$colHeader,$sql,$editlink,$baseroot,$conn){
			
			$deptname='';
			//$loginID =(string)$_SESSION['loginID'];
			$loginID =(string)$_SESSION['userjbremtt'];
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
					
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			while($row_list = sqlsrv_fetch_array($result_list)){
				
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          		
				$this->DataList.="<tr $rowbg>";
				
			for($c=0; $c < $col; $c++) 
               { 
				    		
					
					if ($c==9) {
					$this->DataList.="<td class=row_data><span id=\"edit$r\" class='error'><a href='javascript:void(0)' style=\"color:green;font-size: 12px\" onclick=\"print_certificate('edit".$r."','".$row_list['PE_TXN_ID']."','".$loginID."','$baseroot')\">PRINT CERTIFICATE</a></span></td>"; 	
					//$this->DataList.="<td class=row_data><span id=\"edit$r\" class='error'><a href='javascript:void(0)' style=\"color:green;font-size: 12px\" onclick=\"fc_rate_edit('edit".$r."','".$row_list[9]."','".$row_list[9]."','".$loginID."','$baseroot')\">PRINT CERTIFICATE</a></span></td>"; 	
					
					}
					
					else
					{
					$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
					}
               }
		 	$this->DataList.="</tr>";
			$r++;
			}
       $this->DataList.="</table>";
sqlsrv_free_stmt( $result_list);			
	}

///////////////////////////////////////////////
/*    PASSPORT INFORMATION SHOW ON CLICK */
//////////////////////////////////////////////
function PassportInfo($tblcaption,$colHeader,$passportNo,$baseroot,$conn){
		//echo $tblcaption."<br>".$colHeader."<br>".$passportNo."<br>".$baseroot."<br>".$conn;
		$contactNo="";
		$deptname='';
		$this->DataList="";
		$HeaderArray=explode(",",$colHeader);
		$col=count($HeaderArray);
        
		$slNo=$applicantName=$address=$passportDate=$passportIssuePlace="";
		$passportRenewalDate=$createdBy=$approvedBy=$passportCreateDate ="";
		
		//$sql="exec spPassportInfo $passportNo";
		//$sql="exec spPassportInfo"."'".$passportNo."'";
		$sql1 ="SELECT [PASSPORT_NO],[STATUS]
				FROM [dbjbPassportEndorse].[dbo].[tblpassport]
			  where [PASSPORT_NO]='".$passportNo."'";
			  
		$result_list1 = sqlsrv_query($conn,$sql1);  
		$row_list1 = sqlsrv_fetch_array($result_list1); 
		IF ($row_list1['PASSPORT_NO'] !=NULL AND $row_list1['STATUS']=='A'){
			$sql2 ="SELECT [SL_NO]
				  ,[PASSPORT_NO]
				  ,[CITIZEN_NAME]
				  ,[ADDRESS]
				  ,Convert(varchar,[PASSPORT_DATE],111) AS [PASSPORT_DATE]
				  ,[PASSPORT_ISSUE_PLACE]
				  ,Convert(varchar,[PASSPORT_RENEWAL_DATE],111) AS [PASSPORT_RENEWAL_DATE]
				  ,[CREATED_BY]
				  ,[APPROVED_BY]
				  ,Convert(varchar,[ENTRY_DATE],111) AS [ENTRY_DATE]
			  FROM [dbjbPassportEndorse].[dbo].[tblpassport]
			  where [PASSPORT_NO]='".$passportNo."'";

			$result_list2 = sqlsrv_query($conn,$sql2);
			while ($row_list2 = sqlsrv_fetch_array($result_list2)){
				IF ($row_list2['PASSPORT_NO'] !=NULL){
					$slNo=$row_list2['SL_NO'];
					$passportNo=$row_list2['PASSPORT_NO'];
					$applicantName=$row_list2['CITIZEN_NAME'];
					$address=$row_list2['ADDRESS'];
					$passportDate=$row_list2['PASSPORT_DATE'];
					$passportIssuePlace=$row_list2['PASSPORT_ISSUE_PLACE'];
					$passportRenewalDate= $row_list2['PASSPORT_RENEWAL_DATE'];
					$createdBy=$row_list2['CREATED_BY'];
					$approvedBy=$row_list2['APPROVED_BY'];
					$passportCreateDate =$row_list2['ENTRY_DATE'];
				
	//------GridView-----------//
				//$this->DataList.="<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"frmPassportEntry\" >  ";
				//$this->DataList.="<table width=80% class=msgbox border=1 cellpadding=3 cellspacing=0>";
				$this->DataList.="<table id=\"passportForm\" width=80% >";
				$this->DataList.="<th height=30px class=tbg colspan=2 ><strong>$tblcaption</strong></th>";
				//$this->DataList.="<th height=30px class=tbg><td colspan=2><strong>$tblcaption</strong></td></th>";
				
				$this->DataList.="<tr class=\"data_bg\">";    
				$this->DataList.="<td class=\"row_data\"><strong>Passport Number</strong></td>";
				$this->DataList.="<td class=\"row_data\" ><input type=\"text\" id=\"passportNo\" name=\"passportNo\" value=\"$passportNo\" readonly></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=\"data_bg_alt\">";    
				$this->DataList.="<td class=\"row_data\"><strong>Applicant Name</strong></td>";
				$this->DataList.="<td class=\"row_data\" ><input type=\"text\" id=\"applicantName\" name=\"applicantName\" value=\"$applicantName\" readonly></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=\"data_bg\">";    
				$this->DataList.="<td class=\"row_data\"><strong>Address</strong></td>";
				$this->DataList.="<td class=\"row_data\"><textarea rows=\"3\" cols=\"50\" id=\"address\" name=\"address\" readonly>$address</textarea></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=\"data_bg_alt\">";    
				$this->DataList.="<td class=\"row_data\"><strong>Passport Issue Date</strong></td>";
				$this->DataList.="<td class=\"row_data\"><input type=\"text\" id=\"passportDate\" name=\"passportDate\" value=\"$passportDate\"readonly></td>";
				/* $this->DataList.="<td class=\"row_data\" ><input  type=\"text\" id=\"passportDate\" name=\"passportDate\"  required pattern=\"(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}\" title=\"Format: DD-MM-YYYY\" value=\"$passportDate\" maxlength=\"10\" size=\"12\"  placeholder=\"DD-MM-YYYY?\"/>
				<a href=\"javascript: NewCssCal('passportDate','ddmmyyyy','arrow','$baseroot')\"><img src=\"$baseroot/images/cal.gif\" width=\"16\" height=\"16\" alt=\"Pick a date\" /></a><span class=\"error\">**DD-MM-YYYY**</span>
				</td>"; */
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=\"data_bg\">";    
				$this->DataList.="<td class=\"row_data\"><strong>Passport Issue Place</strong></td>";
				$this->DataList.="<td class=\"row_data\"><input type=\"text\" id=\"passportIssuePlace\" name=\"passportIssuePlace\" value=\"$passportIssuePlace\" readonly></td>";
				$this->DataList.="</tr>";
				/* 
				$this->DataList.="<tr class=data_bg_alt>";    
				$this->DataList.="<td class=row_data><strong>Contact No</strong></td>";
				$this->DataList.="<td class=row_data><input name=\"contactNo\" type=\"text\" id=\"contactNo\" onkeyup=\"IsNumericInt(this);\" value=\"$contactNo\"  autocomplete=\"off\"  placeholder=\"Contact/Mobile Number?\"  maxlength=\"11\"/><span class=\"error\">**Contact Number**</span></td>";
				$this->DataList.="</tr>";
				 */
				$this->DataList.="<tr class=\"data_bg_alt\" hidden>";    
				$this->DataList.="<td class=\"row_data\"><strong>Passport Renewal Date</strong></td>";
				$this->DataList.="<td class=\"row_data\"><strong>".$passportRenewalDate."</strong></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=\"data_bg_alt\" hidden>";    
				$this->DataList.="<td class=\"row_data\"><strong>Passport Create Date</strong></td>";
				$this->DataList.="<td class=\"row_data\"><strong>".$passportCreateDate."</strong></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=\"data_bg\" hidden>";    
				$this->DataList.="<td class=row_data><strong>Created By</strong></td>";
				$this->DataList.="<td class=row_data><strong>".$createdBy."</strong></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=\"data_bg\" hidden>";    
				$this->DataList.="<td class=row_data><strong>Approved By</strong></td>";
				$this->DataList.="<td class=row_data><strong>".$approvedBy."</strong></td>";
				$this->DataList.="</tr>";
				
				
				
										
				$this->DataList.="</table>";
				//$this->DataList.="</form>";
												
		
			}
			
			ELSE 
			{
				//print_r($row_list[0]);
				echo 'unknown error occured';
				
			}
		}		
		sqlsrv_free_stmt($result_list2);	
	}
		
		ELSEIF ($row_list1['PASSPORT_NO'] !=NULL AND $row_list1['STATUS']=='R'){
			$sql2 ="SELECT [SL_NO]
				  ,[PASSPORT_NO]
				  ,[CITIZEN_NAME]
				  ,[ADDRESS]
				  ,Convert(varchar,[PASSPORT_DATE],111) AS [PASSPORT_DATE]
				  ,[PASSPORT_ISSUE_PLACE]
				  ,Convert(varchar,[PASSPORT_RENEWAL_DATE],111) AS [PASSPORT_RENEWAL_DATE]
				  ,[CREATED_BY]
				  ,[APPROVED_BY]
				  ,Convert(varchar,[ENTRY_DATE],111) AS [ENTRY_DATE]
			  FROM [dbjbPassportEndorse].[dbo].[tblpassport]
			  where [PASSPORT_NO]='".$passportNo."'";

			$result_list2 = sqlsrv_query($conn,$sql2);
			while ($row_list2 = sqlsrv_fetch_array($result_list2)){
				IF ($row_list2['PASSPORT_NO'] !=NULL){
					$slNo=$row_list2['SL_NO'];
					$passportNo=$row_list2['PASSPORT_NO'];
					$applicantName=$row_list2['CITIZEN_NAME'];
					$address=$row_list2['ADDRESS'];
					$passportDate=$row_list2['PASSPORT_DATE'];
					$passportIssuePlace=$row_list2['PASSPORT_ISSUE_PLACE'];
					$passportRenewalDate= $row_list2['PASSPORT_RENEWAL_DATE'];
					$createdBy=$row_list2['CREATED_BY'];
					$approvedBy=$row_list2['APPROVED_BY'];
					$passportCreateDate =$row_list2['ENTRY_DATE'];
				
	//------GridView-----------//
				//$this->DataList.="<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"frmPassportEntry\" >  ";
				//$this->DataList.="<table width=80% class=msgbox border=1 cellpadding=3 cellspacing=0>";
				$this->DataList.="<table id=\"passportForm\" width=80% >";
				$this->DataList.="<th height=30px class=tbg colspan=2 ><strong>$tblcaption</strong></th>";
				//$this->DataList.="<th height=30px class=tbg><td colspan=2><strong>$tblcaption</strong></td></th>";
				
				$this->DataList.="<tr class=\"data_bg\">";    
				$this->DataList.="<td class=\"row_data\"><strong>Passport Number</strong></td>";
				$this->DataList.="<td class=\"row_data\" ><input type=\"text\" id=\"passportNo\" name=\"passportNo\" value=\"$passportNo\" readonly ></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=\"data_bg_alt\">";    
				$this->DataList.="<td class=\"row_data\"><strong>Applicant Name</strong></td>";
				$this->DataList.="<td class=\"row_data\" ><input type=\"text\" id=\"applicantName\" name=\"applicantName\" value=\"$applicantName\" ></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=\"data_bg\">";    
				$this->DataList.="<td class=\"row_data\"><strong>Address</strong></td>";
				$this->DataList.="<td class=\"row_data\"><textarea rows=\"3\" cols=\"50\" id=\"address\" name=\"address\" >$address</textarea></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=\"data_bg_alt\">";    
				$this->DataList.="<td class=\"row_data\"><strong>Passport Issue Date</strong></td>";
				$this->DataList.="<td class=\"row_data\"><input type=\"text\" id=\"passportDate\" name=\"passportDate\" value=\"$passportDate\"></td>";
				/* $this->DataList.="<td class=\"row_data\" ><input  type=\"text\" id=\"passportDate\" name=\"passportDate\"  required pattern=\"(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}\" title=\"Format: DD-MM-YYYY\" value=\"$passportDate\" maxlength=\"10\" size=\"12\"  placeholder=\"DD-MM-YYYY?\"/>
				<a href=\"javascript: NewCssCal('passportDate','ddmmyyyy','arrow','$baseroot')\"><img src=\"$baseroot/images/cal.gif\" width=\"16\" height=\"16\" alt=\"Pick a date\" /></a><span class=\"error\">**DD-MM-YYYY**</span>
				</td>"; */
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=\"data_bg\">";    
				$this->DataList.="<td class=\"row_data\"><strong>Passport Issue Place</strong></td>";
				$this->DataList.="<td class=\"row_data\"><input type=\"text\" id=\"passportIssuePlace\" name=\"passportIssuePlace\" value=\"$passportIssuePlace\" ></td>";
				$this->DataList.="</tr>";
				/* 
				$this->DataList.="<tr class=data_bg_alt>";    
				$this->DataList.="<td class=row_data><strong>Contact No</strong></td>";
				$this->DataList.="<td class=row_data><input name=\"contactNo\" type=\"text\" id=\"contactNo\" onkeyup=\"IsNumericInt(this);\" value=\"$contactNo\"  autocomplete=\"off\"  placeholder=\"Contact/Mobile Number?\"  maxlength=\"11\"/><span class=\"error\">**Contact Number**</span></td>";
				$this->DataList.="</tr>";
				 */
				$this->DataList.="<tr class=\"data_bg_alt\" hidden>";    
				$this->DataList.="<td class=\"row_data\"><strong>Passport Renewal Date</strong></td>";
				$this->DataList.="<td class=\"row_data\"><strong>".$passportRenewalDate."</strong></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=\"data_bg_alt\" hidden>";    
				$this->DataList.="<td class=\"row_data\"><strong>Passport Create Date</strong></td>";
				$this->DataList.="<td class=\"row_data\"><strong>".$passportCreateDate."</strong></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=\"data_bg\" hidden>";    
				$this->DataList.="<td class=row_data><strong>Created By</strong></td>";
				$this->DataList.="<td class=row_data><strong>".$createdBy."</strong></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=\"data_bg\" hidden>";    
				$this->DataList.="<td class=row_data><strong>Approved By</strong></td>";
				$this->DataList.="<td class=row_data><strong>".$approvedBy."</strong></td>";
				$this->DataList.="</tr>";
				
										
				$this->DataList.="</table>";
				//$this->DataList.="</form>";
												
		
			}
			
			ELSE 
			{
				//print_r($row_list[0]);
				echo 'unknown error occured';
				
			}
		}		
		sqlsrv_free_stmt($result_list2);	
	}
		
	
	ELSEIF ($row_list1['PASSPORT_NO'] !=NULL AND $row_list1['STATUS']=='P'){
				
			$this->DataList.="<span style=\"color:red;font-size: 20px\">Passport In Pending(Endorsement Approve) List</span>";
	}	
		ELSE 
			{	//$this->DataList.="<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"frmPassportEntry\" >  ";
				$this->DataList.="<table width=80% id=\"passportEntryForm\" >";
				$this->DataList.="<th height=30px class=tbg colspan=2 ><strong>$tblcaption</strong></th>";
				//$this->DataList.="<tr height=30px class=tbg><td colspan=2><strong>$tblcaption</strong></td></tr>";
											
				$this->DataList.="<tr class=data_bg>";    
				$this->DataList.="<td class=row_data><strong>Passport Number</strong></td>";
				$this->DataList.="<td class=row_data  ><input size=\"33\" type=\"text\" id=\"passportNo\" name=\"passportNo\" value=\"$passportNo\" style=\"text-transform: uppercase;\"></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=data_bg_alt>";    
				$this->DataList.="<td class=row_data ><strong>Applicant Name</strong></td>";
				$this->DataList.="<td class=row_data  ><input size=\"33\" type=\"text\" id=\"applicantName\" name=\"applicantName\" value=\"$applicantName\"></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=data_bg>";    
				$this->DataList.="<td class=row_data><strong>Address</strong></td>";
				$this->DataList.="<td class=row_data  ><textarea  rows=\"3\" cols=\"50\" id=\"address\" name=\"address\">$address</textarea></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=\"data_bg_alt\" >";    
				$this->DataList.="<td class=row_data ><strong>Passport Issue Date</strong></td>";
				//$this->DataList.="<td class=row_data><input type=\"text\" id=\"passportDate\" name=\"passportDate\" value=\"$passportDate\"></td>";
				$this->DataList.="<td class=\"row_data\" ><input  type=\"text\" id=\"passportDate\" name=\"passportDate\"  required pattern=\"(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}\" title=\"Format: DD-MM-YYYY\" value=\"$passportDate\" maxlength=\"10\" size=\"12\"    placeholder=\"DD-MM-YYYY?\"/>
				<a href=\"javascript: NewCssCal('passportDate','ddmmyyyy','arrow','$baseroot')\"><img src=\"$baseroot/images/cal.gif\" width=\"16\" height=\"16\" alt=\"Pick a date\" /></a><span class=\"error\">**DD-MM-YYYY**</span>
				</td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=data_bg>";    
				$this->DataList.="<td class=row_data><strong>Passport Issue Place</strong></td>";
				$this->DataList.="<td class=row_data ><input type=\"text\" id=\"passportIssuePlace\" name=\"passportIssuePlace\" value=\"$passportIssuePlace\"></td>";
				$this->DataList.="</tr>";
				/* 
				$this->DataList.="<tr class=data_bg_alt>";    
				$this->DataList.="<td class=row_data><strong>Contact No</strong></td>";
				$this->DataList.="<td class=row_data><input name=\"contactNo\" type=\"text\" id=\"contactNo\" onkeyup=\"IsNumericInt(this);\" value=\"$contactNo\"  autocomplete=\"off\"  placeholder=\"Contact/Mobile Number?\"  maxlength=\"11\"/><span class=\"error\">**Contact Number**</span></td>";
				$this->DataList.="</tr>";
				 */
				
				
				$this->DataList.="<tr class=data_bg_alt hidden>";    
				$this->DataList.="<td class=row_data><strong>Passport Renewal Date</strong></td>";
				$this->DataList.="<td class=row_data  ><strong>".$passportRenewalDate."</strong></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=data_bg_alt hidden>";    
				$this->DataList.="<td class=row_data><strong>Passport Create Date</strong></td>";
				$this->DataList.="<td class=row_data  ><strong>".$passportCreateDate."</strong></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=data_bg hidden>";    
				$this->DataList.="<td class=row_data><strong>Created By</strong></td>";
				$this->DataList.="<td class=row_data  ><strong>".$createdBy."</strong></td>";
				$this->DataList.="</tr>";
				
				$this->DataList.="<tr class=data_bg hidden>";    
				$this->DataList.="<td class=row_data><strong>Approved By</strong></td>";
				$this->DataList.="<td class=row_data ><strong>".$approvedBy."</strong></td>";
				$this->DataList.="</tr>";
										
				$this->DataList.="</table>";
				//$this->DataList.="</form>";
				
				
			}		
		sqlsrv_free_stmt($result_list1);
	//}

						
}
/////////////////////////////////////////
/*Passport Endorse AUTHORIZE*////
///////////////////////////////////////
function form_data_list_auth($tblcaption,$colHeader,$sql,$editlink,$baseroot,$conn){
			$deptname='';
			//$authorizedBy =(string)$_SESSION['loginID'];
			$authorizedBy=(string)$_SESSION['userjbremtt'];
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0 id=\"authorizeList\" >";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c' ><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			while($row_list = sqlsrv_fetch_array($result_list)){
				
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          	//$this->DataList.="<tr $rowbg id='ctl".$row_list[10]."'>";
				
				$this->DataList.="<tr $rowbg>";
				
			for($c=0; $c < $col; $c++) 
               { 
				    /* if ($c==10){
							$bhataType ="";
							switch ($row_list[10]) 
							{		case '1':
										$bhataType='Boyosko';
										break;
									case '2':
										$bhataType= 'Bidhoba';
										break;
									case '3':
										$bhataType= 'Protibondhi';
										break;
									default:
										echo 'Not Found';
							}
							$this->DataList.="<td class=row_data>".$bhataType."</td>";
						
					} */
					
					
					 if ($c==12) {	
					//$this->DataList.="<td class=row_data><a href='enroll.php/".$row_list[11]."';>Reject</a></td>";
					$this->DataList.="<td ><span id=\"ctlno$r\" class='error'><a href='javascript:void(0)' style=\"color:red;font-size: 12px\" onclick=\"peReject('ctlno$r','".$row_list['PE_TXN_ID']."','".$authorizedBy."','$baseroot')\">Reject</a></span></td>"; 
					}
					
					else if ($c==13) {
					
					$this->DataList.="<td class=row_data><span id=\"authorize$r\" class='error'><a href='javascript:void(0)' style=\"color:green;font-size: 12px\" onclick=\"peAuthorize('authorize".$r."','".$row_list['PE_TXN_ID']."','".$authorizedBy."','$baseroot')\">Authorize</a></span></td>"; 
					
					//$this->DataList.="<td class=row_data><span id='ctlno$r' class='error'><a href='javascript:void(0)' style=\"color:green;font-size: 12px\" onclick=\"nepsAuthorize('ctlno$r','".$row_list[12]."','".$authorizedBy."','$baseroot')\">Authorize</a></span></td>"; 
					/*	$this->DataList.="<td class=row_data><span id='ctlno$r' class='error'><a href='javascript:void(0)' onclick=\"nepsAuthorize('ctlno$r','".$row_list[12]."','".$authorizedBy."','".$conn."','$baseroot')\">Authorize</a></span></td>";  					
						$this->DataList.="<td class=row_data><span id='ctlno$r' class='error'><a href='javascript:void(0)' onclick=\"nepsAuthorize(ctlno".$r.",".$row_list[12].",".$authorizedBy.",".$conn.",".$baseroot.")\>Authorize</a></span></td>";  
					*/
					}
					
					else
					{
					$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
					}
               }
		 	$this->DataList.="</tr>";
			$r++;
			}
       $this->DataList.="</table>";
sqlsrv_free_stmt( $result_list);			
	}	


/////////////////////////////////////////
/*Passport Endorse EDIT*////////////////
///////////////////////////////////////
function pe_endoesement_edit($tblcaption,$colHeader,$sql,$editlink,$baseroot,$conn){
			$deptname='';
			//$loginID =(string)$_SESSION['loginID'];
			$loginID =(string)$_SESSION['userjbremtt'];
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0 id=\"authorizeList\" >";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c' ><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			while($row_list = sqlsrv_fetch_array($result_list)){
				
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          	//$this->DataList.="<tr $rowbg id='ctl".$row_list[10]."'>";
				
				$this->DataList.="<tr $rowbg>";
				
			for($c=0; $c < $col; $c++) 
               { 
				    /* if ($c==10){
							$bhataType ="";
							switch ($row_list[10]) 
							{		case '1':
										$bhataType='Boyosko';
										break;
									case '2':
										$bhataType= 'Bidhoba';
										break;
									case '3':
										$bhataType= 'Protibondhi';
										break;
									default:
										echo 'Not Found';
							}
							$this->DataList.="<td class=row_data>".$bhataType."</td>";
						
					} */
					
					
					if ($c==12) {
					$this->DataList.="<td class=row_data><span id=\"edit$r\" class='error'><a href='javascript:void(0)' style=\"color:green;font-size: 12px\" onclick=\"peEdit('edit".$r."','".$row_list['PE_TXN_ID']."','".$loginID."','".$row_list['CREATED_BY']."','$baseroot')\">Edit</a></span></td>"; 	
					//$this->DataList.="<td class=row_data><a href='enroll.php/".$row_list[12]."';>Edit</a></td>";
					}
					
					else
					{
					$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
					}
               }
		 	$this->DataList.="</tr>";
			$r++;
			}
       $this->DataList.="</table>";
sqlsrv_free_stmt( $result_list);			
	}


/////////////////////////////////////////////////////////////////////////////
///////////////////////////  NEPS ENDS HERE ////////////////////////////////
///////////////////////////////////////////////////////////////////////////

function sp_prefixlist($tblcaption,$colHeader,$sql,$baseroot,$conn){
			$deptname='';
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";
          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			$total_bill=0;
			while($row_list = sqlsrv_fetch_array($result_list)){	
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          	$this->DataList.="<tr $rowbg>";
				
				for($c=0; $c < $col; $c++) 
                                {
                                    if($c==3)
                                    {
                                    //$this->DataList.="<td class=row_data><a href='zone_prefix_settings.php/".$row_list[3]."';>Delete</a></td>";
                                    $this->DataList.="<td class=row_data><span id='ctlno$r' class='error'><a href='javascript:void(0)' onclick=\"zone_prefix_delete('ctlno$r','".$row_list[3]."','$baseroot')\">Delete</a></span></td>";    
                                    }
                                    else
                                    {
                                        $this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
                                    }
                                }
		 	$this->DataList.="</tr>";
			$r++;
			}
       $this->DataList.="</table>";
sqlsrv_free_stmt( $result_list);			
	}
function sp_brzonelist($tblcaption,$colHeader,$sql,$scrolltype,$brcode,$baseroot,$conn){
			$deptname='';
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";
          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			$total_bill=0;
			while($row_list = sqlsrv_fetch_array($result_list)){	
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          	$this->DataList.="<tr $rowbg>";
				
				for($c=0; $c < $col; $c++) 
                                {
                                    if($c==5)
                                    {
                                        $chk="";$dis="";
                                        if($row_list[7]==$brcode){$chk="checked"; $dis="disabled=\"true\"";}
                                    $this->DataList.="<td class=row_data><form><input type='checkbox' name='chkconfirm' id='chkconfirm' value='".$row_list[5]."' $chk $dis></form>"
                                            . "<label name='lb_zoneid' id='lb_zoneid' style='display:none'>".$row_list[5]."</label>"
                                            . "<label name='lb_spcode' id='lb_spcode' style='display:none'>".$row_list[6]."</label></td>";
                                    }
                                    else if ($c==3)
                                    {
                                     $this->DataList.="<td class=row_data><span name='span_accounts' id='ctln2$r' class='error'><input name='txt_accounts' type='text' id='txt_accounts' onkeyup='IsNumericInt(this);'  autocomplete='off' value='".$row_list[3]."'/></span></td>";
                                    }
                                    else if ($c==6)
                                    {
                                     $this->DataList.="<td class=row_data><span id='ctlno$r' class='error'><a href='javascript:void(0)' onclick=\"spzone_br_delete('ctlno$r','".$row_list[7]."','".$row_list[6]."','".$row_list[5]."','$baseroot')\">Delete</a></span></td>";
                                    }
                                    else if ($c==4)
                                    {
                                     $this->DataList.="<td class=row_data><span name='span_vat' id='ctln3$r' class='error'><input name='txt_vat' type='text' id='txt_vat' onkeyup='IsNumericInt(this);'  autocomplete='off' value='".$row_list[4]."'/></span></td>";
                                    }
                                    else
                                    {
                                        $this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
                                    }
                                }
		 	$this->DataList.="</tr>";
			$r++;
			}
       $this->DataList.="</table>";
       $this->DataList.="<br>";
       $this->DataList.="<SPAN id='spanreqlist'>";
       $this->DataList.="<div style='width:100%;float:left;' align='center'><input type='button' name='btn_Accept' value='SAVE' onclick=\"spzonebr_chk('spanreqlist','$scrolltype','$brcode','$baseroot');\" /></div>";
       $this->DataList.="</SPAN>";
sqlsrv_free_stmt( $result_list);			
	}        
//Money Format
function moneyformat($number){ 
$explrestunits='';
		$intnumber = (int) $number;
		$decnumber = $number - $intnumber;
		if ($decnumber>0) {
	   	list($num,$decimal)=explode('.', $number);		
		} else if ($decnumber==0) {
		$num=$intnumber;
		$decimal='';			
		} else {
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
//Show Data List Unlink
	function data_list_unlink($tblcaption,$colHeader,$sql,$conn){
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
			$this->DataList.="<table width=100% class=msgbox border=1 cellpadding=3 cellspacing=0>";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			while($row_list = sqlsrv_fetch_array($result_list)){	
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          	$this->DataList.="<tr $rowbg>";				
				for($c=0; $c < $col; $c++) {
				$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";					
				}
		 	$this->DataList.="</tr>";
			$r++;
			}
       $this->DataList.="</table>";
sqlsrv_free_stmt( $result_list);			
	}



//Show Data List
	function data_list($tblcaption,$colHeader,$sql,$actionlink,$dellink,$conn){
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
			$this->DataList.="<table width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			while($row_list = sqlsrv_fetch_array($result_list)){	
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          	$this->DataList.="<tr $rowbg>";
				
				for($c=0; $c < $col; $c++) {
				$loginID='';
				$loginID=$row_list[0]."";
					if ($c==1) {
						if (!empty($actionlink)) {
						$this->DataList.="<td class=row_data><a href=$actionlink$loginID>".$row_list[$c]."</a></td>";
						} else {
						$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";						
						}
					} elseif ($c==$col-1) {
						if (!empty($dellink)) {
						$this->DataList.="<td class=row_data><a href=$dellink$loginID>".$row_list[$c]."</a></td>";
						} else {
						$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";						
						}
					} else {
				$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";					
					}
				}
		 	$this->DataList.="</tr>";
			$r++;
			}
       $this->DataList.="</table>";
sqlsrv_free_stmt( $result_list);			
	}

//Show Data List
	function data_user_list($tblname,$tblcaption,$colHeader,$sql,$user,$actionlink,$permissionlink,$conn){
			$deptname='';
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
			$this->DataList.="<table width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			while($row_list = sqlsrv_fetch_array($result_list)){	
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          	$this->DataList.="<tr $rowbg>";
				
				for($c=0; $c < $col; $c++) {
				$loginID='';
				$loginID=$row_list[0]."";
				if ($c==1) {	
				$this->DataList.="<td class=row_data><a title='Click Here To Update' href='".$actionlink.$loginID."'><span class='error'>".$row_list[$c]."</span></a></td>";					
				} 
				else if ($c==3) {	
				
	//=========================
					if ($row_list[8]=='9999') {
					$sql_deptname="select deptcode,deptname from tbldepartment where brcode='".$row_list[8]."' and deptcode='".$row_list[9]."'";
					$result_deptname=sqlsrv_query($conn,$sql_deptname);
					$row_deptname=sqlsrv_fetch_array($result_deptname);
					$deptname = " [".$row_deptname['deptname']."]";
					sqlsrv_free_stmt( $result_deptname);
				}
		
		//=========================

				$this->DataList.="<td class=row_data>".$row_list[$c].$deptname."</td>";					
				} else if ($c==8) {	
				$this->DataList.="<td class=row_data><a title='Click Here To Permission' href='".$permissionlink.$loginID."'><span class='error'>".$row_list[$c]."</span></a></td>";					
				} else {
				$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
				}
				}
		 	$this->DataList.="</tr>";
			$r++;
			}
       $this->DataList.="</table>";
sqlsrv_free_stmt( $result_list);						
	}

	


function gas_bill_recon_titas_details($sql,$brcode,$br_routing,$currdate_sql_format,$baseroot,$conn)
{
//$sql="exec bpdb_sp_dataview_from_spserver '$acc_no','$bill_year','$bill_month','$branch_code'";
//echo $sql;echo 'Brcode'.$brcode.$br_routing; exit;
$data="";
$this->titasDataCount=0;
$result_list = sqlsrv_query($conn,$sql);
while ($row_list = sqlsrv_fetch_array($result_list)) 
{
$data = json_decode($row_list[0], true);
	//echo $data['data'];
}
$r=0;$titas_total_amount=0;$sl=0;
$titas_surcharge=0;$titas_amount=0;
$this->titasDataCount=count($data['data']);

$this->DataList="";


//$this->DataList.="</tr>";
$query="delete from titas_recon_tbl where brcode='$brcode'";
$stmt1 = sqlsrv_query( $conn, $query);
while($r!=count($data['data']))
{


$banktrID=$data['data'][$r]['bankTransactionId'];$returnID=$data['data'][$r]['id'];
$amount=$data['data'][$r]['total'];$vdate=$data['data'][$r]['voucherDate'];

$query="insert into titas_recon_tbl (brcode,banktrID,returnID,vdate,amount,br_routing_number) values ('$brcode','$banktrID',$returnID,'$vdate','$amount','$br_routing')";
$stmt1 = sqlsrv_query($conn,$query);
//$this->DataList.="</tr>";
$r++;
//$sl++;	
}
//$this->DataList.="</table>";
//echo "exec SP_Reconcile_Gas '$brcode','$currdate_sql_format'"; exit;
//$result_list = sqlsrv_query($conn,"select  [gslno],[returnID],[amount],[banktrID],[vdate],[brcode]
//                            ,[total_amount] from [miss_match_recon_titas] where brcode='$brcode'");

$result_list = sqlsrv_query($conn,"exec SP_Reconcile_Gas '$brcode','$currdate_sql_format'");

$this->DataList.="<table>";
$this->DataList.="<tr>";
$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>SL</strong></td>";
$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>BrCode</strong></td>";
$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>Date</strong></td>";
$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>Total</strong></td>";
$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>ReturnID</strong></td>";
$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>TrID</strong></td>";
$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>Scroll</strong></td>";
$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>Routing No.</strong></td>";
$this->DataList.="</tr>";
while ($row_list = sqlsrv_fetch_array($result_list)) 
{
    $sl++;
    $this->DataList.="<tr>";
    $this->DataList.="<td class=row_data>$sl</td>";
    $this->DataList.="<td class=row_data>".$row_list['brcode']."</td>";
    $this->DataList.="<td class=row_data>".$row_list['vdate']."</td>";
    $this->DataList.="<td class=row_data>".$row_list['amount']."</td>";
    $this->DataList.="<td class=row_data>".$row_list['returnID']."</td>";
    $this->DataList.="<td class=row_data>".$row_list['banktrID']."</td>";
    $this->DataList.="<td class=row_data>".$row_list['scroll_no']."</td>";
    $this->DataList.="<td class=row_data>".$br_routing."</td>";
    $this->DataList.="</tr>";
}
//if($sl==0){$this->DataList.="<tr>";$this->DataList.="<td class=row_data>No Missmatch</td></tr>";}
$this->DataList.="</table>";
}	





	
function elec_bill_list($tblcaption,$colHeader,$sql,$editlink,$baseroot,$conn)
	{
			$deptname='';
			$this->DataList="";
                        $billamount=0;$vat=0;$rev_stamp=0;$totalbill=0;
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			
			for ($h=0;$h < count($HeaderArray); $h++)
			{
				$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			
			$r=0;
						
			while($row_list = sqlsrv_fetch_array($result_list))
				{
                                $billamount=$billamount+$row_list[6];
                                                    $vat=$vat+$row_list[7];
                                                    $rev_stamp=$rev_stamp+$row_list[8];
                                                    $totalbill=$totalbill+$row_list[9];
					if ($r%2) 
						{$rowbg="class=data_bg"; }
				  else { $rowbg="class=data_bg_alt";}
			         	$this->DataList.="<tr $rowbg>";
				
						for($c=0; $c < $col; $c++) 
                                {
                                                    
										if($c==11)
											{
											$this->DataList.="<td class=row_data><a href='elc_bill_receive.php/".$row_list[11]."';>Edit</a></td>";
											}
										else if($c==12)
											{
											 $this->DataList.="<td class=row_data><span id='ctlno$r' class='error'><a href='javascript:void(0)' onclick=\"ele_delete('ctlno$r','".$row_list[11]."','".$row_list[13]."','".$row_list[10]."','".$row_list[15]."','".$row_list[0]."','$baseroot')\">Delete</a></span></td>";    
											}
										else
											{
												$this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
											}
	
								} 
								
					$this->DataList.="</tr>";
					$r++;
				}
                                $this->DataList.="<tr >";
                                $this->DataList.="<td class=mnucolor bgcolor='#23559c' colspan=6><strong>Grand Total</strong></td>";
                                $this->DataList.="<td class=mnucolor bgcolor='#23559c'>".$billamount."</td>";
                                $this->DataList.="<td class=mnucolor bgcolor='#23559c'>".$vat."</td>";
                                $this->DataList.="<td class=mnucolor bgcolor='#23559c'>".$rev_stamp."</td>";
                                $this->DataList.="<td class=mnucolor bgcolor='#23559c' colspan=4>".$totalbill."</td>";
                                $this->DataList.="<tr>";
			$this->DataList.="</table>";
			   
		sqlsrv_free_stmt( $result_list);			
	}

function elec_bill_recon($sql,$baseroot,$conn)
	{
			$deptname='';
			$this->DataList="";
			
			$col=12;		
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";
			$this->DataList.="<tr>";// Print Column Header start				
			$this->DataList.="</tr>"; //Print Column Header end
			$result_list = sqlsrv_query($conn,$sql);
			
			$r=0;
			$total_bill=0;
			$tot_vat=0;
			$tot_sur_amt=0;
			$tot_amt=0;
			$net_amnt=0;
			
			while($row_list = sqlsrv_fetch_array($result_list))
				{	
					if ($r%2) 
						{$rowbg="class=data_bg"; }
				  else { $rowbg="class=data_bg_alt";}
			         	$this->DataList.="<tr $rowbg>";
				
						for($c=0; $c < $col; $c++) 
                                {

								if($c==6)
									{
									$total_bill = $total_bill + $row_list[6];		
									}
									
									
								if($c==7)
									{
									$tot_vat = $tot_vat + $row_list[7];		
									}	
								

								if($c==9)
									{
									$tot_amt = $tot_amt + $row_list[9];		
									}	
									
								if($c==8)
									{
									$tot_sur_amt = $tot_sur_amt + $row_list[8];		
									}

								}
								
					$this->DataList.="</tr>";
					$r++;
				}
				
			$net_amnt = $total_bill - $tot_sur_amt;	
			
			$this->DataList.="<tr><td colspan=$col><strong>Total Bill Amount: ".$total_bill."</strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong>Total Vat Amount: ".$tot_vat."</strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong>Total Amount: ".$tot_amt."</strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong>Total Rev Stamp Amount: ".$tot_sur_amt."</strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong>Total Net Bill Amnt: ".$net_amnt."</strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong>Total Transaction: ".$r."</strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong></strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong></strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong></strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong></strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong></strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong></strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong></strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong></strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong></strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong></strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong></strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong></strong></td></tr>";
			
			$this->DataList.="</table>";
			   
		sqlsrv_free_stmt( $result_list);			
	}	
	
	
	function gas_bill_recon($sql,$baseroot,$conn)
	{
			$deptname='';
			$this->DataList="";
			
			$col=12;		
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";
			$this->DataList.="<tr>";// Print Column Header start				
			$this->DataList.="</tr>"; //Print Column Header end
			$result_list = sqlsrv_query($conn,$sql);
			
			$r=0;
			$total_bill=0;
			$tot_sur_amt=0;
			$tot_amt=0;
			$tot=0;
			
			
			while($row_list = sqlsrv_fetch_array($result_list))
				{	
					$total_bill=$row_list["bill_amount"];
					$tot_sur_amt=$row_list["surcharge_amount"];
					$tot_amt=$row_list["total_amount"];
					$tot=$row_list["total"];
				}
				
						
			$this->DataList.="<tr><td colspan=$col><strong>Total No of Bill : ".$tot."</strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong>Total Bill Amount : ".$total_bill."</strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong>Total Surcharge Amount : ".$tot_sur_amt."</strong></td></tr>";
			$this->DataList.="<tr><td colspan=$col><strong>Total Amount : ".$tot_amt."</strong></td></tr>";
							
			
			$this->DataList.="</table>";
			   
		sqlsrv_free_stmt( $result_list);			
	}	
	
function elec_bill_recon_bubsrv($sql,$baseroot,$conn)
{
//$sql="exec bpdb_sp_dataview_from_spserver '$acc_no','$bill_year','$bill_month','$branch_code'";
//echo $sql; exit;
$result_list = sqlsrv_query($conn,$sql);
while ($row_list = sqlsrv_fetch_array($result_list)) 
{
$data = json_decode($row_list[0], true);
//	echo $data['NAME'];
}
$this->DataList="";    
    
    
			//<tr>
			  //   <td>
			//	  <strong> ORG Code: </strong>
			//	 </td>
			//  </tr>
			// <tr>
			//     <td>
			//	  <strong>Pay Date: </strong>
			//	 </td>
			//  </tr>
			//  <tr>
			//     <td>
			//	 <strong> Bank Name: </strong>
			//	 </td>
			//  </tr>
			//  <tr>
			//     <td>
			//	 <strong> Branch Name: </strong>
			//	 </td>
			//  </tr>
                        $this->DataList.="<table>";
			$this->DataList.="<tr>";
			$this->DataList.="<td><strong> ORG Principle Amount: </strong></td>";
                        $this->DataList.="<td><strong>".$data['ORG_PRINCIPLE_AMOUNT']."</strong></td>";
			$this->DataList.="</tr>";	 
			$this->DataList.="<tr>";
			$this->DataList.="<td><strong> VAT Amount: </strong></td>";
                        $this->DataList.="<td><strong>".$data['VAT_AMOUNT']."</strong></td>";
			$this->DataList.="</tr>";	
			$this->DataList.="<tr>";
			$this->DataList.="<td><strong> ORG TOT Amount: </strong></td>";
                        $this->DataList.="<td><strong>".$data['ORG_TOTAL_AMOUNT']."</strong></td>";
			$this->DataList.="</tr>";
			$this->DataList.="<tr>";
			$this->DataList.="<td><strong> Revenue Stamp: </strong></td>";
                        $this->DataList.="<td><strong>".$data['REVENUE_STAMP_AMOUNT']."</strong></td>";
			$this->DataList.="</tr>";	
			$this->DataList.="<tr>";
			$this->DataList.="<td><strong> NET ORG AMNT: </strong></td>";
                        $this->DataList.="<td><strong>".$data['NET_ORG_AMOUNT']."</strong></td>";
			$this->DataList.="</tr>";
			$this->DataList.="<tr>";
			$this->DataList.="<td><strong> Total Tran: </strong></td>";
                        $this->DataList.="<td><strong>".$data['TOTAL_TRANS']."</strong></td>";
			$this->DataList.="</tr>";			  
                        $this->DataList.="</table>";
        
}

function elec_bill_recon_bubsrv_detail($tblcaption,$colHeader,$sql,$baseroot,$conn)
{
//$sql="exec bpdb_sp_dataview_from_spserver '$acc_no','$bill_year','$bill_month','$branch_code'";
//echo $sql;// exit;
$result_list = sqlsrv_query($conn,$sql);
while ($row_list = sqlsrv_fetch_array($result_list)) 
{
$data = json_decode($row_list[0], true);
//	echo $data['NAME'];
}
$df=count($data);
//echo "Count ".$df;
//$ArrayBill=explode(",",$data[0]);
//$billno=count($ArrayBill);
//echo "TEST".$data[1];
//echo "<pre>";
$rowcount=0;$tr_id="";
$this->DataList.="<table>";
    
	  
	$this->DataList.="<tr>";
	$this->DataList.="<td class=mnucolor bgcolor='#23559c'>Consumer No from BUB";
	$this->DataList.="<td class=mnucolor bgcolor='#23559c'>Transaction ID from BUB";
	$this->DataList.="<td class=mnucolor bgcolor='#23559c'>Request ID from BUB";
	$this->DataList.="<td class=mnucolor bgcolor='#23559c'>Total Amount from BUB";
   
	$this->DataList.="<td class=mnucolor bgcolor='#23559c'>Consumer No";
	$this->DataList.="<td class=mnucolor bgcolor='#23559c'>Transaction ID";
	$this->DataList.="<td class=mnucolor bgcolor='#23559c'>Request ID";
	$this->DataList.="<td class=mnucolor bgcolor='#23559c'>Total Amount";
    $this->DataList.="</td>"; 
	
  

while ($rowcount!=count($data))
{
    $this->DataList.="<tr>";
    $this->DataList.="<td>";$this->DataList.=$data[$rowcount]["CONSUMER_NO"];$this->DataList.="</td>";
    $this->DataList.="<td>";$this->DataList.=$data[$rowcount]["BANK_TRANS_ID"];$this->DataList.="</td>";
    $this->DataList.="<td>";$this->DataList.=$data[$rowcount]["MBP_TRANS_ID"];$this->DataList.="</td>";
    $this->DataList.="<td>";$this->DataList.=$data[$rowcount]["TOTAL_AMOUNT"];$this->DataList.="</td>";
	
	
	$consum_no=$data[$rowcount]["CONSUMER_NO"];
	$tr_id=$data[$rowcount]["BANK_TRANS_ID"];
	$consum_id=$data[$rowcount]["MBP_TRANS_ID"];
	$total_amnt=$data[$rowcount]["TOTAL_AMOUNT"];
	
	//$sql="exec create_temp_table"; 
	//echo $sql; exit;
	$table_name ='temp_table';
	$field_name = "consumer_no,transaction_id,consumer_id,total_amount,BranchCode,loginid,tr_date";
	$values_data="?,?,?,?,?,?,?";
	$arrays_data=array($consum_no,$tr_id,$consum_id,$total_amnt,$branch_code,$loginuserid,$currdate_sql_format);
	$InsertClass->insert_data($field_name,$values_data,$arrays_data,$table_name,$conn);
	
	
    
    // DATA RETRIVE FROM DATA SERVER
    //$tr_id=$data[$rowcount]["BANK_TRANS_ID"];
    $result_list_dataserver = sqlsrv_query($conn,"select consumer_no,transaction_id,consumer_id,total_amount from tbl_daytrans_ele
    where transaction_id='$tr_id'");
    $row_list_dataserver = sqlsrv_fetch_array($result_list_dataserver); 
    $this->DataList.="<td>";$this->DataList.=$row_list_dataserver["consumer_no"];$this->DataList.="</td>";
    $this->DataList.="<td>";$this->DataList.=$row_list_dataserver["transaction_id"];$this->DataList.="</td>";
    $this->DataList.="<td>";$this->DataList.=$row_list_dataserver["consumer_id"];$this->DataList.="</td>";
    $this->DataList.="<td>";$this->DataList.=$row_list_dataserver["total_amount"];$this->DataList.="</td>";
    // DATA RETRIVE FROM DATA SERVER
    $this->DataList.="</tr>";
    $rowcount++;
}
$this->DataList.="</table>";

        
}

function elec_bill_recon_detail_report($tblcaption,$colHeader,$sql,$editlink,$baseroot,$conn)
	
	{
			$deptname='';
			$this->DataListRecon="";
                      //  $billamount=0;$vat=0;$rev_stamp=0;$totalbill=0;
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
			$this->DataListRecon.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";

          	$this->DataListRecon.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataListRecon.="<tr>";// Print Column Header start
			
			for ($h=0;$h < count($HeaderArray); $h++)
			{
				$this->DataListRecon.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			
			$this->DataListRecon.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			
			//echo $sql; exit;
			$r=0;$billamount_bub=0;$billamount_srv=0;
						
			while($row_list = sqlsrv_fetch_array($result_list))
				{
                                if($row_list[4]!=""){$billamount_bub=$billamount_bub+$row_list[4];}else{$billamount_bub=$billamount_bub+0;}
                                if($row_list[9]!=""){$billamount_srv=$billamount_srv+$row_list[9];}else{$billamount_srv=$billamount_srv+0;}
                                //$billamount_bub=$billamount_bub+$row_list[3];
                                //$billamount_srv=$billamount_srv+$row_list[8];
					if ($r%2) 
						{$rowbg="class=data_bg"; }
				  else { $rowbg="class=data_bg_alt";}
			         	$this->DataListRecon.="<tr $rowbg>";
				
						for($c=0; $c < $col; $c++) 
                                                {
                                                    
							if($c==10)
							{
                                                            if($row_list[5]=="")
                                                            {
                                                                $this->DataListRecon.="<td class=row_data><span id='ctlno$r' class='error'><a href='javascript:void(0)' onclick=\"ele_delete_recon('ctlno$r','".$row_list[2]."','".$row_list[3]."','$baseroot')\">Delete</a></span></td>";
                                                            }
                                                            if($row_list[0]=="")
                                                            {
                                                                $this->DataListRecon.="<td class=row_data><span id='ctlno$r' class='error'><a href='javascript:void(0)' onclick=\"ele_delete_recon_local('ctlno$r','".$row_list[7]."','".$row_list[8]."','$baseroot')\">DELETE</a></span></td>";
                                                            }
							}
							/*else if($c==11)
							{
							 $this->DataListRecon.="<td class=row_data><span id='ctlno$r' class='error'><a href='javascript:void(0)' onclick=\"ele_delete_recon('ctlno$r','".$row_list[11]."','".$row_list[13]."','".$row_list[10]."','".$row_list[15]."','".$row_list[0]."','$baseroot')\">Delete</a></span></td>";    
							}*/
							else
							{
							 $this->DataListRecon.="<td class=row_data>".$row_list[$c]."</td>";									
							}
	
						} 
								
					$this->DataListRecon.="</tr>";
					$r++;
				}
                                $this->DataListRecon.="<tr >";
                                $this->DataListRecon.="<td class=mnucolor bgcolor='#23559c' colspan='4'><strong>Grand Total</strong></td>";
                                $this->DataListRecon.="<td class=mnucolor bgcolor='#23559c' colspan='5'>".$billamount_bub."</td>";
                                $this->DataListRecon.="<td class=mnucolor bgcolor='#23559c' colspan='2'>".$billamount_srv."</td>";
                                $this->DataListRecon.="<tr>";
			$this->DataListRecon.="</table>";
			   
		sqlsrv_free_stmt( $result_list);			
	}


function gas_bill_recon_titas($sql,$baseroot,$conn)
{
$data="";
$result_list = sqlsrv_query($conn,$sql);
while ($row_list = sqlsrv_fetch_array($result_list)) 
{
$data = json_decode($row_list[0], true);
	//echo $data['data'];
}
$r=0;$titas_total_amount=0;
$titas_surcharge=0;$titas_amount=0;
while($r!=count($data['data']))
{

$titas_total_amount+=$data['data'][$r]['total'];
$titas_surcharge+=$data['data'][$r]['surcharge'];
$titas_amount+=$data['data'][$r]['amount'];	
$r++;	
}
$this->titasDataCount="";
$this->titasDataCount=count($data['data']);
}

function gas_bill_recon_titas_summary($currDate,$baseroot,$conn)
{

$this->DataList="";    
$this->DataList.="<table>";
    $this->DataList.="<tr>";
    $this->DataList.="<td><strong>Brcode</strong></td>";
    $this->DataList.="<td><strong>Routing No</strong></td>";
    $this->DataList.="<td><strong>TITAS</strong></td>";
    $this->DataList.="<td><strong>BRANCH</strong></td>";
    $this->DataList.="</tr>";	 
        
    
//$sqlbub="exec titash_daily_payment '0085','$brRouting','$currDate'";    
$sqlbr="SELECT distinct(a.BranchCode),b.br_routing_number FROM tbl_daytrans_gas a
inner join [172.17.20.57].[dbjbwebremitt].[dbo].[Branch] b on a.BranchCode=b.BranchCode
where tr_date='$currDate' and pay_status='A'";
$data="";$r=0;
//echo $sqlbr;//exit;
$currDate_titas=date("d/m/Y",strtotime($currDate));
$result_list_br = sqlsrv_query($conn,$sqlbr);
while ($row_list_br = sqlsrv_fetch_array($result_list_br)) 
{
    $BRCODE=$row_list_br['BranchCode'];
    $ROUTING=$row_list_br['br_routing_number'];
    //$this->DataList.="<tr>";
    //$this->DataList.="<td>".$row_list_br['BranchCode']."</td>";
    //$this->DataList.="<td>".$row_list_br['br_routing_number']."</td>";
    //--------------------------------------Titas Data----------------------------//
    $sqltitas="exec titash_daily_payment '$BRCODE','$ROUTING','$currDate_titas'";
    //echo $sqltitas;
    $result_list = sqlsrv_query($conn,$sqltitas);
    while ($row_list = sqlsrv_fetch_array($result_list)) 
    {
    $data = json_decode($row_list[0], true);
    }
    $dtcount=count($data['data']);
    $query="insert into titas_recon_tbl (brcode,br_routing_number,vdate,count_bill) values ('$BRCODE','$ROUTING','$currDate','$dtcount')";
    $stmt1 = sqlsrv_query($conn,$query);
    sqlsrv_free_stmt($stmt1);
    //$this->DataList.="<td>".count($data['data'])."</td>";
//----------------------------------------end of Titas Data----------------------//
    //$sqlbillbr="select COUNT(consumer_no)Bill from tbl_daytrans_gas where tr_date='$currDate' and BranchCode='$BRCODE' and pay_status='A'";
    //$result_list_bill_br = sqlsrv_query($conn,$sqlbillbr);
    
    //while($row_list_bill_br=sqlsrv_fetch_array($result_list_bill_br))
    //{
    //     $this->DataList.="<td>".$row_list_bill_br['Bill']."</td>";
    //}
    //$this->DataList.="</tr>";
    //$r++;
}
$this->DataList.="</table>";
$titas_total_amount=0;
$titas_surcharge=0;$titas_amount=0;
       
}

//----------------------Wasa DataView------------------------//
function wasa_bill_list($tblcaption,$colHeader,$sql,$editlink,$baseroot,$conn){
//echo $sql;
			$deptname='';
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";
                        $this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";
                        $this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			$total_bill=0;
			while($row_list = sqlsrv_fetch_array($result_list)){	
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
                        $this->DataList.="<tr $rowbg>";
				for($c=0; $c < $col; $c++) 
                                {
                                    if ($c==7) 
                                    {
                                    //$this->DataList.="<td class=row_data><a href='gas_bill_receive.php/".$row_list[10]."';>Delete</a></td>";							 
                                    $this->DataList.="<td class=row_data><span id='ctlno$r' class='error'><a href='javascript:void(0)' onclick=\"wasa_delete('ctlno$r','".$row_list[9]."','".$row_list[11]."','".$row_list[8]."','".$row_list[12]."','".$row_list[0]."','".$row_list[5]."','$brRouting','$baseroot')\">Delete</a></span></td>";        
                                    }
                                    else
                                    {
                                        $this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
                                    }
                                 }
		 	$this->DataList.="</tr>";
			$r++;
			}

   //	$this->DataList.="<tr><td colspan=$col><strong>Total Bill : ".$total_bill."</strong></td></tr>";

       $this->DataList.="</table>";
sqlsrv_free_stmt( $result_list);			
	}
//----------------------end of Wasa DataView----------------//

function gas_bill_list($tblcaption,$colHeader,$sql,$editlink,$brRouting,$baseroot,$conn){
//echo $sql;
			$deptname='';
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			$total_bill=0;
			while($row_list = sqlsrv_fetch_array($result_list)){	
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          	$this->DataList.="<tr $rowbg>";
				
				for($c=0; $c < $col; $c++) 
                                {
                                    if ($c==9) 
                                    {
                                    //$this->DataList.="<td class=row_data><a href='gas_bill_receive.php/".$row_list[10]."';>Delete</a></td>";							 
                                    $this->DataList.="<td class=row_data><span id='ctlno$r' class='error'><a href='javascript:void(0)' onclick=\"gas_delete('ctlno$r','".$row_list[9]."','".$row_list[11]."','".$row_list[8]."','".$row_list[12]."','".$row_list[0]."','".$row_list[5]."','$brRouting','$baseroot')\">Delete</a></span></td>";        
                                    }
                                    else
                                    {
                                        $this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
                                    }
if($c==7)
{
$total_bill = $total_bill + $row_list[7];		
}
				}
		 	$this->DataList.="</tr>";
			$r++;
			}

   //	$this->DataList.="<tr><td colspan=$col><strong>Total Bill : ".$total_bill."</strong></td></tr>";

       $this->DataList.="</table>";
sqlsrv_free_stmt( $result_list);			
	}
function telephone_bill_list($tblcaption,$colHeader,$sql,$editlink,$baseroot,$conn){
			$deptname='';
			$this->DataList="";
			$HeaderArray=explode(",",$colHeader);
			$col=count($HeaderArray);
			$this->DataList.="<table  width=100% class=msgbox border=0 cellpadding=3 cellspacing=0>";

          	$this->DataList.="<tr class=tbg><td colspan=$col><strong>$tblcaption</strong></td></tr>";

			$this->DataList.="<tr>";// Print Column Header start
			for ($h=0;$h < count($HeaderArray); $h++) {
			$this->DataList.="<td class=mnucolor bgcolor='#23559c'><strong>".$HeaderArray[$h]."</strong></td>";
			}
			$this->DataList.="</tr>"; //Print Column Header end
			
			$result_list = sqlsrv_query($conn,$sql);
			$r=0;
			$total_bill=0;
			while($row_list = sqlsrv_fetch_array($result_list)){	
			if ($r%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
          	$this->DataList.="<tr $rowbg>";
				
				for($c=0; $c < $col; $c++) 
                                {
                                    if($c==7)
                                    {
                                    $this->DataList.="<td class=row_data><a href='tel_bill_receive.php/".$row_list[7]."';>Edit</a></td>";
                                    }
                                    else if($c==8)
                                    {
                                    //$this->DataList.="<td class=row_data><a href='tel_bill_receive.php/".$row_list[7]."';>Delete</a></td>";
                                    $this->DataList.="<td class=row_data><span id='ctlno$r' class='error'><a href='javascript:void(0)' onclick=\"tel_delete('ctlno$r','".$row_list[7]."','".$row_list[9]."','".$row_list[6]."','".$row_list[10]."','".$row_list[11]."','".$row_list[12]."','$baseroot')\">Delete</a></span></td>";
                                        
                                    }
                                    else
                                    {
                                        $this->DataList.="<td class=row_data>".$row_list[$c]."</td>";									
                                    }
if($c==5)
{
$total_bill = $total_bill + $row_list[5];		
}

				}
		 	$this->DataList.="</tr>";
			$r++;
			}
   	$this->DataList.="<tr><td colspan=$col><strong>Total Bill : ".$total_bill."</strong></td></tr>";

       $this->DataList.="</table>";
sqlsrv_free_stmt( $result_list);			
	}        



function extractadvicelist($advicetype,$pur_id,$thisbranch,$userdeptcode,$otherbranch,$trcode,$startdate,$userid,$conn) {
global $voucher;
$this->voucher='';
$trdate=date("Y-m-d",strtotime($startdate));
$this->voucher.="<table width='100%' border=1 cellpadding=3  cellspacing=2 bordercolor='#CCCCCC'>";
$this->voucher.="<tr>";
$this->voucher.="<td class=mnucolor bgcolor='#23559c'><div align='left'>Date</div></td>";
$this->voucher.="<td class=mnucolor bgcolor='#23559c'><div align='left'>Code</div></td>";
$this->voucher.="<td class=mnucolor bgcolor='#23559c'><div align='left'>Branch Name</div></td>";
$this->voucher.="<td class=mnucolor bgcolor='#23559c'><div align='left'>Advice No</div></td>";
$this->voucher.="<td class=mnucolor bgcolor='#23559c'><div align='left'>Beneficiary</div></td>";
$this->voucher.="<td class=mnucolor bgcolor='#23559c'><div align='left'>A/C No</div></td>";
$this->voucher.="<td class=mnucolor bgcolor='#23559c'><div align='left'>Instrument</div></td>";
$this->voucher.="<td class=mnucolor bgcolor='#23559c'><div align='right'>Amount</div></td>";
$this->voucher.="</tr>";
$sql="exec proc_extractadvice_list '$advicetype','$pur_id','$thisbranch','$otherbranch','$trcode','$trdate','$userdeptcode','$userid'";
//echo $sql;
$result = sqlsrv_query($conn,$sql);
$i=0;
$totalamount = 0;
while ($row=sqlsrv_fetch_array($result)) {
if ($i%2) {$rowbg="class=data_bg"; } else { $rowbg="class=data_bg_alt";}
$this->voucher.="<tr id='ctlno$i' $rowbg>";
$this->voucher.="<td><div align='left'>".date_format($row['trdate'],"d M Y")."</div></td>";
$this->voucher.="<td><div align='left'>".$row['brcode']."</div></td>";
$this->voucher.="<td><div align='left'>".$row['BranchName']."</div></td>";
$this->voucher.="<td><div align='left'>".$row['adviceno']."</div></td>";
$this->voucher.="<td><div align='left'>".$row['beneficiaryname']."</div></td>";
$this->voucher.="<td><div align='left'>".$row['beneficiaryaccount']."</div></td>";
$this->voucher.="<td><div align='left'>".$row['instrumentno']."</div></td>";
$this->voucher.="<td><div align='right'>".$this->moneyformat($row['org_amount'])."</div></td>";
$totalamount = $totalamount + $row['org_amount'];
$this->voucher.="</tr>";
$i++;
}

$this->voucher.="<tr>";
$this->voucher.="<td colspan='4' class=mnucolor bgcolor='#23559c'><div align='left'>Total Advice:  ".$i."</div></td>";
$this->voucher.="<td colspan='4' class=mnucolor bgcolor='#23559c'><div align='right'>Total Amount:  ".$this->moneyformat($totalamount)."</div></td>";
$this->voucher.="</tr>";

$this->voucher.="</td></tr>";
$this->voucher.="</table>";
sqlsrv_free_stmt( $result);			
}

//Pagination
function pagination ($PageSize,$pagelink,$getpageno,$conn) {
//Set the page size
//$PageSize = 2;
    $this->newlink='';
$StartRow = 0;

//Set the page no
if(empty($getpageno)){
    if($StartRow == 0){
        $PageNo = $StartRow + 1;
    }
}else{
    $PageNo = $getpageno;
    $StartRow = ($PageNo - 1) * $PageSize;
}

//Set the counter start
if($PageNo % $PageSize == 0){
    $CounterStart = $PageNo - ($PageSize - 1);
}else{
    $CounterStart = $PageNo - ($PageNo % $PageSize) + 1;
}

//Counter End
$CounterEnd = $CounterStart + ($PageSize - 1);

 $TRecord = sqlsrv_query($conn,$this->sql,array(),array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));

 //Total of record
 $RecordCount = sqlsrv_num_rows($TRecord);

 //Set Maximum Page
 $MaxPage = $RecordCount % $PageSize;
 if($RecordCount % $PageSize == 0){
    $MaxPage = $RecordCount / $PageSize;
 }else{
    $MaxPage = ceil($RecordCount / $PageSize);
 }
;
//echo $MaxPage;

        //Print First & Previous Link is necessary
        if($CounterStart != 1){
            $PrevStart = $CounterStart - 1;
            $this->newlink.= "<a href=".$pagelink."/1>First </a>: ";
            $this->newlink.= "<a href=".$pagelink."/$PrevStart>Previous </a>";
        }
        $this->newlink.= " [ ";
        $c = 0;

        //Print Page No
        for($c=$CounterStart;$c<=$CounterEnd;$c++){
		
            if($c < $MaxPage){
                if($c == $PageNo){
                    if($c % $PageSize == 0){
                        $this->newlink.= "<span class='error'>$c</span> ";
                    }else{
                        $this->newlink.= "<span class='error'>$c</span> , ";
                    }
                }elseif($c % $PageSize == 0){
                    $this->newlink.= "<a href=".$pagelink."/$c>$c</a> ";
                }else{
                    $this->newlink.= "<a href=".$pagelink."/$c>$c</a> , ";
                }//END IF
            }else{
                if($PageNo == $MaxPage){
                    $this->newlink.= "<span class='error'>$c</span> ";
                    break;
                }else{
                    $this->newlink.= "<a href=".$pagelink."/$c>$c</a> ";
                    break;
                }//END IF
            }//END IF
       }//NEXT

      $this->newlink.= "] ";

      if($CounterEnd < $MaxPage){
          $NextPage = $CounterEnd + 1;
          $this->newlink.= "<a href=".$pagelink."/$NextPage>Next</a>";
      }
      
      //Print Last link if necessary
      if($CounterEnd < $MaxPage){
       $LastRec = $RecordCount % $PageSize;
        if($LastRec == 0){
            $LastStartRecord = $RecordCount - $PageSize;
        }
        else{
            $LastStartRecord = $RecordCount - $LastRec;
        }

        $this->newlink.= " : ";
        $this->newlink.= "<a href=".$pagelink."/$MaxPage>Last</a>";
        }

return $this->newlink;
}

	//end class
	
}

?>
