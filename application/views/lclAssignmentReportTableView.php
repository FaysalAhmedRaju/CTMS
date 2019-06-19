<script type="text/javascript">

function changeTextBox(v)
{
	    var search_value = document.getElementById("search_value");
		var fromdate = document.getElementById("fromdate");
		var todate = document.getElementById("todate");
		var shedNo = document.getElementById("shedNo");
		if(v=="dateRange")
		{
			search_value.value=null;
			shedNo.value=null;
			search_value.disabled=true;
			fromdate.disabled=false;
			todate.disabled=false;
			shedNo.disabled=true;
		
		}	
		else if(v=="")
		{
			search_value.value=null;
			fromdate.value=null;
			todate.value=null;
			shedNo.value=null;
			search_value.disabled=true;
			fromdate.disabled=true;
			todate.disabled=true;
			shedNo.disabled=true;

		}
		else if(v=="shedNo")
		{
			search_value.value=null;
			search_value.disabled=true;
			fromdate.disabled=false;
			todate.disabled=false;
			shedNo.disabled=false;	
		}
		else 
		{
			fromdate.value=null;
			todate.value=null;
			search_value.disabled=false;
			fromdate.disabled=true;
			todate.disabled=true;
			shedNo.disabled=true;
			
		}	
}
</script>
<style>
     #table-scroll {
	  height:500px;
	  width: 1000px;
	  overflow:auto;  
	  margin-top:0px;
      }
</style>

