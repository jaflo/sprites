@extends("base")

@section("title", "Upload")

@section("content")
<h2>Upload</h2>
@if (count($errors) > 0)
<div class="alert error">
	@foreach ($errors->all() as $error)
		{{ $error }}
	@endforeach
</div>
@endif
<form action="" method="POST" id="upload" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	<div>
		<label for="name">Short title:</label>
		<input value="{{ old("name") }}" type="text" name="name" id="name" class="largetext" placeholder="Orange Pumpkin" />
	</div>
	<div class="verttoggle">
		<input @if(old("uploadtype") !== "code") checked @endif type="radio" name="uploadtype" id="uploadtype-image" value="image" />
		<label for="uploadtype-image"><div>Upload image</div></label>
		<input @if(old("uploadtype") == "code") checked @endif type="radio" name="uploadtype" id="uploadtype-code" value="code" />
		<label for="uploadtype-code"><div>Paste code</div></label>
		<div>or</div>
	</div>
	<div id="submitfile">
		<input type="file" name="file" id="file" />
	</div>
	<div id="pasteprocessing">
		<textarea rows="2" name="processingcode" id="processingcode" placeholder="Paste code here">{{ old("processingcode") }}</textarea>
		<canvas></canvas>
		<button type="button" class="normal run">Run</button>
		<input type="hidden" name="pdecapture" />
	</div>
	<div id="imagepreview" class="inputlike">
		<img class="checker" />
	</div>
	<div>
		<label for="description">Description:</label>
		<textarea rows="3" name="description" id="description" placeholder="A pumpkin I made for a halloween project.">{{ old("description") }}</textarea>
	</div>
	<div>
		<div class="verttoggle" id="chooselicense">
			<input @if(old("license") !== "pdunlicense") checked @endif type="radio" name="license" id="license-cc" value="ccby4" />
			<label for="license-cc"><div class="large">Require attribution</div><div class="small">Must attribute</div></label>
			<input @if(old("license") == "pdunlicense") checked @endif type="radio" name="license" id="license-pd" value="unlicense" />
			<label for="license-pd"><div>Public domain</div></label>
			<div>or</div>
		</div>
	</div>
	<div id="licensepreview" class="monospace">
		// "<span class="name">Work</span>" by <span class="author">Author</span> via &lt;{{ str_replace("https://www.","",url("/sprite/5pr17")) }}&gt;.
		<span class="link cc">Licensed under <a href="http://creativecommons.org/licenses/by/4.0/">CC BY 4.0</a>, attribution required</span>
		<span class="link public">Public domain under <a href="http://unlicense.org/">Unlicense</a>, no attribution require</span>
	</div>
	<div class="alert notice">
		<i class="icon-attention"></i>
		By uploading this sprite, you allow others to use your work in other
		projects under the terms you stated above. You will not receive monetary compensation.
		Make sure you have sufficient rights to the image!
	</div>
	<div>
		<button type="submit">Upload</button>
	</div>
</form>
@endsection
