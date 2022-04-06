document.onkeydown = function() {    
    switch (event.keyCode) { 
        case 116 : //F5 button
            event.returnValue = false;
            event.keyCode = 0;
            return false; 
        case 82 : //R button
            if (event.ctrlKey) { 
                event.returnValue = false; 
                event.keyCode = 0;  
                return false; 
            } 
    }
};

var xmlhttp;
//With form required
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

//Without form required field
function value_required(field,alerttxt)
{

  if (field==null||field=="")
    {
    alert(alerttxt);return false;
    }
  else
    {
    return true;
    }
  
}

function errortextbox(mnutable,triggerLink,show) {
  dataTable = document.getElementById(mnutable);

  dataTabletRows = dataTable.getElementsByTagName('TR');
  for (i = 0; i < dataTabletRows.length; i++) {
    currentRow = dataTabletRows[i];
    if (currentRow.className.indexOf(triggerLink) != -1) {
      errortoggle(currentRow,show);
    }
  }
document.getElementById('txterror').value='';
}

function errortoggle(item,show) {
  if (show == 'H') {
    item.style.display = 'none';
    opening = false;
  } else {
    item.style.display = '';
    opening = true;
  }
}
function descerrors(descvalue) {
document.getElementById('txterror').value=descvalue;
}
//New LoginID
function get_module(getmodule,baseroot){
	//document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jr_lib/jbsol_module.php";
	url=url+"/"+getmodule+"/";   

	window.open(url,"_self");

}

