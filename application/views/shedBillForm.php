 <script type="text/javascript">	
function saveTable()
{
	alert("OK");
	var rowsArray = {};
	var i = 0;
	$('#tblBill tr').each(function({
		rowsArray[i] = $(this).html(); // if you want to save the htmls of each row
		i++;
	});
	alert(rowsArray);
	/*
	$.ajax({
   type: 'post',
   url: URL_TO_UR_SCRIPT,
   data: { myarray : rowsArray },
   success: function(result) {
     //ur success handler OPTIONAL
   }
	});*/
}
</script> 
<style>
	input:focus
	{
		background-color:#A9E2F3;
	}

	select:focus
	{
		background-color:#A9E2F3;
	}

</style>
 <div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
   <h2><span><?php echo $title; ?></span> </h2>
   <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
   
   <div class="clr"></div>
   <div class="img">

    <!--form name= "myForm" onsubmit="return(validate());" action="<?php echo site_url("ShedBillController/pdf_download");?>" method="post" target="_blank"-->	
    <form name= "myForm" onsubmit="" action="<?php echo site_url("ShedBillController/shedBillGenerate");?>" method="post">	
	<div align="center">	 
	<table style="border:1px solid #ccc;" width=40%; >
		<tr>
			<td colspan="4" align="center">
				<?php echo $stat; ?>
			</td>
		</tr>
		<tr>
			<td colspan="4" align="center">
				<?php echo $msg; ?>
			</td>
		</tr>
		<tr>
			<td align="left"><label> Verify Number</label></td>
			<td>
				<input type="text"  style="width:130px;" id="verifyNo" name="verifyNo"  tabindex="1"/>
			</td>			
			<td  align="left" colspan="2" align="center">			
			   <input type="submit" name="generate_btn" value="Generate" class="login_button"/>			
			</td>
		</tr>
    </table>
	</form>
	<!--table style="border:1px solid #ccc;" width=40%; >
	
		<tr>
			<td align="left"><label> Bill Number</label></td>
			<td>
				<input type="text"  style="width:130px;" id="verifyNo" name="verifyNo"  tabindex="1"/>
			</td>			
			<td  align="left" colspan="2" align="center">			
			   <input type="submit" name="generate_btn" value="Generate" class="login_button"/>			
			</td>
		</tr>
		<tr>
			<td align="left"><label> Verify Number</label></td>
			<td>
				<input type="text"  style="width:130px;" id="verifyNo" name="verifyNo"  tabindex="1"/>
			</td>			
			<td  align="left" colspan="2" align="center">			
			   <input type="submit" name="generate_btn" value="Generate" class="login_button"/>			
			</td>
		</tr>
    </table-->
	<br/>
	<div align="center"><u>QNTY FOR WHICH CHARGE MADE</u></div>
	<form action="<?php echo site_url('ShedBillController/saveGeneratedBilltoDb')?>" method="POST">
	<table id="tblBill" name="tblBill" style="border:1px solid #ccc;" width=70%;>
	
		<tr class="gridDark">
			<td>
				CODE
			</td>
			<td>
				DESCRIPTION
			</td>
			<td>
				RATE(T/$)
			</td>
			<td>
				QNTY
			</td>
			<td>
				DAYS
			</td>
			<td>
				PORT(TK)
			</td>
			<td>
				VAT(TK)
			</td>
			<td>
				MLWF(TK)
			</td>
			
		</tr>
		  <?php
       //print_r(array_values($tariffData));
        for($i=0;$i<count($chargeList);$i++) {
			
			if($chargeList[$i]['qday']>0)
			{
         ?>
		<input type="hidden" value="<?php echo $chargeList[$i]['verify_no'];?>"  name="verifyNo" style="width:80px">
        <tr class="gridLight">
			
			<td>
			   <?php echo $chargeList[$i]['gl_code'];?>
			</td>
			 <!-- <td align="center" -->
			<td>
			   <?php echo $chargeList[$i]['description']?>
			</td>
			<td>
			   <?php echo $chargeList[$i]['tarrif_rate'];?>
			</td>
			 <!-- <td align="center" -->
			<td>
			   <?php echo $chargeList[$i]['Qty']?>
			</td>
			<td>
				<?php if($chargeList[$i]['gl_code']!=206031 && $chargeList[$i]['gl_code']!=206033 && $chargeList[$i]['gl_code']!=206035 && $chargeList[$i]['qday']=1) {?>
			    <?php echo "";} else {?>
				<?php echo $chargeList[$i]['qday'];}?>
			</td>
			 <!-- <td align="center" -->
			<td>
			   <?php echo $chargeList[$i]['amt']?>
			</td>
			<td>
			   <?php echo $chargeList[$i]['vatTK'];?>
			</td>
			 <!-- <td align="center" -->
			<td>
			   <?php echo "";?>
			</td>
		</tr>
			<?php }} ?>
	</table>
	<BR/>
	<table align="center" style="border:1px solid BLACK;" width=30%;>
		<tr>
			<td>
										
					<input type="submit" value="SAVE"  class="login_button" style="width:100%;">							
				</form> 
				
			</td>
			
				<?php 
					if($chkGenerate==1)
					{
				?>
				<td>
				<form action="<?php echo site_url('ShedBillController/getShedBillPdf')?>" target="_blank" method="POST">						
					<?php
					for($i=0;$i<count($chargeList);$i++) {						
						if($chargeList[$i]['qday']>0)
						{
					 ?>
						<input type="hidden" value="<?php echo $chargeList[$i]['verify_no'];?>"  name="sendVerifyNo"">
					<?php }} ?>
					<input type="submit" value="VIEW BILL"  class="login_button" style="width:100%;">							
				</form> 
				</td>
					<?php }?>
			
		</tr>
	</table>
	</div>

	<br/>
   </div>
          <div class="clr"></div>
        </div>
       
   
      </div>
      <div class="sidebar">
    <?php include_once("mySideBar.php"); ?>
   </div>
      <div class="clr"></div>
    </div>
  </div>