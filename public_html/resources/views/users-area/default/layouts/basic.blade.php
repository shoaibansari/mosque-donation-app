<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="description" content="@section('meta_description') @show">
	<meta name="keywords" content="@section('meta_keywords') @show">
	<meta name="author" content="{{ settings()->getAppName() }}">
    <link rel="icon" href="{{ toolbox()->frontend()->url('favicon.ico') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="{{ toolbox()->userArea()->asset('/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ toolbox()->userArea()->asset('/plugins/node-waves/waves.css') }}" rel="stylesheet" />
    <link href="{{ toolbox()->userArea()->asset('/plugins/animate-css/animate.css') }}" rel="stylesheet" />
    <link href="{{ toolbox()->userArea()->asset('/css/style.css') }}" rel="stylesheet">
</head>
<body class="login-page">
    <div class="login-box">
	    {{--
        <div class="logo">
            <a href="javascript:void(0);">
	            <img src="{{ toolbox()->userArea()->asset('/images/logo-login.png')  }}">
            </a>
            <!-- <small>Backoffice - Powered by FSD Solutions</small> -->
        </div>
        --}}
	    <div class="card">
		    <div class="header">
			    <a href="javascript:void(0);">
				    <img src="{{ toolbox()->userArea()->asset('/images/logo-login.png')  }}" style="margin-left: 15px">
			    </a>
		    </div>
            <div class="body">
                @yield('content')
            </div>
	    </div>
    </div>
    <script src="{{ toolbox()->userArea()->asset('/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ toolbox()->userArea()->asset('/plugins/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ toolbox()->userArea()->asset('/plugins/node-waves/waves.js') }}"></script>
    <script src="{{ toolbox()->userArea()->asset('/plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ toolbox()->userArea()->asset('/js/admin.js') }}"></script>
    <script src="{{ toolbox()->userArea()->asset('/js/pages/examples/sign-in.js') }}"></script>
</body>
</html>