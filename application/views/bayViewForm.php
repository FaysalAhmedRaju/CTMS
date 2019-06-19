<html>
	<head>
		<script>
			function pairedState(value) 
			{
				if(value==1)
				{
					var bay = parseInt(document.getElementById("bay").value);
					var bayLimit = bay + 1;
					//alert(bayLimit);
					
					//document.getElementById("pDiv").style.display="inline";
					var pWith=document.getElementById("pWith");
					pWith.disabled=false;
					removeOptions(pWith);
					for (var i = bayLimit; i <=50; i++) 
					{	
						//alert(i.length);
						var iValue =0;
						if(i<10)
							iValue = "0"+i;
						else
							iValue = i;
						var option = document.createElement('option');
						option.value = iValue;
						option.text = iValue;
						pWith.appendChild(option);
					}
				}
				else
				{
					var pw = document.getElementById("pWith");
					pw.disabled=true;
					//removeOptions(pw);
				}
				//document.getElementById("demo").innerHTML = "You selected: " + x;*/
			}
			
			function removeOptions(selectbox)
			{
				var i;
				for(i=selectbox.options.length-1;i>=1;i--)
				{
					selectbox.remove(i);
				}
			}
			
			function createTable(value)
			{
				upValue= parseInt(value);				
				var lowValue = parseInt(document.getElementById("bdlrl").value);
				
				var  table = document.getElementById("dynamicTable");
				removeTableElement(table);
				var trlbl = document.createElement('tr');
				
				var td1lbl1 = document.createElement('td');
				var textlbl1 = document.createTextNode('Row');
				td1lbl1.appendChild(textlbl1);
				trlbl.appendChild(td1lbl1);
				
				var td1lbl2= document.createElement('td');
				var textlbl2 = document.createTextNode('Min Col Limit');
				td1lbl2.appendChild(textlbl2);
				trlbl.appendChild(td1lbl2);	
				
				var td1lbl3 = document.createElement('td');	
				var textlbl3 = document.createTextNode('Max Col Limit');
				td1lbl3.appendChild(textlbl3);
				trlbl.appendChild(td1lbl3);	
				
				table.appendChild(trlbl);
				
				for(var i=lowValue;i<=upValue;i+=2)
				{
					var ival="";
					if(i<10)
						ival = "0"+i;
					else
						ival = i;
						
					var tr = document.createElement('tr');	
					
					var td1 = document.createElement('td');
					var text1 = document.createTextNode('Row '+ival+':');
					td1.appendChild(text1);
					
					var td2 = document.createElement('td');
					var input = document.createElement("input");
					input.type = "text";
					input.name = "minCol" + ival;
					input.value = "01";
					input.style.width = "100px";
					td2.appendChild(input);
					
					var td3 = document.createElement('td');
					var input = document.createElement("input");
					input.type = "text";
					input.name = "maxCol" + ival;
					input.style.width = "100px";
					td3.appendChild(input);
					
					tr.appendChild(td1);
					tr.appendChild(td2);
					tr.appendChild(td3);
					table.appendChild(tr);
				}
				//table.appendChild(table);
			}
			
			function createTableUp(value)
			{
				upValue= parseInt(value);				
				var lowValue = parseInt(document.getElementById("adlrl").value);
				
				var  table = document.getElementById("dynamicTableUp");
				removeTableElement(table);
				var trlbl = document.createElement('tr');
				
				var td1lbl1 = document.createElement('td');
				var textlbl1 = document.createTextNode('Row');
				td1lbl1.appendChild(textlbl1);
				trlbl.appendChild(td1lbl1);
				
				var td1lbl2= document.createElement('td');
				var textlbl2 = document.createTextNode('Min Col Limit');
				td1lbl2.appendChild(textlbl2);
				trlbl.appendChild(td1lbl2);	
				
				var td1lbl3 = document.createElement('td');	
				var textlbl3 = document.createTextNode('Max Col Limit');
				td1lbl3.appendChild(textlbl3);
				trlbl.appendChild(td1lbl3);	
				
				table.appendChild(trlbl);
				
				for(var i=lowValue;i<=upValue;i+=2)
				{
					var ival="";
					if(i<10)
						ival = "0"+i;
					else
						ival = i;
						
					var tr = document.createElement('tr');	
					
					var td1 = document.createElement('td');
					var text1 = document.createTextNode('Row '+ival+':');
					td1.appendChild(text1);
					
					var td2 = document.createElement('td');
					var input = document.createElement("input");
					input.type = "text";
					input.name = "minColUp" + ival;
					input.value = "01";
					input.style.width = "100px";
					td2.appendChild(input);
					
					var td3 = document.createElement('td');
					var input = document.createElement("input");
					input.type = "text";
					input.name = "maxColUp" + ival;
					input.style.width = "100px";
					td3.appendChild(input);
					
					tr.appendChild(td1);
					tr.appendChild(td2);
					tr.appendChild(td3);
					table.appendChild(tr);
				}
				//table.appendChild(table);
			}
			
			function removeTableElement(table)
			{
				var tblLen = table.rows.length;
				//alert(tblLen);
				for(var i=tblLen;i>1;i--)
				{
					table.deleteRow(i-1);
				}				
			}
			
			function getVslInfo(rot)
			{
				//alert(rot);
			
				if (window.XMLHttpRequest) 
				{
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				} 
				else 
				{  
					// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				
				var BASE_URL="http://192.168.16.42/myportpanel/index.php/report/getVslLayout";
				xmlhttp.onreadystatechange=stateChangeVslInfo;
				xmlhttp.open("GET",BASE_URL+"?rot="+rot,false);
				
				xmlhttp.send();
			}
			
			function stateChangeVslInfo()
			{
				
				if (xmlhttp.readyState==4 && xmlhttp.status==200) 
				{
				  var myVslInfo=document.getElementById("myVslInfo");
				  //removeOptions(selectList);
				  var val = xmlhttp.responseText;
				  //alert(val);
				  myVslInfo.innerHTML = val;
				}
			}
			
			function getContinue(check)
			{
				//alert(check);
				var btn=document.getElementById("submit");
				if(check=="yes")
				{
					btn.disabled = false;
					btn.style.background = "#ccc";
				}
				else
				{
					btn.disabled = true;
					btn.style.background = "none";
				}
			}
			
			function checkBelow(val)
			{
				//alert(val);
				if(val==1)
				{
					document.getElementById("cLineB").disabled=false;
					document.getElementById("bdlrl").disabled=false;
					document.getElementById("bdurl").disabled=false;
					document.getElementById("lowerGap").disabled=false;
				}
				else
				{
					document.getElementById("cLineB").disabled=true;
					document.getElementById("bdlrl").disabled=true;
					document.getElementById("bdurl").disabled=true;
					document.getElementById("gapLineB").disabled=true;
					document.getElementById("lowerGap").disabled=true;
					
					var  table = document.getElementById("dynamicTable");
					removeTableElement(table);
				}
				//pw.disabled=true;
			}
			
			function isGap(val1,val2)
			{
				//alert(val1+" "+val2);
				if(val2==1)
					var  field = document.getElementById("gapLineA");
				else
					var  field = document.getElementById("gapLineB");
					
				if(val1=="0")
					field.disabled=false;
				else
					field.disabled=true;
			}
		</script>
	</head>
	<body>
	
	 <script type="text/javascript" src="<?php echo JS_PATH; ?>AdvancedCalender.js"></script>
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
	
	
	
	
	
		<form action="<?php echo site_url("report/vslLayout"); ?>" method="POST">
			<table>
				<tr>
					<td>
					<fieldset>
					<legend>General</legend>
						<table >
							<tr>
								<td>
									Rotation:
								</td>
								<td>
									<input type="text" name="rotation" id="rotation" placeholder="0000/0000" onblur="getVslInfo(this.value)" style="width:150px;">
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div id="myVslInfo"></div>
								</td>
							</tr>
							<tr>
								<td>
									Will you continue?
								</td>
								<td>
									<select name="radio" onchange="getContinue(this.value)">
										<option value="">Select</option>
										<option value="yes">Yes</option>
										<option value="no">No</option>
									</select>
									<!--<input type="radio" name="radio" value="yes" onclick="getContinue(this.value)">Yes
									<input type="radio" name="radio" value="no" onclick="getContinue(this.value)">No-->
								</td>
							</tr>
							<tr>
								<td>
									Bay:
								</td>
								<td>
									<select name="bay" id="bay">
										<option value="">Select</option>
										<?php
										for($i=0;$i<=50;$i++)
										{
										?>
										<option value="<?php if($i<10)echo "0".$i;else echo $i;?>"><?php if($i<10)echo "0".$i;else echo $i;?></option>
										<?php
										}
										?>
									<select>
								</td>
							</tr>
							<tr>
								<td>
									Bay Status:
								</td>
								<td>
									<select name="bayState" id="bayState" onchange="pairedState(this.value)">
										<option value="">Select</option>
										<option value="1">Paired</option>
										<option value="0">Single</option>							
									<select>
								</td>
							</tr>
							<!--tr id="pDiv" style="display: none;">								
								<td>
									Paired With:
								</td>
								<td>
									<select name="pWith" id="pWith">
										<option value="">Select</option>						
									<select>
								</td>
							</tr-->
							<tr>								
								<td>
									Paired With:
								</td>
								<td>
									<select name="pWith" id="pWith" disabled>
										<option value="">Select</option>						
									<select>
								</td>
							</tr>
							
						</table>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset>
						<legend>Above Deck</legend>
						<table>
							<tr>
								<td>
									Center Line:
								</td>
								<td>
									<select name="cLineA" id="cLineA" onchange="isGap(this.value,1)">
										<option value="">Select</option>
										<option value="1">Yes</option>
										<option value="0">No</option>							
									<select>
								</td>
							</tr>
							<tr>
								<td>
									Gap for Center Line?
								</td>
								<td>
									<select name="gapLineA" id="gapLineA" disabled>
										<option value="">Select</option>
										<option value="1">Yes</option>
										<option value="0">No</option>							
									<select>
								</td>
							</tr>
							<tr>
								<td>
									 Lower Row Limit:
								</td>
								<td>
									<select name="adlrl" id="adlrl">
										<option value="">Select</option>
										<?php
										for($i=76;$i<=98;$i+=2)
										{
										?>
										<option value="<?php echo $i;?>"><?php echo $i;?></option>
										<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									Upper Row Limit:
								</td>
								<td>
									<select name="adurl" id="adurl" onchange="createTableUp(this.value)">
										<option value="">Select</option>
										<?php
										for($i=76;$i<=98;$i+=2)
										{
										?>
										<option value="<?php echo $i;?>"><?php echo $i;?></option>
										<?php
										}
										?>
									</select>
								</td>
							</tr>
							
							<tr>
								<td align="center" colspan="2">
									<table id="dynamicTableUp">
										<tr>
											<td></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									Make Gap Upper Row:
								</td>
								<td>
									<textarea name="upperGap" id="upperGap" style="resize:none;"></textarea>
								</td>
							</tr>
							
						</table>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset>
						<legend>Below Deck</legend>
						<table>
							<tr>
								<td>
									Is Below Deck?
								</td>
								<td>
									<select name="isBelow" id="isBelow" onchange="checkBelow(this.value)">
										<option value="">Select</option>
										<option value="1">Yes</option>
										<option value="0">No</option>							
									<select>
								</td>
							</tr>
							<tr>
								<td>
									Center Line:
								</td>
								<td>
									<select name="cLineB" id="cLineB" disabled onchange="isGap(this.value,2)">
										<option value="">Select</option>
										<option value="1">Yes</option>
										<option value="0">No</option>							
									<select>
								</td>
							</tr>
							<tr>
								<td>
									Gap for Center Line?
								</td>
								<td>
									<select name="gapLineB" id="gapLineB" disabled>
										<option value="">Select</option>
										<option value="1">Yes</option>
										<option value="0">No</option>							
									<select>
								</td>
							</tr>
							<tr>
								<td>
									Lower Row Limit:
								</td>
								<td>
									<select name="bdlrl" id="bdlrl" disabled>
										<option value="">Select</option>
										<?php
										for($i=2;$i<=14;$i+=2)
										{
										?>
										<option value="<?php if($i<10)echo "0".$i; else echo $i;?>"><?php if($i<10)echo "0".$i; else echo $i;?></option>
										<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									Upper Row Limit:
								</td>
								<td>
									<select name="bdurl" id="bdurl" onchange="createTable(this.value)" disabled>
										<option value="">Select</option>
										<?php
										for($i=2;$i<=14;$i+=2)
										{
										?>
										<option value="<?php if($i<10)echo "0".$i; else echo $i;?>"><?php if($i<10)echo "0".$i; else echo $i;?></option>
										<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td align="center" colspan="2">
									<table id="dynamicTable">
										<tr>
											<td></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									Make Gap Lower Row:
								</td>
								<td>
									<textarea name="lowerGap" id="lowerGap" style="resize:none;" disabled></textarea>
								</td>
							</tr>
						</table>
						</fieldset>
					</td>
				</tr>				
				<tr>
					<td align="center">
						<input type="submit" name="submit" id="submit" value="Draw Bay" disabled style="width:60px;background:none;">
					</td>
				</tr>
			</table>
		</form>
		
		<?php 
		if(isset($_POST['submit']))
		{
			include('dbConection.php');
			$rotation = $_POST['rotation'];
			$bay = $_POST['bay'];
			//echo intval($bay);
			//return;
			$bayState = $_POST['bayState'];
			$pWith =0;
			if($bayState!="" and $bayState==1)
			{
				$pWith = $_POST['pWith'];
			}
			$cLineA = $_POST['cLineA'];
			$gapLineA = 0;
			if($cLineA==0)
			{
				$gapLineA = $_POST['gapLineA'];
			}
			$adlrl = $_POST['adlrl'];
			$adurl = $_POST['adurl'];
			$upperGap = $_POST['upperGap'];
			/*$adlcl = $_POST['adlcl'];
			$aducl = $_POST['aducl'];*/
			$isBelow = $_POST['isBelow'];			
			if($isBelow==1)
			{
				$gapLineB = 0;
				$cLineB = $_POST['cLineB'];
				if($cLineB==0)
				{
					$gapLineB = $_POST['gapLineB'];
				}
				$bdlrl = $_POST['bdlrl'];
				$bdurl = $_POST['bdurl'];
				$lowerGap = $_POST['lowerGap'];
			}
			//echo 
			if($rotation=="")
			{
				echo "<div align='center'><font color='red' size='5'><b>Rotation should not be blank...</b></font></div>";
				return;
			}
			elseif($bay=="")
			{
				echo "<div align='center'><font color='red' size='5'><b>Must need to select bay...</b></font></div>";
				return;
			}
			elseif($bayState=="")
			{
				echo "<div align='center'><font color='red' size='5'><b>Must need to select bay status...</b></font></div>";
				return;
			}
			elseif($bayState!="" and $bayState==1 and $pWith=="")
			{
				echo "<div align='center'><font color='red' size='5'><b>Must need to select paired with...</b></font></div>";
				return;
			}
			elseif($cLineA=="")
			{
				echo "<div align='center'><font color='red' size='5'><b>Must need to select above deck center line...</b></font></div>";
				return;
			}
			elseif($cLineA==0 and $gapLineA=="")
			{
				echo "<div align='center'><font color='red' size='5'><b>Must need to select above deck gap for center line...</b></font></div>";
				return;
			}
			elseif($adlrl=="")
			{
				echo "<div align='center'><font color='red' size='5'><b>Must need to select above deck lower row limit...</b></font></div>";
				return;
			}
			elseif($adurl=="")
			{
				echo "<div align='center'><font color='red' size='5'><b>Must need to select above deck upper row limit...</b></font></div>";
				return;
			}			
			elseif($isBelow==1 and $cLineB=="")
			{
				echo "<div align='center'><font color='red' size='5'><b>Must need to select below deck center line...</b></font></div>";
				return;
			}
			elseif($isBelow==1 and $cLineB==0 and $gapLineB=="")
			{
				echo "<div align='center'><font color='red' size='5'><b>Must need to select below deck gap for center line...</b></font></div>";
				return;
			}
			elseif($isBelow==1 and $bdlrl=="")
			{
				echo "<div align='center'><font color='red' size='5'><b>Must need to select below deck lower row limit...</b></font></div>";
				return;
			}
			elseif($isBelow==1 and $bdurl=="")
			{
				echo "<div align='center'><font color='red' size='5'><b>Must need to select below upper lower row limit...</b></font></div>";
				return;
			}
			else
			{
				//echo  " rot:".$rotation." bay:".$bay." bstate:".$bayState." pWith:".$pWith." cLine:".$cLineA." bdlrl:".$bdlrl." bdurl:".$bdurl."<br>";
				
				$strVslInfo = "select sparcsn4.vsl_vessels.id,sparcsn4.vsl_vessels.name
				from sparcsn4.vsl_vessel_visit_details
				inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
				where sparcsn4.vsl_vessel_visit_details.ib_vyg='$rotation'";
				$rtnVslInfo = mysql_query($strVslInfo);
				$row = mysql_fetch_object($rtnVslInfo);
				$vslId= $row->id;
				$vslName= $row->name;
				
				$chkBay = intval($bay);
				$strChk = "select * from ctmsmis.misBayView where vslId='$vslId' and bay=$chkBay";
				//echo $strChk;
				$resChk = mysql_query($strChk);
				$chkRows = mysql_num_rows($resChk);
				//return;
				if($chkRows>0)
				{
					echo "<div align='center'><font color='red' size='5'><b>Bay $bay is already drawn before...</b></font></div>";
					echo "<div align='center'><a href='".site_url("report/blankBayView")."?get=yes&vslId=$vslId&vslName=$vslName' target='_blank'><font size='4'>View Layout</font></a></div>";
					return;
				}
				
				$j=intval($adlrl);
				//echo "i value=".$i."<br>";
				for($j;$j<=$adurl;$j+=2)
				{
					if(strlen($j)==1 and $j<10)
						$jval = "0".$j;
					else
						$jval = $j;
						
					//echo $jval."<br>";
					$minColUp = $_POST['minColUp'.$jval];
					$maxColUp = $_POST['maxColUp'.$jval];
					//echo $minColUp."<br>";
					//echo $maxColUp."<br>";
					if($cLineA==1)
						$di=0;
					else
						$di=intval($minColUp);
						
					for($di;$di<=intval($maxColUp);$di++)
					{
						if($di<10)
							$diValue = "0".$di;
						else
							$diValue = $di;
						$pos = $diValue.$jval;
						//echo $pos."<br>";
						//echo $pWith."<br>";
						mysql_query("insert into ctmsmis.misBayDetail(vslId,bay,pairedWith,position) values('$vslId','$bay','$pWith','$pos')");
					}
						
					$strUpInfo = "insert into ctmsmis.misBayViewBelow(vslId,bay,bayRow,minColLimit,maxColLimit) values('$vslId',$bay,$jval,$minColUp,$maxColUp)";
					//echo $strBelowInfo;
					//echo"<br>";
					mysql_query($strUpInfo);
				}
				
				if($isBelow==1)
				{
					$i=intval($bdlrl);
					//echo "i value=".$i."<br>";
					for($i;$i<=$bdurl;$i+=2)
					{
						if(strlen($i)==1 and $i<10)
							$ival = "0".$i;
						else
							$ival = $i;
						
						//echo $ival."<br>";
						$minCol = $_POST['minCol'.$ival];
						$maxCol = $_POST['maxCol'.$ival];
						//echo $minCol."<br>";
						if($cLineB==1)
							$dib=0;
						else
							$dib=intval($minCol);
							
						for($dib;$dib<=intval($maxCol);$dib++)
						{
							if($dib<10)
								$dibValue = "0".$dib;
							else
								$dibValue = $dib;
							$posb = $dibValue.$ival;
							//echo $posb."<br>";
							mysql_query("insert into ctmsmis.misBayDetail(vslId,bay,pairedWith,position) values('$vslId','$bay','$pWith','$posb')");
						}
						
						$strBelowInfo = "insert into ctmsmis.misBayViewBelow(vslId,bay,bayRow,minColLimit,maxColLimit) values('$vslId',$bay,$ival,$minCol,$maxCol)";
						//echo $strBelowInfo;
						//echo"<br>";
						mysql_query($strBelowInfo);
					}
				}
				
				if($isBelow==1)
				{
					$strInsert = "insert into ctmsmis.misBayView(vslId,bay,paired,pairedWith,centerLineA,gapLineA,minRowLimAbv,maxRowLimAbv,isBelow,centerLineB,gapLineB,minRowLimBlw,maxRowLimBlw,gapUpperRow,gapLowerRow) 
					values('$vslId',$bay,$bayState,$pWith,$cLineA,$gapLineA,$adlrl,$adurl,$isBelow,$cLineB,$gapLineB,$bdlrl,$bdurl,'$upperGap','$lowerGap')";
				}
				else
				{
					$strInsert = "insert into ctmsmis.misBayView(vslId,bay,paired,pairedWith,centerLineA,gapLineA,minRowLimAbv,maxRowLimAbv,isBelow,gapUpperRow) 
					values('$vslId',$bay,$bayState,$pWith,$cLineA,$gapLineA,$adlrl,$adurl,$isBelow,'$upperGap')";
				}
				
				$res = mysql_query($strInsert);
				if($res)
				{
					echo "<div align='center'><font color='blue' size='5'><b>Bay $bay for vessel $vslName drawn successfully...</b></font></div>";
					echo "<div align='center'><a href='".site_url("report/blankBayView")."?get=yes&vslId=$vslId&vslName=$vslName' target='_blank'><font size='4'>View Layout</font></a></div>";
				}
				else
				{
					echo "<div align='center'><font color='blue' size='5'><b>Bay $bay for vessel $vslName drawn not successfully...</b></font></div>".mysql_error();
				}
			}
		?>
			
		<?php 
		}
		?>
		
		<div class="clr"></div>
        </div>
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php mysql_close($con_sparcsn4);?>
  </div>
