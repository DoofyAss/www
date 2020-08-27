<link rel='stylesheet' href='view/style.css'>

<button>disabled</button>



<div class='file_area'>

	<span onclick='addFile(this.parentElement)'>добавить файл</span>

	<div>1</div>
	<div>2</div>
	<div>3</div>
	<div>4</div>
	<div>5</div>
	<div>6</div>
	<div>7</div>
	<div>8</div>
	<!-- <div class='file' ext='xlsx' size='4MB'>
		<input value='Document' name='Document' disabled>
		<progress max='100' value='60'></progress>
	</div> -->
</div>

<div id='qeqqe'>
	<div>1</div>
	<div>2</div>
	<div>3</div>
	<div>4</div>
	<div>5</div>
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
