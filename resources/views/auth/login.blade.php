@extends("base")

@section("title", "Login")

@section("content")
<h2>Login</h2>
@if (count($errors) > 0)
<div class="alert error">
	@foreach ($errors->all() as $error)
		{{ $error }}
	@endforeach
</div>
@endif
<form method="POST" action="{{ url('/auth/login') }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	<div>
		<label for="username">Username</label>
		<input type="text" placeholder="player1" id="username" name="username" value="{{ old('username') }}" autocorrect="off" autocapitalize="off" />
	</div>
	<div>
		<label for="password">Password</label>
		<input type="password" placeholder="•••••••" id="password" name="password" />
	</div>
	<div>
		<label><input type="checkbox" name="remember"> Remember me</label>
	</div>
	<button type="submit">Login</button>
	<a href="{{ url("/auth/register") }}">New user?</a>
</form>

@endsection
