/**
	 -- script ce valideaza datele pentru inregistrarea 
	unui user si trimiterea lor catre server --
**/

window.onload = function () {   

	/* extragerea datelor din input-urile formularului cu name-ul "registerForm" */
	var email = document.registerForm.email;
	var password = document.registerForm.password;
	var passwordconf = document.registerForm.passwordconf;
	var firstname = document.registerForm.firstname;
	var lastname = document.registerForm.lastname;

	var array = [email, password, passwordconf, firstname, lastname];	
	var inputNames = ["Emailul", "Parola", "Confirmare parola", "Prenumele", "Numele"];	

	onblurEvent(array, inputNames);	
	onfocusEvent(array);	

	// cand userul da click pe butonul de creare cont se verifica daca sunt valide toate datele
	// daca da, permite trimiterea lor catre server, altfel afiseaza un mesaj de eroare
	document.getElementById('createAccount').onclick = function(){submitFunction(array, inputNames)};
};

/* functie care contine apeleaza sterge toate mesajele 
	de eroare de dupa input-ul curent */
var onfocusEvent = function(array){
	
	document.getElementById("email").onfocus = function(){deleteNextSpans(0, array)};
	document.getElementById("password").onfocus = function(){deleteNextSpans(1, array)};
	document.getElementById("passwordconf").onfocus = function(){deleteNextSpans(2, array)};
	document.getElementById("firstname").onfocus = function(){deleteNextSpans(3, array)};
	document.getElementById("lastname").onfocus = function(){deleteNextSpans(4, array)};	
}

/* functie care contine o colectie de functii care se apeleaza cand 
	apare evenimentul onblur pentru un anumit input */
var onblurEvent = function(array, inputNames){
	
	document.getElementById("email").onblur = function(){invalidEmail(array, inputNames)};
	document.getElementById("password").onblur = function(){invalidPassword(array, inputNames)};
	document.getElementById("passwordconf").onblur = function(){invalidConfPassword(array, inputNames)};
	document.getElementById("firstname").onblur = function(){invalidFirstname(array, inputNames)};
	document.getElementById("lastname").onblur = function(){invalidLastname(array, inputNames)};
}

/* functie care verifica daca toate datele sunt valide si permite trimiterea lor catre server */
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
var ajaxRequest = function(){
  
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        return new ActiveXObject("Msxml2.XMLHTTP");
    }
    else {
         return false;
    }
}
var createUrl = function(segment){
	var base_url, pathName, url, httpRequest;
    
    // localhost sau alt host
    base_url = window.location.origin;

    // calea pana la documentul curent
    pathName = window.location.pathname;        
    
    // construim url-ul prin care se va verifica credentialele
    url = base_url + pathName.substring(0, pathName.lastIndexOf('/')) + '/' + segment;        

    return url;
}

// functie care verifica daca un email exista deja in baza de date
var checkEmailExistence = function(array){		
	var url = createUrl('emailExistence');
    
    var httpRequest = ajaxRequest();

    if (!httpRequest) {    	
      	alert('Eroare: nu se poate crea o instanta XMLHTTP');
      	return false;
    }

    httpRequest.onreadystatechange = function(){
      	if (httpRequest.readyState==4){      		      		
      		if (httpRequest.status==200 || window.location.href.indexOf("http")==-1){       			
       			var result = httpRequest.responseText;       			
       			processEmailExistence(array, result);       			
      		}else{
       			alert("A aparut o eroare in timpul cererii");
      		}
     	}
    }    
    // facem escape la caracterele care nu sunt permise intr-un url    
    var email = encodeURIComponent(array[0].value);    
    
    /* adaugam un numar aleatoriu deoarece exista posibilitatea ca browserul sa faca
     	caching si nu va mai trimite inca o data datele la server, ci va returna 
    	rezultatul gasit anterior */    
    httpRequest.open('POST', url + '?_=' + Date.now(), false);    
	httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	httpRequest.send("email=" + email);    	
}

// functie care apeleaza checkEmailExistence 
var processEmailExistence = function(array, result){
	
	if(result == 0){				
		// emailul nu exista in baza de date
		return false;
	}else if(result == 1){		
		// emailul exista deja in baza de date 								
		makeErrorVisible(array[0].id, "Emailul exista deja in baza de date.");   
		return true;
	}else{
		/* cand este apelata functia, se intra pe ramura aceasta 
			si se face verificarea emailului */
		checkEmailExistence(array);
	}
}

