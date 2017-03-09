(function()
	{
	var streaming = false;
	var video  = document.querySelector('video');
	var canvas     = document.querySelector('#canvas');
	var startbutton  = document.querySelector('#startbutton');
	var photo        = document.querySelector('#photo');
	var superpose = document.getElementById('superpose');
	var width = 400;
	var height = 300;
	var name = 0;
	var source = 0;
	var data = 0;
	var accept = 1;
	
	///////////////////////////////////////////

	function delete_wrong()
	{
		var length = document.getElementById('wrong').childNodes.length;
		if (length > 1)
		{
			var list = document.getElementById('wrong');
			var item = list.firstElementChild;
	  		list.removeChild(item);
		}

	}

	///////////////////////////////////////////
	img1.addEventListener('click', function()
	{
		delete_wrong();
		source = "../img/1.png";
		superpose.setAttribute('src', source);

	},false);

	img2.addEventListener('click', function()
	{
		delete_wrong();
		source = "../img/arbre.png";
		superpose.setAttribute('src', source);

	},false);

	img3.addEventListener('click', function()
	{
		delete_wrong();
		source = "../img/lune.png";
		superpose.setAttribute('src', source);

	},false);

	img4.addEventListener('click', function()
	{
		delete_wrong();

		source = "../img/biere.png";
		superpose.setAttribute('src', source);

	},false);

	img5.addEventListener('click', function()
	{
		delete_wrong();
		source = "../img/fuck.png";
		superpose.setAttribute('src', source);

	},false);

///////////////////////////////////////////////////////////////////////

	function sleep(seconds)
	{
		var waitUntil = new Date().getTime() + seconds*1000;
		while(new Date().getTime() < waitUntil) true;

	}

///////////////////////////////////////////////////////////////////////

	annule.addEventListener('click', function()
	{
		var xhr = getXMLHttpRequest();
		xhr.open("POST", "stock_photo.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		/* creation url image */
		xhr.send('data='+data+'&name='+name+'&source='+source+'&value=3');
		photo.setAttribute('src', "");
		data = 0;
		accept = 1;

	},false);

/////////////////////////////////////////////////////////////////////

	valide.addEventListener('click', function()
	{
		/* requete ajax*/
		 /* pause le temps de la requete ajax, sinon erreur */
		if (data && source && name)
		{
			var xhr = getXMLHttpRequest();
			xhr.open("POST", "stock_photo.php", true); // true pour asynchrone
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			/* creation url image */
			xhr.send('data='+data+'&name='+name+'&source='+source+'&value=1');
			sleep(0.7);
			var length = document.getElementById('placehere').childNodes.length;
			if (length > 10)
			{
				var list = document.getElementById('placehere');
				var item = list.lastElementChild;
				list.removeChild(item);
			}
				/* j'ajoute la derniere photo prise */
			var list = document.getElementById('placehere');
			var new_img = document.createElement("img");
			new_img.setAttribute("src", name);
			list.insertBefore(new_img, list.firstChild);
			photo.setAttribute('src', "");
			data = 0;
			accept = 1;
		}
	},false);

//////////////////////////////////////////////////////////////

	navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;	
	
	///////////////////////////////////////////////////////////////////////

	function successCallback(stream)
	{
		window.stream = stream;
		video.src = window.URL.createObjectURL(stream);
	}
	
	///////////////////////////////////////////////////////////

	function errorCallback(error)
	{
		document.getElementById('startbutton').innerHTML = 'uploader une image';
	}

	/////////////////////////////////////////////////////////

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

	/////////////////////////////////////////////

	var hconstraints = { video: { mandatory: { minWidth: 300, minHeight: 400 }} };
	
	//////////////////////////////////////////////////////////

	function getMedia(Constraints)
	{
		if (window.stream)
		{
		  	video.src = null;
		  	window.stream.getVideoTracks()[0].stop();
		}
		navigator.getUserMedia(Constraints, successCallback, errorCallback);
	}

	///////////////////////////////////////////////////////////////////////

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

	//////////////////////////////////////////////////////////////////

	function takepicture()
	{
		canvas.getContext('2d').drawImage(video, 0, 0, width, height);
		data = canvas.toDataURL('image/png');
		var xhr = getXMLHttpRequest();
		xhr.open("POST", "stock_photo.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		
		/* creation url image */
	   	var uniqid = function()
	   	{
			return (new Date().getTime() + Math.floor((Math.random()*10000)+1)).toString(16);
		};
	   	name = '../montage/'+uniqid()+'.png';
		xhr.send('data='+data+'&name='+name+'&source='+source+'&value=0');
		sleep(0.4);
		photo.setAttribute('src', name);

	    /* fin requete ajax */
	}

	////////////////////////////////////////////////////////////////////////////

	startbutton.addEventListener('click', function(ev)
	{	
		if (source && accept != 0)
		{
			takepicture();
			accept = 0;
			ev.preventDefault();
		}
		else if (!source)
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