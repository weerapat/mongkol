// JavaScript Document
function uzXmlHttp(){ // 0bject UZ for ajax
  var xmlhttp = false;
  try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  }
  catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch (e) {
      xmlhttp = false;
    }
  }
    
  if (!xmlhttp && document.createElement) {
    xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}

function urlchange(url){
  window.location.replace(url);
}



function formatNumber(num, bln){ //num ส่งตัวเลข  bln { true== have , & Decimal)  (false == have  , only) } 
  num = num.toString().replace(/\$|\,/g, '');
  if (isNaN(num))
    num = "0";
  sign = (num == (num = Math.abs(num)));
  num = Math.floor(num * 100 + 0.50000000001);
  cents = num % 100;
  num = Math.floor(num / 100).toString();
  if (cents < 10)
    cents = "0" + cents;
  for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
    num = num.substring(0, num.length - (4 * i + 3)) + ',' +
    num.substring(num.length - (4 * i + 3));
  if (bln == true)
    t_return = (((sign) ? '' : '-') + num + '.' + cents);
  else
    t_return = (((sign) ? '' : '-') + num);
  return t_return;
}

/**
 * Return format not have comma.
 *
 * @param {Object}
 *            num
 * @param {Boolean}
 *            bln
 */
// this function have a ploblem .It cannot return  decimal type
function commaSplit(num){
  num = num.toString().replace(/\$|\,/g, '');
  if (isNaN(num))
    num = "0";
  if (num != 0) {
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
      cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
      num = num.substring(0, num.length - (4 * i + 3)) +
      num.substring(num.length - (4 * i + 3));
        
    t_return = (((sign) ? '' : '-') + num);
        
    return t_return;
  }
  else {
    return (num = "");
  }
}

/**
 * Return format not have comma.
 *
 * @param {string}
 *            num
 *
 *  ex  2,500.12 to 2500.12
 */
function splitComma(num){
  
  if(num){
  num = num.toString().replace(/\$|\,/g, '');
  num = parseFloat(num);
  }else{
    num = 0;
    num = parseFloat(num);
  }
  return num;
}

function checkEmail(obj){
  if (document.getElementById(obj).value == "") {
    return false;
  }
  else {
    if (((document.getElementById(obj).value).indexOf("@") == -1) || ((document.getElementById(obj).value).indexOf("@") == 0) || ((document.getElementById(obj).value).indexOf(".") == -1) || ((document.getElementById(obj).value).indexOf(".") == 0) || ((document.getElementById(obj).value).indexOf("@") == (document.getElementById(obj).value).length - 1)) {
      alert("โปรดระบุ Email ให้ถูกต้อง");
      document.getElementById(obj).focus();
      return false;
    }
  }
}

function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode
  if(charCode==13){
    evt.keyCode=9;
    return true;
  }
  if (charCode > 31 && (charCode < 48 || charCode > 57)){
    if (charCode > 31 && (charCode < 96 || charCode > 105)){
      return false;
    }
  }
	
  return true;
}

function checkEnter(e){ //e is event object passed from function invocation
  var characterCode //literal character code will be stored in this variable

  if(e && e.which){ //if which property of event object is supported (NN4)
    e = e
    characterCode = e.which //character code is contained in NN4's which property
  }else{
    e = event
    characterCode = e.keyCode //character code is contained in IE's keyCode property
  }
  if(characterCode == 0x0d){ //if generated character code is equal to ascii 13 (if enter key)
    e.keyCode=0x09;
  }
  return;
}


function changeAction_Insert_Regis_Form(){
  var c = document.getElementById('regis_form');
  c.action = "../action/action_insert_regis_form.php?action=insert";
  c.target = "_self";
  c.submit();
    
}
function changeAction_Insert_Regis_Form_With_pdf(){
  var c = document.getElementById('regis_form');
  c.action = "../action/action_insert_regis_form_pdf.php?action=insert_pdf";
  c.target = "_self";
  c.submit();
    
}
//// Function::ajax  ______open pdf
function send_insert_show_pdf(object,n){
  var url = '../html2fpdf/regis_form_pdf.php?activity='+n;
  var c=document.getElementById(object);
  xmlhttp=uzXmlHttp();
  xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState==4) {
      if (xmlhttp.status==200) {
        var ret=xmlhttp.responseText;
      }
    }
  }
  xmlhttp.open("GET", url,false);
  xmlhttp.setRequestHeader("If-Modified-Since", ""+ new Date().getTime()+"");
  xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;charset=windows-874');
  xmlhttp.send(null);
}

//Function :: print pdf nodata
function Action_Print_pdf_blank(){
	
  //var url = '../html2fpdf/blank_Application_pdf.phpf';
	
  //window.open('../pdf/blank_Application.pdf');
  window.open('../html2fpdf/blank_Application_pdf.php');
	
//    var c = document.getElementById('regis_form');
//    c.action = "../action/action_insert_regis_form_pdf.php?action=insert_pdf";
//    c.target = "_self";
//    c.submit();
    
}

function print_pdf_permis(){
  var vactivity_id=document.getElementById('activity_id_txt').value;
  window.open('../html2fpdf/pdf_permissive_form.php?activity_id='+vactivity_id);
	
}

