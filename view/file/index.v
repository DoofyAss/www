<link rel='stylesheet' href='view/style.css'>

<button>disabled</button>



<div class='file_area'>

	<span onclick='addFile(this.parentElement)'>добавить файл</span>
	<!-- <div class='file' ext='xlsx' size='4MB'>
		<input value='Document' name='Document' disabled>
		<progress max='100' value='60'></progress>
	</div> -->
</div>



<script>
document.querySelector('button').onclick = function() {

	Array.from(document.querySelectorAll('input'))
	.forEach(function(e) {

		e.disabled = e.disabled == false;
	});
}
</script>

<script src='view/lib.js'></script>
<script src='view/index.js'></script>
