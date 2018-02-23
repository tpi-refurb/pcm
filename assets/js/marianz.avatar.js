/**
 * Generate an avatar image from letters
 */
(function (w, d) {

  function AvatarImage(letters, shape, definedcolor, size) {
	var letters = letters.substring(0, 3);
    var canvas = d.createElement('canvas');
    var context = canvas.getContext("2d");
    var size = size || 60;
	var radius = size/2;

    // Generate a random color every time function is called
    var color =  "#" + (Math.random() * 0xFFFFFF << 0).toString(16);
	
	if(definedcolor || (/^\s*$/).test(definedcolor)){
		color = definedcolor;
	}

    // Set canvas with & height
    canvas.width = size;
    canvas.height = size;

    // Select a font family to support different language characters
    // like Arial
    context.font = Math.round(canvas.width / 2) + "px Arial";
    context.textAlign = "center";
	      
    // Setup background and front color
    context.fillStyle = color;
	
	if(shape=='square'){
		context.fillRect(0, 0, canvas.width, canvas.height);
	}else{	
		context.arc(canvas.width /2, canvas.height /2 , radius, 0, 2 * Math.PI, false);
		context.fill();
	}	
    context.fillStyle = "#FFF";
    context.fillText(letters, size / 2, size / 1.5);
	
    // Set image representation in default format (png)
    dataURI = canvas.toDataURL();

    // Dispose canvas element
    canvas = null;

    return dataURI;
  }

  w.AvatarImage = AvatarImage;

})(window, document);



(function(w, d) {

  function generateAvatars() {
    var images = d.querySelectorAll('img[letters]');

    for (var i = 0, len = images.length; i < len; i++) {
      var img = images[i];
      img.src = AvatarImage(img.getAttribute('letters'),img.getAttribute('shape'), img.getAttribute('color'), img.getAttribute('width'));
      img.removeAttribute('letters');
    }
  }

  d.addEventListener('DOMContentLoaded', function (event) {
      generateAvatars();
  });

})(window, document);

/*
<img width="60" height="60" letters="PP" /> 
*/