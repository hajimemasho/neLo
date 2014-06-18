<html>
	<head>
		<title><?php echo $title; ?></title>				
		<link rel="stylesheet" type="text/css" href=<?php echo $css_file; ?> />
		<script type="text/javascript" src=<?php echo $js_file; ?>></script>
		<script type="text/javascript" src=<?php echo $datepickr; ?>></script>		
	</head>
	<body>
		<section>					
			<form name="availableRooms" id="availableRooms" class="form" method="post" accept-charset="utf-8" 
				action=<?php echo $base_url . 'property/checkAvailability'; ?>>
				<div>					
					<label for="checkInDate">Data sosire:</label>
					<input name="checkInDate" id="checkInDate" readonly="true" placeholder="Data sosire"/>	
				</div>
				<div>					
					<label for="checkOutDate">Data plecare:</label>
					<input name="checkOutDate" id="checkOutDate" readonly="true" placeholder="Data plecare"/>	
				</div>
				 <div>
					<label for="roomType">Tip camera:</label>
					<input name="roomType" id="roomType" list="roomTypes" placeholder="Single"/>
					<datalist id="roomTypes">
					  <option value="Single">
					  <option value="Double">
					  <option value="Triple">
					  <option value="Apartment">
					</datalist>
				</div>       
				<?php
					foreach($options as $result){
						echo $result;
					}
				?>
				<div>
					<input id="submit" value="Verifica" type="submit" />
				</div>				
			</form>
					
			<script type="text/javascript" src=<?php echo $datepickr; ?>></script>
			<script type="text/javascript">
				new datepickr('checkInDate', {
					'fullCurrentMonth': false,
					'dateFormat': 'j M Y'
				});
				new datepickr('checkOutDate', {
					'fullCurrentMonth': false,
					'dateFormat': 'j M Y'
				});
			</script>
		</section>
		<p id="footer">&copy; 2011 </p>
	</body>
</html>