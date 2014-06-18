/** 
	-- script care verifica daca combinatia de email si parola introduse 
	de utilizator exista in baza de date si: 
	- permite trimiterea datelor catre server daca exista
	- insereaza un mesaj de eroare in documentul html via DOM, daca 
	nu exista --
**/
window.onload = function () {   
	// extragem credentialele userului
	var email = document.loginForm.email;
	var password = document.loginForm.password;	
	// mesajele de eroare posibile 
	var errors = ["Adresa de email lipseste. Va rugam corectati si reincercati.", 
					"Va rugam introduceti parola.", "Email sau parola invalide. Va rugam mai incercati."];
		
	document.getElementById("enterAccount").onclick = function(){submitFunction(email.value, password.value, errors)};
};
// functie care verifica daca toate datele sunt valide si permite 
// trimiterea lor catre server prin modificarea tipului inputului din 
// button in submit
var submitFunction = function (email, password, errors) {		
	if (filledField(email, errors[0]) == true) {
		if (filledField(password, errors[1]) == true) {			
			invalidCredentials(email, password, errors[2]);				
		}	
	}
}
// functie care verifica daca combinatia de emai si parola se gaseste 
// in baza de date si, daca da, schimba tipul inputului din button in submit, 
// altfel insereaza un mesaj de eroare in documentul html via DOM
var invalidCredentials = function (email, password, credentialsError) {		
	// cream url care va fi incarcat
	var url = createUrl('credentials');
    // returnam un  obiect de tip XMLHttpRequest
    var httpRequest = ajaxRequest();
    // daca exista
    if (!httpRequest) {    	
      	alert('Eroare: nu se poate crea o instanta XMLHTTP');
      	return false;
    }
    // tratam starea 
    httpRequest.onreadystatechange = function () {
    	// verificam daca starea s-a terminat cu succes
      	if (httpRequest.readyState==4){      		   
      		// verificam daca am obtinut codul de stare '200 OK'
      		if (httpRequest.status==200) { 
      			// procesam datele receptionate prin DOM	
       			var result = httpRequest.responseText;       			       			
       			// daca am preluat 0 
       			if (result == 0) {   
       				// eroare, combinatia de email si parola nu au fost 
       				// gasite in baza de date    				
       				makeSubmitErrorVisible(credentialsError);       				
       			} else {       				
       				// altfel modificam tipul inputului din button in submit
       				// pentru a permite intrarea utilizatorului in contul sau
       				var inputNode = document.getElementById("enterAccount");
					inputNode.type = 'submit';							
       			}
      		} else {
       			alert("A aparut o eraore in timpul procesarii cererii");
      		}
     	}
    }    
    // facem escape la caracterele care nu sunt permise intr-un url    
    email = encodeURIComponent(email);
    password = encodeURIComponent(password);
    // adaugam la url un identificator unic deoarece exista posibilitatea ca 
    // browserul sa faca caching si nu va mai trimite inca o data datele la server, 
    // ci va returna rezultatul gasit anterior 
    httpRequest.open('POST', url + '?_=' + Date.now(), false);    
	httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	httpRequest.send("email=" + email + "&password=" + password);    	
}
 