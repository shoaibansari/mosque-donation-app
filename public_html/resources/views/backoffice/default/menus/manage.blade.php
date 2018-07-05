@extends( toolbox()->backend()->layout('master') )

@section('heading')
	Navigation
@endsection

@section('head')
	<link href="{{ toolbox()->backend()->asset('plugins/nestable/jquery-nestable.css') }}" rel="stylesheet">
@endsection

@section('contents')
	
	@if ( isset($menus) )
		
		@foreach( $menus as $title => $menu )
			
			{{-- @continue ( !$menu ) --}}
			

			<div class="row clearfix">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="header">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<h2>
									{{ ucwords($title) }} Menu
								</h2>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<button type="button" class="btn btn-primary waves-effect pull-right btn-new" title="Create new menu item" data-menu-id="{{ repo()->menu()->getId($title) }}">New</button>
							</div>
							<div class="clearfix"></div>
							
						</div>
						
						@if ( $menu )
						<div class="body">
							
							<div class="clearfix m-b-20">
								<div class="dd nestable-with-handle" data-menu-id="{{ $menu->first()->menu_id }}">
									<ol class="dd-list">
										@foreach( $menu as $menuItem )
											
											<li class="dd-item dd3-item" data-id="{{ $menuItem->id }}">
												<div class="dd-handle dd3-handle"></div>
												<div class="dd3-content">
													
													<div style="display: inline-block !important;float: left;">
														{{ $menuItem->title }}
													</div>
													
													
													<div style="display: inline-block; float: right; ">
														<button class="btn btn-danger btn-block btn-xs waves-effect btn-delete" @if($menuItem->id == 1) disabled="" @endif>
															Delete
														</button>
													</div>
													
													<div style="display: inline-block; float: right; margin-right: 5px; ">
														<button class="btn bg-purple btn-block btn-xs waves-effect btn-edit">
															Edit
														</button>
													</div>
													
													<div class="switch" style="display: inline-block; float: right;margin-right: 30px;">
														<label>
															Active
															<input type="checkbox" @if ($menuItem->active) checked="" @endif class="active-status" value="{{ $menuItem->id }}" @if($menuItem->id == 1) disabled="" @endif>
															<span class="lever switch-col-indigo"></span>
														</label>
													</div>
													
													<div class="clearfix">
													</div>
												
												</div>
												{{--@if ( $menuItem->has('children') )--}}
												{{--<ol class="dd-list">--}}
												{{--@foreach( $menuItem['children'] as $menuItem2 )--}}
												{{--<li class="dd-item dd3-item" data-id="{{ $menuItem2->id }}">--}}
												{{--<div class="dd-handle dd3-handle"></div>--}}
												{{--<div class="dd3-content">{{ $menuItem2->title }}</div>--}}
												{{--</li>--}}
												{{--@endforeach--}}
												{{--</ol>--}}
												{{--@endif--}}
											</li>
										@endforeach
									</ol>
								</div>
							</div>
							
						</div>
						@endif
					</div>
				</div>
			</div>
		@endforeach
	
	@endif
	
@endsection

@push('scripts')
	<script src="{{ toolbox()->backend()->asset('plugins/nestable/jquery.nestable.js') }}"></script>
	<script>
		$(function() {
		    
		    // Nestable
            $('.dd').nestable({
                maxDepth: 1
            });

            // Nestable on change
            $('.dd').on('change', function () {
                
                var me = $(this);
                appHelper.ajax('{{ route('admin.menus.sort.items') }}', {
                    'method': 'POST',
                    'data': {
                        'id': me.data('menu-id'),
                        'data': window.JSON.stringify( me.nestable('serialize') )
                    }
                });
            });
            
            // active or inactive
            $(document).on('change', '.active-status', function(e) {
               var me = $(this);
               appHelper.ajax('{{ route('admin.menus.status') }}', {
                   'method': 'POST',
                   'data': {
                       'id': me.val(),
                       'status': me.prop('checked') ? 1 : 0
                   }
               });
            });
            
            // New
            $('.btn-new').on('click', function (e) {
                location.href = '{{ route('admin.menus.create', '') }}/' + $(this).data('menu-id');
            });

            // Edit
            $('.btn-edit').on('click', function (e) {
                location.href = '{{ route('admin.menus.edit', '') }}/' + $(this).closest('li').data('id');
            });

            // Delete
            $('.btn-delete').on('click', function (e) {
                var me = $(this);
                appHelper.confirm(e, {
                    message: 'Are you sure to delete?', 'onConfirm': function () {
                        window.location = '{{ route('admin.menus.delete','') }}/' + me.closest('li').data('id');
                    }
                });
            });
            
		});
	</script>
	
@endpush
