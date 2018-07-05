@extends( toolbox()->userArea()->layout('master') )

@section('heading')
	Users
@endsection

@section('head')
	<link href="{{ toolbox()->userArea()->asset('plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"/>
@endsection

@section('contents')
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						{{ ucwords($action) }} User
					</h2>
				</div>
				<div class="body">
					
					@if ( !isset($user) )
						{!! Form::open( ['route' => 'users.store', 'method' => 'post', 'files' => true]) !!}
					@else
						{!! Form::model( $user, ['route' => ['users.update'], 'method' => 'post', 'files' => true]) !!}
						{{ Form::hidden('id', $user->id) }}
					@endif
					
						{{ Form::label('name', 'Name *') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'Enter user name']) }}
							</div>
						</div>
						
						{{ Form::label('email', 'Email *') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::text('email', null, ['class' => 'form-control', 'placeholder'=>'Enter email address']) }}
							</div>
						</div>
						
						{{ Form::label('password', 'Password *') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::password('password', ['class' => 'form-control', 'placeholder'=>'Enter password']) }}
							</div>
						</div>
						
						{{ Form::label('password_confirmation', 'Re-enter Password *') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder'=>'Re-enter password']) }}
							</div>
						</div>
						
						
						{{--@if ( isset($user) && $user->id != repo()->user()->getModel()->OWNER_ID )--}}
						{{ Form::label('role_id', 'Role *') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::select( 'role_id', $roles, null, ['class' => 'form-control', 'placeholder'=>'Select a role']) }}
							</div>
						</div>
						{{--@endif--}}
						
						@if ( !isset($user) || (isset($user) && $user->is_deletable) )
							{{ Form::label('is_confirmed_user', 'Required email confirmation? *') }}
							<div class="form-group">
								
								{{ Form::radio('is_confirmed', '1', null, [ 'id'=>'confirmedYes']) }}
								{{ Form::label('confirmedYes', 'Yes') }}
								
								{{ Form::radio('is_confirmed', '0', null, ['id'=>'confirmedNo']) }}
								{{ Form::label('confirmedNo', 'No') }}
							
							</div>
						@endif
						
						<div class="row">
							@if ( isset( $user ) )
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
									<img class="center-block" src="{{ $user->getAvatarUrl() }}" class="img-responsive">
									@if ( $user->hasAvatar() )
										<button type="button" class="btn btn-danger btn-xs waves-effect center-block bn-delete" style="margin-top: 7px; display: block !important;">
											Delete
										</button>
									@endif
								</div>
							@else
								<div class="col-md-12">
									{{ Form::label('avatar', 'Avatar') }}
									<div class="form-group">
										<div class="form-line">
											{{ Form::file('avatar', null, ['class' => 'form-control', 'placeholder'=>'Select an avatar']) }}
										</div>
									</div>
								</div>
							@endif
						</div>
						
						{{ Form::submit( isset($user) ? 'Save' : 'Create', ['class'=>'btn btn-primary m-t-15 waves-effect submit']) }}
						{{ Form::button('Cancel', ['class'=>'btn btn-danger m-t-15 waves-effect bn-cancel']) }}
					
					{!! Form::close() !!}
					
				</div>
			</div>
		</div>
	</div>
	
@endsection

@section('footer')
	
	<script src="{{ toolbox()->userArea()->asset('plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
	
	@if ( $action == 'create' )
		{!! JsValidator::formRequest( toolbox()->userArea()->request('UserCreateRequest'))  !!}
	@else
		{!! JsValidator::formRequest( toolbox()->userArea()->request('UserUpdateRequest'))  !!}
	@endif
	
	<script>
		$(function() {

		    $('.bn-cancel').click( function(e) {
		        appHelper.confirm(e, {message: 'Are you sure to cancel?', 'onConfirm': function() {
		            window.location = '{{ route('users.manage') }}';
		        }});
		    });
			
            // :::: Events trigger on page load ::::
			
			
            
		   
		});
	</script>
@endsection