	
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
		<form id="addPropertyForm" method="post" accept-charset="utf-8" action=<?php echo $base_url . 'admin/characteristics'; ?>>	       
				<legend>Detalii</legend>
				<fieldset>
					<legend>Detalii proprietate</legend>
					<div>
						<label for="propertyName">Denumire:</label>
						<input name="propertyName" id="propertyName", placeholder="Numele proprietatii"/>
					</div> 
					<div>
						<label for="propertyTown">Oras:</label>
						<input name="propertyTown" id="propertyTown" type="town" placeholder="Oras"/>
					</div> 
					<div>
					   <label for="propertyAddress">Adresa</label>
					   <textarea name="propertyAddress" id="propertyAddress" rows="2" cols="50"
					   placeholder="Adresa proprietatii"/></textarea>
					</div>                 
				</fieldset>
				<fieldset>
					<legend>Detalii proprietar</legend>
					<div>
						<label for="ownerName">Nume:</label>
						<input name="ownerName" id="ownerName" placeholder="Numele proprietarului"/>
					</div>
					<div>
						<label for="ownerEmail">Email:</label>
						<input name="ownerEmail" id="ownerEmail" type="email" placeholder="Adresa de email"/>
					</div>
					<div>
						<label for="ownerTown">Oras:</label>
						<input name="ownerTown" id="ownerTown" type="town" placeholder="Oras"/>
					</div>           
					<div>
						<label for="ownerAddress">Adresa</label>
						<textarea name="ownerAddress" id="ownerAddress" rows="2" cols="50"
						placeholder="Adresa proprietarului"/></textarea>
					</div>     
				</fieldset>
				<div id="traverse">
					<input id="hiddenButton" value="Inapoi" type="button" />
					<input id="next" value="Inainte" type="submit" />
				</div>
	    </form>
	</div>			
</section>
