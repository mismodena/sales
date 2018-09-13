
function login(){
	if( !__verified() ) return false;
	__submit('?c=login', '')
}

$(document).ready(function(){
	try{
		var p = parent.document.forms[0];
		parent.TINY.box.hide()
	}catch(e){}
})