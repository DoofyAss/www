{ file :
	<div class='file'>
		<input id='{ file->id }' value="{ file->name }">
		<progress max='100' value='0'></progress>
		<span ext='{ file->ext }'><size byte>{ file->size }</size></span>
	</div>
}
