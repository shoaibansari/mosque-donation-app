@extends( toolbox()->backend()->layout('master') )

@section('heading')
	{!!
	toolbox()->backend()->themeHelper()->breadcrumb([
		'Mosque' => route('admin.mosque.manage'),
		ucwords($action) => '',
	])
	!!}
@endsection

@section('head')

@endsection

@section('contents')
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						{{ ucwords($action) }}
					</h2>
				</div>

				@if ( !isset($mosque) )
					{!! Form::open( ['route' => 'admin.mosque.store', 'method' => 'post', 'files' => true, 'id'=>'mosque', "novalidate" => 'novalidate']) !!}
				@else
					{!! Form::model( $mosque, ['route' => ['admin.mosque.update'], 'method' => 'post', 'files' => true, 'id'=>'mosque']) !!}
					{{ Form::hidden('id', $mosque->id) }}
				@endif

				{{ Form::hidden('longitude', null, ['id'=>'longitude']) }}
				{{ Form::hidden('latitude', null,  ['id'=>'latitude']) }}


				<div class="body firstScreen">
					<div class="row">
						<div class="col-md-4" style="z-index: 1;">
							{{ Form::label('mosque_name', 'Mosque Name *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('mosque_name', null, ['class' => 'form-control', 'placeholder'=>'Mosque Name', 'required' => 'required']) }}
								</div>
							</div>
						</div>

						<div class="col-md-4">
							{{ Form::label('authorized_name', 'Authorized Representative Name *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('authorized_name', null, ['class' => 'form-control', 'placeholder'=>'Representative Name', 'required' => 'required']) }}
								</div>
							</div>
						</div>

                        <div class="col-md-4">
							{{ Form::label('email', 'Email *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::email('email', null, ['class' => 'form-control', 'placeholder'=>'Enter your email address']) }}
								</div>
							</div>
						</div>

						<div class="col-md-4" style="z-index: 1;">
							{{ Form::label('mosque_address', 'Mosque Address *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('address', null, ['class' => 'form-control', 'placeholder'=>'Mosque Address', 'required' => 'required', 'id' => 'address']) }}
								</div>
							</div>
						</div>

						<div class="col-md-2">
							{{ Form::label('zip_code', 'Zip code *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::number('zip_code', null, ['class' => 'form-control', 'placeholder'=>'Zip code', 'required' => 'required']) }}
								</div>
							</div>
						</div>


						<div class="col-md-4">
							{{ Form::label('phone', 'Phone *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::number('phone', null, ['class' => 'form-control', 'placeholder'=>'phone', 'required' => 'required']) }}
								</div>
							</div>
						</div>


						<div class="col-md-2">
							{{ Form::label('is_active', 'Active Mosque *') }}
							<div class="form-group">

								{{ Form::radio('is_active', '1', null, [ 'id'=>'is_activeYes']) }}
								{{ Form::label('is_activeYes', 'Yes') }}

								{{ Form::radio('is_active', '0', null, ['id'=>'is_activeNo']) }}
								{{ Form::label('is_activeNo', 'No') }}

							</div>
						</div>

						<div class="col-md-4" style="z-index: 1;">
							{{ Form::label('bank_account', 'Bank account *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::number('bank_account', null, ['class' => 'form-control', 'placeholder'=>'Bank account', 'required' => 'required']) }}
								</div>
							</div>
						</div>

						<div class="col-md-4" style="z-index: 1;">
							{{ Form::label('bank_account', 'PayPal Email *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::email('paypal_email', null, ['class' => 'form-control', 'placeholder'=>'PayPal Email', 'required' => 'required']) }}
								</div>
							</div>
						</div>

						<div class="col-md-4">
							{{ Form::label('tax_id', 'Tax ID *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::number('tax_id', null, ['class' => 'form-control', 'placeholder'=>'Tax ID', 'required' => 'required']) }}
								</div>
							</div>
						</div>

							<div class="col-md-4" style="z-index: 1;">
							{{ Form::label('city', 'City *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::text('city', null, ['class' => 'form-control', 'placeholder'=>'City', 'required' => 'required']) }}
								</div>
							</div>
						</div>


						<div class="col-md-4">
							{{ Form::label('state', 'State *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::select('state', $states , null, ['class' => 'form-control chosen-select', 'required' => 'required']) }}
								</div>
							</div>
						</div>

						
						<div class="col-md-4">
							{{ Form::label('bank_routing', 'Bank Routing') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::number('bank_routing', null, ['class' => 'form-control', 'placeholder'=>'Bank Routing', 'required' => 'required']) }}
								</div>
							</div>
						</div>

						<div class="col-md-4" id="userlist">
							{{ Form::label('user_id', 'Mosque Admin *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::select('user_id[]', $allMosqueUsers, isset($mosque->users) ? $mosque->users : null, ['class' => 'form-control chosen-select', 'required' => 'required', 'multiple' => 'multiple']) }}
								</div>
							</div>
						</div>

						@if (!isset($mosque->users) )
							<div class="col-md-12">
								<div class="form-group">
									{{ Form::checkbox('usercreate',null, null, [ 'id'=>'createUserYes']) }}
									{{ Form::label('createUserYes', 'Create a new mosque admin') }}
								</div>
							</div>
						@endif

						<div class="col-md-4" id="newuser">
							{{ Form::label('password', 'Password *') }}
							<div class="form-group">
								<div class="form-line">
									{{ Form::password('password', ['class' => 'form-control', 'placeholder'=>'Enter password']) }}
								</div>
							</div>
						</div>

						<div class="col-md-4" id="is_confirmed_user">
							{{ Form::label('is_confirmed_user', 'Required email confirmation? *') }}
							<div class="form-group">

								{{ Form::radio('is_confirmed', '0', null, [ 'id'=>'confirmedYes']) }}
								{{ Form::label('confirmedYes', 'Yes') }}

								{{ Form::radio('is_confirmed', '1', null, ['id'=>'confirmedNo']) }}
								{{ Form::label('confirmedNo', 'No') }}

							</div>
						</div>

					</div>{{-- row --}}
					
					<div class="row">
						<div class="col-md-12">
							{{ Form::submit( isset($mosque) ? 'Save' : 'Create', ['class'=>'btn btn-primary m-t-15 waves-effect submit area_done']) }}
							{{ Form::button('Cancel', ['class'=>'btn btn-danger m-t-15 waves-effect bn-cancel']) }}
						</div>
					</div>
				</div>

				{!! Form::close() !!}
			</div>
		</div>
		<div id="map">

		</div>
	</div>
	<style>
		#map {
			height: 500px;
			width: 500px;
		}
	</style>

@endsection

@section('footer')

	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.25/gmaps.js"></script>

	<script>

		$(function() {

            $('#address').change(function(event){

                GMaps.geocode({
                    address: $('#address').val(),
                    callback: function(results, status) {
                        if (status == 'OK') {
                            var latlng = results[0].geometry.location;
                            $("#latitude").val(latlng.lat());
                            $("#longitude").val(latlng.lng());
                        }
                    }
                });

            });


            $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});

		    $('.bn-cancel').click( function(e) {
		        appHelper.confirm(e, {message: 'Are you sure to cancel?', 'onConfirm': function() {
		            window.location = '{{ route('admin.mosque.manage') }}';
		        }});
		    });

		});



        if($("#createUserYes").is(":checked")){

            $("#newuser").show();
            $("#is_confirmed_user").show();
            $("#userlist").hide();
        }
        else{
            $("#userlist").show();
            $("#is_confirmed_user").hide();
            $("#newuser").hide();
        }


        $("#createUserYes").click(function () {

            if($("#createUserYes").is(":checked")){

                $("#newuser").show();
                $("#is_confirmed_user").show();
                $("#userlist").hide();
			}
            else{
                $("#userlist").show();
                $("#is_confirmed_user").hide();
                $("#newuser").hide();
			}

        });

	

	</script>
@endsection