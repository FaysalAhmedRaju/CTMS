<div align ="center" style="margin:50px;">

	<!--div align="center" style="font-size:18px">
			<title><img align="middle"  width="220px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></title>
	</div>
		<div align="center"><font size="5"><b>INWARD & OUTWARD CONTAINER REGISTER</b></font></div-->

	<table  border="0" cellspacing="0" width="700px;">
		<tr>
                    <th align="center" colspan='7'>
                            <h2><img align="middle"  width="235px" height="75px" src="<?php echo IMG_PATH?>cpanew.jpg"></h2>
                    </th>
		</tr>
		<tr bgcolor="#ffffff">
			<th align="center" colspan='7'><font size="5"><b>OFFICE OF THE TERMINAL MANAGER</b></font></th>
		</tr>
                <tr bgcolor="#ffffff">
			<th align="center" colspan='7'><font size="5"><b>HEAD DELIVERY REGISTER REPORT</b></font></th>
		</tr>
                 <tr bgcolor="#ffffff">
                        <th align="center" colspan='7'><font size="4"><b>Date: <?php echo $head_result[0]['stDate'];?></b></font></th>
		</tr>
        </table>                        
<!--		<tr><td colspan='7'>&nbsp;</td></tr>-->
          <?php
			include("mydbPConnectionctms.php");
			include("mydbPConnection.php");
			for($i=0;$i<count($head_result);$i++)
			{
				$unit_gkey = $head_result[$i]["gkey"];
				$rot_no = $head_result[$i]["rot_no"];
				$contid = $head_result[$i]["contid"];
				
				$strBL = "SELECT DISTINCT BL_No FROM igm_details
				INNER JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id
				WHERE cont_number='$contid' AND Import_Rotation_No='$rot_no'";
				
				$resBL = mysql_query($strBL,$con_cchaportdb);
				$rowBL = mysql_fetch_object($resBL);
				$BL = $rowBL->BL_No;
				
				$strPkgWt = "SELECT CONCAT(Pack_Number,' ',Pack_Description) AS pack,weight FROM igm_details WHERE BL_No='$BL'";
				$resPkgWt = mysql_query($strPkgWt,$con_cchaportdb);
				$rowPkgWt = mysql_fetch_object($resPkgWt);
				$pack = $rowPkgWt->pack;
				$weight = $rowPkgWt->weight;
		?> 
        <table  border="0" cellspacing="0" width="700px;">
		<tr>
			<th align="left" colspan='7' style="font-size:13px;"><b>Assignment (Delivery):<?php echo $head_result[$i]["mfdch_desc"];?></b></th>
		</tr>
                
        </table>
        <table border="1" style="border-collapse:collapse;"   cellspacing="0"  width="700px;">

                <tr >

                        <td style="font-size:12px; width:20px" align="center" ><?php echo $i+1;?></td>
                        <td style="font-size:12px;" colspan="6"><?php echo "C&F :".$head_result[$i]['cf'].", Vessel: ".$head_result[$i]['v_name'].", Rotation : ".$head_result[$i]['rot_no'].", BL No: ".$head_result[$i]['bl_no'];?></td>
                </tr>
                <tr>
                    
                        <?php
                                $str3="SELECT be_no, be_dt, cp_no, cp_dt FROM ctmsmis.mis_head_delivery_detail 
                                WHERE mis_head_delivery_detail.unit_gkey='$unit_gkey'";
                                $dlv_result = mysql_query($str3,$con_ctmsmis);
                                while($row_dlv=mysql_fetch_object($dlv_result))
                                {
                        ?>

                                <!--<td style="border:1px solid black; "></td>-->  
                                <td></td>
                                <td style="width:70px"><b>B/E No:</b></td>
                                <td><?php if($row_dlv->be_no!="") echo $row_dlv->be_no; else echo "&nbsp;";?></td>
                                <td style="width:70px"><b>B/E Date:</b></td>
                                <td><?php if($row_dlv->be_dt!="") echo $row_dlv->be_dt; else echo "&nbsp;";?></td>
                                <td><b>STC:</b></td>
                                <td><?php echo $pack;?></td>
                </tr>
                <tr>
                                <td></td>
                                <td><b>CP No:</b></td>
                                <td><?php if($row_dlv->cp_no!="") echo $row_dlv->cp_no; else echo "&nbsp;";?></td>
                                <td><b>CP Date:</b></td>
                                <td><?php if($row_dlv->cp_dt!="") echo $row_dlv->cp_dt; else echo "&nbsp;";?></td>
                                <td><b>Weight: </b></td>
                                <td><?php echo $weight." KG";?></td>
                </tr>					
                        <?php } ?>
                                    
                <tr>
                        <th>&nbsp; </th>
                        <th colspan='2'  align="center">Cont No.</th>
                        <th colspan='3'  align="center">Cart Details</th>
                        <th style=" width:100px" align="center">Signature & Mobile</th>
                </tr>
                        <?php
			//include("mydbPConnection.php");
			$stringBL = "SELECT DISTINCT cont_number, cont_size, Import_Rotation_No as rot FROM igm_details
					INNER JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id 
					WHERE BL_No='$BL'";
				$bl_reslt = mysql_query($stringBL,$con_cchaportdb);
				while($rsbL = mysql_fetch_object($bl_reslt)){
				$i++;
				?>
                    <tr>

                                    <td >&nbsp;</td>
                                    <td colspan='2'  align="center"><?php if($rsbL->cont_number) echo $rsbL->cont_number." x ".$rsbL->cont_size; else echo "&nbsp;";?></th>
                                    <td colspan='3' style=" width:100px; height:50px;" align="center">
                                    <?php
                                    $strCart = "SELECT truck_no FROM ctmsmis.mis_head_delivery_sub_detail 
                                            INNER JOIN ctmsmis.mis_head_delivery_detail ON mis_head_delivery_detail.id=mis_head_delivery_sub_detail.head_dlv_dtl_id
                                            WHERE  cont_id='$rsbL->cont_number' AND rotation='$rsbL->rot'";
                                    //ECHO $strCart;	
                                    $cart_reslt = mysql_query($strCart,$con_ctmsmis);
                                    while($cart = mysql_fetch_object($cart_reslt)){
                                    $i++;

                                    echo $cart->truck_no.", ";
                                    } ?>					
                                    </th>
                                    <td  ></th>
                    </tr>
				
				<?php
			}
	
			
		?>  


        </table>
		
	<?php
			}
	mysql_close($con_ctmsmis);
	mysql_close($con_cchaportdb);
	?>
</div>