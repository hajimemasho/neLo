/**
	-- script cu functii ce sunt folosite in mai multe scripturi -- 
**/

// functie care returneaza un obiect prin care se pot face cereri http
var ajaxRequest = function(){
  	// verificam existenta obiectului XMLHttpRequest
    if (window.XMLHttpRequest) {
    	// exista suport nativ
        return new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
    	// se foloseste obiectul ActiveX
        return new ActiveXObject("Msxml2.XMLHTTP");
    }
    else {
         return false;
    }
}
// functie care creaza un url pornind de la calea curenta si 
// adaugand un segment dat ca parametru
var createUrl = function (segment) {	
    // localhost sau alt host
    var base_url = window.location.origin;
    // calea pana la documentul curent
    var pathName = window.location.pathname;            
    // construim url-ul prin care se va verifica credentialele
    var url = base_url + pathName.substring(0, pathName.lastIndexOf('/')) + '/' + segment;        
    return url;
}
// functie care verifica daca un anumit input contine caractere
var filledField = function (field, error) {		
	if(field === ""){			
		// insereaza mesajul de eroare in documentul html via DOM		
		makeSubmitErrorVisible(error);						
		return false;
	}else{		
		return true;
	}
}
// functie care schimba clasa divului, ce contine mesajul de eroare, 
// pentru a-l ascunde 
var makeSubmitErrorHidden = function () {			
	// preluam nodul div
	var divNode = document.getElementById("error");			
	// schimbam clasa divului 
	divNode.className = 'hiddenSubmitError';	
}
// functie care schimba clasa paragrafului ce contine mesajul de eroare 
// pentru a fi afisat
var makeSubmitErrorVisible = function (error) {				
	// preluam div-ul in care se gaseste mesajul de eroare
	var divNode = document.getElementById("errorMessage");					
	// luam nodul span in care vom insera mesajul de eroare
	spanNode = divNode.getElementsByTagName('span')[0];	
	// cream nodul de tip text
	var newTextNode = document.createTextNode(error);
	// inseram in span mesajul de eroare
	spanNode.replaceChild(newTextNode, spanNode.childNodes[0]);		
	// modificam clasa acestuia pentru ca mesajul sa fie afisat
	divNode.parentNode.className = 'visibleSubmitError';			
}
