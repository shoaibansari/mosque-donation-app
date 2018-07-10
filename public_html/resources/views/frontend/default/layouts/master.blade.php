<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>{{ settings()->getAppName() }}</title>
	<link rel="icon" href="{{ toolbox()->asset('/favicon.ico') }}" type="image/x-icon">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{ toolbox()->frontend()->asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ toolbox()->frontend()->asset('css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ toolbox()->frontend()->asset('css/simple-line-icons.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
	{{-- Plugin CSS --}}
	<link rel="stylesheet" href="{{ toolbox()->frontend()->asset('device-mockups/device-mockups.min.css') }}">
	{{-- Custom styles for this template --}}
	<link href="{{ toolbox()->frontend()->asset('css/new-age.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
	<div class="container">
		<a class="navbar-brand js-scroll-trigger" href="#page-top">{{ settings()->getAppName() }}</a>
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			Menu
			<i class="fa fa-bars"></i>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto">
				<!-- <li class="nav-item">
					<a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#login">Login</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#signUp">Sign Up</a>
				</li> -->
				<!-- <li class="nav-item">
					<a class="nav-link js-scroll-trigger" href="#download">Download</a>
				</li>
				<li class="nav-item">
					<a class="nav-link js-scroll-trigger" href="#features">Features</a>
				</li>
				<li class="nav-item">
					<a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
				</li> -->
			</ul>
		</div>
	</div>
</nav>

<header class="masthead" style="min-height: 0px">
	<div class="container h-100">
		<div class="row h-100">
			<div class="col-lg-12 my-auto">
				<div class="header-content mx-auto" style="text-align: center;">
					
					<a class="btn btn-outline btn-xl js-scroll-trigger" href="javascript:void(0);" data-toggle="modal" data-target="#login">Login</a>
					<br />
					<br />
					<br />
					<a class="btn btn-outline btn-xl js-scroll-trigger" href="javascript:void(0);" data-toggle="modal" data-target="#signUp">Sign Up</a>
					
				</div>
			</div>
			{{--<div class="col-lg-5 my-auto">
				<div class="device-container">
					<div class="device-mockup iphone6_plus portrait white">
						<div class="device">
							<div class="screen">
								<!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
								<img src="{{ toolbox()->frontend()->asset('img/demo-screen-1.jpg') }}" class="img-fluid" alt="">
							</div>
							<div class="button">
								<!-- You can hook the "home button" to some JavaScript events or just remove it -->
							</div>
						</div>
					</div>
				</div>
			</div>--}}
		</div>
	</div>
</header>

@yield('contents')

<footer>
	<div class="container">
		<p>&copy; {{ date('Y') . ' ' . settings()->getAppName() }}. All Rights Reserved.</p>
		<ul class="list-inline">
			<li class="list-inline-item">
				<a href="#">Privacy</a>
			</li>
			<li class="list-inline-item">
				<a href="#">Terms</a>
			</li>
			<li class="list-inline-item">
				<a href="#">FAQ</a>
			</li>
		</ul>
	</div>
</footer>

<div class="modal fade" id="login" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			{!! Form::open( ['route' => 'login', 'method' => 'post', 'files' => false, 'id'=> 'form-login', 'ajax' => 'on']) !!}
				<div class="modal-header">
					<h4 class="modal-title">Login to your account.</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					@include( toolbox()->frontend()->view('partials.messages') )
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							{{ Form::email('email', null, ['class' => 'form-control', 'placeholder'=>'Enter your email address']) }}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							{{ Form::password('password', ['class' => 'form-control', 'placeholder'=>'Enter password']) }}
						</div>
					</div>
					<a href="javascript:void(0);" data-toggle="modal" data-dismiss="modal" data-target="#forgotPassword">Forgot
						Password?</a>
				</div>
				<div class="modal-footer">
					{{ Form::submit( 'Login', ['class'=>'btn btn-primary']) }}
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<div class="modal fade" id="forgotPassword" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			{!! Form::open( ['route' => 'password.email', 'method' => 'post', 'files' => false, 'id'=> 'form-forgot-password']) !!}
				<div class="modal-header">
					<h4 class="modal-title">Forgot Password.</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					@include( toolbox()->frontend()->view('partials.messages') )
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							{{ Form::email('email', null, ['class' => 'form-control', 'placeholder'=>'Enter your email address']) }}
						</div>
					</div>
				</div>
				<div class="modal-footer">
					{{ Form::submit( 'Reset My Password', ['class'=>'btn btn-primary submit']) }}
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<div class="modal fade" id="signUp" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			{!! Form::open( ['route' => 'signup', 'method' => 'post', 'files' => false, 'id'=> 'form-signup']) !!}
				{!! Form::hidden('latitude', null, ['id' => 'latitude']) !!}
				{!! Form::hidden('longitude', null, ['id' => 'longitude']) !!}
				<div class="modal-header">
					<h4 class="modal-title">Register your account now.</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('name', 'Name') }}
								{{ Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'Enter your name']) }}
							</div>
							<div class="form-group">
								{{ Form::label('email', 'Email Address') }}
								{{ Form::email('email', null, ['class' => 'form-control', 'placeholder'=>'Enter your email address']) }}
							</div>
							<div class="form-group">
								{{ Form::label('password', 'Password') }}
								{{ Form::password('password', ['class' => 'form-control', 'placeholder'=>'Enter your password']) }}
							</div>
							<div class="form-group">
								{{ Form::label('password_confirmation', 'Re-enter Password') }}
								{{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder'=>'Enter your password again']) }}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('street', 'Street') }}
								{{ Form::text('street', null, ['class' => 'form-control', 'placeholder'=>'Enter street name']) }}
							</div>
							<div class="form-group">
								{{ Form::label('city', 'City') }}
								{{ Form::text('city', null, ['class' => 'form-control', 'placeholder'=>'Enter city name']) }}
							</div>
							<div class="form-group">
								{{ Form::label('state', 'State') }}
								{{ Form::text('state', null, ['class' => 'form-control', 'placeholder'=>'Enter state name']) }}
							</div>
							<div class="form-group">
								{{ Form::label('zip', 'Zip Code') }}
								{{ Form::text('zip', null, ['class' => 'form-control', 'placeholder'=>'Enter zip code']) }}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							{!! Form::captcha() !!}
						</div>
					</div>
				</div>
				<div class="modal-footer">
					{{ Form::submit( 'Submit', ['class'=>'btn btn-primary signup-submit']) }}
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>


<div class="modal" id="messageDialog" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title title"></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body message">
			
			</div>
			<div class="modal-footer footer">
				<button class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>



{{-- Bootstrap core JavaScript --}}
<script src="{{ toolbox()->frontend()->asset('js/jquery.min.js') }}"></script>
<script src="{{ toolbox()->frontend()->asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{ toolbox()->frontend()->asset('/plugins/jquery-blockUI/jquery.blockUI.min.js') }}"></script>
<script src="{{ toolbox()->frontend()->asset('/vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="{{ toolbox()->frontend()->asset('/js/jquery.easing.min.js') }}"></script>
{{-- General Scripts --}}
<script src="{{ toolbox()->frontend()->asset('/js/new-age.min.js') }}"></script>
<script src="{{ toolbox()->userArea()->asset('/js/lib.js') }}"></script>
{{-- Page Specific --}}
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.25/gmaps.js"></script>
{!! JsValidator::formRequest( toolbox()->frontend()->request('SignupRequest'), '#form-signup')  !!}
{!! JsValidator::formRequest( toolbox()->frontend()->request('LoginRequest'), '#form-login')  !!}
{!! JsValidator::formRequest( toolbox()->frontend()->request('ForgotPasswordRequest'), '#form-forgot-password')  !!}

<script>

    function showInfoDialog(title, details) {
        var dlg = $('#messageDialog');
        $('.title', dlg).html(title);
        if ( typeof details === undefined || details == '' ) {
            $('.message', dlg).hide();
            $('.footer', dlg).hide();
        } else {
            $('.footer', dlg).show();
            $('.message', dlg).show().html(details);
        }
        dlg.modal('show');
    }

    function showErrorDialog(title, details) {
        var dlg = $('#messageDialog');
        $('.title', dlg).html(title);
        if (typeof details === undefined || details == '') {
            $('.message', dlg).hide();
        } else {
            $('.message', dlg).show().html(details);
        }
        dlg.modal('show');
    }


    {{-- Show dialogbox when a user successfully register --}}
    @if ( ($msg = session('success')) || ($msg = session('status')) )
		
        $(function() {
	        showInfoDialog( '{{ $msg }}', '{!! session('details') !!}');

	        // hide error on before showing the dialog
	        $('.modal').on('shown.bs.modal', function () {
	            $('.alert', $(this)).remove();
	        });
		});
		
	@elseif ( $msg = session('showLoginForm') )
	 
		$(function () {
			$('#login').modal('show');
	    });
		
	@elseif ( session('error') )

	    $(function () {
            showErrorDialog('{{ $msg }}', '{!! session('details') !!}');
	    });
		
	@endif
	
	
	$(function() {
        $('#form-login[ajax="on"]').on('submit', function () {
            var $me = $(this);
            appHelper
	            .ajaxForm(this, {
	                success: function( res ) {
                        location.href = res.redirect;
	                },
		            error: function ( err ) {
                        appHelper.showAlert( err.message, { type: 'danger', container: '#login .modal-body' } );
		            },
		            blockElement: $me
		            
	            });
            return false;
        });

        
	});
	
</script>

@yield('footer')

@stack('scripts')


</body>
</html>