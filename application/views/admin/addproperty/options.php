<section>
	<div id="wizardButtons">
		<?php
			if(isset($wizardButtons))
			{
				echo $wizardButtons;
			}		
		?>
	</div>			
	<div id="tabs">		
		<form id="addPropertyForm" method="post" accept-charset="utf-8" action=<?php echo $base_url . 'admin/saveProperty'; ?>>
			<legend>Optiuni</legend>
			<div>
				<?php 
					if(isset($_SESSION['property']['propertyName'])){
						echo $_SESSION['property']['propertyName'];
					}
				?>	
			</div>	
			<fieldset id="options">
				<ul>
					<li><div>
							<div>
								<label for="roomType">Tip camera</label>
							</div>
							<div>
								<label for="roomPrice">Pret camera</label>
							</div>						
						</div>
					</li>
					<?php 
						if(isset($_SESSION['property']['roomType'])){
							$roomTypes = $_SESSION['property']['roomType'];
							$roomPrices = $_SESSION['property']['roomPrice'];
							
							$length = count($roomTypes);									
							for($i = 0; $i < $length; $i++){
						
								echo '<li><div>' .
										'<div class="roomFeature">"' . $roomTypes[$i] . '</div>' .
										'<div class="roomFeature">' . $roomPrices[$i] . 'RON </div>' .
										'<ul></ul>' .
								        '<div class="add">'.
								        	'<input name="addButton' .  $i .'" id="addButton' . $i .'"' . 
								        		' value="Adauga optiune"' .
												' onclick="addOption(' . $i . ', \'addPropertyForm\' , \'roomOption_\'' . 
												', \'optiune\')"' .
												' type="button" />'.												
										'</div' .
									  '</div></li>';
							}
						}
					?>
				</ul>
			</fieldset>			
			<div id="traverse">
	        	<input id="previous" value="Inapoi" type="button" />
	        	<input id="save" value="Salveaza" type="submit" /> 
	    	</div>
		</form>
	</div>			
</section>
