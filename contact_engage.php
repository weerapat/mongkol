<?php
include "header.php";
include "header_php.php";

if (isset($_GET['task'])) { $task = $_GET["task"]; } else { $task = "save"; }
$contacten_no = $_GET['contacten_no'];

if ($task == "edit") {
  $sql = "SELECT * FROM contacten_tab WHERE contacten_no = '{$contacten_no}'";
  $result = mysql_query($sql);
  $row = mysql_fetch_assoc($result);

  $contacten_id = $row['contacten_id'];

  $customer = getCustomer($row['contacten_customer']);
  $product = getProduct($row['contacten_productid']);
}

function getequipOption($equipmentId, $productID) {
  if (isset($productID) && $productID != "") {
    echo "<option value=''> -- เลือกอุปกรณ์ -- </option>";
    $sql = "SELECT * FROM equip_list WHERE equip_maintype ='{$productID}' ";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result)) {
      if ($equipmentId == $row['equip_id']) {
        echo "<option selected  value='{$row['equip_id']}'>{$row['equip_name']}</option>";
      } else {
        echo "<option  value='{$row['equip_id']}'>{$row['equip_name']}</option>";
      }
    }
  } else {
    echo "<option value=''> -- ไม่มีข้อมูล -- </option>";
  }
}
?>

<script language="javascript" type="text/javascript">
  
  

  $(document).ready(function(){
    $("#formID").validationEngine();
    

   
    $('#contacten_normaltime').timepicker();
    $('#contacten_normaltimeto').timepicker();
    $('#contacten_overtime').timepicker();
    $('#contacten_overtimeto').timepicker();
    
    toggleDesc();
       
    $('#contacten_type').change(function() {
      toggleDesc();
    });         
       
    function toggleDesc(){
      var type = $("#contacten_type option:selected").text();
      //$('#contacten_type').val();
      // alert(type);
      var n=type.search("รถ"); 
      var m=type.search("อื่นๆ"); 
      //alert(n);
      if(n>=0 || m>=0){
        $( ".carDesc" ).show();    
      }else{
        $( ".carDesc" ).hide(); 
      }
      
      if(m>=0){
        $( "#othertype" ).show();
      }else{
        $( "#othertype" ).hide(); 
      }
    }
    
    
      
    // initial form search
    $('#formsrh').dialog({ 
      autoOpen: false,
      width : 500,
      height : 450,
      modal: true
    });
 
    $( "#formsrh" ).dialog({
      close: function(event, ui) {  $("#formsrh").html(""); }
    });
 
 
    $("select#employee_company_name").change(function(){
      var datalist = $.ajax({    // รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist
        url: "../sale_sys/get_detail_reference.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
        data:"id="+$(this).val()+"&task=dep_list", // ส่งตัวแปร GET ชื่อ list1 ให้มีค่าเท่ากับ ค่าของ list
        async: false
      }).responseText;
      $("select#employee_section").html(datalist);
    });
  });
  
  function openSrh(page){
    //alert('hi');
    
    $("#formsrh").load(page); 
    $("#formsrh").dialog("open"); 
  }

  function loadCus(id){
    //alert(id);
    $("#formsrh").dialog("close"); 
    //$("#formsrh").html("");
    $.getJSON("select_callback.php", {
      id: id,
      task: "customer"
    },
    function(data){
    
      $('#contacten_customername').val(data['cu_name']);
      $('#contacten_customername').effect("highlight");
      $('#contacten_customer').val(data['cu_no']);
      $('#contacten_address').val(data['cu_address']);
      $('#contacten_address').effect("highlight");
      $('#contacten_contact').val(data['cu_contact']);
      $('#contacten_contact').effect("highlight");
      $('#contacten_fax').val(data['cu_fax']);
      $('#contacten_fax').effect("highlight");
      $('#contacten_phone').val(data['cu_phone']);
      $('#contacten_phone').effect("highlight");
      $('#contacten_termpayment').val(data['cu_termpayment']);
      $('#contacten_termpayment').effect("highlight");
    });
  }
  
  function loadProduct(id){
    //alert(id);
    $("#formsrh").dialog("close"); 
    $("#formsrh").html("");
    $.getJSON("select_callback.php", {
      id: id,
      task: "product"
    },
    function(data){
    
      $('#contacten_productname').val(data['product_type']);
      $('#contacten_productname').effect("highlight");
      $('#contacten_productid').val(data['product_no']);
      $('#contacten_producttype').val(data['product_type']);
      $('#contacten_producttype').effect("highlight");
      $('#contacten_productsize').val(data['product_size']);
      $('#contacten_productsize').effect("highlight");
      $('#contacten_productprice').val(data['product_price']);
      $('#contacten_productprice').effect("highlight");
      $('#contacten_number').val(data['product_number']);
      $('#contacten_number').effect("highlight");
      
      //alert(data['product_typeid']);
      // load อุปกรณ์ตาม รหัสประเภท
      // var datalist = $.ajax({    // รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist
      //   url: "select_callback.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
      //   data:"id="+data['product_typeid']+"&task=equiplist", // ส่งตัวแปร GET ชื่อ list1 ให้มีค่าเท่ากับ ค่าของ list
      //   async: false
      // }).responseText;
      // $("select#contacten_equipment1").html(datalist);
      // $("select#contacten_equipment2").html(datalist);
      // $("select#contacten_equipment3").html(datalist);
      // $("select#contacten_equipment4").html(datalist);
      // $('#unit1').hide();$('#contacten_equipment_unit1').val('');
      // $('#unit2').hide();$('#contacten_equipment_unit2').val('');
      // $('#unit3').hide();$('#contacten_equipment_unit3').val('');
      // $('#unit4').hide();$('#contacten_equipment_unit4').val('');
      
    });
  }
  
  function submitData(){
<?php if ($task == "save") { ?>
      if(confirm('แน่ใจว่าจะบันทึกในนามบริษัทที่เลือกหรือไม่ ?')==true){
        $('#formID').submit();
      }
                
<?php } else { ?>
          
      $('#formID').submit();
<?php } ?>
  }
  
  function calTotal(){
    
    var  contacten_hourprice = splitComma($('#contacten_hourprice').val());
    var  contacten_hourcount = splitComma($('#contacten_hourcount').val());
    var contacten_total;
    
    contacten_total = contacten_hourprice * contacten_hourcount;
    
    $('#contacten_total').val(formatCurrency(contacten_total.toFixed( 2 )));
    
  }

  function unitToggle(id,row){
    
    $.get("select_callback.php", {
      id: id,
      task: "get_equipmentunit"
    },
    function(data){    
      if(data == 1){$('#unit'+row).show(); }else{ $('#unit'+row).hide();$('#contacten_equipment_unit'+row).val('');}     
    });
  }

