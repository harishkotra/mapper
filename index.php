<?php
	
	/* Inspired by multiple ideas, coded for own use. Put it on github for everyone to copy and paste just like how I do. */
	if(isset($_POST['address']))
	{
		$address = urlencode($_POST['address']);

		$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
		$output= json_decode($geocode); //Store values in variable

		if($output->status == 'OK'){ // Check if address is available or not
			$lat = $output->results[0]->geometry->location->lat; //Returns Latitude
			$long = $output->results[0]->geometry->location->lng; // Returns Longitude
		}
	}

?>

<html>
	<head>
		<title>Generate Google Map from address in PHP</title>

		<!-- bootstrap stylesheet -->
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
		<!-- jquery library -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<!-- google maps library -->
		<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->

	</head>


	<body>

	<div class="container">
		<div class="row">
			<div class="col-sm-3">
			</div>
			<div class="col-sm-6 text-center center-block">
				<h1>Generate a Google Map</h1>
				<!-- form to submit a simple address -->
				<form method="post" action="" name="addressform" id="addressform">
					<textarea class="form-control" id="address" name="address" rows="5" cols="5"></textarea><br />
					<input type="submit" name="submit" class="btn btn-lg btn-warning" value="Generate Map" />
				</form>
			</div>
			<div class="col-sm-3">
			</div>
		</div>
	</div>

	<script type="text/javascript">
	$(document).ready(function () {
		// Define the latitude and longitude positions
		var latitude = parseFloat("<?php echo $lat; ?>"); // Latitude get from above variable
		var longitude = parseFloat("<?php echo $long; ?>"); // Longitude from same
		var latlngPos = new google.maps.LatLng(latitude, longitude);
		// Set up options for the Google map
		var myOptions = {
			zoom: 10,
			center: latlngPos,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			zoomControlOptions: true,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.LARGE
			}
		};
		// Define the map
		map = new google.maps.Map(document.getElementById("map"), myOptions);
		// Add the marker
		var marker = new google.maps.Marker({
			position: latlngPos,
			map: map
		});
	});
	</script>

	<div class="container">
		<div class="row">
			<div class="col-sm-2">
			</div>
			<div class="col-sm-8 text-center center-block">
				<h4>Your map will show here</h4>
				<!-- following DIV shows the map generated. Place it wherever you want to. -->
				<div id="map" style="width:100%;height:350px; margin-top:25px;"></div> 
			</div>
			<div class="col-sm-2">
			</div>
		</div>
	</div>

	<!-- bootstrap javascript library -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<!-- jquery validation library to validate forms -->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
	<!-- call the above library for the particular form to have validation -->
	<script>
		 $("#addressform").validate({
		  rules: {
				address: {
					required: true,
					minlength: 10
				},

			},
		  messages: {
				address: "Please enter a proper address to generate the map."
			},
		  submitHandler: function(form) {
		    $(form).submit();
		  }
		});

	</script>

	</body>	
</html>