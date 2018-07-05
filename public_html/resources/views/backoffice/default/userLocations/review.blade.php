@extends( toolbox()->backend()->layout('master') )

@section('heading')
	User Locations
@endsection

@section('contents')
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2 style="height: 25px">
						<div class="pull-left">
							Location Review
						</div>
						{{-- Next/Previous buttons --}}
						{{--
						<div class="pull-right">
							<div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
								<button type="button" class="btn btn-info waves-effect">&lt;</button>
								<button type="button" class="btn btn-info waves-effect">&gt;</button>
							</div>
						</div>
						--}}
					</h2>
				</div>
				<div class="body">
					@if ( !isset($location) )
						{!! Form::open( ['route' => 'admin.users.locations.store', 'method' => 'post', 'files' => true, 'class' => 'form']) !!}
					@else
						{!! Form::model( $location, ['route' => ['admin.users.locations.status'], 'method' => 'post', 'files' => true, 'class' => 'form']) !!}
						{{ Form::hidden('id', $location->id) }}
					@endif
					{{ Form::hidden('status', '', ['id'=>'status']) }}
					<p>
						<strong>
							User Details:
						</strong>
					</p>
					<table class="table table-bordered">
						<tr>
							<th width="200">Name</th>
							<td>{{ ucwords($location->homeOwner->name) }}</td>
						</tr>
						<tr>
							<th>Email</th>
							<td>{{ $location->homeOwner->email }}</td>
						</tr>
						
					</table>
					
					<p>
						<strong>
							Location Details:
						</strong>
					</p>
					<table class="table table-bordered">
						<tr>
							<th width="200">Address</th>
							<td>{{ ucwords($location->address) }}</td>
						</tr>
						<tr>
							<th width="200">Street</th>
							<td>{!! $location->street ? ucwords($location->street) : '<em>N/A</em>'  !!}</td>
						</tr>
						<tr>
							<th>City</th>
							<td>{!! $location->city ? ucwords($location->city) : '<em>N/A</em>'  !!}</td>
						</tr>
						<tr>
							<th>State</th>
							<td>{!! $location->state ? ucwords($location->state) : '<em>N/A</em>'  !!}</td>
						</tr>
						<tr>
							<th>Zip</th>
							<td>{!! $location->zip ? ucwords($location->zip) : '<em>N/A</em>'  !!}</td>
						</tr>
						<tr>
							<th>Country</th>
							<td>{!! $location->country ? ucwords($location->country) : '<em>N/A</em>'  !!}</td>
						</tr>
						<tr>
							<th>Status</th>
							<td class="location-status">{{ $location->status() }}</td>
						</tr>
					</table>
					
					<div class="row">
						<div class="col-md-12">
							{{ Form::button( 'Approve', ['class'=>'btn btn-primary m-t-15 waves-effect bn-approve']) }}
							{{ Form::button( 'Reject', ['class'=>'btn btn-danger m-t-15 waves-effect bn-reject']) }}
							{{ Form::button( 'Cancel', ['class'=>'btn btn-info m-t-15 waves-effect bn-cancel']) }}
						</div>
					</div>
					
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
	
@endsection

@section('footer')
	<script>
        $(function () {
            
            // Approve
            $('.bn-approve').click(function (e) {
                $('#status').val('1');
                appHelper.ajaxForm('.form', {
                    success: function (r) {
                        $('.bn-approve').hide();
                        $('.bn-reject').show();
                        $('.location-status').html( r.data.status );
                        appHelper.showSuccessNotification( r.message );
                    },
                    error: function (err) {
                        appHelper.showErrorNotification(err.message);
                    }
                });
            });

            // Reject
            $('.bn-reject').click(function (e) {
                $('#status').val('0');
                appHelper.ajaxForm('.form', {
                    success: function (r) {
                        $('.bn-reject').hide();
                        $('.bn-approve').show();
                        $('.location-status').html(r.data.status);
                        appHelper.showSuccessNotification(r.message);
                    },
                    error: function (err) {
                        appHelper.showErrorNotification(err.message);
                    }
                });
            });

            // Cancel
            $('.bn-cancel').click(function (e) {
                appHelper.confirm(e, {
                    message: 'Are you sure to cancel?', 'onConfirm': function () {
                        window.location = '{{ route('admin.users.locations.pending') }}';
                    }
                });
            });
            
            @if ( $location->is_approved === 1)
                $('.bn-approve').hide();
	        @elseif ($location->is_approved === 0)
                $('.bn-reject').hide();
	        @endif
        });
	</script>
@endsection

