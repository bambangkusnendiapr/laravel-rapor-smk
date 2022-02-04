<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Master\Major;
use App\Models\Teacher;
use App\Models\Wali_kelas;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class WaliKelas extends Component
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
        return view('livewire.wali-kelas', [
            'wali_kelas' => Wali_kelas::paginate($this->paginate),
            'jurusan' => Major::all(),
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
        ])->validate();

        $guru = Teacher::find($this->state['guru']);
        $jurusan = Major::find($this->state['jurusan']);
        $user = User::find($guru->user_id);

        $user->syncRoles(['wali_kelas']);

        $jurusan->teachers()->attach($guru, ['kelas' => $this->state['kelas']]);

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
        $data = Wali_kelas::find($this->idHapus);

        $data->delete();

        $this->dispatchBrowserEvent('hide-form-delete');
    }

    public function edit($id)
    {
        $this->idEdit = $id;
        $data = Wali_kelas::find($this->idEdit);
        $this->state['guru'] = $data->teacher_id;
        $this->state['kelas'] = $data->kelas;
        $this->state['jurusan'] = $data->major_id;

        $this->dispatchBrowserEvent('show-form-edit');
    }

    public function updateData()
    {
        // dd($this->state['kelas']);
        Validator::make($this->state, [
            'guru' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
        ])->validate();

        $guru = Teacher::find($this->state['guru']);
        $user = User::find($guru->user_id);

        $user->syncRoles(['wali_kelas']);

        DB::table('major_teacher')
              ->where('id', $this->idEdit)
              ->update([
                  'major_id' => $this->state['jurusan'],
                  'teacher_id' => $this->state['guru'],
                  'kelas' => $this->state['kelas'],
                ]);

        $this->resetInput();

        $this->dispatchBrowserEvent('hide-form-edit');
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
