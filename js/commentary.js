var length = 0;
var nbr2 = 0;
var index = 0;
var j_add = -1;
var length_com = 0;
var pdf = 0;
var j_com = new Array();

function sub_commentaire(objet)
{
	var id = objet.id;
	var parent = objet.parentNode;
	var xhr = getXMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
			if (xhr.responseText == 'yes')
			{
				parent.parentNode.removeChild(parent);
			}
			else if (xhr.responseText == 'no')
			{
				window.scrollTo(0,0);
				need_connect();
			}
		}
	}
	xhr.open("POST", "delete_commentaire.php", true); // true pour asynchrone
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send('id='+id);
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


function plus_de_photos(objet)
{
	var len = objet.parentNode.childNodes.length;
	if (!pdf)
		pdf = 6;
	var i = -1;
	while (++i < 2 && pdf <= len - 2)
	{
		objet.parentNode.childNodes[pdf++].className = 'ensemble_photo';
	}
	if (pdf >= len - 2)
		document.getElementById('plus_de_photos').className = 'shadow';

}

function plus_de_com(objet)
{
	var len = objet.parentNode.parentNode.childNodes.length;
	if (!j_com[objet.id])
		j_com[objet.id] = 5;
	var l = -1;
	while (++l < 5 && j_com[objet.id] < len - 2)
	{
		objet.parentNode.parentNode.childNodes[j_com[objet.id]].className = 'comentaire_photo';
		j_com[objet.id]++;
	}
	if (j_com[objet.id] == len - 2)
	{
		objet.parentNode.parentNode.childNodes[j_com[objet.id]].innerHTML = '';
	}
}

function need_connect()
{
	document.getElementById('need_connect').innerHTML = "Vous devez etre connecte pour liker et commenter les photos <br><a href='#login'>Me connecter</a>";
}

function sub_img(objet)
{
	if (confirm("Voulez-vous vraiment supprimer cette photo ??"))
    {
    	var parent = objet.parentNode.parentNode;
    	var img = parent.childNodes[2].src;
    	img = img.split("/");
    	img = '/'+img[4]+'/'+img[5];
		img = '..'+img;
		var xhr = getXMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
			{
				if (xhr.responseText == 'yes')
				{
					parent.parentNode.removeChild(parent);
				}
			}
		}
		xhr.open("POST", "delete_img.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('img='+img);
	}
}

function add_comment(objet)
{
	var xhr = getXMLHttpRequest();
	var parent = objet.parentNode.parentNode;
	if (!parent.childNodes[1].src)
		var img = parent.childNodes[2].src;
	else
    	var img = parent.childNodes[1].src;
    img = img.split("/");
    img = '/'+img[4]+'/'+img[5];
	img = '..'+img;
	var text = objet.value;
	xhr.onreadystatechange = function()
	{
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
			if (xhr.responseText && xhr.responseText != 'no')
			{
				var res = xhr.response.split('"');
				objet.value = "";
				var new_div = document.createElement('div');
				new_div.setAttribute('id', 'commentaire_photo');
				new_div.setAttribute('class', 'comentaire_photo');
				list = objet.parentNode;
				new_div.innerHTML = '<button id='+res[3]+' type="submit" align="right" onclick="sub_commentaire(this)">X</button><b>'+res[1];
				list.insertBefore(new_div, list.childNodes[7]);
			}
			else if (xhr.responseText == 'no')
			{
				window.scrollTo(0,0);
				need_connect();
			}

		}
	}
	xhr.open("POST", "stock_commentary.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send('text='+text+'&img='+img);
}

function add_like(objet)
{
	var parent = objet.parentNode.parentNode;
	if (!parent.childNodes[1].src)
		var img = parent.childNodes[2].src;
	else
    	var img = parent.childNodes[1].src;
    img = img.split("/");
    img = '/'+img[4]+'/'+img[5];
	img = '..'+img;
	var xhr = getXMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
			if (xhr.responseText > 0)
			{
				objet.value = 'j\'aime plus';
				objet.setAttribute('id', 'dislikee');
				objet.setAttribute('class', 'dislike');
				objet.onclick = function(){sub_like(this);};
				objet.parentNode.childNodes[3].innerHTML = xhr.responseText+" Likes";
			}
			else if (xhr.responseText === 'no')
			{
				window.scrollTo(0,0);
				need_connect();
			}
		}
	}
	xhr.open("POST", "stock_like.php", true); // true pour asynchrone
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send('img='+img+'&add=1');
}

function sub_like(objet)
{
	var parent = objet.parentNode.parentNode;
	if (!parent.childNodes[1].src)
		var img = parent.childNodes[2].src;
	else
    	var img = parent.childNodes[1].src;
    img = img.split("/");
    img = '/'+img[4]+'/'+img[5];
	img = '..'+img;
	var xhr = getXMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
			if (xhr.responseText >= 0)
			{
				objet.value = 'j\'aime';
				objet.setAttribute('id', 'likee');
				objet.setAttribute('class', 'like');
				objet.onclick = function(){add_like(this);};
				objet.parentNode.childNodes[3].innerHTML = xhr.responseText+" Likes";
			}
			else if (xhr.responseText === 'no')
			{
				window.scrollTo(0,0);
				need_connect();
			}
		}
	}
	xhr.open("POST", "stock_like.php", true); // true pour asynchrone
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send('img='+img+'&add=0');
}