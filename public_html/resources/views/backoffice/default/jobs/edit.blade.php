@extends( toolbox()->backend()->layout('master') )

@section('heading')
	{!!
	toolbox()->backend()->themeHelper()->breadcrumb([
		'Drives' => route('admin.jobs.manage'),
		ucwords($action) => '',
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

				@if ( !isset($job) )
					{!! Form::open( ['route' => 'admin.jobs.store', 'method' => 'post', 'files' => true]) !!}
				@else
					{!! Form::model( $job, ['route' => ['admin.jobs.update'], 'method' => 'post', 'files' => true]) !!}
					{{ Form::hidden('id', $job->id) }}
				@endif
				
				<div class="body firstScreen" style="padding-bottom: 0px;">
					<div class="row">
						<div class="col-md-4">
							{{ Form::label('name', 'Drive Date *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'Select drive date', 'required' => 'required']) }}
								</div>
							</div>
						</div>
						<div class="col-md-4">
							{{ Form::label('area_id', 'Homeowner Association *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::select('area_id', $allAreas, null, ['class' => 'form-control chosen-select', 'placeholder'=>'Select an homeowner association', 'required' => 'required']) }}
								</div>
							</div>
						</div>
						<div class="col-md-4">
							{{ Form::label('driver_id', 'Driver') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::select('driver_id', $driversList, isset($driver) ? $driver : null, ['class' => 'form-control chosen-select', 'placeholder'=>'No Driver']) }}
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							{{ Form::submit( isset($job) ? 'Save' : 'Create', ['class'=>'btn btn-primary m-t-15 waves-effect submit area_done']) }}
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
	
	@if ( $action == 'create' )
		{!! JsValidator::formRequest( toolbox()->backend()->request('JobCreateRequest'))  !!}
	@else
		{!! JsValidator::formRequest( toolbox()->backend()->request('JobUpdateRequest'))  !!}
	@endif
	
	<script>
		$(function() {
			
		    if ( $('#name').val().toLowerCase() == 'invalid date' ) {
                $('input[name="name"]').val('');
		    }

            $('input[name="name"]').daterangepicker(
                {
	                singleDatePicker: true,
	                showDropdowns: true,
			        //autoUpdateInput: false,
	                locale: {
	                    format: 'YYYY-MM-DD'
	                }
	            },
	            function (start, end, label) {
                    //$('input[name="name"]').val( start.format('YYYY-MM-DD') );
                }
            );
            
			$(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
			
		    $('.bn-cancel').click( function(e) {
		        appHelper.confirm(e, {message: 'Are you sure to cancel?', 'onConfirm': function() {
		            window.location = '{{ route('admin.jobs.manage') }}';
		        }});
		    });
		    

			
		});
	</script>
@endsection