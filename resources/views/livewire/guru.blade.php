@section('title', 'Guru')
@section('data-guru', 'menu-open')
@section('data_guru', 'active')
@section('guru', 'active')
<div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Guru</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item"><a href="#">Kelola Data Guru</a></li>
              <li class="breadcrumb-item active">Guru</li>
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
                <button wire:click.prevent="addNew" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Data</button>
                <button class="btn btn-primary" data-toggle="modal" data-target="#modal-import"><i class="fas fa-file-upload"></i> Import Data</button>

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
                          <select wire:model="paginate" class="form-control form-control-sm">
                              <option value="10">10 data per halaman</option>
                              <option value="15">15 data per halaman</option>
                              <option value="20">20 data per halaman</option>
                              <option value="30">30 data per halaman</option>
                              <option value="50">50 data per halaman</option>
                          </select>
                      </div>
                  </div>

                  <div class="col-md-4 offset-md-4">
                      <div class="form-group">
                          <div class="input-group input-group-sm">
                              <input wire:model="search" type="text" class="form-control form-control-sm" placeholder="Cari nama...">
                              <div class="input-group-append">
                                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                              </div>
                          </div>
                          <!-- <input  type="text" class="form-control form-control-sm w-100" placeholder="Cari Nama"> -->
                      </div>
                  </div>
                </div>

                <div class="table-responsive">
                  <table class="table table-sm table-striped mt-1" width="100%">
                      <thead>
                          <tr class="text-center">
                              <th>#</th>
                              <th>Nama</th>
                              <th>Email</th>
                              <th>NIP/NIK</th>
                              <th>Kode Guru</th>
                              <th>Tempat, Tgl Lahir</th>
                              <th>L/P</th>
                              <th>Status Perkawinan</th>
                              <th>Agama</th>
                              <th>Kewarganegaraan</th>
                              <th>No Telp</th>
                              <th>Alamat</th>
                              <th>Jabatan</th>
                              <th>Pendidikan</th>
                              <th>Status Kepegawaian</th>
                              <th>Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                          @if($guru->isEmpty())
                              <tr>
                                      <td colspan="16" class="text-center font-italic text-danger"><h5>-- Data Tidak Ditemukan --</h5></td>
                              </tr>
                          @else
                              @foreach($guru as $key => $data)
                                  <tr>
                                      <td class="text-center">{{ $guru->firstItem() + $key }}</td>
                                      <td class="text-center">{{ $data->user->name }}</td>
                                      <td class="text-center">{{ $data->user->email }}</td>
                                      <td class="text-center">{{ $data->nip }}</td>
                                      <td class="text-center">{{ $data->kode }}</td>
                                      <td class="text-center">{{ $data->tempat_lahir }}, {{ $data->tgl_lahir }}</td>
                                      <td class="text-center">{{ $data->jk }}</td>
                                      <td class="text-center">{{ $data->status_merital }}</td>
                                      <td class="text-center">{{ $data->agama }}</td>
                                      <td class="text-center">{{ $data->warganegara }}</td>
                                      <td class="text-center">{{ $data->hp }}</td>
                                      <td class="text-center">{{ $data->alamat }}</td>
                                      <td class="text-center">{{ $data->position->nama }}</td>
                                      <td class="text-center">{{ $data->pendidikan }}</td>
                                      <td class="text-center">{{ $data->status_pegawai }}</td>
                                      <td class="text-center">
                                        <div class="btn-group">
                                          <button wire:click.prevent="edit({{ $data->id }})" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                                          <button wire:click.prevent="delete({{ $data->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
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
                  {{ $guru->links() }}
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
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title">Form Tambah Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="createData">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input wire:model.defer="state.nama" required type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Nama" autofocus>
                  @error('nama')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input wire:model.defer="state.email" required type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email">
                  @error('email')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="password">Password</label>
                  <input wire:model.defer="state.password" required type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                  @error('password')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="password-confirm">Konfirmasi Password</label>
                  <input wire:model.defer="state.password_confirmation" required type="password" class="form-control" id="password-confirm" placeholder="Konfirmasi Password">
                </div>
              </div>
            </div>

            <hr>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="nip">NIP</label>
                  <input wire:model.defer="state.nip" required type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" placeholder="NIP">
                  @error('nip')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="kode">Kode Guru</label>
                  <input wire:model.defer="state.kode" required type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" placeholder="Kode Guru">
                  @error('kode')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="tempat_lahir">Tempat Lahir</label>
                  <input wire:model.defer="state.tempat_lahir" required type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" placeholder="Tempat Lahir">
                  @error('tempat_lahir')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="tgl_lahir">Tanggal Lahir</label>
                  <input wire:model.defer="state.tgl_lahir" required type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" id="tgl_lahir" placeholder="Tempat Lahir">
                  @error('tgl_lahir')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="jk">Jenis Kelamin</label>
                  <select wire:model.defer="state.jk" class="form-control @error('jk') is-invalid @enderror" required id="jk">
                    <option value="">--Pilih--</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                  @error('jk')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="status_merital">Status Perkawinan</label>
                  <input wire:model.defer="state.status_merital" required type="text" class="form-control @error('status_merital') is-invalid @enderror" id="status_merital" placeholder="Status Perkawinan">
                  @error('status_merital')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="agama">Agama</label>
                  <select wire:model.defer="state.agama" class="form-control @error('agama') is-invalid @enderror" required id="agama">
                    <option value="">--Pilih--</option>
                    <option value="Islam">Islam</option>
                    <option value="Protestan">Protestan</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Buddha">Buddha</option>
                    <option value="Khonghucu">Khonghucu</option>
                  </select>
                  @error('agama')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="warganegara">Kewarganegaraan</label>
                  <input wire:model.defer="state.warganegara" required type="text" class="form-control @error('warganegara') is-invalid @enderror" id="warganegara" placeholder="Kewarganegaraan">
                  @error('warganegara')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="hp">No Telepon</label>
                  <input wire:model.defer="state.hp" required type="text" class="form-control @error('hp') is-invalid @enderror" id="hp" placeholder="No Telepon">
                  @error('hp')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="jabatan">Jabatan</label>
                  <select wire:model.defer="state.jabatan" class="form-control @error('jabatan') is-invalid @enderror" required id="jabatan">
                    <option value="">--Pilih--</option>
                    @foreach($jabatan as $data)
                      <option value="{{ $data->id }}">{{ $data->nama }}</option>
                    @endforeach
                  </select>
                  @error('jabatan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="pendidikan">Pendidikan</label>
                  <input wire:model.defer="state.pendidikan" required type="text" class="form-control @error('pendidikan') is-invalid @enderror" id="pendidikan" placeholder="Pendidikan">
                  @error('pendidikan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="status_pegawai">Status Kepegawaian</label>
                  <input wire:model.defer="state.status_pegawai" required type="text" class="form-control @error('status_pegawai') is-invalid @enderror" id="status_pegawai" placeholder="Status Kepegawaian">
                  @error('status_pegawai')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="alamat">Alamat</label>
                  <textarea wire:model.defer="state.alamat" class="form-control @error('alamat') is-invalid @enderror" required id="alamat" placeholder="Alamat"></textarea>
                  @error('alamat')
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
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Modal Edit Data -->
  <div class="modal fade" id="modal-edit" wire:ignore.self>
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h4 class="modal-title">Form Edit Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="updateData">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input wire:model.defer="state.nama" required type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Nama" autofocus>
                  @error('nama')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input wire:model.defer="state.email" required type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email">
                  @error('email')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="password">Password</label>
                  <input wire:model.defer="state.password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                  @error('password')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="password-confirm">Konfirmasi Password</label>
                  <input wire:model.defer="state.password_confirmation" type="password" class="form-control" id="password-confirm" placeholder="Konfirmasi Password">
                </div>
              </div>
            </div>

            <hr>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="nip">NIP</label>
                  <input wire:model.defer="state.nip" required type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" placeholder="NIP">
                  @error('nip')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="kode">Kode Guru</label>
                  <input wire:model.defer="state.kode" required type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" placeholder="Kode Guru">
                  @error('kode')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="tempat_lahir">Tempat Lahir</label>
                  <input wire:model.defer="state.tempat_lahir" required type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" placeholder="Tempat Lahir">
                  @error('tempat_lahir')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="tgl_lahir">Tanggal Lahir</label>
                  <input wire:model.defer="state.tgl_lahir" required type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" id="tgl_lahir" placeholder="Tempat Lahir">
                  @error('tgl_lahir')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="jk">Jenis Kelamin</label>
                  <select wire:model.defer="state.jk" class="form-control @error('jk') is-invalid @enderror" required id="jk">
                    <option value="">--Pilih--</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                  @error('jk')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="status_merital">Status Perkawinan</label>
                  <input wire:model.defer="state.status_merital" required type="text" class="form-control @error('status_merital') is-invalid @enderror" id="status_merital" placeholder="Status Perkawinan">
                  @error('status_merital')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="agama">Agama</label>
                  <select wire:model.defer="state.agama" class="form-control @error('agama') is-invalid @enderror" required id="agama">
                    <option value="">--Pilih--</option>
                    <option value="Islam">Islam</option>
                    <option value="Protestan">Protestan</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Buddha">Buddha</option>
                    <option value="Khonghucu">Khonghucu</option>
                  </select>
                  @error('agama')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="warganegara">Kewarganegaraan</label>
                  <input wire:model.defer="state.warganegara" required type="text" class="form-control @error('warganegara') is-invalid @enderror" id="warganegara" placeholder="Kewarganegaraan">
                  @error('warganegara')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="hp">No Telepon</label>
                  <input wire:model.defer="state.hp" required type="text" class="form-control @error('hp') is-invalid @enderror" id="hp" placeholder="No Telepon">
                  @error('hp')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="jabatan">Jabatan</label>
                  <select wire:model.defer="state.jabatan" class="form-control @error('jabatan') is-invalid @enderror" required id="jabatan">
                    <option value="">--Pilih--</option>
                    @foreach($jabatan as $data)
                      <option value="{{ $data->id }}">{{ $data->nama }}</option>
                    @endforeach
                  </select>
                  @error('jabatan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="pendidikan">Pendidikan</label>
                  <input wire:model.defer="state.pendidikan" required type="text" class="form-control @error('pendidikan') is-invalid @enderror" id="pendidikan" placeholder="Pendidikan">
                  @error('pendidikan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="status_pegawai">Status Kepegawaian</label>
                  <input wire:model.defer="state.status_pegawai" required type="text" class="form-control @error('status_pegawai') is-invalid @enderror" id="status_pegawai" placeholder="Status Kepegawaian">
                  @error('status_pegawai')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="alamat">Alamat</label>
                  <textarea wire:model.defer="state.alamat" class="form-control @error('alamat') is-invalid @enderror" required id="alamat" placeholder="Alamat"></textarea>
                  @error('alamat')
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
            <button type="submit" class="btn btn-warning">Edit</button>
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

  <div class="modal fade" id="modal-import">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title">Import Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('import.guru') }}" method="post" enctype="multipart/form-data">
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