<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="description" content="@section('meta_description') @show">
	<meta name="keywords" content="@section('meta_keywords') @show">
	<meta name="author" content="{{ settings()->getAppName() }}">
	<link rel="icon" href="{{ toolbox()->asset('/favicon.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="{{ toolbox()->asset('/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ toolbox()->asset('/plugins/node-waves/waves.css') }}" rel="stylesheet" />
    <link href="{{ toolbox()->asset('/plugins/animate-css/animate.css') }}" rel="stylesheet" />
    <link href="{{ toolbox()->backend()->asset('/css/style.css') }}" rel="stylesheet">
</head>
<body class="login-page">
    <div class="login-box">
	    <div class="card">
		    <div class="header">
			    <a href="javascript:void(0);">
				    <img src="{{ toolbox()->backend()->asset('/images/new-logo-login.png')  }}" style="margin-left: 15px">
			    </a>
		    </div>
            <div class="body">
                @yield('content')
            </div>
	    </div>
    </div>
    <script src="{{ toolbox()->asset('/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ toolbox()->asset('/plugins/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ toolbox()->asset('/plugins/node-waves/waves.js') }}"></script>
    <script src="{{ toolbox()->asset('/plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ toolbox()->backend()->asset('/js/admin.js') }}"></script>
    <script src="{{ toolbox()->backend()->asset('/js/pages/examples/sign-in.js') }}"></script>
</body>
</html>