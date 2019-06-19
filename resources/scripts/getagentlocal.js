
//var BASE_URL="http://localhost/myportpanel/index.php/report/";
//alert(getenv('HTTP_CLIENT_IP'));
//var ip=<?php echo $_SERVER['REMOTE_ADDR']; ?>
//alert(ip);
//function getip(json) {
 //          alert(json.ip);
  //     }

var BASE_URL="http://192.168.16.42/myportpanel/index.php/report/";

//alert(BASE_URL);
function myshowAgent(str)
{ 


str = document.getElementById('txt_login').value;
//alert(str);
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
//document.getElementById("line_no").innerHTML="<img1 src='image/loading.gif'/><br><a>Loading...</a>";

var url=BASE_URL+"getAgent";
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
//alert(xmlHttp.responseText);
document.getElementById("line_no").innerHTML=xmlHttp.responseText;
}
}

function myShowmlocode(type)
{ 

//alert(type);
//alert(rot_no);
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url=BASE_URL+"getmlocode";
url=url+"?id="+type;
//alert(url);
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedmlo;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}


function stateChangedmlo() 
{ 
if (xmlHttp.readyState==4)
{ 
//alert(xmlHttp.responseText);
document.getElementById("igm").innerHTML=xmlHttp.responseText;

}
}

function myShowMLO(imp_rotation)
{ 
imp_rotation = document.getElementById('txt_login').value;
//alert(imp_rotation);
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url=BASE_URL+"getmlocodeigm";
url=url+"?imp_rotation="+imp_rotation;
//alert(url);
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedUdName;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChangedUdName() 
{ 
if (xmlHttp.readyState==4)
{ 
//alert(xmlHttp.responseText);
document.getElementById("mlocode").innerHTML=xmlHttp.responseText;

}
}

function myShowOrg()
{ 
//alert("shemul");
rot_no = document.getElementById('txt_login').value;
type = document.getElementById('igm').value;
//alert(rot_no);
//alert(type);
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url=BASE_URL+"getShippingAgents";
url=url+"?rot="+rot_no+"&t="+type;
//alert(url);
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedShippingName;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}
//for Suplementary
function myShowSupOrg()
{ 
//alert(rot_no);
rot_no = document.getElementById('txt_login').value;
type = document.getElementById('igm').value;
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url=BASE_URL+"getSupShippingAgents";
url=url+"?rot="+rot_no+"&t="+type;
//alert(url);
//url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedShippingName;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}
function stateChangedShippingName() 
{ 

if (xmlHttp.readyState==4)
{ 

//alert("dd");
//alert(xmlHttp.responseText);
document.getElementById("shipping").innerHTML=xmlHttp.responseText;

}
}

function myshowmloreport()
{
//alert(agent); 
//year = document.getElementById('ddl_year').value;
manifest = document.getElementById('igm').value;
rot = document.getElementById('txt_login').value;
agent = document.getElementById('ddl_Org_id').value;
//alert(year+"-"+manifest+"-"+rot+"-"+type); 
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
//document.getElementById("mlo").innerHTML="<igm src='image/loading.gif'/><br><a>Loading...</a>";
var url=BASE_URL+"getmlo";
url=url+"?rot="+rot+"&man="+manifest+"&agent="+agent;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged1;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChanged1() 
{ 
if (xmlHttp.readyState==4)
{ 
//alert(xmlHttp.responseText);
document.getElementById("mlo").innerHTML=xmlHttp.responseText;
}
}



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
