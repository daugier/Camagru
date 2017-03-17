	var streaming = false;
	var video  = document.querySelector('video');
	var canvas     = document.querySelector('#canvas');
	var startbutton  = document.querySelector('#startbutton');
	var photo        = document.querySelector('#photo');
	var superpose = document.getElementById('superpose');
	var valide = document.getElementById('valide');
	var contain = document.getElementById('container');
	var no_cam = document.getElementById('pas_de_cam');
	var width = 400;
	var height = 300;
	var name = 0;
	var source = 0;
	var data = 0;
	var poto = 0;
	var x = 0;
	var y = 0;
   
	
	///////////////////////////////////////////
	function allowDrop(ev)
	{
	   ev.preventDefault();
	}
	function drag(ev)
	{
	    ev.dataTransfer.setData("text", ev.target.id);
	}
	function drop(ev)
	{
	    ev.preventDefault();
	    poto = ev.dataTransfer.getData("text");
	    if (poto != 'sup_img')
	    {
    		document.getElementById('sup_img').src = poto;
    		source = poto;
	    }
	    delete_wrong();
    	var dat  = document.getElementById(poto);
    	x = event.clientX; 
		y = event.clientY;

		var scroll_x =document.body.scrollLeft || document.documentElement.scrollLeft;
		var scroll_y =document.body.scrollTop || document.documentElement.scrollTop;

		x += scroll_x;
		y += scroll_y;
	  	var x_div = document.getElementById("cheat").offsetLeft;
	   	var y_div = document.getElementById("cheat").offsetTop;
	   	x = x - x_div - 50;
	   	y = y - y_div - 50;
	   	dat.style.left = x + 'px';
	   	dat.style.top = y + 'px';
	   	
	}
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
			var length = document.getElementById('placehere').childNodes.length;
			if (length > 4)
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
			window.scrollTo(0,425);
		}
	},false);

//////////////////////////////////////////////////////////////

	navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;	
	
	///////////////////////////////////////////////////////////////////////

	function successCallback(stream)
	{
		window.stream = stream;
		contain.style.display = 'display';
		no_cam.style.display = "none";
		video.src = window.URL.createObjectURL(stream);
	}
	
	///////////////////////////////////////////////////////////

	function errorCallback(error)
	{
		console.log("pas d'acces a votre camera");
		contain.style.display = "none";
		no_cam.style.display = "display";
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
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
			{
				name = xhr.responseText;
				photo.setAttribute('src', name);
				startbutton.disabled = false;
				valide.disabled = false;
				startbutton.style.background = 'lightgreen';
				valide.style.background = 'lightgreen';
			}
			else
			{
				valide.disabled = true;
				startbutton.disabled = true;
				startbutton.style.background = 'red';
				valide.style.background = 'red';
			}
		} 
		xhr.open("POST", "stock_photo.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		
		/* creation url image */
		xhr.send('data='+data+'&source='+source+'&value=0&name=1&x='+x+'&y='+y);
		data  = 1;
	    /* fin requete ajax */
	}

	////////////////////////////////////////////////////////////////////////////

	startbutton.addEventListener('click', function(ev)
	{	
		if (source)
		{
			if (data == 1)
			{
				var xhr = getXMLHttpRequest();
				xhr.open("POST", "stock_photo.php", true); // true pour asynchrone
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send('data='+data+'&source='+source+'&value=3&name='+name);
			}
			takepicture();
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