'use strict'


/*
	text/html
*/

function HTML(s, e) {



	function fragment(string) {

		return document.createRange().createContextualFragment(string);
	}

	return e ? typeof e == 'string' ?
	s.append(fragment(e)) : e.prepend(fragment(s)) : fragment(s);
}










/*
	Selector
*/

HTMLElement.prototype.all = function(s) {

	return Array.from(this.querySelectorAll(s));
}

function all(s) { return document.body.all(s); }

HTMLElement.prototype.find = function(s) {

	return this.querySelector(s);
}

function find(s) { return document.body.find(s); }

HTMLElement.prototype.appendBefore = function(e) {

	this.parentNode.insertBefore(e, this);
}

HTMLElement.prototype.appendAfter = function(e) {

	this.parentNode.insertBefore(e, this.nextSibling);
}

HTMLElement.prototype.clear = function() {

	this.innerHTML = null;
}

function clear() {

	Array.from(arguments).each(e => find(e).clear());
}

HTMLElement.prototype.addClass = function(s) {

	this.classList.add(s);
}

HTMLElement.prototype.removeClass = function(s) {

	this.classList.remove(s);
}

HTMLElement.prototype.toggleClass = function(s) {

	this.classList.toggle(s);
}

HTMLElement.prototype.effect = function(name) {

	this.removeClass(name);
	this.getBoundingClientRect();
	this.addClass(name);
	this.addEventListener('animationend', () => this.removeClass(name));
}










Object.prototype.each = function(c) {

	let self = this;

	Object.keys(this).forEach(function(key, i) {

		c.call(self, self[key], key, i);
	});
}










/*
	Byte Converter
*/

function size(byte) {

	let i = Math.floor( Math.log(byte) / Math.log(1024) );
	return (byte / Math.pow(1024, i)).toFixed(2) * 1 + ['B', 'KB', 'MB', 'GB'][i];
}



/*
	Timestamp Converter
*/

function date(timestamp) {

	let date = new Date(timestamp); // php timestamp * 1000

	let year = date.toLocaleString('ru', { year: 'numeric' });
	let month = date.toLocaleString('ru', { month: '2-digit' });
	let day = date.toLocaleString('ru', { day: '2-digit' });

	let hour = date.toLocaleString('ru', { hour: '2-digit' });
	let minute = ('0' + date.toLocaleString('ru', { minute: '2-digit' })).slice(-2);

	return `${year}.${month}.${day}, ${hour}:${minute}`;
}

function timestamp(date) {

	return new Date(date).getTime();
}










var $ = {










	/*
		Request
	*/

	Request: function() {



		this.Error = function(c) {

			this.Error = c;
			return this;
		}



		this.Success = function(c) {

			this.Success = c;
			return this;
		}



		this.Progress = function(c) {

			this.Progress = c;
			return this;
		}



		this.Before = function(c) {

			this.Before = c;
			return this;
		}



		/*
			Data
		*/

		this.data = Array.from(arguments).map(e => object(e)).join('&');

		function object(e) {

			return typeof e == 'string' ? e :
			Object.entries(e).map(e => e.join('=')).join('&');
		}



		/*
			XMLHttpRequest
		*/

		this.xhr = post(new XMLHttpRequest(), this);

		function post(xhr, self) {

			xhr.open('POST', window.location.origin);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

			(async function() {



				/*
					Before Send
				*/

				xhr.onreadystatechange = function() {

					if (this.readyState == 2)
					try { self.Before.call(self, self); } catch { }
				}



				/*
					Progress
				*/

				xhr.onprogress = function(e) {

					try {

						if (xhr.getResponseHeader('Content-Length')) {

							let percent = parseInt(e.loaded / e.total * 100);
							self.Progress.call(self, percent, e.loaded, e.total);
						}

					} catch { }
				}



				/*
					Success
				*/

				xhr.onload = function() {

					try {

						if (xhr.status != 200)
						self.Error.call(xhr, xhr.response);

						if (xhr.status == 200)
						self.Success.call(xhr, xhr.response);

					} catch { }
				}


				xhr.send(self.data);

			})();

			return xhr;
		}

		return this;
	}
}
