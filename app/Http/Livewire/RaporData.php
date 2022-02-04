<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Master\Major;
use App\Models\Master\Semester;
use App\Models\Student;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Rapor;
use App\Models\Ortu;
use App\Models\PelajaranGuru;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Wali_kelas;

class RaporData extends Component
{

    public $kelas = [];
    public $jurusan = [];
    public $student = [];
    public $major;

    public $state = [];
    public $idHapus = null;
    public $idEdit = null;

    public $lihat_siswa;
    public $lihat_semester;
    public $lihat_kelas;
    public $lihat = false;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $halaman = 10;
    public $foo;
    public $search = '';
    public $cari = '';
    public $page = 1;

    protected $queryString = [
        'foo',
        'search' => ['except' => ''],
        'cari' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
        if($this->lihat == true) {
            $data = Rapor::find($this->idEdit);
            $this->lihat_siswa = $data->student->user->name;
            $this->lihat_semester = $data->semester->nama .' - '. $data->semester->tahun;
            $this->lihat_kelas = $data->kelas .' - '. $data->student->major->jurusan;
        }

    }

    public function render()
    {
        $search_nama = User::where('name', 'like', '%'.$this->search.'%')->get('id');
        $search_siswa = Student::whereIn('user_id', $search_nama)->get('id');

        $cari_nama = User::where('name', 'like', '%'.$this->cari.'%')->get('id');
        $cari_siswa = Student::whereIn('user_id', $cari_nama)->get('id');

        $siswa_kelas = [];
        $siswa_jurusan = [];
        $jurusan = [];
        $guru = Teacher::where('user_id', Auth::user()->id)->first();

        $raporWaliKelas = Major::all();

        if(Auth::user()->hasRole('wali_kelas')) {
            //Data rapor siswa wali kelas
            $walikelas = Wali_kelas::where('teacher_id', $guru->id)->get();           
            

            foreach($walikelas as $result) {
                $siswa_kelas[] = $result->kelas;
                $siswa_jurusan[] = $result->major_id;
                $this->kelas[] = $result->kelas;
                $jurusan[] = $result->major_id;
            }

            $siswa = Student::whereIn('major_id', $jurusan)->get();
            foreach($siswa as $data) {
                $this->student[] = $data->id; 
            }

            //data guru mengajar pelajaran
            $pelajaran_guru = PelajaranGuru::where('teacher_id', $guru->id)->get();
            foreach($pelajaran_guru as $data) {
                $wali_kelas_mengajar_jurusan[] = $data->major_id;
                $wali_kelas_mengajar_kelas[] = $data->kelas;
            }

            $wali_kelas_mengajar_jurusan = array_unique($wali_kelas_mengajar_jurusan);

            $siswa = Student::whereIn('major_id', $wali_kelas_mengajar_jurusan)->get();
            foreach($siswa as $data) {
                $wali_kelas_mengajar_siswa[] = $data->id; 
            }

            $wali_kelas_mengajar_kelas = array_unique($wali_kelas_mengajar_kelas);

            $raporWaliKelas = Rapor::whereIn('student_id', $wali_kelas_mengajar_siswa)->whereIn('kelas', $wali_kelas_mengajar_kelas)->whereIn('student_id', $cari_siswa)->paginate($this->halaman);
        }

        if(Auth::user()->hasRole('guru')) {
            $pelajaran_guru = PelajaranGuru::where('teacher_id', $guru->id)->get();
            foreach($pelajaran_guru as $data) {
                $this->jurusan[] = $data->major_id;
                $this->kelas[] = $data->kelas;
            }

            $this->jurusan = array_unique($this->jurusan);

            $siswa = Student::whereIn('major_id', $this->jurusan)->get();
            foreach($siswa as $data) {
                $this->student[] = $data->id; 
            }

            $this->kelas = array_unique($this->kelas);
        }

        if(Auth::user()->hasRole('siswa')) {
            $murid = Student::where('user_id', Auth::user()->id)->first();
            $this->student = [$murid->id];
            $this->kelas = ['X', 'XI', 'XII'];
        }

        if(Auth::user()->hasRole('orang_tua')) {
            $ortu = Ortu::where('user_id', Auth::user()->id)->first();
            $murid = Student::where('ortu_id', $ortu->id)->get();
            foreach($murid as $data) {
                $this->student[] = $data->id;
            }
            $this->kelas = ['X', 'XI', 'XII'];
        }

        if(Auth::user()->hasRole('superadmin')) {
            return view('livewire.rapor-data', [
                'rapor' => Rapor::paginate($this->paginate),
                'jurusan' => Major::all(),
                'semester' => Semester::all(),
                'siswa' => Student::where('kelas', $siswa_kelas)->where('major_id', $siswa_jurusan)->get(),
            ]);
        }

        return view('livewire.rapor-data', [
            'rapor' => Rapor::whereIn('student_id', $this->student)->whereIn('kelas', $this->kelas)->whereIn('student_id', $search_siswa)->paginate($this->paginate),
            'jurusan' => Major::all(),
            'semester' => Semester::all(),
            'siswa' => Student::whereIn('kelas', $siswa_kelas)->whereIn('major_id', $siswa_jurusan)->get(),
            'rapor_wali_kelas' => $raporWaliKelas,
        ]);
    }

