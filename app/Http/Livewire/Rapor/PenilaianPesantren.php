<?php

namespace App\Http\Livewire\Rapor;

use Livewire\Component;
use App\Models\Rapor\NilaiPesantren;
use App\Models\Rapor;
use App\Models\Master\Lesson;
use App\Models\Teacher;
use App\Models\PelajaranGuru;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class PenilaianPesantren extends Component
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

        return view('livewire.rapor.penilaian-pesantren', [
            'nilai' => NilaiPesantren::where('rapor_id', $this->idRapor)->where('teacher_id', $this->idGuru)->paginate($this->paginate),
            'rapor' => Rapor::find($this->idRapor),
            'lesson' => Lesson::whereIn('id', $this->pelajaran)->where('group_id', 1)->where('kelas', $query_rapor->kelas)->get(),
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
            'kkm' => 'required',
            'nilai' => 'required',
            'huruf' => 'required',
            // 'predikat' => 'required',
            // 'tuntas' => 'required',
        ])->validate();

        $data = new NilaiPesantren;
        $data->rapor_id = $this->idRapor;
        $data->lesson_id = $this->state['pelajaran'];
        $data->teacher_id = $this->idGuru;
        $data->kkm = $this->state['kkm'];
        $data->nilai = $this->state['nilai'];
        $data->huruf = $this->state['huruf'];
        if($this->state['nilai'] >= 91) {
           $data->predikat = 'A';
        } else if($this->state['nilai'] >= 75 && $this->state['nilai'] <= 90) {
           $data->predikat = 'B';
        } else if($this->state['nilai'] >= 60 && $this->state['nilai'] <= 74) {
           $data->predikat = 'C';
        } else {
           $data->predikat = 'D';
        }

        if($this->state['nilai'] >= 70) {
            $data->tuntas = 'Tuntas';
        } else {
             $data->tuntas = 'Tidak Tuntas';
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
        $data = NilaiPesantren::find($this->idHapus);

        $data->delete();

        $this->dispatchBrowserEvent('hide-form-delete');
    }

    public function edit($id)
    {
        $this->idEdit = $id;
        $data = NilaiPesantren::find($this->idEdit);
        $this->state['pelajaran'] = $data->lesson_id;
        $this->state['kkm'] = $data->kkm;
        $this->state['nilai'] = $data->nilai;
        $this->state['huruf'] = $data->huruf;
        $this->state['predikat'] = $data->predikat;
        $this->state['tuntas'] = $data->tuntas;

        $this->edit = true;

        $this->dispatchBrowserEvent('show-form');
    }

    public function updateData()
    {
        Validator::make($this->state, [
            'pelajaran' => 'required',
            'kkm' => 'required',
            'nilai' => 'required',
            'huruf' => 'required',
            // 'predikat' => 'required',
            // 'tuntas' => 'required',
        ])->validate();

        $data = NilaiPesantren::find($this->idEdit);
        $data->rapor_id = $this->idRapor;
        $data->lesson_id = $this->state['pelajaran'];
        $data->teacher_id = $this->idGuru;
        $data->kkm = $this->state['kkm'];
        $data->nilai = $this->state['nilai'];
        $data->huruf = $this->state['huruf'];
        if($this->state['nilai'] >= 91) {
            $data->predikat = 'A';
         } else if($this->state['nilai'] >= 75 && $this->state['nilai'] <= 90) {
            $data->predikat = 'B';
         } else if($this->state['nilai'] >= 60 && $this->state['nilai'] <= 74) {
            $data->predikat = 'C';
         } else {
            $data->predikat = 'D';
         }
 
         if($this->state['nilai'] >= 70) {
             $data->tuntas = 'Tuntas';
         } else {
              $data->tuntas = 'Tidak Tuntas';
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
