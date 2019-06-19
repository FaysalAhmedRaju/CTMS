
<script language="JavaScript">
$(document).on('keypress', 'input,select', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        var $next = $('[tabIndex=' + (+this.tabIndex + 1) + ']');
        console.log($next.length);
        if (!$next.length) {
            //$next = $('[tabIndex=1]');
			form.submit();
        }
		else
        $next.focus();
    }
});
/*$('body').on('keydown', 'input, select, textarea', function(e) {
		var self = $(this)
		  , form = self.parents('form:eq(0)')
		  , focusable
		  , next
		  ;
		if (e.keyCode == 13) {
			focusable = form.find('input,select,button,textarea,submit').filter(':visible');
			next = focusable.eq(focusable.index(this)+1);
			if (next.length) {
				//next.style.backgroundColor = "red";
				next.focus();			
			} else {
				form.submit();
			}
			return false;
		}
	});*/
/*function changeToRPC(e)
{
	if (e.keyCode == 13) {
		document.getElementById('rpc').focus();
	}
}
function changeToHC(e)
{
	if (e.keyCode == 13) {
		document.getElementById('hc_charge').focus();
	}
}
function changeToScale(e)
{
	if (e.keyCode == 13) {
		document.getElementById('scale_charge').focus();
	}
}
function changeToVat(e)
{
	if (e.keyCode == 13) {
		document.getElementById('vat').focus();
	}
}
function changeToMlwf(e)
{
	if (e.keyCode == 13) {
		document.getElementById('mlwf').focus();
	}
}*/
function validate()
      {
		  var tableData = document.getElementById('mytbl');
          var numberOfRows = tableData.rows.length;
		  //alert(numberOfRows);
		  if( document.myChkForm.verify_num.value =="")
         {
            alert( "Please provide VERIFY Number!" );
            document.myChkForm.verify_num.focus() ;
            return false;
         }
		  else if( numberOfRows <= 2 )
         {
            alert( "TABLE CANNOT BE EMPTY!" );
			 document.myChkForm.scale_charge.focus() ;
            //document.myChkForm.cnfName.focus() ;
            return false;
         }
	
		if (confirm("Do you want to Save Bill Information?") == true) {
		   return true ;
		} else {
			return false;
		}
			 
      }
  
 function sendDetailsToControllerAction() {
            var tableData = document.getElementById('mytbl');
            var numberOfRows = tableData.rows.length;
            for (var i = 1; i < numberOfRows; i += 1) {
                var objCells = tableData.rows.item(i).cells;
				//var objCells = myTab.rows.item(i).cells;

            // LOOP THROUGH EACH CELL OF THE CURENT ROW TO READ CELL VALUES.
				for (var j = 0; j < objCells.length; j++) {
					//info.innerHTML = info.innerHTML + ' ' + objCells.item(j).innerHTML;
					console.log(objCells.item(j).innerHTML);
				}
				//console.log(row.cells[1].innerText);
            }
        }

