<!DOCTYPE html>
<html>
	<head>
		<title>@yield("title", "HEY") | SpriteBase</title>
		<link href="{{ url("style.css") }}" rel="stylesheet" type="text/css">
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="apple-touch-icon" sizes="57x57" href="{{ url("/apple-touch-icon-57x57.png") }}">
		<link rel="apple-touch-icon" sizes="60x60" href="{{ url("/apple-touch-icon-60x60.png") }}">
		<link rel="apple-touch-icon" sizes="72x72" href="{{ url("/apple-touch-icon-72x72.png") }}">
		<link rel="apple-touch-icon" sizes="76x76" href="{{ url("/apple-touch-icon-76x76.png") }}">
		<link rel="apple-touch-icon" sizes="114x114" href="{{ url("/apple-touch-icon-114x114.png") }}">
		<link rel="apple-touch-icon" sizes="120x120" href="{{ url("/apple-touch-icon-120x120.png") }}">
		<link rel="icon" type="image/png" href="{{ url("/favicon-32x32.png") }}" sizes="32x32">
		<link rel="icon" type="image/png" href="{{ url("/favicon-96x96.png") }}" sizes="96x96">
		<link rel="icon" type="image/png" href="{{ url("/favicon-16x16.png") }}" sizes="16x16">
	</head>
	<body>
		<header>
			<div id="right">
			@if (Auth::check())
				<div id="user" class="loggedin">
					<a href="{{ url("/user/".Auth::user()->alphaid) }}" tabindex="-1">{{ Auth::user()->name }}</a>
					<i></i>
				</div>
				<div id="userdrop">
					<a href="{{ url("/user/".Auth::user()->alphaid) }}">My profile</a>
					<a href="{{ url("/upload") }}">Upload</a>
					<a href="{{ url("/home") }}">Home</a>
					<a href="{{ url("/auth/logout") }}">Logout</a>
				</div>
			@else
				<div id="user"><a href="{{ url("/auth/login") }}">Login</a></div>
			@endif
			</div>
			<h1><a href="{{ url("/") }}">SpriteBase</a></h1>
		</header>
		<main>
			@yield("content")
		</main>
		<footer>&copy; 2015</footer>
		<canvas id="background"></canvas>
		<script src="{{ url("min.js") }}"></script>
		<script src="{{ url("app.js") }}"></script>
		<!-- Piwik -->
		<script type="text/javascript">
		  var _paq = _paq || [];
		  _paq.push(['trackPageView']);
		  _paq.push(['enableLinkTracking']);
		  (function() {
			var u="//www.gatshi.com/piwik/";
			_paq.push(['setTrackerUrl', u+'piwik.php']);
			_paq.push(['setSiteId', 2]);
			var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
			g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
		  })();
		</script>
		<noscript><p><img src="//www.gatshi.com/piwik/piwik.php?idsite=2" style="border:0;" alt="" /></p></noscript>
		<!-- End Piwik Code -->
	</body>
</html>
