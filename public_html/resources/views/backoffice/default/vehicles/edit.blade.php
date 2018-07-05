@extends( toolbox()->backend()->layout('master') )

@section('heading')
{!!
toolbox()->backend()->themeHelper()->breadcrumb([
	'Driver' => route('admin.vehicles.manage'),
	ucwords($action) => null
])
!!}
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
						{{ ucwords($action) }}
					</h2>
				</div>

				@if ( !isset($vehicle) )
					{!! Form::open( ['id' => 'upload_csv', 'route' => 'admin.vehicles.store', 'method' => 'post', 'files' => true]) !!}
				@else
					{!! Form::model( $vehicle, ['id' => 'upload_csv', 'route' => ['admin.vehicles.update'], 'method' => 'post', 'files' => true]) !!}
					{{ Form::hidden('id', $vehicle->id) }}
				@endif
					
				<div class="body firstScreen" style="padding-bottom: 0px;">
					<div class="row">
						<div class="col-md-4">
							{{ Form::label('name', 'Name *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'Enter vehicle name', 'required' => 'required']) }}
								</div>
							</div>
						</div>
						<div class="col-md-4">
							{{ Form::label('driver_id', 'User') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::select('driver_id', $allUsers, null, ['class' => 'form-control chosen-select', 'placeholder'=>'No User', 'required' => 'required']) }}
								</div>
							</div>
						</div>
						<div class="col-md-4">
							{{ Form::label('active', 'Is active? *') }}
							<div class="form-group">
								
								{{ Form::radio('active', '1', null, [ 'id'=>'confirmedYes']) }}
								{{ Form::label('confirmedYes', 'Yes') }}
								
								{{ Form::radio('active', '0', null, ['id'=>'confirmedNo']) }}
								{{ Form::label('confirmedNo', 'No') }}
							
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							{{ Form::submit( isset($vehicle) ? 'Save' : 'Create', ['class'=>'btn btn-primary m-t-15 waves-effect submit area_done']) }}
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
	
	{!! JsValidator::formRequest( toolbox()->backend()->request('VehicleRequest'))  !!}
	
	<script>
		$(function() {

			$(".chosen-select").chosen({no_results_text: "Oops, nothing found!"}); 

		    $('.bn-cancel').click( function(e) {
		        appHelper.confirm(e, {message: 'Are you sure to cancel?', 'onConfirm': function() {
		            window.location = '{{ route('admin.vehicles.manage') }}';
		        }});
		    });
			
		});
	</script>
@endsection