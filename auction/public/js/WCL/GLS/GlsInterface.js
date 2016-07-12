//private var

//public var

//construct

//private func

//public func

//таблица
var GlsTable = function(i){
	//var t = new DOMElement('#'+data);
	//t.addChild(this);
	//this.table.className = 'gltable';
	DOMElement.apply(this, ['#'+i]);
	this._table = createElement('table');
	this._selectRow = null;
	this._selectCell = null;
	this._data = [];
	this.count_row = 0;
	this._ajax = null;
	this._menu = null;
	this._header = null;
	this._footer = null;
	this._collum = [];
	this._ajaxData = {
		'start': 0,
		'count': 10
	};
	this._init_url = false;

	this._head = null;//загаловок таблицы
	this._body = null;//тело таблицы
	this._style = {
		'class': 'table responsive-table glsTable',
		'head': {
			'class' : '',
			'tr': '',
			'th': 'sorting'
		},
		'body': {
			'class' : '',
			'tr': 'odd',
			'td': 'butt-center'
		},
		'footer':{
			'class': 'glsTable_footer',
			'paginate':{
				'class': 'glsTable_paginate paging_two_button',
				'next':'btn btn-default',
				'prev':'btn btn-default'
			}
		}
	}; //стили
	this._table.setStyle('table-layout', 'fixed');
	this.loader = createElement('div');
	this.loader.addClass('glsTable_loader');
	this.loader.setStyle({
		'position': 'fixed',
		'font-size': '1.5em',
		'display': 'none'
	});
	this.loader.html('<img id="img-spinner" src="/img/load.gif" alt="Loading">');
	//getElement('#loader').addChild(this.loader);
	this.addChild(this.loader);

	this._table.addClass(this._style.class);
	this.addChild(this._table);

	//this._table.addClass(c);
	var _addEvent = this.addEvent;
	var _this = this;
	//new DOMElement('#'+i).addChild(this);
	this._table.addEvent = function(e, f){
		var func = f;
		if(e == 'contextmenu'){
			func = function(e){
				e = e || window.event;
				_this._selectRow = e.path[1].getAttribute('data');
				_this._selectCell = e.path[0].getAttribute('data');
				f(e, _this._selectRow, _this._selectCell, _this._data);
			};
	}
		_addEvent(e, func);
	}
};

GlsTable.prototype = Object.create(DOMElement.prototype);

GlsTable.prototype.deleteRow = function(tr){
	this._body.deleteChild(tr);
}
GlsTable.prototype.renderCell = function(td, data, index, row){//рендер значения
	return td;
};

GlsTable.prototype.renderRow = function(tr, data, index){
	return tr;
};

GlsTable.prototype.onSelected = function(sr, sc, d) {

};

GlsTable.prototype._loaderCenter = function(){
	var pos = getElement('#loader');
	this.loader.setStyle({
		/*'top': ((_this._table.height() + _this._head.height()) - _this.loader.height())/2 + _this.getY() +  'px',*/
		//'left':(GLS.width() - this.loader.width())/2  +  'px'
		//'top': (GLS.height() - this.loader.height())/2  +  'px'
	});

};

GlsTable.prototype.reload = function(u){
	var _this = this;
	//this._loaderCenter();
	//this.loader.show();
	if(this._init_url) {
		if (u) {
			this._ajax.setOption('url', u);
			this._ajax.send();
		} else {
			this._ajax.send();
		}
	}
};

