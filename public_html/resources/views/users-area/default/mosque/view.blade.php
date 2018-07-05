@extends( toolbox()->backend()->layout('master') )

@section('heading')
	{!!
	toolbox()->backend()->themeHelper()->breadcrumb([
		'Drives' => route('admin.jobs.manage'),
		'Drive' => route('admin.jobs.view', $job->id),
	])
	!!}
@endsection

@section('head')
	<style>
		#dlgLinkHomeOwners label {
			margin-bottom: -10px;
		}
	</style>
@endsection

@section('contents')
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<h2>
							<strong>Drive Date:</strong> {{ $job->name }}
						</h2>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						@if ( isset($job) )
							<button type="button"
							        class="btn btn-danger waves-effect pull-right btnMarkJobAsCompleted"
							        id="btnMarkJobAsCompleted"
							        title="Mark Drive as Completed"
							        style="margin-left: 5px;"
							>
								Mark Drive as Completed
							</button>
						
							<button type="button" class="btn btn-primary waves-effect pull-right" title="Link Homeowners" data-toggle="modal" data-target="#dlgLinkHomeOwners">
								Import Homeowners
							</button>
							
							
						@endif
					</div>
					<div class="clearfix"></div>
				</div>
				
				<div class="body firstScreen" style="padding-bottom: 0px;">
					<div class="row">
						{{--
						<div class="col-md-4">
							{{ Form::label('name', 'Drive Date') }}
							<div class="form-group">
								<div class="form-line">
									{!! $job->name !!}
								</div>
							</div>
						</div>
						--}}
						<div class="col-md-6">
							{{ Form::label('name', 'Is Completed') }}
							<div class="form-group">
								<div class="form-line">
									{!! ($job->is_completed) ? 'Yes' : 'No' !!}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							{{ Form::label('name', 'Is Forcefully Completed') }}
							<div class="form-group">
								<div class="form-line">
									{!! ($job->is_forcefully_completed) ? 'Yes' : 'No' !!}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row clearfix">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="body">
					{!! $dataTable->table() !!}
				</div>
			</div>
		</div>
	</div>
	
	
	@if ( isset($job) )
		
		{{-- Dialog - Link Homeowners --}}
		<div id="dlgLinkHomeOwners" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				
				{!! Form::open( ['id'=>'frmLinkHomeOwners', 'route' => 'admin.jobs.import.homeowners', 'method' => 'post', 'files' => false]) !!}
				{{ Form::hidden('job_id', $job->id) }}
				```
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Import Homeowners</h4>
					</div>
					<div class="modal-body">
						
						@if ( !$locations || $locations->count() == 0 )
							<em>No unassociated homeowner is available at the moment.</em>
						@else
							<div class="table-responsive">
								<table class="table custom-list" id="permissions-table">
									<thead>
									<tr>
										<th width="15">
											<input name="no-name" type="checkbox" id="checkAll" class="filled-in chk-col-deep-orange cb-all" checked/>
											<label for="checkAll"></label>
										</th>
										<th>Homeowner</th>
										<th>Address</th>
									</tr>
									</thead>
									<tbody>
									@foreach( $locations as $location)
										<tr>
											@php  @endphp
											<th scope="row" style="padding: 10px">
												<input type="checkbox" id="locations-{{ $location->id }}" name="locations[]" value="{{ $location->id }}" class="filled-in chk-col-deep-purple cb-homeowner"/>
												<label for="locations-{{ $location->id }}"></label>
											</th>
											<td>
												{{ $location->homeOwner->name }}
											</td>
											<td>
												{{ $location->address }}
											</td>
										</tr>
									@endforeach
									
									</tbody>
								</table>
							</div>
						@endif
					
					
					</div>
					<div class="modal-footer">
						@if ( $locations && $locations->count() > 0 )
							{{ Form::submit('Import', ['class'=>'btn btn-primary waves-effect upload']) }}
						@endif
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
		{{-- end of dialog --}}
	
	@endif
	
	
@endsection

@section('footer')
	
	{!! $dataTable->scripts() !!}
	
	<script>
		$(function() {

			{{--
            // Edit
			$(document).on('click', '.btn-view', function (e) {
                location.href = '{{ route('admin.jobs.image', ['', '']) }}/' + $(this).data('area-id') + '/' + $(this).data('location-id');
            });
            --}}
			
			$('.btnMarkJobAsCompleted').click(function( e ) {
				
				@if ( $job->is_completed )
					alert('This drive is already marked as completed.');
				@else
					
	                var me = $(this);
	                appHelper.confirm( e, {
	                    'message': 'Are you sure to mark this drive as completed?',
		                'details': 'Important: If current drive has incomplete locations then it will be marked as Forcefully Completed.',
		                'onConfirm': function() {
	                        appHelper.ajax('{{ route('admin.jobs.completed') }}', {
	                            method: 'POST',
	                            data: {
	                                'job_id' : '{{ $job->id }}'
	                            },
		                        
		                        success: function( r ) {
	                                me.hide();
	                                appHelper.showNotification( r.message, {colorName: 'bg-green'} );
	                            },
		                        
		                        error: function( err ) {
	                                appHelper.showNotification( err.message, {colorName: 'bg-red'} );
		                        }
	                        })
	                    }
	                });
	                
				@endif
		    });

		});
	</script>
@endsection