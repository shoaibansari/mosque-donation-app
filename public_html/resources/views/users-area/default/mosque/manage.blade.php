@extends( toolbox()->userArea()->layout('master') )

@section('heading')
	{!!
	toolbox()->backend()->themeHelper()->breadcrumb([
		'Mosque' => route('mosque.manage'),
	])
	!!}
@endsection

@section('head')
@endsection


@section('contents')

	<div class="row clearfix">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
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

            

            // Edit
			$(document).on('click', '.btn-edit', function (e) {
                location.href = '{{ route('mosque.edit', '') }}/' + $(this).data('id');
            });

           
            
		});
	</script>
	
@endpush
