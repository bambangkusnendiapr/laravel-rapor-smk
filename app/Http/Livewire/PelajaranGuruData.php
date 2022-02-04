<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Master\Major;
use App\Models\Master\Lesson;
use App\Models\Teacher;
use App\Models\User;
use App\Models\PelajaranGuru;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class PelajaranGuruData extends Component
{
    public $state = [];
    public $idHapus = null;
    public $idEdit = null;

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

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        $nama_guru = User::where('name', 'like', '%'.$this->search.'%')->get('id');
        $cari_guru = Teacher::whereIn('user_id', $nama_guru)->get('id');
        $cari_pelajaran = Lesson::where('nama', 'like', '%'.$this->search.'%')->get('id');
        
        return view('livewire.pelajaran-guru-data', [
            'pelajaran_guru' => PelajaranGuru::whereIn('lesson_id', $cari_pelajaran)->orWhereIn('teacher_id', $cari_guru)->paginate($this->paginate),
            'jurusan' => Major::all(),
            'pelajaran' => Lesson::all(),
            'guru' => Teacher::all()
        ]);
    }

    public function addNew()
    {
        $this->resetInput();
        $this->dispatchBrowserEvent('show-form');
    }

    public function createData()
    {

        Validator::make($this->state, [
            'guru' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'pelajaran' => 'required',
        ])->validate();

        $data = new PelajaranGuru;
        $data->major_id = $this->state['jurusan'];
        $data->teacher_id = $this->state['guru'];
        $data->lesson_id = $this->state['pelajaran'];
        $data->kelas = $this->state['kelas'];
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
        $data = PelajaranGuru::find($this->idHapus);

        $data->delete();

        $this->dispatchBrowserEvent('hide-form-delete');
    }

    public function edit($id)
    {
        $this->idEdit = $id;
        $data = PelajaranGuru::find($this->idEdit);
        $this->state['guru'] = $data->teacher_id;
        $this->state['kelas'] = $data->kelas;
        $this->state['jurusan'] = $data->major_id;
        $this->state['pelajaran'] = $data->lesson_id;

        $this->dispatchBrowserEvent('show-form-edit');
    }

    public function updateData()
    {
        // dd($this->state['kelas']);
        Validator::make($this->state, [
            'guru' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'pelajaran' => 'required',
        ])->validate();

        $data = PelajaranGuru::find($this->idEdit);
        $data->major_id = $this->state['jurusan'];
        $data->teacher_id = $this->state['guru'];
        $data->lesson_id = $this->state['pelajaran'];
        $data->kelas = $this->state['kelas'];
        $data->save();

        $this->resetInput();

        $this->dispatchBrowserEvent('hide-form-edit');
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
