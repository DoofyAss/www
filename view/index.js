'use strict'



function addFile(area) {

	window.files = window.files ?? [];



	let form = document.createElement('input');
	form.type = 'file';
	form.multiple = true;
	form.click();

	form.onchange = function() {



		let modified = Array.from(window.files)
		.map(file => file.lastModified);



		let data = [];

		this.files.each(file => {

			if (!modified.includes(file.lastModified)) {

				window.files.push(file);

				data.push({
					id: file.lastModified,
					name: file.name,
					size: file.size
				});
			}
		});

		$.Request({ 'file-upload': JSON.stringify(data) })
		.Success(r => HTML(area, r));
	}
}
