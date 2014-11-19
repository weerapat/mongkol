var Utility = {
	/**
	 * ปุ่มบนแป้นคีย์บอร์ดที่สามารถปล่อยได้ คือ 0123456789-,.
	 * 
	 * @param {Object} e
	 */
	isNumberKey : function(e) {
		
		if (!((e.keyCode >= 47) && (e.keyCode <= 57) && (e.keyCode==110))) {
			
			e.keyCode = 0;
			return e.keyCode;
		}
	},
	
	
	
	
	
	isNumberKey_numberic : function(e) {
		
		if (!((e.keyCode >= 47) && (e.keyCode <= 57) )) {
			alert(e.keyCode );
			
			e.keyCode = 0;
			return e.keyCode;
		}
	},
	/**
	 * เลื่อน Focus ใน object Forms ไปยัง object Forms ถัดไป
	 * 
	 * @param {Object} e
	 */
	checkEnter : function(e) { // e is event object passed from
	
		// function invocation
		var characterCode; // literal character code will be stored in
		// this
		// variable
		if (e && e.which) { // if which property of event object is
			// supported (NN4)
			e = e;
			characterCode = e.which; // character code is contained
			// in NN4's
			// which property
		} else {
			e = event;
			characterCode = e.keyCode; // character code is contained
			// in IE's
			// keyCode property
		}

		if (characterCode == 0x0d) { // if generated character code
			// is equal to
			// ascii 13 (if enter key)
			
			e.keyCode = 9;
		}
		
		
		
	},
	/**
	 * เลื่อนโฟกัสไปที่วัตถุที่กำหนด
	 * 
	 * @param {Object} nextObject
	 * @return {void}
	 */
	nextObject : function(nextObject) {
		nextObject.focus();
	},
	/**
	 * ตรวจสอบค่าว่าเป็นรูปแบบ E-Mail หรือไม่
	 * 
	 * @param {Object}
	 *            objElement
	 * @return boolean
	 */
	isEmail : function(objElement) {
		
		if(objElement.value==""){ return false}
		var str = objElement.value;
		var re = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
		if (!str.match(re)) {
			
			
			
			
			
//			MessageBox.show('พบข้อผิดพลาด!', 
//                'E-Mail มีรูปแบบไม่ถูกต้อง โปรดแก้ไขอีกครั้ง', Buttons = [{
//                    text: "ตกลง",
//                    handler: function(){
//                        this.destroy();
//                        objElement.focus();
//                    },
//                    isDefault: false
//                }], 'WARN');

          	return false;
		} else {
			return true;
		}
	},
	removeDecimal : function(num) {
		num = num.toString().replace(/\$|\,/g, '');
		if (isNaN(num)) {
			num = "0";
		}
		if (num != 0) {
			return Math.round(num);
		} else {
			num = "";
			return num;
		}
	},
	removeComma : function(num) {
		
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
				num = num.substring(0, num.length - (4 * i + 3))
						+ num.substring(num.length - (4 * i + 3));

			return (((sign) ? '' : '-') + num + '.' + cents);
		} else {
			num = "";
			return;
		}
	},
	
	
	
	
	
	formatCurrency : function(num) {
	
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

	},
	/**
	 * เปลี่ยนสีพื้นหลังเมื่อมีการ Focus ที่ object 
	 * @param {Object} objForms
	 */
	 focusIt:function(objForms,hexColor) {
	 	if(hexColor==''){
	 		hexColor="#FFFFCC";
	 	}
		objForms.style.backgroundColor = hexColor;
	},
	
	/**
	 * เปลี่ยนสีพื้นหลังเมื่อมีการ Lost Focus ที่ object
	 * 
	 * @param {Object} objForms
	 */
	 lostFocusIt:function(objForms,hexColor) {
	 	if(hexColor==''){
	 		hexColor="#FFFFFF";
	 	}
		objForms.style.backgroundColor = hexColor;
	},
	/**
	 * เมทอดจับคู่ List box กับ value
	 * @param {Object} objSelectBox
	 * @param {String} strValue
	 * @return void
	 */
	matchListBox:function(objSelectBox, strValue){
	    for (var intLoop = 0; intLoop < objSelectBox.length; intLoop++) {
	        if (strValue == objSelectBox.options[intLoop].value) {
	            objSelectBox.selectedIndex = intLoop;
	        }
	    }
	},
	notDecimal:function(num) {
    num = num.toString().replace(/\$|\,/g,'');
    if(isNaN(num))
        num = "0";
		if(num != 0){        	
    		return Math.round(num);
		}else{
			return  num = "";
		}
	},
	dumpObjectForm:function(formName){
		var x;
    	for(var m =0; m < formName.elements.length ; m++){
    		x += "uri +=\"&"+formName.elements[m].name+"=\"+Product.oForm."+formName.elements[m].name+".value;<br />";
    	}
    	
    	MessageBox.show('ข้อมูลเพิ่มเติม', x, Buttons = [{
	                        text: "ตกลง",
	                        handler: function(){
	                            this.destroy();
	                        },
	                        isDefault: false
	                    }], 'INFO');
	},
    subenterortab: function(vstring){
        var dumpstring = "";
        var str_sub = vstring;
        var ii = 0;
		var check = true;
		dumpstring = str_sub.substring(0, 1);
		//vstring="$"+vstring+"$";
		//alert(ascii(vstring));
		//alert("$"+dumpstring+"$");
	while ((check) && (ii < vstring.length)) {
			ii++;
            dumpstring = str_sub.substring(0, 1);
			
			if (dumpstring != ' ') {
				 check = false;
			}
            str_sub = str_sub.substring(1);
        }
        
        return check;
    },
  
    checkformatdate: function(vthis){
		//alert("work");
		vstring=vthis.value ;
		$strdate = vstring.substring(2,3);
		$strmonh = vstring.substring(5, 6);
		
        if (($strdate != "-") || ($strmonh != "-")) {
            alert("รูปแบบวันที่ไม่ถูกต้อง หรือมีช่องว่าง กรุณาป้อนใหม่..!!");
			vthis.focus();
        }
     },
	 focusfirst : function(str_box){
	 	document.getElementById(str_box).focus();
         
	 },
	 
	 showError :function(el_obj,str_error,img_locate){	 
	 	var strEl = "<img src='"+img_locate+"' alt='"+str_error+"' /> ";
		el_obj.innerHTML=strEl;
	 },
	 
     validDate: function(str_date, el_obj, str_error, img_locate){
         var vDate = true;
         if ((str_date.value.length == 10)) {
             strdate = str_date.value.substr(0, 2);
             strSep1 = str_date.value.substr(2, 1);
             strmonth = str_date.value.substr(3, 2);
             strSep2 = str_date.value.substr(5, 1);
             stryear = str_date.value.substr(6, 4);
             
             if ((strdate.lengtgh > 0 && strdate.lengtgh <= 2) || (strmonth.lengtgh > 0 && strmonth.lengtgh <= 2) || (stryear.lengtgh > 0 && stryear.lengtgh <= 4)) {
                 str_date.focus();
                 vDate = false;
				  
             }
             
             if (isNaN(strdate) || isNaN(strmonth) || isNaN(stryear)) {
                 str_date.focus();
                 vDate = false;
				 
             }
             
             if (strSep1 != '-' || strSep2 != '-') {
                 str_date.focus();
                 vDate = false;
				 
             }
             
             
         }else {
             str_date.focus();
             vDate = false;
         }
		 
		 if (vDate == false) {
             this.showError(el_obj, str_error, img_locate);
         }else {
             el_obj.innerHTML = '';
             return vDate;
         }
     },
	 
	 logofprogram :function (){
	
	var url = './getid_frompropersal.php?checkform=logof';
		var xmlhttp = uzXmlHttp();
		xmlhttp.onreadystatechange = function(){
			if (xmlhttp.readyState == 4) {
				if (xmlhttp.status == 200) {
				
					
				
				}
			}
		}
		//alert(url);
		xmlhttp.open("GET", url, false);
		xmlhttp.setRequestHeader("If-Modified-Since", "" + new Date().getTime() + "");
		xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;charset=windows-874');
		xmlhttp.send(null);
	
	
	
	} ,
	
	 levelapprove:function (vallink){

			var level_b = document.getElementById('lavel_b').value ;
			if(level_b != "" && level_b== 1){
			if(vallink=='commu'){
				window.location="./view_club_teacher.php";//อนุมัติ ชุมนุม
			}
			if(vallink=='commu_act'){
				window.location="./commu_act_approve.php"; //อนุมัติกิจกรรมชุมนุม
			}
		} 
			
	}
	
	
	
	
};