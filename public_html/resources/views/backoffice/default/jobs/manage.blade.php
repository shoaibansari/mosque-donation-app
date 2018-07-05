@extends( toolbox()->backend()->layout('master') )

@section('heading')
	{!!
	toolbox()->backend()->themeHelper()->breadcrumb([
		'Drives' => route('admin.jobs.manage'),
	])
	!!}
@endsection

@section('head')
@endsection


@section('contents')

	<div class="row clearfix">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="header">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<h2>
							Manage
						</h2>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<button type="button" class="btn btn-primary waves-effect pull-right btn-new" title="Add Job">
							Add Drive
						</button>
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

@push('scripts')
	
	{!! $dataTable->scripts() !!}
	
	<script>
		$(function() {

            // New
            $('.btn-new').on('click', function (e) {
                location.href = '{{ route('admin.jobs.create') }}';
            });

            // Edit
			$(document).on('click', '.btn-edit', function (e) {
                location.href = '{{ route('admin.jobs.edit', '') }}/' + $(this).data('id');
            });

            // View
			//$(document).on('click', '.btn-view', function (e) {
            //    location.href = '{{ route('admin.jobs.view', '') }}/' + $(this).data('id');
            //});

            // Delete
            $(document).on('click', '.btn-delete', function (e) {
                var me = $(this);
                appHelper.confirm(e, {
                    message: 'Are you sure to delete?', 'onConfirm': function () {
                        window.location = '{{ route('admin.jobs.delete','') }}/' + me.data('id');
                    }
                });
            });
            
            
		});
	</script>
	
@endpush
