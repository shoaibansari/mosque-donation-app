@extends( toolbox()->userArea()->layout('master') )

@section('heading')
	{!!
	toolbox()->backend()->themeHelper()->breadcrumb([
		'Donation' => route('donation.manage'),
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
						{!! Form::open( ['route' => 'donation.store', 'method' => 'post', 'files' => false]) !!}
					@else
						{!! Form::model( $donation, ['route' => ['donation.update'], 'method' => 'post', 'files' => false]) !!}
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


						<!-- <div class="col-md-4">
							{{ Form::label('mosque_id', 'Mosque *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::select('mosque_id', $mosque, null ,['class' => 'form-control chosen-select']) }}
								</div>
							</div>
						</div>
 -->

						

						<div class="col-md-4">
							{{ Form::label('is_active', 'Active *') }}
							<div class="form-group">

								{{ Form::radio('is_active', '1', null, [ 'id'=>'is_activeYes']) }}
								{{ Form::label('is_activeYes', 'Yes') }}

								{{ Form::radio('is_active', '0', null, ['id'=>'is_activeNo']) }}
								{{ Form::label('is_activeNo', 'No') }}

							</div>
						</div>

						 <div class="col-md-12">
							{{ Form::label('donation_description', 'Description *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::textarea('donation_description', null, ['class' => 'form-control', 'placeholder'=>'Enter donation description','size' => '10x2']) }}
								</div>
							</div>
						</div>


						</div>{{-- end row --}}
						
						
						{{ Form::submit( isset($role) ? 'Save' : 'Create', ['class'=>'btn btn-primary m-t-15 waves-effect submit']) }}
						{{ Form::button('Cancel', ['class'=>'btn btn-danger m-t-15 waves-effect bn-cancel']) }}
					
					{!! Form::close() !!}
					
				</div>
			</div>
		</div>
	</div>
	
@endsection

@section('footer')
	{{-- 
	<script src="{{ toolbox()->userArea()->asset('plugins/bootstrap-select/js/bootstrap-select.js') }}"></script> --}}
	
	
	
	<script>
		$(function() {
		    
             //$(".chosen-select").chosen({no_results_text: "Oops, nothing found!"}); 
            
		   
		});
	</script>
@endsection