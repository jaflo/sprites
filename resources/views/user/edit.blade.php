@extends("base")

@section("title", "Edit profile")

@section("content")
<h2>Edit profile</h2>
@if (count($errors) > 0)
<div class="alert error">
	@foreach ($errors->all() as $error)
		{{ $error }}
	@endforeach
</div>
@endif
<form action="{{ url("/user/me/edit") }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	<div>
		<label for="name">Credit goes to:</label>
		<input value="{{ old("name", $name) }}" type="text" name="name" id="name" class="largetext" />
	</div>
	<div>
		<label for="about">About me:</label>
		<textarea rows="3" name="about" id="about" placeholder="I really like making sprites.">{{ old("about", $about) }}</textarea>
	</div>
	<div class="alert notice">
		You cannot edit your username.
	</div>
	<div>
		<button type="submit">Make changes</button>
	</div>
</form>
@endsection
