<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ระบบสำนักงาน</title>

    <!--    include Css file-->
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>            
    <script src="js/jquery.ui.datepicker-th.js" type="text/javascript" charset="utf-8"></script>        
    <script src="js/jquery.ui.datetimepicker.js" type="text/javascript" charset="utf-8"></script> 

    <script src="js/jquery.ui.datepicker.ext.be.js" type="text/javascript" charset="utf-8"></script>  

    <script type="text/javascript" src="js/lib.js"></script>

    <script type="text/javascript" src="js/jquery.validationEngine-en.js"></script>
    <script type="text/javascript" src="js/jquery.validationEngine.js "></script>

    
        <!-- add jquery ui time-picker -->
    <script type="text/javascript" src="js/ui-timepicker.js"></script>
    <link type="text/css" href="css/ui-timepicker.css" rel="stylesheet" />

    <link type="text/css" href="css/validationEngine.jquery.css" rel="stylesheet" />



    <link type="text/css" href="css/jquery-ui.css" rel="stylesheet" />
  </head>
  <body >




    <?php include "partials/headbar_menu.php"; ?>

    <div id="wrapper" >
    
      <script type="text/javascript">
        $(document).ready(function(){
          
          $.ajaxSetup({ cache: false });
 
          
          // event loading handler
          $('#loading').dialog({ 
            autoOpen: false,
            dialogClass: 'hide-title-bar',
            width : 160,
            height : 80,
            resizable: false,
            draggable: false,
            modal: true
          });

          $('#loading').ajaxStart(function() {
            
            $( "#loading" ).dialog("open");
 
          });

          $('#loading').ajaxStop(function() {
            $( "#loading" ).dialog("close");
          });
               
          

			
          $( ".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy',
            isBE: true,
            autoConversionField: false
          });

          $( ".datepicker" ).datepicker( "option", "yearRange", '1950:2050' );

          
        });
        // end event loading handler
         
      </script>

      <div style="display: none">
        <div id="loading" style="display: table-cell;vertical-align:middle;"> <img src="images/load.gif" alt="loading" />   ..loading</div>
      </div>