function getCnfCode(e,val) 
{	
	//alert(val);		
	 if (e.keyCode == 13) {
		if (window.XMLHttpRequest) 
		{
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=stateChangeValue;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/getCnfCode')?>?cnf_lic_no="+val,false);
		xmlhttp.send();
	 }
}

function stateChangeValue()
{
	//alert("ddfd");
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
			  
		var val = xmlhttp.responseText;
		var jsonData = JSON.parse(val);
		
		var cnfCodeTxt=document.getElementById("cnfName");
	
		for (var i = 0; i < jsonData.length; i++) 
		{
			
			cnfCodeTxt.value=jsonData[i].name;
			
		}
    }
}

	/****************Working with Enter Key Event********************/
	function getBillData(val) {
    //if (e.keyCode == 13) {
			//alert(val);
			//document.getElementById("").style.display="inline";
			//document.getElementById("loadingImg").style.display="inline";
			var chkVerifyNum=chkExist(val); //Check Verify Number Exist In Shed Bill Master
			//alert(chkVerifyNum);
			var vatInfo = document.getElementById('vat').value;
			var mlwf = document.getElementById('mlwf').value;
			if(chkVerifyNum=="2")
			{
				alert("Bill Already Generated.");
				//document.myChkForm.verify_num.focus();
				document.myChkForm.bill_for.focus();
				document.getElementById('save_btn').style.visibility = 'hidden';
				document.getElementById("loadingImg").style.display="none";
				/*document.getElementById("loadingImg").style.display="inline";
				if (window.XMLHttpRequest) 
				{
					xmlhttp=new XMLHttpRequest();
				} 
				else 
				{  
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=stateChangeFromShedBill;
				xmlhttp.open("GET","<?php echo site_url('ajaxController/getDataFromShedBill')?>?verify_num="+val,false);
				xmlhttp.send();*/
			}
			else if(chkVerifyNum=="1"){
			var unstfDt="";
			//alert(unstfDt);
				//alert("Not Exist");
			if (window.XMLHttpRequest) 
				{
					document.getElementById("loadingImg").style.display="inline";
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				} 
				else 
				{  
					// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=stateChangeBillValue;
				xmlhttp.open("GET","<?php echo site_url('ajaxController/getBillDetails')?>?verify_num="+val+"&unstfDt="+unstfDt+"&vatInfo="+vatInfo+"&mlwf="+mlwf,false);
				xmlhttp.send();
    }
	else
	{
		alert("Verification Number is Invalid.");
		//document.myChkForm.verify_num.focus();
		document.myChkForm.bill_for.focus();
		document.getElementById('save_btn').style.visibility = 'hidden';
		document.getElementById("loadingImg").style.display="none";
	}
	//}
}
function stateChangeFromShedBill()
{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
		//document.myChkForm.scale_charge.focus() ;
		var val = xmlhttp.responseText;
		
		//alert(val);
		var jsonData = JSON.parse(val);
		console.log("hdfgd : "+jsonData.dataExist);
		console.log("length : "+jsonData.shedBillMasterList.length);
		
		
		if(jsonData.dataExist<1)
		{
			alert("Verification Number Not Valid.");
			document.getElementById("loadingImg").style.display="none";
			document.getElementById('verify_num').focus();
		}
		else{
		document.getElementById("loadingImg").style.display="inline";
		
		var bill_no=document.getElementById("bill_no");
		var one_stop_point=document.getElementById("one_stop_point");
		var rotation_no=document.getElementById("rotation_no");
		var arr_dt=document.getElementById("arr_dt");
		var comm_dt=document.getElementById("comm_dt");
		var wr_dt=document.getElementById("wr_dt");
		var ado_no=document.getElementById("ado_no");
		var ado_dt=document.getElementById("ado_dt");
		var ado_upto=document.getElementById("ado_upto");
		var ex_rate=document.getElementById("ex_rate");
		var bill_for=document.getElementById("bill_for");
		var unstfDt=document.getElementById("unstfDt");
		var wr_upto_dt=document.getElementById("wr_upto_dt");
		var be_no=document.getElementById("be_no");
		var be_dt=document.getElementById("be_dt");
		var less=document.getElementById("less");
		var part_bl=document.getElementById("part_bl");
		
		/**********Container Data*****************/
		var twnty_gen_eight_five=document.getElementById("twnty_gen_eight_five");
		var twnty_gen_nine_five=document.getElementById("twnty_gen_nine_five");
		var twnty_open_eight_five=document.getElementById("twnty_open_eight_five");
		var twnty_open_nine_five=document.getElementById("twnty_open_nine_five");
		var twnty_flat_eight_five=document.getElementById("twnty_flat_eight_five");
		var twnty_flat_nine_five=document.getElementById("twnty_flat_nine_five");
		
		var forty_gen_eight_five=document.getElementById("forty_gen_eight_five");
		var forty_gen_nine_five=document.getElementById("forty_gen_nine_five");
		var forty_open_eight_five=document.getElementById("forty_open_eight_five");
		var forty_open_nine_five=document.getElementById("forty_open_nine_five");
		var forty_flat_eight_five=document.getElementById("forty_flat_eight_five");
		var forty_flat_nine_five=document.getElementById("forty_flat_nine_five");
		
		var forty_five_gen_eight_five=document.getElementById("forty_five_gen_eight_five");
		var forty_five_gen_nine_five=document.getElementById("forty_five_gen_nine_five");
		var forty_five_open_eight_five=document.getElementById("forty_five_open_eight_five");
		var forty_five_open_nine_five=document.getElementById("forty_five_open_nine_five");
		var forty_five_flat_eight_five=document.getElementById("forty_five_flat_eight_five");
		var forty_five_flat_nine_five=document.getElementById("forty_five_flat_nine_five");
		
		var total_port=document.getElementById("total_port");
		var total_vat=document.getElementById("total_vat");
		var total_mlwf=document.getElementById("total_mlwf");
		var grand_total=document.getElementById("grand_total");
		
		
		
		
		/***********Container Data****************/
		var cont_qty=document.getElementById("cont_qty");
		var cont_wht=document.getElementById("cont_wht");
		
		var qty_in_shed=document.getElementById("qty_in_shed");
		var wht_in_shed=document.getElementById("wht_in_shed");
		var qty_lock=document.getElementById("qty_lock");
		var wht_lock=document.getElementById("wht_lock");
		var qty_out_shed=document.getElementById("qty_out_shed");
		var wht_out_shed=document.getElementById("wht_out_shed");
		var cnfCode=document.getElementById("cnfCode");
		var cnfName=document.getElementById("cnfName");
		var importerCode=document.getElementById("impo_reg_no");
		var importerName=document.getElementById("impo_reg_name");
		var rpc=document.getElementById("rpc");
		var hc_charge=document.getElementById("hc_charge");
		var scale_charge=document.getElementById("scale_charge");
		var ext_mov_twnty=document.getElementById("ext_mov_twnty");
		var ext_mov_forty=document.getElementById("ext_mov_forty");
		
		var total_port=document.getElementById("total_port");
		var total_vat=document.getElementById("total_vat");
		var total_mlwf=document.getElementById("total_mlwf");
		
		
		for (var i = 0; i < jsonData.shedBillMasterList.length; i++) 
		{
			if(jsonData.shedBillMasterList[i].cont_type.search("general") != -1 )
			{
				// CONTAINER SIZE
				if(jsonData.shedBillMasterList[i].cont_size.search("20") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.shedBillMasterList[i].cont_height.search("8") != -1)
					{
						twnty_gen_eight_five.value="1";
					}
					else if(jsonData.shedBillMasterList[i].cont_height.search("9") != -1)
					{
						twnty_gen_nine_five.value="1";
					}
				}
				else if(jsonData.shedBillMasterList[i].cont_size.search("40") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.shedBillMasterList[i].cont_height.search("8") != -1)
					{
						forty_gen_eight_five.value="1";
					}
					else if(jsonData.shedBillMasterList[i].cont_height.search("9") != -1)
					{
						forty_gen_nine_five.value="1";
					}
				}
				else if(jsonData.shedBillMasterList[i].cont_size.search("45") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.shedBillMasterList[i].cont_height.search("8") != -1)
					{
						forty_five_gen_eight_five.value="1";
					}
					else if(jsonData.shedBillMasterList[i].cont_height.search("9") != -1)
					{
						forty_five_gen_nine_five.value="1";
					}
				}
				
				
				//alert("Match : "+jsonData.rtnBillList[i].cont_type);
			}
			else if (jsonData.shedBillMasterList[i].cont_type.search("flatrack") != -1 ){
				
				// CONTAINER SIZE
				if(jsonData.shedBillMasterList[i].cont_size.search("20") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.shedBillMasterList[i].cont_height.search("8") != -1)
					{
						twnty_flat_eight_five.value="1";
						//ext_mov_twnty.value=jsonData.appraisalData[0].extra_movement;
					}
					else if(jsonData.shedBillMasterList[i].cont_height.search("9") != -1)
					{
						twnty_flat_nine_five.value="1";
						//ext_mov_twnty.value=jsonData.appraisalData[0].extra_movement;
					}
				}
				else if(jsonData.shedBillMasterList[i].cont_size.search("40") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.shedBillMasterList[i].cont_height.search("8") != -1)
					{
						forty_flat_eight_five.value="1";
						//ext_mov_forty.value=jsonData.appraisalData[0].extra_movement;
					}
					else if(jsonData.shedBillMasterList[i].cont_height.search("9") != -1)
					{
						forty_flat_nine_five.value="1";
						//ext_mov_forty.value=jsonData.appraisalData[0].extra_movement;
					}
				}
				else if(jsonData.shedBillMasterList[i].cont_size.search("45") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.shedBillMasterList[i].cont_height.search("8") != -1)
					{
						forty_five_flat_eight_five.value="1";
					}
					else if(jsonData.shedBillMasterList[i].cont_height.search("9") != -1)
					{
						forty_five_flat_nine_five.value="1";
					}
				}
			}
			else if (jsonData.shedBillMasterList[i].cont_type.search("open") != -1 )
			{
				if(jsonData.shedBillMasterList[i].cont_size.search("20") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.shedBillMasterList[i].cont_height.search("8") != -1)
					{
						twnty_open_eight_five.value="1";
					}
					else if(jsonData.shedBillMasterList[i].cont_height.search("9") != -1)
					{
						twnty_open_nine_five.value="1";
					}
				}
				else if(jsonData.shedBillMasterList[i].cont_size.search("40") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.shedBillMasterList[i].cont_height.search("8") != -1)
					{
						forty_open_eight_five.value="1";
					}
					else if(jsonData.shedBillMasterList[i].cont_height.search("9") != -1)
					{
						forty_open_nine_five.value="1";
					}
				}
				else if(jsonData.shedBillMasterList[i].cont_size.search("45") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.shedBillMasterList[i].cont_height.search("8") != -1)
					{
						forty_five_open_eight_five.value="1";
					}
					else if(jsonData.shedBillMasterList[i].cont_height.search("9") != -1)
					{
						forty_five_open_nine_five.value="1";
					}
				}
			}
			
			bill_no.value=jsonData.shedBillMasterList[i].bill_no;
			one_stop_point.value=jsonData.shedBillMasterList[i].unit_no;
			rotation_no.value=jsonData.shedBillMasterList[i].import_rotation;
			arr_dt.value=jsonData.shedBillMasterList[i].arraival_date;
			comm_dt.value=jsonData.shedBillMasterList[i].cl_date;
			wr_dt.value=jsonData.shedBillMasterList[i].wr_date;
			ado_no.value=jsonData.shedBillMasterList[i].ado_no;
			ado_dt.value=jsonData.shedBillMasterList[i].ado_date;
			ado_upto.value=jsonData.shedBillMasterList[i].ado_valid_upto;
			ex_rate.value=jsonData.shedBillMasterList[i].ex_rate;
			bill_for.value=jsonData.shedBillMasterList[i].bill_for;
			unstfDt.value=jsonData.shedBillMasterList[i].wr_date;
			//wr_upto_dt.value=jsonData.shedBillMasterList[i].wr_upto_date;
			wr_upto_dt.value=jsonData.shedBillMasterList[i].valid_up_to_date;
			
			be_no.value=jsonData.shedBillMasterList[i].be_no;
			be_dt.value=jsonData.shedBillMasterList[i].be_date;
			less.value=jsonData.shedBillMasterList[i].less;
			part_bl.value=jsonData.shedBillMasterList[i].part_bl;
			cont_qty.value=jsonData.shedBillMasterList[i].manifest_qty;
			cont_wht.value=jsonData.shedBillMasterList[i].cont_weight;
			qty_in_shed.value=jsonData.shedBillMasterList[i].rcv_pack;
			qty_lock.value=jsonData.shedBillMasterList[i].loc_first;
			cnfCode.value=jsonData.shedBillMasterList[i].cnf_lic_no;
			cnfName.value=jsonData.shedBillMasterList[i].cnf_agent;		
				
			importerCode.value=jsonData.shedBillMasterList[i].importer_vat_reg_no;
			importerName.value=jsonData.shedBillMasterList[i].importer_name;
			
			vessel_name.value=jsonData.shedBillMasterList[i].Vessel_Name;
			bl_no.value=jsonData.shedBillMasterList[i].BL_No;
			container_size.value=jsonData.shedBillMasterList[i].cont_size;
			container_height.value=jsonData.shedBillMasterList[i].cont_height;
			//sendVerifyNo.value=jsonData.shedBillMasterList[i].verify_no;
			
			total_port.value=jsonData.shedBillMasterList[i].total_port;
			total_vat.value=jsonData.shedBillMasterList[i].total_vat;
			total_mlwf.value=jsonData.shedBillMasterList[i].total_mlwf;
			grand_total.value=jsonData.shedBillMasterList[i].grand_total;
			
			if(jsonData.shedBillMasterList[i].cont_size.search("20") != -1)
						{
							ext_mov_twnty.value=jsonData.shedBillMasterList[i].extra_movement;
						}
						else{
							ext_mov_forty.value=jsonData.shedBillMasterList[i].extra_movement;
						}
		//var  table = document.getElementById("mytbl");
	
		var  table = document.getElementById("mytbl");
		document.getElementById("tbl_total_row").value=table.rows.length;
		var  hc_charge = document.getElementById('hc_charge').value;
		var  rpc_charge = document.getElementById('rpc').value;
		var  scale_charge = document.getElementById('scale_charge').value;
		var portSum=0;
		var vatSum=0;
		var mlwfSum=0;
		removeTableElement(table);
		//alert(jsonData.shedBillDetailList.length);
		for (var k = 0; k < jsonData.shedBillDetailList.length; k++) 
				{
					var tr = document.createElement('tr'); 
					   tr.className ="gridDark";
					   
					   var td1 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "tarrif_id" + k;
					   input.value=jsonData.shedBillDetailList[k].tarrif_id;
					   input.style.width = "300px";
					   td1.appendChild(input);
					   
					   var td2 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "billHead" + k;
					   input.value=jsonData.shedBillDetailList[k].description;
					   input.style.width = "100px";
					   td2.appendChild(input);
					   
					   var td3 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "option" + k;
					   input.value=jsonData.shedBillDetailList[k].gl_code;
					   input.style.width = "50px";
					   td3.appendChild(input);
					   
					   var td4 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "rate" + k;
					   input.value=jsonData.shedBillDetailList[k].tarrif_rate;
					   input.style.width = "40px";
					   td4.appendChild(input);
					   
					   
					   
					   var td5 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "qty" + k;					 
					   input.value=jsonData.shedBillDetailList[k].Qty;
					   input.style.width = "20px";
					   td5.appendChild(input);
					   
					    var td6 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "qday" + k;
					   input.value=jsonData.shedBillDetailList[k].qday;
					   input.style.width = "20px";
					   td6.appendChild(input);
					   
					    var td7 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "weight" + k;
					   input.value=jsonData.shedBillMasterList[0].cont_weight;
					   input.style.width = "40px";
					   td7.appendChild(input);
					   
					   var td8 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "mlwf"+k;
					   input.id = "mlwfAmount" + k;
					   input.value="0";
					   input.style.width = "40px";
					   td8.appendChild(input);
					   
					   var td9 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "vatTK"+k;
					   input.id = "vatAmount"+k;
					   input.value=jsonData.shedBillDetailList[k].vatTK;
					   input.style.width = "40px";
					   td9.appendChild(input);
					   
					   var td10 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "amt"+k;
					   input.id = "portAmount"+k;
					   input.value=jsonData.shedBillDetailList[k].amt;
					   input.style.width = "40px";
					   td10.appendChild(input);
					   
					    var td11 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "button";
					   input.style.background="#CCAEDE";
					   input.name = "btn";
					   input.onclick=function(event){deleteRow(this)};
					   input.value="DELETE";
					   input.style.width = "40px";
					   td11.appendChild(input);
					   
					   tr.appendChild(td1);
					   tr.appendChild(td2);
					   tr.appendChild(td3);
					   tr.appendChild(td4);
					   tr.appendChild(td5);
					   tr.appendChild(td6);
					   tr.appendChild(td7);
					   tr.appendChild(td8);
					   tr.appendChild(td9);
					   tr.appendChild(td10);
					   tr.appendChild(td11);
					
					   table.appendChild(tr);
					   //var amount="amt"+k;
					  portSum += parseFloat(document.getElementById("portAmount"+k).value); 
					  vatSum += parseFloat(document.getElementById("vatAmount"+k).value); 
					  mlwfSum += parseFloat(document.getElementById("mlwfAmount"+k).value); 
					
				}
				document.getElementById("total_port").value=portSum.toFixed(2);
				document.getElementById("total_vat").value=vatSum.toFixed(2);
				document.getElementById("total_mlwf").value=mlwfSum.toFixed(2);
		
				document.getElementById("grand_total").value= (portSum + vatSum + mlwfSum).toFixed(2);
				document.getElementById("tbl_total_row").value=table.rows.length-2;
				wht_in_shed.value= (cont_wht.value/cont_qty.value)*qty_in_shed.value;
				wht_lock.value= (cont_wht.value/cont_qty.value)*qty_lock.value;
				//document.myChkForm.scale_charge.focus() ;
		}
		//getGrossTotal();
		document.getElementById("loadingImg").style.display="none";
		document.getElementById('wr_upto_dt').focus();
	}
	}
}
function chkExist(val)
{
	//alert(val);
	if (window.XMLHttpRequest) 
				{
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				} 
				else 
				{  
					// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=stateCheckVerifyNum;
				xmlhttp.open("GET","<?php echo site_url('ajaxController/checkVerifyNumberExist')?>?verify_num="+val,false);
				xmlhttp.send();	
				return xmlhttp.onreadystatechange();
				//alert(xmlhttp.onreadystatechange);
}
function stateCheckVerifyNum(){
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
 {
		//alert(xmlhttp.responseText);			  
		var val = xmlhttp.responseText;
		
		
		var jsonData = JSON.parse(val);
		//console.log(jsonData);
		var chkData=jsonData.rtnChkList;
		//alert(chkData);
		if(chkData=="0")
		{
			return "0";
		}
		else if(chkData=="1")
		{
			return "1";
		}
		else{
			return "2";
		}
 }
}
function addRow(val) {
		//$("#mytbl").append("<tr><td><input type='text' value='"+val+"'></td></tr>");		
		if (window.XMLHttpRequest) 
		{
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=stateChangeBillInformation;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/getBillInfo')?>?tarrif_id="+val,false);
		xmlhttp.send();
				
}
function stateChangeBillInformation()
{
	//alert("ddfd");
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
		//alert(xmlhttp.responseText);			  
		var val = xmlhttp.responseText;
		var jsonData = JSON.parse(val);
		
		document.getElementById("tarrif_id_tbl").value=jsonData.getBillInfo[0].tarrif_id;
		document.getElementById("bill_head_tbl").value=jsonData.getBillInfo[0].description;
		document.getElementById("option_tbl").value=jsonData.getBillInfo[0].gl_code;
		document.getElementById("rate_tbl").value=jsonData.getBillInfo[0].tarrif_rate;
		document.getElementById("qty_tbl").value="";
		document.getElementById("days_tbl").value="";
		document.getElementById("wt_tbl").value="";
		document.getElementById("mlwf_tbl").value="";
		document.getElementById("vat_tbl").value="";
		document.getElementById("port_tbl").value="";
		
		//addAfterTotal();
    }
}
function addTableRow()
{
					var  table = document.getElementById("mytbl");
					var tr = document.createElement('tr'); 
					   tr.className ="gridDark";
					   
					   var td1 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "tarrif_id" + table.rows.length;
					   input.id = "tarrif_id" + table.rows.length;
					   input.value=document.getElementById("tarrif_id_tbl").value;
					   input.style.width = "300px";
					   td1.appendChild(input);
					   
					   var td2 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "billHead"+ table.rows.length;
					   input.id = "billHead";
					   input.value=document.getElementById("bill_head_tbl").value;
					   input.style.width = "100px";
					   td2.appendChild(input);
					   
					   var td3 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "option"+ table.rows.length;
					   input.id = "option";
					   input.value=document.getElementById("option_tbl").value;
					   input.style.width = "50px";
					   td3.appendChild(input);
					   
					   var td4 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "rate"+ table.rows.length;
					   input.id = "rate";
					   input.value=document.getElementById("rate_tbl").value;
					   input.style.width = "40px";
					   td4.appendChild(input);
					   
					   
					   
					   var td5 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "qty"+ table.rows.length;
					   input.id = "qty";
					   input.value=document.getElementById("qty_tbl").value;
					   input.style.width = "20px";
					   td5.appendChild(input);
					   
					   var td6 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "qday"+ table.rows.length;
					   input.id = "qday";
					   input.value=document.getElementById("days_tbl").value;
					   //input.onkeypress=function(event){return getBillRowTotal(event,this.value,table.rows.length)};
					   input.style.width = "20px";
					   td6.appendChild(input);
					   
					    var td7 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "weight"+ table.rows.length;
					   input.id = "weight";
					   input.value=document.getElementById("wt_tbl").value;
					   input.style.width = "40px";
					   td7.appendChild(input);
					   
					   var td8 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "mlwf"+ table.rows.length;
					   input.id = "mlwf";
					   input.value=document.getElementById("mlwf_tbl").value;
					   input.style.width = "40px";
					   td8.appendChild(input);
					   
					   var td9 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "vatTK"+ table.rows.length;
					   input.id = "vatTK";
					   input.value=document.getElementById("vat_tbl").value;
					   input.style.width = "40px";
					   td9.appendChild(input);
					   
					   var td10 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "amt"+ table.rows.length;
					   input.id = "amt";
					   input.value=document.getElementById("port_tbl").value;
					   input.style.width = "40px";
					   td10.appendChild(input);
					   
					    var td11 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "button";
					   //input.name = "mlwf";
					   input.style.background="#CCAEDE";
					   //input.onclick=deleteRow(this);
					    input.onclick=function(event){deleteRow(this)};
					   input.value="DELETE";
					   input.style.width = "40px";
					   td11.appendChild(input);
					   
					   tr.appendChild(td1);
					   tr.appendChild(td2);
					   tr.appendChild(td3);
					   tr.appendChild(td4);
					   tr.appendChild(td5);
					   tr.appendChild(td6);
					   tr.appendChild(td7);
					   tr.appendChild(td8);
					   tr.appendChild(td9);
					   tr.appendChild(td10);
					   tr.appendChild(td11);
					  
					   table.appendChild(tr);
					   
	document.getElementById("total_port").value=parseFloat(document.getElementById("total_port").value) + parseFloat(document.getElementById("port_tbl").value);
	document.getElementById("total_vat").value=parseFloat(document.getElementById("total_vat").value) + parseFloat(document.getElementById("vat_tbl").value);
	document.getElementById("total_mlwf").value=parseFloat(document.getElementById("total_mlwf").value) + parseFloat(document.getElementById("mlwf_tbl").value);
	
	document.getElementById("grand_total").value=parseFloat(document.getElementById("total_port").value) + parseFloat(document.getElementById("total_vat").value) + parseFloat(document.getElementById("mlwf_tbl").value);
	
	var  table = document.getElementById("mytbl");
	document.getElementById("tbl_total_row").value=table.rows.length;
					   
}
function getBillRowTotal(e,val,rowLength) {
    if (e.keyCode == 13) {
		//var rate=document.getElementById("rate"+rowLength).value;
		//console.log(rate);
		alert("kk  "+rowLength);
		//document.getElementById("amt"+k).value=document.getElementById("rate"+k).value * document.getElementById("qty"+k).value * document.getElementById("qday"+k).value;
	}
}
function stateChangeBillValue(){
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
 {
	 //alert("OK");
		//alert(xmlhttp.responseText);			  
		
		var val = xmlhttp.responseText;
		
		//alert(val);
		console.log(val);
		var jsonData = JSON.parse(val);
		console.log(jsonData);
		if(jsonData.rtnBillList.length<1)
		{
			alert("Verification Number Not Valid.");
			document.getElementById("loadingImg").style.display="none";
			document.getElementById('verify_num').focus();
		}
		else{
		document.getElementById('save_btn').style.visibility = 'visible';
		var bill_no=document.getElementById("bill_no");
		var one_stop_point=document.getElementById("one_stop_point");
		var rotation_no=document.getElementById("rotation_no");
		var arr_dt=document.getElementById("arr_dt");
		var comm_dt=document.getElementById("comm_dt");
		var wr_dt=document.getElementById("wr_dt");
		var ado_no=document.getElementById("ado_no");
		var ado_dt=document.getElementById("ado_dt");
		var ado_upto=document.getElementById("ado_upto");
		var ex_rate=document.getElementById("ex_rate");
		var bill_for=document.getElementById("bill_for");
		var unstfDt=document.getElementById("unstfDt");
		var wr_upto_dt=document.getElementById("wr_upto_dt");
		var be_no=document.getElementById("be_no");
		var be_dt=document.getElementById("be_dt");
		var less=document.getElementById("less");
		var part_bl=document.getElementById("part_bl");
		//document.myChkForm.scale_charge.focus() ;
		/**********Container Data*****************/
		var twnty_gen_eight_five=document.getElementById("twnty_gen_eight_five");
		var twnty_gen_nine_five=document.getElementById("twnty_gen_nine_five");
		var twnty_open_eight_five=document.getElementById("twnty_open_eight_five");
		var twnty_open_nine_five=document.getElementById("twnty_open_nine_five");
		var twnty_flat_eight_five=document.getElementById("twnty_flat_eight_five");
		var twnty_flat_nine_five=document.getElementById("twnty_flat_nine_five");
		
		var forty_gen_eight_five=document.getElementById("forty_gen_eight_five");
		var forty_gen_nine_five=document.getElementById("forty_gen_nine_five");
		var forty_open_eight_five=document.getElementById("forty_open_eight_five");
		var forty_open_nine_five=document.getElementById("forty_open_nine_five");
		var forty_flat_eight_five=document.getElementById("forty_flat_eight_five");
		var forty_flat_nine_five=document.getElementById("forty_flat_nine_five");
		
		var forty_five_gen_eight_five=document.getElementById("forty_five_gen_eight_five");
		var forty_five_gen_nine_five=document.getElementById("forty_five_gen_nine_five");
		var forty_five_open_eight_five=document.getElementById("forty_five_open_eight_five");
		var forty_five_open_nine_five=document.getElementById("forty_five_open_nine_five");
		var forty_five_flat_eight_five=document.getElementById("forty_five_flat_eight_five");
		var forty_five_flat_nine_five=document.getElementById("forty_five_flat_nine_five");
		
		
		/***********Container Data****************/
		var cont_qty=document.getElementById("cont_qty");
		var cont_wht=document.getElementById("cont_wht");
		
		var qty_in_shed=document.getElementById("qty_in_shed");
		var wht_in_shed=document.getElementById("wht_in_shed");
		var qty_lock=document.getElementById("qty_lock");
		var wht_lock=document.getElementById("wht_lock");
		var qty_out_shed=document.getElementById("qty_out_shed");
		var wht_out_shed=document.getElementById("wht_out_shed");
		var cnfCode=document.getElementById("cnfCode");
		var cnfName=document.getElementById("cnfName");
		
		var importerCode=document.getElementById("impo_reg_no");
		var importerName=document.getElementById("impo_reg_name");
		
		var rpc=document.getElementById("rpc");
		var hc_charge=document.getElementById("hc_charge");
		var hc_rcv_unit_txt=document.getElementById("hc_rcv_unit");
		var hc_rcv_amount=document.getElementById("hc_rcv_amount");
		var scale_charge=document.getElementById("scale_charge");
		var ext_mov_twnty=document.getElementById("ext_mov_twnty");
		var ext_mov_forty=document.getElementById("ext_mov_forty");
		
		var total_port=document.getElementById("total_port");
		var total_vat=document.getElementById("total_vat");
		var total_mlwf=document.getElementById("total_mlwf");
		
		
		for (var i = 0; i < jsonData.rtnBillList.length; i++) 
		{
			if(jsonData.rtnBillList[i].cont_type.search("general") != -1 )
			{
				// CONTAINER SIZE
				if(jsonData.rtnBillList[i].cont_size.search("20") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.rtnBillList[i].cont_height.search("8") != -1)
					{
						twnty_gen_eight_five.value="1";
					}
					else if(jsonData.rtnBillList[i].cont_height.search("9") != -1)
					{
						twnty_gen_nine_five.value="1";
					}
				}
				else if(jsonData.rtnBillList[i].cont_size.search("40") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.rtnBillList[i].cont_height.search("8") != -1)
					{
						forty_gen_eight_five.value="1";
					}
					else if(jsonData.rtnBillList[i].cont_height.search("9") != -1)
					{
						forty_gen_nine_five.value="1";
					}
				}
				else if(jsonData.rtnBillList[i].cont_size.search("45") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.rtnBillList[i].cont_height.search("8") != -1)
					{
						forty_five_gen_eight_five.value="1";
					}
					else if(jsonData.rtnBillList[i].cont_height.search("9") != -1)
					{
						forty_five_gen_nine_five.value="1";
					}
				}
				
				
				//alert("Match : "+jsonData.rtnBillList[i].cont_type);
			}
			else if (jsonData.rtnBillList[i].cont_type.search("flatrack") != -1 ){
				
				// CONTAINER SIZE
				if(jsonData.rtnBillList[i].cont_size.search("20") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.rtnBillList[i].cont_height.search("8") != -1)
					{
						twnty_flat_eight_five.value="1";
						//ext_mov_twnty.value=jsonData.appraisalData[0].extra_movement;
					}
					else if(jsonData.rtnBillList[i].cont_height.search("9") != -1)
					{
						twnty_flat_nine_five.value="1";
						//ext_mov_twnty.value=jsonData.appraisalData[0].extra_movement;
					}
				}
				else if(jsonData.rtnBillList[i].cont_size.search("40") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.rtnBillList[i].cont_height.search("8") != -1)
					{
						forty_flat_eight_five.value="1";
						//ext_mov_forty.value=jsonData.appraisalData[0].extra_movement;
					}
					else if(jsonData.rtnBillList[i].cont_height.search("9") != -1)
					{
						forty_flat_nine_five.value="1";
						//ext_mov_forty.value=jsonData.appraisalData[0].extra_movement;
					}
				}
				else if(jsonData.rtnBillList[i].cont_size.search("45") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.rtnBillList[i].cont_height.search("8") != -1)
					{
						forty_five_flat_eight_five.value="1";
					}
					else if(jsonData.rtnBillList[i].cont_height.search("9") != -1)
					{
						forty_five_flat_nine_five.value="1";
					}
				}
			}
			else if (jsonData.rtnBillList[i].cont_type.search("open") != -1 )
			{
				if(jsonData.rtnBillList[i].cont_size.search("20") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.rtnBillList[i].cont_height.search("8") != -1)
					{
						twnty_open_eight_five.value="1";
					}
					else if(jsonData.rtnBillList[i].cont_height.search("9") != -1)
					{
						twnty_open_nine_five.value="1";
					}
				}
				else if(jsonData.rtnBillList[i].cont_size.search("40") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.rtnBillList[i].cont_height.search("8") != -1)
					{
						forty_open_eight_five.value="1";
					}
					else if(jsonData.rtnBillList[i].cont_height.search("9") != -1)
					{
						forty_open_nine_five.value="1";
					}
				}
				else if(jsonData.rtnBillList[i].cont_size.search("45") != -1)
				{
					// CONTAINER HEIGHT
					if(jsonData.rtnBillList[i].cont_height.search("8") != -1)
					{
						forty_five_open_eight_five.value="1";
					}
					else if(jsonData.rtnBillList[i].cont_height.search("9") != -1)
					{
						forty_five_open_nine_five.value="1";
					}
				}
			}
			
			bill_no.value="";
			rotation_no.value=jsonData.rtnBillList[i].import_rotation;
			arr_dt.value=jsonData.arraivalDateValue;
			comm_dt.value=jsonData.rtnBillList[i].comm_landing_date;
			hc_rcv_unit_txt.value=jsonData.rtnBillList[i].rcv_unit;
			hc_rcv_amount.value=jsonData.rtnBillList[i].equipment;
			console.log("RCV : "+jsonData.rtnBillList[i].rcv_unit);
			wr_dt.value=jsonData.rtnBillList[i].wr_date;
			ado_no.value=jsonData.rtnBillList[i].do_no;
			ado_dt.value=jsonData.rtnBillList[i].do_date;
			ado_upto.value=jsonData.rtnBillList[i].valid_up_to_date;
			ex_rate.value=jsonData.getExRateValue;
			bill_for.value="";
			one_stop_point.value=jsonData.sectionValue;
			//console.log(jsonData.sectionValue);
			unstfDt.value=jsonData.rtnBillList[i].wr_date;
			//wr_upto_dt.value=jsonData.rtnBillList[i].wr_upto_date;
			wr_upto_dt.value=jsonData.rtnBillList[i].valid_up_to_date;
			be_no.value=jsonData.rtnBillList[i].be_no;
			be_dt.value=jsonData.rtnBillList[i].be_date;
			less.value="";
			part_bl.value="";
			cont_qty.value=jsonData.rtnBillList[i].Pack_Number;
			cont_wht.value=jsonData.rtnBillList[i].cont_weight;
			qty_in_shed.value=jsonData.rtnBillList[i].rcv_pack;
			qty_lock.value=jsonData.rtnBillList[i].loc_first;
			cnfCode.value=jsonData.rtnBillList[i].cnf_lic_no;
			cnfName.value=jsonData.rtnBillList[i].cnf_name;
			
			importerCode.value=jsonData.rtnBillList[i].Consignee_code;
			importerName.value=jsonData.rtnBillList[i].Consignee_name;
			
			vessel_name.value=jsonData.rtnBillList[i].Vessel_Name;
			bl_no.value=jsonData.rtnBillList[i].BL_No;
			container_size.value=jsonData.rtnBillList[i].cont_size;
			container_height.value=jsonData.rtnBillList[i].cont_height;
			totalqty=jsonData.rtnBillList[i].total_pack;
			
			if(totalqty!=cont_qty.value)
			{
				wht_in_shed.value= (cont_wht.value/totalqty)*qty_in_shed.value;
				wht_lock.value= (cont_wht.value/totalqty)*qty_lock.value;
			}
			else
			{
				wht_in_shed.value= (cont_wht.value/cont_qty.value)*qty_in_shed.value;
				wht_lock.value= (cont_wht.value/cont_qty.value)*qty_lock.value;
			}
			//sendVerifyNo.value=jsonData.rtnBillList[i].verify_number;
			
			//var  table = document.getElementById("mytbl");
			//removeTableElement(table);
			var  table = document.getElementById("mytbl");
			removeTableElement(table);
			
			for (var j = 0; i < jsonData.appraisalData.length; i++) 
				{
					
					rpc.value=jsonData.appraisalData[j].carpainter_use;
					hc_charge.value=jsonData.appraisalData[j].hosting_charge;
					//hc_charge.value=parseFloat(jsonData.appraisalData[j].hosting_charge)+Math.ceil((parseFloat(jsonData.rtnBillList[i].cont_weight)/1000));
					scale_charge.value=jsonData.appraisalData[j].scale_for;
					if(jsonData.rtnBillList[i].cont_size.search("20") != -1)
						{
							ext_mov_twnty.value=jsonData.appraisalData[j].extra_movement;
						}
						else{
							ext_mov_forty.value=jsonData.appraisalData[j].extra_movement;
						}
				}
		}
		getGrossTotal();
		//document.myChkForm.scale_charge.focus() ;
		document.getElementById("loadingImg").style.display="none";
		//document.getElementById('wr_upto_dt').focus();
		document.getElementById('bill_for').focus();
 }
    }
}

 function getGrossTotal()
 {
	 var total_port=document.getElementById("total_port");
	 var total_vat=document.getElementById("total_vat");
	 var total_mlwf=document.getElementById("total_mlwf");
	 
	 var grand_total=document.getElementById("grand_total");
	 //grand_total.value=(parseFloat(total_port.value)+parseFloat(total_vat.value)+parseFloat(total_mlwf.value)).toFixed(2);
	 grand_total.value=parseFloat(Math.round(parseFloat(total_port.value)+parseFloat(total_vat.value)+parseFloat(total_mlwf.value))).toFixed(2);
	 
	 var  table = document.getElementById("mytbl");
	 document.getElementById("tbl_total_row").value=table.rows.length;
 }
 function addAfterTotal()
 {
	var  table = document.getElementById("mytbl");
	var l=table.rows.length;
    var i;
    var den=0;
    for (i=2;i<l;i++) {
        den += parseFloat(liste.rows[i].cells[10].innerHTML, 10);
    }
    alert(den);
 }
 function removeTableElement(table)
 {
  var tblLen = table.rows.length;
  //alert(tblLen);
  for(var i=tblLen;i>2;i--)
  {
   table.deleteRow(i-1);
  }    
 }
