/*
Библиотека работа с файлами
 */

GlFile = function(id){

	var file;//дескриптор файла

	//конструктор
	file = document.getElementById(id).files[0];
	console.log(file);
	//конец
	//private
	//процесс считывания
	function upload(evt){
		if (evt.lengthComputable) {
			// evt.loaded and evt.total are ProgressEvent properties
			var loaded = (evt.loaded / evt.total);
			console.log(loaded);
			if (loaded < 1) {

				// Increase the prog bar length
				// style.width = (loaded * 200) + "px";
			}
		}
	}
	//считывание завершилось
	function uploadSuccess(evt){
		// Obtain the read file data
		var fileString = evt.target.result;

		console.log();

	}
	//ощибка
	function uploaderror(evt){
		console.log(evt.target.error.name);
		if(evt.target.error.name == "NotReadableError") {
			// The file could not be read
		}
	}
	//public
	this.readAsCsv = function(encoding){
		//var reader = new FileReader();
		var reader = new FileReader();

		var text = 'empty';
		console.log(file);

		reader.readAsText(file, encoding, text);

		reader.onprogress = upload;
		reader.onload = uploadSuccess;
		reader.onerror = uploaderror;

		console.log(text);

	}

}