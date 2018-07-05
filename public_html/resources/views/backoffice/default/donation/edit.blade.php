@extends( toolbox()->backend()->layout('master') )

@section('heading')
	{!!
	toolbox()->backend()->themeHelper()->breadcrumb([
		'Donation' => route('admin.donation.manage'),
		ucwords($action) => '',
	])
	!!}
@endsection

@section('head')
	{{-- <link href="{{ toolbox()->userArea()->asset('plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"/> --}}
	<style>
		#permissions-table label {
			margin-bottom: -12px;
		}
	</style>
@endsection

@section('contents')
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						{{ ucwords($action) }} Donation
					</h2>
				</div>
				<div class="body">
					
					@if ( !isset($donation) )
						{!! Form::open( ['route' => 'admin.donation.store', 'method' => 'post', 'files' => false]) !!}
					@else
						{!! Form::model( $donation, ['route' => ['admin.donation.update'], 'method' => 'post', 'files' => false]) !!}
						{{ Form::hidden('id', $donation->id) }}
					@endif
					 <div class="row">
					 	<div class="col-md-4">
							{{ Form::label('donation_title', 'Title *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('donation_title', null, ['class' => 'form-control', 'placeholder'=>'Enter donation title']) }}
								</div>
							</div>
						</div>
                        
                        
                        <div class="col-md-4">
							{{ Form::label('required_amount', 'Amount *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::number('required_amount', null, ['class' => 'form-control', 'placeholder'=>'Enter donation required amount']) }}
								</div>
							</div>
						</div>
                        
                        <div class="col-md-4">
							{{ Form::label('start_date', 'Start Date *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::date('start_date', null, ['class' => 'form-control', 'placeholder'=>'Enter donation start date']) }}
								</div>
							</div>
						</div>
                        
                        <div class="col-md-4">
							{{ Form::label('end_date', 'End Date *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::date('end_date', null, ['class' => 'form-control', 'placeholder'=>'Enter donation end date']) }}
								</div>
							</div>
					    </div>


						<div class="col-md-4">
							{{ Form::label('mosque_id', 'Mosque *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::select('mosque_id', $mosque, null ,['class' => 'form-control chosen-select']) }}
								</div>
							</div>
						</div>

						<div class="col-md-4">
							{{ Form::label('is_active', 'Active *') }}
							<div class="form-group">

								{{ Form::radio('is_active', '1', null, [ 'id'=>'is_activeYes']) }}
								{{ Form::label('is_activeYes', 'Yes') }}

								{{ Form::radio('is_active', '0', null, ['id'=>'is_activeNo']) }}
								{{ Form::label('is_activeNo', 'No') }}

							</div>
						</div>


						<div class="col-md-8">
							{{ Form::label('donation_description', 'Description *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::textarea('donation_description', null, ['class' => 'form-control', 'placeholder'=>'Enter donation description','size' => '10x3']) }}
								</div>
							</div>
						</div>
						

						</div>{{-- end row --}}
						
						
						{{ Form::submit( isset($donation) ? 'Save' : 'Create', ['class'=>'btn btn-primary m-t-15 waves-effect submit']) }}
						{{ Form::button('Cancel', ['class'=>'btn btn-danger m-t-15 waves-effect bn-cancel']) }}
					
					{!! Form::close() !!}
					
				</div>
			</div>
		</div>
	</div>
	
@endsection

@section('footer')
	
	{{-- <script src="{{ toolbox()->asset('/plugins/jquery/jquery.min.js') }}"></script> --}}
	
	<script>
		//$('input[name="start_date"]').daterangepicker();
		// $(document).ready(function() {

		//     $('.datepicker').daterangepicker({
		//         format: 'dd/mm/yyyy'
		//     });
		// });
       

		$(function() {
            // $('.datepicker').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
            $('.bn-cancel').click( function(e) {
		        appHelper.confirm(e, {message: 'Are you sure to cancel?', 'onConfirm': function() {
		            window.location = '{{ route('admin.donation.manage') }}';
		        }});
		    });                     
           		   
		});
	</script>
@endsection