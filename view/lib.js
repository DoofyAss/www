'use strict'



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

							let loaded = parseInt(e.loaded / e.total * 100);
							self.Progress.call(self, loaded, e.total);
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

$.Request('sakmadik')
.Success(r => console.log(r))
