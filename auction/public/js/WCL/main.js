'use strict';
function include(url) {
	var aj = new Ajax({
		async: false, dataType: 'text', 'url': url, success: function (code) {
			console.log(code);
			window.execScript ? execScript(code) : window.eval(code);
		}
	});
	aj.send();
}
//AJAX

var WCLAjax = function (data) {

	var _data = {
		'dataType': 'json',
		'method': 'POST',
		'url': '',
		'success': function () {
		},
		'data': {}
	};
	var _this = this;
	this.sended = false;
	if (data) {
		for (var index in data)
			_data[index] = data[index];
	}

	function getXmlHttp() {
		var xmlhttp;
		try {
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (E) {
				xmlhttp = false;
			}
		}
		if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
			xmlhttp = new XMLHttpRequest();
		}
		return xmlhttp;
	}

	var request = getXmlHttp();
	this._message = function(val, status){
		switch (_data['dataType']) {
			case 'json':
				_data['success'](JSON.parse(val));
				break;
			case 'text':
				_data['success'](val);
				break;
		}
	};
	this.success = function(val, status){
		switch (_data['dataType']) {
			case 'json':
				_data['success'](JSON.parse(val));
				break;
			case 'text':
				_data['success'](val);
				break;
		}
	};
	this.error = function(val, status){
		switch (_data['dataType']) {
			case 'json':
				_data['error'](JSON.parse(val));
				break;
			case 'text':
				_data['error'](val);
				break;
		}
	};
	//отправка из формы
	this.sendFromForm = function (data) {

	};
	//установка всех настроек
	this.setOptions = function (val) {
		for (var index in val)
			_data[index] = val[index];
	};

	//установка ностройки
	this.setOption = function (index, val) {
		_data[index] = val;
	};
	this.addData = function(index, val){
		if(typeof index == 'object' ){
			for(var i in index){
				_data['data'][i] = index[i];
			}
		}else{
			_data['data'][index] = val;
		}
	};
	//отправка данных
	this.send = function (u) {
		if (_this.sended) {
			return;
		}
		_this.preSend();//выполнение функции перед отправкой
		_this.sended = true;
		var formdata = new FormData();

		for (var value in _data) {
			switch (value) {
				case 'method':
					break;
				case 'data':
					for (var val in _data['data']) {
						if ((typeof _data['data'][val] == 'object') && !(_data['data'][val] instanceof File)) {
							for (var vals in _data['data'][val]) {
								formdata.append(val + '[' + vals + ']', _data['data'][val][vals]);
							}
						} else {
							formdata.append(val, _data['data'][val]);
						}
					}
					break;
			}
		}

		if (u) {
			request.open(_data['method'], u, true);
		} else {
			request.open(_data['method'], _data['url'], true);
		}

		request.setRequestHeader("X-Requested-With", "XMLHttpRequest");

		request.onload = function () {
			_this.sended = false;
			_this.afterSend();//выполнение функции после получение ответа
		};
		request.onerror = function(){
			console.log(request.responseText);
		};
		request.onreadystatechange = function () {
			if (request.readyState == 4) {
				if (request.status == 200) {
					_this.success(request.responseText);
				}else{
					_this.error(request.responseText);
				}
			}else if(request.readyState == 0){// начальное состояние

			}else if(request.readyState == 1){// вызван open

			}else if(request.readyState == 2){// получены заголовки

			}else if(request.readyState == 3){// загружается тело (получен очередной пакет данных)

			}
		};
		request.send(formdata);
	};

	/*this.afterSend = function () {

	};
	this.preSend = function () {

	};*/
};
/*GlsAjax.prototype = {

 }*/
WCLAjax.prototype.afterSend = function () {

};
WCLAjax.prototype.preSend = function () {

};

