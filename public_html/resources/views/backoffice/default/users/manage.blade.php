@extends( toolbox()->backend()->layout('master') )

@section('heading')
	Users
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
						<button type="button" class="btn btn-primary waves-effect pull-right btn-new" title="Add User">
							Add User
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
		    
		    // Blocked
            $(document).on('change', '.is-blocked', function (e) {
                var me = $(this);
                appHelper.ajax('{{ route('admin.users.blocked') }}', {
                    'method': 'POST',
                    'data': {
                        'id': me.data('id'),
                        'status': me.prop('checked') ? 1 : 0
                    }
                });

            });

            // Confirmed
            $(document).on('change', '.is-confirmed', function (e) {
                var me = $(this);
                appHelper.ajax('{{ route('admin.users.confirmed') }}', {
                    'method': 'POST',
                    'data': {
                        'id': me.data('id'),
                        'status': me.prop('checked') ? 1 : 0
                    }
                });
                var id = $('.count').html();
                $('.count').html(id-1);



            });

            // New
            $('.btn-new').on('click', function (e) {
                location.href = '{{ route('admin.users.create') }}';
            });

            // Edit
			$(document).on('click', '.btn-edit', function (e) {
                location.href = '{{ route('admin.users.edit', '') }}/' + $(this).data('id');
            });

            // Delete
            $(document).on('click', '.btn-delete', function (e) {
                var me = $(this);
                appHelper.confirm(e, {
                    message: 'Are you sure to delete?', 'onConfirm': function () {
                        window.location = '{{ route('admin.users.delete','') }}/' + me.data('id');
                    }
                });
            });
            
            
		});
	</script>
	
@endpush
