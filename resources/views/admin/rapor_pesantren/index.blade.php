@section('title', 'Rapor Pesantren')
@section('nilai-rapor', 'menu-open')
@section('nilai_rapor', 'active')
@section('rapor', 'active')
<x-admin-layout>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Rapor Pesantren</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item"><a href="#">Penilaian Rapor</a></li>
              <li class="breadcrumb-item"><a href="{{ route('rapor') }}">Nilai Rapor</a></li>
              <li class="breadcrumb-item active">Rapor Pesantren</li>
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
                <a href="{{ route('rapor.pesantren.print', $rapor->id) }}" target="_blank" class="btn btn-secondary"><i class="fas fa-file-download"></i> Print / PDF</a>

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
                          <th rowspan="2" class="align-middle">Komponen</th>
                          <th rowspan="2" class="align-middle">KKM</th>
                          <th colspan="3">Nilai</th>
                          <th rowspan="2" class="align-middle">Ketuntasan</th>
                      </tr>
                      <tr>
                          <th>Angka</th>
                          <th>Huruf</th>
                          <th>Predikat</th>
                      </tr>
                      <tr>
                        <th colspan="3">Mata Pelajaran</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($mapel as $data)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nama }}</td>
                        @forelse($nilai->where('lesson_id', $data->id) as $value)
                        <td>{{ $value->kkm }}</td>
                        <td>{{ $value->nilai }}</td>
                        <td>{{ $value->huruf }}</td>
                        <td>{{ $value->predikat }}</td>
                        <td>{{ $value->tuntas }}</td>
                        @empty
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        @endforelse
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="2">Jumlah</th>
                        <th></th>
                        <th>{{ $nilai->sum('nilai') }}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                      <tr>
                        <td colspan="2">Peringkat Ke</td>
                        <td></td>
                        <td colspan="4"></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>

              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</x-admin-layout>