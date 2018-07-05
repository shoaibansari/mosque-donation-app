@extends( toolbox()->backend()->layout('master') )

@section('head')
	<link href="{{ toolbox()->backend()->asset('/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ toolbox()->backend()->asset('/plugins/jquery-datatable/skin/bootstrap/css/additional.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ toolbox()->backend()->asset('/vendor/datatables/buttons/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css">
@endsection


@section('contents')

	<div class="row clearfix">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="header">
					<h2>Users &amp; Files</h2>
				</div>
				<div class="body">
					{!! $dataTable->table() !!}
				</div>
			</div>
		</div>
	</div>
	
@endsection

@push('scripts')
	
	<script src="{{ toolbox()->backend()->asset('plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('/vendor/datatables/buttons/dataTables.buttons.min.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('/vendor/datatables/buttons/buttons.server-side.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('/js/lib.js') }}"></script>
	{!! $dataTable->scripts() !!}
	
	<script>
		$(function() {

            // Download
            $(document).on('click', '.btn-download', function (e) {
                window.location = $(this).data('url');
            });
		});
	</script>
	
@endpush
