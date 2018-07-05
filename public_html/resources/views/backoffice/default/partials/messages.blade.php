{{-- ON ERRORS --}}
@if( !$errors->isEmpty() )

	<div class="alert alert-danger alert-dismissable">
		<p style="font-weight: bold">
			Please correct the following {{ str_plural('error', $errors->count() ) }}:
		</p>
		<ul id="form-errors" style=" margin-left: -38px; list-style: none;">
			@foreach( $errors->all() as $error)
				<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{ $error }}</li>
			@endforeach
		</ul>
	</div>

{{-- ON SUCCESSFUL --}}
@elseif ( session('success') || session('status') )
	
	<div class="alert alert-success">
		<i class="material-icons">done</i>
		<span style="position: relative; top: -5px;">
			{!! session('success') ? session('success') : session('status') !!}
		</span>
	</div>
	
{{-- ON ERROR --}}
@elseif ( session('error') )
	
	<div class="alert alert-danger">
		<i class="material-icons">error_outline</i>
		<span style="position: relative; top: -5px;">
			{!! session('error') !!}
		</span>
	</div>

@endif

