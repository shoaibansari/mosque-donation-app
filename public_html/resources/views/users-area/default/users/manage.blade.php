@extends( toolbox()->userArea()->layout('master') )

@section('heading')
	Users
@endsection

@section('head')
	<link href="{{ toolbox()->userArea()->asset('/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ toolbox()->userArea()->asset('/plugins/jquery-datatable/skin/bootstrap/css/additional.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ toolbox()->userArea()->asset('/vendor/datatables/buttons/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css">
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
	
	<script src="{{ toolbox()->userArea()->asset('plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
	<script src="{{ toolbox()->userArea()->asset('plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
	<script src="{{ toolbox()->userArea()->asset('plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
	<script src="{{ toolbox()->userArea()->asset('plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
	<script src="{{ toolbox()->userArea()->asset('plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
	<script src="{{ toolbox()->userArea()->asset('plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
	<script src="{{ toolbox()->userArea()->asset('plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
	<script src="{{ toolbox()->userArea()->asset('plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
	<script src="{{ toolbox()->userArea()->asset('plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>
	<script src="{{ toolbox()->userArea()->asset('/vendor/datatables/buttons/dataTables.buttons.min.js') }}"></script>
	<script src="{{ toolbox()->userArea()->asset('/vendor/datatables/buttons/buttons.server-side.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('/js/lib.js') }}"></script>
	{!! $dataTable->scripts() !!}
	
	<script>
		$(function() {
		    
		    // Blocked
            $(document).on('change', '.is-blocked', function (e) {
                var me = $(this);
                appHelper.ajax('{{ route('users.blocked') }}', {
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
                appHelper.ajax('{{ route('users.confirmed') }}', {
                    'method': 'POST',
                    'data': {
                        'id': me.data('id'),
                        'status': me.prop('checked') ? 1 : 0
                    }
                });
            });

            // New
            $('.btn-new').on('click', function (e) {
                location.href = '{{ route('users.create') }}';
            });

            // Edit
			$(document).on('click', '.btn-edit', function (e) {
                location.href = '{{ route('users.edit', '') }}/' + $(this).data('id');
            });

            // Delete
            $(document).on('click', '.btn-delete', function (e) {
                var me = $(this);
                appHelper.confirm(e, {
                    message: 'Are you sure to delete?', 'onConfirm': function () {
                        window.location = '{{ route('users.delete','') }}/' + me.data('id');
                    }
                });
            });
            
            
		});
	</script>
	
@endpush
