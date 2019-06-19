<!--barcode code="C217" type="EAN13" size="1" height="0.5" values="0" text="0" /-->

<table style="border-collapse:collapse;width:100%;">
	<!--tr>
		<td align="center" colspan="10"><img width="1250px" src="<?php echo IMG_PATH?>xml_label.PNG"></td>
	</tr-->
	<!--tr>
		<td colspan="9">
			<img style="margin-left:10px" width="1270px" src="<?php echo IMG_PATH?>xml_label.PNG">
			<br>
			<barcode code="<?php echo $dec_ref_no; ?>" type="CODABAR" />
		</td>
	</tr-->
	<tr>
		<td colspan="9" align="center">
			<h3>Bill of Entry Information</h3>
		</td>
	</tr>
	<tr>
		<td colspan="9">
			<barcode code="<?php echo $dec_ref_no; ?>" type="CODABAR" />
		</td>
	</tr>
	<tr>
		<td class="left_top_right" rowspan="9">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td class="left_top_right" rowspan="9">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td class="border_all" rowspan="3" colspan="3">2 Consignor/Exporter&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BIN:<br><?php echo $rslt_show_report[0]['exporter_name']; ?></td>
		<td class="border_all" colspan="2">1 Declaration<br><?php echo $rslt_show_report[0]['dec_type']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rslt_show_report[0]['dec_gen_code']; ?></td>
		<td class="border_all" rowspan="2" colspan="2"><?php echo $rslt_show_report[0]['office_code']; ?>&nbsp;&nbsp;&nbsp;&nbsp;Office Code<br><?php echo $rslt_show_report[0]['office_name']; ?><br><br>Registration<br><?php echo $rslt_show_report[0]['reg_serial']; ?>&nbsp;&nbsp;&nbsp;<span style="background-color:#a5da68"><?php echo $rslt_show_report[0]['reg_no']; ?></span>&nbsp;&nbsp;&nbsp;<span style="background-color:#a5da68"><?php echo $rslt_show_report[0]['reg_date']; ?></span><br><br>Manifest&nbsp;&nbsp;&nbsp;&nbsp;<span style="background-color:#a5da68"><?php echo $rslt_show_report[0]['manif_num']; ?></span></td>
	</tr>
	<tr>
		<td class="border_all" colspan="1">3 Pages<br><?php echo $rslt_show_report[0]['sel_page']; ?></td>	
		<td class="border_all" colspan="1">4 N/A</td>	
	</tr>
	<tr>
		<td class="border_all" colspan="1">6 Items<br><?php echo $rslt_show_report[0]['num_item']; ?></td>
		<td class="border_all" colspan="1">6 Tot Pack<br><?php echo $rslt_show_report[0]['num_pkgs']; ?></td>
		<td class="border_all" colspan="2">7 Agent Reference number<br><?php echo $rslt_show_report[0]['dec_ref_no']; ?></td>
	</tr>
	<tr>
		<td class="border_all" rowspan="2" colspan="3">8 Consignee/Importer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BIN:<?php echo $rslt_show_report[0]['consignee_code']; ?><br><br><?php echo $rslt_show_report[0]['consignee_name']; ?></td>
		<td class="border_all" colspan="4">9 N/A<br>1</td>
	</tr>
	<tr>
		<td class="border_all">Cty.s last</td>
		<td class="border_all">11 N/A</td>
		<td class="border_all">12 Value details<br><?php echo $rslt_show_report[0]['total_value']; ?></td>
		<td class="border_all">13 N/A</td>				
	</tr>
	<tr>
		<td class="border_all" rowspan="2" colspan="3">14. Declarant/Agent&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AIN:<?php echo $rslt_show_report[0]['dec_code']; ?><br><br><?php echo $rslt_show_report[0]['dec_name']; ?></td>
		<td class="border_all" colspan="2">15 Country of export<br><?php echo $rslt_show_report[0]['ex_country_name']; ?></td>
		<td class="border_all" colspan="1">15 CE Code<br><br></td>
		<td class="border_all" colspan="1">17 CD Code<br><br></td>
	</tr>
	<tr>
		<td class="border_all" colspan="2">16 Country of origin<br><span style="background-color:#a5da68"><?php echo $rslt_show_report[0]['country_of_origin']; ?></span></td>
		<td class="border_all" colspan="2">17 Country of destination<br><br></td>
	</tr>
	<tr>
		<td class="border_all" colspan="3">18 Identity and nationality of means of transport at arrival&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;19 CF
		<br>
		<span style="background-color:#a5da68"><?php echo $vsl_name; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| SG</td>
		<td class="border_all" colspan="4">20 Delivery terms<br><?php echo $rslt_show_report[0]['del_terms_code']; ?>&nbsp;&nbsp;&nbsp;|</td>
	</tr>
	<tr>
		<td class="border_all" colspan="3">
			21 N/A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BSTI&nbsp;&nbsp;&nbsp;N.Cash
		</td>
		<td class="border_all">22 Cur Total Invoice Value<br><?php echo $rslt_show_report[0]['gs_inv_cur_code']; ?> | <?php echo $rslt_show_report[0]['total_invoice']; ?></td>
		<td class="border_all" colspan="1">23 Exch. rate<br><?php echo $rslt_show_report[0]['gs_inv_cur_rate']; ?></td>
		<td class="border_all" colspan="2">24 Nature of transac.<br><?php echo $rslt_show_report[0]['financ_code1']; ?>&nbsp;&nbsp;|<?php echo $rslt_show_report[0]['financ_code2']; ?>&nbsp;&nbsp;|</td>
	</tr>
	<tr>
		<td class="border_left_right">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td class="border_left_right">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td class="border_all">25 MOT<br>1&nbsp;&nbsp;|</td>
		<td class="border_all">26 MOT<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| Domestic</td>
		<td class="border_all">27 Place of discharge
		<br>
		<?php echo $rslt_show_report[0]['plc_load_code']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rslt_show_report[0]['plc_load_name']; ?></td>
		<td class="border_all" colspan="4" rowspan="2">
			<span style="background-color:#a5da68">28 Financial and banking data</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bank Code&nbsp;&nbsp;&nbsp;<?php echo $rslt_show_report[0]['bank_code']; ?>
			<br><br>
			Branch&nbsp;&nbsp;&nbsp;<?php echo $rslt_show_report[0]['bank_branch']; ?> &nbsp;&nbsp;&nbsp;LC No.<?php echo $rslt_show_report[0]['bank_ref']; ?>
			<br><br>
			Bank Name <?php echo $rslt_show_report[0]['bank_name']; ?>
			<br><br>
			Sector & Fund Src <?php echo $rslt_show_report[0]['financ_terms_code']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rslt_show_report[0]['financ_terms_desc']; ?>
		</td>
	</tr>
	<tr>
		<td class="left_bottom_right">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td class="left_bottom_right">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td class="border_all" colspan="2">29 Office of entry
		<br>
		<?php echo $rslt_show_report[0]['border_off_code']; ?>&nbsp;&nbsp;&nbsp;<?php echo $rslt_show_report[0]['border_off_name']; ?>
		</td>
		<td class="border_all">30 Location of goods 
		<br>
		<?php echo $rslt_show_report[0]['loc_goods']; ?></td>
	</tr>
	<!-- loop start -->
	<?php
	for($i=0;$i<count($rslt_show_report);$i++)
	{
	?>
	<tr>
		<td class="border_all" colspan="2" rowspan="5">31 Packages<br>and<br>description<br>of goods</td>
		<td class="top_left_bottom" colspan="3" rowspan="5">
			Marks and numbers
			<br>
			Fine/Penalty
			<br>
			Nber of Pkgs&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="background-color:#a5da68"><?php echo $rslt_show_report[$i]['pkgs_no']; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
			Pkg Code <?php echo $rslt_show_report[$i]['pkgs_code']; ?>
			<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php echo $rslt_show_report[$i]['pkgs_name']; ?>
			<br>
			<br>
			Containers No(s)
			<br>
			Description of Goods,Brand,Model,Size
			<br>
			<?php echo $rslt_show_report[$i]['goods_desc']; ?>
			<br>
			<?php echo $rslt_show_report[$i]['commerc_desc']; ?>
		</td>
		<td class="border_all">
			32 Item
			<br>
			<?php //echo $rslt_show_report[0]['num_item']; ?>| No.
			<?php echo $i+1; ?>| No.
		</td>
		<td class="border_all" colspan="2">
			33 HS Code
			<br>
			<?php echo $rslt_show_report[$i]['hs_code']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $rslt_show_report[$i]['hs_prec_1']; ?>
		</td>
		<td class="border_all"></td>
	</tr>
	<tr>
		<td></td>
		<td class="border_all">
			34 Cty.orig.Code
			<br>
			<?php echo $rslt_show_report[$i]['cntry_origin_code']; ?>
			</td>
		<td class="border_all"><span style="background-color:#a5da68">35 Gross weight (kg)<br><?php echo $rslt_show_report[$i]['gross_weight_item']; ?></span></td>
		<td class="border_all">36 Agr. Cd</td>
	</tr>
	<tr>
		<td></td>
		<td class="border_all">37 CPC<br><?php echo $rslt_show_report[$i]['ext_cust_proc']; ?>&nbsp;&nbsp;|<?php echo $rslt_show_report[$i]['nat_cust_proc']; ?></td>
		<td class="border_all"><span style="background-color:#a5da68">38 Net weight (kg)<br><?php echo $rslt_show_report[$i]['net_weight_item']; ?></span></td></td>
		<td class="border_all">39 Visa Ref</td>
	</tr>
	<tr>
		<td></td>
		<td class="border_all" colspan="3"><span style="background-color:#a5da68">40 BL/AWB/TR/RR No</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S/L
		<br>
		<span style="background-color:#a5da68"><?php echo $rslt_show_report[$i]['sum_declare']; ?></td></span>
	</tr>
	<tr>
		<td class="bottom_right"></td>
		<td class="border_all">41 Quant/Units
			<br>
			<?php echo $rslt_show_report[$i]['sup_unit_code']; ?>&nbsp;&nbsp;&nbsp;<?php echo $rslt_show_report[$i]['sup_unit_quant']; ?>
		</td>
		<td class="border_all">42 Item Price
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rslt_show_report[$i]['item_price']; ?></td>
		<td class="border_all">43 V.M.
		<br>&nbsp;&nbsp;&nbsp;| code</td>
	</tr>
	<tr>
		<td class="border_all" rowspan="2" colspan="2">44. Add. info<br>Documents<br>Produced<br>Certificates<br>and authorization</td>
		<td class="border_all" rowspan="2" colspan="3">CRF/EXP No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UP/UD
			<br><?php echo $rslt_show_report[$i]['value_item']; ?>
			<br>A.D. <?php echo $rslt_show_report[$i]['attac_doc_item']; ?>
			<br>
			<br>INV <?php echo $rslt_show_report[$i]['free_text_1']; ?>
		</td>
		<td class="border_all" colspan="2">Dec.U.Price Ass.U.Price A.I. Code</td>
		<td class="border_all" colspan="2">45. Adjustment<br><?php echo $rslt_show_report[$i]['rate_of_adjustement']; ?></td>
	</tr>
	<tr>
		<td class="border_all" colspan="2">41. bis Write-off units</td>
		<td class="border_all" colspan="2">46. Statistical value
			<br><?php echo $rslt_show_report[$i]['stat_value']; ?>
		</td>
	</tr>
	<tr>
		<td class="border_all" rowspan="2" colspan="2">47. Calculation<br>of taxes</td>
		<td class="border_all" rowspan="2" colspan="3">
			<table style="margin:0 0 0 0;width:500px;" valign="top">
				<tr>
					<td class="bottom_right">Type</td>
					<td style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">Tax base</td>
					<td style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">Rate</td>
					<td style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">Amount</td>
					<td style="border-bottom:1px solid black;border-left:1px solid black;">MP</td>
				</tr>
				<tr>
					<td class="bottom_right"><?php echo $rslt_show_report[$i]['cd_tax_code']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['cd_tax_base']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['cd_tax_rate']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['cd_tax_amt']; ?></td>
					<td class="bottom_left"><?php echo $rslt_show_report[$i]['cd_tax_mp']; ?></td>
				</tr>
				<tr>
					<td class="bottom_right"><?php echo $rslt_show_report[$i]['rd_tax_code']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['rd_tax_base']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['rd_tax_rate']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['rd_tax_amt']; ?></td>
					<td class="bottom_left"><?php echo $rslt_show_report[$i]['rd_tax_mp']; ?></td>
				</tr>
				<tr>
					<td class="bottom_right"><?php echo $rslt_show_report[$i]['sd_tax_code']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['sd_tax_base']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['sd_tax_rate']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['sd_tax_amt']; ?></td>
					<td class="bottom_left"><?php echo $rslt_show_report[$i]['sd_tax_mp']; ?></td>
				</tr>
				<tr>
					<td class="bottom_right"><?php echo $rslt_show_report[$i]['vat_tax_code']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['vat_tax_base']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['vat_tax_rate']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['vat_tax_amt']; ?></td>
					<td class="bottom_left"><?php echo $rslt_show_report[$i]['vat_tax_mp']; ?></td>
				</tr>
				<tr>
					<td class="bottom_right"><?php echo $rslt_show_report[$i]['ait_tax_code']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['ait_tax_base']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['ait_tax_rate']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['ait_tax_amt']; ?></td>
					<td class="bottom_left"><?php echo $rslt_show_report[$i]['ait_tax_mp']; ?></td>
				</tr>
				<tr>
					<td class="bottom_right"><?php echo $rslt_show_report[$i]['atv_tax_code']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['atv_tax_base']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['atv_tax_rate']; ?></td>
					<td class="left_bottom_right"><?php echo $rslt_show_report[$i]['atv_tax_amt']; ?></td>
					<td class="bottom_left"><?php echo $rslt_show_report[$i]['atv_tax_mp']; ?></td>
				</tr>
				<tr>
					<td colspan="3" align="center">Total</td>
					<td><?php echo $rslt_show_report[$i]['item_tax_amt']; ?></td>
					<td>1</td>
				</tr>
			</table>			
		</td>
		<td colspan="2" class="border_all">48 Account Current No</td>
		<td colspan="2" class="border_all">49 Warehouse Number/Period</td>
	</tr>
	<tr>
		<td colspan="4" class="border_all">49 B ACCOUNTING DETAILS
			<br>
			<br>
			Mode of payment&nbsp;&nbsp;&nbsp;<?php echo $rslt_show_report[$i]['payment_mode']; ?>
			<br>
			Assessment number&nbsp;&nbsp;&nbsp;<span style="background-color:#a5da68"><?php echo $rslt_show_report[$i]['ass_serial']; ?>&nbsp;&nbsp;&nbsp;<?php echo $rslt_show_report[0]['ass_no']; ?>&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;<?php echo $rslt_show_report[$i]['ass_date']; ?></span>
			<br>
			Receipt number&nbsp;&nbsp;&nbsp;<span style="background-color:#a5da68"><?php echo $rslt_show_report[$i]['recp_serial']; ?>&nbsp;&nbsp;&nbsp;<?php echo $rslt_show_report[0]['recp_no']; ?>&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;<?php echo $rslt_show_report[$i]['recp_date']; ?></span>
			<br>
			Guarantee&nbsp;&nbsp;&nbsp;<?php echo $rslt_show_report[$i]['guarante_amnt']; ?>&nbsp;&nbsp;&nbsp;Date
			<br>
			Total fees&nbsp;&nbsp;&nbsp;<?php echo $rslt_show_report[$i]['global_tax']; ?>&nbsp;&nbsp;&nbsp;BDT
			<br>
			Total declaration&nbsp;&nbsp;&nbsp;<?php echo $rslt_show_report[$i]['total_tax']; ?>&nbsp;&nbsp;&nbsp;BDT
		</td>
	</tr>
	<!-- loop end -->
	<?php
	}
	?>
	<tr>
		<td class="border_all" colspan="2" rowspan="2">
			<br>
			<br>
			<br>
			<hr>
			51 Intended<br>offices<br>of transit<br>and country
		</td>
		<td class="border_all" colspan="4">50 Principal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature
			<br>
			<br>
			<br>
			<br>
			Represented By
			<br>
			Place and date
		</td>
		<td class="border_all" colspan="3">C OFFICEOFDEPARTURE</td>
	</tr>
	<tr>
		<td class="border_all">
			&nbsp;
		</td>
		<td class="border_all">
			&nbsp;
		</td>
		<td class="border_all">
			&nbsp;
		</td>
		<td class="border_all">
			&nbsp;
		</td>
		<td class="border_all" colspan="2">&nbsp;</td>
		<td class="border_all" colspan="1">&nbsp;</td>
	</tr>
	<tr>
		<td class="border_all" colspan="6">
			52 Guarantee not valid for&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Code
		</td>
		<td class="border_all" colspan="3">53 Office of destination and country</td>
	</tr>
	<tr>
		<td class="border_all" colspan="6">
			D CONTROLBYOFFICEOFDESTINATION&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stamp:
			<br>
			<br>
			<br>
			Signature
		</td>
		<td class="border_all" colspan="3">54 Place and date
		<br>
		<?php echo $rslt_show_report[0]['dec_rep']; ?>
		</td>
	</tr>
</table>

<?php
if(count($rslt_cont_info)!=0)
{
?>
<table border="1" style="border-collapse:collapse;width:100%;">
	<tr>
		<td colspan="9" align="center"><b>Container List</b></td>
	</tr>
	<tr>
		<th>Sl</th>
		<th>Container No</th>
		<th>Type</th>
		<th>Status</th>
		<th>Gross Weight</th>
		<th>Goods Description</th>
		<th>Package Type</th>
		<th>Package Number</th>
		<th>Package Weight</th>
	</tr>
	<?php
	for($i=0;$i<count($rslt_cont_info);$i++)
	{
	?>
	<tr>
		<td align="center"><?php echo $i+1; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['cont_number']; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['cont_type']; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['freight_kind']; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['gross_wt']; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['goods_desc']; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['pkg_type']; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['pkg_num']; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['pkg_wt']; ?></td>
	</tr>
	<?php
	}
	?>
</table>
<?php
}
?>