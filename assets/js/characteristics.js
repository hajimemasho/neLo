window.onload = function () {
	document.getElementById('previous').onclick = function(){previousTab('addPropertyForm', 'button2', 'button1', 'details')};
	document.getElementById('next').onclick = function (){
		document.getElementById("button2").className = "defaultWizardButton";
		document.getElementById("button3").className = "walkingWizardButton";
	}
}
