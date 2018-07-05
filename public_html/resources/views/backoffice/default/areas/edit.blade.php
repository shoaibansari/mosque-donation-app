@extends( toolbox()->backend()->layout('master') )

@section('heading')
	Homeowner Associations
@endsection

@section('head')
	<style>
		#dlgLinkHomeOwners label {
			margin-bottom: -10px;
		}
	</style>
@endsection

@section('contents')
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<h2>
							{{ ucwords($action) }}
						</h2>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						@if ( isset($area) )
							<button type="button" class="btn btn-primary waves-effect pull-right" title="Link Homeowners" data-toggle="modal" data-target="#dlgLinkHomeOwners">
								Import Homeowners
							</button>
						@endif
					</div>
					<div class="clearfix"></div>
				</div>

				@if ( !isset($area) )
					{!! Form::open( ['id' => 'upload_csv', 'route' => 'admin.areas.store', 'method' => 'post', 'files' => true]) !!}
				@else
					{!! Form::model( $area, ['id' => 'upload_csv', 'route' => ['admin.areas.update'], 'method' => 'post', 'files' => true]) !!}
					{{ Form::hidden('id', $area->id) }}
					{{ Form::hidden('creator_id', $area->creator_id) }}
				@endif
					
				<div class="body firstScreen" style="padding-bottom: 0px;">
					<div class="row">
						<div class="col-md-6">
							{{ Form::label('title', 'Title *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('title', null, ['class' => 'form-control', 'placeholder'=>'Enter area title', 'required' => 'required']) }}
								</div>
							</div>
						</div>
							
						<div class="col-md-6">
                            {{ Form::label('active', 'Is active? *') }}
                            <div class="form-group">
                                
                                {{ Form::radio('active', '1', null, [ 'id'=>'confirmedYes']) }}
                                {{ Form::label('confirmedYes', 'Yes') }}
                                
                                {{ Form::radio('active', '0', null, ['id'=>'confirmedNo']) }}
                                {{ Form::label('confirmedNo', 'No') }}
                            
                            </div>
                        </div>                        

						<div class="col-md-12">
							{{ Form::label('area_csv', 'Locations CSV *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::file('area_csv', null, ['class' => 'form-control', 'placeholder'=>'Select an areas CSV']) }}
								</div>
								<a href="{{ route('admin.areas.sample') }}" style="margin-top: 5px; display: inline-block">
									<i class="fa fa-file"></i>
									(Download sample CSV file)
								</a>
							</div>

							{{ Form::button('Import Locations', ['id' => 'bn-import-locations', 'class'=>'btn btn-info m-t-15 waves-effect bn-info']) }}
						</div>

                        <div class="col-md-6">                          
                            <div class="form-group">                            
                              
                            </div>
                        </div>

					</div>
				</div>

				<div class="body secondScreen" @if ( !isset($area) ) style="height: 0px; overflow: hidden; padding: 0px;" @endif>
					<div class="row">
						<div class="col-md-12">
							<div class="progress mapProgressBar" @if(isset($area)) style="display: none;" @endif>
								<div class="progress-bar " role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%; color:#000; font-size: 14px; font-weight: bold;">0/0</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div id="map" style="width: 100%; height: 350px"></div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<ol id="mapDetails"></ol>
							<div id="mapDetailsFields"></div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12 actionButtons">
							@if (isset($area))
								{{ Form::submit( isset($area) ? 'Save' : 'Create', ['class'=>'btn btn-primary m-t-15 waves-effect submit area_done']) }}
								{{ Form::button('Cancel', ['class'=>'btn btn-danger m-t-15 waves-effect bn-cancel']) }}
							@else
								{{ Form::submit( isset($area) ? 'Save' : 'Create', ['class'=>'btn btn-primary m-t-15 waves-effect submit area_done', 'disabled' => 'disabled']) }}
								{{ Form::button('Cancel', ['class'=>'btn btn-danger m-t-15 waves-effect bn-cancel', 'disabled' => 'disabled']) }}
							@endif
						</div>
					</div>
				</div>

				<div class="body thirdScreen" style="display: none;">
				</div>

				{!! Form::close() !!}
			</div>
		</div>
	</div>

	@if(isset($area))
		
		{{-- DataTable --}}
		<div class="row clearfix">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card">
					<div class="body">
						{!! $dataTable->table() !!}
					</div>
				</div>
			</div>
		</div>
		
		
		{{-- Dialog - Link Homeowners --}}
		<div id="dlgLinkHomeOwners" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				
				{!! Form::open( ['id'=>'frmLinkHomeOwners', 'route' => 'admin.areas.import.homeowners', 'method' => 'post', 'files' => false]) !!}
				{{ Form::hidden('area_id', $area->id) }}
				
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Import Homeowners</h4>
					</div>
					<div class="modal-body">
						
						@if ( !$locations || $locations->count() == 0 )
							<em>No unassociated homeowner is available at the moment.</em>
						@else
							<div class="table-responsive">
								<table class="table custom-list" id="permissions-table">
									<thead>
									<tr>
										<th width="15">
											<input name="no-name" type="checkbox" id="checkAll" class="filled-in chk-col-deep-orange cb-all" checked/>
											<label for="checkAll"></label>
										</th>
										<th>Homeowner</th>
										<th>Address</th>
									</tr>
									</thead>
									<tbody>
									@foreach( $locations as $location)
										<tr>
											@php  @endphp
											<th scope="row" style="padding: 10px">
												<input type="checkbox" id="locations-{{ $location->id }}" name="locations[]" value="{{ $location->id }}" class="filled-in chk-col-deep-purple cb-homeowner"/>
												<label for="locations-{{ $location->id }}"></label>
											</th>
											<td>
												{{ $location->homeOwner->name }}
											</td>
											<td>
												{{ $location->address }}
											</td>
										</tr>
									@endforeach
									
									</tbody>
								</table>
							</div>
						@endif
						
						
					</div>
					<div class="modal-footer">
						@if ( $locations && $locations->count() > 0 )
							{{ Form::submit('Import', ['class'=>'btn btn-primary waves-effect upload']) }}
						@endif
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
		{{-- end of dialog --}}
		
	@endif

@endsection

@section('footer')

@if(isset($area))
	
	{!! $dataTable->scripts() !!}

@endif

	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.25/gmaps.js"></script>

	<script type="text/javascript">
	 
		//
	    // ADD MARKERS
	    //
        var markers = [];
        function addMarker(map, info) {
            
            info = $.extend(true, {
                title: info.address,
                lat: info.latitude,
                lng: info.longitude,
                homeowner_id: info.homeowner_id,
	            icon: "{{ toolbox()->backend()->asset('images/blue-dot.png') }}",
                draggable: true
            }, info);

            var id = markers.length;
            info.id = id;
            var marker = map.addMarker(info);
            markers[id] = marker;
            return marker;
        }

        //
        // READ GEO-CODE FROM GOOGLE
	    //
        var OKAY = true;
        var CURRENT_INDEX = 0;
        function findAddresses( addresses, onAddressComplete, onComplete ) {
            
            if ( addresses.length == 0 || CURRENT_INDEX >= addresses.length ) {
                OKAY = true;
                return;
            }
            
            var timerId = setInterval(function() {
                if ( OKAY ) {
                    var value = addresses[ CURRENT_INDEX++ ];
                    OKAY = false;
                    if ( value && typeof value.address !== undefined ) {
                        GMaps.geocode({
                            address: value.address,
                            callback: function (results, status) {
                                onAddressComplete(results, status, value);
                                OKAY = true;
                            }
                        });
                    }
                    else {
                        clearInterval( timerId );
                        if ( typeof onComplete == 'function') {
                            onComplete.call();
                        }
                    }
                }
            }, 500);
            
        }
	    
        //
        // FIT MAP ACCORDING TO MARKERS POSITION
	    //
        function fitMap( map ) {
            var bounds = new google.maps.LatLngBounds();
            for (var i = 0; i < markers.length; i++) {
                bounds.extend(markers[i].getPosition());
            }

            map.fitBounds(bounds);
        }

        //
        // BIND INFO-WINDOW WITH MARKERS
	    //
		var iw = new google.maps.InfoWindow({maxWidth: 350});
        function bindInfoWindow(event, marker) {
            event = ( typeof event == 'undefined') ? 'click' : event;
            
            // set info window to specific marker only
            if ( typeof marker != 'undefined' ) {
                google.maps.event.addListener(marker, event, (function (marker) {
                    return function () {
                        var html = getInfoWindowContent(marker);
                        iw.setContent(html);
                        iw.open(map, marker, html);
                    }
                })(marker));
                return;
            }
            
            // associate to to all markers
            for (var i = 0; i < markers.length; i++) {
                var marker = markers[i];
                //console.log( marker.position.lat(), marker.lng, marker.id);
                google.maps.event.addListener(marker, event, (function (marker, i) {
                    return function () {
                        var html = getInfoWindowContent(marker);
                        iw.setContent(html);
                        iw.open(map, marker, html);
                    }
                })(marker, i));
            }
        }

        //
		// INFO-WINDOW TEMPLATE
		//
        function getInfoWindowContent(marker) {
            
            return '' +
                '<h5>' + marker.title + '</h5>' +
                '<p>' +
                '<a href="#" class="duplicate-marker" data-marker-id="'+ marker.id + '">Duplicate Marker</a> | ' +
                '<a href="#" class="remove-marker"  data-marker-id="' + marker.id +'">Remove Marker</a>' +
                '</p>';
        }

        //
		// CSV IMPORT PROGRESS
		//
        function showProgress(totalRecords, itsCount) {
           // alert(itsCount);
            var tw = (itsCount / totalRecords) * 100;
            $('.mapProgressBar .progress-bar').css('width', tw + '%');
            //$('.mapProgressBar .progress-bar').html(Math.round(parseInt(tw)) + '% Completed');
            $('.mapProgressBar .progress-bar').html(itsCount + ' of ' + totalRecords );
            if ( itsCount == totalRecords) {
                setTimeout( function() {
                    $('.mapProgressBar .progress-bar').html('Completed')
                }, 1000);
            }
        }
	    
        var map;
	    $(document).ready(function(){
	     
		    {{-- GOOGLE MAP INSTANCE --}}
	        map = new GMaps({
				div: '#map',
				lat: -12.043333,
				lng: -77.028333
			});
		
		    {{-- EDIT MODE --}}
		    @if ( isset($area) )
			    @foreach ($area->locations as $value)
	                addMarker(map, {!! json_encode($value) !!} );
			    @endforeach
	            bindInfoWindow();
	            fitMap(map);
		    @endif
		    

		    {{-- IMPORT LOCATIONS FROM CSV --}}
            $('#bn-import-locations').on("click", function (e) {
                e.preventDefault();

                if ($('#area_csv').val() == '') {
                    alert('Please select a CSV file.');
                    return false;
                }
			
			    @if( isset($area) )
	                $('.progress.mapProgressBar').show();
	                $(map.markers).each(function (index, value) {
	                    value.setMap(null);
	                });
			    @endif
				   
				csvFile = new FormData();
                csvFile.append('area_csv', $('#area_csv')[0].files[0]);

                $.ajax({
                    url: "{{route('admin.areas.locations')}}",
                    type: 'post',
                    data: csvFile,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        
                        var totalRecords = response.total;
                        var itsCount = 1;
                        
                        $(response.existing).each(function (index, value) {
                            addMarker(map, {
                                address: value.address,
                                latitude: value.latitude,
                                longitude: value.longitude,
                                homeowner_id: value.user
                            });
                            showProgress(totalRecords, itsCount);
                            itsCount++;
                        });
                        
                        if ( response.new.length ) {
                            findAddresses(
                                response.new,
                                function (results, status, value) {
                                    if ( status == 'OK' ) {
                                        addMarker(map, {
                                            address: value.address,
                                            latitude: results[0].geometry.location.lat(),
                                            longitude: results[0].geometry.location.lng(),
                                            homeowner_id: value.user
                                        });
                                        showProgress(totalRecords, itsCount);
                                        itsCount++;
                                    }
                                },
                                function () {
                                    fitMap(map);
                                    bindInfoWindow();
                                }
                            );
                        }
                        else {
                            fitMap(map);
                            bindInfoWindow();
                        }
                        
                        $('.actionButtons input[type="submit"], .actionButtons button').removeAttr('disabled');
                    }
                });


                $('.body').hide();
                $(this).hide();
                $('.body.firstScreen').show();
                $('.body.secondScreen').show();
                $('.body.secondScreen').css('height', 'auto');
                $('.body.secondScreen').css('padding', '20px');
            });

		    {{-- ON SAVE --}}
            $('.area_done').on("click", function (e) {
                var mapMarkers = '';
                var mapMarkersFields = '';
                $(map.markers).each(function (index, value) {
                    if (value.map) {
                        mapMarkers += '<li><strong>Title: </strong>' + value.title + ' <strong>Latitude: </strong>' + value.position.lat() + ' <strong>Longitude: </strong>' + value.position.lng() + '</li>';
                        mapMarkersFields += '<input type="hidden" name="map_locations[' + value.title + '][]" value="' + value.position.lat() + '|' + value.position.lng() + '|' + value.homeowner_id + '">';
                    }
                });
                $('#mapDetails').html(mapMarkers);
                $('#mapDetailsFields').html(mapMarkersFields);
            });
		   
		    {{-- ON DUPLICATE MARKER --}}
            $(document).on('click', '.duplicate-marker', function (e) {
                e.preventDefault();
                console.log('duplicate');
			    
                var $me = $(this);
                var markerId = $me.data('marker-id');
                var marker = markers[ markerId ];
                
                iw.close();
                var newMarker = addMarker(map, {
                    title: marker.address,
                    lat: marker.position.lat(),
                    lng: marker.position.lng(),
                    homeowner_id: marker.homeowner_id,
                    icon: "{{ toolbox()->backend()->asset('images/green-dot.png') }}"
                });

                // BINDING INFO-WINDOW WITH NEW MARKER
                bindInfoWindow('click', newMarker);
            
            });
		
		    {{-- ON REMOVE MARKER --}}
            $(document).on('click', '.remove-marker', function (e) {
                e.preventDefault();
                console.log('remove');
                var $me = $(this);
                if ( confirm('Are you sure to remove this pin?') ) {
                    var markerId = $me.data('marker-id');
                    var marker = markers[markerId];
                    marker.setMap(null);
                }
                /*
                appHelper.confirm(e, {
                    message: 'Are you sure to remove this pin?',
	                closeOnConfirm: true,
	                onConfirm: function () {
                        var markerId = $me.data('marker-id');
                        var marker = markers[markerId];
                        marker.setMap(null);
                    },
	                
                });
                */
                
                
            });


        });

	</script>

	@if ( $action == 'create' )
		{!! JsValidator::formRequest( toolbox()->backend()->request('AreaCreateRequest'), '#upload_csv')  !!}
	@else
		{!! JsValidator::formRequest( toolbox()->backend()->request('AreaUpdateRequest'), '#upload_csv')  !!}
	@endif
	{!! JsValidator::formRequest( toolbox()->backend()->request('HomeownersLinkWithAreaRequest'), '#frmLinkHomeOwners')  !!}
	
	<script>
		$(function() {

            // New
            $('.btn-new').on('click', function (e) {
                location.href = '{{ route('admin.area.location.create') }}';
            });

            // Edit
            $(document).on('click', '.btn-edit', function (e) {
                location.href = '{{ route('admin.area.location.edit', ['', '']) }}/' + $(this).data('area-id') + '/' + $(this).data('location-id');
            });

            // Delete
            $(document).on('click', '.btn-delete', function (e) {
                var me = $(this);
                appHelper.confirm(e, {
                    message: 'Are you sure to delete?', 'onConfirm': function () {
                        window.location = '{{ route('admin.area.location.delete', ['', '']) }}/' + me.data('area-id') + '/' + me.data('location-id');
                    }
                });
            });

            // Cancel
            $('.bn-cancel').click(function (e) {
                appHelper.confirm(e, {
                    message: 'Are you sure to cancel?', 'onConfirm': function () {
                        window.location = '{{ route('admin.areas.manage') }}';
                    }
                });
            });

            
            // Links to Homeowners
            function UpdateCheckAllBox(e) {
                if ( $('.cb-homeowner:checked').size() == $('.cb-homeowner').size()) {
                    $('.cb-all').prop('checked', true);
                } else {
                    $('.cb-all').prop('checked', false);
                }
            }
			
            // Check/uncheck all
            $(document).on('click', '.cb-all', function (e) {
                $('.cb-homeowner').prop('checked', $(this).prop('checked'));
            });

            //  checkbox
            $(document).on('click', '.cb-homeowner', UpdateCheckAllBox);
           
            // Update all checkboxes if all homeowners are selected.
            UpdateCheckAllBox();
            
            $(document).on('submit', '#frmLinkHomeOwners', function() {
                if ( !$('.cb-homeowner:checked').size() ) {
                    alert("Please select at least one homeowner to continue.");
                    return false;
                }
            })
			
        });
	</script>
@endsection