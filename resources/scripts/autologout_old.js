var timeout1=100*60*1000;

setTimeout('resetlogout()',1000);
//

function resetlogout()
{
//alert('125');
this.timeout1=this.timeout1-1000;

//var m=<?php print($myflag); ?>;
//if(m!=9&&m!=1){
if(this.timeout1<=0)
{
alert("shemul");
location.href ="<?php echo base_url(); ?>index.php/login/logout";
}
setTimeout('resetlogout()',1000);
//}
}

function settime()
{

this.timeout1=100*60*1000;

}