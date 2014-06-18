/**
	-- script care verifica daca campurile sunt empty si daca 
	data de sosire si de plecare sunt valide(data de sosire < 
	date de plecare ) : 
	- daca da, modifica tipul inputului din button in submit
	- altfel, insereaza o eroare in documentul html via DOM --
**/
window.onload = function () {   	
	/* extragerea credentialelor userului */
	var checkInDate = document.availableRoomsForm.checkInDate;
	var checkOutDate = document.availableRoomsForm.checkOutDate;	
	/* mesajele de eroare posibile */
	var errors = [
		"Nu ati introdus data de sosire. Va rugam corectati.",
		"Nu ati introdus  data de plecare. Va rugam corectati.",
		"Data de plecare este inainte de data de sosire. Va rugam corectati si reincercati."		
		];
	
	// atasarea functiei submitFunction la aparitia evenimentului onclick al butonului 
	// de submit 
	document.getElementById("checkAvailability").onclick = function () { 
			submitFunction(checkInDate.value, checkOutDate.value, errors) 
		};
};

// functie ce schimba tipul inputului in submit daca nu exista erori, 
// altfel insereaza erorile in documentul html prin DOM
var submitFunction = function (checkInDate, checkOutDate, errors) {
	if (filledField(checkInDate, errors[0]) == true && filledField(checkOutDate, errors[1]) == true) {
		if (validDates(checkInDate, checkOutDate) == true) {			
			var inputNode = document.getElementById("checkAvailability");
			inputNode.type = 'submit';
		} else {
			makeSubmitErrorVisible(errors[2]);
		}
	}
}
// functie care verifica daca data de sosire < data de plecare 
var validDates = function (checkInDate, checkOutDate) {
	// sectionam stringul in zi, luna, an
	var sections1 = checkInDate.split(' ');	
	var sections2 = checkOutDate.split(' ');
	// verificam, mai intai, validitatea anilor
	var validity = validYears(sections1[2], sections2[2]);	
	// daca raspunsul returnat de validYears este true,
	// verifica validitatea lunilor
	validity = validMonths(sections1[1], sections2[1], validity);
	// daca raspunsul returnat de validMonths este true,
	// se verifica validitatea zilelor
	validity =  validDays(sections1[0], sections2[0], validity);
	// se returneaza validitatea datelor
	return validity;
}
// functie care verifica daca anul din data de sosire < anul 
// din data de plecare
var validYears = function (checkInYear, checkOutYear) {
	// convertim anii dati ca siruri de caractere in intregi
	var firstyear = parseInt(checkInYear);
	var lastyear = parseInt(checkOutYear);	
	// daca anul din data de sosire < anul din data de plecare
	if (firstyear <= lastyear) {		
		// se returneaza true
		return true;
	} else {
		// altfel, se returneaza false
		return false;
	}
}
// functie care verifica daca luna din data de sosire < luna din 
// data de plecare
var validMonths = function (checkInMonth, checkOutMonth, yearValidity) {
	// se extrage numarul corespunzator lunii din data de sosire, 
	//respectiv din data de plecare
	var firstmonth = getMonthNumber(checkInMonth);
	var lastmonth = getMonthNumber(checkOutMonth);	
	// daca anul din data de sosire < anul din data de plecare
	if (yearValidity == true) {		
		// se verifica daca luna din data de sosire < luna din 
		// data de plecare
		if (firstmonth != -1 && lastmonth != -1 && firstmonth <= lastmonth) {
			// daca da, returneaza true			
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}
// functie care verifica daca ziua din data de sosire < ziua din 
// data de plecare
var validDays = function (checkInDay, checkOutDay, monthValidity) {
	// se convertesc zilele primite ca siruri de caractere in intregi
	var firstday = parseInt(checkInDay);
	var lastday = parseInt(checkOutDay);
	// daca luna din data de sosire < luna din data de plecare
	if (monthValidity == true){
		// se verifica daca ziua din data de sosire < ziua din 
		// data de plecare
		// nu se permite cazul in care data de sosire = data de plecare
		if (firstday < lastday) {			
			// returneaza true
			return true;
		} else{
			return false;
		}
	} else {
		return false;
	}
}
// functie care returneaza numarul de ordine al unei luni in cadrul 
// unui an 
var getMonthNumber = function (month) {
	// se retin abrevierile lunilor din an
	var months = ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun', 'Iul', 'Aug', 'Sep', 'Oct', 'Noi', 'Dec'];	
	for (var i = 0; i < months.length; i++) {
		// daca luna data ca parametru se gaseste printre aceste luni
		if (months[i] == month) {
			// se returneaza numarul ei de ordine
			return i;
		}
	}
	// altfel se returneaza -1, deoarece avem de-a face cu o luna
	// inexistenta
	return -1;
}

