<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script> window.laravel = {!! $javascript_globals !!}</script>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="{{ URL::asset('assets/backend/css/app.css') }}">
		<?php
		$image = URL::asset('/assets/images/logo.png');
		if(Auth::check())
		{
			$small_logo = @json_decode(Auth::user()->getSettings("logo-pequeno"))[0];
			$image = $small_logo ? $small_logo : URL::asset('/assets/images/logo.png');
		}
		?>
		<link rel="icon" type="image/png" href="@yield('favicon',$image)" />
		<title>{{config("app.name")}} - @yield("title")</title>
	</head>
	<body>
		<div id="app">
			@yield("body")
		</div>
		<script src="{{ URL::asset('/assets/backend/js/manifest.js')}}"></script>
		<script src="{{ URL::asset('/assets/backend/js/vendor.js')}}"></script>
		<script src="{{ URL::asset('/assets/backend/js/app.js') }}"></script>
		@yield("scripts")
	</body>
</html>