<?php
include "header.php";
include "header_php.php";

if (isset($_GET['task'])) { $task = $_GET["task"]; } else { $task = $_POST["task"]; }
if (isset($_GET['contacten_no'])) { $contacten_no = $_GET['contacten_no']; } else { $contacten_no = $_POST["contacten_no"]; }

$contacten_id = $_POST["contacten_id"];
$contacten_date = changeformatdate($_POST["contacten_date"]);
$contacten_customer = $_POST["contacten_customer"];
$contacten_company = $_POST["contacten_company"];
$contacten_pono = $_POST["contacten_pono"];

$contacten_workplace = $_POST["contacten_workplace"];
$contacten_workappear = $_POST["contacten_workappear"];


// product input
$contacten_productname = $_POST["contacten_productname"];        
$contacten_productsize = $_POST["contacten_productsize"];  
$contacten_productnumber = $_POST["contacten_productnumber"];      
$contacten_productprice = rmComma($_POST["contacten_productprice"]);


$contacten_agreementdate = rmComma($_POST["contacten_agreementdate"]);
$contacten_equipment1 = $_POST["contacten_equipment1"];
$contacten_equipment2 = $_POST["contacten_equipment2"];
$contacten_equipment3 = $_POST["contacten_equipment3"];
$contacten_equipment4 = $_POST["contacten_equipment4"];
$contacten_equipment_unit1 = $_POST["contacten_equipment_unit1"];
$contacten_equipment_unit2 = $_POST["contacten_equipment_unit2"];
$contacten_equipment_unit3 = $_POST["contacten_equipment_unit3"];
$contacten_equipment_unit4 = $_POST["contacten_equipment_unit4"];
$contacten_oilloss = $_POST["contacten_oilloss"];
$contacten_keyloss = $_POST["contacten_keyloss"];

$contacten_transport = $_POST["contacten_transport"];
$contacten_transportprice = rmComma($_POST["contacten_transportprice"]);
$contacten_carlicense = $_POST["contacten_carlicense"];
$contacten_normaltime = $_POST["contacten_normaltime"];
$contacten_normaltimeto = $_POST["contacten_normaltimeto"];
$contacten_unit = $_POST["contacten_unit"];
$contacten_priceperunit = rmComma($_POST["contacten_priceperunit"]);
$contacten_overtime = $_POST["contacten_overtime"];
$contacten_overtimeto = $_POST["contacten_overtimeto"];
$contacten_hourprice = rmComma($_POST["contacten_hourprice"]);
$contacten_hourcount = $_POST["contacten_hourcount"];
$contacten_total = rmComma($_POST["contacten_total"]);
$contacten_remark = $_POST["contacten_remark"];
$pay_status = $_POST["pay_status"];
$contacten_create_by = $_SESSION['user_name'];
$contacten_create_date = datetime_now();
$contacten_update_by = $_SESSION['user_name'];
$contacten_update_date = datetime_now();



if ($task == "save") {

$contacten_id = get_preid('contacten_tab', 'contacten_id', $contacten_company, 'contacten_company');


  $sql = "INSERT INTO contacten_tab (
            contacten_id,
            contacten_date,
            contacten_customer,
            contacten_company,
            contacten_pono,
            contacten_productname,
            contacten_productsize,
            contacten_productnumber,
            contacten_productprice,
            contacten_workplace,
            contacten_workappear,
            contacten_agreementdate,
            contacten_equipment1,
            contacten_equipment2,
            contacten_equipment3,
            contacten_equipment4,
            contacten_equipment_unit1,
            contacten_equipment_unit2,
            contacten_equipment_unit3,
            contacten_equipment_unit4,
            contacten_oilloss,
            contacten_keyloss,
            contacten_carlicense,
            contacten_transport,
            contacten_transportprice,
            contacten_normaltime,
            contacten_normaltimeto,
            contacten_unit,
            contacten_priceperunit,
            contacten_overtime,
            contacten_overtimeto,
            contacten_hourprice,
            contacten_hourcount,
            contacten_total,
            contacten_remark,
            pay_status,
            contacten_create_by,
            contacten_create_date
            )VALUES (
            '$contacten_id',
            '$contacten_date',
            '$contacten_customer',
            '$contacten_company',
            '$contacten_pono',
            '$contacten_productname',
            '$contacten_productsize',
            '$contacten_productnumber',
            '$contacten_productprice',
            '$contacten_workplace',
            '$contacten_workappear',
            '$contacten_agreementdate',
            '$contacten_equipment1',
            '$contacten_equipment2',
            '$contacten_equipment3',
            '$contacten_equipment4',
            '$contacten_equipment_unit1',
            '$contacten_equipment_unit2',
            '$contacten_equipment_unit3',
            '$contacten_equipment_unit4',
            '$contacten_oilloss',
            '$contacten_keyloss',
            '$contacten_carlicense',
            '$contacten_transport',
            '$contacten_transportprice',
            '$contacten_normaltime',
            '$contacten_normaltimeto',
            '$contacten_unit',
            '$contacten_priceperunit',
            '$contacten_overtime',
            '$contacten_overtimeto',
            '$contacten_hourprice',
            '$contacten_hourcount',
            '$contacten_total',
            '$contacten_remark',
            '$pay_status',
            '$contacten_create_by',
            '$contacten_create_date'
            )
           ";
  //echo $sql;
  $result = mysql_query($sql);
  $message = "บันทึกข้อมูลสำเร็จ";
}

