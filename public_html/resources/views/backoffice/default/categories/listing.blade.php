@extends( toolbox()->backend()->layout('master') )

@section('heading', 'Categories')

@section('head')
	<!-- JQuery DataTable Css -->
	<link href="{{ toolbox()->backend()->asset('plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endsection

@section('contents')

	{{-- Categories --}}

			<div class="">

				<div class="body">
					<div class="button-demo">
						<a href="{{ route('admin.create.category.form') }}" class="btn bg-blue waves-effect">ADD</a>
					</div>
				</div>
				<!-- Basic Examples -->
				<div class="row clearfix">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="card">

							<div class="header">
								<h2>
									Listing
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="{{ route('admin.create.category.form') }}">ADD</a></li>
											{{--<li><a href="javascript:void(0);">Another action</a></li>--}}
											{{--<li><a href="javascript:void(0);">Something else here</a></li>--}}
										</ul>
									</li>
								</ul>
							</div>
							<div class="body">
								<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
									<thead>
									<tr>
										<th>Title</th>
										<th>Description</th>
										<th>Created</th>
										<th>Actions</th>
									</tr>
									</thead>
									{{--<tfoot>--}}
									{{--<tr>--}}
										{{--<th>Title</th>--}}
										{{--<th>Created</th>--}}
										{{--<th>Actions</th>--}}
									{{--</tr>--}}
									{{--</tfoot>--}}
									<tbody>
						{{--@if( $categories->count() )--}}
							{{--@foreach($categories as $category)--}}
								{{--<tr>--}}
									{{--<td>{{ $category->title }}</td>--}}
									{{--<td>{{ $category->created_at }}</td>--}}
									{{--<td>--}}
										{{--<div class="btn-group">--}}
											{{--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
												{{--MANAGE <span class="caret"></span>--}}
											{{--</button>--}}
											{{--<ul class="dropdown-menu">--}}
												{{--<li><a href="{{ route('admin.update.category.form', [ 'id' => $category->id ]) }}">Edit</a></li>--}}
												{{--<li role="separator" class="divider"></li>--}}
												{{--<li><a href="{{ route('admin.delete.category', [ 'id' => $category->id ])  }}">Delete</a></li>--}}
											{{--</ul>--}}
										{{--</div>--}}
									{{--</td>--}}
								{{--</tr>--}}
							{{--@endforeach--}}
						{{--@endif--}}
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- #END# Basic Examples -->
			</div>
	{{-- END Categories --}}


@endsection

@section('scripts')

	 {{--Jquery DataTable Plugin Js --}}
	<script src="{{ toolbox()->backend()->asset('/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
	<script src="{{ toolbox()->backend()->asset('/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>

	<script>
        $(function () {
            // $('.js-basic-example').DataTable({
            //     responsive: true
            // });

            //Exportable table
            $('.js-basic-example').DataTable({
                // dom: 'Bfrtip',
                // responsive: true,
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print'
                // ]
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('admin.category.list') }}",
                    "type": "POST"
                }
            });
        });
	</script>
@endsection