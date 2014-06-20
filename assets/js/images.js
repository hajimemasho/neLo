var imagesObj = new Object();
imagesObj.value = 0;

window.onload = function () {
	document.getElementById('previous').onclick = function(){previousTab('addPropertyForm', 'button4', 'button3', 'facilities')};
	document.getElementById('addButton').onclick = function () { addImage("images", "image", imagesObj)};
}
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
	    
    var div0 = document.createElement("div");
    var div1 = document.createElement("div");
    div1.appendChild(input);    
    var div2 = document.createElement("div");
    div2.setAttribute("class", "browse");
    div2.appendChild(browseButton);
    var div3 = document.createElement("div");    
    div3.setAttribute("class", "remove");
    div3.appendChild(removeButton);

    div0.appendChild(div1);
    div0.appendChild(div2);
    div0.appendChild(div3);
    var liElement = document.createElement("li");                   
    liElement.appendChild(div0);
    var ulParent = document.getElementById(id).getElementsByTagName('ul')[0];
    ulParent.appendChild(liElement);
    
    document.getElementById(removeButtonId).onclick = function(){removeImage(id, removeButtonId)};
    increment(resourceObj);
};
