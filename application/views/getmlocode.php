<select name="ddl_Org_id" maxlength="50" onFocus="gsLabelObj(lbl_org_id,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id,'','')" >
        
				<?php
				include_once("mydbPConnection.php");
		        //print("select * from tbl_org_types");
				
				//$rot=$_GET["rot"];
				$type=$_GET["id"];
				if($type=='2619')
				$type='2619 or Submitee_Org_Id=153';

				//mlo code
				/*$str="select  distinct Organization_Name,mlocode from organization_profiles inner join 
					igm_details 
					on igm_details.Submitee_Org_Id=organization_profiles.id
					where organization_profiles.id='$type' 
					union
					select  distinct Organization_Name,mlocode from organization_profiles inner join 
					igm_details_history
					on igm_details_history.Submitee_Org_Id=organization_profiles.id
					where organization_profiles.id='$type' order by mlocode asc";*/

				$str="select distinct mlocode from mlocode_igm where Submitee_Org_Id=$type";
				$resultcombo6 = mysql_query($str);
				//print($str);
				?>
				<option value="">--------SELECT--------</option>
				<?php
				while ($rowcombo6 = mysql_fetch_object($resultcombo6)){
			
				?>
				
               	<option value="<?php print($rowcombo6->mlocode);?>"><?php print($rowcombo6->mlocode);?></option>
				
				<?php
			    
				}	
                ?>
				<?php mysql_close($con_cchaportdb);?>
		</select>
