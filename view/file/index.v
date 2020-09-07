<link rel='stylesheet' href='view/style.css'>

<button>disabled</button>



<div class='file_area'>

	<!-- <span onclick='addFile(this.parentElement)'>добавить файл</span> -->
	<span onclick='File.add(this.parentElement)'>добавить файл</span>

	<!-- <div class='file'>
		<input id='19827389123' value='Microsoft Excel'>
		<progress max='100' value='60'></progress>
		<span><ext>xlsx</ext><size byte>131072</size></span>
	</div> -->

</div>



<script src='view/lib.js'></script>
<script src='view/index.js'></script>



<script>
document.querySelector('button').onclick = function() {

	Array.from(document.querySelectorAll('input'))
	.forEach(function(e) {

		e.disabled = e.disabled == false;
	});
}

setInterval(() => {

	let s = all('size[byte]');
	if (s.length) s.each(e => {

		e.innerHTML = size(e.innerHTML);
		e.removeAttribute('byte');
	});

}, 500);

</script>
