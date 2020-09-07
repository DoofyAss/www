'use strict'



function addFile(area) {

	window.files = window.files ?? [];



	let form = document.createElement('input');
	form.type = 'file';
	form.multiple = true;
	form.click();

	form.onchange = function() {



		// $.File.modified();
		// $.File.list();
		// $.File.data();

		// $.File.add();



		let modified = Array.from(window.files)
		.map(file => file.lastModified);



		this.files.each(file => {

			if (!modified.includes(file.lastModified)) {

				file.upload = true;
				window.files.push(file);
			}
		});



		let upload = Array.from(window.files)
		.filter(file => file.upload == true);



		let data = [];
		data.push({
			id: file.lastModified,
			name: file.name,
			size: file.size
		});


		$.Request({ 'file-upload': JSON.stringify(data) })
		.Success(r => {
			HTML(area, r);
			console.log(window.files);
		});
	}
}