// UPDATE
if ($task == "edit") {
  $sql = "UPDATE contacten_tab SET
            contacten_id = '$contacten_id',
            contacten_date = '$contacten_date',
            contacten_customer = '$contacten_customer',
            contacten_company = '$contacten_company',
            contacten_pono = '$contacten_pono',
            contacten_workplace = '$contacten_workplace',
            contacten_workappear = '$contacten_workappear',
            contacten_productname = '$contacten_productname',
            contacten_productsize = '$contacten_productsize',
            contacten_productnumber = '$contacten_productnumber',
            contacten_productprice = '$contacten_productprice',
            contacten_agreementdate = '$contacten_agreementdate',
            contacten_equipment1 = '$contacten_equipment1',
            contacten_equipment2 = '$contacten_equipment2',
            contacten_equipment3 = '$contacten_equipment3',
            contacten_equipment4 = '$contacten_equipment4',
            contacten_equipment_unit1 = '$contacten_equipment_unit1',
            contacten_equipment_unit2 = '$contacten_equipment_unit2',
            contacten_equipment_unit3 = '$contacten_equipment_unit3',
            contacten_equipment_unit4 = '$contacten_equipment_unit4',
            contacten_oilloss = '$contacten_oilloss',
            contacten_keyloss = '$contacten_keyloss',
            contacten_transport = '$contacten_transport',
            contacten_transportprice = '$contacten_transportprice',
            contacten_carlicense = '$contacten_carlicense',
            contacten_normaltime = '$contacten_normaltime',
            contacten_normaltimeto = '$contacten_normaltimeto',
            contacten_unit = '$contacten_unit',
            contacten_priceperunit = '$contacten_priceperunit',
            contacten_overtime = '$contacten_overtime',
            contacten_overtimeto = '$contacten_overtimeto',
            contacten_hourprice = '$contacten_hourprice',
            contacten_hourcount = '$contacten_hourcount',
            contacten_total = '$contacten_total',
            contacten_remark = '$contacten_remark',
            pay_status = '$pay_status',
            contacten_update_by = '$contacten_update_by',
            contacten_update_date = '$contacten_update_date'
            WHERE contacten_no = '$contacten_no' LIMIT 1 ;
  ";

  $result = mysql_query($sql);
  $message = "แก้ไขข้อมูลสำเร็จ";
}

if ($task == "delete") {
  $sql = "DELETE FROM contacten_tab  WHERE  contacten_no = '{$contacten_no}' ";
  mysql_query($sql);
  $message = "ลบข้อมูลสำเร็จ";
}

// Error case
$error_msg = mysql_error($conn);
?>
<div class=content>
  <div id ="successMsg">
    <div style="width: 300px;" class="outter">

      <span style="margin-right: 10px;"><img class="icon" src="images/load.gif" alt="loading" /></span>
        <?php
        if ($error_msg) {
          echo $error_msg;
        } else {

          echo $message;
          redirect_page('contact_engage_search.php', 2);
        }
        ?>
    </div>
  </div>
</div>

<?php include "footer.php" ?>
