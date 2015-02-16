<html>
	<header>
		<!-- includes -->
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/my.css" rel="stylesheet">
		<script type="text/javascript"  src="js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript"  src="js/bootstrap.min.js"></script>
		<script type="text/javascript"  src="js/ajaxRequests2.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function(){
									$('#refresh').click(function() {	
								        location.reload(true);
									});
			});
		</script>
			
		
		<!--Horizontal form -->

	</header>
	<body>
		<div id="wrapper" class="container">
			  <form class="form-inline">
			  <input type="text" class="input-small" placeholder="Source" name="src">
			  <input type="text" class="input-small" placeholder="Destination " name = "dstn">
			  <input type="text" class="input-small" placeholder="Class" name ="cl">
			  <input type="text" class="input-small" placeholder="Day" name ="day">
			  <input type="text" class="input-small" placeholder="Month" name ="month">
			  <button type="submit" class="btn btn-success" name="sub">go</button>
			 <button type="button" class="btn btn-danger" name="stop">stop</button>
			 <button type="button" id="refresh" class="btn btn-default" name="refresh">refresh</button>
		</form>
			<div id="head" class="col-md-12 bg-info"></div>
			<div id="tables"></div>
		<div>
	</body>
</html>