var deleteNextSpans = function(index, array){
	
	// scoate mesajul de eroare pentru input-ul curent
	makeErrorHidden(array[index].id, '');

	for(var i = 0; i <= index; i++){		
		// daca input-urile care urmeaza dupa input-ul curent sunt goale
		if(array[i].value === ""){	
			// scoate mesajele lor de eroare
			makeErrorVisible(array[i].id, 'Acest camp este obligatoriu.');
		}
	}

	for(var i = index; i < array.length; i++){		
		// daca input-urile care urmeaza dupa input-ul curent sunt goale
		if(array[i].value === ""){	
			// scoate mesajele lor de eroare
			makeErrorHidden(array[i].id, '');
		}
	}
	
}
/* functie care verifica validitatea emailului */
var invalidEmail = function(array, inputNames){
	if(requiredError(0, array, inputNames) == true){
		return true;
	}else if(validEmailError(0, array, inputNames) == true){		
		return true;
	}else if(processEmailExistence(array, -1) == true) {		
		return true;	
	}else{
		return false;
	}

	return false;	
}
/* functie care verifica validitatea parolei */
var invalidPassword = function(array, inputNames){
	if(requiredError(1, array, inputNames) == true){		
		return true;
	}else if(spacesError(1, array, inputNames) == true){		
		return true;
	}else if(minLengthError(1, array, inputNames) == true){				
		return true;	
	}else if(uppercaseError(1, array, inputNames) == true){		
		return true;
	}else if(nonalphanumericError(1, array, inputNames) == true){		
		return true;						
	}else{		
		return false;
	}
	return false;	
}
/* functie care testeaza validitatea campului confirmare parola */
var invalidConfPassword = function(array, inputNames){	
	if(requiredError(2, array, inputNames) == true){		
		return true;
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
/* functie care testeaza validitatea prenumelui */
var invalidFirstname = function(array, inputNames){
	if(requiredError(3, array, inputNames) == true){
		return true;
	}else if(lettersOnlyError(3, array, inputNames) == true){
		return true;		
	}else{	
		return false;
	}
	return false;	
}
/* functie care testeaza numelui */
var invalidLastname = function(array, inputNames){
	if(requiredError(4, array, inputNames) == true){
		return true;
	}else if(lettersOnlyError(4, array, inputNames) == true){
		return true;
	}else{		
		return false;
	}
	return false;	
}
/* functie care verifica daca un anumit input nu contine nici un caracter */
var requiredError = function(index, array, inputNames){		
	if(array[index].value === ""){			
		var error = "Acest camp este obligatoriu.";		
		// afiseaza mesajul de eroare
		makeErrorVisible(array[index].id, error);						
		return true;
	}	
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;
}
/* functie care verifica daca un anumit input are o lungime minimima de 6 caractere*/
var minLengthError = function(index, array, inputNames){
	var min = 6;
	if(array[index].value.length < min){
		var error = inputNames[index] + " trebuie sa aiba macar  " + min + " caractere.";		
		// afiseaza mesajul de eroare
		makeErrorVisible(array[index].id, error);		
		return true;
	}
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;
}
/*functie care verifica daca un anumit input are o lungime maxima de 20 de caractere*/
var maxLengthError = function(index, array, inputNames){
	var max = 20;
	if(array[index].value.length > max){
		var error = inputNames[index] + " trebuie sa mai putin de " + min + " caractere.";		
		// afiseaza mesajul de eroare		
		makeErrorVisible(array[index].id, error);		
		return true;
	}
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;
}
/* functie care verifica daca emailul introdus de utilizator este valid */
var validEmailError = function(index, array, inputNames){
	// expresie regulata pentru validarea unui email
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
	// daca nu se potriveste
	if(!array[index].value.match(mailformat)){  
		var error = inputNames[index] + " este invalid.";		
		// afiseaza mesajul de eroare
		makeErrorVisible(array[index].id, error);		
		return true;  
	}
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;
}
/* functie care verifica daca un anumit input contine spatii */
var spacesError = function(index, array, inputNames){	
	// string care contine doar caractere fara spatii
	var format = /^\S*$/;	
	if(!array[index].value.match(format)){  		
		var error = inputNames[index] + " nu are voie sa contina spatii.";		
		// afiseaza mesajul de eroare
		makeErrorVisible(array[index].id, error);		
		return true;  	
	}	
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;	
}
/* functie care verifica daca parola contine macar o litera mare si macar un caracter non-alfanumeric*/
var contentPasswordError = function(index, array, inputNames){
	var format = /^([A-Z]+[\d\W]+[a-z]*)*([a-z]*[\d\W]+[A-Z]+)*([a-z]*[\d\W]+[A-Z]+[a-z]*)*$/;;
	if(!array[index].value.match(format)){  
		var error = "Introduceti macar o litera mare si un caracter nonalfanumeric.";		
		// afiseaza mesajul de eroare
		makeErrorVisible(array[index].id, error);
		return true;  
	}
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;
}
var uppercaseError = function(index, array, inputNames){
	var format = /[A-Z]+/g;	
	var results = array[index].value.match(format);	
	if(results == null){  
		var error = inputNames[index] + " trebuie sa contina macar o litera mare.";		
		// afiseaza mesajul de eroare
		makeErrorVisible(array[index].id, error);		
		return true;  
	}
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;
}
var nonalphanumericError = function(index, array, inputNames){
	var format = /\W+/;
	var results = array[index].value.match(format);		
	if(results == null){  
	
		var error = inputNames[index] + " trebuie sa contina macar un caracter nonalfanumeric.";		
		// afiseaza mesajul de eroare
		makeErrorVisible(array[index].id, error);
		return true;  
	}
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;
}
/* functie ce verifica daca valoarea din campul password si cea din campul passwordconf coincid */
var passwordsMatchingError = function(index1, index2, array){
	// daca parolele nu coincid
	if(array[index1].value !== array[index2].value){
		var error = "Parolele nu coincid.";
		// afiseaza mesajul de eroare
		makeErrorVisible(array[index2].id, error);		
		return true;
	}
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index2].id, '');
	return false;
}
/* functie ce verifica daca un anumit camp contine doar cifre */
var lettersOnlyError = function(index, array, inputNames){
	// regex pentru un string ce contine doar litere mari si mici
	var letters = /^[A-Za-z]+$/;  
	// daca nu se potriveste regexului
	if(!array[index].value.match(letters)){
		var error = inputNames[index] + " trebuie sa contina doar litere.";		
		// afiseaza mesajul de eroare
		makeErrorVisible(array[index].id, error);		
		return true;
	}
	// altfel ascunde mesajul de eroare care putea fi afisat anterior 
	// prin neintroducerea corecta a datelor
	makeErrorHidden(array[index].id, '');
	return false;
}

