@extends( toolbox()->userArea()->layout('basic') )

@section('content')
	
	@include( toolbox()->userArea()->view('partials.messages') )
	
	<form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}" autocomplete="off">
		
		<div class="msg">Reset Password</div>
		
		
		{{ csrf_field() }}
		<input type="hidden" name="token" value="{{ $token }}">
		
		<div class="input-group">
	        <span class="input-group-addon">
	            <i class="material-icons">person</i>
	        </span>
	        <div class="form-line">
	            <input type="text" class="form-control" name="email" placeholder="Email" value="{{ $email or old('email') }}" required autofocus>
	        </div>
	    </div>
		
		<div class="input-group">
	        <span class="input-group-addon">
	            <i class="material-icons">lock</i>
	        </span>
	        <div class="form-line">
	            <input type="password" class="form-control" name="password" placeholder="Password" required autofocus>
	        </div>
	    </div>
		
		
		<div class="input-group">
	        <span class="input-group-addon">
	            <i class="material-icons">lock</i>
	        </span>
	        <div class="form-line">
	            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autofocus>
	        </div>
	    </div>
		
		
		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<button type="submit" class="btn btn-primary">
					Reset Password
				</button>
			</div>
		</div>
	</form>




@endsection
