function usermenudisplay1(a,utype)
{
//alert (utype);
		if (utype!='SA') {
      a.style.display="inline";
		} else {
		a.style.display="none";
		}
   return false;
}



function submenudisplay(mnutable,triggerLink) {
	//alert(triggerLink);
  dataTable = document.getElementById(mnutable);

  dataTabletRows = dataTable.getElementsByTagName('TR');
  for (i = 0; i < dataTabletRows.length; i++) {
    currentRow = dataTabletRows[i];
    if (currentRow.className.indexOf(triggerLink) != -1) {
      togglesubmenu(currentRow);
    }
  }
}

function togglesubmenu(item) {
  if (item.style.display == '') {
    item.style.display = 'none';
    opening = false;
  } else {
    item.style.display = '';
    opening = true;
  }
}


function batchdisplay_replace(a,utype)
{
	alert(a);
   if(a.style.display=="none")
   {
     a.style.display="inline";
   }
   else if(a.style.display=="inline")
   {
      a.style.display="none";
   }
   return false;
}

var timer = null

function Timestart(){
    var time = new Date()
    var hours = time.getHours()
    var minutes = time.getMinutes()
    minutes=((minutes < 10) ? "0" : "") + minutes
    var seconds = time.getSeconds()
    seconds=((seconds < 10) ? "0" : "") + seconds
    //var clock = hours + ":" + minutes + ":" + seconds
	
	//doBlink()
	// date
	
    var mydate=new Date()
    var year=mydate.getYear()
    
    if (year < 1000)
        year+=1900
    
    var day=mydate.getDay()
    var month=mydate.getMonth()+1
    
    if (month<10)
        month="0"+month
    
    var daym=mydate.getDate()
    if (daym<10)
        daym="0"+daym
    
//    document.write(year+"/"+month+"/"+daym)
var AP='AM';
if (hours > 12)
   {
   hours = hours - 12;
   AP='PM';
   }

//var clock = daym+"-"+month+"-"+year +"  "+ hours + ":" + minutes + ":" + seconds
var clock = hours + ":" + minutes + ":" + seconds 
	//
    document.getElementById('display').innerHTML = clock + " " + AP
    timer = setTimeout("Timestart()",500)
	//doBlink()
	//setInterval("doBlink()",1000)
}



function showmenu2_old(f){
if(f){visi="visible";}
else{visi="hidden";}

if(document.layers){document.menu.visibility=visi;}
if(document.all){document.all.menu.style.visibility=visi;}
if(document.getElementById){document.getElementById("menu").style.visibility=visi;}

}




function doBlink_old() {
	var blink = document.all.tags("BLINK")
	for (var i=0; i<blink.length; i++)
		blink[i].style.visibility = blink[i].style.visibility == "" ? "hidden" : "" 
}
 
function startBlink_old() {
	if (document.all)
		setInterval("doBlink()",500)
}
//window.onload = startBlink;
