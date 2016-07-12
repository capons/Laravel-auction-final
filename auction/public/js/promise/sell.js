(function() {
	var btn = getElement('#submit');
	var form = new WCLForm();
	btn.addEvent('click', function () {
		form.init('.input_form');
		form.setValue('type', type);
		form.send('/promise/add', function (d) {
			console.log(d);
		});
	});
	var type = 1;
	getElement('#btn_buy').addEvent('click', function () {
		type = 0;
		getElement('.auction').hide();
		getElement('.buy').show();
	});
	getElement('#btn_auction').addEvent('click', function () {
		type = 1;
		getElement('.auction').show();
		getElement('.buy').hide();
	});
})();
