/**
	 -- script ce valideaza datele pentru inregistrarea 
	unui user si le trimite la catre server --
**/

window.onload = function () {   
	// extragerea datelor din input-urile formularului cu name-ul registerForm
	var email = document.registerForm.email;
	var password = document.registerForm.password;
	var passwordconf = document.registerForm.passwordconf;
	var firstname = document.registerForm.firstname;
	var lastname = document.registerForm.lastname;
	// introducem datele intr-un array pentru a le manipula mai cu usurinta
	var array = [email, password, passwordconf, firstname, lastname];	
	// array cu numele articulat al fiecarui camp
	var inputNames = ["Emailul", "Parola", "Confirmare parola", "Prenumele", "Numele"];		

	// incarca functiile ce sunt apelate cand apare evenimentul onblur
	onblurEvent(array, inputNames);	
	// incarca functiile ce sunt apelate cand apare evenimentul onfocus
	onfocusEvent(array);	

	// cand userul da click pe butonul de creare cont se verifica daca sunt valide toate datele
	// daca da, permite trimiterea lor catre server, altfel afiseaza un mesaj de eroare
	document.getElementById('createAccount').onclick = function(){submitFunction(array, inputNames)};
};

// functie care contine apeleaza sterge toate mesajele 
// de eroare de dupa input-ul curent
var onfocusEvent = function(array){
	
	document.getElementById("email").onfocus = function(){deleteNextSpans(0, array)};
	document.getElementById("password").onfocus = function(){deleteNextSpans(1, array)};
	document.getElementById("passwordconf").onfocus = function(){deleteNextSpans(2, array)};
	document.getElementById("firstname").onfocus = function(){deleteNextSpans(3, array)};
	document.getElementById("lastname").onfocus = function(){deleteNextSpans(4, array)};	
}

