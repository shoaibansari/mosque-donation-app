@extends( toolbox()->userArea()->layout('basic'))
@section('title', 'Forgot Password')

@section('content')
	
	<form id="forgot_password" method="POST" action="{{ route('password.email')}}">
		{{ csrf_field() }}
		<div class="msg">
			Enter your email address that you used to register. We'll send you an email with your username and a
			link to reset your password.
		</div>
		@include( toolbox()->frontend()->view('partials.messages') )
		
		<div class="input-group">
	        <span class="input-group-addon">
	            <i class="material-icons">email</i>
	        </span>
			<div class="form-line">
				<input type="email" class="form-control" name="email" placeholder="Email" required autofocus>
			</div>
		</div>
		
		<button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">RESET MY PASSWORD</button>
		
		<div class="row m-t-20 m-b--5 align-center">
			<a href="{{ route('login') }}">Login</a>
		</div>
	</form>
	
@endsection