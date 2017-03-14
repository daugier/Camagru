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
function moins_de_com(nbr, img)
{
	var pdc = document.getElementById('comentaire_photo'+nbr);
	pdc.innerHTML = '<a onclick="plus_de_com('+nbr+', '+img+')">plus de commentaires</a>';
	window.location.reload();
}
function plus_de_com(nbr, img)
{
	function insertAfter(newNode, referenceNode)
	{
    	referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
	}
	var length = document.getElementById('comment'+nbr).childNodes.length;
	var text = document.getElementById('text_com'+nbr).value;
	var user = document.getElementById('user_com'+nbr).value;
	var pdc = document.getElementById('comentaire_photo'+nbr);
	var j = length - 8;
	var i = -1;
	user = user.split(',');
	text = text.split(',');
	while (++i < 3)
	{
		if (user[j] && text[j])
		{	
			var list = document.getElementById('comment'+nbr);
			var new_div = document.createElement('div');
			new_div.setAttribute('id', 'comentaire_photo');
			new_div.innerHTML = '<b>'+user[j]+' :</b> '+text[j];
			list.insertBefore(new_div, pdc);
			j++;
		}
		else
		{
			pdc.innerHTML = '<a onclick="moins_de_com('+nbr+', \' '+img+'\')">moins de commentaires</a>';
		}
	}
}
function need_connect()
{
	document.getElementById('need_connect').innerHTML = "Vous devez etre connecte pour liker et commenter les photos <br><a href='#login'>Me connecter</a>";
}
function sub_img(img, nbr)
{
	var xhr = getXMLHttpRequest();
	xhr.open("POST", "delete_img.php", true); // true pour asynchrone
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send('img='+img);
	window.location.reload();
}
function add_comment(nbr, user)
{
	if (user != ' ' && user != '' && user)
	{
		var texte = document.getElementById('texte'+nbr).value;
		var user = document.getElementById('user'+nbr).value;
		var img = document.getElementById('img'+nbr).value;
		if (texte)
		{
			var xhr = getXMLHttpRequest();
			xhr.onreadystatechange = function()
			{
				if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					window.location.reload();
				}
			}
			xhr.open("POST", "stock_commentary.php", true); // true pour asynchrone
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send('user='+user+'&texte='+texte+'&img='+img);
			document.getElementById('texte'+nbr).value = "";
		}
	}
	else
	{
		window.scrollTo(0,0);
		need_connect();
	}
}
function add_like(id, nbr, user, user_likes)
{
	if (user != ' ' && user != '' && user)
	{
		var xhr = getXMLHttpRequest();
		xhr.open("POST", "stock_like.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var like = parseInt(document.getElementById('like'+nbr).innerHTML);
		like += 1;
		var position = user_likes.indexOf(user);
		if (position <=  0)
		{
			var add = 1;
			xhr.send('id='+id+'&like='+like+'&user='+user+'&user_likes='+user_likes+'&add='+add);
			window.location.reload();
		}
	}
	else
	{
		window.scrollTo(0,0);
		need_connect();
	}
}
function sub_like(id, nbr, user, user_likes)
{
	if (user != ' ' && user != '' && user)
	{
		var xhr = getXMLHttpRequest();
		xhr.open("POST", "stock_like.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var like = parseInt(document.getElementById('like'+nbr).innerHTML);
		like -= 1;
		var position = user_likes.indexOf(user);
		if (position > 0)
		{
			var add = -1;
			xhr.send('id='+id+'&like='+like+'&user='+user+'&user_likes='+user_likes+'&add='+add);
			window.location.reload();
		}
	}
	else
	{
		window.scrollTo(0,0);
		need_connect();
	}
}