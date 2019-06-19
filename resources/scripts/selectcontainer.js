var xmlHttp
var rrt="";
var arr1;
var myindx=0;
var rtn="Hello";

function myshowcontsplit(strcont,indxx)
{
var arr2;
arr2=strcont.split("#");

if(indxx==0)
{
document.frm2.txt_igm_detail_id.value=arr2[indxx];
alert(document.frm2.txt_igm_detail_id.value);
}

return(arr2[indxx]);
}

function myshowcont(str,bindx,uid)
{ 
//alert(str+":"+bindx+":"+uid);
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
myindx=bindx;  
var url="Forms/getcontainer.php";

url=url+"?q="+str+"&bindx="+bindx+"&uid="+uid;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged2;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChanged2() 
{ 
if (xmlHttp.readyState==4)
{ 

			rtn=parseInt(xmlHttp.responseText);
			rrt=xmlHttp.responseText;

			if(rtn==0)
			{
				alert('No Container Found')
			}
			else
			{
				arr1=rrt.split("|");
				
				switch(myindx)
				{
				case 1:									
					document.frm2.txt_cont_seal_number.value=arr1[1];
					document.frm2.txt_cont_size.value=arr1[2];
					document.frm2.txt_cont_type.value=arr1[3];
					document.frm2.txt_cont_height.value=arr1[4];
					document.frm2.txt_cont_weight.value=arr1[5];
					document.frm2.txt_cont_status.value=arr1[6];
					break;
				case 2:									
					document.frm2.txt_cont_seal_number.value=arr1[1];
					document.frm2.txt_cont_size.value=arr1[2];
					document.frm2.txt_cont_type.value=arr1[3];
					document.frm2.txt_cont_height.value=arr1[4];
					document.frm2.txt_cont_weight.value=arr1[5];
					document.frm2.txt_cont_status.value=arr1[6];
					break;
				case 3:									
					document.frm2.txt_cont_seal_number.value=arr1[1];
					document.frm2.txt_cont_size.value=arr1[2];
					document.frm2.txt_cont_type.value=arr1[3];
					document.frm2.txt_cont_height.value=arr1[4];
					document.frm2.txt_cont_weight.value=arr1[5];
					document.frm2.txt_cont_status.value=arr1[6];
					
					document.frm2.txt_offdock_id.value=arr1[7];
					document.frm2.txt_cont_IMO.value=arr1[8];
					document.frm2.txt_cont_UN.value=arr1[9];
					
					document.frm2.txt_cont_vat.value=arr1[10];
					document.frm2.txt_commudity_code.value=arr1[11];
					document.frm2.txt_commudity_desc.value=arr1[12];
					
					break;
				}

			}

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