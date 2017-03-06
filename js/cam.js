(function()
	{
	var streaming = false;
	var video  = document.querySelector('video');
	var canvas     = document.querySelector('#canvas');
	var startbutton  = document.querySelector('#startbutton');
	var width = 400;
	var height = 300;
		 
	navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;	
	function successCallback(stream)
	{
		window.stream = stream;
		video.src = window.URL.createObjectURL(stream);
	}
	function errorCallback(error)
	{
		console.log('navigator.getUserMedia error: ', error.name);
	}
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
	var hconstraints = { video: { mandatory: { minWidth: 300, minHeight: 400 }} };
	function getMedia(Constraints)
	{
		if (window.stream)
		{
		  	video.src = null;
		  	window.stream.getVideoTracks()[0].stop();
		}
		navigator.getUserMedia(Constraints, successCallback, errorCallback);
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
	function takepicture()
	{
	    canvas.width = width;
	    canvas.height = height;
	    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
	    var data = canvas.toDataURL('image/png');

		/* requete ajax*/

		var xhr = getXMLHttpRequest();
 
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && xhr.status == 200)
			{
			}
		}
		xhr.open("POST", "stock_photo.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		////////////////////////////
    	var res = data.replace('data:image/png;base64,', '');
    	while (res.indexOf(' '))
    	{
    		document.getElementById('placehere').innerHTML += '<div id="idChild"> </div>';
    		data = res.replace(' ', '+');
    	}
		////////////////////////////
	    xhr.send('data='+res);
	    /* fin requete ajax */
	}
	startbutton.addEventListener('click', function(ev)
	{
		takepicture();
		ev.preventDefault();
		document.getElementById('placehere').innerHTML += '<div id="idChild"> content  html </div>';
	}, false);
	getMedia(hconstraints);
})();