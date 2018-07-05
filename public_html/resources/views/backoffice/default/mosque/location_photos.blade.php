@extends( toolbox()->backend()->layout('master') )

@section('heading')
	{!!
	toolbox()->backend()->themeHelper()->breadcrumb([
		'Drives' => route('admin.jobs.manage'),
		'Drive' => route('admin.jobs.view', $job->id),
		'Location' => route('admin.jobs.view',[ $job->id, $location->id]),
	])
	!!}
@endsection

@section('head')
{{--	<link href="{{ toolbox()->backend()->asset('plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"/>--}}
{{--	<link href="{{ toolbox()->asset('vendor/bootstrap-fileinput/css/fileinput-ext.min.css') }}" rel="stylesheet"/>--}}
	{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css"/>--}}
{{--	<link href="{{ toolbox()->asset('vendor/bootstrap-fileinput/themes/explorer/theme.min.css') }}" media="all" rel="stylesheet" type="text/css"/>--}}
	
	<style type="text/css">
		.chosen-container-multi {
			width: 100% !important;
		}
	</style>
	
	<style>
		#pixie-editor-container #pixie-frame-container {
			position: fixed;
			width: 97% !important;
			height: 95% !important;
			top: 3% !important;
			left: 1% !important;
			box-shadow: inset 0 -2px 5px rgba(61, 61, 61, .5), 0 6px 44px rgba(0, 0, 0, .7);
			border-radius: 5px;
			border-right: 5px solid #263238;
			border-bottom: 5px solid #263238;
			border-left: 1px solid #263238;
			border-top: 1px solid #263238;
		}
	</style>
@endsection

@section('contents')
	<div class="pull-right">				
		@php 
		if($previous) { @endphp
			<a href="{{route('admin.jobs.image',[$job->id, $previous])}}" class="btn btn-default waves-effect ">Previous</a>
		@php}
		if($next){ @endphp
			<a style="@php echo $next; @endphp" href="{{route('admin.jobs.image', [$job->id, $next])}}" class="btn btn-default waves-effect ">Next</a>
		@php}
		@endphp
	</div>	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2 style="height: 25px">
						<div class="pull-left">
						{{ $location->address }}
						</div>
						<div class="pull-right">
							{{--Is completed? <strong>{!! ($location->is_completed) ? 'YES' : 'NO' !!}</strong>--}}
							{{ Form::button('Upload Images', ['class'=>'btn btn-primary waves-effect submit', 'data-toggle' => 'modal', 'data-target' =>'#dlgUploadImages']) }}
							{{-- Form::button('Report Violations', ['class'=>'btn btn-danger waves-effect submit']) --}}
						</div>
					</h2>
				</div>

				<div class="body firstScreen">
				
				@if ( $photos->count() == 0)
					
					<div class="row">
						<div class="col-md-12">
							<div class="alert alert-info">
								<i class="material-icons">info_outline</i>
								<span style="position: relative; top: -7px;">No image found.</span>
							</div>
						</div>
					</div>
				@else
					
					@php $photosChunks = $photos->chunk(4); @endphp
					@foreach( $photosChunks as $chunk)
						<div class="row">
						@foreach( $chunk as $photo)
							
							@php
								
								# If a violation is marked on location photo then
								# select that marked image instead of the actual image.
								$imageUrl = $photo->getImageUrl();
								if( $violationsCount = $photo->violations->count()) {
									$violation = $photo->violations->first();
									$imageUrl = $violation->getImageUrl();
								}
							
							@endphp
							
							
							
							<div class="col-md-3 image-container">
								<a href="{{ route('admin.jobs.image.edit', $photo->id) }}" class="report-violation-x" data-photo-id="{{ $photo->id }}">
									{{--<img src="{{ $imageUrl }}" class="img-thumbnail col-md-12" style="height:250px;">--}}
									@if ( $photo->imageExists() )
										{!! toolbox()->image( $photo->getImagePath() )->resize(600, 600, 'f')->get(['class' => 'img-thumbnail']) !!}
									@else
										<p>Image not found</p>
									@endif
								</a>
								
									<div class="pull-left">
									<a href="{{ route('admin.jobs.image.remove', $photo->id ) }}" class="remove-image" >
										<i class="fa fa-trash"></i>
										Delete
									</a>
									</div>
									<div class="pull-right">
										@if ( $vCount = $photo->violations->count() )
											<a href="{{ route('admin.location.violation.view', $location->id) }}">
												<i class="fa fa-info-circle danger" title="{{ $vCount }} {{ str_plural('violation', $vCount) }} reported."></i>
												{{ $vCount }} {{ str_plural('violation', $vCount) }}
											</a>
										@endif
									</div>
								
							</div>
							@endforeach
						</div>
					@endforeach
					
				@endif
				</div>
			</div>
		</div>
	</div>
	
	{{-- Upload Images Modal --}}
	<div id="dlgUploadImages" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			
			{!! Form::open( ['route' => 'admin.jobs.image.upload', 'method' => 'post', 'files' => true]) !!}
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Upload Images</h4>
				</div>
				<div class="modal-body">
					
					{!! Form::open( ['id' => 'fileupload', 'method' => 'POST', 'files' => true]) !!}
						{{ Form::hidden('job_id', $job->id) }}
						{{ Form::hidden('location_id', $location->id, ['required' => 'required']) }}
						<div class="row">
							<div class="col-md-12">
								<div class="file-loading">
									<input id="files" name="files[]" type="file" class="file-loading" multiple data-show-upload="false" data-msg-placeholder="Select {files} for upload..." required>
								</div>
							</div>
						</div>
					{!! Form::close() !!}
					
					
				</div>
				<div class="modal-footer">
					{{ Form::button('Upload', ['class'=>'btn btn-primary waves-effect upload']) }}
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
	{{-- End of Upload Images Modal --}}
	

