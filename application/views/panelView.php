<script>
 
 // *******************MODEL START *************//
			$(window).load(function () {
			  document.getElementById('myModal').style.display = "block";
			});
			$(window).click(function(e) {
				//alert(e.target.id); // gives the element's ID 
				//alert(e.target.className); // gives the elements class(es)
				document.getElementById('myModal').style.display = "none";
			});
			// *******************MODEL END*************//
 </script>
 <style>
 .blink {
    animation-duration: .3s;
    animation-name: blink;
    animation-iteration-count: infinite;
    animation-direction: alternate;
    animation-timing-function: ease-in-out;
	padding-left:5px;
}
.blink:hover {
    opacity: 1;
    -webkit-animation-name: none;
    /* should be set to 100% opacity as soon as the mouse enters the box; when the mouse exits the box, the original animation should resume. */
}
@keyframes blink {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}

/* The Modal (background) */
				.modal {
					display: none; /* Hidden by default */
					position: fixed; /* Stay in place */
					z-index: 1; /* Sit on top */
					padding-top: 100px; /* Location of the box */
					left: 0;
					top: 0;
					width: 100%; /* Full width */
					height: 100%; /* Full height */
					overflow: auto; /* Enable scroll if needed */
					background-color: rgb(0,0,0); /* Fallback color */
					background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
				}

				/* Modal Content */
				.modal-content {
					position: relative;
					background-color: #fefefe;
					margin: auto;
					padding: 0;
					border: 1px solid #888;
					width: 80%;
					box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
					-webkit-animation-name: animatetop;
					-webkit-animation-duration: 0.4s;
					animation-name: animatetop;
					animation-duration: 0.4s
				}

				/* Add Animation */
				@-webkit-keyframes animatetop {
					from {top:-300px; opacity:0} 
					to {top:0; opacity:1}
				}

				@keyframes animatetop {
					from {top:-300px; opacity:0}
					to {top:0; opacity:1}
				}

				/* The Close Button */
				.close {
					color: white;
					float: right;
					font-size: 28px;
					font-weight: bold;
				}

				.close:hover,
				.close:focus {
					color: #000;
					text-decoration: none;
					cursor: pointer;
				}

				.modal-header {
					padding: 2px 16px;
					background-color: #5858FA;
					color: white;
					align:center;
				}

				.modal-body {padding: 2px 16px;}

				.modal-footer {
					padding: 2px 16px;
					background-color: #5858FA;
					color: white;
				}
 </style>
 
 <div class="content">
    <div class="content_resize">
		<?php
			$usr = strtoupper($this->session->userdata('login_id'));
			$orgId = $this->session->userdata('org_Type_id');
			if($usr=="CPACS1"){
		?>
		<div style="font-size:20px;color:red;">
			<marquee hspace="1"><b>This <strong><?php echo $this->session->userdata('login_id'); ?></strong> user id will close soon. Please collect your own user id for portpanel.</b></marquee>
		</div>
		<?php
			}else if($orgId==6){
		?>
		<!--div style="font-size:20px;color:red;">
			<marquee hspace="1"><b>Please send your company logo to this email id <strong>care.ctms@datasoft-bd.com</strong> as we will update your user id info and display your logo to reports</b></marquee>
		</div-->
		<?php
			}else if($orgId==57){
		?>
		<div style="font-size:20px;color:red;">
			<marquee hspace="1"><b>Dear all, from <strong>Today(25/07/2018)</strong> commodity description and vat/nonvat field is mandatory to upload copino file. For more detail please Contact CTMS helpline:01749-923327</b></marquee>
		</div>
		<div id="myModal" class="modal">
			  <!-- Modal content -->
			  <div class="modal-content">
				<div class="modal-header">
				  <span class="close">&times;</span>
				  <div align="center" style="">
					<b>CHITTAGONG PORT AUTHORITY</b>
				</div>
				</div>
				<div class="modal-body">
					<div align ="center" style="font-size:20px;color:red;">
						<b>Please Upload EDI from myportpanel. <br>For more info , Please contact with CTMS help desk (01749923327).</b>
					</div>
				</div>
				<!--div class="modal-footer">
				  <h3>Modal Footer</h3>
				</div-->
			  </div>

		</div>
		<!--div id="myModal" class="modal">
		  <!-- Modal content -->
		  <!--div class="modal-content">
			<div class="modal-header">
			  <span class="close">&times;</span>
			  <div align="center" style="">
				<b>CHITTAGONG PORT AUTHORITY</b>
			</div>
			</div>
			<div class="modal-body">
				<div align ="center" style="font-size:20px;color:red;">
					<b>Dear all, from <strong>24/07/2018</strong> commodity code and vat/nonvat field will be mandatory to upload copino file.</br> For more detail please Contact CTMS helpline:01749-923327</b>
				</div>
			</div>
			<!--div class="modal-footer">
			  <h3>Modal Footer</h3>
			</div-->
		  <!--/div>

		</div-->
		<?php
			}
			else if($orgId==30)
			{
		?>
			<div id="myModal" class="modal">
			  <!-- Modal content -->
			  <div class="modal-content">
				<div class="modal-header">
				  <span class="close">&times;</span>
				  <div align="center" style="">
					<b>CHITTAGONG PORT AUTHORITY</b>
				</div>
				</div>
				<div class="modal-body">
					<div align ="center" style="font-size:20px;color:red;">
						<b>As per decision of Terminal Manager, CPA<br>if there is any incomplete Export vessel in CTMS, Berth/Terminal Operator will NOT be able to view/download All Import information. <br>For more info , Please contact with Shipping section and CTMS help desk.</b>
					</div>
				</div>
				<!--div class="modal-footer">
				  <h3>Modal Footer</h3>
				</div-->
			  </div>

			</div>
		
			<?php } ?>
		<!--div>
			<p style="text-align: justify;padding-left:15px;padding-right:15px;">
				<font color='red' size='4'>
					<b>Current MyportPanel URL will NOT be available soon.
					New Global URL: http://115.127.51.199/myportpanel<br/>
					Please save it.
					<br/>
					For any help please Contact CTMS helpline:01749-923327</b>
				</font>
			</p>
		</div-->
      <div class="mainbar">
	  
        <div class="article">
			
          <h2><span>SUCCESSFULLY LOGGED IN AS <?php echo strtoupper($this->session->userdata('login_id')); ?>.....</span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		  <h2><span><?php echo $title; ?></span> </h2>
		  
          <div class="img"><img src="<?php echo IMG_PATH; ?>panel_pic.jpg" width="600" height="450" alt="" class="fl" /></div>
          <!--<div class="post_content">
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. <a href="#">Suspendisse bibendum. Cras id urna.</a> Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum odio, ac blandit ante orci ut diam. Cras fringilla magna. Phasellus suscipit, leo a pharetra condimentum, lorem tellus eleifend magna, eget fringilla velit magna id neque. Curabitur vel urna. In tristique orci porttitor ipsum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. Cras id urna. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo.</p>
            <p><strong>Aenean consequat porttitor adipiscing. Nam pellentesque justo ut tortor congue lobortis. Donec venenatis sagittis fringilla.</strong> Etiam nec libero magna, et dictum velit. Proin mauris mauris, mattis eu elementum eget, commodo in nulla. Mauris posuere venenatis pretium. Maecenas a dui sed lorem aliquam dictum. Nunc urna leo, imperdiet eu bibendum ac, pretium ac massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla facilisi. Quisque condimentum luctus ullamcorper.</p>
            <p class="spec"><a href="#" class="rm">Read more &raquo;</a></p>
          </div>-->
          <div class="clr"></div>
        </div>
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar">
	  <?php include_once("mySideBar.php"); ?>
	  
	  </div>
      <div class="clr"></div>
    </div>
	</form>
	<?php //echo form_close()?>
  </div>