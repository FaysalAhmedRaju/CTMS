 <script type="text/javascript">
   
   function validate()
   {
    if( document.myForm.date.value == "" )
      {
       alert( "Please provide date!" );
       document.myForm.fromdate.focus() ;
       return false;
      }
    
    if( document.myForm.todate.value == "" )
    {
     alert( "Please provide todate!" );
     document.myForm.todate.focus() ;
     return false;
    }
    return true ;
   }
</script> 
 
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
   <h2><span><?php echo $title; ?></span> </h2>
   <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
   
   <div class="clr"></div>
   <div class="img">
     <!--<div id="login_container">-->
    <form name= "myForm" onsubmit="return(validate());" action="<?php echo site_url("report/last24HrPositionFormPerform");?>" target="_blank" method="post">
     <table align="center" style="border:solid 1px #ccc;" width="550px" align="center" cellspacing="0" cellpadding="0">
		<tr>
			<td>&nbsp;</td>
		</tr>

      <tr>
       <td align="left" ><label><font color='red'><b></font>&nbsp;&nbsp;&nbsp;&nbsp; Date :  </b></label></td>
        <td>
         <input type="text" style="width:130px;" id="date" name="date" value="<?php date("Y-m-d"); ?>"/>
        </td>
			<script>
			 $(function() {
			 $( "#date" ).datepicker({
			  changeMonth: true,
			  changeYear: true,
			  dateFormat: 'yy-mm-dd', // iso format
			 });
			 });
			</script>
		<td>&nbsp;</td>
		<td align="left" ><label><font color='red'><b></font>&nbsp; Unit :  </b></label></td>
	   <td>
		   <select name="unit" id="unit" >
			<option value="">----Select--------</option>
				<!--option value="'HS1','Y2','YMN'">Unit-1</option> 
				<option value="'Y3A','Y3B','HS6','HS9','Y10','Y11'">Unit-2</option> 
				<option value="'HS7','Y8','Y8B','BAPX1','BAPX2'">Unit-3</option> 
				<option value="'Y5A','Y5B','Y6X'">Unit-4</option> 
				<option value="'J1','J2','J3','J4','J5','J6','CW','DR1','DR2','AB','ABA','ABB','ABC'">Unit-5</option> 
				<option value="'NCA','NCB','NCC','NCD','NCY'">NCY</option> 
				<option value="'CSF','CSE'">ICD</option--> 
				<option value="UNIT-1">Unit-1</option> 
				<option value="UNIT-2">Unit-2</option> 
				<option value="UNIT-3">Unit-3</option> 
				<option value="UNIT-4">Unit-4</option> 
				<option value="UNIT-5">Unit-5</option> 
				<option value="NCY">NCY</option> 
				<option value="ICD">ICD</option> 

		   </select>	
		</td>
      </tr>

		<tr>
			<td>&nbsp;</td>
		</tr>

      <tr>
       <td colspan="7" align="center">
        <input type="submit" value="View" class="login_button"/>      
       </td>
      </tr>
      <tr>
       <td>&nbsp;</td>
      </tr>
     </table>
    </form>
    </table>
   
      </div>

	  <div class="clr"></div>
	</div>
       
      </div>
      <div class="sidebar">
    <?php include_once("mySideBar.php"); ?>
   </div>
      <div class="clr"></div>
    </div>
 <?php echo form_close()?>
  </div>