GlsTable.prototype.setHead = function(data){//установка заголовка
	if(!this._head){
		this._head = createElement('thead');
		this._head.addClass(this._style.head.class);
		this._table.addChild(this._head);
	}
	var _this = this;
	var th = null;
	var th_menu = null;
	var tr = createElement('tr');
	th_menu = createElement('th');
	th_menu.html('<select id="gls_select_count"><option value="10">10</option><option value="20">20</option></select>');
	tr.addChild(th_menu);
	this._head.addChild(tr);
	getElement('#gls_select_count').on('change',function(){
		_this._ajaxData.count = this.value;
		_this.reload();
	});

	tr = createElement('tr');
	tr.addClass(this._style.head.tr);
	this._head.addChild(tr);

	var func = function(e){
		var sort = e.target.getAttribute('sorting');
		var data = e.target.getAttribute('data');
		for(var i in tr.child){
			if(tr.child[i].className == 'sorting_desc' || tr.child[i].className == 'sorting_asc'){
				tr.child[i].className = 'sorting';
				break;
			}
		}
		if(sort == 'asc'){
			_this._ajaxData.order = data+' asc';
			e.target.setAttribute('sorting', 'desc');
			e.target.className = 'sorting_desc';
		}else{
			_this._ajaxData.order = data+' desc';
			e.target.setAttribute('sorting', 'asc');
			e.target.className = 'sorting_asc';
		}
		_this.reload();
	};
	if(typeof data == 'array'){
		th_menu.setAttr('colspan',data.length);
		for (var val = 0; val < data.length; val++) {
			th = createElement('th');
			th.addClass(this._style.head.th);
			th.html(data[val]);
			th.setAttr('sorting', 'asc');
			th.setAttr('data', val);
			th.addEvent('click', function(e){func(e)});
			//th.setStyle('width', (data[val].length*10) + 'px');
			this._collum.push(val);
			this._head.child[0].appendChild(th.getNode());
		}
	}else {
		for (var val in data) {
			th = createElement('th');
			th.addClass(this._style.head.th);
			th.html(data[val]);
			th.setAttr('sorting', 'asc');
			th.setAttr('data', val);
			th.addEvent('click', function(e){func(e)});
			//th.setStyle('width', (data[val].length*10) + 'px');
			this._collum.push(val);
			tr.addChild(th);
		}
		th_menu.setAttr('colspan',tr.child.length);
	}
	tr.child[0].className = 'sorting_asc';
	this._head.addChild(tr);
	/*if(!this._head)
		this._table.addChild(this._head);*/
};

GlsTable.prototype.setRowHead = function(d, attr){
	if(!this._head){
		this._head = createElement('thead');
		this._head.addClass(this._style.head.class);
		this._table.addChild(this._head);
	}
	var tr = createElement('tr');
	tr.addClass(this._style.head.tr);
	this._head.addChild(tr);
	var th = null;
	for (var val = 0; val < d.length; val++) {
		th = createElement('th');
		th.addClass(this._style.head.th);
		th.html(d[val]);
		if(attr){
			for(var i in attr[val]){
				th.setAttr(i, attr[val][i]);
			}
		}
		tr.addChild(th);

	}

	this._head.addChild(tr);
	//if(!this._head)
		//this._table.addChild(this._head);
};

GlsTable.prototype.setBody = function(data){//утановка тела таблицы
	this._body = createElement('tbody');
	this._body.addClass(this._style.body.class);
	if(data)
		for(var trval in data){
			this.addRow(data[trval]);
		}
	var _this = this;
	this._table.addEvent('click', function(e){
		e = e || window.event;
		_this._selectRow = e.target.parentNode.parentNode.getAttribute('data');
		_this._selectCell = e.target.parentNode.getAttribute('data');
		_this.onSelected(_this._selectRow, _this._selectCell, _this._data);
	});
	this._table.addChild(this._body);
};

GlsTable.prototype.update = function(data){//обновление данных
	this._body.html('');
	this.setBody(data);
};


GlsTable.prototype.addRow = function(data){
	var td = null;
	var tr = null;
	this._data.push(data);
	tr = createElement('tr');
	tr.addClass(this._style.body.tr);
	tr.setAttr('data', this.count_row);
	if(this._collum){
		for (var tdval in this._collum) {
			td = createElement('td');
			td.addClass(this._style.body.td);
			td.html(data[this._collum[tdval]]);
			tr.addChild(this.renderCell(td, data[this._collum[tdval]], this._collum[tdval], data));
		}
	}else{
		for (var tdval in data) {
			td = createElement('td');
			td.addClass(this._style.body.td);
			td.html(data[tdval]);
			tr.addChild(this.renderCell(td, this._data, tdval,data));
		}
	}
	this._body.addChild(this.renderRow(tr, this._data[this.count_row], this.count_row));
	this.count_row++;
	return tr;
};
/*
 Установка стилей таблицы
 {
 'class' : '',
 'head': {
  'class' : '',
  'tr': {},
  'td: {}
 },
 'body': {
  'class' : '',
  'tr': {},
  'td: {}
 },
 }
 */
