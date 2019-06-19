<select name="txt_line" maxlength="50" onFocus="gsLabelObj(lbl_org_id,'#61BCEF','white')" onchange="myShowmlocode(this.value)">
        
				<?php
				include_once("mydbPConnection.php");
		        //print("select * from tbl_org_types");
				//print("shemul bhowmick");
                $qry=$_GET['q'];
				//Organization Name
				$resultcombo6 = mysql_query("select  distinct Organization_Name,organization_profiles.id from organization_profiles inner join 
								igm_details 
								on igm_details.Submitee_Org_Id=organization_profiles.id
								where igm_details.Import_Rotation_No='$qry'
								");
				//$resultcombo7 = mysql_query("select * from egm_details where Export_Rotation_No='$qry' ORDER BY EXP_No");
				
				?>
				<option value="">------------Select-------------</option>
				<?php
				while ($rowcombo6 = mysql_fetch_object($resultcombo6)){
				?>
                
				<option value="<?php print($rowcombo6->id);?>"><?php print($rowcombo6->Organization_Name);?></option>
	
				<?php			    
				}
					
                ?>
				<option value="all">ALL</option>
				<?php mysql_close($con_cchaportdb);?>
		</select>