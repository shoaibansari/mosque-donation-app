<aside id="leftsidebar" class="sidebar">
	
	<!-- User Info -->
	<div class="user-info">
		<div class="image">
			<img src="{{ $thisUser->getAvatarUrl() }}" width="48" height="48" alt="User"/>
		</div>
		<div class="info-container">
			<div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $thisUser->name }}</div>
			<div class="email">{{ $thisUser->email }}</div>
		</div>
	</div>
	<!-- #User Info -->
	
	<!-- Menu -->
	<div class="menu">
		<ul class="list">
			
			<li class="{{ toolbox()->route()->getActiveClassIfRoute('dashboard') }}">
				<a href="{{ route('dashboard') }}">
					<i class="material-icons">dashboard</i>
					<span>Dashboard</span>
				</a>
			</li>
		
            
            @if ( $thisUser->mosques() )
			<li class="{{ toolbox()->route()->getActiveClassIfRoute('mosque.manage') }}">
				<a href="{{ route('mosque.manage') }}">
					<i class="material-icons">star</i>
					<span>Mosque Details</span>
				</a>
			</li>
			@endif

			<li class="{{ toolbox()->route()->getActiveClassIfRoute(['donation.create', 'donation.edit', 'donation.manage']) }}">
				<a href="{{ route('donation.manage') }}" class="waves-effect waves-block ">
					<i class="material-icons">monetization_on</i>
					<span>Donations</span>
				</a>
			</li>

			<li class="{{ toolbox()->route()->getActiveClassIfRoute('profile.edit') }}">
				<a href="{{ route('profile.edit') }}">
					<i class="material-icons">person_outline</i>
					<span>My Profile</span>
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
			<b>Powered By:</b> <a href="{{ settings()->getVendorUrl() }}" target="_blank">{{ settings()->getVendorName() }}</a>
		</div>
	</div>
	<!-- #Footer -->
	
</aside>