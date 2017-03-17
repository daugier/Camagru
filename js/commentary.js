var sub = 0;
var length = 0;
var nbr2 = 0;
var index = 0;
function set_nbr(nbr)
{
	length = nbr;
	nbr2 = length - (3 + (index * 2));
	index++;
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
function plus_de_photos(i)
{
	set_nbr(i);
	var i = -1;
	console.log('length = '+length);
	console.log('i = '+i);
	console.log('nbr2 = '+nbr2);
	while (++i < 2 && nbr2 >= 0)
	{
		var pdc = document.getElementById('ensemble_photo'+nbr2).className = 'ensemble_photo';
		nbr2--;
	}
	console.log('i = '+i+'\n\n');
	if (nbr2 == -1)
		document.getElementById('plus_de_photos').innerHTML = null;

}
function plus_de_com(nbr, img)
{
	var length2 = document.getElementById('comment'+nbr).childNodes.length;
	var text = document.getElementById('text_com'+nbr).value;
	var user = document.getElementById('user_com'+nbr).value;
	var pdc = document.getElementById('comentaire_photo_plus'+nbr);
	var j = length2 - 8;
	var i = -1;
	user = user.split(',');
	text = text.split(',');
	while (++i < 3)
	{
		if (user[j] && text[j])
		{	
			var list = document.getElementById('comment'+nbr);
			var new_div = document.createElement('div');
			new_div.setAttribute('id', 'comentaire_photo'+nbr);
			new_div.setAttribute('class', 'comentaire_photo');
			new_div.innerHTML = '<b>'+user[j]+' :</b> '+text[j];
			list.insertBefore(new_div, pdc);
			j++;
		}
	}
	if (!user[j] && !text[j])
		pdc.className = 'shadow';
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
	var list = document.getElementById('ensemble_photo'+nbr);
	list.parentNode.removeChild(list);
}
function add_comment(nbr, user)
{
	if (user != ' ' && user != '' && user)
	{
		var texte = document.getElementById('texte'+nbr).value;
		var user = document.getElementById('user'+nbr).value;
		var img = document.getElementById('img'+nbr).value;
		console.log(texte);
		console.log(user);
		if (texte)
		{
			var xhr = getXMLHttpRequest();
			xhr.onreadystatechange = function()
			{
				if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					var new_div = document.createElement('div');
					var pdc = document.getElementById('comentaire_photo'+nbr);
					new_div.setAttribute('id', 'comentaire_photo'+nbr);
					new_div.setAttribute('class', 'comentaire_photo');
					list = document.getElementById('comment'+nbr);
					new_div.innerHTML = '<b>'+user+' :</b> '+texte;
					list.insertBefore(new_div, list.firstChild);
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
function add_like(id, nbr, user, user_likes, like_ref)
{
	if (user != ' ' && user != '' && user)
	{
		var like = parseInt(document.getElementById('like'+nbr).innerHTML);
		var position = user_likes.indexOf(user);
		if (position <=  0 && like_ref == like || sub == 1)
		{
			sub = 0;
			like += 1;
			document.getElementById('like'+nbr).innerHTML = like+' likes';
			var add = 1;
			var xhr = getXMLHttpRequest();
			xhr.open("POST", "stock_like.php", true); // true pour asynchrone
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send('id='+id+'&like='+like+'&user='+user+'&user_likes='+user_likes+'&add='+add);
		}
	}
	else
	{
		window.scrollTo(0,0);
		need_connect();
	}
}
function sub_like(id, nbr, user, user_likes, like_ref)
{
	if (user != ' ' && user != '' && user)
	{
		var like = parseInt(document.getElementById('like'+nbr).innerHTML);
		var position = user_likes.indexOf(user);
		if (position > 0 && sub == 0 || like_ref < like && sub == 0)
		{
			sub = 1;
			like -= 1;
			var add = -1;
			document.getElementById('like'+nbr).innerHTML = like+' likes';
			var xhr = getXMLHttpRequest();
			xhr.open("POST", "stock_like.php", true); // true pour asynchrone
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send('id='+id+'&like='+like+'&user='+user+'&user_likes='+user_likes+'&add='+add);
		}
	}
	else
	{
		window.scrollTo(0,0);
		need_connect();
	}
}