


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
.Progress((loaded, total) => console.log(`${loaded} of ${total}`));

// Success

$.Request('...')
.Success(r => console.log('done'));
