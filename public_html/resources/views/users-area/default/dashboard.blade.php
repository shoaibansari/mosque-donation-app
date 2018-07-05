@extends( toolbox()->userArea()->layout('master') )

@section('heading', 'Dashboard')

@section('contents')

	{{-- Tiles --}}
	<div class="row clearfix">
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="info-box bg-blue hover-expand-effect">
				<div class="icon">
					<i class="material-icons">perm_identity</i>
				</div>
				<div class="content">
					<div class="text">Donors</div>
					<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">0</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="info-box bg-orange hover-expand-effect">
				<div class="icon">
					<i class="material-icons">monetization_on</i>
				</div>
				<div class="content">
					<div class="text">Donations</div>
					<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">0</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="info-box bg-indigo hover-expand-effect">
				<div class="icon">
					<i class="material-icons">event_note</i>
				</div>
				<div class="content">
					<div class="text">Campaign</div>
					<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">0</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="info-box bg-brown hover-expand-effect">
				<div class="icon">
					<i class="material-icons">monetization_on</i>
				</div>
				<div class="content">
					<div class="text">Funds Details</div>
					<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">0</div>
				</div>
			</div>
		</div>
		
	</div>
	{{-- END Tiles --}}

	{{-- Task Info --}}
	<div class="row clearfix">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			{{--<div class="card">
				<div class="header">
					<h2>Activity</h2>
				</div>
				<div class="body">
					No record found.
					{!! toolbox()->image( storage_path('/app/public/sample2.jpg') )->reset(1)->resize(400, 250, 'f')->get() !!}
				</div>
			</div>--}}
		</div>
	</div>
	{{-- END Task Info --}}
	
@endsection