function deleteRow(row)
{
	//alert(row);
	var i=row.parentNode.parentNode.rowIndex;
	
	var rowPortAmountValue= document.getElementById('mytbl').rows[i].cells[9].children[0].value;
	var rowVatAmountValue= document.getElementById('mytbl').rows[i].cells[8].children[0].value;
	var rowMlwfAmountValue= document.getElementById('mytbl').rows[i].cells[7].children[0].value;
	//console.log("Value : "+document.getElementById('mytbl').rows[i].cells[2].children[0].value);
    document.getElementById("total_port").value=parseFloat(parseFloat(document.getElementById("total_port").value) - parseFloat(rowPortAmountValue)).toFixed(2);
	document.getElementById("total_vat").value=parseFloat(parseFloat(document.getElementById("total_vat").value) - parseFloat(rowVatAmountValue)).toFixed(2);
	document.getElementById("total_mlwf").value=parseFloat(parseFloat(document.getElementById("total_mlwf").value) - parseFloat(rowMlwfAmountValue)).toFixed(2);
	
	document.getElementById("grand_total").value=parseFloat(parseFloat(document.getElementById("grand_total").value) - (parseFloat(rowPortAmountValue) + parseFloat(rowVatAmountValue) + parseFloat(rowMlwfAmountValue))).toFixed(2);
    
	document.getElementById('mytbl').deleteRow(i);
	//console.log("hello"+i);
	
	
	
}
 function addBillToTable(e)
 {
	  
		  //alert("Changed");
		  var verify_num = document.getElementById('verify_num').value;
		  var unstfDt = "";
		  var uptoDt = "";
		  
		  var rpc = "0";
		  var hcCharge = "0";
		  var scCharge = "0";
		  var vatInfo = document.getElementById('vat').value;
		  var mlwf = document.getElementById('mlwf').value;
		  unstfDt= document.getElementById('unstfDt').value;
		  uptoDt= document.getElementById('wr_upto_dt').value;
		  rpc= document.getElementById('rpc').value;
		  hcCharge= document.getElementById('hc_charge').value;
		  scCharge= document.getElementById('scale_charge').value;
		  
		  console.log(hcCharge+"--"+scCharge+"--"+rpc);
		  
		  if(verify_num=="")
		{
			document.getElementById("loadingImg").style.display="none";
			alert("Please Input Verification Number.");			
			document.getElementById('verify_num').focus();
		}
		else if(unstfDt=="")
		{
			document.getElementById("loadingImg").style.display="none";
			alert("Please Input Unstuffing Date.");
			
			document.getElementById('unstfDt').focus();
		}
		else if(uptoDt=="")
		{
			document.getElementById("loadingImg").style.display="none";
			alert("Please Input Up to Date.");			
			document.getElementById('wr_upto_dt').focus();
		}
		else{
		  //alert(unstfDt);
			if (confirm("Do you want to Generate Bill?") == true) {
				   	document.getElementById("loadingImg").style.display="inline";
				  if (window.XMLHttpRequest) 
					{
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp=new XMLHttpRequest();
					} 
					else 
					{  
						// code for IE6, IE5
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange=stateChangeAddBillDetails;
					xmlhttp.open("GET","<?php echo site_url('ajaxController/getBillDetails')?>?verify_num="+verify_num+"&unstfDt="+unstfDt+"&uptoDt="+uptoDt+"&rpc="+rpc+"&hcCharge="+hcCharge+"&scCharge="+scCharge+"&vatInfo="+vatInfo+"&mlwf="+mlwf,false);
					xmlhttp.send();
				} else {
					document.getElementById("loadingImg").style.display="none";
				}
			
		}
	  
 }
 
 function stateChangeAddBillDetails()
{
	if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		//alert(xmlhttp.responseText);			  
		var val = xmlhttp.responseText;
		
		
		var jsonData = JSON.parse(val);
		console.log(jsonData);
		if(jsonData.chargeList.length<1)
		{
			alert("Verification Number is invalid");
			//document.getElementById("loadingImg").style.display="none";
			document.getElementById('verify_num').focus();
		}
		else
		{
		
		/**********************ADD BILL TO TABLE START*******************************/
		var  table = document.getElementById("mytbl");
		
		var  hc_charge = document.getElementById('hc_charge').value;
		var  hc_rcv_unit = document.getElementById('hc_rcv_unit').value;
		var  hc_rcv_amount = document.getElementById('hc_rcv_amount').value;
		var  rpc_charge = document.getElementById('rpc').value;
		var  scale_charge = document.getElementById('scale_charge').value;
		
		var  wht_in_shed = document.getElementById('wht_in_shed').value;
		var  wht_lock = document.getElementById('wht_lock').value;
		
		var portSum=0;
		var vatSum=0;
		var mlwfSum=0;
		removeTableElement(table);
		for (var k = 0; k < jsonData.chargeList.length; k++) 
				{
					if(jsonData.chargeList[k].qday>0)
					{
					   var tr = document.createElement('tr'); 
					   tr.className ="gridDark";
					   
					   var td1 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "tarrif_id" + k;
					   input.value=jsonData.chargeList[k].tarrif_id;
					   input.style.width = "300px";
					   td1.appendChild(input);
					   
					   var td2 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "billHead" + k;
					   input.value=jsonData.chargeList[k].description;
					   input.style.width = "100px";
					   td2.appendChild(input);
					   
					   var td3 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "option" + k;
					   input.value=jsonData.chargeList[k].gl_code;
					   input.style.width = "50px";
					   td3.appendChild(input);
					   
					   var td4 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "rate" + k;
					    if(jsonData.chargeList[k].gl_code=="503000N" && hc_charge!="" || (hc_rcv_unit=="Pallet" && hc_rcv_unit=="Carton"))
							{
								input.value=hc_rcv_amount;
							}
							else
							{
								input.value=jsonData.chargeList[k].tarrif_rate;
							}
					   input.style.width = "40px";
					   td4.appendChild(input);
					   
					   
					   
					   var td5 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "qty" + k;
					  
					   if(jsonData.chargeList[k].gl_code=="503000N" && hc_charge!="" || (hc_rcv_unit=="Pallet" && hc_rcv_unit=="Carton"))
					   {
						    input.value=Math.ceil(hc_charge);		
								//alert("IF : "+hc_charge);
					   }
					   else
					   {
						   if(jsonData.chargeList[k].gl_code=="206031" || jsonData.chargeList[k].gl_code=="206033" || jsonData.chargeList[k].gl_code=="206035")
							{
								input.value=Math.ceil(wht_in_shed /1000);
							}
							else
							{
								if(jsonData.chargeList[k].gl_code=="206037" || jsonData.chargeList[k].gl_code=="206039" || jsonData.chargeList[k].gl_code=="206041")
								{
									input.value=Math.ceil(wht_lock /1000);
								}
								else
								{
									if(jsonData.chargeList[k].gl_code=="204002N" && (scale_charge!="" || scale_charge!="0"))
									{
										input.value=scale_charge;
									}
									else
									{
										if(jsonData.chargeList[k].gl_code=="309000" && (rpc_charge!="" || rpc_charge!="0"))
										{
											input.value=rpc_charge;
										}
										else{
											input.value=jsonData.chargeList[k].Qty;
										}
									}
									 
								}
							}
						  
					   }
					    
					   input.style.width = "20px";
					   td5.appendChild(input);
					   
					    var td6 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "qday" + k;
					  if(jsonData.chargeList[k].gl_code=="501005" || jsonData.chargeList[k].gl_code=="502000N" || jsonData.chargeList[k].gl_code=="503000N")
								{
									input.value=0;
								}
								else
								{
									input.value=jsonData.chargeList[k].qday;
								}
					   input.style.width = "20px";
					   td6.appendChild(input);
					   
					    var td7 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "weight" + k;
					   input.value=jsonData.chargeList[k].cont_weight;
					   input.style.width = "40px";
					   td7.appendChild(input);
					   
					   var td8 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "mlwf"+k;
					   input.id = "mlwfAmount" + k;
					   //input.value=jsonData.chargeList[k].totMlwf;
					   // comment by both awal and sourav for coming mlwf from ajax controller
					    if(jsonData.chargeList[k].gl_code=="501005" || jsonData.chargeList[k].gl_code=="502000N")
					   {
						   input.value=parseFloat(jsonData.chargeList[k].amt*0.04).toFixed(2);
						   
					   }
					   else
					   {
						   input.value="0";
					   }
					   // comment by both awal and sourav for coming mlwf from ajax controller
					   
					  // input.value="0";
					   input.style.width = "40px";
					   td8.appendChild(input);
					   
					   var td9 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "vatTK"+k;
					   input.id = "vatAmount"+k;
					    if(jsonData.chargeList[k].gl_code=="503000N" && hc_charge!="")
						{
							input.value=(hc_charge * hc_rcv_amount)*0.15;
							
						}
						else
						{
							if(jsonData.chargeList[k].gl_code=="204002N" && scale_charge!="")
							{
								input.value=(scale_charge * jsonData.chargeList[k].tarrif_rate)*0.15;
							}
							else{
								if(jsonData.chargeList[k].gl_code=="309000" && rpc_charge!="")
								{
									input.value=(rpc_charge * jsonData.chargeList[k].tarrif_rate)*0.15;
								}
								else
								{
									input.value=jsonData.chargeList[k].vatTK;
								}
								
							}
							
						}
					   input.style.width = "40px";
					   td9.appendChild(input);
					   
					   var td10 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "text";
					   input.name = "amt"+k;
					   input.id = "portAmount"+k;
					    if(jsonData.chargeList[k].gl_code=="503000N" && hc_charge!="")
						{
							input.value=hc_charge * hc_rcv_amount;
						}
						else{
							if(jsonData.chargeList[k].gl_code=="204002N" && scale_charge!="")
							{
								input.value=scale_charge * jsonData.chargeList[k].tarrif_rate;
							}
							else
							{
								if(jsonData.chargeList[k].gl_code=="309000" && rpc_charge!="")
								{
									input.value=rpc_charge * jsonData.chargeList[k].tarrif_rate;
								}
								else
								{
									input.value=jsonData.chargeList[k].amt;
								}
								
							}
						}
					   input.style.width = "40px";
					   td10.appendChild(input);
					   
					    var td11 = document.createElement('td');
					   //td1.colSpan="2";
					   var input = document.createElement("input");
					   input.type = "button";
					   input.style.background="#CCAEDE";
					   input.name = "mlwf";
					   input.onclick=function(event){deleteRow(this)};
					   input.value="DELETE";
					   input.style.width = "40px";
					   td11.appendChild(input);
					   
					   tr.appendChild(td1);
					   tr.appendChild(td2);
					   tr.appendChild(td3);
					   tr.appendChild(td4);
					   tr.appendChild(td5);
					   tr.appendChild(td6);
					   tr.appendChild(td7);
					   tr.appendChild(td8);
					   tr.appendChild(td9);
					   tr.appendChild(td10);
					   tr.appendChild(td11);
		
					   table.appendChild(tr);
					   //var amount="amt"+k;
					  portSum += parseFloat(document.getElementById("portAmount"+k).value); 
					  vatSum += parseFloat(document.getElementById("vatAmount"+k).value); 
					  mlwfSum += parseFloat(document.getElementById("mlwfAmount"+k).value); 
					}
				}
				document.getElementById("total_port").value=parseFloat(portSum).toFixed(2);
				document.getElementById("total_vat").value=parseFloat(vatSum).toFixed(2);
				document.getElementById("total_mlwf").value=parseFloat(mlwfSum).toFixed(2);
		
				document.getElementById("grand_total").value= parseFloat(portSum + vatSum + mlwfSum).toFixed(2);
				document.getElementById("loadingImg").style.display="none";
				document.getElementById("tbl_total_row").value=table.rows.length-2;
				
				//var hidden_val = document.getElementById('forBill').getAttribute('data-value');
				//document.getElementById('type_id').value = hidden_val;
		/**********************ADD BILL TO TABLE END*******************************/
	}
	}
}
 

