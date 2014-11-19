<?php
include "header.php";
include "header_php.php";
?>

<script type="text/javascript">
  $(function(){
        
    $('#formEdit').dialog({ 
      autoOpen: false,
      width : 450,
      modal: true
    }
  );
    

    $('#addButton').click(function() {
      
      $('#unit_name').val("");

        
      $( "#formEdit" ).dialog({ 
        title: 'เพิ่มข้อมูล' ,               
        buttons: { "Save": function() {
            
            var unit_name = $('#unit_name').val();

            if(unit_name==""){
              alert("คุณยังไม่ได้ใส่ข้อมูลสำคัญ");
            }else{
              $.post("unit_ajax.php", { 
                task:"save" ,
                unit_name: unit_name
              },
              function(data){
                //reload table
                if(data != "success"){
                  alert(data);
                }else{
                  $('#dataList').load('unit_master.php #table', function() {
                    $('#table tr:last').effect( 'highlight','slow');  // highlight แถวที่เพิ่ม
                  });
                }
              });
  
              $(this).dialog("close"); 
            }
          }}
      });
      $( "#formEdit" ).dialog("open");
      
    });
  });
  
  function edit(id){
  
    $('#unit_name').val($('#unit_name'+id).text());


    $( "#formEdit" ).dialog({ 
      title: 'แก้ไขข้อมูล' ,               
      buttons: { "Save": function() {
            
          var unit_name = $('#unit_name').val();

            
          if(unit_name==""){
            alert("คุณยังไม่ได้ใส่ข้อมูลสำคัญ");
          }else{
            $.post("unit_ajax.php", { 
              task:"edit" ,
              unit_id: id,
              unit_name: unit_name
            },
            function(data){
              
              if(data != "success"){
                alert(data);
              }else{
                //reload table
                $('#dataList').load('unit_master.php #table', function() {
                  $('#row'+id).effect( 'highlight','slow');
                });
              }
            });
  
            $(this).dialog("close"); 
          }
        }}
    });
    $( "#formEdit" ).dialog("open");
  }
  
  function del(id){
    var r=confirm("ยืนยันว่าต้องการลบข้อมูล!");
    if(r==true)
      $.post("unit_ajax.php", { 
        task:"delete" ,
        unit_id: id
      },
    function(data){
      $('#row'+id).effect( 'highlight','slow');
      $('#dataList').load('unit_master.php #table');
                
    });
  }
</script>



<div class="content" >

  <div id="navigator"> 
    <a href="menu.php">Menu </a> 
    <img src="images/btween_link.png" width="10" height="7" align="absmiddle">  ฐานข้อมูลหน่วยสินค้า
  </div>
  <div class="txtHead" style="width: 250px" >ฐานข้อมูลหน่วยสินค้า</div>

  <div style="position:relative;top:45px;  left:32px;">
    <button id="addButton" class="submitBtn" role="button" aria-disabled="false" >เพิ่มข้อมูล</button>
  </div>

  <div id="dataList" style="margin: 70px 0px 0px 32px">

    <table id="table" class="simply">
      <tr class="ui-widget-header ">

        <th style="width: 30px">No</th>
        <th style="width: 160px">ชื่อเต็ม</th>

        <th style="width: 60px">Edit</th>
        <th style="width: 60px">Del</th>
      </tr>

      <?php
      $sql = "SELECT * FROM unit_master";

      $resource = mysql_query($sql);

      if (mysql_num_rows($resource)>0) {
        $i = 0;
        while ($row = mysql_fetch_assoc($resource)) {
          ?>

          <tr id="row<?= $row['unit_id'] ?>" <?php if (($i + 1) % 2 == 0) { echo "style='background-color: #f4f9f6'"; } ?> >

            <td  align="center" ><?= $i + 1 ?>.</td>
            <td id="unit_name<?= $row['unit_id'] ?>" ><?= $row['unit_name'] ?></td>

            <td align="center" ><span onclick="edit('<?= $row['unit_id'] ?>')" class="ui-state-default ui-corner-all ui-icon ui-icon-wrench"></span></td>
            <td align="center" ><span onclick="del('<?= $row['unit_id'] ?>')" class="ui-state-default ui-corner-all ui-icon ui-icon-closethick"></span></td>

          </tr>
          <?php
          $i++;
        }
      } else {
        ?>

        <td align="center" colspan = '4'>..ไม่มีข้อมูล..</td>
      <?php } ?>
    </table>
  </div>


  <div id="formEdit" >
    <table>
      <tr >
        <td>ชื่อเต็ม :</td>
        <td><input type="text" name="unit_name" id="unit_name" class="ui-widget-content ui-corner-all" /></td>
      </tr>
    </table>

  </div>

</div>

<?php
include "footer.php";
?>
