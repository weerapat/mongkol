<?php
include "header.php";
include "header_php.php";

?>
<script language="javascript" type="text/javascript">
  

  $(document).ready(function(){


    
    
      
    // initial form search
    $('#formSrh').dialog({ 
      autoOpen: false,
      width : 350,
      modal: true
    });
 


  });
  
  function openSrh(){
    //alert('hi');
    $("#formsrh").dialog("open"); 
  }

</script>




<div class="content">

  <div id="navigator"> 
    <a href="menu.php">Menu </a> 
    <a href="contacten_search.php"><img src="images/btween_link.png" width="10" height="7" align="absmiddle">  ค้นหาข้อมูลใบสัญญาว่าจ้าง/เช่าและรับรองเวลาทำงาน </a> 
    <img src="images/btween_link.png" width="10" height="7" align="absmiddle">  ใบสัญญาว่าจ้าง/เช่าและรับรองเวลาทำงาน 
  </div>
  <div class="txtHead" style="width: 250px" >ใบสัญญาว่าจ้าง/เช่าและรับรองเวลาทำงาน</div>

  <div class="outter" style="width: 800px">

    <?php if ($task == "edit") { ?>
      <div style="position: relative;top:10px;left:480px;"><button id="openNote" type="button" >รายละเอียดเพิ่มเติม</button></div>
    <?php } ?>
    <form id="formID" action="contact_engage_do.php" method="post" >
      <table width="758">

        <tr>
          <td width="137" class="formLabel" >รหัสสัญญา :</td>
          <td width="259"><input readonly="readonly" class="forbidTxt" name="contacten_id"  id="contacten_id" type="text" value="<?= $row['contacten_id'] ?>" /></td>
          <td width="142" class="formLabel" >วันที่ :</td>
          <td width="200"  ><input style="width: 70px;"  name="contacten_date2" id="contacten_date2" class="datepicker" value="<?= splitdate($row['contacten_date'], "max") ?>" type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel"  >ชื่อลูกค้า :</td>
          <td>
            <input class="forbidTxt" readonly="readonly" name="contacten_othertype" id="contacten_othertype" value="<?= $row['contacten_othertype'] ?>" type="text" />
            <input type="button" onclick="openSrh()" value="เลือกลูกค้า"  class="button_st1" />
          </td>
          <td class="formLabel">ออกโดยบริษัท :</td>
          <td>
            <select name="cu_type3" id="cu_type3"  >
              <option <?php if ($row['cu_type'] == 1) { echo "selected"; } ?> value="วัน"> มิตรมงคล</option>
              <option <?php if ($row['cu_type'] == 1) { echo "selected"; } ?> value="วัน"> มงคลทวีทรัพย์</option>
            </select>
          </td>
        </tr>
        <tr height="15px;">
          <td rowspan="2" class="formLabel" style="vertical-align: top" >ที่อยู่ : </td>
          <td rowspan="2" style="vertical-align: top"><textarea readonly="readonly" class="forbidTxt" name="cu_address" id="cu_address" style="width:250px"><?= $row['cu_address'] ?></textarea></td>
          <td class="formLabel">PO.No :</td>
          <td><input readonly="readonly" class="forbidTxt" name="contacten_id2"  id="contacten_id2" type="text" value="<?= $row['contacten_id'] ?>" /></td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="formLabel" >ชื่อผู้ติดต่อ : </td>
          <td><input type="text" readonly="readonly" class="forbidTxt" name="cu_contact" style="width: 200px" id="cu_contact" value="<?= $row['cu_contact'] ?>" /></td>
          <td ><span class="formLabel">เงื่อนไขการชำระเงิน :</span></td>
          <td><input readonly="readonly" class="forbidTxt"  name="contacten_checkprice2"  id="contacten_checkprice2" value="" type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel" >เบอร์แฟกซ์ : </td>
          <td><input  readonly="readonly" class="forbidTxt" style="width: 200px"  type="text" name="cu_fax" value="<?= $row['cu_fax'] ?>" id="cu_fax"  /></td>
          <td class="formLabel">เบอร์โทร : </td>
          <td><input  readonly="readonly" class="forbidTxt" style="width: 200px" name="cu_phone" id="cu_phone" value="<?= $row['cu_phone'] ?>" type="text" /></td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td>&nbsp;</td>
          <td >&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" class="formLabelhd" >รายการ / description</td>
        </tr>

        <tr>
          <td class="formLabel" >ชื่อสินค้า :</td>
          <td><input  readonly="readonly" class="forbidTxt" name="contacten_othertype2" id="contacten_othertype2" value="<?= $row['contacten_othertype'] ?>" type="text" />
            <input type="button" onclick="openner_file_callback('select_quatation_ref_pop.php?page_re=poc');" value="เลือกสินค้า"  class="button_st1" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="formLabel" >ประเภท :</td>
          <td><input readonly="readonly" class="forbidTxt" type="text" name="product_number" value="<?= $row['product_number'] ?>" id="product_number"  /></td>
          <td class="formLabel">หมายเลข/ลักษณะ : </td>
          <td><input readonly="readonly" class="forbidTxt" type="text" name="product_number3" value="<?= $row['product_number'] ?>" id="product_number3"  /></td>
        </tr>
        <tr>
          <td class="formLabel" >แบบ/รุ่น/ขนาด : </td>
          <td><input readonly="readonly" class="forbidTxt" type="text" name="product_number2" value="<?= $row['product_number'] ?>" id="product_number2"  /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="formLabel" >สถานที่ใช้งาน :</td>
          <td><input type="text" name="product_number4" value="<?= $row['product_number'] ?>" id="product_number4"  /></td>
          <td class="formLabel">ลักษณะงาน :</td>
          <td><input type="text" name="product_number5" value="<?= $row['product_number'] ?>" id="product_number5"  /></td>
        </tr>
        <tr>
          <td class="formLabel" >มูลค่าสินค้า :</td>
          <td><input class="" style="width : 80px;" name="product_checkprice" onblur="$(this).val(formatCurrency($(this).val()))" id="product_checkprice" value="<?= number_format($row['product_checkprice'], 2) ?>" type="text" />
            บาท</td>
          <td class="formLabel">ชำระวันที่ทำสัญญา :</td>
          <td><input class="" style="width : 80px;" name="product_checkprice2"  id="product_checkprice2" value="<?= number_format($row['product_checkprice'], 2) ?>" type="text" />
            บาท</td>
        </tr>
        <tr>
          <td class="formLabel" >อุปกรณ์ :</td>
          <td><select name="cu_type2" id="cu_type2"  >
              <option <?php if ($row['cu_type'] == 1) { echo "selected"; } ?> value="วัน"> == เลือกอุปกรณ์ ==</option>

            </select></td>
          <td class="formLabel">ทะเบียนรถ :</td>
          <td><input type="text" name="product_number6" value="<?= $row['product_number'] ?>" id="product_number6"  /></td>
        </tr>
        <tr>
          <td  >&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" class="formLabelhd" >อัตราค่าเช่า/บริการ/Rate of Change</td>
        </tr>
        <tr>
          <td class="formLabel" >เวลาทำงานปกติ :</td>
          <td><input class="" style="width : 80px;" name="contacten_normaltime"  id="contacten_normaltime" value="" type="text" />
            น. ถึง 
            <input class="" style="width : 80px;" name="contacten_normaltimeto"  id="contacten_normaltimeto" value="" type="text" /></td>
          <td class="formLabel">หน่วย :</td>
          <td><select name="cu_type" id="cu_type"  >
              <option <?php if ($row['cu_type'] == 1) { echo "selected"; } ?> value="วัน">วัน</option>
              <option <?php if ($row['cu_type'] == 2) { echo "selected"; } ?> value="เดือน">เดือน</option>
              <option <?php if ($row['cu_type'] == 3) { echo "selected"; } ?> value="3">เที่ยว</option>
              <option <?php if ($row['cu_type'] == 4) { echo "selected"; } ?> value="4">ครึ่งวัน</option>
              <option <?php if ($row['cu_type'] == 5) { echo "selected"; } ?> value="4">เหมา</option>
            </select></td>
        </tr>
        <tr>
          <td class="formLabel" >ราคาต่อหน่วย :</td>
          <td><input class="" style="width : 80px;" name="product_checkprice7" onblur="$(this).val(formatCurrency($(this).val()))" id="product_checkprice7" value="" type="text" />
            บาท</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="formLabel" >เวลาทำงานล่วงเวลา :</td>
          <td><input class="" style="width : 80px;" name="contacten_overtime"  id="contacten_overtime" value="" type="text" />
            น. ถึง
            <input class="" style="width : 80px;" name="contacten_overtimeto"  id="contacten_overtimeto" value="" type="text" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="formLabel" >ชม.ละ :</td>
          <td><input  style="width : 80px;" name="product_checkprice9"  id="product_checkprice9" value="" type="text" /> บาท</td>
          <td class="formLabel">จำนวน ชม :</td>
          <td ><input  style="width : 80px;" name="product_checkprice3"  id="product_checkprice3" value="" type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel" >รวมเป็นเงิน</td>
          <td><input style="width : 80px;" readonly="readonly" class="forbidTxt" name="product_checkprice8" onblur="$(this).val(formatCurrency($(this).val()))" id="product_checkprice8" value="" type="text" /> บาท</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="formLabel" >หมายเหตุ : </td>
          <td><textarea  style="width: 200px" id="remark" name="contacten_remark" ><?= $row['contacten_remark'] ?></textarea></td>
        </tr>
        <tr height="50">
          <td><button class="submitBtn" type="submit" >บันทึก</button></td>

      </table>
      <input type="hidden" name="task" value="<?= $task ?>" />
      <input type="hidden" name="contacten_no" value="<?= $contacten_no ?>" />
    </form>

  </div>





  <div id="formsrh" >

    <span>hihihi</span>
  </div>

  <?php include "footer.php" ?>
