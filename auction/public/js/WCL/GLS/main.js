//функция определяющая производительность
function test(func){
	var time = new Date();

	func();
	time = new Date() - time;
	console.log("Время заняло: "+(time));
}

//библиотека управления DOM элементами
/*
 Получение обьекта по:
 - id
 - name
 - class
 */
/**
 *
 * @param elem
 * @param name
 * @constructor DOMElement
 */
function DOMElement(elem, name){

	var element;
	var selector, findElem;
	var index = 0;

	//конструктор
	//this.init = function(elem, name){
	//private

	//создание элемента
	if(name){
		element = document.createElement(name);
	}else{//получение элемента
		if(typeof elem == 'object'){
			element = elem;
		}else {
			selector = elem.slice(0,1);
			switch (selector) {
				case '#':
					element = document.getElementById(elem.slice(1));
					break;
				case '.':
					element = document.getElementsByClassName(elem.slice(1));

					break;
				default:
					element = document.getElementsByTagName(elem)[0];
					break;
			}
		}
		//проверка получение элемента
		if(!element){
			throw new Error('Element '+elem+' was not found');
		}
	}

	this.child = element.childNodes;
	this.parent = element.parentNode;
	//}
	//конец
	this.getNode = function(){
		return element;
	};
	this.setPropety = function(n,v){
		element[n] = v;
	};
	this.getPropety = function(n){
		return element[n];
	};
	//события
	this.addEvent = function(event, func){
		if(event == 'contextmenu'){
			//document.oncontextmenu = function(){};
			element.oncontextmenu =  function(e){func(e);return false;};
		}else {
			element.addEventListener(event, func);
		}
	};
	this.toogleEvent = function(n){
		if(document.createEvent) {
			var evt = document.createEvent("Event");
			evt.initEvent(n, true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
			element.dispatchEvent(evt);
		}
		else {
			var event = new Event(n, {bubbles : true, cancelable : true});
			element.dispatchEvent(event);
		}

		//element['on'+n]();
	};
	//конец события
	//стили
	this.setStyle = function(name, val){
		if(typeof name == 'object'){
			for(var i in name){
				element.style[i] = name[i];
			}
		}else
		if(typeof element.style[name] == 'string'){
			element.style[name] = val;
		}else{
			element.style.cssText += name+':'+val+';'
			//throw new Error('Style '+name+' not defined');
		}
	};
	this.setStyleText = function(v){
		element.style.cssText = v;
	};
	this.getStyle = function(i){
		return element.style[i];
	};
	//установка значения input
	this.val = function(val){
		if(typeof val != 'undefined')
			element.value = val;
		return element.value;
	};
	//следующий элемент массива
	this.next = function(){
		if(index != element.length){
			return new DOMElement(element[index++]);
		}
		return false;
	};
	this.for = function(f){
		for(var i = 0; i < element.length; i++){
			f(i, new DOMElement(element[i]));
		}
	};
	//конец ли массива
	this.EOF = function(){
		var r = ((index == (element.length) ? true : false));
		if(r){
			index = 0;
		}
		return r;
	};
	//размер массива
	this.size = function(){
		return element.length;
	};
	//проверка radiobox, checkbox
	this.checked = function (){
		return element.checked;
	};
	//установка html значения
	this.html = function(val){
		if(typeof val != 'undefined'){
			element.innerHTML = val;
		}
		return element.innerHTML;
	};
	//поиск
	this.find = function(name){
		selector = name.slice(0,1);
		switch (selector){
			case '#':
				//element = element.getElementById(elem.slice(1));
				break;
			case '.':
				return new DOMElement(element.getElementsByClassName(elem.slice(1))[0]);
				break;
			default:
				return new DOMElement(element.getElementsByTagName(elem)[0]);
				break;
		}
	};
	//конец поиск
	//работа с атрибутами
	this.getAttr = function(name){
		return element.getAttribute(name);
	};
	this.setAttr = function(name, val){
		if(typeof name == 'object'){
			for(var i in name){
				element.setAttribute(i, name[i]);
			}
		}else {
			return element.setAttribute(name, val);
		}
	};
	this.removeAttr = function(v){
		element.removeAttr(v);
	};
	//работа с классом
	this.addClass = function(v){
		if(element.className) {
			element.className += ' ' + v;
		}else{
			element.className = v;
		}
	};
	this.removeClass = function(v){
		element.className = element.className.replace(new RegExp(" ?"+v), '');
	};
	this.getClass = function(){
		return element.className;
	};
	//работа с дочерными элементами
	this.addChild = function(v){
		if(typeof v == 'object'){
			element.appendChild(v.getNode());
		}
	};
	this.findChild = function(v){
		for(var i = 0; i < element.childNodes.length; i ++){
			if(element.childNodes[i].id == v){
				return new DOMElement(element.childNodes[i]);
			}
		}
	};
	this.deleteChild = function(v){
		element.removeChild(v.getNode());
	}

	//работа с местоположением
	this.getX = function(){
		return element.offsetLeft;
	};
	this.getY = function(){
		return element.offsetTop;
	};
	//видимость
	this.show = function(){
		this.setStyle('display', 'block');
	};
	this.hide = function(){
		this.setStyle('display', 'none');
	};
	//this.init(elem, name);
	this.getFile = function(){
		return element.files[0];
	};
	//работа с размерами
	this.height = function(){
		return element.clientHeight;
	};
	this.width = function(){
		return element.clientWidth;
	};
	this.getSize = function(){
		return {height: element.clientHeight, width:element.clientWidth};
	};
	this.getXY = function(){
		return [element.offsetLeft, element.offsetTop];
	};
	//работа с событиями
	this.on = function(n, f){
		element['on'+n] = f;
	}
}
DOMElement.prototype = Object.create(Element.prototype);

/*DOMElement.fn = DOMElement.prototype = {

 }*/



var includeFooter = [];

//include file
function include(file, footer){
	if(footer){
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



function isBrowser(val){
	return (navigator.userAgent.search(val) != -1);
}
/**
 *
 * @constructor
 */

var GLSMain = function(){
	var funcDomReady = [];
	var DOMContentLoaded = false;

	DOMElement.call(this, [document]);

	//событие DOMContentLoaded
	this.contentLoaded = function(func){
		if(DOMContentLoaded){
			func();
		}else{
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
	this.addChild = function(v){
		document.body.appendChild(v.getNode());
	};
	//добавление после загрузки
	includefooter = function(){
		for(var i = 0; i < includeFooter.length; i++){
			include(includeFooter[i]);
		}
	};

	this.init = function(){
		// выходим, если функция уже выполнялась
		//if (arguments.callee.done) return;
		//ввод разрешен для чисел



		var list = new DOMElement('.input_number');
		var t;
		list.for(function(index, elem){
			elem.on('keypress', function(e){
				var key = e.charCode | e.keyCode;
				if(key != 8 && key != 46  && key != 44)
					if(e.charCode < 48 || e.charCode > 57){
						return false;
					}
			});
		});

		$( ".datepicker" ).each(function(index){
			$(this).datepicker({
				yearRange: "-115:+0",
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				dateFormat: "yy-mm-dd"
			});
		});



		/*Select*/
		list = getElement('.gls_select');

		list.for(function(i, e){

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
			input.addEvent('click',function(){
				if(select.getStyle('display') == 'none'){
					select.setStyle('display', 'block');
				}else{
					select.setStyle('display', 'none');
				}
			});
			input.addEvent('keyup',function(e){
				var char = e.target.value.charAt(0);
				for(var i = 0; i < select.child.length; i++) {
					if(char != select.child[i].innerHTML.charAt(0)){
						select.child[i].style.display = 'none';
					}else{
						select.child[i].style.display = 'block';
					}
				}
				select.setStyle('display', 'block');
			});
			var li;
			for(var i = 0; i < _this.getPropety('options').length; i++){
				li = createElement('li');
				li.html(_this.getPropety('options')[i].innerHTML);
				li.setAttr('data', i);
				li.addEvent('click', function(e){
					input.val(this.innerHTML);
					_this.setPropety('selectedIndex',this.getAttribute('data'));
					select.setStyle('display', 'none');
				});
				select.addChild(li);
			}
			_this.setStyle('display', 'none');
			var label = createElement('label');
			label.setAttr('for','gls_select');
			label.html('&nbsp;');
			div.addChild(input);
			div.addChild(label);
			div.addChild(select);
			_this.parent.appendChild(div.getNode());
			select.setStyle('width', input.width()+'px');
      select.setStyle('border', '1px solid #ccc');
			document.addEventListener('click',function(e){
				var find = false;
				var par = e.target.parentNode;

				while(par){
					if(par.id !=  'gls_select_main'){
						select.setStyle('display', 'none');
						break;
					}
					par = par.parent;
				}
				/*for(var i = 0 ; i < e.path.length; i++){
					if(e.path[i].id == 'gls_select_main'){
						find = true;
					}
				}
				if(!find){
					select.setStyle('display', 'none');
				}*/
			});
		});
		/*end select*/

		// устанавливаем флаг, чтобы функция не исполнялась дважды
		arguments.callee.done = true;

		includefooter();
		for(var i = 0; i < funcDomReady.length; i++){
			funcDomReady[i]();
		}
		DOMContentLoaded = true;
	};

	this.height = function(){
		return window.innerHeight;
	};
	this.width = function(){
		return window.innerWidth;
	};

};

GLSMain.prototype = Object.create(DOMElement.prototype);

var	GLS = new GLSMain();



if (/WebKit/i.test(navigator.userAgent)) { // условие для Safari
	var _timer = setInterval(function() {
		if (/loaded|complete/.test(document.readyState)) {
			clearInterval(_timer);
			GLS.init(); // вызываем обработчик для onload
		}
	}, 10);
}else if (document.addEventListener)
	document.addEventListener('DOMContentLoaded', GLS.init);



function createElement(name){
	return new DOMElement(document.createElement(name));
}

/**
 *
 * @param elem
 * @returns {DOMElement}
 */
function getElement(elem){
	return new DOMElement(elem);
	var element;
	if(typeof elem == 'object'){
		element = elem;
	}else {
		selector = elem.slice(0,1);
		switch (selector) {
			case '#':
				element = document.getElementById(elem.slice(1));
				break;
			case '.':
				element = document.getElementsByClassName(elem.slice(1));

				break;
			default:
				element = document.getElementsByTagName(elem)[0];
				break;
		}
	}
	return new DOMElement(element);
}


