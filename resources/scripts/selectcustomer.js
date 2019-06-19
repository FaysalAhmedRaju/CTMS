var xmlHttp

function myshoworg(str)
{ 
//alert(str);
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
document.getElementById("lbl_org_id1").innerHTML="<igm src='image/loading.gif'/><br><a>Loading...</a>";
var url="Forms/getcustomer.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedCustom;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChangedCustom() 
{ 
if (xmlHttp.readyState==4)
{ 
document.getElementById("lbl_org_id1").innerHTML=xmlHttp.responseText;
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
