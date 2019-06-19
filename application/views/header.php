<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo GEN_TITLE ; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="cache-control" content="no-cache, no store"/>
<META Http-Equiv="Pragma" Content="no-cache">
<META Http-Equiv="Expires" Content="0">
<link rel="shortcut icon" href="<?php echo IMG_PATH; ?>cpa.png" />
<link href="<?php echo CSS_PATH; ?>style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>coin-slider.css" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>login_style.css" />
<script type="text/javascript" src="<?php echo JS_PATH; ?>cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>cufon-titillium-250.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>script.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>coin-slider.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>welcome_ccha.js"></script>
</head>
<body>
<div class="main">
	<div class="header">
		<div class="header_resize">
			<div class="logo">
				<h1><a href="#"><?php echo GEN_TITLE ; ?><small>.......................................................................................................................</small></a></h1>
			</div>	   
			<div class="menu_nav">
				<ul>
					<?php
						//echo $_SERVER['SERVER_NAME'];
						$path= 'http://'.$_SERVER['SERVER_NAME'].'/myportpanel/resources/download/';
					?>
					<li class="active"><a href="<?php site_url('welcome/index') ?>"><span>Home Page</span></a></li>
					<!--li class="active"><a href="<?php echo $path.'C&F_Agent_USER_ID_Enlistment_Form.pdf';?>" download ><span>User ID Form</span></a></li-->
					<li class="active"><a href="<?php echo $path.'copino_sample.xls';?>"><span>Copino Sample</span></a></li>
					<!--<li><a href="#"><span>About Us</span></a></li>
					<li><a href="#"><span>Blog</span></a></li>
					<li><a href="#"><span>Contact Us</span></a></li>-->
				</ul>
				<ul>
					<?php
						$path2= 'http://'.$_SERVER['SERVER_NAME'].'/myportpanel/resources/CopinoManual/';
					?>
					<li class="active" ><a target="_blank" href="<?php echo $path2. 'CopinoManual.pdf'; ?>"><span>Copino Manual</span></a></li>
					<!-- <li><a href="<?php echo $path.'CopinoManual.pdf';?>" target="_BLANK"><span>Download PDF</span></a></li>-->
				</ul>
			</div>
			<div class="clr"></div>
			<div class="slider">
				<div id="coin-slider"> 
					<a href="#"><img src="<?php echo IMG_PATH; ?>slider_1.png" width="935" height="272" alt="" /> </a> 
					<a href="#"><img src="<?php echo IMG_PATH; ?>slide8.png" width="935" height="272" alt="" /> </a> 
					<a href="#"><img src="<?php echo IMG_PATH; ?>slide7.png" width="935" height="272" alt="" /></a>
					<!--a href="#"> <img src="<?php echo IMG_PATH; ?>slide3.png" width="935" height="272" alt="" /></a-->
					<a href="#"><img src="<?php echo IMG_PATH; ?>sl-5.jpg" width="935" height="272" alt="" /></a> 
					<a href="#"><img src="<?php echo IMG_PATH; ?>sl-4.jpg" width="935" height="272" alt="" /></a>
				</div>
				<div class="clr"></div>
			</div>
			<div class="clr"></div>
		</div>
	</div>