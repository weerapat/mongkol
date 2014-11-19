<?php
include "header.php";
include "header_php.php";

if (isset($_GET['task'])) { $task = $_GET["task"]; } else { $task = "save"; }
$rec_no = $_GET['rec_no'];


if ($task == "edit") {
  $sql = "SELECT * FROM receipt_tab WHERE rec_no = '{$rec_no}'";
  $result = mysql_query($sql);
  $row = mysql_fetch_assoc($result);

  $rec_id = $row['rec_id'];

  $customer = getCustomer($row['rec_customer']);
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
      width : 350,
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
    
      <?php if($task=="save") {?>
        if(confirm('แน่ใจว่าจะบันทึกในนามบริษัทที่เลือกหรือไม่ ?')==true){
          $('#formID').submit();
        }
          
        <?php }else{ ?>
    
    $('#formID').submit();
    <?php } ?>
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
    
      $('#rec_customername').val(data['cu_name']);
      $('#rec_customername').effect("highlight");
      $('#rec_customer').val(data['cu_no']);
      $('#rec_address').val(data['cu_address']);
      $('#rec_address').effect("highlight");
    });
  }
  
  function checkDisable(checkid){

    if(checkid == "cash_payment"){
      if($('#cash_payment').is(':checked')){
        $('#cash_amount').removeAttr('disabled');
      }
      else{
        $('#cash_amount').val('');
        $('#cash_amount').attr('disabled', true);
      }
    }

    else if(checkid == "cheque"){
      if($('#cheque').is(':checked')){
        $('#cheque_amount').removeAttr('disabled');
        $('#cheque_no').removeAttr('disabled');
        $('#cheque_bank').removeAttr('disabled');
        $('#cheque_branch').removeAttr('disabled');
        $('#cheque_date').removeAttr('disabled');
      }
      else{
        $('#cheque_amount').val('');
        $('#cheque_amount').attr('disabled', true);
        $('#cheque_no').val('');
        $('#cheque_no').attr('disabled', true);
        $('#cheque_bank').val('');
        $('#cheque_bank').attr('disabled', true);
        $('#cheque_branch').val('');
        $('#cheque_branch').attr('disabled', true);
        $('#cheque_date').val('');
        $('#cheque_date').attr('disabled', true);
      }
    }
  }
</script>

