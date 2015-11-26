@extends("base")

@section("title", "Sprite: ".$title)

@section("content")

<h2>{{ $title }}</h2>
<img src="{{ url("/sprites/full/".$alphaid.".png") }}" class="checker raised"
	width="{{ $width }}" height="{{ $height }}" />
<?php $image = Image::make(public_path()."/sprites/full/".$alphaid.".png"); ?>
@if (strlen($description) > 0)
	<p class="description">{{ $description }}</p>
@else
	<p class="empty"><em>No description</em></p>
@endif

<div>
@if ($favorited)
	<a href="{{ url("/sprite/".$alphaid."/unfavorite?t=".csrf_token()) }}" /><i class="icon-heart"></i></a>
@else
	<a href="{{ url("/sprite/".$alphaid."/favorite?t=".csrf_token()) }}" /><i class="icon-heart-empty"></i></a>
@endif
	<a href="{{ url("/sprite/".$alphaid."/download") }}"><i class="icon-download"></i></a>
	<a href="{{ url("/sprites/full/".$alphaid.".png") }}"><i class="icon-link-ext-alt"></i></a>
	{{ $width }}&times;{{ $height }}px, {{ $filesize }} bytes,
	uploaded {{ $creation->diffForHumans() }} by
	<a href="{{ url("/user/".$username) }}">{{ $uploader }}</a>
</div>
<div class="colors">
@foreach($colors as $color)
	<a href="{{ url("/search?q=".substr($color, 1)) }}" style="background:{{ $color }}">{{ $color }}</a>
@endforeach
</div>

@if ($license !== "unlicense")
<div class="alert notice fivetop">
<i class="icon-attention"></i> Attribution required! Credit the author of this sprite.
</div>
@endif
<textarea class="monospace selectall fivetop">// "{{ $title }}" by {{ $uploader }} via <{{ str_replace("https://www.","",url("/sprite/".$alphaid)) }}>.{{--
--}}@if ($license == "ccby4") Licensed under CC BY 4.0{{----}}@else{{--
--}} Public domain under Unlicense{{----}}@endif</textarea>

<a href="{{ url("/sprite/".$alphaid."/download") }}" class="button">Download</a>
@if ($favorited)
	<a href="{{ url("/sprite/".$alphaid."/unfavorite?t=".csrf_token()) }}" class="button">Unfavorite ({{ $favorites }})</a>
@else
	<a href="{{ url("/sprite/".$alphaid."/favorite?t=".csrf_token()) }}" class="button">Favorite ({{ $favorites }})</a>
@endif
@if ($username == Auth::user()->alphaid)
<a href="{{ url("/sprite/".$alphaid."/edit") }}" class="button">Edit</a>
@endif
@if ($username == Auth::user()->alphaid || str_contains(Auth::user()->rights, "delete_anything "))
<a href="{{ url("/sprite/".$alphaid."/remove?t=".csrf_token()) }}" class="button needsconfirm">Remove</a>
@endif

@endsection
