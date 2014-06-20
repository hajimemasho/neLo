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
		<form id="addPropertyForm" method="post" accept-charset="utf-8" action=<?php echo $base_url . 'admin/images'; ?>>					
			<legend>Facilitati</legend>						
			<div>
				<?php 
					if(isset($_SESSION['property']['propertyName'])){
						echo $_SESSION['property']['propertyName'];
					}
				?>	
			</div>			
			<fieldset id="facilities">															
				<ul>
					<li>				
						<div>
							<label for="facility">Facilitate:</label>										
						</div>																		
					</li>								
				</ul>				
				<div class="add">
					<input name="addButton" id="addButton" value="Adauga facilitate" type="button" />				
				 </div>
			</fieldset>
			<div id="traverse">
	        	<input id="previous" value="Inapoi" type="button" />
	        	<input id="next" value="Inainte" type="submit" />
	    	</div>
		
		</form>
	</div>			
</section>
