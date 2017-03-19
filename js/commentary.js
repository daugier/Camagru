var length = 0;
var nbr2 = 0;
var index = 0;
var j_add = -1;
var length_com = 0;
var j_com = 6;
function set_nbr(nbr)
{
	length = nbr;
	nbr2 = length - (3 + (index * 2));
	index++;
}
function sub_commentaire(i, j, uniq, user, text, id)
{
	if (confirm("Voulez-vous vraiment supprimer ce commentaire ??"))
    {
		var xhr = getXMLHttpRequest();
		console.log("i = "+i+" j = "+j);
		var list = document.getElementById('comentaire_photo'+i+j);
		if (list)
			list.parentNode.removeChild(list);
		xhr.open("POST", "delete_commentaire.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('user='+user+'&text='+text+'&uniq='+uniq+'&id='+id);
	}
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
	while (++i < 2 && nbr2 >= 0)
	{
		var pdc = document.getElementById('ensemble_photo'+nbr2).className = 'ensemble_photo';
		nbr2--;
	}
	if (nbr2 == -1)
		document.getElementById('plus_de_photos').className = 'shadow';

}
function plus_de_com(i, j)
{
	var l = -1;
	while (++l < 3 && j_com < j)
	{
		var pdc = document.getElementById('comentaire_photo'+i+j_com).className = 'comentaire_photo';
		j_com++;
	}
	if (j_com == j)
		document.getElementById('comentaire_photo_plus'+i).innerHTML = null;
}
function need_connect()
{
	document.getElementById('need_connect').innerHTML = "Vous devez etre connecte pour liker et commenter les photos <br><a href='#login'>Me connecter</a>";
}
function sub_img(img, nbr)
{
	if (confirm("Voulez-vous vraiment supprimer cette photo ??"))
    {
		var xhr = getXMLHttpRequest();
		xhr.open("POST", "delete_img.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('img='+img);
		var list = document.getElementById('ensemble_photo'+nbr);
		list.parentNode.removeChild(list);
	}
}
function add_comment(nbr, user)
{
	if (user != ' ' && user != '' && user)
	{
		var texte = document.getElementById('texte'+nbr).value;
		var user = document.getElementById('user'+nbr).value;
		var img = document.getElementById('img'+nbr).value;
		var id = document.getElementById('id_img'+nbr).value;
		if (texte != ' ' && texte && texte != '')
		{
			var xhr = getXMLHttpRequest();
			xhr.onreadystatechange = function()
			{
				if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					if (xhr.responseText != 'no')
					{
						var uniq = xhr.responseText;
						var new_div = document.createElement('div');
						var pdc = document.getElementById('comentaire_photo'+nbr+0);
						new_div.setAttribute('id', 'comentaire_photo'+nbr+j_add);
						new_div.setAttribute('class', 'comentaire_photo');
						list = document.getElementById('comment'+nbr);
						new_div.innerHTML = '<button type="submit" align="right" onclick="sub_commentaire( \''+nbr+'\', \''+j_add+'\', \''+uniq+'\', \''+user+'\', \''+texte+'\',\''+id+'\')">X</button><b>'+user+' :</b>'+" "+texte;
						list.insertBefore(new_div, list.firstChild);
						j_add--;
					}
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
		var like = parseInt(document.getElementById('like'+nbr).innerHTML);
		like += 1;
		document.getElementById('like'+nbr).innerHTML = like+' likes';
		var add = '1';
		var xhr = getXMLHttpRequest();
		xhr.open("POST", "stock_like.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('id='+id+'&like='+like+'&user='+user+'&user_likes='+user_likes+'&add='+add);
		var change_like = document.getElementById('likee'+nbr);
		change_like.value = 'j\'aime plus';
		change_like.setAttribute('id', 'dislikee'+nbr);
		change_like.setAttribute('class', 'dislike');
		change_like.onclick = function(){sub_like(id, nbr, user, user_likes);};
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
		var like = parseInt(document.getElementById('like'+nbr).innerHTML);
		like -= 1;
		var add = -1;
		document.getElementById('like'+nbr).innerHTML = like+' likes';
		var xhr = getXMLHttpRequest();
		xhr.open("POST", "stock_like.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('id='+id+'&like='+like+'&user='+user+'&user_likes='+user_likes+'&add='+add);
		var change_like = document.getElementById('dislikee'+nbr);
		change_like.value = 'j\'aime';
		change_like.setAttribute('id', 'likee'+nbr);
		change_like.setAttribute('class', 'like');
		change_like.onclick = function(){add_like(id, nbr, user, user_likes);};
	}
	else
	{
		window.scrollTo(0,0);
		need_connect();
	}
}