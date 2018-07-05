<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Page Not Found - {{ settings()->getAppName() }}</title>
	<link rel="icon" href="{{ toolbox()->asset('/favicon.ico') }}" type="image/x-icon">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="all,follow">
	<!-- Bootstrap CSS-->
	<link rel="stylesheet" href="{{ toolbox()->frontend()->asset('css/bootstrap.css') }}">
	<!-- Font Awesome CSS-->
	<link rel="stylesheet" href="{{ toolbox()->frontend()->asset('css/css/font-awesome.min.css') }}">
	<!-- Google fonts - Roboto for copy, Montserrat for headings-->
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,700">
	<!-- theme stylesheet-->
{{--	<link rel="stylesheet" href="{{ toolbox()->frontend()->asset('css/style.default.css') }}" id="theme-stylesheet">--}}
	<!-- Custom stylesheet - for your changes-->
{{--	<link rel="stylesheet" href="{{ toolbox()->frontend()->asset('css/custom.css') }}">--}}
	<!-- Favicon-->
	
	<!-- Tweaks for older IEs--><!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<br><br><br>
	</div>
	<div class="row intro">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="intro-left-content">
				<p><img src="{{ toolbox()->frontend()->asset('img/new-logo.png') }}" alt="{{ settings()->getAppName() }}"></p>
				<h1>404 - Page Not Found</h1>
				<p>The page you are looking for is not available.</p>
				<p><br></p>
				<p class="social">
					<a href="javascript:;" class="external facebook">
						<i class="fa fa-facebook"></i>
					</a>
					<a href="javascript:;" class="external gplus">
						<i class="fa fa-google-plus"></i>
					</a>
					<a href="javascript:;" class="external twitter">
						<i class="fa fa-twitter"></i>
					</a>
					<a href="javascript:;" title="" class="external instagram">
						<i class="fa fa-instagram"></i>
					</a>
					<a href="javascript:;" class="email">
						<i class="fa fa-envelope"> </i>
					</a>
				</p>
				<p class="credit">&copy; 2017 {{ settings()->getAppName() }} </p>
			</div>
		</div>
	</div>
</div>
<!-- Javascript files-->
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>--}}
{{--<script src="{{ toolbox()->frontend()->asset('js/bootstrap.min.js') }}"></script>--}}
{{--<script src="{{ toolbox()->frontend()->asset('js/jquery.cookie.js') }}"></script>--}}
{{--<script src="{{ toolbox()->frontend()->asset('js/front.js') }}"></script>--}}
<!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
<!---->
<script>
    (function (b, o, i, l, e, r) {
        b.GoogleAnalyticsObject = l;
        b[l] || (b[l] =
            function () {
                (b[l].q = b[l].q || []).push(arguments)
            });
        b[l].l = +new Date;
        e = o.createElement(i);
        r = o.getElementsByTagName(i)[0];
        e.src = '//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e, r)
    }(window, document, 'script', 'ga'));
    ga('create', 'UA-XXXXX-X');
    ga('send', 'pageview');
</script>
</body>
</html>