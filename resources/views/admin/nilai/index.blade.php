@section('title', 'Nilai Rapor')
@section('nilai-rapor', 'menu-open')
@section('nilai_rapor', 'active')
@section('rapor-nilai', 'active')
<x-admin-layout>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Penilaian</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Penilaian</li>
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
                <h3 class="card-title">Penilaian</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <form action="{{ route('rapor.pilih') }}" method="post">
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-4">
                      <div class="form-group">
                        <label for="pelajaran">Kelas - Pelajaran</label>
                        <select name="pelajaran" required id="pelajaran" class="form-control">
                          <option value="">Pilih Pelajaran</option>
                          @foreach($pelajaran as $plj)
                            <option value="{{ $plj->id }}">{{ $plj->kelas }} - {{ $plj->nama }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="semester">Semester - Tahun Jaran</label>
                        <select name="semester" required id="semester" class="form-control">
                          <option value="">Pilih Semester</option>
                          @foreach($semester as $sms)
                            <option value="{{ $sms->id }}">{{ $sms->nama }} - {{ $sms->tahun }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="Jurusan">Jurusan</label>
                        <select name="Jurusan" required id="Jurusan" class="form-control">
                          <option value="">Pilih Jurusan</option>
                          @foreach($jurusan as $j)
                          <option value="{{ $j->id }}">{{ $j->jurusan }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                <button type="submit" class="btn btn-primary">Masukan Nilai</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</x-admin-layout>