<style>


@media screen and (max-width: 450px) {


.table1 {
	display:table;
   width: 350px;
}

.table2{
	width:100%;
}
  .tr1 {
    width: 100%;
	display:inline;
	
  }
  .tr2 {
    width: 25%;
	
  }
  .tr3 {
    width: 31%;
	
  }
  .tr4 {
    overflow:scroll;
	
  }
  .tr {
    display: block;
    width:100%;
    
  }

}

</style>
<?php session_start();?>
<html >
<head>
	<title>Upload Signature</title> 
	<link rel="stylesheet" href="<?php echo CSS_PATH; ?>signature-pad.css">
	<script type="text/javascript">
	function clearBOBox(val)
	{
		if(val=="bo")
		{
			signaturePad.clear();
		}
		if(val=="ff")
		{
			signaturePad1.clear();
		}
		if(val=="cpa")
		{
			signaturePad2.clear();
		}
	}
	function validate()
	{
		if (signaturePad.isEmpty()) {
			//alert("hello");
			  alert("Please provide Bearth Operator signature first.");
			return false;
		}
		else if (signaturePad1.isEmpty()) {
			//alert("hello");
			alert("Please provide Freight Forwarder signature first.");
			return false;
		}
		else if (signaturePad2.isEmpty()) {
			//alert("hello");
			alert("Please provide CPA signature first.");
			return false;
		}
		else{
			var div = document.getElementById('popup1');
			div.style.display = 'none';
			return true;
		}
		
	}
	</script>
	
</head>

<body>
	<a class="close" href="#" data-action="clear">&times;</a >
	<!--button type="button" class="close" data-action="clear">&times;</button-->
<?php //echo $signCategoryType."-CategoryType-"; ?>
		<div class="divtest2" >		
			
		<div align="center">
			<!--<div  >
				<img src="<?php echo IMG_PATH; ?>/MCNYC-logo01.png" width="180px" height="50px" style="background-color:black;"/>
			</div>-->
			<!--div  style="width:190px;height:60px;background-color:black;vertical-align: middle;">
				<img src="<?php echo IMG_PATH; ?>/MCNYC-logo01.png" width="180px" height="50px" style="background-color:black;display : inline-block;margin : auto;margin-top:4px;margin-left:5px;vertical-align:middle;"/>
			</div-->
			<div class="phn5" align="center">Chittagong Port Authority</div>
			<div class="phn5" align="center">Signature Upload Box</div>
			
			<div class="clear"></div>
			
			<input type="hidden" name="param" value="<?php echo $param; ?>">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		</div>
		<form id="myChkForm" name="myChkForm" action="<?php echo site_url('report/uploadSignature');?>" method="post" onsubmit="return validate()" >
		<div>
				<table>
					<tr>
						<td>
							Rotation Number <label id="rotNum"></label>
							<input  id="rotNumber" type="hidden" name="rotNumber" />
						</td>
						<td>
							Container Number <label id="contNum"></label>
							<input  id="contNumber" type="hidden" name="contNumber" />
							<input  id="user" type="hidden" name="user" />
						</td>
					</tr>
				</table>
			</div>
			<div >Sign Below : </div> </br>
		<div>
		<div id="signature-pad" class="m-signature-pad" style="border:1px #EAEAEA;height:100%; ">		
			<table>
			<tr>
				<td>
					Berth Operator Signature
				</td>
				<td>
					Freight Forwarder Signature
				</td>
				<td>
					CPA Signature				
				</td>
			</tr>
			<tr>
				<td>
					<div class="m-signature-pad--body">
						<canvas id="canvas" style="border:1px solid #EAEAEA">
						</canvas>
					</div>
					<div>
						<table>
							<tr>
								<td>Name: </td>
							</tr>
							<tr>
								<td>Designation: </td>
							</tr>
						</table>
					</div>
				</td>
				<td>
					<div class="m-signature-pad--body">
						<canvas id="canvas1" style="border:1px solid #EAEAEA">
						</canvas>
					</div>
					<div>
						<table>
							<tr>
								<td>Name: </td>
							</tr>
							<tr>
								<td>Designation: </td>
							</tr>
						</table>
					</div>
				</td>
				<td>
					<div class="m-signature-pad--body">
						<canvas id="canvas2" style="border:1px solid #EAEAEA">
						</canvas>
					</div>
					<div>
						<table>
							<tr>
								<td>Name: </td>
							</tr>
							<tr>
								<td>Designation: </td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<button type="button" class="clear myButton" onclick="clearBOBox('bo')">Clear BO Signature</button>
				</td>
				<td>
					<button type="button" class="clear myButton" onclick="clearBOBox('ff')">Clear FF Signature</button>
				</td>
				<td>
					<button type="button" class="clear myButton" onclick="clearBOBox('cpa')">Clear CPA Signature</button>			
				</td>
			</tr>
			</table>
			
			
			<div class="m-signature-pad--footerup" >
				</br>
				<div>
					USER : <label id="userName"></label>
				</div>
				<div>
					Date: <?php echo date("m/d/Y"); ?>
					<input  type='hidden' id="datepicker2" name="sign_date" value="<?php echo date("m/d/Y"); ?>" style="width:230px"/><br>
					<div><font size="1"><?php echo "IP Address: ".$_SERVER['REMOTE_ADDR']; ?></font></div>
				</div>
			</div>
			
			
			<div class="common">
			</div>
			<div class="m-signature-pad--footer" >
				</br>
				<div>
				<input type="hidden" id="my_hidden" name="my_hidden" >
				<input type="hidden" id="my_hidden_ff" name="my_hidden_ff" >
				<input type="hidden" id="my_hidden_cpa" name="my_hidden_cpa" >
				<button type="button" class="clear myButton" data-action="clear">Clear All</button>
				<!--button type="submit" class="save myButton" data-action="save" onclick="uploadSignature()">Save</button-->
				<button type="submit" class="save myButton" data-action="save">Save</button>
				<!--input type="submit" class="save myButton" value="Save"/-->
				</div>
			</div>
			<div>
				<iframe name="msgbar" id="msgbar" width="800" height="50" frameborder="0"></iframe>
			</div>
		</div>
		</form>
	</div>
	<div>
	<br/>
		<!--<p>...........................................................................................</p>
		<p>Customer Signature (as on Photo ID)</p>-->
		<div class="phn5">&nbsp;</div>
	</div>

	  
		
		
		
		<script src="<?php echo JS_PATH; ?>signature_pad.js"></script>		
		<script src="<?php echo JS_PATH; ?>appSignUp.js"></script>

	</div>
	</body>
	</html>