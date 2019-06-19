
<html>
<title>Commodity Information </title>
<body>
<table width="90%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<!--tr align="center">
					<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr-->
				<tr>
					<td colspan="12" align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>
			
				<tr align="center">
					<td colspan="12" align="right"><font size="3"><b><?php echo $UserName?></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b>COMMODITY INFORMATION</b></font></td>
				</tr>

				

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	<table width="80%" border ='1' cellpadding='0' cellspacing='0'align="center">
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		<!--<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>-->
		<!--<td style="border-width:3px;border-style: double;"><b>ID.</b></td>-->
		<td style="border-width:3px;border-style: double;"><b>CODE.</b></td>
		<td style="border-width:3px;border-style: double;"><b>NAME.</b></td>
		
	</tr>

<?php
	//$con=mysql_connect("10.1.1.21", "sparcsn4","sparcsn4")or die("cannot connect"); 
	//mysql_select_db("sparcsn4")or die("cannot select DB");
	include("dbConection.php");
	
	$query=mysql_query("SELECT commudity_code, commudity_desc FROM ctmsmis.commudity_detail");
	$i=0;

	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
	
?>
<tr align="center">
		<!--<td><?php  echo $i;?></td>-->
		<!--td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td-->
		<td><?php if($row->commudity_code) echo $row->commudity_code; else echo "&nbsp;";?></td>
		<td><?php if($row->commudity_desc) echo $row->commudity_desc; else echo "&nbsp;";?></td>
				
	</tr>

<?php } ?>
</table>

<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
