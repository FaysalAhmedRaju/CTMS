<select name="ddl_Org_id" id="ddl_Org_id" maxlength="50" onFocus="gsLabelObj(lbl_org_id,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id,'','')" onchange="myshowmloreport()">
        
				<?php
				include_once("mydbPConnection.php");
		        //print("select * from tbl_org_types");
				
				$rot=$_GET['rot'];
				$type=$_GET['t'];
				echo $rot."=".$type;
				$str="select DISTINCT organization_profiles.id as id,organization_profiles.Organization_Name as name from igm_details,organization_profiles where igm_details.Submitee_Org_Id = organization_profiles.id and Import_Rotation_No='$rot' and type_of_igm='$type' ";
				echo $str;
				$resultcombo6 = mysql_query($str);
				?>
				<option value="">--------SELECT--------</option>
				<?php
				while ($rowcombo6 = mysql_fetch_object($resultcombo6)){
				?>
                <option value="<?php print ($rowcombo6->id);?>"><?php print($rowcombo6->name);?></option>
				
				<?php
			    
				}	
                ?>
				<?php mysql_close($con_cchaportdb);?>	
		</select>