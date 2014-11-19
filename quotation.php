<?php
include "header.php";
include "header_php.php";

if (isset($_GET['task'])) { $task = $_GET["task"]; } else { $task = "save"; }
$quo_no = $_GET['quo_no'];

if ($task == "edit") {
  $sql = "SELECT * FROM quotation_tab WHERE quo_no = '{$quo_no}'";
  $result = mysql_query($sql);
  $row = mysql_fetch_assoc($result);

  $quo_id = $row['quo_id'];

  $customer = getCustomer($row['quo_customer']);
}
?>

<script language="javascript" type="text/javascript">
  
  

  $(document).ready(function(){
    $("#formID").validationEngine();

  });
  
</script>

<script type="text/javascript">
  $(function(){
    
    $('#formEdit').dialog({ 
      autoOpen: false,
      width : 650,
      modal: true
    }
  );
    
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
    
    $('[name="tax_status"]').change(function() {
      sumTotal();
    });
    
    $('#discount').change(function() {
      sumTotal();
    });
    
    $('#addButton ').click(function() {
      
      $('#description').val("");
      $('#amount').val("");
      $('#unit').val("วัน");
      $('#per_unit').val("");

      $( "#formEdit" ).dialog({ 
        title: 'เพิ่มข้อมูล' ,               
        buttons: { "Save": function() {
            
            var description = $('#description').val();
            var amount = $('#amount').val();
            var per_unit = $('#per_unit').val();
            var unit = $('#unit :selected').val();

            
            if(description == "" || amount == "" || per_unit == "" ){
              alert("คุณยังไม่ได้ใส่ข้อมูลสำคัญ");
            }else{
              // เพิ่มแถวให้กับรายการสินค้า
              amount = splitComma(amount);
              per_unit = splitComma(per_unit);
              var total = amount * per_unit ;

              $('#tableDetail tr:last').after('<tr><td>'+
                description+'</td><td align="center">'+
                amount+'</td><td align="center" >'+
                unit+'</td><td align="center" >'+
                formatCurrency(per_unit.toFixed( 2 ))+'</td><td class="total" align="right">'+
                formatCurrency(total.toFixed( 2 ))+'</td>'+
                '<td align="center"><img alt=""  src="images/edit.png" class="icon"  onclick="editRow(this)"/></td>'+
                '<td align="center"><img alt=""  src="images/del.png" class="icon"  onclick="delRow(this)"/></td>'+
                '</tr>');
              sumTotal();
              $(this).dialog("close"); 
            }
            
          }}
      });
      
      
      $( "#formEdit" ).dialog("open");
      
    });
  });
  
  function editRow(obj){
  
    var field_description = $(obj).parent().prev().prev().prev().prev().prev();
    var field_amount = $(obj).parent().prev().prev().prev().prev();
    var field_unit = $(obj).parent().prev().prev().prev();
    var field_per_unit = $(obj).parent().prev().prev();
    var field_total = $(obj).parent().prev();

    $('#description').val(field_description.html());
    $('#amount').val(field_amount.html());
    $('#per_unit').val(field_per_unit.html());
    $('#unit').val(field_unit.html());

    $( "#formEdit" ).dialog({ 
      title: 'แก้ไขข้อมูล' ,               
      buttons: { "Save": function() {
            
            
          if($('#description').val() == "" || $('#amount').val() == "" || $('#per_unit').val() == "" ){
            alert("คุณยังไม่ได้ใส่ข้อมูลสำคัญ");
          }else{
            var amount = splitComma($('#amount').val());
            var unit = $('#unit :selected').val();
            var per_unit = splitComma($('#per_unit').val());
            var total = amount * per_unit ;
  
            field_description.html($('#description').val());
            field_amount.html(amount);
            field_unit.html(unit);
            field_per_unit.html(per_unit.toFixed( 2 ));
            field_total.html(total.toFixed( 2 ));
            sumTotal();
            $(this).dialog("close"); 
          }
        }}
    });
    
    $( "#formEdit" ).dialog("open");
  }
  
  function delRow(obj){
    if($('#tableDetail tbody tr').size() > 1){
      if(confirm('คุณต้องการลบแถวนี้?')){
        $(obj).parent().parent().remove();
        sumTotal();
      } 
    }else{
      alert('ไม่อนุญาตให้ลบแถวที่เหลือนี้ได้');
    }
  }
  

  
  function sumTotal(){
    var subtotal = 0,vat=0;
    var discount,grandtotal,total;  
    
    $('#tableDetail tr').each(function() {
      // alert ($(this).find(".total").html());
      total = splitComma($(this).find(".total").html());
      subtotal = subtotal + total ;
    });
    //alert(subtotal);
    
    
    $('#subtotal').val(formatCurrency(subtotal.toFixed( 2 )));
    
    var after_discount = subtotal - splitComma($('#discount').val());
    $('#after_discount').val(formatCurrency(after_discount.toFixed( 2 )));
    
    if ($('[name="tax_status"]:checked').val()==0){
      vat = after_discount * 7/100;
    }
    $('#vat').val(formatCurrency(vat.toFixed( 2 )));
    
    grandtotal = after_discount + vat;
    $('#total').val(formatCurrency(grandtotal.toFixed( 2 )));
  }
  
  function submitData(){
    
    //alert('hi');
    var tbl = document.getElementById('tableDetail');
    var lastRow = tbl.rows.length;


    var i=1 ;
    var string_hid ="";
    if(lastRow >1){
      for(i=1;i<lastRow;i++){
        var row = tbl.rows[i] ;
        cell0=row.cells[0].innerHTML ;
        cell1=row.cells[1].innerHTML ;
        cell2=row.cells[2].innerHTML ;
        cell3=row.cells[3].innerHTML ;
        cell4=row.cells[4].innerHTML ;

        string_hid +=cell0+'?'+cell1+'?'+cell2+'?'+cell3+'?'+cell4+'|';
      }
    }

    $('#hid_detail').val(string_hid);
    //alert(string_hid);
    
    <?php if($task=="save"){?>
        if(confirm('แน่ใจว่าจะบันทึกในนามบริษัทที่เลือกหรือไม่ ?')==true){
          $('#formID').submit();
        }
          
        <?php }else{?>
    
    $('#formID').submit();
    <?php }?>
  }
  

    
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
    
      $('#quo_customername').val(data['cu_name']);
      $('#quo_customername').effect("highlight");
      $('#quo_customer').val(data['cu_no']);
      $('#quo_address').val(data['cu_address']);
      $('#quo_address').effect("highlight");
      $('#quo_termpayment').val(data['cu_termpayment']);
      $('#quo_termpayment').effect("highlight");
      //      $('#quo_contact').val(data['cu_contact']);
      //      $('#quo_contact').effect("highlight");
      //      $('#quo_fax').val(data['cu_fax']);
      //      $('#quo_fax').effect("highlight");
      //      $('#quo_phone').val(data['cu_phone']);
      //      $('#quo_phone').effect("highlight");

    });
  }
