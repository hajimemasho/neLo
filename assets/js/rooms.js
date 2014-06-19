// obiect care retine numarul de camere existente pe pagina 
var roomsObj = new Object();
roomsObj.value = 0;
window.onload = function () {
	document.getElementById('previous').onclick = function(){previousTab('addPropertyForm', 'button5', 'button4', 'images')};
	document.getElementById('addButton').onclick = function () {addRoom("rooms", "roomType", "roomPrice", roomsObj)};
	document.getElementById('next').onclick = function (){
		document.getElementById("button5").className = "defaultWizardButton";
		document.getElementById("button6").className = "walkingWizardButton";
	}
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
	var input1 = document.createElement("input");	
    input1.setAttribute("name", resource1 + "[]");       
    input1.setAttribute("id", resource1 + resourceNr);
    input1.setAttribute("type", "text");
    input1.setAttribute("list", resource1 + "s");
    input1.setAttribute("value", "Single");

    var datalist = document.createElement("datalist");    
    input1.setAttribute("id", resource1 + "s");
    var options = '';    
    options += '<option value="Single"/>';
    options += '<option value="Double"/>';
    options += '<option value="Triple"/>';
    options += '<option value="Apartment"/>';        
    datalist.innerHTML = options;
    
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
	    

    var div1 = document.createElement("div");
    div1.appendChild(input1);
    div1.appendChild(datalist);
    var div2 = document.createElement("div");
    div2.appendChild(input2);
    var div3 = document.createElement("div");    
    div3.setAttribute("class", "remove");
    div3.appendChild(removeButton);

   
    var liElement = document.createElement("li");               
    liElement.appendChild(div1);
    liElement.appendChild(div2);
	liElement.appendChild(div3);

    var ulParent = document.getElementById(id).getElementsByTagName('ul')[0];
    ulParent.appendChild(liElement);
    
    document.getElementById(removeButtonId).onclick = function(){removeRoom(id, removeButtonId)};
    increment(resourceObj);
};

/* functie care sterge un element de tip li in care se afla butonul cu id-ul removeRoomButtonId */
var removeRoom = function(id, removeRoomButtonId)
{
    removeInputs(id, removeRoomButtonId);
}