@extends( toolbox()->backend()->layout('master') )

@section('heading')
	Homeowner Location
@endsection

@section('head')
	<link href="{{ toolbox()->backend()->asset('plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"/>
@endsection

@section('contents')

<div class="pull-right">	
		@php 
		if($previous){ @endphp	
			<a href="{{route('admin.area.location.edit', [$area_id, $previous])}}" class="btn btn-default waves-effect ">Previous</a>
		@php } if($next) { @endphp
			<a href="{{route('admin.area.location.edit',[$area_id, $next])}}" class="btn btn-default waves-effect ">Next</a>
	    @php } @endphp
	</div>	
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						{{ ucwords($action) }}
					</h2>
				</div>

				@if ( !isset($location) )
					{!! Form::open( ['route' => 'admin.area.location.store', 'method' => 'post', 'files' => false]) !!}
				@else
					{!! Form::model( $location, ['route' => ['admin.area.location.update'], 'method' => 'post', 'files' => false]) !!}
					{{ Form::hidden('id', $location->id) }}
					{{ Form::hidden('latitude', $location->latitude) }}
					{{ Form::hidden('longitude', $location->longitude) }}
					{{ Form::hidden('area_id', $area_id) }}
				@endif
					
				<div class="body firstScreen" style="padding-bottom: 0px;">
					<div class="row">
						<div class="col-md-6">
							{{ Form::label('address', 'Address *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('address', null, ['class' => 'form-control', 'placeholder'=>'Enter address', 'required' => 'required']) }}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							{{ Form::label('homeowner_id', 'Homeowner *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::select('homeowner_id', $allUsers, null, ['class' => 'form-control chosen-select', 'placeholder'=>'Select user', 'required' => 'required']) }}
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="body secondScreen" @if ( !isset($location) ) style="height: 0px; overflow: hidden; padding: 0px;" @endif>
					<div class="row">
						<div class="col-md-12">
							<div id="map" style="width: 100%; height: 350px"></div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12 actionButtons">
							{{ Form::submit( isset($location) ? 'Save' : 'Create', ['class'=>'btn btn-primary m-t-15 waves-effect submit area_done']) }}
							{{ Form::button('Cancel', ['class'=>'btn btn-danger m-t-15 waves-effect bn-cancel']) }}
						</div>
					</div>
				</div>

				<div class="body thirdScreen" style="display: none;">
				</div>

				{!! Form::close() !!}
			</div>
		</div>
	</div>

@endsection

@section('footer')

	<script type="text/javascript">
	    var map;

	    $(document).ready(function(){
			map = new GMaps({
				div: '#map',
				lat: -12.043333,
				lng: -77.028333
			});
	    });
	</script>

	@if(isset($location))
		<script type="text/javascript">
		    $(document).ready(function(){
		      	map.addMarker({
		      		title: "{!! $location->address !!}",
		        	lat: "{!! $location->latitude !!}",
		        	lng: "{!! $location->longitude !!}",
		        	draggable: true,
		        	icon: "{{ toolbox()->backend()->asset('images/blue-dot.png') }}",
		        	customInfo: "{!! $location->homeowner_id !!}"
		      	});
		      	map.setCenter("{!! $location->latitude !!}", "{!! $location->longitude !!}");

		      	$('.area_done').on("click", function(e){
			      	$(map.markers).each(function(index, value){
			      		if (value.map) {
			      			$('input[name="longitude"]').val(value.position.lng());
			      			$('input[name="latitude"]').val(value.position.lat());
			      		}
			      	});
		      	});
		    });
		</script>
	@endif

	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.25/gmaps.js"></script>
	{!! JsValidator::formRequest( toolbox()->backend()->request('AreaLocationRequest'))  !!}
	
	<script>
		$(function() {
		    $('.bn-cancel').click( function(e) {
		        appHelper.confirm(e, {message: 'Are you sure to cancel?', 'onConfirm': function() {
		            window.location = '{{ route('admin.areas.edit', $area_id) }}';
		        }});
		    });
		});
	</script>
@endsection