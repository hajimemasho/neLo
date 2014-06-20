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
		<form id="addPropertyForm" method="post" accept-charset="utf-8" action=<?php echo $base_url . 'admin/facilities'; ?>>
			<legend>Caracteristici</legend>
			<fieldset>
				<div>
					<label for="propertyType">Tip proprietate:</label>
					<select id="propertyType" name="propertyType">
					    <option value="Hotel">Hotel</option>
					    <option value="Pensiune">Pensiune</option>
					    <option value="Vila">Vila</option>				    
					</select>					
				</div>				
				<div>
					<label for="starsNumber">Numar stele:</label>
					<input name="starsNumber" id="starsNumber" type="number" min="2" max="5" placeholder="2"/>
				</div>
				<div>
					<label for="totalRooms">Numar total camere:</label>
					<input name="totalRooms" id="totalRooms" type="number" min="1" placeholder="1"/>
				</div>
				<div>
					<label for="presentation">Prezentare</label>
					<textarea name="presentation" id="presentation" rows="7" cols="50" 
					placeholder="Servicii oferite, localizare, puncte de reper, spatii de cazare, facilitati" /></textarea>
				</div>
				<div>
					<label for="accommodRules">Reguli de cazare:</label>
					<textarea name="accommodRules" id="accommodRules" rows="7" cols="50" 
						placeholder="Detalii legate de ziua hoteliera, termenul limita de plata, conditiile cuprivire la anularea rezervarii, alte restrictii."></textarea>
				</div>
			</fieldset>   
			<div id="traverse">
				<input id="previous" value="Inapoi" type="button" />
				<input id="next" value="Inainte" type="submit" />
			</div>
		</form>		
	</div>			
</section>
