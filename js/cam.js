(function()
	{
	var streaming = false;
	var video  = document.querySelector('video');
	var canvas     = document.querySelector('#canvas');
	var startbutton  = document.querySelector('#startbutton');
	var width = 400;
	var height = 300;
	var url_photo = 0;
		 
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
	function takepicture()
	{
	    canvas.width = width;
	    canvas.height = height;
	    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
	    var data = canvas.toDataURL('image/png');
	    photo.setAttribute('src', data);
	    /*ajax = new XMLHttpRequest();
	    ajax.open("POST",'stock_photo.php?data='+data, true);
	    ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	    ajax.send(data);
	    redirect();*/
	}
	startbutton.addEventListener('click', function(ev)
	{
		takepicture();
		ev.preventDefault();
	}, false);
	getMedia(hconstraints);
})();