<div class="content">

  <div id="navigator"> 
    <a href="menu.php">Menu </a> 
    <a href="receipt_search.php"><img src="images/btween_link.png" width="10" height="7" align="absmiddle">  ค้นหาข้อมูลใบเสร็จรับเงิน/ใบกำกับภาษี </a> 
    <img src="images/btween_link.png" width="10" height="7" align="absmiddle">  ใบเสร็จรับเงิน/ใบกำกับภาษี
  </div>
  <div class="txtHead" >ใบเสร็จรับเงิน/ใบกำกับภาษี</div>

  <div class="outter" >

    <form id="formID" action="receipt_do.php" method="post" >
      <table width="800">
        <? if ($task != "save") { ?>
          <tr>
            <td width="270" class="formLabel" >รหัสใบเสร็จรับเงิน :</td>
            <td width="340"><input readonly="readonly" class="forbidTxt" name="rec_id"  id="rec_id" type="text" value="<?= getPrefix($rec_id, $row["rec_company"]); ?>" /></td>
            <td width="119"  >&nbsp;</td>
            <td width="160"  >&nbsp;</td>
          </tr>
        <? } ?>
        <tr>
          <td class="formLabel"  >ชื่อลูกค้า :</td>
          <td>
            <input  readonly="readonly" name="rec_customername" class="forbidTxt validate[required]" id="rec_customername" value="<?= $customer['cu_name'] ?>" type="text" />
            <input  name="rec_customer" id="rec_customer" value="<?= $row['rec_customer'] ?>" type="hidden" />
            <button type="button" onclick="openSrh('select_customer.php');" class="button_st1" >เลือกลูกค้า</button>
          </td>
          <td class="formLabel" >ออกโดย :</td>
          <td  >
            <?php
            if ($task == "save") {

              $company = 'rec_company'; include "company_display.php";
            } else {
              $company = 'rec_company'; include "_company_display.php";
              ?>
              <input readonly="readonly" name="rec_company"  id="rec_company" type="hidden" value="<?= $row['rec_company'] ?>" />
            <?php } ?>
          </td>
        </tr>
        <tr height="15px;">
          <td rowspan="2" class="formLabel" style="vertical-align: top" >ที่อยู่ : </td>
          <td rowspan="2" style="vertical-align: top">
            <textarea readonly="readonly" class="forbidTxt" name="rec_address" id="rec_address" style="width:250px"><?= $customer['cu_address'] ?></textarea>
          </td>
          <td class="formLabel">วันที่ :</td>
          <td><input style="width: 80px;"  name="rec_date" id="rec_date" class="datepicker" value="<?php if ($task == 'save') { echo datenow(); } else { echo splitdate($row['rec_date'], "max"); } ?>"  type="text" /></td>
        </tr>
                <tr>
          <td   >&nbsp;</td>
          <td>&nbsp;</td>
          <td  ></td>
          <td  ></td>
        </tr>
        <tr>
          <td class="formLabel" >ผู้รับเงิน :</td>
          <td><select name="rec_receiver" id="rec_receiver"  >
            <option <?php if ($row['rec_receiver'] == "คุณแก้วมณี  คิดดี") { echo "selected"; } ?> value="คุณแก้วมณี  คิดดี">คุณแก้วมณี  คิดดี </option>
            <option <?php if ($row['rec_receiver'] == "คุณเสน่ห์จิต  รวยรื่น") { echo "selected"; } ?> value="คุณเสน่ห์จิต  รวยรื่น">คุณเสน่ห์จิต  รวยรื่น </option>
            <option <?php if ($row['rec_receiver'] == "คุณภัสสราดา  คุ้มพลาย") { echo "selected"; } ?> value="คุณภัสสราดา  คุ้มพลาย">คุณภัสสราดา  คุ้มพลาย </option>
          </select></td>
        </tr>

        <tr>
          <td >&nbsp;</td>
          <td>&nbsp;</td>
          <td >&nbsp;</td>
          <td>&nbsp;</td>
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
                $sql_d = "SELECT * FROM receipt_d WHERE rec_id='{$rec_id}' ORDER BY recd_id ";
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
          <td><input name="subtotal" type="text" class="forbidTxt" id="subtotal" value="<?= number_format($row['rec_subtotal'], 2) ?>" size="20"  readonly="readonly"/></td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td>&nbsp;</td>
          <td class="formLabel">ส่วนลด :</td>
          <td><input name="discount" type="text" onblur="$(this).val(formatCurrency($(this).val()))" class="tb-border" id="discount" value="<?= number_format($row['rec_discount'], 2) ?>" size="20"  /></td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td>&nbsp;</td>
          <td class="formLabel">คงเหลือยอด :</td>
          <td><input name="after_discount" type="text" class="forbidTxt" id="after_discount" value="<?= number_format($row['rec_after_discount'], 2) ?>" size="20"  readonly="readonly"/></td>
        </tr>
        <tr>
          <td  >&nbsp;</td>
          <td>&nbsp;</td>
          <td class="formLabel">vat 7 % :</td>
          <td><input name="vat" type="text" class="forbidTxt" id="vat" value="<?= number_format($row['rec_vat'], 2) ?>" size="20"  readonly="readonly"/></td>
        </tr>
        <tr>
          <td  >&nbsp;</td>
          <td>&nbsp;</td>
          <td class="formLabel">มูลค่ารวม :</td>
          <td><input name="total" type="text" class="forbidTxt" id="total" value="<?= number_format($row['rec_total'], 2) ?>" size="20"  readonly="readonly"/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2" >
            <input type="radio" name="tax_status"   value="0"  <?php if ($row['rec_tax_status'] == 0 || $row['rec_tax_status'] == "") { echo "checked=checked"; } ?> />
            <label>คิดภาษี</label>
            <input type="radio" name="tax_status"   value="1" <?php if ($row['rec_tax_status'] == 1) { echo "checked=checked"; } ?> />
            <label>ไม่คิดภาษี</label></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="3"><table width="640">
              <tr>
                <td width="159">&nbsp;</td>
                <td width="133">&nbsp;</td>
                <td width="184">&nbsp;</td>
                <td width="144">&nbsp;</td>
              </tr>
              <tr  >
                <td>&nbsp;</td>
                <td><input name="cash_payment" type="checkbox" id="cash_payment" value="Y" onclick="checkDisable('cash_payment')" <?php if ($row['cash_payment'] == 'Y') { echo 'checked="checked"'; } ?> />
                  <label for ="cash_payment">ชำระด้วยเงินสด</label></td>
                <td class="formLabel" >จำนวนเงินที่ชำระ :</td>
                <td id ="cash_pay" >
                  <input name="cash_amount" type="text" onblur="$(this).val(formatCurrency($(this).val()))" class="tb-border" id="cash_amount" <?php if ($row['cash_payment'] == 'Y') { echo "value='" . number_format($row['cash_amount'], 2) . "'"; } else { echo "disabled=disabled"; } ?> size="20"  />
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>
                  <input name="cheque" type="checkbox" id="cheque" value="Y" onclick="checkDisable('cheque');" <?php if ($row['cheque'] == 'Y') { echo 'checked="checked"'; } ?> />
                  <label for ="cheque">ชำระด้วยเช็ค</label>
                </td>
                <td align="left" class="formLabel">จำนวนเงินที่จ่ายด้วยเช็ค :</td>
                <td align="left" >
                  <input name="cheque_amount" type="text" onblur="$(this).val(formatCurrency($(this).val()))" class="tb-border" id="cheque_amount"  <?php if ($row['cheque'] == 'Y') { echo "value='" . number_format($row['cheque_amount'], 2) . "'"; } else { echo "disabled=disabled"; } ?> size="20"  />
                </td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
                <td align="left" class="formLabel" >เลขที่เช็ค :</td>
                <td align="left" ><input name="cheque_no" type="text"  class="tb-border" id="cheque_no" <?php if ($row['cheque'] == 'Y') { echo "value='{$row['cheque_no']}'"; } else { echo "disabled=disabled"; } ?> size="20"  /></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
                <td align="left" class="formLabel">ธนาคารเจ้าของเช็ค :</td>
                <td align="left"><input name="cheque_bank" type="text"  class="tb-border" id="cheque_bank" <?php if ($row['cheque'] == 'Y') { echo "value='{$row['cheque_bank']}'"; } else { echo "disabled=disabled"; } ?> size="20"  /></td>
              </tr>
              <tr>
                  <td colspan="2">&nbsp;</td>
                <td align="left" class="formLabel">สาขา :</td>
                <td align="left"><input name="cheque_branch" type="text"  class="tb-border" id="cheque_branch" <?php if ($row['cheque'] == 'Y') { echo "value='{$row['cheque_branch']}'"; } else { echo "disabled=disabled"; } ?> size="20"  /></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
                <td align="left" class="formLabel" >วันที่ออกเช็ค :</td>
                <td align="left" ><input style="width: 70px;"  name="cheque_date" id="cheque_date" class="datepicker" <?php if ($row['cheque'] == 'Y') { echo "value=" . splitdate($row['cheque_date'], "max"); } else { echo "disabled=disabled"; } ?>   type="text" /></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr height="50">
          <td><button class="submitBtn" type="button" onclick="submitData()" >บันทึก</button></td>
        </tr>
      </table>
      <input type="hidden" name="task" value="<?= $task ?>" />
      <input type="hidden" name="rec_no" value="<?= $rec_no ?>" />
      <input name="hid_detail" type="hidden" id="hid_detail" value="" />
    </form>

  </div>

  <div id="formEdit">
    <table>
      <tr >
        <td>รายการ  :</td>
        <td><input type="text" name="description" id="description" class="ui-widget-content ui-corner-all" /></td>
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
