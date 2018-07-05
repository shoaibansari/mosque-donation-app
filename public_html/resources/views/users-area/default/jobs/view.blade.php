@extends( toolbox()->userArea()->layout('master') )

@section('heading')
	Jobs
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
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="header">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<h2>
							{{ $job->name }}
						</h2>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						@if ( $job->is_completed )
							<div class="pull-right">
								<small><em>Job completed on <strong>{{ toolbox()->datetime()->formatShortDateTimeFormat( $job->completed_at ) }}</strong></em></small>
							</div>
						@else
							<button type="button" class="btn btn-primary waves-effect pull-right btn-mark-completed  @if(!$job->is_accepted) hide @endif" title="Mark as Completed">
								Mark as Completed
							</button>
							<button type="button" class="btn btn-primary waves-effect pull-right btn-accept-job @if($job->is_accepted) hide @endif" title="Accept Job">
								Accept Job
							</button>
							<button type="button" class="btn btn-danger waves-effect pull-right btn-reject-job @if(!$job->is_accepted) hide @endif" title="Reject Job" style="margin-right: 5px">
								Reject Job
							</button>
						@endif
						
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="body">
					{!! $dataTable->table() !!}
				</div>
			</div>
		</div>
	</div>
	
	
@endsection

@section('footer')

	{!! $dataTable->scripts() !!}
	
	<script>
		$(function() {

            // Edit
			$(document).on('click', '.btn-view', function (e) {
                location.href = '{{ route('admin.jobs.image', ['', '']) }}/' + $(this).data('area-id') + '/' + $(this).data('location-id');
            });
			
			{{-- Accept a Job --}}
			$(document).on('click', '.btn-accept-job', function(e) {
                var me = $(this);
                appHelper.confirm(e, {
                    'message': 'Are you sure to accept this job?', 'onConfirm': function () {
                        appHelper.ajax('{{ route('jobs.accept') }}', {
                            method: 'POST',
                            block: true,
	                        data: {
                                'job_id': '{{ $job->id }}',
                                'accept': true
	                        },
                            success: function (r) {
                                me.addClass('hide');
                                $('.btn-mark-completed').removeClass('hide');
                                $('.btn-reject-job').removeClass('hide');
                                appHelper.showNotification(r.message);
                                
                            },
                            error: function (e) {
                                console.error(e);
                            }
                        });
                    }
                });
			});
			
			{{-- Reject a Job --}}
            $(document).on('click', '.btn-reject-job', function (e) {
                var me = $(this);
                appHelper.confirm(e, {
                    'message': 'Are you sure to reject this job?', 'onConfirm': function () {
                        appHelper.ajax('{{ route('jobs.reject') }}', {
                            method: 'POST',
                            block: true,
                            data: {
                                'job_id': '{{ $job->id }}',
	                            'accept': false
                            },
                            success: function (r) {
                                me.addClass('hide');
                                $('.btn-mark-completed').addClass('hide');
                                $('.btn-accept-job').removeClass('hide');
                                appHelper.showNotification(r.message);
                            },
                            error: function (e) {
                                console.error(e);
                            }
                        });
                    }
                });
            });
			
			
			{{-- Mark as completed --}}
            $(document).on('click', '.btn-mark-completed', function (e) {
                var me = $(this);
                appHelper.confirm(e, {
                    'message': 'Are you sure to mark this job as completed?', 'onConfirm': function () {
                        appHelper.ajax('{{ route('jobs.completed') }}', {
                            method: 'POST',
                            block: true,
                            data: {
                                'job_id': '{{ $job->id }}'
                            },
                            success: function (r) {
                                me.addClass('hide');
                                $('.btn-mark-completed').addClass('hide');
                                $('.btn-accept-job').addClass('hide');
                                $('.btn-reject-job').addClass('hide');
                                appHelper.showNotification(r.message);
                            },
                            error: function (e) {
                                console.error(e);
                            }
                        });
                    }
                });
            });
            

		});
	</script>
@endsection