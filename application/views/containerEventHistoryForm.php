
<script>
 function getEventDetails(gkey)
 {
	   //alert(gkey);
	//document.getElementById("cargoAtShed").value=shed;
		
		if (window.XMLHttpRequest) 
		{

		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=stateChangeShedInfo;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/contEventDetails')?>?gkey="+gkey,false);
					
		xmlhttp.send();		
   }
   
   
   
   	function stateChangeShedInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{	
		var val = xmlhttp.responseText;
			//alert(val);
		var tbl = document.getElementById("mytbl");
		var rowslenth = tbl.getElementsByTagName("tr").length;
		var rmvroLn = rowslenth-1;
		//alert(rmvroLn);

		for(var i=rmvroLn;i>=0;i--)
		{
			tbl.deleteRow(i);
		}
		 
		var tr1 = document.createElement("tr");
		tr1.style.background="#c6d105";
		 
		var th1 = document.createElement("th");
		var txt1 = document.createTextNode("ID");
		th1.appendChild(txt1);
		 
        var th2 = document.createElement("th");
		var txt2 = document.createTextNode("Description");
		th2.appendChild(txt2);		
		
	/*	
		var th4 = document.createElement("th");
		var txt4 = document.createTextNode("Placed by");
		th4.appendChild(txt4);
	*/	
		var th5 = document.createElement("th");
		var txt5 = document.createTextNode("Placed Time");
		th5.appendChild(txt5);
	/*	
		var th6 = document.createElement("th");
		var txt6 = document.createTextNode("Creator");
		th6.appendChild(txt6);
	*/	
		var th7 = document.createElement("th");
		var txt7 = document.createTextNode("Created");
		th7.appendChild(txt7);
		
        tr1.appendChild(th1);
		tr1.appendChild(th2);
	 //	tr1.appendChild(th4);
	    tr1.appendChild(th5);
	  //  tr1.appendChild(th6);
	    tr1.appendChild(th7);
		
		tbl.appendChild(tr1);	 
		
		
		
        var jsonData = JSON.parse(val);
		for (var i = 0; i < jsonData.length; i++) 
		{
	        var tr = document.createElement("tr");
			tr.style.background="#f5e783"; 
			
			var td2 = document.createElement('td');
			var text2 = document.createTextNode(jsonData[i].id);
			td2.appendChild(text2);
			
			var td3 = document.createElement('td');
			var text3 = document.createTextNode(jsonData[i].description);
			td3.appendChild(text3);
			
		/*	
			var td4 = document.createElement('td');
			var text4 = document.createTextNode(jsonData[i].placed_by);
			td4.appendChild(text4);
		*/	
			var td5 = document.createElement('td');
			var text5 = document.createTextNode(jsonData[i].placed_time);
			td5.appendChild(text5);
				
		/*				
			var td6 = document.createElement('td');
			var text6 = document.createTextNode(jsonData[i].creator);
			td6.appendChild(text6);
		*/	
			var td7 = document.createElement('td');
			var text7 = document.createTextNode(jsonData[i].created);
			td7.appendChild(text7);	
			
	

		    tr.appendChild(td2);
			tr.appendChild(td3);
		  //  tr.appendChild(td4);
			tr.appendChild(td5);
			//tr.appendChild(td6);
			tr.appendChild(td7);			
			
			tbl.appendChild(tr);
		}
					
		}
	}
</script>
<style>
.contTable tr { background-color: #E1F0FF }
.contTable tr:hover { background-color: #49e8ce };
</style>


<div class="content" style="padding: 30px 0 12px;">
    <div class="content_resize_1" >
      <div class="mainbar_1" style="width:910px">
        <div class="article">
   <h2 align="center"><span><?php echo $title; ?></span> </h2>
   <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
   
   <div class="clr"></div>
   <div class="img">

    <form name= "myForm" action="<?php echo site_url("report/containerEventHistoryReport");?>" method="post">
	
	
	<div align="center">	 
		<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
			<tr>
				<td>&nbsp;</td>
					</tr>
						<tr>
						  <td align="left" ><label><font color='red'></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Container No:</label></td>
						  <td>
							<input type="text" style="width:130px;" id="contNo" name="contNo" value=""/>
								&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="submit" value="Search" class="login_button"/> 
						  </td>
						</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
		</table>
	</form>
	 </div>
    </form>
	<br/>
   <div >
   	<table class="contTable" cellspacing="1" cellpadding="1" align="center"  style="overflow-y:scroll" >
		   <?php if($tableFlag==1){?>
	<tr><td colspan="12" align="center">  <h2><span><font color="green"  size="3" style="font-weight: bold"><nobr><b><?php echo $tableTitle; ?></b></nobr></font></span> </h2></td></tr>
		<tr  style="height:35px; background-color:#C1E0FF;" >
		
		
		<font size="15">		
			<th><nobr>Time Move</nobr></th>
			<th><nobr>Time In<nobr></th>
			<th><nobr>Time Out<nobr></th>
			<th><nobr>Category<nobr></th>
			<th><nobr>Status<nobr></th>
			<th><nobr>MLO<nobr></th>
			<th><nobr>Transit.State</nobr></th>
			<th><nobr>Last Pos Name</nobr></th>
			<th><nobr>Expand</nobr></th>
			
			</font>
		</tr>
		
	  <?php
       
        for($i=0;$i<count($contHistory);$i++) { 				
		?>
	      <tr class="gridLight">
			  <td align="center">
			   <?php echo $contHistory[$i]['time_move']?>
			  </td>
			  <td align="center">
			   <?php echo $contHistory[$i]['time_in']?>
			  </td>
			  <td align="center">
			   <?php echo $contHistory[$i]['time_out']?>
			  </td> 
			   <td align="center">
			   <?php echo $contHistory[$i]['category']?>
			  </td> 
			 <td align="center">
			   <?php echo $contHistory[$i]['freight_kind']?>
			 </td> 
			<td align="center">
			   <?php echo $contHistory[$i]['mlo']?>
			 </td> 
			 <td align="center">
			   <?php echo $contHistory[$i]['transit_state']?>
			 </td>   

			 <td align="center">
			   <?php echo $contHistory[$i]['last_pos_name']?>
			 </td>   

			 <td align="center">

					<input type="hidden" name="contNo" id="contNo" value="<?php echo $contNo;?>">	
				    <button class="login_button"  style="width:100%;"  type="submit" value="<?php echo $contHistory[$i]['gkey'];?>" onclick ="getEventDetails(this.value);">Expand</button>  	
			 </td>   
         </tr>		 
         <?php } ?>	 
		 <?php } ?>
	    </table>
	</div>	

	<table>
	<tr><td>&nbsp;</td></tr>

	</table>
		
	<table cellspacing="1" cellpadding="1" align="center"  id="mytbl" style="overflow-y:scroll" >		
	</table>
   
    </div>
      <div class="clr"></div>
    </div>
       
   
    </div>
   <div class="sidebar" style="width:160px">
    <?php include_once("mySideBar.php"); ?>
   </div>
      <div class="clr"></div>
    </div>
 <?php echo form_close()?>
 </div>
 