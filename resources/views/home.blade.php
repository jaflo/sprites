@extends("base")

@if (isset($query))
	@section("title", "Search: ".$query)
@else
	@section("title", "Home")
@endif

@section("content")

<form action="search" method="GET" id="search" class="zerofont clearfix">
	<input value="{{ $query or "" }}" type="text" name="q" id="search" class="largetext" placeholder="Search" />
	<div>
		<button type="submit" class="normal floatright">Search</button>
		<a href="{{ url("/upload") }}" class="primary button">Upload a sprite</a>
	</div>
</form>

@if (count($sprites) > 0)
</main>
<div class="grid">
@foreach ($sprites as $sprite)
	<a class="item @if ($sprite->width/$sprite->height > 1.5) double @endif" href="{{ url("/sprite/".$sprite->alphaid) }}">
		<img src="{{ url("/sprites/small/".$sprite->alphaid.".png") }}"
		     data-original="{{ url("/sprites/full/".$sprite->alphaid.".png") }}"
		     width="{{ $sprite->width }}" height="{{ $sprite->height }}"
		     class="checker" />
		<div>{{ $sprite->title }}</div><i> </i>
	</a>
@endforeach
</div>
<main>
@else
<p class="empty"><em>Nothing here (yet)</em></p>
@endif

@endsection
