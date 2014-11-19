<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<script type="text/javascript">


function dataRow(value1,value2,value3) {
    this.name = value1;
    this.comparison = value2;
    this.value = value3;
}

$('#out').click(function(){   

    // create array to hold your data
    var dataArray = new Array();

    // iterate through rows of table
    for(var i = 1; i <= $("table tr").length; i++){

        // check if first field is used
        if($("table tr:nth-child(" + i + ") select[class='field']").val().length > 0) {

            // create object and push to array
            dataArray.push(    
                new dataRow(
                    $("table tr:nth-child(" + i + ") select[class='field']").val(),
                    $("table tr:nth-child(" + i + ") select[class='comp']").val(),
                    $("table tr:nth-child(" + i + ") input").val())
            );
        }

    }

    // consider using a JSON library to do this for you
    for(var i = 0; i < dataArray.length; i++){
        var output = "";
        output = output + '{"name":"data' + (i + 1) + '.' + dataArray[i].name + '",';
        output = output + '"comparison":"data' + (i + 1) + '.' + dataArray[i].comparison + '",';
        output = output + '"value":"data' + (i + 1) + '.' + dataArray[i].value + '"}';
        alert(output);
    }
})
</script>

<table id="table">
  
</table>