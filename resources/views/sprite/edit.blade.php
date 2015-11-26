@extends("base")

@section("title", "Edit sprite")

@section("content")
<h2>Edit sprite</h2>
@if (count($errors) > 0)
<div class="alert error">
	@foreach ($errors->all() as $error)
		{{ $error }}
	@endforeach
</div>
@endif
<form action="{{ url("/sprite/".old("alphaid", $alphaid)."/edit") }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	<input type="hidden" name="alphaid" value="{{ old("alphaid", $alphaid) }}" />
	<div>
		<label for="name">Short title:</label>
		<input value="{{ old("name", $title) }}" type="text" name="name" id="name" class="largetext" placeholder="Orange Pumpkin" />
	</div>
	<div>
		<label for="description">Description:</label>
		<textarea rows="3" name="description" id="description" placeholder="A pumpkin I made for a halloween project.">{{ old("description", $description) }}</textarea>
	</div>
	<div class="alert notice">
		You cannot edit the license or actual file associated with this sprite.
	</div>
	<div>
		<button type="submit">Make changes</button>
	</div>
</form>
@endsection
