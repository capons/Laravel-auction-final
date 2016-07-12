var cat = getElement('.select-category');

function list(data){
	var div;
	var cont = getElement('#list_promise');
	cont.removeAllChild();
	for(var i in data){
		div = createElement('div');
		div.html('<div><a href="/promise/profile/'+data[i].id+'"><img height="100px" width="100px" src="'+data[i].url+'/'+data[i].name+'"></a></div><div class="title">'+data[i].title+'</div><div class="desc">'+data[i].desc+'</div><div class="price">$'+data[i].price+'</div>');
		cont.addChild(div);
	}
}

var aj = new WCLAjax({
	'url': '/promise/getdata',
	'success': function(d){
		if(d.data){
			list(d.data);
		}
	},
	'data':{
		'type':1,
		'value':0
	}
});
aj.send();
cat.addEvent('click',function(){
	aj.addData({'value': this.getAttribute('data-id')});
	aj.send();
});