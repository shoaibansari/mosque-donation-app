<aside id="leftsidebar" class="sidebar">
	
	<!-- User Info -->
	<div class="user-info">
		<!-- <div class="image">
			<img src="{{ $thisUser->getAvatarUrl() }}" width="48" height="48" alt="User"/>
		</div> -->
		<div class="info-container">
			<div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $thisUser->name }}</div>
			<div class="email">{{ $thisUser->email }}</div>
		</div>
	</div>
	<!-- #User Info -->
	
	<!-- Menu -->
	<div class="menu">
		<ul class="list">
			
			<li class="{{ toolbox()->route()->getActiveClassIfRoute('admin.dashboard') }}">
				<a href="{{ route('admin.dashboard') }}">
					<i class="material-icons">dashboard</i>
					<span>Dashboard</span>
				</a>
			</li>
			
			
			
			<li class="{{ toolbox()->route()->getActiveClassIfRoute(['admin.mosque.create', 'admin.mosque.edit', 'admin.mosque.manage', 'admin.mosque.view', 'admin.mosque.image']) }}">
				<a href="{{ route('admin.mosque.manage') }}" class="waves-effect waves-block ">
					<i class="material-icons">star</i>
					<span>Mosques</span>
				</a>
			</li>
			
			<li class="{{ toolbox()->route()->getActiveClassIfRoute(['admin.donation.create', 'admin.donation.edit', 'admin.donation.manage']) }}">
				<a href="{{ route('admin.donation.manage') }}" class="waves-effect waves-block ">
					<i class="material-icons">monetization_on</i>
					<span>Donations</span>
				</a>
			</li>
		
			
			<li class="{{ toolbox()->route()->getActiveClassIfRoute(['admin.users.create', 'admin.users.edit', 'admin.users.manage']) }}">
				<a href="{{ route('admin.users.manage') }}" class="waves-effect waves-block ">
					<i class="material-icons">people</i>
					<span>Users</span>
				</a>
			</li>
			
			
			
			<li class="{{ toolbox()->route()->getActiveClassIfRoute('admin.edit') }}">
				<a href="{{ route('admin.edit') }}">
					<i class="material-icons">person_outline</i>
					<span>My Profile</span>
				</a>
			</li>
			
			<li class="{{ toolbox()->route()->getActiveClassIfRoute(['admin.settings.edit', 'admin.settings.countries', 'admin.violations.edit', 'admin.violations.create', 'admin.violations.manage']) }}">
				<a href="{{ route('admin.settings.edit') }}" class="waves-effect waves-block ">
					<i class="material-icons">settings</i>
					<span>Settings</span>
				</a>
				
			</li>
		
		</ul>
	</div>
	<!-- #Menu -->
	
	<!-- Footer -->
	<div class="legal">
		<div class="copyright">
			&copy; {{ date('Y') }} <a href="javascript:void(0);">{{ settings()->getAppName() }}</a>.
		</div>
		<div class="version">
			<b>Version: </b> {{ settings()->getAppVersion() }}
			<br>
			<b>Powered By:</b>
			<a href="{{ settings()->getVendorUrl() }}" target="_blank">{{ settings()->getVendorName() }}</a>
		</div>
	</div>
	<!-- #Footer -->
	
</aside>