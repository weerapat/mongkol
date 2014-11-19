<?php

include "header.php";
?>

<link type="text/css" href="css/bootstrap.min.css" rel="stylesheet" />
<script type="text/javascript" >

  $(function() {
    $("#submit").click(function() {

      var username = $('#username').val();
      var password = $('#password').val();

      if(username == ""){
        alert("คุณยังใส่ข้อมูลไม่ครบ");
      }else{

        $.post("login_ajax.php", {
          username: username,
          password : password
        },
        function(data){
          if(data == "ok"){
            urlchange("menu.php");
          }else{
            alert("Login fail !");
          }

        });
      }
    });
  });


</script>



<div class="container">
    <div id="textLogin" >
        <h3>
        ระบบสำนักงาน
        </h4>
    </div>
    <div class="col-md-4 col-md-offset-4 login-form" >
        <form class="form-horizontal" role="form">

          <div class="form-group">
            <label for="username" class="col-sm-3 control-label">Usename</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="username" placeholder="Username">
            </div>
          </div>

          <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-9">
              <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              <button type="button" id="submit" class="btn btn-info">Sign in</button>
            </div>
          </div>
        </form>
    </div>
</div>

<!-- <div id="textLogin" >ระบบสำนักงาน</div>
<div id="login" >
    <table>

      <tr style="height: 50px">
        <td><input id="username" placeholder="username" id="username" type="text" /></td>
      </tr>

      <tr style="height: 40px">
        <td><input id="password" placeholder="password" id="password" type="password" /></td>
      </tr>
      <tr style="height: 30px">
        <td style="padding-left: 15px;"><button class="submitBtn" id="submit" type="button" >Sign in</button></td>
      </tr>
    </table>
</div> -->

</div>