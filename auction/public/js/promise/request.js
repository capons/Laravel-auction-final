var btn = getElement('#btn_form');
var form = new WCLForm();
btn.addEvent('click',function(){
	form.init('.input_form');
	form.send('/promise/addrequest', function(d){
		console.log(d);
	});
});
