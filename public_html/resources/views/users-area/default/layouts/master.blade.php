<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>@section('title') {{ 'Users Portal::'. settings()->getAppName() }} @show</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="description" content="@section('meta_description') @show">
	<meta name="keywords" content="@section('meta_keywords') @show">
	<meta name="author" content="FSD Solutions">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ toolbox()->asset('/favicon.ico') }}" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
{{--	<link href="{{ toolbox()->backend()->asset('/css/fonts.css') }}" rel="stylesheet">--}}
{{--	<link href="{{ toolbox()->backend()->asset('/css/material-icons.css') }}" rel="stylesheet" type="text/css">--}}
    <link href="{{ toolbox()->asset('/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ toolbox()->asset('/plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet" >
	<link href="{{ toolbox()->asset('/plugins/node-waves/waves.css') }}" rel="stylesheet" />
    <link href="{{ toolbox()->asset('/plugins/animate-css/animate.css') }}" rel="stylesheet" />
    <link href="{{ toolbox()->asset('/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />
    <link href="{{ toolbox()->asset('/plugins/waitme/waitMe.css') }}" rel="stylesheet">
    <link href="{{ toolbox()->userArea()->asset('/css/style.css') }}" rel="stylesheet">
    <link href="{{ toolbox()->userArea()->asset('/css/themes/all-themes.min.css') }}" rel="stylesheet">
	{{-- BEGIN PLUGIN MANAGER SPECIFIC STYLES --}}
	{!! toolbox()->pluginsManager()->renderStylesheets() !!}
	{{-- END PLUGIN MANAGER STYLES --}}
	<link href="{{ toolbox()->userArea()->asset('/css/custom.css') }}" rel="stylesheet">
	@yield('head')
</head>
<body class="theme-indigo" data-url="{{ toolbox()->userArea()->url() }}" data-assets-url="{{ toolbox()->userArea()->assetsUrl() }}">
	
	<!-- Page Loader -->
	<div class="page-loader-wrapper">
		<div class="loader">
			<div class="preloader">
				<div class="spinner-layer pl-red">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>
			</div>
			<p>Please wait...</p>
		</div>
	</div>
	<div class="overlay"></div>
	<nav class="navbar">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
				<a href="javascript:void(0);" class="bars"></a>
				<a class="navbar-brand" href="{{ settings()->getAdminUrl('dashboard') }}">{{ settings()->getAppName() }}</a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					{{--
					<li class="">
						<a href="{{ toolbox()->frontend()->url('') }}" target="_blank" data-toggle="" role="button">
							<i class="material-icons">launch</i>
							<span style="position: relative; top: -7px;">Browse Front Website</span>
						</a>
						</a>
					</li>
					--}}
					<li class="">
						<a href="{{ route('logout') }}" class="logout" data-toggle="" role="button">
							<i class="material-icons">input</i>
							<span style="position: relative; top: -7px;">Logout</span>
						</a>
						</a>
					</li>
					
				</ul>
			</div>
		</div>
	</nav>
	
	<section>
		@include( toolbox()->userArea()->view('partials.sidebar-left') );
		{{--
		@include( toolbox()->userArea()->view('partials.sidebar-right') );
		--}}
	</section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					
					@hasSection('heading')
					<div class="block-header">
						<h2>@yield('heading')</h2>
					</div>
					@endif
	
					@include( toolbox()->userArea()->view('partials.messages') )
	
				</div>
			</div>
	
			@yield('contents')
			
		</div>
	</section>

	<div class="modal fade" id="infoDialog" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel"></h4>
				</div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">OKAY</button>
				</div>
			</div>
		</div>
	</div>

	<script src="{{ toolbox()->asset('/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ toolbox()->asset('/plugins/bootstrap/js/bootstrap.js') }}"></script>
	<script src="{{ toolbox()->asset('/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
	<script src="{{ toolbox()->asset('/plugins/node-waves/waves.js') }}"></script>
	<script src="{{ toolbox()->asset('/plugins/autosize/autosize.js') }}"></script>
	<script src="{{ toolbox()->asset('/plugins/jquery-blockUI/jquery.blockUI.min.js') }}"></script>
	<script src="{{ toolbox()->asset('/plugins/sweetalert/sweetalert.min.js') }}"></script>
	<script src="{{ toolbox()->asset('/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>
	<script src="{{ toolbox()->asset('/plugins/jsvalidation/js/jsvalidation.js')}}"></script>
	
	<script src="{{ toolbox()->backend()->asset('/js/admin.js') }}"></script>
	{{-- BEGIN PLUGIN MANAGER SCRIPTS --}}
	{!! toolbox()->pluginsManager()->renderScripts() !!}
	{{-- END PLUGIN MANAGER SCRIPTS --}}
	<script src="{{ toolbox()->backend()->asset('/js/lib.js') }}"></script>
	
	<script>
	    $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });
	</script>
	<script src="{{ toolbox()->userArea()->asset('/js/lib.js') }}"></script>
	<script src="{{ toolbox()->userArea()->asset('/js/admin.js') }}"></script>
	{{-- BEGIN PLUGIN MANAGER SCRIPTS --}}
	{!! toolbox()->userArea()->pluginsManager()->renderScripts() !!}
	{{-- END PLUGIN MANAGER SCRIPTS --}}
	<script>
		
		function showInfoDialog(title, details, callback ) {
            var dlg = $('#infoDialog');
            $('.modal-title', dlg).html(title);
            if (typeof details == 'undefined' || details == '') {
                $('.modal-body', dlg).hide();
                $('.modal-footer', dlg).hide();
            } else {
                $('.modal-body', dlg).show().html(details);
                $('.modal-footer', dlg).show();
            }
            if ( typeof callback === 'function' ) {
                $('.btn-link', dlg).click ( function(e) {
                    callback.call(e);
                });
            }
            dlg.modal('show');
        }

        function sessionChecker( ) {
            appHelper.ajax('{{ route('check.session') }}', {
                method: 'GET',
                block: false,
                success: function (r) {
                    if (r.expired == 'yes') {
                        showInfoDialog('Session Expired!', 'Your session has expired. Please do login again to continue.', function() {
                            location.href = '{{ route('login') }}';
                        });
                    }
                    else {
                        setTimeout(function () {
                            sessionChecker();
                        }, 3000);
                    }
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
        
		$(function() {
		    sessionChecker( );
		    $('.logout').click(function( e ) {
		        var me = this;
                appHelper.confirm( e, { 'message': 'Are you sure to logout?', 'onConfirm': function() {
                    window.location = me.href;
                }});
		    });
      
		})
	</script>

	@yield('footer')

	@stack('scripts')


</body>
</html>