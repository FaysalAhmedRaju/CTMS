<script type="text/javascript">
	function delete_product()
	{
		if (confirm("Do you want to detete this entry?") == true)
		{
			return true ;
		}
		else
		{
			return false;
		}
	}
</script>
<div class="content">
	<div class="content_resize">
		<div class="mainbar">
			<div class="article">
				<h2><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
    <table>
                <form action="<?php echo site_url('report/product_list');?>" method="POST">	
                 <tr>
		<td align="center" >
		<label for=""><nobr><b>Product Type:</b></nobr><em>&nbsp;</em></label></td>

                <td>
                    <select  id="product_type" name="product_type"  value=""  >
                             <option value="">--Select--</option>
                            <?php
                            for($i=0; $i<count($product_type_list); $i++){ ?>
                                <option value="<?php echo $product_type_list[$i]['short_name']; ?>"><?php echo $product_type_list[$i]['short_name']; ?></option>
                           <?php } ?>
                    </select>
                  </td>  
                <td  align="left">
                    <input type="submit" value="View" name="search" class="login_button">
	   
		</td>
                </form>
                </tr>
     </table>
				<div class="clr"></div>
				<div class="img">
					<table width="600px">
						<tr>
							<th class="gridDark">Sl</th>
							<th class="gridDark">Name</th>
							<th class="gridDark">Description</th>
							<!--th class="gridDark">Created By</th-->
							<th class="gridDark">Action</th>
							<th class="gridDark">Action</th>
						</tr>
						<?php
						for($i=0;$i<count($rslt_product_list);$i++)
						{
							$id=$rslt_product_list[$i]['id'];
							$short_name=$rslt_product_list[$i]['short_name'];
							$product_desc=$rslt_product_list[$i]['product_desc'];
							$created_by=$rslt_product_list[$i]['created_by'];
						?>
						<tr>
							<td class="gridLight" align="center"><?php echo $i+1; ?></td>
							<td class="gridLight" align="center"><?php echo $short_name; ?></td>
							<td class="gridLight" align="center"><?php echo $product_desc; ?></td>
							<!--td class="gridLight" align="center"><?php echo $created_by; ?></td-->
							<td class="gridLight" align="center">
								<form id="product_edit_form" name="product_edit_form" method="post" action="<?php echo site_url("report/product_edit_form"); ?>">
									<input id="product_id" name="product_id" type="hidden" value="<?php echo $id; ?>" />
									<input id="edit_btn" name="edit_btn" type="submit" value="Edit" class="login_button" />
								</form>
							</td>
							<td class="gridLight" align="center">
								<form id="product_delete_form" name="product_delete_form" method="post" action="<?php echo site_url("report/product_delete_form"); ?>" onsubmit="return(delete_product());">
									<input id="product_id" name="product_id" type="hidden" value="<?php echo $id; ?>" />
									<input id="delete_btn" name="delete_btn" type="submit" value="Delete" class="login_button" disabled />
								</form>
							</td>
						</tr>
						<?php
						}
						?>
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
</div>
	