@extends( toolbox()->backend()->layout('master') )

@section('heading')
	{{ ucwords($action) }} Menu Item
@endsection

@section('head')
	<link href="{{ toolbox()->backend()->asset('plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"/>
@endsection

@section('contents')
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				{{--<div class="header">--}}
					{{--<h2>--}}
						{{--{{ ucwords($action) }} Page--}}
					{{--</h2>--}}
				{{--</div>--}}
				<div class="body">
					@if ( !isset($menuItem) )
						{!! Form::open( ['route' => 'admin.menus.store', 'method' => 'post', 'files' => false]) !!}
					@else
						{!! Form::model( $menuItem, ['route' => ['admin.menus.update'], 'method' => 'post', 'files' => false]) !!}
						{{ Form::hidden('id', $menuItem->id) }}
					@endif
						{{ Form::hidden('menu_id', $menu_id) }}
						
						{{ Form::label('heading', 'Title *') }}
						<div class="form-group">
							<div class="form-line">
								{{ Form::text('title', null, ['class' => 'form-control', 'placeholder'=>'Enter menu title']) }}
							</div>
						</div>
						
						{{ Form::label('linkWith', 'Link With *') }}
						<div class="">
							
							{{ Form::radio('type', 'slug', null, [ 'id'=>'linkWithSlug']) }}
							{{ Form::label('linkWithSlug', 'Page') }}
							
							{{ Form::radio('type', 'url', null, ['id'=>'linkWithUrl']) }}
							{{ Form::label('linkWithUrl', 'URL') }}
						
						</div>
						
						{{ Form::label('url', 'URL *', ['class' => 'url-options']) }}
						<div class="form-group url-options">
							<div class="form-line">
								{{ Form::text('url', null, ['class' => 'form-control', 'placeholder'=>'Enter URL']) }}
							</div>
						</div>
						
						
						{{ Form::label('page', 'Page *', ['class' => 'page-options']) }}
						<div class="form-group page-options">
							<div class="form-line">
								<select name="page" class="form-control show-tick">
									<option value="">-- Please select --</option>
									@foreach( $pages as $page)
										<option value="{{ $page->id }}">{{ $page->heading }}</option>
									@endforeach
								</select>
							</div>
						</div>
						
						{{ Form::label('target', 'Open In') }}
						<div class="form-group">
							<div class="form-line">
								
								{{ Form::radio('target', '_self', null, [ 'id'=>'targetCurrent', 'class'=> 'with-gap']) }}
								{{ Form::label('targetCurrent', 'Current Window') }}
								
								{{ Form::radio('target', '_top', null, [ 'id'=>'targetTop', 'class'=> 'with-gap']) }}
								{{ Form::label('targetTop', 'Parent Window') }}
								
								{{ Form::radio('target', '_blank', null, [ 'id'=>'targetBlank', 'class'=> 'with-gap']) }}
								{{ Form::label('targetBlank', 'New Window') }}
								
							</div>
						</div>
						
						{{ Form::label('active', 'Active *') }}
						<div class="">
							
							{{ Form::radio('active', '1', null, [ 'id'=>'activeYes']) }}
							{{ Form::label('activeYes', 'Yes') }}
							
							{{ Form::radio('active', '0', null, ['id'=>'activeNo']) }}
							{{ Form::label('activeNo', 'No') }}
						
						</div>
						
						{{ Form::submit( isset($menuItem) ? 'Save' : 'Create', ['class'=>'btn btn-primary m-t-15 waves-effect submit']) }}
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
		{!! JsValidator::formRequest( toolbox()->backend()->request('MenuItemUpdateRequest'))  !!}
	@else
		{!! JsValidator::formRequest( toolbox()->backend()->request('MenuItemCreateRequest'))  !!}
	@endif
	
	<script>
		$(function() {
		    
		    $('.bn-cancel').click( function(e) {
		        appHelper.confirm(e, {message: 'Are you sure to cancel?', 'onConfirm': function() {
		            window.location = '{{ route('admin.menus.manage') }}';
		        }});
		    });
		   
		    $('input[name="type"]').on('change', function(e) {
			    if ( this.value == 'slug' ) {
			        $('.page-options').show();
			        $('.url-options').hide();
			    } else {
                   $('.url-options').show();
                   $('.page-options').hide();
			    }
		    });
			
			
            if ( $('input[name="type"]:checked').val() == undefined ) {
                $('#linkWithSlug').click();
            }
            else {
                //console.warn($('input[name="type"]:checked').val() );
                
	            if ( $('input[name="type"]:checked').val() == 'slug' ) {
                    $('#linkWithSlug').change();
                    @if ( isset($menuItem) || old('page') )
	                    $('select[name="page"]').val( '{{ old('page', isset($menuItem) ? $menuItem->page : null)  }}' );
	                    $('select[name="page"]').selectpicker('refresh')
                    @endif
                } else {
                    $('#linkWithUrl').change();
                }
            }

            if ( $('input[name="target"]:checked').val() == undefined ) {
                $('#targetCurrent').click();
            }

            if ( $('input[name="active"]:checked').val() == undefined ) {
                $('#activeYes').click();
            }
		   
		});
	</script>
@endsection