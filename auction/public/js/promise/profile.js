var _href = location.href.split('/');
var aj = new WCLAjax({
	'url':'/promise/buy',
	'data': {
		'id': _href[_href.length-1]
	},
	'success':function(d){
		console.log(d);
		if(d.price){
			getElement('.price').html('$'+d.price);
		}
		ajCheck.send();
	},
	'error': function(d){
		console.log(d);
	}
});
var ajCheck = new WCLAjax({
	'url':'/promise/check',
	'data': {
		'id': _href[_href.length-1]
	},
	'success':function(d){
		check(d.check);
	}
});
var btn = getElement('#btn_buy');
btn.addEvent('click',function(){
	aj.addData('amount', getElement('#amount').val());
	aj.send();
});


function check(d){
	if(getElement('#amount').getStyle('display') == 'none') return;
	if(d){
		btn.class('bid');
		btn.removeClass('out');
	}else{
		btn.class('out');
		btn.removeClass('bid');
	}
}
setInterval(function(){
	ajCheck.send();
}, 100000);

ajCheck.send();