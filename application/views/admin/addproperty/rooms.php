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
		<form id="addPropertyForm" method="post" accept-charset="utf-8" action=<?php echo $base_url . 'admin/options'; ?>>					
			<legend>Camere</legend>
			<div>
				<?php 
					if(isset($_SESSION['property']['propertyName'])){
						echo $_SESSION['property']['propertyName'];
					}
				?>	
			</div>				
			<fieldset id="rooms">			
				<ul>
					<li>
						<div>			
							<div>
								<label for="roomType">Tip camera:</label>										
							</div>
							<div>
								<label for="roomPrice">Pret camera:</label>										
							</div>																
						</div>
					</li>
				</ul>
				<div class="add">
					<input name="addButton" id="addButton" type="button" value="Adauga camera"/>
				</div>			
			</fieldset>
		    <div id="traverse">
		        <input id="previous" value="Inapoi" type="button" />
		        <input id="next" value="Inainte" type="submit" />
		    </div>
		</form>
	</div>			
</section>
