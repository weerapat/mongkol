<?php
include "header.php";
include "header_php.php";

if (isset($_GET['task'])) { $task = $_GET["task"]; } else { $task = "save"; }
$cu_no = $_GET['cu_no'];


if ($task == "edit") {
  $row = getCustomer($cu_no);
}
?>

<script language="javascript" type="text/javascript">
  $(document).ready(function(){
    
    $("#formID").validationEngine();
 
  
<?php if ($task == save) { ?>
      $('#cu_name').blur(function() {
        $.get("select_callback.php", {
          id: $('#cu_name').val(),
          task: "checkCustomer"
        },
        function(data){
        
          // ข้อมูลซ้ำ
          if(data >0){
            alert('มีชื่อนี้ในระบบแล้วกรุณากรอกใหม่');
            $('#cu_name').val("");
            $('#cu_name').focus();
          }
            
        });
      });
<?php } ?>
  });
  
</script>


<div class="content">

  <div id="navigator"> 
    <a href="menu.php">Menu </a> 
    <a href="customer_search.php"><img src="images/btween_link.png" width="10" height="7" align="absmiddle">  ค้นหาข้อมูลลูกค้า  </a> 
    <img src="images/btween_link.png" width="10" height="7" align="absmiddle">  ข้อมูลลูกค้า 
  </div>
  <div class="txtHead" style="width: 100px" >ข้อมูลลูกค้า</div>

  <div class="outter" style="width: 500px">
    <form id="formID" action="customer_do.php" method="post" >
      <table>
        <?php if ($task == "edit") { ?>
          <tr>
            <td class="formLabel" >รหัสลูกค้า :</td>
            <td><input class="validate[required] text-input" name="cu_id" readonly="readonly" id="cu_id" type="text" value="<?= $row['cu_id'] ?>" /></td>
          </tr>
        <?php } ?>
        <tr>
          <td class="formLabel" >ชื่อลูกค้า :</td>
          <td><input class="validate[required] text-input" style="width: 320px" name="cu_name" id="cu_name" value="<?= $row['cu_name'] ?>" type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel" >ประเภทลูกค้า :</td>
          <td>
            <select name="cu_type" id="cu_type"  >
              <option <?php if ($row['cu_type'] == 1) { echo "selected"; } ?> value="1">บริษัท</option>
              <option <?php if ($row['cu_type'] == 2) { echo "selected"; } ?> value="2">ห้างหุ้นส่วนจำกัด</option>
              <option <?php if ($row['cu_type'] == 3) { echo "selected"; } ?> value="3">บุคคลธรรมดา</option>
              <option <?php if ($row['cu_type'] == 4) { echo "selected"; } ?> value="4">ร้าน</option>
              <option <?php if ($row['cu_type'] == 5) { echo "selected"; } ?> value="5">คณะบุคคล</option>
            </select>

            <?php if ($task == "save") { ?>
              <select name="runId"  >
                <option  value="1">รันรหัสฐานข้อมูล</option>
                <option  value="2">ลูกค้าจร (ใส่รหัส 0000)</option>

              </select>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td class="formLabel" style="vertical-align: top">ที่อยู่ : </td>
          <td><textarea name="cu_address" id="cu_address" style="width:320px"><?= $row['cu_address'] ?></textarea></td>
        </tr>
        <tr>
          <td class="formLabel" >เบอร์โทร : </td>
          <td><input class="" style="width: 320px" name="cu_phone" id="cu_phone" value="<?= $row['cu_phone'] ?>" type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel" >เบอร์แฟกซ์ : </td>
          <td><input class="" style="width: 320px"  type="text" name="cu_fax" value="<?= $row['cu_fax'] ?>" id="cu_fax"  /></td>
        </tr>
        <tr>
          <td class="formLabel" >ชื่อผู้ติดต่อ :  </td>
          <td><input type="text" name="cu_contact" style="width: 200px" id="cu_contact" value="<?= $row['cu_contact'] ?>" /></td>
        </tr>
        <tr>
          <td class="formLabel" >เบอร์ผู้ติดต่อหน้างาน : </td>
          <td><input type="text" name="cu_contacttel" style="width: 320px" id="cu_contacttel" value="<?= $row['cu_contacttel'] ?>" /></td>
        </tr>
        <tr>
          <td class="formLabel" >Email : </td>
          <td><input type="text" name="cu_email" style="width: 220px" id="cu_email" value="<?= $row['cu_email'] ?>" /></td>
        </tr>
        <tr>
          <td class="formLabel" >เงื่อนไขการชำระเงิน : </td>
          <td>
            <select name="cu_termpayment" id="cu_termpayment"  >
              <option <?php if ($row['cu_termpayment'] == "เงินสด") { echo "selected"; } ?> value="เงินสด">เงินสด</option>
              <option <?php if ($row['cu_termpayment'] == "เครดิต 7 วัน") { echo "selected"; } ?> value="เครดิต 7 วัน">เครดิต 7 วัน</option>
              <option <?php if ($row['cu_termpayment'] == "เครดิต 15 วัน") { echo "selected"; } ?> value="เครดิต 15 วัน">เครดิต 15 วัน</option>
              <option <?php if ($row['cu_termpayment'] == "เครดิต 30 วัน") { echo "selected"; } ?> value="เครดิต 30 วัน">เครดิต 30 วัน</option>
            </select>
        </tr>
        <tr>
          <td class="formLabel" >เลขที่ผู้เสียภาษี :</td>
          <td><input  name="cu_taxid" id="cu_taxid" value="<?= $row['cu_taxid'] ?>" type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel" >หมายเหตุ : </td>
          <td colspan="2"><textarea  style="width: 320px" id="cu_remark" name="cu_remark" ><?= $row['cu_remark'] ?></textarea></td>
        </tr>
        <tr height="50">
          <td><button class="submitBtn" type="submit" >บันทึก</button></td>
        </tr>
      </table>
      <input type="hidden" name="task" value="<?= $task ?>" />
      <input type="hidden" name="cu_no" value="<?= $cu_no ?>" />
    </form>

  </div>


  <?php include "footer.php" ?>
