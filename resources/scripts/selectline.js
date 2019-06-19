var xmlHttp
//-----------------------------------------------------------------------------------------------------------------------------------------------------------
function myshowline(str)
{ 
//alert(str);
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url="Forms/getline.php";
url=url+"?q="+str;
//alert(url);
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged9;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChanged9() 
{ 
if (xmlHttp.readyState==4)
{ 
document.getElementById("line_no").innerHTML=xmlHttp.responseText;
}
}
//-----------------------------------------------------------
//for IGM Suplementary Ammendment
function myshowSupline(str)
{ 
//alert(str);
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url="Forms/getSupline.php";
url=url+"?q="+str;
//alert(url);
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedSup;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChangedSup() 
{ 
if (xmlHttp.readyState==4)
{ 
document.getElementById("line_no").innerHTML=xmlHttp.responseText;
}
}
//---------------------------------------------------------
//for egm ammendment
function myshowexp(str)
{ 
//alert(str);
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url="Forms/getexp.php";
url=url+"?q="+str;
//alert("hi");
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedexp;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChangedexp() 
{ 
if (xmlHttp.readyState==4)
{ 
document.getElementById("line_no").innerHTML=xmlHttp.responseText;
}
}
//-----------------------------------------------------------------------------------------------------------------------------------------------------------

function myshowfile(str)
{ 

xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url="Forms/getfile.php";
url=url+"?q="+str;
//alert(url);
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedfile;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChangedfile() 
{ 
if (xmlHttp.readyState==4)
{ 
document.frm2.file_ref_no.value=xmlHttp.responseText;
}
}
//Final Entry
function showfinal(str)
{ 
//alert(str);
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url="Forms/getfinal.php";
url=url+"?q="+str;
//alert("hh");
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedfinal;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChangedfinal() 
{ 
if (xmlHttp.readyState==4)
{
//alert("vv"); 
document.getElementById("line_no").innerHTML=xmlHttp.responseText;
}
}
//
//
//port Clearance
function showport(str)
{ 
//alert(str);
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url="Forms/getport.php";
url=url+"?q="+str;
//alert("hh");
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedport;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChangedport() 
{ 
if (xmlHttp.readyState==4)
{
//alert("vv"); 
document.getElementById("line_no").innerHTML=xmlHttp.responseText;
}
}
//
//PSI
function myshowpsiorg(str,orgid)
{ 
//alert("str");
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {m
  alert ("Your browser does not support AJAX!");
  return;
  } 
 //alert(orgid);
var url="Forms/myPsiOrgname.php";
url=url+"?q="+str;
url=url+"&orgid="+orgid;
//alert(url);
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangepsiorg;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}


function stateChangepsiorg() 
{ 
if (xmlHttp.readyState==4)
{ 
document.getElementById("line_no").innerHTML=xmlHttp.responseText;
}
}
//PSI
function myshowcnf(str)
{ 
//alert("str");
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url="Forms/myPounchGetcnf.php";
url=url+"?q="+str;
//alert("url");
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedBillEntry;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChangedBillEntry() 
{ 
if (xmlHttp.readyState==4)
{ 
document.getElementById("line_no").innerHTML=xmlHttp.responseText;
}
}

//
//For Discharge 

function myshowAgent(str)
{ 
alert(str);
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
//document.getElementById("line_no").innerHTML="<img1 src='image/loading.gif'/><br><a>Loading...</a>";
var url="Forms/getAgent.php";
url=url+"?q="+str;
//alert(url);
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedAgent;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChangedAgent() 
{ 
if (xmlHttp.readyState==4)
{ 
document.getElementById("line_no").innerHTML=xmlHttp.responseText;
}
}



function myshowuddt(udno,sel,id)
{ 
//alert(id+"uyutyu");
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url="Forms/udajax1.php";
url=url+"?udno="+udno+"&s="+sel+"&id="+id;
//alert(url);
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedudt;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChangedudt() 
{ 
if (xmlHttp.readyState==4)
{ 
document.getElementById("lin1").innerHTML=xmlHttp.responseText;
}
}

function unittest(OrderNo,SADITM_HS_COD,sad_gen_id)
{ 
//alert(OrderNo+"uyutyu");
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
if(SADITM_HS_COD!=""&sad_gen_id!=""&&OrderNo!="")
{
var url="Forms/getud.php";

url=url+"?SADITM_HS_COD="+SADITM_HS_COD+"&sad_gen_id="+sad_gen_id+"&OrderNo="+OrderNo;
//alert(url);
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedud;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}
else
{
	//alert("Shirin");
}
}

function stateChangedud() 
{ 

if (xmlHttp.readyState==4)
{ 

			rtn=parseInt(xmlHttp.responseText);
			rrt=xmlHttp.responseText;

			if(rtn==0)
			{
				alert('No Organization Found');
				
				document.frm2.UnitName.value="";
					document.frm2.ep_no.value="";
			}
			else
			{
				arr1=rrt.split("|");
				
						document.frm2.ep_no.value=arr1[1];
					document.frm2.UnitName.value=arr1[2];
				
				
					
				
					
					
				

			}

}
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------
function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;


}
