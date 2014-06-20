// obiect care retine numarul de camere existente pe pagina 
var roomsObj = new Object();
roomsObj.value = 0;
window.onload = function () {
	document.getElementById('previous').onclick = function(){previousTab('addPropertyForm', 'button5', 'button4', 'images')};
	document.getElementById('addButton').onclick = function () {addRoom("rooms", "roomType", "roomPrice", roomsObj)};
}

/*
<div>
		<input name="roomType[]" id="roomType0" list="roomTypes" value="Single"/>
        <datalist id="roomTypes">
          <option value="Single">
          <option value="Double">
          <option value="Triple">
          <option value="Apartment">
        </datalist>
	</div>
	<div>									
		<input name="roomPrice[]" id="roomPrice0" type="number" value="1" min="1"/>
	</div>							
	<div class="remove">
		<input name="removeButton" id="removeButton0" type="button" value="x">
	</div>


*/
var addRoom = function (id, resource1, resource2, resourceObj) {    	
	var resourceNr = resourceObj.value;
	var removeButtonId = "removeButton" + resourceNr;
    var select = document.createElement("select");          
    select.setAttribute("name", resource1 + "[]");
    select.setAttribute("id", resource1 + resourceNr);
    var options = '';    
    options += '<option value="Single">Single</option>';
    options += '<option value="Double">Double</option>';
    options += '<option value="Triple">Triple</option>';
    options += '<option value="Apartment">Apartment</option>';        
    select.innerHTML = options;
    
    var input2 = document.createElement("input");
    input2.setAttribute("name", resource2 + "[]");       
    input2.setAttribute("id", resource2 + resourceNr);
    input2.setAttribute("type", "number");    
    input2.setAttribute("value", "10");
    input2.setAttribute("min", "10");
    input2.setAttribute("step", "10");
    
    var removeButton = document.createElement("input");
    removeButton.setAttribute("name", "removeButton");       
    removeButton.setAttribute("id", removeButtonId);
    removeButton.setAttribute("type", "button");    
    removeButton.setAttribute("value", "x");
	    
    //cream divul principal
    var div0 = document.createElement("div");
    //cream 3 divuri
    var div1 = document.createElement("div");    
    div1.appendChild(select);
    var div2 = document.createElement("div");
    div2.appendChild(input2);
    var div3 = document.createElement("div");    
    div3.setAttribute("class", "remove");
    div3.appendChild(removeButton);
        
    div0.appendChild(div1);
    div0.appendChild(div2);
	div0.appendChild(div3);

    var li = document.createElement("li");               
    li.appendChild(div0);

    var ulParent = document.getElementById(id).getElementsByTagName('ul')[0];
    ulParent.appendChild(li);
    
    document.getElementById(removeButtonId).onclick = function(){removeRoom(id, removeButtonId)};
    increment(resourceObj);
};

// functie care sterge un element de tip li in care se afla 
// butonul cu id-ul removeRoomButtonId
var removeRoom = function(id, removeRoomButtonId)
{
    removeInputs(id, removeRoomButtonId);
}