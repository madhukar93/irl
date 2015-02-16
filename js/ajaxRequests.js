


//var interval = 1000 * 60 * X; // where X is your every X minutes

//setInterval(ajax_call, interval);
$(document).ready(function() {
$("form").submit(function(){	
	event.preventDefault();
	
	$.ajax({
	  //type: "POST",
	  url: "./request_trains.php",
	  dataType: 'json',
	  data: { source: $('input[name*="src"]').val(), destination: $('input[name*="dstn"]').val(), 
	  			day: $('input[name*="day"]').val(), month: $('input[name*="month"]').val(), cl: $('input[name*="cl"]').val()  }
	})
	  .done(function(trains) {
	  	console.log(trains)


	    var requests = trains.map(function(train) {
    	// no "i" variable needed - use "train" instead of "train[i]"
	    return $.ajax({
		            url: './request_availability.php', 
		            dataType: 'json',
		            data: { 
		  					day: $('input[name*="day"]').val(), month: $('input[name*="month"]').val(),lccp_trndtl: train[0]  }
		            
		        })
			});

	  	$.when.apply($, requests).then(function() {

		    // convert the arguments array, where each argument is in the form
		    // [data, textStatus, jqXHR], into an array of just the data values
			    var allData = [].map.call(arguments, function(arg) {
			        return arg[0];
			    });
		    //do stuff
		    console.log(allData);
			});

	});

});
});