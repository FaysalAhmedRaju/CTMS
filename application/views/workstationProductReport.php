
<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2 align="left"><span><?php echo $title; ?></span> </h2>
		  

          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>	  
		 
	
	<div class="img">         
		   
   	<table cellspacing="1" cellpadding="1" align="center"  id="mytbl" style="overflow-y:scroll" >
            <form action="<?php echo site_url('report/workstationReportPerform');?>" method="POST" target="_blank" >
             <tr><td colspan="12" align="center">  <span><font color="green"  size="4" style="font-weight: bold"><nobr><?php print $tableTitle; ?></nobr></font></span></td></tr>
		 
		<tr>
			<td align="center" >
			<label for=""><nobr><b>Search By :</b></nobr><em>&nbsp;</em></label></td>

					<td>
						<select name="search_by" id="search_by">
							<option value="ALL" label="all" selected style="width:110px;">ALL</option>
							<option value="serial" label="Serial No">Serial No</option>
							<option value="ip_addr" label="IP Address">IP Address</option>
						 </select>
			</td>

			<td><b><nobr>Search Value:</nobr></b></td>
			<td>
						<input type="text" style="width:170px" id="searchInput" name="searchInput" autofocus />
			</td>

			<td  align="center" width="150px">
						<input type="submit" value="View PDF" name="View " class="login_button">
			</td>
		</tr>
            </form>
        </table>

    </form>

	</div>
			
          <div class="clr"></div>
        </div>

      </div>
      <div class="sidebar" style="width:140px; padding: 0px 0 12px;">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>