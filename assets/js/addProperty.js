/* variabila care retine numarul de input-uri de tip button in fieldset-ul cu id-ul options */
var optionsNr = 0;
/* nr de optiuni pentru fiecare tip de camera in parte */
var optionsNumber = [];

// functie care incrementeaza valoarea unui obiect dat ca parametru
// si-l returneaza 
var increment = function (obj) {
    obj.value++;    
    return obj.value;
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
// functie care sterge un element de tip input din fieldset-ul cu id-ul 
// dat ca parametru
var  removeResource = function(id, removeButtonId)
{    
    removeInputs(id, removeButtonId);    
};
// functie care adauga un input de tip text si unul de tip button in fieldset-ul
// cu id-ul dat ca parametru
// Va crea o structura de genul:
//         <li>
//            <div>
//                <input type="text" id="resource0"/>                
//            </div>        
//            <div class="remove">
//                <input type="button" id="removeButton0"/>
//            </div>
//        </li>             
var addInputs = function (id, resource, removeButtonId, removeButton, input) {        
    // cream un element de tip li
    var li = document.createElement("li");       
    // cream doua divuri care vor contine inputul, respectiv butonul
    var div1 = document.createElement("div");
    var div2 = document.createElement("div");    
    // atasam clasa remove la al doilea div
    div2.setAttribute("class", "remove");
    // adaugam inputul si butonul in divuri
    div1.appendChild(input);
    div2.appendChild(removeButton);
    // inseram divurile in elementul li
    li.appendChild(div1);
    li.appendChild(div2);
    // preluam parintele tuturor elementelor de tip li, adica lu
    var ulParent = document.getElementById(id).getElementsByTagName('ul')[0];    
    // inseram elementul li in ul
    ulParent.appendChild(li);    
    // atasam un eveniment de tip onclick fiecarui buton creat
    // acesta va permite stergerea butonului si a inputului asociat
    document.getElementById(removeButtonId).onclick = function(){removeResource(id, removeButtonId)};
};

// functie care sterge un element de tip li din fieldsetul cu id-ul id
// elementul li contine un input de tip text si unul de tip buton al carui
// id este removeButtonId   
var removeInputs = function (id, removeButtonId) {        
    // accesam li-ul in care se afla butonul pe care tocmai am dat click
    // adica cel cu id-ul removeButtonId
    var li = document.getElementById(removeButtonId).parentNode.parentNode;        
    // preluam parintele elementulului li    
    var ulParent = document.getElementById(id).getElementsByTagName('ul')[0];
    // verificam daca numarul de copii este mai mare decat 1
    if (ulParent.children.length >= 1) {            
        // stergem li-ul
        ulParent.removeChild(li);                                  
    }
};
// functie care directioneaza utilizatorul spre pagina pageName
var previousTab = function(id, currentWizardButtonId, wizardButtonId, pageName){     
    // cream url-ul paginii
    var url = createUrl(pageName);    
    // schimbam locatia documentului(aici are loc directionarea)
    location.href = url; 
    document.getElementById(wizardButtonId).className = "walkingWizardButton";
    document.getElementById(currentWizardButtonId).className = "defaultWizardButton";
    // daca numele paginii dat ca parametru este 'details'
    if(pageName === 'details'){              
        // nu avem buton de previous pe pagina details, deci incarcam aceeasi pagina
        //document.getElementById(id).innerHTML = details;             
    }else{              
        // altfel, atasam un eveniment pentru butonul previous de pe pagina nou incarcata
        document.getElementById('previous').onclick = function(){previousTab('addPropertyForm')};   
    }
}





































/* functie care creaza un input de tip text */
var createInput = function(name, id, value){    
    var input;

    input = document.createElement("input");    

    input.setAttribute("name", name);
    input.setAttribute("id", id);
    input.setAttribute("type", "text");        
    input.setAttribute("value", value);

    return input;
};

/* functie care creaza un input de tip button */
var createButton = function(name, id, value){
    var button;

    button = document.createElement("input");
    
    button.setAttribute("name", name);
    button.setAttribute("id", id);
    button.setAttribute("type", "button");
    button.setAttribute("value", value);    

    return button;
};


var getRoomLastId = function(id){
    var liCollection, lastLiElement, lastId;
   
    liCollection = document.getElementById(id).getElementsByTagName('li');
    
    lastLiElement = liCollection[liCollection.length - 1];
    
    if(lastLiElement != null){        
        lastId = lastLiElement.children[lastLiElement.children.length - 1].getElementsByTagName('input')[0].getAttribute('id');        
        lastId = parseInt(lastId.substring(lastId.length - 1, lastId.length)) + 1;        
    }else{
        lastId = 0;
    }

    return lastId;
}

/* functie care adauga un element de tip input in fieldset-ul cu id-ul options */
var addOption = function(listItem, id) 
{
    var xButtonId, xButton, inputElement;
    
    if(optionsNumber[listItem] == undefined){
        optionsNumber[listItem] = 0;
    }
    /* cream un element de tip input si un buton care va putea sterge inputul din dreptul sau */
    xButtonId = "xButton" + listItem + optionsNumber[listItem];
    xButton = createButton("xButton", xButtonId, "x");//, "removeOption('" + id +"')");        
    inputElement = createInput("roomOption_" + listItem + "[]", "roomOption", "Optiune"+optionsNumber[listItem]);

    /* se adauga elementele la arborele dom */    
    addInputs1(listItem, id, xButtonId, xButton, inputElement);

    /* se incrementeaza numarul de optiuni pentru tipul de camera dat de listItem */
    optionsNumber[listItem]++;
    optionsNr++;        
}


var addInputs1 = function(listItem, id, xButtonId, xButton, inputElement){
    var ulParent, liElement, divArray;
    //alert("listItem = " + listItem);
    
    liElement = document.createElement("li");       
    divArray = createArrayElements("div", 1);

    /* cream o structura de genul:
         <li>
            <div>
                <input type="text" id="optionroom"/>
                <input type="button" id="xButton0"/>
            </div>        
        </li>
         <li>
            <div>
                <input type="text" id="optionroom"/>
                <input type="button" id="xButton1"/>
            </div>        
        </li>    
    */    
    divArray[0].appendChild(inputElement);
    divArray[0].appendChild(xButton);
    liElement.appendChild(divArray[0]);
        
    ulParent = document.getElementById(id).getElementsByTagName('ul')[listItem + 1];
    //am ramas la atribuirea evenimentului de stergere butonului corect, raspunzator pentru acea actiune
    // cu Doamne ajuta inainte
    //trebuie sa iau mai intai lista apoi removeRoomButton de cat e, care este idependent de numarul de itemuri li
    //alert((xButtonId));
    //document.getElementById('xButton' + (xButtonId)).onclick = function(){removeOption(listItem + 1, id, xButtonId)};
    
    ulParent.appendChild(liElement);
    //alert(ulParent.getElementsByTagName('li')[0].getElementById('removeRoomButton0'));

    /* se ataseaza cate un eveniment fiecarui buton xButtonId */
    document.getElementById(xButtonId).onclick = function(){removeOption(listItem + 1, id, xButtonId)};    
}

/* functie care sterge un element de tip input in fieldset-ul cu id-ul options */
var removeOption = function(listItem, id, xButtonId) 
{        
    
    removeInputs1(listItem, id, xButtonId);    
};

/* Functii care creaza diferite elemente de tip html */

/* functie care creaza un label, numele label-ului este dat de textNode */
var createLabel = function(forValue, textNode){    
    var label;

    label = document.createElement("label");    
        
    label.setAttribute("for", forValue);            

    label.appendChild(document.createTextNode(textNode));
    return label;
};

/* functie care creaza un input de tip number */
var createNrInput = function(name, id, min, max, step)
{
    var nrInput;
    
    nrInput = document.createElement("input");
    nrInput.setAttribute("name", name);
    nrInput.setAttribute("id", id);
    nrInput.setAttribute("type", "number");
    nrInput.setAttribute("value", min);
    
    if(min != -1){
        nrInput.setAttribute("min", min);
    }
    if(max != -1){
        nrInput.setAttribute("max", max);
    }
    if(step != -1){
        nrInput.setAttribute("step", step);
    }

    return nrInput;
}


/* functie care creaza un select cu optiuni*/
var createSelect = function(optionsArray){
    var select = document.createElement("select");
    
    for(var i = 0; i < optionsArray.length; i++){
        var option = document.createElement("option");
        option.text = optionsArray[i];    
        select.add(option);
    }
    
    return select;
};

/* functie care creaza un datalist cu id si optiuni*/
var createDataList = function(id, optionsArray){
    var datalist = document.createElement("datalist");
    datalist.setAttribute("id", id);

    var options = '';
    for(var i = 0; i < optionsArray.length; i++){
        options += '<option value="'+optionsArray[i]+'"/>';
    }
    
    datalist.innerHTML = options;        
    return datalist;
}

/* functie care creaza un fieldset cu id si legenda*/
var createFieldset = function(id, legendValue){
    var fieldset, legend;

    fieldset = document.createElement("fieldset");
    fieldset.setAttribute("id", id);

    legend = fieldset.appendChild(document.createElement("legend"));
    
    if(legendValue !== "")
    {
        legend.appendChild(document.createTextNode(legendValue));
    }

    return fieldset;
};
/* functie care creaza un array de elemente name. Exe: name = div => elemente de tip div etc*/
var createArrayElements = function(name, number){
    var elements = [];
    
    for(var i = 0; i < number; i++){
        elements.push(document.createElement(name));
    }
    
    return elements;
};
var removeInputs1 = function(listItem, id, xButtonId)
{
    var ulParent, liElement;
    
    // accesam li-ul in care se afla butonul pe care tocmai am dat click
    liElement = document.getElementById(xButtonId).parentNode.parentNode;    
    alert("liElement in removeInputs1 = " + liElement);
    // preluam parintele elementulului li    
    ulParent = liElement.parentNode;//document.getElementById(id).getElementsByTagName('ul')[listItem + 1];

//===> sa mai pun testul asta? are ceva daca se incearca stergerea unui element care nu exista?
    if(ulParent.children.length >= 1)
    {            
        ulParent.removeChild(liElement);                                  
    }
};