// functie care contine o colectie de functii care se apeleaza cand 
//	apare evenimentul onblur pentru un anumit input
var onblurEvent = function(array, inputNames){
	
	document.getElementById("email").onblur = function(){invalidEmail(array, inputNames)};
	document.getElementById("password").onblur = function(){invalidPassword(array, inputNames)};
	document.getElementById("passwordconf").onblur = function(){invalidConfPassword(array, inputNames)};
	document.getElementById("firstname").onblur = function(){invalidFirstname(array, inputNames)};
	document.getElementById("lastname").onblur = function(){invalidLastname(array, inputNames)};
}
// functie care verifica daca toate datele sunt valide si permite trimiterea lor catre server
var submitFunction = function(array, inputNames){
	if(invalidEmail(array, inputNames) == false && invalidPassword(array, inputNames) == false && 
		invalidConfPassword(array, inputNames) == false && invalidFirstname(array, inputNames) == false &&
			invalidLastname(array, inputNames) == false){		
			// datele sunt valide, permite submitul
			var inputNode = document.getElementById("createAccount");
			inputNode.type = 'submit';				
		}else{
			// datele sunt invalide, afiseaza o eroare
			makeSubmitErrorVisible("Campuri invalide. Va rugam mai incercati.");
		}
}
// functie care verifica daca un email exista deja in baza de date
var checkEmailExistence = function(array){
	// creaza url-ul documentului care urmeaza a fi incarcat
	var url = createUrl('emailExistence');
    // creaza un obiect de tip XMLHttpRequest
    var httpRequest = ajaxRequest();
    // verifica daca acesta este corect creat
    if (!httpRequest) {    	
      	alert('Eroare: nu se poate crea o instanta XMLHTTP');
      	return false;
    }
    // trateaza schimbarea de stare a cererii
    httpRequest.onreadystatechange = function(){
    	// verifim daca incarcarea a avut loc cu succes
      	if (httpRequest.readyState==4){      		   
      		// verificam daca am obtinut codul codul de stare '200 OK'
      		if (httpRequest.status==200){       			
      			// preluam raspunsul primit
       			var result = httpRequest.responseText;       			
       			processEmailExistence(array, result);       			
      		}else{
       			alert("A aparut o eroare in timpul cererii");
      		}
     	}
    }    
    // facem escape la caracterele care nu sunt permise intr-un url    
    var email = encodeURIComponent(array[0].value);    
    
    // adaugam la url un identificator unic deoarece exista posibilitatea 
    // ca browserul sa faca	caching si nu va mai trimite inca o data 
    // datele la server, ci va returna 	rezultatul gasit anterior
    httpRequest.open('POST', url + '?_=' + Date.now(), false);    
	httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	httpRequest.send("email=" + email);    	
}
// functie care apeleaza checkEmailExistence 
var processEmailExistence = function(array, result){
	// daca emailul nu exista in baza de date
	if(result == 0){				
		// returneaza false
		return false;
	// altfel
	}else if(result == 1){		
		// emailul exista deja in baza de date, se insereaza o eroare
		makeErrorVisible(array[0].id, "Emailul exista deja in baza de date.");   
		return true;
	}else{
		// cand este apelata functia, se intra pe ramura aceasta 
		// si se face verificarea emailului
		checkEmailExistence(array);
	}
}
// functie care face vizibile span-urile cu mesajele de eroare dinaintea 
// unui input si ascunde spanurile cu mesajele de eroare de dupa acel input
var deleteNextSpans = function(index, array){	
	// ascunde mesajul de eroare pentru input-ul curent
	makeErrorHidden(array[index].id, '');

	for(var i = 0; i <= index; i++){		
		// daca input-urile dinainte de input-ul curent sunt vide
		if(array[i].value === ""){	
			// afiseaza mesajele lor de eroare
			makeErrorVisible(array[i].id, 'Acest camp este obligatoriu.');
		}
	}

	for(var i = index; i < array.length; i++){		
		// daca input-urile care urmeaza dupa input-ul curent sunt vide
		if(array[i].value === ""){	
			// ascunde mesajele lor de eroare
			makeErrorHidden(array[i].id, '');
		}
	}
	
}
// functie care verifica validitatea emailului
var invalidEmail = function(array, inputNames){
	// se testeaza mai intai daca campul este vid
	if(requiredError(0, array, inputNames) == true){
		return true;
	// daca nu este vid, se testeaza daca emailul este valid
	}else if(validEmailError(0, array, inputNames) == true){		
		return true;
	// daca este valid, se testeaza daca exista deja in baza de date
	}else if(processEmailExistence(array, -1) == true) {		
		// daca exista, se returneaza true(emailul este invalid)
		return true;	
	}else{
		// altfel emailul este valid
		return false;
	}

	return false;	
}
// functie care verifica validitatea parolei
var invalidPassword = function(array, inputNames){
	// se testeaza mai intai daca campul este vid
	if(requiredError(1, array, inputNames) == true){		
		return true;
	// daca nu este vid, se testeaza daca contine spatii 
	}else if(spacesError(1, array, inputNames) == true){	
		return true;
	// daca nu contine spatii, se testeaza daca lungimea este cea
	// admisa		
	}else if(minLengthError(1, array, inputNames) == true){				
		return true;	
	// daca e valid dpdv al lungimii, se verifica daca are macar o
	// litera mare
	}else if(uppercaseError(1, array, inputNames) == true){		
		return true;
	// daca are cel putin o litera mare, verifica daca are macar 
	// un alfabet non-alfanumeric
	}else if(nonalphanumericError(1, array, inputNames) == true){		
		return true;						
	}else{		
		return false;
	}
	return false;	
}
// functie care testeaza validitatea campului confirmare parola
var invalidConfPassword = function(array, inputNames){	
	// se testeaza mai intai daca campul este vid
	if(requiredError(2, array, inputNames) == true){		
		return true;
	// daca nu este vid si parola din campul anterior este valida,
	// se verifica daca cele doua parole coincid
	}else if(invalidPassword(array, inputNames) == false){		
		if(passwordsMatchingError(1, 2, array) == true){			
			return true;		
		}else{			
			return false;
		}
		return false;
	}
	return false;	
}
// functie care testeaza validitatea prenumelui 
var invalidFirstname = function(array, inputNames){
	// se testeaza mai intai daca campul nu este vid
	if(requiredError(3, array, inputNames) == true){
		return true;
	// apoi se verifica daca este alcatuit doar din litere si spatii
	}else if(lettersOnlyError(3, array, inputNames) == true){
		return true;		
	}else{	
		return false;
	}
	return false;	
}
// functie care testeaza validitatea numelui
var invalidLastname = function(array, inputNames){
	// se verifica mai intai daca campul nu este vid
	if(requiredError(4, array, inputNames) == true){
		return true;
	// apoi se verifica daca este alcatuit doar din litere si spatii
	}else if(lettersOnlyError(4, array, inputNames) == true){
		return true;
	}else{		
		return false;
	}
	return false;	
}
// functie care verifica daca un anumit input este vid
var requiredError = function(index, array, inputNames){		
	// daca inputul este vid
	if(array[index].value === ""){			
		var error = "Acest camp este obligatoriu.";		
		// modifica mesajul de eroare si afiseaza-l		
		makeErrorVisible(array[index].id, error);						
		return true;
	}	
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;
}
// functie care verifica daca un anumit input are o lungime 
// minimima de 6 caractere
var minLengthError = function(index, array, inputNames){
	// lungimea minima 
	var min = 6;
	// daca lungimea campului este mai mica decat lungimea minima
	if(array[index].value.length < min){
		var error = inputNames[index] + " trebuie sa aiba macar  " + min + " caractere.";		
		// modifica mesajul de eroare si afiseaza-l	
		makeErrorVisible(array[index].id, error);		
		return true;
	}
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;
}
// functie care verifica daca un anumit input are o lungime 
// maxima de 20 de caractere
var maxLengthError = function(index, array, inputNames){
	var max = 20;
	if(array[index].value.length > max){
		var error = inputNames[index] + " trebuie sa mai putin de " + min + " caractere.";		
		// modifica mesajul de eroare si afiseaza-l	
		makeErrorVisible(array[index].id, error);		
		return true;
	}
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;
}
// functie care verifica daca emailul introdus de utilizator este valid
var validEmailError = function(index, array, inputNames){
	// expresie regulata pentru validarea unui email
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
	// daca nu se potriveste
	if(!array[index].value.match(mailformat)){  
		var error = inputNames[index] + " este invalid.";		
		// modifica mesajul de eroare si afiseaza-l	
		makeErrorVisible(array[index].id, error);		
		return true;  
	}
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;
}
// functie care verifica daca un anumit input contine spatii
var spacesError = function(index, array, inputNames){	
	// string care contine doar caractere fara spatii
	var format = /^\S*$/;	
	if(!array[index].value.match(format)){  		
		var error = inputNames[index] + " nu are voie sa contina spatii.";		
		// modifica mesajul de eroare si afiseaza-l	
		makeErrorVisible(array[index].id, error);		
		return true;  	
	}	
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;	
}
// functie care verifica daca campul contine macar o litera mare
var uppercaseError = function(index, array, inputNames){
	// expresia regulata
	var format = /[A-Z]+/g;	
	// returneaza toate potrivirile
	var results = array[index].value.match(format);	
	// daca nu gaseste nici o potrivire
	if(results == null){  
		var error = inputNames[index] + " trebuie sa contina macar o litera mare.";		
		// modifica mesajul de eroare si afiseaza-l	
		makeErrorVisible(array[index].id, error);		
		return true;  
	}
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;
}
// functie care verifica daca campul contine macar un caracter non-alfanumeric
var nonalphanumericError = function(index, array, inputNames){
	// expresia regulata
	var format = /\W+/;
	// returneaza toate potrivirile
	var results = array[index].value.match(format);		
	// daca nu gaseste nici o potrivire
	if(results == null){  
		var error = inputNames[index] + " trebuie sa contina macar un caracter nonalfanumeric.";		
		// modifica mesajul de eroare si afiseaza-l	
		makeErrorVisible(array[index].id, error);
		return true;  
	}
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;
}
// functie care verifica daca valoarea din campul password si cea din campul passwordconf coincid
var passwordsMatchingError = function(index1, index2, array){
	// daca parolele nu coincid
	if(array[index1].value !== array[index2].value){
		var error = "Parolele nu coincid.";
		// modifica mesajul de eroare si afiseaza-l	
		makeErrorVisible(array[index2].id, error);		
		return true;
	}
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index2].id, '');
	return false;
}
// functie ce verifica daca un anumit camp contine doar cifre
var lettersOnlyError = function(index, array, inputNames){
	// expresia regulata pentru un string ce contine doar litere mari si mici
	var letters = /^[A-Za-z]+$/;  
	// daca nu se potriveste regexului
	if(!array[index].value.match(letters)){
		var error = inputNames[index] + " trebuie sa contina doar litere.";		
		// modifica mesajul de eroare si afiseaza-l	
		makeErrorVisible(array[index].id, error);		
		return true;
	}
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;
}
// functie care schimba clasa paragrafului ce contine de mesajul
// de eroare pentru a-l ascunde 
var makeErrorHidden = function(fieldId, error){			
	// preluam nodul parinte al campului cu id-ul fieldId
	//acest camp si paragraful nostru au in comun parintele
	var parentNode = document.getElementById(fieldId).parentNode;	
	// preluam nodul paragraf
	var paraNode = parentNode.getElementsByTagName('p')[0];
	// schimbam clasa pargrafului
	paraNode.className = 'hiddenSignUpError';	
}
// functie care schimba clasa paragrafului ce contine mesajul de eroare 
// pentru a fi afisat 
var makeErrorVisible = function(fieldId, error){			
	// preluam nodul parinte
	var parentNode = document.getElementById(fieldId).parentNode;	
	// preluam nodul paragraf
	var paraNode = parentNode.getElementsByTagName('p')[0];
	// schimbam clasa paragrafului
	paraNode.className = 'visibleSignUpError';	
	var newTextNode = document.createTextNode(error);
	// inseram in paragraf mesajul de eroare
	paraNode.replaceChild(newTextNode, paraNode.childNodes[0]);	
}