    public function addNew()
    {
        $this->resetInput();
        $this->dispatchBrowserEvent('show-form');
    }

    public function createData()
    {
        // $word = "2021-12-12";

        // if($this->state['tanggal'] === $word) {
        //     dd("sama");
        // } else {
        //     dd("tidak sama");
        // }

        Validator::make($this->state, [
            'siswa' => 'required',
            'semester' => 'required',
            'spiritual' => 'required',
            'sosial' => 'required',
            'catatan' => 'required',
            'sakit' => 'required',
            'izin' => 'required',
            'alpa' => 'required',
        ])->validate();

        $data = new Rapor;
        $data->tanggal = $this->state['tanggal'];
        $data->student_id = $this->state['siswa'];
        $data->semester_id = $this->state['semester'];
        $data->kelas = $this->state['kelas'];
        $data->spiritual = $this->state['spiritual'];
        $data->sosial = $this->state['sosial'];
        $data->catatan = $this->state['catatan'];
        $data->sakit = $this->state['sakit'];
        $data->izin = $this->state['izin'];
        $data->alpa = $this->state['alpa'];
        $data->save();

        $this->resetInput();

        $this->dispatchBrowserEvent('hide-form');
    }

    public function delete($id)
    {
        $this->idHapus = $id;

        $this->dispatchBrowserEvent('show-form-delete');
    }

    public function deleteData()
    {
        $data = Rapor::find($this->idHapus);

        $data->delete();

        $this->dispatchBrowserEvent('hide-form-delete');
    }

    public function edit($id)
    {
        $this->resetInput();   
        $this->idEdit = $id;
        $data = Rapor::find($this->idEdit);
        if($data->tanggal != null) {
            $this->state['tanggal'] = $data->tanggal->format('Y-m-d');
        }
        $this->state['siswa'] = $data->student_id;
        $this->state['kelas'] = $data->kelas;
        $this->state['semester'] = $data->semester_id;
        $this->state['spiritual'] = $data->spiritual;
        $this->state['sosial'] = $data->sosial;
        $this->state['catatan'] = $data->catatan;
        $this->state['sakit'] = $data->sakit;
        $this->state['izin'] = $data->izin;
        $this->state['alpa'] = $data->alpa;
        $this->state['jumlah'] = $data->sakit + $data->izin + $data->alpa;

        $this->dispatchBrowserEvent('show-form-edit');
    }

    public function updateData()
    {
        Validator::make($this->state, [
            'siswa' => 'required',
            'semester' => 'required',
            'spiritual' => 'required',
            'sosial' => 'required',
            'catatan' => 'required',
            'sakit' => 'required',
            'izin' => 'required',
            'alpa' => 'required',
        ])->validate();

        $data = Rapor::find($this->idEdit);
        $data->tanggal = $this->state['tanggal'];
        $data->student_id = $this->state['siswa'];
        $data->semester_id = $this->state['semester'];
        $data->kelas = $this->state['kelas'];
        $data->spiritual = $this->state['spiritual'];
        $data->sosial = $this->state['sosial'];
        $data->catatan = $this->state['catatan'];
        $data->sakit = $this->state['sakit'];
        $data->izin = $this->state['izin'];
        $data->alpa = $this->state['alpa'];
        $data->save();

        $this->resetInput();

        $this->dispatchBrowserEvent('hide-form-edit');
    }