</script>
<style>
input {
   
    width: 100px;
  
}
input:focus {
    background-color: #F3F781;
}
select:focus {
    background-color: #F3F781;
}
 table {border-collapse: collapse;}
			 .left{
					width:230px;
					float:left;										
					font-size: 10px;
					color:black;
				}
				.middle{
					margin-left:0px;
					width:230px;
					float:left;
					height:100%;
					font-size: 10px;
					color:black;
				}
				.right{
					margin-left:20px;
					font-size: 10px;
					color:black;
				}
				.left_container_fieldSet{
					
					float:left;
					height:100%;
					font-size: 10px;
					color:black;
				}
				.right_container_fieldSet{
					margin-left:10px;
					font-size: 10px;
					color:black;
				}
				.left_tbl_div{
					float:left;
					height:100%;
					font-size: 10px;
					color:black;
				}
				.right_tbl_div{
					float:right;
					font-size: 10px;
					color:black;
				}
	.ui-datepicker {
				   background: #DF7A3C;
				   border: 1px solid #555;
				   color: black;
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
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
		
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div align="center"><?php echo $msg;?></div>
		 
		  <?php 
		  $attributes = array('method' => 'POST','id' => 'myform','name'=>'myChkForm','enctype'=>'multipart/form-data');
		  //,'target'=>'_BLANK'
		  //echo form_open(base_url().'index.php/shedBillController/billGenerationFormToDB',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}?>
		<div align="center">
		<table>
			<tr align="center">
				<th style="color:black;">CHITTAGONG PORT AUTHORITY</th>
			</tr>
			<tr align="center">
				<th style="color:black;">ONE STOP SERVICE</th>
			
			</tr>
		</table>
		</div>
          <h3 style="color:black;"><span><?php echo $title; ?></span> </h3>
		  
		<div class="img" style="margin-right:20px; background-color:#C1E0FF;">
		 	 <!--<div id="login_container">-->
		<form id="myChkForm" name="myChkForm" action="<?php echo site_url('ShedBillController/billGenerationFormToDB');?>" method="post" onkeypress="return event.keyCode != 13" onsubmit="return validate()" target="msgbar">
		 <table style="border:solid 1px #ccc;" width="800px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>	 
		 <table align="center" border=0>	
						<tr align="left">
							<td style="color:black;">VERIFY NO :<em>&nbsp;</em></td>
							<td>
							<input type="text" tabindex="1" id="verify_num"  name="verify_num" onblur="getBillData(this.value);" autofocus/>
							<input type="hidden" id="tbl_total_row"  name="tbl_total_row"/>
							
							<input type="hidden" id="vessel_name"  name="vessel_name"/>
							<input type="hidden" id="bl_no"  name="bl_no"/>
							<input type="hidden" id="container_size"  name="container_size"/>
							<input type="hidden" id="container_height"  name="container_height"/>
							</td>
							<td style="color:black;">DA BILL NO :<em>&nbsp;</em></td>
							<td>
							<input type="text" id="da_bill_no"  name="da_bill_no"/>
							</td>
							<td style="color:black;">BILL DATE :<em>&nbsp;</em></td>
							<td>
							<input type="text" id="bill_date" value="<?php echo date("Y-m-d"); ?>" name="bill_date"/>
							<script>
							$(function() {
								$( "#bill_date" ).datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
							</td>
						</tr>
						<tr>
							<td colspan="9"><div id="loadingImg" style="display:none;" ><img src="<?php echo IMG_PATH?>ajax-loader.gif" width="400" height="200" style="position:absolute;"/><span style="padding-bottom:5px;"><font color="red" size="4">Processing. Please wait untill process data......</font></span></div></td>
						</tr>
				</table>
			</td>
		</tr>
		<!--TR align="center"><TD colspan="6" ><h2><span ><?php echo "Verify No: ".$verify_num; ?></span> </h2></TD></TR-->
	</table>
	<!--fieldset>
    <legend>Personalia:</legend>
    Name: <input type="text"><br>
    Email: <input type="text"><br>
    Date of birth: <input type="text">
  </fieldset-->
	<div>
		<div class="left">
			<fieldset>
				<legend>IGM INFO:</legend>
				<table height="217px">
					<tr>
						<td> BILL NO</td>
						<td>:</td>
						<td><input type="text" id="bill_no"  name="bill_no"/></td>
					</tr>
					<tr>
						<td> ROTATION NO</td>
						<td>:</td>
						<td><input type="text" id="rotation_no"  name="rotation_no"/></td>
					</tr>
					<tr>
						<td> ARRAIVAL DT</td>
						<td>:</td>
						<td><input type="text" id="arr_dt"  name="arr_dt"/>
							<script>
							$(function() {
								$( "#arr_dt" ).datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
						</td>
					</tr>
					<tr>
						<td> COMML DT</td>
						<td>:</td>
						<td><input type="text" id="comm_dt"  name="comm_dt"/>
						<script>
							$(function() {
								$( "#comm_dt" ).datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
						</td>
					</tr>
					<tr>
						<td> W/R ST DT</td>
						<td>:</td>
						<td><input type="text" id="wr_dt"  name="wr_dt"/>
						<script>
							$(function() {
								$( "#wr_dt" ).datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
						</td>
					</tr>
					<tr>
						<td> A.D.O NO</td>
						<td>:</td>
						<td><input type="text" id="ado_no"  name="ado_no"/></td>
					</tr>
					<tr>
						<td> A.D.O DATE</td>
						<td>:</td>
						<td><input type="text" id="ado_dt"  name="ado_dt"/>
						<script>
							$(function() {
								$( "#ado_dt" ).datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
						</td>
					</tr>
					<tr>
						<td> A.D.O UPTO</td>
						<td>:</td>
						<td><input type="text" id="ado_upto"  name="ado_upto"/>
						<script>
							$(function() {
								$( "#ado_upto" ).datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
						</td>
					</tr>
					<tr>
						<td> ONE STOP POINT</td>
						<td>:</td>
						<td><input type="text" id="one_stop_point" name="one_stop_point"/></td>
					</tr>
				</table>
			</fieldset>
		</div>
		<div class="middle">
			<fieldset>
				<legend>OTHER INFO:</legend>
				<table height="217px">
					<tr>
						<td> EXCH RATE</td>
						<td>:</td>
						<td><input type="text" id="ex_rate"  name="ex_rate"/></td>
					</tr>
					<tr>
						
					</tr>
					<tr>
						<td> BILL FOR</td>
						<td>:</td>
						<td><input tabIndex="2" type="text" id="bill_for"  name="bill_for" list="forBill"/>
							<datalist id="forBill">
								<?php				
								include_once("mydbPConnection.php");
								$strrcvAllQry = "select invoice_id as type_id,invoice_description as billFor from invoice_type";
													
								$resrcvAllT = mysql_query($strrcvAllQry);
													
								while($rowrcvAllQry=mysql_fetch_object($resrcvAllT))
								{
									echo '<option value="'.$rowrcvAllQry->billFor.'">'.$rowrcvAllQry->billFor.'</option>';													
								}
								?>
							  <!--option value="LCL CONTAINER">
							  <option value="LCL TRANSHIPMENT">
							  <option value="CAR NEW">
							  <option value="CAR OLD">
							  <option value="FCL CONTAINER">
							  <option value="DEPO CONTAINER">
							  <option value="SUSPECT CONTAINER">
							  <option value="FCL TRANSHIPMENT"-->
							</datalist>
							<!--input type="text" name="type_id" id="type_id"-->
						</td>
					</tr>
					<tr>
						<td> UNSTF DT</td>
						<td>:</td>
						<td><input type="text" id="unstfDt"  name="unstfDt" /> <!--onkeypress="return addBillToTable(event,this.value)"-->
						<script>
							$(function() {
								$( "#unstfDt" ).datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
						</td>
					</tr>
					<tr>
						<td> W/R BILL UP TO</td>
						<td>:</td>
						<td><input type="text" id="wr_upto_dt"  name="wr_upto_dt" tabindex="3"/>
						<script>
							$(function() {
								$( "#wr_upto_dt" ).datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
						</td>
					</tr>
					<tr>
						<td> BE NO</td>
						<td>:</td>
						<td><input type="text" id="be_no"  name="be_no"/></td>
					</tr>
					<tr>
						<td> BE DATE</td>
						<td>:</td>
						<td><input type="text" id="be_dt"  name="be_dt"/>
						<script>
							$(function() {
								$( "#be_dt" ).datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
						</td>
					</tr>
					<tr>
						<td> LESS</td>
						<td>:</td>
						<td><input style="width : 60px" type="text" id="less"  name="less"/> % WAVE</td>
					</tr>
					<tr>
						<td> PART BL</td>
						<td>:</td>
						<td><input type="text" id="part_bl"  name="part_bl"/></td>
					</tr>
				</table>
			</fieldset>
		</div>
		<div class="right">
			<fieldset>
			<legend>CONTAINER</legend>
				<div>
				<div class="left_container_fieldSet">				
				<table >
					<tr>
						<td></td>
						<td colspan="2"><u>GENERAL</u></td>
						<td colspan="2"><u>OPEN TOP</u></td>
						<td colspan="2"><u>FLAT TRACK</u></td>
					</tr>
					<tr>
						<td></td>
						<td><u>8.5</u></td>
						<td><u>9.5</u></td>
						<td><u>8.5</u></td>
						<td><u>9.5</u></td>
						<td><u>8.5</u></td>
						<td><u>9.5</u></td>
					</tr>
					<tr>
						<td>20</td>
						<td><input id="twnty_gen_eight_five" name="twnty_gen_eight_five" style="width : 20px" type="text"></td>
						<td><input id="twnty_gen_nine_five" name="twnty_gen_nine_five"style="width : 20px" type="text"></td>
						<td><input id="twnty_open_eight_five" name="twnty_open_eight_five"style="width : 20px" type="text"></td>
						<td><input id="twnty_open_nine_five" name="twnty_open_nine_five"style="width : 20px" type="text"></td>
						<td><input id="twnty_flat_eight_five" name="twnty_flat_eight_five"style="width : 20px" type="text"></td>
						<td><input id="twnty_flat_nine_five" name="twnty_flat_nine_five" style="width : 20px" type="text"></td>
					</tr>
					<tr>
						<td>40</td>
						<td><input id="forty_gen_eight_five" name="forty_gen_eight_five" style="width : 20px" type="text"></td>
						<td><input id="forty_gen_nine_five" name="forty_gen_nine_five" style="width : 20px" type="text"></td>
						<td><input id="forty_open_eight_five" name="forty_open_eight_five" style="width : 20px" type="text"></td>
						<td><input id="forty_open_nine_five" name="forty_open_nine_five" style="width : 20px" type="text"></td>
						<td><input id="forty_flat_eight_five" name="forty_flat_eight_five" style="width : 20px" type="text"></td>
						<td><input id="forty_flat_nine_five" name="forty_flat_nine_five" style="width : 20px" type="text"></td>
					</tr>
					<tr>
						<td>45</td>
						<td><input id="forty_five_gen_eight_five" name="forty_five_gen_eight_five" style="width : 20px" type="text"></td>
						<td><input id="forty_five_gen_nine_five" name="forty_five_gen_nine_five" style="width : 20px" type="text"></td>
						<td><input id="forty_five_open_eight_five" name="forty_five_open_eight_five" style="width : 20px" type="text"></td>
						<td><input id="forty_five_open_nine_five" name="forty_five_open_nine_five" style="width : 20px" type="text"></td>
						<td><input id="forty_five_flat_eight_five" name="forty_five_flat_eight_five" style="width : 20px" type="text"></td>
						<td><input id="forty_five_flat_nine_five" name="forty_five_flat_nine_five" style="width : 20px" type="text"></td>
					</tr>
				</table>
				<table>
					<tr>
						<td>EXT MOV 20 : </td>
						<td><input id="ext_mov_twnty" name="ext_mov_twnty" style="width : 80px" type="text"></td>
					</tr>
					<tr>
						<td>EXT MOV 40 : </td>
						<td><input id="ext_mov_forty" name="ext_mov_forty" style="width : 80px" type="text"></td>
					</tr>
				</table>
				</div>
				<div class="right_container_fieldSet">
					<table align="center">
						<tr>
							<td>QTY</td>
							<td>:</td>
							<td><input id="cont_qty" name="cont_qty" style="width : 40px" type="text"></td>
							<td>WEIGHT</td>
							<td>:</td>
							<td><input id="cont_wht" name="cont_wht" style="width : 40px" type="text"></td>
						</tr>
					</table>
					<fieldset>
					<legend>LCL</legend>
					<table>
						<tr>
							<td></td>
							<td></td>
							<td>QTY</td>
							<td>WEIGHT</td>
						</tr>
						<tr>
							<td>IN SHED</td>
							<td>:</td>
							<td><input id="qty_in_shed" name="qty_in_shed" style="width : 40px" type="text"></td>
							<td><input id="wht_in_shed" name="wht_in_shed"style="width : 40px" type="text"></td>
						</tr>
						<tr>
							<td>LOCK FAST</td>
							<td>:</td>
							<td><input id="qty_lock" name="qty_lock" style="width : 40px" type="text"></td>
							<td><input id="wht_lock" name="wht_lock" style="width : 40px" type="text"></td>
						</tr>
						<tr>
							<td>OUT SHED</td>
							<td>:</td>
							<td><input id="qty_out_shed" name="qty_out_shed" style="width : 40px" type="text"></td>
							<td><input id="wht_out_shed" name="wht_out_shed" style="width : 40px" type="text"></td>
						</tr>
					</table>
					</fieldset>
					<table align="right">
						<tr align="">
							<td>Remarks : </td>
							<td><TextArea id="remarks" name="remarks" style="width : 160px"></TextArea></td>
						</tr>
					</table>
				</div>
				<table>
					<tr>
						<td>C&F CODE & NAME </td>
						<td><input id="cnfCode" name="cnfCode" style="width : 50px" type="text" onkeypress="return getCnfCode(event,this.value)"></td>
						<td><input id="cnfName" name="cnfName"style="width : 220px" type="text"></td>						
					</tr>
					<tr>
						<td>IMPO.REG NO.& NAME </td>
						<td><input id="impo_reg_no" name="impo_reg_no" style="width : 50px" type="text"></td>
						<td><input id="impo_reg_name" name="impo_reg_name" style="width : 220px" type="text"></td>	
					</tr>
					
				</table>
				</div>
			</fieldset>
		
		</div>
		</div>
		</br>
	<table style="border:solid 1px #ccc;" width="800px" align="center" cellspacing="0" cellpadding="0">
						<tr align="left">
							<td style="color:black;">RPC :<em>&nbsp;</em></td>
							<td >
							<input type="text" id="rpc"  name="rpc" tabindex="4"/>   
							</td>
							<td style="color:black;">HC CHARGE :<em>&nbsp;</em></td>
							<td>
							<input type="text" id="hc_charge"  name="hc_charge" tabindex="5"/>
							<input type="hidden" id="hc_rcv_unit"  name="hc_rcv_unit" />
							<input type="hidden" id="hc_rcv_amount"  name="hc_rcv_amount" />
							</td>
							<td style="color:black;">SCALE CHARGE :<em>&nbsp;</em></td> <!-- WEIGHMENT CHARGE -->
							<td>
							<input type="text" id="scale_charge"  name="scale_charge" tabindex="6"/> <!--onkeypress="return addBillToTable(event,this.value)"-->
							</td>
							<td style="color:black;">VAT :<em>&nbsp;</em></td>
							<td>
								<select name="vat" id="vat" onkeypress="changeToMlwf(event)" tabindex="7">
									<option value="1">Yes</option> 
									<option value="0">No</option> 
								</select>
							</td>
							<td style="color:black;">MLWF :<em>&nbsp;</em></td>
							<td>
							<select name="mlwf" id="mlwf" onblur="return addBillToTable(event)"tabindex="8">
									<option value="1">Yes</option> 
									<option value="0">No</option> 
							</select>
							</td>
						</tr>
				</table>
				</br>
				<div>
					<div class="left_tbl_div" style="overflow:auto;width:650px;">
					<table id="mytbl" class="mytbl" border=1>
					<thead>
						<tr class="header">
							<td align="center"><b>CHOICE</b></td>
							<td align="center"><b>BILL HEAD</b></td>
							<td align="center"><b>OPTION</b></td>
							<td align="center"><b>RATE</b></td>
							<td align="center"><b>QTY</b></td>
							<td align="center"><b>DAYS</b></td>
							<td align="center"><b>WT</b></td>
							<td align="center"><b>MLWF(TK)</b></td>
							<td align="center"><b>VAT(TK)</b></td>
							<td align="center"><b>PORT(TK)</b></td>
							<td align="center"><b>ACTION</b></td>
						</tr>
						</thead>
						<tbody>
						<tr>
							
							<td>
							<input style="white-space:pre-wrap;background-color:#FF9;width: 300px;" type="search" list="tarrif" placeholder="Pick a Tarrif ID" name="bill_tarrif" oninput="return addRow(this.value)">							
							<datalist id="tarrif">
								<?php 

								for($i=0;$i<count($getBillTarrif);$i++)
								{
								  echo '<option value="'.$getBillTarrif[$i]['id'].'">'.$getBillTarrif[$i]['id'].'('.$getBillTarrif[$i]['amount'].')'.'</option>';
								}
								?>
							</datalist>
							
							<!--select class="" style="width : 100px" onchange="return addRow(this.value)">
								<?php 

								for($i=0;$i<count($getBillTarrif);$i++)
								{
								  echo '<option value="'.$getBillTarrif[$i]['id'].'">'.$getBillTarrif[$i]['id'].'</option>';
								}
								?>
							</select-->
							</td>
							<td><input type="text" id="bill_head_tbl" style="width : 100px" name="bill_head_tbl"/></td>
							<td style="display:none;"><input type="hidden" id="tarrif_id_tbl" style="width : 150px" name="tarrif_id_tbl"/></td>
							<td><input type="text" id="option_tbl" style="width : 50px" name="option_tbl"/></td>
							<td><input type="text" id="rate_tbl" style="width : 40px" name="rate_tbl"/></td>
							<td><input type="text" id="qty_tbl" style="width : 20px" name="qty_tbl"/></td>
							<td><input type="text" id="days_tbl" style="width : 20px" name="days_tbl"/></td>
							<script>
								$('#days_tbl').keyup(function() {												
								var tot_amount= parseFloat($("#days_tbl").val())* parseFloat($("#qty_tbl").val())*parseFloat($("#rate_tbl").val());
								var tot_vat= (parseFloat($("#days_tbl").val())* parseFloat($("#qty_tbl").val())*parseFloat($("#rate_tbl").val()))*0.15;
									$("#port_tbl").val(tot_amount);
									$("#vat_tbl").val(tot_vat);
									});	
							</script>
							<td><input type="text" id="wt_tbl" style="width : 40px" name="wt_tbl"/></td>
							<td><input type="text" id="mlwf_tbl" style="width : 40px" name="mlwf_tbl"/></td>
							<td><input type="text" id="vat_tbl" style="width : 40px" name="vat_tbl"/></td>
							<td><input type="text" id="port_tbl" style="width : 40px" name="port_tbl"/></td>
							<td><input type="button" style="width : 40px" value="ADD" class="login_button" onclick="addTableRow()"/></td>
							
						
						</tr>
						</tbody>
					</table>					
					</div>
					
					<div class="right_tbl_div" align="right" style="width:200px;">
						<table>
							<tr>
								<td>TOTAL PORT</td>
								<td>:</td>
								<td><input type="text" class="total_port" id="total_port" style="width : 100px" name="total_port"/></td>
							</tr>
							<tr>
								<td>TOTAL VAT</td>
								<td>:</td>
								<td><input type="text" id="total_vat" style="width : 100px" name="total_vat"/></td>
							</tr>
							<tr>
								<td>TOTAL MLWF</td>
								<td>:</td>
								<td><input type="text" id="total_mlwf" style="width : 100px" name="total_mlwf"/></td>
							</tr>
							<tr>
								<td>LESS AMOUNT PORT</td>
								<td>:</td>
								<td><input type="text" id="less_amt_port" style="width : 100px" name="less_amt_port"/></td>
							</tr>
							<tr>
								<td>LESS AMOUNT VAT</td>
								<td>:</td>
								<td><input type="text" id="less_amt_vat" style="width : 100px"name="less_amt_vat"/></td>
							</tr>
						</table>
						</br>
						<table border=1>
							<td>G.TOTAL</td>
							<td>:</td>
							<td><input type="text" id="grand_total" style="width : 100px" name="grand_total"/></td>
						</table>
					</div>
				</div>
				<div align="center">
					<table border="0">
						<tr>
							<td><input tabindex="9" id="save_btn" class="login_button" type="submit" style="width : 100px" value="SAVE"/></td>
			</form>
							<?php //echo form_close()?>
							<td><input  id="preViewBtn" onclick="GetBillToModal()" class="login_button" type="button" style="width : 100px" value="PENAL BILL"/></td>
							<!--td>
								<form action="<?php echo site_url('ShedBillController/getShedBillPdf')?>" name="myChkForm" target="_blank" method="POST" onsubmit="return validate();">						
									<input type="hidden"  id="sendVerifyNo" name="sendVerifyNo" value="<?php echo $verify_num;?>">									
									<input type="submit" value="VIEW BILL"  class="login_button" style="width:100%;">							
								</form> 							
							</td-->
							<td><input class="login_button" type="button" style="width : 100px" value="MANUAL BILL"/></td>
							<td><input class="login_button" type="button" style="width : 100px" value="ROUGH BILL"/></td>
							<td><input class="login_button" type="button" style="width : 100px" value="UNDERCHARGE"/></td>
							<td><input class="login_button" type="button" style="width : 100px" value="DELETE BILL"/></td>
							<td><a href="<?php echo site_url('ShedBillController/billGenerationForm') ?>">
								<input class="login_button" type="button" style="width : 100px" value="CLEAR"/></a>
							</td>
						</tr>
						<tr>
							<td colspan="8"><iframe name="msgbar" id="msgbar" width="800" height="50" frameborder="0"></iframe></td>
						</tr>
					</table>
				</div>
	
	<?php
/*****************************************************
Developed BY: Sourav Chakraborty
Software Engineer
DataSoft Systems Bangladesh Ltd
******************************************************/

$_SESSION['Control_Panel']=$this->session->userdata('Control_Panel');

?>

<!--div style="width:100%; height:500px; overflow-y:auto;">
</div-->


		 <!--</div>-->
		 </div>
         
		  </form>
          <div class="clr"></div>
        </div>
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar" >
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
		<!-- The Modal Start-->
		<div id="myModal" class="modal">
		  <!-- Modal content -->
		  <div class="modal-content">
			<div class="modal-header">
			  <span class="close">&times;</span>
			  <div align="center" style="">
				<b>CHITTAGONG PORT AUTHORITY</b>
			</div>
			<div align="center">ONE STOP SERVICE CENTER</div>
			<div align="center">(LCL BILL)</div>
			</div>
			<div class="modal-body">
				<div align ="center">
					<table align="center" width="100%">
						<tr style="">
							<td>VERIFY NO : <label id="v_Number"></label></td>
							<td>UNIT NO : <label id="unit_Number"></label></td>
							<td>CPA VAT REG NO : <label id="vat_reg"></label></td>
							<td>EX.RATE($) : <label id="exchange_rate"></label></td>
						</tr>			
					</table>
					<hr>
					<table align="center" width="200px" >
					 <?php       
							for($i=0;$i<count($rtnContainerList);$i++) { 
							 ?>
						<tr style="border-bottom:1px solid black">
							<td>BILL NO : <?php echo $rtnContainerList[$i]['bill_no'];?></td>
							<td>DATE : <?php echo date("y-m-d");?></td>
							<td>ARRAIVAL DATE : <?php echo $rtnContainerList[$i]['arraival_date'];?></td>
						</tr>
						<tr style="border-bottom:1px solid black">
							<td>ROT NO : <?php echo $rtnContainerList[$i]['import_rotation'];?></td>
							<td>VSL NAME : <?php echo $rtnContainerList[$i]['vessel_name'];?></td>
							<td>C/L DATE : <?php echo $rtnContainerList[$i]['cl_date'];?></td>
						</tr>	
						<tr style="border-bottom:1px solid black">
							<td>LINE/BL NO : <?php echo $rtnContainerList[$i]['bl_no'];?></td>
							<td>W/R DATE : <?php echo $rtnContainerList[$i]['wr_date'];?></td>
							<td>W/R BILL UPTO : <?php echo $rtnContainerList[$i]['wr_upto_date'];?></td>
						</tr>	
						<tr style="border-bottom:1px solid black">
							<td>VAT REG NO : <?php echo $rtnContainerList[$i]['cpa_vat_reg_no'];?></td>
							<td>IMPORTER : <?php echo $rtnContainerList[$i]['importer_name'];?></td>
						</tr>	
						<tr style="border-bottom:1px solid black">
							<td>C&F LC NO : <?php echo $rtnContainerList[$i]['cnf_lic_no'];?></td>
							<td>C&F AGENT : <?php echo $rtnContainerList[$i]['cnf_agent'];?></td>
						</tr>	
						<tr style="border-bottom:1px solid black">
							<td>BE NO : <?php echo $rtnContainerList[$i]['be_no'];?></td>
							<td>BE DATE : <?php echo $rtnContainerList[$i]['be_date'];?></td>
						</tr>	
						<tr style="border-bottom:1px solid black">
							<td>ADO NO : <?php echo $rtnContainerList[$i]['ado_no'];?></td>
							<td>ADO DATE : <?php echo $rtnContainerList[$i]['ado_date'];?></td>
							<td>ADO VALID UPTO : <?php echo $rtnContainerList[$i]['ado_valid_upto'];?></td>
						</tr>	
						<tr style="border-bottom:1px solid black">
							<td>MANIFEST QTY : <?php echo $rtnContainerList[$i]['manifest_qty']."*".$rtnContainerList[$i]['cont_size']."*".$rtnContainerList[$i]['cont_height'];?></td>
						</tr>
							<?Php }?>
					</table>
					<div align="center"><u>QNTY FOR WHICH CHARGE MADE</u></div>
						<table align="center"  cellpadding="1" cellspacing="1" style="border-top: 1px solid black;border-bottom: 1px solid black;">
							<thead style="">
								<tr style="border-top: 1px solid black;">		
									<th align="center" >CODE</th>
									<th align="center" >DESCRIPTION</th>
									<th align="center" >RATE(T/$)</th>
									<th align="center" >QNTY</th>
									<th align="center" >DAYS</th>
									<th align="center" >PORT(TK)</th>
									<th align="center" >VAT(TK)</th>
									<th align="center" >MLWF(TK)</th>
								</tr>
							</thead>
							<tbody>
							 <?php       
							for($i=0;$i<count($chargeList);$i++) { 
							 ?>
							 <tr class="" style="page-break-inside:avoid; page-break-after:auto;"> 
							  
							  <td align="center">
							   <?php echo $chargeList[$i]['gl_code']?>
							  </td>
							  <td align="left">
							   <?php echo $chargeList[$i]['description']?>
							  </td>
							  <td align="center">
							   <?php echo $chargeList[$i]['tarrif_rate']?>
							  </td>
							  <td align="center">
							   <?php echo $chargeList[$i]['Qty']?>
							  </td>
							  <td align="center">
							   <?php if($chargeList[$i]['gl_code']!=206031 && $chargeList[$i]['gl_code']!=206033 && $chargeList[$i]['gl_code']!=206035 
							   && $chargeList[$i]['gl_code']!=206037 && $chargeList[$i]['gl_code']!=206039 && $chargeList[$i]['gl_code']!=206041 && $chargeList[$i]['qday']=1) {?>
								<?php echo "";} else {?>
								<?php echo $chargeList[$i]['qday'];}?>
							  </td>
							  <td align="center">
							   <?php echo $chargeList[$i]['amt']?>
							  </td>
							  <td align="center">
							   <?php echo $chargeList[$i]['vatTK']?>
							  </td>
							  <td align="center">
							   
							  </td>
							</tr>
							 <?php
							}
						   ?>
						</tbody>
						</table>
						<table>
							<tr>
								<td>
									SHOW RATE IN US$ TOTAL DAYS : <?php echo $tot_qday;?></b>
								</td>
								<td>
									TOTAL(TK) : <?php echo $tot_sum;?></b>
								</td>
							</tr>
							<tr >
								<td colspan="4">NET AMOUNT : <?php $ait=($tot_sum * 0.1); $other= $tot_sum - $ait; echo "( ".$other." + AIT 10% ".$ait." )"?></td>
								<td>PORT : <?php echo $tot_sum;?></b></td>
							</tr>
							<tr>
								<td align="center" colspan="5">
									<b>NET PAYABLE (TK) : <?php echo $tot_sum;?></b>
								</td>
							</tr>
							<tr>
								<td colspan="5">
									REMARKS :  <?php echo numtowords($tot_sum); ?>
									
								</td>
							</tr>
							<tr>
								<td colspan="5">
									<b>SHOULD BE PAID ON BEFORE <?php for($i=0;$i<count($rtnContainerList);$i++) {  echo $rtnContainerList[$i]['wr_upto_date'];}?></b> 
								</td>
							</tr>
							<tr>
								<td>BANK'S SEAL</td><td></td>
								<td>C&F AGENT</td><td></td>
								<td>BILL CLERK</td><td></td>
								<td>L/C NO</td><td></td>
								<td>UNIT NO </td><td><?php echo $unit_no;?></td>
							</tr>
						</table>
					</div>
			</div>
			<div class="modal-footer">
			  <h3>Modal Footer</h3>
			</div>
		  </div>

		</div>
		<script>
			// *******************MODEL START *************//
			var modal = document.getElementById('myModal');

			// Get the button that opens the modal
			var btn = document.getElementById("preViewBtn");

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];

			// When the user clicks the button, open the modal 
			 function showModal() {
				//alert("TEst");
				modal.style.display = "block";
			}

			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
				modal.style.display = "none";
			}

			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
				if (event.target == modal) {
					modal.style.display = "none";
				}
			}
			// *******************MODEL END*************//
			function GetBillToModal() {
		//$("#mytbl").append("<tr><td><input type='text' value='"+val+"'></td></tr>");
			var verify_num = document.getElementById('verify_num').value;
			
			if(verify_num=="")
			{
				alert("Verify Number Can not be blank.");
			}
			else{
					if (window.XMLHttpRequest) 
					{
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp=new XMLHttpRequest();
					} 
					else 
					{  
						// code for IE6, IE5
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange=stateChangeBillModalInformation;
					xmlhttp.open("GET","<?php echo site_url('ajaxController/getBillToModal')?>?verify_num="+verify_num,false);
					xmlhttp.send();
				}	
			}
			function stateChangeBillModalInformation()
			{
				//alert("ddfd");
				if (xmlhttp.readyState==4 && xmlhttp.status==200) 
				{
					//alert(xmlhttp.responseText);			  
					var val = xmlhttp.responseText;
					var jsonData = JSON.parse(val);
					console.log(jsonData);
					document.getElementById('v_Number').innerText=jsonData.verify_num;
					document.getElementById('unit_Number').innerText=jsonData.unit_no;
					document.getElementById('vat_reg').innerText=jsonData.cpa_vat_reg_no;
					document.getElementById('exchange_rate').innerText=jsonData.ex_rate;
					showModal();
					//addAfterTotal();
				}
			}
		</script>
		<!-- The Modal End-->
  </div>
<?php function numtowords($num){ 
$decones = array( 
            '01' => "One", 
            '02' => "Two", 
            '03' => "Three", 
            '04' => "Four", 
            '05' => "Five", 
            '06' => "Six", 
            '07' => "Seven", 
            '08' => "Eight", 
            '09' => "Nine", 
            10 => "Ten", 
            11 => "Eleven", 
            12 => "Twelve", 
            13 => "Thirteen", 
            14 => "Fourteen", 
            15 => "Fifteen", 
            16 => "Sixteen", 
            17 => "Seventeen", 
            18 => "Eighteen", 
            19 => "Nineteen" 
            );
$ones = array( 
            0 => " ",
            1 => "One",     
            2 => "Two", 
            3 => "Three", 
            4 => "Four", 
            5 => "Five", 
            6 => "Six", 
            7 => "Seven", 
            8 => "Eight", 
            9 => "Nine", 
            10 => "Ten", 
            11 => "Eleven", 
            12 => "Twelve", 
            13 => "Thirteen", 
            14 => "Fourteen", 
            15 => "Fifteen", 
            16 => "Sixteen", 
            17 => "Seventeen", 
            18 => "Eighteen", 
            19 => "Nineteen" 
            ); 
$tens = array( 
            0 => "",
            2 => "Twenty", 
            3 => "Thirty", 
            4 => "Forty", 
            5 => "Fifty", 
            6 => "Sixty", 
            7 => "Seventy", 
            8 => "Eighty", 
            9 => "Ninety" 
            ); 
$hundreds = array( 
            "Hundred", 
            "Thousand", 
            "Million", 
            "Billion", 
            "Trillion", 
            "Quadrillion" 
            ); //limit t quadrillion 
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){ 
    if($i < 20){ 
        $rettxt .= $ones[$i]; 
    }
    elseif($i < 100){ 
        $rettxt .= $tens[substr($i,0,1)]; 
        $rettxt .= " ".$ones[substr($i,1,1)]; 
    }
    else{ 
        $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
        $rettxt .= " ".$tens[substr($i,1,1)]; 
        $rettxt .= " ".$ones[substr($i,2,1)]; 
    } 
    if($key > 0){ 
        $rettxt .= " ".$hundreds[$key]." "; 
    } 

} 
$rettxt = $rettxt." Taka";

if($decnum > 0){ 
    $rettxt .= " and "; 
    if($decnum < 20){ 
        $rettxt .= $decones[$decnum]; 
    }
    elseif($decnum < 100){ 
        $rettxt .= $tens[substr($decnum,0,1)]; 
        $rettxt .= " ".$ones[substr($decnum,1,1)]; 
    }
    $rettxt = $rettxt." Paisa"; 
} 
return $rettxt;} ?>
