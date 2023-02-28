<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="csrf-token" content="v2Gkend6sYW8QLog1K43r5sZmmoYTOVWMuMqDM0j">
	<link rel="shortcut icon" href="/favicon.ico">
	<title>Zapiet: Store Pickup + Delivery</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://app.zapiet.com/assets/css/app.css" rel="stylesheet">
	<script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
	<script src="https://amkwebsolutions.com/shopify-app/foodorder_manager/jquery-1.12.4.js"></script>
	<link href="{{ URL::asset('resources/css/dashboard.css') }}" rel="stylesheet">
	<script src="https://unpkg.com/@shopify/app-bridge"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ URL::asset('public/css/style.css') }}">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body>
@yield('content')
</body>
<script>
		var AppBridge = window['app-bridge'];
		var createApp = AppBridge.default;
		var app = createApp({
				apiKey: '{{ config('shopify-app.api_key') }}',
				shopOrigin: '{{$shop}}',
				forceRedirect: true,
		});
		var actions = AppBridge.actions;
		var TitleBar = actions.TitleBar;
		var Button = actions.Button;
		var Redirect = actions.Redirect;
		var Flash=actions.Flash;
	</script>
	@yield('scripts')
</html>
