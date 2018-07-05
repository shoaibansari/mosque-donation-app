@extends( toolbox()->userArea()->layout('master') )

@section('heading')
	Violation Details
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
						{{ $violation->location->address }}
					</h2>
					
				</div>
				<div class="body">
					
					
					<div class="row">
						
						{{-- start of chat panel --}}
						<div class="col-md-8">
							<div class="panel panel-primary">
								
								<div class="panel-heading" id="accordion">
									<span class="glyphicon glyphicon-comment"></span>
										Discussion Board
									<div class="btn-group pull-right">
										{{--<a type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">--}}
											{{--<span class="glyphicon glyphicon-chevron-down"></span>--}}
										{{--</a>--}}
									</div>
								</div>
								
								<div class="panel-collapse" id="collapseOne">
									<div class="panel-body">
										<ul class="chat">
											
											@foreach ( $violation->discussion as $message)
												
												{{--@if ( $message->sender->isAdministrativeUser()  )--}}
												@if ( $message->sender->id == $thisUser->id  )
													
													<li class="right clearfix">
														<span class="chat-img pull-right">
								                            <img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="{{ $message->sender->name }}" class="img-circle"/>
															{{--															<img src="{{ $message->sender->getAvatarUrl() }}" alt="{{ $message->sender->name }}" class="img-circle"/>--}}
								                        </span>
														<div class="chat-body clearfix">
															<div class="header">
																<small class=" text-muted">
																	<span class="glyphicon glyphicon-time"></span>
																	{{ $message->created_at->diffForHumans() }}
																</small>
																<strong class="pull-right primary-font">
																
																</strong>
															</div>
															<p>
																{!! nl2br( $message->comments ) !!}
															</p>
														</div>
													</li>
												
												@else
													
													<li class="left clearfix">
														<span class="chat-img pull-left">
															<img src="{{ $message->sender->getAvatarUrl() }}" alt="{{ $message->sender->name }}" class="img-circle"/>
															{{--<img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle"/>--}}
								                        </span>
														<div class="chat-body clearfix">
															<div class="header">
																<strong class="primary-font">{{ $message->sender->name }}</strong>
																<small class="pull-right text-muted">
																	<span class="glyphicon glyphicon-time"></span>
																	{{ $message->created_at->diffForHumans() }}
																</small>
															</div>
															<p>
																{!! nl2br( $message->comments ) !!}
															</p>
														</div>
													</li>
													
												@endif
												<div class="clearfix"></div>
												
											@endforeach
											
										</ul>
									</div>
									
									<div class="panel-footer">
										<div class="input-group">
											{!! Form::open( ['route' => 'violation.discussion.store', 'method' => 'post', 'files' => false]) !!}
												{{ Form::hidden('location_violation_id', $violation->id) }}
												{{ Form::textarea('comments', null, ['class' => 'form-control', 'placeholder'=>'Type your response here...', 'required' => 'required', 'rows'=>'4']) }}
												<span class="input-group-btn">
													{{ Form::submit( 'Send', ['class'=>'btn btn-warning m-t-15 waves-effect submit']) }}
	                                            </span>
											{!! Form::close() !!}
										</div>
									</div>
								</div>
							</div>
						</div>
						{{-- end of info panel --}}
						
						{{-- start of info panel --}}
						<div class="col-md-4">
							<div class="panel panel-primary">
								<div class="panel-heading" id="accordion">
									<span class="glyphicon glyphicon-info-sign"></span>
									Details
								</div>
								<div class="panel-collapse" id="collapseOne">
									<div class="panel-body" style="">
										<div class="row" style="padding: 0 10px 10px 10px" >
											<img src="{{ $violation->getImageUrl() }}" class="">
										</div>
										<div class="row" style="padding: 0 10px 10px 10px">
											{{ Form::label('violation', 'Violation') }}
											<div class="form-group">
												<div class="form-line">
													{!! $violation->violation->title !!}
												</div>
											</div>
											{{ Form::label('reporter', 'Reported By') }}
											<div class="form-group">
												<div class="form-line">
													{!! $violation->reporter->name  !!}
												</div>
											</div>
										
										</div>
									</div>
									
								</div>
								
							</div>
							
						</div>
						<div class="clearfix"></div>
						{{-- end of info panel --}}
						
					</div>
				</div>

			</div>
		</div>
	</div>

@endsection

@section('footer')
	
@endsection