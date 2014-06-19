var imagesObj = new Object();
imagesObj.value = 0;

window.onload = function () {
	document.getElementById('previous').onclick = function(){previousTab('addPropertyForm', 'button4', 'button3', 'facilities')};
	document.getElementById('addButton').onclick = function () { addImage("images", "image", imagesObj)};
	document.getElementById('next').onclick = function (){
		document.getElementById("button4").className = "defaultWizardButton";
		document.getElementById("button5").className = "walkingWizardButton";
	}
}




/*
<div>	
	<input name="image[]" id="image0" placeholder="Imagine"/>								            
</div>	
<div class="browse">
	<input name="browseButton" id="browseButton0" type="button" value="Cauta"/>
</div>								 	
<div class="remove">
	<input name="removeButton" id="removeButton0" type="button" value="x">
</div>*/

//
var addImage = function (id, resource, resourceObj) {    	
	var resourceNr = resourceObj.value;
	var removeButtonId = "removeButton" + resourceNr;
	var browseButtonId = "browseButton" + resourceNr;
	
	var input = document.createElement("input");	
    input.setAttribute("name", resource + "[]");       
    input.setAttribute("id", resource + resourceNr);
    input.setAttribute("type", "text");    
    input.setAttribute("placeholder", "Imagine" + resourceNr);
 
 	var browseButton = document.createElement("input");
 	browseButton.setAttribute("name", "browseButton");       
    browseButton.setAttribute("id", browseButtonId);
    browseButton.setAttribute("type", "button");    
    browseButton.setAttribute("value", "Cauta");
	
    var removeButton = document.createElement("input");
    removeButton.setAttribute("name", "removeButton");       
    removeButton.setAttribute("id", removeButtonId);
    removeButton.setAttribute("type", "button");    
    removeButton.setAttribute("value", "x");
	    

    var div1 = document.createElement("div");
    div1.appendChild(input);    
    var div2 = document.createElement("div");
    div2.setAttribute("class", "browse");
    div2.appendChild(browseButton);
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
