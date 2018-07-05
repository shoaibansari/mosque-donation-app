@extends( toolbox()->backend()->layout('master') )

@section('heading')
	Settings
@endsection

@section('head')
@endsection


@section('contents')

	<div class="row clearfix">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="header">
					<h2>Countries</h2>
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
		    
            $(document).on('change', '.active-status', function (e) {
                var me = $(this);
                appHelper.ajax('{{ route('admin.settings.countries.status') }}', {
                    'method': 'POST',
                    'data': {
                        'id': me.data('id'),
                        'status': me.prop('checked') ? 1 : 0
                    }
                });
            });
		});
	</script>
	
@endpush
