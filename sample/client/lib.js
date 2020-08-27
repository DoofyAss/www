


/*
	Request
*/

// domain/request
var xhr = $.Request('request');

// domain/key=value
$.Request({'key': 'value'});

// domain/request&key=value
$.Request('request', {'key': 'value'});



// Before send

$.Request('...')
.Before(function() { ... });

// Progress (if header Content-Length exist)

$.Request('...')
.Progress((percent, loaded, total) => console.log(`${percent}%`));

// Success

$.Request('...')
.Success(r => console.log('done'));











/*
	Misc
*/

/* HTML */

// return DOM from String
let element = HTML('<div>');

// append
HTML(document.body, '<div>');

// prepend
HTML('<div>', document.body);



/* Selector */

// return one element
find('#menu').find('#item');

// return array elements
find('#menu').all('div');

// append before element
find('#menu span').appendBefore(element);

// append after element
find('#menu span').appendAfter(element);

// clear elements
clear('#menu', ...);

// effect
element.effect('shake');

// each array/object
array.each((value, key, index) => { ... });



/* Byte Converter */

// return 32GB
size(34359738368);

/* Timestamp Converter */

// return date
date(1598553228270);

// return timestamp
timestamp('2020.08.28, 05:33');
