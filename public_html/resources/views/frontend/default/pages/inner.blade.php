@extends( toolbox()->frontend()->layout('inner') )
@section('title', toolbox()->frontend()->title( $page->meta_title ) )
@section('meta_keywords', $page->meta_keywords )
@section('meta_description', $page->meta_description )
@section('head')
	<style type="text/css">
		.headerMenu {
			background: rgba(255,255,255,0.7);
		}
		.headerMain {
		    background-image: url("{{ toolbox()->frontend()->asset('img/bg2.jpg') }}");
		    background-repeat: no-repeat;
		    background-size: cover;
		    background-position: center;
		}
	</style>
@stop
@section('contents')
	
		<section class="textSection">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						{!! $page->contents !!}
					</div>
				</div>
			</div>
		</section>
	
@stop