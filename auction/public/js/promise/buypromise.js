var list_promise = getElement('#list_promise');
var cat = new WCLAjax({
	'url' : '/promise/getpromisebycategory',
	'success': function(d){
		if(d){
			list_promise.removeAllChild();
			var div = null;
			for(var i = 0; i < d.length; i++){
				div = createElement('div');
				div.html('<div><div><img height="100px" src="'+d[i].url+'/'+d[i].name+'"></div><div><a href="/promise/profile/'+d[i].id+'">'+d[i].title+'</a></div><div>'+d[i].desc+'</div><div>$'+d[i].price+'</div></div>');
				list_promise.addChild(div);
			}
		}
	}
});

getElement('.li_category').addEvent('click',function(){
	cat.addData('category',this.getAttribute('data-id'));
	cat.send();
});