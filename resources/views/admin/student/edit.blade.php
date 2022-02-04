@section('title', 'Edit Data Siswa / Siswi')
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
            <h1>Edit Data Siswa / Siswi</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Kelola Data Siswa/i</a></li>
              <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Siswa/i</a></li>
              <li class="breadcrumb-item active">Edit Data</li>
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
                <a href="{{ route('students.index') }}" class="btn btn-dark"><i class="fas fa-long-arrow-alt-left"></i> Kembali</a>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <form action="{{ route('students.update', $student->id) }}" method="post">
                @method('put')
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="nama" class="form-label">Nama</label>                     
                          <input type="text" name="nama" required autofocus class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ $student->user->name }}">
                          @error('nama')
                            <span class="error invalid-feedback">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="email" class="form-label">Email</label>                     
                          <input type="email" name="email" required value="{{ $student->user->email }}" class="form-control @error('email') is-invalid @enderror" id="email">
                          @error('email')
                            <span class="error invalid-feedback">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
  
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="password" class="form-label">Password (Kosongkan jika tidak ganti password)</label>                     
                          <input type="password" name="password" autofocus class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                          @error('password')
                            <span class="error invalid-feedback">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="password-confirm" class="form-label">Konfirmasi Password</label>                     
                          <input type="password" name="password_confirmation" class="form-control" id="password-confirm" placeholder="Konfirmasi Password">
                      </div>
                    </div>
                  </div>
                  
                  <hr>
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="nis" class="form-label">NIS</label>                     
                          <input type="text" name="nis" required class="form-control @error('nis') is-invalid @enderror" id="nis" value="{{ $student->nis }}">
                          @error('nis')
                            <span class="error invalid-feedback">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="noInduk" class="form-label">No Induk</label>                     
                          <input type="text" name="noInduk" value="{{ $student->no_induk }}" class="form-control @error('noInduk') is-invalid @enderror" id="noInduk">
                          @error('noInduk')
                            <span class="error invalid-feedback">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
  
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="tempatLahir" class="form-label">Tempat Lahir</label>                     
                          <input type="text" value="{{ $student->tempat_lahir }}" name="tempatLahir" class="form-control @error('tempatLahir') is-invalid @enderror" id="tempatLahir">
                          @error('tempatLahir')
                            <span class="error invalid-feedback">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="tglLahir" class="form-label">Tanggal Lahir</label>                     
                          <input type="date" value="{{ $student->tgl_lahir }}" tempatLahir name="tgl_lahir" class="form-control" id="tglLahir">
                      </div>
                    </div>
                  </div>
  
                  <hr>
  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="jk" class="form-label">Jenis Kelamin</label>   
                        <select name="jk" id="jk" class="form-control @error('jk') is-invalid @enderror">
                          <option value="Laki-laki" {{ $student->jk == 'Lakilaki' ? 'selected':'' }}>Laki-laki</option>
                          <option value="Perempuan" {{ $student->jk == 'Lakilaki' ? '':'selected' }}>Perempuan</option>
                        </select>                  
                          @error('jk')
                            <span class="error invalid-feedback">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="agama" class="form-label">Agama</label>   
                        <select name="agama" id="agama" class="form-control @error('agama') is-invalid @enderror">
                          <option value="Islam">Islam</option>
                          @if($student->agama == 'Protestan')
                            <option value="Protestan" selected>Protestan</option>
                          @else
                            <option value="Protestan">Protestan</option>
                          @endif
                          @if($student->agama == 'Katolik')
                            <option value="Katolik" selected>Katolik</option>
                          @else
                            <option value="Katolik">Katolik</option>
                          @endif
                          @if($student->agama == 'Hindu')
                            <option value="Hindu" selected>Hindu</option>
                          @else
                            <option value="Hindu">Hindu</option>
                          @endif
                          @if($student->agama == 'Buddha')
                            <option value="Buddha" selected>Buddha</option>
                          @else
                            <option value="Buddha">Buddha</option>
                          @endif
                          @if($student->agama == 'Khonghucu')
                            <option value="Khonghucu" selected>Khonghucu</option>
                          @else
                            <option value="Khonghucu">Khonghucu</option>
                          @endif
                        </select>                  
                          @error('agama')
                            <span class="error invalid-feedback">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="warganegara" class="form-label">Kewarganegaraan</label>                     
                          <input type="text" value="{{ $student->warganegara }}" name="warganegara" class="form-control @error('warganegara') is-invalid @enderror" id="warganegara">
                          @error('warganegara')
                            <span class="error invalid-feedback">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="hp" class="form-label">No Telepon</label>                     
                          <input type="text" value="{{ $student->hp }}" name="hp" class="form-control @error('hp') is-invalid @enderror" id="hp" >
                          @error('hp')
                            <span class="error invalid-feedback">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
  
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="kelas" class="form-label">Kelas</label>   
                        <select name="kelas" id="kelas" class="form-control @error('kelas') is-invalid @enderror">
                        <option value="X">X</option>
                          @if($student->kelas == 'XI')
                            <option value="XI" selected>XI</option>
                          @else
                            <option value="XI">XI</option>
                          @endif
                          @if($student->kelas == 'XII')
                            <option value="XII" selected>XII</option>
                          @else
                            <option value="XII">XII</option>
                          @endif
                        </select>                  
                          @error('kelas')
                            <span class="error invalid-feedback">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="jurusan" class="form-label">Jurusan</label>   
                        <select name="jurusan" id="jurusan" class="form-control @error('jurusan') is-invalid @enderror">
                          @foreach($jurusan as $data)
                              <option value="{{ $data->id }}" {{ $student->major_id == $data->id ? 'selected':'' }}>{{ $data->jurusan }}</option>
                          @endforeach
                        </select>                  
                          @error('jurusan')
                            <span class="error invalid-feedback">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="alamat" class="form-label">Alamat</label>           
                        <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ $student->alamat }}</textarea>    
                          @error('alamat')
                            <span class="error invalid-feedback">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="ortu" class="form-label">Orang Tua</label>   
                        <select name="ortu" id="ortu" class="form-control @error('ortu') is-invalid @enderror">
                          @foreach($ortu as $data)
                            <option value="{{ $data->id }}" {{ $student->ortu_id == $data->id ? 'selected':'' }}>{{ $data->user->name }}</option>
                          @endforeach
                        </select>                  
                          @error('ortu')
                            <span class="error invalid-feedback">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
                  </div>
  
  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning w-100"><i class="fas fa-paper-plane"></i> Edit</button>
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
  @push('style')
  
  @endpush
  
  @push('script')

  @endpush
</x-admin-layout>