<div class="content" style="padding: 0px 0 12px;">
    <div class="content_resize_1" style="width:1270px">
      <div class="mainbar_1" style="width:1000px">
        <div class="article">
		   <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>

   <h2><span><?php echo $title; ?></span> </h2>
   
   <div class="clr"></div>
   <div class="img">
       <form name= "myForm"  action="<?php echo site_url("cfsModule/lclAssignmentReportTablePerform");?>" method="post">
   
  			<table border="0" width="300px" align="center">
								<tr>
									<td align="right" colspan="2"></td>
								</tr>
								 
                                <tr>
									<td align="left" >
									<label for=""><font color='red'></font>Search By :<em>&nbsp;</em></label></td>
									<td>
									        <select name="search_by" id="search_by" class="" onchange="changeTextBox(this.value);">
												<option value="" label="search_by" selected style="width:110px;">---Select-------</option>
												<option value="all" label="All" >All</option>
												<option value="rotation" label="Rotation" >Rotation</option>
												<option value="container" label="Container" >Container</option>
												<option value="dateRange" label="DateRange" >Date Range</option>	
												<option value="shedNo" label="ShedNo">Shed No</option>														
											</select>

									</td>
								</tr>	
								
								
								 <tr>
									<td align="left" ><label for=""><font color='red'></font><nobr>Search value :<nobr><em>&nbsp;</em></label></td>
									<td>
									<input type="text" style="width:150px;" id="search_value" name="search_value" disabled> 
									</td>
								</tr>	


                                <tr colspan="4">
									   <td align="left" ><label><font color='red'></font>From Date:</label></td>
										<td>
										 <input type="text" style="width:130px;" id="fromdate" name="fromdate" value="<?php date("Y-m-d"); ?>" disabled />
										</td>
											<script>
											 $(function() {
											 $( "#fromdate" ).datepicker({
											  changeMonth: true,
											  changeYear: true,
											  dateFormat: 'yy-mm-dd', // iso format
											 });
											 });
											</script>
				
									   <td align="left" ><label><font color='red'></font><nobr>To Date:</nobr></label></td>
										<td>
										 <input type="text" style="width:130px;" id="todate" name="todate" value="<?php date("Y-m-d"); ?>" disabled />
										</td>
											<script>
											 $(function() {
											 $( "#todate" ).datepicker({
											  changeMonth: true,
											  changeYear: true,
											  dateFormat: 'yy-mm-dd', // iso format
											 });
											 });
											</script>
								</tr>
								
							    <tr>
									<td align="left" >
									<label for=""><font color='red'></font>Shed No :<em>&nbsp;</em></label></td>
									<td>
									        <select name="shedNo" id="shedNo" class=""; disabled>
												<option value="" label="Shed_No" selected style="width:110px;">---Select-------</option>
												<option value="CFS/NCT" label="CFS/NCT" >CFS/NCT</option>
												<option value="CFS/CCT" label="CFS/CCT" >CFS/CCT</option>
												<option value="13 Shed" label="13 Shed" >13 Shed</option>	
												<option value="12 Shed" label="12 Shed" >12 Shed</option>												
												<option value="9 Shed" label="9 Shed" >9 Shed</option>												
												<option value="8 Shed" label="8 Shed" >8 Shed</option>												
												<option value="7 Shed" label="7 Shed" >7 Shed</option>												
												<option value="6 Shed" label="6 Shed" >6 Shed</option>												
												<option value="N Shed" label="N Shed" >N Shed</option>												
												<option value="D Shed" label="D Shed" >D Shed</option>												
												<option value="P Shed" label="P Shed" >P Shed</option>												
												
											</select>

									</td>
								</tr>	
								
								
								<tr>
									<td colspan="2" align="center" width="70px">
									<input type="submit" value="View" name="View" class="login_button">
									</td>
						<!-- </form>	
								<form action="<?php echo site_url('cfsModule/lclAssignmentReportView')?>" target="_blank" method="post"> -->		
									<td colspan="2" align="center" width="70px">
										<input type="submit" value="Print" name="Print"  formtarget="_blank" class="login_button">
									</td>
								</form>	
								</tr>

							</table>
						</td>
					</tr>
				</table>
		</form>
   
	<br/>
	<div id="table-scroll" >
	<table cellspacing="1" cellpadding="1" align="center" style="padding: 0px 30px 12px;" >
		<tr class="gridDark" style="height:45px; bgcolor="#BDBDBD" >
			<th>SL</th>
			<th>Cont. No</th>
			<th>Size</th>
			<th>Height</th>
			<th>Rotation</th>
			<th>Vessel Name</th>
			<th><nobr>Assign Date</nobr></th>
			<th>MLO</th>
			<th>STV</th>
			<th><nobr>Cont.at Shed</nobr></th>
			<th><nobr>Cargo at Shed</nobr></th>
			<th>Desc.of Cargo</th>
            <th><nobr>Landing Date</nobr></th>
			<th>Remarks</th>
			<?php if($login_id=='admin'){?>			
			<th>Action</th>
			<?php }?>
			<th>Action</th>			
			
		</tr>
		
	  <?php
       
        for($i=0;$i<count($lclAssignmentList);$i++) { 
         ?>
         <tr class="gridLight">
          <td>
           <?php echo $i+1;?>
          </td>
         <!-- <td align="center" >
           <?php echo $lclAssignmentList[$i]['id']?>
          </td> 
		  -->
          <td align="center">
           <?php echo $lclAssignmentList[$i]['cont_number']?>
          </td>
          <td align="center">
           <?php echo $lclAssignmentList[$i]['cont_size']?>
          </td>
          <td align="center">
           <?php echo $lclAssignmentList[$i]['cont_height']?>
          </td>
          <td align="center">
           <?php echo $lclAssignmentList[$i]['Import_Rotation_No']?>
          </td> 
		  <td align="center">
           <?php echo $lclAssignmentList[$i]['Vessel_Name']?>
          </td> 		  
		 <td align="center">
           <?php echo $lclAssignmentList[$i]['assignment_date']?>
          </td>   		  
          <td align="center">
           <?php echo $lclAssignmentList[$i]['mlocode']?>
          </td>          
          <td align="center">
           <?php if( $lclAssignmentList[$i]['stv']=="SAIF POWERTEC") echo "SPL"; else echo $lclAssignmentList[$i]['stv'];?>
          </td>
          <td align="center">
           <?php echo $lclAssignmentList[$i]['cont_loc_shed']?>
          </td> 
		  <td align="center">
           <?php echo $lclAssignmentList[$i]['cargo_loc_shed']?>
          </td> 
		  <td align="center">
           <?php echo $lclAssignmentList[$i]['description_cargo']?>
          </td> 
		  <td align="center">
           <?php echo $lclAssignmentList[$i]['landing_time']?>
          </td> 
		  <td align="center">
           <?php echo $lclAssignmentList[$i]['remarks']?>
          </td> 
		  
		  <?php if($login_id=='admin'){ ?>
		  <td align="center">
			<form action="<?php echo site_url('cfsModule/lclAssignmentEdit');?>" method="POST">
				<input type="hidden" name="lclID" value="<?php echo $lclAssignmentList[$i]['id'];?>">							
				<input type="submit" value="Edit" name="start" class="login_button" style="width:70%;">							
			</form> 
        </td> 
		  <?php }?>
		<td align="center"> 
			<form action="<?php echo site_url('report/tallyEntryFormWithIgmContInfo/'.$lclAssignmentList[$i]['cont_number'].'/'.$lclAssignmentList[$i]['Import_Rotation_No'])?>" target="_blank" method="POST">						
				<input type="submit" value="Tally Entry"  class="login_button" style="width:100%;">							
			</form> 
        </td> 
		  
         </tr>
         <?php
        }
       ?>
	</table>
  </div>
   </div>

          <div class="clr"></div>
        </div>
       
   
      </div>
      <div class="sidebar" style="width:140px">
    <?php include_once("mySideBar.php"); ?>
   </div>
      <div class="clr"></div>
    </div>
 <?php echo form_close()?>
  </div>
  