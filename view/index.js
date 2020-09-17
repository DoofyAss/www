'use strict'


/*setInterval(() => {

	let s = all('size[byte]');
	if (s.length) s.each(e => {

		e.innerHTML = size(e.innerHTML);
		e.removeAttribute('byte');
	});

}, 500);



function disable() {

	Array.from(document.querySelectorAll('input'))
	.forEach(function(e) {

		e.disabled = e.disabled == false;
	});
}
*/

File.onChangeStatus = function(status) {

	find('button').attr('disabled', status ? null : '');
}

function insert() {

	let content = find('.content');



	/*Request({
		content : content.id,
		text: content.innerHTML,
		file: JSON.stringify(File.list)
	});*/

	// File.list.each(f => console.log(f));

	console.dir( File.list );
}
