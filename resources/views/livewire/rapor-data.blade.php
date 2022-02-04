@section('title', 'Nilai Rapor')
@section('nilai-rapor', 'menu-open')
@section('nilai_rapor', 'active')
@section('rapor', 'active')
<div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Nilai Rapor</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item"><a href="#">Penilaian Rapor</a></li>
              <li class="breadcrumb-item active">Nilai Rapor</li>
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

            <!-- Rapor untuk semua -->
            <!-- Default box -->
            <div class="card">
              @role('superadmin|wali_kelas')
              <div class="card-header">
                <h3 class="card-title"><button wire:click.prevent="addNew" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Data</button> &nbsp; Rapor Siswa</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              @endrole
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

                <div class="table-responsive-sm">
                  <table class="table table-sm table-striped mt-1">
                      <thead>
                          <tr class="text-center">
                              <th>#</th>
                              @role('superadmin|wali_kelas|siswa|orang_tua')
                              <th>Catatan Orang Tua</th>
                              @endrole
                              <th>Nama Siswa</th>
                              <th>Semester</th>
                              <th>Tahun Ajaran</th>
                              <th>Kelas</th>
                              <th>Jurusan</th>
                              @role('superadmin|guru')
                              <th>Penilaian Pelajaran</th>
                              <th>Penilaian Pesantren</th>
                              @endrole
                              <!-- <th>Penilaian & Catatan</th> -->
                              @role('superadmin|wali_kelas|siswa|orang_tua')
                              <th>Penilaian Kepesantrenan</th>
                              <th>Aksi</th>
                              @endrole
                          </tr>
                      </thead>
                      <tbody>
                          @if($rapor->isEmpty())
                              <tr>
                                      <td colspan="11" class="text-center font-italic text-danger"><h5>-- Data Tidak Ditemukan --</h5></td>
                              </tr>
                          @else
                              @foreach($rapor as $key => $data)
                                <tr>
                                    <td class="text-center">{{ $rapor->firstItem() + $key }}</td>
                                    @role('superadmin|wali_kelas|siswa|orang_tua')
                                    <td><button class="btn btn-danger" wire:click.prevent="catatan_ortu({{ $data->id }})">Catatan Orang Tua</button></td>
                                    @endrole
                                    <td class="text-center">{{ $data->student->user->name }}</td>
                                    <td class="text-center">{{ $data->semester->nama }}</td>
                                    <td class="text-center">{{ $data->semester->tahun }}</td>
                                    <td class="text-center">{{ $data->kelas }}</td>
                                    <td class="text-center">{{ $data->student->major->jurusan }}</td>
                                    @role('superadmin|guru')
                                    <td class="text-center"><a href="{{ route('penilaian', $data->id) }}" class="btn btn-primary">Nilai Pelajaran Umum</a></td>
                                    <td class="text-center"><a href="{{ route('penilaian.pesantren', $data->id) }}" class="btn btn-success">Nilai Pelajaran Pesantren</a></td>
                                    @endrole
                                    <!-- <td class="text-center"><button wire:click.prevent="lihat({{ $data->id }})" class="btn btn-secondary">Lihat Penilaian & Catatan</button></td> -->
                                    @role('superadmin|wali_kelas|siswa|orang_tua')
                                    <td class="text-center">
                                      <div class="dropdown">
                                          <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                            Rapor Kepesantrenan
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{ route('rapor.pesantren', $data->id) }}">Rapor Kepesantrenan</a>
                                            <button class="dropdown-item" wire:click.prevent="catatan_pesantren({{ $data->id }})">Catatan, Pengembangan & Absensi</button>
                                            <a class="dropdown-item" href="{{ route('eskul.pesantren', $data->id) }}">Ekstrakurikuler</a>
                                            @if($data->semester->nama == 'Genap')
                                              <button class="dropdown-item" wire:click.prevent="kelulusan({{ $data->id }})">Kelulusan</button>
                                            @endif
                                          </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                      <div class="btn-group">
                                        <div class="dropdown">
                                          <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                            Rapor
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{ route('penilaian.rapor', $data->id) }}">Pengetahuan & Keterampilan</a>
                                            <a class="dropdown-item" href="{{ route('eskul', $data->id) }}">Ekstrakurikuler</a>
                                            <a class="dropdown-item" href="{{ route('prestasi', $data->id) }}">Prestasi</a>
                                          </div>
                                        </div>
                                        <div class="btn-group">
                                            <button wire:click.prevent="edit({{ $data->id }})" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                                            @role('superadmin|wali_kelas')
                                            <button wire:click.prevent="delete({{ $data->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            @endrole
                                        </div>
                                      </div>
                                    </td>
                                    @endrole
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
                  {{ $rapor->links() }}
                </div>
              </div>
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->


            <!-- Rapor untuk wali kelas -->
            @role('wali_kelas')
              <!-- Default box -->
            <div class="card">
              <div class="card-header bg-primary">
                <h3 class="card-title">Penilaian Mata Pelajaran</h3>

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
                          <select wire:model="halaman" class="form-control form-control-sm">
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
                              <input wire:model="cari" type="text" class="form-control form-control-sm" placeholder="Cari nama...">
                              <div class="input-group-append">
                                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                              </div>
                          </div>
                          <!-- <input  type="text" class="form-control form-control-sm w-100" placeholder="Cari Nama"> -->
                      </div>
                  </div>
                </div>

                <div class="table-responsive-sm">
                  <table class="table table-sm table-striped mt-1">
                      <thead>
                          <tr class="text-center">
                              <th>#</th>
                              <th>Nama Siswa</th>
                              <th>Semester</th>
                              <th>Tahun Ajaran</th>
                              <th>Kelas</th>
                              <th>Jurusan</th>
                              <th>Penilaian Pelajaran</th>
                              <th>Penilaian Pesantren</th>
                          </tr>
                      </thead>
                      <tbody>
                          @if($rapor_wali_kelas->isEmpty())
                              <tr>
                                      <td colspan="8" class="text-center font-italic text-danger"><h5>-- Data Tidak Ditemukan --</h5></td>
                              </tr>
                          @else
                              @foreach($rapor_wali_kelas as $key => $value)
                                <tr>
                                    <td class="text-center">{{ $rapor_wali_kelas->firstItem() + $key }}</td>
                                    <td class="text-center">{{ $value->student->user->name }}</td>
                                    <td class="text-center">{{ $value->semester->nama }}</td>
                                    <td class="text-center">{{ $value->semester->tahun }}</td>
                                    <td class="text-center">{{ $value->kelas }}</td>
                                    <td class="text-center">{{ $value->student->major->jurusan }}</td>
                                    <td class="text-center"><a href="{{ route('penilaian', $value->id) }}" class="btn btn-primary">Nilai Pelajaran Umum</a></td>
                                    <td class="text-center"><a href="{{ route('penilaian.pesantren', $value->id) }}" class="btn btn-success">Nilai Pelajaran Pesantren</a></td>
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
                  {{ $rapor_wali_kelas->links() }}
                </div>
              </div>
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
            @endrole
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
                  <label for="tanggal">Tanggal Bagi Rapor</label>
                  <input wire:model.defer="state.tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror" required id="tanggal">
                  @error('tanggal')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>

              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="semester">Semester - Tahun Ajaran</label>
                  <select wire:model.defer="state.semester" class="form-control @error('semester') is-invalid @enderror" required id="semester">
                    <option value="">--Pilih--</option>
                    @foreach($semester as $data)
                      <option value="{{ $data->id }}">{{ $data->nama }} - {{ $data->tahun }}</option>
                    @endforeach
                  </select>
                  @error('semester')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>

              </div>

            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="kelas">Kelas</label>
                  <select wire:model.defer="state.kelas" class="form-control @error('kelas') is-invalid @enderror" required id="kelas">
                    <option value="">--Pilih--</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                  </select>
                  @error('kelas')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
  
              </div>              
  
              <div class="col-md-6">
                <div class="form-group">
                  <label for="siswa">Siswa</label>
                  <select wire:model.defer="state.siswa" class="form-control @error('siswa') is-invalid @enderror" required id="siswa">
                    <option value="">--Pilih--</option>
                    @foreach($siswa as $data)
                      <option value="{{ $data->id }}">{{ $data->kelas }} - {{ $data->major->jurusan }} - {{ $data->user->name }}</option>
                    @endforeach
                  </select>
                  @error('siswa')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
            </div>  
            
            <hr>

            <div class="form-group">
              <label for="spiritual">Deskripsi Sikap Spiritual</label>
              <textarea wire:model.defer="state.spiritual" class="form-control @error('spiritual') is-invalid @enderror" required id="spiritual" placeholder="Deskripsi Sikap Spiritual"></textarea>
              @error('spiritual')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="sosial">Deskripsi Sikap Sosial</label>
              <textarea wire:model.defer="state.sosial" class="form-control @error('sosial') is-invalid @enderror" required id="sosial" placeholder="Deskripsi Sikap Sosial"></textarea>
              @error('sosial')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="catatan">Catatan Wali Kelas</label>
              <textarea wire:model.defer="state.catatan" class="form-control @error('catatan') is-invalid @enderror" required id="catatan" placeholder="Catatan Wali Kelas"></textarea>
              @error('catatan')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <hr>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Sakit</label>
                    <div class="input-group">
                        <input wire:model.defer="state.sakit" type="number" class="form-control @error('sakit') is-invalid @enderror" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">Hari</div>
                        </div>
                    </div>
                    @error('sakit')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Izin</label>
                    <div class="input-group">
                        <input wire:model.defer="state.izin" type="number" class="form-control @error('izin') is-invalid @enderror" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">Hari</div>
                        </div>
                    </div>
                    @error('izin')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tanpa Keterangan</label>
                    <div class="input-group">
                        <input wire:model.defer="state.alpa" type="number" class="form-control @error('alpa') is-invalid @enderror" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">Hari</div>
                        </div>
                    </div>
                    @error('alpa')
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
                  <label for="tanggal">Tanggal Bagi Rapor</label>
                  <input wire:model.defer="state.tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror" required id="tanggal">
                  @error('tanggal')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>

              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="semester">Semester - Tahun Ajaran</label>
                  <select wire:model.defer="state.semester" class="form-control @error('semester') is-invalid @enderror" required id="semester">
                    <option value="">--Pilih--</option>
                    @foreach($semester as $data)
                      <option value="{{ $data->id }}">{{ $data->nama }} - {{ $data->tahun }}</option>
                    @endforeach
                  </select>
                  @error('semester')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>

              </div>

            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="kelas">Kelas</label>
                  <select wire:model.defer="state.kelas" class="form-control @error('kelas') is-invalid @enderror" required id="kelas">
                    <option value="">--Pilih--</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                  </select>
                  @error('kelas')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
  
              </div>              
  
              <div class="col-md-6">
                <div class="form-group">
                  <label for="siswa">Siswa</label>
                  <select wire:model.defer="state.siswa" class="form-control @error('siswa') is-invalid @enderror" required id="siswa">
                    <option value="">--Pilih--</option>
                    @foreach($siswa as $data)
                      <option value="{{ $data->id }}">{{ $data->kelas }} - {{ $data->major->jurusan }} - {{ $data->user->name }}</option>
                    @endforeach
                  </select>
                  @error('siswa')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
            </div>
                        
            <hr>

            <div class="form-group">
              <label for="spiritual">Deskripsi Sikap Spiritual</label>
              <textarea wire:model.defer="state.spiritual" @role('siswa|orang_tua') readonly @endrole class="form-control @error('spiritual') is-invalid @enderror" required id="spiritual" placeholder="Deskripsi Sikap Spiritual"></textarea>
              @error('spiritual')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="sosial">Deskripsi Sikap Sosial</label>
              <textarea wire:model.defer="state.sosial" @role('siswa|orang_tua') readonly @endrole class="form-control @error('sosial') is-invalid @enderror" required id="sosial" placeholder="Deskripsi Sikap Sosial"></textarea>
              @error('sosial')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="catatan">Catatan Wali Kelas</label>
              <textarea wire:model.defer="state.catatan" @role('siswa|orang_tua') readonly @endrole class="form-control @error('catatan') is-invalid @enderror" required id="catatan" placeholder="Catatan Wali Kelas"></textarea>
              @error('catatan')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <hr>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Sakit</label>
                    <div class="input-group">
                        <input wire:model.defer="state.sakit" @role('siswa|orang_tua') readonly @endrole type="number" class="form-control @error('sakit') is-invalid @enderror" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">Hari</div>
                        </div>
                    </div>
                    @error('sakit')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Izin</label>
                    <div class="input-group">
                        <input wire:model.defer="state.izin" @role('siswa|orang_tua') readonly @endrole type="number" class="form-control @error('izin') is-invalid @enderror" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">Hari</div>
                        </div>
                    </div>
                    @error('izin')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tanpa Keterangan</label>
                    <div class="input-group">
                        <input wire:model.defer="state.alpa" @role('siswa|orang_tua') readonly @endrole type="number" class="form-control @error('alpa') is-invalid @enderror" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">Hari</div>
                        </div>
                    </div>
                    @error('alpa')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Jumlah</label>
                    <div class="input-group">
                        <input wire:model.defer="state.jumlah" readonly type="number" class="form-control"/>
                        <div class="input-group-append">
                            <div class="input-group-text">Hari</div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            @role('superadmin|wali_kelas')
            <button type="submit" class="btn btn-warning">Edit</button>
            @endrole
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Modal Lihat Data -->
  <div class="modal fade" id="modal-lihat" wire:ignore.self>
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-secondary">
          <h4 class="modal-title">{{ $lihat_siswa }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="updateData">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Semester - Tahun jaran</label>
                  <input type="text" class="form-control" readonly value="{{ $lihat_semester }}">
                </div>
              </div>
              
              <div class="col-md-6">
                <label>Kelas - Jurusan</label>
                <input type="text" class="form-control" readonly value="{{ $lihat_kelas }}">
              </div>
            </div>  
            
            <hr>

            <div class="form-group">
              <label for="spiritual">Deskripsi Sikap Spiritual</label>
              <textarea wire:model.defer="state.spiritual" readonly class="form-control @error('spiritual') is-invalid @enderror" required id="spiritual" placeholder="Deskripsi Sikap Spiritual"></textarea>
              @error('spiritual')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="sosial">Deskripsi Sikap Sosial</label>
              <textarea wire:model.defer="state.sosial" readonly class="form-control @error('sosial') is-invalid @enderror" required id="sosial" placeholder="Deskripsi Sikap Sosial"></textarea>
              @error('sosial')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="catatan">Catatan Wali Kelas</label>
              <textarea wire:model.defer="state.catatan" readonly class="form-control @error('catatan') is-invalid @enderror" required id="catatan" placeholder="Catatan Wali Kelas"></textarea>
              @error('catatan')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Sakit</label>
                    <div class="input-group">
                        <input wire:model.defer="state.sakit" readonly type="number" class="form-control @error('sakit') is-invalid @enderror" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">Hari</div>
                        </div>
                    </div>
                    @error('sakit')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Izin</label>
                    <div class="input-group">
                        <input wire:model.defer="state.izin" readonly type="number" class="form-control @error('izin') is-invalid @enderror" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">Hari</div>
                        </div>
                    </div>
                    @error('izin')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tanpa Keterangan</label>
                    <div class="input-group">
                        <input wire:model.defer="state.alpa" readonly type="number" class="form-control @error('alpa') is-invalid @enderror" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">Hari</div>
                        </div>
                    </div>
                    @error('alpa')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Jumlah</label>
                    <div class="input-group">
                        <input wire:model.defer="state.jumlah" readonly type="number" class="form-control"/>
                        <div class="input-group-append">
                            <div class="input-group-text">Hari</div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Modal Catatan Pesantren -->
  <div class="modal fade" id="modal-catatan-pesantren" wire:ignore.self>
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title">Form Catatan Kepesantrenan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="updateCatatanPesantren">
          <div class="modal-body">
            <div class="form-group">
              <label for="catatan_pesantren">Catatan Kepesantrenan</label>
              <textarea wire:model.defer="state.catatan_pesantren" @role('siswa|orang_tua') readonly @endrole required class="form-control @error('catatan_pesantren') is-invalid @enderror" id="catatan_pesantren" placeholder="Catatan Kepesantrenan"></textarea>
              @error('catatan_pesantren')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Kelakuan</label>
                  <input wire:model.defer="state.kelakuan" @role('siswa|orang_tua') readonly @endrole required type="text" class="form-control @error('kelakuan') is-invalid @enderror" placeholder="Kelakuan">
                  @error('kelakuan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Disiplin</label>
                  <input wire:model.defer="state.disiplin" @role('siswa|orang_tua') readonly @endrole required type="text" class="form-control @error('disiplin') is-invalid @enderror" placeholder="Disiplin">
                  @error('disiplin')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Kerapihan</label>
                  <input wire:model.defer="state.rapih" @role('siswa|orang_tua') readonly @endrole required type="text" class="form-control @error('rapih') is-invalid @enderror" placeholder="Kerapihan">
                  @error('rapih')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Sakit</label>
                    <div class="input-group">
                        <input wire:model.defer="state.sakit_pesantren" @role('siswa|orang_tua') readonly @endrole type="number" class="form-control @error('sakit') is-invalid @enderror" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">Hari</div>
                        </div>
                    </div>
                    @error('sakit')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Izin</label>
                    <div class="input-group">
                        <input wire:model.defer="state.izin_pesantren" @role('siswa|orang_tua') readonly @endrole type="number" class="form-control @error('izin') is-invalid @enderror" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">Hari</div>
                        </div>
                    </div>
                    @error('izin')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tanpa Keterangan</label>
                    <div class="input-group">
                        <input wire:model.defer="state.alpa_pesantren" @role('siswa|orang_tua') readonly @endrole type="number" class="form-control @error('alpa') is-invalid @enderror" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">Hari</div>
                        </div>
                    </div>
                    @error('alpa')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Jumlah</label>
                    <div class="input-group">
                        <input wire:model.defer="state.jumlah_pesantren" type="number" class="form-control" readonly/>
                        <div class="input-group-append">
                            <div class="input-group-text">Hari</div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            @role('wali_kelas|superadmin')
            <button type="submit" class="btn btn-success">Simpan</button>
            @endrole
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Modal Kelulusan -->
  <div class="modal fade" id="modal-kelulusan" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title">Form Kelulusan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="updateKelulusan">
          <div class="modal-body">
            <div class="form-group">
              <label for="ket_naik">Keterangan Kelulusan</label>
              <select wire:model.defer="state.ket_naik" required class="form-control @error('ket_naik') is-invalid @enderror" id="ket_naik">
                <option value="">--Pilih--</option>
                <option value="Naik">Naik</option>
                <option value="Tidak Naik">Tidak Naik</option>
              </select>
              @error('ket_naik')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="ke_kelas">Ke Kelas</label>
              <select wire:model.defer="state.ke_kelas" class="form-control @error('ke_kelas') is-invalid @enderror" required>
                  <option value="">--Pilih--</option>
                  <option value="X">X</option>
                  <option value="XI">XI</option>
                  <option value="XII">XII</option>
              </select>
              @error('ke_kelas')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Modal Catatan Ortu -->
  <div class="modal fade" id="modal-catatan-ortu" wire:ignore.self>
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h4 class="modal-title">Form Catatan Orang Tua</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="updateCatatanOrtu">
          <div class="modal-body">
            <div class="form-group">
              <label for="catatan_ortu">Catatan Orang Tua</label>
              <textarea wire:model.defer="state.catatan_ortu" @role('siswa|wali_kelas') readonly @endrole required class="form-control @error('catatan_ortu') is-invalid @enderror" id="catatan_ortu" placeholder="Catatan Orang Tua"></textarea>
              @error('catatan_ortu')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            @role('superadmin|orang_tua')
            <button type="submit" class="btn btn-danger">Simpan</button>
            @endrole
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
  
        window.addEventListener('show-form-edit', event => {
            $('#modal-edit').modal('show');
        });

        window.addEventListener('show-form-lihat', event => {
            $('#modal-lihat').modal('show');
        });

        window.addEventListener('show-form-catatan-pesantren', event => {
            $('#modal-catatan-pesantren').modal('show');
        });

        window.addEventListener('show-form-catatan-ortu', event => {
            $('#modal-catatan-ortu').modal('show');
        });

        window.addEventListener('show-form-kelulusan', event => {
            $('#modal-kelulusan').modal('show');
        });

        window.addEventListener('hide-form-kelulusan', event => {
            $('#modal-kelulusan').modal('hide');
  
            Swal.fire({
                "title":"Sukses!",
                "text":"Keterangan Lulus Berhasil Disimpan",
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

        window.addEventListener('hide-form-catatan-pesantren', event => {
            $('#modal-catatan-pesantren').modal('hide');
  
            Swal.fire({
                "title":"Sukses!",
                "text":"Data Catatan Berhasil Disimpan",
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

        window.addEventListener('hide-form-catatan-ortu', event => {
            $('#modal-catatan-ortu').modal('hide');
  
            Swal.fire({
                "title":"Sukses!",
                "text":"Data Catatan Berhasil Disimpan",
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