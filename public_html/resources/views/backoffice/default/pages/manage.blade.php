@extends( toolbox()->backend()->layout('master') )

@section('head')
@endsection


@section('contents')

	<div class="row clearfix">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="header">
					<h2>Pages</h2>
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
            $(document).on('change', '.publish-status', function(e) {
               var me = $(this);
               appHelper.ajax('{{ route('admin.pages.publish') }}', {
                   'method': 'POST',
                   'data': {
                       'id': me.data('id'),
                       'status': me.prop('checked')
                   }
               });
            });

            // Edit
            $(document).on('click', '.btn-edit', function (e) {
                location.href = '{{ route('admin.pages.edit','') }}/' + $(this).data('id');
            });
            
            // Browse
            $(document).on('click', '.btn-browse', function (e) {
                window.open($(this).data('url'), '_blank');
            });
		});
	</script>
	
@endpush
