
<div align="center"  style="margin:5%;">
	<table border="0" width="600px" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2" align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><b>EDI DECLARATION</b></td>
		</tr>
	</table>
	<br>
	<table border="1" width="600px" cellpadding="0" cellspacing="0">
		<tr>
			<td class="gridLight" align="center">Vessel Name</td>
			<td class="gridLight" align="center"><?php echo $rslt_edi_list[0]['Vessel_Name']; ?></td>
		</tr><tr>
			<td class="gridLight" align="center">Rotation</td>
			<td class="gridLight" align="center"><?php echo $rslt_edi_list[0]['Import_Rotation_No']; ?></td>
		</tr>
		<tr>
			<td class="gridLight" align="center">Imp Voyage</td>
			<td class="gridLight" align="center"><?php echo $rslt_edi_list[0]['Voy_No']; ?></td>
		</tr>
		<tr>
			<td class="gridLight" align="center">Exp Voyage</td>
			<td class="gridLight" align="center"><?php echo $rslt_edi_list[0]['VoyNoExp']; ?></td>
		</tr>
		<tr>
			<td class="gridLight" align="center">GRT</td>
			<td class="gridLight" align="center"><?php echo $rslt_edi_list[0]['grt']; ?></td>
		</tr>
		<tr>
			<td class="gridLight" align="center">NRT</td>
			<td class="gridLight" align="center"><?php echo $rslt_edi_list[0]['nrt']; ?></td>
		</tr>
		<tr>
			<td class="gridLight" align="center">IMO NO</td>
			<td class="gridLight" align="center"><?php echo $rslt_edi_list[0]['imo']; ?></td>
		</tr>
		<tr>
			<td class="gridLight" align="center">LOA</td>
			<td class="gridLight" align="center"><?php echo $rslt_edi_list[0]['loa_cm']; ?></td>
		</tr>
		<tr>
			<td class="gridLight" align="center">Name of Master</td>
			<td class="gridLight" align="center"><?php echo $rslt_edi_list[0]['Name_of_Master']; ?></td>
		</tr>
		<tr>
			<td class="gridLight" align="center">FLAG</td>
			<td class="gridLight" align="center"><?php echo $rslt_edi_list[0]['flag']; ?></td>
		</tr>
		<tr>
			<td class="gridLight" align="center">Call Sign</td>
			<td class="gridLight" align="center"><?php echo $rslt_edi_list[0]['radio_call_sign']; ?></td>
		</tr>
		<tr>
			<td class="gridLight" align="center">Beam</td>
			<td class="gridLight" align="center"><?php echo $rslt_edi_list[0]['beam_cm']; ?></td>
		</tr>
		<tr>
			<td class="gridLight" align="center">Agent</td>
			<td class="gridLight" align="center"><?php echo $rslt_edi_list[0]['agent_name']; ?></td>
		</tr>
	</table>
</div>

	