function  name_pro( pro_id,text_name)
{
	
  if (pro_id !='') {
		
    var url = './getname_product.php?code=' + pro_id ;
    var xmlhttp = uzXmlHttp();
		
    xmlhttp.onreadystatechange = function(){
		
      if (xmlhttp.readyState == 4) {
        if (xmlhttp.status == 200) {
          var ret = xmlhttp.responseText;
          if(ret !='no_data'){
            document.getElementById(text_name).innerHTML = ret ;
          }
        }
      }
    }
    //alert(url);
    xmlhttp.open("GET", url, false);
    xmlhttp.setRequestHeader("If-Modified-Since", "" + new Date().getTime() + "");
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;charset=windows-874');
    xmlhttp.send(null);
  }
}

/**
 * return number with comma format.
 *
 */
function formatCurrency(num) {
	
  num = num.toString().replace(/\$|\,/g, '');
  if (isNaN(num))
    num = "0";

  sign = (num == (num = Math.abs(num)));
  num = Math.floor(num * 100 + 0.50000000001);
  cents = num % 100;
  num = Math.floor(num / 100).toString();
  if (cents < 10)
    cents = "0" + cents;
  for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
    num = num.substring(0, num.length - (4 * i + 3)) + ','
    + num.substring(num.length - (4 * i + 3));
  //alert(((sign) ? '' : '-') + num + '.' + cents);
  return (((sign) ? '' : '-') + num + '.' + cents);

}

function multiple_fuc(var1,var2,val3){
  var sum
  
  //alert('var 1='+var1)
  if(var1==""){
    var1=0;
  }
  if(var2==""){
    var2=0;
  }
  //var2 = var2.replace(/\,/g,"");
  //var1 = var1.replace(/\,/g,"");
  var2 = splitComma(var2);
  var1 = splitComma(var1);
  // vat include method
  if($('input[name=vat_include]:checked').val()==1){
    sum =var2*var1*100/107;
  }else{
    sum =var2*var1;
  }
  
  val3.value = formatCurrency(sum.toFixed( 2 ));
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features).focus();
}

function  openner_file_callback(file_popup){	 
  controlWindow=window.open(file_popup,"","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=900,height=600");
}


//===========================================================


function confirm_approve()
{
	
  alert("อนุมัติเรียบร้อย");
  window.close();
	
}



function validatetxt(fld,msg){
  if($('#'+fld).val()==""){
    alert(msg);
    $('#'+fld).focus();
    return false;
  }
  else{
    return true;
  }
}


// ex 29-11-2553
// return Mon Nov 11 2010 13:48:59 GMT+0700 (SE Asia Standard Time)
function dateToFormat(num){
  var date=new Date();
  var year;
  var month;
  var day;
  year = num.substr(6,4)-543;
  month = num.substr(3,2);
  day = num.substr(0,2);
  date.setFullYear(year,month-1,day);
  return date;
}

// plusday คือวันที่นับถัดไป
// Ex 12-11-2553  to   14-11-2553 if plus day is two.
function getNextDay(date,plusday){
  date = dateToFormat(date);
  var day = new Date(date);
  plusday = parseInt(plusday);
  day.setDate(day.getDate()+plusday);
  day = setFormatDate(day);
  return day;
}

// input Mon Nov 11 2010 13:48:59 GMT+0700 (SE Asia Standard Time)
// return 11-9-2010
function setFormatDate(d){
  var curr_date = d.getDate();
  var curr_month = d.getMonth()+1;
  var curr_year = d.getFullYear()+543;
  
  return curr_date + "-" + curr_month + "-" + curr_year;
}


// แปลงจาก json object เป็น string ใน js  convert ของ jquery.parseJSON
function Stringify(jsonData) {
  var strJsonData = '{';
  var itemCount = 0;
  for (var item in jsonData) {
    if (itemCount > 0) {
      strJsonData += ', ';
    }
    temp = jsonData[item];
    if (typeof(temp) == 'object') {
      s =  Stringify(temp);
    } else {
      s = '"' + temp + '"';
    }
    strJsonData += '"' + item + '":' + s;
    itemCount++;
  }
  strJsonData += '}';
  return strJsonData;
}

/**
 * ex 19/09/2010
 * getDateObject('19/09/2010','/');
 * 
 * retrun date object
 */
function getDateObject(dateString,dateSeperator)
{
  //This function return a date object after accepting
  //a date string ans dateseparator as arguments
  var curValue=dateString;
  var sepChar=dateSeperator;
  var curPos=0;
  var cDate,cMonth,cYear;

  //extract day portion
  curPos=dateString.indexOf(sepChar);
  cDate=dateString.substring(0,curPos);

  //extract month portion
  endPos=dateString.indexOf(sepChar,curPos+1);
  cMonth=dateString.substring(curPos+1,endPos);

  //extract year portion
  curPos=endPos;
  endPos=curPos+5;
  cYear=curValue.substring(curPos+1,endPos);

  //Create Date Object
  dtObject=new Date(cYear,cMonth,cDate);
  return dtObject;
}

function typeFileValid(id){
  var ext = $('#'+id).val().split('.').pop().toLowerCase();
  if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
    alert('invalid extension!');
    $('#'+id).val("");
    return false;
  }else
    return true;
}


function curencyNm(amount){
  /* Since we are extending Number prototype, amount **must** be a real number */
  var amount = "12345.6789"; // But, in case it is not (like the above example: "string "), we need to convert it 
  typeof(amount) == 'number' ? null : typeof(amount) == 'string' ? amount = parseFloat(amount) : null;
  var currency_string =  amount.toCurrency({
    "thousands_separator":",",
    "currency_symbol":"$",
    "symbol_position":"front",
    "use_fractions" : {
      "fractions":2, 
      "fraction_separator":"."
    }
  }); // 12345.6789 should return $12,345.68
               
  return currency_string;
}                
