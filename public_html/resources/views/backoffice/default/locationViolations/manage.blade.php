@extends( toolbox()->backend()->layout('master') )

@section('heading')
{!!
	toolbox()->backend()->themeHelper()->breadcrumb([
		'Reported Violations' => route('admin.location.violations.manage'),
	])
!!}
@endsection

@section('head')
	<style media="screen">
		.hide-image {
			display: none;
		}
	</style>
@endsection


@section('contents')
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				
				<div class="header">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<h2>
							Manage
						</h2>
					</div>
					<div class="clearfix"></div>
				</div>
				
				<div class="body">
					
					<form method="POST" id="search-form" class="form-inline" role="form"  style="margin-bottom: 25px;">
						
						<div style="border: 1px solid #dcdcdc; margin-bottom: 5px; padding: 20px; background: #f4f4f4">
							
							<div class="row ">
								<div class="col-md-6">
									<div class="form-group">
										{{ Form::label('hoa[]', 'HOA') }}
										{{ Form::select('hoa[]', [], null, ['class' => 'form-control hoa select2', 'multiple' => 'multiple']) }}
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										{{ Form::label('homeowner[]', 'Homeowner') }}
										{{ Form::select('homeowner[]', [], null, ['class' => 'form-control homeowner select2', 'multiple' => 'multiple']) }}
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										{{ Form::label('email[]', 'Homeowner Email Address') }}
										{{ Form::select('email[]', [], null, ['class' => 'form-control email select2', 'multiple' => 'multiple']) }}
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										{{ Form::label('status[]', 'Violation Status') }}
										{{ Form::select('status[]', [], null, ['class' => 'form-control status select2', 'multiple' => 'multiple']) }}
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										{{ Form::label('locations[]', 'Address') }}
										{{ Form::select('locations[]', [], null, ['class' => 'form-control locations select2', 'multiple' => 'multiple']) }}
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										{{ Form::label('violations[]', 'Violation') }}
										{{ Form::select('violations[]', $violations, null, ['class' => 'form-control violations select2', 'multiple' => 'multiple']) }}
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Last Update</label>
										<div id="date_range" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
											<input type="hidden" name="report_between" id="report_between" class="report_between">
											<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
											<span>Select a date or date range</span> <b class="caret"></b>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
									<button type="submit" class="btn btn-primary">Search</button>
									<button type="button" class="btn btn-warning btn-clear-search">Clear Search</button>
								</div>
							</div>
							
						</div>
					</form>
					
					{!! $dataTable->table(['id' => 'locationTable']) !!}
					
				</div>
			</div>
		</div>
	</div>

@endsection

@push('scripts')
	
	{!! $dataTable->scripts() !!}
	
	<script>

        var dataTable = LaravelDataTables["locationTable"];
		var tmp = null;
		
		function getSelect2ElementText( select2Selector, separator ) {
            var arr = $( select2Selector ).select2('data');
            if ( !separator )
                separator = ',';
            var output = [];
            $.each(arr, function (i, val) {
                output[i] = val.text;
            });
            if ( output.length ) {
                return output.join( separator );
            }
            return null;
		}
		
        $(function () {
            
            // homeowner
            $('#search-form .homeowner').select2({
                placeholder: 'Homeowner',
                //minimumInputLength: 1,
                minimumResultsForSearch: 5,
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.homeowners.list', 'name') }}',
                    dataType: 'json',
                    delay: 100,
                    cache: true,
                    results: function (data) {
                        return data;
                    }
                }
            });

            // email
            $('#search-form .email').select2({
                placeholder: 'Email',
                //minimumInputLength: 1,
                minimumResultsForSearch: 5,
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.homeowners.list', 'email') }}',
                    dataType: 'json',
                    delay: 100,
	                cache: true,
                    results: function (data) {
                        return data;
                    }
                }
            });

            // HOAs
            $('#search-form .hoa').select2({
                placeholder: 'HOA',
                //minimumInputLength: 1,
                minimumResultsForSearch: 5,
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.areas.list', 'title') }}',
                    dataType: 'json',
                    delay: 100,
                    cache: true,
                    results: function (data) {
                        return data;
                    }
                }
            });

            // Status
            $('#search-form .status').select2({
                placeholder: 'Status',
                //minimumInputLength: 1,
                minimumResultsForSearch: 5,
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.violations.status.list', 'title') }}',
                    dataType: 'json',
                    delay: 100,
                    cache: true,
                    results: function (data) {
                        return data;
                    }
                }
            });

            $("#search-form .violations").select2({
                placeholder: 'Violation'
            });

            // Locations
            $('#search-form .locations').select2({
                placeholder: 'Address',
                //minimumInputLength: 1,
                minimumResultsForSearch: 5,
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.locations.list', 'address') }}',
                    dataType: 'json',
                    delay: 100,
                    cache: true,
                    results: function (data) {
                        return data;
                    }
                }
            });
	        
			        
			{{-- <Date Range Calendar> --}}
            var start = moment().subtract(29, 'days');
            var end = moment();

            function dateRangeCallback(start, end) {
                $('#date_range span').html('<strong>From:</strong> ' + start.format('MMMM D, YYYY') + ' <strong>To</strong>: ' + end.format('MMMM D, YYYY'));
                $('#report_between').val(start.format('YYYY-MM-DD') + ',' + end.format('YYYY-MM-DD') );
            }

            $('#search-form #date_range').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, dateRangeCallback);
            //dateRangeCallback(start, end);
			{{-- </Date Range Calendar> --}}

            $('#search-form').on('submit', function (e) {
                e.preventDefault();
				
                
				{{--
				For locations only we are sending location TEXT instead of IDs. Also we are using a '||'
				as separator because of the | sign and comma could be part of the address text.
				--}}
                var locations = getSelect2ElementText( '#search-form .locations', '||' );
                
                dataTable
                    .column(1).search( $('#search-form .homeowner').val() ? $('#search-form .homeowner').val() : '' )
                    .column(2).search( $('#search-form .email').val() ? $('#search-form .email').val() : '' )
                    .column(3).search( $('#search-form .hoa').val() ? $('#search-form .hoa').val() : '' )
                    .column(4).search( locations ? locations : '')
	                .column(5).search( $('#search-form .violations').val() ? $('#search-form .violations').val() : '' )
                    .column(6).search( $('#search-form .status').val() ? $('#search-form .status').val() : '')
                    .column(7).search( $('#search-form .report_between').val() ? $('#search-form .report_between').val() : '')
                    .draw();
                
            });

            $('#search-form .btn-clear-search').click(function () {
                $('#search-form')[0].reset();
                $('#report_between').val('');
                $('#date_range > span').html('Select a date or date range');
                $('.select2').val(null).trigger('change');
                $('#search-form').submit();
            });
			
			{{--
			// Edit
			$(document).on('click', '.btn-view', function (e) {
				location.href = '{{ route('admin.location.violation.view', '') }}/' + $(this).data('id');
			});
			--}}
        });
	
	</script>

@endpush
