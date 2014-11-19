<?php
include "header.php";
include "header_php.php";

if (isset($_GET['task'])) { $task = $_GET["task"]; } else { $task = "save"; }
$product_no = $_GET['product_no'];


if ($task == "edit") {
  $row = getProduct($product_no);
}
?>

<script language="javascript" type="text/javascript">
  $(document).ready(function(){
    $("#formID").validationEngine();
   
    toggleDesc();
       
    $('#product_type').change(function() {
      toggleDesc();
    });         
       
    function toggleDesc(){
      var type = $("#product_type option:selected").text();
      //$('#product_type').val();
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
  });
</script>




<div class="content">

  <div id="navigator"> 
    <a href="menu.php">Menu </a> 
    <a href="product_search.php"><img src="images/btween_link.png" width="10" height="7" align="absmiddle">  ค้นหาข้อมูลสินค้า </a> 
    <img src="images/btween_link.png" width="10" height="7" align="absmiddle">  ข้อมูลสินค้า 
  </div>
  <div class="txtHead" style="width: 100px" >ข้อมูลสินค้า</div>

  <div class="outter" style="width: 620px">

    <?php if ($task == "edit") { ?>
      <div style="position: relative;top:10px;left:480px;"><button id="openNote" type="button" >รายละเอียดเพิ่มเติม</button></div>
    <?php } ?>
    <form id="formID" action="product_do.php" method="post" >
      <table width="533">

        <tr>
          <td width="145" class="formLabel" >รหัสสินค้า :</td>
          <td colspan="2"><input class="validate[required] text-input" name="product_id"  id="product_id" type="text" value="<?= $row['product_id'] ?>" /></td>
        </tr>
        <tr>
          <td class="formLabel" >ชื่อ/ประเภทสินค้า :</td>
          <td colspan="3">
            <?php
            $sql = "SELECT * FROM product_type";
            $resource = mysql_query($sql);
            ?>
            <select name="product_type" id="product_type"  >
              <option>== โปรดเลือก ==</option>
              <?php while ($type = mysql_fetch_assoc($resource)) { ?>
                <option <?php if ($row['product_type'] == $type['producttype_id']) { echo "selected"; } ?> value="<?= $type['producttype_id'] ?>"><?= $type['producttype_name'] ?></option>
              <?php } ?>
            </select>

            <span id="othertype" >
              <input  name="product_othertype" id="product_othertype" value="<?= $row['product_othertype'] ?>" type="text" />
            </span>

          </td>
        </tr>
        <tr>
          <td class="formLabel" >แบบ/รุ่น/ขนาด : </td>
          <td colspan="2"><input class="validate[required]" name="product_size" id="product_size" value="<?= $row['product_size'] ?>" type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel" >หมายเลข/ลักษณะ : </td>
          <td colspan="2"><input type="text" name="product_number" value="<?= $row['product_number'] ?>" id="product_number"  /></td>
        </tr>
        <tr class="carDesc">
          <td class="formLabel" >ภาษี วันที่หมดอายุ : </td>
          <td width="187"><input class="datepicker" name="product_taxdate" style="width : 70px;" id="product_taxdate" value="<?= splitdate($row['product_taxdate'], "max") ?>" type="text" /></td>
          <td class="formLabel" width="59">ราคา :</td>
          <td width="122"><input class="" name="product_taxprice" style="width : 80px;" onblur="$(this).val(formatCurrency($(this).val()))" id="product_taxprice" value="<?= number_format($row['product_taxprice'], 2) ?>" type="text" /> บาท</td>
        </tr>
        <tr class="carDesc" >
          <td class="formLabel" >พรบ วันที่หมดอายุ :</td>
          <td><input class="datepicker" name="product_prbdate" style="width : 70px;" id="product_prbdate" value="<?= splitdate($row['product_prbdate'], "max") ?>" type="text" /></td>
          <td class="formLabel">ราคา :</td>
          <td><input class="" name="product_prbprice" style="width : 80px;" onblur="$(this).val(formatCurrency($(this).val()))" id="product_prbprice" value="<?= number_format($row['product_prbprice'], 2) ?>" type="text" /> บาท</td>
        </tr>
        <tr class="carDesc" >
          <td class="formLabel" >ประกัน วันที่หมดอายุ :</td>
          <td><input class="datepicker" name="product_warrentydate" style="width : 70px;" id="product_warrentydate" value="<?= splitdate($row['product_warrentydate'], "max") ?>" type="text" /></td>
          <td class="formLabel">ราคา :</td>
          <td><input class="" name="product_warrentyprice" style="width : 80px;" onblur="$(this).val(formatCurrency($(this).val()))" id="product_warrentyprice" value="<?= number_format($row['product_warrentyprice'], 2) ?>" type="text" /> บาท</td>
        </tr>
        <tr class="carDesc" >
          <td class="formLabel" >ตรวจสภาพ ราคา : </td>
          <td colspan="2"><input class="" style="width : 80px;" name="product_checkprice" onblur="$(this).val(formatCurrency($(this).val()))" id="product_checkprice" value="<?= number_format($row['product_checkprice'], 2) ?>" type="text" /> บาท</td>
        </tr>
        <tr>
          <td class="formLabel" >ราคาต้นทุน :</td>
          <td colspan="2"><input class="" style="width : 80px;" name="product_cost" onblur="$(this).val(formatCurrency($(this).val()))" id="product_cost" value="<?= number_format($row['product_cost'], 2) ?>" type="text" /> บาท</td>
        </tr>
        <tr>
          <td class="formLabel" >ราคาขาย :</td>
          <td colspan="2"><input style="width : 80px;" name="product_price" onblur="$(this).val(formatCurrency($(this).val()))" id="product_price" value="<?= number_format($row['product_price'], 2) ?>" type="text" /> บาท</td>
        </tr>
        <tr>
          <td class="formLabel" >วันที่ซื้อ :</td>
          <td colspan="2"><input style="width: 70px;"  name="product_date" id="product_date" class="datepicker" value="<?= splitdate($row['product_date'], "max") ?>" type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel" >ที่มา :</td>
          <td colspan="2"><input  name="product_from" style="width: 180px;"  id="product_from" value="<?= $row['product_from'] ?>" type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel" >ประเภทเครื่อง :</td>
          <td colspan="2"><input  name="product_typetool" id="product_typetool" value="<?= $row['product_typetool'] ?>" type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel" >ประเภทไดร์ :</td>
          <td colspan="2"><input  name="product_typedai" id="product_typedai" value="<?= $row['product_typedai'] ?>" type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel" >กรองเครื่อง :</td>
          <td colspan="2"><input name="product_braiddai" id="product_braiddai" value="<?= $row['product_braiddai'] ?>" type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel" >กรองโซล่า :</td>
          <td colspan="2"><input  name="product_braidsola" id="product_braidsola" value="<?= $row['product_braidsola'] ?>" type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel" >กรองอากาศ :</td>
          <td colspan="2"><input  name="product_braidair" id="product_braidair" value="<?= $row['product_braidair'] ?>" type="text" /></td>
        </tr>
        <tr>
          <td class="formLabel" >สถานะ : </td>
          <td colspan="2">
            <input type="radio" <?php if ($row['product_status'] == 0) { echo "checked"; } ?> name="product_status" id="product_status1" value="0" />
            <label for="product_status1">พร้อมใช้งาน</label>
            <input type="radio" <?php if ($row['product_status'] == 1) { echo "checked"; } ?> name="product_status" id="product_status2" value="1" />
            <label for="product_status2">ไม่พร้อมใช้งาน</label>
          </td>
        </tr>
        <tr>
          <td class="formLabel" >หมายเหตุ : </td>
          <td colspan="2"><textarea  style="width: 200px" id="remark" name="product_remark" ><?= $row['product_remark'] ?></textarea></td>
        </tr>
        <tr height="50">
          <td><button class="submitBtn" type="submit" >บันทึก</button></td>

      </table>
      <input type="hidden" name="task" value="<?= $task ?>" />
      <input type="hidden" name="product_no" value="<?= $product_no ?>" />
    </form>

  </div>




  <script type="text/javascript">
    $(function(){
    
      $('#noteEdit').dialog({ 
        autoOpen: false,
        width : 450,
        modal: true
      }
    );
    
      $('#noteList').dialog({ 
        autoOpen: false,
        width : 660,
        draggable: false,
        minHeight : 400,
        modal: true
      }
    
    );
      
      $( "#notedate" ).datepicker({ dateFormat: 'dd-mm-y' });
    
      $('#openNote').click(function() {
        $( "#noteList" ).dialog("open");
      });
    
 
      $('#addButton ').click(function() {
      
        $('#notemsg').val("");
        $('#notedate').val("");
        $('#note_hourmeter').val("");
        $('#note_actionby').val("");

        $( "#noteEdit" ).dialog({ 
          title: 'เพิ่มข้อมูล' ,               
          buttons: { "บันทึก": function() {
            
              var notemsg = $('#notemsg').val();
              var notedate = $('#notedate').val();
              var note_hourmeter = $('#note_hourmeter').val();
              var note_actionby = $('#note_actionby').val();
              var product_no = <?= $product_no ?>;

            
              if(notemsg == "" || notedate == "" ){
                alert("คุณยังใส่ข้อมูลไม่ครบ");
              }else{
                $.post("productnote_ajax.php", { 
                  task:"save" ,
                  notemsg: notemsg,
                  notedate: notedate,
                  note_hourmeter: note_hourmeter,
                  note_actionby: note_actionby,
                  product_no : product_no
                },
                function(data){
                  //reload table
                  if(data != "success"){
                    alert(data);
                  }else{
                    // alert(data);
                    $('#divTable').load('product.php?task=edit&product_no=<?= $product_no ?> #table', function() {

                      $('#table tr:last').effect( 'highlight','slow');
                    });
                  }
                });
  
                $(this).dialog("close"); 
              }
            }}
        });
        $( "#noteEdit" ).dialog("open");
      
      });
    });
  
    function edit(id){
  
      $('#notemsg').val($('#notemsg'+id).text());
      $('#notedate').val($('#notedate'+id).text());
      $('#note_hourmeter').val($('#note_hourmeter'+id).text());
      $('#note_actionby').val($('#note_actionby'+id).text());

      $( "#noteEdit" ).dialog({ 
        title: 'แก้ไขข้อมูล' ,               
        buttons: { "บันทึก": function() {
            
            var notemsg = $('#notemsg').val();
            var notedate = $('#notedate').val();
            var note_hourmeter = $('#note_hourmeter').val();
            var note_actionby = $('#note_actionby').val();
            
            
            if(notemsg == "" || notedate == "" ){
              alert("คุณยังใส่ข้อมูลไม่ครบ");
            }else{
              $.post("productnote_ajax.php", { 
                task:"edit" ,
                productnote_id: id,
                notemsg: notemsg,
                note_hourmeter: note_hourmeter,
                note_actionby: note_actionby,
                notedate: notedate
              },
              function(data){
              
                if(data != "success"){
                  alert(data);
                }else{
                  //reload table
                  //alert(data);
                  $('#divTable').load('product.php?task=edit&product_no=<?= $product_no ?> #table', function() {
                  
                    // highlight แถวที่เพิ่ม
                    $('#row'+id).effect( 'highlight','slow');
                  });
                }
              });
  
              $(this).dialog("close"); 
            }
          }}
      });
      $( "#noteEdit" ).dialog("open");
    }
  
    function del(id){
      var r=confirm("ยืนยันว่าต้องการลบข้อมูล!");
      if(r==true)
        $.post("productnote_ajax.php", { 
          task:"delete" ,
          productnote_id: id
        },
      function(data){
        $('#row'+id).effect( 'highlight','slow');
        $('#divTable').load('product.php?task=edit&product_no=<?= $product_no ?> #table');
                
      });
    }
  </script>


  <?php if ($task == "edit") { ?>

    <div id="noteList" title="Note message" >
      <div style="text-align: right;margin-bottom: 20px;">
        <input type="button" value="เพิ่มข้อมูล" id="addButton"  />
      </div>

      <div id="divTable">
        <table id="table" class="simply">
          <tr class="ui-widget-header ">

            <th style="width: 30px">No</th>
            <th style="width: 100px">วันที่ / Date</th>
            <th style="width: 380px">รายการ / Description</th>
            <th style="width: 200px">เลขไมล์สะสม / Hour meter</th>
            <th style="width: 200px">ผู้ดำเนินการ / Action By</th>
            <?php if ($_SESSION['level'] == "admin") { ?>
              <th style="width: 30px">Edit</th>
              <th style="width: 30px">Del</th>
            <?php } ?>
          </tr>

          <?php
          //$building_list = get_buildinglist($searchw, $site_id);

          $notesql = "SELECT * FROM product_note WHERE product_no = '{$product_no}'";
          //echo $notesql;
          $resource = mysql_query($notesql);
          while ($row = mysql_fetch_assoc($resource)) {
            $notelist[] = $row;
          }

          if ($notelist) {
            $i = 0;
            while ($row = $notelist[$i]) {
              ?>

              <tr id="row<?= $notelist[$i]['productnote_id'] ?>" <?php if (($i + 1) % 2 == 0) { echo "style='background-color: #f4f9f6'"; } ?> >

                <td  align="center" ><?= $i + 1 ?>.</td>
                <td id="notedate<?= $notelist[$i]['productnote_id'] ?>" ><?= splitdate($notelist[$i]['notedate'], "avg") ?></td>
                <td id="notemsg<?= $notelist[$i]['productnote_id'] ?>" ><?= $notelist[$i]['notemsg'] ?></td>
                <td id="note_hourmeter<?= $notelist[$i]['productnote_id'] ?>" ><?= $notelist[$i]['note_hourmeter'] ?></td>
                <td id="note_actionby<?= $notelist[$i]['productnote_id'] ?>" ><?= $notelist[$i]['note_actionby'] ?></td>
                <td align="center"><img alt=""  src="images/edit.png" class="icon"  onclick="edit('<?= $notelist[$i]['productnote_id'] ?>')"/></td>
                <td align="center"><img alt=""  src="images/del.png" class="icon"  onclick="del('<?= $notelist[$i]['productnote_id'] ?>')"/></td>
              </tr>
              <?php
              $i++;
            }
          } else {
            ?>

            <td colspan = '7' align="center" >
              ..ไม่มีข้อมูล..
            </td>
          <?php } ?>
        </table>
      </div>
    </div>
    <div id="noteEdit">
      <table>
        <tr >
          <td>วันที่ / Date  :</td>
          <td><input type="text" name="notedate" class="datepicker" id="notedate" style="width:80px;"  /></td>
        </tr>
        <tr >
          <td style="vertical-align: top">รายการ / Description :</td>
          <td  ><textarea id="notemsg" name="notemsg" style="width:200px;height:50px"><?= $row['notemsg'] ?></textarea></td>
        </tr>
        <tr >
          <td style="vertical-align: top">เลขไมล์สะสม / Hour meter :</td>
          <td  ><input type="text" name="note_hourmeter" id="note_hourmeter" style="width:80px;"  /></td>
        </tr>
        <tr >
          <td style="vertical-align: top">ผู้ดำเนินการ / Action By :</td>
          <td  ><input type="text" name="note_actionby" id="note_actionby" style="width:100px;"  /></td>
        </tr>
      </table>

    </div>
  <?php } ?>
  <?php include "footer.php" ?>
