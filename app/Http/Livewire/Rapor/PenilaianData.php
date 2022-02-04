<?php

namespace App\Http\Livewire\Rapor;

use Livewire\Component;
use App\Models\Rapor\Penilaian;
use App\Models\Rapor;
use App\Models\Master\Lesson;
use App\Models\Teacher;
use App\Models\PelajaranGuru;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class PenilaianData extends Component
{
    public $state = [];
    public $idHapus = null;
    public $idEdit = null;
    public $idRapor = null;
    public $idGuru = null;
    public $pelajaran = [];

    public $edit = false;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
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
        $this->search = request()->query('search', $this->search);
        $guru = Teacher::where('user_id', Auth::user()->id)->first();
        if(Auth::user()->hasRole('guru') || Auth::user()->hasRole('wali_kelas')) {
            $this->idGuru = $guru->id;
            $lesson = PelajaranGuru::where('teacher_id', $this->idGuru)->get();
            foreach($lesson as $data) {
                $this->pelajaran[] = $data->lesson_id; 
            }

            $this->pelajaran = array_unique($this->pelajaran);
        }

        
        
    }

    public function render()
    {
        $query_rapor = Rapor::find($this->idRapor);

        return view('livewire.rapor.penilaian-data', [
            'nilai' => Penilaian::where('rapor_id', $this->idRapor)->where('teacher_id', $this->idGuru)->paginate($this->paginate),
            'rapor' => Rapor::find($this->idRapor),
            'lesson' => Lesson::whereIn('id', $this->pelajaran)->where('group_id', '!=', 1)->where('kelas', $query_rapor->kelas)->get(),
            'teacher' => Teacher::all(),
        ]);
    }

    public function addNew()
    {
        $this->edit = false;
        $this->resetInput();
        $this->dispatchBrowserEvent('show-form');
    }

    public function createData()
    {
        Validator::make($this->state, [
            'pelajaran' => 'required',
            'pengetahuan_nilai' => 'required',
            'keterampilan_nilai' => 'required',
        ])->validate();

        
        $data = new Penilaian;
        $data->rapor_id = $this->idRapor;
        $data->lesson_id = $this->state['pelajaran'];
        $data->teacher_id = $this->idGuru;
        $data->pengetahuan_nilai = $this->state['pengetahuan_nilai'];
        if($this->state['pengetahuan_nilai'] >= 91) {
            $data->pengetahuan_predikat = 'A';
        } else if($this->state['pengetahuan_nilai'] >= 75 && $this->state['pengetahuan_nilai'] <= 90) {
            $data->pengetahuan_predikat = 'B';
        } else if($this->state['pengetahuan_nilai'] >= 60 && $this->state['pengetahuan_nilai'] <= 74) {
            $data->pengetahuan_predikat = 'C';
        } else {
            $data->pengetahuan_predikat = 'D';
        }

        if($this->state['pengetahuan_nilai'] >= 70) {
            $data->pengetahuan_deskripsi = 'Tuntas';
        } else {
             $data->pengetahuan_deskripsi = 'Tidak Tuntas';
        }
        $data->keterampilan_nilai = $this->state['keterampilan_nilai'];
        if($this->state['keterampilan_nilai'] >= 91) {
            $data->keterampilan_predikat = 'A';
        } else if($this->state['keterampilan_nilai'] >= 75 && $this->state['keterampilan_nilai'] <= 90) {
            $data->keterampilan_predikat = 'B';
        } else if($this->state['keterampilan_nilai'] >= 60 && $this->state['keterampilan_nilai'] <= 74) {
            $data->keterampilan_predikat = 'C';
        } else {
            $data->keterampilan_predikat = 'D';
        }

        if($this->state['keterampilan_nilai'] >= 70) {
            $data->keterampilan_deskripsi = 'Tuntas';
        } else {
             $data->keterampilan_deskripsi = 'Tidak Tuntas';
        }
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
        $data = Penilaian::find($this->idHapus);

        $data->delete();

        $this->dispatchBrowserEvent('hide-form-delete');
    }

    public function edit($id)
    {
        $this->idEdit = $id;
        $data = Penilaian::find($this->idEdit);
        $this->state['pelajaran'] = $data->lesson_id;
        $this->state['pengetahuan_nilai'] = $data->pengetahuan_nilai;
        $this->state['pengetahuan_predikat'] = $data->pengetahuan_predikat;
        $this->state['pengetahuan_deskripsi'] = $data->pengetahuan_deskripsi;
        $this->state['keterampilan_nilai'] = $data->keterampilan_nilai;
        $this->state['keterampilan_predikat'] = $data->keterampilan_predikat;
        $this->state['keterampilan_deskripsi'] = $data->keterampilan_deskripsi;

        $this->edit = true;

        $this->dispatchBrowserEvent('show-form');
    }

    public function updateData()
    {
        Validator::make($this->state, [
            'pelajaran' => 'required',
            'pengetahuan_nilai' => 'required',
            'keterampilan_nilai' => 'required',
        ])->validate();

        $data = Penilaian::find($this->idEdit);
        $data->rapor_id = $this->idRapor;
        $data->lesson_id = $this->state['pelajaran'];
        $data->teacher_id = $this->idGuru;
        $data->pengetahuan_nilai = $this->state['pengetahuan_nilai'];
        if($this->state['pengetahuan_nilai'] >= 91) {
            $data->pengetahuan_predikat = 'A';
        } else if($this->state['pengetahuan_nilai'] >= 75 && $this->state['pengetahuan_nilai'] <= 90) {
            $data->pengetahuan_predikat = 'B';
        } else if($this->state['pengetahuan_nilai'] >= 60 && $this->state['pengetahuan_nilai'] <= 74) {
            $data->pengetahuan_predikat = 'C';
        } else {
            $data->pengetahuan_predikat = 'D';
        }

        if($this->state['pengetahuan_nilai'] >= 70) {
            $data->pengetahuan_deskripsi = 'Tuntas';
        } else {
             $data->pengetahuan_deskripsi = 'Tidak Tuntas';
        }
        $data->keterampilan_nilai = $this->state['keterampilan_nilai'];
        if($this->state['keterampilan_nilai'] >= 91) {
            $data->keterampilan_predikat = 'A';
        } else if($this->state['keterampilan_nilai'] >= 75 && $this->state['keterampilan_nilai'] <= 90) {
            $data->keterampilan_predikat = 'B';
        } else if($this->state['keterampilan_nilai'] >= 60 && $this->state['keterampilan_nilai'] <= 74) {
            $data->keterampilan_predikat = 'C';
        } else {
            $data->keterampilan_predikat = 'D';
        }

        if($this->state['keterampilan_nilai'] >= 70) {
            $data->keterampilan_deskripsi = 'Tuntas';
        } else {
             $data->keterampilan_deskripsi = 'Tidak Tuntas';
        }
        $data->save();

        $this->resetInput();

        $this->dispatchBrowserEvent('hide-form');
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
