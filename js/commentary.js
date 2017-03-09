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
function sleep(seconds)
{
	var waitUntil = new Date().getTime() + seconds*1000;
		while(new Date().getTime() < waitUntil) true;
}
function add_comment(nbr)
{
	var texte = document.getElementById('texte'+nbr).value;
	var user = document.getElementById('user'+nbr).value;
	var img = document.getElementById('img'+nbr).value;
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
	  
	
		/* pause le temps de la requete ajax, sinon erreur */
		if (texte)
		{
			sleep(0.3);
			var length = document.getElementById('comment'+nbr).childNodes.length;
			if (length > 2)
			{
				var list = document.getElementById('comment'+nbr);
				var item = list.lastElementChild;
	  			list.removeChild(item);
			}
			var list = document.getElementById('comment'+nbr);
			var z = document.createElement('div');
			z.innerHTML = user+' : '+texte;
			list.appendChild(z);
			list.insertBefore(z, list.firstChild);
			document.getElementById('texte'+nbr).value = "";
		}
}
function add_like(id, nbr, user, user_likes)
{
	var xhr = getXMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if(xhr.readyState == 4 && xhr.status == 200)
		{
		}
	}
	xhr.open("POST", "stock_like.php", true); // true pour asynchrone
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	var like = parseInt(document.getElementById('like'+nbr).innerHTML);
	like += 1;
	var position = user_likes.indexOf(user);
	if (position <=  0)
	{
		var add = 1;
		xhr.send('id='+id+'&like='+like+'&user='+user+'&user_likes='+user_likes+'&add='+add);
		sleep(0.1);
		document.getElementById('like'+nbr).innerHTML = like;
		window.location.reload();
	}
}
function sub_like(id, nbr, user, user_likes)
{
	var xhr = getXMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if(xhr.readyState == 4 && xhr.status == 200)
		{
		}
	}
	xhr.open("POST", "stock_like.php", true); // true pour asynchrone
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	var like = parseInt(document.getElementById('like'+nbr).innerHTML);
	like -= 1;
	var position = user_likes.indexOf(user);
	if (position > 0)
	{
		var add = -1;
		xhr.send('id='+id+'&like='+like+'&user='+user+'&user_likes='+user_likes+'&add='+add);
		sleep(0.1);
		document.getElementById('like'+nbr).innerHTML = like;
		window.location.reload();
	}
}