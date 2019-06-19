
		<style>
		.myButton {
	-moz-box-shadow: 0px 0px 0px 0px #f0f7fa;
	-webkit-box-shadow: 0px 0px 0px 0px #f0f7fa;
	box-shadow: 0px 0px 0px 0px #f0f7fa;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #33bdef), color-stop(1, #019ad2));
	background:-moz-linear-gradient(top, #33bdef 5%, #019ad2 100%);
	background:-webkit-linear-gradient(top, #33bdef 5%, #019ad2 100%);
	background:-o-linear-gradient(top, #33bdef 5%, #019ad2 100%);
	background:-ms-linear-gradient(top, #33bdef 5%, #019ad2 100%);
	background:linear-gradient(to bottom, #33bdef 5%, #019ad2 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bdef', endColorstr='#019ad2',GradientType=0);
	background-color:#33bdef;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #057fd0;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:15px;
	font-weight:bold;
	padding:6px 24px;
	text-decoration:none;
	text-shadow:0px -1px 0px #5b6178;
}
.myButton:hover {
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #019ad2), color-stop(1, #33bdef));
	background:-moz-linear-gradient(top, #019ad2 5%, #33bdef 100%);
	background:-webkit-linear-gradient(top, #019ad2 5%, #33bdef 100%);
	background:-o-linear-gradient(top, #019ad2 5%, #33bdef 100%);
	background:-ms-linear-gradient(top, #019ad2 5%, #33bdef 100%);
	background:linear-gradient(to bottom, #019ad2 5%, #33bdef 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#019ad2', endColorstr='#33bdef',GradientType=0);
	background-color:#019ad2;
}
.myButton:active {
	position:relative;
	top:1px;
}
</style>

 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		

	<?php
		include('dbConection.php');
		$str = "select distinct sparcsn4.vsl_vessel_visit_details.vvd_gkey,concat(sparcsn4.vsl_vessels.name,'-',sparcsn4.vsl_vessel_visit_details.ib_vyg) as vsl
		from sparcsn4.vsl_vessel_visit_details
		inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
		inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
		where sparcsn4.argo_carrier_visit.phase not in('80CANCELED','70CLOSED') order by sparcsn4.argo_carrier_visit.phase desc";
		$query = mysql_query($str);
	?>
	<div class="img">
		<form action="<?php echo site_url("report/blankBayView");?>" target="_blank" method="post">
			<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
			<input type="hidden" name="get" value="no">
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
				<td colspan="2" align="center"><font size="4"><b>Vessel View Form</b></font></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr align="center">
					<td align="center">&nbsp;&nbsp;<b>Vessel :</b></td>
					<td>
						<select name="vvdGkey">
							<option>----Select Vessel----</option>
							<?php while($row = mysql_fetch_object($query)){ ?>
								<option value="<?php echo $row->vvd_gkey; ?>"><?php echo $row->vsl; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="View" class="login_button"/>						
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
		</form>
		</div>
		<div class="clr"></div>
        </div>
       <?php mysql_close($con_sparcsn4);?>
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	
  </div>