</script>


<style>
  .ui-autocomplete-loading { background: white url('images/loading.gif') right center no-repeat; }
</style>

<div class="content">

  <div id="navigator"> 
    <a href="menu.php">Menu </a> 
    <a href="contact_engage_search.php"><img src="images/btween_link.png" width="10" height="7" align="absmiddle">  ค้นหาข้อมูลใบสัญญาว่าจ้าง/เช่าและรับรองเวลาทำงาน </a> 
    <img src="images/btween_link.png" width="10" height="7" align="absmiddle">  ใบสัญญาว่าจ้าง/เช่าและรับรองเวลาทำงาน 
  </div>
  <div class="txtHead" style="width: 250px" >ใบสัญญาว่าจ้าง/เช่าและรับรองเวลาทำงาน</div>

  <div class="outter" style="width: 800px;">

    <form id="formID" action="contact_engage_do.php" method="post" >
      <table width="758">
        <?php if ($task != "save") { ?>
          <tr>
            <td width="137" class="formLabel" >รหัสสัญญา :</td>
            <td width="259"><input readonly="readonly" class="forbidTxt" name="contacten_id"  id="contacten_id" type="text" value="<?= getPrefix($contacten_id, $row["contacten_company"]); ?>" /></td>
            <td width="142" >&nbsp;</td>
            <td width="200"  >&nbsp;</td>
          </tr>
        <?php } ?>
        <tr>
          <td class="formLabel"  >ชื่อลูกค้า :</td>
          <td>
            <input  readonly="readonly" name="contacten_customername" class="forbidTxt validate[required]" id="contacten_customername" value="<?= $customer['cu_name'] ?>" type="text" />
            <input  name="contacten_customer" id="contacten_customer" value="<?= $row['contacten_customer'] ?>" type="hidden" />
            <button type="button" onclick="openSrh('select_customer.php');" class="button_st1" />เลือกลูกค้า</button> 
          </td>
          <td class="formLabel" >ออกโดย :</td>
          <td  >
            <?php
            if ($task == "save") {

              $company = 'contacten_company'; include "company_display.php";
            } else {
              $company = 'contacten_company'; include "_company_display.php";
              ?>
              <input readonly="readonly" name="contacten_company"  id="contacten_company" type="hidden" value="<?= $row['contacten_company'] ?>" />
            <?php } ?>


          </td>
        </tr>
        <tr height="15px;">
          <td rowspan="2" class="formLabel" style="vertical-align: top" >ที่อยู่ : </td>
          <td rowspan="2" style="vertical-align: top">
            <textarea readonly="readonly" class="forbidTxt" name="contacten_address" id="contacten_address" style="width:250px"><?= $customer['cu_address'] ?></textarea>
          </td>
          <td class="formLabel">วันที่ :</td>
          <td><input style="width: 70px;"  name="contacten_date" id="contacten_date" class="datepicker" value="<?php if ($task == 'save') { echo datenow(); } else { echo splitdate($row['contacten_date'], "max"); } ?>"  type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel">เงื่อนไขการชำระเงิน :</td>
          <td><input readonly="readonly" class="forbidTxt"  name="contacten_termpayment"  id="contacten_termpayment" value="<?= $customer['cu_termpayment'] ?>" type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel" >ชื่อผู้ติดต่อ : </td>
          <td><input type="text" readonly="readonly" class="forbidTxt" name="contacten_contact" style="width: 200px" id="contacten_contact" value="<?= $customer['cu_contact'] ?>" /></td>
          <td class="formLabel">PO.No :</td>
          <td><input  name="contacten_pono"  id="contacten_pono" type="text" value="<?= $row['contacten_pono'] ?>" /></td>
        </tr>
        <tr>
          <td class="formLabel" >เบอร์แฟกซ์ : </td>
          <td><input  readonly="readonly" class="forbidTxt" style="width: 200px"  type="text" name="contacten_fax" value="<?= $customer['cu_fax'] ?>" id="contacten_fax"  /></td>
          <td class="formLabel">เบอร์โทร : </td>
          <td><input  readonly="readonly" class="forbidTxt" style="width: 200px" name="contacten_phone" id="contacten_phone" value="<?= $customer['cu_phone'] ?>" type="text" /></td>
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


        <td class="formLabel" >ชื่อสินค้า/ประเภทสินค้า:</td>
        <td>
          <input  class="validate[required]" name="contacten_productname" id="contacten_productname" value="<?= $row['contacten_productname'] ?>" type="text" />
        </td>

        <td class="formLabel">สถานที่ใช้งาน :</td>
        <td><input type="text" name="contacten_workplace" value="<?= $row['contacten_workplace'] ?>" id="contacten_workplace"  /></td>
        </tr>
        <tr>
          <td class="formLabel" >แบบ/รุ่น/ขนาด : </td>
          <td><input type="text" name="contacten_productsize" value="<?= $row['contacten_productsize'] ?>" id="contacten_productsize"  /></td>
          <td class="formLabel">ลักษณะใช้งาน : </td>
          <td><input type="text" name="contacten_workappear" value="<?= $row['contacten_workappear'] ?>" id="contacten_workappear"  /></td>
        </tr>
        <tr>
          <td class="formLabel" >หมายเลข/ลักษณะ :</td>
          <td><input   type="text" name="contacten_productnumber" value="<?= $row['contacten_productnumber'] ?>" id="contacten_number"  /></td>
          <td class="formLabel">มูลค่าสินค้า :</td>
          <td><input style="width : 80px;" name="contacten_productprice" onblur="$(this).val(formatCurrency($(this).val()))" id="contacten_productprice" value="<?= number_format($row['contacten_productprice'], 2) ?>" type="text" />
            บาท</td>
        </tr>
        <tr>
          <td class="formLabel" >&nbsp;</td>
          <td>&nbsp;</td>
          <td class="formLabel">ชำระวันที่ทำสัญญา :</td>
          <td><input class="" style="width : 80px;" name="contacten_agreementdate" onblur="$(this).val(formatCurrency($(this).val()))" id="contacten_agreementdate" value="<?= number_format($row['contacten_agreementdate'], 2) ?>" type="text" />
            บาท</td>
        </tr>
        <tr>
          <td class="formLabel" >อุปกรณ์_1 :</td>
          <td>
