// обработчик кнопок
WCLAjax.prototype.preSend = function(){
	this.addData('_token', getElement('meta[name="csrf-token"]').getAttr('content'));
};