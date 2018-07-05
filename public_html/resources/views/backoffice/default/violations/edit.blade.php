@extends( toolbox()->backend()->layout('master') )

@section('heading')
	Settings
@endsection

@section('head')
	<link href="{{ toolbox()->backend()->asset('plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"/>
@endsection

@section('contents')
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						{{ ucwords($action) }} Violation
					</h2>
				</div>
				<div class="body">
					
					@if ( !isset($violation) )
						{!! Form::open( ['route' => 'admin.violations.store', 'method' => 'post', 'files' => true]) !!}
					@else
						{!! Form::model( $violation, ['route' => ['admin.violations.update'], 'method' => 'post', 'files' => true]) !!}
						{{ Form::hidden('id', $violation->id) }}
					@endif
					
						{{ Form::label('title', 'Title *') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::text('title', null, ['class' => 'form-control', 'placeholder'=>'Enter violation type']) }}
							</div>
						</div>
						
						{{ Form::label('description', 'Description') }}
						<div class="form-group">
							<div class="form-line">
								{!!  Form::textarea('description', isset($violation) ? $violation->description : null, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						{{--
						Hiding image upload function.
						--}}
						{{--
						<div class="row">
							@if ( isset( $violation ) )
								<div class="col-md-10">
									{{ Form::label('image', 'Image') }}
									<div class="form-group">
										<div class="form-line">
											{{ Form::file('image', null, ['class' => 'form-control', 'placeholder'=>'Select a reference image to violation']) }}
										</div>
									</div>
								</div>
								<div class="col-md-2 ">
									{{ Form::label('preview', 'Image Preview', ['class'=>'center-block text-center']) }}
									<img class="center-block" src="{{ $violation->getImageUrl(80) }}" >
									@if ( $violation->hasImage() )
										<button type="button" class="btn btn-danger btn-xs waves-effect center-block bn-delete" style="margin-top: 7px; display: block !important;">
											Delete
										</button>
									@endif
								</div>
							@else
								<div class="col-md-12">
									{{ Form::label('image', 'Image') }}
									<div class="form-group">
										<div class="form-line">
											{{ Form::file('image', null, ['class' => 'form-control', 'placeholder'=>'Select a reference image to violation']) }}
										</div>
									</div>
								</div>
							@endif
						</div>
						--}}
						
						{{ Form::label('is_active', 'Active *') }}
						<div class="form-group">
							{{ Form::radio('active', '1', null, [ 'id'=>'activeYes']) }}
							{{ Form::label('activeYes', 'Yes') }}
							
							{{ Form::radio('active', '0', null, ['id'=>'activeNo']) }}
							{{ Form::label('activeNo', 'No') }}
						
						</div>
						
						{{ Form::submit( isset($violation) ? 'Save' : 'Create', ['class'=>'btn btn-primary m-t-15 waves-effect submit']) }}
						{{ Form::button('Cancel', ['class'=>'btn btn-danger m-t-15 waves-effect bn-cancel']) }}
					
					{!! Form::close() !!}
					
				</div>
			</div>
		</div>
	</div>
	
@endsection

@section('footer')
	
	<script src="{{ toolbox()->backend()->asset('plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
	
	@if ( $action == 'create' )
		{!! JsValidator::formRequest( toolbox()->backend()->request('ViolationCreateRequest'))  !!}
	@else
		{!! JsValidator::formRequest( toolbox()->backend()->request('ViolationUpdateRequest'))  !!}
	@endif
	
	<script src="{{ toolbox()->backend()->asset('/plugins/tinymce/tinymce.js') }}"></script>
	<script>
		$(function() {

		    // Cancel
		    $('.bn-cancel').click( function(e) {
		        appHelper.confirm(e, {message: 'Are you sure to cancel?', 'onConfirm': function() {
		            window.location = '{{ route('admin.violations.manage') }}';
		        }});
		    });
		    
		    
			// Delete Image
            $('.bn-delete').click(function (e) {
                appHelper.confirm(e, {
                    message: 'Are you sure to remove image?', 'onConfirm': function () {
                        window.location = '{{ route('admin.violations.image.remove','') }}/' + $('input[name="id"]').val();
                    }
                });
            });
			
            // :::: Events trigger on page load ::::
			
            // TinyMCE - Editor
            tinymce.init({
                selector: "#description",
                theme: "modern",
                height: 200,
                content_css: [
                    'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
                    'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
                    '{{ toolbox()->frontend()->asset('/css/style.css') }}'
                ],
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    //'emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager variables code'
                    'emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager code'
                ],
                menubar: 'edit insert view format table',
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                //toolbar2: 'responsivefilemanager | print preview media | forecolor backcolor emoticons | mybutton code',
                toolbar2: 'responsivefilemanager | print preview media | forecolor backcolor emoticons | code',
                image_advtab: true,

                // filemanager
                relative_urls: false,
                filemanager_title: "File Manager",
                filemanager_crossdomain: true,
                external_filemanager_path: "{{ toolbox()->frontend()->url('wfm/filemanager/') }}/",
                external_plugins: {
                    "filemanager": "{{ toolbox()->frontend()->url('wfm/filemanager/plugin.min.js') }}"
                }
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{ toolbox()->backend()->asset('/plugins/tinymce') }}';
		});
	</script>
@endsection