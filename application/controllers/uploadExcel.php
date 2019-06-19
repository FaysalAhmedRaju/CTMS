<?php
	class uploadExcel extends CI_Controller {
		
		function __construct()
		{
	    parent::__construct();	
            $this->load->library(array('session', 'form_validation'));
            $this->load->model(array('CI_auth', 'CI_menu'));
            $this->load->helper(array('html','form', 'url'));
			$this->load->driver('cache');
			$this->load->model('CI_auth', 'bm', TRUE);
			$this->load->library("pagination");
			
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			
		}
		
		function index(){
			$data['title']="UPLOAD EXCEL FILE FOR COPINO...";
			$this->load->view('header2');
			$this->load->view('excelUpload',$data);
			$this->load->view('footer');
			//$this->load->view('excelUpload');
        }
		
		function bayView(){
			$data['title']="VESSEL BAY VIEW FORM...";
			$this->load->view('header2');
			$this->load->view('vslViewForm',$data);
			$this->load->view('footer');
			//$this->load->view('excelUpload');
        }
		
		function bayViewPerformed(){
			//$data['title']="VESSEL VIEW FORM...";
			//$this->load->view('header2');
			$this->load->view('vslView');
			//$this->load->view('footer');
			//$this->load->view('excelUpload');
        }
		
		function impBayView(){
			$data['title']="VESSEL BAY VIEW FORM...";
			$this->load->view('header2');
			$this->load->view('impBayViewForm',$data);
			$this->load->view('footer');
			//$this->load->view('excelUpload');
        }
		
		function impBayViewPerformed(){
			$this->load->view('impVslView');
        }
		
		function upload()
		{
			$login_id = $this->session->userdata('login_id');
			$date = date('YmdHis');
			$dbDate = date('Y-m-d H:i:s');
			//echo $dbDate."<br>";
			error_reporting(E_ALL ^ E_NOTICE);   
    
			$filenm=$login_id."_".$date.".xls";
			$filetype=$_POST["file"];
			
			if ($_FILES["file"]["error"] > 0)
			{
				echo "File Error.";
				$data['msg'] = "<b>Error: " . $_FILES["file"]["error"] . "<br />May be your file size exceeds 2MB.Please reduce file size and try again.<br/>To reduce file size-<br/>
				Step1:Save your Excel file into CSV(.csv) format.<br/>
				Step2:Now save your CSV file into Excel(.xls) format.<br/>
				Step3:Upload new Excel(.xls) file again.</b>";
				$data['title']="UPLOAD EXCEL FILE FOR COPINO...";
				$this->load->view('header2');
				$this->load->view('excelUpload',$data);
				$this->load->view('footer');
				return;
			}
			else
			{
			move_uploaded_file($_FILES["file"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadfile/".$_FILES["file"]["name"]);
			
			rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadfile/".$_FILES["file"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadfile/".$filenm);
			}
			//echo "Upload";
			// Load the spreadsheet reader library
			//echo $filenm;
			require_once('excel_reader2.php');
			$mydata = new Spreadsheet_Excel_Reader($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadfile/".$filenm);
			$shipAgent=trim($mydata->value(3,3));
			$callSign=$mydata->value(5,3);
			$voys_no=$mydata->value(6,3);
			$rot=trim($mydata->value(7,3));
			$rot=str_replace(" ","",$rot);
			$expRot=$mydata->value(8,3);
			//echo "Main=".$shipAgent."-".$rot;
			$sqlrot="select sparcsn4.vsl_vessel_visit_details.vvd_gkey as rtnValue from sparcsn4.vsl_vessel_visit_details where sparcsn4.vsl_vessel_visit_details.ib_vyg='$rot'";
			//echo $sqlrot;
			$vvd_gkey=$this->bm->dataReturn($sqlrot);
			//echo "<br>".$vvd_gkey;
			//return;
			if($vvd_gkey==null or $vvd_gkey=="" or $vvd_gkey==" ")
			{
				$data['msg'] = "Rotation ".$rot." not exist in system.<br> PLEASE CORRECT & TRY AGAIN...";
				$data['title']="UPLOAD EXCEL FILE FOR COPINO...";
				$this->load->view('header2');
				$this->load->view('excelUpload',$data);
				$this->load->view('footer');
				return;
			}
			
			$strAgentChk = "select r.id as rtnValue 
			from sparcsn4.vsl_vessel_visit_details 
			INNER JOIN
			( sparcsn4.ref_bizunit_scoped r
			LEFT JOIN ( sparcsn4.ref_agent_representation X
			LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )
			ON r.gkey=X.bzu_gkey
			)  ON r.gkey = sparcsn4.vsl_vessel_visit_details.bizu_gkey
			where sparcsn4.vsl_vessel_visit_details.ib_vyg='$rot'";
			
			$strAgent=$this->bm->dataReturn($strAgentChk);
			if($strAgent!=$shipAgent or $shipAgent=="" or $shipAgent==" ")
			{
				$data['msg'] = "Rotation ".$rot." Shipping agent shuld be ".$strAgent." instead of ".$shipAgent." or should not blank.<br> PLEASE CORRECT & TRY AGAIN...";
				$data['title']="UPLOAD EXCEL FILE FOR COPINO...";
				$this->load->view('header2');
				$this->load->view('excelUpload',$data);
				$this->load->view('footer');
				return;
			}
			
			$totalrow=0;
			$excelrow=$mydata->rowcount(0);
			$i=13;

			while($i<=$excelrow)
			{
				if( $mydata->value($i,3)!="" )
				$totalrow=$totalrow+1;
				$i=$i+1;
			}
			//echo "<br>".$totalrow;
			//return;
			$row=13;   
			$prob = "<table border='1'><tr><td>Container</td><td>Description</td></tr>";
			$st = 0;
			$totCont = "";			
			while($row<($totalrow+13))
			{
				$pod_chk=trim($mydata->value($row,13));
				$containerNo=$mydata->value($row,3);
				$cont_mlo=$mydata->value($row,2);
				$cont_boking_no=$mydata->value($row,4);
				$cont_iso=$mydata->value($row,5);
				$cont_category=$mydata->value($row,16);
				$cont_friedKind=strtoupper(trim($mydata->value($row,17)));
				$cont_commodity=trim($mydata->value($row,55));
				$vatNonvat=strtoupper(trim($mydata->value($row,56)));
				$cont_mlo = preg_replace('/[^A-Za-z0-9\. -]/', '', $cont_mlo);
				$cont_transOperator=trim($mydata->value($row,11));
				
				$strChkPOD="select count(sparcsn4.ref_unloc_code.id) as rtnValue from sparcsn4.ref_unloc_code where sparcsn4.ref_unloc_code.id='$pod_chk'";
				//echo $strChkPOD."<br>";
				//$resChkPOD = mysql_query($strChkPOD);
				$rowChkPOD = $this->bm->dataReturn($strChkPOD);
				
				$strChkOffDoc="select count(id) as rtnValue from ctmsmis.offdoc where id='$cont_transOperator'";
				$offDocId = $this->bm->dataReturn($strChkOffDoc);
				
				$strChkCom="select count(*) as rtnValue from ctmsmis.commudity_detail where commudity_code='$cont_commodity'";
				$resCom = $this->bm->dataReturn($strChkCom);
				$vatSt = 0;
				if($vatNonvat=="VAT")
					$vatSt = 1;
				else if($vatNonvat=="NONVAT")
					$vatSt = 1;
				else
					$vatSt = 0;
				
				if($rowChkPOD==0)
				{		
					//echo $strChkPOD;
					$prob .= "<tr><td>".$containerNo."</td><td>Mismatch POD with system.$st</td></tr>";
					$st = $st+1;
					$totCont .=$containerNo.", ";
				}			
				else if($cont_mlo=="" or $cont_mlo==" ")
				{
					$prob .= "<tr><td>".$containerNo."</td><td>MLO should not be blank.</td></tr>";
					$st = $st+1;
					$totCont .=$containerNo.", ";
				}
				else if($containerNo=="" or $containerNo==" ")
				{
					$prob .= "<tr><td>&nbsp;</td><td>Container No. should not be blank.</td></tr>";
					$st = $st+1;
				}
				else if($pod_chk=="" or $pod_chk==" ")
				{
					$prob .= "<tr><td>".$containerNo."</td><td>POD should not be blank.</td></tr>";
					$st = $st+1;
					$totCont .=$containerNo.", ";
				}
				else if($cont_iso=="" or $cont_iso==" ")
				{
					$prob .= "<tr><td>".$containerNo."</td><td>ISO Code should not be blank.</td></tr>";
					$st = $st+1;
					$totCont .=$containerNo.", ";
				}
				else if($cont_category=="" or $cont_category==" ")
				{
					$prob .= "<tr><td>".$containerNo."</td><td>Category should not be blank.</td></tr>";
					$st = $st+1;
					$totCont .=$containerNo.", ";
				}
				else if($cont_friedKind=="" or $cont_friedKind==" ")
				{
					$prob .= "<tr><td>".$containerNo."</td><td>Status(MTY/FCL) should not be blank.</td></tr>";
					$st = $st+1;
					$totCont .=$containerNo.", ";
				}
				else if($shipAgent=="" or $shipAgent==" ")
				{
					$prob .= "<tr><td></td><td>Shipping Agent should not be blank.</td></tr>";
					$st = $st+1;
				}
				else if($rot=="" or $rot==" ")
				{
					$prob .= "<tr><td></td><td>Import rotation should not be blank.</td></tr>";
					$st = $st+1;
				}
				else if($offDocId<1)
				{
					$prob .= "<tr><td>".$containerNo."</td><td>Mismatched offdoc id at Tranport Operator Column.</td></tr>";
					$st = $st+1;
					$totCont .=$containerNo.", ";
				}
				else if(($cont_friedKind=="FCL" or $cont_friedKind=="LCL") and ($cont_commodity=="" or $cont_commodity==" " or $resCom<1))
				{
					$prob .= "<tr><td></td>".$containerNo."<td>Loaded contariner(s) must have commodity code not description. </td></tr>";
					$st = $st+1;
				}
				else if(($cont_friedKind=="FCL" or $cont_friedKind=="LCL") and ($vatSt==0))
				{
					$prob .= "<tr><td>".$containerNo."</td><td>Loaded contariner(s) must be VAT or NONVAT valued. </td></tr>";
					$st = $st+1;
				}
				$row=$row+1; 
			}
			$prob .= "<tr><td colspan='2'>".$totCont."</td></tr>";
			$prob .= "</table>";
			//echo $st;
			
			if($st>0)
			{
				$data['msg'] = "IN YOUR EXCEL FILE LISTED PROBLEM(S) FOUND<br>".$prob."<br> PLEASE CORRECT & TRY AGAIN...";
				$data['title']="UPLOAD EXCEL FILE FOR COPINO...";
				$this->load->view('header2');
				$this->load->view('excelUpload',$data);
				$this->load->view('footer');
				return;
			}
			else
			{
				$row = 13;
			}
			//echo "<br>".$row;
			//echo "<br>".$totalrow;
			$failStr = "<table border='1'><tr><td colspan='3'>Following containers are  not uploaded. Possible cause is unavailability in system or miss-spelling.</td></tr><tr><td>Rotation</td><td>Container</td><td>MLO</td></tr>";
			$flst = 0;
			$sst = 0;
			$i=0;
			$prevInboundCont = 0;
			while($row<($totalrow+13))
			{
				$i++;
				//echo "<br>".$i;
				$mlo=$mydata->value($row,2);
				$container_no=$mydata->value($row,3);
				$boking_no=$mydata->value($row,4);
				$iso=$mydata->value($row,5);
				//$size=$mydata->value($row,6);
				//$height=$mydata->value($row,7);
				$iso_grp=$mydata->value($row,8);
				$modeTrans=$mydata->value($row,9);
				$transport=$mydata->value($row,10);
				$transOperator=$mydata->value($row,11);
				$pod=$mydata->value($row,13);
				$fpod=$mydata->value($row,14);
				$weight=$mydata->value($row,15);
				$category=$mydata->value($row,16);
				$friedKind=trim($mydata->value($row,17));
				$imoClass1=$mydata->value($row,20);
				$imoClass2=$mydata->value($row,21);
				$imoClass3=$mydata->value($row,22);
				$imoClass4=$mydata->value($row,23);
				$imoClass5=$mydata->value($row,24);
				$unNo1=$mydata->value($row,25);
				$unNo2=$mydata->value($row,26);
				$unNo3=$mydata->value($row,27);
				$unNo4=$mydata->value($row,28);
				$unNo5=$mydata->value($row,29);
				$imoName1=$mydata->value($row,30);
				$imoName2=$mydata->value($row,31);
				$imoName3=$mydata->value($row,32);
				$imoName4=$mydata->value($row,33);
				$imoName5=$mydata->value($row,34);
				$tempUnit=$mydata->value($row,36);
				$minTemp=$mydata->value($row,37);
				$maxTemp=$mydata->value($row,38);
				$OOG=$mydata->value($row,39);
				$OH=$mydata->value($row,40);
				$OWL=$mydata->value($row,41);
				$OWR=$mydata->value($row,42);
				$OLF=$mydata->value($row,43);
				$OLB=$mydata->value($row,44);
				$seal1=$mydata->value($row,51);
				$seal2=$mydata->value($row,52);
				$seal3=$mydata->value($row,53);
				$seal4=$mydata->value($row,54);
				$commodity=$mydata->value($row,55);
				$VatNvat=strtoupper($mydata->value($row,56));
				$row=$row+1;
				$container_no = preg_replace('/[^A-Za-z0-9\. -]/', '', $container_no);
				$container_no = trim($container_no);
				
				if($friedKind=="FCL" or $friedKind=="LCL")
					$friedKind = $friedKind;
				else
					$friedKind = "MTY";
				
				//$container_no = str_replace('\n','',$container_no);
				//echo "<br>".$mlo."-".$container_no."-".$boking_no."-".$iso."-".$size."-".$fpod."-".$seal1;
				$sql="select sparcsn4.inv_unit.gkey as rtnValue from sparcsn4.inv_unit
				where sparcsn4.inv_unit.id = '$container_no' order by sparcsn4.inv_unit.gkey desc limit 1";
				//echo "<br>".$sql;				
				$gkey=$this->bm->dataReturn($sql);				
				//echo "<br>".$gkey."-".$container_no;
				$sqlSize="select cont_size as rtnValue from igm_detail_container where cont_number='$container_no' limit 1";
				//echo "<br>".$sql;				
				$size=$this->bm->dataReturnDb1($sqlSize);
				
				$sqlHeight="select cont_height as rtnValue from igm_detail_container where cont_number='$container_no' limit 1";
				//echo "<br>".$sql;				
				$height=$this->bm->dataReturnDb1($sqlHeight);		
				
				
				$sqlTrans = "select sparcsn4.inv_unit_fcy_visit.transit_state,sparcsn4.inv_unit.category from sparcsn4.inv_unit 
				inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
				where sparcsn4.inv_unit.id='$container_no' order by sparcsn4.inv_unit_fcy_visit.gkey";
				$preTransList = $this->bm->dataSelect($sqlTrans);
				$trans = "";	
				$cat = "";				
				for($t=0;$t<count($preTransList);$t++) {
					$trans = $preTransList[$t][transit_state];
					$cat = $preTransList[$t][category];
				}
							
				$preVvdGky = "";
				$cnt = 0;
				if($cat=="EXPRT" and $trans=="S20_INBOUND")
				{
					$prevInboundCont++;
					$sqlPreVvdGky = "select vvd_gkey from ctmsmis.mis_exp_unit_preadv_req  where cont_id='$container_no'";
					$preVvdGkyList = $this->bm->dataSelect($sqlPreVvdGky);
					for($v=0;$v<count($preVvdGkyList);$v++) {
						$cnt=$cnt+1;
						$preVvdGky = $preVvdGkyList[$v][vvd_gkey];
					}
				}
				
				if($cnt==0)
				{
					//echo "inserted";
					$qryInsert = "replace into ctmsmis.mis_exp_unit_preadv_req(gkey,cont_id,cont_category,cont_status,cont_mlo,isoType,cont_size,cont_height,isoGroup,bookingNo,vvd_gkey,rotation,voys_no,agent,callSign,last_update,
					user_id,seal_no,seal_no2,seal_no3,seal_no4,goods_and_ctr_wt_kg,pod,fpod,modeTrans,transport,transOp,preAddStat,imoClass1,imoClass2,imoClass3,imoClass4,imoClass5,unNo1,unNo2,unNo3,unNo4,unNo5,imoName1,
					imoName2,imoName3,imoName4,imoName5,OLF,OLB,OWL,OWR,OH,tempUnit,minTemp,maxTemp,commodity_code) values($gkey,'$container_no','$category','$friedKind','$mlo','$iso','$size','$height','$iso_grp','$boking_no',$vvd_gkey,
					'$rot','$voys_no','$shipAgent','$callSign',now(),'$login_id','$seal1','$seal2','$seal3','$VatNvat','$weight','$pod','$fpod','$modeTrans','$transport','$transOperator',1,'$imoClass1','$imoClass2','$imoClass3',
					'$imoClass4','$imoClass5','$unNo1','$unNo2','$unNo3','$unNo4','$unNo5','$imoName1','$imoName2','$imoName3','$imoName4','$imoName5','$OLF','$OLB','$OWL','$OWR','$OH','$tempUnit','$minTemp','$maxTemp','$commodity')";
					//echo $qryInsert;
					$yes=$this->bm->dataInsert($qryInsert);
					//echo $yes;
					if($yes==0)
					{
						$strLog = $rot."|".$container_no."|".$mlo."|".$friedKind."|".$size."|".$height."|".$shipAgent."\n";
						write_file("preAddviseFail.txt", $strLog, 'a');
						$failStr = $failStr."<tr><td>".$rot."</td><td>".$container_no."</td><td>".$mlo."</td></tr>";
						$flst = $flst+1;
					}
					else
					{
						$sst = $sst+1;
					}
				}
				else
				{
					//echo "updated";
					$qryUpdate = "update ctmsmis.mis_exp_unit_preadv_req set gkey=$gkey,cont_id='$container_no',cont_category='$category',cont_status='$friedKind',cont_mlo='$mlo',isoType='$iso',cont_size='$size',cont_height='$height',
					isoGroup='$iso_grp',bookingNo='$boking_no',vvd_gkey=$vvd_gkey,rotation='$rot',voys_no='$voys_no',agent='$shipAgent',callSign='$callSign',last_update=now(),user_id='$login_id',seal_no='$seal1',seal_no2='$seal2',
					seal_no3='$seal3',seal_no4='$VatNvat',goods_and_ctr_wt_kg='$weight',pod='$pod',fpod='$fpod',modeTrans='$modeTrans',transport='$transport',transOp='$transOperator',preAddStat=1,imoClass1='$imoClass1',imoClass2='$imoClass2',
					imoClass3='$imoClass3',imoClass4='$imoClass4',imoClass5='$imoClass5',unNo1='$unNo1',unNo2='$unNo2',unNo3='$unNo3',unNo4='$unNo4',unNo5='$unNo5',imoName1='$imoName1',imoName2='$imoName2',imoName3='$imoName3',
					imoName4='$imoName4',imoName5='$imoName5',OLF='$OLF',OLB='$OLB',OWL='$OWL',OWR='$OWR',OH='$OH',tempUnit='$tempUnit',minTemp='$minTemp',maxTemp='$maxTemp',commodity_code='$commodity',updateStat=1
					where cont_id='$container_no' and vvd_gkey='$preVvdGky'";
					//echo $qryInsert;
					$yes=$this->bm->dataUpdate($qryUpdate);
					if($yes==0)
					{
						$strLog = $rot."|".$container_no."|".$mlo."|".$friedKind."|".$size."|".$height."|".$shipAgent."\n";
						write_file("preAddviseFail.txt", $strLog, 'a');
						$failStr = $failStr."<tr><td>".$rot."</td><td>".$container_no."</td><td>".$mlo."</td></tr>";
						$flst = $flst+1;
					}
					else
					{
						$sst = $sst+1;
					}
				}
				
			}
			$failStr = $failStr."<tr><td colspan='3'>Please check container(s) in N4</td></tr></table>";
			//echo "===".$i;
			$new = $i-$prevInboundCont;
			//return;
			if($sst>0)
			{
				if($flst>0)
					$data['msg'] = "Total container <a href='".site_url('uploadExcel/showDetailPrevCont/'.$vvd_gkey)."/all' target='_blank'>$i</a>,<br/>Newly Pre-Advised <a href='".site_url('uploadExcel/showDetailPrevCont/'.$vvd_gkey)."/new' target='_blank'>$new</a>,<br/>Pre-Advised with Vessel change <a href='".site_url('uploadExcel/showDetailPrevCont/'.$vvd_gkey)."/old' target='_blank'>$prevInboundCont</a><br/>".$failStr;
				else
					$data['msg'] = "Total container <a href='".site_url('uploadExcel/showDetailPrevCont/'.$vvd_gkey)."/all' target='_blank'>$i</a>,<br/>Newly Pre-Advised <a href='".site_url('uploadExcel/showDetailPrevCont/'.$vvd_gkey)."/new' target='_blank'>$new</a>,<br/>Pre-Advised with Vessel change <a href='".site_url('uploadExcel/showDetailPrevCont/'.$vvd_gkey)."/old' target='_blank'>$prevInboundCont</a>";
			}
			else{
			$data['msg'] = "PLEASE TRY AGAIN...";
			}
				
			$data['title']="UPLOAD EXCEL FILE FOR COPINO...";
			$this->load->view('header2');
			$this->load->view('excelUpload',$data);
			$this->load->view('footer');
			
		}
		
		function uploadCoparnForm()
		{
			$data['title']="UPLOAD EXCEL FILE FOR COPARN...";
			$this->load->view('header2');
			$this->load->view('uploadCoparnForm',$data);
			$this->load->view('footer');
			//$this->load->view('excelUpload');
        }
		
		function uploadCoparn()
		{
			$login_id = $this->session->userdata('login_id');
			$date = date('YmdHis');
			$dbDate = date('Y-m-d H:i:s');
			//echo $dbDate."<br>";
			error_reporting(E_ALL ^ E_NOTICE);   
    
			$filenm=$login_id."_".$date.".xls";
			$filetype=$_POST["file"];
			
			if ($_FILES["file"]["error"] > 0)
			{
			echo "Error: " . $_FILES["file"]["error"] . "<br />";
			return;
			}
			else
			{
			move_uploaded_file($_FILES["file"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadfile/".$_FILES["file"]["name"]);
			
			rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadfile/".$_FILES["file"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadfile/".$filenm);
			}
			//echo "Upload";
			// Load the spreadsheet reader library
			require_once('excel_reader2.php');
			$mydata = new Spreadsheet_Excel_Reader($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadfile/".$filenm);
			$shipAgent=$mydata->value(3,3);
			$callSign=$mydata->value(5,3);
			$voys_no=$mydata->value(6,3);
			$rot=$mydata->value(7,3);
			$expRot=$mydata->value(8,3);
			//echo "Main=".$shipAgent."-".$rot;
			$sqlrot="select sparcsn4.vsl_vessel_visit_details.vvd_gkey as rtnValue from sparcsn4.vsl_vessel_visit_details where sparcsn4.vsl_vessel_visit_details.ib_vyg='$rot'";
			//echo $sqlrot."<hr>";
			$vvd_gkey=$this->bm->dataReturn($sqlrot);
			//echo "<br>".$vvd_gkey;
			//return;
			
			mysql_query("delete from ctmsmis.mis_exp_unit_preadv_coparn where vvd_gkey=$vvd_gkey ");
			
			$totalrow=0;
			$excelrow=$mydata->rowcount(0);
			$i=13;

			while($i<=$excelrow)
			{
				if( $mydata->value($i,3)!="" )
				$totalrow=$totalrow+1;
				$i=$i+1;
			}
			//echo "<br>".$totalrow;
			//return;
			$row=13;   
			$prob = "<table border='1'><tr><td>MLO</td><td>Description</td></tr>";
			$st = 0;
			while($row<($totalrow+13))
			{
				$pod_chk=trim($mydata->value($row,10));
				$cont_quantity=$mydata->value($row,4);
				$cont_mlo=$mydata->value($row,2);
				$cont_boking_no=$mydata->value($row,3);
				$cont_iso=$mydata->value($row,6);
				$cont_category=$mydata->value($row,13);
				$cont_friedKind=$mydata->value($row,14);
				
				$strChkPOD="SELECT count(sparcsn4.ref_routing_point.id) as cnt  
				from sparcsn4.ref_routing_point 
				inner join sparcsn4.ref_unloc_code on sparcsn4.ref_unloc_code.gkey=sparcsn4.ref_routing_point.unloc_gkey
				where sparcsn4.ref_routing_point.id='$pod_chk' or sparcsn4.ref_unloc_code.id='$pod_chk'";
				//echo $strChkPOD."<br>";
				$resChkPOD = mysql_query($strChkPOD);
				$rowChkPOD = mysql_fetch_object($resChkPOD);
				
				$strBookingGky="select booking0_.gkey from inv_eq_base_order booking0_ where booking0_.sub_type='BOOK' and (booking0_.created is null or booking0_.created>'2010-09-20 00:00:00') and booking0_.complex_gkey=1 and (booking0_.nbr = '$cont_boking_no')";
				//echo $strBookingGky."<br>";
				$resBookingGky = mysql_query($strBookingGky);
				$rowBookingGky = mysql_fetch_object($resBookingGky);
				$brow = mysql_num_rows($resBookingGky);
				$bGky = $rowBookingGky->gkey;
				//echo $containerNo."-".$rowChkPOD->cnt."<hr>";
				//echo $bGky."<br>";
				$strBookingInfo="select booking0_.nbr, scopedbizu1_.id as mlo, carriervis2_.id as visit_id, carriervis2_.phase ,carriervis2_.cvcvd_gkey
				from inv_eq_base_order booking0_ 
				left outer join ref_bizunit_scoped scopedbizu1_ on booking0_.line_gkey=scopedbizu1_.gkey 
				left outer join argo_carrier_visit carriervis2_ on booking0_.vessel_visit_gkey=carriervis2_.gkey 
				left outer join ref_bizunit_scoped scopedbizu3_ on booking0_.agent_gkey=scopedbizu3_.gkey 
				left outer join ref_bizunit_scoped scopedbizu4_ on booking0_.shipper_gkey=scopedbizu4_.gkey 
				left outer join ref_routing_point routingpoi5_ on booking0_.pol_gkey=routingpoi5_.gkey 
				left outer join ref_bizunit_scoped scopedbizu6_ on booking0_.truck_co_gkey=scopedbizu6_.gkey 
				left outer join ref_routing_point routingpoi7_ on booking0_.pod1_gkey=routingpoi7_.gkey 
				left outer join ref_routing_point routingpoi8_ on booking0_.pod2_gkey=routingpoi8_.gkey 
				left outer join ref_routing_point routingpoi9_ on booking0_.pod_optional_gkey=routingpoi9_.gkey 
				where booking0_.sub_type='BOOK' and (booking0_.gkey='$bGky') order by booking0_.nbr ASC";
				//echo $strBookingInfo."<br>";
				$resBookingInfo = mysql_query($strBookingInfo);
				$rowBookingInfo = mysql_fetch_object($resBookingInfo);
				//echo "Booking==".$cont_boking_no."<br>";
				//echo "Prev Used==".$rowBookingInfo->cvcvd_gkey."<br>";
				//echo "Curr=".$vvd_gkey."<br>";
				//echo "<hr>";
				if($rowBookingInfo->phase=="50COMPLETE" or $rowBookingInfo->phase=="60DEPARTED" or $rowBookingInfo->phase=="70CLOSED")
				{
					$prob .= "<tr><td>".$cont_mlo."</td><td>Booking '".$cont_boking_no."' is old</td></tr>";
					$st = $st+1;
				}
				else if(($rowBookingInfo->phase=="30ARRIVED" or $rowBookingInfo->phase=="40WORKING" or $rowBookingInfo->phase=="20INBOUND") and ($rowBookingInfo->cvcvd_gkey!=$vvd_gkey))
				{
					$prob .= "<tr><td>".$cont_mlo."</td><td>Booking '".$cont_boking_no."' is already used for another vessel</td></tr>";
					$st = $st+1;
				}
				else if($rowChkPOD->cnt==0)
				{
					//if($row%3==0)
					//$cont .= $containerNo.", ";
					//else
					$prob .= "<tr><td>".$cont_mlo."</td><td><b>'".$pod_chk."'</b> Mismatch POD with CTMS system</td></tr>";
					$st = $st+1;
				}	
				else if($cont_mlo=="" or $cont_mlo==" ")
				{
					$prob .= "<tr><td></td><td>MLO should not be blank</td></tr>";
					$st = $st+1;
				}
				else if($cont_quantity=="" or $cont_quantity==" ")
				{
					$prob .= "<tr><td>".$cont_mlo."</td><td>Quantity should not be blank</td></tr>";
					$st = $st+1;
				}
				else if($pod_chk=="" or $pod_chk==" ")
				{
					$prob .= "<tr><td>".$cont_mlo."</td><td>POD should not be blank</td></tr>";
					$st = $st+1;
				}
				else if($cont_boking_no=="" or $cont_boking_no==" ")
				{
					$prob .= "<tr><td>".$cont_mlo."</td><td>Booking No. should not be blank</td></tr>";
					$st = $st+1;
				}
				else if($cont_iso=="" or $cont_iso==" ")
				{
					$prob .= "<tr><td>".$cont_mlo."</td><td>ISO Code should not be blank</td></tr>";
					$st = $st+1;
				}
				else if($cont_category=="" or $cont_category==" ")
				{
					$prob .= "<tr><td>".$cont_mlo."</td><td>Category should not be blank</td></tr>";
					$st = $st+1;
				}
				else if($cont_friedKind=="" or $cont_friedKind==" ")
				{
					$prob .= "<tr><td>".$cont_mlo."</td><td>Status(MTY/FCL) should not be blank</td></tr>";
					$st = $st+1;
				}
				else if($shipAgent=="" or $shipAgent==" ")
				{
					$prob .= "<tr><td></td><td>Shipping Agent should not be blank</td></tr>";
					$st = $st+1;
				}
				else if($callSign=="" or $callSign==" ")
				{
					$prob .= "<tr><td></td><td>Call Sign should not be blank</td></tr>";
					$st = $st+1;
				}
				else if($voys_no=="" or $voys_no==" ")
				{
					$prob .= "<tr><td></td><td>Voys No. should not be blank</td></tr>";
					$st = $st+1;
				}
				else if($rot=="" or $rot==" ")
				{
					$prob .= "<tr><td></td><td>Import rotation should not be blank</td></tr>";
					$st = $st+1;
				}
				else if($expRot=="" or $expRot==" ")
				{
					$prob .= "<tr><td></td><td>Export rotation should not be blank</td></tr>";
					$st = $st+1;
				}
				$row=$row+1; 
			}
			$prob .= "</table>";
			//echo $st;
			
			if($st>0)
			{
				$data['msg'] = "IN YOUR EXCEL FILE LISTED PROBLEM(S) FOUND<br>".$prob."<br> PLEASE CORRECT & TRY AGAIN...";
				$data['title']="UPLOAD EXCEL FILE FOR COPARN...";
				$this->load->view('header2');
				$this->load->view('uploadCoparnForm',$data);
				$this->load->view('footer');
				return;
			}
			else
			{
				$row = 13;
			}
   			
			$i=0;
			while($row<($totalrow+13))
			{
				$i++;
				//echo "<br>".$i;
				$mlo=$mydata->value($row,2);
				$container_no=$mydata->value($row,5);
				$boking_no=$mydata->value($row,3);
				$quantity=$mydata->value($row,4);
				$iso=$mydata->value($row,6);
				$size=$mydata->value($row,7);
				$height=$mydata->value($row,8);
				$iso_grp=$mydata->value($row,9);
				/*$modeTrans=$mydata->value($row,9);
				$transport=$mydata->value($row,10);
				$transOperator=$mydata->value($row,11);*/
				$pod=$mydata->value($row,10);
				$fpod=$mydata->value($row,11);
				$weight=$mydata->value($row,12);
				$category=$mydata->value($row,13);
				$friedKind=$mydata->value($row,14);
				$imoClass1=$mydata->value($row,17);
				$imoClass2=$mydata->value($row,18);
				$imoClass3=$mydata->value($row,19);
				$imoClass4=$mydata->value($row,20);
				$imoClass5=$mydata->value($row,21);
				$unNo1=$mydata->value($row,22);
				$unNo2=$mydata->value($row,23);
				$unNo3=$mydata->value($row,24);
				$unNo4=$mydata->value($row,25);
				$unNo5=$mydata->value($row,26);
				$imoName1=$mydata->value($row,27);
				$imoName2=$mydata->value($row,28);
				$imoName3=$mydata->value($row,29);
				$imoName4=$mydata->value($row,30);
				$imoName5=$mydata->value($row,31);
				$tempUnit=$mydata->value($row,33);
				$minTemp=$mydata->value($row,34);
				$maxTemp=$mydata->value($row,35);
				$OOG=$mydata->value($row,37);
				$OH=$mydata->value($row,38);
				$OWL=$mydata->value($row,39);
				$OWR=$mydata->value($row,40);
				$OLF=$mydata->value($row,41);
				$OLB=$mydata->value($row,42);
				$seal1=$mydata->value($row,48);
				$seal2=$mydata->value($row,49);
				$seal3=$mydata->value($row,50);
				$seal4=$mydata->value($row,51);
				$row=$row+1; 
				$size = preg_replace('/[^A-Za-z0-9\. -]/', '', $size);
				$height = preg_replace('/[^A-Za-z0-9\. -]/', '', $height);
				/*$container_no = trim($container_no);
				//$container_no = str_replace('\n','',$container_no);
				//echo "<br>".$mlo."-".$container_no."-".$boking_no."-".$iso."-".$size."-".$fpod."-".$seal1;
				$sql="select sparcsn4.inv_unit.gkey as rtnValue from sparcsn4.inv_unit
				where sparcsn4.inv_unit.id = '$container_no' order by sparcsn4.inv_unit.gkey desc limit 1";
				//echo "<br>".$sql;				
				$gkey=$this->bm->dataReturn($sql);				
				//echo "<br>".$gkey."-".$container_no;
				$sqlSize="select cont_size as rtnValue from igm_detail_container where cont_number='$container_no' order by id desc limit 1";
				//echo "<br>".$sql;				
				$size=$this->bm->dataReturnDb1($sqlSize);
				
				$sqlHeight="select cont_height as rtnValue from igm_detail_container where cont_number='$container_no' order by id desc limit 1";
				//echo "<br>".$sql;				
				$height=$this->bm->dataReturnDb1($sqlHeight);
				
				$sqlcheck = "select count(gkey) as rtnValue from ctmsmis.mis_exp_unit_preadv_req where gkey =$gkey";
				$cnt = $this->bm->dataReturn($sqlcheck);
				//echo "<br>CNT==".$cnt;
				//$yes= 0;
				
				$strChkStat="select count(id) as cnt from sparcsn4.inv_unit
				inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
				where sparcsn4.inv_unit.id='$container_no' and sparcsn4.inv_unit.visit_state='1ACTIVE' and sparcsn4.inv_unit_fcy_visit.transit_state='S20_INBOUND'";
				//echo $strChkStat."<br>";
				$resChkStat = mysql_query($strChkStat);
				$rowChkStat = mysql_fetch_object($resChkStat);
				//echo "<br>CNT==".$cnt."pre==".$rowChkStat->cnt;
				if($cnt==0 and $rowChkStat->cnt==0)
				{*/
					$qryInsert = "insert into ctmsmis.mis_exp_unit_preadv_coparn(quantity,cont_id,cont_category,cont_status,cont_mlo,isoType,cont_size,cont_height,isoGroup,bookingNo,vvd_gkey,rotation,voys_no,agent,callSign,last_update,
					user_id,seal_no,seal_no2,seal_no3,seal_no4,goods_and_ctr_wt_kg,pod,fpod,imoClass1,imoClass2,imoClass3,imoClass4,imoClass5,unNo1,unNo2,unNo3,unNo4,unNo5,imoName1,
					imoName2,imoName3,imoName4,imoName5,OLF,OLB,OWL,OWR,OH,tempUnit,minTemp,maxTemp) values($quantity,'$container_no','$category','$friedKind','$mlo','$iso','$size','$height','$iso_grp','$boking_no',$vvd_gkey,
					'$rot','$voys_no','$shipAgent','$callSign',now(),'$login_id','$seal1','$seal2','$seal3','$seal4','$weight','$pod','$fpod','$imoClass1','$imoClass2','$imoClass3',
					'$imoClass4','$imoClass5','$unNo1','$unNo2','$unNo3','$unNo4','$unNo5','$imoName1','$imoName2','$imoName3','$imoName4','$imoName5','$OLF','$OLB','$OWL','$OWR','$OH','$tempUnit','$minTemp','$maxTemp')";
					//echo $qryInsert."<hr>";
					$yes=$this->bm->dataInsert($qryInsert);
					//echo $yes;
					//if($yes==0)
					//echo $qryInsert." - No -<hr>";
				//}
				
			}
			//return;
			if($yes>0)
			$data['msg'] = "DATA SUCCESSFULLY UPLOADED...";
			else
			$data['msg'] = "PLEASE TRY AGAIN...";
				
			$data['title']="UPLOAD EXCEL FILE FOR COPARN...";
			$this->load->view('header2');
			$this->load->view('uploadCoparnForm',$data);
			$this->load->view('footer');
		}
		
		function convertCoparn(){
			//print_r($this->session->all_userdata());
			
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="CONVERT COPARN...";
				$data['mystatus']="1";
				$this->load->view('header2');
				$this->load->view('myConvertCoparnForm',$data);
				$this->load->view('footer');
			}	
        }
		
		function convertCoparnPerformed()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$this->load->view('myConvertCoparnPerformed',$data);
			}
		}
		
		function convertCopino(){
			//print_r($this->session->all_userdata());
			
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="CONVERT COPINO...";
				$data['mystatus']="1";
				$this->load->view('header2');
				$this->load->view('myConvertCopinoForm',$data);
				$this->load->view('footer');
			}	
        }
		
		function convertCopinoPerformed()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$this->load->view('myConvertCopinoPerformed',$data);
			}
		}
		
		function preAdvisedRotList()
		{
			$session_id = $this->session->userdata('value');
			$login_id = $this->session->userdata('login_id');
			/*if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{*/
				$data['title']="TODAY'S PRE-ADVISED ROTATION LIST...";
				$data['mystatus']="1";
				$data['login_id']=$login_id;
				$this->load->view('header2');
				$this->load->view('preAdvisedRotListHTML',$data);
				$this->load->view('footer');
			//}
		}
		
		function updateSNXStatus()
		{
			$login_id = $this->session->userdata('login_id');
			$vvdGkey = $this->uri->segment(3);
			$strUpdate = "update ctmsmis.mis_exp_unit_preadv_req set preAddStat=2,snx_uploaded_by='$login_id' where vvd_gkey=$vvdGkey and preAddStat=1";
			//echo $strUpdate;
			$this->bm->dataUpdate($strUpdate);
			
			$data['title']="TODAY'S PRE-ADVISED ROTATION LIST...";
			$data['mystatus']="1";
			$this->load->view('header2');
			$this->load->view('preAdvisedRotListHTML',$data);
			$this->load->view('footer');
		}
		
		function showDetailPrevCont()
		{
			$vvdGkey = $this->uri->segment(3);
			$opt = $this->uri->segment(4);
			$sql = "";
			$title = "";
			if($opt=="new")
			{
				$title  = "Newly Pre-Advised Container List";
				$sql = "select vvd_gkey,rotation,agent,cont_id,cont_mlo,isoType,cont_size,cont_height,transOp
				from ctmsmis.mis_exp_unit_preadv_req where preAddStat=1 and date(last_update)=date(now()) and vvd_gkey=$vvdGkey and updateStat=0";
			}
			else if($opt=="old")
			{
				$title  = "Pre-Advised Container List with vessel change";
				$sql = "select vvd_gkey,rotation,agent,cont_id,cont_mlo,isoType,cont_size,cont_height,transOp
				from ctmsmis.mis_exp_unit_preadv_req where preAddStat=1 and date(last_update)=date(now()) and vvd_gkey=$vvdGkey and updateStat=1";
			}
			else
			{
				$title  = "Updated Pre-Advised Container List";
				$sql = "select vvd_gkey,rotation,agent,cont_id,cont_mlo,isoType,cont_size,cont_height,transOp
				from ctmsmis.mis_exp_unit_preadv_req where preAddStat=1 and date(last_update)=date(now()) and vvd_gkey=$vvdGkey";
			}
			
			$preAddContList = $this->bm->dataSelect($sql);
			$data['preAddContList']=$preAddContList;
			$data['title']=$title;
			$this->load->view('preAdvisedContListHTML',$data);			
		}
		
		function showConverted()
		{
			$vvdGkey = $this->uri->segment(3);
			$sql = "";
			$title = "To be converted container list";		
			$data['vvdGkey']=$vvdGkey;
			$data['title']=$title;
			$this->load->view('myConvertedContListHTML',$data);			
		}
		
		function showNoConverted()
		{
			$vvdGkey = $this->uri->segment(3);
			$sql = "";
			$title = "Not converted container list";		
			$data['vvdGkey']=$vvdGkey;
			$data['title']=$title;
			$this->load->view('myNoConvertedContListHTML',$data);			
		}
		
		function logout(){
		
			$query="SELECT sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.vsl_vessel_visit_details.ob_vyg,
			LEFT(sparcsn4.argo_carrier_visit.phase,2) AS phase_num,SUBSTR(sparcsn4.argo_carrier_visit.phase,3) AS phase_str,sparcsn4.argo_visit_details.eta,
			sparcsn4.argo_visit_details.etd,sparcsn4.argo_carrier_visit.ata,
			sparcsn4.argo_carrier_visit.atd,sparcsn4.ref_bizunit_scoped.id AS agent,sparcsn4.argo_quay.id AS berth,
			IFNULL(sparcsn4.vsl_vessel_visit_details.flex_string02,sparcsn4.vsl_vessel_visit_details.flex_string03) AS berthop
			FROM sparcsn4.argo_carrier_visit
			INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
			INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
			INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
			INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey
			LEFT JOIN sparcsn4.vsl_vessel_berthings ON sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
			LEFT JOIN sparcsn4.argo_quay ON sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
			WHERE sparcsn4.argo_carrier_visit.phase IN ('20INBOUND','30ARRIVED','40WORKING','50COMPLETE','60DEPARTED')
			ORDER BY sparcsn4.argo_carrier_visit.phase";
			//echo $data['voysNo'];
			$rtnVesselList = $this->bm->dataSelect($query);
			$data['rtnVesselList']=$rtnVesselList;
          
			$data['body']="<font color='blue' size=2>LogOut Successfully....</font>";

			$this->session->sess_destroy();
			$this->cache->clean();
			//redirect(base_url(),$data);
			$this->load->view('header');
			$this->load->view('welcomeview_1', $data);
			$this->load->view('footer');
			$this->db->cache_delete_all();
        }
		
		function remove_numbers($string) 
		{
			$spchar = array("\n","&",'"',"'","/",">","<","^","  ","~");
			$string = str_replace($spchar, '', $string);				
			//$string=substr($string, 0, 80);
			return $string;
		}

		// SOURAV

		function blockWiseEquipmentList()
		{
			$session_id = $this->session->userdata('value');
			$login_id = $this->session->userdata('login_id');
			$type_of_Igm = $this->uri->segment(3);
			$search=$this->input->post('search');
			$this->load->model('ci_auth', 'bm', TRUE);
				
				$sql="select count(sparcsn4.xps_che.short_name) as rtnValue
						from sparcsn4.xps_che
						inner join sparcsn4.xps_chezone on sparcsn4.xps_chezone.che_id=sparcsn4.xps_che.id
						where short_name is not null and short_name!='' and short_name not like 'HHT%' and short_name not like 'F%'
						and short_name not like 'SP%' and login_name!=''
						order by 1 ";
				$config = array();
				$config["base_url"] = site_url("uploadExcel/blockWiseEquipmentList/$type_of_Igm");
				$config["total_rows"] = $this->bm->dataReturn($sql);
				$config["per_page"] = 20;
				$offset = $this->uri->segment(4, 0);
				$config["uri_segment"] = 4;
				$limit=$config["per_page"];
			
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
				$start=$page;
				/***********Pagination***************/
				if($this->input->post()){
					$search=$this->input->post('search');
					$sql_data="Select distinct  sel_block Block,short_name equipement 
								from sparcsn4.xps_che
								inner join sparcsn4.xps_chezone on sparcsn4.xps_chezone.che_id=sparcsn4.xps_che.id  
								inner join ctmsmis.yard_block on ctmsmis.yard_block.block=sel_block
								where short_name = '$search' and login_name!='' order by 1";
				}
				else{
					$sql_data="select *,if(yard='GCB',1,2) as sl
								from (
								select distinct  sel_block Block,short_name equipement,
								(select ctmsmis.yard_block.terminal from ctmsmis.yard_block where ctmsmis.yard_block.block=sel_block) as yard 
								from sparcsn4.xps_che
								inner join sparcsn4.xps_chezone on sparcsn4.xps_chezone.che_id=sparcsn4.xps_che.id
								where short_name is not null and short_name!='' and short_name not like 'HHT%' and short_name not like 'F%'
								and short_name not like 'SP%' and login_name!=''
								union all
								select distinct  sel_block Block,short_name equipement,
								(select ctmsmis.yard_block.terminal from ctmsmis.yard_block where ctmsmis.yard_block.block=sel_block) as yard 
								from sparcsn4.xps_che
								inner join sparcsn4.xps_chezone on sparcsn4.xps_chezone.che_id=sparcsn4.xps_che.id
								where short_name is not null and short_name!='' and short_name like 'FLT%'
								) as tbl where yard is not null order by sl limit $start,$limit";
				}	
							
				//echo("<script>console.log('QueryController: ".$sql_data."');</script>");		
				
				
				$equipmentList = $this->bm->dataSelect($sql_data);
				
				
				//$strChkStartId='0';
				//$strChkStartId = "select count(id) as rtnValue from ctmsmis.mis_equip_assign_detail where DATE(start_work_time)=DATE(NOW()) and start_state='1' and end_state='0'";
				//$chkStrt=$this->bm->dataReturn($strChkStartId);
				
				$data['equipmentList']=$equipmentList;    
				$data['title']="Equipment List...";
				//$data['startChk']=$this->bm->dataReturn($strChkStartId);;
				$data['msg']="<a href='".site_url('report/containerHandlingView')."' target='_blank'>Yardwise Equipment Booking Report Today</a>";
				//$data['msg']="";
				$data['start']=$start;
				$data["links"] = $this->pagination->create_links();
				$data['login_id']=$login_id;
				$this->load->view('header2');
				$this->load->view('EquipmentListRpt',$data);
				$this->load->view('footer');
			//}
		}
		
		function equipmentBookingPerform()
		{
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			$login_id = $this->session->userdata('login_id');
			
			$block=$this->input->post('type');
			
			$equipment=$this->input->post('myval');
			
			$this->load->model('ci_auth', 'bm', TRUE);
				
			
			$strEqId = "select id as rtnValue from ctmsmis.mis_equip_detail where equipment='$equipment'";
			$eqiId=$this->bm->dataReturn($strEqId);
			
			$strInsertEq = "insert into ctmsmis.mis_equip_booking(equip_detail_id,block,booking_date,booking_by,ip_address) values('$eqiId','$block',now(),'$login_id','$ipaddr')";
			
			$stat = $this->bm->dataUpdate($strInsertEq);
			$data['msg']="";
			if($stat==1)
				$data['msg']="Booking successfully completed for the equipment ".$equipment." <a href='".site_url('report/dateWiseEqipAssignReport')."' target='_blank'>Block Wise Equipment Booking Lists for today</a>";
			else
				$data['msg']="Not booked yet.";
			
			$sql_data="select distinct equipment equipement from ctmsmis.mis_equip_detail
								   where equipment like 'RTG%' or equipment like 'SC%' or equipment like 'RST%' order by 1";
			$equipmentList = $this->bm->dataSelect($sql_data);
			$data['equipmentList']=$equipmentList;   
			$data['title']="Update Equipment List...";
			$this->load->view('header2');
			$this->load->view('equipmentDemandListHTML',$data);
			$this->load->view('footer');
			
		}
		
		function updateEquipmentList()
		{
			$session_id = $this->session->userdata('value');
			$login_id = $this->session->userdata('login_id');
			$type_of_Igm = $this->uri->segment(3);
			$search=$this->input->post('search');
			//echo $type_of_Igm;
			$this->load->model('ci_auth', 'bm', TRUE);
			if($this->input->post()){
				$search=$this->input->post('search');
				$sql_data="select distinct equipment equipement from ctmsmis.mis_equip_detail
							where equipment='$search'";
			}
			else{
				$sql_data="select distinct equipment equipement from ctmsmis.mis_equip_detail
							   where equipment like 'RTG%' or equipment like 'SC%' or equipment like 'RST%' or equipment like 'RMG%' or equipment like 'FLT%' order by 1";
				
			}	
							
			//echo("<script>console.log('QueryController: ".$sql_data."');</script>");		
			
			$equipmentList = $this->bm->dataSelect($sql_data);
			$data['equipmentList']=$equipmentList;    
			$data['title']="Update Equipment List...";
			$data['msg']="";
			$data['type']=$type_of_Igm;
			$data['start']=$start;
			$data['mystatus']="1";
			$data['login_id']=$login_id;
			$this->load->view('header2');
			$this->load->view('updateEquipmentInformationHTML',$data);
			$this->load->view('footer');
			//}
		}
		
		function updateEquipmentPerform()
		{
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			$login_id = $this->session->userdata('login_id');
			$myval=$this->input->post('myval');
			$descValue=$this->input->post('descValue');
			$capacity=$this->input->post('capacity');
			//echo $descValue." ".$capacity;
			$strupdate = "replace into ctmsmis.mis_equip_detail(equipment,description,capacity,last_update,update_by,ip_address) values('$myval','$descValue','$capacity',now(),'$login_id','$ipaddr')";
			$stat = $this->bm->dataUpdate($strupdate);
			$data['msg']="";
			if($stat==1)
				$data['msg']="Data successfully updated for the equipment ".$myval;
			else
				$data['msg']="Data not updated";
			
			$sql_data="select distinct equipment equipement from ctmsmis.mis_equip_detail
								   where equipment like 'RTG%' or equipment like 'SC%' or equipment like 'RST%' order by 1";

					
			$equipmentList = $this->bm->dataSelect($sql_data);
			$data['equipmentList']=$equipmentList;    
			$data['title']="Update Equipment List...";
			$this->load->view('header2');
			$this->load->view('updateEquipmentInformationHTML',$data);
			$this->load->view('footer');
		}
		function equipmentStartWorkoutPerform()
		{	
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			$login_id = $this->session->userdata('login_id');
			
			$block=$this->input->post('block');
			
			$equipment=$this->input->post('equipment');
			
			$this->load->model('ci_auth', 'bm', TRUE);
			$data['msg']='';
			// For Pagination***************/
			$sql="select count(sparcsn4.xps_che.short_name) as rtnValue
			from sparcsn4.xps_che
			inner join sparcsn4.xps_chezone on sparcsn4.xps_chezone.che_id=sparcsn4.xps_che.id
			order by 1 ";
			
			$config = array();
			$config["base_url"] = site_url("uploadExcel/blockWiseEquipmentList/$type_of_Igm");
			$config["total_rows"] = $this->bm->dataReturn($sql);
			$config["per_page"] = 20;
			$offset = $this->uri->segment(4, 0);
			$config["uri_segment"] = 4;
			$limit=$config["per_page"];
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$start=$page;
			
			// get Equipment ID from Equipment Name...........
			$strEqId = "select id as rtnValue from ctmsmis.mis_equip_detail where equipment='$equipment'";
			$eqiId=$this->bm->dataReturn($strEqId);
			if($eqiId==0)
			{
				$strInsert = "insert into ctmsmis.mis_equip_detail (equipment) values('$equipment')";
				$statInsert = $this->bm->dataUpdate($strInsert);
				
				$strEqId = "select id as rtnValue from ctmsmis.mis_equip_detail where equipment='$equipment'";
				$eqiId=$this->bm->dataReturn($strEqId);
			}
			// get Block Name from Equipment ID..............
			$strBlockName = "select block as rtnValue from ctmsmis.mis_equip_assign_detail where equip_detail_id='$eqiId' and Date(start_work_time)=DATE(NOW()) and start_state='1'";
			$blockName=$this->bm->dataReturn($strBlockName);
			
			// Count ID from Assign Detail for insert and update............
				$strChkStartId='0';
				$strChkStartId = "select count(id) as rtnValue from ctmsmis.mis_equip_assign_detail where 
									equip_detail_id='$eqiId' and block='$blockName' and Date(start_work_time)=DATE(NOW()) and start_state='1'";
			
			$formSubmitWorkout = $this->input->post('workout');
			$formSubmitStart = $this->input->post('start');
			$formSubmitEnd = $this->input->post('end');
			
			//echo 'Work Out Button Clicked....'.$formSubmitWorkout;
			//echo 'Start Button Clicked....'.$formSubmitStart;
			//echo 'End Button Clicked....'.$formSubmitEnd;
			
			if( $formSubmitWorkout == 'Work Out' )//If Workout Button Clicked .........									
				{
					$id=$this->input->post('detailID');
				
					$strUpdateEq="update ctmsmis.mis_equip_assign_detail
								SET work_out_state='1',work_out_time=now()
								where id='$id'";
					$stat = $this->bm->dataUpdate($strUpdateEq);
					if($stat==1)
						$data['msg']="Work Out for the equipment ".$equipment;
					else
						$data['msg']="Not WorkOut yet.";		
				}
			else if($formSubmitStart=='Start')
			{
				// If Start Button Clicked .............
				    $jval=$this->input->post('jval');
				    $shift=$this->input->post('shift'.$jval);
					//echo "ShiftName".$shift;
					
					$strInsertEq = "insert into ctmsmis.mis_equip_assign_detail (equip_detail_id,block,start_state,start_work_time,shift,assign_by,ip_address)
								values('$eqiId','$block',1,now(),'$shift','$login_id','$ipaddr')";
				
					$stat = $this->bm->dataUpdate($strInsertEq);
					
					if($stat==1)
						$data['msg']="Started successfully for the equipment ".$equipment;
					else
						$data['msg']="Not started yet.";				
			}
			else if($formSubmitEnd=='End')
			{  //If End Button Clicked .........	
						$id=$this->input->post('detailID');
					
					$strUpdateEq="update ctmsmis.mis_equip_assign_detail
								SET end_state='1',end_work_time=now()
								where id='$id'";
					$stat = $this->bm->dataUpdate($strUpdateEq);
					if($stat==1)
						$data['msg']="Ended Period for the equipment ".$equipment;
					else
						$data['msg']="Not started yet.";
				
			}
			else{
				
			}
			
			$sql_data="select distinct  sel_block Block,short_name equipement from sparcsn4.xps_che
			inner join sparcsn4.xps_chezone on sparcsn4.xps_chezone.che_id=sparcsn4.xps_che.id
			where short_name is not null and short_name!='' and short_name not like 'HHT%' and short_name not like 'F%'
			and short_name not like 'SP%'
			order by 1 limit $start,$limit";
			
			$equipmentList = $this->bm->dataSelect($sql_data);
			
			$data['equipmentList']=$equipmentList;    
			$data['title']="Equipment List...";
			$data['startChk']=$this->bm->dataReturn($strChkStartId);
			$data['start']=$start;
			$data["links"] = $this->pagination->create_links();
			$data['login_id']=$login_id;
			$this->load->view('header2');
			$this->load->view('EquipmentListRpt',$data);
			$this->load->view('footer');
			
		}
		
		function equipmentDemandList()
		{
			$session_id = $this->session->userdata('value');
			$login_id = $this->session->userdata('login_id');
			$type_of_Igm = $this->uri->segment(3);
			$search=$this->input->post('search');
			//echo $type_of_Igm;
			$this->load->model('ci_auth', 'bm', TRUE);
				if($this->input->post()){
					$search=$this->input->post('search');
					
					$sql_data="select distinct equipment equipement from ctmsmis.mis_equip_detail
								where equipment='$search'";
				}
				else{
					
						$sql_data="select distinct equipment equipement from ctmsmis.mis_equip_detail
								   where equipment like 'RTG%' or equipment like 'SC%' or equipment like 'RST%' or equipment like 'RMG%' or  equipment like 'FLT%' order by 1";
				}	
							
				//echo("<script>console.log('QueryController: ".$sql_data."');</script>");		
				
				$equipmentList = $this->bm->dataSelect($sql_data);
				$data['equipmentList']=$equipmentList;    
				$data['title']="Equipment Demand List...";
				$data['msg']="";
				$data['type']=$type_of_Igm;
				$data['start']=$start;
				$data['mystatus']="1";
				$data['login_id']=$login_id;
				$this->load->view('header2');
				$this->load->view('equipmentDemandListHTML',$data);
				$this->load->view('footer');
		}
		function updateEquipmentDemandList()
		{
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			$login_id = $this->session->userdata('login_id');
			$myval=$this->input->post('myval');
			
			$terminal=$this->input->post('terminalList');
			$block=$this->input->post('type');
			
			//echo("<script>console.log('Terminal: ".$terminal."Block: ".$block."');</script>");
			echo "Terminal : ".$terminal."Block ".$block."Value ".$myval;
			/*
			$strupdate = "replace into ctmsmis.mis_equip_detail(equipment,description,capacity,last_update,update_by,ip_address) values('$myval','$descValue','$capacity',now(),'$login_id','$ipaddr')";
			$stat = $this->bm->dataUpdate($strupdate);
			$data['msg']="";
			if($stat==1)
				$data['msg']="Data successfully updated for the equipment ".$myval;
			else
				$data['msg']="Data not updated";*/ 
						
			$sql_data="select distinct equipment equipement from ctmsmis.mis_equip_detail
								   where equipment like 'RTG%' or equipment like 'SC%' or equipment like 'RST%' order by 1";
			$equipmentList = $this->bm->dataSelect($sql_data);
			$data['equipmentList']=$equipmentList;   
			$data['title']="Update Equipment List...";
			$this->load->view('header2');
			$this->load->view('equipmentDemandListHTML',$data);
			$this->load->view('footer');
		}
		
	function pangoanContUpload()
	{
		$data['title']="UPLOAD EXCEL FILE FOR PANGOAN...";
		$this->load->view('header2');
		$this->load->view('pangoanContUploadForm',$data);
		$this->load->view('footer');
		//$this->load->view('excelUpload');
    }
		
	function pangoanContUploadPerform()
	{
		$login_id = $this->session->userdata('login_id');
		$ipaddr = $_SERVER['REMOTE_ADDR'];
		$date = date('YmdHis');
		$dbDate = date('Y-m-d H:i:s');
		//echo $dbDate."<br>";
		error_reporting(E_ALL ^ E_NOTICE);   
    
		$filenm=$login_id."_".$date.".xls";
		$filetype=$_POST["file"];
			
		if ($_FILES["file"]["error"] > 0)
		{
			$data['msg'] = "<b>Error: " . $_FILES["file"]["error"] . "<br />May be your file size exceeds 2MB.Please reduce file size and try again.<br/>To reduce file size-<br/>
			Step1:Save your Excel file into CSV(.csv) format.<br/>
			Step2:Now save your CSV file into Excel(.xls) format.<br/>
			Step3:Upload new Excel(.xls) file again.</b>";
			$data['title']="UPLOAD EXCEL FILE FOR PANGOAN...";
			$this->load->view('header2');
			$this->load->view('pangoanContUploadForm',$data);
			$this->load->view('footer');
			return;			
		}
		else
		{
			move_uploaded_file($_FILES["file"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/pangoan/uploadfile/".$_FILES["file"]["name"]);			
			rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/pangoan/uploadfile/".$_FILES["file"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/pangoan/uploadfile/".$filenm);
		}
		require_once('excel_reader2.php');
		$mydata = new Spreadsheet_Excel_Reader($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/pangoan/uploadfile/".$filenm);
			
		$totalrow=0;
		$excelrow=$mydata->rowcount(0);
		$i=2;
		while($i<=$excelrow)
		{
			if( trim($mydata->value($i,3))!="")
			$totalrow=$totalrow+1;
			$i=$i+1;
		}
		$row=2;  
		$i=0;
		$stat = 0;
		while($row<($totalrow+2))
		{
			$i++;
			$mlo=$mydata->value($row,2);
			$cont_no=$mydata->value($row,3);
			$visit=$mydata->value($row,7);
			$weight=$mydata->value($row,8);
			$category=$mydata->value($row,9);
			$status=$mydata->value($row,10);
			$seal=$mydata->value($row,11);	
				
			$cont_no = preg_replace('/[^A-Za-z0-9\. -]/', '', $cont_no);
			$cont_no = trim($cont_no);
				
			$sqlIso="select sparcsn4.ref_equip_type.id as rtnValue from sparcsn4.inv_unit
				inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
				inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
				inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
				where sparcsn4.inv_unit.id='$cont_no' limit 1";			
			$isoCode=$this->bm->dataReturn($sqlIso);
			//echo $mlo."-".$cont_no."-".$visit."-".$weight."-".$category."-".$isoCode."<br>";
			$strQuery = "replace into ctmsmis.mis_pangoan_unit(cont_id,mlo,iso_code,visit_id,gross_weight,category,fried_kind,seal,last_update,user_id,ip_address) 
			values('$cont_no','$mlo','$isoCode','$visit','$weight','$category','$status','$seal',now(),'$login_id','$ipaddr')";
			$yes=$this->bm->dataInsert($strQuery);
			if($yes==1)
				$stat = $stat+1;					
			else
				$stat = $stat;									
				
			$row=$row+1; 
		}
		if($stat>0)
			$data['msg'] ="Data successfully uploaded.";
		else
			$data['msg'] ="Data not uploaded.";	
				
		$data['title']="UPLOAD EXCEL FILE FOR PANGOAN...";
		$this->load->view('header2');
		$this->load->view('pangoanContUploadForm',$data);
		$this->load->view('footer');
	}
		
	function convertPanContForm()
	{
		$data['title']="PANGOAN CONTAINERS CONVERTING FORM...";
		$data['mystatus']="1";
		$this->load->view('header2');
		$this->load->view('convertPanContForm',$data);
		$this->load->view('footer');
    }
		
	function convertPandContPerformed()
	{			
		$this->load->view('convertPanContPerform',$data);
	}
		
	function uploadCnFSignatureForm()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['msg']="";
			//$data['unstuff_flag']="";
			//$data['verify_number']="-1";
			$data['title']="UPLOAD C&f SIGNATURE SECTION...";
			$this->load->view('header5');
			$this->load->view('uploadCnFSignatureForm',$data);
			$this->load->view('footer_1');
		}	
	}
	
	function cnfSignatureUpload()
	{
		$cnfLicense= $this->input->post('license_no'); // Get Cnf License
			
		$filenmPrefix= str_replace("/","_","$cnfLicense"); // Replace '/' to '_'
			
		$filenm=$filenmPrefix."_".basename($_FILES["file"]["name"]); // Create Signature File Name 
		$targetFile= $_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/CnfSignature/".$filenm; // Target Folder where Signature file uploaded 
		$uploadOk = 1;
		$imgFileType = pathinfo($targetFile,PATHINFO_EXTENSION); // Get file extension
		
		$filetype=$_POST["file"];
		// Check if file already exists
		if (file_exists($targetFile)) 
		{
			$errMsg = "file already exists.";
			rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/CnfSignature/".$_FILES["file"]["name"],$targetFile);
			$uploadOk = 2;
		}
		// Check file size
		if ($_FILES["file"]["size"] > 500000) 
		{
			$errMsg = "file is too large.";
			$uploadOk = 0;
		}
		//echo "\n".$imgFileType;	
		// Allow certain file formats
		if($imgFileType != "png" && $imgFileType != "jpeg" && $imgFileType !="jpg" && $imgFileType != "gif") 
		{
			$errMsg= "only image files are allowed here.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) 
		{
			$Msg = "<font color='red'><b>Sorry, your file was not uploaded. Cause ".$errMsg."</b></font>";
		}
		else if ($uploadOk == 2) 
		{ // if File Edited then try to reload file
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) 
			{
				$Msg= "<font color='green'><b>The file ". basename( $_FILES["file"]["name"]). " has been uploaded."."</b></font>";
			} 
			else 
			{
				$Msg = "<font color='red'><b>Sorry, there was an error uploading your file."."</b></font>";
			}
		}
		// if everything is ok, try to upload file & Insert Into dataBase
		else
		{
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) 
			{
				$strChk="select COUNT(id) as id from cnf_signature_data where cnf_license_no='$cnfLicense'";
				$chkData = $this->bm->dataSelectDb1($strChk);
				$chkVal=$chkData[0]['id'];
				if($chkVal>0)
				{
					$strInsertEq = "update cnf_signature_data set signature_path = '$filenm' where cnf_license_no='$cnfLicense'";
					$stat = $this->bm->dataInsertDB1($strInsertEq);
									
					if($stat==1)
						$Msg = "<font color='green'><b>The file ". basename( $_FILES["file"]["name"]). " has been uploaded."."</b></font>";
					else
						$Msg= "<font color='red'><b>Signature File not inserted.Please Check."."</b></font>";
				}
				else
				{
					$strInsertEq = "insert into cnf_signature_data (cnf_license_no,signature_path)
								values('$cnfLicense','$filenm')";
					$stat = $this->bm->dataInsertDB1($strInsertEq);
									
					if($stat==1)
						$Msg = "<font color='green'><b>The file ". basename( $_FILES["file"]["name"]). " has been uploaded."."</b></font>";
					else
						$Msg= "<font color='red'><b>Signature File not inserted.Please Check."."</b></font>";
				}
			} 
			else 
			{
				$Msg = "<font color='red'><b>Sorry, there was an error uploading your file."."</b></font>";
			}
		}
		//echo "Message : ".$Msg;
		$data['msg']=$Msg;
		//$data['unstuff_flag']="";
		//$data['verify_number']="-1";
		$data['title']="UPLOAD C&f SIGNATURE SECTION...";
		$this->load->view('header5');
		$this->load->view('uploadCnFSignatureForm',$data);
		$this->load->view('footer_1');
	}
		
	//-------------Export Excel Upload start---------------
	function exportExcelUpload()
	{
		$data['title']="UPLOAD EXCEL FILE...";
		$this->load->view('header2');
		$this->load->view('myExportExcelUploadForm',$data);
		$this->load->view('footer');
	}
		
	function exportExcelUploadPerform()
	{
		$login_id = $this->session->userdata('login_id');
		$ipaddr = $_SERVER['REMOTE_ADDR'];
		$date = date('YmdHis');
		$dbDate = date('Y-m-d H:i:s');
		
		error_reporting(E_ALL ^ E_NOTICE);   
    
		$filenm=$login_id."_".$date.".xls";
		$filetype=$_POST["file"];
			
		if ($_FILES["file"]["error"] > 0)
		{
			$data['msg'] = "<b>Error: " . $_FILES["file"]["error"] . "<br />May be your file size exceeds 2MB.Please reduce file size and try again.<br/>To reduce file size-<br/>
			Step1:Save your Excel file into CSV(.csv) format.<br/>
			Step2:Now save your CSV file into Excel(.xls) format.<br/>
			Step3:Upload new Excel(.xls) file again.</b>";
			$data['title']="UPLOAD EXCEL FILE...";
			$this->load->view('header2');
			$this->load->view('myExportExcelUploadForm',$data);
			$this->load->view('footer');
			return;			
		}
		else
		{
			move_uploaded_file($_FILES["file"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/export/uploadfile/".$_FILES["file"]["name"]);			
			rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/export/uploadfile/".$_FILES["file"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/export/uploadfile/".$filenm);
		}
			
		require_once('excel_reader2.php');
		$mydata = new Spreadsheet_Excel_Reader($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/export/uploadfile/".$filenm);
			
		$rotation=$mydata->value(1,6);
		$str_vvd_gkey="SELECT vvd_gkey AS rtnValue FROM sparcsn4.vsl_vessel_visit_details WHERE ib_vyg='$rotation'";
			
		$vvd_gkey=$this->bm->dataReturn($str_vvd_gkey);   //dataReturn for DB2
		
		if($vvd_gkey==null)
		{
			$data['msg']="Rotation ".$rotation." is not valid. Please provide correct rotation.";
			$data['title']="UPLOAD EXCEL FILE...";
			$this->load->view('header2');
			$this->load->view('myExportExcelUploadForm',$data);
			$this->load->view('footer');
			return;
		}
		
		$totalrow=0;
		$excelrow=$mydata->rowcount(0);
		$i=3;
			
		while($i<=$excelrow)   //row count
		{
			if(trim($mydata->value($i,2))!="")  //3
			$totalrow=$totalrow+1;
			$i=$i+1;
		}
		
		//Validation start
		$row=3;
		$stat=0;
		$count_stowage=0;
	
		$table = "<table border='1'><tr><th>Field</th><th>Description</th></tr>";
		while($row<=($totalrow+2))  
		{
			$container=trim($mydata->value($row,2));
			$container = preg_replace('/[^A-Za-z0-9\. -]/', '', $container);
	
			$pod=$mydata->value($row,9);
			$stowage=$mydata->value($row,10);
			
			if($stowage!=null)
			{
				$stowage = preg_replace("/[^0-9,.]/", "", $stowage);
				
				if(strlen($stowage)==5)
					$stowage = "0".$stowage;
				else
					$stowage=$stowage;
				
				$sql_stow_chk="SELECT COUNT(*) AS rtnValue
				FROM ctmsmis.mis_exp_unit
				WHERE ctmsmis.mis_exp_unit.vvd_gkey='$vvd_gkey' AND ctmsmis.mis_exp_unit.stowage_pos='$stowage'";
			
				$count_stowage=$this->bm->dataReturn($sql_stow_chk);  //dataReturn for DB2
			}
			
			$strcontchk="SELECT count(id) AS rtnValue FROM sparcsn4.inv_unit WHERE id='$container'";
			
			$count_container=$this->bm->dataReturn($strcontchk);  //dataReturn for DB2
			
			$sql_pod_check="SELECT count(sparcsn4.ref_routing_point.id) as rtnValue FROM sparcsn4.vsl_vessel_visit_details
			INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
			INNER JOIN sparcsn4.ref_point_calls ON sparcsn4.ref_point_calls.itin_gkey=sparcsn4.argo_visit_details.itinereray
			INNER JOIN sparcsn4.ref_routing_point ON sparcsn4.ref_point_calls.point_gkey=sparcsn4.ref_routing_point.gkey 
			WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$rotation' AND id='$pod'";
			
			$count_pod=$this->bm->dataReturn($sql_pod_check);  //dataReturn for DB2
				
			if($count_container==0)			//check in n4
			{
				$stat=$stat+1;
				$table .= "<tr><td>".$container."</td><td>Container is not available or Wrong Container No.</td></tr>";
			}
			else if($stowage==null)			//check blank stowage
			{
				$stat=$stat+1;
				$table .= "<tr><td>".$container."</td><td>Stowage position of container is blank</td></tr>";
			}
			else if($count_stowage>0)		//check duplicate stowage
			{
				$strStowCont="SELECT cont_id AS rtnValue
				FROM ctmsmis.mis_exp_unit
				WHERE ctmsmis.mis_exp_unit.vvd_gkey='$vvd_gkey' AND ctmsmis.mis_exp_unit.stowage_pos='$stowage'";
			
				$StowCont=$this->bm->dataReturn($strStowCont);
				
				if($StowCont!=$container)
				{
					$stat=$stat+1;
					$table .= "<tr><td>".$container."</td><td>Stowage Position of container is duplicate</td></tr>";
				}					
			}
			else if($count_pod==0)			//check valid port of destination
			{
				$stat=$stat+1;
				$table .= "<tr><td>".$pod."</td><td>Port of destination is not valid</td></tr>";
			}
				
			$row++;
		}
		
		$table=$table."</table>";
		
		if($stat>0)
		{
			$data['msg']="Uploaded excel file has following errors<br>".$table;
			$data['title']="UPLOAD EXCEL FILE...";
			$this->load->view('header2');
			$this->load->view('myExportExcelUploadForm',$data);
			$this->load->view('footer');
			return;
		}
		
		//Validation end
			
		$row=3;  
		$i=0;
		$stat = 0;
		
		$chkShipmentTypeNotGivenCont="";
		$chkShipmentTypeStat="";
		$updateby=$this->session->userdata('login_id');
		
		while($row<=($totalrow+2))  //data insert
		{
			$container=trim($mydata->value($row,2));
			$container = preg_replace('/[^A-Za-z0-9\. -]/', '', $container);
				
			$str_gkey="SELECT gkey as rtnValue FROM sparcsn4.inv_unit WHERE id='$container' ORDER BY gkey DESC LIMIT 1";
				
			$gkey=$this->bm->dataReturn($str_gkey);    //$gkey of inv_unit for particular container
				
			$iso=trim($mydata->value($row,3));
			$mlo=$mydata->value($row,6);
			
			if($mlo==null)
			{
				$sql_mlo="select sparcsn4.ref_bizunit_scoped.id as rtnValue
				from sparcsn4.inv_unit
				inner join sparcsn4.ref_bizunit_scoped on sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
				where sparcsn4.inv_unit.id='$container' and sparcsn4.inv_unit.category='IMPRT' order by sparcsn4.inv_unit.gkey desc LIMIT 1";
				
				$mlo=$this->bm->dataReturn($sql_mlo);
			}
			
			$cont_status=$mydata->value($row,7);
			$weight=$mydata->value($row,8);
			$pod=$mydata->value($row,9);
			$stowage=$mydata->value($row,10);
			$stowage = preg_replace("/[^0-9,.]/", "", $stowage);
			if(strlen($stowage)==5)
				$stowage = "0".$stowage;
			else
				$stowage=$stowage;
			$loaded_time=$mydata->value($row,11);
			$seal_no=$mydata->value($row,12);
			$coming_from=$mydata->value($row,13);
			$truck_no=$mydata->value($row,14);
			$craine_id=$mydata->value($row,15);
			$commodity=$mydata->value($row,16);
			$shift=$mydata->value($row,17);
			$date=$mydata->value($row,18);
			//$shipment_type=$mydata->value($row,19);
			
			if($iso=="")
			{
				$getIsoTypeQry="select sparcsn4.ref_equip_type.id as iso
				from ctmsmis.mis_exp_unit
				left join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
				inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
				inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
				inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
				where mis_exp_unit.vvd_gkey='$vvd_gkey' and mis_exp_unit.cont_id='$container'
				AND mis_exp_unit.preAddStat='0' and snx_type=0 and mis_exp_unit.delete_flag='0'";
				
				$rslt_IsoType=$this->bm->dataSelect($getIsoTypeQry);
				$iso = $rslt_IsoType[0]['iso'];
			}
				
			$str_count="SELECT COUNT(gkey) AS rtnValue FROM ctmsmis.mis_exp_unit WHERE vvd_gkey='$vvd_gkey' AND cont_id='$container' and snx_type=0";
					
			$count=$this->bm->dataReturn($str_count);  //dataReturn for DB2
				
			$str_sizeheightgroup="SELECT 
			RIGHT(sparcsn4.ref_equip_type.nominal_length,2) AS size,
			RIGHT(sparcsn4.ref_equip_type.nominal_height,2) AS height,
			sparcsn4.ref_equip_type.iso_group AS isogroup 
			FROM sparcsn4.ref_equip_type WHERE id='$iso'";
				
			$rslt_sizeheightgroup=$this->bm->dataSelect($str_sizeheightgroup);
				
			$size=$rslt_sizeheightgroup[0]['size'];
			$height=$rslt_sizeheightgroup[0]['height'];
			$isoGroup=$rslt_sizeheightgroup[0]['isogroup'];
					
			if($count>0)
			{
				//last update not in update
				$str_pgkey="SELECT gkey AS rtnValue FROM ctmsmis.mis_exp_unit WHERE vvd_gkey='$vvd_gkey' AND cont_id='$container' and snx_type=0";
					
				$presentGky=$this->bm->dataReturn($str_pgkey);  //$presentGky from excel file
				$str_update = "";
				if($presentGky!=$gkey)
				{
					$str_update="UPDATE ctmsmis.mis_exp_unit SET gkey='$gkey',cont_id='$container',isoType='$iso',cont_size='$size',cont_height='$height',isoGroup='$isoGroup',cont_status='$cont_status',cont_mlo='$mlo',vvd_gkey='$vvd_gkey',rotation='$rotation',stowage_pos='$stowage',user_id='$updateby',seal_no='$seal_no',goods_and_ctr_wt_kg='$weight',pod='$pod',truck_no='$truck_no',re_status=1,craine_id='$craine_id',last_update=NOW(),updated_in_n4=1,coming_from='$coming_from',shift='$shift',date='$date' WHERE cont_id='$container' AND vvd_gkey='$vvd_gkey' and snx_type=0";
				}
				else
				{
					$str_update="UPDATE ctmsmis.mis_exp_unit SET gkey='$gkey',cont_id='$container',isoType='$iso',cont_size='$size',cont_height='$height',isoGroup='$isoGroup',cont_status='$cont_status',cont_mlo='$mlo',vvd_gkey='$vvd_gkey',rotation='$rotation',stowage_pos='$stowage',user_id='$updateby',seal_no='$seal_no',goods_and_ctr_wt_kg='$weight',pod='$pod',truck_no='$truck_no',re_status=1,craine_id='$craine_id',updated_in_n4=1,coming_from='$coming_from',shift='$shift',date='$date' WHERE cont_id='$container' AND vvd_gkey='$vvd_gkey' and snx_type=0";
				}
					
				$yes=$this->bm->dataUpdatedb2($str_update); //dataUpdatedb2 for DB2
			}
			else
			{
				$str_insert="INSERT INTO ctmsmis.mis_exp_unit(gkey,cont_id,cont_status,cont_mlo,isoType,cont_size,cont_height,isoGroup,vvd_gkey,rotation,stowage_pos,last_update,updated_in_n4,user_id,seal_no,goods_and_ctr_wt_kg,pod,truck_no,re_status,craine_id,coming_from,shift,date) 
				VALUES ('$gkey','$container','$cont_status','$mlo','$iso','$size','$height','$isoGroup','$vvd_gkey','$rotation','$stowage',now(),1,'$updateby','$seal_no','$weight','$pod','$truck_no',1,'$craine_id','$coming_from','$shift','$date')";
					
				$yes=$this->bm->dataInsert($str_insert); //dataInsert for DB2
			}

			if($yes==1)
				$stat = $stat+1;					
			else
				$stat = $stat;	
		
			$row=$row+1;
		}  
			
		if($stat>0)
			$data['msg'] ="Successful";
		else
			$data['msg'] ="Failed";	
		
		$data['title']="UPLOAD EXCEL FILE...";
		$this->load->view('header2');
		$this->load->view('myExportExcelUploadForm',$data);
		$this->load->view('footer');
	}
	//-------------Export Excel Upload end---------------
	/*function exportExcelUpload()
	{
		$data['title']="UPLOAD EXCEL FILE...";
		$this->load->view('header2');
		$this->load->view('myExportExcelUploadForm',$data);
		$this->load->view('footer');
	}*/
		
	
	//-------------Export Excel Upload end---------------
		
	//EDI and Excel/PDF Upload start
	function ediUpload()
	{
		$id=$this->uri->segment(3);
			
		$data['title']="UPLOAD FILE...";
		$data['id']=$id;
		$this->load->view('header2');
		$this->load->view('ediUploadForm',$data);
		$this->load->view('footer');
	}
		
	function ediUploadPerform()
	{
		$login_id = $this->session->userdata('login_id');
		$ipaddr = $_SERVER['REMOTE_ADDR'];
		
		error_reporting(E_ALL ^ E_NOTICE);
			
		if ($_FILES["edi"]["error"] > 0)
		{
			$data['msg'] = "<b>Error: Try again<b>";
			$data['title']="UPLOAD FILE...";
			$this->load->view('header2');
			$this->load->view('ediUploadForm',$data);
			$this->load->view('footer');
			return;			
		}
		else
		{
			$rot=$this->input->post('rotation');
			$rotation=str_replace('/', '_', $rot); 
				
			$filenm1=$_FILES["edi"]["name"];
			$ext1 = explode(".", $filenm1);
			$fileExt1 = end($ext1);
			$filenmedi=$rotation.".".$fileExt1;		//assigned new name for edi file
				
			
				
			move_uploaded_file($_FILES["edi"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/edi/".$_FILES["edi"]["name"]);		
			rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/edi/".$_FILES["edi"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/edi/".$filenmedi);
			
			if($_FILES["excel"]["error"] <= 0)
			{
				$filenm2=$_FILES["excel"]["name"];
				$ext2 = explode(".", $filenm2);
				$fileExt2 = end($ext2);
				$filenmstow=$rotation.".".$fileExt2;	//assigned new name for	excel/pdf file
				move_uploaded_file($_FILES["excel"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/edi/".$_FILES["excel"]["name"]);		
				rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/edi/".$_FILES["excel"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/edi/".$filenmstow);
			}
			else
			{
				$filenmstow="";
			}
			$imp_voyage=$this->input->post('imp_voyage');
			$exp_voyage=$this->input->post('exp_voyage');
			$grt=$this->input->post('grt');
			$nrt=$this->input->post('nrt');
			$imo_no=$this->input->post('imo_no');
			$loa=$this->input->post('loa');
			$flag=$this->input->post('flag');
			$call_sign=$this->input->post('call_sign');
			$beam=$this->input->post('beam');
				
			$strid="SELECT id as rtnValue FROM igm_masters WHERE Import_Rotation_No='$rot'";
			
			$igm_masters_id=$this->bm->dataReturnDb1($strid);  
				
			$count_id="SELECT COUNT(igm_masters_id) AS rtnValue FROM edi_stow_info WHERE igm_masters_id='$igm_masters_id'";
				
			$rtn_count_id=$this->bm->dataReturnDb1($count_id);
				
			if($rtn_count_id>0)
			{
				$stow_info_update="UPDATE edi_stow_info SET file_name_edi='$filenmedi',file_name_stow='$filenmstow',file_upload_by='$login_id' WHERE igm_masters_id='$igm_masters_id'";
					
				$update=$this->bm->dataUpdateDB1($stow_info_update);
			}
				
			else
			{
				$stow_info_insert="INSERT INTO edi_stow_info(igm_masters_id,file_name_edi,file_name_stow,file_upload_by) VALUES('$igm_masters_id','$filenmedi','$filenmstow','$login_id')";
				
				$insert=$this->bm->dataInsertDB1($stow_info_insert);
			}
				
			$igm_masters_update="UPDATE igm_masters
			SET Voy_No='$imp_voyage',VoyNoExp='$exp_voyage',grt='$grt',nrt='$nrt',imo='$imo_no',loa_cm='$loa',flag='$flag',radio_call_sign='$call_sign',beam_cm='$beam' WHERE id='$igm_masters_id'";
				
			$update=$this->bm->dataUpdateDB1($igm_masters_update);
				
			$stat=1;
		}
			
		if($stat>0)
			$msg="Successful";
		else
			$msg="Failed";
			
		$data['title']="UPLOAD FILE...";
		$data['msg']=$msg;
		$this->load->view('header2');
		$this->load->view('ediUploadForm',$data);
		$this->load->view('footer');
	}
	//EDI and Excel/PDF Upload end
		
	//ICD EXCEL FILE UPLOAD START
		
	function uploadIcdExcel()
	{
		$data['title']="UPLOAD EXCEL FILE...";
		$this->load->view('header2');
		$this->load->view('uploadIcdExcelHTML',$data);
		$this->load->view('footer');
	}
		
	function uploadIcdExcelPerform()
		{
			$login_id = $this->session->userdata('login_id');
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			$date = date('YmdHis');
			$dbDate = date('Y-m-d H:i:s');
			//echo $dbDate."<br>";
			error_reporting(E_ALL ^ E_NOTICE);   
    
			$filenm=$login_id."_".$date.".xls";
			$filetype=$_POST["file"];
			
			if ($_FILES["file"]["error"] > 0)
			{
				$data['msg'] = "<b>Error: " . $_FILES["file"]["error"] . "<br />May be your file size exceeds 2MB.Please reduce file size and try again.<br/>To reduce file size-<br/>
				Step1:Save your Excel file into CSV(.csv) format.<br/>
				Step2:Now save your CSV file into Excel(.xls) format.<br/>
				Step3:Upload new Excel(.xls) file again.</b>";
				$data['title']="UPLOAD EXCEL FILE...";
				$this->load->view('header2');
				$this->load->view('uploadIcdExcelHTML',$data);
				$this->load->view('footer');
				return;			
			}
			else
			{
				move_uploaded_file($_FILES["file"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadExcelFile/".$_FILES["file"]["name"]);			
				rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadExcelFile/".$_FILES["file"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadExcelFile/".$filenm);
			}
			
			require_once('excel_reader2.php');
			$mydata = new Spreadsheet_Excel_Reader($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadExcelFile/".$filenm);
			
			
			$totalrow=3; //note: last 3 row not upload. i.e, number of total row increase by 3.
			$excelrow=$mydata->rowcount(0);
			$i=0;

			while($i<=$excelrow)   //row count
			{
				if($mydata->value($i,2)!="") 
				$totalrow=$totalrow+1;
				$i++;
			}
		//	echo $excelrow."  ".$totalrow;
		//	echo $totalrow;
		//	return;
			
			$row=7;  
			$i=0;
			$stat = 0;
			
		
    
			$prob = "<table border='1'><tr><td>Container</td><td>Description</td></tr>";
			$st = 0;
			$totCont = "";			
			while($row<=($totalrow))
			{
				//$pod_chk=trim($mydata->value($row,13));
				$cont_id=trim($mydata->value($row,3));

				
				$chekCont="SELECT count(id) as rtnValue FROM sparcsn4.inv_unit WHERE inv_unit.id='$cont_id'";
			//	echo $chekCont;
				$foundContainer = $this->bm->dataReturn($chekCont);
				
				if($foundContainer==0)
				{					
					$prob .= "<tr><td>".$cont_id."</td><td>Not Found in the system.</td></tr>";
					$st = $st+1; 
					$totCont .=$cont_id.", ";
				}			
				
				$row=$row+1; 
			}
			$prob .= "<tr><td colspan='2'>".$totCont."</td></tr>";
			$prob .= "</table>";
			
			
			if($st>0)
			{
					$data['msg'] = "IN YOUR EXCEL FILE LISTED PROBLEM(S) FOUND<br>".$prob."<br> PLEASE CORRECT & TRY AGAIN...";
					$data['title']="UPLOAD EXCEL FILE...";
					$this->load->view('header2');
					$this->load->view('uploadIcdExcelHTML',$data);
					$this->load->view('footer');
					return;
			}
			else
			{
					$row=7;  
					$i=0;
					$stat = 0;
					while($row<=($totalrow)) 
					{
						$mlo=$mydata->value($row,2);
						$cont_id=$mydata->value($row,3);
						$iso=$mydata->value($row,4);
						$trans_mode=$mydata->value($row,5);
						$trans_type=$mydata->value($row,6);
						$trans_operator=$mydata->value($row,7);
						$train_visit_id=$mydata->value($row,8);
						$slot=$mydata->value($row,9);
						$transport_id=$mydata->value($row,10);
						$gross_wt=$mydata->value($row,11);
						$export=$mydata->value($row,12);
						$status=$mydata->value($row,13);
						$seal=$mydata->value($row,14);
						
						$updateby=$this->session->userdata('login_id');
						$ipaddr = $_SERVER['REMOTE_ADDR'];
						
						$insertStr="REPLACE INTO ctmsmis.mis_icd_unit(mlo, cont_id, iso_code, trans_mode, trans_type, trans_operator, visit_id, slot, transport_id, gross_weight, category, fried_kind, seal, last_update, user_id, ip_address) 
							VALUES ('$mlo','$cont_id','$iso','TRAIN','$trans_type', '$trans_operator','$train_visit_id','$slot','$transport_id','$gross_wt','$export','$status','$seal', now(), '$updateby','$ipaddr')";
							
						$yes=$this->bm->dataInsert($insertStr);
						if($yes==1)
							$stat = $stat+1;					
						else
							$stat = $stat;	
						
				
						$row=$row+1;
					}	
				
					
					if($stat>0)
						$data['msg'] ="Successful";
					else
						$data['msg'] ="Failed";	
						
					$data['title']="UPLOAD EXCEL FILE...";
					$this->load->view('header2');
					$this->load->view('uploadIcdExcelHTML',$data);
					$this->load->view('footer');
				}
		}
	//ICD EXCEL FILE UPLOAD END
		
	//ICD EXCEL FILE CONVERT TO XML START
		
	function convertIcdFileForm()
	{
		$data['title']="ICD CONTAINERS CONVERTING FORM...";
		$data['mystatus']="1";
		$this->load->view('header2');
		$this->load->view('convertIcdFileForm',$data);
		$this->load->view('footer');
    }
		
	function convertIcdFilePerform()
	{			
		$this->load->view('convertIcdFilePerform',$data);
	}
	
	//ICD EXCEL FILE CONVERT TO XML END
		
	/*----Last 24 hrs Report Statement*/
	function last24hrsStatements()
	{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$login_id = $this->session->userdata('login_id');	
				$query="SELECT u_name as rtnValue FROM users WHERE login_id='$login_id'";
				$offDock= $this->bm->dataReturnDb1($query);
				//echo $query;
				//return;
				$ctime=8;
				$time=' 08:00:00';
				$offDockId = $this->Offdock($login_id);
				
				$sql_time="SELECT HOUR(NOW()) AS ctime,TIMEDIFF(CONCAT(DATE(NOW()),' 08:00:00'),NOW()) AS diff";			
				$rslt_time=$this->bm->dataSelectDb1($sql_time);
				$diff=$rslt_time[0]['diff'];
				$ctime=$rslt_time[0]['ctime'];
				
				
				$permit_time_query="SELECT  ctmsmis.offdock_upload_permission.permit_time as rtnValue from ctmsmis.offdock_upload_permission 
									where ctmsmis.offdock_upload_permission.offdock_code='$offDockId' and 
									ctmsmis.offdock_upload_permission.permit_date=date(now())";		
				$permit_time=$this->bm->dataReturn($permit_time_query);
				if ($permit_time!="")
				{
					$time=" ".$permit_time;
					$permit_time=" ".$permit_time;
				}
				/*				
				$sql_ctime="SELECT HOUR('$permit_time') AS rtnValue from ctmsmis.offdock_upload_permission where ctmsmis.offdock_upload_permission.offdock_code='$offDockId' and 
									ctmsmis.offdock_upload_permission.permit_date=date(now())";			
				$per_c_time=$this->bm->dataReturn($sql_ctime);
				if($per_c_time!="")
				{
					$ctime=$per_c_time;
				}
				*/	
				if ($permit_time!="")
				{
					$sql_permission_time="SELECT TIMEDIFF(CONCAT(DATE(NOW()),'$permit_time'),NOW()) AS diff";			
					$permission_time=$this->bm->dataSelectDb1($sql_permission_time);
					$new_diff=$permission_time[0]['diff'];
				
					if($new_diff!="")
					{
						$diff=$new_diff;
					}
					$data['msgFlag']=1;
				}
				//echo $rslt_time[0]['ctime'];
				//echo $c_time;
				//echo $permit_time_query;
				//echo $diff;
				//echo $sql_permission_time;
				//return;
				$data['ctime']=$ctime;
				$data['diff']=$diff;
				$data['time']=$time;
				$data['rslt_time']=$rslt_time;
				$data['title']="Last 24hrs Statement";
				$data['offDock']=$offDock;
				$data['updateFlag']=0;
				$this->load->view('header5');
				$this->load->view('last24hrsStatements',$data);
				$this->load->view('footer_1');
			}
	}
		
	function last24hrsOffDocStatement()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			$akey=$this->input->post('akey');	

			$ipaddr = $_SERVER['REMOTE_ADDR'];
			$date=$this->input->post('date');
			$offDock=$this->input->post('offDock');
			$capacity=$this->input->post('capacity');
			$impCont=$this->input->post('impCont');
			$expCont=$this->input->post('expCont');
			$emptyCont=$this->input->post('emptyCont');
			$total=$this->input->post('total');
			$last24stuff=$this->input->post('last24stuff');
			$p2dLaden=$this->input->post('p2dLaden');
			$p2dEmpty=$this->input->post('p2dEmpty');
			$d2pLaden=$this->input->post('d2pLaden');
			$d2pEmpty=$this->input->post('d2pEmpty');
			$remarks=$this->input->post('remarks');
			//echo $total;
			//return; 
			$offDockId = $this->Offdock($login_id);
			//$query="SELECT id as rtnValue FROM users WHERE login_id='$login_id'";
			//$offDockId= $this->bm->dataReturnDb1($query);
				
			if($this->input->post('update'))
			{
				$strInsertEq = "UPDATE ctmsmis.offdoc_statement SET stmt_date ='$date', offdoc_code = '$offDockId',
									capacity='$capacity', imp_lying ='$impCont',exp_lying='$expCont', mty_lying='$emptyCont',
									total_teus='$total',last_24hrs='$last24stuff', port_to_depo_laden='$p2dLaden', port_to_depo_mty='$p2dEmpty', 
									depo_to_port_laden='$d2pLaden', depo_to_port_mty='$d2pEmpty',
									remarks='$remarks', last_update=now(), update_by='$login_id', ip_address='$ipaddr' WHERE ctmsmis.offdoc_statement.akey=$akey";
				//echo $strInsertEq ;
				//return; 
				$updateStat = $this->bm->dataInsert($strInsertEq);
				if($updateStat>=1)
				{
					$data['msg']="Successfully Updated"; 
				}
				else
					$data['msg']="Not Updated";
				
			}
			else
			{
				$strInsertEq = "insert into ctmsmis.offdoc_statement(stmt_date, offdoc_code, capacity, imp_lying, exp_lying, mty_lying, total_teus, last_24hrs,
				port_to_depo_laden, port_to_depo_mty, depo_to_port_laden, depo_to_port_mty, remarks, last_update, update_by, ip_address) 
				values('$date', '$offDockId', '$capacity', '$impCont', '$expCont', '$emptyCont', '$total', '$last24stuff', '$p2dLaden',
				'$p2dEmpty', '$d2pLaden', '$d2pEmpty', '$remarks', now(), '$login_id', '$ipaddr')";  
				$stat = $this->bm->dataInsert($strInsertEq);
				if($stat>=1)
				{
					$data['msg']="Successfully Saved"; 
				}
				else
					$data['msg']="Not Saved";
				
			}
			$query="SELECT u_name as rtnValue FROM users WHERE login_id='$login_id'";
			$offDock= $this->bm->dataReturnDb1($query);
				
			$data['title']="Last 24hrs Statement";
			$data['offDock']=$offDock;
			$data['updateFlag']=0;
			$this->load->view('header5');
			$this->load->view('last24hrsStatements',$data);
			$this->load->view('footer_1');
		}
	}
	
	function last24hrsStatementList()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$login_id = $this->session->userdata('login_id');	
			$query="SELECT * FROM ctmsmis.offdoc_statement WHERE update_by='$login_id'";
			$offDock= $this->bm->dataSelect($query);
			//echo $offDock[0]['offdoc_code'];
			//return;
				
			$data['title']="Last 24hrs Statement List";
			$data['offDock']=$offDock;
			$this->load->view('header5');
			$this->load->view('last24hrsStatementList',$data);
			$this->load->view('footer_1');
		}
	}
		
	function last24hrsOffDocStatementEdit()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$akey=$this->input->post('akey');
			$login_id = $this->session->userdata('login_id');	
			$query="SELECT * FROM ctmsmis.offdoc_statement WHERE akey='$akey'";
			$offDockEditList= $this->bm->dataSelect($query);
			//echo $offDockEditList[0]['offdoc_code'];
			//return;
			$query="SELECT u_name as rtnValue FROM users WHERE login_id='$login_id'";
			$offDock= $this->bm->dataReturnDb1($query);
			$data['title']="Last 24hrs Statement List";
			$data['offDock']=$offDock;
			$data['editFlag']=1;
			$data['updateFlag']=1;
				
			$data['offDockEditList']=$offDockEditList;
			$this->load->view('header5');
			$this->load->view('last24hrsStatements',$data);
			$this->load->view('footer_1');
		}
	}
		
	function last24hrsOffDocStatementDelete()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$akey=$this->input->post('akey1');
			$login_id = $this->session->userdata('login_id');	
			$query="delete from ctmsmis.offdoc_statement  WHERE akey='$akey'";
			$deleteStat= $this->bm->dataDelete($query);
			$data['delFlag']="1";
			if($deleteStat==1)
			{
				$data['msg2']="Successfully Deleted";
			}
			else
				$data['msg2']="Not Deleted";
				
			//echo $offDockEditList[0]['offdoc_code'];
			//return;
			$query="SELECT * FROM ctmsmis.offdoc_statement WHERE update_by='$login_id'";
			$offDock= $this->bm->dataSelect($query);
			//echo $offDock[0]['offdoc_code'];
			//return;
				
			$data['title']="Last 24hrs Statement List";
			$data['offDock']=$offDock;
			$this->load->view('header5');
			$this->load->view('last24hrsStatementList',$data);
			$this->load->view('footer_1');
		}
	}
		
	function last24hrsOffDocStatementPdf()
	{
		$akey=$this->input->post('akey2');
		$offdockName=$this->input->post('offdockName');
					
		$login_id = $this->session->userdata('login_id');	
		$query="SELECT * FROM ctmsmis.offdoc_statement WHERE akey='$akey'";
		$offDockData= $this->bm->dataSelect($query);
		$this->data['offDockData']=$offDockData;

		//echo $offDockEditList[0]['offdoc_code'];
		//return;
		$offdockQuery="SELECT u_name as rtnValue FROM users WHERE login_id='$login_id'";
		$offDock= $this->bm->dataReturnDb1($offdockQuery);		
				
		$offdockNameQueryForAdmin="SELECT u_name as rtnValue FROM users WHERE login_id='$offdockName'";
		$offDockName= $this->bm->dataReturnDb1($offdockNameQueryForAdmin);
		if($login_id=='admin')
		{
			$this->data['offDock']=$offDockName;
		}
		else
		{
			$this->data['offDock']=$offDock;
		}
		$this->data['title']="Last 24hrs Statement List";
		$this->load->library('m_pdf');
		$mpdf->use_kwt = true;

		$html=$this->load->view('last24hrsStatementListPdf',$this->data, true); 
		$pdfFilePath ="Last24hrsStatementListPdf-".time()."-download.pdf";

		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
						
		//$stylesheet = file_get_contents('resources/styles/test.css'); // external css
		$pdf->setFooter('Developed By : DataSoft|Page {PAGENO}|Date {DATE j-m-Y}');
		$pdf->WriteHTML($html,2);
		$pdf->Output($pdfFilePath, "I"); // For Show Pdf	
	}
	/*----Last 24 hrs Report Statement*/
		
	//DOWLOAD EXCEL SAMPLE FOR EDI DOWNLOAD START
		
	function ediDownloadSample()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="DOWLOAD EXCEL SAMPLE FOR EDI DOWNLOAD";
			$this->load->view('header2');
			$this->load->view('ediDownloadSample',$data);
			$this->load->view('footer');
		}
	}
		
	function ediDownloadSampleView()
	{
		$rotNo=$this->input->post('rotNo');
		$type=$this->input->post('options');
		//echo $type;
		$fileSample = str_replace("/", "_", $rotNo);
			
		$query="SELECT cont_id,isoType,cont_mlo,cont_status,goods_and_ctr_wt_kg,bookingNo,seal_no,stowage_pos,'BDCGP' as load_port,pod FROM ctmsmis.mis_exp_unit WHERE rotation='$rotNo'";
		$result= $this->bm->dataSelect($query);	
			
		$query2="SELECT Voy_No from igm_masters WHERE Import_Rotation_No='$rotNo'";
		$result2= $this->bm->dataSelectDb1($query2);
			
		//echo $result2[0]['Voy_No'];
		//return;
			
		$query1="select sparcsn4.vsl_vessels.name, agent,radio_call_sign, 'BDCGP' as LOP
				from sparcsn4.vsl_vessel_visit_details
				inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
				inner join ctmsmis.mis_exp_unit_preadv_req on 
				sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit_preadv_req.vvd_gkey
				where sparcsn4.vsl_vessel_visit_details.ib_vyg='$rotNo' limit 1";

		$result1= $this->bm->dataSelect($query1);
		//echo  $query;
		//return;

		$data['type']=$type;
		$data['fileSample']=$fileSample;
		$data['result']=$result;
		$data['result1']=$result1;
		$data['result2']=$result2;
		$this->load->view('ediDownloadSampleView',$data);
	}
		
	//DOWLOAD EXCEL SAMPLE FOR EDI DOWNLOAD END
		
	//STUFFING CONTAINER Excel start
	function stuffingContExcel()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			$flag=1;
			
			$org_Type_id=$this->session->userdata('org_Type_id');
			
			$data['title']="UPLOAD EXCEL FOR LAST 24 HOURS STUFFING CONTAINER...";		
			$data['flag']=$flag;
			
			$login_id = $this->session->userdata('login_id');
			
			$depo_code=$this->Offdock($login_id);
			
			$sql_cnt_permit="select count(*) as rtnValue 
			from ctmsmis.offdock_upload_permission 
			where offdock_code='$depo_code' and permit_date=date(now())";
			
			$count=$this->bm->dataReturn($sql_cnt_permit);
			
			if($count==1)
			{
				$sql_permit="select concat(permit_date,' ',permit_time) as upperLimitTmp,hour(permit_time) as upperLimit
				from ctmsmis.offdock_upload_permission 
				where offdock_code='$depo_code' and permit_date=date(now())";
				
				$rslt_permit=$this->bm->dataSelect($sql_permit);
				
				$upperLimitTmp=$rslt_permit[0]['upperLimitTmp'];
				$upperLimit=$rslt_permit[0]['upperLimit'];
			
				$sql_time="SELECT HOUR(NOW()) AS ctime,TIME(NOW()) as ctimetmp,DATE(NOW()) as cdate";
		
				$rslt_time=$this->bm->dataSelectDb1($sql_time);
				$ctime=$rslt_time[0]['ctime'];						
				$cdate=$rslt_time[0]['cdate'];
				$ctimetmp=$rslt_time[0]['ctimetmp'];
				
				$lowerLimitTmp=$cdate.$ctimetmp;						
				$lowerLimit=$ctime;						
			
				$upperLimitTmp = strtotime($upperLimitTmp);
				$lowerLimitTmp = strtotime($lowerLimitTmp);
			//	$diff=round(abs($upperLimitTmp - $lowerLimitTmp) / 60,2);		
				$diff=round(($upperLimitTmp - $lowerLimitTmp) / 60,2);
				if($diff<0)
					$diff=null;
			}
			else
			{
			//	$sql_time="SELECT HOUR(NOW()) AS ctime,TIMEDIFF(CONCAT(DATE(NOW()),' 10:00:00'),NOW()) AS diff";
				$sql_time="SELECT HOUR(NOW()) AS ctime,TIMEDIFF(CONCAT(DATE(NOW()),' 08:00:00'),NOW()) AS diff";
			
				$rslt_time=$this->bm->dataSelectDb1($sql_time);
				$ctime=$rslt_time[0]['ctime'];
				$diff=$rslt_time[0]['diff'];
				
				$str=substr($diff,0,1); 
				
				if($str=="-")
					$diff=null;
				
				/* $lowerLimit=9;
				$upperLimit=10; */
				
				$lowerLimit=7;
				$upperLimit=8;
			}
			
			$data['lowerLimit']=$lowerLimit;
			$data['upperLimit']=$upperLimit;
			
			$data['ctime']=$ctime;
			$data['diff']=$diff;
			$data['org_Type_id']=$org_Type_id;
			
			$this->load->view('header2');
			$this->load->view('stuffingContExcel',$data);
			$this->load->view('footer');
		}
	}
	
	function stuffingContExcelPerform()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			$date = date('YmdHis');
			$dbDate = date('Y-m-d H:i:s');
			//echo $dbDate."<br>";
			$offdock=$this->input->post('offdock');
			
			$org_Type_id=$this->session->userdata('org_Type_id');
			
			$data['org_Type_id']=$org_Type_id;
			
			/* $lowerLimit=9;
			$upperLimit=10; */
			
			$lowerLimit=7;
			$upperLimit=8;
			
			error_reporting(E_ALL ^ E_NOTICE);   
    
			$filenm=$login_id."_".$date.".xls";
			$filetype=$_POST["file"];
			
			if ($_FILES["file"]["error"] > 0)
			{
				$data['msg'] = "<b>Error: " . $_FILES["file"]["error"] . "<br />May be your file size exceeds 2MB.Please reduce file size and try again.<br/>To reduce file size-<br/>
				Step1:Save your Excel file into CSV(.csv) format.<br/>
				Step2:Now save your CSV file into Excel(.xls) format.<br/>
				Step3:Upload new Excel(.xls) file again.</b>";
				$data['title']="UPLOAD EXCEL FOR LAST 24 HOURS STUFFING CONTAINER...";
				
				$login_id = $this->session->userdata('login_id');
			
				$depo_code=$this->Offdock($login_id);
				
				$sql_cnt_permit="select count(*) as rtnValue 
				from ctmsmis.offdock_upload_permission 
				where offdock_code='$depo_code' and permit_date=date(now())";
				
				$count=$this->bm->dataReturn($sql_cnt_permit);
			
				if($count==1)
				{
					$sql_permit="select concat(permit_date,' ',permit_time) as upperLimitTmp,hour(permit_time) as upperLimit
					from ctmsmis.offdock_upload_permission 
					where offdock_code='$depo_code' and permit_date=date(now())";
					
					$rslt_permit=$this->bm->dataSelect($sql_permit);
					
					$upperLimitTmp=$rslt_permit[0]['upperLimitTmp'];
					$upperLimit=$rslt_permit[0]['upperLimit'];
				
					$sql_time="SELECT HOUR(NOW()) AS ctime,TIME(NOW()) as ctimetmp,DATE(NOW()) as cdate";
			
					$rslt_time=$this->bm->dataSelectDb1($sql_time);
					$ctime=$rslt_time[0]['ctime'];						
					$cdate=$rslt_time[0]['cdate'];
					$ctimetmp=$rslt_time[0]['ctimetmp'];
					
					$lowerLimitTmp=$cdate.$ctimetmp;						
					$lowerLimit=$ctime;						
				
					$upperLimitTmp = strtotime($upperLimitTmp);
					$lowerLimitTmp = strtotime($lowerLimitTmp);
				//	$diff=round(abs($upperLimitTmp - $lowerLimitTmp) / 60,2);		
					$diff=round(($upperLimitTmp - $lowerLimitTmp) / 60,2);
					if($diff<0)
						$diff=null;
				}
				else
				{
				//	$sql_time="SELECT HOUR(NOW()) AS ctime,TIMEDIFF(CONCAT(DATE(NOW()),' 10:00:00'),NOW()) AS diff";
					$sql_time="SELECT HOUR(NOW()) AS ctime,TIMEDIFF(CONCAT(DATE(NOW()),' 08:00:00'),NOW()) AS diff";
			
					$rslt_time=$this->bm->dataSelectDb1($sql_time);
					
					$ctime=$rslt_time[0]['ctime'];
					$diff=$rslt_time[0]['diff'];
					
					$str=substr($diff,0,1); 
				
					if($str=="-")
						$diff=null;
				}
				
				$data['ctime']=$ctime;
				$data['diff']=$diff;
				
				$data['lowerLimit']=$lowerLimit;
				$data['upperLimit']=$upperLimit;
				
				$this->load->view('header2');
				$this->load->view('stuffingContExcel',$data);
				$this->load->view('footer');
				return;			
			}
			
			else
			{
				move_uploaded_file($_FILES["file"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/offdockexcel/".$_FILES["file"]["name"]);			
				rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/offdockexcel/".$_FILES["file"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/offdockexcel/".$filenm);
			}
			
			require_once('excel_reader2.php');
			$mydata = new Spreadsheet_Excel_Reader($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/offdockexcel/".$filenm);
			
			$row=4;
		
			$totalrow=0;
			$excelrow=$mydata->rowcount(0);
			$i=4;
			
			while($i<=$excelrow)
			{
				if(trim($mydata->value($i,2))!="")
				$totalrow=$totalrow+1;
				$i=$i+1;
			}
		//	echo $totalrow;
			$row=4;  
			$i=0;
			$stat = 0;
			
			while($row<($totalrow+4))
			{
				$cont_no=$mydata->value($row,2);
				$cont_no = preg_replace('/[^A-Za-z0-9\. -]/', '', $cont_no);
				
				$seal_no=$mydata->value($row,3);
				$mlo=$mydata->value($row,4);
				$stfdate=$mydata->value($row,5);
				
				$newdate = str_replace('/', '-', $stfdate);
				$stfdate = date("Y-m-d", strtotime($newdate)); 
				/*
				$stfdate=$mydata->value($row,5);
				$newdate = str_replace('/', '-', $stfdate);
				if(preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/",$newdate))
				{
					$stfdate = date("Y-m-d", strtotime($newdate));
				}
				else
				{
					$msg="Stuffing date format is not in dd/mm/yyyy format for container ".$cont_no.". Please correct it.";
					$data['msg']=$msg;
					
					$this->load->view('header2');
					$this->load->view('stuffingContExcel',$data);
					$this->load->view('footer');
					return;
				}
				*/
				$destport=$mydata->value($row,6);
				$commodity=$mydata->value($row,7);
				$commodity=str_replace("'","\'",$commodity);
			
				$sql_ISOSizeHeight="SELECT sparcsn4.ref_equip_type.id,RIGHT(sparcsn4.ref_equip_type.nominal_length,2) AS size,RIGHT(sparcsn4.ref_equip_type.nominal_height,2) AS height,sparcsn4.ref_equip_type.iso_group
				FROM sparcsn4.inv_unit
				INNER JOIN sparcsn4.inv_unit_equip ON inv_unit.gkey=inv_unit_equip.unit_gkey 
				INNER JOIN sparcsn4.ref_equipment ON inv_unit_equip.eq_gkey=ref_equipment.gkey
				INNER JOIN sparcsn4.ref_equip_type ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey
				WHERE sparcsn4.inv_unit.id='$cont_no' LIMIT 1";
				
				$rslt_ISOSizeHeight=$this->bm->dataSelect($sql_ISOSizeHeight);
				
				$iso=$rslt_ISOSizeHeight[0]['id'];
				$size=$rslt_ISOSizeHeight[0]['size'];
				$height=$rslt_ISOSizeHeight[0]['height'];
				$isoGroup=$rslt_ISOSizeHeight[0]['iso_group'];
				
			//	$depo_code=$this->Offdock($login_id);
			
				if($org_Type_id==28)		//works when user is admin
				{
					$sql_code="select id as rtnValue from ctmsmis.offdoc where code='$offdock'";
					$depo_code=$this->bm->dataReturn($sql_code);
				}
				else						//works when user is an offdock
					$depo_code=$this->Offdock($login_id);
				
				$stfdate_chk="select count(*) as rtnValue from ctmsmis.exp_stuffing_unit where stuffing_date='$stfdate' and cont_id='$cont_no'";
				
				$count_stfdate=$this->bm->dataReturn($stfdate_chk);
				
				if($count_stfdate==1)
				{
					$sql_update="update ctmsmis.exp_stuffing_unit
					set cont_id='$cont_no',seal_no='$seal_no',iso_type='$iso',size='$size',height='$height',mlo_code='$mlo',stuffing_date='$stfdate',dest_port='$destport',comodity_code='$commodity',last_update=now(),uploaded_by='$login_id',user_ip='$ipaddr',depo_code='$depo_code',iso_group='$isoGroup'
					where stuffing_date='$stfdate' and cont_id='$cont_no'";
					
					$yes=$this->bm->dataUpdate($sql_update);
				}
				else
				{
					$sql_insert="insert into ctmsmis.exp_stuffing_unit(cont_id,seal_no,iso_type,size,height,mlo_code,stuffing_date,dest_port,comodity_code,last_update,uploaded_by,user_ip,depo_code,iso_group)
					values('$cont_no','$seal_no','$iso','$size','$height','$mlo','$stfdate','$destport','$commodity',now(),'$login_id','$ipaddr','$depo_code','$isoGroup')";
				
					$yes=$this->bm->dataInsert($sql_insert);
				}
			
				if($yes==1)
					$stat = $stat+1;					
				else
					$stat = $stat;							
				
				$row=$row+1; 
			}
			
			if($stat>0)
				$data['msg'] ="Data successfully uploaded.";
			else
				$data['msg'] ="Data not uploaded.";	
			
		//	$sql_time="SELECT HOUR(NOW()) AS ctime,TIMEDIFF(CONCAT(DATE(NOW()),' 10:00:00'),NOW()) AS diff";
			$sql_time="SELECT HOUR(NOW()) AS ctime,TIMEDIFF(CONCAT(DATE(NOW()),' 08:00:00'),NOW()) AS diff";
			
			$rslt_time=$this->bm->dataSelectDb1($sql_time);
				
			$data['ctime']=$rslt_time[0]['ctime'];
			$data['diff']=$rslt_time[0]['diff'];
				
			$data['title']="UPLOAD EXCEL FOR LAST 24 HOURS STUFFING CONTAINER...";
			$this->load->view('header2');
			$this->load->view('stuffingContExcel',$data);
			$this->load->view('footer'); 
		}
	}
	//STUFFING CONTAINER Excel end
	
	//-------------Export Excel Upload for admin start---------------
	
	function exportExcelUploadForAdmin()
	{
		$data['title']="UPLOAD EXCEL FILE FROM ADMIN PANEL...";
		$this->load->view('header2');
		$this->load->view('myExportExcelUploadFormForAdmin',$data);
		$this->load->view('footer');
	}
	
	function exportExcelUploadPerformForAdmin()
	{
		$login_id = $this->session->userdata('login_id');
		$ipaddr = $_SERVER['REMOTE_ADDR'];
		$date = date('YmdHis');
		$dbDate = date('Y-m-d H:i:s');
		
		error_reporting(E_ALL ^ E_NOTICE);   
    
		$filenm=$login_id."_".$date.".xls";
		$filetype=$_POST["file"];
			
		if ($_FILES["file"]["error"] > 0)
		{
			$data['msg'] = "<b>Error: " . $_FILES["file"]["error"] . "<br />May be your file size exceeds 2MB.Please reduce file size and try again.<br/>To reduce file size-<br/>
			Step1:Save your Excel file into CSV(.csv) format.<br/>
			Step2:Now save your CSV file into Excel(.xls) format.<br/>
			Step3:Upload new Excel(.xls) file again.</b>";
			$data['title']="UPLOAD EXCEL FILE FROM ADMIN PANEL...";
			$this->load->view('header2');
			$this->load->view('myExportExcelUploadFormForAdmin',$data);
			$this->load->view('footer');
			return;			
		}
		else
		{
			move_uploaded_file($_FILES["file"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/export/uploadfile/".$_FILES["file"]["name"]);			
			rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/export/uploadfile/".$_FILES["file"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/export/uploadfile/".$filenm);
		}
			
		require_once('excel_reader2.php');
		$mydata = new Spreadsheet_Excel_Reader($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/export/uploadfile/".$filenm);
			
		$rotation=$mydata->value(1,6);
		
		//delete old data start
		$sql_delete_old_data="DELETE FROM ctmsmis.mis_exp_unit WHERE rotation='$rotation' AND snx_type='0'";
		
		$rslt_delete_old_data=$this->bm->dataDelete($sql_delete_old_data);
		//delete old data end
		
		$str_vvd_gkey="SELECT vvd_gkey AS rtnValue FROM sparcsn4.vsl_vessel_visit_details WHERE ib_vyg='$rotation'";
			
		$vvd_gkey=$this->bm->dataReturn($str_vvd_gkey);   //dataReturn for DB2
		
		if($vvd_gkey==null)
		{
			$data['msg']="Rotation ".$rotation." is not valid. Please provide correct rotation.";
			$data['title']="UPLOAD EXCEL FILE FROM ADMIN PANEL...";
			$this->load->view('header2');
			$this->load->view('myExportExcelUploadFormForAdmin',$data);
			$this->load->view('footer');
			return;
		}
		
		$totalrow=0;
		$excelrow=$mydata->rowcount(0);
		$i=3;
			
		while($i<=$excelrow)   //row count
		{
			if(trim($mydata->value($i,2))!="")  //3
			$totalrow=$totalrow+1;
			$i=$i+1;
		}
		
		//Validation start
		$row=3;
		$stat=0;
		$count_stowage=0;
	
		$table = "<table border='1'><tr><th>Field</th><th>Description</th></tr>";
		while($row<=($totalrow+2))  
		{
			$container=trim($mydata->value($row,2));
			$container = preg_replace('/[^A-Za-z0-9\. -]/', '', $container);
	
			$pod=$mydata->value($row,9);
			$stowage=$mydata->value($row,10);
			
			if($stowage!=null)
			{
				$stowage = preg_replace("/[^0-9,.]/", "", $stowage);
				
				if(strlen($stowage)==5)
					$stowage = "0".$stowage;
				else
					$stowage=$stowage;
				
				$sql_stow_chk="SELECT COUNT(*) AS rtnValue
				FROM ctmsmis.mis_exp_unit
				WHERE ctmsmis.mis_exp_unit.vvd_gkey='$vvd_gkey' AND ctmsmis.mis_exp_unit.stowage_pos='$stowage'";
			
				$count_stowage=$this->bm->dataReturn($sql_stow_chk);  //dataReturn for DB2
			}
			
			$strcontchk="SELECT count(id) AS rtnValue FROM sparcsn4.inv_unit WHERE id='$container'";
			
			$count_container=$this->bm->dataReturn($strcontchk);  //dataReturn for DB2
			
			$sql_pod_check="SELECT count(sparcsn4.ref_routing_point.id) as rtnValue FROM sparcsn4.vsl_vessel_visit_details
			INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
			INNER JOIN sparcsn4.ref_point_calls ON sparcsn4.ref_point_calls.itin_gkey=sparcsn4.argo_visit_details.itinereray
			INNER JOIN sparcsn4.ref_routing_point ON sparcsn4.ref_point_calls.point_gkey=sparcsn4.ref_routing_point.gkey 
			WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$rotation' AND id='$pod'";
			
			$count_pod=$this->bm->dataReturn($sql_pod_check);  //dataReturn for DB2
				
			if($count_container==0)			//check in n4
			{
				$stat=$stat+1;
				$table .= "<tr><td>".$container."</td><td>Container is not available or Wrong Container No.</td></tr>";
			}
			else if($stowage==null)			//check blank stowage
			{
				$stat=$stat+1;
				$table .= "<tr><td>".$container."</td><td>Stowage position of container is blank</td></tr>";
			}
			else if($count_stowage>0)		//check duplicate stowage
			{
				$strStowCont="SELECT cont_id AS rtnValue
				FROM ctmsmis.mis_exp_unit
				WHERE ctmsmis.mis_exp_unit.vvd_gkey='$vvd_gkey' AND ctmsmis.mis_exp_unit.stowage_pos='$stowage'";
			
				$StowCont=$this->bm->dataReturn($strStowCont);
				
				if($StowCont!=$container)
				{
					$stat=$stat+1;
					$table .= "<tr><td>".$container."</td><td>Stowage Position of container is duplicate</td></tr>";
				}					
			}
			else if($count_pod==0)			//check valid port of destination
			{
				$stat=$stat+1;
				$table .= "<tr><td>".$pod."</td><td>Port of destination is not valid</td></tr>";
			}
				
			$row++;
		}
		$row;
		$table=$table."</table>";
		
		if($stat>0)
		{
			$data['msg']="Uploaded excel file has following errors<br>".$table;
			$data['title']="UPLOAD EXCEL FILE FROM ADMIN PANEL...";
			$this->load->view('header2');
			$this->load->view('myExportExcelUploadFormForAdmin',$data);
			$this->load->view('footer');
			return;
		}
		
		//Validation end
			
		$row=3;  
		$i=0;
		$stat = 0;
		
		$chkShipmentTypeNotGivenCont="";
		$chkShipmentTypeStat="";
		$updateby=$this->session->userdata('login_id');
		
		while($row<=($totalrow+2))  //data insert
		{
			$container=trim($mydata->value($row,2));
			$container = preg_replace('/[^A-Za-z0-9\. -]/', '', $container);
				
			$str_gkey="SELECT gkey as rtnValue FROM sparcsn4.inv_unit WHERE id='$container' ORDER BY gkey DESC LIMIT 1";
				
			$gkey=$this->bm->dataReturn($str_gkey);    //$gkey of inv_unit for particular container
				
			$iso=trim($mydata->value($row,3));
			$mlo=$mydata->value($row,6);
			
			if($mlo==null)
			{
				$sql_mlo="select sparcsn4.ref_bizunit_scoped.id as rtnValue
				from sparcsn4.inv_unit
				inner join sparcsn4.ref_bizunit_scoped on sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
				where sparcsn4.inv_unit.id='$container' and sparcsn4.inv_unit.category='IMPRT' order by sparcsn4.inv_unit.gkey desc LIMIT 1";
				
				$mlo=$this->bm->dataReturn($sql_mlo);
			}
			
			$cont_status=$mydata->value($row,7);
			$weight=$mydata->value($row,8);
			$pod=$mydata->value($row,9);
			$stowage=$mydata->value($row,10);
			$stowage = preg_replace("/[^0-9,.]/", "", $stowage);
			if(strlen($stowage)==5)
				$stowage = "0".$stowage;
			else
				$stowage=$stowage;
			$loaded_time=$mydata->value($row,11);
			$seal_no=$mydata->value($row,12);
			$coming_from=$mydata->value($row,13);
			$truck_no=$mydata->value($row,14);
			$craine_id=$mydata->value($row,15);
			$commodity=$mydata->value($row,16);
			$shift=$mydata->value($row,17);
			$date=$mydata->value($row,18);
			//$shipment_type=$mydata->value($row,19);
			
			if($iso=="")
			{
				$getIsoTypeQry="select sparcsn4.ref_equip_type.id as iso
				from ctmsmis.mis_exp_unit
				left join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
				inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
				inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
				inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
				where mis_exp_unit.vvd_gkey='$vvd_gkey' and mis_exp_unit.cont_id='$container'
				AND mis_exp_unit.preAddStat='0' and snx_type=0 and mis_exp_unit.delete_flag='0'";
				
				$rslt_IsoType=$this->bm->dataSelect($getIsoTypeQry);
				$iso = $rslt_IsoType[0]['iso'];
			}
				
			$str_count="SELECT COUNT(gkey) AS rtnValue FROM ctmsmis.mis_exp_unit WHERE vvd_gkey='$vvd_gkey' AND cont_id='$container' and snx_type=0";
					
			$count=$this->bm->dataReturn($str_count);  //dataReturn for DB2
				
			$str_sizeheightgroup="SELECT 
			RIGHT(sparcsn4.ref_equip_type.nominal_length,2) AS size,
			RIGHT(sparcsn4.ref_equip_type.nominal_height,2) AS height,
			sparcsn4.ref_equip_type.iso_group AS isogroup 
			FROM sparcsn4.ref_equip_type WHERE id='$iso'";
				
			$rslt_sizeheightgroup=$this->bm->dataSelect($str_sizeheightgroup);
				
			$size=$rslt_sizeheightgroup[0]['size'];
			$height=$rslt_sizeheightgroup[0]['height'];
			$isoGroup=$rslt_sizeheightgroup[0]['isogroup'];
					
			if($count>0)
			{
				//last update not in update
				$str_pgkey="SELECT gkey AS rtnValue FROM ctmsmis.mis_exp_unit WHERE vvd_gkey='$vvd_gkey' AND cont_id='$container' and snx_type=0";
					
				$presentGky=$this->bm->dataReturn($str_pgkey);  //$presentGky from excel file
				$str_update = "";
				if($presentGky!=$gkey)
				{
					$str_update="UPDATE ctmsmis.mis_exp_unit SET gkey='$gkey',cont_id='$container',isoType='$iso',cont_size='$size',cont_height='$height',isoGroup='$isoGroup',cont_status='$cont_status',cont_mlo='$mlo',vvd_gkey='$vvd_gkey',rotation='$rotation',stowage_pos='$stowage',user_id='$updateby',seal_no='$seal_no',goods_and_ctr_wt_kg='$weight',pod='$pod',truck_no='$truck_no',re_status=1,craine_id='$craine_id',last_update=NOW(),updated_in_n4=1,coming_from='$coming_from',shift='$shift',date='$date' WHERE cont_id='$container' AND vvd_gkey='$vvd_gkey' and snx_type=0";
				}
				else
				{
					$str_update="UPDATE ctmsmis.mis_exp_unit SET gkey='$gkey',cont_id='$container',isoType='$iso',cont_size='$size',cont_height='$height',isoGroup='$isoGroup',cont_status='$cont_status',cont_mlo='$mlo',vvd_gkey='$vvd_gkey',rotation='$rotation',stowage_pos='$stowage',user_id='$updateby',seal_no='$seal_no',goods_and_ctr_wt_kg='$weight',pod='$pod',truck_no='$truck_no',re_status=1,craine_id='$craine_id',updated_in_n4=1,coming_from='$coming_from',shift='$shift',date='$date' WHERE cont_id='$container' AND vvd_gkey='$vvd_gkey' and snx_type=0";
				}
					
				$yes=$this->bm->dataUpdatedb2($str_update); //dataUpdatedb2 for DB2
			}
			else
			{
				$str_insert="INSERT INTO ctmsmis.mis_exp_unit(gkey,cont_id,cont_status,cont_mlo,isoType,cont_size,cont_height,isoGroup,vvd_gkey,rotation,stowage_pos,last_update,updated_in_n4,user_id,seal_no,goods_and_ctr_wt_kg,pod,truck_no,re_status,craine_id,coming_from,shift,date) 
				VALUES ('$gkey','$container','$cont_status','$mlo','$iso','$size','$height','$isoGroup','$vvd_gkey','$rotation','$stowage',now(),1,'$updateby','$seal_no','$weight','$pod','$truck_no',1,'$craine_id','$coming_from','$shift','$date')";
					
				$yes=$this->bm->dataInsert($str_insert); //dataInsert for DB2
			}

			if($yes==1)
				$stat = $stat+1;					
			else
				$stat = $stat;	
		
			$row=$row+1;
		}  
			//echo "row : ".$row;
		if($stat>0)
			$data['msg'] ="Successful";
		else
			$data['msg'] ="Failed";	
		
		$data['title']="UPLOAD EXCEL FILE FROM ADMIN PANEL...";
		$this->load->view('header2');
		$this->load->view('myExportExcelUploadFormForAdmin',$data);
		$this->load->view('footer');
	}
	
	//-------------Export Excel Upload for admin end---------------
	
	
	
		function equipmentHandlingDemandForm()
		{	
                    $session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
					if($this->input->post('delete'))
						{
							$eid=$this->input->post('eid');
							$deleteSql="DELETE FROM ctmsmis.mis_equip_demand WHERE ctmsmis.mis_equip_demand.id='$eid'";
							$deleteStat=$this->bm->dataDelete($deleteSql);
						}
					$rslt_sql="SELECT id, yard, equip_type, equip_demand, demand_by FROM ctmsmis.mis_equip_demand";
					$result=$this->bm->dataSelect($rslt_sql);			
					$data['result']=$result;
					$data['editFlag']=0;
					$msg="";
					$data['title']="Equipment Demand Form...";
					$this->load->view('header2');
					$this->load->view('equipmentHandlingDemandForm',$data);
					$this->load->view('footer');
				}
		}
		
		function equipmentHandlingDemandFormPerform()
		{
                    $session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$login_id = $this->session->userdata('login_id');
				$yard=$this->input->post('yard');
				$equipment=$this->input->post('equipment');
				$demand=$this->input->post('demand');
				$ipaddr = $_SERVER['REMOTE_ADDR'];
				if($this->input->post('update'))
				  {
					$equipID=$this->input->post('eqiID');
//                            echo $equipID;
//                            return;
					$updateSql="UPDATE ctmsmis.mis_equip_demand set yard ='$yard', equip_type='$equipment', equip_demand='$demand',
								demand_by='$login_id',  demand_date=now(), ip_address='$ipaddr' where ctmsmis.mis_equip_demand.id='$equipID'";
					$updateStat=$this->bm->dataUpdate($updateSql);
					if($updateStat==1)
					   $msg="<font color='green'><b>Succesfully Updated</b></font>";
					else
					   $msg="<font color='red'><b>Updation failed. $equipment demand in $yard yard already assigned. Please Edit!</b></font>";

				   }
				 else{

					$insert_sql="INSERT INTO ctmsmis.mis_equip_demand(yard, equip_type, equip_demand, demand_by, demand_date, ip_address)
						VALUES('$yard','$equipment','$demand', '$login_id', NOW(), '$ipaddr')";


					$insert_stat=$this->bm->dataInsert($insert_sql);

					if($insert_stat==1)
						$msg="<font color='green'><b>Succesfully inserted</b></font>";
					else
						$msg="<font color='red'><b>$equipment demand in $yard yard already assigned. Please Edit! </b></font>";
					 }   
						//$msg="";
					$rslt_sql="SELECT id, yard, equip_type, equip_demand, demand_by FROM ctmsmis.mis_equip_demand";
					$result=$this->bm->dataSelect($rslt_sql);			
					$data['result']=$result;

					$data['msg']=$msg;
					$data['editFlag']=0;
					$data['title']="Equipment Demand Form...";
					$this->load->view('header2');
					$this->load->view('equipmentHandlingDemandForm',$data);
					$this->load->view('footer');
			}

		}
                
     function equipmentHandlingDemandFormEdit()
	{
            $session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
               
               $eqiID= $this->input->post('eqiID');
                
                $select_sql="SELECT id, yard, equip_type, equip_demand, demand_by FROM ctmsmis.mis_equip_demand
                        where mis_equip_demand.id='$eqiID'";
                
           //    echo $select_sql;
//                return;
                $select_result=$this->bm->dataSelect($select_sql);			
                $data['select_result']=$select_result;
                
                $rslt_sql="SELECT id, yard, equip_type, equip_demand, demand_by FROM ctmsmis.mis_equip_demand";
                $result=$this->bm->dataSelect($rslt_sql);			
                $data['result']=$result;

                $data['editFlag']=1;
                $msg="";
                $data['title']="Equipment Assign Entry Form";
                $data['msg']=$msg;
                $this->load->view('header2');
                $this->load->view('equipmentHandlingDemandForm',$data);
                $this->load->view('footer');
            }
	}
	
	//TODAY'S EDI DECLARATION - start
	function todays_edi_declaration()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			$sql_edi_list="SELECT id,file_name_edi,file_name_stow
						FROM edi_stow_info
						WHERE file_status='0'";
						
			$rslt_edi_list=$this->bm->dataSelectDb1($sql_edi_list);
			
			$data['rslt_edi_list']=$rslt_edi_list;
			$data['title']="TODAY'S EDI DECLARATION...";
			
			$this->load->view('header2');
			$this->load->view('todays_edi_declaration',$data);
			$this->load->view('footer'); 
		}
	}
	
	function update_edi_status()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			$edi_id = $this->uri->segment(3);
			
			$strUpdate = "UPDATE edi_stow_info
			SET file_status='1',file_download_by='$login_id'
			WHERE id='$edi_id'";
			
			$this->bm->dataUpdateDB1($strUpdate);
			
			$sql_edi_list="SELECT id,file_name_edi,file_name_stow
						FROM edi_stow_info
						WHERE file_status='0'";
						
			$rslt_edi_list=$this->bm->dataSelectDb1($sql_edi_list);
			
			$data['rslt_edi_list']=$rslt_edi_list;
			
			$data['title']="TODAY'S EDI DECLARATION...";
			
			$this->load->view('header2');
			$this->load->view('todays_edi_declaration',$data);
			$this->load->view('footer');
		}
	}
	
	function show_edi_declaration()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{			
			$edi_id = $this->uri->segment(3);
			$sql_edi_list="SELECT Import_Rotation_No,Vessel_Name,Name_of_Master,Voy_No,VoyNoExp,grt,nrt,imo,loa_cm,flag,radio_call_sign,beam_cm,
			Organization_Name AS agent_name			
			FROM igm_masters 
			LEFT JOIN organization_profiles ON  organization_profiles.id = igm_masters.Submitee_Org_Id
			WHERE igm_masters.id = (SELECT igm_masters_id FROM edi_stow_info WHERE id='$edi_id')";
						
			$rslt_edi_list=$this->bm->dataSelectDb1($sql_edi_list);
			
			$data['rslt_edi_list']=$rslt_edi_list;
			
			$data['title']="TODAY'S EDI DECLARATION...";
			
			//$this->load->view('header2');
			$this->load->view('todays_edi_declaration_list',$data);
			//$this->load->view('footer');
		}
	}
	//TODAY'S EDI DECLARATION - end
	
	
	  function last24hrPerformancePdfForm()
        {
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                $this->logout();
            }
            
            else {
                $data['title']="LAST 24 HR PERFORMANCE PDF FILE UPLOAD FORM ";
                $data['msg']="";
                $this->load->view('header2');
                $this->load->view('last24hrPerformancePdfForm',$data);
                $this->load->view('footer');
                    
            }
        }
        
        function last24hrPerformancePdfUpload()
        {
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                $this->logout();
            }
            
            else {
       		$perform_date = $this->input->post('perform_date');
                $ipaddr = $_SERVER['REMOTE_ADDR'];
				error_reporting(E_ALL ^ E_NOTICE);   
    
             //   $fi=$cont.".jpg";
                $pDate=str_replace('-','',$perform_date);
				$m_file=$pDate."_manual.pdf";
				$c_file=$pDate."_ctms.pdf";

				
			$manual_file=$_POST["manual_file"];
			$ctms_file=$_POST["ctms_file"];
			//$filetype=$_POST["manualReportDate"];
				
			if ($_FILES["manual_file"]["error"] > 0 and $_FILES["ctms_file"]["error"] > 0)
			{
					$data['msg']="<font color='red' size=4>Here is Problem!! To upload this file. Please! Check Again, That file is not Corrupted and ensure correct format</font>";
			}
			else
			{
                move_uploaded_file($_FILES["manual_file"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/manual_files/".$_FILES["manual_file"]["name"]);			
                rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/manual_files/".$_FILES["manual_file"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/manual_files/".$m_file);
				
				 move_uploaded_file($_FILES["ctms_file"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/ctms_files/".$_FILES["ctms_file"]["name"]);			
                rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/ctms_files/".$_FILES["ctms_file"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/ctms_files/".$c_file);

                $insertStr="INSERT INTO ctmsmis.performance_file_upload (date, manual_file_path, ctms_file_path, ip_adddress, login_id, upload_time) VALUES
                             ('$perform_date','$m_file','$c_file','$ipaddr','$login_id',now())";
							 
				// echo $insertStr;
				// return;	 
                $stat =  $this->bm->dataInsert($insertStr);
                
                if($stat==1)
                {
                $data['msg']="<font color='green' size='3'>PDF file uploaded Successfully for <b>".$perform_date."</b></font>";
                }
                else{
                $data['msg']="<font color='red' size='3'>Not Uploaded</font>";
                }
                
                }

                $data['title']="LAST 24 HR PERFORMANCE PDF FILE UPLOAD FORM ";
                $this->load->view('header2');
                $this->load->view('last24hrPerformancePdfForm',$data);
                $this->load->view('footer');
                    
            }
        }
	
	
	
	function Offdock($login_id)
	{
		$offdoc ="";
		if($login_id=='gclt')
		{
			$offdoc = "3328";
		}
		elseif($login_id=='saple')
		{
			$offdoc = "3450";
		}
		elseif($login_id=='saplw')
		{
			$offdoc = "2603";
		}
		elseif($login_id=='ebil')
		{
			$offdoc = "2594";
		}
		elseif($login_id=='cctcl')
		{
			$offdoc = "2595";
		}
		elseif($login_id=='ktlt')
		{
			$offdoc = "2596";
		}
		elseif($login_id=='qnsc')
		{
			$offdoc = "2597";
		}
		elseif($login_id=='ocl')
		{
			$offdoc = "2598";
		}
		elseif($login_id=='vlsl')
		{
			$offdoc = "2599";
		}
		elseif($login_id=='shml')
		{
			$offdoc = "2600";
		}
		elseif($login_id=='iqen')
		{
			$offdoc = "2601";
		}
		elseif($login_id=='iltd')
		{
			$offdoc = "2620";
		}
		elseif($login_id=='plcl')
		{
			$offdoc = "2643";
		}
		elseif($login_id=='shpm')
		{
			$offdoc = "2646";
		}
		elseif($login_id=='hsat')
		{
			$offdoc = "3697";
		}
		elseif($login_id=='ellt')
		{
			$offdoc = "3709";
		}
		elseif($login_id=='bmcd')
		{
			$offdoc = "3725";
		}
		elseif($login_id=='nclt')
		{
			$offdoc = "4013";
		}
		elseif($login_id=='kdsl')
		{
			$offdoc = "2624";
		}		
		else
		{
			$offdoc = "";
		}
		return $offdoc;
	}
}
	
?>