<?php

namespace App\Http\Livewire\Rapor;

use Livewire\Component;
use App\Models\Rapor\Penilaian;
use App\Models\Rapor;
use App\Models\User;
use App\Models\Student;
use App\Models\Ortu;
use App\Models\Master\Lesson;
use App\Models\Master\Group;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\PelajaranGuru;
use RealRashid\SweetAlert\Facades\Alert;

class PenilaianRapor extends Component
{
    public $idRapor = null;
    public $idGuru = null;
    public $pelajaran = [];

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginate = 30;
    public $foo;
    public $search = '';
    public $page = 1;

    protected $queryString = [
        'foo',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount($id)
    {
        $this->idRapor = $id;
        $rapot = Rapor::find($this->idRapor);
        $this->search = request()->query('search', $this->search);

        if(Auth::user()->hasRole('guru')) {
            
            Alert::warning('Forbidden', 'Anda Tidak Memiliki Akses');
            return redirect()->route('rapor');
        }

        if(Auth::user()->hasRole('siswa')) {
            $user = User::find(Auth::user()->id);
            $siswa = Student::where('user_id', $user->id)->first();

            if($siswa->id != $rapot->student_id){
                Alert::warning('Forbidden', 'Anda Tidak Memiliki Akses');
                return redirect()->route('rapor');
            }
        }

        if(Auth::user()->hasRole('orang_tua')) {
            $user = User::find(Auth::user()->id);
            $ortu = Ortu::where('user_id', $user->id)->first();
            $siswa = Student::where('ortu_id', $ortu->id)->first();

            if($siswa->id != $rapot->student_id){
                Alert::warning('Forbidden', 'Anda Tidak Memiliki Akses');
                return redirect()->route('rapor');
            }
        }
    }

    public function render()
    {
        $rapor_data = Rapor::find($this->idRapor);
        $pelajaran_kelas = Lesson::where('group_id', '!=', 1)->where('kelas', $rapor_data->kelas)->get('id');

        $guru_pelajaran = PelajaranGuru::where('major_id', $rapor_data->student->major_id)->whereIn('lesson_id', $pelajaran_kelas)->get('lesson_id');

        $pelajaran = Lesson::whereIn('id', $guru_pelajaran)->where('group_id', '!=', 1)->where('kelas', $rapor_data->kelas)->get();

        return view('livewire.rapor.penilaian-rapor', [
            'nilai' => Penilaian::where('rapor_id', $this->idRapor)->paginate($this->paginate),
            'rapor' => $rapor_data,
            'kelompok' => Group::where('id', '!=', 1)->get(),
            'mapel' => $pelajaran,
            'pelajaran_guru' => PelajaranGuru::where('major_id', $rapor_data->student->major_id)->get(),
        ]);
    }
}
