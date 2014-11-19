function calculateOt(holiday,rowId){

  var datein = $('#datein'+rowId).val();
  var dateout = $('#dateout'+rowId+' :selected').text();
  var time_workend =  $('#time_end').val();
  var time_workst = $('#time_start').val();
  var time_st = $('#checkin'+rowId).val();
  var timelunch = $('#checkin'+rowId).val();
  var ntimelunch = $('#checkout'+rowId).val();
  var time_end = $('#checkout'+rowId).val();
  var worktime;

  time_st = hrFormat(time_st);
  time_workst = hrFormat(time_workst);

  if(datein!=dateout){
    time_end = 2400+parseInt(time_end);
  }
 
  time_end = hrFormat(time_end);
  
  time_workend = hrFormat(time_workend);

  // ถ้าเวลาเข้างานน้อยกว่า 8.30 จะเริ่มต้นที่ 8.30
  if(time_st<time_workst){
    time_st = time_workst;
  }
  // วันปกติ
  if(holiday == 0){
    worktime = time_end - time_workend;
    var hr = Math.floor(worktime/60);
    if (hr<0) hr = 0;
    var minute = worktime%60;
    if (minute<0) minute = 0;
    worktime = hr+"."+minute;
  }
  // วันหยุด
  if(holiday == 1){
    worktime = time_end - time_st;
    
    // หักเวลาพักเที่ยง
    if(timelunch < 1200 && ntimelunch > 1330){
      worktime = worktime-60;
    }

    var hr = Math.floor(worktime/60);
    if (hr<0) hr = 0;
    var minute = worktime%60;
    if (minute<0) minute = 0;
    worktime = hr+"."+minute;
    
  }

  if (worktime =='NaN.NaN'){
    worktime = '0.0';
  }
  $('#count_ot'+rowId).html(worktime);
}

function hrFormat(num){
  var hr = Math.floor(num/100);
  var minute = num % 100;
  var time = (hr*60)+ minute;
  return time;
}

function checkOt(rowId){

  var checkbox = $('#overtime'+rowId).is(':checked');
  var start_ot = $('#start_ot'+rowId);
  var end_ot = $('#end_ot'+rowId);

  if(checkbox == true){
    start_ot.removeAttr("disabled");
    end_ot.removeAttr("disabled");
  }
  if(checkbox == false){
    start_ot.attr("disabled","disabled");
    end_ot.attr("disabled","disabled");
  }
}


