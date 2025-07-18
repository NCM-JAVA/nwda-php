function MM_validateForm() 
{ 
	var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments,r,a,b,c,d,e,f,s,g,h;
	j=0;
	//	/^([-a-zA-Z0-9._]+@[-a-zA-Z0-9.]+(\.[-a-zA-Z0-9]+)+)$/;
	var regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	var regBlank = /[^\s]/;
	var regAlphaNum = /^([a-zA-Z0-9-+/_& :?;\n\r.,\']+)$/;
	//var regAlphaNum = /^([a-zA-Z0-9_]+)$/;
	var regDate = /^([0-9_]+-[0-9][0-9]+-[0-9][0-9]+)$/;

		//var regcontact = /^([0-9-]+)$/;

		var regcontact = /^([0-9-()+ ]+)$/;

			var alphnum = /^([0-9a-zA-Z]+)$/;

	
	//alert (MM_validateForm.arguments[1].name);
	//alert("sss--->"+document.forms[""+args[0]].elements[""+args[0]].value);
	for (i=1; i<(args.length-2); i+=3) 
	{	
		mesg=args[i+1];
		test=args[i+2]; 
		val=document.forms[""+args[0]].elements[""+args[i]];
	
	    if (val) 
		{	nm=mesg; 
			
			val = val.value;
			//if ((val=val.value)!="") 
			if(regBlank.test(val))
			{
				if(test.indexOf('isEqual')!=-1)
				{
					result = trim(val);
				if(result.length==0){
				errors += '- '+nm+' is required.\n'; 
				}else{
					equal_obj_val = test.substring(8,test.indexOf(":"));
					mesg_string =test.substring((test.indexOf(":")+1));
					if(val != document.forms[""+args[0]].elements[""+equal_obj_val].value)
					{
						errors+='- '+nm+' must be same to '+mesg_string+'.\n';
					}
				}
				}
				else if(test.indexOf('isAlphaNum')!=-1)
				{
				var first_char;
					first_char= val.charAt(0);
					if(first_char==0||first_char==1||first_char==2||first_char==3||first_char==4||first_char==5||first_char==6||first_char==7||first_char==8||first_char==9){
					 errors+='- '+nm+' must starts with  a char.\n';
					}
				result = trim(val);
				if(result.length==0){
				errors += '- '+nm+' is required.\n'; 
				}else{
					if(!regAlphaNum.test(val))
					{
						errors+='- '+nm+': Only Alpha Numeric and "_" Chars Allowed.\n';
					}
				}
				}






	 else if (test.indexOf('isalphaNum')!=-1) 
				{ 
					var minLength =5;
					result = trim(val);
					
					if(!alphnum.test(val))
					{
						//errors+='- '+nm+' can contain numbers and "_" character.\n';
					errors+='- '+nm+': Only Alpha Numeric Allowed.\n';
					}

				}


				else if (test.indexOf('isDate')!=-1) 
				{ 
					p=val.indexOf('-');
			        
					if (p != 4 )
					{
						errors+='- '+nm+' must contain Valid Date YYYY-MM-DD.\n';
		
					}
					else if(!regDate.test(val))
					{
						errors+='- '+nm+' must contain Valid Date YYYY-MM-DD.\n';
					}
			     }

				 else if (test.indexOf('isPhone')!=-1) 
				{ 
					//p=val.indexOf('-');
			        
					 if(!regPhone.test(val))
					{
						errors+='- '+nm+' must contain Valid Phone Number xxx-xxx-xxxx\n';
					}
			     }
				  else if (test.indexOf('isPassword')!=-1) 
				{ 
					//p=val.indexOf('-');
					result = trim(val);
  					 if(result.length<6)
					{
						errors+='- '+nm+' must contain must contain at least 6 characters\n';
					}
			     }
				 
				 else if (test.indexOf('isContactNo')!=-1) 
				{ 
					var minLength =5;
					result = trim(val);
					
					if(!regcontact.test(val))
					{
						//errors+='- '+nm+' can contain numbers and "_" character.\n';
					errors+='- The Phone number must contain a number, + or () sign.\n';
					}


					

					 else if(result.length<minLength)
					{
						errors+='- '+nm+' must contain minimum 6 digits\n';
					}
			     }

				else if (test.indexOf('isstdcode')!=-1) 
				{ 
				var minLength =3;
				result = trim(val);
				
				if(!regcontact.test(val))
				{
				//errors+='- '+nm+' can contain numbers and "_" character.\n';
				errors+='- The Phone number must contain a number, + or () sign.\n';
				}
				
				
				
				
				else if(result.length<minLength)
				{
				errors+='- '+nm+' must contain minimum 3 digits\n';
				}
				}



				 else if (test.indexOf('isCountry')!=-1) 
				{ 
					var minLength =5;
					result = trim(val);
					
					if(!regcontact.test(val))
					{
						//errors+='- '+nm+' can contain numbers and "_" character.\n';
					errors+='- The Country Code must contain a number, + or () please.\n';
					}
					
				}

				else if (test.indexOf('isArea')!=-1) 
				{ 
					var minLength =5;
					result = trim(val);
					
					if(!regcontact.test(val))
					{
						//errors+='- '+nm+' can contain numbers and "_" character.\n';
					errors+='- The Area Code must contain a number, + or () please.\n';
					}
					
				}

	else if (test.indexOf('islandlineNo1')!=-1) 
				{ 
					var minLength1 =7;
					result = trim(val);
					
					if(!regcontact.test(val))
					{
						//errors+='- '+nm+' can contain numbers and "_" character.\n';
					errors+='- '+nm+' can contain "-" & numeric value.\n';
					}


					

					 else if(result.length<minLength1)
					{
						errors+='- '+nm+' must contain minimum 7 digits\n';
					}
			     }

		 else if (test.indexOf('isExt')!=-1) 
				{	
					a=val.indexOf('.jpg');
					b=val.indexOf('.JPG');

					c=val.indexOf('.gif');
					d=val.indexOf('.GIF');

					e=val.indexOf('.jpeg');
					f=val.indexOf('.JPEG');

					r=val.indexOf('.png');
					g=val.indexOf('.PNG');
		
					y=val.indexOf('.swf');
					z=val.indexOf('.SWF');              

					

			        if ((a<1 || a==(val.length-1)) && (b<1 || b==(val.length-1))&& (c<1 || c==(val.length-1)) && (d<1 || d==(val.length-1))  && (e<1 || e==(val.length-1)) && (f<1 || f==(val.length-1)) && (g<1 || g==(val.length-1)) && (r<1 || r==(val.length-1)) && (y<1 || y==(val.length-1)) && (z<1 || z==(val.length-1)))
					{
						errors+='- '+nm+' should be in .gif, .jpg, .jpeg, .png, .swf format!.\n';
		
					}
				}

else if (test.indexOf('isXlsExt')!=-1) 
				{	


					a=val.indexOf('.xls');
					b=val.indexOf('.XLS');

				        if ((a<1 || a==(val.length-1)) && (b<1 || b==(val.length-1)))
					{
						errors+='- '+nm+' File should be in .xls,.XLS format!.\n';
		
					}
	
				}			


 else if (test.indexOf('isPdfExt')!=-1) 
				{	
//	 alert("asdjhasfjsdh");

					r=val.indexOf('.pdf');
					d=val.indexOf('.PDF');

			        if ((d<1 || d==(val.length-1)) && (r<1 || r==(val.length-1)))
					{
						errors+='- '+nm+' should have a valid format!.\n';
		
					}
	
				}


else if (test.indexOf('isDocPdfExt')!=-1) 
				{	
//	 alert("asdjhasfjsdh");

					a=val.indexOf('.txt');
					b=val.indexOf('.TXT');

					c=val.indexOf('.doc');
					d=val.indexOf('.DOC');

					e=val.indexOf('.rtf');
					f=val.indexOf('RTF');

					r=val.indexOf('.pdf');
					g=val.indexOf('.PDF');


			        if ((a<1 || a==(val.length-1)) && (b<1 || b==(val.length-1)) && (c<1 || c==(val.length-1)) && (d<1 || d==(val.length-1)) && (e<1 || e==(val.length-1)) && (f<1 || f==(val.length-1)) && (g<1 || g==(val.length-1)) && (r<1 || r==(val.length-1)))
					{
						errors+='- '+nm+' File should be in .txt, .doc, .rtf, .pdf format!.\n';
		
					}
	
				}
				//for doc and pdf
//doc pdf jpeg validation for email
else if (test.indexOf('isDocPdfJpegExt')!=-1) 
{	
//	 alert("asdjhasfjsdh");

					a=val.indexOf('.txt');
					b=val.indexOf('.TXT');

					c=val.indexOf('.doc');
					d=val.indexOf('.DOC');


					e=val.indexOf('.jpg');
					f=val.indexOf('.JPG');

					
					r=val.indexOf('.pdf');
					g=val.indexOf('.PDF');


			        if ((a<1 || a==(val.length-1)) && (b<1 || b==(val.length-1)) && (c<1 || c==(val.length-1)) && (d<1 || d==(val.length-1)) && (e<1 || e==(val.length-1)) && (f<1 || f==(val.length-1)) && (g<1 || g==(val.length-1)) && (r<1 || r==(val.length-1)))
					{
						errors+='- '+nm+' File should be in .txt, .doc, .jpg or .pdf format!\n';
		
					}
	
				}


else if (test.indexOf('isDocExt')!=-1) 
				{	


					a=val.indexOf('.txt');
					b=val.indexOf('.TXT');

					c=val.indexOf('.doc');
					d=val.indexOf('.DOC');

					e=val.indexOf('.rtf');
					f=val.indexOf('RTF');

			        if ((a<1 || a==(val.length-1)) && (b<1 || b==(val.length-1)) && (c<1 || c==(val.length-1)) && (d<1 || d==(val.length-1)) && (e<1 || e==(val.length-1)) && (f<1 || f==(val.length-1)))
					{
						errors+='- '+nm+' File should be in .txt, .doc, .rtf format!.\n';
		
					}
	
				}
				
	



//----------------

				else if (test.indexOf('isEmail')!=-1) 
				{ 
					
					var first_char;
					first_char= val.charAt(0);
					//if(first_char==0||first_char==1||first_char==2||first_char==3||first_char==4||first_char==5||first_char==6||first_char==7||first_char==8||first_char==9){
					 //errors+='- '+nm+'  can start only with characters.\n';
					//}
					p=val.indexOf('@');
					s=val.indexOf('.');
			        if (p<1 || p==(val.length-1))
					{
						errors+='- '+nm+' should be a valid e-mail Address.\n';
		
					}
					//else if(s<p || s==(val.length-1))
					else if(!regEmail.test(val))
					{
						errors+='- '+nm+' should be a valid e-mail Address.\n';
					}
			     }
				else if (test.indexOf('isUrl')!=-1) 
				{ 
					p=val.indexOf('http://');
					s=val.indexOf('.');
			        if (p<0 || p==(val.length-1))
					{
						errors+='- '+nm+' must be valid URL e.g. http://www.abc.com\n';
		
					}
					else if(s<p || s==(val.length-1))
					{
						errors+='- '+nm+' must be valid URL e.g. http://www.abc.com\n';
					}
			     }
				 else if (test.indexOf('isChar')!=-1) 
				 { 
					var first_char;
					first_char= val.charAt(0);
					if(first_char==0||first_char==1||first_char==2||first_char==3||first_char==4||first_char==5||first_char==6||first_char==7||first_char==8||first_char==9){
					 errors+='- '+nm+' must starts with  a char.\n';
					}
			     }
	   			 else if (test!='R') 
				 {
				 result = trim(val);
					if(result.length==0){
					errors += '- '+nm+'.\n'; 
					}
				    if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';

					if (test.indexOf('inRange') != -1) 
					{ num = parseFloat(val);
						p=test.indexOf(':');
						min=test.substring(10,p); 
						max=test.substring(p+1);
						if (num<min || max<num) 
						errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
					} 
					if (val.indexOf('-') != -1) 
					{ 
						errors+='- '+nm+' must contain a number without dashes sign.\n';
					} 
					if (val.indexOf('+') != -1) 
					{ 
						errors+='- '+nm+' must contain a number without plus sign.\n';
					}
					
				}else if (test.charAt(0)=='R')
				{
				result = trim(val);
				if(result.length==0){
				errors += '- '+nm+'.\n'; 
				}
				} 
			}
			else if (test.charAt(0) == 'R'){
				errors += '- '+nm+'.\n'; 
			}
		}
		if(errors !="")
		{	if(j<=0)
			{
				
				focusitem = document.forms[""+args[0]].elements[""+args[i]];
				j++;
			}	
			
		}
	} 
	
//return errors;
  
  if (errors)
  {
	alert('The following error(s) occurred:\n\n'+errors);
	
	focusitem.focus();
	return false;
   }
   else
	return true;

//  document.MM_returnValue = (errors == '');
	
}

function trim(inputString) {
   // Removes leading and trailing spaces from the passed string. Also removes
   // consecutive spaces and replaces it with one space. If something besides
   // a string is passed in (null, custom object, etc.) then return the input.
   if (typeof inputString != "string") { return inputString; }
   var retValue = inputString;
   var ch = retValue.substring(0, 1);
   while (ch == " ") { // Check for spaces at the beginning of the string
      retValue = retValue.substring(1, retValue.length);
      ch = retValue.substring(0, 1);
   }
   ch = retValue.substring(retValue.length-1, retValue.length);
   while (ch == " ") { // Check for spaces at the end of the string
      retValue = retValue.substring(0, retValue.length-1);
      ch = retValue.substring(retValue.length-1, retValue.length);
   }
   while (retValue.indexOf("  ") != -1) { // Note that there are two spaces in the string - look for multiple spaces within the string
      retValue = retValue.substring(0, retValue.indexOf("  ")) + retValue.substring(retValue.indexOf("  ")+1, retValue.length); // Again, there are two spaces in each of the strings
   }
   return retValue; // Return the trimmed string back to the user
} // Ends the "trim" function


var MONTH_NAMES=new Array('January','February','March','April','May','June','July','August','September','October','November','December','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
var DAY_NAMES=new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sun','Mon','Tue','Wed','Thu','Fri','Sat');
function LZ(x) {return(x<0||x>9?"":"0")+x}



/***
function isDate(val,format) {
	var date=getDateFromFormat(val,format);
	if (date==0) { return false; }
	return true;
	}
****/



// code for mm/dd/yyyy validate

var dtCh= "/";
var minYear=1900;
var maxYear=2100;

function isInteger(s){
	var i;
    for (i = 0; i < s.length; i++){   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag){
	var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++){   
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function daysInFebruary (year){
	// February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
	for (var i = 1; i <= n; i++) {
		this[i] = 31
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
		if (i==2) {this[i] = 29}
   } 
   return this
}

function __isDate(dtStr){
	var daysInMonth = DaysArray(12)
	var pos1=dtStr.indexOf(dtCh)
	var pos2=dtStr.indexOf(dtCh,pos1+1)
	var strMonth=dtStr.substring(0,pos1)
	var strDay=dtStr.substring(pos1+1,pos2)
	var strYear=dtStr.substring(pos2+1)
	strYr=strYear
	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
	}
	month=parseInt(strMonth)
	day=parseInt(strDay)
	year=parseInt(strYr)
	if (pos1==-1 || pos2==-1){
		alert("The date format should be : mm/dd/yyyy")
		return false
	}
	if (strMonth.length<1 || month<1 || month>12){
		alert("Please enter a valid month")
		return false
	}
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
		alert("Please enter a valid day")
		return false
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		alert("Please enter a valid 4 digit year between "+minYear+" and "+maxYear)
		return false
	}
	if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
		alert("Please enter a valid date")
		return false
	}
return true
}











function valButton(btn) {
	
    var cnt = -1;
    for (var i=btn.length-1; i > -1; i--) {
        if (btn[i].checked) {cnt = i; i = -1;}
    }
    if (cnt > -1) return btn[cnt].value;
    else return null;
}




//end code for mm/dd/yyyy format

function compareDates(date1,dateformat1,date2,dateformat2) {
	var d1=getDateFromFormat(date1,dateformat1);
	var d2=getDateFromFormat(date2,dateformat2);
	alert(d1);
	if (d1==0 || d2==0) {
		return -1;
		}
	else if (d1 > d2) {
		return 1;
		}
	return 0;
	}
	
// ------------------------------------------------------------------
// Utility functions for parsing in getDateFromFormat()
// ------------------------------------------------------------------
function _isInteger(val) {
	var digits="1234567890";
	for (var i=0; i < val.length; i++) {
		if (digits.indexOf(val.charAt(i))==-1) { return false; }
		}
	return true;
	}
function _getInt(str,i,minlength,maxlength) {
	for (var x=maxlength; x>=minlength; x--) {
		var token=str.substring(i,i+x);
		if (token.length < minlength) { return null; }
		if (_isInteger(token)) { return token; }
		}
	return null;
	}
	

function __getDateFromFormat(val,format) {
	val=val+"";
	format=format+"";
	var i_val=0;
	var i_format=0;
	var c="";
	var token="";
	var token2="";
	var x,y;
	var now=new Date();
	var year=now.getYear();
	var month=now.getMonth()+1;
	var date=1;
	var hh=now.getHours();
	var mm=now.getMinutes();
	var ss=now.getSeconds();
	var ampm="";
	
	while (i_format < format.length) {
		// Get next token from format string
		c=format.charAt(i_format);
		token="";
		while ((format.charAt(i_format)==c) && (i_format < format.length)) {
			token += format.charAt(i_format++);
			}
		// Extract s of value based on format token
		if (token=="yyyy" || token=="yy" || token=="y") {
			if (token=="yyyy") { x=4;y=4; }
			if (token=="yy")   { x=2;y=2; }
			if (token=="y")    { x=2;y=4; }
			year=_getInt(val,i_val,x,y);
			if (year==null) { return 0; }
			i_val += year.length;
			if (year.length==2) {
				if (year > 70) { year=1900+(year-0); }
				else { year=2000+(year-0); }
				}
			}
		else if (token=="MMM"||token=="NNN"){
			month=0;
			for (var i=0; i<MONTH_NAMES.length; i++) {
				var month_name=MONTH_NAMES[i];
				if (val.substring(i_val,i_val+month_name.length).toLowerCase()==month_name.toLowerCase()) {
					if (token=="MMM"||(token=="NNN"&&i>11)) {
						month=i+1;
						if (month>12) { month -= 12; }
						i_val += month_name.length;
						break;
						}
					}
				}
			if ((month < 1)||(month>12)){return 0;}
			}
		else if (token=="EE"||token=="E"){
			for (var i=0; i<DAY_NAMES.length; i++) {
				var day_name=DAY_NAMES[i];
				if (val.substring(i_val,i_val+day_name.length).toLowerCase()==day_name.toLowerCase()) {
					i_val += day_name.length;
					break;
					}
				}
			}
		else if (token=="MM"||token=="M") {
			month=_getInt(val,i_val,token.length,2);
			if(month==null||(month<1)||(month>12)){return 0;}
			i_val+=month.length;}
		else if (token=="dd"||token=="d") {
			date=_getInt(val,i_val,token.length,2);
			if(date==null||(date<1)||(date>31)){return 0;}
			i_val+=date.length;}
		else if (token=="hh"||token=="h") {
			hh=_getInt(val,i_val,token.length,2);
			if(hh==null||(hh<1)||(hh>12)){return 0;}
			i_val+=hh.length;}
		else if (token=="HH"||token=="H") {
			hh=_getInt(val,i_val,token.length,2);
			if(hh==null||(hh<0)||(hh>23)){return 0;}
			i_val+=hh.length;}
		else if (token=="KK"||token=="K") {
			hh=_getInt(val,i_val,token.length,2);
			if(hh==null||(hh<0)||(hh>11)){return 0;}
			i_val+=hh.length;}
		else if (token=="kk"||token=="k") {
			hh=_getInt(val,i_val,token.length,2);
			if(hh==null||(hh<1)||(hh>24)){return 0;}
			i_val+=hh.length;hh--;}
		else if (token=="mm"||token=="m") {
			mm=_getInt(val,i_val,token.length,2);
			if(mm==null||(mm<0)||(mm>59)){return 0;}
			i_val+=mm.length;}
		else if (token=="ss"||token=="s") {
			ss=_getInt(val,i_val,token.length,2);
			if(ss==null||(ss<0)||(ss>59)){return 0;}
			i_val+=ss.length;}
		else if (token=="a") {
			if (val.substring(i_val,i_val+2).toLowerCase()=="am") {ampm="AM";}
			else if (val.substring(i_val,i_val+2).toLowerCase()=="pm") {ampm="PM";}
			else {return 0;}
			i_val+=2;}
		else {
			if (val.substring(i_val,i_val+token.length)!=token) {return 0;}
			else {i_val+=token.length;}
			}
		}
	// If there are any trailing characters left in the value, it doesn't match
	if (i_val != val.length) { return 0; }
	// Is date valid for month?
	if (month==2) {
		// Check for leap year
		if ( ( (year%4==0)&&(year%100 != 0) ) || (year%400==0) ) { // leap year
			if (date > 29){ return 0; }
			}
		else { if (date > 28) { return 0; } }
		}
	if ((month==4)||(month==6)||(month==9)||(month==11)) {
		if (date > 30) { return 0; }
		}
	// Correct hours value
	if (hh<12 && ampm=="PM") { hh=hh-0+12; }
	else if (hh>11 && ampm=="AM") { hh-=12; }
	var newdate=new Date(year,month-1,date,hh,mm,ss);
	return newdate.getTime();
	}



	//=====code for validate start date and end date================================
	
	
	//code for validate mm/dd/yyyy formnat

/**
 * DHTML date validation script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
 */
// Declaring valid date character, minimum year and maximum year
var dtCh= "/";
var minYear=1900;
var maxYear=2100;

function isInteger(s){
	var i;
    for (i = 0; i < s.length; i++){   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag){
	var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++){   
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function daysInFebruary (year){
	// February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
	for (var i = 1; i <= n; i++) {
		this[i] = 31
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
		if (i==2) {this[i] = 29}
   } 
   return this
}

function isDate(dtStr){
	var daysInMonth = DaysArray(12)
	var pos1=dtStr.indexOf(dtCh)
	var pos2=dtStr.indexOf(dtCh,pos1+1)
	var strMonth=dtStr.substring(0,pos1)
	var strDay=dtStr.substring(pos1+1,pos2)
	var strYear=dtStr.substring(pos2+1)
	strYr=strYear
	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
	}
	month=parseInt(strMonth)
	day=parseInt(strDay)
	year=parseInt(strYr)
	if (pos1==-1 || pos2==-1){
		alert("The date format should be : mm/dd/yyyy")
		return false
	}
	if (strMonth.length<1 || month<1 || month>12){
		alert("Please enter a valid month")
		return false
	}
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
		alert("Please enter a valid day")
		return false
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		alert("Please enter a valid 4 digit year between "+minYear+" and "+maxYear)
		return false
	}
	if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
		alert("Please enter a valid date")
		return false
	}
return true
}



function checkall(objForm){

	alert(a);
	
	len = objForm.elements.length;

	

	var i=0;
	for( i=0 ; i<len ; i++) {
		if (objForm.elements[i].type=='checkbox') {
			objForm.elements[i].checked=objForm.check_all.checked;
		}
	}
}


//end code for mm/dd/yyyy format



function __is_any_check_box_checked(fObj)
{
	found=false;

	//alert(fObj.length);


	for(i=0;i<fObj.length;i++)
	{
		if(fObj[i].type=="checkbox" && fObj[i].checked && fObj[i].disabled==false && i!=1) 
		{

			
			found=true;
			break	
		}		
	}
	return found;
}




/*function checkCheckboxes(fObj)
{		
	if(is_any_check_box_checked(fObj)==true)
	{


		if(confirm("Are you sure?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(is_any_check_box_checked(fObj)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}


*/




function __checkCheckboxes(fObj)
{
	//alert("Select1");	
	
	if(is_any_check_box_checked(fObj)==true)
	{

//alert("Select2");	
		if(confirm("Are you sure?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(is_any_check_box_checked(fObj)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}

function __checkCheckboxes(fObj)
{		
	////////alert("aaaaaa");

//alert(is_any_check_box_checked(fObj));

	if(is_any_check_box_checked(fObj)==true)
	{
		if(confirm("Are you sure?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(is_any_check_box_checked(fObj)==false)
	{
		alert("Please select at least one check box.");		
		return false;
	}
}



function is_any_check_box_checked(id)
{

	found=false;


	for(i=0;i<id.length;i++)
	
	{


		if(id[i].type=="checkbox" && id[i].checked) 
		{

							//alert("aaaaaa");
			found=true;
			break	
		}		
	}

	return found;
}



function conformme(id)
{		
	

	if(is_any_check_box_checked(id)==true)
	{
		
		
			if(confirm("Are you sure?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(is_any_check_box_checked(id)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}



function conformme_active(id)
{		
	

	if(is_any_check_box_checked(id)==true)
	{
		
		
			if(confirm("Are you sure,you want to Deactivate ?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(is_any_check_box_checked(id)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}


function conformme_inactive(id)
{		
	
	if(is_any_check_box_checked(id)==true)
	{
		
		
			if(confirm("Are you sure,you want to Activate ?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(is_any_check_box_checked(id)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}

function conformme_repost(id)
{		
	
	if(is_any_check_box_checked(id)==true)
	{
		
		
			if(confirm("Are you sure?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}
	}
	else if(is_any_check_box_checked(id)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}






function conformch(id)
{		
	
	
	alert("hiiiii")
	if(is_any_check_box_checked(id)==false)
	{
		alert("Select at least one check box.");		
		return false;
	}
}


function delete_normal_product()
{
if(confirm("The deletion of the product will delete it from the Normal Product list. Are you sure you want to delete this Product?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}

}

function conform_delete()
{
if(confirm("Are you sure want to delete?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}

}


function confirm_active_prod_del()
{
if(confirm("Sorry! This product can not be deleted as it is Active?"))
		{
			return true;  
		}
		else 
		{
			return false;  
		}

}


function conform_delete_inactive_job()
{
    alert("This job can not be deleted as it is Active");
		
			return false; 

}




	


	



//==============function for convert how to convert date format in dd/mm/yy to javascript format in month date,year=====


function convert_date(date)
{

if(date!='')
	{
var date_arr = date.split("/",3);
var get_day = date_arr[0];
var get_month = date_arr[1];
//alert(get_day);

if(get_day<=9)
{
//get_day=
get_day=get_day.split("0");
day_string=get_day[1];
}

else
{
day_string=get_day;
}

if(get_month=="01"){
			month_string="Jan";
		}else if(get_month=="02"){
			month_string="Feb";
		}else if(get_month=="03"){
			month_string="Mar";
		}else if(get_month=="04"){
			month_string="Apr";
		}else if(get_month=="05"){
			month_string="May";
		}else if(get_month=="06"){
			month_string="Jun";
		}else if(get_month=="07"){
			month_string="July";
		}else if(get_month=="08"){
			month_string="Aug";
		}else if(get_month=="09"){
			month_string="Sep";
		}else if(get_month=="10"){
			month_string="Oct";
		}else if(get_month=="11"){
			month_string="Nov";
		}else if(get_month=="12"){
			month_string="Dec";
		}


var conv_date = month_string+" "+day_string+", "+date_arr[2];
//alert(conv_date);
//return false;

return conv_date;
	}
}

//==============end code for convert date in javascirpt format in month day,year=====================








	










	function submitValidDate_date()
		{

			


if(((document.form_search.alm_event_start_date.value=="")&&(document.form_search.alm_end_date.value!=""))||((document.form_search.alm_event_start_date.value!="")&&(document.form_search.alm_end_date.value=="")))
{
		alert("Please Enter Start date and end date!");
			return false;
			exit;
			}

if(document.form_search.alm_event_start_date.value!="")
			{


if(isDate(document.form_search.alm_event_start_date.value,"dd/MM/yyyy")==false)
{
	alert("Check the Format for Start Date It should be in dd/mm/yyyy");
	return false;
	exit;
	
}
	
			}


if(document.form_search.alm_end_date.value!="")
			{
		


		
if(isDate(document.form_search.alm_end_date.value,"dd/MM/yyyy")==false)
{
	alert("Check the Format for End Date It should be in dd/mm/yyyy");
	return false;
	exit;
}

			}




if (compareDates(document.form_search.alm_event_start_date.value,"dd/MM/yyyy",document.form_search.alm_end_date.value,"dd/MM/yyyy")==1)
		{
			alert("Start date should not be greater then end date");
			return false;
			exit;
			
		}



if((document.form_search.alm_event_start_date.value==false)&&((document.form_search.alm_end_date.value==false)||
	(document.form_search.event_name.value==false)))
			{
	return true;
			}


  return true;
		}





//============================end code for validate start date and end date for view event============================






//===================check validate start date and end date for admin/view article==============================

function submitvalidate_article()
		{

			


if(((document.form_search.start_date.value=="")&&(document.form_search.end_date.value!=""))||((document.form_search.start_date.value!="")&&(document.form_search.end_date.value=="")))
{
		alert("Please Enter Start date and end date!");
			return false;
			exit;
			}



if(document.form_search.start_date.value!="")
			{


if(isDate(document.form_search.start_date.value,"dd/MM/yyyy")==false)
{
	alert("Check the Format for Start Date It should be in dd/mm/yyyy");
	return false;
	exit;
	
}

	}
			

if(document.form_search.start_date.value!="")
			{

		
if(isDate(document.form_search.end_date.value,"dd/MM/yyyy")==false)
{
	alert("Check the Format for End Date It should be in dd/mm/yyyy");
	return false;
	exit;
}

			}




if(compareDates(document.form_search.start_date.value,"dd/MM/yyyy",document.form_search.end_date.value,"dd/MM/yyyy")==1)
		{
			alert("Start date should not be greater then end date");
			return false;
			exit;
			
		}



if((document.form_search.start_date.value==false)&&((document.form_search.end_date.value==false)||
	(document.form_search.article_title.value==false)))
			{
	return true;
			}


  return true;
		}



//-----end code for valid date ====================================================


function valid_edit_admin_profile(formname)
{
	

	if(MM_validateForm(formname,'user_first_name','First Name','R','user_last_name','Last Name','RisAlphaNum','user_email_id','Email','RisEmail','user_pass','Password','RisPassword'))
	{

		return true;
	} 
	else{
		return false;
	}
	
}







function valid_login_form(formname)
{
	
if(MM_validateForm(formname,'user_name','User Name','R','user_password','Password','RisPassword'))
	{

		return true;
	} else{
		return false;
	}
}

function valid_forgot_pass(formname)
{

if(MM_validateForm(formname,'forgot_email','User email','RisEmail'))
	{
		
		return true;
	} else{
		return false;
	}
}


//----------------validate registartion form ----------------------------


function valid_front_forgot_pass(formname)
{
if(MM_validateForm(formname,'forgot_email','User email','RisEmail'))
	{
		
		return true;
	} else{
		return false;
	}
}



function valid_edit_profile_form(formname)
{

if(MM_validateForm(formname,'admin_password','Password','R','admin_name','Name','R','admin_email','Email Address','RisEmail','admin_contact_no', 'Contact Number','RisContactNo'))
	{

		return true;
	} 
	else{
		return false;
	}

}

function valid_add_gallery_form(formname)
{

if(MM_validateForm(formname,'image_title','Image Title','R','image_desc','Image Description','R','image_name','Uploading of Image','R'))
	{

		return true;
	} 
	else{
		return false;
	}

}

function valid_edit_gallery_form(formname)
{

if(MM_validateForm(formname,'image_title','Image Title','R','image_desc','Image Description','R'))
	{

		return true;
	} 
	else{
		return false;
	}

}

function add_newuserpolicy(formname)
{
	alert(formname);
if(MM_validateForm(formname,'usertype','Please Select User Type','R'))
	{

		return true;
	} 
	else{
		return false;
	}
}

function edit_email(formname)
{
 
    if(MM_validateForm(formname,'txtemail','Please enter valid email id in format like abc@def.com','RisEmail'))
    {

        return true;
    } 
    else{
        return false;
    }

}



function add_content(formname)
{
	//alert('mnvcmncvnmvc');
if(MM_validateForm(formname,
	'txtename','Please enter Name','R', 
	'txtepage_title','Please enter page title','R',
	'txtlanguage','Please enter Language','R', 
	'txtekeyword','Please enter meta keyword','R',
	'texttype','Please enter menu type','R',
	'txtpostion','Please enter content position','R',
	'txtstatus','Please select page status','R'
	
	))
	{

		return true;
	} 
	else{
		return false;
	}

}
function edit_content(formname)
{
	//alert('mnvcmncvnmvc');
if(MM_validateForm(formname,
	/*'txtename','Please enter Name','R', */
	'txtlanguage','Please enter Language','R', 
	'txtename','Please enter Name','R', 
	'txtepage_title','Please enter page title','R',
	//'txtekeyword','Please enter meta keyword','R',
	'texttype','Please enter menu type','R',
	'txtpostion','Please enter content position','R',
	'txtstatus','Please select page status','R'
	
	))
	{

		return true;
	} 
	else{
		return false;
	}

}


function add_institute(formname)
{
	//alert('mnvcmncvnmvc');
if(MM_validateForm(formname,
	'txtename','Please enter Name','R', 
	'txtepage_title','Please enter page title','R',
	'txtlanguage','Please enter Language','R', 
	'texttype','Please enter menu type','R',
	'txtpostion','Please enter content position','R',
	'txtstatus','Please select page status','R'
	
	))
	{

		return true;
	} 
	else{
		return false;
	}

}
function edit_institute(formname)
{
	//alert('mnvcmncvnmvc');
if(MM_validateForm(formname,
	/*'txtename','Please enter Name','R', */
	'txtlanguage','Please enter Language','R', 
	'txtename','Please enter Name','R', 
	'txtepage_title','Please enter page title','R',
	'texttype','Please enter menu type','R',
	'txtpostion','Please enter content position','R',
	'txtstatus','Please select page status','R'
	
	))
	{

		return true;
	} 
	else{
		return false;
	}

}


function add_role(formname)
{
if(MM_validateForm(formname,
	'txtename','Please Enter Name','R',
	'roletype','Please Enter User Type','R'
))
	{

		return true;
	} 
	else{
		return false;
	}

}


function edit_role(formname)
{

if(MM_validateForm(formname,
	'txtename','Please Enter Name','R',
	'roletype','Please Enter User Type','R'
	))
	{

		return true;
	} 
	else{
		return false;
	}

}






function add_user(formname)
{

if(MM_validateForm(formname,
	'txtlog','Please Enter User Id,','R',
	'txtename','Please Enter Name','R',
	'txtemail','Please Enter Email','RisEmail',
	'designation','Please Enter Designation','R',
	'txtphone','Please Enter Phone Number','R',
	'dob','Please Enter Date of Birth','R',
	'roleid','Please Select User Postion','R'

	))
	{

		return true;
	} 
	else{
		return false;
	}

}

function edit_user(formname)
{

if(MM_validateForm(formname,
	'txtlog','Please Enter login Id,','R',
	'txtename','Please Enter Name','R',
	'txtemail','Please Enter Email','RisEmail',
	'txtphone','Please Enter Phone Number','R',
	'dob','Please Enter Date of Birth','R',
	'roleid','Please Select User Role','R',
	'user_status','Please Select User Status','R'
	))
	{

		return true;
	} 
	else{
		return false;
	}

}



function changepassword(formname)
{

if(MM_validateForm(formname,'txtpwd','Old Password','R',
	'txtnpwd','New Password','R',
	'txtcpwd','Confirm Password','R'))
	{

		return true;
	} 
	else{
		return false;
	}

}




function feedback(formname)
{
	if(MM_validateForm(formname,
		'Name','Please Enter the Name','R',
		'email','Email','RisEmail',
		'code','Please Enter the Code','R'
		 ))
	{

		return true;
	} 
	else{
		return false;
	}

	
}
function forgetpass(formname)
{
	
	if(MM_validateForm(formname,
		'admin_email','Please Enter Email','RisEmail',
		'txtlog','Please Enter Valid User Id or Date of birth DD-MM-YYYY','R',
		'code','Please Enter the Code','R'
		 ))
	{

		return true;
	} 
	else{
		return false;
	}


	
}
function edit_profile(formname)
{
	if(MM_validateForm(formname,
		'Name','Please Enter the Name','R',
		'email','Email','RisEmail',
		'address','Please Enter the address','R',
		'station','Please Enter the station','R',
		'pin_code','Please Enter the Code','R'
		 ))
	{

		return true;
	} 
	else{
		return false;
	}

	
}

function newpassword(formname)
{

if(MM_validateForm(formname,'txtpwd','Old Password','R',
	'txtnpwd','New Password','R',
	'txtcpwd','Confirm Password','R','code','Image Code','R'))
	{

		return true;
	} 
	else{
		return false;
	}

}





function category(formname)
{ 


	if(MM_validateForm(formname,
	'texttype','Please Select Category Type','R',
	'txtepage_name','Please Enter Category Name','R',
	'txtstatus','Please Select Page Status','R'))
	{

		return true;
	} 
	else{
		return false;
	}
}
function edit_category(formname)
{ 
	if(MM_validateForm(formname,
	'txtepage_name','Please Enter Category Type','R',
	'txtlanguage','Please Select Page Language','R'
	))
	{

		return true;
	} 
	else{
		return false;
	}
}



function add_photogallery(formname)
{ 
	if(MM_validateForm(formname,
		'txtcategory','Please enter Category Name','R',
	'txtepage_title','Please enter Image Title','R',
		'txtuplode','Please upload image ','R',
		'txtstatus','Please Select Page Status.','R'))
	{

		return true;
	} 
	else{
		return false;
	}
}

function edit_photogallery(formname)
{ 

if(MM_validateForm(formname,
			'txtcategory','Please enter Category Name','R',
	'txtepage_title','Please enter Image Title','R',
		//'txtuplode','Please upload image ','R',
		'txtstatus','Please Select Page Status.','R'))
	{
		return true;
	} 
	else{
		return false;
	}
}
	function add_videogallery(formname)
	{ 
	if(MM_validateForm(formname,
		'divi_category','Please Select Division Category','R',
			'title','Please Enter Video Title','R',
			'vid_file','Please Upload Video File','R',
			'txtuplode','Please Upload Image File','R',
			'startdate','Please Enter Start date ','R',
			'expairydate','Please Enter Termination Date','R',
			'txtlanguage','Please Select Page Language','R',
			'txtstatus','Please Select Page Status.','R'))
		{
		return true;
		} 
		else{
		return false;
		}
}
function edit_videogallery(formname)
	{ 
	if(MM_validateForm(formname,'divi_category','Please Select Division Category','R',
			'title','Please Enter Video Title','R',
			'startdate','Please Enter Start date ','R',
			'expairydate','Please Enter Termination Date','R',
			'txtlanguage','Please Select Page Language','R' ))
		{
		return true;
		} 
		else{
		return false;
		}
}



function gsearch(formname)
{
	
if(MM_validateForm(formname,'q','Search Text','RisAlphaNum'))
	{
		
		return true;
	} else{
		return false;
	}
}
function deletemasage()
{	var agree=confirm('Are you sure you want to delete this record permanently?');
if (agree)
     return true ;
else      return false ;


}

function manage_rfd(formname)
{
	//alert('mnvcmncvnmvc');
if(MM_validateForm(formname,
	'txtlanguage','Please enter Language','R', 
	'txtename','Please enter document/page Name','R', 
	'txtepage_title','Please enter browser title','R',
	'quarter_doc','Please select one option','R',
	'financial_year','Please select financial year','R',
	'texttype','Please enter menu type','R',
	'txtstatus','Please select page status','R'
	
	))
	{

		return true;
	} 
	else{
		return false;
	}

}

function add_faq(formname)
{
	//alert('mnvcmncvnmvc');
if(MM_validateForm(formname,
	'txtlanguage','Please enter Language','R', 
	'modulename','Please select module','R', 
	'txtename','Please enter document/page Name','R', 
	'txtepage_title','Please enter browser title','R',
	'startdate','Please select startdate from calender','R',
	'expairydate','Please  enddate from calender','R',
	//'txtcontentdesc','Please enter content description','R',
	'txtstatus','Please select page status','R'
	
	))
	{

		return true;
	} 
	else{
		return false;
	}

}
