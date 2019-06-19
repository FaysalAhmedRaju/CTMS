<HTML>
	<HEAD>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
</HEAD>
<BODY>

	<?php
		$tot_cr_50=0;
		$tot_cr_30=0;
		$tot_cr_20=0;
		$tot_cr_10=0;
		$tot_fr_20=0;
		$tot_fr_10=0;
		$tot_fr_5=0;
		$tot_fr_3=0;
		$tot_rrc=0;
		
		include("dbConection.php");
	//	$indent_date=$_POST['indent_date']; 
	?>
	
	<table width="95%" align="center">
		<tr>
			<td colspan="10" align="center"><h3> চট্টগ্রাম বন্দর কর্তৃপক্ষ </h3></td>
		</tr>
		<tr>
			<td class="defaultColor" colspan="10" align="center"> টার্মিনাল ম্যানেজার দপ্তর </td>
		</tr>
		<tr>
			<td colspan="10" align="center"> www.cpa.gov.bd </td>
		</tr>
		<tr>
			<td colspan="8" align="left"> নথি নং- টিএম/ইক্যুঃ অপাঃ প্ল্যানিং/যাঃ উঃ/চাহিদা-সরবরাহ/১৮ </td>
			<td colspan="3" align="center"> তারিখঃ <?php echo  date('d-m-Y', strtotime($indent_date)); ?> </td>
		</tr>
		<tr>
			<td colspan="10" align="left">বরাবর</td>
		</tr>
		<tr>
			<td colspan="10" align="left">ওয়ার্কসপ ম্যানেজার</td>
		</tr>
		<tr>
			<td colspan="10" align="left">চট্টগ্রাম বন্দর কর্তৃপক্ষ।</td>
		</tr>
		<tr>
			<td colspan="10" align="left"><b> বিষয়ঃ <u> চাহিদা মোতাবেক যান্ত্রিক উপকরণ সরবরাহ প্রসংগে </u></b></td>
		</tr>
		<tr>			
			<td colspan="10" align="left">নিম্নোক্ত যান্ত্রিক উপকরণগুলি  <?php echo date('d-m-Y', strtotime($indent_date. ' + 1 days'));?> তারিখে কন্টেইনারবাহীত মালামাল ডেলিভারী এবং আনস্টাফিং কাজের চাহিদা মোতাবেক সরবরাহের জন্য অনুরোধ করা গেল।</td>
		</tr>
		<tr>
			<td colspan="10">&nbsp;</td>
		</tr>
		<tr>
			<th align="center" colspan="10" style="border:1px solid black">
				চাহিদা (ডেলিভারী/হোয়েস্টিং)
			</th>
		</tr>
		<tr>
			<th align="center" rowspan="2" style="border:1px solid black">
				ইয়ার্ড/শেড
			</th>
			<th align="center" colspan="9" style="border:1px solid black">
				যান্ত্রিক উপকরণ ও ক্ষমতা
			</th>
		</tr>
		<tr>
			<th style="border:1px solid black" align="center">ক্রেন ১০ টন </th>
			<th style="border:1px solid black" align="center">ক্রেন ২০ টন   </th>
			<th style="border:1px solid black" align="center">ক্রেন ৩০ টন </th>
			<th style="border:1px solid black" align="center"> ক্রেন ৫০ টন </th>
			<th style="border:1px solid black" align="center">ফর্ক লিফট ০৩ টন  </th>
			<th style="border:1px solid black" align="center">ফর্ক লিফট ০৫ টন  </th>
			<th style="border:1px solid black" align="center">ফর্ক লিফট  ১০ টন </th>
			<th style="border:1px solid black" align="center">ফর্ক লিফট  ২০ টন  </th>
			<th style="border:1px solid black" align="center">RRC</th>
		</tr>
	<?php 
		$getAllYard="SELECT id,yard_name FROM ctmsmis.mis_equip_indent";
		$result=mysql_query($getAllYard);
		$i=0;
		while ($row=mysql_fetch_object($result))
		{
	?>
		<tr>
			<td style="border:1px solid black" align="center"><?php echo $row->yard_name; ?></td>
			<?php 
			$get_mc_50_qry="";
			$result_mc="";
			$row_mc="";
				$get_mc_50_qry="select sum(no_of_mc) as tot from ctmsmis.mis_equip_indent_entry where equip_mc_10t=1 and date(entry_dt)='$indent_date' and indent_yard_id=$row->id";
				$result_mc=mysql_query($get_mc_50_qry);
				$row_mc=mysql_fetch_object($result_mc);
			?>
			<td style="border:1px solid black" align="center">
				<?php 
					if($row_mc->tot)
					{
						echo $row_mc->tot; 
						$tot_cr_50=$tot_cr_50+$row_mc->tot;
					}
					else 
						echo "-"; 
				?>
			</td>
			<?php 
				$get_mc_50_qry="";
				$result_mc="";
				$row_mc="";
				$get_mc_50_qry="select sum(no_of_mc) as tot from ctmsmis.mis_equip_indent_entry where equip_mc_20t=1 and date(entry_dt)='$indent_date' and indent_yard_id=$row->id";
				echo $get_mc_50_qry;
				$result_mc=mysql_query($get_mc_50_qry);
				$row_mc=mysql_fetch_object($result_mc);
			?>
			<td style="border:1px solid black" align="center">
				<?php 
					if($row_mc->tot) 
					{
						echo $row_mc->tot; 
						$tot_cr_30=$tot_cr_30+$row_mc->tot;
					}						
					else 
						echo "-"; 
				?>
			</td>
			<?php 
				$get_mc_50_qry="";
				$result_mc="";
				$row_mc="";
				$get_mc_50_qry="select sum(no_of_mc) as tot from ctmsmis.mis_equip_indent_entry where equip_mc_30t=1 and date(entry_dt)='$indent_date' and indent_yard_id=$row->id";
				$result_mc=mysql_query($get_mc_50_qry);
				$row_mc=mysql_fetch_object($result_mc);
			?>
			<td style="border:1px solid black" align="center">
				<?php 
					if($row_mc->tot) 
					{
						echo $row_mc->tot; 
						$tot_cr_20=$tot_cr_20+$row_mc->tot;
					}
					else 
						echo "-"; 
				?>
			</td>
			<?php 
				$get_mc_50_qry="";
				$result_mc="";
				$row_mc="";
				$get_mc_50_qry="select sum(no_of_mc) as tot from ctmsmis.mis_equip_indent_entry where equip_mc_50t=1 and date(entry_dt)='$indent_date' and indent_yard_id=$row->id";
				$result_mc=mysql_query($get_mc_50_qry);
				$row_mc=mysql_fetch_object($result_mc);
			?>
			<td style="border:1px solid black" align="center">
				<?php 
					if($row_mc->tot)
					{						
						echo $row_mc->tot; 
						$tot_cr_10=$tot_cr_10+$row_mc->tot;
					}
					else 
						echo "-"; ?>
			</td>
			<?php 
				$get_mc_50_qry="";
				$result_mc="";
				$row_mc="";
				$get_mc_50_qry="select sum(no_of_flt) as tot from ctmsmis.mis_equip_indent_entry where equip_flt_3t=1 and date(entry_dt)='$indent_date' and indent_yard_id=$row->id";
				$result_mc=mysql_query($get_mc_50_qry);
				$row_mc=mysql_fetch_object($result_mc);
			?>
			<td style="border:1px solid black" align="center">
				<?php 
					if($row_mc->tot) 
					{
						echo $row_mc->tot; 
						$tot_fr_20=$tot_fr_20+$row_mc->tot;
					}
					else 
						echo "-"; 
				?>
			</td>
			<?php 
				$get_mc_50_qry="";
				$result_mc="";
				$row_mc="";
				$get_mc_50_qry="select sum(no_of_flt) as tot from ctmsmis.mis_equip_indent_entry where equip_flt_5t=1 and date(entry_dt)='$indent_date' and indent_yard_id=$row->id";
				$result_mc=mysql_query($get_mc_50_qry);
				$row_mc=mysql_fetch_object($result_mc);
			?>
			<td style="border:1px solid black" align="center">
				<?php 
					if($row_mc->tot) 
					{
						echo $row_mc->tot; 
						$tot_fr_10=$tot_fr_10+$row_mc->tot;
					}						
					else 
						echo "-"; 
				?>
			</td>
			<?php 
				$get_mc_50_qry="";
				$result_mc="";
				$row_mc="";
				$get_mc_50_qry="select sum(no_of_flt) as tot from ctmsmis.mis_equip_indent_entry where equip_flt_10t=1 and date(entry_dt)='$indent_date' and indent_yard_id=$row->id";
				$result_mc=mysql_query($get_mc_50_qry);
				$row_mc=mysql_fetch_object($result_mc);
			?>
			<td style="border:1px solid black" align="center">
				<?php 
					if($row_mc->tot) 
					{
						echo $row_mc->tot; 
						$tot_fr_5=$tot_fr_5+$row_mc->tot;
					}
					else 
						echo "-"; 
				?>
			</td>
			<?php 
				$get_mc_50_qry="";
				$result_mc="";
				$row_mc="";
				$get_mc_50_qry="select sum(no_of_flt) as tot from ctmsmis.mis_equip_indent_entry where equip_flt_20t=1 and date(entry_dt)='$indent_date' and indent_yard_id=$row->id";
				$result_mc=mysql_query($get_mc_50_qry);
				$row_mc=mysql_fetch_object($result_mc);
			?>
			<td style="border:1px solid black" align="center">
				<?php 
					if($row_mc->tot) 
					{
						echo $row_mc->tot; 
						$tot_fr_3=$tot_fr_3+$row_mc->tot;
					}
					else 
						echo "-"; 
				?>
			</td>
			<?php 
				$get_mc_50_qry="";
				$result_mc="";
				$row_mc="";
				$get_mc_50_qry="select sum(no_of_rrc) as tot from ctmsmis.mis_equip_indent_entry where equip_rrc=1 and date(entry_dt)='$indent_date' and indent_yard_id=$row->id";
				$result_mc=mysql_query($get_mc_50_qry);
				$row_mc=mysql_fetch_object($result_mc);
			?>
			<td style="border:1px solid black" align="center">
				<?php 
					if($row_mc->tot) 
					{
						echo $row_mc->tot; 
						$tot_rrc=$tot_rrc+$row_mc->tot;
					}
					else 
						echo "-"; 
				?>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td style="border:1px solid black" align="center">মোট = </td>
			<td style="border:1px solid black" align="center">
				<?php 
					if($tot_cr_50)
						echo $tot_cr_50;
					else
						echo "";
					?>
			</td>
			<td style="border:1px solid black" align="center">
				<?php 
					if($tot_cr_30)
						echo $tot_cr_30;
					else
						echo "";
					?>
			</td>
			<td style="border:1px solid black" align="center">
				<?php
					if($tot_cr_20)
						echo $tot_cr_20;
					else
						echo "";
				?>
			</td>
			<td style="border:1px solid black" align="center">
				<?php
					if($tot_cr_10)
						echo $tot_cr_10; 
					else
						echo ""
				?>
			</td>
			<td style="border:1px solid black" align="center">
				<?php 
					if($tot_fr_20)
						echo $tot_fr_20;
					else
						echo "";
				?>
			</td>
			<td style="border:1px solid black" align="center">
				<?php 
					if($tot_fr_10)
						echo $tot_fr_10; 
					else
						echo "";
				?>
			</td>
			<td style="border:1px solid black" align="center">
				<?php 
					if($tot_fr_5)
						echo $tot_fr_5; 
					else
						echo "";
				?>
			</td>
			<td style="border:1px solid black" align="center">
				<?php 
					if($tot_fr_3)
						echo $tot_fr_3;
					else
						echo "";	
				?>
			</td>
			<td style="border:1px solid black" align="center">
				<?php 
					if($tot_rrc)
						echo $tot_rrc;
					else
						echo "";
				?>
			</td>
		</tr>	
		</table>
		<table width="95%" align="center">
		<tr>
			<td style="border:1px solid black" colspan="16">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="16" style="border:1px solid black">চাহিদা (এল সি এল কন্টেইনার আনস্টাফিং)</th>
		</tr>
		<tr>
			<th style="border:1px solid black" colspan="2">বার্থ অপারেটর</th>
			<th style="border:1px solid black" colspan="2">জাহাজ</th>
			<th style="border:1px solid black">আঃ পাঃ</th>
			<th style="border:1px solid black">শেড </th>
			<th style="border:1px solid black">বুশকার</th>
			<th style="border:1px solid black">লং ট্রলি</th>
			<th style="border:1px solid black" align="center">ক্রেন ৫০ টন </th>
			<th style="border:1px solid black" align="center">ক্রেন ৩০ টন </th>
			<th style="border:1px solid black" align="center">ক্রেন ২০ টন  </th>
			<th style="border:1px solid black" align="center">ক্রেন ১০ টন  </th>
			<th style="border:1px solid black" align="center">FLT ০৩ টন  </th>
			<th style="border:1px solid black" align="center">FLT ০৫ টন  </th>
			<th style="border:1px solid black" align="center">FLT ১০ টন  </th>
			<th style="border:1px solid black" align="center">FLT ২০ টন  </th>
		</tr>
		<?php
		$tot_bushkar=0;
		$tot_long_trolly=0;
		$tot_flt_3=0;
		$tot_flt_5=0;
		$tot_flt_10=0;
		$tot_flt_20=0;
		$tot_mc_10=0;
		$tot_mc_20=0;
		$tot_mc_30=0;
		$tot_mc_50=0;
		
		$sql_equip_unstuffing="SELECT vsl_name,berth_op,up_no,shed_no,rotation,
		buskar,
		SUM(IFNULL(long_trolly,0)) AS long_trolly,
		IF(flt_3t>0,SUM(no_of_flt),0) AS flt_3t,
		IF(flt_5t>0,SUM(no_of_flt),0) AS flt_5t,
		IF(flt_10t>0,SUM(no_of_flt),0) AS flt_10t,
		IF(flt_20t>0,SUM(no_of_flt),0) AS flt_20t,

		IF(mc_10t>0,SUM(no_of_mc),0) AS mc_10t,
		IF(mc_20t>0,SUM(no_of_mc),0) AS mc_20t,
		IF(mc_30t>0,SUM(no_of_mc),0) AS mc_30t,
		IF(mc_50t>0,SUM(no_of_mc),0) AS mc_50t
		FROM ctmsmis.mis_equip_unstuffing 
		WHERE DATE(entry_date)='$indent_date'
		GROUP BY berth_op";
		
		$rslt_equip_unstuffing=mysql_query($sql_equip_unstuffing);
		
		while($row_equip_unstuffing=mysql_fetch_object($rslt_equip_unstuffing))
		{
			
		?>
		<tr>
			<td align="center" style="border:1px solid black" colspan="2"><?php if($row_equip_unstuffing->berth_op) echo $row_equip_unstuffing->berth_op; else echo "-"; ?></td>
			<td align="center" style="border:1px solid black" colspan="2"><?php if($row_equip_unstuffing->vsl_name) echo $row_equip_unstuffing->vsl_name; else echo "-";?></td>
			<td align="center" style="border:1px solid black"><?php if($row_equip_unstuffing->rotation) echo $row_equip_unstuffing->rotation; else echo "-"; ?></td>
			<td align="center" style="border:1px solid black"><?php if($row_equip_unstuffing->shed_no) echo $row_equip_unstuffing->shed_no; else echo "-"; ?></td>
			<td align="center" style="border:1px solid black"><?php if($row_equip_unstuffing->buskar) echo $row_equip_unstuffing->buskar; else echo "-"; ?></td>
			<td align="center" style="border:1px solid black">
				<?php 
					if($row_equip_unstuffing->long_trolly) 
					{
						echo $row_equip_unstuffing->long_trolly;
						$tot_long_trolly=$tot_long_trolly+$row_equip_unstuffing->long_trolly;						
					}
					else 
						echo "-"; 
				?>
			</td>
			<td align="center" style="border:1px solid black">
				<?php 
					
					$query_mc_50t="SELECT SUM(no_of_flt) AS mc_50t FROM ctmsmis.mis_equip_unstuffing WHERE mc_50t=1 AND DATE(entry_date)='$indent_date' and berth_op='".$row_equip_unstuffing->berth_op."'";
					$rslt_mc_50t=mysql_query($query_mc_50t);
					$row_mc_50t=mysql_fetch_object($rslt_mc_50t);
					if($row_mc_50t->mc_50t) 
					{
						echo $row_mc_50t->mc_50t; 
						$tot_mc_50=$tot_mc_50+$row_mc_50t->mc_50t;
					}
					else 
						echo "-"; 
				?>
			</td>
			<td align="center" style="border:1px solid black">
				<?php 
					$query_mc_30t="SELECT SUM(no_of_flt) AS mc_30t FROM ctmsmis.mis_equip_unstuffing WHERE mc_30t=1 AND DATE(entry_date)='$indent_date' and berth_op='".$row_equip_unstuffing->berth_op."'";
					$rslt_mc_30t=mysql_query($query_mc_30t);
					$row_mc_30t=mysql_fetch_object($rslt_mc_30t);
					if($row_mc_30t->mc_30t) 
					{
						echo $row_mc_30t->mc_30t; 
						$tot_mc_30=$tot_mc_30+$row_mc_30t->mc_30t;
					}
					else 
						echo "-"; 
				?>
			</td>
			<td align="center" style="border:1px solid black">
				<?php 
					$query_mc_20t="SELECT SUM(no_of_flt) AS mc_20t FROM ctmsmis.mis_equip_unstuffing WHERE mc_20t=1 AND DATE(entry_date)='$indent_date' and berth_op='".$row_equip_unstuffing->berth_op."'";
					$rslt_mc_20t=mysql_query($query_mc_20t);
					$row_mc_20t=mysql_fetch_object($rslt_mc_20t);
					if($row_mc_20t->mc_20t) 
					{
						echo $row_mc_20t->mc_20t; 
						$tot_mc_20=$tot_mc_20+$row_mc_20t->mc_20t;
					}
					else 
						echo "-"; 
				?>
			</td>
			<td align="center" style="border:1px solid black">
				<?php 
					$query_mc_10t="SELECT SUM(no_of_flt) AS mc_10t FROM ctmsmis.mis_equip_unstuffing WHERE mc_10t=1 AND DATE(entry_date)='$indent_date' and berth_op='".$row_equip_unstuffing->berth_op."'";
					$rslt_mc_10t=mysql_query($query_mc_10t);
					$row_mc_10t=mysql_fetch_object($rslt_mc_10t);
					if($row_mc_10t->mc_10t) 
					{
						echo $row_mc_10t->mc_10t; 
						$tot_mc_10=$tot_mc_10+$row_mc_10t->mc_10t;
					}
					else 
						echo "-"; 
				?>
			</td>
			<td align="center" style="border:1px solid black">
				<?php 
					$query_3t="SELECT SUM(no_of_flt) AS flt_3t FROM ctmsmis.mis_equip_unstuffing WHERE flt_3t=1 AND DATE(entry_date)='$indent_date' and berth_op='".$row_equip_unstuffing->berth_op."'";
					$rslt_3t=mysql_query($query_3t);
					$row_3t=mysql_fetch_object($rslt_3t);
					if($row_3t->flt_3t) 
					{
						echo $row_3t->flt_3t; 
						$tot_flt_3=$tot_flt_3+$row_3t->flt_3t;
					}
					else 
						echo "-"; 
				?>
			</td>
			<td align="center" style="border:1px solid black">
				<?php 
					$query_5t="SELECT SUM(no_of_flt) AS flt_5t FROM ctmsmis.mis_equip_unstuffing WHERE flt_5t=1 AND DATE(entry_date)='$indent_date' and berth_op='".$row_equip_unstuffing->berth_op."'";
					$rslt_5t=mysql_query($query_5t);
					$row_5t=mysql_fetch_object($rslt_5t);
					if($row_5t->flt_5t) 
					{
						echo $row_5t->flt_5t; 
						$tot_flt_5=$tot_flt_5+$row_5t->flt_5t;
					}
					else 
						echo "-"; 
				?>
			</td>
			<td align="center" style="border:1px solid black">
				<?php 
					$query_10t="SELECT SUM(no_of_flt) AS flt_10t FROM ctmsmis.mis_equip_unstuffing WHERE flt_10t=1 AND DATE(entry_date)='$indent_date' and berth_op='".$row_equip_unstuffing->berth_op."'";
					$rslt_10t=mysql_query($query_10t);
					$row_10t=mysql_fetch_object($rslt_10t);
					
					if($row_10t->flt_10t) 
					{
						echo $row_10t->flt_10t; 
						$tot_flt_10=$tot_flt_10+$row_10t->flt_10t;
					}
					else 
						echo "-"; 
				?>
			</td>
			<td align="center" style="border:1px solid black">
				<?php 
					$query_20t="SELECT SUM(no_of_flt) AS flt_20t FROM ctmsmis.mis_equip_unstuffing WHERE flt_20t=1 AND DATE(entry_date)='$indent_date' and berth_op='".$row_equip_unstuffing->berth_op."'";
					$rslt_20t=mysql_query($query_20t);
					$row_20t=mysql_fetch_object($rslt_20t);
					if($row_20t->flt_20t) 
					{
						echo $row_20t->flt_20t; 
						$tot_flt_20=$tot_flt_20+$row_20t->flt_20t;
					}
					else 
						echo "-"; 
				?>
			</td>
			
			
		</tr>
		<?php
		}
		?>
		<tr>
			<td style="border:1px solid black" align="center" colspan="2">মোট = </td>
			<td style="border:1px solid black" align="center" colspan="2">&nbsp;</td>
			<td style="border:1px solid black" align="center">&nbsp;</td>
			<td style="border:1px solid black" align="center">&nbsp;</td>
			<td style="border:1px solid black" align="center">
				<?php 
					if($tot_bushkar)
						echo $tot_bushkar; 
					else
						echo "";
					?>
			</td>
			<td style="border:1px solid black" align="center">
				<?php
					if($tot_long_trolly)
						echo $tot_long_trolly;
					else
						echo "";
				?>
			</td>
			<td style="border:1px solid black" align="center">
				<?php
					if($tot_mc_50)
						echo $tot_mc_50;
					else	
						echo "";
				?>
			</td>
			<td style="border:1px solid black" align="center">
				<?php 
					if($tot_mc_30)
						echo $tot_mc_30; 
					else
						echo "";
				?>
			</td>	
			<td style="border:1px solid black" align="center">
				<?php 
					if($tot_mc_20)
						echo $tot_mc_20; 
					else
						echo "";
				?>
			</td>	
			<td style="border:1px solid black" align="center">
				<?php 
					if($tot_mc_10)
						echo $tot_mc_10; 
					else
						echo "";
				?>
			</td>	
			<td style="border:1px solid black" align="center">
				<?php 
					if($tot_flt_3)
						echo $tot_flt_3; 
					else
						echo "";
				?>
			</td>	
			<td style="border:1px solid black" align="center">
				<?php 
					if($tot_flt_5)
						echo $tot_flt_5; 
					else
						echo "";
				?>
			</td>	
			<td style="border:1px solid black" align="center">
				<?php 
					if($tot_flt_10)
						echo $tot_flt_10; 
					else
						echo "";
				?>
			</td>	
			<td style="border:1px solid black" align="center">
				<?php 
					if($tot_flt_20)
						echo $tot_flt_20; 
					else
						echo "";
				?>
			</td>			
			
		</tr>
		<tr>
			<td colspan="16">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="16">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="14">&nbsp;</td>
			<td colspan="2" align="center">টার্মিনাল অফিসার (কন্ট্রোল)</td>
		</tr>
		<tr>
			<td colspan="14">&nbsp;</td>
			<td colspan="2" align="center">পক্ষে টার্মিনাল ম্যানেজার</td>
		</tr>
		<tr>
			<td colspan="14">&nbsp;</td>
			<td colspan="2" align="center">চট্টগ্রাম বন্দর কর্তৃপক্ষ।</td>
		</tr>
		<tr>
			<td colspan="16" align="left">অনুলিপিঃ<br>১. টিআই/ইনচার্জ-ইক্যুইপমেন্ট বুকিং ও সুপারভিশন(মোবাইল-৩)/টাওয়ার ভবন এর অবগতি ও উপরোক্ত<br> যান্ত্রিক উপকরণগুলো কেন্দ্রীয় কারখানায় গিয়ে বুকিং নিশ্চিত করার জন্য বলা গেল।</td>
		</tr>
		<tr>
			<td colspan="16">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="16">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="14">&nbsp;</td>
			<td colspan="2" align="center">টার্মিনাল অফিসার (কন্ট্রোল)</td>
		</tr>
		<tr>
			<td colspan="14">&nbsp;</td>
			<td colspan="2" align="center">পক্ষে টার্মিনাল ম্যানেজার</td>
		</tr>
		<tr>
			<td colspan="14">&nbsp;</td>
			<td colspan="2" align="center">চট্টগ্রাম বন্দর কর্তৃপক্ষ।</td>
		</tr>
	</table>
<?php 

mysql_close($con_cchaportdb);
if($_POST['options']=='html'){?>		
	</BODY>
</HTML>
<?php }?>