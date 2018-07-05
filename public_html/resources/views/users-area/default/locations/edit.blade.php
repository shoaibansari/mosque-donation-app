@extends( toolbox()->userArea()->layout('master') )

@section('heading')
	Location
@endsection

@section('head')
	<link href="{{ toolbox()->backend()->asset('plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"/>
@endsection

@section('contents')
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						@if ( $action == 'create' )
							Request
						@else
							Edit
						@endif
					</h2>
				</div>

				@if ( !isset($location) )
					{!! Form::open( ['route' => 'users.locations.store', 'method' => 'post', 'files' => false, 'id' => 'fromRequestLocation']) !!}
				@else
					{!! Form::model( $location, ['route' => ['users.locations.update'], 'method' => 'post', 'files' => false, 'id' => 'fromRequestLocation']) !!}
					{{ Form::hidden('id', $location->id) }}
				@endif
				{!! Form::hidden('latitude', null, ['id' => 'latitude']) !!}
				{!! Form::hidden('longitude', null, ['id' => 'longitude']) !!}
				{!! Form::hidden('address', null, ['id' => 'address']) !!}
				
				<div class="body firstScreen" style="padding-bottom: 0px;">
					<div class="row">
						<div class="col-md-6">
							{{ Form::label('street', 'Street *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('street', null, ['class' => 'form-control', 'placeholder'=>'Enter street']) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							{{ Form::label('city', 'City *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('city', null, ['class' => 'form-control', 'placeholder'=>'Enter city']) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							{{ Form::label('state', 'State *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::select('state', $allStates, null, ['class' => 'form-control', 'placeholder'=>'Select state']) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							{{ Form::label('zip', 'Zip Code *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('zip', null, ['class' => 'form-control', 'placeholder'=>'Enter zip code']) }}
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							{{ Form::button( isset($location) ? 'Save' : 'Send Request', ['class'=>'btn btn-primary m-t-15 waves-effect bn-save']) }}
							{{ Form::button('Cancel', ['class'=>'btn btn-danger m-t-15 waves-effect bn-cancel']) }}
						</div>
					</div>
				</div>

				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection

@section('footer')
	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.25/gmaps.js"></script>
	
	@if ( $action == 'create' )
		{!! JsValidator::formRequest( toolbox()->userArea()->request('LocationCreateRequest'))  !!}
	@else
		{!! JsValidator::formRequest( toolbox()->userArea()->request('LocationUpdateRequest'))  !!}
	@endif
	
	<script>
		$(function() {
			
		    $('.bn-cancel').click( function(e) {
		        appHelper.confirm(e, {message: 'Are you sure to cancel?', 'onConfirm': function() {
		            window.location = '{{ route('users.locations') }}';
		        }});
		    });
		    
		    $('.bn-save').click(function(e) {
				console.log('x');
                if ( $('#street').val().length && $('#city').val().length && $('#state').val().length && $('#zip').val().length ) {
                    console.log('y');
                    var address = $('#street').val()
                        + ' ' + $('#city').val()
                        + ' ' + $('#state').val()
                        + ' ' + $('#zip').val();
                    console.log(address);
                    GMaps.geocode({
                        address: address,
                        callback: function (results, status) {
                            if (status == 'OK') {
                                    var location = results[0].geometry.location;
                                    console.log(location.lat(), location.lng());
                                    $('#address').val(address);
                                    $('#latitude').val(location.lat());
                                    $('#longitude').val(location.lng());
                                    $('#fromRequestLocation').submit();
                            } else {
                                alert('The Google map is not understanding the provided location details. Please correct location details.');
                                console.error(results, status);
                            }
                        }
                    });
                }
                console.log('z');
		    });
			
		});
	</script>
@endsection