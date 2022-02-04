@section('title', 'Penilaian')
@section('nilai-rapor', 'menu-open')
@section('nilai_rapor', 'active')
@section('rapor', 'active')
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
              <li class="breadcrumb-item"><a href="#">Penilaian Rapor</a></li>
              <li class="breadcrumb-item"><a href="{{ route('rapor') }}">Nilai Rapor</a></li>
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
                <a href="{{ route('rapor') }}" class="btn btn-dark"><i class="fas fa-long-arrow-alt-left"></i> Kembali</a>
                <button wire:click.prevent="addNew" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Data</button>

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
                <hr>
                <div class="row">
                  <div class="col-md-4">
                      <div class="form-group">
                          <select wire:model="paginate" class="form-control form-control-sm">
                              <option value="10">10 data per halaman</option>
                              <option value="15">15 data per halaman</option>
                              <option value="20">20 data per halaman</option>
                              <option value="30">30 data per halaman</option>
                              <option value="50">50 data per halaman</option>
                          </select>
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
                              <th rowspan="2" class="align-middle">Aksi</th>
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
                          @if($nilai->isEmpty())
                              <tr>
                                      <td colspan="8" class="text-center font-italic text-danger"><h5>-- Data Tidak Ditemukan --</h5></td>
                              </tr>
                          @else
                              @foreach($nilai as $key => $data)
                                <tr>
                                    <td class="text-center">{{ $nilai->firstItem() + $key }}</td>
                                    <td class="text-center">
                                      {{ $data->lesson->nama }}
                                      <br>
                                      <span class="badge bg-primary">{{ $data->teacher->user->name }}</span>
                                    </td>
                                    <td class="text-center">{{ $data->pengetahuan_nilai }}</td>
                                    <td class="text-center">{{ $data->pengetahuan_predikat }}</td>
                                    <td class="text-center">{{ $data->pengetahuan_deskripsi }}</td>
                                    <td class="text-center">{{ $data->keterampilan_nilai }}</td>
                                    <td class="text-center">{{ $data->keterampilan_predikat }}</td>
                                    <td class="text-center">{{ $data->keterampilan_deskripsi }}</td>
                                    <td class="text-center">
                                      <div class="btn-group">
                                        <div class="btn-group">
                                            <button wire:click.prevent="edit({{ $data->id }})" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                                            <button wire:click.prevent="delete({{ $data->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </div>
                                      </div>
                                    </td>
                                </tr>
                              @endforeach
                          @endif
                      </tbody>
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

    <!-- Modal Tambah Data -->
  <div class="modal fade" id="form" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        @if($edit == false)
        <div class="modal-header bg-primary">
          <h4 class="modal-title">Form Tambah Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="createData">
        @else
          <div class="modal-header bg-warning">
            <h4 class="modal-title">Form Edit Data</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form wire:submit.prevent="updateData">
        @endif
          <div class="modal-body">
            <div class="form-group">
              <label for="pelajaran">Mata Pelajaran</label>
              <select wire:model.defer="state.pelajaran" class="form-control @error('pelajaran') is-invalid @enderror" required id="pelajaran">
                <option value="">--Pilih--</option>
                @foreach($lesson as $data)
                  <option value="{{ $data->id }}">{{ $data->nama }}</option>
                @endforeach
              </select>
              @error('pelajaran')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="pengetahuan_nilai">Nilai Pengetahuan</label>
                  <input wire:model.defer="state.pengetahuan_nilai" class="form-control @error('pengetahuan_nilai') is-invalid @enderror" required id="pengetahuan_nilai" type="number">
                  @error('pengetahuan_nilai')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="keterampilan_nilai">Nilai Keterampilan</label>
                  <input wire:model.defer="state.keterampilan_nilai" class="form-control @error('keterampilan_nilai') is-invalid @enderror" required id="keterampilan_nilai" type="number">
                  @error('keterampilan_nilai')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
            </div>
            
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            @if($edit == false)
            <button type="submit" class="btn btn-primary">Simpan</button>
            @else
            <button type="submit" class="btn btn-warning">Edit</button>
            @endif
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Modal Delete Data -->
  <div class="modal fade" id="modal-delete" wire:ignore.self>
      <div class="modal-dialog">
          <div class="modal-content bg-danger">
          <div class="modal-header">
              <h4 class="modal-title">Hapus Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
              <div class="modal-body">
                  <h5>Yakin ingin hapus data ?</h5>
              </div>
              <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                  <button wire:click.prevent="deleteData" type="button" class="btn btn-outline-light">Lanjut Hapus</button>
              </div>
          </div>
          <!-- /.modal-content -->
      </div>
  <!-- /.modal-dialog -->
  </div>

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