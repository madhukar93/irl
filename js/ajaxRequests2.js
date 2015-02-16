
var running = false;
$(document).ready(function() {
$("form").submit(function(){	
	event.preventDefault();
	if(running){
		alert("already running");
		location.reload(true);
		//return;
	}
	running = true;
	$.ajax({
	  //type: "POST",
	  url: "./request_trains.php",
	  dataType: 'json',
	  data: { source: $('input[name*="src"]').val(), destination: $('input[name*="dstn"]').val(), 
	  			day: $('input[name*="day"]').val(), month: $('input[name*="month"]').val(), cl: $('input[name*="cl"]').val()  }
	})
	  .done(function(trains) {
	  	//console.log(trains);
	  	$("#head").append("Train availibility:");

	  	var interval = setInterval(function(){
	    trains.map(function(train) {
    	// no "i" variable needed - use "train" instead of "train[i]"

	    	$.ajax({
		            url: './request_availability.php', 
		            dataType: 'json',
		            data: { 
		  					day: $('input[name*="day"]').val(), month: $('input[name*="month"]').val(), lccp_trndtl:train[0], number:train[1], name:train[2] }
		            
		        }).done(function(data){
		        	 console.log(train);
		        	 console.log(data);
		        	//0:{number,name} 1:{s no, date, class1, class2}, 3 5 7 9 11

		        	table = $('<table></table>').addClass('table').attr("id",train[1]);
		        	//["12722NZM HYB 0YYYYYYYA", "12722", " +DAKSHIN EXPRESS ", "H NIZAMUDDIN ", "23:00", "HYDERABAD DECAN", "05:00", "30:00"
		        	table.append("<tr> <th>T No.:"+train[1]+"</th> <th>name:"+train[2]+"</th> <th>source:"+train[3]+"</th> <th>dest:"+train[5]+"</th> </tr>")
		        	table.append("<tr> <th>S No.</th> <th>date</th> <th>SL</th> <th>Chair</th> </tr>")
				    for (i = 0; i <= 10; i+=2) {
			            var row = $('<tr></tr>');
			            for (j = 0; j < 4; j++) {
			                var row1 = $('<td></td>').text(data[''+i][j]);
			                table.append(row);
			                row.append(row1);
           				 }
        			}

		        	if($('#'+train[1]).length){
				          $('#'+train[1]).replaceWith(table);
				          console.log("replace");
				    }
				    else{
				          $('#tables').append(table);
				          console.log("Add, length = " + $('#'+train[1]).length);
				    }

        			$('#tables').append(table);
		        });
			});
	}, 10000);

	 	 $('button[name*="stop"]').click(function(){
	 	 	console.log("stopping");
	 	 	clearInterval(interval);
	 	 	running = false;
	 	 	interval = null;
	 	 });	
	});

});
});