<script>
    function validate2()
    {
        if(document.myForm.date.value == "")
        {
            alert( "Please provide date!" );
            document.myForm.date.focus() ;
            return false;
        }
        else if(document.myForm.gate.value == "")
        {
            alert( "Please provide Gate No!" );
            document.myForm.terminal.focus() ;
            return false;
        }
    }
</script>

<!--script>
   function getAllGate()
	{	
     alert("ok");	
		if (window.XMLHttpRequest) 
		{

		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=stateChangeGateInfo;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/getAllGate')?>",false);
					
		xmlhttp.send();
	}
	
	
	function stateChangeGateInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var val = xmlhttp.responseText;
			
		   alert(val);
			var selectList=document.getElementById("gateNo");
			removeOptions(selectList);
			//alert(xmlhttp.responseText);
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			//alert(xmlhttp.responseText);
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].gkey;  //value of option in backend
				option.text = jsonData[i].id;	  //text of option in frontend
				selectList.appendChild(option);
			}										
		}
	}
 

 
	 function removeOptions(selectbox)
		{
			var i;
			for(i=selectbox.options.length-1;i>=1;i--)
			{
				selectbox.remove(i);
			}
		}
 
</script-->
<html>
<!--body onload="getAllGate()"-->
<div class="content">
    <div class="content_resize">
		<div class="mainbar">
			<div class="article">
				<h2><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
   
				<div class="clr"></div>
					<div class="img">
						<form name= "myForm" onsubmit="return(validate2());" action="<?php echo site_url("gateController/containerRegisterInRegisterView_ocr");?>" target="_blank" method="post">
							<table align="center" style="border:solid 1px #ccc;" width="350px"  cellspacing="0" cellpadding="0">
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
								    <th><nobr>DATE</nobr></th>
									<td colspan="2"><input type="text" class="read" style="width:135px;"  id="date" name="date" ></td>
									<script>
											  $(function() {
												$( "#date" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
									</script>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<th align="left"><label><font color='red'></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GATE NO:</label></th>
							
										<td colspan="2">
											<select name="gate" id="gate">  
												<option value="">--------Select--------</option>
												<?php for($i=0; $i<count($gateList); $i++){ ?>
													
												<option value="<?php echo $gateList[$i]['gkey'];?>"><?php echo $gateList[$i]['id'];?></option>
												
												<?php } ?>
											</select>	
									    </td>						
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="submit" value="Search" class="login_button"/> 
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
							
							
							<!--table align="center" style="border:solid 1px #ccc;"  cellspacing="0" cellpadding="0">
								<tr>
										<th><nobr>DATE :&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
										<td colspan="2"><input type="text" class="read" style="width:135px;"  id="date" name="date"  placeholder="Date" ></td>
										<script>
												  $(function() {
													$( "#date" ).datepicker({
														changeMonth: true,
														changeYear: true,
														dateFormat: 'yy-mm-dd', // iso format
													});
												});
										</script>
									
										<th align="left"><label><font color='red'></font><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GATE NO:&nbsp;&nbsp;&nbsp;&nbsp;</nobr></label></th>
								
										<td colspan="2">
												<select name="gateNo" id="gateNo" >  
													<option value="">------Select-------</option>
															
												</select>	
										</td>						
										<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
										<td><input type="submit" value="Search" class="login_button" /> </td>
								</tr>
							</table-->
							
						</form>
                        <?php

//==================================== Lowest Higest Descending Ascending start ============================
//                        function selectionSort($arr,$n){
//                            for ($i = 0; $i< $n; $i++){//just print the array here...it's ok to work...
//                                for ($j = $i + 1; $j <$n ; $j++ ){
//                                    if ($arr[$i] > $arr[$j]){
//                                        $temp = $arr[$i];
//                                        $arr[$i] = $arr[$j];
//                                        $arr[$j] = $temp;
//                                    }
//                                }
//                            }
//                            echo  "Lowest : ". $arr[0]."\n";
//                            echo  "Higest : ". $arr[$n-1]." \n";
//                            echo "Ascending Array: \n";
//                            for ($i = 0; $i < $n; $i++){
//                                echo $arr[$i]. " ";
//                            }
//                            echo  "Descending Array: \n";
//                            for ($i = $n; $i>=0; $i--){
//                                echo $arr[$i]. " ";
//                            }
//                        }
//                        $arr = array(0,3,55,30,88,21);
//                        $len =  sizeof($arr);
//                        selectionSort($arr,$len);
 //==================================== Lowest Higest Descending Ascending end ============================
//===================================== Find Second Largest element start =================================
//                        function showSecondLargestFunction($arr,$arr_size)
//                        {
//                           if($arr_size < 2){
//                               echo "Invalid Input";
//                               return;
//                           }
//
//                           $first = $second = PHP_INT_MIN;
//                           for ($i =0; $i<$arr_size; $i++)
//                           {
//                               if($arr[$i] > $first){
//                                   $second = $first;
//                                   $first = $arr[$i];
//                               }
//                               elseif($arr[$i] > $second && $arr[$i] != $first){
//                                   $second = $arr[$i];
//
//                               }
//                           }
//                            if($second == PHP_INT_MIN)
//                            {
//                                echo "There is no second largest element.\n";
//                            }else{
//                                echo "The second largest element is: ".$second."\n";
//                            }
//                        }
//                        $arr = array(1,121,112);
//                        $arr_size = sizeof($arr);
//                        showSecondLargestFunction($arr,$arr_size);
 //==================================== End ===============================================================

//===================================== 3rd largest Element From Array Start ==============================
//                    function thirdLargestElementFunction($arr, $arr_size){
//                        if ($arr_size < 3){
//                            echo "Invalid Input";
//                            return;
//                        }
//
//                        $first = $arr[0];
//                        for ($i=0; $i<$arr_size; $i++){
//                            if ($arr[$i] > $first){
//                                $first = $arr[$i];
//                            }
//                        }
//
//                        $second = PHP_INT_MIN;
//                        for ($i=0; $i<$arr_size; $i++){
//                            if ($arr[$i] > $second && $arr[$i] < $first){
//                                        $second = $arr[$i];
//                            }
//                        }
//
//                        $third = PHP_INT_MIN;
//                        for ($i=0; $i<$arr_size; $i++){
//                            if ($arr[$i] > $third && $arr[$i] < $second){
//                                $third = $arr[$i];
//                            }
//                        }
//
//                        echo "The largest Element: ".$first."\n";
//                        echo "The Second Largest Element: ".$second."\n";
//                        echo "The third largest element: ".$third."\n";
//                    }
//
//                     $arr = array(981,932,900,55,10,33,977,1,500,2,5,0,901,978);
//                     $arr_size = sizeof($arr);
//                     thirdLargestElementFunction($arr,$arr_size);
//===================================== End ===============================================================
//========================== Reverse String Start ==========================================
//                        function reverseStringFunction($str){
//                            $sizeStr = strlen($str);
//
////                            for ($i = $sizeStr - 1, $j = 0; $j<$i; $i--, $j++){
////                                $temp = $str[$i];
////                                $str[$i] = $str[$j];
////                                $str[$j] = $temp;
////                            }
//                            $j = 0;
//                            $i = $sizeStr -1;
//                            while($j < $i){
//                                $temp = $str[$i];
//                                $str[$i] = $str[$j];
//                                $str[$j] = $temp;
//                                $i --;
//                                $j ++;
//                            }
//                           // return $str;
//                            echo "Revert Istring: ". $str;
//                        }
//                        $str = "klop";
//                        reverseStringFunction($str);
                        //print_r(reverseStringFunction($str));
//================= End ===========================================================

                        //===================================== Perfect Number Start ==================================
                        //==============================way-1
//                        function isPerfect($n)
//                        {
//                            $sum = 1;
//                            for ($i = 2; $i * $i <= $n; $i++)
//                            {
//                                if ($n % $i == 0)
//                                {
//                                    if($i * $i != $n)
//                                        $sum = $sum + $i + (int)($n / $i);
//                                    else
//                                        $sum = $sum + $i;
//                                }
//                            }
//                            if ($sum == $n && $n != 1)
//                                return true;
//
//                            return false;
//                        }
//
//                        echo "Below are all perfect numbers till 10000\n";
//                        for ($n = 2; $n < 10000; $n++)
//                            if (isPerfect($n))
//                                echo "$n is a perfect number\n";
                        //==================way -2
//                        function isPerfectNumber($N)
//                        {
//                            // To store the sum
//                            $sum = 0;
//
//                            // Traversing through each number
//                            // In the range [1,N)
//                            for ($i = 1; $i < $N; $i++)
//                            {
//                                if ($N % $i == 0)
//                                {
//                                    $sum = $sum + $i;
//                                }
//                            }
//
//                            // returns True is sum is equal
//                            // to the original number.
//                            return $sum == $N;
//                        }
//
//                        // Driver's code
//                        $N = 7;
//
//                        if (isPerfectNumber($N))
//                            echo $N." is Perfect Number";
//                        else
//                            echo $N." is Not  Perfect Number";

                        //========================== End =================================

//                        $str1 = 'yabadabadoo';
//                        $str2 = 'yaba';
//                        if (strpos($str1,$str2) !== false) {
//                            echo "\"" . $str1 . "\" contains \"" . $str2 . "\"";
//                        } else {
//                            echo "\"" . $str1 . "\" does not contain \"" . $str2 . "\"";
//                        }

//                        $x = 5;
//                        echo $x;
//                        echo "<br />";
//                        echo $x+++$x++;
//                        echo "<br />";
//                        echo $x;
//                        echo "<br />";
//                        echo $x---$x--;
//                        echo "<br />";
//                        echo $x;

                        //====================== calculate power ==================
//                        function power($x, $y)
//                        {
////                            if ($y == 0)
////                                return 1;
////                            else if ($y % 2 == 0)
////                                return power($x, (int)$y / 2) *
////                                    power($x, (int)$y / 2);
////                            else
////                                return $x * power($x, (int)$y / 2) *
////                                    power($x, (int)$y / 2);
//
//
//                            if( $y == 0)
//                                return 1;
//                            $temp = power($x, $y/2);
//
//
//                            if ($y%2 == 0)
//
//                                return $temp*$temp;
//
//                            else
//
//                           // echo $temp."---r--"; //exit();
//                            return $x*$temp*$temp;
//                        }
//
//                        // Driver Code
//                        $x = 2;
//                        $y = 8;
//
//                        echo power($x, $y);

//                        function power($x, $y)
//                        {
//                            // Initialize result
//                            $res = 1;
//
//                            while ($y > 0)
//                            {
//
//                                // If y is odd, multiply
//                                // x with result
//                                if ($y & 1)
//                                    $res = $res * $x;
//
//                                // n must be even now
//
//                                // y = y/2
//                                $y = $y >> 1;
//
//                                // Change x to x^2
//                                $x = $x * $x;
//                            }
//                            return $res;
//                        }
//                        // Driver Code
//                        $x = 2;
//                        $y = 3;
//                        echo "Power is ", power($x, $y);


//                        $a = '7';
//                        $b = $a;
//                        echo $b;
//                        $b = "9$b";

//                        var_dump(0123 == 123);
//                        var_dump('0123' == 123);
//                        var_dump('0123' === 123);


                        //======================== end ========================

                        //=================Find first and last digits of a number start=====
//                        function firstDigit($n)
//                        {
//                            while ($n >= 10)
//                            {
//                                $n = $n / 10;
//                            }
//                            return (int)$n;
//                        }
//
//                        function lastDigit($n)
//                        {
//                            $n = $n % 10;
//                            return (int)$n;
//
//                        }
//
//                        $n = 765439;
//                        echo "Number: ".$n."---". firstDigit($n)."---".lastDigit($n)."\n";

                        //========================
                      //===================================== count word from String ==============
                        $OUT = 0;
                        $IN = 1;
                        function countWords($str)
                        {
                            global $OUT, $IN;
                            $state = $OUT;
                            $word = 0;
                            $i = 0;
                            while ($i < strlen($str))
                            {
                                if ($str[$i] == " " || $str[$i] == "\n" || $str[$i] == "\t")
                                    $state = $OUT;
                                elseif ($state == $OUT)
                                {
                                    $state = $IN;
                                    ++$word;
                                }
                                ++$i;
                            }
                            return $word;
                        }
                        $str = "One two      three\n four\tfive\n six";
                        echo "No of Words : ". countWords($str);

                        //=====================================end=================================

                        ?>
					</div>


        
					<div class="clr"></div>
		    </div>
      </div>
      <div class="sidebar">
    <?php include_once("mySideBar.php"); ?>
   </div>
      <div class="clr"></div>
    </div>
 <?php echo form_close()?>
  </div>
  <!--/body-->
  </html>