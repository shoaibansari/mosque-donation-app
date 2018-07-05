@extends( toolbox()->frontend()->layout('master') )

@section('contents')
	
	{{-- Password Reset Dialog --}}
	<div class="modal fade" id="reset-password" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				
				
				{!! Form::open( ['route' => 'password.sendLink', 'method' => 'post', 'files' => false, 'id'=> 'form-reset-password']) !!}
				{!! Form::hidden('token', $token ); !!}
				<div class="modal-header">
					<h4 class="modal-title">Reset Password.</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					@include( toolbox()->frontend()->view('partials.messages') )
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							{{ Form::email('email', old('email', $email), ['class' => 'form-control', 'placeholder'=>'Enter your email address', 'readonly'=>'']) }}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							{{ Form::password('password', ['class' => 'form-control', 'placeholder'=>'Enter new password']) }}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							{{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder'=>'Confirm new password']) }}
						</div>
					</div>
				
				</div>
				<div class="modal-footer">
					{{ Form::submit( 'Reset Password', ['class'=>'btn btn-primary']) }}
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	{{--  END of Passowrd Reset Dialog --}}
@endsection


@push('scripts')
	{!! JsValidator::formRequest( toolbox()->frontend()->request('ResetPasswordRequest'), '#form-reset-password')  !!}
	<script>
		$(function() {
            $('#reset-password').modal('show');
        });
	</script>
@endpush