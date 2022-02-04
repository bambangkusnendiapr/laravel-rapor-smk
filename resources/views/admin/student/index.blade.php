@section('title', 'Siswa / Siswi')
@section('data-siswa', 'menu-open')
@section('data_siswa', 'active')
@section('student', 'active')
<x-admin-layout>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Siswa / Siswi</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Kelola Data Siswa/i</a></li>
              <li class="breadcrumb-item active">Siswa / Siswi</li>
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
                <a href="{{ route('students.create') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Tambah Data</a>
                <button class="btn btn-primary" data-toggle="modal" data-target="#modal-import"><i class="fas fa-file-upload"></i> Import Data</button>
                <button class="btn btn-primary"><i class="fas fa-file-excel"></i> Export Data</button>
                <a href="{{ route('download') }}" class="text-success"><i class="fas fa-file-download"></i> Contoh Import Data</a>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-striped" width="100%">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NIS</th>
                    <th>No Induk</th>
                    <th>Tempat, Tgl Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Agama</th>
                    <th>Kewarganegaraan</th>
                    <th>No Telp</th>
                    <th>Alamat</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($students as $data)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->user->name }}</td>
                        <td>{{ $data->user->email }}</td>
                        <td>{{ $data->nis }}</td>
                        <td>{{ $data->no_induk }}</td>
                        <td>{{ $data->tempat_lahir }}, {{ $data->tgl_lahir }}</td>
                        <td>{{ $data->jk }}</td>
                        <td>{{ $data->agama }}</td>
                        <td>{{ $data->warganegara }}</td>
                        <td>{{ $data->hp }}</td>
                        <td>{{ $data->alamat }}</td>
                        <td>{{ $data->kelas }}</td>
                        <td>{{ $data->major->jurusan }}</td>
                        <td>
                          <form action="{{ route('students.destroy', $data->user->id) }}" method="post">
                            @method('delete')
                            @csrf
                            <div class="btn-group">
                              <a href="{{ route('students.edit', $data->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                              <button type="submit" onclick="return confirm('Yakin ingin dihapus ?')" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                            </div>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

      <div class="modal fade" id="modal-import">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Import Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <label>Pilih file excel</label>
                <div class="form-group">
                  <input type="file" name="file" required>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
  </div>
  @push('style')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  @endpush
  
  @push('script')
  <!-- DataTables  & Plugins -->
  <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
  <script>
    $(function () {
      $("#example1").DataTable({
        "scrollX": true,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
  @endpush
</x-admin-layout>
