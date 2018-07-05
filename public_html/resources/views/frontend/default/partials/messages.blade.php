{{-- ON ERRORS --}}
@if( !$errors->isEmpty() )
	<div class="alert alert-danger alert-dismissable">
		<p style="font-weight: bold">
			Please correct the following {{ str_plural('error', $errors->count() ) }}:
		</p>
		<ul id="form-errors" style=" margin-left: -38px; list-style: none;">
			@if ( is_array( $errors ) || is_object( $errors ))
				@foreach( $errors->all() as $error)
					<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{ $error }}</li>
				@endforeach
			@else
				<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{ $errors }}</li>
			@endif
		</ul>
	</div>

{{-- ON SUCCESSFUL --}}
@elseif ( session('success') || session('status') )
	<div class="alert alert-success">
		<span style="position: relative; top: -5px;">
			{!! session('success') ? session('success') : session('status') !!}
		</span>
	</div>
	
{{-- ON ERROR --}}
@elseif ( session('error') )
	<div class="alert alert-danger">
		<span style="position: relative; top: -5px;">
			{!! session('error') !!}
		</span>
	</div>
@endif

