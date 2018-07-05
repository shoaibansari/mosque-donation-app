@extends( toolbox()->userArea()->layout('master') )
@section('heading') Settings @stop


@section('contents')
	
	
	{!! Form::model( $thisUser, ['route' => ['settings.update'], 'method' => 'post', 'files' => true, 'class' => 'profile-form']) !!}
	
	@foreach( $settings as $type => $fields )
		
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>{{ ucwords(str_replace("-", " ", $type)) }}</h2>
					</div>
					<div class="body">
						
						@foreach( $fields as $field )
							@continue ( !$field->visible )
							@php
							$disabled = $field->editable ? [] : ['disabled' => ""];
							@endphp
							
							<div class="row clearfix">
								<div class="col-md-2 text-right">
									{{ Form::label( $field->key, $field->label) }}
								</div>
								
								<div class="col-md-8 ">
									<div class="form-group">
										<div class="form-line">
											{{ Form::text( $field->key, $field->value, ['class' => 'form-control', 'placeholder'=>''] + $disabled) }}
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	
	@endforeach
	
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="body">
					{{ Form::submit( 'Save', ['class'=>'btn btn-primary m-t-15 waves-effect submit']) }}
				</div>
			</div>
		</div>
	</div>
	
	{{ Form::close() }}
	<!-- #END# Vertical Layout -->
	
	
	
	
@endsection

@section('footer')
	
	<script>
        $(function () {
            $('input').blur();
        });
	</script>
@endsection

