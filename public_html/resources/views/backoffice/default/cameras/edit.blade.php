@extends( toolbox()->backend()->layout('master') )

@section('heading')
	{!!
	toolbox()->backend()->themeHelper()->breadcrumb([
		'Cameras' => route('admin.cameras.manage'),
		ucwords($action) => null,
	])
	!!}
@endsection

@section('head')

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

				@if ( !isset($camera) )
					{!! Form::open( ['id' => 'upload_csv', 'route' => 'admin.cameras.store', 'method' => 'post', 'files' => true]) !!}
				@else
					{!! Form::model( $camera, ['id' => 'upload_csv', 'route' => ['admin.cameras.update'], 'method' => 'post', 'files' => true]) !!}
					{{ Form::hidden('id', $camera->id) }}
					{{ Form::hidden('creator_id', $camera->creator_id) }}
				@endif
					
				<div class="body firstScreen" style="padding-bottom: 0px;">
					<div class="row">
						<div class="col-md-6">
							{{ Form::label('name', 'Name *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'Enter name', 'required' => 'required']) }}
								</div>
							</div>

							{{ Form::label('dpi', 'DPI *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('dpi', null, ['class' => 'form-control', 'placeholder'=>'Enter dpi', 'required' => 'required']) }}
								</div>
							</div>

							{{ Form::label('check_connection_after', 'Check Internet Connection Availability After *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::number('check_connection_after', null, ['class' => 'form-control', 'placeholder'=>'Enter time in seconds', 'required' => 'required']) }}
								</div>
							</div>
						</div>
							
						<div class="col-md-6">
							{{ Form::label('size', 'Resolution *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('size', null, ['class' => 'form-control', 'placeholder'=>'Enter size', 'required' => 'required']) }}
								</div>
								<em><small>Example: 1080x1900</small></em>
							</div>

							{{ Form::label('images_per_second', 'Images Per Second *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('images_per_second', null, ['class' => 'form-control', 'placeholder'=>'Enter images per second', 'required' => 'required']) }}
								</div>
							</div>

							{{ Form::label('driver_id', 'Driver') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::select('driver_id', $allDrivers, null, ['class' => 'form-control', 'placeholder'=>'No driver', 'required' => 'required']) }}
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						{{ Form::label('active', 'Is active? *') }}
						<div class="form-group">
							
							{{ Form::radio('active', '1', null, [ 'id'=>'confirmedYes']) }}
							{{ Form::label('confirmedYes', 'Yes') }}
							
							{{ Form::radio('active', '0', null, ['id'=>'confirmedNo']) }}
							{{ Form::label('confirmedNo', 'No') }}
						
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							{{ Form::submit( isset($camera) ? 'Save' : 'Create', ['class'=>'btn btn-primary m-t-15 waves-effect submit area_done']) }}
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

		    $('.bn-cancel').click( function(e) {
		        appHelper.confirm(e, {message: 'Are you sure to cancel?', 'onConfirm': function() {
		            window.location = '{{ route('admin.cameras.manage') }}';
		        }});
		    });
			
		});
	</script>
@endsection