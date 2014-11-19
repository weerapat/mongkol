<?php

function cuType($cu_type) {
  if ($cu_type == 1) {
    $typename = "บริษัท";
  } elseif ($cu_type == 2) {
    $typename = "ห้างหุ้นส่วนจำกัด";
  }
  return $typename;
}

function cuName($cu_type, $cu_name) {
  if ($cu_type == 1) {
    $typename = "บริษัท $cu_name";
  } elseif ($cu_type == 2) {
    $typename = "ห้างหุ้นส่วนจำกัด $cu_name";
  } elseif ($cu_type == 3) {
    $typename = $cu_name;
  } elseif ($cu_type == 4) {
    $typename = "ร้าน $cu_name";
  } elseif ($cu_type == 5) {
    $typename = "คณะบุคคล $cu_name";
  }
  return $typename;
}

function getCompanyName($companynum) {
  if ($companynum == 1) {
    $name = "มิตรมงคล";
  } elseif ($companynum == 2) {
    $name = "มงคลทวีทรัพย์";
  }elseif ($companynum == 3) {
    $name = "มิตรมงคล อีควิปเม้นท์";
  }
  return $name;
}

function getPayword($val) {
  if ($val == 0) {
    $name = "ยังไม่ชำระเงิน";
  } elseif ($val == 1) {
    $name = "ชำระเงินแล้ว";
  }
  return $name;
}

function get_preid($table, $field, $companyId, $companyFld) {

  $sql = "SELECT max({$field}) as num FROM {$table} WHERE {$companyFld} = '{$companyId}'  ";
  $result = mysql_query($sql);
  $row = mysql_fetch_assoc($result);
  //echo $row['num'];
  $num = substr($row['num'], 5) + 1;
  $nextId = str_pad($num, 5, "0", STR_PAD_LEFT);

//  $sql = "SHOW TABLE STATUS LIKE '{$table}'";
//  $result = mysql_query($sql);
//  $row = mysql_fetch_assoc($result);
//  $next_increment = $row['Auto_increment'];
//  $next_increment = str_pad($next_increment, 5, "0", STR_PAD_LEFT);


  $year = substr(date("Y"), 2, 2) + 43;
  $id = $year . "-" . $nextId;

  if ($companyId == 1) {
    $id = 'MM' . $id;
  } 
  elseif ($companyId == 2) {
    $id = 'MT' . $id;
  }  
  elseif ($companyId == 3) {
    $id = 'ME' . $id;
  }

  return $id;
}

function getPrefix($num, $companyId) {
//  if($companyId==1){
//    $num = 'MM'.$num;
//  }else{
//    $num = 'MT'.$num;
//  }

  return $num;
}



function productType($product_type, $product_no) {
  $sql = "SELECT * FROM product_type WHERE producttype_id = '{$product_type}'";
  $result = mysql_query($sql);
  $row = mysql_fetch_assoc($result);

  if ($row['producttype_name'] == "อื่นๆ") {
    $sql = "SELECT * FROM product_tab WHERE product_no = '{$product_no}'";
    $result = mysql_query($sql);
    $row = mysql_fetch_assoc($result);
    return $row['product_othertype'];
  }else
    return $row['producttype_name'];
}

function redirect_page($url, $delay) {
  echo '<meta http-equiv="refresh" content="' . $delay . ';url=' . $url . '">';
}

function datetime_now() {
  $date = date("Y-m-d H:i:s");
  return $date;
}

function changeformatdate($strvalue) {

  if ($strvalue && $strvalue != "00-00-0000") {
    $dd = substr($strvalue, 0, 2);
    $mm = substr($strvalue, 3, 2);
    $yy = substr($strvalue, 6, 4);
    $yy = $yy - 543;

    $formatdate = "$yy-$mm-$dd";
    return $formatdate;
  } else {
    return "0000-00-00";
  }
}

function splitdate($vadate, $type = "min") {


  if ($vadate != "" && $vadate != "0000-00-00") {
    $dd = substr($vadate, 8, 2);
    $mm = substr($vadate, 5, 2);
    $yy = substr($vadate, 0, 4);
    $yy = $yy + 543 + 543; // for fix bug datepicker budist format Suck
    //echo $yy;
    if ($type == "min") { $yy = substr($yy, 2, 2); }
    if ($type == "avg")
      $yy = $yy - 543;

    $datesplit = "$dd/$mm/$yy";

    return $datesplit;
  }else
    return "00/00/00";
}

function rmComma($value) {
  return str_replace(",", "", $value);
}

/**
 *   function list
 *   monththai  // คืนค่าเป็นเดือนภาษาไทย
 *   daythai  // คืนค่าเป็นวันภาษาไทย
 *
 *
 *
 */
function datenow() {
  $nowyear = date("Y") + 1086;
  return date("d/m/") . $nowyear;
}

function getCustomer($customerNo) {
  $sql = "SELECT * FROM customer_tab WHERE cu_no = '{$customerNo}'";
  $result = mysql_query($sql);
  $row = mysql_fetch_assoc($result);
  return $row;
}

function getProduct($productNo) {
  $sql = "SELECT * FROM product_tab WHERE product_no = '{$productNo}'";
  $result = mysql_query($sql);
  $row = mysql_fetch_assoc($result);
  return $row;
}

function bathformat($number) {
  $numberstr = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า', 'สิบ');
  $digitstr = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');

  $number = str_replace(",", "", $number); //ลบ comma
  $number = explode(".", $number); //แยกจุดทศนิยมออก
  //เลขจำนวนเต็ม
  $strlen = strlen($number[0]);
  $result = '';
  for ($i = 0; $i < $strlen; $i++) {
    $n = substr($number[0], $i, 1);
    if ($n != 0) {
      if ($i == ($strlen - 1) AND $n == 1) { $result .= 'เอ็ด'; } elseif ($i == ($strlen - 2) AND $n == 2) { $result .= 'ยี่'; } elseif ($i == ($strlen - 2) AND $n == 1) { $result .= ''; } else { $result .= $numberstr[$n]; }
      $result .= $digitstr[$strlen - $i - 1];
    }
  }

  //จุดทศนิยม
  $strlen = strlen($number[1]);
  if ($strlen > 2) { //ทศนิยมมากกว่า 2 ตำแหน่ง คืนค่าเป็นตัวเลข
    $result .= 'จุด';
    for ($i = 0; $i < $strlen; $i++) {
      $result .= $numberstr[(int) $number[1][$i]];
    }
  } else { //คืนค่าเป็นจำนวนเงิน (บาท)
    $result .= 'บาท';
    if ($number[1] == '0' OR $number[1] == '00' OR $number[1] == '') {
      $result .= 'ถ้วน';
    } else {
      //จุดทศนิยม (สตางค์)
      for ($i = 0; $i < $strlen; $i++) {
        $n = substr($number[1], $i, 1);
        if ($n != 0) {
          if ($i == ($strlen - 1) AND $n == 1) { $result .= 'เอ็ด'; } elseif ($i == ($strlen - 2) AND $n == 2) { $result .= 'ยี่'; } elseif ($i == ($strlen - 2) AND $n == 1) { $result .= ''; } else { $result .= $numberstr[$n]; }
          $result .= $digitstr[$strlen - $i - 1];
        }
      }
      $result .= 'สตางค์';
    }
  }
  return $result;
}

?>