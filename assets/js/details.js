window.onload = function () {
	//document.getElementById('hiddenButton').onclick = function(){previousTab('addPropertyForm', '', 'button1', 'details')};
	
	document.getElementById('next').onclick = function (){
		document.getElementById("button1").className = "defaultWizardButton";
		document.getElementById("button2").className = "walkingWizardButton";		
	}
}
