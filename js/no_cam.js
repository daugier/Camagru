	var startbutton2  = document.querySelector('#startbutton2');
	var photo2        = document.querySelector('#photo2');
	var superpose2 = document.getElementById('superpose2');
	var valide2 = document.getElementById('valide2');
	var source;
	var name;
	var poto = 0;
	var x = 0;
	var y = 0;
  	var size = 100;
   

	function replace_url2()
	{
		var good_img = document.getElementById('sup_img').src;
		if (size == '100')
		{
			good_img = good_img.replace("2.png", ".png");
			good_img = good_img.replace("3.png", ".png");
		}
		else if (size == '150')
		{
			good_img = good_img.replace("3.png", "2.png");
			good_img = good_img.replace(".png", "2.png");
		}
		else if (size == '250')
		{
			good_img = good_img.replace(".png", "3.png");
			good_img = good_img.replace("2.png", "3.png");
		}
		source = good_img;

	} 
	function get_size2(tail)
	{
		size = tail;
		if (tail == '100')
			document.getElementById('sup_img_2').style.width = "100px";
		else if (tail == '150')
			document.getElementById('sup_img_2').style.width = "150px";
		else if (tail == '250')
			document.getElementById('sup_img_2').style.width = "250px";
		replace_url2()
	}
	
	///////////////////////////////////////////
	function allowDrop2(ev)
	{
	   ev.preventDefault();
	}
	function drag2(ev)
	{
	    ev.dataTransfer.setData("text", ev.target.id);
	}
	function drop2(ev)
	{
	    delete_wrong2();
	    ev.preventDefault();
	    poto = ev.dataTransfer.getData("text");
	    if (poto != 'sup_img_2')
	    {
    		document.getElementById('sup_img_2').src = poto;
    		source = poto;
	    }
    	var dat  = document.getElementById(poto);
		x = event.clientX; 
		y = event.clientY;

		var scroll_x =document.body.scrollLeft || document.documentElement.scrollLeft;
		var scroll_y =document.body.scrollTop || document.documentElement.scrollTop;

		x += scroll_x;
		y += scroll_y;
	  	var x_div = document.getElementById("cheat2").offsetLeft;
	   	var y_div = document.getElementById("cheat2").offsetTop;
	   	x = x - x_div - (2/4 * size);
	   	y = y - y_div - (2/4 * size);
	   	dat.style.left = x + 'px';
	   	dat.style.top = y + 'px';
	   	var el = document.getElementById('radio');
	   	el.style.visibility = "visible";
		el.style.opacity = '1';
		replace_url2();
	}

	function get_name()
	{
		name = document.getElementById('photo_up').src;
		name = name.replace('http://localhost:8080/camagru/','');
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

	upload_photo.addEventListener('click', function()
	{
		var el = document.getElementById('up_form');
		el.style.visibility = "visible";
		el.style.opacity = '1';
	},false);

	function add_wrong()
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
		z.innerHTML = "telechargez une image";
		list.appendChild(z);
		list.insertBefore(z, list.firstChild);

	}

	function delete_wrong2()
	{
		var length = document.getElementById('wrong2').childNodes.length;
		if (length > 0)
		{
			var list = document.getElementById('wrong2');
			var item = list.firstElementChild;
	  		list.removeChild(item);

		}
	}

	valide2.addEventListener('click', function()
	{
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
			new_img.setAttribute('draggable', false);
			list.insertBefore(new_img, list.firstChild);
			photo2.setAttribute('src', "");
		}
	},false);


	function takepicture2()
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
					photo2.setAttribute('draggable', false);
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
			
			xhr.send('source='+source+'&value=0'+'&name='+name+'&x='+x+'&y='+y);
	    /* fin requete ajax */
	   	}
	}

	startbutton2.addEventListener('click', function(ev)
	{	
		get_name();
		if (name)
			name = '../'+name;
		if (source && name)
		{
			var xhr = getXMLHttpRequest();
			xhr.open("POST", "stock_photo.php", true); // true pour asynchrone
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send('source='+source+'&value=3&name='+name);
			takepicture2();
			ev.preventDefault();
		}
		else if (!name)
			add_wrong();
		else
		{
			console.log(source);
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