{{$notifications['count']}}
@extends( toolbox()->backend()->layout('master') )

@section('heading')
{!!
	toolbox()->backend()->themeHelper()->breadcrumb([
		'Dashboard' => route('admin.dashboard'),
	])
!!}
	
	<style>
		table#backlogJobs th:nth-child(1) { width: 90px; }
		table#availableJobs th:nth-child(1) { width: 90px; }
	</style>
@endsection

@section('contents')

	{{-- Tiles --}}
	<div class="row clearfix">
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="info-box bg-blue hover-expand-effect">
				<div class="icon">
					<i class="material-icons">star</i>
				</div>
				<div class="content">
					<div class="text">Mosques</div>
					<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">{{ $mosques }}</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="info-box bg-orange hover-expand-effect">
				<div class="icon">
					<i class="material-icons">perm_identity</i>
				</div>
				<div class="content">
					<div class="text">Mosque Admin</div>
					<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">{{ $mosque_admin }}</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="info-box bg-indigo hover-expand-effect">
				<div class="icon">
					<i class="material-icons">perm_identity</i>
				</div>
				<div class="content">
					<div class="text">Donors</div>
					<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">{{ $donors }}</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="info-box bg-brown hover-expand-effect">
				<div class="icon">
					<i class="material-icons">monetization_on</i>
				</div>
				<div class="content">
					<div class="text">Donations</div>
					<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">{{ $TotalFunds }}</div>
				</div>
			</div>
		</div>
		
	</div>

		<div class="row clearfix">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="header">
					<h2>User Registration Notification</h2>
				</div>
				<div class="body">
					@foreach($notifications['data'] as $data)
						<p class="active"><a href="{{ route('admin.users.manage', '')}}' "> {{$data->name}} </a> is waiting for your approval</p> 
					@endforeach
				</div>
			</div>
		</div>
	</div>
	{{-- END Tiles --}}

	{{-- Task Info --}}
	{{--<div class="row clearfix">--}}
		{{----}}
		{{--<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">--}}
			{{--<div class="card">--}}
				{{--<div class="header bg-blue-grey">--}}
					{{--<h2 style="height: 25px">--}}
						{{--<div class="pull-left">--}}
							{{--Activity--}}
						{{--</div>--}}
						{{--<div class="pull-right">--}}
							{{--<button class="btn btn-primary waves-effect" type="button" onclick="location.href='{{ route('admin.activities.manage') }}';">--}}
								{{--View All--}}
							{{--</button>--}}
						{{--</div>--}}
					{{--</h2>--}}
				{{--</div>--}}
				{{--<div class="body">--}}
					{{--@if ( !$activities || count($activities) == 0)--}}
						{{--No activity found.--}}
					{{--@else--}}
					{{--<ul class="dashboard-activity">--}}
					{{--@foreach( $activities as $activity )--}}
						{{--<li>--}}
							{{--<small>--}}
								{{--<b>--}}
								{{--{{ toolbox()->datetime()->parse($activity->created_at)->diffForHumans() }}--}}
								{{--</b>--}}
							{{--</small>--}}
							{{--{!!  $activity->details !!}--}}
						{{--</li>--}}
					{{--@endforeach--}}
					{{--@endif--}}
					{{--</ul>--}}
				{{--</div>--}}
			{{--</div>--}}
		{{--</div>--}}
		{{----}}
		{{--<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">--}}
			{{----}}
			{{--<div class="row clearfix">--}}
				{{----}}
				{{----}}
				{{-- START -- Backlog Drives --}}
				{{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
					{{--<div class="card">--}}
						{{--<div class="header bg-blue-grey">--}}
							{{--<h2 style="height: 25px">--}}
								{{--<div class="pull-left">--}}
									{{--Backlog Drives--}}
								{{--</div>--}}
								{{-- <div class="pull-right">--}}
									{{--<button class="btn btn-primary waves-effect" type="button" onclick="location.href='{{ route('admin.jobs.manage') }}';">--}}
										{{--View All--}}
									{{--</button>--}}
								{{--</div> --}}
							{{--</h2>--}}
						{{--</div>--}}
						{{----}}
						{{--<div class="body">--}}
							{{--@if ( !$backlogJobs || count($backlogJobs) == 0 )--}}
								{{--No record found.--}}
							{{--@else--}}
								{{--<table data-toggle="table" id="backlogJobs">--}}
									{{--<thead>--}}
									{{--<tr>--}}
										{{--<th data-sortable="true">Drive Date</th>--}}
										{{--<th data-sortable="true">HOA</th>--}}
										{{--<th data-sortable="true">Days Overdue</th>--}}
									{{--</tr>--}}
									{{--</thead>--}}
									{{-- <tbody>--}}
									{{--@foreach( $backlogJobs as $job)--}}
										{{--<tr>--}}
											{{--<td>--}}
												{{--<a href="{{  route('admin.jobs.view', $job->id ) }}">--}}
													{{--{{ $job->name }}--}}
												{{--</a>--}}
											{{--</td>--}}
											{{--<td>{{ $job->area->title }}</td>--}}
											{{--<td>{{ toolbox()->datetime()->parse( $job->name )->diffInDays() }}</td>--}}
										{{--</tr>--}}
									{{--@endforeach--}}
									{{--</tbody> --}}
								{{--</table>--}}
							{{--@endif--}}
						{{--</div>--}}
					{{--</div>--}}
				{{--</div>--}}
				{{-- END -- Backlog Drives --}}
				{{----}}
				{{----}}
				{{-- START -- Available Drives --}}
				{{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
					{{--<div class="card">--}}
						{{--<div class="header bg-blue-grey">--}}
							{{--<h2 style="height: 25px">--}}
								{{--<div class="pull-left">--}}
									{{--Available Drives--}}
								{{--</div>--}}
								{{-- <div class="pull-right">--}}
									{{--<button class="btn btn-primary waves-effect" type="button" onclick="location.href='{{ route('admin.jobs.manage') }}';">--}}
										{{--View All--}}
									{{--</button>--}}
								{{--</div> --}}
							{{--</h2>--}}
						{{--</div>--}}
						{{----}}
						{{--<div class="body">--}}
							{{--@if ( !$availableJobs || count($availableJobs) == 0 )--}}
								{{--No record found.--}}
							{{--@else--}}
								{{--<table data-toggle="table" id="availableJobs">--}}
									{{--<thead>--}}
									{{--<tr>--}}
										{{--<th data-sortable="true">Drive Date</th>--}}
										{{--<th data-sortable="true">HOA</th>--}}
										{{--<th data-sortable="true">Days Overdue</th>--}}
									{{--</tr>--}}
									{{--</thead>--}}
									{{-- <tbody>--}}
									{{--@foreach( $availableJobs as $job)--}}
										{{--<tr>--}}
											{{--<td>--}}
												{{--<a href="{{  route('admin.jobs.view', $job->id ) }}">--}}
													{{--{{ $job->name }}--}}
												{{--</a>--}}
											{{--</td>--}}
											{{--<td>{{ $job->area->title }}</td>--}}
											{{--<td>{{ toolbox()->datetime()->parse( $job->name )->diffInDays() }}</td>--}}
										{{--</tr>--}}
									{{--@endforeach--}}
									{{--</tbody> --}}
								{{--</table>--}}
							{{--@endif--}}
						{{--</div>--}}
					{{--</div>--}}
				{{--</div>--}}
				{{-- END -- Available Drives --}}
				{{----}}
				{{----}}
				{{-- START -- Completed Drives --}}
				{{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
					{{--<div class="card">--}}
						{{--<div class="header bg-blue-grey">--}}
							{{--<h2 style="height: 25px">--}}
								{{--<div class="pull-left">--}}
									{{--Completed Drives--}}
								{{--</div>--}}
								{{-- <div class="pull-right">--}}
									{{--<button class="btn btn-primary waves-effect" type="button" onclick="location.href='{{ route('admin.jobs.manage') }}';">--}}
										{{--View All--}}
									{{--</button>--}}
								{{--</div> --}}
							{{--</h2>--}}
						{{--</div>--}}
						{{----}}
						{{--<div class="body">--}}
							{{--@if ( !$completedJobs || count($completedJobs) == 0 )--}}
								{{--No record found.--}}
							{{--@else--}}
								{{--<table data-toggle="table" id="completedJobs">--}}
									{{--<thead>--}}
										{{--<tr>--}}
											{{--<th data-sortable="true">Drive Date</th>--}}
											{{--<th data-sortable="true">HOA</th>--}}
											{{--<th data-sortable="true">Completed On</th>--}}
										{{--</tr>--}}
									{{--</thead>--}}
									{{-- <tbody>--}}
									{{--@foreach( $completedJobs as $job)--}}
										{{--<tr>--}}
											{{--<td>--}}
												{{--<a href="{{  route('admin.jobs.view', $job->id ) }}">--}}
													{{--{{ $job->name }}--}}
												{{--</a>--}}
											{{--</td>--}}
											{{--<td>{{ $job->area->title }}</td>--}}
											{{--<td>{{ toolbox()->datetime()->parse( $job->completed_at )->diffForHumans() }}</td>--}}
										{{--</tr>--}}
									{{--@endforeach--}}
									{{--</tbody> --}}
								{{--</table>--}}
							{{--@endif--}}
						{{--</div>--}}
					{{--</div>--}}
				{{--</div>--}}
				{{-- END -- Completed Drives --}}
				{{----}}
			{{--</div>--}}
			{{----}}
			{{----}}
		{{--</div>--}}
		{{----}}
		{{----}}
	{{----}}
	{{----}}
	{{--</div>--}}
	{{-- END Task Info --}}
	
	<div class="row clearfix">
	
	</div>
	
@endsection

@push('scripts')

@endpush