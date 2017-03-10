(function()
	{
	var startbutton2  = document.querySelector('#startbutton2');
	var photo        = document.querySelector('#photo');
	var superpose = document.getElementById('superpose');
	var valide2 = document.getElementById('valide2');
	var name = 0;
	var data = 0;
	var source = 0;
	
	///////////////////////////////////////////
	function sleep(seconds){
    var waitUntil = new Date().getTime() + seconds*1000;
    while(new Date().getTime() < waitUntil) true;
	}
/////////////////////////////////////////////////////////////////////////////////

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
	/////////////////////////////////////////////

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
		}
	},false);


	//////////////////////////////////////////////////////////////////

	function takepicture()
	{
		var xhr = getXMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
			{
				photo.setAttribute('src', name);
				startbutton2.disabled = false;
				valide.disabled = false;
				startbutton2.style.background = 'lightgreen';
				valide.style.background = 'lightgreen';
			}
			else
			{
				valide.disabled = true;
				startbutton2.disabled = true;
				startbutton2.style.background = 'red';
				valide.style.background = 'red';
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
		xhr.send('data='+data+'&name='+name+'&source='+source+'&value=0');
	    /* fin requete ajax */
	}

	////////////////////////////////////////////////////////////////////////////

	startbutton2.addEventListener('click', function(ev)
	{	
		console.log(source);
		if (source)
		{
			var xhr = getXMLHttpRequest();
			xhr.open("POST", "stock_photo.php", true); // true pour asynchrone
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send('data='+data+'&name='+name+'&source='+source+'&value=3');
			takepicture();
			ev.preventDefault();
		}
		else if (!source)
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