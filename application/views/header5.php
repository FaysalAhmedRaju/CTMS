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
<!--<script type="text/javascript" src="<?php echo JS_PATH; ?>autologout.js"></script>-->
<script type="text/javascript" src="<?php echo JS_PATH; ?>cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>cufon-titillium-250.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>script.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>coin-slider.min.js"></script>
 <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.ptTimeSelect.js"></script>
 <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>jquery.ptTimeSelect.css" />
 <script type="text/javascript"t src="<?php echo JS_PATH; ?>AdvancedCalender1.js"></script>
<!--<script type="application/javascript" src="http://jsonip.appspot.com/?callback=getip">  </script>-->

 <script type="text/javascript" src="<?php echo JS_PATH; ?>calender.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>calender.jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css"  href="<?php echo CSS_PATH; ?>calender.jquery-ui.css" />

<script type="text/javascript">

history.pushState(null, null, 'pagename');
window.addEventListener('popstate', function(event) {
history.pushState(null, null, 'pagename');
});

/*var timeout1=100*60*1000;

setTimeout('resetlogout()',1000);
//

function resetlogout()
{
//alert('125');
this.timeout1=this.timeout1-1000;

//var m=<?php print($myflag); ?>;
//if(m!=9&&m!=1){
if(this.timeout1<=0)
{
alert("shemul");

location.href ="<?php echo base_url(); ?>index.php/login/logout";
}
setTimeout('resetlogout()',1000);
//}
}

function settime()
{

this.timeout1=100*60*1000;

}*/
</script>

</head>
<body>
<div class="main_2">
  <div class="header">
    <div class="header_resize">
      <div class="logo">
        <h1><a href="#"><?php echo GEN_TITLE ; ?><small>.......................................................................................................................</small></a></h1>
      </div>
     <!-- <div class="menu_nav">
        <ul>
          <li class="active"><a href="index.html"><span>Home Page</span></a></li>
          <li><a href="support.html"><span>Support</span></a></li>
          <li><a href="about.html"><span>About Us</span></a></li>
          <li><a href="blog.html"><span>Blog</span></a></li>
          <li><a href="contact.html"><span>Contact Us</span></a></li>
        </ul>
      </div>-->
      <div class="clr"></div>
    <!--  <div class="slider">
        <div id="coin-slider"> <a href="#"><img src="<?php echo IMG_PATH; ?>slide1.png" width="935" height="272" alt="" /> </a> <a href="#"><img src="<?php echo IMG_PATH; ?>slide2.png" width="935" height="272" alt="" /> </a> <a href="#"><img src="<?php echo IMG_PATH; ?>slide3.png" width="935" height="272" alt="" /> <img src="<?php echo IMG_PATH; ?>slide6.png" width="935" height="272" alt="" /></a> </div>
        <div class="clr"></div>
      </div>-->
      <div class="clr"></div>
    </div>
  </div>