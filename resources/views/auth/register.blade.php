@extends("base")

@section("title", "Register")

@section("content")
<h2>Register</h2>
@if (count($errors) > 0)
<div class="alert error">
	@foreach ($errors->all() as $error)
		{{ $error }}
	@endforeach
</div>
@endif
<form method="POST" action="{{ url('/auth/register') }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	<div>
		<label for="username">Username</label>
		<input type="text" placeholder="player1" id="username" name="username" value="{{ old('username') }}" autocorrect="off" autocapitalize="off" />
	</div>
	<div>
		<label for="username">Name</label>
		<input type="text" placeholder="Frisk" id="name" name="name" value="{{ old('name') }}" />
	</div>
	<div>
		<label for="password">Password</label>
		<input type="password" placeholder="•••••••" id="password" name="password" />
	</div>
	<div>
		<label for="password">Password (again)</label>
		<input type="password" placeholder="•••••••" id="password_confirmation" name="password_confirmation" />
	</div>
	<button type="submit">Register</button>
	<a href="{{ url("/auth/login") }}">Already a user?</a>
</form>

@endsection
