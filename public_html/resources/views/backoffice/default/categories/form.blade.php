@extends( toolbox()->backend()->layout('master') )

@section('heading', 'Categories')

@section('head')
	{{-- JQuery DataTable CSS --}}
	{{--	<link href="{{ toolbox()->backend()->asset('plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">--}}

    {{-- Dropzone CSS --}}
    <link rel="stylesheet" href="{{ toolbox()->backend()->asset('plugins/dropzone/dropzone.css') }}">

    {{-- Cropper CSS --}}
    <link rel="stylesheet" href="{{ toolbox()->backend()->asset('/plugins/cropper/dist/cropper.min.css') }}" >
    <link rel="stylesheet" href="{{ toolbox()->backend()->asset('/plugins/cropper/dist/cropper-helper.css') }}" >

@endsection

@section('contents')

	{{-- Categories --}}

	<div class="">

		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">

					<div class="header">
						<h2>
							{{ $category ? 'Update' : 'Create' }}
						</h2>
					</div>

					<div class="body">
						{{--<h2 class="card-inside-title">Basic Examples</h2>--}}
						<form action="{{ route($route, isset($id) ? [ 'id' => $id ] : [] ) }}" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}

							{{-- active value 0 is used when checkbox is turned off as it is not sent so this will be used with value 0 --}}
							<input type="hidden" name="active" value="0">
							<input type="hidden" name="parent_id" value="">

							<div class="row clearfix">
								<div class="col-sm-12">

									<div class="form-group">
										<div class="form-line">
											<input type="text" class="form-control" placeholder="Title" name="title" value="{{ old('title', $category ? $category->title : '') }}" />
										</div>
									</div>

									<div class="form-group">
										<div class="form-line">
											<input type="text" class="form-control" placeholder="Icon" name="icon" value="{{ old('icon', $category ? $category->icon : '') }}" />
										</div>
									</div>

									<div class="form-group">
									<textarea id="tinymce" name="description" >{{ old('description', $category ? $category->description : '') }}</textarea>
									</div>


									<br><br>

									<div class="form-group">
										<label for="banner">{{ $category && $category->bannerExists() ? 'Update' : 'Choose' }} Banner</label>
										{{--<input type="file" class="form-control" name="banner" id="banner"  />--}}

                                        <input type="hidden" class="form-control" id="banner"  name="banner" value="">

                                        <input type="button" value="Change Picture" class="btn btn-btcolor5 banner" data-toggle="" data-target="" data-crop-source="banner">
									</div>

									@if( $category && $category->bannerExists() )
										<div class="form-group">
										<span>Current Banner</span>
										<br><br>
										<img src="{{ $category->bannerImageUrl() }}" alt="Banner" class="col-sm-12">
									</div>
									@endif

									<div class="form-group">
										<label for="banner">{{ $category && $category->infographicExists() ? 'Update' : 'Choose' }} Infographic</label>
										<input type="file" class="form-control" name="infographic" id="infographic"  />
									</div>

									@if( $category && $category->infographicExists() )
										<div class="form-group">
											<span>Current Banner</span>
											<br><br>
											<img src="{{ $category->infographicImageUrl() }}" alt="Infographic" class="col-sm-12">
										</div>
									@endif


									<div class="form-group">
										<div class="row">
											<div class="col-sm-2">
												<div class="demo-switch-title">Active</div>
												<div class="switch">
													<label><input type="checkbox" {{ $category && $category->active ? ' checked ' : '' }} name="active" value="1"><span class="lever switch-col-blue"></span></label>
												</div>
											</div>
										</div>
									</div>


									<!-- File Upload | Drag & Drop OR With Click & Choose -->
									{{--<div class="row clearfix">--}}
										{{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
											{{--<div class="card">--}}
												{{--<div class="header">--}}
													{{--<h2>--}}
														{{--FILE UPLOAD - DRAG & DROP OR WITH CLICK & CHOOSE--}}
														{{--<small>Taken from <a href="http://www.dropzonejs.com/" target="_blank">www.dropzonejs.com</a></small>--}}
													{{--</h2>--}}
													{{--<ul class="header-dropdown m-r--5">--}}
														{{--<li class="dropdown">--}}
															{{--<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">--}}
																{{--<i class="material-icons">more_vert</i>--}}
															{{--</a>--}}
															{{--<ul class="dropdown-menu pull-right">--}}
																{{--<li><a href="javascript:void(0);">Action</a></li>--}}
																{{--<li><a href="javascript:void(0);">Another action</a></li>--}}
																{{--<li><a href="javascript:void(0);">Something else here</a></li>--}}
															{{--</ul>--}}
														{{--</li>--}}
													{{--</ul>--}}
												{{--</div>--}}
												{{--<div class="body">--}}
													{{--<div action="/fileUpload" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">--}}
														{{--<div class="dz-message">--}}
															{{--<div class="drag-icon-cph">--}}
																{{--<i class="material-icons">touch_app</i>--}}
															{{--</div>--}}
															{{--<h3>Drop files here or click to upload.</h3>--}}
															{{--<em>(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</em>--}}
														{{--</div>--}}
														{{--<div class="fallback">--}}
															{{--<input name="file" type="file" multiple />--}}
														{{--</div>--}}
													{{--</div>--}}
												{{--</div>--}}
											{{--</div>--}}
										{{--</div>--}}
									{{--</div>--}}
									<!-- #END# File Upload | Drag & Drop OR With Click & Choose -->




									<div class="form-group">
										<div class="button-demo">
											<button type="submit" class="btn bg-blue waves-effect">Save</button>
										</div>
									</div>

								</div>


							</div>

						</form>

					</div>

					@include( toolbox()->backend()->view('partials.cropper-dialog'), [
                                'heading'   => 'Edit Tile Image',
                                'image_url' => $category->bannerImageUrl(),
                            ])

				</div>
			</div>

		</div>
		{{-- END Categories --}}

		@endsection

		@section('scripts')

            <script src="{{ toolbox()->backend()->asset('/plugins/cropper/dist/cropper.js') }}"></script>
            <script>
                var cropItems = [
                    {
                        'source': '.banner',
                        'heading': 'Edit Image',
                        'post_url': '{{-- route('uploadTileImage', [$id, 'small']) --}}',
                        'original_image_url': '{{-- $tile->originalImageUrl() --}}',
                        'width': 366,
                        'height': 925
                    }
                ];

                $(function() {
                    $('.banner').click(function(){

                        $('#cropper-modal').modal({
                            keyboard: false,
                            backdrop: 'static'
                        });
                    });

                    $('#cropper-modal').on('shown.bs.modal', function (e) {

                        console.log('*** show modal ***');

                        var $source = $(e.relatedTarget);
                        console.log($source.data('crop-source'));

                    }).on('hidden.bs.modal', function () {

                        console.log('*** hide modal ***');
                    });
                });


                var backoffice_url = '{{ toolbox()->backend()->url() }}';
                var categoryId     = '{{ $id or '' }}';
//                console.info(backoffice_url);

            </script>
            <script src="{{ toolbox()->backend()->asset('/plugins/cropper/dist/cropper-helper.js') }}"></script>

			{{-- TinyMCE --}}
			<script src="{{ toolbox()->backend()->asset('/plugins/tinymce/tinymce.js') }}"></script>

			{{-- Dropzone --}}
			{{--<script src="{{ toolbox()->backend()->asset('/plugins/dropzone/dropzone.js') }}"></script>--}}

			<script>
//                Dropzone.autoDiscover = false;
//
//                $(function(){
//                    //Dropzone
//                    var myDropzone = new Dropzone("#frmFileUpload");
//                    myDropzone.options.maxFiles = 1;
//				});

                $(function () {
                    //TinyMCE
                    tinymce.init({
                        selector: "textarea#tinymce",
                        theme: "modern",
                        height: 300,
                        plugins: [
                            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                            'searchreplace wordcount visualblocks visualchars code fullscreen',
                            'insertdatetime media nonbreaking save table contextmenu directionality',
                            'emoticons template paste textcolor colorpicker textpattern imagetools'
                        ],
                        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                        toolbar2: 'print preview media | forecolor backcolor emoticons',
                        image_advtab: true
                    });

                    tinymce.suffix = ".min";
                    tinyMCE.baseURL = '{{ toolbox()->backend()->asset('/plugins/tinymce') }}';

                });
			</script>

@endsection