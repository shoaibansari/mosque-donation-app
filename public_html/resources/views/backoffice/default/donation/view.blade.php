@extends( toolbox()->backend()->layout('master') )

@section('heading')
  {!!
  toolbox()->backend()->themeHelper()->breadcrumb([
    'Donation' => route('admin.donation.manage'),
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
            Donation Detail
          </h2>
        </div>
        <div class="body">
          <strong> Title :</strong> {{ $donation->donation_title }}
          <hr>
           <strong> Description :</strong> {{ nl2br($donation->donation_description) }}
        </div>
      </div>
    </div>
  </div>

  
  <div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card">

        <div class="header">
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <h2>
              Funds 
            </h2>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
           
          </div>
          <div class="clearfix"></div>
        
        </div>
        <div class="body">
          {!! $dataTable->table() !!}
        </div>
      </div>
    </div>
  </div>
  
@endsection

@push('scripts')
  
  {!! $dataTable->scripts() !!}
  
  <script>
    $(function() {
        
        // Active / Inactive
            // $(document).on('change', '.active-status', function (e) {
            //     var me = $(this);
            //     appHelper.ajax('{-- route('admin.roles.status') --}', {
            //         'method': 'POST',
            //         'data': {
            //             'id': me.data('id'),
            //             'status': me.prop('checked') ? 1 : 0
            //         }
            //     });
            // });

            // New
            $('.btn-new').on('click', function (e) {
                location.href = '{{ route('admin.donation.create') }}';
            });

            // Edit
      $(document).on('click', '.btn-edit', function (e) {
                location.href = '{{ route('admin.donation.edit', '') }}/' + $(this).data('id');
            });
            //view
            $(document).on('click', '.btn-view', function (e) {
                location.href = '{{ route('admin.donation.view', '') }}/' + $(this).data('id');
            });

            // Delete
            $(document).on('click', '.btn-delete', function (e) {
                var me = $(this);
                appHelper.confirm(e, {
                    message: 'Are you sure to delete?', 'onConfirm': function () {
                        window.location = '{{ route('admin.donation.delete','') }}/' + me.data('id');
                    }
                });
            });
            
            
    });
  </script>
  
@endpush
