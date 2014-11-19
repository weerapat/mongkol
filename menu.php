<?php

include "header.php";
include "header_php.php";
?>
<style type="text/css">
  .menu_disable{
    color: #c1bebe;
  }
</style>

<div class="content">

  <div class="txtHead" style="width: 100px" >ระบบสำนักงาน</div>

    <ul class="mainNav">
      <li ><a href="quotation_search.php" >ออกใบเสนอราคา</a></li>
      <li ><a href="invoice_search.php" >ออกใบแจ้งหนี้</a></li>
      <li ><a href="contact_engage_search.php" >ออกใบสัญญาว่าจ้าง/เช่าและรับรองเวลาทำงาน</a></li>
      <li ><a href="receipt_search.php" >ออกใบเสร็จ/ใบกำกับภาษี</a></li>
      <li ><a href="income_report.php" >ออกรายงานสรุปยอดรายรับ</a></li>
      <li><a href="unit_master.php" >ฐานข้อมูลหน่วยสินค้า</a></li>
      <li><a href="customer_search.php" >ฐานข้อมูลลูกค้า</a></li>
      <li ><a href="product_search.php" >ฐานข้อมูลสินค้า</a></li>
      <li><a href="logout.php" >ออกจากระบบ</a></li>
    </ul>



  <?php include "footer.php" ?>
