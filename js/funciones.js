window.addEventListener('load', init);

function init(){
	// Declaracion de variables
	var video = document.querySelector('#video'),
	canvas = document.querySelector('#canvas'),
	btn = document.querySelector('#camara'),
	img = document.querySelector('#imagen');

	// Funcion que nos permite acceder a la camara
	navigator.getUserMedia = (
		navigator.getUserMedia ||       // standard
		navigator.webkitGetUserMedia || // chrome
		navigator.mozGetUserMedia ||    // mozilla
		navigator.msGetUserMedia        // internet explorer
	);

	//Validación de que encontro el user media
	if(navigator.getUserMedia){
		// Reproducir lo que vea la camara en el video.
		navigator.getUserMedia({video:true},function(stream){
			video.src = window.URL.createObjectURL(stream);  // Lee la camara.
			video.play();  // Reproduce el video.
		},function(e){console.log(e);})
	}
	else{
		alert('Tu navegador no acepta las opciones de video de html5.');
	}

	video.addEventListener('loadedmetadata',function(){
			canvas.width = video.videoWidth; canvas.height = video.videoHeight;
		}, false);
		btn.addEventListener('click',function(){
		canvas.getContext('2d').drawImage(video,0,0);
		var imgData = canvas.toDataURL('image/png');
		img.setAttribute('src',imgData);
	});
}


(function(){

function filevista(input){

	if (input.files && input.files[0]) {

		var reader = new  FileReader();

		reader.onload = function(e){

			$('#imagenprevia').html("<img src='"+e.target.result+"'>");
		}

		reader.readAsDataURL(input.files[0]);

	} 
}

$('#imagen').change(function(){

	filevista(this);

});

})();