function userlist(ctlName,usertype,baseroot){
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>';
	var branchcode = document.getElementById('txtbranchcode').value;
	
	var xmlHttp = GetXmlHttpObject();     
	var url="../jbpe_lib/getaccount.php";
	url=url+"/userlist/"+usertype+"/"+branchcode+"/xyz/xyz/";  
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function branchdetails(ctlName,accounttype,branchcode,brcode,baseroot){
//alert(baseroot);
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>';
	var xmlHttp = GetXmlHttpObject();     
	var url="../jbbill_lib/getaccount.php/"+accounttype+"/"+branchcode+"/"+baseroot+"/xyz/xyz/xyz";
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function show_spzone(ctlName,ctlZone,spzone,sp_code,baseroot){
//alert(baseroot);
if(ctlZone=='N')
{
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php/"+"SPZONE"+"/"+sp_code+"/"+baseroot+"/xyz/xyz/xyz";
        //alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}
else
{
        //alert(baseroot);
        document.getElementById(ctlZone).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php/"+spzone+"/"+ctlZone+"/"+sp_code+"/"+baseroot+"/xyz/xyz/xyz";
        //alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlZone).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}
}

function showzonePrefix(ctlName,spzonecode,baseroot)
{
        //alert(ctlName+"spcode: "+spcode+"_"+baseroot);
        document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>';
	var xmlHttp = GetXmlHttpObject();
        var url=baseroot+"/jbbill_lib/getaccount.php";
	var url=url+"/PREFIX/"+spzonecode+"/xyz/xyz/xyz";
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function zone_prefix_delete(ctlName,spzonecode,baseroot)
{
        //alert(ctlName+"spcode: "+spzonecode+"_"+baseroot);
        document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>';
	var xmlHttp = GetXmlHttpObject();
        var url=baseroot+"/jbbill_lib/getaccount.php";
	var url=url+"/PREFIXDEL/"+spzonecode+"/xyz/xyz/xyz";
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function service_provider_details(ctlName,Servicestatus,service_type,baseroot){
//alert(baseroot);
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>';
	var xmlHttp = GetXmlHttpObject();     
	var url="../jbbill_lib/getaccount.php/"+Servicestatus+"/"+service_type+"/"+baseroot+"/xyz/xyz/xyz";
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function showbranchzone(ctlName,providercode,scrolltype,brcode,baseroot){
		//alert(document.getElementById(ctlName));
	//alert(providercode+brcode+baseroot+""+ctlName);
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/SHOWBRZONE/"+providercode+"/"+scrolltype+"/"+brcode+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function showbrscrolltype(ctlName,brcode,baseroot){
		//alert(brcode);
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/SCROLLTYPE"+"/"+brcode+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function spzone_br_delete(ctlName,brcode,spcode,spzone,baseroot){
	//alert(brcode+"spcode"+spcode+"spzone"+spzone);	
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/DELSPZONEBR"+"/"+brcode+"/"+spcode+"/"+spzone+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function spzone_delete(ctlName,spzone,spcode,baseroot){
	//alert(brcode+"spcode"+spcode+"spzone"+spzone);	
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php/";
	url=url+"DELSPZONE"+"/"+spzone+"/"+spcode+"/"+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function spzonebr_chk(ctlname,scrolltype,brcode,baseroot){
	//alert(accountType);
	//alert(document.getElementById(ctlname));
	//alert(scrolltype);
        //alert(ctlname);
	var totalnobooks=0;
	var cboxes = document.getElementsByName('chkconfirm');
        var lb_zoneid = document.getElementsByName('lb_zoneid');
        var lb_spcode=document.getElementsByName('lb_spcode');
        var txt_accounts=document.getElementsByName('txt_accounts');
        var txt_vat=document.getElementsByName('txt_vat');
	//var txtnobooks = document.getElementsByName('txtno_books');
	//var lb_reqno = document.getElementsByName('lb_reqno');
	//var lbtotalbooks=document.getElementById('lb_totalnobooks').innerHTML;
	//var lb_brcode=document.getElementsByName('lb_brcode');span_nobooks
	//var span_nobooks=document.getElementsByName('span_nobooks');
        //var wc='';
	//alert(span_nobooks);
	/*if(accountType!='6')
	{
		if((lbtotalbooks%12!=0) || (lbtotalbooks==0))
		{alert('Requisition is not well formate');return;
		}
		else
		{
		//alert('working');
		wc='a';
		}
	}
	else if(accountType=='6')
	{
		if((lbtotalbooks%10!=0) || (lbtotalbooks==0)){alert('Requisition is not well formate'); return;}
		else
		{
		//alert('working');
		wc='a';
		}
	}*/
	
	//alert(wc);
	
	var len = cboxes.length;
	var lb_reqArray='';
	
	for(var i=0; i<len; i++) 
		{
                    if(cboxes[i].checked==true)
			{
						var zone_id=lb_zoneid[i].innerHTML;
                        var spcode=lb_spcode[i].innerHTML
                        var accounts=txt_accounts[i].value
                        var vat=txt_vat[i].value
                        //alert(accounts+"vat:"+vat);
                        var xmlHttp = GetXmlHttpObject();     
			var url=baseroot+"/jbbill_lib/getaccount.php";
			url=url+"/SPZONEBRCK/"+brcode+"/"+scrolltype+"/"+spcode+"/"+zone_id+"/"+accounts+"/"+vat+"/xyz/xyz/";    
			//alert(url);
			if (!xmlHttp){          
			 alert ("Browser does not support HTTP Request")          
			 return     
			 }   
				xmlHttp.onreadystatechange=function(){     
				 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
				 document.getElementById(ctlname).innerHTML=xmlHttp.responseText;
				 //txtnobooks[i].innerHTML=xmlHttp.responseText;
				 //alert(xmlHttp.responseText);
				 }     
			};     
			 xmlHttp.open("GET", url, true);     
			 xmlHttp.send(null);
			}
		}
}

function showzone(ctlName,providercode,zonecode,brcode,all,baseroot){
		//alert(document.getElementById(ctlName));
	//alert(providercode+brcode+baseroot+""+ctlName);
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/SHOWZONE/"+providercode+"/"+brcode+"/"+zonecode+"/"+all+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function showgasbill(ctlName,consumercode,routing_no,br_code,baseroot){
                //alert(ctlName+consumercode+routing_no);
        
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/SHOWGASBILL/"+consumercode+"/"+routing_no+"/"+br_code+"/xyz/xyz/"+Math.random();  
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
        		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}


function showwasabill(ctlName,bill_no,br_code,baseroot){
                //alert(bill_no);
        
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/SHOWWASABILL/"+bill_no+"/"+br_code+"/xyz/xyz/"+Math.random();  
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
        		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function showReconcileGas(ctlName,br_code,baseroot){
                //alert(ctlName+br_code+baseroot);
        
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/RECONGASBILL/"+br_code+"/"+"/xyz/xyz/"+Math.random();  
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
        		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
} 

function gas_delete(ctlName,slno,spcode,loginid,trdate,brcode,id2,brRouting,baseroot){
	
    //alert(slno+"spcode:"+spcode+"loginid:"+loginid+"trdate:"+trdate+"brcode:"+brcode+"id:"+id2+"baseroot1:"+brRouting+"routing");
    document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Uploading . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/UTILDEL_GAS/"+slno+"/"+spcode+"/"+loginid+"/"+trdate+"/"+brcode+"/"+id2+"/"+brRouting+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
    
}

// for electric bill 

function showelebillreconcile(ctlName,branch_code,tr_date,baseroot){
              //  alert(ctlName);
				       
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/SHOWRECON/"+branch_code+"/"+tr_date+"/xyz/xyz/"+Math.random(); 
	//alert(url);
	
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
        		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}


function showelebill(ctlName,acc_no,bill_month,bill_year,baseroot){
               // alert(year);
				       
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/SHOWELEBILL/"+acc_no+"/"+bill_month+"/"+bill_year+"/xyz/xyz/"+Math.random(); 
	//alert(url);
	
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
        		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

//----------------------------Wasa Library---------------------//
function wasa_delete(ctlName,billno,baseroot){
	
    //alert(slno+"spcode:"+spcode+"loginid:"+loginid+"trdate:"+trdate+"brcode:"+brcode+"id:"+id2+"baseroot1:"+brRouting+"routing");
    document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Uploading . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/UTILDEL_WASA/"+billno+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
    
}
//----------------------------Wasa Library---------------------//


function showtelbill(ctlName,telephone_no,baseroot){
                //alert(billno);
        
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/SHOWTELBILL/"+telephone_no+"//xyz/xyz/"+Math.random();  
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
        		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function showzone_Gas(ctlName,providercode,accnumber,baseroot){
		
	//alert(providercode+brcode+baseroot+""+ctlName);
        //alert(providercode);
        //alert(document.getElementById(providercode).value);
//alert("Provider:"+providercode+"_Consumer:"+accnumber+"_Base:"+baseroot);
        providercode=document.getElementById(providercode).value;
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/SHOWZONEGAS/"+providercode+"/"+accnumber+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
        		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function showzone_Tel(ctlName,providercode,accnumber,baseroot){
		
	//alert(providercode+brcode+baseroot+""+ctlName);
        //alert(providercode);
        //alert(document.getElementById(providercode).value);
//alert("Provider:"+providercode+"_Consumer:"+accnumber+"_Base:"+baseroot);
        providercode=document.getElementById(providercode).value;
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/SHOWZONETEL/"+providercode+"/"+accnumber+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
        		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function tel_delete(ctlName,slno,spcode,loginid,trdate,brcode,spmaincode,baseroot){
	
    //alert(slno+"spcode:"+spcode+"loginid:"+loginid+"trdate:"+"brcode:"+brcode+"spmaincode:"+spmaincode+"baseroot:"+baseroot);
    document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Uploading . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/UTILDEL/"+slno+"/"+spcode+"/"+loginid+"/"+trdate+"/"+brcode+"/"+spmaincode+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
    
}

function showelecbilldetails(ctlName,brcode,tr_date,baseroot){
               // alert(year);
	//alert(baseroot+brcode+tr_date);			       
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/BLDETAIL/"+brcode+"/"+tr_date+"/xyz/xyz/"+Math.random(); 
	//alert(url);
	
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
        		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}


function ele_delete(ctlName,slno,spcode,req_id,brcode,tran_id,baseroot){ //alert('dhg');exit;
	
   //alert(slno+"spcode:"+spcode+"Req_Id:"+req_id+"trdate:"+"brcode:"+brcode+"Tran_Id:"+tran_id+"baseroot:"+baseroot);
    document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Uploading . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/UTILDEL_ELC/"+slno+"/"+spcode+"/"+req_id+"/"+brcode+"/"+tran_id+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
    
}


function ele_delete_recon(ctlName,tran_id,req_id,baseroot){ 
	//alert(ctlName);
   
    document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Uploading . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/UTILDEL_ELC_RECON/"+tran_id+"/"+req_id+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
    
}


function reconcileconfirm(ctlName,org_code,pc_br_code,currdate_sql_format,baseroot){ 
	//alert(ctlName);
  
   document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Uploading . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	//alert  (url);
	url=url+"/BPDB_RECONCILE_CONFIRM/"+org_code+"/"+pc_br_code+"/"+currdate_sql_format+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
	 
	 
	 
    
}


function ele_delete_recon_local(ctlName,tran_id,req_id,baseroot){ 
	//alert(ctlName);
   
    document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Uploading . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jbbill_lib/getaccount.php";
	url=url+"/UTILDEL_ELC_RECON_LOCAL/"+tran_id+"/"+req_id+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
    
}



function show_acc_title(ctlName,brcode,acc_type,acc_number,baseroot){
	
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jreq_lib/getaccount.php";
	url=url+"/SHOWTITLE/"+brcode+"/"+acc_type+"/"+acc_number+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function show_customer_acc(ctlName,brcode,acc_title,acc_type,acc_number,baseroot){
	
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jreq_lib/getaccount.php";
	url=url+"/SHOWACC/"+brcode+"/"+acc_title+"/"+acc_type+"/"+acc_number+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function show_requisition_list(ctlName,brcode,acc_type,leafqty,acc_number,acc_title,baseroot){
	
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jreq_lib/getaccount.php";
	url=url+"/SHOWREQLIST/"+brcode+"/"+acc_type+"/"+acc_number+"/"+acc_title+"/"+leafqty+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}
function show_requisition_proc_list(ctlName,brcode,acc_type,leafqty,acc_number,acc_title,baseroot){
	
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jreq_lib/getaccount.php";
	url=url+"/SHOWREQPROCLIST/"+brcode+"/"+acc_type+"/"+acc_number+"/"+acc_title+"/"+leafqty+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function exe_requisition_proc_list(ctlName,brcode,acc_type,acc_number,acc_title,baseroot){
	
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jreq_lib/getaccount.php";
	url=url+"/EXEREQPROC/"+brcode+"/"+acc_type+"/"+acc_number+"/"+acc_title+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}




function micr_cheque_approve(ctlName,brcode,reqno,baseroot){
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Uploading . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jreq_lib/getaccount.php";
	url=url+"/REQAPPROVED/"+brcode+"/"+reqno+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}
function csd_accept(accountType,ctlname,baseroot){
	//alert(accountType);
	//alert(document.getElementById(ctlname));
	//alert(ctlname);
	var totalnobooks=0;
	var cboxes = document.getElementsByName('chkconfirm');
	var txtnobooks = document.getElementsByName('txtno_books');
	var lb_reqno = document.getElementsByName('lb_reqno');
	var lbtotalbooks=document.getElementById('lb_totalnobooks').innerHTML;
	var lb_brcode=document.getElementsByName('lb_brcode');span_nobooks
	var span_nobooks=document.getElementsByName('span_nobooks');
    var wc='';
	//alert(span_nobooks);
	if(accountType!='6')
	{
		if((lbtotalbooks%12!=0) || (lbtotalbooks==0))
		{alert('Requisition is not well formate');return;
		}
		else
		{
		//alert('working');
		wc='a';
		}
	}
	else if(accountType=='6')
	{
		if((lbtotalbooks%10!=0) || (lbtotalbooks==0)){alert('Requisition is not well formate'); return;}
		else
		{
		//alert('working');
		wc='a';
		}
	}
	
	//alert(wc);
	
	var len = cboxes.length;
	var lb_reqArray='';
	//alert(len);
	//var i=0;
	for(var i=0; i<len; i++) 
		{
			//alert(txtnobooks[i].innerHTML);
			//alert(cboxes[i].value);
			//alert(span_nobooks[i].innerHTML);
        //alert(i + (cboxes[i].checked?' checked ':' unchecked ') + cboxes[i].value);
			if(cboxes[i].checked==true && wc=='a')
			{
			 
			 //totalnobooks=totalnobooks+parseInt(txtnobooks[i].value);
//			 alert(lb_reqno[i].innerHTML);
//			 if(lb_reqArray=='')
//			 {
//			 lb_reqArray=lb_reqno[i].innerHTML;
//			 }
//			 else
//			 {
//			 lb_reqArray=lb_reqArray+','+lb_reqno[i].innerHTML; 	 
//			 }
			var req_number=lb_reqno[i].innerHTML;
			var branch_code=lb_brcode[i].innerHTML;txtnobooks
			var csd_nobook=txtnobooks[i].value;
			//document.getElementById(ctlname).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Uploading . . . ';
			var xmlHttp = GetXmlHttpObject();     
			var url=baseroot+"/jreq_lib/getaccount.php";
			//url=url+"/CSDACCEPT/"+branch_code+"/"+req_number+"/xyz/xyz/";    
			url=url+"/CSDACCEPT/"+branch_code+"/"+req_number+"/"+csd_nobook+"/xyz/xyz/";    
			//alert(url);
			if (!xmlHttp){          
			 alert ("Browser does not support HTTP Request")          
			 return     
			 }   
				xmlHttp.onreadystatechange=function(){     
				 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
				 document.getElementById(ctlname).innerHTML=xmlHttp.responseText;
				 //txtnobooks[i].innerHTML=xmlHttp.responseText;
				 //alert(xmlHttp.responseText);
				 }     
			};     
			 xmlHttp.open("GET", url, true);     
			 xmlHttp.send(null);
			}
		}
	//alert(lb_reqArray);
	lb_reqArray=lb_reqArray.split(",");
	//alert(lb_reqArray.length);
	
	
	
	
}
//function csd_accept(ctlName,brcode,reqno,baseroot){
	//document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Uploading . . . ';
//	var xmlHttp = GetXmlHttpObject();     
//	var url=baseroot+"/jreq_lib/getaccount.php";
//	url=url+"/CSDACCEPT/"+brcode+"/"+reqno+"/xyz/xyz/";    
//	//alert(url);
//	if (!xmlHttp){          
//	 alert ("Browser does not support HTTP Request")          
//	 return     
//	 }   
//	 	xmlHttp.onreadystatechange=function(){     
//		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
//		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
//		 }     
//	};     
//	 xmlHttp.open("GET", url, true);     
//	 xmlHttp.send(null);
//}

function requisition_export_list(ctlName,acc_type,baseroot){
	
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jreq_process/export.php";
	url=url+"/EXPORTDATA/"+acc_type+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function rpt_requisition_account_list(ctlName,reqstatus,brcode,acc_type,reqdate,approvdate,baseroot){
	//alert("Hi");
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jreq_lib/getaccount.php";
	url=url+"/RPTACC/"+reqstatus+"/"+brcode+"/"+acc_type+"/"+reqdate+"/"+approvdate+"/Qyz/Ryz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}


function sanction_upload_process(ctlName,uplodsl,accounttype,baseroot){
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Uploading . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/js_lib/getaccount.php";
	url=url+"/SANCUPLDPROC/"+uplodsl+"/"+accounttype+"/xyz/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function removeuploads(ctlName,uplodsl,t24,accounttype,baseroot){
	  var answer = confirm ("Are You Sure To Delete This File?")
	  if (answer) {
		  
	document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait  . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/js_lib/getaccount.php";
	url=url+"/SANCUPLDDEL/"+t24+"/"+accounttype+"/"+uplodsl+"/xyz/";    
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).style.display="none";		 
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
	  }
}



function modal_close () {
	location.href="#close";
}


function showdeveloper(baseroot){
	document.getElementById('ctlbottom').innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>';

	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jr_help/frmdevelopers.php";
        if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request");          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 	document.getElementById('ctlbottom').innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function usermanual(baseroot){
	document.getElementById('ctlbottom').innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>';

	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jr_help/usermanual.php";
        if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request");          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 	document.getElementById('ctlbottom').innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function jbrpssupport(baseroot){
	document.getElementById('ctlbottom').innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>';

	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/jr_help/support.php";
        if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request");          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 	document.getElementById('ctlbottom').innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

function downloadsoftware(baseroot){
	document.getElementById('ctlbottom').innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>';

	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+"/downloads/downloads.php";
        if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request");          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 	document.getElementById('ctlbottom').innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
}

//
	 function GetXmlHttpObject(){ 
	 var objXMLHttp=null;     
	 if (window.XMLHttpRequest){
	  objXMLHttp=new XMLHttpRequest();     
	  } else if (window.ActiveXObject){          
		objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP");     
	   }     
		return objXMLHttp;
	}


//ajax show code end
function IsCharacter(t)
{
	
var v = "0123456789.ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz(){}[],.?:@#%&*_=-+ ";

var w = "";
for (i=0; i < t.value.length; i++) {
x = t.value.charAt(i);
if (v.indexOf(x,0) != -1)
w += x;
}
t.value = w;
   }


function IsNumeric(t)
{
var v = "0123456789.";

var w = "";
for (i=0; i < t.value.length; i++) {
x = t.value.charAt(i);
if (v.indexOf(x,0) != -1)
w += x;
}
t.value = w;
   }

function IsNumericInt(t)
{
var v = "0123456789";

var w = "";
for (i=0; i < t.value.length; i++) {
x = t.value.charAt(i);
if (v.indexOf(x,0) != -1)
w += x;
}
t.value = w;
   }
function IsCharacterOnly(t)
{
var v = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz. ";

var w = "";
for (i=0; i < t.value.length; i++) {
x = t.value.charAt(i);
if (v.indexOf(x,0) != -1)
w += x;
}
t.value = w;
   }   


function checkedRadioBtn(sGroupName)
    {   
        var radios = document.getElementById(sGroupName);
alert(radios);
for (var i = 0; i < radios.length; i++) {
    if (radios[i].checked) {
        // get value, set checked flag or do whatever you need to
        value = radios[i].value;  
		//return value;
		alert(value);
    }
	}
    }


function inwords(junkVal,currname,decname,ctlinwords) {
	//alert(junkVal);
	//var junkVal=document.getElementById(amtval).value;
	var fullnumber = junkVal;
	junkVal=Math.floor(junkVal);
	var decimal = fullnumber - junkVal;
	decimal = decimal.toFixed(2);

	decimal = decimal.substring(2,4);
	var obStr_decimal=new String(decimal);
	numReversed_decimal=obStr_decimal.split("");
	actnumber_decimal=numReversed_decimal.reverse();
	var iDecimalLength=numReversed_decimal.length;
//alert(decimal.substring(2,4));
	var obStr=new String(junkVal);
	numReversed=obStr.split("");
	actnumber=numReversed.reverse();

	if(Number(junkVal) >=0){
		//do nothing
	}
	else{
		alert('wrong Number cannot be converted');
		return false;
	}
	if(Number(junkVal)==0){
		//document.getElementById(ctlinwords).innerHTML=obStr+''+'Rupees Zero Only';
		//document.getElementById(ctlinwords).innerHTML='Taka Zero Only';
		document.getElementById(ctlinwords).innerHTML=currname + ' Zero Only';

	return false;
	}
	if(actnumber.length>15){
		alert('Oops!!!! the Number is too big to covertes');
		return false;
	}

	var iWords=["Zero", " One", " Two", " Three", " Four", " Five", " Six", " Seven", " Eight", " Nine"];
	var ePlace=['Ten', ' Eleven', ' Twelve', ' Thirteen', ' Fourteen', ' Fifteen', ' Sixteen', ' Seventeen', ' Eighteen', ' Nineteen'];
	var tensPlace=['dummy', ' Ten', ' Twenty', ' Thirty', ' Forty', ' Fifty', ' Sixty', ' Seventy', ' Eighty', ' Ninety' ];

	var iWordsLength=numReversed.length;
	var totalWords="";
	var inWords=new Array();
	var finalWord="";
	var decimalwords="";
	var dec1="";
	var dec2="";
	
	j=0;
	for(i=0; i<iWordsLength; i++){
		switch(i)
		{
		case 0:
			if(actnumber[i]==0 || actnumber[i+1]==1 ) {
				inWords[j]='';
			}
			else {
				inWords[j]=iWords[actnumber[i]];
			}

				//For Decimal Start
				if (decimal>0) {
				if (decimal.substring(1,2)>0) {
					var dec1 = iWords[actnumber_decimal[0]];
				}
					if (decimal.substring(0,1)>0) {
						if (actnumber_decimal[1]==1) {
							var dec1 = '';
							if (decimal==10) {
						var dec2 = ePlace[actnumber_decimal[1]-1];
							} else {
						var dec2 = ePlace[actnumber_decimal[0]];	
							}
						} else {
						var dec2 = tensPlace[actnumber_decimal[1]];
						}
					}
				
						//var decimalwords = ' '+ currname +' And ' + dec2 + dec1 + ' Paisa Only';
						var decimalwords = ' '+ currname +' And ' + dec2 + dec1 + ' ' + decname +' Only';
						
				} else {
						var decimalwords = ' '+ currname +' Only';					
				}
				//For Decimal End
				
			inWords[j]=inWords[j] +  decimalwords ;				
			
			break;
		case 1:
			tens_complication();
			break;
		case 2:
			if(actnumber[i]==0) {
				inWords[j]='';
			}
			else if(actnumber[i-1]!=0 && actnumber[i-2]!=0) {
				inWords[j]=iWords[actnumber[i]]+' Hundred';
			}
			else {
				inWords[j]=iWords[actnumber[i]]+' Hundred';
			}
			break;
		case 3:
			if(actnumber[i]==0 || actnumber[i+1]==1) {
				inWords[j]='';
			}
			else {
				inWords[j]=iWords[actnumber[i]];
			}
			if(actnumber[i+1] != 0 || actnumber[i] > 0){
				inWords[j]=inWords[j]+" Thousand";
			}
			break;
		case 4:
			tens_complication();
			break;
		case 5:
			if(actnumber[i]==0 || actnumber[i+1]==1) {
				inWords[j]='';
			}
			else {
				inWords[j]=iWords[actnumber[i]];
			}
			if(actnumber[i+1] != 0 || actnumber[i] > 0){
				inWords[j]=inWords[j]+" Lac";
			}
			break;
		case 6:
			tens_complication();
			break;
		case 7:
			if(actnumber[i]==0 || actnumber[i+1]==1 ){
				inWords[j]='';
			}
			else {
				inWords[j]=iWords[actnumber[i]];
			}
			inWords[j]=inWords[j]+" Crore";
			break;
		case 8:
			tens_complication();
			break;
		case 9:
			if(actnumber[i]==0) {
				inWords[j]='';
			}
			else if(actnumber[i-1]!=0 && actnumber[i-2]!=0) {
				inWords[j]=iWords[actnumber[i]]+' Hundred';
			}
			else {
				inWords[j]=iWords[actnumber[i]]+' Hundred';
			}
			break;

		case 10:
			if(actnumber[i]==0 || actnumber[i+1]==1) {
				inWords[j]='';
			}
			else {
				inWords[j]=iWords[actnumber[i]];
			}
			if(actnumber[i+1] != 0 || actnumber[i] > 0){
				inWords[j]=inWords[j]+" Thousand";
			}
			break;

			default:
			break;
		}
		j++;
	}


	function tens_complication() {
		if(actnumber[i]==0) {
			inWords[j]='';
		}
		else if(actnumber[i]==1) {
			inWords[j]=ePlace[actnumber[i-1]];
		}
		else {
			inWords[j]=tensPlace[actnumber[i]];
		}
	}

	function tens_decimal_complication() {
		if(actnumber_decimal[e]==0) {
			inWords[d]='';
		}
		else if(actnumber_decimal[e]==1) {
			inWords[d]=ePlace[actnumber_decimal[e-1]];
		}
		else {
			inWords[d]=tensPlace[actnumber_decimal[e]];
		}
	}

	inWords.reverse();
	for(i=0; i<inWords.length; i++) {
		finalWord+=inWords[i];
	}
	document.getElementById(ctlinwords).innerHTML=finalWord;
	//return obStr+'  '+finalWord;
}

//*********************** PASSPORT ENDORSEMENT START    ********************//

function fc_rate_edit(ctlName,fcrateid,loginID,createdBy,baseroot){
	
  //alert("jhjh"+bankOrgTxnCode+"Userid"+authorizedBy); exit;
	if (loginID.trim()==createdBy.trim())
	{
		var url=baseroot+'/jbpe_user_forms/fcRateIssue.php';
		url = url+"/"+fcrateid;
		window.open(url, "_self");
		
	}
    else
	{	
		document.getElementById(ctlName).innerHTML = 'Same User Required To Edit';
	}   
}
//*********************** CERTIFICATE    ********************//

function print_certificate(ctlName,passportNo,loginID,baseroot){
	
  //alert("jhjh"+bankOrgTxnCode+"Userid"+authorizedBy); exit;
	

		var url=baseroot+'/jbpe_report/rpt_downloadCertificate_fpdf.php';
		url = url+"/"+passportNo;
		window.open(url);	

	var xmlHttp = GetXmlHttpObject(); 
	var url=baseroot+'/jbpe_lib/getaccount.php';
	url=url+"/CERTIFICATEDOWNLOADSTATUSCHANGE/"+passportNo+"/xyz/"; 
	
	if (!xmlHttp){          
	 //alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		  
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);

	
}
function fcRateReject(ctlName,fcrateid,authorizedBy,baseroot){
	
  //alert("jhjh"+bankOrgTxnCode+"Userid"+authorizedBy); exit;
  
    document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Uploading . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+'/jbpe_lib/getaccount.php';
	url=url+"/FCRATEREJECT/"+fcrateid+"/"+authorizedBy+"/"; 
	//alert(url);
	if (!xmlHttp){          
	 //alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 var dom = 'authorize'+ctlName.substring(5);
		 document.getElementById(dom).remove();
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
    
}

//*****************JBPE FC RATE AUTHORIZED**********************************************

function fcRateAuthorize(ctlName,fcrateid,authorizedBy,baseroot){
	
  //alert("jhjh"+bankOrgTxnCode+"Userid"+authorizedBy); exit;
  
    document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Uploading . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+'/jbpe_lib/getaccount.php';
	url=url+"/FCRATEAUTHORIZATION/"+fcrateid+"/"+authorizedBy+"/"; 
	//alert(url);
	if (!xmlHttp){          
	 //alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 var dom = 'ctlno'+ctlName.substring(9);
		 document.getElementById(dom).remove();
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
    
}

function nepsVerify(ctlName,txnCode,baseroot){
	
  //alert("jhjh"+bankOrgTxnCode);
    document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Uploading . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+'/jbneps_lib/getaccount.php';
	url=url+"/NEPSVERIFY/"+txnCode+"/"; 
	//alert(url);
	if (!xmlHttp){          
	 //alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
    
}

function showIndivisualCustomer(showCustomer,nIDNo,baseroot){
                alert(showCustomer+nIDNo+baseroot); exit;

  document.getElementById(showCustomer).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+'/jbneps_lib/getaccount.php';
	url=url+"/SHOWINDIVISUALCUSTOMER/"+nIDNo+"/";  
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
        		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(showCustomer).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);

}
// Show Customer Bulk Data

function showCustBulkData(showCustomer,fromDate,toDate,baseroot){
                //alert(ctlName+consumercode+routing_no);
  document.getElementById(showCustomer).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+'/jbneps_lib/getaccount.php';
	url=url+"/SHOWCUSTBULKDATA/"+fromDate+"/"+toDate+"/";  
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
        		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(showCustomer).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);

}

function reconcile(showCustomer,fromDate,toDate,branchcode,baseroot){
                //alert(ctlName+consumercode+routing_no);
				//+accRoutingCode+"/"
  document.getElementById(showCustomer).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+'/jbneps_lib/getaccount.php';
	url=url+"/RECONCILE/"+fromDate+"/"+toDate+"/"+branchcode+"/";  
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
        		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(showCustomer).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);

}
//////////////////////////////////
//Passport Endorsement Starts Here
//
function showPassportInfo(showPassportInfo,passportNo,baseroot){
                //alert(passportInfo+passportNo+baseroot); exit;
	passportNo = passportNo.trim();
  document.getElementById(showPassportInfo).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait . . . . ';
	//alert(showPassportInfo+passportNo+baseroot); exit;
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+'/jbpe_lib/getaccount.php';
	url=url+"/SHOWPASSPORTINFO/"+passportNo+"/";  
	//alert(url);
	if (!xmlHttp){          
	 alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
        		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(showPassportInfo).innerHTML=xmlHttp.responseText;
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);

}


 
 function peReject(ctlName,peTxnId,authorizedBy,baseroot){
	
  //alert("Pe Reject"+bankOrgTxnCode+"Userid"+authorizedBy); exit;
  
    document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Uploading . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+'/jbpe_lib/getaccount.php';
	url=url+"/PEREJECT/"+peTxnId+"/"+authorizedBy+"/"; 
	//alert(url);
	if (!xmlHttp){          
	 //alert ("Browser does not support HTTP Request")          
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 var dom = 'authorize'+ctlName.substring(5);
		 document.getElementById(dom).remove();
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
    
}


function peAuthorize(ctlName,peTxnId,authorizedBy,baseroot){
	
  //alert("Pe Authorize"+peTxnId+"Userid"+authorizedBy+"Control Name:"+ctlName); exit;
  
  
    document.getElementById(ctlName).innerHTML = '<img src='+baseroot+'/images/loader.gif width=16 height=16>  Please wait Authorizing . . . ';
	var xmlHttp = GetXmlHttpObject();     
	var url=baseroot+'/jbpe_lib/getaccount.php';
	url=url+"/PEAUTHORIZATION/"+peTxnId+"/"+authorizedBy+"/"; 
	//alert(url); exit;
	if (!xmlHttp){          
	 //alert ("Browser does not support HTTP Request")        
	 return     
	 }   
	 	xmlHttp.onreadystatechange=function(){     
		 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){    
		 document.getElementById(ctlName).innerHTML=xmlHttp.responseText;
		 var dom = 'ctlno'+ctlName.substring(9);
		 document.getElementById(dom).remove();
		 }     
	};     
	 xmlHttp.open("GET", url, true);     
	 xmlHttp.send(null);
    
}


function peEdit(ctlName,peTxnId,loginID,createdBy,baseroot){
	
  //alert("Edit PPE TXN:"+peTxnId+"Userid:"+loginID+'Created By:'+createdBy+'Baseroot:'+baseroot+'ControlName'+ctlName);
  //exit;
	if (loginID.trim()==createdBy.trim())
	{
		var url=baseroot+'/jbpe_user_forms/endorsementEntry.php';
		url = url+"/"+peTxnId;
		window.open(url, "_self");
		
	}
    else
	{	
		document.getElementById(ctlName).innerHTML = 'Same User Required To Edit';
	}   
}