@endsection

@section('footer')
	
	<script>

        var photoId = null;
        var imageSaved = null;
        $(function () {
        
			{{-- image editor settings --}}
		    if ( typeof Pixie != 'undefined' ) {
                var myPixie = Pixie.setOptions({
                    replaceOriginal: true,
                    appendTo: 'body',
                    hideOpenButton: true,
                    //noManualClose: true,
                    onSaveButtonClick: function () {

                        console.log('save triggered');
                        myPixie.save('png', 8);
                        imageSaved = true;

                        appHelper.blockPage();
						
						{{-- showing form in modal to collect violatoin data --}}
                        setTimeout(function () {
                            appHelper.unblockPage();
                            $('#photo_id').val(photoId);
                            //$('.chosen-select').val('').trigger('chosen:updated');
                            $('textarea[name="comment"]').val('');
                            $('#dlgViolation').modal();
                        }, 2000);
						
						
						{{--
						format: png, jpeg or json
						quality: 1 to 10
						--}}
                    },

                    onClose: function () {
                        console.log(photoId);
                    },

                    onSave: function (data, img) {
                        $('#new_image').val(data);
                    }
                });
            }
	
			{{-- report violation --}}
	        $('.report-violation').on('click', function (e) {
	            var $me = $(this);
	            var img = $me.closest('.image-container').find('img')[0];
             
	            imageSaved = null;
	            photoId = $me.data('photo-id');
	            
	            myPixie.open({
		            url: img.src,
	                //image: img,
	                image: $('#new_image')
	            });
	            
	        });
        
	        {{-- files upload settings --}}
            $("#files").fileinput({
                theme: "fa",
                uploadUrl: "{{ route('admin.jobs.image.upload') }}",
                uploadExtraData: {
                    'job_id': '{{ $job->id }}',
                    'location_id': '{{ $location->id }}',
                },
                allowedFileExtensions: ["jpg", "jpeg", "png", "gif"],
                fileActionSettings: {
                    showUpload: false,
                    showRemove: true,
                    showZoom: false
                }
            });
            
	        {{-- start uploading --}}
            $(document).on('click', '#dlgUploadImages .upload', function(e) {
            	if(document.getElementById("files").value != ""){
                console.log('uploading...');
                $("#files").fileinput('upload');
                $("#files").fileinput('disable');
            		
            	} else{
            		//alert('Upload Image');
            		return false;
            	}           	
            });
		
	        {{-- on upload completion --}}
            $('#files').on('filebatchuploadcomplete', function (event, data) {
                location.href = '{{ route('admin.jobs.image', [$job->id, $location->id])  }}';
            });
            
            
	        {{-- Remove image --}}
	        $('.remove-image').click( function (e) {
                var me = this;
                appHelper.confirm(e, {
                    'message': 'Are you sure to remove this image?', 'onConfirm': function () {
                        window.location = me.href;
                    }
                });
            });
        });

        //$(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
        
	</script>

@endsection