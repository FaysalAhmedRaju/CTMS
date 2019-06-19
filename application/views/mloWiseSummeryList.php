<?php //if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Bearth Operator Report</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
</HEAD>
<BODY>

	<?php /*} 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=MLO_WISE_SUMMERY.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}*/
//$ddl_imp_rot_no=$_REQUEST['ddl_imp_rot_no']; 

	//$con=mysql_connect("10.1.1.21", "sparcsn4","sparcsn4")or die("cannot connect"); 
	//mysql_select_db("sparcsn4")or die("cannot select DB");
	include_once("mydbPConnectionn4.php");
	
	
	 $rotaiton=$rot;
	 $mlo=$mlo;
	
	//$rotaiton="2016/273";
	//$mlo="BLG";
	
	$sql=mysql_query("
select cont_mlo,last_update,name,voys_no,cont_size,
IFNULL(SUM(F_20),0) AS F_20,
IFNULL(SUM(L_20),0) AS L_20,
IFNULL(SUM(M_20),0) AS M_20,
IFNULL(SUM(I_20),0) AS I_20,
IFNULL(SUM(T_20),0) AS T_20,
IFNULL(SUM(R_20),0) AS R_20,
IFNULL(SUM(IMDG_20),0) AS IMDG_20, 
IFNULL(SUM(F_40),0) AS F_40,
IFNULL(SUM(L_40),0) AS L_40,
IFNULL(SUM(M_40),0) AS M_40,
IFNULL(SUM(I_40),0) AS I_40,
IFNULL(SUM(T_40),0) AS T_40,
IFNULL(SUM(R_40),0) AS R_40,
IFNULL(SUM(IMDG_40),0) AS IMDG_40,

IFNULL(SUM(FW_20),0) AS FW_20,
IFNULL(SUM(LW_20),0) AS LW_20,
IFNULL(SUM(MW_20),0) AS MW_20,
IFNULL(SUM(IW_20),0) AS IW_20,
IFNULL(SUM(TW_20),0) AS TW_20,
IFNULL(SUM(RW_20),0) AS RW_20,
IFNULL(SUM(IMDGW_20),0) AS IMDGW_20, 
IFNULL(SUM(FW_40),0) AS FW_40,
IFNULL(SUM(LW_40),0) AS LW_40,
IFNULL(SUM(MW_40),0) AS MW_40,
IFNULL(SUM(IW_40),0) AS IW_40,
IFNULL(SUM(TW_40),0) AS TW_40,
IFNULL(SUM(RW_40),0) AS RW_40,
IFNULL(SUM(IMDGW_40),0) AS IMDGW_40
from (

select cont_mlo,date(last_update) as last_update,sparcsn4.vsl_vessels.name,voys_no,cont_size,
(CASE WHEN cont_size = '20' AND cont_status in ('FCL') AND isoGroup not in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS F_20,
(CASE WHEN cont_size = '20' AND cont_status in ('LCL') AND isoGroup not in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS L_20,
(CASE WHEN cont_size = '20' AND cont_status in ('MTY') AND isoGroup not in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS M_20,
0 AS I_20,
0 AS T_20,
(CASE WHEN cont_size = '20' AND isoGroup in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS R_20,
0 AS IMDG_20,
(CASE WHEN cont_size in ('40','45') AND cont_status in ('FCL') AND isoGroup not in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS F_40,
(CASE WHEN cont_size in ('40','45') AND cont_status in ('LCL') AND isoGroup not in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS L_40,
(CASE WHEN cont_size in ('40','45') AND cont_status in ('MTY') AND isoGroup not in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS M_40,
0 AS I_40,
0 AS T_40,
(CASE WHEN cont_size in ('40','45') AND isoGroup in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS R_40,
0 AS IMDG_40,
(CASE WHEN cont_size = '20' AND cont_status in ('FCL') AND isoGroup not in ('RS','RT','RE')  THEN goods_and_ctr_wt_kg  
ELSE NULL END) AS FW_20,
(CASE WHEN cont_size = '20' AND cont_status in ('LCL') AND isoGroup not in ('RS','RT','RE')  THEN goods_and_ctr_wt_kg  
ELSE NULL END) AS LW_20,
(CASE WHEN cont_size = '20' AND cont_status in ('MTY') AND isoGroup not in ('RS','RT','RE')  THEN goods_and_ctr_wt_kg 
ELSE NULL END) AS MW_20,
0 AS IW_20,
0 AS TW_20,
(CASE WHEN cont_size = '20' AND isoGroup in ('RS','RT','RE')  THEN goods_and_ctr_wt_kg  
ELSE NULL END) AS RW_20,
0 AS IMDGW_20,
(CASE WHEN cont_size in ('40','45') AND cont_status in ('FCL') AND isoGroup not in ('RS','RT','RE')  THEN goods_and_ctr_wt_kg  
ELSE NULL END) AS FW_40,
(CASE WHEN cont_size in ('40','45') AND cont_status in ('LCL') AND isoGroup not in ('RS','RT','RE')  THEN goods_and_ctr_wt_kg  
ELSE NULL END) AS LW_40,
(CASE WHEN cont_size in ('40','45') AND cont_status in ('MTY') AND isoGroup not in ('RS','RT','RE')  THEN goods_and_ctr_wt_kg  
ELSE NULL END) AS MW_40,
0 AS IW_40,
0 AS TW_40,
(CASE WHEN cont_size in ('40','45') AND isoGroup in ('RS','RT','RE')  THEN goods_and_ctr_wt_kg  
ELSE NULL END) AS RW_40,
0 AS IMDGW_40

from ctmsmis.mis_exp_unit_preadv_req 
inner join sparcsn4.vsl_vessel_visit_details on sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit_preadv_req.vvd_gkey
inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
where rotation='$rotaiton' and cont_mlo='$mlo'
) as tmp ");
	$row=mysql_fetch_object($sql);
	
	$SUB_20=$row->F_20+$row->L_20+$row->M_20+$row->I_20+$row->T_20+$row->R_20+$row->IMDG_20;
	$FL_20=$row->F_20+$row->L_20+$row->I_20+$row->T_20+$row->R_20+$row->IMDG_20;
	
	$SUBW_20=$row->FW_20+$row->LW_20+$row->MW_20+$row->IW_20+$row->TW_20+$row->RW_20+$row->IMDGW_20;
	$FLW_20=$row->FW_20+$row->LW_20+$row->IW_20+$row->TW_20+$row->RW_20+$row->IMDGW_20;
	
	$SUB_40=$row->F_40+$row->L_40+$row->M_40+$row->I_40+$row->T_40+$row->R_40+$row->IMDG_40;
	$FL_40=$row->F_40+$row->L_40+$row->I_40+$row->T_40+$row->R_40+$row->IMDG_40;
	
	$SUBW_40=$row->FW_40+$row->LW_40+$row->MW_40+$row->IW_40+$row->TW_40+$row->RW_40+$row->IMDGW_40;
	$FLW_40=$row->FW_40+$row->LW_40+$row->IW_40+$row->TW_40+$row->RW_40+$row->IMDGW_40;
//	$vvdGkey=$row->vvd_gkey;


	$TF=$FL_20+$FL_40;
	$TM=$row->M_20+$row->M_40;
	$TT=$SUB_20+$SUB_40;
	
	$TFW=$FLW_20+$FLW_40;
	$TMW=$row->MW_20+$row->MW_40;
	$TTW=$SUBW_20+$SUBW_40;
	
	?>
<html>
<title>MLO WISE LOADED CONTAINER SUMMERY LIST</title>
<body>
<br/>
<table border="0" width="100%">
	<tr>
		<td colspan="2" align="right"><b>MLO</b></td>
		<td colspan="2" align="right"><b></b></td>
		<td><b><?php if($mlo) echo $mlo; else echo "&nbsp;"; ?></b></td>
		<td colspan="3" align="right"><b>CPA:-C2D7</b></td>
		<td><b></b></td>
	</tr>
</table>

<br/>
<br/>
<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr height="70px">
		<td colspan="2"><b>PROJECTED <br /> FINAL</b></td>
		<td colspan="3" align="center"><b>CONTAINER LOADING</b></td>
		<td colspan="5" align="center"><b>SUMMARY<br/> DATE:- <?php if ($row->last_update) echo $row->last_update; else echo "&nbsp;"; ?></b></td>
	</tr>
	<tr>
		<td><b>VESSEL</b></td>
		<td colspan="9" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php  if ($row->name) echo $row->name; else echo "&nbsp;"; ?></b></td>
		
	</tr>
	<tr>
		<td><b>VOY.NO</b></td>
		<td colspan="9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php if ($row->voys_no) echo $row->voys_no; else echo "&nbsp;"; ?></b></td>
	</tr>
	<tr height="25px">
		<td colspan="10" align="center"><b> EXPORT</b></td>
	</tr>
	<tr align="center">
		<td colspan="2"><b>CONTAINER</b></td>
		<td><b></b></td>
		<td colspan="4"><b>NOS. OF CONT. WEIGHT</b></td>
		<td colspan="3"><b>GROSS WEIGHT</b></td>
	</tr>
	<tr align="center">
		<td><b>TYPE</b></td>
		<td><b>SIZE</b></td>
		<td><b>CL</b></td>
		<td><b>FULL</b></td>
		<td><b>MT</b></td>
		<td><b>TOTAL</b></td>
		<td><b>NET</b></td>
		<td><b>FULL</b></td>
		<td><b>MT</b></td>
		<td><b>TOTAL</b></td>
	</tr>
	<tr align="center">
		<td><b>20'</b></td>
		<td><b>NORMAL</b></td>
		<td><b>FCL</b></td>
		<td><?php if($row->F_20=="0") echo "&nbsp;"; else echo $row->F_20;?></td>
		<td></td>
		<td><?php if($row->F_20=="0") echo "&nbsp;"; else echo $row->F_20;?></td>
		<td></td>
		<td><?php if($row->FW_20=="0") echo "&nbsp;"; else echo $row->FW_20;?></td>
		<td></td>
		<td><?php if($row->FW_20=="0") echo "&nbsp;"; else echo $row->FW_20;?></td>
	</tr>
	<tr align="center">
		<td><b></b></td>
		<td><b></b></td>
		<td><b>LCL</b></td>
		<td><?php if($row->L_20=="0") echo "&nbsp;"; else echo $row->L_20;?></td>
		<td></td>
		<td><?php if($row->L_20=="0") echo "&nbsp;"; else echo $row->L_20;?></td>
		<td></td>
		<td><?php if($row->LW_20=="0") echo "&nbsp;"; else echo $row->LW_20;?></td>
		<td></td>
		<td><?php if($row->LW_20=="0") echo "&nbsp;"; else echo $row->LW_20;?></td>
	</tr>
	<tr align="center">
		<td><b></b></td>
		<td><b></b></td>
		<td><b>EMPTY</b></td>
		<td></td>
		<td><?php if($row->M_20=="0") echo "&nbsp;"; else echo $row->M_20;?></td>
		<td><?php if($row->M_20=="0") echo "&nbsp;"; else echo $row->M_20;?></td>
		<td></td>
		<td></td>
		<td><?php if($row->MW_20=="0") echo "&nbsp;"; else echo $row->MW_20;?></td>
		<td><?php if($row->MW_20=="0") echo "&nbsp;"; else echo $row->MW_20;?></td>
	</tr>
	<tr align="center">
		<td><b></b></td>
		<td><b></b></td>
		<td><b>ICD</b></td>
		<td><?php if($row->I_20=="0") echo "&nbsp;"; else echo $row->I_20;?></td>
		<td></td>
		<td><?php if($row->I_20=="0") echo "&nbsp;"; else echo $row->I_20;?></td>
		<td></td>
		<td><?php if($row->IW_20=="0") echo "&nbsp;"; else echo $row->IW_20;?></td>
		<td></td>
		<td><?php if($row->IW_20=="0") echo "&nbsp;"; else echo $row->IW_20;?></td>
	</tr>
	<tr align="center">
		<td><b></b></td>
		<td><b></b></td>
		<td><b>TRAN</b></td>
		<td><?php if($row->T_20=="0") echo "&nbsp;"; else echo $row->T_20;?></td>
		<td></td>
		<td><?php if($row->T_20=="0") echo "&nbsp;"; else echo $row->T_20;?></td>
		<td></td>
		<td><?php if($row->TW_20=="0") echo "&nbsp;"; else echo $row->TW_20;?></td>
		<td></td>
		<td><?php if($row->TW_20=="0") echo "&nbsp;"; else echo $row->TW_20;?></td>
	</tr>
	<tr align="center">
		<td><b></b></td>
		<td><b>REEFER</b></td>
		<td><b>REEF</b></td>
		<td><?php if($row->R_20=="0") echo "&nbsp;"; else echo $row->R_20;?></td>
		<td></td>
		<td><?php if($row->R_20=="0") echo "&nbsp;"; else echo $row->R_20;?></td>
		<td></td>
		<td><?php if($row->RW_20=="0") echo "&nbsp;"; else echo $row->RW_20;?></td>
		<td></td>
		<td><?php if($row->RW_20=="0") echo "&nbsp;"; else echo $row->RW_20;?></td>
	</tr>
	<tr align="center">
		<td><b></b></td>
		<td><b>IMDG</b></td>
		<td><b>IMDG</b></td>
		<td><?php if($row->IMDG_20=="0") echo "&nbsp;"; else echo $row->IMDG_20;?></td>
		<td></td>
		<td><?php if($row->IMDG_20=="0") echo "&nbsp;"; else echo $row->IMDG_20;?></td>
		<td></td>
		<td><?php if($row->IMDGW_20=="0") echo "&nbsp;"; else echo $row->IMDGW_20;?></td>
		<td></td>
		<td><?php if($row->IMDGW_20=="0") echo "&nbsp;"; else echo $row->IMDGW_20;?></td>
	</tr>
	<tr align="center">
		<td><b>SUB: TOTAL</b></td>
		<td><b></b></td>
		<td><b></b></td>
		<td><?php if($FL_20=="0") echo "&nbsp;"; else echo $FL_20;?></td>
		<td><?php if($row->M_20=="0") echo "&nbsp;"; else echo $row->M_20;?></td>
		<td><?php if($SUB_20=="0") echo "&nbsp;"; else echo $SUB_20;?></td>
		<td></td>
		<td><?php if($FLW_20=="0") echo "&nbsp;"; else echo $FLW_20;?></td>
		<td><?php if($row->MW_20=="0") echo "&nbsp;"; else echo $row->MW_20;?></td>
		<td><?php if($SUBW_20=="0") echo "&nbsp;"; else echo $SUBW_20;?></td>
	</tr>
	<tr align="center">
		<td><b>40'</b></td>
		<td><b>NORMAL</b></td>
		<td><b>FCL</b></td>
		<td><?php if($row->F_40=="0") echo "&nbsp;"; else echo $row->F_40;?></td>
		<td></td>
		<td><?php if($row->F_40=="0") echo "&nbsp;"; else echo $row->F_40;?></td>
		<td></td>
		<td><?php if($row->FW_40=="0") echo "&nbsp;"; else echo $row->FW_40;?></td>
		<td></td>
		<td><?php if($row->FW_40=="0") echo "&nbsp;"; else echo $row->FW_40;?></td>
	</tr>
	<tr align="center">
		<td><b>45'</b></td>
		<td><b></b></td>
		<td><b>LCL</b></td>
		<td><?php if($row->L_40=="0") echo "&nbsp;"; else echo $row->L_40;?></td>
		<td></td>
		<td><?php if($row->L_40=="0") echo "&nbsp;"; else echo $row->L_40;?></td>
		<td></td>
		<td><?php if($row->LW_40=="0") echo "&nbsp;"; else echo $row->LW_40;?></td>
		<td></td>
		<td><?php if($row->LW_20=="0") echo "&nbsp;"; else echo $row->LW_40;?></td>
	</tr>
	<tr align="center">
		<td><b></b></td>
		<td><b></b></td>
		<td><b>EMPTY</b></td>
		<td></td>
		<td><?php if($row->M_40=="0") echo "&nbsp;"; else echo $row->M_40;?></td>
		<td><?php if($row->M_40=="0") echo "&nbsp;"; else echo $row->M_40;?></td>
		<td></td>
		<td></td>
		<td><?php if($row->MW_40=="0") echo "&nbsp;"; else echo $row->MW_40;?></td>
		<td><?php if($row->MW_40=="0") echo "&nbsp;"; else echo $row->MW_40;?></td>
	</tr>
	<tr align="center">
		<td><b></b></td>
		<td><b></b></td>
		<td><b>ICD</b></td>
		<td><?php if($row->I_40=="0") echo "&nbsp;"; else echo $row->I_40;?></td>
		<td></td>
		<td><?php if($row->I_40=="0") echo "&nbsp;"; else echo $row->I_40;?></td>
		<td></td>
		<td><?php if($row->IW_40=="0") echo "&nbsp;"; else echo $row->IW_40;?></td>
		<td></td>
		<td><?php if($row->IW_40=="0") echo "&nbsp;"; else echo $row->IW_40;?></td>
	</tr>
	<tr align="center">
		<td><b></b></td>
		<td><b></b></td>
		<td><b>TRAN</b></td>
		<td><?php if($row->T_40=="0") echo "&nbsp;"; else echo $row->T_40;?></td>
		<td></td>
		<td><?php if($row->T_40=="0") echo "&nbsp;"; else echo $row->T_40;?></td>
		<td></td>
		<td><?php if($row->TW_40=="0") echo "&nbsp;"; else echo $row->TW_40;?></td>
		<td></td>
		<td><?php if($row->TW_40=="0") echo "&nbsp;"; else echo $row->TW_40;?></td>
	</tr>
	<tr align="center">
		<td><b></b></td>
		<td><b>REEFER</b></td>
		<td><b>REEF</b></td>
		<td><?php if($row->R_40=="0") echo "&nbsp;"; else echo $row->R_40;?></td>
		<td></td>
		<td><?php if($row->R_40=="0") echo "&nbsp;"; else echo $row->R_40;?></td>
		<td></td>
		<td><?php if($row->RW_40=="0") echo "&nbsp;"; else echo $row->RW_40;?></td>
		<td></td>
		<td><?php if($row->RW_40=="0") echo "&nbsp;"; else echo $row->RW_40;?></td>
	</tr>
	<tr align="center">
		<td><b></b></td>
		<td><b>IMDG</b></td>
		<td><b>IMDG</b></td>
		<td><?php if($row->IMDG_40=="0") echo "&nbsp;"; else echo $row->IMDG_40;?></td>
		<td></td>
		<td><?php if($row->IMDG_40=="0") echo "&nbsp;"; else echo $row->IMDG_40;?></td>
		<td></td>
		<td><?php if($row->IMDGW_40=="0") echo "&nbsp;"; else echo $row->IMDGW_40;?></td>
		<td></td>
		<td><?php if($row->IMDGW_40=="0") echo "&nbsp;"; else echo $row->IMDGW_40;?></td>
	</tr>
	<tr align="center">
		<td><b>SUB: TOTAL</b></td>
		<td><b></b></td>
		<td><b></b></td>
		<td><?php if($FL_40=="0") echo "&nbsp;"; else echo $FL_40;?></td>
		<td><?php if($row->M_40=="0") echo "&nbsp;"; else echo $row->M_40;?></td>
		<td><?php if($SUB_40=="0") echo "&nbsp;"; else echo $SUB_40;?></td>
		<td></td>
		<td><?php if($FLW_40=="0") echo "&nbsp;"; else echo $FLW_40;?></td>
		<td><?php if($row->MW_40=="0") echo "&nbsp;"; else echo $row->MW_40;?></td>
		<td><?php if($SUBW_40=="0") echo "&nbsp;"; else echo $SUBW_40;?></td>
	</tr>
	<tr align="center">
		<td><b>TOTAL</b></td>
		<td><b></b></td>
		<td><b></b></td>
		<td><?php if($TF=="0") echo "&nbsp;"; else echo $TF;?></td>
		<td><?php if($TM=="0") echo "&nbsp;"; else echo $TM;?></td>
		<td><?php if($TT=="0") echo "&nbsp;"; else echo $TT;?></td>
		<td></td>
		<td><?php if($TFW=="0") echo "&nbsp;"; else echo $TFW;?></td>
		<td><?php if($TMW=="0") echo "&nbsp;"; else echo $TMW;?></td>
		<td><?php if($TTW=="0") echo "&nbsp;"; else echo $TTW;?></td>
	</tr>
	<tr height="60px">
		<td colspan="10"><b>OTHER CARGO</b></td>
	</tr>
	<tr >
		<td colspan="10" border="0">
			<table  width="100%">
				<tr height="50px">
					<td colspan="10"><b>PROVIDED/RECEIVED BY</b></td>
				</tr>
				<tr>
					<td colspan="5"></td>
					<td colspan="5" align="center">___________________________________________________________________________________________</td>
				</tr>
				<tr>
					<td colspan="5"></td>
					<td colspan="5" align="center"><b>SIGNATURE AGENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CPA TERMINAL MANAGEMENT</b></td>
				</tr>
			</table>
		</td>
		
	</tr>
	
	<tr>
		<td colspan="10">&nbsp;</td>
	</tr>
	
</table>

<?php 
mysql_close($con_sparcsn4);

// if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php //}?>
