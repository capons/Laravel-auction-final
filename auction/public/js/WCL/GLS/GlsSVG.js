/**
 *
 * @param id
 * @param w
 * @param h
 * @returns {GlsSVG}
 */
function initSVG(id){
	var svg = new GlsSVG(id);
	//getElement('#'+id).addChild(svg);

	return svg;
}

function GlsSVG(id){

	//DOMElement.apply(this, ['', 'svg']);
	this.svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
	/*this.setAttr('width', w);
	this.setAttr('height', h);
	this.setAttr('version', '1.1');
	ths.setAttr('xmlns', 'http://www.w3.org/2000/svg');*/
	var el = document.getElementById(id);
	this.svg.setAttribute('id', '');
	this.svg.setAttribute('width', el.offsetWidth);
	this.svg.setAttribute('height', el.offsetHeight);
	this.width = el.offsetWidth;
	this.height = el.offsetHeight;
	this._x = 0;
	this._y = this.height;
	this._factor=0;
	this._shift=0;
	this._shift_y=40;
	this._point = [];
	this._points = [];
	this._size=7;
	this.init=false;
	el.appendChild(this.svg);
}
//GlsSVG.prototype = Object.create(DOMElement.prototype);
GlsSVG.prototype.line = function(x1, y1, x2, y2,attr){
	var line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
	line.setAttribute('x1', x1);
	line.setAttribute('y1', y1);
	line.setAttribute('x2', x2);
	line.setAttribute('y2', y2);
	//line.setAttribute('style', 'stroke:rgb(0,0,0);stroke-width:1');
	for(var i in attr){
		line.setAttribute(i, attr[i]);
	}
	this.svg.appendChild(line);
	return line;
};
GlsSVG.prototype.circle = function(cx, cy, r){
	var el = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
	el.setAttribute('cx', cx);
	el.setAttribute('cy', cy);
	el.setAttribute('r', r);
	el.setAttribute('style', 'stroke:rgb(0,0,0);stroke-width:1');
	this.svg.appendChild(el);
	return el;
};
GlsSVG.prototype.text = function(x,y,t,attr){
	var el = document.createElementNS('http://www.w3.org/2000/svg', 'text');
	el.setAttribute('x', x);
	el.setAttribute('y', y);
	el.innerHTML = t;
	for(var i in attr){
		el.setAttribute(i, attr[i]);
	}
	this.svg.appendChild(el);
	return el;
};
GlsSVG.prototype.path = function(d,attr){
	var el = document.createElementNS('http://www.w3.org/2000/svg', 'path');
	el.setAttribute('d', d);
	for(var i in attr){
		el.setAttribute(i, attr[i]);
	}
	this.svg.appendChild(el);
	return el;
};
GlsSVG.prototype.chart= function(data, textX, textY){
	this.innerHtml = '';
	this.text(textY.length*(-1)*10,10, textY,{'transform':'rotate(270)'});
	this.text(this.width-50,this.height, textX);
	this.line(10,0, 10,this.height);
	this.line(0,this.height-10, this.width,this.height-10);
	this.width -= 10;
	this.height -= 10;
	var size = data.data.length;
	var y_point = this.height / data.max_y;
	var x_point = this.width / size;
	var x = 0;
	var _x = 0;
	var _y = 0;
	//size /= 2;
	for(var i = 0; i < size-1; i++){
		_x = (x*x_point)+10;
		_y = this.height-(data.data[i]['y']*y_point);
		this.line(_x, _y, (++x * x_point) + 10, this.height-(data.data[i+1]['y']*y_point));
		this.line(_x, this.height+5, _x, this.height-5);
		this.circle(_x, _y, 3);
		this.text(_x + 5, _y, data.data[i]['y']);
		this.text(_x, this.height+10, data.data[i]['x']);
	}
};
GlsSVG.prototype.parsePoint = function(cand){
	var c=0;
	/*if(cand != 0)
		while (cand.toFixed(0)==0){
			cand*=10;
			c++
		}*/

	var t = String(cand).split('.');
	if(t.length>1)
		c = t[1].length;
	return c;
};
GlsSVG.prototype.candle = function(data){
	this._x = 0;
	this._y = this._y;
	if(this.height/this._size<40){
		this._size /= 40/(this.height/this._size);
	}
	chart.svg.setAttribute('class','candle');
	this._start_point = 0;
	this._text_y=[];
	this._text_x=[];
	this._digits=0;
	this.init=false;
	if(this.height && this.width){
		console.log('INIT candle');
		this.init=true;
		this._renderCandle(data, true);
	}else{
		throw new Error('Do not set the size of');
	}

};
GlsSVG.prototype._renderCell=function(start,text){
	if(text){
		this._start_y+=start;
		start = this._start_y;
		for(var i=0;i<this._text_y.length;i++) {
			this._text_y[i].innerHTML=start.toFixed(this._digits);
			start-=5/this._factor;
		}
		return;
	}
	var y=this._size*5;
	var s = this.height/y;
	this._start_y = start+((s-1)*5)/this._factor;
	start = this._start_y;
	this.path('M '+(this.width-this._shift_y-2)+' 0 v '+this.height,{'class':'line_x'});
	for(var i=0;i<s;i++){
		this.path('M 0 '+y+' h '+(this.width-this._shift_y),{'class':'line'});
		this._text_y.push(this.text(this.width-this._shift_y,y+2,start.toFixed(this._digits)));
		start-=5/this._factor;
		y+=this._size*5;
	}
	y=this._size*5;
	s = (this.width)/y;
	for(var i=0;i<s-2;i++){
		this.path('M '+y+' 0 v '+this.height,{'class':'line'});
		y+=this._size*5;
	}
};
GlsSVG.prototype._renderCandle=function(d,r){
	this._count_candle=(this.width-this._shift_y)/this._size;
	this._x=0;
	if(d && d.length && this._factor == 0){
		this._factor = 4;//this.parsePoint(d[0][1]);
		this._digits=this._factor;
		this._factor = Math.pow(10,this._factor);
		this._shift = (d[0][1]*this._factor-10);
		this._renderCell(d[0][1]-(10/this._factor));
	}
	/*if(this._points.length)
		this._points=[];*/
	for(var ii=0,c=this._point.length;ii<c;ii++){
		this.svg.removeChild(	this._point.pop());
	}
	for(var i=this._start_point,c=d.length;i<c;i++){
		this._addCandle(d[i],r);
	}
};
// [open, max, min,close]
GlsSVG.prototype.addCandle=function(d,add){
	if(d && this.init) {
		this._addCandle(d, add);
		if ((this._x + this._size) > (this.width - this._shift_y)) {
			this._start_point += 1;
			this._renderCandle(this._points, true);
			this._x -= this._size * 2;
			reload = true;
		}
	}
};
// [time, open, max, min,close]
GlsSVG.prototype._addCandle=function(d,add){
	//console.log(d);
	var dd;
	var attr = {'stroke-width':"1",'stroke':'rgb(0,0,0)'};
	var reload=false;
	var y=this._y-(this._factor * d.open-this._shift)*this._size,
		y1=(this._y-(this._factor * d.close-this._shift)*this._size),
		_x;
	//this._x = (this.size*2)*(this._point.length-this._start_point)
	attr['id']= d.time;
	dd = 'M '+this._x +' '+y;
	dd += ' L '+(this._x +this._size)+' '+y;
	dd += ' L '+(this._x +this._size)+' '+y1;
	dd += ' L '+this._x +' '+y1;
	dd += ' L '+this._x +' '+y;
	if((d[1] - d[4]) > 0){
		attr['class'] = 'bull';
		dd += ' Z M '+(this._x +(this._size/2))+' '+(this._y-(this._factor * d.high-this._shift)*this._size);
		dd += ' L '+(this._x +(this._size/2))+' '+y;
		dd += ' M '+(this._x +(this._size/2))+' '+(this._y-(this._factor * d.low-this._shift)*this._size);
		dd += ' L '+(this._x +(this._size/2))+' '+y1;
	}else{
		attr['class'] = 'bear';
		dd += ' Z M ' + (this._x + (this._size / 2)) + ' ' + (this._y-(this._factor * d.high - this._shift) * this._size);
		dd += ' L ' + (this._x + (this._size / 2)) + ' ' + y1;
		dd += ' M ' + (this._x + (this._size / 2)) + ' ' + (this._y-(this._factor * d.low - this._shift) * this._size);
		dd += ' L ' + (this._x + (this._size / 2)) + ' ' + y;
	}
	if(!add && this._points.length && d.time==this._points[this._points.length-1][0]){
		this._point[this._point.length-1].setAttribute('d',dd);
		this._point[this._point.length-1].setAttribute('class',attr['class']);
		//this._x -= this._size * 2;
	}else{
		if(this._points.length)
			this._x += this._size * 2;
		this._point.push(this.path(dd,attr));
		//if(!add)
			this._points.push(d);
	}

	if(y1<=0){
		this._shift+=5;
		this._renderCell(10/this._factor,true);
		this._renderCandle(this._points);
	}else if(y1>=this.height){
		this._shift-=5;
		this._renderCell((10/this._factor)*(-1),true);
		this._renderCandle(this._points);
	}
	//y += size/2;

};