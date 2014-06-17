window.onload = function () {   

	/* extragerea credentialelor userului */
	var email = document.loginForm.email;
	var password = document.loginForm.password;

	/* mesajele de eroare posibile */
	var errors = ["Adresa de email lipseste. Va rugam corectati si reincercati.", 
					"Va rugam introduceti parola.", "Email sau parola invalide. Va rugam mai incercati."];

		
	document.getElementById("enterAccount").onclick = function(){submitFunction(email.value, password.value, errors)};
};

/* functie care verifica daca toate datele sunt valide si permite trimiterea lor catre server */
var submitFunction = function(email, password, errors){	
	if(missingEmail(email, errors[0]) == false && missingPassword(password, errors[1]) == false){
		invalidCredentials(email, password, errors[2]);		
	}
}

var missingEmail = function(email, emailError){		
	if(email.value === ""){		
		makeErrorVisible(emailError);
		return true;
	}else{
		return false;
	}
}

var missingPassword = function(password, passwordError){
	if(password.value === ""){		
		makeErrorVisible(passwordError);
		return true;
	}else{
		return false;
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

var invalidCredentials = function(email, password, credentialsError){	
	
	var url = createUrl('credentials');
    
    var httpRequest = ajaxRequest();

    if (!httpRequest) {    	
      	alert('Eroare: nu se poate crea o instanta XMLHTTP');
      	return false;
    }

    httpRequest.onreadystatechange = function(){
      	if (httpRequest.readyState==4){      		      		
      		if (httpRequest.status==200 || window.location.href.indexOf("http")==-1){ 
      			//alert(httpRequest.responseText);
       			var result = httpRequest.responseText;       			
       			if(result == 0){       				
       				makeErrorVisible(credentialsError);       				
       			}else{       				
       				var inputNode = document.getElementById("enterAccount");
					inputNode.type = 'submit';							
       			}
      		}else{
       			alert("A aparut o eraore in timpul procesarii cererii");
      		}
     	}
    }    
    // facem escape la caracterele care nu sunt permise intr-un url    
    email = encodeURIComponent(email);
    password = encodeURIComponent(password);
    /* adaugam un numar aleatoriu deoarece exista posibilitatea ca browserul sa faca
     	caching si nu va mai trimite inca o data datele la server, ci va returna 
    	rezultatul gasit anterior */    
    httpRequest.open('POST', url + '?_=' + Date.now(), false);    
	httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	httpRequest.send("email=" + email + "&password=" + password);    	
}

/* functie care schimba clasa paragrafului ce contine mesajul de eroare pentru a-l ascunde */
var makeErrorHidden = function(error){			
	// preluam nodul div
	var divNode = document.getElementById("errorMessage");		
	
	// schimbam clasa pargrafului
	divNode.className = 'hiddenSubmitError';	
}

/* functie care schimba clasa paragrafului ce contine mesajul de eroare pentru a fi afisat */
var makeErrorVisible = function(error){			
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