@extends("base")

@section("title", "User: ".$name)

@section("content")

<h2>{{ $name }}</h2>
<div>
@if ($username == Auth::user()->username){{ $username }}, @endif
joined {{ $creation->diffForHumans() }}
@if ($username == Auth::user()->username)
	<a href="{{ url("/user/me/edit") }}">edit profile</a>
@endif
</div>
@if (strlen($about) > 0)
	<p class="description">{{ $about }}</p>
@else
	<p class="empty"><em>Nothing here{{--
	--}}@if ($username == Auth::user()->username), <a href="{{ url("/user/me/edit") }}">write something</a>!@endif</em></p>
@endif

@if ($username == Auth::user()->username)
<h3>Favorites ({{ count($favorites) }})</h3>
@if (count($favorites) > 0)
</main>
<div class="grid">
@foreach ($favorites as $favorite)
	<?php $sprite = \App\Sprite::where("alphaid", "=", $favorite->alphaid)->first(); ?>
	<a class="item @if ($sprite->width/$sprite->height > 1.5) double @endif" href="{{ url("/sprite/".$sprite->alphaid) }}">
		<img src="{{ url("/sprites/small/".$sprite->alphaid.".png") }}"
		     data-original="{{ url("/sprites/full/".$sprite->alphaid.".png") }}"
		     width="{{ $sprite->width }}" height="{{ $sprite->height }}"
		     class="checker" />
		<div>{{ \App\Sprite::where("alphaid", "=", $sprite->alphaid)->first()->title }}</div><i> </i>
	</a>
@endforeach
</div>
<main>
@else
<p class="empty"><em>Nothing here</em></p>
@endif
@endif

<h3>Uploads ({{ count($uploads) }})</h3>
@if (count($uploads) > 0)
</main>
<div class="grid">
@foreach ($uploads as $sprite)
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
<p class="empty"><em>Nothing here</em></p>
@endif

@if ($username != Auth::user()->username && false)
<h3>Favorites ({{ count($favorites) }})</h3>
@if (count($favorites) > 0)
</main>
<div class="grid">
@foreach ($favorites as $favorite)
	<?php $sprite = \App\Sprite::where("alphaid", "=", $favorite->alphaid)->first(); ?>
	<a class="item @if ($sprite->width/$sprite->height > 1.5) double @endif" href="{{ url("/sprite/".$sprite->alphaid) }}">
		<img src="{{ url("/sprites/small/".$sprite->alphaid.".png") }}"
		     data-original="{{ url("/sprites/full/".$sprite->alphaid.".png") }}"
		     width="{{ $sprite->width }}" height="{{ $sprite->height }}"
		     class="checker" />
		<div>{{ \App\Sprite::where("alphaid", "=", $sprite->alphaid)->first()->title }}</div><i> </i>
	</a>
@endforeach
</div>
<main>
@else
<p class="empty"><em>Nothing here</em></p>
@endif
@endif

@endsection