function WCLElement(elem) {

	var element;
	var selector, findElem;
	var index = 0;

	//конструктор
	//this.init = function(elem, name){
	//private

	function _callFunc(name){
		var arg = Array.prototype.slice.call(arguments,1);
		if(element.length){
			for(var i = 0; i < element.length; i++){
				element[i][name].apply(element[i],arg);
			}
		}else{
			element[name].apply(element,arg);
		}
	}
	function _callAttr(el, name, val){
		/*if(name.length == 1){
			el[name[0]] = val;
		}else{
			_callAttr(el[name[0]],name.splice(1), val);
		}*/
		var temp = el;
		for(var i = 0; i < name.length; i++){
			if(i == (name.length-1)){
				temp[name[i]] = val;
			}else{
				temp = temp[name[i]];
			}

		}
	}
	function _callAttribute(name,val){
		if(!val){
			return element[name];
		}else{
			if(element.length){
				var temp = null;
				for(var i = 0; i < element.length; i++){
					_callAttr(element[i], name, val);
					//element[i][name] = val;
				}
			}else{
				element[name] = val;
			}
		}
	}

	//создание элемента
	if (typeof elem == 'object') {
		element = elem;
	} else {
		element = document.querySelectorAll(elem);
		if(element.length == 1){
			element = element[0];
		}
	}
	//проверка получение элемента
	if (!element) {
		throw new Error('Element ' + elem + ' was not found');
	}

	//работа с child
	Object.defineProperty(this, "child", {
		get: function() {
			return element.childNodes;
		}
	});
	Object.defineProperty(this, "parent", {
		get: function() {
			return new WCLElement(element.parentNode);
		}
	});
	this.removeAllChild = function(){
		while (element.hasChildNodes()) {
			element.removeChild(element.firstChild);
		}
	};
	//}
	//конец
	this.getNode = function () {
		return element;
	};
	//события
	this.addEvent = function (event, func) {
		if (event == 'contextmenu') {
			//document.oncontextmenu = function(){};
			element.oncontextmenu = function (e) {
				func(e);
				return false;
			};
		} else {
			_callFunc('addEventListener', event, func);
			//element.addEventListener(event, func);
		}
	};
	this.toogleEvent = function (n) {
		if (document.createEvent) {
			var evt = document.createEvent("Event");
			evt.initEvent(n, true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
			_callFunc('dispatchEvent', evt)
			//element.dispatchEvent(evt);
		}
		else {
			var event = new Event(n, {bubbles: true, cancelable: true});
			_callFunc('dispatchEvent', evt)
		}

		//element['on'+n]();
	};
	//конец события
	//стили
	this.setStyle = function (name, val) {
		if (typeof name == 'object') {
			for (var i in name) {
				_callAttribute(['style',i],name[i]);
				//element.style[i] = name[i];
			}
		} else{
			_callAttribute(['style',name],val);
			//element.style[name] = val;
		}
	};
	this.setStyleText = function (v) {
		element.style.cssText = v;
	};
	this.getStyle = function (i) {
		var computedStyle = getComputedStyle(element);
		return computedStyle[i];
	};
	//установка значения input
	this.val = function (val) {
		if (typeof val != 'undefined')
			element.value = val;
		return element.value;
	};
	//следующий элемент массива
	this.next = function () {
		if (index != element.length) {
			return new WCLElement(element[index++]);
		}
		return false;
	};
	this.for = function (f) {
		for (var i = 0; i < element.length; i++) {
			f(i, new WCLElement(element[i]));
		}
	};
	//конец ли массива
	this.EOF = function () {
		var r = ((index == (element.length) ? true : false));
		if (r) {
			index = 0;
		}
		return r;
	};
	//размер массива
	this.size = function () {
		return element.length;
	};
	//проверка radiobox, checkbox
	this.checked = function () {
		return element.checked;
	};
	//установка html значения
	this.html = function (val) {
		if (typeof val != 'undefined') {
			element.innerHTML = val;
		}
		return element.innerHTML;
	};
	//поиск
	this.find = function (name) {
		return new WCLElement(element.querySelectorAll(name));
	};
	//конец поиск
	//работа с атрибутами
	this.getAttr = function (name) {
		return element.getAttribute(name);
	};
	this.setAttr = function (name, val) {
		if (typeof name == 'object') {
			for (var i in name) {
				element.setAttribute(i, name[i]);
			}
		} else {
			return element.setAttribute(name, val);
		}
	};
	this.removeAttr = function (v) {
		element.removeAttr(v);
	};
	//работа с классом
	this.class = function (n) {
		/*if(!v){
			return element.classList.
		}*/
		element.classList.add(n);
	};
	this.removeClass = function (v) {
		element.classList.remove(v);
	};
	this.toggleClass = function (n) {
		return element.classList.toggle(n);
	};
	//работа с дочерными элементами
	this.addChild = function (v) {
		if (typeof v == 'object') {
			element.appendChild(v.getNode());
		}
	};
	this.findChild = function (v) {
		for (var i = 0; i < element.childNodes.length; i++) {
			if (element.childNodes[i].id == v) {
				return new WCLElement(element.childNodes[i]);
			}
		}
	};
	this.deleteChild = function (v) {
		element.removeChild(v.getNode());
	};

	//работа с местоположением
	this.getX = function () {
		return element.offsetLeft;
	};
	this.getY = function () {
		return element.offsetTop;
	};
	//видимость
	this.show = function () {
		this.setStyle('display', 'block');
	};
	this.hide = function () {
		this.setStyle('display', 'none');
	};
	//this.init(elem, name);
	this.getFile = function () {
		return element.files[0];
	};
	//работа с размерами
	this.height = function () {
		return element.clientHeight;
	};
	this.width = function () {
		return element.clientWidth;
	};
	this.getSize = function () {
		return {height: element.clientHeight, width: element.clientWidth};
	};
	this.getXY = function () {
		return [element.offsetLeft, element.offsetTop];
	};
	//работа с событиями
	this.on = function (n, f) {
		element['on' + n] = f;
	}
}
WCLElement.prototype = Object.create(Element.prototype);

/*DOMElement.fn = DOMElement.prototype = {

 }*/


var includeFooter = [];

//include file
function include(file, footer) {
	if (footer) {
		includeFooter.push(file);
		return;
	}

	/*function getXmlHttp(){
	 var xmlhttp;
	 try {
	 xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	 } catch (e) {
	 try {
	 xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	 } catch (E) {
	 xmlhttp = false;
	 }
	 }
	 if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
	 xmlhttp = new XMLHttpRequest();
	 }
	 return xmlhttp;
	 }
	 var xmlhttp = getXmlHttp()
	 xmlhttp.open('GET', file, true);
	 xmlhttp.send(null);
	 if(xmlhttp.status == 200) {
	 eval(xmlhttp.responseText);
	 //alert(xmlhttp.responseText);
	 }*/

	var js = document.createElement("script");

	js.type = "text/javascript";
	js.src = file;

	document.head.appendChild(js);
	//document.head.insertBefore(js, document.head.firstChild);
}


function isBrowser(val) {
	return (navigator.userAgent.search(val) != -1);
}
/**
 *
 * @constructor
 */

var WCLMain = function () {
	var funcDomReady = [];
	var DOMContentLoaded = false;

	WCLElement.call(this, [document]);

	//событие DOMContentLoaded
	this.contentLoaded = function (func) {
		if (DOMContentLoaded) {
			func();
		} else {
			funcDomReady.push(func);
		}
		/*var oldonload = funcDomReady;
		 if (typeof funcDomReady != 'function')
		 funcDomReady = func;
		 else {
		 funcDomReady = function() {
		 oldonload();
		 func();
		 }
		 }*/
	};
	//добавление элементов
	this.addChild = function (v) {
		document.body.appendChild(v.getNode());
	};
	//добавление после загрузки
	var includefooter = function () {
		for (var i = 0; i < includeFooter.length; i++) {
			include(includeFooter[i]);
		}
	};
	this.caller = {'done':false};
	this.init = function () {
		// выходим, если функция уже выполнялась
		if (this.caller.done) return;
		//ввод разрешен для чисел


		/*var list = new WCLElement('.input_number');
		var t;
		list.for(function (index, elem) {
			elem.on('keypress', function (e) {
				var key = e.charCode | e.keyCode;
				if (key != 8 && key != 46 && key != 44)
					if (e.charCode < 48 || e.charCode > 57) {
						return false;
					}
			});
		});*/

		/*$(".datepicker").each(function (index) {
			$(this).datepicker({
				yearRange: "-115:+0",
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				dateFormat: "yy-mm-dd"
			});
		});*/


		/*Select*/
		/*list = getElement('.gls_select');

		list.for(function (i, e) {

			var div = createElement('div');
			div.setAttr('id', 'gls_select_main');
			var select = createElement('ul');
			var input = createElement('input');
			input.setAttr('id', 'gls_select');
			var _this = e;
			select.setStyle('display', 'none');
			input.setAttr('type', 'text');
			_this.removeClass('gls_select');
			select.addClass('select');
			input.addClass('select');
			input.addClass(_this.getClass());
			input.val(e.getAttr('data'));
			input.addEvent('click', function () {
				if (select.getStyle('display') == 'none') {
					select.setStyle('display', 'block');
				} else {
					select.setStyle('display', 'none');
				}
			});
			input.addEvent('keyup', function (e) {
				var char = e.target.value.charAt(0);
				for (var i = 0; i < select.child.length; i++) {
					if (char != select.child[i].innerHTML.charAt(0)) {
						select.child[i].style.display = 'none';
					} else {
						select.child[i].style.display = 'block';
					}
				}
				select.setStyle('display', 'block');
			});
			var li;
			for (var i = 0; i < _this.getPropety('options').length; i++) {
				li = createElement('li');
				li.html(_this.getPropety('options')[i].innerHTML);
				li.setAttr('data', i);
				li.addEvent('click', function (e) {
					input.val(this.innerHTML);
					_this.setPropety('selectedIndex', this.getAttribute('data'));
					select.setStyle('display', 'none');
				});
				select.addChild(li);
			}
			_this.setStyle('display', 'none');
			var label = createElement('label');
			label.setAttr('for', 'gls_select');
			label.html('&nbsp;');
			div.addChild(input);
			div.addChild(label);
			div.addChild(select);
			_this.parent.appendChild(div.getNode());
			select.setStyle('width', input.width() + 'px');
			select.setStyle('border', '1px solid #ccc');
			document.addEventListener('click', function (e) {
				var find = false;
				var par = e.target.parentNode;

				while (par) {
					if (par.id != 'gls_select_main') {
						select.setStyle('display', 'none');
						break;
					}
					par = par.parent;
				}
				*//*for(var i = 0 ; i < e.path.length; i++){
				 if(e.path[i].id == 'gls_select_main'){
				 find = true;
				 }
				 }
				 if(!find){
				 select.setStyle('display', 'none');
				 }*//*
			});
		});*/
		/*end select*/

		// устанавливаем флаг, чтобы функция не исполнялась дважды
		this.caller.done = true;

		includefooter();
		for (var i = 0; i < funcDomReady.length; i++) {
			funcDomReady[i]();
		}
		DOMContentLoaded = true;
	};

	this.height = function () {
		return window.innerHeight;
	};
	this.width = function () {
		return window.innerWidth;
	};

};

WCLMain.prototype = Object.create(WCLElement.prototype);

var WCL = new WCLMain();


if (/WebKit/i.test(navigator.userAgent)) { // условие для Safari
	var _timer = setInterval(function () {
		if (/loaded|complete/.test(document.readyState)) {
			clearInterval(_timer);
			WCL.init(); // вызываем обработчик для onload
		}
	}, 10);
} else if (document.addEventListener)
	document.addEventListener('DOMContentLoaded', GLS.init);


function createElement(name) {
	return new WCLElement(document.createElement(name));
}

/**
 *
 * @param elem
 * @returns {WCLElement}
 */
function getElement(elem) {
	return new WCLElement(elem);
}