GlsTable.prototype.setStyleTable = function(d){

	for (var st in d) {
		for (var st2 in d[st]) {
			this._style[st][st2] = d[st][st2];
		}
	}

};

GlsTable.prototype.initUrl = function(u){
	this._init_url = true;
	this._ajax = new GlsAjax();
	var _this = this;
	var f = this._loaded_data;
	//this._loaderCenter();
	//this.loader.show();
	this.setBody();
	this._ajax.setOptions({
		'url' : u,
		'method' : 'post',
		'success': function(data){
			//_this.loader.hide();
			_this._loaded_data(data);
		}
	});
	this._ajax.setOption('data', this._ajaxData);
	this._ajax.send();
};
GlsTable.prototype.clear = function(){
	if(this._body)
		this._body.html('');
};

GlsTable.prototype._loaded_data = function(d){
	this._body.html('');
	if(this.show_page)
		this.show_page.html('');
	if(d.count != '0') {
		if(this.show_page) {
			this.show_page.html('Page ' + Math.ceil((this._ajaxData.start / this._ajaxData.count) + 1) + ' of ' + Math.ceil(d.count / this._ajaxData.count));
		}
		for(var i in d.data){
			this.addRow(d.data[i]);
		}
		this.count = d.count;

	}else{
		this._body.html('<td style="text-align:center;" colspan="'+this._collum.length+'">No data</div>');
		//this.setStyle('display', 'none');
	}
};

//добавление новых возможностей таблицы
GlsTable.prototype.addModule = function(n){
	var _this = this;
	switch (n){
		case 'navigate':
			this._footer = createElement('div');
			this._footer.addClass(this._style.footer.class);
			this._footer.html('<div class="glsTable_filter" id="glsTable_filter"><label>Search: <input type="text" aria-controls="glsTable" class="icon-arrow-left-4"></label></div>');
			this._footer.child[0].childNodes[0].childNodes[1].addEventListener('keypress', function(e){

				if(e.keyCode == 13){
					_this._ajaxData.find = this.value;
					_this._ajaxData.start = 0;
					_this.reload();
				}
			});
		//<div class="dataTables_info" id="datatables_info">Showing 1 to 3 of 3 entries</div>
			this.show_page = createElement('div');
			this.show_page.addClass('glsTable_info');
			this._footer.addChild(this.show_page);


			var t = createElement('div');
			t.addClass(this._style.footer.paginate.class);

			var a = createElement('a');
			a.html('<i class="icon-arrow-left-2" style="margin-right: 5px"></i>Previous');
			a.addClass(this._style.footer.paginate.prev);
			a.addEvent('click', function(){
				if(_this._ajaxData.start != 0) {
					_this._ajaxData.start -= _this._ajaxData.count;
					//_this._ajax.setOption('data', _this._ajaxData);
					_this.reload();
				}
			});
			t.addChild(a);

			a = createElement('a');
			a.addClass(this._style.footer.paginate.next);
			a.addEvent('click', function(){
				_this._ajaxData.start += _this._ajaxData.count;
				if(_this._ajaxData.start < _this.count){
					//_this._ajax.setOption('data', _this._ajaxData);
					_this.reload();
				}else{
					_this._ajaxData.start -= _this._ajaxData.count;
				}

			});
			a.html('Next<i class="icon-arrow-right-2" style="margin-left: 5px"></i>');
			t.addChild(a);
			this._footer.addChild(t);
			this.addChild(this._footer);
			break;
	}
};

GlsTable.prototype.setColumnSize = function(d){
	var c = this._head.child[this._head.child.length-1].childNodes;
	var w  = this.width();
	for(var i = 0; i < c.length; i++){
		c[i].style.width = (w * (parseInt(d[i])/100)) + 'px';
	}
};

//end таблица

