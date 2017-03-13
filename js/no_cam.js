(function()
	{
	var startbutton2  = document.querySelector('#startbutton2');
	var photo2        = document.querySelector('#photo2');
	var superpose2 = document.getElementById('superpose2');
	var valide2 = document.getElementById('valide2');
	var name = 0;
	var source = 0;
	
	///////////////////////////////////////////

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
	///////////////////////////////////////////////
	upload_photo.addEventListener('click', function()
	{
		var el = document.getElementById('up_form');
		el.style.visibility = "visible";
		el.style.opacity = '1';
	},false);
////////////////////////////////////////////
	function add_wrong()
	{
		var z = document.createElement('div');
		var list = document.getElementById('wrong2');
		z.innerHTML = "telechargez une image";
		list.appendChild(z);
		list.insertBefore(z, list.firstChild);
	}
	function delete_wrong()
	{
		var length = document.getElementById('wrong2').childNodes.length;
		if (length > 0)
		{
			var list = document.getElementById('wrong2');
			var item = list.firstElementChild;
	  		list.removeChild(item);

		}
	}
	///////////////////////////////////////////
	img1.addEventListener('click', function()
	{
		delete_wrong();
		if (name)
		{
			source = "../img/1.png";
			superpose2.setAttribute('src', source);
		}

	},false);
	img2.addEventListener('click', function()
	{
		delete_wrong();
		if (name)
		{
			source = "../img/arbre.png";
			superpose2.setAttribute('src', source);
		}
	},false);

	img3.addEventListener('click', function()
	{
		delete_wrong();
		if (name)
		{
			source = "../img/lune.png";
			superpose2.setAttribute('src', source);
		}
	},false);

	img4.addEventListener('click', function()
	{
		delete_wrong();
		if (name)
		{
			source = "../img/biere.png";
			superpose2.setAttribute('src', source);
		}
	},false);

	/////////////////////////////////////////////

	valide2.addEventListener('click', function()
	{
		/* requete ajax*/
		 /* pause le temps de la requete ajax, sinon erreur */
		if (source && name)
		{
			var xhr = getXMLHttpRequest();
			xhr.open("POST", "stock_photo_upload.php", true); // true pour asynchrone
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			/* creation url image */
			xhr.send('source='+source+'&value=1&name='+name);
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
		}
	},false);


	//////////////////////////////////////////////////////////////////

	function takepicture()
	{
		
		if (name)
		{
			var xhr = getXMLHttpRequest();
			xhr.onreadystatechange = function()
			{
				if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					name = xhr.responseText;
					photo2.setAttribute('src', name);
					startbutton2.disabled = false;
					valide2.disabled = false;
					startbutton2.style.background = 'lightgreen';
					valide2.style.background = 'lightgreen';
				}
				else
				{
					valide2.disabled = true;
					startbutton2.disabled = true;
					startbutton2.style.background = 'red';
					valide2.style.background = 'red';
				}
			} 
			xhr.open("POST", "stock_photo_upload.php", true); // true pour asynchrone
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			var match;
			/* creation url image */
			
			xhr.send('source='+source+'&value=0'+'&name='+name);
	    /* fin requete ajax */
	   	}
	}

	////////////////////////////////////////////////////////////////////////////

	startbutton2.addEventListener('click', function(ev)
	{	
		name = document.getElementById('photo_up').src;
		name = name.replace('http://localhost:8080/camagru/','')
		if (name)
			name = '../'+name;
		if (source && name)
		{
			var xhr = getXMLHttpRequest();
			xhr.open("POST", "stock_photo.php", true); // true pour asynchrone
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send('source='+source+'&value=3&name='+name);
			takepicture();
			ev.preventDefault();
		}
		else if (!name)
			add_wrong();
		else
		{
			var length = document.getElementById('wrong2').childNodes.length;
			if (length > 0)
			{
				var list = document.getElementById('wrong2');
				var item = list.firstElementChild;
	  			list.removeChild(item);
			}
			var z = document.createElement('div');
			var list = document.getElementById('wrong2');
			z.innerHTML = "Selectionnez d'abord une image";
			list.appendChild(z);
			list.insertBefore(z, list.firstChild);
		}
	}, false);

})();