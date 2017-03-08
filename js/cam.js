(function()
	{
	var streaming = false;
	var video  = document.querySelector('video');
	var canvas     = document.querySelector('#canvas');
	var startbutton  = document.querySelector('#startbutton');
	var width = 400;
	var height = 300;
	var name;
	var source;
		 
	
	img1.addEventListener('click', function()
	{
		source = "../img/1.png";

	},false);
	img2.addEventListener('click', function()
	{
		source = "../img/arbre.png";
	},false);
	img3.addEventListener('click', function()
	{
		source = "../img/lune.png";
	},false);
	img4.addEventListener('click', function()
	{
		source = "../img/biere.png";
	},false);
	img5.addEventListener('click', function()
	{
		source = "../img/fuck.png";
	},false);
	navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;	
	function successCallback(stream)
	{
		window.stream = stream;
		video.src = window.URL.createObjectURL(stream);
	}
	function errorCallback(error)
	{
		console.log('navigator.getUserMedia error: ', error.name);
	}
	video.addEventListener('canplay', function(ev)
	{
    	if (!streaming)
    	{
    		  height = video.videoHeight / (video.videoWidth/width);
    		  video.setAttribute('width', width);
    		  video.setAttribute('height', height);
    		  canvas.setAttribute('width', width);
    		  canvas.setAttribute('height', height);
    		  streaming = true;
    	}
  	}, false);
	var hconstraints = { video: { mandatory: { minWidth: 300, minHeight: 400 }} };
	function getMedia(Constraints)
	{
		if (window.stream)
		{
		  	video.src = null;
		  	window.stream.getVideoTracks()[0].stop();
		}
		navigator.getUserMedia(Constraints, successCallback, errorCallback);
	}
	function getXMLHttpRequest()
	{
        var xhr = null;
  
        if(window.XMLHttpRequest || window.ActiveXObject)
        {
            if(window.ActiveXObject)
            {
            	try
            	{
                    xhr = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch(e)
                {
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }
            }
            else
                xhr = new XMLHttpRequest();
        }
        else
        {
            alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
            return null;
        }
        return xhr;
	}
	function takepicture()
	{
	    canvas.width = width;
	    canvas.height = height;
	    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
	    var data = canvas.toDataURL('image/png');

		/* requete ajax*/

		var xhr = getXMLHttpRequest();
 
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && xhr.status == 200)
			{
			}
		}
		xhr.open("POST", "stock_photo.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		
		/* creation url image */
   		var uniqid = function()
   		{
			return (new Date().getTime() + Math.floor((Math.random()*10000)+1)).toString(16);
		};
   		name = '../montage/'+uniqid()+'.png';

	    xhr.send('data='+data+'&name='+name+'&source='+source);

	    /* fin requete ajax */
	}
	startbutton.addEventListener('click', function(ev)
	{	
		if (source)
		{
			takepicture();
			ev.preventDefault();
			function sleep(seconds)
			{
	    		var waitUntil = new Date().getTime() + seconds*1000;
	    		while(new Date().getTime() < waitUntil) true;
			}
			 /* pause le temps de la requete ajax, sinon erreur */

			sleep(0.4);

			/* si 10 photo sont deja afficher, j'efface la derniere */

			var length = document.getElementById('placehere').childNodes.length;
			if (length > 10)
			{
				var list = document.getElementById('placehere');
				var item = list.lastElementChild;
	  			list.removeChild(item);
			}

			/* j'ajoute la derniere photo prise */
			var length = document.getElementById('wrong').childNodes.length;
			
			if (length > 1)
			{
				var list = document.getElementById('wrong');
				var item = list.firstElementChild;
	  			list.removeChild(item);
			}
			var list = document.getElementById('placehere');
			var new_img = document.createElement("img");
			new_img.setAttribute("src", name);
			list.insertBefore(new_img, list.firstChild);
		}
		else
		{
			var length = document.getElementById('wrong').childNodes.length;
			if (length > 1)
			{
				var list = document.getElementById('wrong');
				var item = list.firstElementChild;
	  			list.removeChild(item);
			}
			var z = document.createElement('div');
			var list = document.getElementById('wrong');
			z.innerHTML = "Selectionnez d'abord une image";
			list.appendChild(z);
			list.insertBefore(z, list.firstChild);
		}
	}, false);
	getMedia(hconstraints);
})();