/* functie care schimba clasa paragrafului ce contine de mesajul de eroare pentru a-l ascunde */
var makeErrorHidden = function(fieldId, error){			
	// preluam nodul parinte al campului cu id-ul fieldId
	//acest camp si paragraful nostru au in comun parintele
	var parentNode = document.getElementById(fieldId).parentNode;	
	// preluam nodul paragraf
	var paraNode = parentNode.getElementsByTagName('p')[0];
	// schimbam clasa pargrafului
	paraNode.className = 'hiddenSignUpError';	
}

/* functie care schimba clasa paragrafului ce contine mesajul de eroare pentru a fi afisat */
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

/* functie care schimba clasa paragrafului ce contine mesajul de eroare pentru a-l ascunde */
var makeSubmitErrorHidden = function(error){			
	// preluam nodul div
	var divNode = document.getElementById("errorMessage");		
	
	// schimbam clasa pargrafului
	divNode.className = 'hiddenSubmitError';	
}

/* functie care schimba clasa paragrafului ce contine mesajul de eroare pentru a fi afisat */
var makeSubmitErrorVisible = function(error){			
	// preluam div-ul in care se gaseste mesajul de eroare
	var divNode = document.getElementById("errorMessage");			
	
	// modificam clasa acestuia pentru ca mesajul sa fie afisat
	divNode.parentNode.className = 'visibleSubmitError';	
	
	// luam nodul span in care vom insera mesajul de eroare
	spanNode = divNode.getElementsByTagName('span')[0];
	// cream nodul de tip text
	var newTextNode = document.createTextNode(error);
	
	// inseram in paragraf mesajul de eroare
	spanNode.replaceChild(newTextNode, spanNode.childNodes[0]);	
}