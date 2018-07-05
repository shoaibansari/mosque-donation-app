@extends( toolbox()->backend()->layout('master') )

@section('header')

@endsection

@section('contents')
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						Upload Video
					</h2>
				</div>
				<div class="body">
					@if ( !isset($video) )
						{!! Form::open( ['route' => 'admin.videos.store', 'method' => 'post', 'files' => true]) !!}
					@else
						{!! Form::model( $video, ['route' => ['admin.videos.update'], 'method' => 'post', 'files' => true]) !!}
						{{ Form::hidden('id', $video->id) }}
					@endif
						
						{{ Form::label('title', 'Title *') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::text('title', null, ['class' => 'form-control', 'placeholder'=>'Enter video title']) }}
							</div>
						</div>
						
						{{ Form::label('description', 'Description *') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder'=>'Enter video description', 'rows' => 5]) }}
							</div>
						</div>
						
						{{ Form::label('file', 'Video File * (File size limit: '. toolbox()->upload()->getSizeLimit( true ) .')') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::file('file', null, ['class' => 'form-control', 'placeholder'=>'Select video file']) }}
							</div>
						</div>
						
						{{ Form::label('thumbnail', 'Thumbnail * (File size limit: '. toolbox()->upload()->getSizeLimit( true ) .')') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::file('thumbnail', null, ['class' => 'form-control', 'placeholder'=>'Select a video thumbnail']) }}
							</div>
						</div>
						
						{{ Form::label('is_featured_box', 'Is Featured Video?') }}
						<div class="">
							
							{{ Form::radio('is_featured', 1, null, [ 'id'=>'featuredYes']) }}
							{{ Form::label('featuredYes', 'Yes') }}
							
							{{ Form::radio('is_featured', 0, null, ['id'=>'featuredNo']) }}
							{{ Form::label('featuredNo', 'No') }}
							
						</div>
						
						{{ Form::submit( isset($video) ? 'Update' : 'Upload', ['class'=>'btn btn-primary m-t-15 waves-effect submit']) }}
						{{ Form::button('Cancel', ['class'=>'btn btn-danger m-t-15 waves-effect bn-cancel']) }}
					
					{!! Form::close() !!}
					
				</div>
			</div>
		</div>
	</div>
	
@endsection

@section('footer')
	
	@if ( isset($video) )
		{!! JsValidator::formRequest( toolbox()->backend()->request('VideoUpdateRequest'))  !!}
	@else
		{!! JsValidator::formRequest( toolbox()->backend()->request('VideoCreateRequest'))  !!}
	@endif
	
	<script>
		$(function() {
		   $('.bn-cancel').click( function(e) {
		      appHelper.confirm(e, {message: 'Are you sure to cancel?', 'onConfirm': function() {
		        window.location = '{{ route('admin.videos.manage') }}';
		      }});
		   });
		});
	</script>
@endsection