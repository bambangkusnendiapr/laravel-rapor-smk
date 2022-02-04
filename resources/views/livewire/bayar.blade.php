@section('title', 'Ekstrakurikuler')
@section('bayar', 'active')
<div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ekstrakurikuler</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Bayar</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
              <button id="pay-button">Pay!</button>
                <pre><div id="result-json">JSON result will appear here after payment:<br></div></pre>

                <form action="Payment" id="payment-form" method="get">
                    <input type="hidden" name="result_data" id="result-data" value="">
                </form>

              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                
              </div>
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

  @push('style')
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  @endpush
  
  @push('script')
  <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-3bFUrssQLN01DDqL"></script>
    <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){

        // var resultType = document.getElementById('result-type');
        // var resultData = document.getElementById('result-data');
        // function changeResult(type. data) {
        //     $("#result-type").val(type);
        //     $("#result-data").val(JSON.stringify(data));
        // }

        // SnapToken acquired from previous step
        snap.pay('<?=$snapToken?>', {
          // Optional
          onSuccess: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 1);

            // changeResult('success', result);
            console.log(result.status_message);
            // console.log(result);
            // $("#result-data").val(result.status_message);
            // $('#payment-form').submit();
          },
          // Optional
          onPending: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 1);

            // changeResult('pending', result);
            console.log(result.status_message);
            // $("#result-data").val(result.status_message);
            // $('#payment-form').submit();
          },
          // Optional
          onError: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 1);

            // changeResult('error', result);
            console.log(result.status_message);
            // $("#result-data").val(result.status_message);
            // $('#payment-form').submit();
          }
        });
      };
    </script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Sweet alert real rashid -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script>
      $(function () {
  
        window.addEventListener('show-form-delete', event => {
            $('#modal-delete').modal('show');
        });
  
        window.addEventListener('hide-form-delete', event => {
            $('#modal-delete').modal('hide');
  
            Swal.fire({
                "title":"Sukses!",
                "text":"Data Berhasil Dihapus",
                "position":"middle-center",
                "timer":2000,
                "width":"32rem",
                "heightAuto":true,
                "padding":"1.25rem",
                "showConfirmButton":false,
                "showCloseButton":false,
                "icon":"success"
            });
  
        });
  
        window.addEventListener('show-form-edit', event => {
            $('#modal-edit').modal('show');
            // alert('edit');
        });
  
        window.addEventListener('hide-form-edit', event => {
            $('#modal-edit').modal('hide');
  
            Swal.fire({
                "title":"Sukses!",
                "text":"Data Berhasil Diedit",
                "position":"middle-center",
                "timer":2000,
                "width":"32rem",
                "heightAuto":true,
                "padding":"1.25rem",
                "showConfirmButton":false,
                "showCloseButton":false,
                "icon":"success"
            });
  
        });
  
        window.addEventListener('show-form', event => {
            $('#form').modal('show');
        });
  
        window.addEventListener('hide-form', event => {
            $('#form').modal('hide');
  
            Swal.fire({
                "title":"Sukses!",
                "text":"Data Berhasil Ditambahkan",
                "position":"middle-center",
                "timer":2000,
                "width":"32rem",
                "heightAuto":true,
                "padding":"1.25rem",
                "showConfirmButton":false,
                "showCloseButton":false,
                "icon":"success"
            });
  
        });
  
      });
    </script>
    
    @endpush

</div>