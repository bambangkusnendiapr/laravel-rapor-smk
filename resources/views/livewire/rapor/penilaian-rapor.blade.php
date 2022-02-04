@section('title', 'Pengetahuan & Keterampilan')
@section('nilai-rapor', 'menu-open')
@section('nilai_rapor', 'active')
@section('rapor', 'active')
<div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pengetahuan & Keterampilan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item"><a href="#">Penilaian Rapor</a></li>
              <li class="breadcrumb-item"><a href="{{ route('rapor') }}">Nilai Rapor</a></li>
              <li class="breadcrumb-item active">Pengetahuan & Keterampilan</li>
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
                <a href="{{ route('rapor') }}" class="btn btn-dark"><i class="fas fa-long-arrow-alt-left"></i> Kembali</a>
                <a href="{{ route('rapor.print', $rapor->id) }}" target="_blank" class="btn btn-secondary"><i class="fas fa-file-download"></i> Print / PDF</a>

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
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <span>Siswa: </span><label>{{ $rapor->student->user->name }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span>Semester: </span><label>{{ $rapor->semester->nama }} - {{ $rapor->semester->tahun }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span>Kelas: </span><label>{{ $rapor->kelas }} - {{ $rapor->student->major->jurusan }}</label>
                        </div>
                    </div>
                </div>

                <div class="table-responsive-sm">
                  <table class="table table-sm table-bordered table-striped mt-1">
                      <thead>
                          <tr class="text-center">
                              <th rowspan="2" class="align-middle">#</th>
                              <th rowspan="2" class="align-middle">Mata Pelajaran</th>
                              <th colspan="3">Pengetahuan</th>
                              <th colspan="3">Keterampilan</th>
                          </tr>
                          <tr>
                              <th>Nilai</th>
                              <th>Predikat</th>
                              <th>Deskripsi</th>
                              <th>Nilai</th>
                              <th>Predikat</th>
                              <th>Deskripsi</th>
                          </tr>
                      </thead>
                      <tbody>
                        @php $i = 0; @endphp
                        @foreach($kelompok as $k)
                        <tr>
                          <th colspan="8">{{ $k->nama }}</th>
                        </tr>
                        @foreach($mapel->where('group_id', $k->id) as $m)
                        @php $i++; @endphp
                        <tr>
                          <td>{{ $i }}</td>
                          <td>
                            {{ $m->nama }}
                            <br>
                            @foreach($pelajaran_guru->where('lesson_id', $m->id) as $pg)
                            <span class="badge bg-primary">{{ $pg->teacher->user->name }}</span>
                            @endforeach
                          </td>
                          @forelse($nilai->where('lesson_id', $m->id) as $value)
                          <td>{{ $value->pengetahuan_nilai }}</td>
                          <td>{{ $value->pengetahuan_predikat }}</td>
                          <td>{{ $value->pengetahuan_deskripsi }}</td>
                          <td>{{ $value->keterampilan_nilai }}</td>
                          <td>{{ $value->keterampilan_predikat }}</td>
                          <td>{{ $value->keterampilan_deskripsi }}</td>
                          @empty
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          @endforelse
                        </tr>
                        @endforeach
                        @endforeach
                      </tbody>
                      <tfoot>
                          <tr>
                              <th colspan="2">Jumlah</th>
                              <th>{{ $nilai->sum('pengetahuan_nilai') +  $nilai->sum('keterampilan_nilai')}}</th>
                              <th colspan="5"></th>
                          </tr>
                          <tr>
                              <th colspan="2">Rata-rata</th>
                              <th>
                                @if(($nilai->sum('pengetahuan_nilai') +  $nilai->sum('keterampilan_nilai')) != 0)
                                {{ number_format((float)($nilai->sum('pengetahuan_nilai') +  $nilai->sum('keterampilan_nilai')) / ($nilai->count() * 2), 2, ',', '')}}
                                @endif
                              </th>
                              <th colspan="5"></th>
                          </tr>
                          <tr>
                              <th colspan="2">Peringkat Ke</th>
                              <th colspan="6"></th>
                          </tr>
                          
                      </tfoot>
                  </table>
                </div>

              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div class="d-flex justify-content-center">
                  {{ $nilai->links() }}
                </div>
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
  
        window.addEventListener('show-form', event => {
            $('#form').modal('show');
        });
  
        window.addEventListener('hide-form', event => {
            $('#form').modal('hide');            

            Swal.fire({
                "title":"Sukses!",
                "text":"Data Berhasil Disimpan",
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