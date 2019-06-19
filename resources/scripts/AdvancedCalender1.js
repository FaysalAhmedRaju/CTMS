
var JACS = new function()
	{
	 var dateNow = new Date(Date.parse(new Date().toDateString()));
	
	 var cals = new Array();


	 function getEl(id) {return document.getElementById(id);}

	
	 document.writeln("<!--[if IE]><div id='jacsIE'></div><![endif]-->");
	 document.writeln("<!--[if lt IE 7]><div id='jacsIElt7'></div><![endif]-->");



	document.writeln(
		'<style type="text/css">' +
			'.jacs, .jacsStatic {padding:1px;vertical-align:middle;}' +
			'iframe.jacs        {position:absolute;visibility:hidden;' +
								'top:0px;left:0px;width:1px;height:1px;}' +
			'table.jacs, ' +
			'table.jacsStatic   {padding:0px;visibility:hidden;width:200px;'+
								'cursor:default;text-align:center;}' +
			'table.jacs         {top:0px;left:0px;position:absolute;}' +
		'</style>'  );



	document.writeln(
		'<style type="text/css">' +
			'/* IMPORTANT:  The JACS calendar script requires all ' +
			'               the classes defined here. */' +
			'table.jacs,' +
			'table.jacsStatic   {padding:       1px;' +
								'vertical-align:middle;' +
								'border:        ridge 2px;' +
								'font-size:     10pt;' +
								'font-family:   Verdana,Arial,Helvetica,' +
												'Sans-Serif;' +
								'font-weight:   bold;}' +
			'td.jacsDrag,' +
			'td.jacsHead                 {padding:       0px 0px;' +
										 'text-align:    center;}' +
			'td.jacsDrag                 {font-size:     8pt;}' +
			'select.jacsHead             {margin:        3px 1px;}' +
			'input.jacsHead              {height:        22px;' +
										 'width:         22px;' +
										 'vertical-align:middle;' +
										 'text-align:    center;' +
										 'margin:        2px 1px;' +
										 'font-weight:   bold;' +
										 'font-size:     10pt;' +
										 'font-family:   fixedSys;}' +
			'td.jacsWeekNumberHead,' +
			'td.jacsWeek                 {padding:       0px;' +
										 'text-align:    center;' +
										 'font-weight:   bold;}' +
			'td.jacsFoot,' +
			'td.jacsFootHover,' +
			'td.jacsFoot:hover,' +
			'td.jacsFootDisabled         {padding:       0px;' +
										 'text-align:    center;' +
										 'font-weight:   normal;}' +
			'table.jacsCells             {text-align:    right;' +
										 'font-size:     8pt;' +
										 'width:         96%;}' +
			'td.jacsCells,' +
			'td.jacsCellsHover,' +
			'td.jacsCells:hover,' +
			'td.jacsCellsDisabled,' +
			'td.jacsCellsExMonth,' +
			'td.jacsCellsExMonthHover,' +
			'td.jacsCellsExMonth:hover,' +
			'td.jacsCellsExMonthDisabled,' +
			'td.jacsCellsWeekend,' +
			'td.jacsCellsWeekendHover,' +
			'td.jacsCellsWeekend:hover,' +
			'td.jacsCellsWeekendDisabled,' +
			'td.jacsInputDate,' +
			'td.jacsInputDateHover,' +
			'td.jacsInputDate:hover,' +
			'td.jacsInputDateDisabled,' +
			'td.jacsWeekNo,' +
			'td.jacsWeeks                {padding:           3px;' +
										 'width:             16px;' +
										 'height:            16px;' +
										 'border-width:      1px;' +
										 'border-style:      solid;' +
										 'font-weight:       bold;' +
										 'vertical-align:    middle;}' +
			'/* Blend the colours into your page here...    */' +
			'/* Calendar background */' +
			'table.jacs,' +
			'table.jacsStatic            {background-color:  #6666CC;}' +
			'/* Drag Handle */' +
			'td.jacsDrag                 {background-color:  #9999CC;' +
										 'color:             #CCCCFF;}' +
			'/* Week number heading */' +
			'td.jacsWeekNumberHead       {color:             #6666CC;}' +
			'/* Week day headings */' +
			'td.jacsWeek                 {color:             #CCCCCC;}' +
			'/* Week numbers */' +
			'td.jacsWeekNo               {background-color:  #776677;' +
										 'color:             #CCCCCC;}' +
			'/* Enabled Days */' +
			'/* Week Day */' +
			'td.jacsCells                {background-color:  #CCCCCC;' +
										 'color:             #000000;}' +
			'/* Day matching the input date */' +
			'td.jacsInputDate            {background-color:  #CC9999;' +
										 'color:             #FF0000;}' +
			'/* Weekend Day */' +
			'td.jacsCellsWeekend         {background-color:  #CCCCCC;' +
										 'color:             #CC6666;}' +
			'/* Day outside the current month */' +
			'td.jacsCellsExMonth         {background-color:  #CCCCCC;' +
										 'color:             #666666;}' +
			'/* Today selector */' +
			'td.jacsFoot                 {background-color:  #6666CC;' +
										 'color:             #FFFFFF;}' +
			'/* MouseOver/Hover formatting ' +
			'       If you want to "turn off" any of the formatting ' +
			'       then just set to the same as the standard format' +
			'       above. ' +
			' ' +
			'       Note: The reason that the following are' +
			'       implemented using both a class and a :hover' +
			'       pseudoclass is because Opera handles the rendering' +
			'       involved in the class-swap very poorly and IE6 ' +
			'       (and below) only implements pseudoclasses on the' +
			'       anchor tag.' +
			'*/' +
			'/* Active cells */' +
			'td.jacsCells:hover,' +
			'td.jacsCellsHover           {background-color:  #FFFF00;' +
										 'cursor:            pointer;' +
										 'cursor:            hand;' +
										 'color:             #000000;}' +
			'/* Day matching the input date */' +
			'td.jacsInputDate:hover,' +
			'td.jacsInputDateHover       {background-color:  #FFFF00;' +
										 'cursor:            pointer;' +
										 'cursor:            hand;' +
										 'color:             #000000;}' +
			'/* Weekend cells */' +
			'td.jacsCellsWeekend:hover,' +
			'td.jacsCellsWeekendHover    {background-color:  #FFFF00;' +
										 'cursor:            pointer;' +
										 'cursor:            hand;' +
										 'color:             #000000;}' +
			'/* Day outside the current month */' +
			'td.jacsCellsExMonth:hover,' +
			'td.jacsCellsExMonthHover    {background-color:  #FFFF00;' +
										 'cursor:            pointer;' +
										 'cursor:            hand;' +
										 'color:             #000000;}' +
			'/* Today selector */' +
			'td.jacsFoot:hover,' +
			'td.jacsFootHover            {color:             #FFFF00;' +
										 'cursor:            pointer;' +
										 'cursor:            hand;' +
										 'font-weight:       bold;}' +
			'/* Disabled cells */' +
			'/* Week Day */' +
			'/* Day matching the input date */' +
			'td.jacsInputDateDisabled    {background-color:  #999999;' +
										 'color:             #000000;}' +
			'td.jacsCellsDisabled        {background-color:  #999999;' +
										 'color:             #000000;}' +
			'/* Weekend Day */' +
			'td.jacsCellsWeekendDisabled {background-color:  #999999;' +
										 'color:             #CC6666;}' +
			'/* Day outside the current month */' +
			'td.jacsCellsExMonthDisabled {background-color:  #999999;' +
										 'color:             #666666;}' +
			'td.jacsFootDisabled         {background-color:  #6666CC;' +
										 'color:             #FFFFFF;}' +
		'</style>');

	function calAttributes(cal)
		{switch (cal.id)
			{case 'EnterYourIDHere':

				

				

				break;
			 default:

				
				cal.zIndex = 1;

			

				cal.baseYear = dateNow.getFullYear()-50;

				

				cal.dropDownYears = 80;

				

				cal.weekStart = 1;

				

				cal.weekNumberBaseDay = 4;

				

				cal.weekNumberDisplay = false;

				cal.defaultToCurrentMonth = false;

				

				try   {jacsSetLanguage(cal);}
				catch (exception)
					{
					 cal.language            = 'en';
					 cal.today               = 'Today:';
					 cal.drag                = 'click here to drag';
					 cal.monthNames          = ['Jan','Feb','Mar','Apr','May','Jun',
												'Jul','Aug','Sep','Oct','Nov','Dec'];
					 cal.weekInits           = ['S','M','T','W','T','F','S'];
					 cal.invalidDateMsg      = 'The entered date is invalid.\n';
					 cal.outOfRangeMsg       = 'The entered date is out of range.';
					 cal.doesNotExistMsg     = 'The entered date does not exist.';
					 cal.invalidAlert        = ['Invalid date (',') ignored.'];
					 cal.dateSettingError    = ['Error ',' is not a Date object.'];
					 cal.rangeSettingError   = ['Error ',' should consist of two elements.'];
					}

				

				cal.showInvalidDateMsg      = true;
				cal.showOutOfRangeMsg       = true;
				cal.showDoesNotExistMsg     = true;
				cal.showInvalidAlert        = true;
				cal.showDateSettingError    = true;
				cal.showRangeSettingError   = true;

				

				cal.delimiters = ['/','-','.',':',',',' '];

				

				cal.dateDisplayFormat = 'DD MMM YYYY';    

				
				cal.dateOutputFormat  = 'YYYY-MM-DD'; 

				
				cal.dateInputSequence = 'YMD';        

				

				cal.strict = false;

				

				cal.valuesEnabled = false;

				

				cal.dayCells = [true, true, true, true, true, true, true,
								true, true, true, true, true, true, true,
								true, true, true, true, true, true, true,
								true, true, true, true, true, true, true,
								true, true, true, true, true, true, true,
								true, true, true, true, true, true, true];

				

				cal.dates = new Array();

			
			

				cal.outOfRangeDisable = true;

			

				cal.outOfMonthDisable = false;
				cal.outOfMonthHide    = false;

				
				
				cal.formatTodayCell = true;
				cal.todayCellBorderColour = '#f00'; // red

				

				cal.allowDrag = false;

				

				cal.onBlurMoveNext = false;

				
				cal.clickToHide = false;

				

				cal.xBase     = 'L';
				cal.yBase     = 'B';
				cal.xPosition = 'L';
				cal.yPosition = 'T';

				
				

				cal.dateReturned  = false;

				

				cal.seedDate      = new Date();
				cal.fullInputDate = false;
				cal.activeToday   = true;
				cal.monthSum      = 0;
				cal.days          = new Array();
				cal.arrOnNext     = new Array();
				cal.triggerEle,
				cal.targetEle;
			}
		}


	

	Date.prototype.jacsFormat =
		function(format,monthNames)
			{var charCount = 0,
				 codeChar  = '',
				 result    = '';

			 for (var i=0;i<=format.length;i++)
				{if (i<format.length && format.charAt(i)==codeChar)
						{
						 charCount++;
						}
				 else   {switch (codeChar)
							{case 'y': case 'Y':
								result += (this.getFullYear()%Math.pow(10,charCount)).toString().jacsPadLeft(charCount);
								break;
							 case 'm': case 'M':
								
								result += (charCount<3)
											?(this.getMonth()+1).toString().jacsPadLeft(charCount)
											:monthNames[this.getMonth()];
								break;
							 case 'd': case 'D':
								
								result += this.getDate().toString().jacsPadLeft(charCount);
								break;
							 default:
								
								while (charCount-->0) {result += codeChar;}
							}

						 if (i<format.length)
							{
							 codeChar  = format.charAt(i);
							 charCount = 1;
							}
						}
				}
			 return result;
			}

	

	String.prototype.jacsPadLeft =
		function(padToLength)
			{var result = '';
			 for (var i=0;i<(padToLength-this.length);i++) result += '0';
			 return (result+this);
			}

	

	Function.prototype.jacsRunNext =
		function()  {var func = this, args = arguments[0];
					 func.JACScalId = arguments[1];
					 return function() {return func.apply(this, args);}
					}


	if (document.addEventListener)
		 window.addEventListener(  'load',jacsLoader,true);
	else window.attachEvent     ('onload',jacsLoader);

	function jacsLoader()
		{

		 if (document.addEventListener)
			  document.addEventListener('click',hide, false);
		 else document.attachEvent('onclick',hide);

		 

		 if (getEl('jacsIElt7')) window.attachEvent('onbeforeunload',defeatLeaks);

		 function defeatLeaks()
			{for (var i=0;i<cals.length;i++)
				{
				 getEl(cals[i]+'Week_').style.display='';

				 for (var j=0;j<6;j++) getEl(cals[i]+'Week_'+j).style.display='';

				

				 getEl(cals[i]+'Foot').onclick     = null;
				 getEl(cals[i]+'Foot').onmouseover = null;
				 getEl(cals[i]+'Foot').onmouseout  = null;

				 var cal    = getEl(cals[i]),
					 cells  = getEl(cals[i]+'Cells').childNodes;

				 for (var j=0;j<cells.length;j++)
					{var rows = cells[j].childNodes;
					 for (var k=1;k<rows.length;k++)
						{rows[k].onclick     = null;
						 rows[k].onmouseover = null;
						 rows[k].onmouseout  = null;
						}
					}

			

				 cal.arrOnClose  = null;
				 cal.onClose     = null;
				 cal.arrOnSelect = null;
				 cal.onSelect    = null;
				 cal.ele         = null;
				}
            }
		}



	function showMonth(bias,calId)
		{

		 var cal       = getEl(calId),
			 showDate  = new Date(Date.parse(new Date().toDateString())),
			 startDate = new Date();

		

		 showDate.setHours(12);

		 selYears  = getEl(calId+'Years');
		 selMonths = getEl(calId+'Months');

		 if ( selYears.options.selectedIndex>-1) cal.monthSum  = 12*(selYears.options.selectedIndex)+bias;
		 if (selMonths.options.selectedIndex>-1) cal.monthSum += selMonths.options.selectedIndex;

		 showDate.setFullYear(cal.baseYear+Math.floor(cal.monthSum/12),(cal.monthSum%12),1);

	

		 getEl(calId+'Week_').style.display = (cal.weekNumberDisplay)?'':'none';

		 if ((12*parseInt((showDate.getFullYear()-cal.baseYear),10))+parseInt(showDate.getMonth(),10) < (12*cal.dropDownYears) &&
			 (12*parseInt((showDate.getFullYear()-cal.baseYear),10))+parseInt(showDate.getMonth(),10) > -1)
			{selYears.options.selectedIndex  = Math.floor(cal.monthSum/12);
			 selMonths.options.selectedIndex = (cal.monthSum%12);

			 curMonth = showDate.getMonth();

			 showDate.setDate((((showDate.getDay()-cal.weekStart)<0)?-6:1)+cal.weekStart-showDate.getDay());

			 var compareDateValue = new Date(showDate.getFullYear(),showDate.getMonth(),showDate.getDate()).valueOf();

			 startDate = new Date(showDate);

			 if (getEl(calId+'Foot'))
				{var foot = getEl(calId+'Foot');

				 function footOutput() {setOutput(dateNow,calId);}

				 if (cal.dates.length==0)
					{if (cal.activeToday)
						{foot.onclick   = footOutput;
						 foot.className = 'jacsFoot';

						 if (getEl('jacsIE'))
							{foot.onmouseover = changeClass;
							 foot.onmouseout  = changeClass;
							}

						 if (document.removeEventListener)
								{foot.removeEventListener('click',stopPropagation,false);}
						 else   {foot.detachEvent(      'onclick',stopPropagation);}
						}
					 else
						{foot.onclick   = null;
						 foot.className = 'jacsFootDisabled';

						 if (getEl('jacsIE'))
							{foot.onmouseover = null;
							 foot.onmouseout  = null;
							}

						 if (document.addEventListener)
								{foot.addEventListener('click',stopPropagation,false);}
						 else   {foot.attachEvent(   'onclick',stopPropagation);}
						}
					}
				 else
					{for (var k=0;k<cal.dates.length;k++)
						{if (!cal.activeToday ||
							 (typeof cal.dates[k]=='object' &&
								  ((cal.dates[k].constructor==Date  && dateNow.valueOf() == cal.dates[k].valueOf()) ||
								   (cal.dates[k].constructor==Array && dateNow.valueOf() >= cal.dates[k][0].valueOf() &&
																	   dateNow.valueOf() <= cal.dates[k][1].valueOf()
								   )
								  )
							 )
							)
							{foot.onclick   = (cal.valuesEnabled)?footOutput:null;
							 foot.className = (cal.valuesEnabled)?'jacsFoot':'jacsFootDisabled';

							 if (getEl('jacsIE'))
								{foot.onmouseover = (cal.valuesEnabled)?changeClass:null;
								 foot.onmouseout  = (cal.valuesEnabled)?changeClass:null;
								}

							 if (cal.valuesEnabled)
								{if (document.removeEventListener) foot.removeEventListener('click',stopPropagation,false);
								 else                              foot.detachEvent(      'onclick',stopPropagation);
								}
							 else
								{if (document.addEventListener) foot.addEventListener('click',stopPropagation,false);
								 else                           foot.attachEvent(   'onclick',stopPropagation);
								}

							 break;
							}
						 else
							{foot.onclick   = (cal.valuesEnabled)?null:footOutput;
							 foot.className = (cal.valuesEnabled)?'jacsFootDisabled':'jacsFoot';

							 if (getEl('jacsIE'))
								{foot.onmouseover = (cal.valuesEnabled)?null:changeClass;
								 foot.onmouseout  = (cal.valuesEnabled)?null:changeClass;
								}

							 if (cal.valuesEnabled)
								{if (document.addEventListener) foot.addEventListener('click',stopPropagation,false);
								 else                           foot.attachEvent(   'onclick',stopPropagation);
								}
							 else
								{if (document.removeEventListener) foot.removeEventListener('click',stopPropagation,false);
								 else                              foot.detachEvent(      'onclick',stopPropagation);
								}
							}
						}
					}
				}

			 function setOutput(outputDate,calId)
				{var cal = getEl(calId);

				 if (typeof cal.targetEle.value == 'undefined')
						cal.triggerEle.textNode.replaceData(0,cal.triggerEle.len,outputDate.jacsFormat(cal.dateOutputFormat,cal.monthNames));
				 else   cal.ele.value = outputDate.jacsFormat(cal.dateOutputFormat,cal.monthNames);

				 cal.dateReturned = true;

				 if (cal.dynamic) hide(calId);
				 else {if (typeof cal.onNext!='undefined' && cal.onNext!=null) cal.onNext();
					   JACS.show(cal.ele,cal.id,cal.days);
					  }

				 if (cal.onBlurMoveNext)
					{

					 var tagsToFind = 'INPUT;A;SELECT;TEXTAREA;BUTTON;AREA;OBJECT',
						 found      = false;

					 if (cal.ele.tabIndex>0)
						{var tags = tagsToFind.split(';');

						 tagsOuterLoop:
						 for (var i=0;tags.length;i++)
							{elementsByTag = document.getElementsByTagName(tags[i]);

							 for (var j=0;j<elementsByTag.length;j++)
								if (elementsByTag[j].tabIndex==(cal.ele.tabIndex+1) && !elementsByTag[j].disabled &&
									elementsByTag[j].type!='hidden' && elementsByTag[j].style.display!='none' &&
									elementsByTag[j].style.visibility!='hidden')
									{elementsByTag[j].focus();
									 found = true;
									 break tagsOuterLoop;
									}
							}
						}

					

					 if (!found)
						{
						 function orderElements()
							{var tabOrder  = new Array,
								 unordered = new Array;

							 function elementArrays(ele)
								{for (var i=0;i<ele.childNodes.length;i++)
									{var tempEle = ele.childNodes[i];
									 if (tempEle.nodeType==1 && tempEle.style.display!='none' &&
										 !tempEle.disabled   && tempEle.type!='hidden' &&
										 tempEle.style.visibility!='hidden')
										{if (tagsToFind.indexOf(tempEle.tagName)>-1)
											{if (tempEle.tabIndex>0) tabOrder[tempEle.tabIndex]  = tempEle;
											 else                    unordered[unordered.length] = tempEle;
											}
										 elementArrays(tempEle);
										}
									}
								}

							 elementArrays(document.body);

							 while (tabOrder.length>0 && tabOrder[0]==null) {tabOrder.shift();}

							 return tabOrder.concat(unordered);
							}

						 var tabSequenced = orderElements();

						

						 for (var i=0;i<tabSequenced.length;i++)
							if (tabSequenced[i]==cal.targetEle)
								{if (i<(tabSequenced.length-1)) tabSequenced[i+1].focus();
								 else                           tabSequenced[0].focus();
								 break;
								}
						}
					}
				 else if (!cal.targetEle.disabled      && cal.targetEle.style.display!='none' &&
						  cal.targetEle.type!='hidden' && cal.targetEle.style.visibility!='hidden')	cal.targetEle.focus();
				}

			 function changeClass(evt)
				{var ele = eventTrigger(evt);

				 if (ele.nodeType==3) ele=ele.parentNode;

				 if (((evt)?evt.type:event.type)=='mouseover')
					{switch (ele.className)
						{case 'jacsCells':
							ele.className = 'jacsCellsHover';        break;
						 case 'jacsCellsExMonth':
							ele.className = 'jacsCellsExMonthHover'; break;
						 case 'jacsCellsWeekend':
							ele.className = 'jacsCellsWeekendHover'; break;
						 case 'jacsFoot':
							ele.className = 'jacsFootHover';         break;
						 case 'jacsInputDate':
							ele.className = 'jacsInputDateHover';
						}
					}
				 else
					{switch (ele.className)
						{case 'jacsCellsHover':
							ele.className = 'jacsCells';             break;
						 case 'jacsCellsExMonthHover':
							ele.className = 'jacsCellsExMonth';      break;
						 case 'jacsCellsWeekendHover':
							ele.className = 'jacsCellsWeekend';      break;
						 case 'jacsFootHover':
							ele.className = 'jacsFoot';              break;
						 case 'jacsInputDateHover':
							ele.className = 'jacsInputDate';
						}
					}
				 return true;
				}

			 function eventTrigger(evt)
				{if (!evt) evt = event;
				 return evt.target||evt.srcElement;
				}

			 function weekNumber(inDate)
				{
				 var inDateWeekBase = new Date(inDate);

				 inDateWeekBase.setDate(inDateWeekBase.getDate() - inDateWeekBase.getDay() + cal.weekNumberBaseDay +
											((inDate.getDay() > cal.weekNumberBaseDay)?7:0));

				
				 var firstBaseDay = new Date(inDateWeekBase.getFullYear(),0,1)

				 firstBaseDay.setDate(firstBaseDay.getDate() - firstBaseDay.getDay() + cal.weekNumberBaseDay);

				 if (firstBaseDay<new Date(inDateWeekBase.getFullYear(),0,1))
					 firstBaseDay.setDate(firstBaseDay.getDate()+7);

				
				 var startWeekOne = new Date(firstBaseDay - cal.weekNumberBaseDay + inDate.getDay());

				 if (startWeekOne>firstBaseDay) startWeekOne.setDate(startWeekOne.getDate()-7);

				

				 var weekNo = '0'+(Math.round((inDateWeekBase - firstBaseDay)/604800000,0)+1);

				

				 return weekNo.substring(weekNo.length-2,weekNo.length);
				}

		

			 var cells = getEl(calId+'Cells').childNodes;

			 for (var i=0;i<cells.length;i++)
				{var rows = cells[i];
				 if (rows.nodeType==1 && rows.tagName=='TR')
					{tmpEl = rows.childNodes[0];
				     if (cal.weekNumberDisplay)
						  {
						   tmpEl.innerHTML = weekNumber(showDate);
                           tmpEl.style.borderColor = 
							   (tmpEl.currentStyle)
									?tmpEl.currentStyle['backgroundColor']
									:(window.getComputedStyle)
										?document.defaultView.getComputedStyle(tmpEl,null).getPropertyValue('background-color')
										:'';
						   tmpEl.style.display = '';
						  }
					 else  tmpEl.style.display='none';

					 for (var j=1;j<rows.childNodes.length;j++)
						{var cols = rows.childNodes[j];
						 if (cols.nodeType==1 && cols.tagName=='TD')
							{rows.childNodes[j].innerHTML = showDate.getDate();

							 var cell = rows.childNodes[j];

							 cell.style.visibility = (cal.outOfMonthHide &&
													  (showDate < (new Date(showDate.getFullYear(),curMonth,1,showDate.getHours())) ||
													   showDate > (new Date(showDate.getFullYear(),curMonth+1,0,showDate.getHours()))
													  )
													 )?'hidden':'';

							
							 var disabled = cal.valuesEnabled;

							 if ((cal.outOfRangeDisable && (showDate < (new Date(cal.baseYear,0,1,12)) ||
															showDate > (new Date(cal.baseYear+cal.dropDownYears,0,0,12))
														   )
								 ) ||
								 (cal.outOfMonthDisable && (showDate < (new Date(showDate.getFullYear(),curMonth,1,showDate.getHours())) ||
															showDate > (new Date(showDate.getFullYear(),curMonth+1,0,showDate.getHours()))
														   )
								 )
								) disabled = true;
							 else
								{if ((cal.days.join().search(((j-1+(7*(i*cells.length/6))+cal.weekStart)%7))>-1) ||
									  !cal.dayCells[j-1+(7*((i*cells.length)/6))]
									)   {disabled = !cal.valuesEnabled;} // Set (Disable or Enable) if the day is passed as a parameter of JACS.show
								 else   {for (var k=0;k<cal.dates.length;k++)
											{if (typeof cal.dates[k]=='object' &&
												 ((cal.dates[k].constructor==Date  && compareDateValue == cal.dates[k].valueOf()) ||
												  (cal.dates[k].constructor==Array && compareDateValue >= cal.dates[k][0].valueOf() &&
																					  compareDateValue <= cal.dates[k][1].valueOf()
												  )
												 )
												)
												{disabled = !cal.valuesEnabled;
												 break;
												}
											}
										}
								}

							 if (disabled)
								{rows.childNodes[j].onclick = null;

								 if (getEl('jacsIE'))
									{rows.childNodes[j].onmouseover = null;
									 rows.childNodes[j].onmouseout  = null;
									}

								 cell.className=
									(showDate.getMonth()!=curMonth)
										?'jacsCellsExMonthDisabled'
										:(cal.fullInputDate && compareDateValue==cal.seedDate.valueOf())
											?'jacsInputDateDisabled'
											:(showDate.getDay()%6==0)
												?'jacsCellsWeekendDisabled'
												:'jacsCellsDisabled';

                                 cell.style.borderColor = 
									 (cal.formatTodayCell && showDate.toDateString()==dateNow.toDateString())
										?cal.todayCellBorderColour
										:(cell.currentStyle)
											?cell.currentStyle['backgroundColor']
											:(window.getComputedStyle)
												?document.defaultView.getComputedStyle(cell,null).getPropertyValue('background-color')
												:'';
								}
							 else
								{function cellOutput(evt)
									{var ele = eventTrigger(evt),
										 outputDate = new Date(startDate);

									 if (ele.nodeType==3) ele=ele.parentNode;

									 outputDate.setDate(startDate.getDate() +
										parseInt(ele.id.substr(calId.length+5),10));

									 setOutput(outputDate,calId);
									}

								 rows.childNodes[j].onclick=cellOutput;

								 if (getEl('jacsIE'))
									{rows.childNodes[j].onmouseover = changeClass;
									 rows.childNodes[j].onmouseout  = changeClass;
									}

								 cell.className=
									 (showDate.getMonth()!=curMonth)
										?'jacsCellsExMonth'
										:(cal.fullInputDate && compareDateValue==cal.seedDate.valueOf())
											?'jacsInputDate'
											:(showDate.getDay()%6==0)
												?'jacsCellsWeekend'
												:'jacsCells';

                                 cell.style.borderColor = 
									 (cal.formatTodayCell && showDate.toDateString()==dateNow.toDateString())
										?cal.todayCellBorderColour
										:(cell.currentStyle)
											?cell.currentStyle['backgroundColor']
											:(window.getComputedStyle)
												?document.defaultView.getComputedStyle(cell,null).getPropertyValue('background-color')
												:'';
							   }

							 showDate.setDate(showDate.getDate()+1);
							 compareDateValue = new Date(showDate.getFullYear(),
														 showDate.getMonth(),
														 showDate.getDate()).valueOf();
							}
						}
					}
				}
			}

		
		 cal.style.visibility = 'hidden';
		 cal.style.visibility = 'visible';
		}

	 function hide(instanceID)
		{if (typeof instanceID=='object')
				for (var i=0;i<cals.length;i++) hideOne(cals[i]);
		 else   hideOne(instanceID);

		 function hideOne(id)
			{cal = getEl(id);

			 if (cal.dynamic)
				{cal.style.visibility = 'hidden';

				 if (getEl('jacsIE')) getEl(id+'Iframe').style.visibility='hidden';

				 doNext(cal);
				}
			}
		}

	 function doNext(cal)
		{if (cal.arrOnNext.length > 0)
			 {cal.onNext = cal.arrOnNext.shift();
			  cal.onNext();
			
			  cal.onNext = null;
			 }
		}

	 function stopPropagation(evt)
	   {if (evt.stopPropagation) 
			 {if (evt.target!=evt.currentTarget) {evt.stopPropagation(); evt.preventDefault();}}
		else evt.cancelBubble = true;
	   }


	 return {show: function(ele)
				{

				 if (typeof arguments[1]=='object')
					{var sourceEle = arguments[1], dynamic = true;

					 if (typeof arguments[2]=='string')
							var calId = arguments[2], min = 3;
					 else   var calId = 'jacs',       min = 2;

					

					 if (sourceEle.tagName!='A')
						{
						 var tmpEl = (sourceEle.parentNode)?sourceEle.parentNode:sourceEle;
						 if (tmpEl.addEventListener) tmpEl.addEventListener('click',stopPropagation,false);
						}

					 if (sourceEle.attachEvent)			   sourceEle.attachEvent('onclick',stopPropagation);
					 else if (!sourceEle.addEventListener) event.cancelBubble = true;
					}
				 else
					{var sourceEle = ele, dynamic = false;

					 if (typeof arguments[1]=='string')
							var calId = arguments[1], min = 2;
					 else   var calId = 'jacs',       min = 1;
					}

			

				 if (document.addEventListener)
						ele.addEventListener('keydown',hideOnTab,false);
				 else   ele.attachEvent('onkeydown',hideOnTab);

				 function hideOnTab(evt)
					{if (!evt) var evt = window.event;
					 if ((evt.keyCode||evt.which)==9) hide(calId);
					}

				

			

				 if (!getEl(calId)) JACS.make(calId,dynamic);

				 cal = getEl(calId);

				

				 if (getEl('jacsIE') && event && cal.dateReturned && !cal.onBlurMoveNext)
					if (event.type == 'focus') {cal.dateReturned = false; return false;}

				 if (cal.style.visibility != 'hidden' && cal.style.visibility != '') doNext(cal);

				 cal.triggerEle = sourceEle;

				 cal.dateReturned = false;
				 cal.activeToday  = true;

				

				 if (typeof arguments[min]=='object')
					{for (var i=0;i<arguments[min].length;i++)
						if (cal.days.join().indexOf(arguments[min][i])==-1)
							cal.days.push(arguments[min][i]);
					}
				 else
					{for (var i=min;i<arguments.length;i++)
						if (cal.days.join().indexOf(arguments[i])==-1)
							cal.days.push(arguments[i]);
					}

				 for (var i=0;i<cal.days.length;i++)
					if (dateNow.getDay()==cal.days[i]%7)
						{cal.activeToday = false; break;}

				

				 cal.seedDate = dateNow;

			

				 if (typeof ele.value == 'undefined')
					{var childNodes = ele.childNodes;
					 for (var i=0;i<childNodes.length;i++)
						if (childNodes[i].nodeType == 3)
							{var dateValue = childNodes[i].nodeValue.replace(/^\s+/,'').replace(/\s+$/,'');
							 if (dateValue.length > 0)
								{cal.triggerEle.textNode = childNodes[i];
								 cal.triggerEle.len      = childNodes[i].nodeValue.length;
								 break;
								}
							}
					 }
				  else
					 {var dateValue = ele.value.replace(/^\s+/,'').replace(/\s+$/,'');}

		

				 var yearOptions = getEl(calId+'Years').options;

				 if (yearOptions.length==0 || yearOptions[0].value!=cal.baseYear)
					{yearOptions.length = 0;
					 for (var i=0;i<cal.dropDownYears;i++) yearOptions[i] = new Option((cal.baseYear+i),(cal.baseYear+i));
					}

				 if (dateValue.length==0)
					{

					 cal.fullInputDate=false;

					 if ((new Date(cal.baseYear+cal.dropDownYears,0,0))<cal.seedDate ||
						 (new Date(cal.baseYear,0,1))                  >cal.seedDate
						)
						cal.seedDate = new Date(cal.baseYear+Math.floor(cal.dropDownYears / 2), 5, 1);
					}
				 else
					{function inputFormat()
						{var seed = new Array(),
							 input = dateValue.split(new RegExp('[\\'+cal.delimiters.join('\\')+']+','g'));

						

						 if (input[0]!=null)
							{if (input[0].length==0)              input.splice(0,1);
							 if (input[input.length-1].length==0) input.splice(input.length-1,1);
							}

						 cal.fullInputDate = false;

						 switch (input.length)
							{case 1:
								{
								 seed[0] = parseInt(input[0],10);                                                    // Year
								 seed[1] = cal.defaultToCurrentMonth?(dateNow.getMonth()+1).toString():'6';          // Month
								 seed[2] = 1;                                                                        // Day
								 break;
								}
							 case 2:
								{
								 seed[0] = parseInt(input[cal.dateInputSequence.replace(/D/i,'').search(/Y/i)],10);  // Year
								 seed[1] = input[cal.dateInputSequence.replace(/D/i,'').search(/M/i)];               // Month
								 seed[2] = 1;                                                                        // Day
								 break;
								}
							 case 3:
								{
								 seed[0] = parseInt(input[cal.dateInputSequence.search(/Y/i)],10);  // Year
								 seed[1] = input[cal.dateInputSequence.search(/M/i)];               // Month
								 seed[2] = parseInt(input[cal.dateInputSequence.search(/D/i)],10);  // Day
								 cal.fullInputDate = true;
								 break;
								}
							 default:
								{
								 seed[0] = 0;     // Year
								 seed[1] = 0;     // Month
								 seed[2] = 0;     // Day
								}
							}

						

						 var expValDay    = new RegExp('^(0?[1-9]|[1-2][0-9]|3[0-1])$'),
							 expValMonth  = new RegExp('^(0?[1-9]|1[0-2]|'+cal.monthNames.join('|')+')$','i'),
							 expValYear   = new RegExp('^([0-9]{1,2}|[0-9]{4})$');

						

						 if (expValYear.exec(seed[0]) ==null ||
							 expValMonth.exec(seed[1])==null ||
							 expValDay.exec(seed[2])  ==null
							)
							{if (cal.invalidDateMsg)
								alert(cal.invalidDateMsg + cal.invalidAlert[0] + dateValue + cal.invalidAlert[1]);
							 seed[0] = cal.baseYear + Math.floor(cal.dropDownYears/2);                   // Year
							 seed[1] = cal.defaultToCurrentMonth?(dateNow.getMonth()+1).toString():'6';  // Month
							 seed[2] = 1;                                                                // Day
							 cal.fullInputDate = false;
							}

						

						 return seed;
						}

					

					 seedDate = inputFormat();

					

					 if (seedDate[0]<100) seedDate[0] += (seedDate[0]>50)?1900:2000;

					

					 if (seedDate[1].search(/\d+/)!=0)
						{month = cal.monthNames.join('|').toUpperCase().search(seedDate[1].substr(0,3).toUpperCase());
						 seedDate[1] = Math.floor(month/4)+1;
						}

					 cal.seedDate = new Date(seedDate[0],seedDate[1]-1,seedDate[2]);
					}

				

				 if (isNaN(cal.seedDate))
					{if (cal.showInvalidDateMsg)
						alert(cal.invalidDateMsg + cal.invalidAlert[0] + dateValue + cal.invalidAlert[1]);
					 cal.seedDate = new Date(cal.baseYear + Math.floor(cal.dropDownYears/2),5,1);
					 cal.fullInputDate = false;
					}
				 else
					{

					 if ((new Date(cal.baseYear,0,1))>cal.seedDate)
						{if (cal.strict && cal.showOutOfRangeMsg) alert(cal.outOfRangeMsg);
						 cal.seedDate = new Date(cal.baseYear,0,1);
						 cal.fullInputDate=false;
						}
					 else
						{if ((new Date(cal.baseYear+cal.dropDownYears,0,0))<cal.seedDate)
							{if (cal.strict && cal.showOutOfRangeMsg) alert(cal.outOfRangeMsg);
							 cal.seedDate = new Date(cal.baseYear + Math.floor(cal.dropDownYears),-1,1);
							 cal.fullInputDate=false;
							}
						 else
							{if (cal.strict && cal.fullInputDate &&
								  (cal.seedDate.getDate()     !=seedDate[2] ||
								   (cal.seedDate.getMonth()+1)!=seedDate[1] ||
								   cal.seedDate.getFullYear() !=seedDate[0]
								  )
								)
								{if (cal.showDoesNotExistMsg) alert(cal.doesNotExistMsg);
								 cal.seedDate = new Date(cal.seedDate.getFullYear(),cal.seedDate.getMonth()-1,1);
								 cal.fullInputDate=false;
								}
							}
						}
					}

				

				 for (var i=0;i<cal.dates.length;i++)
					{if (!((typeof cal.dates[i]=='object') && (cal.dates[i].constructor==Date)))
						{if ((typeof cal.dates[i]=='object') && (cal.dates[i].constructor==Array))
							{var pass = true;

							 if (cal.dates[i].length!=2)
								{if (cal.showRangeSettingError)
									alert(cal.rangeSettingError[0] + cal.dates[i] + cal.rangeSettingError[1]);
								 pass = false;
								}
							 else
								{for (var j=0;j<cal.dates[i].length;j++)
									if (!((typeof cal.dates[i][j]=='object') && (cal.dates[i][j].constructor==Date)))
										{if (cal.showRangeSettingError)
											alert(cal.dateSettingError[0] + cal.dates[i][j] + cal.dateSettingError[1]);
										 pass = false;
										}
								}

							 if (pass && (cal.dates[i][0]>cal.dates[i][1])) cal.dates[i].reverse();
							}
						 else
							{if (cal.showRangeSettingError)
								alert(cal.dateSettingError[0] + cal.dates[i] + cal.dateSettingError[1]);
							}
						}
					}

				

				 getEl(calId+'DragText').innerHTML = cal.drag;

				 var monthOptions = getEl(calId+'Months').options,  months = '';

				 if (monthOptions.length>0) for (var i=0;i<monthOptions.length;i++) months += monthOptions[i].value+',';

				 if (monthOptions.length==0 || (cal.monthNames.join()+',')!=months)
					{monthOptions.length = 0;

					 if (cal.monthNames.length<monthOptions.length) monthOptions.length = cal.monthNames.length;

					 for (var i=0;i<cal.monthNames.length;i++)
						{if (i>monthOptions.length-1)
							  monthOptions[i] = new Option(cal.monthNames[i],cal.monthNames[i]);
						 else monthOptions[i].innerHTML = cal.monthNames[i];
						}
					}

				 for (var i=0;i<cal.weekInits.length;i++)
					getEl(calId+'WeekInit'+i).innerHTML = cal.weekInits[(i+cal.weekStart)%cal.weekInits.length];

				 if (getEl(calId+'Foot'))
					 getEl(calId+'Foot').innerHTML = cal.today+' '+dateNow.jacsFormat(cal.dateOutputFormat,cal.monthNames);

				
				 cal.monthSum =  12*(cal.seedDate.getFullYear() - cal.baseYear) + cal.seedDate.getMonth();

				 
				 getEl(calId+'Years').options.selectedIndex  = Math.floor(cal.monthSum/12);
				 getEl(calId+'Months').options.selectedIndex = (cal.monthSum%12);

				
				 if (window.opera)
					{getEl(calId+'Months').style.display = 'none';
					 getEl(calId+'Months').style.display = 'block';
					 getEl(calId+'Years' ).style.display = 'none';
					 getEl(calId+'Years' ).style.display = 'block';
					}
				

				 getEl(calId).ele = ele;

				
				 showMonth(0,calId);

				
				 cal.targetEle = ele;

				
				 if (dynamic)
					{
					 getEl(calId+'Drag').style.display = (cal.allowDrag)?'':'none';

					 var offsetTop  = parseInt(ele.offsetTop ,10),
						 offsetLeft = parseInt(ele.offsetLeft,10);

					 if (cal.xBase.length>0)
							{if (isNaN(cal.xBase))
									{cal.xBase = cal.xBase.toUpperCase();
									 offsetLeft += (cal.xBase=='R')
														?parseInt(ele.offsetWidth,10)
														:(cal.xBase=='M')?Math.round(parseInt(ele.offsetWidth,10)/2):0;
									}
							 else   offsetLeft += parseInt(cal.xBase,10);
							}

					 if (cal.yBase.length>0)
							{if (isNaN(cal.yBase))
									{cal.yBase  = cal.yBase.toUpperCase();
									 offsetTop += (cal.yBase=='B')
													?parseInt(ele.offsetHeight,10)
													:(cal.yBase=='M')?Math.round(parseInt(ele.offsetHeight,10)/2):0;
									}
							 else   offsetTop += parseInt(cal.yBase,10);
							}
					 else   offsetTop += parseInt(ele.offsetHeight,10);

					 if (cal.xPosition.length>0)
							{if (isNaN(cal.xPosition))
									{cal.xPosition = cal.xPosition.toUpperCase();
									 offsetLeft -= (cal.xPosition=='R')
														?parseInt(cal.offsetWidth,10)
														:(cal.xPosition=='M')?Math.round(parseInt(cal.offsetWidth,10)/2):0;
									}
							 else   offsetLeft += parseInt(cal.xPosition,10);
							}

					 if (cal.yPosition.length>0)
							{if (isNaN(cal.yPosition))
									{cal.yPosition = cal.yPosition.toUpperCase();
									 offsetTop -= (cal.yPosition=='B')
														?parseInt(cal.offsetHeight,10)
														:(cal.yPosition=='M')?Math.round((parseInt(cal.offsetHeight,10))/2):0;
									}
							 else   offsetTop += parseInt(cal.yPosition,10);
							}

					
					 if (!window.opera)
						 {while (ele.tagName!='BODY' && ele.tagName!='HTML')
							 {offsetTop  -= parseInt(ele.scrollTop, 10);
							  offsetLeft -= parseInt(ele.scrollLeft,10);
							  ele = ele.parentNode;
							 }
						  ele = cal.targetEle;
						 }

					 while (ele.tagName!='BODY' && ele.tagName!='HTML')
						{ele = ele.offsetParent;
						 offsetTop  += parseInt(ele.offsetTop, 10);
						 offsetLeft += parseInt(ele.offsetLeft,10);
						}

					 cal.style.top  = offsetTop +'px';
					 cal.style.left = offsetLeft+'px';

					 if (getEl('jacsIE'))
						{getEl(calId+'Iframe').style.top  = offsetTop +'px';
						 getEl(calId+'Iframe').style.left = offsetLeft+'px';

						 getEl(calId+'Iframe').style.width  = cal.offsetWidth -2;
						 getEl(calId+'Iframe').style.height = cal.offsetHeight-2;

						 getEl(calId+'Iframe').style.visibility='visible';
						}
					}

				
				 cal.style.visibility='visible';
				},

			 make: function (calId)
				{cals.push(calId);

				 var dynamic = (typeof arguments[1]=='boolean')?arguments[1]:true;

				 TABLEjacs           = document.createElement('table');
				 TABLEjacs.id        = calId;
				 TABLEjacs.dynamic   = dynamic;
				 TABLEjacs.className = (dynamic)?'jacs':'jacsStatic';

				 calAttributes(TABLEjacs);

				 if (dynamic) TABLEjacs.style.zIndex = TABLEjacs.zIndex+1;

				 function cancel(evt)
					{if (TABLEjacs.clickToHide) hide(calId);
					 stopPropagation(evt);
					}

				 TBODYjacs                 = document.createElement('tbody');
				 TRjacs1                   = document.createElement('tr');
				 TRjacs1.className         = 'jacs';
				 TDjacs1                   = document.createElement('td');
				 TDjacs1.className         = 'jacs';
				 TABLEjacsHead             = document.createElement('table');
				 TABLEjacsHead.id          = calId+'Head';
				 TABLEjacsHead.cellSpacing = '0';
				 TABLEjacsHead.cellPadding = '0';
				 TABLEjacsHead.className   = 'jacsHead';
				 TABLEjacsHead.width       = '100%';

				 TBODYjacsHead             = document.createElement('tbody');

				 TRjacsDrag                = document.createElement('tr');
				 TRjacsDrag.id             = calId+'Drag';
				 TRjacsDrag.style.display  = 'none';

				 TDjacsDrag                = document.createElement('td');
				 TDjacsDrag.className      = 'jacsDrag';
				 TDjacsDrag.colSpan        = '4';

				 function beginDrag(evt)
					{var elToDrag = getEl(calId);

					 var deltaX    = evt.clientX,
						 deltaY    = evt.clientY,
						 offsetEle = elToDrag;

					 while (offsetEle.tagName!='BODY' && offsetEle.tagName!='HTML')
						{deltaX   -= parseInt(offsetEle.offsetLeft,10);
						 deltaY   -= parseInt(offsetEle.offsetTop ,10);
						 offsetEle = offsetEle.offsetParent;
						}

					 if (document.addEventListener)
							{elToDrag.addEventListener('mousemove',moveHandler,true);
							 elToDrag.addEventListener('mouseup',    upHandler,true);
							}
					 else   {elToDrag.attachEvent('onmousemove', moveHandler);
							 elToDrag.attachEvent('onmouseup',     upHandler);
							 elToDrag.setCapture();
							}

					 stopPropagation(evt);

					 function moveHandler(evt)
						{if (!evt) evt = window.event;

						 elToDrag.style.left = (evt.clientX-deltaX)+'px';
						 elToDrag.style.top  = (evt.clientY-deltaY)+'px';

						 if (getEl('jacsIE'))
							{getEl(calId+'Iframe').style.left = (evt.clientX-deltaX)+'px';
							 getEl(calId+'Iframe').style.top  = (evt.clientY-deltaY)+'px';
							}

						 stopPropagation(evt);
						}

					 function upHandler(evt)
						{if (!evt) evt = window.event;

						 if (document.removeEventListener)
								{document.removeEventListener('mousemove',moveHandler,true);
								 document.removeEventListener(  'mouseup',  upHandler,true);
								}
						 else   {elToDrag.detachEvent('onmouseup',    upHandler);
								 elToDrag.detachEvent('onmousemove',moveHandler);
								 elToDrag.releaseCapture();
								}

						 stopPropagation(evt);
						}
					}

				 DIVjacsDragText           = document.createElement('div');
				 DIVjacsDragText.id        = calId+'DragText';

				 TRjacsHead                = document.createElement('tr');
				 TRjacsHead.className      = 'jacsHead';

				 TDjacsHead1               = document.createElement('td');
				 TDjacsHead1.className     = 'jacsHead';

				 INPUTjacsHead1            = document.createElement('input');
				 INPUTjacsHead1.className  = 'jacsHead';
				 INPUTjacsHead1.id         = calId+'HeadLeft';
				 INPUTjacsHead1.type       = 'button';
				 INPUTjacsHead1.tabIndex   = '-1';
				 INPUTjacsHead1.value      = '<';
				 INPUTjacsHead1.onclick    = function() {showMonth(-1,calId);}

				 TDjacsHead2               = document.createElement('td');
				 TDjacsHead2.className     = 'jacsHead';

				 SELECTjacsHead2           = document.createElement('select');
				 SELECTjacsHead2.className = 'jacsHead';
				 SELECTjacsHead2.id        = calId+'Months';
				 SELECTjacsHead2.tabIndex  = '-1';
				 SELECTjacsHead2.onchange  = function() {showMonth(0,calId);}

				 TDjacsHead3               = document.createElement('td');
				 TDjacsHead3.className     = 'jacsHead';

				 SELECTjacsHead3           = document.createElement('select');
				 SELECTjacsHead3.className = 'jacsHead';
				 SELECTjacsHead3.id        = calId+'Years';
				 SELECTjacsHead3.tabIndex  = '-1';
				 SELECTjacsHead3.onchange  = function() {showMonth(0,calId);}

				 TDjacsHead4               = document.createElement('td');
				 TDjacsHead4.className     = 'jacsHead';

				 INPUTjacsHead4            = document.createElement('input');
				 INPUTjacsHead4.className  = 'jacsHead';
				 INPUTjacsHead4.id         = calId+'HeadRight';
				 INPUTjacsHead4.type       = 'button';
				 INPUTjacsHead4.tabIndex   = '-1';
				 INPUTjacsHead4.value      = '>';
				 INPUTjacsHead4.onclick    = function() {showMonth(1,calId);}

				 TRjacs2                   = document.createElement('tr');
				 TRjacs2.className         = 'jacs';

				 TDjacs2                   = document.createElement('td');
				 TDjacs2.className         = 'jacs';

				 TABLEjacsCells            = document.createElement('table');
				 TABLEjacsCells.className  = 'jacsCells';
				 TABLEjacsCells.align      = 'center';
				 TABLEjacsCells.width      = '100%';

				 THEADjacsCells            = document.createElement('thead');
				 TRjacsCells               = document.createElement('tr');
				 TDjacsCells               = document.createElement('td');
				 TDjacsCells.className     = 'jacsWeekNumberHead';
				 TDjacsCells.id            = calId+'Week_';

				 TABLEjacs.appendChild(TBODYjacs);
				 TBODYjacs.appendChild(TRjacs1);
					TRjacs1.appendChild(TDjacs1);
						TDjacs1.appendChild(TABLEjacsHead);
							TABLEjacsHead.appendChild(TBODYjacsHead);
								 TBODYjacsHead.appendChild(TRjacsDrag);
									TRjacsDrag.appendChild(TDjacsDrag);
										TDjacsDrag.appendChild(DIVjacsDragText);
								 TBODYjacsHead.appendChild(TRjacsHead);
									TRjacsHead.appendChild(TDjacsHead1);
										TDjacsHead1.appendChild(INPUTjacsHead1);
									TRjacsHead.appendChild(TDjacsHead2);
										TDjacsHead2.appendChild(SELECTjacsHead2);
									TRjacsHead.appendChild(TDjacsHead3);
										TDjacsHead3.appendChild(SELECTjacsHead3);
									TRjacsHead.appendChild(TDjacsHead4);
										TDjacsHead4.appendChild(INPUTjacsHead4);
				 TBODYjacs.appendChild(TRjacs2);
					TRjacs2.appendChild(TDjacs2);
						TDjacs2.appendChild(TABLEjacsCells);
							TABLEjacsCells.appendChild(THEADjacsCells);
								THEADjacsCells.appendChild(TRjacsCells);
									TRjacsCells.appendChild(TDjacsCells);

									for (var i=0;i<7;i++)
										{TDjacsCells           = document.createElement('td');
										 TDjacsCells.className = 'jacsWeek';
										 TDjacsCells.id        = calId+'WeekInit'+i;
										 TRjacsCells.appendChild(TDjacsCells);
										}

							TBODYjacsCells    = document.createElement('tbody');
							TBODYjacsCells.id = calId+'Cells';

							TABLEjacsCells.appendChild(TBODYjacsCells);

							for (var i=0;i<6;i++)
								{TRjacsCells              = document.createElement('tr');
								 TBODYjacsCells.appendChild(TRjacsCells);

									TDjacsCells           = document.createElement('td');
									TDjacsCells.className = 'jacsWeekNo';
									TDjacsCells.id        = calId+'Week_'+i;
									TRjacsCells.appendChild(TDjacsCells);

									for (var j=0;j<7;j++)
										{TDjacsCells           = document.createElement('td');
										 TDjacsCells.className = 'jacsCells';
										 TDjacsCells.id        = calId+'Cell_'+(j+(i*7));
										 TRjacsCells.appendChild(TDjacsCells);
										}
								}

							if ((new Date(TABLEjacs.baseYear + TABLEjacs.dropDownYears,0,0))>dateNow &&
								(new Date(TABLEjacs.baseYear,0,0))                          <dateNow)
								{TFOOTjacsFoot           = document.createElement('tfoot');
								 TFOOTjacsFoot.className = 'jacsFoot';
								 TABLEjacsCells.appendChild(TFOOTjacsFoot);

								 TRjacsFoot              = document.createElement('tr');
								 TRjacsFoot.className    = 'jacsFoot';
								 TFOOTjacsFoot.appendChild(TRjacsFoot);

								 TDjacsFoot              = document.createElement('td');
								 TDjacsFoot.className    = 'jacsFoot';
								 TDjacsFoot.id           = calId+'Foot';
								 TDjacsFoot.colSpan      = '8';
								 TRjacsFoot.appendChild(TDjacsFoot);
								}

				 if (document.addEventListener)
						{      TABLEjacs.addEventListener('click',    cancel,         false);
							   TABLEjacs.addEventListener('change',   cancel,         false);
							  TDjacsDrag.addEventListener('mousedown',beginDrag,      false);
						  INPUTjacsHead1.addEventListener('click',    stopPropagation,false);
						 SELECTjacsHead2.addEventListener('click',    stopPropagation,false);
						 SELECTjacsHead2.addEventListener('change',   stopPropagation,false);
						 SELECTjacsHead3.addEventListener('click',    stopPropagation,false);
						 SELECTjacsHead3.addEventListener('change',   stopPropagation,false);
						  INPUTjacsHead4.addEventListener('click',    stopPropagation,false);
						  TBODYjacsCells.addEventListener('click',    stopPropagation,false);
						}
				 else   {      TABLEjacs.attachEvent('onclick',    cancel);
							   TABLEjacs.attachEvent('onchange',   cancel);
							  TDjacsDrag.attachEvent('onmousedown',beginDrag);
						  INPUTjacsHead1.attachEvent('onclick',    stopPropagation);
						 SELECTjacsHead2.attachEvent('onclick',    stopPropagation);
						 SELECTjacsHead2.attachEvent('onchange',   stopPropagation);
						 SELECTjacsHead3.attachEvent('onclick',    stopPropagation);
						 SELECTjacsHead3.attachEvent('onchange',   stopPropagation);
						  INPUTjacsHead4.attachEvent('onclick',    stopPropagation);
						  TBODYjacsCells.attachEvent('onclick',    stopPropagation);
						}

				 if (dynamic)
						{document.body.insertBefore(TABLEjacs, document.body.firstChild);
						 if (getEl('jacsIE'))
							{iFrame = document.createElement('iframe');
							 iFrame.className    = 'jacs';
							 iFrame.src          = '';
							 iFrame.id           = calId+'Iframe';
							 iFrame.name         = 'jacsIframe';
							 iFrame.frameborder  = '0';
							 iFrame.style.zIndex = TABLEjacs.zIndex;

							 getEl('jacsIE').appendChild(iFrame);
							}
						}
				 else   {if (!getEl('jacsSpan'+calId)) document.writeln("<span id='jacsSpan"+calId+"'></span>");
						 getEl('jacsSpan'+calId).appendChild(TABLEjacs);
						}
				},

			 cals: function ()  {return cals;},
			 next: function ()
				{if (typeof arguments[0]=='object' && arguments[0].constructor!=Function)
					{
					 returnEle  = arguments[0];
					 e          = arguments[1];
					 caller     = (e.target)?e.target:e.srcElement;

					 if (typeof arguments[2]=='string')
						{calID       = arguments[2];
						 inFunc      = arguments[3];
						 argPosition = 4;

						 if (getEl(calID))
								{if (!getEl(calID).dynamic)
									{alert('This calendar is static\nbut this call to JACS.next\nis for dynamic calendars.');
									 return;
									}
								}
						 else   JACS.make(calID,true);
						}
					 else
						{calID       = 'jacs';
						 inFunc      = arguments[2];
						 argPosition = 3;
						 if (!getEl(calID)) JACS.make(calID,true);
						}
					}
				 else
					{
					 if (typeof arguments[0]=='string')
						{calID       = arguments[0];
						 inFunc      = arguments[1];
						 argPosition = 2;

						 if (getEl(calID))
								{if (getEl(calID).dynamic)
									{alert('This calendar is dynamic\nbut this call to JACS.next\nis for static calendars.');
									 return;
									}
								}
						 else   JACS.make(calID,false);
						}
					 else
						{calID       = 'jacs';
						 inFunc      = arguments[0];
						 argPosition = 1;
						 if (!getEl(calID)) JACS.make(calID,false);
						}
					}

				

				 var args = new Array();

				 for (var i=argPosition;i<arguments.length;i++) args.push(arguments[i]);

			

				 newFunc = inFunc.jacsRunNext(args,calID);

				

				 var cal = getEl(calID);

				 if (getEl(calID).dynamic)
					  cal.arrOnNext.push(newFunc);
				 else cal.onNext = newFunc;
				}
			}
	}

