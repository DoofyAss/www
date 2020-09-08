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
	this.onanimationend = () => this.removeClass(name);
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

	return byte == 0 ? '0 Byte' :

	(byte / Math.pow(1024, i)).toFixed(2) * 1 + [' Byte', ' KB', ' MB', ' GB'][i];
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










/*
	Request
*/

var Request = function() {



	/*
		Data
	*/

	let data = Array.from(arguments).map(e => object(e)).join('&');

	function object(e) {

		return typeof e == 'string' ? e :
		Object.entries(e).map(e => e.join('=')).join('&');
	}



	/*
		XMLHttpRequest
	*/

	function post(xhr) {

		xhr.open('POST', window.location.origin);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

		xhr.Error = function(c) { xhr.Error = c; return this; };
		xhr.Before = function(c) { xhr.Before = c; return this; };
		xhr.Success = function(c) { xhr.Success = c; return this; };
		xhr.Progress = function(c) { xhr.Progress = c; return this; };



		/*
			Before
		*/

		xhr.onloadstart = function() {

			try { xhr.Before.call(xhr, xhr); } catch { }
		}



		/*
			Error
			Success
		*/

		xhr.onload = function() {

			try {

				if (xhr.status != 200)
				xhr.Error.call(xhr, xhr.response);

				if (xhr.status == 200)
				xhr.Success.call(xhr, xhr.response);

			} catch { }
		}



		/*
			Progress
		*/

		xhr.onprogress = function(e) {

			try {

				if (xhr.getResponseHeader('Content-Length')) {

					let percent = parseInt(e.loaded / e.total * 100);
					xhr.Progress.call(xhr, percent, e.loaded, e.total);
				}

			} catch { }
		}



		setTimeout(() => xhr.send(data));
		return xhr;
	}

	return post(new XMLHttpRequest());
}










/*
	File
*/

var File = {

	list: [],



	get modified() {

		return File.list.map(file => file.lastModified);
	},



	get data() {

		return File.list
		.filter(file => file.data != null)
		.map(file => file.data);
	},



	add: function(area) {

		let form = document.createElement('input');
		form.type = 'file';
		form.multiple = true;
		form.click();

		form.onchange = function() {



			this.files.each(file => {

				if (!File.modified.includes(file.lastModified)) {

					file.data = {

						id: file.lastModified,
						name: file.name,
						size: file.size
					}

					File.list.push(file);
				}
			});



			Request({ 'file-upload': JSON.stringify(File.data) })

			.Success(r => {

				HTML(area, r);

				area.all('[id]').each(e => {

					let index = File.modified.indexOf(parseInt(e.id));

					File.upload( File.list[index] )
					.Before(xhr => xhr.progressbar = e.parentNode.find('progress'))
					.Progress((xhr, percent) => xhr.progressbar.value = percent);
				});
			});
		}
	},



	upload: function(file) {

		delete file.data;



		function post(xhr) {

			let form = new FormData();
			form.append('file', file);



			xhr.open('POST', window.location.origin);

			xhr.Error = function(c) { xhr.Error = c; return this; };
			xhr.Before = function(c) { xhr.Before = c; return this; };
			xhr.Success = function(c) { xhr.Success = c; return this; };
			xhr.Progress = function(c) { xhr.Progress = c; return this; };



			/*
				Before
			*/

			xhr.onloadstart = function() {

				try { xhr.Before.call(xhr, xhr); } catch { }
			}



			/*
				Error,
				Abort
			*/

			xhr.onerror = xhr.onabort = function() {

				try { xhr.Error.call(xhr, xhr); } catch { }
			}



			/*
				Progress
			*/

			xhr.upload.onprogress = function(e) {

				try {

					let percent = parseInt(e.loaded / e.total * 100);
					xhr.Progress.call(xhr, xhr, percent, e.loaded, e.total);

				} catch { }
			}



			/*
				Success
			*/

			xhr.onload = function() {

				try {

					if (this.status != 200)
					xhr.Error.call(xhr, xhr.response);

					if (this.status == 200)
					xhr.Success.call(xhr, xhr.response);

				} catch { }
			}



			setTimeout(() => xhr.send(form));
			return xhr;
		}

		return post(new XMLHttpRequest());
	}
}
