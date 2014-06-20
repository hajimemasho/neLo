//* obiect care retine numarul de input-uri de tip button in 
// fieldset-ul cu id-ul otherFacilities
var facilitiesObj = new Object();
facilitiesObj.value = 0;

window.onload = function () {
	document.getElementById('previous').onclick = function(){previousTab('addPropertyForm', 'button3', 'button2', 'characteristics')};
	document.getElementById('addButton').onclick = function () { addFacility("facilities", "facility", facilitiesObj, "Facilitate")};
}
// functie care adauga un nou input pentru introducerea unei facilitati
var addFacility = function (id, resource, resourceObj, placeholder) {     
    // se preia valoarea obiectului
    var resourceNr = resourceObj.value;
    // se creaza noul id pentru butonul de remove
    var removeButtonId = "removeButton" + resourceNr;
    // se creaza butonul de remove
    var removeButton = document.createElement("input");
    // se creaza un input
    var input = document.createElement('input');    
    // butonul de remove va avea un id unic(ex, "removeButton0") si 
    // va afisa "x"
    removeButton.setAttribute("name", "removeButton");
    removeButton.setAttribute("id", removeButtonId);
    removeButton.setAttribute("type", "button");
    removeButton.setAttribute("value", "x");    
    // inputul va avea un id unic(ex, "facilitate0") iar in placeholder
    // va afisa numarul de facilitati care s-au creat
    input.setAttribute("name", resource + "[]");
    input.setAttribute("id", resource + resourceNr);
    input.setAttribute("type", "text");        
    input.setAttribute("placeholder", placeholder + resourceNr);
    // elementele se dau ca parametri unei functii care le va introduce 
    // intr-un element de tip li si le va insera in documentul html 
    // via DOM
    addInputs(id, resource, removeButtonId, removeButton, input);        
    increment(resourceObj);
}