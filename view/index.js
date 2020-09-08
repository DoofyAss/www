'use strict'


setInterval(() => {

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