<!--             <select onchange="unitToggle($(this).val(),1)" name="contacten_equipment1" id="contacten_equipment1"  >
              <?php getequipOption($row['contacten_equipment1'], $product['product_type']) ?>
            </select> -->

            <input type="text" name="contacten_equipment1" id="contacten_equipment1" value="<?= $row['contacten_equipment1'] ?>">
            <span <?php if (!$row['contacten_equipment_unit1']) echo "style='display: none'"; ?> id="unit1">
              <input type="text" style="width:60px;" name="contacten_equipment_unit1" class=""  id="contacten_equipment_unit1" value="<?= $row['contacten_equipment_unit1'] ?>"   />
            </span>
          </td>
          <td class="formLabel">อุปกรณ์_2 :</td>
          <td><!-- <select onchange="unitToggle($(this).val(),2)" name="contacten_equipment2" id="contacten_equipment2"  >
              <?php getequipOption($row['contacten_equipment2'], $product['product_type']) ?>
            </select> -->
            <input style="width: 120px;" type="text" name="contacten_equipment2" id="contacten_equipment2" value="<?= $row['contacten_equipment2'] ?>">
            <span <?php if (!$row['contacten_equipment_unit2']) echo "style='display: none'"; ?> id="unit2">
              <input type="text" style="width:60px;" name="contacten_equipment_unit2" class=""  id="contacten_equipment_unit2" value="<?= $row['contacten_equipment_unit2'] ?>"   />
            </span></td>
        </tr>
        <tr>
          <td class="formLabel" >อุปกรณ์_3 :</td>
          <td><!-- <select onchange="unitToggle($(this).val(),3)" name="contacten_equipment3" id="contacten_equipment3"  >
              <?php getequipOption($row['contacten_equipment3'], $product['product_type']) ?>
            </select> -->
            <input type="text" name="contacten_equipment3" id="contacten_equipment3" value="<?= $row['contacten_equipment3'] ?>">

            <span <?php if (!$row['contacten_equipment_unit3']) echo "style='display: none'"; ?> id="unit3">
              <input type="text" style="width:60px;" name="contacten_equipment_unit3" class=""  id="contacten_equipment_unit3" value="<?= $row['contacten_equipment_unit3'] ?>"   />
            </span></td>
          <td class="formLabel">อุปกรณ์_4 :</td>
          <td><!-- <select onchange="unitToggle($(this).val(),4)" name="contacten_equipment4" id="contacten_equipment4"  >
              <?php getequipOption($row['contacten_equipment4'], $product['product_type']) ?>
            </select> -->

            <input style="width: 120px;" type="text" name="contacten_equipment4" id="contacten_equipment4" value="<?= $row['contacten_equipment4'] ?>">

            <span <?php if (!$row['contacten_equipment_unit4']) echo "style='display: none'"; ?> id="unit4">
              <input type="text" style="width:60px;" name="contacten_equipment_unit4" class="" id="contacten_equipment_unit4" value="<?= $row['contacten_equipment_unit4'] ?>"   />
            </span></td>
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
          <td>
            <input class=""  name="contacten_normaltime"   value="<?= $row['contacten_normaltime'] ?>" type="text" />
          </td>
           <!--  น. ถึง 
            <input class="" style="width : 35px;" name="contacten_normaltimeto"  id="contacten_normaltimeto" value="<?= $row['contacten_normaltimeto'] ?>" type="text" /></td> -->
          <td class="formLabel">หน่วย :</td>
          <td><select name="contacten_unit" id="contacten_unit"  >
              <option <?php if ($row['contacten_unit'] == "วันละ") { echo "selected"; } ?> value="วันละ">วันละ</option>
              <option <?php if ($row['contacten_unit'] == "เดือนละ") { echo "selected"; } ?> value="เดือนละ">เดือนละ</option>
              <option <?php if ($row['contacten_unit'] == "เที่ยว") { echo "selected"; } ?> value="เที่ยว">เที่ยว</option>
              <option <?php if ($row['contacten_unit'] == "ครึ่งวัน") { echo "selected"; } ?> value="ครึ่งวัน">ครึ่งวัน</option>
              <option <?php if ($row['contacten_unit'] == "เหมา") { echo "selected"; } ?> value="เหมา">เหมา</option>
            </select></td>
        </tr>
        <tr>
          <td class="formLabel" >ราคาต่อหน่วย :</td>
          <td><input class="" style="width : 80px;" name="contacten_priceperunit" onblur="$(this).val(formatCurrency($(this).val()))" id="contacten_priceperunit" value="<?= number_format($row['contacten_priceperunit'], 2) ?>" type="text" />
            บาท</td>
          <td class="formLabel">OT ชม.ละ :</td>
          <td><input  style="width : 80px;" name="contacten_hourprice" onblur="$(this).val(formatCurrency($(this).val()));calTotal();" id="contacten_hourprice" value="<?= number_format($row['contacten_hourprice'], 2) ?>" type="text" />            บาท</td>
        </tr>
        <tr>
          <td class="formLabel" >ขนส่งจาก :</td>
          <td><input type="text" name="contacten_transport" value="<?= $row['contacten_transport'] ?>" id="contacten_transport"  /></td>
          <td class="formLabel">ค่าขนส่งไปกลับ :</td>
          <td ><input type="text" name="contacten_transportprice" onblur="$(this).val(formatCurrency($(this).val()))" value="<?= number_format($row['contacten_transportprice'], 2) ?>" id="contacten_transportprice"  /></td>
        </tr>
        <tr>
          <td class="formLabel" >ทะเบียนรถ :</td>
          <td><input type="text" name="contacten_carlicense" value="<?= $row['contacten_carlicense'] ?>" id="contacten_carlicense"  /></td>
          <td class="formLabel">ฝาน้ำมันหาย :</td>
          <td ><input type="text" style="width:60px;" name="contacten_oilloss" value="<?= $row['contacten_oilloss'] ?>" id="contacten_oilloss"  /></td>
        </tr>
        <tr>

          <td class="formLabel"></td>
          <td ></td>
          <td class="formLabel" >กุญแจหาย :</td>
          <td><input type="text" style="width:60px;" name="contacten_keyloss" value="<?= $row['contacten_keyloss'] ?>" id="contacten_keyloss"  /></td>
        </tr>

        <tr>
          <td class="formLabel" >หมายเหตุ : </td>
          <td colspan="3"><textarea  style="width: 400px;height: 35px" id="contacten_remark" name="contacten_remark" ><?= $row['contacten_remark'] ?></textarea></td>
        </tr>

        <tr>
          <td class="formLabel" >สถานะการจ่ายเงิน :</td>
          <td colspan="3" >
            <input type="radio" name="pay_status"   value="0"  <?php if ($row['pay_status'] == 0 || $row['pay_status'] == "") { echo "checked=checked"; } ?> />
            <label>ยังไม่จ่ายเงิน</label>
            <input type="radio" name="pay_status"   value="1" <?php if ($row['pay_status'] == 1) { echo "checked=checked"; } ?> />
            <label>จ่ายเงินแล้ว</label></td>
        </tr>
        <tr height="50">
          <td><button class="submitBtn" type="submit" onclick="submitData()" >บันทึก</button></td>
        </tr>
      </table>
      <input type="hidden" name="task" value="<?= $task ?>" />
      <input type="hidden" name="contacten_no" value="<?= $contacten_no ?>" />
    </form>

  </div>


  <div id="formsrh"></div>

  <?php include "footer.php" ?>