    public function lihat($id)
    {
        $this->idEdit = $id;
        $data = Rapor::find($this->idEdit);
        $this->lihat = true;
        $this->mount();
        $this->state['spiritual'] = $data->spiritual;
        $this->state['sosial'] = $data->sosial;
        $this->state['catatan'] = $data->catatan;
        $this->state['sakit'] = $data->sakit;
        $this->state['izin'] = $data->izin;
        $this->state['alpa'] = $data->alpa;
        $this->state['jumlah'] = $data->sakit + $data->izin + $data->alpa;

        $this->dispatchBrowserEvent('show-form-lihat');
    }

    public function catatan_pesantren($id)
    {
        $this->idEdit = $id;
        $data = Rapor::find($this->idEdit);
        $this->state['catatan_pesantren'] = $data->catatan_pesantren;
        $this->state['kelakuan'] = $data->kelakuan;
        $this->state['disiplin'] = $data->disiplin;
        $this->state['rapih'] = $data->rapih;
        $this->state['sakit_pesantren'] = $data->sakit_pesantren;
        $this->state['izin_pesantren'] = $data->izin_pesantren;
        $this->state['alpa_pesantren'] = $data->alpa_pesantren;
        $this->state['jumlah_pesantren'] = $data->sakit_pesantren + $data->izin_pesantren + $data->alpa_pesantren;

        $this->dispatchBrowserEvent('show-form-catatan-pesantren');
    }

    public function updateCatatanPesantren()
    {
        Validator::make($this->state, [
            'catatan_pesantren' => 'required',
            'kelakuan' => 'required',
            'disiplin' => 'required',
            'rapih' => 'required',
            'sakit_pesantren' => 'required',
            'izin_pesantren' => 'required',
            'alpa_pesantren' => 'required',
        ])->validate();

        $data = Rapor::find($this->idEdit);
        $data->catatan_pesantren = $this->state['catatan_pesantren'];
        $data->kelakuan = $this->state['kelakuan'];
        $data->disiplin = $this->state['disiplin'];
        $data->rapih = $this->state['rapih'];
        $data->sakit_pesantren = $this->state['sakit_pesantren'];
        $data->izin_pesantren = $this->state['izin_pesantren'];
        $data->alpa_pesantren = $this->state['alpa_pesantren'];
        $data->save();

        $this->resetInput();

        $this->dispatchBrowserEvent('hide-form-catatan-pesantren');
    }

    public function kelulusan($id)
    {
        $this->idEdit = $id;
        $data = Rapor::find($this->idEdit);
        $this->state['ket_naik'] = $data->ket_naik;
        $this->state['ke_kelas'] = $data->ke_kelas;

        $this->dispatchBrowserEvent('show-form-kelulusan');
    }

    public function updateKelulusan()
    {
        Validator::make($this->state, [
            'ket_naik' => 'required',
            'ke_kelas' => 'required',
        ])->validate();

        $data = Rapor::find($this->idEdit);

        if($this->state['ket_naik'] == 'Naik') {
            $student = Student::find($data->student_id);
            $student->kelas = $this->state['ke_kelas'];
            $student->save();
        }

        $data->ket_naik = $this->state['ket_naik'];
        $data->ke_kelas = $this->state['ke_kelas'];
        $data->save();

        $this->resetInput();

        $this->dispatchBrowserEvent('hide-form-kelulusan');
    }

    public function catatan_ortu($id)
    {
        $this->idEdit = $id;
        $data = Rapor::find($this->idEdit);
        $this->state['catatan_ortu'] = $data->catatan_ortu;

        $this->dispatchBrowserEvent('show-form-catatan-ortu');
    }

    public function updateCatatanOrtu()
    {
        Validator::make($this->state, [
            'catatan_ortu' => 'required',
        ])->validate();

        $data = Rapor::find($this->idEdit);
        $data->catatan_ortu = $this->state['catatan_ortu'];
        $data->save();

        $this->resetInput();

        $this->dispatchBrowserEvent('hide-form-catatan-ortu');
    }

    private function resetInput()
    {
        $this->state = null;
    }
}