//private var

//public var

//construct

//end construct
//private function

//public function
var GlsForm = function(){
	//private var
	var data_input = {};
	var aj = new GlsAjax();
	var list;
	//public var

	//construct

	//end construct
	//private function

	//public function
	this.init = function(name){
		list = new DOMElement('.'+name);
		var temp;
		data_input = {};
		while(!list.EOF()){
			temp = list.next();
			if(temp.getAttr('type') == 'file'){
				data_input[temp.getAttr('name')] = temp.getFile();
			}else {
				data_input[temp.getAttr('name')] = temp.val();
			}
		}
		aj.setOption('data', data_input);
	};
	//ручная установка занчения
	this.setValue = function(n, v){
		data_input[n] = v;
	};
	//сброс значений
	this.reset = function(){
		while(!list.EOF()){
			temp = list.next();
			temp.val('');
		}
	};

	this.send = function(url, success){
		if(!success){
			success = function(){};
		}
		aj.setOptions({
			'url': url,
			'success': success
		});
		aj.send();
	}

	this.validate = function(f){
		for(var i in data_input){
			f(i,data_input[i]);
		}
	}
};