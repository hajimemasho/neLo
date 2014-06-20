
/** Fisierul contine functii ce adauga/sterge optiuni pentru fiecare 
camera introdusa pentru un anumit hotel
**/

// nr de optiuni pentru fiecare tip de camera in parte
var roomOptionsNumber = [];

window.onload = function () {
	document.getElementById('previous').onclick = function(){previousTab('addPropertyForm', 'button6', 'button5', 'rooms')};
}

// functie care creaza un input in care se introduce optiune si un element de tip
// buton pentru stergerea ei, adica o structura de genul:
//<li>
// <div class="remove">
//  <input name="roomOption_0[]" id="roomOption_02" type="text" placeholder="optiune2">
//  <input name="removeButton" id="removeButton02" type="button" value="x">
// </div>
//</li>
var addOption = function (listItem, id, resource, placeholder) {            
    if(roomOptionsNumber[listItem] == undefined){        
        roomOptionsNumber[listItem] = 0;
    }    
    // cream id-ul pentru butonul de remove
    var removeButtonId = "removeButton" + listItem + roomOptionsNumber[listItem];    
    // cream un element de tip input  in care se va introduce optiunea 
    var input = document.createElement("input");
    input.setAttribute("name", resource + listItem + "[]");
    input.setAttribute("id", resource + listItem + roomOptionsNumber[listItem]);
    input.setAttribute("type", "text");        
    input.setAttribute("placeholder", "optiune"+roomOptionsNumber[listItem]);    
    // cream un element de tip buton care va putea sterge inputul de mai sus           
    var removeButton = document.createElement("input");
    removeButton.setAttribute("name", "removeButton");    
    removeButton.setAttribute("id", removeButtonId);
    removeButton.setAttribute("type", "button");
    removeButton.setAttribute("value", "x");        
    // cream un element de tip li         
    li = document.createElement("li");       
    // cream un element de tip div
    div = document.createElement("div");
    div.setAttribute("class", "remove");
    // inseram inputul si buton in elementul div
    div.appendChild(input);
    div.appendChild(removeButton);
    // inseram elementul div in elementul li
    li.appendChild(div);
    // preluam ul-ul in care vrem sa inseram li-ul
    ulParent = document.getElementById(id).getElementsByTagName('ul')[listItem + 1];    
    // inseram in documentul html elmentul li
    ulParent.appendChild(li);
    // atasam cate un eveniment onclick fiecarui removeButton creat 
    // astfel incat, la apasarea lui, se va sterge optiunea din dreptul 
    // sau
    document.getElementById(removeButtonId).onclick = function(){removeOption(listItem + 1, id, removeButtonId)};    
    // se incrementeaza numarul de optiuni pentru tipul de camera dat de listItem 
    roomOptionsNumber[listItem]++;    

};
// functie care sterge elementul lista ce contine un input(optiunea )
// si butonul asociat ei
var removeOption = function (listItem, id, removeButtonId) {                
    // accesam li-ul in care se afla butonul pe care tocmai am dat click
    var li = document.getElementById(removeButtonId).parentNode.parentNode.parentNode;        
    // preluam parintele elementulului li    
    ulParent = liElement.parentNode;
    // daca are copii de tip li
    if (ulParent.children.length >= 1) {            
    	// se sterge li-ul dorit
        ulParent.removeChild(liElement);                                  
    }
};
