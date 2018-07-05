@extends( toolbox()->backend()->layout('master') )

@section('heading')
	My Profile
@endsection

@section('contents')
	
	<!-- Vertical Layout -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						Personal
					</h2>
				</div>
				<div class="body">
					@if ( !isset($thisUser) )
						{!! Form::open( ['route' => 'admin.store', 'method' => 'post', 'files' => true, 'class' => 'profile-form']) !!}
					@else
						{!! Form::model( $thisUser, ['route' => ['admin.update'], 'method' => 'post', 'files' => true, 'class' => 'profile-form']) !!}
						{{ Form::hidden('id', $thisUser->id) }}
					@endif
					
					{{ Form::label('name', 'Name *') }}
					<div class="form-group">
						<div class="form-line">
							{{ Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'Enter your name']) }}
						</div>
					</div>
					
					{{ Form::label('email', 'Email Address *') }}
					<div class="form-group">
						<div class="form-line">
							{{ Form::email('email', null, ['class' => 'form-control', 'placeholder'=>'Enter your email address']) }}
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-10">
							{{ Form::label('avatar', 'Avatar') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::file('avatar', null, ['class' => 'form-control', 'placeholder'=>'Select an avatar']) }}
								</div>
							</div>
						</div>
						<div class="col-md-2 ">
							{{ Form::label('preview', 'Avatar Preview', ['class'=>'center-block text-center']) }}
				      		<img class="center-block img-responsive" src="{{ $thisUser->getAvatarUrl() }}">
							@if ( $thisUser->hasAvatar() )
							<button type="button" class="btn btn-danger btn-xs waves-effect center-block bn-delete" style="margin-top: 7px; display: block !important;">
								Delete
							</button>
							@endif
						</div>
					</div>
					
					{{ Form::submit( 'Save', ['class'=>'btn btn-primary m-t-15 waves-effect submit']) }}
				
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
	<!-- #END# Vertical Layout -->
	
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						Change Password
					</h2>
				</div>
				<div class="body">
					
					{!! Form::open( ['route' => 'admin.password.update', 'method' => 'post', 'class' => 'chw-password-form']) !!}
					
						{{ Form::label('current_password', 'Current Password') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::password('current_password', ['class' => 'form-control', 'placeholder'=>'Enter current password']) }}
							</div>
						</div>
					
						{{ Form::label('password', 'New Password') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::password('password', ['class' => 'form-control', 'placeholder'=>'Enter new password']) }}
							</div>
						</div>
						
						{{ Form::label('password_confirmation', 'Retype New Password') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder'=>'Reenter new password']) }}
							</div>
						</div>
					
						{{ Form::submit( 'Save', ['class'=>'btn btn-primary m-t-15 waves-effect submit']) }}
					
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
	
@endsection

@section('footer')
	{{-- {!! JsValidator::formRequest( toolbox()->backend()->request('AdminProfileUpdateRequest'), '.profile-form')  !!}
	{!! JsValidator::formRequest( toolbox()->backend()->request('AdminPasswordUpdateRequest'), '.chw-password-form')  !!} --}}
	
	<script>
        $(function () {
            $('.bn-delete').click(function (e) {
                appHelper.confirm(e, {
                    message: 'Are you sure to remove avatar?', 'onConfirm': function () {
                        window.location = '{{ route('admin.remove.avatar') }}';
                    }
                });
            });
        });
	</script>
@endsection