GlsAjax = function(data){

	var _data = {
		'dataType' : 'json',
		'method' : 'post',
		'url':'',
		'success': function(){}
	};
	var _this = this;
	this.sended = false;
	if(data){
		for(var index in data)
			_data[index] = data[index];
	}

	function getXmlHttp(){
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

	var request = getXmlHttp();
	var success = null;
	//отправка из формы
	this.sendFromForm = function(data){

	};
	//установка всех настроек
	this.setOptions = function(val){
		for(var index in val)
			_data[index] = val[index];
	};

	//установка ностройки
	this.setOption = function(index, val){
		_data[index] = val;
	};
	//отправка данных
	this.send = function(u){
		if(_this.sended){
			return;
		}
		_this.preSend();//выполнение функции перед отправкой
		_this.sended = true;
		var formdata = new FormData();

		for(var value in _data){
			switch (value){
				case 'method':
					break;
				case 'data':
					for(var val in _data['data']){
						if((typeof _data['data'][val] == 'object') && !(_data['data'][val] instanceof File)){
							for(var vals in _data['data'][val]){
								formdata.append(val+'['+vals+']', _data['data'][val][vals]);
							}
						}else {
							formdata.append(val, _data['data'][val]);
						}
					}
					break;
			}
		}
		switch (_data['dataType']){
			case 'json':
				success = function(val){
					_data['success'](JSON.parse(val));
				};
				break;
			case 'text':
				success = function(val){
					_data['success'](val);
				};
				break;
		}
		if(u){
			request.open(_data['method'], u, true);
		}else {
			request.open(_data['method'], _data['url'], true);
		}
        request.onload = function(){
            _this.sended = false;
	          _this.afterSend();//выполнение функции после получение ответа
        };
		request.onreadystatechange = function() {

			if (request.readyState == 4) {
				if(request.status == 200) {
					success(request.responseText);
				}
			}
		};
		request.send(formdata);
	}
};
/*GlsAjax.prototype = {

 }*/
GlsAjax.prototype.afterSend=function(){

};
GlsAjax.prototype.preSend=function(){

};
var GlsTimer = function(elem){
	//private var
	var timers;
	var start, end, userFunc;
	var elem = elem;
	//public var

	//construct

	//private func
	function timerCallback(){
		start += 1000;
		var left = (end - new Date()) / 1000;
		// Number of days left
		var d = Math.floor(left / 86400);
		//updateDuo(0, 1, d);
		left -= d*86400;

		// Number of hours left
		var h = Math.floor(left / 3600);
		left -= h*3600;

		// Number of minutes left
		var m = Math.floor(left / 60);
		left -= m*60;

		// Number of seconds left
		var s = Math.floor(left);
		userFunc(d, h, m, s);
	}
	//public func
	this.setDateStart = function(val){
		start = Date.parse(val);
	};

	this.setDateEnd = function(val){
		end = Date.parse(val);
	};

	this.setFuncCallback = function(func){
		userFunc = func;
	};

	this.start = function(val){
		if(val)
			end = Date.parse(val);
		timers = setInterval(timerCallback, 1000);
	};

	this.startTimer = function(s, f){
		timers = setInterval(f, s);
	};

	this.startTimeout = function(s,f){
		setTimeout(function(){f(elem)}, s);
	}
};

function GLSWindow(){
	//construct
	DOMElement.apply(this, ['div','div']);
	var _t = this;
	_t.hide();
	GLS.addChild(_t);
	_t.addClass('window');
	var content = createElement('div');
	var close = createElement('span');
	var title = createElement('div');
	close.html('X');
	close.addEvent('click',function(){
		_t.hide();
	});
	close.addClass('close');
	title.addClass('title');
	content.addClass('content');
    content.setAttr('name','content');
	title.addChild(close);
	_t.addChild(title);
	_t.addChild(content);
	//private

	//public
	_t.addChild=function(v){
		if(typeof v == 'object'){
			content.addChild(v);
		}
	};
	_t.html=function(v){
		content.html(v);
	};
	_t.show=function(){
		_t.setStyle({'top':(GLS.height()-_t.height())/2+'px','left':(GLS.width()-_t.width())/2+'px'});
		_t.setStyle('display','block');
	};
	_t.addButtons=function(v){
		var b;
        var p = createElement('div');
        p.addClass('buttons_panel');
		for(var i in v){
			b = createElement('div');
			b.addClass('btn btn-default');
			b.addEvent('click',v[i].click);
			b.html(i);
			p.addChild(b);
		}
        _t.addChild(p);
	};
}


GLSWindow.prototype = Object.create(DOMElement.prototype);