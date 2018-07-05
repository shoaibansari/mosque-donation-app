@extends( toolbox()->userArea()->layout('master') )

@section('heading')
	Violations
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
							{{ $userLocation->address }} <small>{{ $userLocation->homeOwner->name }} | {{ $userLocation->homeOwner->email }}</small>
						</h2>
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

            // Edit
			$(document).on('click', '.btn-view', function (e) {
                location.href = '{{ route('location.violation.details', '') }}/' + $(this).data('id');
            });
            
		});
	</script>
	
@endpush
