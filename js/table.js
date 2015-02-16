$(function () {

        var table = $('<table></table>').addClass('foo');
        for (var i = 0; i < 10; i++) {
                row = $('<tr></tr>');
                for (var j = 0; j < 10; j++) {
                    var rowData = $('<td></td>').addClass('bar').text('result ' + j);
                    row.append(rowData);
                }
                table.append(row);
            }

        if ($('table').length) {
             $("#someContainer tr:first").after(row);
        }
        else {
            $('#someContainer').append(table);
        }
    });
//==================================================
$(function () {
    $("#addProduct").click(function () {
    var table
    
    if($('#someContainer').find("table").length > 0){
          table =$('#someContainer').find("table");
    }else{
          table = $('<table></table>').addClass('foo');
    }

        for (i = 0; i < 10; i++) {
            var row = $('<tr></tr>');
            for (i = 0; i < 10; i++) {
                var row1 = $('<td></td>').addClass('bar').text('result ' + i);
                table.append(row);
                row.append(row1);
            }
        }
        $('#someContainer').append(table);
    });
});