</script>

<div class="content">

  <div id="navigator"> 
    <a href="menu.php">Menu </a> 
    <a href="quotation_search.php"><img src="images/btween_link.png" width="10" height="7" align="absmiddle">  ค้นหาข้อมูลใบเสนอราคา </a> 
    <img src="images/btween_link.png" width="10" height="7" align="absmiddle">  ใบเสนอราคา
  </div>
  <div class="txtHead" >ใบเสนอราคา</div>

  <div class="outter" style="width: 800px;">

    <form id="formID" action="quotation_do.php" method="post" >
      <table width="758">
        <?php if ($task != "save") { ?>
          <tr>
            <td width="172" class="formLabel" >รหัสใบเสนอราคา :</td>
            <td width="251"><input readonly="readonly" class="forbidTxt" name="quo_id"  id="quo_id" type="text" value="<?= getPrefix($quo_id, $row['quo_company']) ?>" /></td>
            <td width="178"  >&nbsp;</td>
            <td width="190"  >&nbsp;</td>
          </tr>
        <?php } ?>
        <tr>
          <td class="formLabel"  >เรียน :</td>
          <td>
            <input  name="quo_nameto" class="" id="quo_nameto" value="<?= $row['quo_nameto'] ?>" type="text" />
          </td>
          <td class=""></td>
          <td> &nbsp; </td>
        </tr>
        <tr>
          <td class="formLabel"  >ชื่อลูกค้า :</td>
          <td>
            <input  readonly="readonly" name="quo_customername" class="forbidTxt validate[required]" id="quo_customername" value="<?= $customer['cu_name'] ?>" type="text" />
            <input  name="quo_customer" id="quo_customer" value="<?= $row['quo_customer'] ?>" type="hidden" />
            <button type="button" onclick="openSrh('select_customer.php');" class="button_st1" >เลือกลูกค้า</button>
          </td>
          <td class="formLabel">ออกโดย :</td>
          <td>
            <?php
            if ($task == "save") {

              $company = 'quo_company'; include "company_display.php";
            } else {
              $company = 'quo_company'; include "_company_display.php";
              ?>
              <input readonly="readonly" class="forbidTxt" name="quo_company"  id="quo_company" type="hidden" value="<?= $row['quo_company'] ?>" />
            <?php } ?>
          </td>
        </tr>
        <tr height="15px;">
          <td rowspan="2" class="formLabel" style="vertical-align: top" >ที่อยู่ : </td>
          <td rowspan="2" style="vertical-align: top">
            <textarea readonly="readonly" class="forbidTxt" name="quo_address" id="quo_address" style="width:250px"><?= $customer['cu_address'] ?></textarea>
          </td>
          <td class="formLabel" >วันที่ :</td>
          <td><input style="width: 70px;"  name="quo_date" id="quo_date" class="datepicker" value="<?php if ($task == 'save') { echo datenow(); } else { echo splitdate($row['quo_date'], "max"); } ?>"  type="text" /></td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td>&nbsp;</td>
        </tr>

        <tr>
          <td class="formLabel">เงื่อนไขการชำระเงิน :</td>
          <td><input readonly="readonly" class="forbidTxt"  name="quo_termpayment"  id="quo_termpayment" value="<?= $customer['cu_termpayment'] ?>" type="text" /></td>
          <td  class="formLabel" >ผู้เสนอราคา : </td>
          <td>
            <select name="quo_dealer" id="quo_dealer"  >
              <option <?php if ($row['quo_dealer'] == "คุณแก้วมณี  คิดดี") { echo "selected"; } ?> value="คุณแก้วมณี  คิดดี">คุณแก้วมณี  คิดดี
              </option>
              <option <?php if ($row['quo_dealer'] == "คุณเสน่ห์จิต  รวยรื่น") { echo "selected"; } ?> value="คุณเสน่ห์จิต  รวยรื่น">คุณเสน่ห์จิต  รวยรื่น
              </option>
              <option <?php if ($row['quo_dealer'] == "คุณภัสสราดา  คุ้มพลาย") { echo "selected"; } ?> value="คุณภัสสราดา  คุ้มพลาย">คุณภัสสราดา  คุ้มพลาย
              </option>
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="4" align='center' >

            <fieldset>
              <button type="button" id ="addButton" >เพิ่มรายการสินค้า</button>
              <br><br>         
              <table width="758" class="simply" id="tableDetail" >
                <tr >
                  <th width="160" align="center" >รายการ</th>
                  <th width="90" align="center" >จำนวน</th>
                  <th width="90" align="center" >หน่วย</th>
                  <th width="57" align="center" >หน่วยละ</th>
                  <th width="84" align="center" >จำนวนเงิน</th>
                  <th width="40" align="center" >แก้ไข </th>
                  <th width="24" align="center" >ลบ </th>

                </tr>
                <?php
                $sql_d = "SELECT * FROM quotation_d WHERE quo_id='{$quo_id}' ORDER BY quod_id ";
                $result_d = mysql_query($sql_d);
                while ($row_d = mysql_fetch_array($result_d)) {
                  ?>
                  <tr >
                    <td align="left"><?= $row_d['description'] ?></td>
                    <td align="center"><?= $row_d['amount']; ?></td>
                    <td align="center"><?= $row_d['unit']; ?></td>
                    <td align="center"><?= number_format($row_d['perunit'], 2) ?></td>
                    <td align="right" class="total" ><?= number_format($row_d['total'], 2) ?></td>
                    <td align="center"><img class="icon" alt="แก้ไข" src="images/edit.png"   onclick="editRow(this)"/></td>
                    <td align="center"><img class="icon" alt="ลบ" src="images/del.png"  onclick="delRow(this)"/></td>
                  </tr>
                <?php } ?>

              </table>
            </fieldset>
          </td>
        </tr>

        <tr>
          <td  >&nbsp;</td>
          <td>&nbsp;</td>
          <td >&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td>&nbsp;</td>
          <td class="formLabel">ยอดรวม :</td>
          <td><input name="subtotal" type="text" class="forbidTxt" id="subtotal" value="<?= number_format($row['quo_subtotal'], 2) ?>" size="20"  readonly="readonly"/></td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td>&nbsp;</td>
          <td class="formLabel">ส่วนลด :</td>
          <td><input name="discount" type="text" onblur="$(this).val(formatCurrency($(this).val()))" class="tb-border" id="discount" value="<?= number_format($row['quo_discount'], 2) ?>" size="20"  /></td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td>&nbsp;</td>
          <td class="formLabel">คงเหลือยอด :</td>
          <td><input name="after_discount" type="text" class="forbidTxt" id="after_discount" value="<?= number_format($row['quo_after_discount'], 2) ?>" size="20"  readonly="readonly"/></td>
        </tr>
        <tr>
          <td  >&nbsp;</td>
          <td>&nbsp;</td>
          <td class="formLabel">vat 7 % :</td>
          <td><input name="vat" type="text" class="forbidTxt" id="vat" value="<?= number_format($row['quo_vat'], 2) ?>" size="20"  readonly="readonly"/></td>
        </tr>
        <tr>
          <td  >&nbsp;</td>
          <td>&nbsp;</td>
          <td class="formLabel">มูลค่ารวม :</td>
          <td><input name="total" type="text" class="forbidTxt" id="total" value="<?= number_format($row['quo_total'], 2) ?>" size="20"  readonly="readonly"/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td >
            <input type="radio" name="tax_status"   value="0"  <?php if ($row['quo_tax_status'] == 0 || $row['quo_tax_status'] == "") { echo "checked=checked"; } ?> />
            <label>คิดภาษี</label>
            <input type="radio" name="tax_status"   value="1" <?php if ($row['quo_tax_status'] == 1) { echo "checked=checked"; } ?> />
            <label>ไม่คิดภาษี</label></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td style="vertical-align: top">หมายเหตุ : </td>
          <td colspan="3"><textarea  class="" name="quo_remark" id="quo_remark" style="height:80px;width:680px"><?= $row['quo_remark'] ?></textarea>          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr height="50">
          <td><button class="submitBtn" type="button" onclick="submitData()" >บันทึก</button></td>
        </tr>
      </table>
      <input type="hidden" name="task" value="<?= $task ?>" />
      <input type="hidden" name="quo_no" value="<?= $quo_no ?>" />
      <input name="hid_detail" type="hidden" id="hid_detail" value="" />
    </form>

  </div>

  <div id="formEdit">
    <table>
      <tr >
        <td style="vertical-align: top;" >รายการ  :</td>
        <td><textarea name="description" style="width: 500px" id="description" class="ui-widget-content ui-corner-all"></textarea></td>
      </tr >
      <tr >
        <td>จำนวน  :</td>
        <td><input type="text" name="amount"  id="amount" class="ui-widget-content ui-corner-all" /></td>
      </tr >

      <tr >
        <td>หน่วย  :</td>
        <td>
          <select name="unit" id="unit" class="ui-widget-content ui-corner-all" >
            <?php include "unitlist.php"; ?>
          </select>
        </td>
      </tr >
      <tr >
        <td>หน่วยละ  :</td>
        <td><input type="text" name="per_unit" onblur="$(this).val(formatCurrency($(this).val()))" id="per_unit" class="ui-widget-content ui-corner-all" /></td>
      </tr>

    </table>

  </div>

  <div id="formsrh"></div>

  <?php include "footer.php" ?>
