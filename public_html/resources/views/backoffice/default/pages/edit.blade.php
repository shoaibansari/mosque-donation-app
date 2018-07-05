@extends( toolbox()->backend()->layout('master') )

@section('header')

@endsection

@section('contents')
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						{{ ucwords($action) }} Page
					</h2>
				</div>
				<div class="body">
					@if ( !isset($page) )
						{!! Form::open( ['route' => 'admin.pages.store', 'method' => 'post', 'files' => true]) !!}
					@else
						{!! Form::model( $page, ['route' => ['admin.pages.update'], 'method' => 'post', 'files' => true]) !!}
						{{ Form::hidden('id', $page->id) }}
					@endif
						
						{{ Form::label('heading', 'Heading *') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::text('heading', null, ['class' => 'form-control', 'placeholder'=>'Enter page heading']) }}
							</div>
						</div>
						
						{{ Form::label('contents', 'Contents *') }}
						<div class="form-group">
							<div class="form-line">
								{!!  Form::textarea('contents', isset($page) ? $page->contents : null, ['class' => 'form-control']) !!}
							</div>
						</div>
						
						{{ Form::label('banner', 'Banner * (Size limit: '. toolbox()->upload()->getSizeLimit( true ) .')') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::file('banner', null, ['class' => 'form-control', 'placeholder'=>'Select page banner']) }}
							</div>
						</div>
						
						
						
						{{ Form::label('meta_title', 'Meta Title') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::text('meta_title', null, ['class' => 'form-control', 'placeholder'=>'Enter page meta title']) }}
							</div>
						</div>
						
						{{ Form::label('meta_keywords', 'Meta Keywords') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::text('meta_keywords', null, ['class' => 'form-control', 'placeholder'=>'Enter page meta keywords']) }}
							</div>
						</div>
						
						{{ Form::label('meta_description', 'Meta Description') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::textarea('meta_description', null, ['class' => 'form-control', 'placeholder'=>'Enter page meta description', 'rows' => 5]) }}
							</div>
						</div>
						
						{{ Form::label('published_box', 'Publish *') }}
						<div class="">
							
							{{ Form::radio('published', 1, null, [ 'id'=>'publishedYes']) }}
							{{ Form::label('publishedYes', 'Yes') }}
							
							{{ Form::radio('published', 0, null, ['id'=>'publishedNo']) }}
							{{ Form::label('publishedNo', 'No') }}
						
						</div>
						
						{{ Form::submit( isset($page) ? 'Save' : 'Create', ['class'=>'btn btn-primary m-t-15 waves-effect submit']) }}
						{{ Form::button('Cancel', ['class'=>'btn btn-danger m-t-15 waves-effect bn-cancel']) }}
					
					{!! Form::close() !!}
					
				</div>
			</div>
		</div>
	</div>
	
@endsection

@section('footer')
	
	@if ( settings('wysiwyg.editor') == 'tinymce' )
		<script src="{{ toolbox()->backend()->asset('/plugins/tinymce/tinymce.js') }}"></script>
		{{--<script src="{{ toolbox()->backend()->asset('/plugins/tinymce/plugins/variables/src/plugin.js') }}"></script>--}}
		<script>
            //TinyMCE
            tinymce.init({
                selector: "#contents",
                theme: "modern",
                height: 400,
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
                },

//                setup: function (ed) {
//                    window.tester = ed;
//                    ed.addButton('mybutton', {
//                        title: 'My button',
//                        text: 'Insert variable',
//                        onclick: function () {
//                            ed.plugins.variables.addVariable('account_id');
//                        }
//                    });
//
//                    ed.on('variableClick', function (e) {
//                        console.log('click', e);
//                    });
//                },
//
//                variable_mapper: {
//                    username: 'Username',
//                    phone: 'Phone',
//                    community_name: 'Community name',
//                    email: 'Email address',
//                    sender: 'Sender name',
//                    account_id: 'Account ID'
//                }

            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{ toolbox()->backend()->asset('/plugins/tinymce') }}';
		</script>
	@else
		<script src="{{ toolbox()->backend()->asset('/plugins/ckeditor/ckeditor.js') }}"></script>
		<script>
            CKEDITOR.replace('contents', {
                'height': 400,
                'contentsCss': '{{ toolbox()->frontend()->asset('/css/backoffice-editor.css') }}'
            });
		</script>
	@endif
	
	
	@if ( isset($page) )
		{!! JsValidator::formRequest( toolbox()->backend()->request('PageUpdateRequest'))  !!}
	@else
		{!! JsValidator::formRequest( toolbox()->backend()->request('PageCreateRequest'))  !!}
	@endif
	
	<script>
		$(function() {
		   $('.bn-cancel').click( function(e) {
		      appHelper.confirm(e, {message: 'Are you sure to cancel?', 'onConfirm': function() {
		        window.location = '{{ route('admin.pages.manage') }}';
		      }});
		   });
		});
	</script>
@endsection