<?php
include "header.php";
include "header_php.php";

if (isset($_GET['task'])) { $task = $_GET["task"]; } else { $task = $_POST["task"]; }
if (isset($_GET['quo_no'])) { $quo_no = $_GET['quo_no']; } else { $quo_no = $_POST["quo_no"]; }

$quo_id = $_POST["quo_id"];
$quo_date = changeformatdate($_POST["quo_date"]);
$quo_nameto = $_POST["quo_nameto"];
$quo_customer = $_POST["quo_customer"];
$quo_company = $_POST["quo_company"];
$quo_subtotal = rmComma($_POST["subtotal"]);
$quo_discount = rmComma($_POST["discount"]);
$quo_after_discount = rmComma($_POST["after_discount"]);
$quo_vat = rmComma($_POST["vat"]);
$quo_total = rmComma($_POST["total"]);
$quo_tax_status = $_POST["tax_status"];
$quo_remark = $_POST["quo_remark"];
$quo_dealer = $_POST["quo_dealer"];
$quo_create_by = $_SESSION['user_name'];
$quo_create_date = datetime_now();
$quo_update_by = $_SESSION['user_name'];
$quo_update_date = datetime_now();

$hid_detail = trim($_POST["hid_detail"]);

if ($task == "save") {

  $quo_id = get_preid('quotation_tab', 'quo_id', $quo_company, 'quo_company');
  $sql = "INSERT INTO quotation_tab (
            quo_id,
            quo_date,
            quo_nameto,
            quo_customer,
            quo_company,
            quo_subtotal,
            quo_discount,
            quo_after_discount,
            quo_vat,
            quo_total,
            quo_tax_status,
            quo_remark,
            quo_dealer,
            quo_create_by,
            quo_create_date
            )VALUES (
            '$quo_id',
            '$quo_date',
            '$quo_nameto',
            '$quo_customer',
            '$quo_company',
            '$quo_subtotal',
            '$quo_discount',
            '$quo_after_discount',
            '$quo_vat',
            '$quo_total',
            '$quo_tax_status',
            '$quo_remark',
            '$quo_dealer',
            '$quo_create_by',
            '$quo_create_date'
            )
           ";
  //echo $sql;
  $result = mysql_query($sql);
  $message = "บันทึกข้อมูลสำเร็จ";
}

// UPDATE
if ($task == "edit") {
  $sql = "UPDATE quotation_tab SET
            quo_id = '$quo_id',
            quo_date = '$quo_date',
            quo_nameto = '$quo_nameto',
            quo_customer = '$quo_customer',
            quo_company = '$quo_company',
            quo_subtotal= '$quo_subtotal',
            quo_discount= '$quo_discount',
            quo_after_discount= '$quo_after_discount',
            quo_vat= '$quo_vat',
            quo_total= '$quo_total',
            quo_tax_status= '$quo_tax_status',
            quo_remark= '$quo_remark',
            quo_dealer= '$quo_dealer',
            quo_update_by = '$quo_update_by',
            quo_update_date = '$quo_update_date'
            WHERE quo_no = '$quo_no' LIMIT 1 ;
  ";

  $result = mysql_query($sql);

  $message = "แก้ไขข้อมูลสำเร็จ";
}

if ($task == 'save' || $task == 'edit') {

  if ($hid_detail) {
    $sql = "DELETE FROM quotation_d  WHERE  quo_id = '{$quo_id}' ";
    mysql_query($sql);
//  =====insert===========================
    $detail_splid = explode("|", $hid_detail);
    $length = count($detail_splid);
    //print_r($detail_splid);

    for ($i = 0; $i < $length - 1; $i++) {
      $inline = $i + 1;
      $detail_value = $detail_splid[$i];
      $detail_insert = explode("?", $detail_value);
      /*       * ************
        รายการ , จำนวน ,หน่วย,หน่วยละ  , จำนวนเงิน
       * ******** */

      $description = $detail_insert[0]; // รายการ
      $amount = rmComma($detail_insert[1]);
      $unit = rmComma($detail_insert[2]);
      $perunit = rmComma($detail_insert[3]);
      $linetotal = rmComma($detail_insert[4]);
      $sql_detail = "INSERT INTO quotation_d (
                    quo_id ,
                    description ,
                    amount ,
                    unit,
                    perunit ,
                    total
                    )VALUES (
                    '$quo_id',
                    '$description',
                    '$amount',
                    '$unit',
                    '$perunit',
                    '$linetotal'
                    )";
      //echo $sql_detail;
      $result = mysql_query($sql_detail);
    }
  }
}

if ($task == "delete") {
  $sql = "DELETE FROM quotation_tab  WHERE  quo_no = '{$quo_no}' ";
  mysql_query($sql);

  $sql = "DELETE FROM quotation_d  WHERE  quo_id = '{$quo_id}' ";
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
        <?
        if ($error_msg) {
          echo $error_msg;
        } else {

          echo $message;
          redirect_page('quotation_search.php', 2);
        }
        ?>
    </div>
  </div>
</div>

<? include "footer.php" ?>
