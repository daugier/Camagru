(function()
{
	var streaming = false;
	var video  = document.querySelector('video');
	var canvas     = document.querySelector('#canvas');
	var startbutton  = document.querySelector('#startbutton');
	var width = 200;
	var height = 200;
		 
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
	function displayVideoDimensions()
	{
		dimensions.innerHTML = 'Actual video dimensions: ' + video.videoWidth +
	    'x' + video.videoHeight + 'px.';
	}	
	video.addEventListener('play', function()
	{
		setTimeout(function()
		{
			displayVideoDimensions();
		}, 500);
	});
	var hconstraints =
	{
	  	video: {
	    mandatory: {
	    minWidth: 300,
	    minHeight: 400
	    }
	  	}
	};
	function getMedia(Constraints)
	{
		if (window.stream)
		{
		  	video.src = null;
		  	window.stream.getVideoTracks()[0].stop();
		}
		navigator.getUserMedia(Constraints, successCallback, errorCallback);
	}
	hd.onclick = function()
	{
		getMedia(hconstraints);
	};
	function takepicture()
	{
	    canvas.width = width;
	    canvas.height = height;
	    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
	    var data = canvas.toDataURL('image/png');
	    photo.setAttribute('src', data);
	}
	startbutton.addEventListener('click', function(ev)
	{
		takepicture();
		ev.preventDefault();
	}, false);
})();