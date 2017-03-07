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
	document.getElementById('comment').onclick = function()
	{
		var texte = document.getElementById('texte').value;
		var user = document.getElementById('user').value;
		var img = document.getElementById('img').value;
		console.log(img);
		var xhr = getXMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && xhr.status == 200)
			{
			}
		}
		xhr.open("POST", "stock_commentary.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	    xhr.send('user='+user+'&texte='+texte+'&img='+img);
	    

	    function sleep(seconds)
		{
    		var waitUntil = new Date().getTime() + seconds*1000;
    		while(new Date().getTime() < waitUntil) true;
		}
		 /* pause le temps de la requete ajax, sinon erreur */
		if (texte)
		{
			sleep(0.3);
			var length = document.getElementById('new_comment').childNodes.length;
			if (length > 2)
			{
				var list = document.getElementById('new_comment');
				var item = list.lastElementChild;
	  			list.removeChild(item);
			}
			var list = document.getElementById('new_comment');
			var z = document.createElement('div');
			z.innerHTML = user+' : '+texte;
			list.appendChild(z);
			list.insertBefore(z, list.firstChild);
		}
	}