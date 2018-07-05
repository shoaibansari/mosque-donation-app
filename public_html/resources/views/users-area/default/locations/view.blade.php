@extends( toolbox()->userArea()->layout('master') )

@section('heading')
	My Location
@endsection

@section('head')
	<link href="{{ toolbox()->backend()->asset('/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ toolbox()->backend()->asset('/plugins/jquery-datatable/skin/bootstrap/css/additional.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ toolbox()->backend()->asset('/vendor/datatables/buttons/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('contents')
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2 style="height: 25px">
						<div class="pull-left">
							{{ $location->address }}
						</div>
					</h2>
				</div>
				<div class="body">
					
					{!! $dataTable->table() !!}
					
					<div class="row">
						<div class="col-md-12">
							{{ Form::button( 'Back', ['class'=>'btn btn-info m-t-15 waves-effect bn-cancel']) }}
						</div>
					</div>
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
        $(function () {

            // Edit
            $(document).on('click', '.btn-view', function (e) {
                location.href = '{{ route('location.violation.details', '') }}/' + $(this).data('id');
            });

        });
	</script>

@endpush

@section('footer')
	<script>
        $(function () {

            // Cancel
            $('.bn-cancel').click(function (e) {
                window.location = '{{ route('users.locations') }}';
            });
        });
	</script>
@endsection
