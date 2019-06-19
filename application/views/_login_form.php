<div class="form1">
<?php echo form_open(base_url().'index.php/login/')?>
<div class="formtitle">Login to your account</div>
<?php echo validation_errors(); ?>
<span class="error"><b><?php echo $login_failed; ?></b></span>

			<div class="input nobottomborder">
				<div class="inputtext">Username Or Email: </div>
				<div class="inputcontent">
<input type="text" name="username" value="<?php echo set_value('username'); ?>"/>

				</div>
			</div>

			<div class="input nobottomborder">
				<div class="inputtext">Password: </div>
				<div class="inputcontent">

<input type="password" name="password" value="<?php echo set_value('password'); ?>" /><br/>
</div>
			</div>

			<div class="buttons">
<input class="orangebutton" type="submit" value="Submit" name="submit_login"/>
</div>

<?php echo form_close()?>
</div>
<!--Sourav-->