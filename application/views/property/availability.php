<html>
	<head>
		<title><?php echo $title; ?></title>				
		<link rel="stylesheet" type="text/css" href=<?php echo $css_file; ?> />
		<script type="text/javascript" src=<?php echo $generaljs_file; ?>></script>
		<script type="text/javascript" src=<?php echo $js_file; ?>></script>
		<script type="text/javascript" src=<?php echo $datepickr; ?>></script>		
	</head>
	<body>
		<section>					
			<form name="availableRoomsForm" id="availableRoomsForm" class="form" method="post" accept-charset="utf-8" 
				action=<?php echo $base_url . 'property/checkAvailability'; ?>>
				<!-- div care momentan este ascuns si devine vizibil cand apare o eroare la logare -->
				<div id="error" class="hiddenSubmitError">
					<div id="xIcon"></div>
					<div id="errorMessage">A aparut o eroare<span class="normal">Eroare</span></div>
				</div>
				<legend><?php echo $heading; ?></legend>
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
					<input name="checkAvailability" id="checkAvailability" type="button" value="Verifica"/>
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